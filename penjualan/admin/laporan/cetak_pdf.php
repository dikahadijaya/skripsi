<?php 

	require_once('../../function/koneksi.php');
	require_once('pdf.php');

	$dari = isset($_GET['dari']) ? $_GET['dari'] : false;
	$sampai = isset($_GET['sampai']) ? $_GET['sampai'] : false;
	// die($dari);
	// $dari = date('Y-m-d', strtotime($dari));
	// $sampai = date('Y-m-d', strtotime($sampai));

	$pdf = new Pdf();
	
	//cetak
	$cetak = 
	'
		<style>
			@page { margin: 20px; }
		</style>

		<h3 align="center">Laporan Penjualan</h3><br/><br/>
	';


	//query mengeluarkan penjualan berdasarkan waktu lalu di jadikan satu group per waktu yang ditentukan
	$query = 
	"
	SELECT * FROM penjualan WHERE tanggal_jual
	BETWEEN '$dari' AND '$sampai' 
	GROUP BY tanggal_jual
	ORDER BY tanggal_jual ASC
	";

	$penjualan = mysqli_query($koneksi, $query);

	$total_semua = 0;
	while($row = mysqli_fetch_assoc($penjualan))
	{

		//query mengeluarkan data di table penjualan
		// $tanggal_jual = date('Y-m-d', strtotime($row['tanggal_jual'])); 
		$sub_query = "SELECT * FROM penjualan WHERE tanggal_jual = '$row[tanggal_jual]' ORDER BY tanggal_jual ASC";
		$sub_penjualan = mysqli_query($koneksi, $sub_query);

		$cetak .= 
		'
			<table width="100%" border="0" cellpadding="5" cellspacing="0">
				<tr>
					<td><b>'.date('d F Y', strtotime($row['tanggal_jual'])).'</b></td>
				</tr>

				<tr>
					<td>
						<table width="100%" border="1" cellpadding="5" cellspacing="0">
							<tr>
								<td align="center">ID penjualan</td>
								<td align="center">Jumlah Barang</td>
								<td align="center">Total Harga</td>
							</tr>
		';

		$subtotal = 0;
		$totalBarang = 0;

		while($sub_row = mysqli_fetch_assoc($sub_penjualan))
		{
			//query detail pemesanan untuk mendapatkan jumlah barang dan total harga
			$queryDetail = "SELECT * FROM detail_penjualan WHERE id_penjualan = '$sub_row[id_penjualan]'";
			$detail = mysqli_query($koneksi, $queryDetail);

			$jumlahBarang = 0;
			$harga = 0;
			$totalHarga = 0;
					
			while($rowDetail = mysqli_fetch_assoc($detail))
			{
				$jumlahBarang = $jumlahBarang + $rowDetail['jumlah']; 	//jumlah barang per id_penjualan
				$totalBarang = $totalBarang + $rowDetail['jumlah']; 	//jumlah total barang per waktu

				$harga = $rowDetail['harga'] * $rowDetail['jumlah'];
				$totalHarga = $totalHarga + $harga; 	//total harga jumlah barang per id_penjualan
				$subtotal = $subtotal + $harga; 		//total penjualan semua barang per waktu
				$total_semua = $total_semua + $harga;	//total semua penjualan
			}	

			$cetak .= 
			'
				<tr>
					<td align="center">'.$sub_row["id_penjualan"].'</td>
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

	// die($cetak);

	$filename = 'Laporan_Penjualan.pdf';
	$pdf->loadHtml($cetak);
	$pdf->render();
	$pdf->stream($filename, array("Attachment" => false));
	exit(0);