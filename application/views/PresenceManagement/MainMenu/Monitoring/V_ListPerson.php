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
							<table class="table table-striped table-bordered table-hover text-left" id="registered-presensi" style="font-size:14px;">
								<thead class="bg-primary">
									<tr>
										<th style="text-align:center;" >NO</th>
										<th style="text-align:center;" >ID</th>
										<th style="text-align:center;">NAME</th>
										<th style="text-align:center;" >STAT</th>
										<th style="text-align:center;" >DO</th>
										<th style="text-align:center;" >SECTION</th>
										<th style="text-align:center;" >NEW ID</th>
										<?php
											foreach($location as $data_location){
												echo "<th title='".$data_location['lokasi']."' style='text-align:center;'>".strtoupper(substr($data_location['lokasi'],0,4))."</th>";
											}
										?>
									</tr>
								</thead>
								<tbody>
								<?php 
								$no = 0;
									foreach($person as $data_person){
								$no++;
								?>
										<tr>
											<td align="center"><?php echo $no ?></td>
											<td align="center"><?php echo $data_person['noind'] ?></td>
											<td><?php echo $data_person['nama'] ?></td>
											<td align="center"><?php echo strtoupper($data_person['keluar']) ?></td>
											<td align="center"><?php echo date("Y-m-d", strtotime($data_person['tglkeluar'])) ?></td>
											<td align="center"><?php echo $data_person['kodesie'] ?></td>
											<td align="center"><?php echo $data_person['noind_baru'] ?></td>
											<?php foreach($location as $data_location){
												?>
													<td style='text-align:center;'>
														<?php
															if(($data_person['id_lokasi'] == $data_location['id_lokasi'])){
																echo "<span class='fa fa-check' style='color:green;'></span>";
															}else{
																echo "<span class='fa fa-close' style='color:red;'></span>";
															}
														?>
													</td>
												<?php
											} ?>
										</tr>
										<?php } ?>
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
