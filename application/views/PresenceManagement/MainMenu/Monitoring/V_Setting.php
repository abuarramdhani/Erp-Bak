<script src="<?php echo base_url('assets/js/ajaxSearch.js');?>"></script>

<section class="content">
	<div class="inner" >
	<div class="row">
		<div class="col-lg-12">
			<div class="row" >
				<div class="col-lg-12">
					<div class="col-lg-11">
						<div class="text-right">
						<h1><b>Presence Monitoring</b></h1>
						</div>
					</div>
					<div class="col-lg-1">
						<div class="text-right hidden-md hidden-sm hidden-xs">
                            <a class="btn btn-default btn-lg" href="<?php echo site_url('CateringManagement/Receipt');?>">
                                <i class="icon-wrench icon-2x"></i>
                                <span><br/></span>	
                            </a>
						</div>
					</div>
				</div>
			</div>
			<br/>
			
			<div class="row">
				<div class="col-lg-12">
				<div class="box box-primary box-solid">
					<div class="box-header with-border">
						<b>Add new fingerprint device</b>
					</div>
					<div class="box-body">
					<form method="post" action="<?php echo base_url('PresenceManagement/Monitoring/UpdateDevice')?>">
						
					
						<!-- INPUT GROUP 1 ROW 1 -->
						<?php foreach( $device as $data_device){ ?>
						<div class="row" style="margin: 10px 10px">
							<div class="form-group">
								<label class="col-lg-2 control-label">Serial Number</label>
								<div class="col-lg-4">
									<input name="txtSN" class="form-control toupper" placeholder="[ Enter the serial number of fingerprint ]" value="<?php echo $data_device['sn']?>" readonly>
								</div>
							</div>
						</div>
						<!-- INPUT GROUP 1 ROW 2 -->
						<div class="row" style="margin: 10px 10px">
							<div class="form-group">
								<label class="col-lg-2 control-label">Verifivation Code</label>
								<div class="col-lg-5">
									<input name="txtVC" class="form-control toupper" placeholder="[ Enter the verification code of fingerprint ]" value="<?php echo $data_device['vc'] ?>"  disabled>
								</div>
							</div>
						</div>
						<!-- INPUT GROUP 1 ROW 3 -->
						<div class="row" style="margin: 10px 10px">
							<div class="form-group">
								<label class="col-lg-2 control-label">Activation Code</label>
								<div class="col-lg-5">
									<input name="txtAC" class="form-control toupper" placeholder="[ Enter the activation code of fingerprint ]" value="<?php echo $data_device['ac'] ?>"  disabled >
								</div>
							</div>
						</div>
						<hr>
						<!-- INPUT GROUP 2 ROW 1 -->
						<div class="row" style="margin: 10px 10px">
							<div class="form-group">
								<label class="col-lg-2 control-label">Id Location</label>
								<div class="col-lg-6">
									<input name="txtIdLocation" class="form-control toupper" value="<?php echo $data_device['id_lokasi'] ?>" placeholder=""  readonly>
								</div>
							</div>
						</div>
						<!-- INPUT GROUP 2 ROW 1.2 -->
						<div class="row" style="margin: 10px 10px">
							<div class="form-group">
								<label class="col-lg-2 control-label">Location</label>
								<div class="col-lg-6">
									<input name="txtLocation" class="form-control toupper" placeholder="[ Enter the location device ]" value="<?php echo $data_device['lokasi'] ?>"  readonly  >
								</div>
							</div>
						</div>
						<!-- INPUT GROUP 2 ROW 3 -->
						<div class="row" style="margin: 10px 10px">
							<div class="form-group">
								<label class="col-lg-2 control-label">Office</label>
								<div class="col-lg-3">
									<select class="form-control" name="txtOffice" placeholder="[ Enter the location device ]" disabled>
										<?php
											foreach($office as $data_office){
												if($data_device['kd_lokasi'] == $data_office['kd_lokasi']){
													$select	= "selected";
												}else{
													$select = "";
												}
												echo "<option value='".$data_office['kd_lokasi']."' ".$select.">".$data_office['lokasi_kerja']."</option>";
											}
										?>
									</select>
								</div>	
							</div>
						</div>
						<hr>
						
						<div class="row" style="margin: 10px 10px">
							<div class="form-group">
								<label class="col-lg-2 control-label">Device</label>
								<div class="col-lg-3">
									<select class="form-control" name="txt_device_tgt" placeholder="[ Enter the location device ]">
									<option value=""> [ Select Target Device ] </option>
										<?php
											foreach($tgt_device as $data_tgt_device){
												echo "<option value='".$data_tgt_device['sn']."'>".$data_tgt_device['sn']."</option>";
											}
										?>
									</select>
								</div>	
							</div>
						</div>
						<!-- INPUT GROUP 3 ROW 1 -->
						<div class="row" style="margin: 10px 10px">
							<div class="form-group">
								<label class="col-lg-2 control-label">IP Address</label>
								<div class="col-lg-3">
									<input id="calc" name="txt_host_tgt" class="form-control" onkeypress="return isNumberKeyAndComma(event)" placeholder="Calc" value="<?php echo $data_device['host'] ?>">
								</div>								
							</div>
						</div>
						<hr>
						<?php } ?>
						<!-- submit -->
						<div class="form-group">
							<div class="col-lg-12 text-right">
								<a href="<?php echo site_url('PresenceManagement/Monitoring');?>"  class="btn btn-success btn-lg btn-rect">Back</a>
								&nbsp;&nbsp;
								<button type="submit" class="btn btn-success btn-lg btn-rect">Save Data</button>
							</div>
						</div>
						
					<form>
					</div>
				</div>
				</div>
			</div>		
		</div>		
	</div>
	</div>
</section>			
			
				
