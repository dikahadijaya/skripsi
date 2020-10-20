<?php 

	session_start();

	
	require_once('function/koneksi.php');
	require_once('function/helper.php');

	$input_barang = $_POST['input_barang'];
	$id_barang = $_POST['id_barang'];

	$keranjang = isset($_SESSION['keranjang']) ? $_SESSION['keranjang'] : array(); 

	$jumlah = 0;
	foreach($keranjang as $key => $value)
	{
		if($_SESSION['keranjang'][$key]['id_barang'] == $id_barang){
			$_SESSION['keranjang'][$key]['jumlah'] = $input_barang; 
		}

	}

	$data['input_barang'] = $input_barang;
	echo json_encode($data);


