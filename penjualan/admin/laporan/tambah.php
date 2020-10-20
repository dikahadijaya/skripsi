 <?php 

    require_once "../templates/header.php";
    require_once "../templates/sidebar.php";
    require_once "../templates/topbar.php";

    if(isset($_POST['submit'])){
      $kode_barang = $_POST['kode_barang'];
      $nama_barang = $_POST['nama_barang'];
      $harga = $_POST['harga'];
      $stok = $_POST['stok'];

      $sql = "INSERT INTO barang(kode_barang, nama_barang, harga, stok) VALUES('$kode_barang', '$nama_barang', '$harga', '$stok')";
      $query = mysqli_query($koneksi, $sql);
      $_SESSION['success'] = 'Barang berhasil ditambahkan';
      header('Location: index.php');

    }

  ?>

 <div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="header">

                    		
                        
                        <h4 class="title">Tambah Barang</h4>

                    </div>
                    <div class="content">
                      <form action="" method="POST">
                        <div class="form-group">
                          <label>Kode Barang</label>
                          <input type="text" name="kode_barang" class="form-control">
                        </div>

                        <div class="form-group">
                          <label>Nama Barang</label>
                          <input type="text" name="nama_barang" class="form-control">
                        </div>

                        <div class="form-group">
                          <label>Harga</label>
                          <input type="text" name="harga" class="form-control">
                        </div>

                        <div class="row">    
                            <div class="col-md-8">     
                                <div class="form-group">
                                  <label>Stok</label>
                                  <input type="text" name="stok" class="form-control">
                                </div>
                            </div> 

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label></label>
                                  <input type="text" value="KG" readonly="" class="form-control">
                                </div>
                            </div>
                        </div>

                        <button type="submit" name="submit" class="btn btn-primary btn-fill btn-sm">Tambah</button>
                      </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
 </div>

 <?php require_once "../templates/footer.php"; ?>

