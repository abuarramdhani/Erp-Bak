	<div style="margin-left:20px;margin-right:20px;padding-top:0px">
		<div class="row" style="margin-left:3px;margin-right:3px">
			<h5 align="center"><b>DATA HASIL PENGECEKAN KLIKBCA-ORACLE</b></h5>
			<table border="1" style="border-collapse: collapse;margin: 0 auto;">
				<tbody>
					<tr>
						<td align="center" width="2%" rowspan="2" style="height:20px;background:#DDDDDD;font-size:9px">NO</td>
						<td align="center" width="11%" rowspan="2" style="height:20px;background:#DDDDDD;font-size:9px">NO.REFERENSI</td>
						<td align="center" width="15%" colspan="2" style="height:20px;background:#DDDDDD;font-size:9px">PAYMENT NUMBER</td>
						<td align="center" width="15%" colspan="2" style="height:20px;background:#DDDDDD;font-size:9px">NO.REKENING TUJUAN</td>
						<td align="center" width="20%" colspan="2" style="height:20px;background:#DDDDDD;font-size:9px">NAMA PEMILIK REKENING</td>
						<td align="center" width="10%" colspan="2" style="height:20px;background:#DDDDDD;font-size:9px">NOMINAL</td>
						<td align="center" width="8%" rowspan="2" style="height:20px;background:#DDDDDD;font-size:9px">STATUS CHECK</td>
						<td align="center" width="5%" rowspan="2" style="height:20px;background:#DDDDDD;font-size:9px">TANGGAL CHECK</td>
						<td align="center" width="5%" rowspan="2" style="height:20px;background:#DDDDDD;font-size:9px">APPROVE</td>
					</tr>
					<tr>
						<td align="center" width="7.5%" style="height:20px;background:#DDDDDD;font-size:9px">KLIKBCA</td>
						<td align="center" width="7.5%" style="height:20px;background:#DDDDDD;font-size:9px">ORACLE</td>
						<td align="center" width="7%" style="height:20px;background:#DDDDDD;font-size:9px">KLIKBCA</td>
						<td align="center" width="7%" style="height:20px;background:#DDDDDD;font-size:9px">ORACLE</td>
						<td align="center" width="13%" style="height:20px;background:#DDDDDD;font-size:9px">KLIKBCA</td>
						<td align="center" width="13%" style="height:20px;background:#DDDDDD;font-size:9px">ORACLE</td>
						<td align="center" width="7%" style="height:20px;background:#DDDDDD;font-size:9px">KLIKBCA</td>
						<td align="center" width="7%" style="height:20px;background:#DDDDDD;font-size:9px">ORACLE</td>
					</tr>

					<?php
						if(!(empty($Referencee))){
							$no=0;
							foreach($Referencee as $Ref) { $no++;
								$majorcolor		= '#DE7575';

								if($Ref['oracle_checking'] == 'Y'){
									$majorcolor= '';
								}

								$col_PayNum		= $majorcolor;
								$col_RekTujuan	= $majorcolor;
								$col_NamaTujuan	= $majorcolor;
								$col_NamaTujuan	= $majorcolor;
								$col_Nominal	= $majorcolor;

								if($Ref['berita'] !== $Ref['pay_num_oracle']){$col_PayNum = '#FFEE85';}
								if($Ref['no_rek_penerima'] !== $Ref['rek_tujuan']){$col_RekTujuan = '#FFEE85';}
								if($Ref['inisial_penerima'] !== $Ref['inisial_tujuan']){$col_NamaTujuan = '#FFEE85';}
								if(chr($Ref['jumlah']) !== chr($Ref['jumlah_oracle'])){$col_Nominal = '#FFEE85';}

								$data_StatusChecking='';
								if($Ref['oracle_checking']=='Y'){$data_StatusChecking='OK';
								}elseif($Ref['oracle_checking']=='T'){$data_StatusChecking='NOT OK';}
					?>
					<tr>
						<td align="center" style="height:20px;font-size:9px;background:<?php echo $majorcolor ?>;"><?php echo $no?></td>
						<td align="center" style="height:20px;font-size:9px;background:<?php echo $majorcolor ?>;"><?php echo $Ref['no_referensi']?></td>
						<td align="center" style="height:20px;font-size:9px;background:<?php echo $col_PayNum ?>;"><?php echo $Ref['berita']?></td>
						<td align="center" style="height:20px;font-size:9px;background:<?php echo $col_PayNum ?>;"><?php echo $Ref['pay_num_oracle'] ?></td>
						<td align="center" style="height:20px;font-size:9px;background:<?php echo $col_RekTujuan ?>;"><?php echo $Ref['no_rek_penerima']?></td>
						<td align="center" style="height:20px;font-size:9px;background:<?php echo $col_RekTujuan ?>;"><?php echo $Ref['rek_tujuan']?></td>
						<td align="center" style="height:20px;font-size:9px;background:<?php echo $col_NamaTujuan; ?>;"><?php echo str_replace('(Rp)', '', $Ref['nama_penerima']) ?></td>
						<td align="center" style="height:20px;font-size:9px;background:<?php echo $col_NamaTujuan; ?>;"><?php echo $Ref['nama_penerima_oracle'] ?></td>
						<td align="right" style="height:20px;font-size:9px;background:<?php echo $col_Nominal ?>;"><?php echo $Ref['jumlah']?></td>
						<td align="right" style="height:20px;font-size:9px;background:<?php echo $col_Nominal ?>;"><?php echo $Ref['jumlah_oracle']?></td>
						<td align="center" style="height:20px;font-size:9px;background:<?php echo $majorcolor ?>;"><?php echo $data_StatusChecking?></td>
						<td align="center" style="height:20px;font-size:9px;background:<?php echo $majorcolor ?>;"><?php echo $Ref['tanggal_cek']?></td>
						<td align="center" style="height:20px;font-size:9px;background:<?php echo $majorcolor ?>;"><?php echo ''?></td>
					</tr>
					<?php }}?>
				</tbody>
			</table>
			<br>