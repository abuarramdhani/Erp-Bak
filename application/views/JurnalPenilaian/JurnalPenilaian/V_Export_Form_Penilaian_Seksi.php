<h2>
	Golongan <?php echo $golonganKerja;?>
</h2>
<table style="border: 1px solid black; border-collapse: collapse; width: 100%">
	<thead>
		<tr>
			<th rowspan="2" style="border: 1px solid black; width: 3%">No.</th>
			<th rowspan="2" style="border: 1px solid black; width: 6%">Nomor Induk</th>
			<th rowspan="2" style="border: 1px solid black; width: 32%">Nama</th>
			<th rowspan="2" style="border: 1px solid black; width: 15%">Seksi</th>
			<th colspan="2" style="border: 1px solid black; width: 11%">PWK</th>
			<th colspan="2" style="border: 1px solid black; width: 11%">KK</th>
			<th colspan="2" style="border: 1px solid black; width: 11%">PK</th>
			<th colspan="2" style="border: 1px solid black; width: 11%">PL</th>			
		</tr>
		<tr>
			<th style="border: 1px solid black;">PL</th>
			<th style="border: 1px solid black;">PK</th>
			<th style="border: 1px solid black;">PL</th>
			<th style="border: 1px solid black;">PK</th>
			<th style="border: 1px solid black;">PL</th>
			<th style="border: 1px solid black;">PK</th>
			<th style="border: 1px solid black;">PL</th>
			<th style="border: 1px solid black;">PK</th>			
		</tr>
	</thead>
	<tbody>
		<?php
			$no 	=	1;
			foreach ($daftarEvaluasiSeksi as $evaluasiSeksi) 
			{
				if(substr($evaluasiSeksi['kodesie'], 0, 5)==$unit and $evaluasiSeksi['gol_kerja']==$golonganKerja)
				{

		?>
		<tr>
			<td style="border: 1px solid black; vertical-align: middle; text-align: center;"><?php echo $no;?></td>
			<td style="border: 1px solid black; text-align: center; vertical-align: middle; white-space: nowrap;"><?php echo $evaluasiSeksi['noind'];?></td>
			<td style="border: 1px solid black; vertical-align: middle; white-space: nowrap;"><?php echo $evaluasiSeksi['nama'];?></td>
			<td style="border: 1px solid black; vertical-align: middle; white-space: nowrap;"><b><?php echo substr($evaluasiSeksi['nama_seksi'], 0, 25)?></b></td>
			<td style="border: 1px solid black; text-align: center; vertical-align: bottom;">______</td>
			<td style="border: 1px solid black; text-align: center; vertical-align: bottom;">______</td>
			<td style="border: 1px solid black; text-align: center; vertical-align: bottom;">______</td>
			<td style="border: 1px solid black; text-align: center; vertical-align: bottom;">______</td>
			<td style="border: 1px solid black; text-align: center; vertical-align: bottom;">______</td>
			<td style="border: 1px solid black; text-align: center; vertical-align: bottom;">______</td>
			<td style="border: 1px solid black; text-align: center; vertical-align: bottom;">______</td>
			<td style="border: 1px solid black; text-align: center; vertical-align: bottom;">______</td>						
		</tr>
		<?php
					$no++;
				}else{echo $unit;}
			}
		?>
	</tbody>
</table>