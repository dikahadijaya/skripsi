<?php 

	session_start();

	$id_barang = $_POST['id_barang'];

	$keranjang = isset($_SESSION['keranjang']) ? $_SESSION['keranjang'] : array(); 

	foreach($keranjang as $key => $value)
	{
		if($_SESSION['keranjang'][$key]['id_barang'] == $id_barang){
			unset($_SESSION['keranjang'][$key]);
		}

	}