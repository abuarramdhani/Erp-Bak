<div class="box-body">
	<h2 align="center">POTONGAN DANA PENSIUN</h2>
	<p align="center">PERIODE: <?php echo date('F',mktime(0,0,0,$month,10))." - ".$year ?></p>
	<div class="table-responsive" style="overflow:hidden;">	
		<div id="res">		
			<table class='t_dana_pensiun'>
				<thead>
					<tr>
						<th>NO</th>
						<th>NOIND</th>
						<th width='200px'>NAMA</th>
						<th>SEKSI</th>
						<th>NO. REKENING</th>						
						<th>JUMLAH</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$num = 0;
						foreach ($dana_pensiun as $row):
							$num++;
					?>
					<tr>
						<td align='center'><?php echo $num ?></td>
						<td align='center'><?php echo $row['no_induk'] ?></td>
						<td align='left'><?php echo $row['nama'] ?></td>
						<td align='left'><?php echo $row['seksi'] ?></td>
						<td align='center'><?php echo $row['norek'] ?></td>
						<td align='center' id='uang'><?php echo 'Rp '.number_format($row['jumlah'],0,",",".") ?></td>						
					</tr>
					<?php endforeach ?>
					<tr>
					<td colspan="5" align="right" id="total">TOTAL</td>
					<td align="center" id="uang"><?php echo 'Rp '.number_format($total,0,",",".") ?></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>