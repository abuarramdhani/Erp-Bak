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
						<b>Control Panel Distributing Presence</b>
					</div>
					<div class="box-body">
					<br>
					<!-- DISTRIBUSI DATABASE POSTGRES PERSONALIA DARI 6.20 -->
					<div class="box box-primary box-solid">
						<div class="box-header with-border">
							Distribute Database of Personal Data
						</div>
						<div class="box-body">
							<div class="col-lg-6">
								<a class="btn bg-maroon" id="execute-cronjob-hrd"><span class="fa fa-upload"></span> Execute</a>
							</div>
						</div>
					</div>
					<!-- DISTRIBUSI FRONTPRESENSI DARI LOCAL KE 6.20 -->
					<div class="box box-primary box-solid">
						<div class="box-header with-border">
							Re-distribution Presence
						</div>
						<div class="box-body">
							<div class="col-lg-12">
								<form class="form-inline" method="post" action="">
									<div class="form-group">
										  <input type="text" class="form-control" name="fr_start" id="fr_start" placeholder="[ Start Date ]">
									</div>
									<div class="form-group">
										  <input type="text" class="form-control" name="fr_end" id="fr_end" placeholder="[ End Date ]">
									</div>
									<button type="submit" class="btn btn-distribute-presence bg-maroon"><span class="fa fa-send"></span> Distribute</button>
								  </form>
							</div>
						</div>
					</div>
					<!-- DISTRIBUSI DATABASE POSTGRES PERSONALIA DARI 6.20 -->
					<div class="box box-primary box-solid">
						<div class="box-header with-border">
							Refresh Database Local
						</div>
						<div class="box-body">
							<div class="col-lg-6">
								<a class="btn bg-maroon" id="refresh-cronjob-hrd"><span class="fa fa-refresh"></span> Refresh</a>
							</div>
							<div class="col-lg-6" id="loading2">
								<img src="<?php echo site_url('assets/img/loading.gif') ?>"></img>
							</div>
						</div>
					</div>
					<!-- UPDATE SEKSI -->
					<div class="box box-primary box-solid">
						<div class="box-header with-border">
							Update Section to Computer Finger
						</div>
						<div class="box-body">
							<div class="col-lg-6">
								<a class="btn bg-maroon" id="update-section-cronjob-hrd"><span class="fa fa-upload"></span> Update</a>
							</div>
							<div class="col-lg-6" id="loading3">
								<img src="<?php echo site_url('assets/img/loading.gif') ?>"></img>
							</div>
						</div>
					</div>
					<!-- BACK UP -->
					<div class="box box-primary box-solid">
						<div class="box-header with-border">
							Back Up Data Finger Local
						</div>
						<div class="box-body">
							<div class="col-lg-6">
								<a class="btn bg-maroon" id="backup-cronjob-hrd"><span class="fa fa-download"></span> Back Up</a>
							</div>
							<div class="col-lg-6" id="loading4">
								<img src="<?php echo site_url('assets/img/loading.gif') ?>"></img>
							</div>
						</div>
					</div>
					<!-- UPDATE FINGER -->
					<div class="box box-primary box-solid">
						<div class="box-header with-border">
							Update Finger Server
						</div>
						<div class="box-body">
							<div class="col-lg-6">
								<a class="btn bg-maroon" id="update-fingercode"><span class="fa fa-refresh"></span> Update Finger</a>
							</div>
							<div class="col-lg-6" id="loading4">
								<img src="<?php echo site_url('assets/img/loading.gif') ?>"></img>
							</div>
						</div>
					</div>
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
