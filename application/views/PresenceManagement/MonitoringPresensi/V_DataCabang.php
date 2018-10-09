<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11">
							<div class="text-right">
								<h1><b><?=$Title ?></b></h1>
							</div>
						</div>
						<div class="col-lg-1">
							<div class="text-right hidden-md hidden-sm hidden-xs">
								<a href="<?php echo site_url('PresenceManagement/CekData') ?>" class="btn btn-default btn-lg">
									<i class="icon-wrench icon-2x"></i>
								</a>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header">
								<div class="row">
									<div class="col-lg-12">
										<form class="form-horizontal" method="post" action="<?php echo site_url('PresenceManagement/CekData') ?>">
											<div class="form-group" style="margin-bottom: 0px;">
												<label class="control-label col-lg-4">Pilih Cabang</label>
												<div class="col-lg-4">
													<select class="select select2" name="txtCabangCekData" data-placeholder="Pilih Cabang" style="width: 100%">
														<option></option>
														<?php foreach ($Cabang as $key) { ?>
															<option value="<?php echo $key['id_'] ?>" <?php if (isset($kd)){if ($kd == $key['id_']) {echo "selected";}} ?>><?php echo $key['id_']." - ".$key['lokasi_kerja'] ?></option>
														<?php } ?>
													</select>
												</div>
												<div class="col-lg-4">
													<button class="btn btn-info" type="submit">Proses</button>
												</div>
											</div>
										</form>
									</div>
								</div>
							</div>
							<div class="box-body">
								<?php if (isset($pembanding)) {
									foreach ($pembanding as $value) { ?>
										<div class="row">
											<div class="col-lg-12">
												<form class="form-horizontal">
													<div class="form-group text-center">
														<div class="col-lg-4"></div>
														<div class="col-lg-2">
															<label class="form-label">Lama</label>
														</div>
														<div class="col-lg-2">
															<label class="form-label">baru</label>
														</div>
													</div><div class="form-group <?php if($value['pekerja_utama']==$value['pekerja_banding']){echo 'has-success has-feedback';}else{echo 'has-error has-feedback';} ?>">
														<label class="control-label col-lg-4">Pekerja Terdaftar</label>
														<div class="col-lg-2">
															<input type="text" name="" value="<?php echo $value['pekerja_utama'] ?>" class="form-control" disabled>
														</div>
														<div class="col-lg-2">
															<input type="text" name="" value="<?php echo $value['pekerja_banding'] ?>" class="form-control" disabled>
															<?php if($value['pekerja_utama']==$value['pekerja_banding']) { ?>
																<span class="glyphicon glyphicon-ok form-control-feedback"></span>
															 <?php }else{ ?> 
															 	<span class="glyphicon glyphicon-remove form-control-feedback"></span>
															 <?php }?>
														</div>
													</div>
													<div class="form-group <?php if($value['finger_utama']==$value['finger_banding']){echo 'has-success has-feedback';}else{echo 'has-error has-feedback';} ?>">
														<label class="control-label col-lg-4">Finger Terdaftar</label>
														<div class="col-lg-2">
															<input type="text" name="" value="<?php echo $value['finger_utama'] ?>" class="form-control " disabled>
														</div>
														<div class="col-lg-2">
															<input type="text" name="" value="<?php echo $value['finger_banding'] ?>" class="form-control" disabled>
															<?php if($value['finger_utama']==$value['finger_banding']) { ?>
																<span class="glyphicon glyphicon-ok form-control-feedback"></span>
															 <?php }else{ ?> 
															 	<span class="glyphicon glyphicon-remove form-control-feedback"></span>
															 <?php }?>
														</div>
													</div>
													<div class="form-group <?php if($value['password_utama']==$value['password_banding']){echo 'has-success has-feedback';}else{echo 'has-error has-feedback';} ?>">
														<label class="control-label col-lg-4">Password Terdaftar</label>
														<div class="col-lg-2">
															<input type="text" name="" value="<?php echo $value['password_utama'] ?>" class="form-control" disabled>
														</div>
														<div class="col-lg-2">
															<input type="text" name="" value="<?php echo $value['password_banding'] ?>" class="form-control" disabled>
															<?php if($value['password_utama']==$value['password_banding']) { ?>
																<span class="glyphicon glyphicon-ok form-control-feedback"></span>
															 <?php }else{ ?> 
															 	<span class="glyphicon glyphicon-remove form-control-feedback"></span>
															 <?php }?>
														</div>
													</div>
													<div class="fomr-group">
														<div class="col-lg-8 text-right">
															<a href="<?php echo site_url('PresenceManagement/CekData/Detail/'.$kd) ?>" class="btn btn-success">Detail</a>
														</div>
													</div>
												</form>
											</div>
										</div>
									<?php }} ?>
								
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>