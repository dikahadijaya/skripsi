<?php 


	require_once('function/koneksi.php');
	require_once('function/helper.php');

	session_start();

	$keranjang = isset($_SESSION['keranjang']) ? $_SESSION['keranjang'] : array();
	$halaman = isset($_POST['halaman']) ? $_POST['halaman'] : 1;
	$cari = isset($_POST['cari']) ? $_POST['cari'] : false;

	$data_page = '';
	$table = '';

	// pagination
	$jumlah_data_per_halaman = 10;
	$mulai_halaman = ($halaman - 1) * $jumlah_data_per_halaman;


	if($cari){
		$query = "
		SELECT * FROM barang 
		WHERE kode_barang LIKE '%".$cari."%'
		OR nama_barang LIKE '%".$cari."%' 
		OR harga LIKE '%".$cari."%' 
		OR stok LIKE '%".$cari."%' 
		";
	}else{
		$query = "SELECT * FROM barang WHERE aktif = 1 ORDER BY nama_barang ASC LIMIT $mulai_halaman, $jumlah_data_per_halaman";
	}

	$barang = mysqli_query($koneksi, $query);
	// $barang = $koneksi->prepare($query);
	// $barang->execute();

		$no = 1;
		if(mysqli_num_rows($barang) > 0){

			while($row = mysqli_fetch_assoc($barang))
			{
				$button_tambah = '';
				$button_edit = '';
				$button_hapus = '';
				$aktif = '';

				$jumlah_barang = 0;
				foreach($keranjang as $key => $value)
				{
					$id_barang = $_SESSION['keranjang'][$key]['id_barang'];
					if($id_barang == $row['id_barang']){
						$jumlah_barang = $_SESSION['keranjang'][$key]['jumlah'];
					}
				}

				$button_tambah = '<button onclick=tambahKeranjangBarang("'.$row["id_barang"].'") id="editBarang" class="btn btn-primary btn-sm" '.checkJumlahBarang($row['stok'], $jumlah_barang).' ><i class="fa fa-plus"></i></button>';

				$table .= '
						<tr id="'.$row["id_barang"].'">
							<td class="text-center">'.$no.'</td>
							<td class="text-center">'.$row["kode_barang"].'</td>
							<td class="text-center">'.$row["nama_barang"].'</td>
							<td class="text-center">Rp. '.number_format($row["harga"]).'</td>
							<td id="stok-kasir" class="text-center">'.$row["stok"].'</td>
							<td class="text-center">
								'.$button_tambah.'
							</td>
						</tr>
				';
				$no++;	
			}

			$query_page = "SELECT * FROM barang ORDER BY id_barang ASC";
			$page = mysqli_query($koneksi, $query_page);
			$total_row = mysqli_num_rows($page);
			$total_page = ceil($total_row / $jumlah_data_per_halaman);
			for($i=1; $i <= $total_page ; $i++) 
			{ 
				if($halaman == $i){
					$data_page .= '<li class="page-item active" id="'.$i.'" style="cursor: pointer"><a class="page-link">'.$i.'</a></li>';
				}else{
					$data_page .= '<li class="page-item" id="'.$i.'"  style="cursor: pointer"><a class="page-link">'.$i.'</a></li>';
				}
			}

			$json = [
				'table' => $table,
				'halaman' => $data_page,
			];

			echo json_encode($json);

		}else{
		 	$table .= '<tr id="dataKosongBarang"><td colspan="11" class="text-center">Tidak ada barang</td></tr>';

			$json = [
				'table' => $table
			];

			echo json_encode($json);
		}