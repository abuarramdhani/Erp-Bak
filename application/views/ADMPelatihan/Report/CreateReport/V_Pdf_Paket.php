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
				echo ':	'.$indonesianDate;
			?>	
		</td>
	</tr>
	<tr>
		<td style="width: 70px; font-size: 13px;"><b>Judul Training / Nama Kegiatan</b></td>
		<td style="width: 300px; font-size: 13px;"><?php echo ':	'.$rp['scheduling_or_package_name'];?></td>
	</tr>
	<tr>
		<td style="width: 70px; font-size: 13px;"><b>Jenis Training</b></td>
		<td style="width: 300px; font-size: 13px;">
			<?php 
				if ($rp['jenis']==0) {echo ':	'."Softskill";} 
				if ($rp['jenis']==1) {echo ':	'."Hardskill";} 
			?>
		</td>
	</tr>
	<tr>
		<td style="width: 70px; font-size: 13px;"><b>Jumlah Peserta yang Terdaftar</b></td>
		<td style="width: 300px; font-size: 13px;"><?php echo ':	'.$rp['peserta_total']." Orang";?></td>
	</tr>
	<tr>
		<td style="width: 70px; font-size: 13px;"><b>Jumlah Peserta yang Datang</b></td>
		<td style="width: 300px; font-size: 13px;"><?php echo ':	'.$rp['peserta_hadir']." Orang";?></td>
	</tr>
	<tr>
		<td style="width: 70px; font-size: 13px; vertical-align: top;"><b>Pelaksana</b></td>
		<td style="width: 300px; font-size: 13px;vertical-align: top;">
			<?php 
				$strainer=explode(',', $rp['pelaksana']);					
				foreach ($strainer as $st) {
					foreach ($trainer as $tr) {
						if ($st==$tr['trainer_id']) {
							echo ':	'.$tr['trainer_name']."<br>";
						} 
					} 
				}
			?>
		</td>
	</tr>
	<tr>
		<td style="width: 70px;  font-size: 13px;"><b>Index Materi</b></td>
		<td style="width: 300px; font-size: 13px;"><?php echo ':	'.$rp['index_materi'];?></td>
	</tr>
	<tr>
		<td style="width: 70px; font-size: 13px;vertical-align: top;"><b>Deskripsi Kegiatan</b></td>
	</tr>
	<tr>
		<td style="height: 10px"></td>
	</tr>
	<tr>
		<td style="width: 300px; font-size: 13px;vertical-align: top;"><?php echo $rp['description'];?></td>
	</tr>
</table>
<br>
<table style="width:100%; " class="table table-bordered">
	<tr>
		<td style="width: 70px; font-size: 13px;"><b>Evaluasi Reaksi</b></td>
	</tr>
	<br>
	<!-- NESTING TABLE -->
	<tr>
		<td>
			<table class="table table-bordered" style="border: 1px solid black; padding: 0px" id="tbodyevalReaksi">
				<thead class="bg-blue">
					<tr>
						<th style="width: 40px; border-right: 1px solid black;  border-bottom: 1px solid black;font-size: 13px; text-align: center;vertical-align: middle" rowspan="2">No</th>
						<th width="230px" style="border-right: 1px solid black;  border-bottom: 1px solid black;font-size: 13px; text-align: center;vertical-align: middle" rowspan="2">Komponen Evaluasi</th>
						<th style="border-bottom: 1px solid black;font-size: 13px; text-align: center;" colspan="<?php echo $jmlrowPck; ?>">Rata-rata</th>
					</tr>
					<tr>
						<?php foreach ($countPel as $ct) {
							foreach ($GetSchName_QuesName_RPTPCK as $sp) { ?>
								<td width="60px" style="text-align:center; border-right: 1px solid black; border-bottom: 1px solid black;font-size: 13px;">
									<?php
										echo $sp['scheduling_name'];
									?>
								</td>
							<?php }
						} ?>
					</tr>
				</thead>
				<tbody>
					<?php
					$no=1;
					foreach ($justSegmentPck as $jspk) {
						?>
						<tr>
						<?php if ($no < $countSegmentPck) { ?>
							<td style="text-align:center;border-right: 1px solid black;border-bottom: 1px solid black;width:40px;font-size: 13px;"><?php echo $no++; ?></td>
							<td width="230px" style="border-right: 1px solid black;border-bottom: 1px solid black;font-size: 13px;">
								<?php
									echo $jspk['segment_description'];
								?>
							</td>
							<?php
							foreach ($GetSchName_QuesName_RPTPCK as $spk) {
								$checkpoint=0;
								$rowborder=0;
								if ($rowborder < $jmlrowPck) {
									foreach ($t_nilai as $tot) {
										if ($jspk['segment_description'] == $tot['segment_description'] && $spk['scheduling_id'] == $tot['scheduling_id']) {
											echo '<td style="border-right: 1px solid black; border-bottom: 1px solid black;font-size: 13px;">'.round($tot['f_rata'],2).'</td>';
											$checkpoint++;
										}
									}
									if ($checkpoint==0) {
										echo '<td style="border-right: 1px solid black;border-bottom: 1px solid black;font-size: 13px;">-</td>';
										$checkpoint++;
									}
								}
							}
						 }else { ?>
						 	<td style="text-align:center;border-right: 1px solid black;font-size: 13px;"><?php echo $no++; ?></td>
							<td width="230px" style="border-right: 1px solid black;font-size: 13px;">
								<?php
									echo $jspk['segment_description'];
								?>
							</td>
							<?php 
							foreach ($GetSchName_QuesName_RPTPCK as $spk) {
								$rowborder=0;
								$checkpoint=0;
								foreach ($t_nilai as $tot) {
									if ($jspk['segment_description'] == $tot['segment_description'] && $spk['scheduling_id'] == $tot['scheduling_id']) {
										echo '<td style="border-right: 1px solid black;font-size: 13px;width:30px">'.round($tot['f_rata'],2).'</td>';
										$checkpoint++;
									}
								}
								if ($checkpoint==0) {
									echo '<td style="border-right: 1px solid black; font-size: 13px; width:30px">-</td>';
									$checkpoint++;
								}
							}
						 } ?>
						</tr>
					<?php }?>	
				</tbody>
			</table>
		</td>
	</tr>
</table>
<br>
<table style="width:100%; padding: 0px" class="table table-bordered">
	<tr>
		<td style="width: 70px; font-size: 13px;"><b>Evaluasi Pembelajaran</b></td>
	</tr>
	<br>
	<!-- NESTING TABLE -->
	<tr>
		<td>
			<table class="table table-bordered" style="border: 1px solid black; padding: 0px" name="tbodyevalPembelajaran" id="tbodyevalPembelajaran">
				<thead>
					<tr class="bg-primary">
						<th width="40px" style="border-right: 1px solid black;  border-bottom: 1px solid black;font-size: 13px; text-align: center;vertical-align: middle" rowspan="2">No</th>
						<th width="230px" style="border-right: 1px solid black;  border-bottom: 1px solid black;font-size: 13px; text-align: center;vertical-align: middle" rowspan="2">Nama</th>
						<th width="50px" style="border-right: 1px solid black;  border-bottom: 1px solid black;font-size: 13px; text-align: center;vertical-align: middle" rowspan="2" >Noind</th>
						<th colspan="<?php echo $jmlrowPck; ?>" style="border-bottom: 1px solid black;font-size: 13px; text-align: center;" >Post-Test</th>
					</tr>
					<tr>
						<?php foreach ($countPel as $ct) {
							foreach ($GetSchName_QuesName_RPTPCK as $sp) { ?>
								<td width="60px" style="border-right: 1px solid black;border-bottom: 1px solid black; text-align: center;">
									<?php
										echo $sp['scheduling_name'];
									?>
								</td>
							<?php }
						} ?>
					</tr>
				</thead>
				<tbody id="tbodyEvalPembelajaran">
						<?php 
							$no=1; foreach ($participantName as $prt) {		
						?>
					<tr class="clone" row-id="<?php echo $no; ?>">
						<?php if ($no < $countPesertaPkt) {?>
							<td style="text-align:center;border-right: 1px solid black;border-bottom: 1px solid black;font-size: 13px;"><?php echo $no++; ?></td>
							<td style="border-right: 1px solid black;border-bottom: 1px solid black;font-size: 13px;">
								<?php echo $prt['participant_name'];?>
							</td>
							<td style="border-right: 1px solid black;border-bottom: 1px solid black;font-size: 13px;">
								<?php echo $prt['noind']; ?>
							</td>
								<?php 
								foreach ($GetSchName_QuesName_RPTPCK as $spk) {
									$checkpoint=0;
									foreach ($participant as $p) {
										if ($spk['scheduling_id'] == $p['scheduling_id'] && $prt['participant_name'] == $p['participant_name']) {
											?>
											<td width="30px" style="border-right: 1px solid black;border-bottom: 1px solid black;font-size: 13px;">
												<?php echo $p['score_eval2_post'];
												$checkpoint++; ?>
											</td>
										<?php }
									}
									if ($checkpoint==0) {?>
										<td width="30px" style="border-right: 1px solid black;border-bottom: 1px solid black;font-size: 13px;">
											<?php echo "-"; $checkpoint++; ?>
										</td>;
									<?php }
								}
								?>  										
							</td>
						<?php } else{?>
							<td style="text-align:center;border-right: 1px solid black;font-size: 13px;"><?php echo $no++; ?></td>
							<td style="border-right: 1px solid black;font-size: 13px;">
								<?php echo $prt['participant_name'];?>
							</td>
							<td style="border-right: 1px solid black;font-size: 13px;">
								<?php echo $prt['noind']; ?>
							</td>
								<?php 
								foreach ($GetSchName_QuesName_RPTPCK as $spk) {
									$checkpoint=0;
									foreach ($participant as $p) {
										if ($spk['scheduling_id'] == $p['scheduling_id'] && $prt['participant_name'] == $p['participant_name']) {
											?>
											<td width="30px" style="border-right: 1px solid black;font-size: 13px;">
												<?php echo $p['score_eval2_post'];
												$checkpoint++; ?>
											</td>
										<?php }
									}
									if ($checkpoint==0) {?>
										<td width="30px" style="border-right: 1px solid black;font-size: 13px;">
											<?php echo "-"; $checkpoint++; ?>
										</td>;
									<?php }
								}
								?>  										
							</td>
						<?php } ?>
					</tr>
					<?php } ?>
				</tbody>
			</table>
		</td>
	</tr>
</table>
<br>
<table style="width:100%; padding: 0px;" class="table table-bordered">
	<tr style="width: 70px; border-right: 1px solid black; font-size: 13px;vertical-align: top;">
		<td style="width: 70px; font-size: 13px;vertical-align: top;"><b>Kendala yang dialami</b></td>
	</tr>
	<tr>
		<td style="height: 10px"></td>
	</tr>
	<tr style="width: 70px; border-right: 1px solid black; font-size: 13px;vertical-align: top;">
		<td style="width: 330px; font-size: 13px;vertical-align: top;"><?php echo $rp['kendala'];?></td>
	</tr>
	<tr>
		<td style="height: 20px"></td>
	</tr>
	<tr style="width: 70px; border-right: 1px solid black; font-size: 13px;vertical-align: top;">
		<td style="width: 70px;font-size: 13px;vertical-align: top;"><b>Catatan Penting</b></td>
	</tr>
	<tr>
		<td style="height: 10px"></td>
	</tr>
	<tr style="width: 70px; border-right: 1px solid black; font-size: 13px;vertical-align: top;">
		<td style="width: 330px; font-size: 13px;vertical-align: top;"><?php echo $rp['catatan'];?></td>
	</tr>
</table>
<br>
<table style="width: 100%;border:1px solid black">
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