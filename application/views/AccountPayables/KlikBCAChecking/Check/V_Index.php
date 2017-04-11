<script src="<?php echo base_url('assets/js/ajaxSearch.js');?>"></script>

<section class="content">
	<div class="inner" >
		<div class="row">
			<div class="col-lg-12">
				<div class="row" >
					<div class="col-lg-12">
						<div class="col-lg-11">
							<div class="text-right">
								<h1><b>KlikBCA Checking</b></h1>
							</div>
						</div>
						<div class="col-lg-1">
							<div class="text-right hidden-md hidden-sm hidden-xs">
	                            <a class="btn btn-default btn-lg" href="<?php echo site_url('AccountPayables/KlikBCAChecking/Insert');?>">
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
								<b>KlikBCA Checking</b>
							</div>
							<div class="box-body">
								<div class="row">
									<div class="form-group">
										<form method="post" action="<?php echo base_url('AccountPayables/KlikBCAChecking/Check/Validate')?>">
											<label class="col-lg-1 control-label">Tanggal</label>
											<div class="col-lg-2">
												<input name="TxtStartDate" class="form-control bcacheck">
											</div>
											<label class="col-lg-1 control-label" align="center">s/d</label>
											<div class="col-lg-2">
												<input name="TxtEndDate" class="form-control bcacheck">
											</div>
											<div class="col-lg-2">
												<a class="btn btn-primary btn-flat btn-block" id="ShowBCAbydate">Tampilkan</a>
											</div>
											<div class="col-lg-2">
												<button class="btn btn-success btn-flat btn-block" id="">Cocokan</button>
											</div>
											<div class="col-lg-1" align="center"  id="loading">
											</div>
										</form>
									</div>
								</div>
								<br>
								<div class="row">
								<div id="table-full">