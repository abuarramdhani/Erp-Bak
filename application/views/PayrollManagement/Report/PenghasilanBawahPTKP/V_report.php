<div class="box-body">
	<h2 align="center">CV. KARYA HIDUP SENTOSA</h2>
	<p align="center">NPWP: 01.132.66.3.541.000</p>
	<p align="center">DAFTAR KARYAWAN BER-NPWP YANG BERPENGHASILAN DI BAWAH PTKP-NYA</p>
	<p align="center">TAHUN PERIODE : <?php echo $year ?></p>
	<div class="table-responsive" style="overflow:hidden;">	
		<div id="res">		
			<table class='t_bawah_ptkp'>
				<thead>
					<tr>
						<th>NO</th>
						<th>NO. INDUK</th>
						<th width='160px'>NPWP</th>
						<th width='420px'>NAMA</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$num = 0;
						foreach ($daftar_karyawan as $row):
							$num++;
					?>
					<tr>
						<td align='center'><?php echo $num ?></td>
						<td align='center'><?php echo $row['no_induk'] ?></td>
						<td align='center'><?php echo $row['npwp'] ?></td>
						<td align='left' id='nama'><?php echo $row['nama'] ?></td>
					</tr>
					<?php endforeach ?>
				</tbody>
			</table>
		</div>
	</div>
</div>