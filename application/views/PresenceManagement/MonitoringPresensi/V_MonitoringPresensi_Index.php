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
								<table class="table table-bordered" id="PresenceManagement-daftarPerangkat">
									<thead>
										<tr>
											<th class="text-center">No.</th>
											<th class="text-center">Device IP Address</th>
											<th class="text-center">Device S/N</th>
											<th class="text-center">Device Name</th>
											<th class="text-center">Lokasi Kerja</th>
											<th class="text-center">Status Koneksi</th>
											<th class="text-center">Action</th>

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
											<td class="text-center"><?php echo $device['device_ip'].':'.$device['device_port'];?></td>
											<td><?php echo $device['device_sn'];?></td>
											<td><?php echo $device['device_name'];?></td>
											<td><?php echo $device['lokasi_kerja'];?></td>
											<td><?php $output= array();exec("ping -c 1 ".$device['device_ip']." && exit",$output,$returnval);if($returnval != 0){echo "<label class='label label-danger'>Tidak Terhubung</label>";}else{ if(count(preg_grep("/Destination host unreachable/i", $output)) == 0){echo "<label class='label label-success'>Terhubung</label>";}else{ echo "<label class='label label-danger'>Tidak Terhubung</label>";}}
											?></td>
											<td class="text-center">
												<a type="button" class="btn btn-info btn-sm" href="<?php echo base_url('PresenceManagement/MonitoringPresensi/device_user_list'.'/'.$encrypted_string);?>" data-toggle="tooltip" title="User List">
													<i class="fa fa-users"></i>
												</a>
												<a type="button" class="btn btn-success btn-sm" href="<?php echo base_url('PresenceManagement/MonitoringPresensi/time_sync'.'/'.$encrypted_string);?>" data-toggle="tooltip" title="Time Syncronization">
													<i class="fa fa-clock-o"></i>
												</a>
												<a type="button" href="<?php echo site_url('PresenceManagement/MonitoringPresensi/finger_data_get'.'/'.$encrypted_string) ?>" class="btn btn-success btn-sm" data-toggle="tooltip" alt="Get Finger Data From This Device" title="Get Finger Data From This Device" >
				                                    <i class="fa fa-cloud-download"></i> <i class="fa fa-hand-pointer-o"></i>
				                                </a>
				                                <a type="button" href="<?php echo site_url('PresenceManagement/MonitoringPresensi/get_scanlog'.'/'.$encrypted_string) ?>" class="btn btn-success btn-sm" data-toggle="tooltip" alt="Get Scanlog" title="Get Scanlog" >
				                                    <i class="fa fa-cloud-download"></i> <i class="fa fa-database"></i>
				                                </a>
											</td>
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