<head>
<!-- GLOBAL SCRIPTS -->
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
				<th width="20%">Additional Name</th>
				<th width="75%">Description</th>
			</tr>
		</thead>
		<tbody>
			<?php 
			$num = 1;
			foreach($AdditionalInfo as $cs){
			?>
			<tr onclick="sendValueAdditionalInfo('<?php echo $cs['additional_id'];?>','<?php echo $cs['additional_name'];?>','<?php echo $cs['additional_description'];?>')" data-dismiss="modal" style="cursor:hand;">
				<td align="center"><?php echo $num;?></td>
				<td><?php echo $cs['additional_name'];?></td>
				<td><?php echo $cs['additional_description'];?></td>
			</tr>
			<?php
				$num++;
			}
			?>
		</tbody>
	</table>