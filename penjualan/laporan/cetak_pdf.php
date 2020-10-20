<?php 

	require_once('../functions/koneksi.php');
	require_once('../functions/helper.php');
	require_once('pdf.php');
	require_once('cetak.php');

	$awal_waktu = isset($_GET['awal_waktu']) ? $_GET['awal_waktu'] : false;
	$akhir_waktu = isset($_GET['akhir_waktu']) ? $_GET['akhir_waktu'] : false;

	$awal_waktu = date('Y-m-d', strtotime($awal_waktu));
	$akhir_waktu = date('Y-m-d', strtotime($akhir_waktu));

	$pdf = new Pdf();

	//cetak
	$cetak = 
	'
		<style>
			@page { margin: 20px; }
		</style>

		<h3 align="center">Laporan Penjualan</h3><br/><br/>
	';

	$cetak .= cetak($awal_waktu, $akhir_waktu);

	$filename = 'Laporan_Penjualan.pdf';
	$pdf->loadHtml($cetak);
	$pdf->render();
	$pdf->stream($filename);
	exit(0);