<script src="<?php echo base_url('assets/js/ajaxSearch.js');?>"></script>

<section class="content">
	<div class="inner" >
	<div class="row">
		<div class="col-lg-12">
			<div class="row" >
				<div class="col-lg-12">
					<div class="col-lg-11">
						<div class="text-right">
						<h1><b>Penjadwalan Paket Pelatihan</b></h1>
						</div>
					</div>
					<div class="col-lg-1">
						<div class="text-right hidden-md hidden-sm hidden-xs">
                            <a class="btn btn-default btn-lg" href="<?php echo site_url('ADMPelatihan/PenjadwalanPackage');?>">
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
						<b>View Penjadwalan Paket Pelatihan</b>
					</div>
					
					<div class="box-body">
					<form method="post" action="<?php echo base_url('ADMPelatihan/PenjadwalanPackage/Add')?>">
					<?php foreach($GetScheduledPackageId as $gspn){ ?>
						<div class="row" style="margin: 10px 10px">
							<div class="form-group">
								<label class="col-lg-2 control-label">Nama Paket Pelatihan</label>
								<div class="col-lg-6">
									<input class="form-control" value="<?php echo $gspn['package_name'] ?>" readonly >
								</div>
							</div>
						</div>
						<div class="row" style="margin: 10px 10px">
							<div class="form-group">
								<label class="col-lg-2 control-label">Jenis Paket Pelatihan</label>
								<div class="col-lg-2">
									<input class="form-control" value="<?php echo $gspn['training_type_description'] ?>" readonly >
								</div>
								<label class="col-lg-1 control-label">Peserta</label>
								<div class="col-lg-3">
									<input class="form-control" value="<?php echo $gspn['participant_type_description'] ?>" readonly >
								</div>
							</div>
						</div>
						<div class="row" style="margin: 10px 10px">
							<div class="form-group">
								<label class="col-lg-2 control-label">Nama Penjadwalan</label>
								<div class="col-lg-6">
									<input class="form-control toupper" value="<?php echo $gspn['package_scheduling_name'] ?>" readonly >
								</div>
							</div>
						</div>
						<hr>
					<?php } ?>
						<div class="form-group">
							<div class="col-lg-8 text-right">
								<a href="<?php echo site_url('ADMPelatihan/PenjadwalanPackage');?>"  class="btn btn-primary btn btn-flat">Back</a>
									&nbsp;&nbsp;
							</div>
						</div>
					<form>
					</div>
				</div>
				</div>
			</div>		
		</div>		
	</div>
	</div>
</section>			
			
				
