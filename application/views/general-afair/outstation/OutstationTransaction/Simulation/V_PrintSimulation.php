<table>
	<tr>
		<td><img width="80px" src="<?php echo base_url('assets/img/logo.png')?>" /></td>
		<td>
			<h1>
				Quick Outstation Simulation Detail
			</h1>
		</td>
	</tr>
</table>
<br/>

	<table class="table" style="font-size:15px;">
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

<b>Simulation Table</b>
<table class="table table-bordered table-striped" style="font-size:15px;">
	<thead>
		<tr>
			<th style="background-color: #357ca5;color: #fff" width="5%"><center><br>No<br>&nbsp;</center></th>
			<th style="background-color: #357ca5;color: #fff" width="10%"><center>Date</center></th>
			<th style="background-color: #357ca5;color: #fff" width="10%"><center>Time</center></th>
			<th style="background-color: #357ca5;color: #fff" width="15%"><center>Meal Allowance</center></th>
			<th style="background-color: #357ca5;color: #fff" width="23%"><center>Accomodation Allowance</center></th>
			<th style="background-color: #357ca5;color: #fff" width="10%"><center>Group</center></th>
			<th style="background-color: #357ca5;color: #fff" width="13%"><center>USH</center></th>
			<th style="background-color: #357ca5;color: #fff"><center>Total</center></th>
		</tr>
	</thead>
	<tbody id="simulation_body">
		<?php
			$no=1;
			foreach ($Simulation_detail as $sdet) {
				$inn_date = explode(' ', $sdet['inn_date']);
				$string = array('Rp',',00','.');
				$meal_nominal = str_replace($string, '', $sdet['meal_allowance_nominal']);

				$acc_nominal = str_replace($string, '', $sdet['acomodation_allowance_nominal']);

				$ush_nominal = str_replace($string, '', $sdet['ush_nominal']);

				$total = $meal_nominal+$acc_nominal+$ush_nominal;
				$group_name ='-';
				foreach ($GroupUSH as $grp) {
					if ($sdet['group_id'] == $grp['group_id']) {
						$group_name = $grp['group_name'];
					}
				}
		?>
		<tr>
			<td style="text-align: center"><?php echo $no++?></td>
			<td>&nbsp;&nbsp;<?php echo $inn_date[0] ?></td>
			<td>&nbsp;&nbsp;<?php echo $sdet['time_name'] ?></td>
			<td style="text-align: right">Rp<?php echo number_format($meal_nominal , 2, '.', ',') ?>&nbsp;&nbsp;</td>
			<td style="text-align: right">Rp<?php echo number_format($acc_nominal , 2, '.', ',') ?>&nbsp;&nbsp;</td>
			<td style="text-align: center"><?php echo $group_name ?></td>
			<td style="text-align: right">Rp<?php echo number_format($ush_nominal , 2, '.', ',') ?>&nbsp;&nbsp;</td>
			<td style="text-align: right">Rp<?php echo number_format($total , 2, '.', ',') ?>&nbsp;&nbsp;</td>
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
			<td style="text-align: right" colspan="3"><br>Total&nbsp;&nbsp;<br>&nbsp;&nbsp;</td>
			<td style="text-align: right">Rp<?php echo number_format($meal_total , 2, '.', ',') ?>&nbsp;&nbsp;</td>
			<td style="text-align: right">Rp<?php echo number_format($accomodation_nominal , 2, '.', ',') ?>&nbsp;&nbsp;</td>
			<td></td>
			<td style="text-align: right">Rp<?php echo number_format($ush_nominal , 2, '.', ',') ?>&nbsp;&nbsp;</td>
			<td style="text-align: right">Rp<?php echo number_format($total_nominal , 2, '.', ',') ?>&nbsp;&nbsp;</td>
		</tr>
	</tfoot>
</table>
