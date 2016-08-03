<?php
	$no=1;
	foreach($data_realization as $drel){
?>
<div style="border: 2px solid #000; height: 100%">
	<table style="border: 1px solid #000; width: 100%; margin: 2px">
		<tr>
			<td height="20px" colspan="2" width="400px">&emsp;<b style="font-size: 17px">CV. KARYA HIDUP SENTOSA<b></td>
			<td width="200px" style="border-left: 1px solid #000;">&nbsp;No. Kas Bon : <?php echo str_pad($drel['realization_id'], 8, "0", STR_PAD_LEFT); ?></td>
		</tr>
		<tr>
			<td width="100px">&emsp;Jl. Magelang 144</td>
			<td rowspan="2" width="200px" style="font-size: 25px; text-align: center"><b>KAS BON</b></td>
			<td rowspan="2" width="200px" style="border-left: 1px solid #000;">&nbsp;Tanggal : <?php echo date("d/m/Y") ?></td>
		</tr>
		<tr>
			<td width="100px">&emsp;Yogyakarta</td>
		</tr>
	</table>
	<table style="width: 100%; margin: 2px">
		<tr>
			<td height="40px" style="border: 1px solid #000; width:40px;font-size: 20px"><center><b>No</b></center></td>
			<td height="40px" style="border: 1px solid #000; width:600px;font-size: 20px"><center><b>Pengeluaran</b></center></td>
			<td height="40px" style="border: 1px solid #000; width:100px;font-size: 20px"><center><b>Jumlah</b></center></td>
		</tr>
	<?php
		$index=0;
		foreach ($data_realization_detail as $real_det) {
			foreach($Component as $comp){
				if ($real_det['component_id'] == $comp['component_id']) {
					$component_name = $comp['component_name'];
				}
			}
			$qty = $real_det['qty'];
			$string = array('Rp',',00','.');
			$nominal = str_replace($string, '', $real_det['nominal']);

			$total[$index] = $qty*$nominal;
			$group_name ='-';

			$index++;
		}
			if($drel['sex'] == 'L'){
				$jk = 'Bp.';
			}
			else{
				$jk = 'Ibu';
			}
			$ex_time1 = explode(' ', $drel['depart_time']);
			$depart = explode('-', $ex_time1[0]);
			$ex_time2 = explode(' ', $drel['return_time']);
			$return = explode('-', $ex_time2[0]); 
	?>
		<tr >
			<td height="40px" style="border: 1px solid #000;font-size: 15px; vertical-align: middle"><center><?php echo $no++; ?></center></td>
			<td style="padding-left: 5px;border: 1px solid #000; font-size: 15px; vertical-align: top;">Bea DL <?php echo $jk.' '.$drel['employee_name'].' / '.$drel['employee_code'].' Ke '.$drel['area_name'].' tgl '.$depart[2].'/'.$depart[1].'/'.$depart[0].' - '.$return[2].'/'.$return[1].'/'.$return[0]?></td>
			<td style="padding-left: 3px;text-align: right ;border: 1px solid #000;font-size: 15px; vertical-align: middle"><?php echo number_format(array_sum($total), 0, ',', '.') ?>&nbsp;</td>
		</tr>
		<tr>
			<td height="40px" style="border: 1px solid #000;">&nbsp;</td>
			<td style="border: 1px solid #000;">&nbsp;</td>
			<td style="text-align: right ;border: 1px solid #000;">&nbsp;</td>
		</tr>
		<tr>
			<td height="40px" style="border: 1px solid #000;">&nbsp;</td>
			<td style="border: 1px solid #000;">&nbsp;</td>
			<td style="text-align: right ;border: 1px solid #000;">&nbsp;</td>
		</tr>
		<tr>
			<td height="40px" style="border: 1px solid #000;">&nbsp;</td>
			<td style="border: 1px solid #000;">&nbsp;</td>
			<td style="text-align: right ;border: 1px solid #000;">&nbsp;</td>
		</tr>
		<tr>
			<td height="40px" colspan="2" style="text-align: right ;border: 1px solid #000;"><b>Total Rp.</b>&emsp;</td>
			<td style="text-align: right ;border: 1px solid #000;"><?php echo number_format(array_sum($total), 0, ',', '.') ?>&nbsp;</td>
		</tr>
	</table>
	<table style="width: 100%; margin: 2px;">
		<tr>
			<td colspan="3">&nbsp;</td>
		</tr>
		<tr>
			<td style="font-size: 20px" width="300px"><center>Kasir</center></td>
			<td style="font-size: 20px" width="300px"><center>Menyetujui</center></td>
			<td style="font-size: 20px" width="300px"><center>Menerima</center></td>
		</tr>
		<tr>
			<td colspan="3">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="3">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="3">&nbsp;</td>
		</tr>
		<tr>
			<td style="font-size: 20px;vertical-align: top" width="300px"><center>Yuning Widiastuti</center></td>
			<td style="font-size: 20px;vertical-align: top" width="300px"><center>Amelia Ayu Luthfi</center></td>
			<td style="font-size: 20px;vertical-align: top" width="300px"><center><?php echo $drel['employee_name'] ?></center></td>
		</tr>
		<tr>
			<td colspan="3">&nbsp;</td>
		</tr>
	<?php
		}
	?>
	</table>
</div>