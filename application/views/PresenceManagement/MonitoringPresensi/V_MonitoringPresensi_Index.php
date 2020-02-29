<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11">
							<div class="text-right">
								<h1><b><?php echo $Title;?></b></h1>
							</div>
						</div>
						<div class="col-lg-1">
							<div class="text-right hidden-md hidden-sm hidden-xs">
								<a class="btn btn-default btn-lg" href="<?php echo site_url('PresenceManagement/MonitoringPresensi');?>">
									<i class="icon-wrench icon-2x"></i>
								</a>
							</div>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header with-border">
								<h3 class="box-title">Device List</h3>
							</div>
							<div class="box-body">
								<div>
									show column :
									<a class="toggle-vis btn btn-primary btn-sm" data-column="0">No.</a>
									<a class="toggle-vis btn btn-primary btn-sm" data-column="1">Action</a>
									<a class="toggle-vis btn btn-primary btn-sm" data-column="2">ID Lokasi</a>
									<a class="toggle-vis btn btn-primary btn-sm" data-column="3">Server IP Address</a>
									<a class="toggle-vis btn btn-primary btn-sm" data-column="4">Device IP Address</a>
									<a class="toggle-vis btn btn-primary btn-sm" data-column="5">Device S/N</a>
									<a class="toggle-vis btn btn-primary btn-sm" data-column="6">Device Name</a>
									<a class="toggle-vis btn btn-primary btn-sm" data-column="7">Lokasi</a>
									<a class="toggle-vis btn btn-primary btn-sm" data-column="8">Voip</a>
									<a class="toggle-vis btn btn-primary btn-sm" data-column="9">Status Ping</a>
									<a class="toggle-vis btn btn-primary btn-sm" data-column="10">Frontpresensi</a>
									<a class="toggle-vis btn btn-primary btn-sm" data-column="11">Catering</a>
									<a class="toggle-vis btn btn-primary btn-sm" data-column="12">Status Catering</a>
								</div>
								<br>
								<table class="table table-bordered" id="PresenceManagement-daftarPerangkat">
									<thead>
										<tr>
											<th class="text-center">No.</th>
											<th class="text-center" style="width: 200px">Action</th>
											<th class="text-center">ID Lokasi</th>
											<th class="text-center">Server IP Address</th>
											<th class="text-center">Device IP Address</th>
											<th class="text-center">Device S/N</th>
											<th class="text-center">Device Name</th>
											<th class="text-center">Lokasi</th>
											<th class="text-center">Voip</th>
											<th class="text-center">Status Ping</th>
											<th class="text-center">Frontpresensi</th>
											<th class="text-center">Catering</th>
											<th class="text-center">Status Catering</th>

										</tr>
									</thead>
									<tbody>
										<?php
											$no 	=	1;
											foreach ($device_fingerprint as $device) 
											{
												$encrypted_string 	=	$this->general->enkripsi($device['id_lokasi']);
										?>
										<tr>
											<td class="text-center"><?php echo $no;?></td>

									<?php
											$time = date('H:i:s');
											$var = '';
												if ($time > '23:30:00' && $time < '23:40:00') {
													$var = '1';
												}elseif ($time > '23:10:00' && $time < '23:20:00') {
													$var = '1';
												} elseif ($time > '22:30:00' && $time < '22:40:00') {
													$var = '1';
												} elseif ($time > '21:00:00' && $time < '21:10:00') {
													$var = '1';
												} elseif ($time > '20:00:00' && $time < '20:10:00') {
													$var = '1';
												} elseif ($time > '19:26:00' && $time < '19:36:00') {
													$var = '1';
												} elseif ($time > '19:00:00' && $time < '19:10:00') {
													$var = '1';
												} elseif ($time > '14:41:00' && $time < '14:51:00') {
													$var = '1';
												} elseif ($time > '14:06:00' && $time < '14:16:00') {
													$var = '1';
												} elseif ($time > '12:26:00' && $time < '12:36:00') {
													$var = '1';
												} elseif ($time > '07:25:00' && $time < '08:00:00') {
													$var = '1';
												} elseif ($time > '06:26:00' && $time < '06:36:00') {
													$var = '1';
												} elseif ($time > '05:26:00' && $time < '05:36:00') {
													$var = '1';
												} else {
													$var = '2';
												}
												?>
										<?php $output= array();exec("ping -c 1 ".$device['device_ip']." && exit",$output,$returnval);
										if($returnval != 0){
											$label = "<label class='label label-danger'>Disconnected</label>";
											$dc = '1';
										}
										else{ 
											if(count(preg_grep("/Destination host unreachable/i", $output)) == 0){
												$label = "<label class='label label-success'>Connected</label>";
												$dc = '0';
												}
												else{ 
													$label = "<label class='label label-danger'>Disconnected</label>";
													$dc = '1';
													}
													} ?>

										<?php if ($var =='1' or $dc == '1'): ?>
											<td class="text-center">
												<a type="button" class="btn btn-info btn-sm disabled " href="<?php echo base_url('PresenceManagement/MonitoringPresensi/device_user_list'.'/'.$encrypted_string);?>" data-toggle="tooltip" title="User List" >
													<i class="fa fa-users"></i>
												</a>
												<a type="button" class="btn btn-success btn-sm  disabled" href="<?php echo base_url('PresenceManagement/MonitoringPresensi/time_sync'.'/'.$encrypted_string);?>" data-toggle="tooltip" title="Time Syncronization" disabled >
													<i class="fa fa-clock-o"></i>
												</a>
												<a type="button" href="<?php echo site_url('PresenceManagement/MonitoringPresensi/finger_data_get'.'/'.$encrypted_string) ?>" class="btn btn-success btn-sm  disabled" data-toggle="tooltip" alt="Get Finger Data From This Device" title="Get Finger Data From This Device" disabled >
				                                    <i class="fa fa-cloud-download"></i> <i class="fa fa-hand-pointer-o"></i>
				                                </a>
				                               <!-- <a type="button" target="_blank" href="<?php //echo site_url('PresenceManagement/MonitoringPresensi/get_scanlog'.'/'.$encrypted_string) ?>" class="btn btn-success btn-sm" data-toggle="tooltip" alt="Get Scanlog" title="Get Scanlog" >
				                                    <i class="fa fa-cloud-download"></i> <i class="fa fa-database"></i>
				                                </a> -->
											</td>
										<?php endif ?>
										<?php if ($var =='2' and $dc == '0'): ?>
											<td class="text-center">
												<a type="button" class="btn btn-info btn-sm" href="<?php echo base_url('PresenceManagement/MonitoringPresensi/device_user_list'.'/'.$encrypted_string);?>" data-toggle="tooltip" title="User List" >
													<i class="fa fa-users"></i>
												</a>
												<a type="button" class="btn btn-success btn-sm" href="<?php echo base_url('PresenceManagement/MonitoringPresensi/time_sync'.'/'.$encrypted_string);?>" data-toggle="tooltip" title="Time Syncronization">
													<i class="fa fa-clock-o"></i>
												</a>
												<a type="button" href="<?php echo site_url('PresenceManagement/MonitoringPresensi/finger_data_get'.'/'.$encrypted_string) ?>" class="btn btn-success btn-sm" data-toggle="tooltip" alt="Get Finger Data From This Device" title="Get Finger Data From This Device" >
				                                    <i class="fa fa-cloud-download"></i> <i class="fa fa-hand-pointer-o"></i>
				                                </a>
				                               <!-- <a type="button" target="_blank" href="<?php //echo site_url('PresenceManagement/MonitoringPresensi/get_scanlog'.'/'.$encrypted_string) ?>" class="btn btn-success btn-sm" data-toggle="tooltip" alt="Get Scanlog" title="Get Scanlog" >
				                                    <i class="fa fa-cloud-download"></i> <i class="fa fa-database"></i>
				                                </a> -->
											</td>
										<?php endif ?>
											<td><?php echo $device['id_lokasi'];?></td>
											<td><?php echo $device['server_ip'];?></td>
											<td class="text-center"><?php echo $device['device_ip'].':'.$device['device_port'];?></td>
											<td><?php echo $device['device_sn'];?></td>
											<td><?php echo $device['device_name'];?></td>
											<td><?php echo $device['lokasi_kerja'];?></td>
											<td><?php echo $device['voip'];?></td>
											<td>
											<?= $label; ?>
											</td>
											<td><?php echo $device['frontpresensi'] ?></td>
											<td><?php echo $device['catering'] ?></td>
											<td><?php echo $device['status'] ?></td>
										</tr>
										<?php
												$no++;
											}
										?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		$(document).ready(function(){
			setTimeout(function(){
				window.location.reload(true);
			},60000);
			
		});
	</script>  
</section>