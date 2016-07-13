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
          "destroy": true,
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
				<th width="95%">Customer Group Name</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$num = 1;
			foreach($CustomerGroup as $cs){
			?>
			<tr onclick="sendValueCustomerGroup('<?php echo $cs['customer_group_id'];?>','<?php echo $cs['customer_group_name'];?>')" data-dismiss="modal" style="cursor:hand;">
				<td align="center"><?php echo $num;?></td>
				<td><?php echo $cs['customer_group_name'];?></td>
			</tr>
			<?php
				$num++;
			}
			?>
		</tbody>
	</table>
