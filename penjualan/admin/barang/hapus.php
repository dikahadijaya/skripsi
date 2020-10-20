<?php 

	require_once '../../function/db.php';

	session_start();
	
	$id_barang = $_GET['id_barang'];
	mysqli_query($koneksi, "DELETE FROM barang WHERE id_barang = $id_barang");
	$_SESSION['success'] = 'Barang berhasil dihapus';
    header('Location: index.php');

 ?>