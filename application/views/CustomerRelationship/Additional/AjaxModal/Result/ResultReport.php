<head>
	<script src="<?php echo base_url('assets/plugins/jquery-2.1.4.min.js');?>"></script>
    <script src="<?php echo base_url('assets/plugins/bootstrap/3.0.0/js/bootstrap.min.js');?>"></script>
    <script src="<?php echo base_url('assets/plugins/modernizr-2.6.2-respond-1.1.0.min.js');?>"></script>
	
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
		<thead class="bg-primary">
			<tr>
				<th width="5%">No</th>
				<th width="95%">Report Name</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$num = 1;
			foreach($Report as $cs){
			$link = $cs['report_link'];
			?>
			
			<tr onclick="location.href ='<?php echo site_url()."".$link;?>'" style="cursor:hand;">
				<td align="center"><?php echo $num;?></td>
				<td><?php echo "Report ".$cs['report_name'];?></td>
			</tr>
			<?php
				$num++;
			}
			?>
		</tbody>
	</table>
