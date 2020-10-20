
 <?php 

    require_once "../templates/header.php";
    require_once "../templates/sidebar.php";
    require_once "../templates/topbar.php";
    require_once "../../function/helper.php";

    $id_penjualan = $_GET['id'];
    $query_penjualan = mysqli_query($koneksi, "SELECT * FROM penjualan WHERE id_penjualan = '$id_penjualan'");
		$row_penjualan = mysqli_fetch_assoc($query_penjualan);

		$query_user = mysqli_query($koneksi, "SELECT * FROM user WHERE email = '$row_penjualan[email]'");
		$row_user = mysqli_fetch_assoc($query_user);

		$sql_detail = "SELECT detail_penjualan.*, barang.nama_barang, penjualan.tanggal_jual, penjualan.jam FROM detail_penjualan JOIN barang ON detail_penjualan.id_barang = barang.id_barang JOIN penjualan ON detail_penjualan.id_penjualan = penjualan.id_penjualan WHERE detail_penjualan.id_penjualan = $id_penjualan ORDER BY id_penjualan";
		$query_detail = mysqli_query($koneksi, $sql_detail);

		$query_konfirmasi = mysqli_query($koneksi, "SELECT * FROM konfirmasi WHERE id_penjualan = $id_penjualan");
		$row_konfirmasi = mysqli_fetch_assoc($query_konfirmasi);

		if(isset($_GET['status']) && isset($_GET['id_penjualan'])){
      $id_penjualan = $_GET['id_penjualan'];
      $status = $_GET['status'];
      $sql_update = "UPDATE penjualan SET status = '$status' WHERE id_penjualan = '$id_penjualan'";
      mysqli_query($koneksi, $sql_update);
      $_SESSION['success'] = 'Update status berhasil';
      header('Location: index.php');
    }

  ?>

 <div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="header">
                        <div class="row">
                          <div class="col-md-6">
                            <h4 class="title">Detail Penjualan</h4>
                          </div>

                          <div class="col-md-6 text-right">
                          	<div class="btn-group">
                              <button type="button" class="btn btn-success btn-sm btn-fill dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Update Status <span class="caret"></span>
                              </button>
                              <ul class="dropdown-menu dropdown-menu-right">
                                <li><a href="?id_penjualan=<?= $id_penjualan; ?>&status=1">Menunggu Pembayaran</a></li>
                                <li><a href="?id_penjualan=<?= $id_penjualan; ?>&status=2">Sedang di Validasi</a></li>
                                <li><a href="?id_penjualan=<?= $id_penjualan; ?>&status=3">Pembayaran Lunas</a></li>
                                <li><a href="?id_penjualan=<?= $id_penjualan; ?>&status=4">Pembayaran ditolak</a></li>
                              </ul>
	                           </div>
                          </div>
                        </div>
                    </div>
                    <div class="content table-responsive table-full-width">               
					             <table class="table table-hover table-striped">
								      		<tr>
								      			<td>ID</td>
								      			<td>:</td>
								      			<td id="id_pembelian"><?= $row_penjualan['id_penjualan']; ?></td>
								      		</tr>

								      		<tr>
								      			<td>Nama</td>
								      			<td>:</td>
								      			<td id="nama_pembeli"><?= $row_user['nama']; ?></td>
								      		</tr>

								      		<tr>
								      			<td>Tanggal</td>
								      			<td>:</td>
								      			<td id="tanggal_pembelian"><?= $row_penjualan['tanggal_jual']; ?> &nbsp; <?= $row_penjualan['jam']; ?></td>
								      		</tr>

								      		<tr>
								      			<td>Alamat</td>
								      			<td>:</td>
								      			<td id="alamat"><?= $row_konfirmasi['alamat']; ?></td>
								      		</tr>

								      		<tr>
								      			<td>No Rekening</td>
								      			<td>:</td>
								      			<td id="rekening"><?= $row_konfirmasi['rekening']; ?></td>
								      		</tr>

								      		<tr>
								      			<td>Jumlah Uang yang dibayar</td>
								      			<td>:</td>
								      			<td id="jumlah_uang"><?= 'Rp '.number_format($row_konfirmasi['jumlah_uang']); ?></td>
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
        </div>
    </div>
 </div>
</div>

 <?php require_once "../templates/footer.php"; ?>

