<?php 

	require_once('../functions/koneksi.php');
	require_once('../functions/helper.php');
	require_once('pdf.php');

	function cetak($awal_waktu, $akhir_waktu)
	{	
		global $koneksi;
		
		$cetak = '';

		//query mengeluarkan pembelian berdasarkan waktu lalu di jadikan satu group per waktu yang ditentukan
		$query = 
		"
		SELECT * FROM pembelian WHERE tanggal_beli 
		BETWEEN :awal_waktu AND :akhir_waktu 
		GROUP BY tanggal_beli
		ORDER BY tanggal_beli ASC
		";

		$waktu = ['awal_waktu' => $awal_waktu, 'akhir_waktu' => $akhir_waktu];
		$pembelian = $koneksi->prepare($query);
		$pembelian->execute($waktu);

		$total_semua = 0;
		foreach($pembelian->fetchAll() as $row)
		{

			//query mengeluarkan data di table pembelian
			$tanggal_beli = date('Y-m-d', strtotime($row['tanggal_beli'])); 
			$sub_query = "SELECT * FROM pembelian WHERE tanggal_beli = '".$tanggal_beli."' ORDER BY tanggal_beli ASC";
			$sub_pembelian = $koneksi->prepare($sub_query);
			$sub_pembelian->execute();

			$cetak .= 
			'
				<table width="100%" border="0" cellpadding="5" cellspacing="0">
					<tr>
						<td><b>'.date('d F Y', strtotime($row['tanggal_beli'])).'</b></td>
					</tr>

					<tr>
						<td>
							<table width="100%" border="1" cellpadding="5" cellspacing="0">
								<tr>
									<td align="center">ID Pembelian</td>
									<td align="center">Jumlah Barang</td>
									<td align="center">Total Harga</td>
								</tr>
			';

			$subtotal = 0;
			$totalBarang = 0;

			foreach($sub_pembelian->fetchAll() as $sub_row)
			{
				//query detail pemesanan untuk mendapatkan jumlah barang dan total harga
				$dataDetail = ['id_pembelian' => $sub_row["id_pembelian"]];
				$queryDetail = "SELECT * FROM detail_pembelian WHERE id_pembelian = :id_pembelian";
				$detail = $koneksi->prepare($queryDetail);
				$detail->execute($dataDetail);

				$jumlahBarang = 0;
				$harga = 0;
				$totalHarga = 0;
						
				foreach($detail->fetchAll() as $rowDetail)
				{
					$jumlahBarang = $jumlahBarang + $rowDetail['jumlah']; 	//jumlah barang per id_pembelian
					$totalBarang = $totalBarang + $rowDetail['jumlah']; 	//jumlah total barang per waktu

					$harga = $rowDetail['harga'] * $rowDetail['jumlah'];
					$totalHarga = $totalHarga + $harga; 	//total harga jumlah barang per id_pembelian
					$subtotal = $subtotal + $harga; 		//total penjualan semua barang per waktu
					$total_semua = $total_semua + $harga;	//total semua penjualan
				}	

				$cetak .= 
				'
					<tr>
						<td align="center">'.$sub_row["id_pembelian"].'</td>
						<td align="center">'.$jumlahBarang.'</td>
						<td align="right">Rp. '.number_format($totalHarga).'</td>
					</tr>
				';
				
			}	
			

			$cetak .= 
			'		
				<tr>
					<td align="center"><b>Total Penjualan</b></td>
					<td align="center">'.$totalBarang.'</td>
					<td align="right">Rp. '.number_format($subtotal).'</td>
				</tr>

				</table>
						</td>
					</tr>
				</table><br><br>

			';					
										
		}

		$cetak .= 
		'
			<p align="center">Total Semua Penjualan = Rp. '.number_format($total_semua).'</p>		
		';

		return $cetak;
	}