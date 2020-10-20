<?php 

	date_default_timezone_set("Asia/Bangkok");
	session_start();
	
	require_once('function/koneksi.php');
	require_once('function/helper.php');

	$keranjang = isset($_SESSION['keranjang']) ? $_SESSION['keranjang'] : array();
	$uang = isset($_POST['uang']) ? $_POST['uang'] : false;

	$tanggal_beli = date('Y-m-d');
	$jam = date('H:i:s');
	$status = 1;

	$data = [
		'tanggal_beli' => $tanggal_beli,
		'jam' => $jam,
		'status' => $status
	];

	$queryPembelian = "INSERT INTO pembelian(tanggal_beli, jam, status) VALUES (:tanggal_beli, :jam, :status)";
	$pembelian = $koneksi->prepare($queryPembelian);
	$pembelian->execute($data);
	$id_pembelian = $koneksi->lastInsertId();


	$total_harga = 0;
	$kembalian = null;
	foreach($keranjang as $key => $value) 
	{
		$id_barang = $_SESSION['keranjang'][$key]['id_barang'];
		$jumlah_barang = $_SESSION['keranjang'][$key]['jumlah'];
		$harga_barang = $_SESSION['keranjang'][$key]['harga'];
		$harga = $jumlah_barang * $harga_barang;
		$total_harga = $total_harga + $harga;
		
		//kembalian
		if($uang){
			$kembalian = $uang - $total_harga;
		}else{
			$kembalian = 'Uang tidak dimasukkan';
		}

		//update barang
		$queryBarang = "UPDATE barang set stok = stok-$jumlah_barang WHERE id_barang = :id_barang";
		$dataBarang = ['id_barang' => $id_barang];
		$updateBarang = $koneksi->prepare($queryBarang);
		$updateBarang->execute($dataBarang);

		//insert detail pembelian
		$dataDetail = ['id_pembelian' => $id_pembelian, 'id_barang' => $id_barang, 'jumlah_barang' => $jumlah_barang, 'harga_barang' => $harga_barang];
		$queryDetail = "INSERT INTO detail_pembelian(id_pembelian, id_barang, jumlah, harga) VALUES(:id_pembelian, :id_barang, :jumlah_barang, :harga_barang)";
		$insertPembelian = $koneksi->prepare($queryDetail);
		$insertPembelian->execute($dataDetail);
	}

	// query chart
	$tahun = date('Y');
	$bulan = date('F');
	$data_chart = [
		'tahun' => $tahun,
		'bulan' => $bulan,
	];
	$selectChart = "SELECT * FROM chart WHERE tahun = :tahun AND bulan = :bulan";
	$chart = $koneksi->prepare($selectChart);
	$chart->execute($data_chart);
	if($chart->rowCount() == 0){
		$data_chart['penjualan'] = $total_harga;
		$queryChart  = "INSERT INTO chart(tahun, bulan, penjualan) VALUES (:tahun, :bulan, :penjualan)";
		$insertChart = $koneksi->prepare($queryChart);
		$insertChart->execute($data_chart);
	}else{
		$queryChart  = "UPDATE chart SET penjualan = penjualan + $total_harga WHERE tahun = :tahun AND bulan = :bulan";
		$updateChart = $koneksi->prepare($queryChart);
		$updateChart->execute($data_chart);
	}
	
	$_SESSION['success'] = 'Pembelian berhasil';

	unset($_SESSION['keranjang']);

	echo $kembalian;