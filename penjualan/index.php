<?php 

  require_once('function/koneksi.php');
  $query_profile = mysqli_query($koneksi, "SELECT * FROM profile WHERE id = 1");
  $row_profile = mysqli_fetch_assoc($query_profile);

 ?> 


<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Business Frontpage - Start Bootstrap Template</title>

  <!-- Bootstrap core CSS -->
  <link href="assets/bootstrap4/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- <link rel="stylesheet" type="text/css" href="assets/css/style.css"> -->
  <link rel="stylesheet" type="text/css" href="assets/vendor/@fontawesome/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" type="text/css" href="assets/vendor/@fontawesome/fontawesome-free/css/fontawesome.min.css">
  <!-- Custom styles for this template -->
  <link href="assets/css/business-frontpage.css" rel="stylesheet">

</head>

<body>

  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
      <a class="navbar-brand" href="#">Start Bootstrap</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item active">
            <a class="nav-link" href="#">Home
              <span class="sr-only">(current)</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="login.php">Login</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Header -->
  <header class="bg-primary py-5 mb-5" style="background: linear-gradient(to bottom, rgba(22, 22, 22, 0.5) 0%, rgba(22, 22, 22, 0.7) 75%, #161616 100%), url('assets/img/<?= $row_profile['background']; ?>'); background-size: cover; background-color: #242e26; min-height: 400px;">
    <div class="container h-100">
      <div class="row h-100 align-items-center">
        <div class="col-lg-12">
          <h1 class="display-4 text-white mt-5 mb-2"><?= $row_profile['nama']; ?></h1>
          <p class="lead mb-5 text-white-50"><?= $row_profile['sub_nama']; ?></p>
        </div>
      </div>
    </div>
  </header>

  <!-- Page Content -->
  <div class="container">

    <div class="row">
      <div class="col-md-8 mb-5">
        <h2>Deskripsi</h2>
        <hr>
        <p><?= $row_profile['deskripsi']; ?></p>
        <a class="btn btn-primary" href="order.php">Order Barang &raquo;</a>
      </div>
      <div class="col-md-4 mb-5">
        <h2>Kontak</h2>
        <hr>
        <p><?= $row_profile['kontak']; ?></p>
        <!-- <address>
          <strong>Start Bootstrap</strong>
          <br>3481 Melrose Place
          <br>Beverly Hills, CA 90210
          <br>
        </address>
        <address>
          <abbr title="Phone">P:</abbr>
          (123) 456-7890
          <br>
          <abbr title="Email">E:</abbr>
          <a href="mailto:#">name@example.com</a>
        </address> -->
      </div>
    </div>
    <!-- /.row -->

    
    <!-- /.row -->


    <div class="row">
        <div class="col-6">
            <h3 class="mb-3">Daftar Produk </h3>
        </div>
        <div class="col-6 text-right">
            <a class="btn btn-primary mb-3 mr-1" href="#carouselExampleIndicators2" role="button" data-slide="prev">
                <i class="fa fa-arrow-left"></i>
            </a>
            <a class="btn btn-primary mb-3 " href="#carouselExampleIndicators2" role="button" data-slide="next">
                <i class="fa fa-arrow-right"></i>
            </a>
        </div>
        <div class="col-12">
            <div id="carouselExampleIndicators2" class="carousel slide" data-ride="carousel">

                <div class="carousel-inner">
                <?php 
                  $query_barang = mysqli_query($koneksi, "SELECT * FROM barang WHERE aktif = 1");
                  $jumlah_barang = ceil(mysqli_num_rows($query_barang)/4);  
                  $awal = 1;
                  $akhir = 4;
                  for($i=0; $i<$jumlah_barang; $i++) :
                    $query = mysqli_query($koneksi, "SELECT * FROM barang WHERE aktif = 1 ORDER BY nama_barang ASC LIMIT $awal, $akhir"); 
                ?>
                    <div class="carousel-item <?= ($awal == 1) ? 'active' : ''; ?>">
                        <div class="row">
                          <?php while($row_barang = mysqli_fetch_assoc($query)) : ?>
                            <div class="col-md-3 mb-5">
                              <div class="card">
                                <img class="card-img-top" src="./assets/img/barang/<?= $row_barang['gambar']; ?>" alt="">
                                <div class="card-body">
                                  <h4 class="card-title text-center"><?= $row_barang['nama_barang']; ?></h4>
                                  <p class="card-text text-center">Stok : <?= $row_barang['stok']; ?></p>
                                  <p class="card-text text-center">Rp <?= number_format($row_barang['harga']); ?></p>
                                </div>
                              </div>
                            </div>
                            <?php endwhile; ?>
                        </div>
                    </div>
                <?php 
                  $awal+=4;
                  endfor; 
                ?>
                </div>
            </div>
        </div>
    </div>



  </div>
  <!-- /.container -->

  <!-- Footer -->
  <footer class="py-5 bg-dark">
    <div class="container">
      <p class="m-0 text-center text-white">Copyright &copy; <?= $row_profile['footer']; ?> 2019</p>
    </div>
    <!-- /.container -->
  </footer>

  <!-- Bootstrap core JavaScript -->
  <script src="assets/vendor/jquery/dist/jquery.min.js"></script>
  <script src="assets/bootstrap4/dist/js/bootstrap.min.js"></script>
  <!-- <script src="assets/vendor/popper.js/dist/popper.min.js"></script> -->

</body>

</html>
