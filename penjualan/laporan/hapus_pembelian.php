<?php 

	date_default_timezone_set("Asia/Bangkok");
	require_once('../functions/koneksi.php');

	$data['id_pembelian'] = $_POST['id_pembelian'];

	// select detail pembelian
	$selectDetail = $koneksi->prepare("SELECT * FROM detail_pembelian WHERE id_pembelian = :id_pembelian");
	$selectDetail->execute($data);
	$total_harga = 0;
	foreach($selectDetail->fetchAll() as $row)
	{
		$totalPembelian = $row['harga'] * $row['jumlah'];
		$total_harga = $total_harga + $totalPembelian;
	}

	//delete pembelian
	$queryPembelian = "DELETE FROM pembelian WHERE id_pembelian = :id_pembelian";
	$deletePembelian = $koneksi->prepare($queryPembelian);
	$deletePembelian->execute($data);
	
	// select pembelian untuk mendapatkan jumlah data
	$query = $koneksi->prepare("SELECT * FROM pembelian");
	$query->execute();
	$row_pembelian = $query->rowCount();

	//delete detail pembelian
	$queryDetail = "DELETE FROM detail_pembelian WHERE id_pembelian = :id_pembelian";
	$deleteDetail = $koneksi->prepare($queryDetail);
	$deleteDetail->execute($data);

	// query chart
	$tahun = date('Y');
	$bulan = date('F');
	$data_chart = [
		'tahun' => $tahun,
		'bulan' => $bulan,
	];
	$updateChart = "UPDATE chart SET penjualan = penjualan - $total_harga WHERE tahun = :tahun AND bulan = :bulan";;
	$chart = $koneksi->prepare($updateChart);
	$chart->execute($data_chart);

	$data['row_pembelian'] = $row_pembelian;

	echo json_encode($data);