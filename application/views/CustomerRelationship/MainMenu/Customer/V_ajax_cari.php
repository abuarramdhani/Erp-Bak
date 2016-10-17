<?php
//echo $category;
?>
<!-- PAGE LEVEL SCRIPTS FOR DATATABLES-->
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
		<tr  class="bg-primary">
			<th width="5%">No</th>
			<th width="20%">Name</th>
			<th width="25%">Address</th>
			<th width="20%">City/Regency</th>
			<th width="20%">Province</th>
			<th width="10%">Action</th>
		</tr>
	</thead>
	<tbody>
	<?php $num = 0;
		foreach ($Customer as $Customer_item): 
		$num++;
		$encrypted_string = $this->encrypt->encode($Customer_item['customer_id']);
		$encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
	?>
		<tr>
			<td><?php echo $num?></td>
			<td><?php echo $Customer_item['customer_name'] ?></td>
			<td><?php echo $Customer_item['address'] ?></td>
			<td><?php echo $Customer_item['city_regency'] ?></td>
			<td><?php echo $Customer_item['province'] ?></td>
			<td align="center">
				<a href="<?php echo site_url('CustomerRelationship/Customer/Details')."/".$encrypted_string ?>"><img src="<?php echo base_url('assets/img/detail.png');?>" title="Details"></a>
				<!--
				<a href="<?php echo site_url('CustomerRelationship/Customer/Update/')."/".$encrypted_string ?>"><img src="<?php echo base_url('assets/img/edit.png');?>" title="Update"></a>
				-->
			</td>
		</tr>
	<?php endforeach ?>

	</tbody>
</table>