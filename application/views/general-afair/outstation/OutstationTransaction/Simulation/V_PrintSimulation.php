<h1>
	Quick Outstation Simulation Detail
</h1>

	<table width="100%">
	<?php
	foreach($data_simulation as $dsim){
?>
	<tr>
		<td width="15%">ID Employee</td>
		<td width="35%"><?php echo $dsim['employee_code'] ?></td>
		<td width="15%"></td>
		<td width="25%"></td>
	</tr>
	<tr>
		<td>Employee Name</td>
		<td><?php echo $dsim['employee_name'] ?></td>
		<td>Destination</td>
		<td><?php echo $dsim['area_name'] ?></td>
	</tr>
	<tr>
		<td>Section</td>
		<td><?php echo $dsim['section_name'] ?></td>
		<td>City Type</td>
		<td><?php echo $dsim['city_type_name'] ?></td>
	</tr>
	<tr>
		<td>Unit</td>
		<td><?php echo $dsim['unit_name'] ?></td>
		<td>Depart</td>
		<td><?php echo $dsim['depart_time'] ?></td>
	</tr>
	<tr>
		<td>Departemen</td>
		<td><?php echo $dsim['department_name'] ?></td>
		<td>Return</td>
		<td><?php echo $dsim['return_time'] ?></td>
	</tr>
</table>
<?php
		}
?>
<br/>
<br/>
<b>Simulation Table</b>
<table width="100%" border="1" style="border-collapse: collapse; border: 1px solid #ddd">
	<thead>
		<tr style="background-color:#337ab7;">
			<th width="5%" style="color: #fff">No</th>
			<th width="10%" style="color: #fff">Date</th>
			<th width="10%" style="color: #fff">Time</th>
			<th width="25%" style="color: #fff">Meal Allowance</th>
			<th width="25%" style="color: #fff">Accomodation Allowance</th>
			<th style="color: #fff">Group</th>
			<th style="color: #fff">USH</th>
			<th style="color: #fff">Total</th>
		</tr>
	</thead>
	<tbody id="simulation_body">
		<?php
			$no=1;
			foreach ($Simulation_detail as $sdet) {
				$inn_date = explode(' ', $sdet['inn_date']);
				$meal_rep = str_replace('Rp', '', $sdet['meal_allowance_nominal']);
				$meal_rep1 = str_replace(',00', '', $meal_rep);
				$meal_rep2 = str_replace('.', '', $meal_rep1);

				$acc_rep = str_replace('Rp', '', $sdet['acomodation_allowance_nominal']);
				$acc_rep1 = str_replace(',00', '', $acc_rep);
				$acc_rep2 = str_replace('.', '', $acc_rep1);

				$ush_rep = str_replace('Rp', '', $sdet['ush_nominal']);
				$ush_rep1 = str_replace(',00', '', $ush_rep);
				$ush_rep2 = str_replace('.', '', $ush_rep1);

				$total = $meal_rep2+$acc_rep2+$ush_rep2;
					$group_name ='-';
				foreach ($GroupUSH as $grp) {
					if ($sdet['group_id'] == $grp['group_id']) {
						$group_name = $grp['group_name'];
					}
				}
		?>
		<tr>
			<td style="text-align: center"><?php echo $no++?></td>
			<td><?php echo $inn_date[0] ?></td>
			<td><?php echo $sdet['time_name'] ?></td>
			<td style="text-align: right">Rp<?php echo number_format($meal_rep2 , 2, '.', ',') ?></td>
			<td style="text-align: right">Rp<?php echo number_format($acc_rep2 , 2, '.', ',') ?></td>
			<td><?php echo $group_name ?></td>
			<td style="text-align: right">Rp<?php echo number_format($ush_rep2 , 2, '.', ',') ?></td>
			<td style="text-align: right">Rp<?php echo number_format($total , 2, '.', ',') ?></td>
		</tr>
		<?php
			}
		?>
	</tbody>
	<tfoot>
		<?php
			foreach ($total_nominal as $tm) {
				$string = array('Rp',',00','.' );
				$remover = array('');

				$meal_total = str_replace($string, $remover, $tm['meal_nominal']);
				$accomodation_nominal = str_replace($string, $remover, $tm['accomodation_nominal']);
				$ush_nominal = str_replace($string, $remover, $tm['ush_nominal']);

				$total_nominal = $meal_total+$accomodation_nominal+$ush_nominal;
			}
		?>
		<tr>
			<td colspan="3">Total</td>
			<td style="text-align: right">Rp<?php echo number_format($meal_total , 2, '.', ',') ?></td>
			<td style="text-align: right">Rp<?php echo number_format($accomodation_nominal , 2, '.', ',') ?></td>
			<td></td>
			<td style="text-align: right">Rp<?php echo number_format($ush_nominal , 2, '.', ',') ?></td>
			<td style="text-align: right">Rp<?php echo number_format($total_nominal , 2, '.', ',') ?></td>
		</tr>
	</tfoot>
</table>
