 <?php 

    require_once "../templates/header.php";
    require_once "../templates/sidebar.php";
    require_once "../templates/topbar.php";

    $id_barang = $_GET['id_barang'];

    if(isset($_POST['submit'])){
      $kode_barang = $_POST['kode_barang'];
      $nama_barang = $_POST['nama_barang'];
      $harga = $_POST['harga'];
      $stok = $_POST['stok'];
      $aktif = $_POST['aktif'];

      $sql = "UPDATE barang SET kode_barang = '$kode_barang', 
                                nama_barang = '$nama_barang', 
                                harga = '$harga', 
                                stok = '$stok', 
                                aktif = '$aktif' 
                                WHERE id_barang = $id_barang";

      $query = mysqli_query($koneksi, $sql);
      $_SESSION['success'] = 'Barang berhasil diupdate';
      header('Location: index.php');

    }

    $query_barang = mysqli_query($koneksi, "SELECT * FROM barang WHERE id_barang = $id_barang");
    $row = mysqli_fetch_assoc($query_barang);

  ?>

 <div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="header">
                        <h4 class="title">Edit Barang</h4>
                    </div>
                    <div class="content">
                      <form action="" method="POST">
                        <div class="form-group">
                          <label>Kode Barang</label>
                          <input type="text" name="kode_barang" class="form-control" value="<?= $row['kode_barang']; ?>">
                        </div>

                        <div class="form-group">
                          <label>Nama Barang</label>
                          <input type="text" name="nama_barang" class="form-control" value="<?= $row['nama_barang']; ?>">
                        </div>

                        <div class="form-group">
                          <label>Harga</label>
                          <input type="text" name="harga" class="form-control" value="<?= $row['harga']; ?>">
                        </div>

                        <div class="row">    
                            <div class="col-md-8">     
                                <div class="form-group">
                                  <label>Stok</label>
                                  <input type="text" name="stok" class="form-control" value="<?= $row['stok']; ?>">
                                </div>
                            </div> 

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label></label>
                                  <input type="text" value="KG" readonly="" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                          <label>Status</label>   
                          <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="aktif" id="inlineRadio1" value="1" <?= ($row['aktif'] == '1') ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="inlineRadio1" >Aktif</label>
                          </div>

                          <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="aktif" id="inlineRadio2" value="0" <?= ($row['aktif'] == '0') ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="inlineRadio2">Tidak Aktif</label>
                          </div>
                        </div>

                        <button type="submit" name="submit" class="btn btn-primary btn-fill btn-sm">Update</button>
                      </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
 </div>

 <?php require_once "../templates/footer.php"; ?>

