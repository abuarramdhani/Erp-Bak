<?php foreach ($report as $rp) {?>
<br>
<table style="width:100%;" class="table table-bordered">
	<tr>
		<td style="width: 50px; font-size: 13px;"><b>Hari / Tanggal</b></td>
		<td style="width: 300px; font-size: 13px;">
			<?php 
				$date=$rp['tanggal']; 
				// $newDate=date("l, d F Y", strtotime($date));

				$nameofDay 	=	str_replace(
									array
									(
										'Sunday',
										'Monday',
										'Tuesday',
										'Wednesday',
										'Thursday',
										'Friday',
										'Saturday'
									),
									array
									(
										'Minggu',
										'Senin',
										'Selasa',
										'Rabu',
										'Kamis',
										'Jumat',
										'Sabtu'
									),
									date("l", strtotime($date))
								);
				$nameofMonth 	=	str_replace(
									array
									(
										'January',
										'February',
										'March',
										'April',
										'May',
										'June',
										'July',
										'August',
										'September',
										'October',
										'November',
										'December'
									),
									array
									(
										'Januari',
										'Februari',
										'Maret',
										'April',
										'Mei',
										'Juni',
										'Juli',
										'Agustus',
										'September',
										'Oktober',
										'November',
										'Desember'
									),
									date("F", strtotime($date))
								);
				$Date 		=	date("d", strtotime($date));
				$Year 		=	date("Y", strtotime($date));
				$indonesianDate 	=	$nameofDay.', '.$Date.' '.$nameofMonth.' '.$Year;
				echo ':&emsp;'.$indonesianDate;
			?>	
		</td>
	</tr>
	<tr>
		<td style="width: 70px; font-size: 13px;"><b>Judul Training / Nama Kegiatan</b></td>
		<td style="width: 300px; font-size: 13px;"><?php echo ':&emsp;'.$rp['scheduling_or_package_name'];?></td>
	</tr>
	<tr>
		<td style="width: 70px;  font-size: 13px;"><b>Jenis Training</b></td>
		<td style="width: 300px; font-size: 13px;">
			<?php 
				if ($rp['jenis']==0) {echo ':&emsp;'."Softskill";} 
				if ($rp['jenis']==1) {echo ':&emsp;'."Hardskill";} 
				if ($rp['jenis']==2) {echo ':&emsp;'."Softskill & Hardskill";} 
			?>
		</td>
	</tr>
	<tr>
		<td style="width: 70px;  font-size: 13px;"><b>Jumlah Peserta yang Terdaftar</b></td>
		<td style="width: 300px; font-size: 13px;"><?php echo ':&emsp;'.$rp['peserta_total']." Orang";?></td>
	</tr>
	<tr>
		<td style="width: 70px;  font-size: 13px;"><b>Jumlah Peserta yang Datang</b></td>
		<td style="width: 300px; font-size: 13px;"><?php echo ':&emsp;'.$rp['peserta_hadir']." Orang";?></td>
	</tr>
	<tr>
		<td style="width: 70px;  font-size: 13px; vertical-align: top;"><b style="text-align: right;">Pelaksana</b></td>
		<td style="width: 300px; font-size: 13px; vertical-align: top;">
			<?php 
				$checkpoint=0;
				$strainer=explode(',', $rp['pelaksana']);
				foreach ($strainer as $st) {
					foreach ($trainer as $tr) {
						if ($st==$tr['trainer_id']) {
							if ($checkpoint==0) {
								echo ':&emsp;'.ucwords(strtolower($tr['trainer_name']))."<br>";
								$checkpoint++;
							}
							else{
								echo '&emsp;&nbsp;'.ucwords(strtolower($tr['trainer_name']))."<br>";
							}
						} 
					} 
				}
			?>
		</td>
	</tr>
	<tr>
		<td style="width: 70px; font-size: 13px;"><b>Index Materi</b></td>
		<td style="width: 300px; font-size: 13px;"><?php echo ':&emsp;'.$rp['index_materi'];?></td>
	</tr>
	<tr>
		<td style="width: 70px; font-size: 13px;vertical-align: top;"><b>Deskripsi Kegiatan</b></td>
	</tr>
	<tr>
		<td style="height: 10px"></td>
	</tr>
	<tr>
		<td style="width: 300px; font-size: 13px;vertical-align: top;text-align: justify;" colspan="2"><?php echo $panjang_desc;?></td>
	</tr>
	<tr>
		<td style="width: 300px; font-size: 13px;vertical-align: top;text-align: justify;" colspan="2"><?php echo $panjang_desc2;?></td>
	</tr>
	<tr>
		<td style="width: 300px; font-size: 13px;vertical-align: top;text-align: justify;" colspan="2"><?php echo $panjang_desc3;?></td>
	</tr>
</table>
<br>
<table style="width:100%; " class="table table-bordered">
	<tr>
		<td style="width: 70px; font-size: 13px;"><b>Evaluasi Reaksi</b></td>
	</tr>
</table>
<table>
	<br>
	<!-- NESTING TABLE -->
	<tr>
		<td>
			<table class="table table-bordered" style="border: 1px solid black; padding: 0px" id="tbodyevalReaksi">
				<thead class="bg-blue">
					<tr>
						<th style="width: 50px; border-right: 1px solid black;  border-bottom: 1px solid black;font-size: 13px; text-align: center;">No</th>
						<th style="width: 300px; border-right: 1px solid black;  border-bottom: 1px solid black;font-size: 13px; text-align: center;">Komponen Evaluasi</th>
						<th style="width: 70px; border-bottom: 1px solid black;font-size: 13px; text-align: center;">Rata-rata</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$no=1; foreach($GetSchName_QuesName_RPT as $sq){ ?>
							<?php 
							foreach ($GetSchName_QuesName_segmen as $segmen) {
								if ($sq['scheduling_id'] == $segmen['scheduling_id'] && $sq['questionnaire_id'] == $segmen['questionnaire_id'] && $segmen['segment_type']==1) {
									$n=0;
									$i=0;
							?>
								<tr>
									<?php 
									if ($no < $countSegment ) {?> 
										<td style="text-align:center;border-right: 1px solid black; border-bottom: 1px solid black;font-size: 13px;"><?php echo $no++; ?>
										<?php echo '<td style="border-right: 1px solid black; border-bottom: 1px solid black;font-size: 13px;">'.$segmen['segment_description'].'</td>';?>
										<td style="border-bottom: 1px solid black;font-size: 13px;">
									<?php }else{?>
										<td style="text-align:center;border-right: 1px solid black; font-size: 13px;"><?php echo $no++; ?>
										<?php echo '<td style="border-right: 1px solid black; font-size: 13px;">'.$segmen['segment_description'].'</td>';?>
										<td style="font-size: 13px;">
									<?php } 
									?>
										<?php 
											foreach ($t_nilai as $tot) {
												if ($tot['scheduling_id'] == $segmen['scheduling_id'] && $tot['questionnaire_id'] == $segmen['questionnaire_id'] && $tot['segment_id'] == $segmen['segment_id']) {
													echo round($tot['f_rata'],2);
												}
											}
										?>
									</td>
								</tr>
					<?php $i++; }
						}
					}?>
				</tbody>
			</table>
		</td>
	</tr>
</table>
<br>
<table style="width:100%; " class="table table-bordered">
	<tr>
		<td style="width: 70px; font-size: 13px;"><b>Komentar dan Saran Pelatihan</b></td>
	</tr>
</table>
<table>
	<br>
	<!-- NESTING TABLE -->
	<tr>
		<td>
			<ul style="list-style: disc; font-size: 13px;">
		    	<?php
		    		echo '<li>'.implode('</li><li>', $komen);
		    		for ($i=0; $i < count($komen) ; $i++) { 
		    			echo ''; //agar bullet hanya sesuai jumlah row
		    		}
		    	?>
		    </ul>
		</td>
	</tr>
</table>
<br>
<table style="width:100%; padding: 0px" class="table table-bordered">
	<tr>
		<td style="width: 70px; font-size: 13px;"><b>Evaluasi Pembelajaran</b></td>
	</tr>
</table>
<table>
	<br>
	<!-- NESTING TABLE -->
	<tr>
		<td>
			<table class="table table-bordered" style="border: 1px solid black; padding: 0px" name="tbodyevalPembelajaran" id="tbodyevalPembelajaran">
				<thead>
					<tr class="bg-primary">
						<th style="width: 50px; border-right: 1px solid black; border-bottom: 1px solid black;font-size: 13px; text-align: center;">No</th>
						<th style="width: 300px; border-right: 1px solid black; border-bottom: 1px solid black;font-size: 13px; text-align: center;">Nama</th>
						<th style="width: 100px; border-right: 1px solid black; border-bottom: 1px solid black;font-size: 13px; text-align: center;">Noind</th>
						<th style="width: 50px; border-bottom: 1px solid black; font-size: 13px; text-align: center;">Nilai Test</th>
					</tr>
				</thead>
				<tbody id="tbodyEvalPembelajaran">
						<?php 
							$no=1; foreach ($participant_reg as $prt) {		
						?>
					<tr class="clone" row-id="<?php echo $no; ?>">
						<?php 
						if ($no < $countPeserta) {?>
							<td style="width: 50px; border-right: 1px solid black;  border-bottom: 1px solid black;font-size: 13px;text-align:center;"><?php echo $no++; ?></td>
							<td style="width: 300px; border-right: 1px solid black;  border-bottom: 1px solid black;font-size: 13px;">
								<?php echo $prt['participant_name'];?>
							</td>
							<td style="width: 100px; border-right: 1px solid black;  border-bottom: 1px solid black;font-size: 13px;">
								<?php echo $prt['noind']; ?>
							</td>
							<td style="width: 50px; border-bottom: 1px solid black;font-size: 13px; text-align: center;" >
								<?php if ($prt['score_eval2_post']==NULL) {
									echo "-";
								}else{
									echo $prt['score_eval2_post']; 
								}
								?>
							</td>
						<?php } else{ ?>
							<td style="width: 50px; border-right: 1px solid black;font-size: 13px;text-align:center;"><?php echo $no++; ?></td>
							<td style="width: 300px; border-right: 1px solid black; font-size: 13px;">
								<?php echo $prt['participant_name'];?>
							</td>
							<td style="width: 100px; border-right: 1px solid black; font-size: 13px;">
								<?php echo $prt['noind']; ?>
							</td>
							<td style="width: 50px;font-size: 13px; text-align: center;" >
								<?php if ($prt['score_eval2_post']==NULL) {
									echo "-";
								}else{
									echo $prt['score_eval2_post']; 
								}
								?>
							</td>
						<?php }?>
					</tr>
					<?php } ?>
				</tbody>
			</table>
		</td>
	</tr>
</table>
<br>
<table style="width:100%; padding: 0px" class="table table-bordered">
	<tr>
		<td style="width: 70px; font-size: 13px;vertical-align: top;"><b>Kendala yang dialami</b></td>
	</tr>
	<tr>
		<td style="height: 10px"></td>
	</tr>
	<tr>
		<td style="width: 300px; font-size: 13px;vertical-align: top;text-align: justify;"><?php echo $rp['kendala'];?></td>
	</tr>
	<tr>
		<td style="height: 20px"></td>
	</tr>
	<tr>
		<td style="width: 70px; font-size: 13px;vertical-align: top;"><b>Catatan Penting</b></td>
	</tr>
	<tr>
		<td style="height: 10px"></td>
	</tr>
	<tr>
		<td style="width: 300px; font-size: 13px;vertical-align: top;text-align: justify;"><?php echo $rp['catatan'];?></td>
	</tr>
</table>
<br>
<table style="width: 100%;">
    <tr>
        <td rowspan="2" style="width: 65%; font-size: 14px">
            <table style="width:70px;height: 70px;border:1px solid black">
            	<tr>
            		<td style="border-right: 1px solid black; border-bottom: 1px solid black">Tgl Scan</td>
            		<td style="border-bottom: 1px solid black">Paraf</td>
            	</tr>
            	<tr>
            		<td style="height: 50px; width: 60px; border-right: 1px solid black"></td>
            		<td style="height: 50px;">apararar</td>
            	</tr>
            </table>
        </td>
        <td colspan="2" style="width: 35%; font-size: 14px">
             <center>Yogyakarta, 
	             <?php 
					$date=$rp['tgldoc']; 
					$nameofMonth 	=	str_replace(
										array
										(
											'January',
											'February',
											'March',
											'April',
											'May',
											'June',
											'July',
											'August',
											'September',
											'October',
											'November',
											'December'
										),
										array
										(
											'Januari',
											'Februari',
											'Maret',
											'April',
											'Mei',
											'Juni',
											'Juli',
											'Agustus',
											'September',
											'Oktober',
											'November',
											'Desember'
										),
										date("F", strtotime($date))
									);
					$Date 		=	date("d", strtotime($date));
					$Year 		=	date("Y", strtotime($date));
					$indonesianDate 	=	$Date.' '.$nameofMonth.' '.$Year;
					echo $indonesianDate;
					?>
			</center>
        </td>
    </tr>
    <tr>
        <td colspan="2" style="width: 35%; height: 100px; font-size: 14px">
            <b>
            </b>
            <br/>
            <br/>
            <br/>
            <br/>
            <center>
                ( <?php echo $rp['nama_acc'];?> )
            </center>
             <center>
                ( <?php echo $rp['jabatan_acc'];?> )
            </center>
        </td>
    </tr>
</table>
<?php } ?>