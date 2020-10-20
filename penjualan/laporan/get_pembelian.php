<?php 


	require_once('../functions/koneksi.php');
	require_once('../functions/helper.php');

	$awal_waktu = isset($_POST['awal_waktu']) ? $_POST['awal_waktu'] : false;
	$akhir_waktu = isset($_POST['akhir_waktu']) ? $_POST['akhir_waktu'] : false;
	$halaman = isset($_POST['halaman']) ? $_POST['halaman'] : 1;

	$data_waktu = [
		'awal_waktu' => $awal_waktu,
		'akhir_waktu' => $akhir_waktu
	];

	$data = '';
	$data_page = '';

	// pagination
	$jumlah_data_per_halaman = 10;
	$mulai_halaman = ($halaman - 1) * $jumlah_data_per_halaman;

	if($awal_waktu && $akhir_waktu){
		$query = "SELECT * FROM pembelian WHERE tanggal_beli BETWEEN :awal_waktu AND :akhir_waktu";
		$pembelian = $koneksi->prepare($query);
		$pembelian->execute($data_waktu);
	}else{
		$query = "SELECT * FROM pembelian ORDER BY id_pembelian DESC LIMIT $mulai_halaman, $jumlah_data_per_halaman";
		$pembelian = $koneksi->prepare($query);
		$pembelian->execute();
	}

		$no = 1;
		if($pembelian->rowCount() > 0){


			foreach($pembelian->fetchAll() as $row)
			{

				$jumlahBarang = 0;
				$totalHarga = 0;
				$harga = 0;

				$dataDetail = ['id_pembelian' => $row["id_pembelian"]];

				// cara 1
				// $queryDetail = "SELECT * FROM detail_pembelian WHERE id_pembelian = :id_pembelian";
				// $detail = $koneksi->prepare($queryDetail);
				// $detail->execute($dataDetail);

				
				// foreach($detail->fetchAll() as $rowDetail)
				// {
				// 	$jumlahBarang = $jumlahBarang + $rowDetail['jumlah'];
				// 	$harga = $rowDetail['harga'] * $rowDetail['jumlah'];
				// 	$totalHarga = $totalHarga + $harga;
				// }

				// cara 2
				$queryDetail = "SELECT id_pembelian, SUM(jumlah) AS jumlah_barang, SUM(jumlah * harga) AS harga_barang FROM detail_pembelian WHERE id_pembelian = :id_pembelian";
				$detail = $koneksi->prepare($queryDetail);
				$detail->execute($dataDetail);

				while($rowDetail = $detail->fetch(PDO::FETCH_ASSOC))
				{
					$jumlahBarang += $rowDetail['jumlah_barang'];
					$harga += $rowDetail['harga_barang'];
					$totalHarga += $harga;
				}

				$button_detail = '<button onclick=getDetailPembelian("'.$row["id_pembelian"].'") id="detailPembelian" class="badge badge-warning">Detail</button>';
				$button_hapus = '<button onclick=hapusPembelian("'.$row["id_pembelian"].'") id="hapusPembelian" class="badge badge-danger">Hapus</button>';

				$tanggal_beli = date('d F Y', strtotime($row['tanggal_beli']));

				$data .= '
						<tr id="'.$row["id_pembelian"].'">
							<td id="nomor" class="text-center">'.$no.'</td>
							<td class="text-center">'.$row["id_pembelian"].'</td>
							<td class="text-center">'.$tanggal_beli.'</td>
							<td class="text-center">'.$jumlahBarang.'</td>
							<td class="text-center">Rp. '.number_format($totalHarga).'</td>
							<td class="text-center">
								'.$button_detail.'
								'.$button_hapus.'
							</td>
						</tr>
				';
				$no++;	
			}

			// halaman
			$query_page = "SELECT * FROM pembelian ORDER BY id_pembelian DESC";
			$page = $koneksi->prepare($query_page);
			$page->execute();
			$total_row = $page->rowCount();
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
				'table' => $data,
				'halaman' => $data_page
			];

			echo json_encode($json);

		}else{
			$data .= '<tr id="dataKosongPembelian"><td colspan="11" class="text-center">Tidak ada pembelian</td></tr>';
			$json = [
				'table' => $data,
				'halaman' => $data_page
			];

			echo json_encode($json);
		}

		