<table>
	<tr>
		<td><img width="80px" src="<?php echo base_url('assets/img/logo.png')?>" /></td>
		<td>
			<h1>
				Quick Outstation Realization Detail
			</h1>
		</td>
	</tr>
</table>
<br/>

	<table class="table" style="font-size:15px;">
	<?php
	foreach($data_realization as $drel){
?>
	<tr>
		<td width="15%">ID Employee</td>
		<td width="35%"><?php echo $drel['employee_code'] ?></td>
		<td width="15%">Destination</td>
		<td width="25%"><?php echo $drel['area_name'] ?></td>
	</tr>
	<tr>
		<td>Employee Name</td>
		<td><?php echo $drel['employee_name'] ?></td>
		<td>City Type</td>
		<td><?php echo $drel['city_type_name'] ?></td>
	</tr>
	<tr>
		<td>Section</td>
		<td><?php echo $drel['section_name'] ?></td>
		<td>Depart</td>
		<td><?php echo $drel['depart_time'] ?></td>
	</tr>
	<tr>
		<td>Unit</td>
		<td><?php echo $drel['unit_name'] ?></td>
		<td>Return</td>
		<td><?php echo $drel['return_time'] ?></td>
	</tr>
	<tr>
		<td>Departemen</td>
		<td><?php echo $drel['department_name'] ?></td>
		<td>Bon</td>
		<td><?php echo $drel['bon_nominal'] ?></td>
	</tr>
</table>
<?php
		}
?>
<br/>

<b>Realization Table</b>
<table class="table table-bordered table-striped" style="font-size:15px;">
	<thead>
		<tr>
			<th style="background-color: #357ca5;color: #fff" width="5%"><center><br>No<br>&nbsp;</center></th>
			<th style="background-color: #357ca5;color: #fff" width="10%"><center>Component Name</center></th>
			<th style="background-color: #357ca5;color: #fff" width="10%"><center>Info</center></th>
			<th style="background-color: #357ca5;color: #fff" width="15%"><center>Qty</center></th>
			<th style="background-color: #357ca5;color: #fff" width="20%"><center>Nominal</center></th>
			<th style="background-color: #357ca5;color: #fff"><center>Total</center></th>
		</tr>
	</thead>
	<tbody id="simulation_body">
		<?php
			$no=1;
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
		?>
		<tr>
			<td style="text-align: center"><?php echo $no++?></td>
			<td width="30%">&nbsp;&nbsp;<?php echo $component_name ?></td>
			<td width="20%">&nbsp;&nbsp;<?php echo $real_det['info'] ?></td>
			<td style="text-align: center" width="10%"><?php echo $qty?></td>
			<td style="text-align: right">Rp<?php echo number_format($nominal , 2, ',', '.') ?>&nbsp;&nbsp;</td>
			<td style="text-align: right">Rp<?php echo number_format($total[$index] , 2, ',', '.') ?>&nbsp;&nbsp;</td>
		</tr>
		<?php
				$index++;
			}
		?>
	</tbody>
	<tfoot>
		<?php
			
		?>
		<tr>
			<td colspan="5" style="text-align: right"><br>Total&nbsp;&nbsp;&nbsp;&nbsp;<br>&nbsp;</td>
			<td style="text-align: right">Rp<?php echo number_format(array_sum($total), 2, ',', '.') ?>&nbsp;&nbsp;</td>
		</tr>
	</tfoot>
</table>
