<?php 
	session_start();
	require_once('function/koneksi.php');

	define('base_url', 'http://localhost/penjualan/');
	if(isset($_SESSION['user'])){
		header('Location: order.php');
	}
	
	if(isset($_POST['submit'])){
		$nama = $_POST['nama'];
		$email = $_POST['email'];
		$password = $_POST['password'];
		$password2 = $_POST['password2'];

		//validasi atau logika
		if(!empty(trim($email)) && !empty(trim($nama)) && !empty(trim($password)) &&!empty(trim($password2))  ){

			$query_read = "SELECT * FROM user WHERE email='$email'";
			$result_read = mysqli_query($koneksi, $query_read);
		
			if($user = mysqli_num_rows($result_read) == 0){

				if($password == $password2){

					$password = password_hash($password, PASSWORD_DEFAULT);
					$query_insert = "INSERT INTO user(email, nama, password) VALUES('$email', '$nama', '$password')";

					if($result_insert = mysqli_query($koneksi, $query_insert)){
						$_SESSION['success'] = 'Pendaftaran user baru berhasil, silahkan coba login';
						header('Location: login.php');
					}

				}else{
					$error = 'Password tidak sama';
				}

			}else{
				$error = 'Email Sudah ada';
			}

		}else{
			$error = 'Data tidak boleh kosong';
		}
	}

 ?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Pembelian</title>
	<link rel="stylesheet" type="text/css" href="<?= base_url; ?>assets/bootstrap4/dist/css/bootstrap.min.css">
</head>
<body>

	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
	 	<div class="container">	
		  <a class="navbar-brand" href="<?= base_url; ?>">Pembelian</a>
		  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
		    <span class="navbar-toggler-icon"></span>
		  </button>
	</nav>

 	<div class="container mt-5">
 		<div class="row justify-content-center">
 			<div class="col-md-6">

 				<?php if(isset($error)) : ?>
					<div class="alert alert-danger">
						<?= $error; ?>
					</div>
				<?php endif; ?>
 				
 				<form action="" method="post">	
		 			<div class="card">

				 		<div class="card-header">Halaman Daftar</div>
				 		<div class="card-body">
				 			
				 			<div class="form-group">
				 				<label>Email</label>
				 				<input type="email" name="email" id="email" class="form-control">
				 				<span id="error_username" class="text-danger"></span>
				 			</div>

				 			<div class="form-group">
				 				<label>Nama</label>
				 				<input type="text" name="nama" id="nama" class="form-control">
				 				<span id="error_nama" class="text-danger"></span>
				 			</div>


				 			<div class="form-group">
				 				<label>Password</label>
				 				<input type="password" name="password" id="password" class="form-control">
				 				<span id="error_password" class="text-danger"></span>
				 			</div>

				 			<div class="form-group">
				 				<label>Ulangi Password</label>
				 				<input type="password" name="password2" id="password" class="form-control">
				 				<span id="error_password" class="text-danger"></span>
				 			</div>

				 		</div>
				 		<div class="card-footer footer-login">
				 			<button type="submit" name="submit" id="daftar" class="btn btn-primary btn-sm">Daftar</button>
				 			<p class="float-right">Sudah punya akun? <a href="login.php">Login</a></p>
				 		</div>

				 	</div>
 				</form>
 			</div>
 		</div>
 	</div>