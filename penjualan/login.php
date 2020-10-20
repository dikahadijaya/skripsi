<?php 
	require_once('function/koneksi.php');
	session_start();
	define('base_url', 'http://localhost/penjualan/');
	if(isset($_SESSION['user'])){
		header('Location: order.php');
	} 
	
	if(isset($_POST['submit'])){

		$email = $_POST['email'];
		$password = $_POST['password'];

		//validasi atau logika
		if(!empty(trim($email)) && !empty(trim($password))){

			$query_read = "SELECT * FROM user WHERE email='$email'";
			$result_read = mysqli_query($koneksi, $query_read);
		
			if($user = mysqli_num_rows($result_read) != 0){
				$row = mysqli_fetch_assoc($result_read);
				if(password_verify($password, $row['password'])){
					$_SESSION['user'] = $email;
					header('Location: order.php');

				}else{
					$error = 'Username atau password salah';
				}
			}else{
				$error = 'Email belum terdaftar';
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

 				<?php if(isset($_SESSION['success'])) : ?>
        			<div class="alert alert-success">
        				<?= $_SESSION['success']; ?>
        			</div>
        			<?php unset($_SESSION['success']); ?>
        		<?php endif; ?>

        		<?php if(isset($error)) : ?>
					<div class="alert alert-danger">
						<?= $error; ?>
					</div>
				<?php endif; ?>

 				<form id="formLogin" action="" method="post">	
		 			<div class="card">

				 		<div class="card-header">Halaman Login</div>
				 		<div class="card-body">
				 			
				 			<div class="form-group">
				 				<label>Email</label>
				 				<input type="email" name="email" id="email" class="form-control">
				 				<span id="error_username" class="text-danger"></span>
				 			</div>

				 			<div class="form-group">
				 				<label>Password</label>
				 				<input type="password" name="password" id="password" class="form-control">
				 				<span id="error_password" class="text-danger"></span>
				 			</div>

				 		</div>
				 		<div class="card-footer footer-login">
				 			<button type="submit" name="submit" id="login" class="btn btn-primary btn-sm">Login</button>
				 			<p class="float-right">Belum punya akun? <a href="daftar.php">Daftar</a></p>
				 		</div>

				 	</div>
 				</form>
 			</div>
 		</div>
 	</div>