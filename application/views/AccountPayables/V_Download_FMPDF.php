
<div>
	<div style="margin-left:20px;margin-right:20px;padding-top:10px;">
		<div class="row" style="margin-left:3px;margin-right:3px;padding-top:10px;">
			<table>
				<tr>
					<td><img src="<?php echo base_url('assets/img/logo.png')?>" style="width:60px;"></td>
					<td>&nbsp;&nbsp;</td>
					<td>
						<h3><b>CV. KARYA HIDUP SENTOSA</b><br>
						<small style="font-size:12px;">Jl. Magelang No. 144 Yogyakarta 55241</small><br>
						<small style="font-size:12px;">Telp: (0274)512095,563217 Fax: (0274) 563523</small>
						</h3>
					</td>
				</tr>
			</table>
		</div>
		<hr>
		<div class="row" style="margin-left:3px;margin-right:3px">
			<h5><b>FAKTUR MASUKAN</b></h5>
			<table border="1" style="border-collapse: collapse;margin: 0 auto;">
				<tbody>
					<tr>
						<td align="center" width="2%" style="height:60px;background:#DDDDDD;font-size:9px">FM</td>
						<td align="center" width="6%" style="height:60px;background:#DDDDDD;font-size:9px">KODE JENIS TRANSAKSI</td>
						<td align="center" width="7%" style="height:60px;background:#DDDDDD;font-size:9px">FG PENGGANTI</td>
						<td align="center" width="8%" style="height:60px;background:#DDDDDD;font-size:9px">NOMOR FAKTUR</td>
						<td align="center" width="3%" style="height:60px;background:#DDDDDD;font-size:9px">MASA PAJAK</td>
						<td align="center" width="3%" style="height:60px;background:#DDDDDD;font-size:9px">TAHUN PAJAK</td>
						<td align="center" width="4%" style="height:60px;background:#DDDDDD;font-size:9px">TANGGAL FAKTUR</td>
						<td align="center" width="8%" style="height:60px;background:#DDDDDD;font-size:12px">NPWP</td>
						<td align="center" width="10%" style="height:60px;background:#DDDDDD;font-size:12px">NAMA</td>
						<td align="center" width="17%" style="height:60px;background:#DDDDDD;font-size:12px">ALAMAT LENGKAP</td>
						<td align="center" width="5%" style="height:60px;background:#DDDDDD;font-size:9px">JUMLAH DPP</td>
						<td align="center" width="5%" style="height:60px;background:#DDDDDD;font-size:9px">JUMLAH PPN</td>
						<td align="center" width="6%" style="height:60px;background:#DDDDDD;font-size:9px">JUMLAH PPNBM</td>
						<td align="center" width="4%" style="height:60px;background:#DDDDDD;font-size:9px">IS CREDIT ABLE</td>
						<td align="center" width="7%" style="height:60px;background:#DDDDDD;font-size:12px">KETERANGAN</td>
						<td align="center" width="4%" style="height:60px;background:#DDDDDD;font-size:9px">STATUS</td>
					</tr>
					<?php
						if(!(empty($FilteredFaktur))){
							$no=0;
							foreach($FilteredFaktur as $FF) { $no++;
							$typ = substr($FF->FAKTUR_PAJAK, 0, 2);
							$alt = substr($FF->FAKTUR_PAJAK, 2, 1);
							$num = substr($FF->FAKTUR_PAJAK, 3);
					?>
					<tr>
						<td align="center" style="height:40px;font-size:11px"><?php echo $FF->FM?></td>
						<td align="center" style="height:40px;font-size:11px"><?php echo $typ?></td>
						<td align="center" style="height:40px;font-size:11px"><?php echo $alt?></td>
						<td align="center" style="height:40px;font-size:11px"><?php echo $num?></td>
						<td align="center" style="height:40px;font-size:11px"><?php echo $FF->MONTH?></td>
						<td align="center" style="height:40px;font-size:11px"><?php echo $FF->YEAR?></td>
						<td align="center" style="height:40px;font-size:11px"><?php echo $FF->FAKTUR_DATE?></td>
						<td align="center" style="height:40px;font-size:11px"><?php echo $FF->NPWP?></td>
						<td align="center" style="height:40px;font-size:11px"><?php echo $FF->NAME?></td>
						<td align="center" style="height:40px;font-size:11px"> <?php echo $FF->ADDRESS?></td>
						<td align="center" style="height:40px;font-size:11px"><?php echo $FF->DPP?></td>
						<td align="center" style="height:40px;font-size:11px"><?php echo $FF->PPN?></td>
						<td align="center" style="height:40px;font-size:11px"><?php echo $FF->PPN_BM?></td>
						<td align="center" style="height:40px;font-size:11px"><?php echo $FF->IS_CREDITABLE_FLAG?></td>
						<td align="center" style="height:40px;font-size:11px"><?php echo $FF->DESCRIPTION?></td>
						<td align="center" style="height:40px;font-size:11px"><?php echo $FF->STATUS?></td>
					</tr>
					<?php }}?>
				</tbody>
			</table>
		</div>
	</div>
</div>
