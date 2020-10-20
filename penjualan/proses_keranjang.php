<?php 

	date_default_timezone_set("Asia/Bangkok");
	session_start();
	require_once('function/koneksi.php');

	$keranjang = isset($_SESSION['keranjang']) ? $_SESSION['keranjang'] : array();
	$email = $_SESSION['user'];
	$tanggal_jual = date('Y-m-d');
	$jam = date('H:i:s');
	$status = 1;

	$query_penjualan = "INSERT INTO penjualan(email, tanggal_jual, jam, status) VALUES ('$email', '$tanggal_jual', '$jam', '$status')";
	mysqli_query($koneksi, $query_penjualan);
	$last_id = mysqli_insert_id($koneksi);

	foreach($keranjang as $key => $value) 
	{
		$id_barang = $_SESSION['keranjang'][$key]['id_barang'];
		$jumlah_barang = $_SESSION['keranjang'][$key]['jumlah'];
		$harga_barang = $_SESSION['keranjang'][$key]['harga'];

		//update barang
		// $queryBarang = "UPDATE barang SET stok = stok-$jumlah_barang WHERE id_barang = '$id_barang'";
		// mysqli_query($koneksi, $queryBarang);

		//insert detail pembelian
		$queryDetail = "INSERT INTO detail_penjualan(id_penjualan, id_barang, jumlah, harga) VALUES('$last_id', '$id_barang', '$jumlah_barang', '$harga_barang')";
		mysqli_query($koneksi, $queryDetail);
	}

	unset($_SESSION['keranjang']);
	$_SESSION['success'] = 'Pembelian berhasil ditambahkan';
	header('Location: laporan.php');

 ?>
