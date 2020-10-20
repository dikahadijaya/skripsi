<?php 

	require_once('../functions/koneksi.php');
	require_once('../functions/helper.php');
	require_once('cetak.php');

	$awal_waktu = $_GET['awal_waktu'];
	$akhir_waktu = $_GET['akhir_waktu'];
	
	$cetak = 'Laporan Penjualan';
	$cetak .= cetak($awal_waktu, $akhir_waktu);

	header('Content-Type: application/xls');
  	header('Content-Disposition: attachment; filename=laporan_penjualan.xls');
  	echo $cetak;
