<?php 
	
	require_once('templates/header_user.php'); 
	require_once('function/helper.php');

	$query_penjualan = mysqli_query($koneksi, "SELECT * FROM penjualan WHERE id_penjualan = '$_GET[id]'");
	$row_penjualan = mysqli_fetch_assoc($query_penjualan);

	$sql_detail = "SELECT detail_penjualan.*, barang.nama_barang, penjualan.tanggal_jual, penjualan.jam FROM detail_penjualan JOIN barang ON detail_penjualan.id_barang = barang.id_barang JOIN penjualan ON detail_penjualan.id_penjualan = penjualan.id_penjualan WHERE detail_penjualan.id_penjualan = $_GET[id] ORDER BY id_penjualan";
	$query_detail = mysqli_query($koneksi, $sql_detail);

	if(isset($_POST['submit'])){
		$rekening = $_POST['rekening'];
		$nama = $_POST['nama'];
		$jumlah_uang = $_POST['jumlah_uang'];
		$alamat = $_POST['alamat'];

		$sql_insert = "INSERT INTO konfirmasi(id_penjualan, rekening, nama, jumlah_uang, alamat) VALUEs('$_GET[id]', '$rekening', '$nama', '$jumlah_uang', '$alamat')";
		$query_insert = mysqli_query($koneksi, $sql_insert);
		mysqli_query($koneksi, "UPDATE penjualan SET status = status+1 WHERE id_penjualan = $_GET[id]");
		$_SESSION['success'] = 'Konfirmasi pembayaran berhasil dilakukan, tunggu konfirmasi selanjutnya dari admin';
		header('Location: laporan.php');
	}
 ?>

 <div class="container mt-3 mb-5">

        <?php if(isset($_SESSION['success'])) : ?>
            <div class="alert alert-success">
                <?= $_SESSION['success']; ?>
            </div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

		<div class="card">
			<div class="card-header">
				Invoice
			</div>
			
            <div class="table-responsive">                
                <table class="table">
		      		<tr>
		      			<td>ID Pembelian</td>
		      			<td>:</td>
		      			<td id="id_pembelian"><?= $row_penjualan['id_penjualan']; ?></td>
		      		</tr>

		      		<tr>
		      			<td>Tanggal Pembelian</td>
		      			<td>:</td>
		      			<td id="tanggal_pembelian"><?= $row_penjualan['tanggal_jual']; ?> <?= $row_penjualan['jam']; ?></td>
		      		</tr>

		      		<tr>
		      			<td>Status</td>
		      			<td>:</td>
		      			<td><?= checkStatus($row_penjualan['status']); ?></td>
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
		      		<tbody>
		      			<?php 
		      				$jumlahBarang = 0;
							$totalHarga = 0;
							$harga = 0;
		      				$no = 1;
		      				while($rowDetail = mysqli_fetch_assoc($query_detail)) : 
		      				$jumlahBarang = $jumlahBarang + $rowDetail['jumlah'];
							$harga = $rowDetail['harga'] * $rowDetail['jumlah'];
							$totalHarga = $totalHarga + $harga;
		      			?>
		      				<tr>
		      					<td class="text-center"><?= $no; ?></td>
				      			<td id="detail_nama_barang" class="text-center"><?= $rowDetail["nama_barang"]; ?></td>
				      			<td id="detail-harga" class="text-center"><?= 'Rp '.number_format($rowDetail["harga"]); ?></td>
				      			<td id="detail-jumlah" class="text-center"><?= $rowDetail["jumlah"];?></td>
				      			<td id="detail-harga-barang" class="text-right"><?= 'Rp '.number_format($harga); ?></td>
		      				</tr>
		      			<?php 
		      				$no++;
		      				endwhile; 
		      			?>
		      				<tr>
								<td></td>
								<td></td>
								<td></td>
								<th id="detail-total-harga" class="text-center">Total Harga</th>
								<td align="right"><?= 'Rp '.number_format($totalHarga); ?></td>
						  </tr>
		      		</tbody>
                </table> 
            </div>
		</div>
		<br>
		<?php if($row_penjualan['status'] == 1 || $row_penjualan['status'] == 4) : ?>
			<div class="row">
				<div class="col-md-6">
					<div class=card>
						<div class="card-header">Konfirmasi pembayaran setelah mentransfer</div>

						<div class="card-body">
							<form action="" method="post">
								<div class="form-group">
									<label>No Rekening</label>
									<input type="text" name="rekening" class="form-control">
								</div>

								<div class="form-group">
									<label>Atas Nama</label>
									<input type="text" name="nama" class="form-control">
								</div>

								<div class="form-group">
									<label>Jumlah uang yang di transfer</label>
									<input type="text" name="jumlah_uang" class="form-control">
								</div>

								<div class="form-group">
									<label>Alamat Pengiriman</label>
									<input type="text" name="alamat" class="form-control">
								</div>
								<button class="btn btn-primary bn-sm" type="submit" name="submit">Konfirmasi</button>
							</form>
						</div>
					</div>	
				</div>

				<div class="col-md-6">
					<div class="card">	
						<div class="card-header">Silahkan transfer ke salah satu rekening</div>
						<div class="card-body">
							<table class="table table-bordered">
								<tr>
									<tr>		
										<th colspan="2">Bank Mandiri</th>
									</tr>
									<tr>
										<td>No Rekening</td>
										<td>0000-0000-0000</td>
									</tr>
									<tr>
										<td>Atas Nama</td>
										<td>Dika Hadijaya</td>
									</tr>
								</tr>

								<tr>
									<tr>		
										<th colspan="2">Bank BRI</th>
									</tr>
									<tr>
										<td>No Rekening</td>
										<td>0000-0000-0000</td>
									</tr>
									<tr>
										<td>Atas Nama</td>
										<td>Dika Hadijaya</td>
									</tr>
								</tr>
							</table>
						</div>
						<div class="card-footer">
							Informasi lebih lanjut silahkan hubungi WhatsApp kami 087788778877
						</div>
					</div>
				</div>
			</div>
		<?php endif; ?>
</div>