	<br>

	<div style="margin-left:20px;padding-top:10px;">
		<table class="table" style="font-size:20px;">
			<tr>
				<td width="10%"></td>
				<td width="80%" align="center"><b>Laporan Riwayat Kenaikan Gaji Karyawan</b></td>
				<td width="10%"></td>
			</tr>
			<tr>
				<td width="10%"></td>
				<td width="80%" align="center"><b>CV. Karya Hidup Sentosa</b></td>
				<td width="10%"></td>
			</tr>
		</table>
	</div>

	<div style="margin-left:20px;margin-top:10px;margin-right:20px;">
		<div style="width:100%;align:center">
			
			<table class="table table-bordered" style="width:100%;font-size:10px;">
				<tr>
					<td style="text-align:center;" rowspan="2" width="8%"><b>No Induk</b></td>
					<td style="text-align:center;" rowspan="2" width="20%"><b>Nama</b></td>
					<td style="text-align:center;" rowspan="2" width="32%"><b>Seksi</b></td>
					<td style="text-align:center;" colspan="5" ><b>Riwayat Kenaikan Gaji</b></td>
				</tr>
				<tr>
					<td style="text-align:center;" width="8%">Tgl Berlaku</td>
					<td style="text-align:center;" width="8%">GP (30 hari)</td>
					<td style="text-align:center;" width="8%">Kenaikan GP</td>
					<td style="text-align:center;" width="8%">IF (25 hari)</td>
					<td style="text-align:center;" width="8%">Kenaikan IF</td>
				</tr>
				<?php foreach($main_data as $md){ ?>
				<tr>
					<td style="text-align:center;"><?php echo $md['noind']?></td>
					<td style="text-align:left;"><?php echo $md['nama']?></td>
					<td style="text-align:left;"><?php echo $md['seksi']?></td>
					<td style="text-align:center;"><?php echo $md['tgl_berlaku']?></td>
					<td style="text-align:center;"><?php echo number_format($md['gaji_pokok'],0,",",".")?></td>
					<td style="text-align:center;"><?php echo number_format($md['kenaikan_gp'],0,",",".")?></td>
					<td style="text-align:center;"><?php echo number_format($md['if'],0,",",".")?></td>
					<td style="text-align:center;"><?php echo number_format($md['kenaikan_if'],0,",",".")?></td>
				</tr>
				<?php } ?>
			</table>
		</div>
	</div>
	
</div>
