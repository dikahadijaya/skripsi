<?php 

	require_once '../../function/koneksi.php';

	session_start();
	
	$id_penjualan = $_GET['id'];
	mysqli_query($koneksi, "DELETE FROM penjualan WHERE id_penjualan = $id_penjualan");
	mysqli_query($koneksi, "DELETE FROM detail_penjualan WHERE id_penjualan = $id_penjualan");
	$_SESSION['success'] = 'Penjualan berhasil dihapus';
    header('Location: index.php');

 ?>