	<section class="content">
	<div class="inner" >
			<div class="box box-header"  style="padding-left:20px;padding-right: 20px;">
				<h3 class="pull-left"><strong> Android Approve List </strong> - Android</h3>
			</div>
	</div>
		<div class="panel box-body" >
			<div class="table-responsive">
				<table id="tableAndroidApproval" class="table table-striped table-bordered table-hover">
					<thead>
						<tr style="background-color:#367FA9; color:white ">
							<th class="text-center " style="width:15px">No</th>
							<th data-sortable="false" class="text-center ">Action</th>
							<th class="text-center ">Android ID</th>
							<th class="text-center ">IMEI</th>
							<th class="text-center ">Hardware Serial</th>
							<th class="text-center ">GSF</th>
							<th class="text-center ">Employee</th>
							<th class="text-center ">Status</th>						
						</tr>
					</thead>
					<tbody>
						<?php 
							if(isset($data) and !empty($data)){
								$nomor = 1;
								foreach ($data as $key) {
									?>
										<tr>
											<td><?=$nomor ?></td>
											<td style="text-align: center">
												<a href="<?php echo base_url('SystemAdministration/Android/ApproveAtasan/edit/'.$key['gadget_id']) ?>">
													<span class="fa fa-search"></span>
												</a>
											</td>
											<td><?=$key['android_id'] ?></td>
											<td><?=$key['imei'] ?></td>
											<td><?=$key['hardware_serial'] ?></td>
											<td><?=$key['gsf'] ?></td>
											<td><?=$key['info_1'] ?></td>
											<td><?=$key['status_approve'] ?></td>
										</tr>
									<?php 
									$nomor++;
								}
							}
						?>
					</tbody>
				</table>
			</div>
		</div>
</section>

