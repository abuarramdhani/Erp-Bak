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
										<th style="text-align:center;" width="10%">REGISTERED</th>
										<th style="text-align:center;" width="20%">OFFICE</th>
										<th style="text-align:center;" width="10%">STATUS</th>
										<th style="text-align:center;" width="10%">ACTION</th>
									</tr>
								</thead>
								<tbody>
									<?php 
										$no=0; foreach($device as $data_device){ 
										$no++;
										 $status="<span class='label bg-red'>Not Active</span>";
										 if ($data_device['status_']=='1'){$status="<span class='label bg-green'>Active</span>";}										
									?>
									
										<tr>
											<td align="center"><?php echo $no ?></td>
											<td align="center"><?php echo $data_device['sn'] ?></td>
											<td align="center"><?php echo $data_device['host'] ?></td>
											<td><?php echo strtoupper($data_device['lokasi']) ?></td>
											<td align="center"><?php echo $data_device['registered'] ?></td>
											<td><?php echo $data_device['lokasi_kerja'] ?></td>
											<td align="center"><?php echo $status ?></td>
											<td align="center">
												<a data-toggle="tooltip" title="list registered people" href='<?php echo site_URL() ?>PresenceManagement/Monitoring/Show/<?php echo $data_device['id_lokasi']?>' class="btn bg-navy btn-xs"><i class="fa fa-group"></i></a>
												<a title="Change Name Location Device" data-toggle="modal" data-filter="<?php echo $data_device['id_lokasi']; ?>" data-id="<?php echo $data_device['lokasi']; ?>" class="modalchangelocationname btn bg-maroon btn-xs"  href="#confirm-change-location"><i class="fa fa-edit"></i></a>
												<a data-toggle="tooltip" title="Change setting device" href='<?php echo site_URL() ?>PresenceManagement/Monitoring/SettingDev/<?php echo $data_device['id_lokasi']?>' class="btn bg-purple btn-xs"><i class="fa fa-cogs"></i></a>
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
