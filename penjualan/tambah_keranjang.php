<?php 

	session_start();

	
	require_once('function/koneksi.php');
	require_once('function/helper.php');


	$id_barang = $_POST['id_barang'];

	$keranjang = isset($_SESSION['keranjang']) ? $_SESSION['keranjang'] : array(); 

	$jumlah_keranjang = count($keranjang);

	$query = mysqli_query($koneksi, "SELECT * FROM barang WHERE id_barang = '$id_barang'");
	$row = mysqli_fetch_assoc($query);

	$jumlah = 0;
	foreach($keranjang as $key => $value)
	{
		if($_SESSION['keranjang'][$key]['id_barang'] == $id_barang){
			$_SESSION['keranjang'][$key]['jumlah'] = $_SESSION['keranjang'][$key]['jumlah'] + 1; 
			$jumlah++;
		}

	}

	if($jumlah == 0){
		$keranjang = [	
			'id_barang' => $row['id_barang'],
			'kode_barang' => $row['kode_barang'],
			'nama_barang' => $row['nama_barang'],
			'harga' => $row['harga'],
			'jumlah' => 1
		];

		$_SESSION['keranjang'][] = $keranjang;
	}


	$data['keranjang'] = $_SESSION['keranjang'];

	echo json_encode($data);

	

