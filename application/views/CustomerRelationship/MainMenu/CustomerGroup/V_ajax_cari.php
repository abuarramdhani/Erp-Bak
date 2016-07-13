<?php
/*
echo $name."<br />";
echo $village."<br />";
echo $city."<br />";
echo $province."<br />";
*/
?>
<script src="<?php echo base_url('assets/plugins/dataTables/jquery.dataTables.js');?>"></script>
	<script src="<?php echo base_url('assets/plugins/dataTables/dataTables.bootstrap.js');?>"></script>
     <script>
         $(document).ready(function () {
             $('#dataTables-example').dataTable({
			  "bSort" : false
			});
			
			$('#dataTables-customer').dataTable({
			  "bSort" : false,
			   "searching": false,
			   "bLengthChange": false
			});
         });
    </script>
<table class="table table-striped table-bordered table-hover text-left" id="dataTables-customer" style="font-size:12px;">
	<thead>
		<tr class="bg-primary">
			<th width="5%">No</th>
			<th width="20%">Group Name</th>
			<th width="25%">Address</th>
			<th width="20%">City/Regency</th>
			<th width="15%">Province</th>
			<th width="15%">Action</th>
		</tr>
	</thead>
	<tbody>
	<?php $num = 0;
	foreach ($CustomerGroup as $CustomerGroup_item): 
	$encrypted_string = $this->encrypt->encode($CustomerGroup_item['customer_group_id']);
	$encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
	$num++;
	?>
		<tr>
			<td align="center"><?php echo $num?></td>
			<td><?php echo $CustomerGroup_item['customer_group_name'] ?></td>
			<td><?php echo $CustomerGroup_item['address'] ?></td>
			<td><?php echo strtoupper($CustomerGroup_item['city_regency']) ?></td>
			<td><?php echo strtoupper($CustomerGroup_item['province'])?></td>
			<td align="center">
				<a href="<?php echo site_url('CustomerRelationship/CustomerGroup/'.$encrypted_string) ?>">
				<img src="<?php echo base_url('assets/img/detail.png');?>" title="Details">
				</a>
			</td>
		</tr>
	<?php endforeach ?>
	</tbody>
</table>