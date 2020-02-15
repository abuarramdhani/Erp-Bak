<table class="table table-bordered table-striped" id="tb_assy" >
	<thead class="bg-primary">
		<tr>
			<th>NO</th>
			<th>KODE ASSY</th>
			<th>DESCRIPTION</th>
			<th>COMPONENT CODE</th>
			<th>COMPONENT DESC</th>
			<th>FROM SUBINVENTORY</th>
			<th>FROM LOCATOR</th>
			<th>PULL SUBINVENTORY</th>
			<th>PULL LOCATOR</th>
			<th>ONHAND</th>
			<th>DEPT CLASS</th>
		</tr>
	</thead>
	<tbody>
		<?php
		$nomorline = 1; 
		foreach ($monitoringassy as $mon) { ?>
		<tr>
			<td><?=$nomorline?></td>
			<td><?=$mon['SEGMENT1']?></td>
			<td><?=$mon['DESCRIPTION']?></td>
			<td><?=$mon['COMPONENT_CODE']?></td>
			<td><?=$mon['COMPONENT_DESC']?></td>
			<td><?=$mon['FROM_SUBINV']?></td>
			<td><?=$mon['FROM_LOCATOR']?></td>
			<td><?=$mon['PULL_SUBINV']?></td>
			<td><?=$mon['PULL_LOCATOR']?></td>
			<td><?=$mon['ONHAND']?></td>
			<td><?=$mon['DEPT_CLASS']?></td>
		</tr>
	<?php 
	$nomorline++;
	 } ?>
	</tbody>
	
</table>