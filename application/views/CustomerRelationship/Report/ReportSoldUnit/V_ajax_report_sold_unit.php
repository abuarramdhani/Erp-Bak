<?php
/*
echo $item_name."<br />";
echo $body_number."<br />";
echo $engine_number."<br />";
echo $district."<br />";
echo $city."<br />";
echo $province."<br />";
*/
?>
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
<button class="btn btn-app"><img src="<?php echo base_url('assets/img/export.png');?>"></button>
<table class="table table-striped table-bordered table-hover text-left" id="dataTables-customer" style="font-size:12px;">
	<thead>
		<tr>
			<th width="5%">No</th>
			<th width="15%">Item Name</th>
			<th width="10%">Body Number</th>
			<th width="10%">Engine Number</th>
			<th width="10%">Ownership Date</th>
			<th width="10%">District</th>
			<th width="10%">City</th>
			<th width="10%">Province</th>
			<th width="10%">Owner</th>
			<th width="10%">Buying Type</th>
		</tr> 
	</thead>
	<tbody>
	<?php
	$i = 1;
	foreach($soldunit as $su){
		if($su['ownership_date'] == null){
			$date = "";
		}else{
			$date = date_format(date_create($su['ownership_date']), 'd-M-Y');
		} 
	?>
		<tr>
			<td align="center"><?php echo $i;?></td>
			<td><?php echo $su['item_name'];?></td>
			<td><?php echo $su['no_body'];?></td>
			<td><?php echo $su['no_engine'];?></td>
			<td align="center"><?php echo $date;?></td>
			<td><?php echo $su['district'];?></td>
			<td><?php echo $su['city_regency'];?></td>
			<td><?php echo strtoupper($su['province']);?></td>
			<td><?php echo $su['customer_name'];?></td>
			<td align="center"><?php echo strtoupper($su['buying_type_name']);?></td>
		</tr>
	<?php
		$i++;
	}
	?>
	</tbody>
</table>