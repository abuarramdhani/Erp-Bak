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
						<b>List Registered Finger</b>
					</div>
					<div class="box-body">
						<div class="table-responsive" style="overflow:hidden;">
						<div class="box box-primary">
						<?php
							foreach($person as $data_person){
								
						?>
							<table class="table">
								<thead>
									<tr>
										<th width="5%">NOIND</th>
										<th width="5%">:</th>
										<th width="90%"><?php echo $data_person['noind'] ?></th>
									</tr>
									<tr>
										<th>NAME</th>
										<th>:</th>
										<th><?php echo strtoupper($data_person['nama']); ?></th>
									</tr>
								</thead>
							</table>
						<?php } ?>
						</div>
							<table class="table table-striped table-bordered table-hover text-left" id="datatable-presensi-presence-management" style="font-size:14px;">
								<thead class="bg-primary">
									<tr>
										<th style="text-align:center;" width="10%">NO</th>
										<th style="text-align:center;" width="10%">ID FINGER</th>
										<th style="text-align:center; width="70%">FINGER</th>
										<th style="text-align:center;" width="10%">ACTION</th>
									</tr>
								</thead>
								<tbody>
									<?php 
										$no=0; 
										foreach($finger as $data_finger){
										$no++;
									?>
									
										<tr>
											<td align="center"><?php echo $no ?></td>
											<td align="center"><?php echo $data_finger['id_finger'] ?></td>
											<td align="center"><?php echo $data_finger['jari'] ?></td>
											<td style="text-align:center;">
												<a title="remove finger" id="execute-delete-finger" href="<?php echo site_URL() ?>PresenceManagement/Monitoring/Delete_Finger?loc=<?php echo $enc_loc; ?>&noind=<?php echo $data_finger['noind']?>&fing=<?php echo $data_finger['id_finger'] ?>" class="btn bg-red btn-xs"><i class="fa fa-remove"></i></a>
											</td>
										</tr>
									<?php }?>
								</tbody>																			
							</table>
						</div>
						<hr>
						<div class="form-group">
							<div class="col-lg-12 text-right">
								<a href="<?php echo site_url('PresenceManagement/Monitoring/Connect/'.$enc_loc.'');?>"  class="btn btn-success btn-lg btn-rect">Back</a>
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
	
<!-- MODAL ADD -->
<div class="modal fade" id="confirm-add" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h5 class="modal-title" id="myModalLabel"><strong>Form Register Person</strong></h5>
                </div>
            <form class="form-horizontal" method="post" action="<?php echo site_URL() ?>PresenceManagement/Monitoring/Add_Finger/<?php echo $enc_loc; ?>?id=<?php echo $enc_id; ?>">
                <div class="modal-body">
				<?php
							foreach($person as $data_person){
						?>
							<input type="hidden" name="noind" value="<?php echo $data_person['noind'] ?>"></input>
							<input type="hidden" name="noind_baru" value="<?php echo $data_person['noind_baru'] ?>"></input>
							<?php } ?>
                    <p>Which Finger wants to register on this machine ??</p>
						<table class="table table-striped table-bordered table-hover text-left">
							<thead>
								<tr>
									<th></th>
									<th>FINGER</th>
								</tr>
							</thead>
							<tbody>
						<?php foreach($all_finger as $data_all_finger){ 
						?>
								<tr>
									<td align="center;"><input type="checkbox"  name="id_finger[]" value="<?php echo $data_all_finger['id_finger'] ?>"></input></td>
									<td><input type="text" class="form-control" name="finger[]" value="<?php echo $data_all_finger['jari'] ?>" readonly></input>
										   <input type="hidden" class="form-control" name="code[]" value="<?php echo $data_all_finger['finger'] ?>" readonly></input></td>
								</tr>
											<?php 
						} ?>
							</tbody>
						</table>
					</div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-xs" data-dismiss="modal">Cancel</button>
					<input type="submit" class="btn bg-green btn-xs" value="Save">
                </div>
				</form>
            </div>
        </div>
    </div>	
				
