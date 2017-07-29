<div class="box-body">
	<h3 align="center">LAPORAN REKAP PENERIMAAN GAJI STAF PER BANK</h3>
	<p align="center">PERIODE: <?php echo date('F',mktime(0,0,0,$month,10))." - ".$year ?></p>
	<p align="left">BANK: <?php echo $bank ?></p>
	<div class="table-responsive" style="overflow:hidden;">	
		<div id="res">		
			<table class="t_rekap_gaji_bank">
				<thead>
					<tr>
						<th>NO</th>
						<th>NO INDUK</th>
						<th>NAMA</th>
						<th>NO REKENING</th>
						<th>NAMA PEMILIK REKENING</th>
						<th>THP</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$num = 0;
						foreach ($data_gaji as $row):
							$num++;
					?>
					<tr>
						<td><?php echo $num ?></td>
						<td><?php echo $row['no_induk'] ?></td>
						<td id='nama'><?php echo $row['nama'] ?></td>
						<td><?php echo $row['no_rekening'] ?></td>
						<td><?php echo $row['nama_pemilik_rekening'] ?></td>
						<td><?php echo 'Rp. '.number_format($row['thp'],0,",",".") ?></td>
					</tr>
					<?php endforeach ?>
                </tbody>
			</table>
			<br />
			<table>
				<tr>
					<td width="40%">
						<b>TOTAL PENERIMAAN GAJI KESELURUHAN</b>
					</td>
					<td width="40%">
						:
					</td>
					<td width="20%">
						<?php echo 'Rp. '.number_format($total['total_thp'],0,",",".") ?>
					</td>
				</tr>
				<tr>
					<td width="40%">
						<b>TOTAL POTONGAN TRANSFER</b>
					</td>
					<td width="40%">
						<?php echo ': '.$total['cacah'].' * Rp. '.number_format($total['pot_transfer'],0,",",".") ?>
					</td>
					<td width="20%" class="garis_bawah">
						<?php echo 'Rp. '.number_format($total['total_pot_transfer'],0,",",".") ?>
					</td>
				</tr>
				<tr>
					<td width="40%">
					</td>
					<td width="40%">
					</td>
					<td width="20%">
						<?php echo 'Rp. '.number_format($total['total_nett'],0,",",".") ?>
					</td>
				</tr>
			</table>
		</div>
	</div>
</div>