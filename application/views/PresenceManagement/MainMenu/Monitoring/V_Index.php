<script src="<?php echo base_url('assets/js/ajaxSearch.js');?>"></script>
<section class="content">
	<div class="inner" >
	<div class="row">
		<div class="col-lg-12">
			<div class="row">
				<div class="col-lg-12">
					<div class="col-lg-11">
						<div class="text-right">
						<h1><b>Presence Monitoring</b></h1>
						</div>
					</div>
					<div class="col-lg-1">
						<div class="text-right hidden-md hidden-sm hidden-xs">
                            <a class="btn btn-default btn-lg" href="<?php echo site_url('CateringManagement/List');?>">
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
				<?php
				if($this->session->userdata('change_device')){ 
				?>
				<div class="alert alert-warning alert-dismissable"  style="width:100%;" >
							<h4> <li class="fa fa-warning"> </li> Alert!</h4>
								<b>Device <?php echo $this->session->userdata('name_loc'); ?> Has Change !!!</b>
						</div>
				<?php
				}
				?>
				<?php
				if($this->session->userdata('refresh_db')){ 
				?>
				<div class="alert alert-warning alert-dismissable"  style="width:100%;" >
							<h4> <li class="fa fa-warning"> </li> Alert!</h4>
								<b >Device <?php echo $this->session->userdata('loc'); ?> Has Change !!!</b>
						</div>
				<?php
				}
				?>
				
				<div class="box box-primary box-solid">
					<div class="box-header with-border">
						<a href="<?php echo site_url('PresenceManagement/Monitoring/Create/') ?>" style="float:right;margin-right:1%;margin-top:-0.5%;" alt="Add New" title="Add New" >
							<button type="button" class="btn btn-default btn-xs">
							  <i class="icon-plus icon-2x"></i>
							</button>
						</a>
						<b>List Presence Device</b>
					</div>
					<div class="box-body">

						<div class="table-responsive" style="overflow:hidden;">
							<table class="table table-striped table-bordered table-hover text-left" id="datatable-presensi" style="font-size:14px;">
								<thead class="bg-primary">
									<tr>
										<th style="text-align:center;" width="5%">NO</th>
										<th style="text-align:center;" width="10%">ID DEVICE</th>
										<th style="text-align:center;" width="10%">IP ADDRESS</th>
										<th style="text-align:center;" width="25%">LOCATION</th>
										<th style="text-align:center;" width="10%">OFFICE</th>
										<th style="text-align:center;" width="10%">STATUS</th>
										<th style="text-align:center;" width="20%">ACTION</th>
									</tr>
								</thead>
								<tbody>
									<?php 
										$no=0; foreach($device as $data_device){ 
										$encrypted_string = $this->encrypt->encode($data_device['id_lokasi']);
										$encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
										$no++;									
									?>
									
										<tr>
											<td align="center"><?php echo $no ?></td>
											<td align="center"><?php echo $data_device['sn'] ?></td>
											<td align="left"><?php echo $data_device['host'] ?></td>
											<td><?php echo strtoupper($data_device['lokasi']) ?></td>
											<td  align="center"><?php echo $data_device['kantor'] ?></td>
											<td align="center">
											<?php
													@$loadConSQL = $this->load->database('pg_'.$data_device['id_lokasi'],true);
													@$checkSQL = $loadConSQL->initialize();
													if(!$checkSQL){
														?>
															<span style="color:red;"  data-toggle="tooltip" title="Connecting to Computer Database" href='#' ><i class="fa fa-exclamation-circle"></i> Disconnected</span> <span id="stat_con" class="hide">0</span>
														<?php 
													}else{
														?>
														<span style="color:green;" id="stat_con" data-toggle="tooltip" title="Connecting to Computer Database" href='#' ><i class="fa fa-spinner fa-spin"></i> Connected</span><span id="stat_con" class="hide">1</span>
														<?php
													}
											?>
											</td>
											<td align="center">
												<a data-toggle="tooltip" id="btn-reg-person" title="list registered people" href='<?php echo site_URL() ?>PresenceManagement/Monitoring/Connect/<?php echo $encrypted_string ?>' class="btn bg-navy btn-xs"><i class="fa fa-group"></i></a>
												<a title="Change Name Location Device" data-toggle="modal" data-filter="<?php echo $data_device['id_lokasi']; ?>" data-id="<?php echo $data_device['lokasi']; ?>" class="modalchangelocationname btn bg-maroon btn-xs"  href="#confirm-change-location"><i class="fa fa-edit"></i></a>
												<a data-toggle="tooltip" id="btn-reg-person" title="Refresh Database" href='<?php echo site_URL() ?>PresenceManagement/Cronjob/Refresh_Database/<?php echo $encrypted_string ?>' class="btn bg-green btn-xs btn-refresh-db"><i class="fa fa-refresh"></i></a>
												<a data-toggle="tooltip" id="btn-reg-person" title="Update Seksi" href='<?php echo site_URL() ?>PresenceManagement/Cronjob/UpdateSection/<?php echo $encrypted_string ?>' class="btn bg-orange btn-xs btn-refresh-db"><i class="fa fa-sitemap"></i></a>
												<a data-toggle="tooltip" title="Change setting device" href='<?php echo site_URL() ?>PresenceManagement/Monitoring/SettingDev/<?php echo $encrypted_string ?>' class="btn bg-purple btn-xs"><i class="fa fa-cogs"></i></a>
												<a title="Check Miss Distribution Presence" data-toggle="modal" data-filter="<?php echo $data_device['id_lokasi']; ?>" data-id="<?php echo $data_device['lokasi']; ?>" class="distribusi-presensi btn bg-red btn-xs"  href="#distribusi-presensi"><i class="fa fa-history"></i></a>
											<!--	<a data-toggle="tooltip" id="" title="Activation Device" href='<?php echo site_URL() ?>PresenceManagement/Cronjob/ActivatedDevice/<?php echo $encrypted_string ?>' class="btn bg-yellow btn-xs btn-refresh-db"><i class="fa fa-check-circle-o"></i></a> -->
											</td> 
										</tr>
									<?php }?>
								</tbody>																			
							</table>
						</div>
					</div>
				</div>
				</div>
			</div>		
		</div>		
	</div>
	</div>
</section>			
			
<!-- MODAL CHANGE LOCATION -->
<div class="modal fade" id="confirm-change-location" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h5 class="modal-title" id="myModalLabel"><strong>Form change location device</strong></h5>
                </div>
            <form class="form-horizontal" method="post" action="<?php echo site_URL() ?>PresenceManagement/Monitoring/ChangeName">
                <div class="modal-body">
                    <p>You are about to change location device, this procedure is irreversible.</p>
						<input type="hidden" name="txtLocation" id="txtLocation" value="" class="form-control"></input>
						<input style=" text-transform: uppercase;" type="text" name="txtName" id="txtName" value="" class="form-control"></input>
					<p>Do you want to proceed?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-xs" data-dismiss="modal">Cancel</button>
					<input type="submit" class="btn bg-orange btn-xs" value="Change">
                </div>
				</form>
            </div>
        </div>
    </div>
	
	<!-- CHECK PRESENCE -->
<div class="modal fade" id="distribusi-presensi" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h5 class="modal-title" id="myModalLabel"><strong>Check Presence Fingerprint</strong></h5>
                </div>
            <form class="form-inline" method="post" action="<?php echo site_URL() ?>PresenceManagement/Monitoring/CheckPresence" target="_blank">
                <div class="modal-body">
                    <p>You are about to check fingerprint from computer finger, this procedure is irreversible.</p>
						<input type="hidden" name="txtLocation" id="txtLocation" value="" class="form-control"></input>
						<span>Date Start</span>
						<input style=" text-transform: uppercase;" type="text" name="txtDateStart" data-date-format="yyyy-mm-dd" id="txtDateStart" value="" class="form-control datepicker"></input>
						<span>Date End</span>
						<input style=" text-transform: uppercase;" type="text" name="txtDateEnd" data-date-format="yyyy-mm-dd" id="txtDateEnd" value="" class="form-control datepicker"></input>
					<p>Do you want to proceed?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-xs" data-dismiss="modal">Cancel</button>
					<input type="submit" class="btn bg-orange btn-xs" value="Show">
                </div>
				</form>
            </div>
        </div>
    </div>
	
	
	<!-- LOADER -->
<div class="modal fade" id="modal-loader" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="main">
			<div class="s1">
			  <div class="s b sb1"></div>
			  <div class="s b sb2"></div>
			  <div class="s b sb3"></div>
			  <div class="s b sb4"></div>
			</div>
			<div class="s2">
			  <div class="s b sb5"></div>
			  <div class="s b sb6"></div>
			  <div class="s b sb7"></div>
			  <div class="s b sb8"></div>
			</div>
			<div class="bigcon">
			  <div class="big b"></div>
			</div>
		  </div>
    </div>
	
	

