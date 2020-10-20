<?php require_once 'templates/header_user.php'; ?>    

	<div class="container-fluid mt-3">
		<h1 class="text-center mb-3">Order Barang</h1>

		<div class="row mt-5">
			<div class="col-lg-6">
				<div class="card">
					<div class="card-header">	
						Daftar Barang <br><br>
						<div class="input-group mb-3">
						  <input type="text" class="form-control" id="cari-barang" name="cari" placeholder="Cari barang..." aria-label="Recipient's username" aria-describedby="button-addon2">
						</div>
					</div>

					<div class="table-responsive">
						<table class="table" id="example1">
							<thead>
								<th class="text-center">No</th>
								<th class="text-center">Kode Barang</th>
								<th class="text-center">Nama Barang</th>
								<th class="text-center">Harga</th>
								<th class="text-center">Stok</th>
								<th class="text-center">Aksi</th>
							</thead>
							<tbody id="tbody-barang"> <!-- isi table barang --></tbody>

							<!-- tampil ketika table barang kosong -->
							<tr class="dataKosong">	
								<td colspan="11" class="text-center">Tidak ada barang</td> 
							</tr>
						</table>
                        <nav>
                            <ul id="page-kasir" class="pagination justify-content-center"><!--halaman --></ul>
                        </nav>
					</div>
					<img src="<?= base_url; ?>loader.gif" class="mx-auto" id="loader" width="100">
				</div>
			</div>

			<div class="col-lg-6">

				<?php if(isset($_SESSION['success'])) : ?>
					<div class="alert alert-success">
						<?= $_SESSION['success']; ?>
					</div>
				<?php unset($_SESSION['success']); ?>
				<?php endif; ?>

				<div class="card mb-1">
					<div class="card-body bg-secondary">
						<h2 class="text-white float-left">Total Harga</h2>	
						<input type="text" id="harga" class="form-control float-right text-right font-weight-bolder" value="0" readonly="" style="width: 70%; font-size: 35px; box-shadow: none;">
					</div>
				</div>
				<div class="card">
					<div class="card-header">Keranjang</div>
					<div class="table-responsive">
						<table id="table-keranjang" class="table">
							<tr>
								<th class="text-center">No</th>
								<th class="text-center">Nama Barang</th>
								<th class="text-center">Harga</th>
								<th class="text-center">Jumlah</th>
								<th class="text-center">Total</th>
								<th class="text-center">Aksi</th>
							</tr>
							<tbody id="tbody-keranjang" style="display: none;"></tbody>
							<tr id="dataKosong" style="display: none;">
								<td colspan="11" class="text-center">Tidak ada barang</td>
							</tr>
						</table>
                    </div>
				</div>
			</div>
		</div>
	</div>

	<!-- Modal -->
	<div class="modal fade" id="pembelianModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">Isi Data Pembelian</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <form id="pembelian">
		      <div class="modal-body">

		      	<input type="hidden" name="id_barang" id="id_barang">
		        <div class="form-group">
		        	<label>Nama</label>
		        	<input type="text" id="nama_penghutang" class="form-control">
                    <span id="error_nama" class="text-danger"></span>
		        </div>

                <div class="form-group">
                    <label>Phone / HP</label>
                    <input type="text" id="phone" class="form-control">
                    <span id="error_phone" class="text-danger"></span>
                </div>

                <div class="form-group">
                    <label>Alamat</label>
                    <textarea id="alamat" class="form-control"></textarea>
                    <span id="error_alamat" class="text-danger"></span>
                </div>

		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		        <button type="button" name="simpan" id="simpan_hutang" class="btn btn-primary">Simpan</button>
		      </div>
	      </form>
	    </div>
	  </div>
	</div>


<script src="<?= base_url; ?>assets/vendor/jquery/dist/jquery.min.js"></script>
<script src="<?= base_url; ?>assets/bootstrap4/dist/js/bootstrap.min.js"></script>
<script>

	// keranjang
    function getKeranjang()
    {

        $.ajax({
            url: '<?= base_url; ?>keranjang.php',
            dataType: 'json',
            success:function(response){
                $('#harga').val(response.total_harga);
                $('#table-keranjang #tbody-keranjang').html(response.data).show();  
            }
        });
    }

    function pembelian()
    {
        $('#pembelianModal').modal('show');
    }

    function tambahKeranjangBarang(id_barang)
    {

        let jumlah = $(document).find('tr#'+id_barang+' #jumlah').val();

        $.ajax({
            url: '<?= base_url; ?>tambah_keranjang.php',
            type: 'POST',
            dataType: 'json',
            data: {
                id_barang: id_barang,
                jumlah: jumlah
            },
            success: function(response){
                getBarang();
                getKeranjang();
            }
        });
    }

    function hapusKeranjang(id_barang)
    {
        $.ajax({
            url: '<?= base_url; ?>hapus_keranjang.php',
            type: 'POST',
            data: {
                id_barang: id_barang
            },
            success: function(response){
                getBarang();
                getKeranjang();
            }
        });
    }

    //input pembelian
    function prosesKeranjang()
    {

        $('#prosesModal').modal('show');

        $('#hitung').on('click', function(){

            let uang = $('#uang').val();

            $.ajax({
                url: '<?= base_url; ?>proses_keranjang.php',
                type: 'POST',
                data: {uang: uang},
                success: function(response){
                    $('#prosesModal').modal('hide');
                    $('#Kembalian').html('Kembalian = '+response);
                    $('#kembalianModal').modal('show');

                    $('#selesai-transaksi').on('click', function(){
                        location.reload();
                    });

                    $('#kembalianModal').on('hidden.bs.modal', function(){
                        location.reload();
                    });


                }
            });

        });
    }
    // akhir keranjang

    // get barang
    function getBarang(cari, halaman)
    {   
        $.ajax({
            url: '<?= base_url; ?>get_barang.php',
            type: 'POST',
            data: {
                cari: cari,
                halaman: halaman,
            },
            dataType: 'json',
            success:function(response){
                $('table #tbody-barang').html(response.table).show();
                $('#page-kasir').html(response.halaman); 
            }
        });
    }


    $(document).ready(function(){
    	getBarang();
        getKeranjang();

        // halaman barang
        $(document).on('click', '#page-kasir .page-item', function(){  
           let halaman = $(this).attr("id");  
           getBarang('',halaman);  
        });

        //pencarian barang
        $('#cari-barang').keyup(function(){
            let cari = $(this).val();
            let halaman;
            if(cari != ''){
                getBarang(cari, halaman)
            }else{
                getBarang();
            }
        });

        //update keranjang
        $(document).on('input', '#jumlah', function(){

            let input_barang = $(this).val();
            let id_barang = $(this).data('id');
            let stok = $('#'+id_barang+' td#stok-kasir').html();

            if(input_barang == ''){     //jika input barang kosong
                $(this).val('0');
                input_barang = 0;
            }else if(input_barang < 0){ //jika input barang lebih kecil dari 0
                $(this).val('0');
                input_barang = 0;
            }

            $.ajax({
                url: '<?= base_url; ?>update_keranjang.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    input_barang: input_barang,
                    id_barang: id_barang
                },
                success: function(response){
                    getBarang();
                    getKeranjang();
                }
            });

        });

    });
</script>