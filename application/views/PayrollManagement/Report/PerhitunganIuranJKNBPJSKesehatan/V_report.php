<div class="box-body">
	<h2 align="center">PERHITUNGAN IURAN JKN BPJS KESEHATAN</h2>
	<table align="center">
		<tr>
			<td><b>NAMA BADAN USAHA</b></td>
			<td><b>:</b></td>
			<td></td>
			<td width="75%"></td>
			<td><b>TAHUN</b></td>
			<td><b>:</b></td>
			<td><?php echo $year ?></td>
		</tr>
		<tr>
			<td><b>KODE BADAN USAHA</b></td>
			<td><b>:</b></td>
			<td></td>
			<td width="75%"></td>
			<td><b>BULAN</b></td>
			<td><b>:</b></td>
			<td><?php echo date('F',mktime(0,0,0,$month,10)) ?></td>
		</tr>
	</table>
	<br />
	<div class="table-responsive" style="overflow:hidden;">	
		<div id="res">		
			<table align="center" style="border: 2px solid black; border-collapse: collapse;">
				<thead>
	                <tr>
	                    <th rowspan="2" style="text-align:center; vertical-align: middle; border: 1px solid black;">NO</th>
						<th rowspan="2" style="text-align:center; vertical-align: middle; border: 1px solid black;">Nama</th>
						<th rowspan="2" style="text-align:center; vertical-align: middle; border: 1px solid black;">Gaji Pokok</th>
						<th rowspan="2" style="text-align:center; vertical-align: middle; border: 1px solid black;">Tunjangan Tetap</th>
						<th rowspan="2" style="text-align:center; vertical-align: middle; border: 1px solid black;">Total Gaji</th>
						<th rowspan="2" style="text-align:center; vertical-align: middle; border: 1px solid black;">Gaji untuk Perhitungan</th>
						<th colspan="3" style="text-align:center; border: 1px solid black;">Iuran</th>
						<th rowspan="2" style="text-align:center; vertical-align: middle; border: 1px solid black;">Jumlah P/I/S/A</th>
						<th rowspan="2" style="text-align:center; vertical-align: middle; border: 1px solid black;">Kelas Perawatan</th>
	                </tr>
	                <tr>
	                	<th style="text-align:center; border: 1px solid black;">Perusahaan</th>
	                	<th style="text-align:center; border: 1px solid black;">Karyawan</th>
	                	<th style="text-align:center; border: 1px solid black;	">Total</th>
	                </tr>
				</thead>
				<tbody>
					<?php $no = 1; 
					if(!empty($perhitungan_iuran)){
						foreach($perhitungan_iuran as $row) { ?>
						<tr>
							<td align='center' style="border: 1px solid black;"><?php echo $no++;?></td>
							<td align='center' style="border: 1px solid black;"><?php echo $row['nama'] ?></td>
							<td align='center' style="border: 1px solid black;"><?php echo 'Rp. '.number_format(floatval($row['gaji_pokok']),0,",",".") ?></td>
							<td align='center' style="border: 1px solid black;"><?php echo 'Rp. '.number_format(0,0,",",".") ?></td>
							<td align='center' style="border: 1px solid black;"><?php echo 'Rp. '.number_format(floatval($row['gaji_pokok']),0,",",".") ?></td>
							<td align='center' style="border: 1px solid black;"><?php echo 'Rp. '.number_format(floatval($row['gaji_perhitungan']),0,",",".") ?></td>
							<td align='center' style="border: 1px solid black;"><?php echo 'Rp. '.number_format(floatval($row['iuran_perusahaan']),0,",",".") ?></td>
							<td align='center' style="border: 1px solid black;"><?php echo 'Rp. '.number_format(floatval($row['iuran_karyawan']),0,",",".") ?></td>
							<td align='center' style="border: 1px solid black;"><?php echo 'Rp. '.number_format(floatval($row['iuran_total']),0,",",".") ?></td>
							<td align='center' style="border: 1px solid black;"><?php echo $row['jumlah_pisa'] ?></td>
							<td align='center' style="border: 1px solid black;"><?php echo $row['kelas_perawatan'] ?></td>
						</tr>
					<?php 
						}
					}
					if (!empty($total)) {
					?>	<tr>
							<td colspan="5" align="right" style="border: 1px solid black;"><b>TOTAL</b></td>
							<td align='center' style="border: 1px solid black;"><?php echo 'Rp. '.number_format(floatval($total['total_gaji_perhitungan']),0,",",".") ?></td>									
							<td align='center' style="border: 1px solid black;"><?php echo 'Rp. '.number_format(floatval($total['total_iuran_perusahaan']),0,",",".") ?></td>
							<td align='center' style="border: 1px solid black;"><?php echo 'Rp. '.number_format(floatval($total['total_iuran_karyawan']),0,",",".") ?></td>
							<td align='center' style="border: 1px solid black;"><?php echo 'Rp. '.number_format(floatval($total['total_iuran_total']),0,",",".") ?></td>
						</tr>
					<?php
					}
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>