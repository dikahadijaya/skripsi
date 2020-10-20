<?php 

  require_once '../templates/header.php';
  require_once '../templates/sidebar.php';
  require_once '../templates/topbar.php';

  if (isset($_POST['submit'])) {
    
    $nama = $_POST['nama'];
    $sub_nama = $_POST['sub_nama'];
    $deskripsi = $_POST['deskripsi'];
    $kontak = $_POST['kontak'];
    $nama_foto = $_POST['background'];

    if(isset($_FILES['background']['name'])){
      $nama_foto = $_FILES['background']['name'];
      $asal_lokasi = $_FILES['background']['tmp_name'];
      $lokasi = '../../assets/img/'.$nama_foto;
      move_uploaded_file($asal_lokasi, $lokasi);
    }

    $query = "UPDATE profile SET nama = '$nama', 
                                 sub_nama = '$sub_nama', 
                                 background = '$nama_foto', 
                                 deskripsi = '$deskripsi', 
                                 kontak = '$kontak'
                                 WHERE id = 1";

    mysqli_query($koneksi,$query);
    $_SESSION['success'] = 'Data Berhasil disimpan';
    header('Location: ');
      
  }

  $profile = mysqli_query($koneksi, "SELECT * FROM profile WHERE id = 1");
  $row = mysqli_fetch_assoc($profile);


 ?>

  <div class="content">
      <div class="container-fluid">
          <div class="row">
              <div class="col-md-12">
                  <div class="card">
                      <div class="header">

                          <h4 class="title">Profile</h4><br>

                          <?php if(isset($_SESSION['success'])) : ?>
                          <div class="alert alert-success">
                            <?= $_SESSION['success']; ?>
                          </div>
                          <?php unset($_SESSION['success']); ?>
                        <?php endif; ?>

                      </div>
                      <div class="content">
                        <div class="row">
                          <div class="col-md-12">
                            <form action="" method="POST" enctype="multipart/form-data">

                              <div class="form-group">
                                <label>Nama</label>
                                <input type="text" name="nama" class="form-control" value="<?= $row['nama']; ?>">
                              </div>

                              <div class="form-group">
                                <label>Sub nama</label>
                                <input type="text" name="sub_nama" class="form-control" value="<?= $row['sub_nama']; ?>">
                              </div>

                              <div class="form-group">
                                <label>Background</label>
                                <div class="row">
                                  <div class="col-md-4">
                                    <img src="../../assets/img/<?= $row['background']; ?>" class="img-thumbnail">
                                  </div>
                                  
                                  <div class="col-md-8">
                                    <input type="file" name="background" class="form-control">
                                    <input type="hidden" name="background" value="<?= $row['background']; ?>">
                                  </div>
                                </div>
                              </div>

                              <div class="form-group">
                                <label>Deskripsi</label>
                                <textarea name="deskripsi" class="form-control" rows="5"><?= $row['deskripsi']; ?></textarea>
                              </div>

                              <div class="form-group">
                                <label>Kontak</label>
                                <textarea name="kontak" class="form-control" rows="5"><?= $row['kontak']; ?></textarea>
                              </div>

                              <button type="submit" name="submit" class="btn btn-primary btn-fill btn-sm">Simpan</button>

                            </form>
                          </div>
                        </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>

        
 
     

 <?php  
  require_once '../templates/footer.php';
 ?>