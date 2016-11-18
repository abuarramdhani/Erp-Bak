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
						<b>Control Panel Execute Presence</b>
					</div>
					<div class="box-body">
					<div class="box box-primary">
						<div class="row" style="padding:10px;">
							<div class="col-lg-1 text-center">
								<a title="Refresh to Update Registered Person :: hrd_khs" id="refreshRegPers" class="btn btn-lg bg-blue btn-rect"><span class="fa fa-refresh"></span> <br> Refresh Person</a>
							</div>
							<div class="col-lg-1"></div>
							<div class="col-lg-1 text-center">
								<a title="Refresh to Master fingercode" id="refreshFinger"  class="btn btn-lg bg-purple btn-rect disabled"><span class="fa fa-hand-stop-o"></span> <br> Update Finger</a>
							</div>
							<div class="col-lg-1"></div>
							<div class="col-lg-1 text-center">
								<a title="Distribute finger from quick.com to local presence :: fingertolocalhost" id="refreshFinger"  class="btn btn-lg bg-maroon btn-rect"><span class="fa fa-sitemap"></span> <br> Distribute Finger</a>
							</div>
							<div class="col-lg-1"></div>
							<div class="col-lg-1 text-center">
								<a title="Refresh location device" href="<?php echo site_url('PresenceManagement/Monitoring');?>"  class="btn btn-lg bg-navy btn-rect disabled"><span class="fa fa-toggle-on"></span> <br> Refresh Device</a>
							</div>
						</div>
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
