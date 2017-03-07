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
			<input class="hide" id="txtLoc" value="<?php echo $sesloc?>"></input>
			<input class="hide" id="txtStart" value="<?php echo $sesdtStart?>"></input>
			<input class="hide" id="txtEnd" value="<?php echo $sesdtEnd?>"></input>
			<div class="row">
				<div class="col-lg-12">
				<div class="box box-primary box-solid">
					<div class="box-header with-border">
						<b>Not Distribute Data</b>
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
										<th style="text-align:center;" width="7%">TANGGAL</th>
										<th style="text-align:center;" width="10%">NOIND</th>
										<th style="text-align:center;" width="5%">KODESIE</th>
										<th style="text-align:center;" width="8%">WAKTU</th>
										<th style="text-align:center;" width="8%">TRANSFER</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$no = 0;
									foreach($frontpresensi as $data_frontpresensi){
										if($data_frontpresensi['transfer'] == 0){
											$stat	= "not yet";
											$bg	= "background:#ffcccc;";
										}else{
											$stat	= "done";
											$bg	= "";
										}
									$no++;
									?>
										<tr style="<?php echo $bg; ?>">
											<td style="text-align:center;"><?php echo $data_frontpresensi['tanggal']?></td>
											<td><?php echo $data_frontpresensi['noind']?></td>
											<td style="text-align:center;"><?php echo $data_frontpresensi['kodesie']?></td>
											<td style="text-align:center;"><?php echo $data_frontpresensi['waktu']?></td>
											<td style="text-align:center;"><?php echo $stat?></td>
										</tr>
									<?php } ?>
								</tbody>																			
							</table>
						</div>
						<hr>
						<div class="form-group">
							<div class="col-lg-12 text-right">
								<a href="<?php echo site_url('PresenceManagement/Monitoring');?>"  class="btn btn-success btn-lg btn-rect">Back</a>
								<?php if($no == 0){ ?>
									<a class="btn btn-primary btn-lg btn-rect" disabled>RELEASE</a>
								<?php }else{ ?>
									<a class="release_presence btn btn-primary btn-lg btn-rect">RELEASE</a>
								<?php } ?>
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
				
