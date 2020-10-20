 <?php 

    require_once "../templates/header.php";
    require_once "../templates/sidebar.php";
    require_once "../templates/topbar.php";
    require_once "../../function/helper.php";

  ?>

 <div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card" style="padding: 10px;">
                  <div class="row">
                    <div class="col-md-8">
                      <form action="" method="get">
                        <label>Mulai dari tanggal : </label>
                        <input type="date" name="dari" required="">
                        <label> Sampai </label>
                        <input type="date" name="sampai" required="">
                        <button type="submit" class="btn btn-xs btn-secondary btn-fill">Cari</button>
                      </form>
                    </div>
                    <div class="col-md-4 text-right">
                      <?php if(isset($_GET['dari']) && isset($_GET['sampai'])) : ?>
                        <a href="cetak_pdf.php?dari=<?= $_GET['dari']; ?>&sampai=<?= $_GET['sampai']; ?>" target="_blank" class="btn btn-sm btn-warning btn-fill">Cetak</a>
                      <?php endif; ?>
                    </div>
                  </div>
                </div>
                <div class="card">
                    <div class="header">

                    		<?php if(isset($_SESSION['success'])) : ?>
                    			<div class="alert alert-success">
                    				<?= $_SESSION['success']; ?>
                    			</div>
                    			<?php unset($_SESSION['success']); ?>
                    		<?php endif; ?>

                        <div class="row">
                          <div class="col-md-4">
                            <h4 class="title">Laporan Penjualan</h4>
                          </div>
                        </div>
                    </div>
                    <div class="content table-responsive table-full-width">
                        <table class="table table-hover table-striped">
                            <thead>
                              <th class="text-center">No</th>
                              <th class="text-center">ID Penjualan</th>
															<th class="text-center">Tanggal Penjualan</th>
															<th class="text-center">Jumlah Barang</th>
															<th class="text-center">Total Harga</th>
															<th class="text-center">Status</th>
															<th class="text-center">Aksi</th> 
                            </thead>
   
                            <tbody>
                            		<?php
                                  $halaman = 10;
                                  $page = isset($_GET["halaman"]) ? (int)$_GET["halaman"] : 1;
                                  $mulai = ($page>1) ? ($page * $halaman) - $halaman : 0;
                                  $result_halaman = mysqli_query($koneksi, "SELECT * FROM penjualan");
                                  $total = mysqli_num_rows($result_halaman);
                                  $pages = ceil($total/$halaman);            
                                  $no = $mulai+1;

                                  if(isset($_GET['dari']) && isset($_GET['sampai'])){
                                    $dari = $_GET['dari'];
                                    $sampai = $_GET['sampai'];
                                    $query = "SELECT * FROM penjualan WHERE tanggal_jual BETWEEN '$dari' AND '$sampai'";
                                  }else{
                                   $query = "SELECT * FROM penjualan ORDER BY id_penjualan DESC LIMIT $mulai, $halaman";
                                  }

                                  $result = mysqli_query($koneksi, $query);
                            			if(mysqli_num_rows($result) < 1) {
                            				echo '<td colspan="11" class="text-center">Data kosong</td>';
                            			}
                            		?>	

                                <?php
                                  $no = 1;
                                	while($row =mysqli_fetch_assoc($result)) : 
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
                                      <td class="text-center"><?= 'Rp '.number_format($totalHarga); ?></td>
                                      <td class="text-center"><?= checkStatus($row['status']); ?></td>
                                      <td class="text-center">
                                          <a href="detail.php?id=<?= $row['id_penjualan']; ?>" class="btn btn-success btn-xs btn-fill">Detail</a>
                                          <a onclick="return confirm('Apa anda yakin?')" href="hapus.php?id=<?= $row['id_penjualan']; ?>" class="btn btn-danger btn-xs btn-fill">Hapus</a>
                                      </td>
                                    </tr>
                                <?php 
                                  $no++;
                                  endwhile;  
                              ?>
                            </tbody>
                        </table>
                    </div>
                    <nav aria-label="Page navigation" class="text-center">
                      <ul class="pagination">
                        <!-- <li>
                          <a href="#" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                          </a>
                        </li> -->
                        <?php for ($i=1; $i<=$pages; $i++) : ?>
                          <?php if($page == $i) : ?>
                            <li class="active"><a class="page-link" href="?halaman=<?= $i; ?>"><?= $i; ?></a></li>
                          <?php else : ?>
                            <li><a href="?halaman=<?= $i; ?>"><?= $i; ?></a></li>
                          <?php endif; ?>
                        <?php endfor; ?>
                        <!-- <li>
                          <a href="#" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                          </a>
                        </li> -->
                      </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
 </div>

 <?php require_once "../templates/footer.php"; ?>

