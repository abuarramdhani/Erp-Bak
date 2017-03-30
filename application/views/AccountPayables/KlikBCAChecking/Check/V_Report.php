
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

		<div class="row" style="margin-left:3px;margin-right:3px">
			<h5 align="center"><b>DATA HASIL PENGECEKAN KLIKBCA-ORACLE</b></h5>
			<table border="1" style="border-collapse: collapse;margin: 0 auto;">
				<tbody>
					<tr>
						<td align="center" width="2%" rowspan="2" style="height:20px;background:#DDDDDD;font-size:9px">NO</td>
						<td align="center" width="15%" rowspan="2" style="height:20px;background:#DDDDDD;font-size:9px">NO.REFERENSI</td>
						<td align="center" width="15%" colspan="2" style="height:20px;background:#DDDDDD;font-size:9px">PAYMENT NUMBER</td>
						<td align="center" width="15%" colspan="2" style="height:20px;background:#DDDDDD;font-size:9px">NO.REKENING TUJUAN</td>
						<td align="center" width="20%" colspan="2" style="height:20px;background:#DDDDDD;font-size:9px">NAMA PEMILIK REKENING</td>
						<td align="center" width="10%" colspan="2" style="height:20px;background:#DDDDDD;font-size:9px">NOMINAL</td>
						<td align="center" width="10%" rowspan="2" style="height:20px;background:#DDDDDD;font-size:9px">STATUS CHECK</td>
						<td align="center" width="5%" rowspan="2" style="height:20px;background:#DDDDDD;font-size:9px">TANGGAL CHECK</td>
						<td align="center" width="5%" rowspan="2" style="height:20px;background:#DDDDDD;font-size:9px">APPROVE</td>
					</tr>
					<tr>
						<td align="center" width="7.5%" style="height:20px;background:#DDDDDD;font-size:9px">KLIKBCA</td>
						<td align="center" width="7.5%" style="height:20px;background:#DDDDDD;font-size:9px">ORACLE</td>
						<td align="center" width="7%" style="height:20px;background:#DDDDDD;font-size:9px">KLIKBCA</td>
						<td align="center" width="7%" style="height:20px;background:#DDDDDD;font-size:9px">ORACLE</td>
						<td align="center" width="12%" style="height:20px;background:#DDDDDD;font-size:9px">KLIKBCA</td>
						<td align="center" width="12%" style="height:20px;background:#DDDDDD;font-size:9px">ORACLE</td>
						<td align="center" width="5%" style="height:20px;background:#DDDDDD;font-size:9px">KLIKBCA</td>
						<td align="center" width="5%" style="height:20px;background:#DDDDDD;font-size:9px">ORACLE</td>
					</tr>

					<?php
						if(!(empty($Referencee))){
							$no=0;
							foreach($Referencee as $Ref) { $no++;
								$majorcolor		= '#DE7575';
								$oci_PayNum 	= '-';
								$oci_RekTujuan 	= '-';
								$oci_NamaTujuan	= '-';
								$oci_Nominal 	= '-';
								foreach ($OracleData as $oci) {
									if($oci['PAY_NUMBER']==$Ref['berita']){
										$majorcolor		= '';
										$oci_PayNum 	= $oci['PAY_NUMBER'];
										$oci_RekTujuan 	= $oci['REK_TUJUAN'];
										$oci_NamaTujuan = $oci['ACCT_TUJUAN'];
										$oci_Nominal 	= $oci['AMOUNT'];
									}
								}

								$col_PayNum		= $majorcolor;
								$col_RekTujuan	= $majorcolor;
								$col_NamaTujuan	= $majorcolor;
								$col_NamaTujuan	= $majorcolor;
								$col_Nominal	= $majorcolor;

								if($Ref['berita'] !== $oci_PayNum){$col_PayNum = '#FFEE85';}
								if($Ref['no_rek_penerima'] !== $oci_RekTujuan){$col_RekTujuan = '#FFEE85';}
								if($Ref['nama_penerima'] !== $oci_NamaTujuan){$col_NamaTujuan = '#FFEE85';}
								if($Ref['jumlah'] !== $oci_Nominal){$col_Nominal = '#FFEE85';}

								$data_StatusChecking='';
								if($Ref['oracle_checking']=='Y'){$data_StatusChecking='OK';
								}elseif($Ref['oracle_checking']=='T'){$data_StatusChecking='NOT OK';}
					?>
					<tr>
						<td align="center" style="height:20px;font-size:9px;background:<?php echo $majorcolor ?>;"><?php echo $no?></td>
						<td align="center" style="height:20px;font-size:9px;background:<?php echo $majorcolor ?>;"><?php echo $Ref['no_referensi']?></td>
						<td align="center" style="height:20px;font-size:9px;background:<?php echo $col_PayNum ?>;"><?php echo $Ref['berita']?></td>
						<td align="center" style="height:20px;font-size:9px;background:<?php echo $col_PayNum ?>;"><?php echo $oci_PayNum ?></td>
						<td align="center" style="height:20px;font-size:9px;background:<?php echo $col_RekTujuan ?>;"><?php echo $Ref['no_rek_penerima']?></td>
						<td align="center" style="height:20px;font-size:9px;background:<?php echo $col_RekTujuan ?>;"><?php echo $oci_RekTujuan?></td>
						<td align="center" style="height:20px;font-size:9px;background:<?php echo $col_NamaTujuan; ?>;"><?php echo $Ref['nama_penerima']?></td>
						<td align="center" style="height:20px;font-size:9px;background:<?php echo $col_NamaTujuan; ?>;"><?php echo $oci_NamaTujuan?></td>
						<td align="center" style="height:20px;font-size:9px;background:<?php echo $col_Nominal ?>;"><?php echo $Ref['jumlah']?></td>
						<td align="center" style="height:20px;font-size:9px;background:<?php echo $col_Nominal ?>;"><?php echo $oci_Nominal?></td>
						<td align="center" style="height:20px;font-size:9px;background:<?php echo $majorcolor ?>;"><?php echo $data_StatusChecking?></td>
						<td align="center" style="height:20px;font-size:9px;background:<?php echo $majorcolor ?>;"><?php echo $Ref['tanggal_cek']?></td>
						<td align="center" style="height:20px;font-size:9px;background:<?php echo $majorcolor ?>;"><?php echo ''?></td>
					</tr>
					<?php }}?>
				</tbody>
			</table>
			<br>
			<table width="100%">
				<tr>
					<td width="80%" ></td>
					<td width="20%" >
						Yogyakarta, &nbsp;&nbsp; <?php echo date("F Y"); ?>
					</td>
				</tr>
				<tr>
					<td></td>
					<td>
						<br><br>
						<br><br>
					</tr>
				<tr>
				<tr>
					<td></td>
					<td>
						(........................................)
					</td>
				</tr>
			</table>
		</div>
	</div>
</div>
