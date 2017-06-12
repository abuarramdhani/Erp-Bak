<div class="box-body">
	<h2 align="center">LAPORAN RIWAYAT MUTASI PEKERJA</h2>
	<p align="center">PERIODE: <?php echo $tgl_awal." - ".$tgl_akhir ?></p>
	<div class="table-responsive" style="overflow:hidden;">	
		<div id="res">		
			<table class='t_riwayat_mutasi'>
				<thead>
					<tr>
						<th width="5%">NO</th>
						<th width="10%">TANGGAL</th>
						<th width="10%">NO INDUK</th>
						<th width="25%">NAMA</th>
						<th width="25%">SEKSI LAMA</th>						
						<th width="25%">SEKSI BARU</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$num = 0;
						foreach ($data_mutasi as $row):
							$num++;
					?>
							<tr>
								<td align='center'><?php echo $num ?></td>
								<td align='center'><?php echo $row['tanggal'] ?></td>
								<td align='center'><?php echo $row['no_induk'] ?></td>
								<td align='center'><?php echo $row['nama'] ?></td>
								<td align='center'><?php echo $row['seksi_lama'] ?></td>
								<td align='center'><?php echo $row['seksi_baru'] ?></td>
							</tr>
					<?php endforeach ?>
				</tbody>
			</table>
		</div>
	</div>
</div>