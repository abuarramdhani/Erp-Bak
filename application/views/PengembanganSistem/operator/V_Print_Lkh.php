<div style="margin-left:20px;margin-right:20px;padding-top:0px" class="print_lkh">
		<div class="row" style="margin-left:3px;margin-right:3px; size=23px">
			<h2 style="text-align: center"><b>LAPORAN HASIL KERJA ADMINISTRASI PENGEMBANGAN SISTEM</b></h2>
			<table style="font-size: 12px;">
				<tr>
					<th style="text-align: left">
						NAMA
					</th>
					<th style="text-align: left">
					<?= ": ",$this->session->employee;?>
					</th>
				</tr>
				<tr>
					<th style="text-align: left">
					NO. INDUK
					</th>
					<th style="width:780px; text-align: left">
					<?= ": " ,$this->session->user;?>
					</th>
					<th style="text-align: left" >
                    <?php if ($a = date('Y-m-d')) {
                        $bulanIndo = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September' , 'Oktober', 'November', 'Desember'];
                    }   $s = explode('-',$a);
                            $day = $s[2];
                            $mon = $s[1];
                            $year = $s[0];
                            echo('BULAN : ' .$bulanIndo[abs($mon - 1)]. ' ' .$year);
                     ?>
					</th>
				</tr>
			</table>
			<table border="1" style="border-collapse: collapse;margin: 0 auto; font-size:12 px">
				<tbody>
					<tr>
						<th width="5%" rowspan="2" style="text-align:center; height:20px;background:#DDDDDD;font-size:13px">Hari</th>
						<th width="8%" rowspan="2" style="text-align:center; height:20px;background:#DDDDDD;font-size:13px">Tanggal</th>
						<th width="18%" rowspan="2" style="text-align:center; height:20px;background:#DDDDDD;font-size:13px">Uraian Pekerjaan</td>
						<th width="15%" rowspan="2" style="text-align:center; height:20px;background:#DDDDDD;font-size:13px">Kode</td>
						<th width="5%" rowspan="2" style="text-align:center; height:20px;background:#DDDDDD;font-size:13px">Target<br>Waktu</td>
						<th width="5%" colspan="2" style="text-align:center; height:20px;background:#DDDDDD;font-size:13px">Waktu</td>
						<th width="5%" rowspan="2" style="text-align:center; height:20px;background:#DDDDDD;font-size:13px">Total<br>Waktu</td>
						<th width="5%" rowspan="2" style="text-align:center; height:20px;background:#DDDDDD;font-size:13px">IP%</td>
						<th width="8%" rowspan="2" style="text-align:center; height:20px;background:#DDDDDD;font-size:13px">Persetujuan<br>Kualitas</td>
						<th width="8%" rowspan="2" style="text-align:center; height:20px;border:0;"></th>
						<th width="2%" colspan="6" style="text-align:center; height:20px;background:#DDDDDD;font-size:13px">KETERANGAN</th>
					</tr>
					<tr>
						<th width="5%" style="text-align:center; height:20px;background:#DDDDDD;font-size:13px">Mulai</th>
						<th width="5%" style="text-align:center; height:20px;background:#DDDDDD;font-size:13px">Selesai</th>
						<th width="3%" style="text-align:center; height:20px;background:#DDDDDD;font-size:13px">T</th>
						<th width="3%" style="text-align:center; height:20px;background:#DDDDDD;font-size:13px">I</th>
						<th width="3%" style="text-align:center; height:20px;background:#DDDDDD;font-size:13px">M</th>
						<th width="3%" style="text-align:center; height:20px;background:#DDDDDD;font-size:13px">SK</th>
						<th width="3%" style="text-align:center; height:20px;background:#DDDDDD;font-size:13px">CT</th>
						<th width="3%" style="text-align:center; height:20px;background:#DDDDDD;font-size:13px">IP</th>
					</tr>

                    <?php $no = 1; foreach ($record as $row) { ?>
					<tr row-id="<?php echo $row['id']?>">
					<!-- <td style="text-align: center; padding: 5px; width: 32px;"><b><?php echo $no++; ?></b></td> -->
						<td style="text-align: center; padding: 1px; width: 5%; <?php if ($row["uraian_pekerjaan"]=='LIBUR') {echo 'font-weight: bold'; } ?>"><?php echo $row["harimasuk"];?>
							
						</td>
						<td style="text-align: center; padding: 1px; width: 8%;"><?php 
						$datatanggal = explode("-", $row["tglmasuk"]);
						$day = $datatanggal[2];
						$bulan = $datatanggal[1];
						$tahun = $datatanggal[0];
							
						$hasil = $day."-".$bulan."-".$tahun;
						echo $hasil;
						?>
							
						</td>
						<td style="text-align: center; padding: 1px; width: 18%; <?php 
							$str = explode(" ",$row["uraian_pekerjaan"]);
						if ($str[0] =='LIBUR' ) {
						echo 'background: #a7a7a7; font-weight: bold; font-family: sans-serif; font-size: 11.5px;';
						}elseif ($str[0] =='Libur' && $str[1] !== '') {
							echo 'background: #93ff81; font-weight: bold; font-family: sans-serif; font-size: 11.5px;';
						}; ?>"><?php echo $row["uraian_pekerjaan"];?>
						
						</td>
						<td style="text-align: center; padding: 1px; width: 5%; <?php 
							$str = explode(" ",$row["uraian_pekerjaan"]);
							if ($str[0] =='LIBUR') {
						echo 'background: #a7a7a7; font: bold; font-family: sans-serif; font-size: 11.5px;';
						}elseif ($str[0] =='Libur' && $str[1] !== '') {
							echo 'background: #93ff81; font-weight: bold; font-family: sans-serif; font-size: 11.5px;';
						}; ?>"><?php echo $row["kodesie"];?>
						
						</td>
						<td style="text-align: center; padding: 1px; width: 5%; <?php
							$str = explode(" ",$row["uraian_pekerjaan"]);
							if ($str[0] =='LIBUR') {
						echo 'background: #a7a7a7; font: bold; font-family: sans-serif; font-size: 11.5px;';
						}elseif ($str[0] =='Libur' && $str[1] !== '') {
							echo 'background: #93ff81; font-weight: bold; font-family: sans-serif; font-size: 11.5px;';
						}; ?>"><?php echo $row["targetjob"];?>
						
						</td>
						<td <?php 
							$str = explode(" ",$row["uraian_pekerjaan"]);
						if ($str =='LIBUR') {
							echo 'hidden="hidden"';
						} ?> style="text-align: center; padding: 1px; width: 5%; <?php
							$str = explode(" ",$row["uraian_pekerjaan"]);
						 if ($str[0] =='LIBUR') {
						echo 'background: #a7a7a7; font: bold; font-family: sans-serif; font-size: 11.5px;';
						}elseif ($str[0] =='Libur' && $str[1] !== '') {
							echo 'background: #93ff81; font-weight: bold; font-family: sans-serif; font-size: 11.5px;';
						}; ?>"><?php if ($row["waktu_mulai"] =='00:00:00') { echo ""; }else{$jam = explode(":", $row["waktu_mulai"]);$jam1 = $jam[2];
						$jam2 = $jam[1];
						$jam3 = $jam[0];
						$jadi = $jam3.":".$jam2; echo $jadi;};?>
							
						</td>
						<td style="text-align: center; padding: 1px; width: 5%; <?php
							$str = explode(" ",$row["uraian_pekerjaan"]);
						 if ($str[0]=='LIBUR') {
						echo 'background: #a7a7a7; font: bold; font-family: sans-serif; font-size: 11.5px;';
						}elseif ($str[0] =='Libur' && $str[1] !== '') {
							echo 'background: #93ff81; font-weight: bold; font-family: sans-serif; font-size: 11.5px;';
						}; ?>"><?php if ($row["waktu_selesai"] =='00:00:00') { echo "";}else{$jam = explode(":", $row["waktu_selesai"]);$jam1 = $jam[2];
						$jam2 = $jam[1];
						$jam3 = $jam[0];
						$jadi = $jam3.":".$jam2; echo $jadi;};?>
						
						</td>
						<td style="text-align: center; padding: 1px; width: 5%; <?php
							$str = explode(" ",$row["uraian_pekerjaan"]);
						 if ($str[0]=='LIBUR') {
						echo 'background: #a7a7a7; font: bold; font-family: sans-serif; font-size: 11.5px;';
						}elseif ($str[0] =='Libur' && $str[1] !== '') {
							echo 'background: #93ff81; font-weight: bold; font-family: sans-serif; font-size: 11.5px;';
						}; ?>"><?php echo $row["total_waktu"];?>
						
						</td>
						<td style="text-align: center; padding: 1px; width: 5%; <?php 
							$str = explode(" ",$row["uraian_pekerjaan"]);
						if ($str[0]=='LIBUR') {
						echo 'background: #a7a7a7; font: bold; font-family: sans-serif; font-size: 11.5px;';
						}elseif ($str[0] =='Libur' && $str[1] !== '') {
							echo 'background: #93ff81; font-weight: bold; font-family: sans-serif; font-size: 11.5px;';
						}; ?>"><?php echo $row["persen"];?>
						
						</td>
						<td style="text-align: center; padding: 1px; width: 8%;"></td>
						<td style="text-align: center; padding: 1px; width: 2%;border:0"></td>
						<td style="text-align: center; padding: 1px; width: 3%;"><b><?php echo $row["t"];?></b></td>
						<td style="text-align: center; padding: 1px; width: 3%;"><b><?php echo $row["i"];?></b></td>
						<td style="text-align: center; padding: 1px; width: 3%;"><b><?php echo $row["m"];?></b></td>
						<td style="text-align: center; padding: 1px; width: 3%;"><b><?php echo $row["sk"];?></b></td>
						<td style="text-align: center; padding: 1px; width: 3%;"><b><?php echo $row["ct"];?></b></td>
						<td style="text-align: center; padding: 1px; width: 2%;"><b><?php echo $row["ip"];?></b></td>	
					</tr>
					<?php } ?>
				</tbody>
			</table>
			<div>
				<table>
						<tr>
							<td width="600"></td>
							<td>
                            <?php if ($a = date('Y-m-d')) {
                        $bulanIndo = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September' , 'Oktober', 'November', 'Desember'];
                    }   $s = explode('-',$a);
                            $day = $s[2];
                            $mon = $s[1];
                            $year = $s[0];
                            echo('Yogyakarta, ' .$day.' '.$bulanIndo[abs($mon)]. ' ' .$year);
                     ?>
							</td>
						</tr>
						<tr>
							<td height="50"></td>
						</tr>
						<tr>
							<td width="600"></td>
							<td align="center">
							<?php
                            echo $pic;
                    
                 			?>
							</td>
						</tr>
				</table>
				
			</div>
		</div>
	</div>