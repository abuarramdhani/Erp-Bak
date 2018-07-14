<?php 
$number=1;
$stafdata = array();
$nonstafdata = array();

if ($chk_eval_pembelajaran==1 || $chk_eval_perilaku==1) {
	$rowspan_='rowspan="2"';
}

// ------------------------------------------------------
?>
<table style="width: 100%">
	<thead>
		<tr>
			<td style="text-align: center; font-size: 16px"><b>REKAP PELATIHAN</b></td>
		</tr>
	</thead>
</table>
<br>
<table style="width:100%; border: 1px solid black; font-size: 10px;">
	<thead style="text-align: center;vertical-align: middle;">
		<tr>
			<th <?php echo $rowspan_ ?>  style="border-right: 1px solid black; border-bottom: 1px solid black; width: 2%">No</th>
			<th <?php echo $rowspan_ ?> style="border-right: 1px solid black; border-bottom: 1px solid black; width: 15%">Nama</th>
			<th <?php echo $rowspan_ ?> style="border-right: 1px solid black; border-bottom: 1px solid black; width: 5%">Nomor Induk</th>
			<th <?php echo $rowspan_ ?> style="border-right: 1px solid black; border-bottom: 1px solid black; width: 10%">Seksi</th>
			<th <?php echo $rowspan_ ?>  style="border-right: 1px solid black; border-bottom: 1px solid black; width: 10%">Unit</th>
			<th <?php echo $rowspan_ ?> style="border-right: 1px solid black; border-bottom: 1px solid black; width: 7%">Departemen</th>
			<th <?php echo $rowspan_ ?> style="border-right: 1px solid black; border-bottom: 1px solid black; width: 10%">Pelatihan</th>
			<th <?php echo $rowspan_ ?> style="border-right: 1px solid black; border-bottom: 1px solid black; width: 7%">Trainer</th>
			<th <?php echo $rowspan_ ?> style="border-right: 1px solid black; border-bottom: 1px solid black; width: 5%">Tanggal</th>
			<?php
			if ($chk_eval_pembelajaran=='1') {?>
				<th colspan="2" style="border-right: 1px solid black; border-bottom: 1px solid black; width: 10px">Pembelajaran</th>
			<?php }
			if ($chk_eval_perilaku=='1') {?>
				<th colspan="4" style="border-right: 1px solid black; border-bottom: 1px solid black; width: 40px">Perilaku</th>
			<?php } ?>
		</tr>
		<?php if ($chk_eval_pembelajaran=='1') {?>
			<tr>
				<th style=" width: 5%;border-right: 1px solid black; border-bottom: 1px solid black;">Pre</th>
				<th style=" width: 5%;border-right: 1px solid black; border-bottom: 1px solid black;">Post</th>
		<?php } 
			if ($chk_eval_perilaku=='1') {?>
				<th style=" width: 3%;border-right: 1px solid black; border-bottom: 1px solid black;">Hard skill</th>
				<th style=" width: 3%;border-right: 1px solid black; border-bottom: 1px solid black;">Ket</th>
				<th style=" width: 3%;border-right: 1px solid black; border-bottom: 1px solid black;">Soft skill</th>
				<th style=" width: 3%;border-right: 1px solid black; border-bottom: 1px solid black;">Ket</th>
			</tr>
		<?php } ?>
	</thead>
	<tbody>
	<?php foreach ($search as $src) {?>
		<tr>
			<td style="border-right: 1px solid black;border-bottom: 1px solid black;text-align: center;vertical-align: middle;"><?php echo $number++?></td>
				<td style="border-right: 1px solid black;border-bottom: 1px solid black;" <?php echo $col_a?> ><?php echo $src['participant_name']?></td>
				<td style="border-right: 1px solid black;border-bottom: 1px solid black;"><?php echo $src['noind']?></td>
			
				<td style="border-right: 1px solid black;border-bottom: 1px solid black;"><?php echo $src['section_name']?></td>
			
				<td style="border-right: 1px solid black;border-bottom: 1px solid black;"><?php echo $src['unit_name']?></td>
			
				<td style="border-right: 1px solid black;border-bottom: 1px solid black;"><?php echo $src['department_name']?></td>
				<td style="border-right: 1px solid black;border-bottom: 1px solid black;"><?php echo $src['nama_pelatihan']?></td>
				<td style="border-right: 1px solid black;border-bottom: 1px solid black;">
			<?php 
				$no=0;
				$strainer = explode(',', $src['trainer']);
				foreach ($strainer as $st){ $no++;
					foreach ($trainer as $tr){
						if($st == $tr['trainer_id']){
							$status='Internal';
							if($tr['trainer_status']==0){
								$status='Eksternal';
							}
			
						 echo $tr['trainer_name'];
						}
					}
				} ?>
				</td>
				<td style="border-right: 1px solid black;border-bottom: 1px solid black;"><?php echo $src['tanggal']?></td>
			<?php
			if ($chk_eval_pembelajaran=='1') {?>
				<td style="border-right: 1px solid black;border-bottom: 1px solid black;"><?php echo $src['score_eval2_pre']?></td>
			<?php

				// MASUK PENILAIAN
				$nilai_minimum = explode(',', $src['standar_kelulusan']);
				$min_s = $nilai_minimum[0];
				$min_n = $nilai_minimum[1];

				// NOMOR INDUK YANG STAF DAN NONSTAFF UNTUK MEMBEDAKAN 
				$staffCode = array('B', 'D', 'J', 'Q');
				$indCode = substr($src['noind'], 0, 1);
				if (in_array($indCode, $staffCode)) 
				{
					$a='stafKKM';
					array_push($stafdata, $src['noind'] );
				}
				else
				{
					$a='nonstafKKM';
					array_push($nonstafdata, $src['noind'] );
				}

				// --------------------------------------------------------------------------------------------------------------
				// KONDISI APABILA ADA PESERTA REMIDI
				// STAF
				if ($src['score_eval2_post']>=$min_s) 
				{
					$nilai_s='<td style="border-right: 1px solid black;border-bottom: 1px solid black;">'.$src['score_eval2_post'].'</td>';
				}
				elseif ($src['score_eval2_r1']>=$min_s)
				{
					$nilai_s='<td style="border-right: 1px solid black;border-bottom: 1px solid black;"><font color="red">'.$src['score_eval2_post'].'</font> /'.$src['score_eval2_r1'].'</td>';
				}
				elseif ($src['score_eval2_r2']>=$min_s)
				{
					$nilai_s='<td style="border-right: 1px solid black;border-bottom: 1px solid black;"><font color="red">'.$src['score_eval2_post'].'/'.$src['score_eval2_r1'].'</font> /'.$src['score_eval2_r2'].'</td>';
				}
				elseif ($src['score_eval2_r3']>=$min_s)
				{
					$nilai_s='<td style="border-right: 1px solid black;border-bottom: 1px solid black;"><font color="red">'.$src['score_eval2_post'].'/'.$src['score_eval2_r1'].'/'.$src['score_eval2_r2'].'</font> /'.$src['score_eval2_r3'].'</td>';
				}
				else
				{
					$nilai_s='<td style="border-right: 1px solid black;border-bottom: 1px solid black;">-</td>';
				}
				// --------------------------------------------------------------------------------------------------------------
				// KONDISI APABILA ADA PESERTA REMIDI
				// NONSTAF
				if ($src['score_eval2_post']>=$min_n) 
				{
					$nilai_n='<td style="border-right: 1px solid black;border-bottom: 1px solid black;">'.$src['score_eval2_post'].'</td>';
				}
				elseif ($src['score_eval2_r1']>=$min_n)
				{
					$nilai_n='<td style="border-right: 1px solid black;border-bottom: 1px solid black;"><font color="red">'.$src['score_eval2_post'].'</font> /'.$src['score_eval2_r1'].'</td>';
				}
				elseif ($src['score_eval2_r2']>=$min_n)
				{
					$nilai_n='<td style="border-right: 1px solid black;border-bottom: 1px solid black;"><font color="red">'.$src['score_eval2_post'].'/'.$src['score_eval2_r1'].'</font> /'.$src['score_eval2_r2'].'</td>';
				}
				elseif ($src['score_eval2_r3']>=$min_n)
				{
					$nilai_n='<td style="border-right: 1px solid black;border-bottom: 1px solid black;"><font color="red">'.$src['score_eval2_post'].'/'.$src['score_eval2_r1'].'/'.$src['score_eval2_r2'].'</font> /'.$src['score_eval2_r3'].'</td>';
				}
				else
				{
					$nilai_n='<td style="border-right: 1px solid black;border-bottom: 1px solid black;">-</td>';
				}
				// --------------------------------------------------------------------------------------------------------------
				// ISI STAFDATA DAN NONSTAFDATA
				if ($stafdata!=null && $nonstafdata==null) 
				{
					echo $nilai_s;
				} 
				else 
				{
					echo $nilai_n;
				}
				// --------------------------------------------------------------------------------------------------------------
			}
			if ($chk_eval_perilaku=='1') {?>
				<td style="border-right: 1px solid black;border-bottom: 1px solid black;"><?php echo $src['score_eval3_hardskill']?></td>
				<td style="border-right: 1px solid black;border-bottom: 1px solid black;"><?php echo $src['keterangan_hardskill']?></td>
				<td style="border-right: 1px solid black;border-bottom: 1px solid black;"><?php echo $src['score_eval3_softskill']?></td>
				<td style="border-right: 1px solid black;border-bottom: 1px solid black;"><?php echo $src['keterangan_softskill']?></td>
			<?php } ?>
		</tr>
	<?php } ?>
	</tbody>
</table>
<br>
<br>
<table style="width: 100%;">
    <tr>
        <td rowspan="2" style="width: 65%; font-size: 14px">
        </td>
        <td colspan="2" style="width: 35%; font-size: 13px">
             <center>
             	Mengetahui,
			</center>
        </td>
    </tr>
    <tr>
        <td colspan="2" style="width: 35%; height: 100px; font-size: 14px">
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