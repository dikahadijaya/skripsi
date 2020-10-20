<?php 

	session_start();

	require_once('function/koneksi.php');

	$keranjang = isset($_SESSION['keranjang']) ? $_SESSION['keranjang'] : array();
	$jumlah_keranjang = count($keranjang);

	$no = 1;
	$total_harga = 0;
	$data = '';

	if($jumlah_keranjang < 1){
		$data = '<td class="text-center" colspan="11">Keranjang kosong</td>';
	}else{

		foreach($keranjang as $key => $value) 
		{
			$query_barang = "SELECT * FROM barang WHERE id_barang = ".$value['id_barang'];
			$barang = mysqli_query($koneksi, $query_barang);
			$row_barang = mysqli_fetch_assoc($barang);

			//jika jumlah yang diinput masih kurang dari stok
			if($value["jumlah"] < $row_barang['stok']){
				$input_jumlah = 
				'
					<td>
						<input id="jumlah" type="number" class="form-control" name="jumlah" data-id="'.$value["id_barang"].'" value="'.$value["jumlah"].'" style="width: 100px;">
					</td>
				';

				$harga_barang = '<td class="text-center">Rp. '.number_format($value["harga"]*$value["jumlah"], 2).'</td>';
				$total_harga =  $total_harga + ($value["jumlah"]*$value["harga"]);
			}else{
				$input_jumlah = 
				'
					<td>
						<input id="jumlah" type="number" class="form-control" name="jumlah" data-id="'.$value["id_barang"].'" value="'.$row_barang['stok'].'" style="width: 100px;">
					</td>
				';

				$harga_barang = '<td class="text-center">Rp. '.number_format($value["harga"]*$row_barang['stok'], 2).'</td>';
				$total_harga =  $total_harga + ($row_barang['stok']*$value["harga"]);
				$_SESSION['keranjang'][$key]['jumlah'] = $row_barang['stok'];
			}

			$data .= '
				<tr id="'.$value["id_barang"].'">
					<td class="text-center">'.$no.'</td>
					<td class="text-center">'.$value["nama_barang"].'</td>
					<td class="text-center">'.$value["harga"].'</td>
					'.$input_jumlah.'
					'.$harga_barang.'
					<td class="text-center"><button onclick=hapusKeranjang("'.$value["id_barang"].'") class="btn btn-danger btn-sm"><span class="fa fa-minus"></span></button></td>
				</tr>
			';


			$no++;

		}

		$data .= '<tr align="right">
					<td align="right" colspan="7">
						<form action="proses_keranjang.php" method="post">
							<button type="submit" class="btn btn-success btn-sm">Selesai</button>
						</form
					</td>
				  </tr>	
		';
	}
	
	$json = [
		'data' => $data,
		'total_harga' => number_format($total_harga)
	];

	echo json_encode($json);
