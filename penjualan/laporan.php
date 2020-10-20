
<?php 
	require_once('templates/header_user.php'); 
	require_once('function/helper.php');
?>

	<div class="container mt-3">

    <?php if(isset($_SESSION['success'])) : ?>
        <div class="alert alert-success">
            <?= $_SESSION['success']; ?>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

		<div class="card">
			<div class="card-header">
				Laporan Pembelian
			</div>
			
      <div class="table-responsive">                
          <table class="table">
              <thead>
              	<tr>
                    <th class="text-center">No</th>
                    <th class="text-center">ID Pembelian</th>
                    <th class="text-center">Tanggal Pembelian</th>
                    <th class="text-center">Jumlah Barang</th>
                    <th class="text-center">Total Harga</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Aksi</th>
              	</tr>
              </thead>

              <?php 
              	$halaman = 10;
                $page = isset($_GET["halaman"]) ? (int)$_GET["halaman"] : 1;
                $mulai = ($page>1) ? ($page * $halaman) - $halaman : 0;
                $result_halaman = mysqli_query($koneksi, "SELECT * FROM penjualan WHERE email = '$_SESSION[user]'");
                $total = mysqli_num_rows($result_halaman);
                $pages = ceil($total/$halaman);            
                $no = $mulai+1;
              	$query = mysqli_query($koneksi, "SELECT * FROM penjualan WHERE email = '$_SESSION[user]' ORDER BY id_penjualan DESC LIMIT $mulai, $halaman");
          		?>

          	<?php if(mysqli_num_rows($query) == 0 ): ?>
                <tr> 
                    <td colspan="6" class="text-center">Tidak ada pembelian</td> 
                </tr>
              <?php endif; ?>
              <tbody>
                <?php 
                	$no = 1;
                  while($row = mysqli_fetch_assoc($query)) : 
                      $queryDetail = "SELECT id_penjualan, SUM(jumlah) AS jumlah_barang, SUM(jumlah * harga) AS harga_barang FROM detail_penjualan WHERE id_penjualan = '$row[id_penjualan]'";
                      $detail = mysqli_query($koneksi, $queryDetail);

                      $jumlahBarang = 0;
											$totalHarga = 0;
											$harga = 0;
                      while($rowDetail = mysqli_fetch_assoc($detail))
                      {
                          $jumlahBarang += $rowDetail['jumlah_barang'];
                          $harga += $rowDetail['harga_barang'];
                          $totalHarga += $harga;
                      }    
                ?>
                  <tr>
                      <td class="text-center"><?= $no; ?></td>
                      <td class="text-center"><?= $row['id_penjualan']; ?></td>
                      <td class="text-center"><?= $row['tanggal_jual']; ?></td>
                      <td class="text-center"><?= $jumlahBarang; ?></td>
                      <td class="text-center">Rp <?= number_format($totalHarga); ?></td>
                      <td class="text-center"><?= checkStatus($row['status']); ?></td>
                      <td class="text-center">
                          <a href="konfirmasi.php?id=<?= $row['id_penjualan']; ?>" class="btn btn-success btn-sm">Konfirmasi Pembayaran</a>
                      </td>
                  </tr>
              <?php 
              	$no++;
          		endwhile; 
          	?>
              </tbody>
          </table>
      </div>
			
			<nav>
				<ul class="pagination justify-content-center"><!--halaman --></ul>
			</nav>

			<div class="card-footer">
					<nav aria-label="...">
					  <ul class="pagination pagination-sm justify-content-center">
					    <!-- <li class="page-item disabled">
					      <a class="page-link" href="#" tabindex="-1" aria-disabled="true"><</a>
					    </li> -->
					    <?php for ($i=1; $i<=$pages; $i++) : ?>
					    	<?php if($page == $i) : ?>
					    		<li class="page-item active"><a class="page-link" href="?halaman=<?= $i; ?>"><?= $i; ?></a></li>
					    	<?php else : ?>
					    		<li class="page-item"><a class="page-link" href="?halaman=<?= $i; ?>"><?= $i; ?></a></li>
							<?php endif; ?>
						<?php endfor; ?>
					   <!--  <li class="page-item">
					      <a class="page-link" href="#">></a>
					    </li> -->
					  </ul>
					</nav>
				</div>

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
