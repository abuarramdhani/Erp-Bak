<table class="table table-bordered table-striped table-hover" id="jobTable">
	<thead class="bg-primary">
		<td>NO</td>
		<td>JOB NUMBER</td>
		<td>RELEASED</td>
		<td>CODE</td>
		<td>DESCRIPTION</td>
	</thead>
	<tbody>
		<?php $no=1; foreach ($jobData as $val) { ?>
			<tr>
				<td><?php echo $no++; ?></td>
				<td>
					<a href="<?php echo base_url('ManufacturingOperation/Job/ReplaceComp/viewJob/'.$val['WIP_ENTITY_NAME']) ?>">
						<?php echo $val['WIP_ENTITY_NAME']; ?>
					</a>
				</td>
				<td><?php echo $val['RELEASE']; ?></td>
				<td><?php echo $val['SEGMENT1']; ?></td>
				<td><?php echo $val['DESCRIPTION']; ?></td>
			</tr>
		<?php } ?>
	</tbody>
</table>