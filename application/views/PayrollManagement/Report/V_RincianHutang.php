	<br>

	<div style="margin-left:20px;padding-top:10px;">
		<table class="table" style="font-size:20px;">
			<tr>
				<td width="10%"></td>
				<td width="80%" align="center"><b>DATA PINJAMAN PEKERJA</b></td>
				<td width="10%"></td>
			</tr>
		</table>
		<br>
	</div>

	<div style="margin-left:20px;margin-top:10px;margin-right:20px;">
		<div style="width:100%;align:center">
			<div>
			<?php 
				foreach($main_data as $md){ 
					$lunas_hutang="BELUM LUNAS"; if($sd['lunas']='1'){$lunas_hutang="LUNAS";}
			?>
				<b style="font-size:16px;">DATA PEKERJA</b><br>		
				<table class="table" style="width:100%;font-size:16px;">
					<tr>
						<td style="text-align:left;" width="17%">Noind</td>
						<td style="text-align:left;" width="2%">:</td>
						<td style="text-align:left;" width="33%"><?php echo $md['noind']?></td>
						<td style="text-align:left;" width="10%">Jabatan</td>
						<td style="text-align:left;" width="2%">:</td>
						<td style="text-align:left;" width="36%"><?php echo $md['jabatan']?></td>
					</tr>
					<tr>
						<td style="text-align:left;">Nama</td>
						<td style="text-align:left;">:</td>
						<td style="text-align:left;"><?php echo $md['nama']?></td>
						<td style="text-align:left;">Seksi</td>
						<td style="text-align:left;">:</td>
						<td style="text-align:left;"><?php echo $md['seksi']?></td>
					</tr>
					<tr>
						<td style="text-align:left;">Status Kerja</td>
						<td style="text-align:left;">:</td>
						<td style="text-align:left;" colspan="4"><?php echo $md['status_kerja']?></td>
					</tr>
				</table>
				<hr>
				<b style="font-size:16px;">DATA PINJAMAN</b><br>
				<table class="table" style="width:100%;font-size:16px;">
					<tr>
						<td style="text-align:left;" width="17%">No Pinjaman</td>
						<td style="text-align:left;" width="2%">:</td>
						<td style="text-align:left;" width="33%"><?php echo $md['no_hutang']?></td>
						<td style="text-align:left;" width="10%">Jumlah Cicilan</td>
						<td style="text-align:left;" width="2%">:</td>
						<td style="text-align:left;" width="36%"><?php echo $md['jml_cicilan']?></td>
					</tr>
					<tr>
						<td style="text-align:left;">Tanggal Pengajuan</td>
						<td style="text-align:left;">:</td>
						<td style="text-align:left;"><?php echo $md['tgl_pengajuan']?></td>
						<td style="text-align:left;">Status Lunas</td>
						<td style="text-align:left;">:</td>
						<td style="text-align:left;"><?php echo $lunas_hutang?></td>
					</tr>
					<tr>
						<td style="text-align:left;">Total Pinjaman</td>
						<td style="text-align:left;">:</td>
						<td style="text-align:left;" colspan="4"><?php echo 'Rp'.number_format($md['total_hutang'],2,",",".")?></td>
					</tr>
				</table>
				<hr>
				<b style="font-size:16px;">RINCIAN ANGSURAN</b><br>
				<table class="table table-bordered" style="width:60%;font-size:16px;">
					<tr>
						<td style="text-align:left;" width="30%"><b>PERIODE</b></td>
						<td style="text-align:left;" width="39%"><b>CICILAN</b></td>
						<td style="text-align:left;" width="30%"><b>STATUS</b></td>
					</tr>
					<?php
						foreach($secondary_data as $sd) {
							$lunas_cicilan="belum lunas"; if($sd['lunas']='1'){$lunas_cicilan="lunas";}
					?>
					<tr>
						<td style="text-align:left;" ><?php echo $sd['tgl_transaksi']?></td>
						<td style="text-align:left;" ><?php echo 'Rp '.number_format($sd['jumlah_transaksi'],2,",",".")?></td>
						<td style="text-align:left;" ><?php echo $lunas_cicilan?></td>
					</tr>
					<?php }?>
				</table>
				<table class="table" style="width:100%;font-size:16px;">
					<tr>
						<td style="text-align:left;" width="17%">Angsuran Sudah Dibayar</td>
						<td style="text-align:left;" width="2%">:</td>
						<td style="text-align:left;" width="81%"><?php echo 'Rp '.number_format($md['sudah_dibayar'],2,",",".")?></td>
					</tr>
					<tr>
						<td style="text-align:left;" width="17%">Sisa Angsuran</td>
						<td style="text-align:left;" width="2%">:</td>
						<td style="text-align:left;" width="81%"><?php echo 'Rp'.number_format($md['sisa_angsuran'],2,",",".") ?></td>
					</tr>
				</table>

			<?php } ?>
			</div>
		</div>
	</div>
	
</div>
