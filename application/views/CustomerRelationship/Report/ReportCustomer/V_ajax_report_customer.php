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
<?php 
/*
echo $name."<br />";
echo $district."<br />";
echo $city."<br />";
*/
//echo $province."<br />";
//echo $job."<br />";
//echo $category."<br />";

?>
<button class="btn btn-app"><img src="<?php echo base_url('assets/img/export.png');?>"></button>
<table class="table table-striped table-bordered table-hover text-left" id="dataTables-customer" style="font-size:12px;">
	<thead>
		<tr>
			<th width="5%">No</th>
			<th width="20%">Name</th>
			<th width="15%">Address</th>
			<th width="10%">District</th>
			<th width="10%">City/Regency</th>
			<th width="10%">Province</th>
			<th width="10%">Additional Info</th>
			<th width="10%">Category</th>
			<th width="10%">Contact</th>
		</tr>
	</thead>
	<tbody>
	<?php
	$i = 1;
	foreach($customer as $cs){
		$ct = $cs['contact'];
		if($ct == ""){
			$ct = "no contact info";
		}
		
	?>
		<tr>
			<td align="center"><?php echo $i;?></td>
			<td><?php echo $cs['customer_name'];?></td>
			<td><?php echo $cs['address'];?></td>
			<td><?php echo $cs['district'];?></td>
			<td><?php echo $cs['city_regency'];?></td>
			<td><?php echo strtoupper($cs['province']);?></td>
			<td><?php echo $cs['additional_info'];?></td>
			<td><?php echo $cs['customer_category_name'];?></td>
			<td align="center"><?php echo $ct;?></td>
		</tr>
	<?php
		$i++;
	}
	?>
	</tbody>
</table>