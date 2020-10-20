<?php 

	function checkAktif($aktif)
	{
		if($aktif == '1'){
			return 'Aktif';
		}else{
			return 'Tidak Aktif';
		}

	}

	function checkBadgeAktif($aktif)
	{
		if($aktif == '1'){
			return 'success';
		}else{
			return 'danger';
		}

	}

	function checkJumlahBarang($stok, $jumlah_barang)
	{
		if($stok == 0){
			return 'disabled';
		}elseif($jumlah_barang >= $stok){
			return 'disabled';
		}else{
			return '';
		}
	}

	function checkStatus($status)
	{
		if($status == '1'){
			return 'Menunggu Pembayaran';
		}else if($status == '2'){
			return 'Pembayaran sedang di validasi';
		}else if($status == '3'){
			return 'Pembayaran Lunas';
		}else{
			return 'Pembayaran ditolak';
		}

	}

	function checkBadgeStatus($status)
	{
		if($status == '1'){
			return 'danger';
		}else{
			return 'success';
		}
	}