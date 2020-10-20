<?php 

	require_once('../functions/koneksi.php');
	require_once('../functions/helper.php');

	$id_pembelian = $_POST['id_pembelian'];
	$dataDetail = ['id_pembelian' => $id_pembelian];
	$queryDetail = '';
	$queryDetail = "SELECT detail_pembelian.*, barang.nama_barang, pembelian.tanggal_beli, pembelian.jam FROM detail_pembelian JOIN barang ON detail_pembelian.id_barang = barang.id_barang JOIN pembelian ON detail_pembelian.id_pembelian = pembelian.id_pembelian WHERE detail_pembelian.id_pembelian = :id_pembelian ORDER BY id_pembelian";
	$detail = $koneksi->prepare($queryDetail);
	$detail->execute($dataDetail);

	$jumlahBarang = 0;
	$totalHarga = 0;
	$harga = 0;
	$data = '';
	$no = 1;
	foreach($detail->fetchAll(PDO::FETCH_ASSOC) as $rowDetail)
	{
		$jumlahBarang = $jumlahBarang + $rowDetail['jumlah'];
		$harga = $rowDetail['harga'] * $rowDetail['jumlah'];
		$totalHarga = $totalHarga + $harga;


		$data .= '<tr id="'.$rowDetail["id_pembelian"].'">
	      			<td class="text-center">'.$no.'</td>
	      			<td id="detail_nama_barang" class="text-center">'.$rowDetail["nama_barang"].'</td>
	      			<td id="detail-harga" class="text-center">Rp '.number_format($rowDetail["harga"]).'</td>
	      			<td id="detail-jumlah" class="text-center">'.$rowDetail["jumlah"].'</td>
	      			<td id="detail-harga-barang" class="text-right">Rp '.number_format($harga).'</td>
			      </tr>
			      ';

		$no++;
			      
	}

	$data .= '<tr>
					<td></td>
					<td></td>
					<td></td>
					<th id="detail-total-harga" class="text-center">Total Harga</th>
					<td align="right">Rp '.number_format($totalHarga).'</td>
			  </tr>	
			';

		$tanggal_beli = date('d F Y', strtotime($rowDetail['tanggal_beli']));
		$jam = date('H:i:s', strtotime($rowDetail['jam']));
		$json = [
			'id_pembelian' => $id_pembelian,
			'tanggal_beli' => $tanggal_beli,
			'jam' => $jam,
			'table' => $data,
		];
		echo json_encode($json);
	