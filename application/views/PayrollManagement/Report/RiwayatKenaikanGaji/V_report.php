<div class="box-body">
	<h2 align="center">LAPORAN PERUBAHAN GAJI POKOK STAFF CV KHS</h2>
	<h2 align="center">PERIODE : <?php echo date('F',mktime(0,0,0,$month,10))." - ".$year ?></h2>
	<div class="table-responsive" style="overflow:hidden;">	
		<div id="res">		
			<table class='t_riwayat_gaji'>
				<thead>
					<tr>
						<th rowspan='2'>NO</th>
						<th rowspan='2'>NO. INDUK</th>
						<th rowspan='2'>NAMA</th>
						<th rowspan='2'>TGL PERUBAHAN</th>
						<th colspan='2'>GAJI POKOK</th>						
						<th rowspan='2'>SELISIH</th>
					</tr>
					<tr>
						<th>LAMA</th>
						<th>BARU</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$num = 0;
						foreach ($riwayat_gaji as $row):
							$num++;
					?>
					<tr>
						<td><?php echo $num ?></td>
						<td><?php echo $row['no_induk'] ?></td>
						<td id='nama'><?php echo $row['nama'] ?></td>
						<td><?php echo $row['tgl_berubah'] ?></td>
						<td><?php echo 'Rp. '.number_format($row['gaji_lama'],0,",",".") ?></td>
						<td><?php echo 'Rp. '.number_format($row['gaji_baru'],0,",",".") ?></td>
						<td><?php echo 'Rp. '.number_format($row['selisih'],0,",",".") ?></td>
					</tr>
					<?php endforeach ?>
				</tbody>
			</table>
		</div>
	</div>
</div>