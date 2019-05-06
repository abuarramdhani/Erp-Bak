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
					
						<b>List Registered Finger</b>
					</div>
					<div class="box-body">
						<div class="table-responsive" style="overflow:hidden;">
						<div class="box box-primary">
						<?php
							foreach($pekerja as $data_person){
								
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
										<th style="text-align:center; width=70%">FINGER</th>
										<!-- <th style="text-align:center;" width="10%">ACTION</th> -->
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
											<td align="center"><?php echo $data_finger['kode_finger'] ?></td>
											<td align="center"><?php echo $data_finger['nama_jari'] ?></td>
											<!-- <td style="text-align:center;">
												<a title="remove finger" id="execute-delete-finger" href="<?php echo site_URL().'PresenceManagement/MonitoringPresensi/Delete_Finger/'.$data_finger['id_jari'] ?>" class="btn bg-red btn-xs"><i class="fa fa-remove"></i></a>
											</td> -->
										</tr>
									<?php }?>
								</tbody>																			
							</table>
						</div>
						<hr>
						<div class="form-group">
							
						</div>
					</div>
				</div>
				</div>
			</div>		
		</div>		
	</div>
	</div>
</section>		
	

				
