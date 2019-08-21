<section class="content">
	<div class="inner" >
			<div class="box box-header"  style="padding-left:20px">
				<h3 class="pull-left"><strong> Android Entry List </strong> - Android</h3>
			</div>
		</div>
		<div class="panel box-body" >
		<table id="ms_barang" class="table table-striped table-bordered table-responsive table-hover dataTable no-footer">
			<thead>
				<tr style="background-color:#367FA9; color:white ">
						<th class="text-center " style="width:15px">No</th>
						<th class="text-center ">Action</th>
						<th class="text-center ">Android ID</th>
						<th class="text-center ">IMEI</th>
						<th class="text-center ">Hardware Serial</th>
						<th class="text-center ">GSF</th>
						<th class="text-center ">Employee</th>
						<th class="text-center ">Validation</th>						
					</tr>
			</thead>
			<tbody>
			<?php
			$no = 0;
			foreach ($android as $key => $andro) {
			$no++;



			?>
			
					
					<td><?php echo $no ?></td>
					<td>
						<a href="<?php echo base_url('SystemAdministration/Android/edit/'.$andro['gadget_id']) ?>" class="btn btn-success">
						Edit
						</a>
						<span>    </span>

						<span>
						<a href="<?php echo base_url('SystemAdministration/Android/delete/'.$andro['gadget_id']) ?>" class="btn btn-danger">
						Delete
						</a>
						</span>

					</td>

					<td><?php echo $andro['android_id'] ?></td>
					<td><?php echo $andro['imei']?></td>
					<td><?php echo $andro['hardware_serial']?></td>
					<td><?php echo $andro['gsf']?></td>
					<td><?php echo $andro['info_1']?></td>
					<td>
						<?php
						if ($andro['validation'] ==0) {
							echo "New Entry";
						}
						elseif ($andro['validation'] ==1) {
							echo "Approved";
						}
						elseif ($andro['validation'] ==2)
						{
							echo "Rejected";
						}
						?>	
					</td>
											
					
					
			</tbody>

			<?php } ?>
		</table>
		</div>
	</div>
</section>