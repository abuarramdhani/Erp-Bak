<div class="box-body">
	<h2 class="h_master_gaji" align="center">MASTER DATA GAJI KARYAWAN</h2>
	<h3 class="h_master_gaji" align="center">DEPARTEMEN: <?php echo $dept_selected ?></h3>
	<p align="center">PERIODE: <?php echo date('F',mktime(0,0,0,$month,10))." - ".$year ?></p>
	<p align="center">( Standar 25 Hari Kerja )</p>
	<p align="left">Tanggal Cetak: <?php echo date("d/m/Y") ?></p>
	<div class="table-responsive" style="overflow:hidden;">	
		<div id="res">		
			<table class='t_master_gaji'>
				<thead>
					<tr>
						<th>NO</th>
						<th>NOIND</th>
						<th width='200px'>NAMA</th>
						<th>PTKP</th>
						<th>GP</th>						
						<th>IF</th>
						<th>IP</th>
						<th>IK</th>
						<th>UBT</th>
						<th>UPAMK</th>
						<th>I KMHLN</th>
						<th>JHT</th>
						<th>JKN</th>
						<th>P DUKA</th>
						<th>P SPSI</th>
						<th>P IKOP</th>
						<th>THP</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$num = 0;
						foreach ($master_gaji as $row):
							$num++;
					?>
					<tr>
						<td align='center'><?php echo $num ?></td>
						<td align='center'><?php echo $row['no_induk'] ?></td>
						<td align='left' id='nama'><?php echo $row['nama'] ?></td>
						<td id='uang' align='center'><?php echo number_format($row['ptkp'],0,",",".") ?></td>
						<td id='uang' align='center'><?php echo number_format($row['gaji_pokok'],0,",",".") ?></td>
						<td id='uang' align='center'><?php echo number_format($row['i_f'],0,",",".") ?></td>
						<td id='uang' align='center'><?php echo number_format($row['i_p'],0,",",".") ?></td>
						<td id='uang' align='center'><?php echo number_format($row['i_k'],0,",",".") ?></td>
						<td id='uang' align='center'><?php echo number_format($row['ubt'],0,",",".") ?></td>
						<td id='uang' align='center'><?php echo number_format($row['upamk'],0,",",".") ?></td>
						<td id='uang' align='center'><?php echo number_format($row['i_mahal'],0,",",".") ?></td>
						<td id='uang' align='center'><?php echo number_format($row['jht'],0,",",".") ?></td>
						<td id='uang' align='center'><?php echo number_format($row['jkn'],0,",",".") ?></td>
						<td id='uang' align='center'><?php echo number_format($row['pot_duka'],0,",",".") ?></td>
						<td id='uang' align='center'><?php echo number_format($row['pot_spsi'],0,",",".") ?></td>
						<td id='uang' align='center'><?php echo number_format($row['pot_ikop'],0,",",".") ?></td>
						<td id='uang' align='center'><?php echo number_format($row['thp'],0,",",".") ?></td>
					</tr>
					<?php endforeach ?>
				</tbody>
			</table>
		</div>
	</div>
</div>