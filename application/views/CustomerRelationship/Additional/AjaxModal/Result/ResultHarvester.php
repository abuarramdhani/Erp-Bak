<head>
<!-- GLOBAL SCRIPTS -->
    <!-- END GLOBAL SCRIPTS -->
	<script src="<?php echo base_url('assets/plugins/jquery-2.1.4.min.js');?>"></script>
    <script src="<?php echo base_url('assets/plugins/bootstrap/js/bootstrap.min.js');?>"></script>
    <script src="<?php echo base_url('assets/plugins/modernizr-2.6.2-respond-1.1.0.min.js');?>"></script>
	<!-- PAGE LEVEL SCRIPTS FOR DATATABLES-->
    <script src="<?php echo base_url('assets/plugins/dataTables/jquery.dataTables.js');?>"></script>
	<script src="<?php echo base_url('assets/plugins/dataTables/dataTables.bootstrap.js');?>"></script>
	<script>
	$(function () {
        $("#example1").dataTable({
			 "paging": true,
			  "lengthChange": false,
			  "lengthMenu": [[5, 25, 50, -1], [5, 25, 50, "All"]],
			  "searching": false,
			  "ordering": false,
			  "info": true,
			  "autoWidth": false
		});
		$( "#search" ).focus();
		
	});	
	</script>
</head>
<table class="table table-bordered table-hover" id="example1">
		<thead>
			<tr>
				<th width="5%">No</th>
				<th width="15%">Item Code</th>
				<th width="40%">Item Name</th>
				<th width="20%">Body Num.</th>
				<th width="20%">Engine Num.</th>
			</tr>
		</thead>
		<tbody>
			<?php 
			$num = 1;
			foreach($Item as $cs){
				if(date("Y-m-d H:i:s") <= $Ownership_item['warranty_expired_date']){
					$warranty = 'Y';
				}
				else{
					$warranty = 'N';
				};

?>
			?>
			<tr onclick="sendValueHarvester('<?php echo $cs['customer_ownership_id'];?>','<?php echo $cs['segment1'];?>','<?php echo $cs['item_name'];?>', '<?php echo $warranty; ?>','<?php echo $rowid; ?>')" data-dismiss="modal" style="cursor:hand;">
				<td align="center"><?php echo $num;?></td>
				<td><?php echo $cs['segment1'];?></td>
				<td><?php echo $cs['item_name'];?></td>
				<td><?php echo $cs['no_body'];?></td>
				<td><?php echo $cs['no_engine'];?></td>
			</tr>
			<?php
				$num++;
			}
			?>
		</tbody>
	</table>