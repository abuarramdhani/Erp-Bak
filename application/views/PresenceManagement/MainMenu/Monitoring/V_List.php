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
				<div class="box box-primary box-solid">
					<div class="box-header with-border">
					<a style="float:right;margin-right:1%;margin-top:-0.5%;" title="Mutation / Change to another device" id="modaladd" data-toggle="modal" data-target="#confirm-add" class="btn btn-default btn-xs"><i class="icon-plus icon-2x"></i></a>
						<b>List Registered Person</b>
					</div>
					<div class="box-body">
						<div class="table-responsive" style="overflow:hidden;">
						<div class="box box-primary">
						<?php
							foreach($device as $data_device){
								$location = $data_device['id_lokasi'];
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
										<th><?php echo strtoupper($data_device['lokasi_kerja']); ?></th>
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
										<th style="text-align:center;" width="23%">JABATAN</th>
										<th style="text-align:center;" width="7%">FP CODE</th>
										<th style="text-align:center;" width="10%">NOIND BARU</th>
										<th style="text-align:center;" width="10%">ACTION</th>
									</tr>
								</thead>
								<tbody>
									<?php 
										$no=0; 
										foreach($registered as $data_registered){ 
										$no++;		
										$color = "green";
										if($data_registered['fp_code']==0){$color="red";}
									?>
									
										<tr>
											<td align="center"><?php echo $no ?></td>
											<td align="center"><?php echo $data_registered['noind'] ?></td>
											<td><?php echo $data_registered['nama'] ?></td>
											<td align="center"><?php echo $data_registered['jenkel'] ?></td>
											<td align="center"><?php echo $data_registered['kodesie'] ?></td>
											<td align="center"><?php echo strtoupper($data_registered['keluar']) ?></td>
											<td><?php echo substr(strtoupper($data_registered['jabatan']),0,30) ?></td>
											<td align="center" style="color:<?php echo $color; ?>;"><?php echo $data_registered['fp_code'] ?></td>
											<td align="center"><?php echo strtoupper($data_registered['noind_baru']) ?></td>
											<td align="center">
												<a title="Mutation / Change to another device" data-toggle="modal" data-filter="<?php echo $data_registered['nama']; ?>" data-id="<?php echo $data_registered['noind']; ?>" class="modalmutation btn bg-orange btn-xs"  href="#confirm-mutation"><i class="fa fa-random"></i></a>
												<a title="remove person from this device" href="" data-href="<?php echo site_URL() ?>PresenceManagement/Monitoring/Delete?location=<?php echo $location; ?>&noind=<?php echo $data_registered['noind']?>" data-toggle="modal" data-target="#confirm-delete" class="btn bg-red btn-xs"><i class="fa fa-remove"></i></a>
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
            
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h5 class="modal-title" id="myModalLabel"><strong>Confirmation Mutation / Presence Location</strong></h5>
                </div>
            <form class="form-horizontal" method="post" action="<?php echo site_URL() ?>PresenceManagement/Monitoring/Mutation">
                <div class="modal-body">
                    <p>You are about to change presence location for <br>(<span style="font-weight: bold;" id="txtNoind"></span>) <span style="font-weight: bold;" id="txtName"></span>, <br>this procedure is irreversible.</p>
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
	
<!-- MODAL ADD -->
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
				
