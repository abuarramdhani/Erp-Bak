<div class="box-body">
	<h2 align="center">REKAP PEMBAYARAN JKN</h2>
	<?php
	if(!empty($data_karyawan)){
		echo '<div class="row" style="margin: 10px 0px">
				<table>
					<tr>
						<td width="80px"><b>PERIODE</b></td>
						<td> : </td>
						<td>'.$year.'</td>
					</tr>
					<tr>
						<td width="80px"><b>NAMA</b></td>
						<td> : </td>
						<td>'.$data_karyawan['nama'].'</td>
					</tr>
					<tr>
						<td width="80px"><b>NO INDUK</b></td>
						<td> : </td>
						<td>'.$data_karyawan['no_induk'].'</td>
					</tr>
					<tr>
						<td width="80px"><b>SEKSI</b></td>
						<td> : </td>
						<td>'.$data_karyawan['seksi'].'</td>
					</tr>
					<tr>
						<td width="80px"><b>NO KPJ</b></td>
						<td> : </td>
						<td>'.$data_karyawan['no_kpj'].'</td>
					</tr>
				</table>
		</div>';
	}
	?>
	<div class="table-responsive" style="overflow:hidden;">	
		<div id="res">		
			<table class="t_rekap_pembayaran">
				<thead>
					<tr>
						<th rowspan="3">NO</th>
						<th rowspan="3">BULAN</th>
						<th rowspan="3">GAJI POKOK</th>
						<th colspan="4">TAGIHAN JKN</th>
						<th rowspan="3">TOTAL TAGIHAN</th>
					</tr>
					<tr>
						<th colspan="2">KARYAWAN</th>
						<th colspan="2">PERUSAHAAN</th>
					</tr>
					<tr>
						<th>TARIF</th>
						<th>NOMINAL</th>
						<th>TARIF</th>
						<th>NOMINAL</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$num = 0;
						foreach ($pembayaran_jkn as $row):
							$num++;
					?>
					<tr>
						<td align='center'><?php echo $num ?></td>
						<td align='center'><?php echo $row['bulan'] ?></td>
						<td align='center' id='uang'><?php echo 'Rp '.number_format($row['gaji_pokok'],0,",",".") ?></td>
						<td align='center'><?php echo $row['tarif_karyawan'].'%' ?></td>
						<td align='center' id='uang'><?php echo 'Rp '.number_format($row['jkn_karyawan'],0,",",".") ?></td>	
						<td align='center'><?php echo $row['tarif_perusahaan'].'%' ?></td>
						<td align='center' id='uang'><?php echo 'Rp '.number_format($row['jkn_perusahaan'],0,",",".") ?></td>
						<td align='center' id='uang'><?php echo 'Rp '.number_format($row['total_jkn'],0,",",".") ?></td>
					</tr>
					<?php endforeach;
						if(!empty($total_pembayaran_jkn)) {
					?>
							<tr>
								<td align='right' colspan="3" id="total"><b>TOTAL</b></td>
								<td align='center' colspan="2" id="uang"><?php echo 'Rp. '.number_format($total_pembayaran_jkn['jkn_karyawan'],0,",",".") ?></td>
								<td align='center' colspan="2" id="uang"><?php echo 'Rp. '.number_format($total_pembayaran_jkn['jkn_perusahaan'],0,",",".") ?></td>
								<td align='center' id="uang"><?php echo 'Rp. '.number_format($total_pembayaran_jkn['total_jkn'],0,",",".") ?></td>
							</tr>
					<?php
						}
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>