<div class="box-body">
	<h4 align="center">LAPORAN RAPEL PREMI ASURANSI / BPJS</h4>
	<h4 align="center">KARYAWAN CV. KARYA HIDUP SENTOSA</h4>
	<h4 align="center">TAHUN: <?php echo $year?></h4>
	<br />
	<span>Tgl. Cetak : <?php echo date("d/m/Y") ?></span>
	<br /><br />
	<div class="table-responsive" style="overflow:hidden;">	
		<div id="res">		
			<table align="center" style="border: 2px solid black; border-collapse: collapse;">
				<thead>
					<tr>
						<th style="width: 5%; border: 1px solid black;">NO</th>
						<th style="width: 5%; border: 1px solid black;">NO INDUK</th>
						<th style="width: 10%; border: 1px solid black;">NO KPJ</th>
						<th style="width: 25%; border: 1px solid black;">NAMA</th>
						<th style="width: 10%; border: 1px solid black;">JHT</th>
						<th style="width: 10%; border: 1px solid black;">JKK</th>
						<th style="width: 10%; border: 1px solid black;">JKM</th>
						<th style="width: 10%; border: 1px solid black;">JKN</th>
						<th style="width: 15%; border: 1px solid black;">TOTAL</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$num = 0;
						foreach ($premi_asuransi as $row):
							$num++;
					?>
					<tr>
						<td align='center' style="border: 1px solid black;"><?php echo $num ?></td>
						<td align='center' style="border: 1px solid black;"><?php echo $row['no_induk'] ?></td>
						<td align='center' style="border: 1px solid black;"><?php echo $row['no_kpj'] ?></td>
						<td align='left' style="border: 1px solid black;"><?php echo $row['nama'] ?></td>
						<td align='center' style="border: 1px solid black;"><?php echo 'Rp '.number_format($row['jht'],0,",",".") ?></td>
						<td align='center' style="border: 1px solid black;"><?php echo 'Rp '.number_format($row['jkk'],0,",",".") ?></td>
						<td align='center' style="border: 1px solid black;"><?php echo 'Rp '.number_format($row['jkm'],0,",",".") ?></td>
						<td align='center' style="border: 1px solid black;"><?php echo 'Rp '.number_format($row['jkn'],0,",",".") ?></td>
						<td align='center' style="border: 1px solid black;"><?php echo 'Rp '.number_format($row['total'],0,",",".") ?></td>
					</tr>
					<?php endforeach;
						if(!empty($total)) {
					?>
							<tr>
								<td align='right' colspan="4" style="height: 20px; border: 1px solid black;"><b>GRAND TOTAL</b></td>
								<td align='center' style="height: 24px; border: 1px solid black;"><?php echo 'Rp. '.number_format($total['total_jht'],0,",",".") ?></td>
								<td align='center' style="height: 24px; border: 1px solid black;"><?php echo 'Rp. '.number_format($total['total_jkk'],0,",",".") ?></td>
								<td align='center' style="height: 24px; border: 1px solid black;"><?php echo 'Rp. '.number_format($total['total_jkm'],0,",",".") ?></td>
								<td align='center' style="height: 24px; border: 1px solid black;"><?php echo 'Rp. '.number_format($total['total_jkn'],0,",",".") ?></td>
								<td align='center' style="height: 24px; border: 1px solid black;"><?php echo 'Rp. '.number_format($total['grand_total'],0,",",".") ?></td>
							</tr>
					<?php
						}
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>