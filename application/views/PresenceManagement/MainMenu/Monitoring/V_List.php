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
				if($this->session->userdata('update')){ 
				?>
				<div class="alert alert-warning alert-dismissable"  style="width:100%;" >
							<h4> <li class="fa fa-warning"> </li> Alert!</h4>
								<b>Successful update data !!!</b>
						</div>
				<?php
				}
				?>

				<?php
				if($this->session->userdata('delete')){ 
				?>
				<div class="alert alert-danger alert-dismissable"  style="width:100%;" >
							<h4> <li class="fa fa-warning"> </li> Alert!</h4>
								<b>Successful delete data !!!</b>
						</div>
				<?php
				}
				?>
				
				<?php
				if($this->session->userdata('register')){ 
				?>
				<div class="alert alert-success alert-dismissable"  style="width:100%;" >
							<h4> <li class="fa fa-warning"> </li> Alert!</h4>
								<b>Successful Add data !!!</b>
						</div>
				<?php
				}
				?>
				
				<?php
				if($this->session->userdata('registered')){ 
				?>
				<div class="alert alert-warning alert-dismissable"  style="width:100%;" >
							<h4> <li class="fa fa-warning"> </li> Alert!</h4>
								<b>ID already registered !!!</b>
						</div>
				<?php
				}
				?>
				<div class="box box-primary box-solid">
					<div class="box-header with-border">
					<a style="float:right;margin-right:1%;margin-top:-0.5%;" title="Add Personal Data" id="modaladd" data-toggle="modal" data-target="#confirm-add" class="btn btn-default btn-xs"><i class="icon-plus icon-2x"></i> Person</a>
					<a style="float:right;margin-right:1%;margin-top:-0.5%;" title="Add Data Worker by Section" id="modaladd" data-toggle="modal" data-target="#confirm-add-section" class="btn btn-default btn-xs"><i class="icon-plus icon-2x"></i> Section</a>
						<b>List Registered Person</b>
					</div>
					<div class="box-body">
						<div class="table-responsive" style="overflow:hidden;">
						<div class="box box-primary">
						<?php
							foreach($device as $data_device){
								$location = $data_device['id_lokasi'];
								$enc_loc = $this->encrypt->encode($location);
								$enc_loc = str_replace(array('+', '/', '='), array('-', '_', '~'), $enc_loc);			
								
						?>
							<table class="table">
								<thead>
									<tr>
										<th>ID DEVICE</th>
										<th>:</th>
										<th><?php echo $data_device['sn'] ?></th>
									</tr>
									<tr>
										<th>OFFICE</th>
										<th>:</th>
										<th><?php echo strtoupper($data_device['kantor']); ?></th>
									</tr>
									<tr>
										<th>LOCATION DEVICE</th>
										<th>:</th>
										<th><?php echo strtoupper($data_device['lokasi']); ?></th>
									</tr>
								</thead>
							</table>
						<?php } ?>
						</div>
							<table class="table table-striped table-bordered table-hover text-left" id="datatable-presensi-presence-management" style="font-size:14px;">
								<thead class="bg-primary">
									<tr>
										<th style="text-align:center;" width="5%">NO</th>
										<th style="text-align:center;" width="7%">NOIND</th>
										<th style="text-align:center;" width="20%">NAMA</th>
										<th style="text-align:center;" width="5%">JENKEL</th>
										<th style="text-align:center;" width="8%">KODESIE</th>
										<th style="text-align:center;" width="5%">KELUAR</th>
										<th style="text-align:center;" width="23%">LOKASI KRJ</th>
										<th style="text-align:center;" width="10%">NOIND BARU</th>
										<th style="text-align:center;" width="10%">ACTION</th>
									</tr>
								</thead>
								<tbody>
									<?php 
										$no=0; 
										foreach($registered as $data_registered){
										$enc_id = $this->encrypt->encode($data_registered['noind']);
										$enc_id = str_replace(array('+', '/', '='), array('-', '_', '~'), $enc_id);											
											if($data_registered['lokasi_kerja'] == "01"){
												$lokasikerja = "KHS PUSAT";
											}elseif($data_registered['lokasi_kerja'] == "02"){
												$lokasikerja = "KHS TUKSONO";
											}elseif($data_registered['lokasi_kerja'] == "03"){
												$lokasikerja = "KHS MLATI";
											}else{
												$lokasikerja = "UNREGISTERED";
											}
											
											if($data_registered['keluar'] == 0){
													$status = "no";
													$color	= "green";
												}else{
													$status = "yes";
													$color	= "red";
											}
										$no++;		
									?>
									
										<tr>
											<td align="center"><?php echo $no ?></td>
											<td align="center"><?php echo $data_registered['noind'] ?></td>
											<td><?php echo $data_registered['nama'] ?></td>
											<td align="center"><?php echo $data_registered['jenkel'] ?></td>
											<td align="center"><?php echo $data_registered['kodesie'] ?></td>
											<td align="center" style="color:<?php echo $color; ?>"><?php echo strtoupper($status) ?></td>
											<td align="center"><?php echo $lokasikerja; ?></td>
											<td align="center"><?php echo strtoupper($data_registered['noind_baru']) ?></td>
											<td align="center">
												<a title="Check Data Fingercode" class="modalcheckfinger btn bg-green btn-xs"  href="<?php echo site_URL('PresenceManagement/Monitoring/Show/'.$enc_loc.'?id='.$enc_id.'') ?>"><i class="fa fa-hand-paper-o"></i> </a> 
												<a title="Mutation / Change to another device" data-toggle="modal" data-filter="<?php echo $data_registered['nama']; ?>" data-id="<?php echo $data_registered['noind']; ?>" class="modalmutation btn bg-orange btn-xs"  href="#confirm-mutation"><i class="fa fa-random"></i></a>
												<a title="remove person from this device" href="" data-href="<?php echo site_URL('PresenceManagement/Monitoring/Delete/'.$enc_loc.'?id='.$enc_id.'') ?>" data-toggle="modal" data-target="#confirm-delete" class="btn bg-red btn-xs"><i class="fa fa-remove"></i></a>
											</td>
										</tr>
									<?php }?>
								</tbody>																			
							</table>
						</div>
						<hr>
						<div class="form-group">
							<div class="col-lg-12 text-right">
								<a href="<?php echo site_url('PresenceManagement/Monitoring');?>"  class="btn btn-success btn-lg btn-rect">Back</a>
							</div>
						</div>
					</div>
				</div>
				</div>
			</div>		
		</div>		
	</div>
	</div>
</section>			
<!-- MODAL DELETE -->
<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h5 class="modal-title" id="myModalLabel"><strong>Confirmation Delete</strong></h5>
                </div>
            
                <div class="modal-body">
                    <p>You are about to delete one track, this procedure is irreversible.</p>
                    <p>Do you want to proceed?</p>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-xs" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-danger btn-ok btn-xs">Delete</a>
                </div>
            </div>
        </div>
    </div>
	
<!-- MODAL MUTATION -->
<div class="modal fade" id="confirm-mutation" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            
                <div class="modal-header " style="background:#337ab7;">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h5 class="modal-title" id="myModalLabel"><strong>Confirmation Mutation / Presence Location</strong></h5>
                </div>
            <form class="form-horizontal" method="post" action="<?php echo site_URL() ?>PresenceManagement/Monitoring/Mutation">
                <div class="modal-body">
                    <p>You are about to change presence location for <br>(<span style="font-weight: bold;" id="txtNoind"></span>) <span style="font-weight: bold;" id="txtName"></span>,<br>&nbsp;
						<select name="txtTarget" id="txtTarget" class="form-control">
						<option value="">[ change location ]</option>
						<?php foreach($lokasi as $data_lokasi){ ?>
							<option value="<?php echo $data_lokasi['id_lokasi'] ?>"><?php echo strtoupper($data_lokasi['lokasi']) ?></option>
						<?php } ?>
						</select>
						<input type="hidden" name="txtLocation" id="txtLocation" value="<?php echo $location; ?>" class="form-control"></input>
						<input type="hidden" name="txtID" id="txtID" value="" class="form-control"></input>
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
	
<!-- MODAL ADD PERSONAL-->
<div class="modal fade" id="confirm-add" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h5 class="modal-title" id="myModalLabel"><strong>Form Register Person</strong></h5>
                </div>
            <form class="form-horizontal" method="post" action="<?php echo site_URL() ?>PresenceManagement/Monitoring/Register">
                <div class="modal-body">
                    <p>Who wants to register on this machine ??</p>
						<select class="form-control select-presence" id="txtID" name="txtID" style="width:100%;" required>
								<option value=""></option>
						</select>
						<input type="hidden" name="txtLocation" id="txtLocation" value="<?php echo $location; ?>" class="form-control"></input>
                    </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-xs" data-dismiss="modal">Cancel</button>
					<input type="submit" class="btn bg-green btn-xs" value="Save">
                </div>
				</form>
            </div>
        </div>
    </div>	
	
	<!-- MODAL ADD SECTION-->
<div class="modal fade" id="confirm-add-section" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h5 class="modal-title" id="myModalLabel"><strong>Form Register Section</strong></h5>
                </div>
            <form class="form-horizontal" method="post" action="<?php echo site_URL() ?>PresenceManagement/Monitoring/RegisterSection">
                <div class="modal-body">
                    <p>Section to register on this machine ??</p>
						<select class="form-control select-presence-section" id="txtID" name="txtID" style="width:100%;" required>
								<option value=""></option>
						</select>
						<input type="hidden" name="txtLocation" id="txtLocation" value="<?php echo $location; ?>" class="form-control"></input>
                    </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-xs" data-dismiss="modal">Cancel</button>
					<input type="submit" class="btn bg-green btn-xs" value="Save">
                </div>
				</form>
            </div>
        </div>
    </div>	
				
