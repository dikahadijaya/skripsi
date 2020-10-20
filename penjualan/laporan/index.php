
<?php require_once('../templates/header.php'); ?>

	<div class="container mt-3">

		<div class="row waktu">	
			<div class="col-md-4">	
				<div class="form-group">
					<label>Awal Waktu</label>
					<input type="text" id="dari" class="form-control datepicker" placeholder="Dari" readonly="">
				</div>
			</div>

			<div class="col-md-4">	
				<div class="form-group">
					<label>Akhir Waktu</label>
					<input type="text" id="sampai" class="form-control datepicker" placeholder="Sampai" readonly="">
				</div>
			</div>

			<div class="col-md-4 mb-5" style="margin-top: 36px;">			
				<button class="btn btn-primary btn-sm refresh"><span class="fa fa-sync-alt"></span> Refresh</button>
                <button class="btn btn-danger btn-sm hapus-waktu" style="display: none;"><span class="fa fa-minus"></span> Hapus</button>
			</div>

            
		</div>

		<div class="card">
			<div class="card-header">
				Laporan Penjualan
				<div class="float-right">
					<button class="btn btn-danger btn-sm" id="pdf"><i class="fa fa-print"></i> PDF</button>
					<button class="btn btn-success btn-sm" id="excel"><i class="fa fa-file-excel"></i> Excel</button>
				</div>
			</div>
			
            <div class="table-responsive">                
                <table class="table">
                    <thead>
                        <th class="text-center">No</th>
                        <th class="text-center">ID Pembelian</th>
                        <th class="text-center">Tanggal Pembelian</th>
                        <th class="text-center">Jumlah Barang</th>
                        <th class="text-center">Total Harga</th>
                        <th class="text-center">Aksi</th>
                    </thead>
                    <tbody id="tbody-pembelian"> <!-- isi table pembelian --></tbody>


                    <!-- tampil ketika table pembelian kosong -->
                    <tr class="dataKosong"> 
                        <td colspan="11" class="text-center">Tidak ada pembelian</td> 
                    </tr>

                </table>
            </div>
			
			<nav>
				<ul class="pagination justify-content-center"><!--halaman --></ul>
			</nav>

			<br>

			<img src="<?= base_url; ?>loader.gif" class="mx-auto" id="loader" width="100px">
		</div>
	</div>

	<!-- modal detail -->
	<div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog modal-lg" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">Detail Pembelian</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <form id="formLaporan">
		      <div class="modal-body">

		      	
		      	<table class="table table-sm" id="detail-pembelian">
		      		<tr>
		      			<td>ID Pembelian</td>
		      			<td>:</td>
		      			<td id="id_pembelian"></td>
		      		</tr>

		      		<tr>
		      			<td>Tanggal Pembelian</td>
		      			<td>:</td>
		      			<td id="tanggal_pembelian"></td>
		      		</tr>
		      	</table>

		      	<table class="table" id="barang-pembelian">
		      		<thead>		
			      		<tr>
			      			<th class="text-center">No</th>
			      			<th class="text-center">Nama Barang</th>
			      			<th class="text-center">Harga</th>
			      			<th class="text-center">Jumlah</th>
			      			<th class="text-right">Total</th>
			      		</tr>
		      		</thead>
		      		<tbody id="tbody-detailpembelian"><!-- isi detail pembelian --></tbody>
                </table>    

		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		      </div>
	      </form>
	    </div>
	  </div>
	</div>

	<!-- Modal print -->
	<div class="modal fade" id="cetakModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">Cetak Laporan</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">

	      	<div class="form-group">
	      		<label>Masukkan Awal Waktu</label>
	            <input type="text" id="awal_waktu" class="form-control datepicker" placeholder="Dari" readonly />
	            <span id="error_awal_waktu" class="text-danger"></span>
	      	</div>

	      	<div class="form-group">
	      		<label>Masukkan Akhir Waktu</label>
	            <input type="text"  id="akhir_waktu" class="form-control datepicker" placeholder="sampai" readonly />
	            <span id="error_akhir_waktu" class="text-danger"></span>
	      	</div>

	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	        <button type="submit" id="cetak" class="btn btn-primary"> Cetak </button>
	      </div>
	    </div>
	  </div>
	</div>	

<?php require_once('../templates/footer.php'); ?>

<script>
	
	// pembelian
    function getPembelian(awalWaktu, akhirWaktu, halaman)
    {

        $('#loader').show();

        if(awalWaktu && akhirWaktu){
            $('.hapus-waktu').show(1000);
        }

        $.ajax({
            url: '<?= base_url; ?>laporan/get_pembelian.php',
            type: 'POST',
            data: {
                awal_waktu: awalWaktu,
                akhir_waktu: akhirWaktu,
                halaman: halaman,
            },
            dataType: 'json',
            success:function(response){
                if(halaman != null){
                    $('#loader').hide();
                    $('table #tbody-pembelian').html(response.table).show();
                    $('.pagination').html(response.halaman);
                }else{    
                    $('#loader').delay(500).hide(function(){
                        $('table #tbody-pembelian').html(response.table).show();
                        $('.pagination').html(response.halaman);
                    });    
                }
            }
        });
    }

    function getDetailPembelian(id_pembelian)
    {
        $(document).on('click', '#detailPembelian', function(){
            $('#id_pembelian').html('');
            $('#tanggal_pembelian').html('');
            $('#tbody-detailpembelian').html('');

           let request = null; 
           request = $.ajax({
                url: '<?= base_url; ?>laporan/get_detail_pembelian.php',
                type: 'POST',
                dataType: 'json',
                async: false,
                cache: false,
                data: {id_pembelian: id_pembelian},
                success: function(response){  

                    $('#id_pembelian').html(response.id_pembelian);
                    $('#tanggal_pembelian').html(response.tanggal_beli+' '+response.jam);
                    $('#tbody-detailpembelian').html(response.table);
                    $('#detailModal').modal('show');
                }
            });
        });
    }

    function hapusPembelian(id_pembelian)
    {
        if(confirm('Anda yakin ingin menghapus ?'))
        {
            let passData = {id_pembelian: id_pembelian};

            $.ajax({
                url: '<?= base_url; ?>laporan/hapus_pembelian.php',
                type: 'POST',
                dataType: 'json',
                data: passData,
                success: function(response){
                    $('#tbody-pembelian tr#'+response.id_pembelian).hide(1000);  
                    if(response.row_pembelian < '1'){
                        $('table #tbody-pembelian').hide(1000);
                        $('.pagination').hide(1000);
                        $('tr.dataKosong').delay(300).show(1500);
                    }
                }
            });
        }   
    }

    function hapusBanyakPembelian()
    {
        let awalWaktu = $('#dari').val();
        let akhirWaktu = $('#sampai').val();

        const months = ["JAN", "FEB", "MAR","APR", "MAY", "JUN", "JUL", "AUG", "SEP", "OCT", "NOV", "DEC"];
        let awal_datetime = new Date(awalWaktu)
        let awal_date = awal_datetime.getDate() + "-" + months[awal_datetime.getMonth()] + "-" + awal_datetime.getFullYear();

        let akhir_datetime = new Date(akhirWaktu)
        let akhir_date = akhir_datetime.getDate() + "-" + months[akhir_datetime.getMonth()] + "-" + akhir_datetime.getFullYear();
        
        if(confirm('Apa anda ingin mengapus data dari '+awal_date+' sampai '+akhir_date+'?')){

            let passData = {
                awal_waktu: awalWaktu,
                akhir_waktu: akhirWaktu
            };

            $.ajax({
                url: '<?= base_url; ?>laporan/hapus_banyak_pembelian.php',
                type: 'POST',
                data: passData,
                success: function(){
                    getPembelian(); 
                }
            });

        }
    }

    // akhir pembelian

    $(document).ready(function(){

    	getPembelian();

        // hapus berdasarkan waktu
        $('.hapus-waktu').on('click', function(){
            hapusBanyakPembelian();
        });

    	//halaman
    	$(document).on('click', '.page-item', function(){  
           let halaman = $(this).attr("id");  
           getPembelian('','',halaman);  
      	}); 

    	 //pencarian laporan berdasarkan waktu
        $('.waktu').change(function(){
            let awalWaktu = $('#dari').val();
            let akhirWaktu = $('#sampai').val();
            if(awalWaktu != '' && akhirWaktu != ''){
                getPembelian(awalWaktu, akhirWaktu);
            }
            
        });

        //refresh pada halaman laporan penjualan
        $('.refresh').on('click', function(){
            $('#dari').val('');
            $('#sampai').val('');
            $('.hapus-waktu').hide(1000);
            getPembelian();
        });

        //datepicker
        $('.datepicker').datepicker({
            todayBtn: "linked",
            format: "yyyy-mm-dd",
            autoclose: true,
            container: '#printModal modal-body'
        });

        //cetak laporan pembelian
        //pdf
        $('#pdf').on('click', function(){
            
            $('#formLaporan').html('');
            let hasError1 = $('#error_awal_waktu').text('');
            let hasError2 = $('#error_akhir_waktu').text('');
            $('#cetakModal').modal('show');
            $('#cetak').off('click').on('click', function(e){
                e.preventDefault();
                let error = 0;
                let awalWaktu = $('#awal_waktu').val();
                let akhirWaktu = $('#akhir_waktu').val();
                if(awalWaktu == ''){
                    hasError1 = $('#error_awal_waktu').text('Data tidak boleh kosong');
                    error = 1;
                }else{
                    hasError2 = $('#error_akhir_waktu').text('');
                }

                if(akhirWaktu == ''){
                    $('#error_akhir_waktu').text('Data tidak boleh kosong');
                    error = 1;
                }else{
                    $('#error_awal_waktu').text('');
                }

                if(error == 0){
                    $('#awal_waktu').val('');
                    $('#akhir_waktu').val('');
                    $('#cetakModal').modal('hide');
                    let pdf = "cetak_pdf.php?awal_waktu="+awalWaktu+"&akhir_waktu="+akhirWaktu;
                    window.location = pdf;
                }
            });
        });

        //excel
        $('#excel').on('click', function(e){
            e.preventDefault();
            $('#formLaporan').html('');
            let hasError1 = $('#error_awal_waktu').text('');
            let hasError2 = $('#error_akhir_waktu').text('');
            $('#cetakModal').modal('show');
            $('#cetak').off('click').on('click', function(e){
                e.preventDefault();
                let error = 0;
                let awalWaktu = $('#awal_waktu').val();
                let akhirWaktu = $('#akhir_waktu').val();
                if(awalWaktu == ''){
                    hasError1 = $('#error_awal_waktu').text('Data tidak boleh kosong');
                    error = 1;
                }else{
                    $('#error_akhir_waktu').text('');
                }

                if(akhirWaktu == ''){
                    hasError2 = $('#error_akhir_waktu').text('Data tidak boleh kosong');
                    error = 1;
                }else{
                    $('#error_awal_waktu').text('');
                }

                if(error == 0){
                    $('#awal_waktu').val('');
                    $('#akhir_waktu').val('');
                    $('#cetakModal').modal('hide');
                    let excel = 'cetak_excel.php?awal_waktu='+awalWaktu+'&akhir_waktu='+akhirWaktu;
                    window.location = excel;
                }
            });
        });

    });

</script>
