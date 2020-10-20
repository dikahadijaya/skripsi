<?php 
  
  date_default_timezone_set("Asia/Bangkok");
  require_once 'templates/header.php';
  require_once 'templates/sidebar.php';
  require_once 'templates/topbar.php';
  
  $query_barang = mysqli_query($koneksi, "SELECT * FROM barang");
  $jumlah_barang = mysqli_num_rows($query_barang);  

  $stok_barang = 0;
  while($row = mysqli_fetch_assoc($query_barang)){
    $stok_barang = $stok_barang + $row['stok'];
  }

  // penjualan
  $tanggal_jual = date('Y-m-d');
  $queryPembelian = mysqli_query($koneksi, "SELECT * FROM penjualan WHERE tanggal_jual = '$tanggal_jual'");
  $jumlah_transaksi = mysqli_num_rows($queryPembelian);

  //detail penjualan
  $barang_terjual = 0;
  $total_penjualan = 0;
  while($row_pembelian = mysqli_fetch_assoc($queryPembelian))
  {
    $id_penjualan = $row_pembelian["id_penjualan"];
    $queryDetail = mysqli_query($koneksi, "SELECT * FROM detail_penjualan WHERE id_penjualan = '$id_penjualan'");

    // untuk mendapatkan total penjualan
    while($row_detail = mysqli_fetch_assoc($queryDetail))
    {
      $barang_terjual = $barang_terjual + $row_detail['jumlah'];
      $harga = $row_detail['harga'] * $row_detail['jumlah'];
      $total_penjualan = $total_penjualan + $harga;
    }
  }

  $status_penjualan1 = mysqli_num_rows(mysqli_query($koneksi, "SELECT id_penjualan FROM penjualan WHERE status = 1"));
  $status_penjualan2 = mysqli_num_rows(mysqli_query($koneksi, "SELECT id_penjualan FROM penjualan WHERE status = 2"));
  $status_penjualan3 = mysqli_num_rows(mysqli_query($koneksi, "SELECT id_penjualan FROM penjualan WHERE status = 3"));
  $status_penjualan4 = mysqli_num_rows(mysqli_query($koneksi, "SELECT id_penjualan FROM penjualan WHERE status = 4"));

  // total semua penjualan
  $query_semua_penjualan = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM penjualan"));
  $query_semua_detail = mysqli_query($koneksi, "SELECT * FROM detail_penjualan");
  $total_barang_terjual = 0;
  $total_semua_penjualan = 0;
  while($row_semua_detail = mysqli_fetch_assoc($query_semua_detail))
  {
    $total_barang_terjual = $total_barang_terjual + $row_semua_detail['jumlah'];
    $total_harga = $row_semua_detail['harga'] * $row_semua_detail['jumlah'];
    $total_semua_penjualan = $total_semua_penjualan + $total_harga;
  }

 ?>

  <div class="content">
      <div class="container-fluid">
          <div class="row">
              <div class="col-md-6">
                  <div class="card">
                      <div class="header">
                          <h4 class="title text-center">Penjualan hari ini</h4><br>
                      </div>
                      <div class="content">
                        <div class="row text-center">
                          <div class="col-md-4">
                            <h6>Jumlah Transaksi</h6> <br> 
                            <?= $jumlah_transaksi; ?>
                          </div>

                          <div class="col-md-4">
                            <h6>Barang terjual</h6> <br>
                            <?= $barang_terjual; ?>
                          </div>

                          <div class="col-md-4">
                            <h6>Total penjualan</h6> <br>
                            Rp <?= number_format($total_penjualan); ?>
                          </div>
                        </div>
                      </div>
                  </div>
              </div>

              <div class="col-md-6">
                <div class="card">
                  <div class="header">
                      <h4 class="title text-center">Status Penjualan</h4><br>
                  </div>
                  <div class="content">
                    <div class="row text-center">
                      <div class="col-md-3">
                        <h6>Menunggu Pembayaran</h6> <br> 
                        <?= $status_penjualan1; ?>
                      </div>

                      <div class="col-md-3">
                        <h6>Belum di validasi</h6> <br>
                        <?= $status_penjualan2; ?>
                      </div>

                      <div class="col-md-3">
                        <h6>Sudah Lunas</h6> <br>
                        <?= $status_penjualan3; ?>
                      </div>

                      <div class="col-md-3">
                        <h6>Sudah Lunas</h6> <br>
                        <?= $status_penjualan4; ?>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="card">
                  <div class="header">
                      <h4 class="title text-center">Barang</h4><br>
                  </div>
                  <div class="content">
                    <div class="row text-center">
                      <div class="col-md-6">
                        <h6>Jumlah Barang</h6> <br> 
                        <?= $jumlah_barang; ?>
                      </div>

                      <div class="col-md-6">
                        <h6>Total stok barang</h6> <br>
                        <?= $stok_barang; ?>
                      </div>
                    </div>
                  </div>
              </div>
            </div>  
            <div class="col-md-6">
                  <div class="card">
                      <div class="header">
                          <h4 class="title text-center">Total Semua Penjualan</h4><br>
                      </div>
                      <div class="content">
                        <div class="row text-center">
                          <div class="col-md-4">
                            <h6>Jumlah Transaksi</h6> <br> 
                            <?= $query_semua_penjualan; ?>
                          </div>

                          <div class="col-md-4">
                            <h6>Total Barang terjual</h6> <br>
                            <?= $total_barang_terjual; ?>
                          </div>

                          <div class="col-md-4">
                            <h6>Total Semua penjualan</h6> <br>
                            Rp <?= number_format($total_semua_penjualan); ?>
                          </div>
                        </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>

        
 
     

 <?php  
  require_once 'templates/footer.php';
 ?>