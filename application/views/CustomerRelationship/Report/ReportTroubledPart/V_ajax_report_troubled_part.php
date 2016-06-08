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
			<th width="13%">Part Code</th>
			<th width="17%">Part Name</th>
			<th width="25%">Unit Name</th>
			<th width="10%">Body Number</th>
			<th width="10%">Problem Category</th>
			<th width="10%">Action Date</th>
			<th width="10%">Finish Date</th>
			
		</tr>
	</thead>
	<tbody>
	<?php
	$i = 1;
	foreach($troubledPart as $tp){
		if($tp['finish_date'] == null){
			$date = "";
		}else{
			$date = date_format(date_create($tp['finish_date']), 'd-M-Y');
		}
		if($tp['action_date'] == null){
			$date2 = "";
		}else{
			$date2 = date_format(date_create($tp['action_date']), 'd-M-Y');
		}
	?>
		<tr>
			<td align="center"><?php echo $i;?></td>
			<td><?php echo $tp['spare_part'];?></td>
			<td><?php echo $tp['spare_part_name'];?></td>
			<td><?php echo $tp['item_name'];?></td>
			<td><?php echo $tp['no_body'];?></td>
			<td></td>
			<td align="center"><?php echo $date2;?></td>
			<td align="center"><?php echo $date;?></td>
		</tr>
	<?php
		$i++;
	}
	?>
	</tbody>
</table>