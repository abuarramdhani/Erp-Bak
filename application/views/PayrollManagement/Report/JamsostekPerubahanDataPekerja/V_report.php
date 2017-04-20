<div class="box-body">
	<h2 align="center">LAPORAN PERUBAHAN DATA JAMSOSTEK PEKERJA</h2>
	<h2 align="center">PERIODE : <?php echo date('F',mktime(0,0,0,$month,10))." - ".$year ?></h2>
	<div class="table-responsive" style="overflow:hidden;">	
		<div id="res">		
			<table align="center" style="border: 2px solid black; border-collapse: collapse;">
				<thead>
					<tr>
						<th width="5%" rowspan='2' align='center' style="border: 1px solid black;">NO</th>
						<th width="10%" rowspan='2' align='center' style="border: 1px solid black;">NO. INDUK</th>
						<th width="15%" rowspan='2' align='center' style="border: 1px solid black;">NO. KPJ</th>
						<th width="32%" rowspan='2' align='center' style="border: 1px solid black;">NAMA</th>
						<th width="32%" colspan='2' align='center' style="border: 1px solid black;">GAJI POKOK</th>	
						<th width="16%" rowspan='2' align='center' style="border: 1px solid black;">SELISIH</th>
					</tr>
					<tr>
						<th style="border: 1px solid black;">SEBELUM</th>
						<th style="border: 1px solid black;">SESUDAH</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$num = 0;
						foreach ($data_perubahan as $row):
							$num++;
					?>
					<tr>
						<td align='center' style="border: 1px solid black;"><?php echo $num ?></td>
						<td align='center' style="border: 1px solid black;"><?php echo $row['no_induk'] ?></td>
						<td align='center' style="border: 1px solid black;"><?php echo $row['no_kpj'] ?></td>
						<td align='left' style="border: 1px solid black;"><?php echo $row['nama'] ?></td>
						<td align='center' style="border: 1px solid black;"><?php echo 'Rp. '.number_format($row['gaji_sebelum'],0,",",".") ?></td>
						<td align='center' style="border: 1px solid black;"><?php echo 'Rp. '.number_format($row['gaji_sesudah'],0,",",".") ?></td>
						<td align='center' style="border: 1px solid black;"><?php echo 'Rp. '.number_format($row['selisih'],0,",",".") ?></td>
					</tr>
					<?php endforeach ?>
				</tbody>
			</table>
			<br />
			<p><b>TOTAL : </b><?php echo 'Rp. '.number_format($total,0,",",".") ?></p>
		</div>
	</div>
</div>