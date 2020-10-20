 <?php 

    require_once "../templates/header.php";
    require_once "../templates/sidebar.php";
    require_once "../templates/topbar.php";

  ?>

 <div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="header">

                    		<?php if(isset($_SESSION['success'])) : ?>
                    			<div class="alert alert-success">
                    				<?= $_SESSION['success']; ?>
                    			</div>
                    			<?php unset($_SESSION['success']); ?>
                    		<?php endif; ?>

                        <div class="row">
                          <div class="col-md-6">
                            <h4 class="title">Daftar Barang</h4>
                          </div>

                          <div class="col-md-6 text-right">
                            <a href="tambah.php" class="btn btn-primary btn-fill btn-sm">Tambah Barang</a>
                          </div>
                        </div>
                    </div>
                    <div class="content table-responsive table-full-width">
                        <table class="table table-hover table-striped">
                            <thead>
                              <th class="text-center">No</th>
                              <th>Kode Barang</th>
															<th>Nama Barang</th>
															<th class="text-center">Harga</th>
															<th class="text-center">Stok</th>
															<th class="text-center">Aktif</th>
															<th class="text-center">Aksi</th> 
                            </thead>
   
                            <tbody>
                            		<?php 
                                
                                  $halaman = 10;
                                  $page = isset($_GET["halaman"]) ? (int)$_GET["halaman"] : 1;
                                  $mulai = ($page>1) ? ($page * $halaman) - $halaman : 0;
                                  $result_halaman = mysqli_query($koneksi, "SELECT * FROM barang");
                                  $total = mysqli_num_rows($result_halaman);
                                  $pages = ceil($total/$halaman);            
                                  $no = $mulai+1;

                            			$query = "SELECT * FROM barang ORDER BY nama_barang DESC LIMIT $mulai, $halaman";
																	$result = mysqli_query($koneksi, $query); 

                            			if(mysqli_num_rows($result) < 1) {
                            				echo '<td colspan="11" class="text-center">Data kosong</td>';
                            			}
                            		?>	

                                <?php
                                  $no = 1;
                                	while($row =mysqli_fetch_assoc($result)) : 
                                ?>
																  <tr>
                                    <td class="text-center"><?= $no; ?></td>
																    <td><?php echo $row['kode_barang']; ?></td>
																		<td><?php echo $row['nama_barang']; ?></td>
																		<td class="text-center">Rp. <?php echo number_format($row['harga']); ?></td>
																		<td class="text-center"><?php echo $row['stok']; ?></td>
																		<td class="text-center"><?php echo $row['aktif']; ?></td>
																		<td class="text-center">
																			<a href="edit.php?id_barang=<?php echo $row['id_barang']; ?>" class="btn btn-warning btn-fill btn-xs">Edit</a>
																			<a onclick="return confirm('apa anda yakin?')" href="hapus.php?id_barang=
																		<?php echo $row['id_barang']; ?>" class="btn btn-danger btn-fill btn-xs">Delete</a>
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

