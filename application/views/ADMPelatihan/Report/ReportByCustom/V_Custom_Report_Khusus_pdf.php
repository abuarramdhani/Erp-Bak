<?php 
$number=1;
$stafdata = array();
$nonstafdata = array();

?>

<br>
<table style="width: 100%">
	<thead style="text-align: center;">
		<tr>
			<td style="font-size: 16px"><b>REKAP PELATIHAN</b></td>
		</tr>
		<tr>
			<td style="font-size: 14px">EVALUASI REAKSI</td>
		</tr>
	</thead>
</table>
<br>
<table style="width:100%; border: 1px solid black; font-size: 10px;">
	<thead style="text-align: center;vertical-align: middle;">
		<tr>
			<th style="border-right: 1px solid black; border-bottom: 1px solid black;text-align:center;" width="2%">No</th>
			<th style="border-right: 1px solid black; border-bottom: 1px solid black;" width="10%">Nama Pelatihan</th>
			<th style="border-right: 1px solid black; border-bottom: 1px solid black;" width="5%">Tanggal</th>
			<th style="border-right: 1px solid black; border-bottom: 1px solid black;" width="7%">Trainer</th>
			<th style="border-right: 1px solid black; border-bottom: 1px solid black;text-align:center;" width="4%" title="yang mengisi kuesioner">Jumlah Partisipan</th>
			<th style="border-right: 1px solid black; border-bottom: 1px solid black;" width="10%">Kuesioner</th>
			<th style="border-right: 1px solid black; border-bottom: 1px solid black;" width="15%">Komponen Evaluasi</th>
			<th style="border-right: 1px solid black; border-bottom: 1px solid black;" width="7%">Total</th>
			<th style="border-right: 1px solid black; border-bottom: 1px solid black;" width="7%">Rata-rata</th>
			<th style="border-right: 1px solid black; border-bottom: 1px solid black;" width="7%">Keterangan</th>
		</tr>
	</thead>
	<tbody>
		<?php
			$no=1; foreach($GetSchName_QuesName as $sq){ 
				$strainer = explode(',', $sq['trainer']);
				$checkpoint_sg_desc = 0;
				foreach ($GetSchName_QuesName_segmen as $segmen) {
					if ($sq['scheduling_id'] == $segmen['scheduling_id'] && $sq['questionnaire_id'] == $segmen['questionnaire_id']) {
				$n=0;
				$i=0;
		?>
			<tr>
				<?php if ($checkpoint_sg_desc == 0) {
					$checkpoint_sch_id = 0;
					foreach ($sgCount as $key => $value) {
						if ($value['scheduling_id']==$segmen['scheduling_id'] && $value['questionnaire_id']==$segmen['questionnaire_id'] && $checkpoint_sch_id == 0  && $segmen['segment_type']!='0') {?>
							<td align="center" style="border-right: 1px solid black;border-bottom: 1px solid black" rowspan="<?php echo $value['rowspan'];?>"><?php echo $no++ ?></td>
							<td style="border-right: 1px solid black;border-bottom: 1px solid black" rowspan="<?php echo $value['rowspan']; ?>"><?php echo $sq['scheduling_name']?></a></td>
							<td style="border-right: 1px solid black;border-bottom: 1px solid black;min-width: 100px" rowspan="<?php echo $value['rowspan']; ?>"><?php echo $sq['date']; ?></td>
							<td style="border-right: 1px solid black;border-bottom: 1px solid black;min-width: 100px" rowspan="<?php echo $value['rowspan']; ?>">
							<?php
								foreach ($strainer as $st) {
									foreach ($trainer as $tr) {
										if ($st==$tr['trainer_id']) {
											echo $tr['trainer_name'].'<br>';
										}
									}
								}
							?>
							</td>
							<?php foreach ($attendant as $ga) {
								if ($ga['scheduling_id']==$sq['scheduling_id']) {?>
									<td style="border-right: 1px solid black;border-bottom: 1px solid black;min-width: 100px; text-align:center" rowspan="<?php echo $value['rowspan']; ?>"><?php echo $ga['attendant']; ?></td>
								<?php }
							} ?>
							<td style="border-right: 1px solid black;border-bottom: 1px solid black;min-width: 100px" rowspan="<?php echo $value['rowspan']; ?>"><?php echo $sq['questionnaire_title']; ?></td>
						<?php $checkpoint_sch_id = 1;
						}
						$checkpoint_sg_desc = 1;
					}
				} ?>
				<?php
					echo '<td style="border-right: 1px solid black;border-bottom: 1px solid black">'.$segmen['segment_description'].'</td>';
				?>
				<td style="border-right: 1px solid black;border-bottom: 1px solid black">
					<?php 
						foreach ($t_nilai as $tot) {
							if ($tot['scheduling_id'] == $segmen['scheduling_id'] && $tot['questionnaire_id'] == $segmen['questionnaire_id'] && $tot['segment_id'] == $segmen['segment_id']) {
								if ($tot['f_total']=='0') {echo "-";}
								else{echo round($tot['f_total'],2);}
							}
						}
					?>
				</td>
				<td style="border-right: 1px solid black;border-bottom: 1px solid black">
					<?php 
						foreach ($t_nilai as $tot) {
							if ($tot['scheduling_id'] == $segmen['scheduling_id'] && $tot['questionnaire_id'] == $segmen['questionnaire_id'] && $tot['segment_id'] == $segmen['segment_id']) {
								if ($tot['f_rata']=='0') {echo "-";}
								else{echo round($tot['f_rata'],2);}
							}
						}
					?>
				</td>
				<td style="border-right: 1px solid black;border-bottom: 1px solid black">
					<?php
						foreach ($t_nilai as $tot) {
							if ($tot['scheduling_id'] == $segmen['scheduling_id'] && $tot['questionnaire_id'] == $segmen['questionnaire_id'] && $tot['segment_id'] == $segmen['segment_id']) {
								if (1<=$tot['f_rata'] && $tot['f_rata']<=1.74) {echo "Kurang";}
								elseif (1.75<=$tot['f_rata'] && $tot['f_rata']<=2.49) {echo "Sedang";}
								elseif (2.5<=$tot['f_rata'] && $tot['f_rata']<=3.24) {echo "Baik";}
								elseif (3.25<=$tot['f_rata'] && $tot['f_rata']<=4) {echo "Baik Sekali";}
								elseif ($tot['f_rata']=='0') {echo "-";}
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
<br>
<br>
<table style="width: 100%;">
    <tr>
        <td rowspan="2" style="width: 75%; font-size: 14px">
        </td>
        <td colspan="2" style="width: 25%; font-size: 13px">
             <center>
             	Mengetahui,
			</center>
        </td>
    </tr>
    <tr>
        <td colspan="2" style="width: 25%; height: 100px; font-size: 14px">
            <b>
            </b>
            <br/>
            <br/>
            <center>
                ( <?php echo $Nama_Pe_report; ?> )
            </center>
             <center>
                ( <?php echo $Jabatan_Pe_report; ?> )
            </center>
        </td>
    </tr>
</table>