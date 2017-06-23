<?php
/*
echo $service_number."<br />";
echo $name."<br />";
echo $activity."<br />";
echo $method."<br />";
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
<table class="table table-striped table-bordered table-hover text-center" id="dataTables-customer" style="font-size:12px;">
	<thead>
		<tr class="bg-primary">
			<th width="5%"><center>No</center></th>
			<th width="15%"><center>Activity Number</center></th>
			<th width="15%"><center>Activity Type</center></th>
			<th width="15%"><center>Customer</center></th>
			<th width="15%"><center>Province/City</center></th>
			<th width="15%"><center>Contact</center></th>
			<th width="15%"><center>Status</center></th>
			<th width="5%"><center>Action</center></th>
		</tr>
	</thead>
	<tbody>
	<?php 
	$num = 0;
	foreach ($Activity as $Activity_item): 
	$num++;
	$encrypted_string = $this->encrypt->encode($Activity_item['service_product_id']);
	$encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
	$link_connect = site_url('CustomerRelationship/ServiceProducts/UpdateConnect/')."/".$encrypted_string;
	$link_service = site_url('CustomerRelationship/ServiceProducts/Update/')."/".$encrypted_string;
	?>
		<tr>
			<td><?php echo $num?>
			</td>
			<td align="left"><?php echo $Activity_item['service_number'] ?>
			</td>
			<td align="middle">
			<?php if($Activity_item['service_type'] == 'service_keliling'){
												echo "Service Keliling";
												$link = $link_service;
											}
											elseif($Activity_item['service_type'] == 'customer_visit'){
												echo "Customer Visit";
												$link = $link_service;
											}
											elseif($Activity_item['service_type'] == 'visit_us'){
												echo "Visit Us";
												$link = $link_service;
											}
											elseif($Activity_item['service_type'] == 'kirim_part'){
												echo "Kirim Part";
												$link = $link_service;
											}
											elseif($Activity_item['service_type'] == 'call_in'){
												echo "Call In";
												$link = $link_connect;
											}
											elseif($Activity_item['service_type'] == 'call_out'){
												echo "Call Out";
												$link = $link_connect;
											}
											elseif($Activity_item['service_type'] == 'social'){
												echo "Social Media";
												$link = $link_connect;
											}
											elseif($Activity_item['service_type'] == 'email'){
												echo "Email";
												$link = $link_connect;
											};
										?>
			</td>
			<td align="left"><?php echo strtoupper($Activity_item['customer_name']) ?></td>
			<td align="left"><?php echo strtoupper($Activity_item['province']).", ".strtoupper($Activity_item['city_regency']) ?></td>
			<td align="left"><?php echo $Activity_item['contact_number'] ?></td>
			<td align="left"><?php echo $Activity_item['service_status'] ?></td>
			</td>
			<td>
				<a href="<?php echo $link; ?>" alt="Update" title="Update">
				<img src="<?php echo base_url('assets/img/edit.png');?>" title="Update">
				</a>
			</td>
		</tr>
	<?php endforeach ?>
	</tbody>
</table>