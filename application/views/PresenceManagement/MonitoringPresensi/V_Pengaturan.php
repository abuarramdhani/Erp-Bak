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
								<a class="btn btn-default btn-lg" href="<?php echo site_url('PresenceManagement/MonitoringPresensiPengaturan');?>">
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
								<a style="float:right;margin-right:1%;margin-top:-0.5%; vertical-align: middle;" alt="Add Device" title="Add Device" >
                                    <button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#deviceCreate"><i class="fa fa-desktop fa-2x"></i> <i class="icon-plus icon-2x"></i></button>
                                </a>
							</div>
							<div class="box-body">
								<table class="table table-bordered" id="PresenceManagement-daftarPerangkat">
									<thead>
										<tr>
											<th class="text-center">No.</th>
											<th class="text-center">Action</th>
											<th class="text-center">SDK Server IP</th>
											<th class="text-center">Device S/N</th>
											<th class="text-center">Device IP</th>
											<th class="text-center">Inisial</th>
											<th class="text-center">ID Lokasi</th>
											<th class="text-center">Lokasi Kerja</th>

										</tr>
									</thead>
									<tbody>
										<?php
											$no 	=	1;
											foreach ($device_fingerprint as $device) 
											{
												$encrypted_string 	=	$this->general->enkripsi($device['device_sn']);
										?>
										<tr>
											<td class="text-center"><?php echo $no;?></td>
											<td class="text-center">
												<a 	style="margin-right:4px"
													onclick="PresenceManagement_device_update(
													<?php echo "'".$device['server_ip']."'";?>,
													<?php echo "'".$device['server_port']."'";?>,
													<?php echo "'".$device['device_sn']."'";?>,
													<?php echo "'".$device['device_ip']."'";?>,
													<?php echo "'".$device['device_port']."'";?>,
													<?php echo "'".$device['inisial_lokasi']."'";?>,
													<?php echo "'".$device['id_lokasi']."'";?>,
													<?php echo "'".$device['office']."'";?>,
													<?php echo "'".$device['lokasi_kerja']."'";?>
													)"
													data-placement="bottom" title="Edit Format">
													<span class="fa fa-pencil-square-o fa-2x"></span>
												</a>
											</td>
											<td><?php echo $device['server_ip'].':'.$device['server_port'];?></td>
											<td><?php echo $device['device_sn'];?></td>
											<td><?php echo $device['device_ip'].':'.$device['device_port'];?></td>
											<td><?php echo $device['inisial_lokasi'];?></td>
											<td><?php echo $device['id_lokasi'];?></td>
											<td><?php echo $device['office'];?></td>
										</tr>
										<?php
												$no++;
											}
										?>
									</tbody>
								</table>
							</div>
						</div>

						<div class="box box-primary box-solid">
							<div class="box-header with-border">
								<h3 class="box-title">User List</h3>
								<!-- <a style="float:right;margin-right:1%;margin-top:-0.5%; vertical-align: middle;" alt="Add User" title="Add User" >
                                    <button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#userCreate"><i class="fa fa-users fa-2x"></i> <i class="icon-plus icon-2x"></i></button>
                                </a> -->
                                <a href="<?php echo site_url('PresenceManagement/MonitoringPresensiPengaturan/CronUser') ?>" target="_blank" class="btn btn-primary pull-right"><i class="fa fa-users fa-2x"></i> <i class="icon-plus icon-2x"></i></a>
							</div>
							<div class="box-body">
								<table class="table table-bordered" id="PresenceManagement-daftarUser-ServerSide">
									<thead>
										<tr>
											<th class="text-center">No.</th>
											<th class="text-center">Noind Baru</th>
											<th class="text-center">Noind</th>
											<th class="text-center">Nama</th>
										</tr>
									</thead>
									<tbody>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<form class="form-horizontal" method="post" action="<?php echo base_url('PresenceManagement/MonitoringPresensiPengaturan/device_create');?>" enctype="multipart/form-data">
		<div id="deviceCreate" class="modal fade" role="dialog">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Add Device</h4>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<label for="PresenceManagement-MonitoringPresensi-Pengaturan-txtIPServerSDK" class="control-label col-lg-4">Server SDK IP</label>
							<div class="col-lg-4">
								<input type="text" class="form-control" id="PresenceManagement-MonitoringPresensi-Pengaturan-txtIPServerSDK" name="txtIPServerSDK" placeholder="(ex. 192.168.255.255)" />
							</div>
						</div>
						<div class="form-group">
							<label for="PresenceManagement-MonitoringPresensi-Pengaturan-txtPortServerSDK" class="control-label col-lg-4">Server SDK Port</label>
							<div class="col-lg-4">
								<input type="number" class="form-control" id="PresenceManagement-MonitoringPresensi-Pengaturan-txtPortServerSDK" name="txtPortServerSDK" value="8080" />
							</div>
						</div>
						<div class="form-group">
							<label for="PresenceManagement-MonitoringPresensi-Pengaturan-txtDeviceSN" class="control-label col-lg-4">Device S/N</label>
							<div class="col-lg-4">
								<input type="text" class="form-control" id="PresenceManagement-MonitoringPresensi-Pengaturan-txtDeviceSN" name="txtDeviceSN" />
							</div>
						</div>
						<div class="form-group">
							<label for="PresenceManagement-MonitoringPresensi-Pengaturan-txtIPDevice" class="control-label col-lg-4">Device IP</label>
							<div class="col-lg-4">
								<input type="text" class="form-control" id="PresenceManagement-MonitoringPresensi-Pengaturan-txtIPDevice" name="txtIPDevice" placeholder="(ex. 192.168.255.255)" />
							</div>
						</div>
						<div class="form-group">
							<label for="PresenceManagement-MonitoringPresensi-Pengaturan-txtPortDevice" class="control-label col-lg-4">Device Port</label>
							<div class="col-lg-4">
								<input type="number" class="form-control" id="PresenceManagement-MonitoringPresensi-Pengaturan-txtPortDevice" name="txtPortDevice" value="5005" />
							</div>
						</div>
						<div class="form-group">
							<label for="PresenceManagement-MonitoringPresensi-Pengaturan-txtInisialLokasi" class="control-label col-lg-4">Inisial Lokasi</label>
							<div class="col-lg-4">
								<input type="text" class="form-control" id="PresenceManagement-MonitoringPresensi-Pengaturan-txtInisialLokasi" name="txtInisialLokasi" maxlength="5" />
							</div>
						</div>
						<div class="form-group">
							<label for="PresenceManagement-MonitoringPresensi-Pengaturan-cmbLokasiKerja" class="control-label col-lg-4">Lokasi Kerja</label>
							<div class="col-lg-4">
								<select style="width: 100%" name="cmbLokasiKerja" id="PresenceManagement-MonitoringPresensi-Pengaturan-cmbLokasiKerja">
								</select>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-success">Proceed</button>
						<button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>
					</div>
				</div>
			</div>
		</div>
	</form>

	<form class="form-horizontal" method="post" action="<?php echo base_url('PresenceManagement/MonitoringPresensiPengaturan/device_update');?>" enctype="multipart/form-data">
		<div id="deviceUpdate" class="modal fade" role="dialog">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Update Device</h4>
					</div>
					<div class="modal-body">
						<div class="form-group hidden">
							<label for="PresenceManagement-MonitoringPresensi-PengaturanEdit-txtIDLokasi" class="control-label col-lg-4">ID Lokasi</label>
							<div class="col-lg-4">
								<input type="text" class="form-control" id="PresenceManagement-MonitoringPresensi-PengaturanEdit-txtIDLokasi" name="txtIDLokasi" readonly="" />
							</div>
						</div>
						<div class="form-group">
							<label for="PresenceManagement-MonitoringPresensi-PengaturanEdit-txtIPServerSDK" class="control-label col-lg-4">Server SDK IP</label>
							<div class="col-lg-4">
								<input type="text" class="form-control" id="PresenceManagement-MonitoringPresensi-PengaturanEdit-txtIPServerSDK" name="txtIPServerSDK" placeholder="(ex. 192.168.255.255)" />
							</div>
						</div>
						<div class="form-group">
							<label for="PresenceManagement-MonitoringPresensi-PengaturanEdit-txtPortServerSDK" class="control-label col-lg-4">Server SDK Port</label>
							<div class="col-lg-4">
								<input type="number" class="form-control" id="PresenceManagement-MonitoringPresensi-PengaturanEdit-txtPortServerSDK" name="txtPortServerSDK" value="8080" />
							</div>
						</div>
						<div class="form-group">
							<label for="PresenceManagement-MonitoringPresensi-PengaturanEdit-txtDeviceSN" class="control-label col-lg-4">Device S/N</label>
							<div class="col-lg-4">
								<input type="text" class="form-control" id="PresenceManagement-MonitoringPresensi-PengaturanEdit-txtDeviceSN" name="txtDeviceSN" />
							</div>
						</div>
						<div class="form-group">
							<label for="PresenceManagement-MonitoringPresensi-PengaturanEdit-txtIPDevice" class="control-label col-lg-4">Device IP</label>
							<div class="col-lg-4">
								<input type="text" class="form-control" id="PresenceManagement-MonitoringPresensi-PengaturanEdit-txtIPDevice" name="txtIPDevice" placeholder="(ex. 192.168.255.255)" />
							</div>
						</div>
						<div class="form-group">
							<label for="PresenceManagement-MonitoringPresensi-PengaturanEdit-txtPortDevice" class="control-label col-lg-4">Device Port</label>
							<div class="col-lg-4">
								<input type="number" class="form-control" id="PresenceManagement-MonitoringPresensi-PengaturanEdit-txtPortDevice" name="txtPortDevice" value="5005" />
							</div>
						</div>
						<div class="form-group">
							<label for="PresenceManagement-MonitoringPresensi-PengaturanEdit-txtInisialLokasi" class="control-label col-lg-4">Inisial Lokasi</label>
							<div class="col-lg-4">
								<input type="text" class="form-control" id="PresenceManagement-MonitoringPresensi-PengaturanEdit-txtInisialLokasi" name="txtInisialLokasi" maxlength="5" />
							</div>
						</div>
						<div class="form-group">
							<label for="PresenceManagement-MonitoringPresensi-PengaturanEdit-cmbLokasiKerja" class="control-label col-lg-4">Lokasi Kerja</label>
							<div class="col-lg-4">
								<select style="width: 100%" name="cmbLokasiKerja" id="PresenceManagement-MonitoringPresensi-PengaturanEdit-cmbLokasiKerja">
								</select>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-success">Proceed</button>
						<button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>
					</div>
				</div>
			</div>
		</div>
	</form>

	<form class="form-horizontal" method="post" action="<?php echo base_url('PresenceManagement/MonitoringPresensiPengaturan/user_create');?>" enctype="multipart/form-data">
		<div id="userCreate" class="modal fade" role="dialog">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Add User</h4>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<label for="PresenceManagement-MonitoringPresensi-Pengaturan-cmbPekerja" class="control-label col-lg-4">User</label>
							<div class="col-lg-6">
								<select style="width: 100%" name="cmbPekerja" id="PresenceManagement-MonitoringPresensi-Pengaturan-cmbPekerja" required>
								</select>
							</div>
						</div>
						<div class="form-group">
							<div class="col-lg-4"></div>
							<label id="PresenceManagement-MonitoringPresensi-Pengaturan-labelStatusUser" class="control-label col-lg-4"></label>
						</div>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-success" id="PresenceManagement-MonitoringPresensi-Pengaturan-btnProceed">Proceed</button>
						<button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>
					</div>
				</div>
			</div>
		</div>
	</form>
</section>

