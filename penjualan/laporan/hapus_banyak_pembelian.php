<?php 

	require_once('../functions/koneksi.php');

	$awal_waktu = isset($_POST['awal_waktu']) ? $_POST['awal_waktu'] : false;
	$akhir_waktu = isset($_POST['akhir_waktu']) ? $_POST['akhir_waktu'] : false;

	$data = [
		'awal_waktu' => $awal_waktu,
		'akhir_waktu' => $akhir_waktu
	];

	$query = $koneksi->prepare("SELECT * FROM pembelian WHERE tanggal_beli BETWEEN :awal_waktu AND :akhir_waktu");
	$query->execute($data);

	foreach($query->fetchAll(PDO::FETCH_ASSOC) as $row)
	{
		$dataDetail['id_pembelian'] = $row['id_pembelian'];

		//delete detail pembelian
		$queryDetail = "DELETE FROM detail_pembelian WHERE id_pembelian = :id_pembelian";
		$deleteDetail = $koneksi->prepare($queryDetail);
		$deleteDetail->execute($dataDetail);
	}

	//delete pembelian
	$queryPembelian = "DELETE FROM pembelian WHERE tanggal_beli BETWEEN :awal_waktu AND :akhir_waktu";
	$deletePembelian = $koneksi->prepare($queryPembelian);
	$deletePembelian->execute($data);