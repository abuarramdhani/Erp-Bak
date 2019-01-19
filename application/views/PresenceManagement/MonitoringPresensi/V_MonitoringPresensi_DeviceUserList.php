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
				<?php
					$device_sn 		=	'';
					$lokasi_kerja 	=	'';
					$device_name 	=	'';
					$id_lokasi 		=	'';
					foreach ($device_fingerprint as $device)
					{
						$device_sn 		=	$device['device_sn'];
						$lokasi_kerja 	=	$device['lokasi_kerja'];
						$device_name 	=	$device['device_name'];
						$id_lokasi 		=	$device['id_lokasi'];
					}
				?>
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header with-border">
								<h3 class="box-title">Device List</h3>
                                <a style="float:right;margin-right:1%;margin-top:-0.5%; vertical-align: middle;" alt="Add User Access" title="Add User Access" onclick="PresenceManagement_user_register(<?php echo "'".$id_lokasi."'";?>)">
                                    <button type="button" class="btn btn-warning btn-sm" ><i class="fa fa-user-plus fa-2x"></i></button>
                                </a>
							</div>
							<div class="box-body">
								<table class="table">
									<tr>
										<th class="text-right">Device S/N</th>
										<td>     :     </td>
										<td><?php echo $device_sn;?></td>
									</tr>
									<tr>
										<th class="text-right">Lokasi Kerja</th>
										<td>     :     </td>
										<td><?php echo $lokasi_kerja;?></td>
									</tr>
									<tr>
										<th class="text-right">Nama</th>
										<td>     :     </td>
										<td><?php echo $device_name;?></td>
									</tr>
								</table>
								<br/>
								<table class="table table-bordered" id="PresenceManagement-daftarAksesUser">
									<thead>
										<tr>
											<th class="text-center" style="width: 5%">No.</th>
											<th class="text-center" style="width: 5%">Noind Baru</th>
											<th class="text-center" style="width: 5%">Noind</th>
											<th class="text-center" style="width: 20%">Nama</th>
											<th class="text-center" style="width: 10%">Kodesie</th>
											<th class="text-center" style="width: 20%">Seksi</th>
											<th class="text-center" style="width: 5%">Keluar</th>
											<th class="text-center" style="width: 10%">Lokasi Kerja</th>
											<th class="text-center" style="width: 10%">Action</th>
										</tr>
									</thead>
									<tbody>
										<?php
											$no 	=	1;
											foreach ($device_user_list as $user_access) 
											{
												$encrypted_string 	=	$this->general->enkripsi($user_access['id_user_access']);
										?>
										<tr>
											<td class="text-center"><?php echo $no;?></td>
											<td class="text-center"><?php echo $user_access['noind_baru'];?></td>
											<td><?php echo $user_access['noind'];?></td>
											<td><?php echo $user_access['nama'];?></td>
											<td><?php echo $user_access['kodesie'];?></td>
											<td><?php echo $user_access['seksi'];?></td>
											<td><?php echo $user_access['keluar'];?></td>
											<td><?php echo $user_access['nama_lokasi_kerja'];?></td>
											<td class="text-center">
												<a type="button" class="btn btn-success btn-sm" href="<?php echo base_url('PresenceManagement/MonitoringPresensi/device_user_list'.'/'.$encrypted_string);?>" data-toggle="tooltip" title="Finger List">
													<i class="fa fa-hand-pointer-o"></i>
												</a>
												<a type="button" class="btn btn-danger btn-sm" href="<?php echo base_url('PresenceManagement/MonitoringPresensi/device_user_delete'.'/'.$encrypted_string);?>" data-toggle="tooltip" title="Delete User From This Device" onclick="return confirm('Apakah Anda ingin menghapus akses presensi <?php echo $user_access['nama'].' ('.$user_access['noind'].')';?> di lokasi ini?');">
													<i class="fa fa-times"></i>
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

	<form class="form-horizontal" method="post" action="<?php echo base_url('PresenceManagement/MonitoringPresensi/user_register');?>" enctype="multipart/form-data">
		<div id="userRegister" class="modal fade" role="dialog">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Register User</h4>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<label for="PresenceManagement-MonitoringPresensi-DeviceUserList-txtIDLokasi" class="control-label col-lg-4">ID Lokasi</label>
							<div class="col-lg-4">
								<input type="text" class="form-control" id="PresenceManagement-MonitoringPresensi-DeviceUserList-txtIDLokasi" name="txtIDLokasi" readonly="" />
							</div>
						</div>
						<div class="form-group">
							<label for="PresenceManagement-MonitoringPresensi-DeviceUserList-cmbUserRegistered" class="control-label col-lg-4">
								User<br/>
								
							</label>
							<div class="col-lg-6">
								<select style="width: 100%" name="cmbUserRegistered[]" id="PresenceManagement-MonitoringPresensi-DeviceUserList-cmbUserRegistered" multiple="multiple">
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="PresenceManagement-MonitoringPresensi-DeviceUserList-cmbJariRef" class="control-label col-lg-4">Jari</label>
							<div class="col-lg-6">
								<select style="width: 100%" name="cmbJariRef[]" id="PresenceManagement-MonitoringPresensi-DeviceUserList-cmbJariRef" multiple="multiple">
								</select>
							</div>
							<div class="col-lg-2">
								<h6 class="text-orange">Kosongkan jika menggunakan default, hanya mendaftarkan jari jika data tersedia</h6>
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
</section>