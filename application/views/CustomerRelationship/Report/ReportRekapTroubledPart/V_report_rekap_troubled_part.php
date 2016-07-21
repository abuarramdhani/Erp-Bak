<section class="content">
	<div class="inner" >
	<div class="row">
		<div class="col-lg-12">
			<div class="row">
				<div class="col-lg-12">
					<div class="col-lg-11">
						<div class="text-right">
							<h1><b> Report Rekap Troubled Part </b></h1>
						
						</div>
					</div>
					<div class="col-lg-1 ">
							<div class="text-right hidden-md hidden-sm hidden-xs">
								<a class="btn btn-default btn-lg" href="#">
									<i class="icon-file-text icon-2x"></i>
									<span ><br /></span>
								</a>
								

							</div>
					</div>
				</div>	
			</div>
			<br />
			<div class="row">
				<div class="col-lg-12">
					<div class="box box-primary box-solid">
						<div class="box-header with-border">
							Filter Parameters
						</div>
						<form class="form-horizontal" method="post" action="<?php echo site_url('CustomerRelationship/Report/ExportReportRekapTroubledPart');?>">
						<div class="panel-body">
							<div class="col-lg-11">
								<div class="form-group">
									<label class="control-label col-lg-3" >Time Period</label>

									<div class="col-lg-4">
										<input type="text" placeholder="Start" name="txtStartProgram" style="width:100%;" class="form-control datepickermonth" required/>
									</div>
									
									<label class="control-label col-lg-1" style="text-align:center;" >To</label>

									<div class="col-lg-4">
										<input type="text" placeholder="End" name="txtEndProgram" class="form-control datepickermonth" required/>
									</div>
								</div>
								
								<div class="form-group">
									<label for="norm" class="control-label col-lg-3" >Unit</label>
									<div class="col-lg-9">
										<select class="form-control item-name" multiple name="txtUnit[]" data-placeholder="All Unit" style="width:100%;">
											<option value=""></option>
											
										</select>
									</div>
								</div>
								<div class="form-group">
									<label for="norm" class="control-label col-lg-3" >Area</label>
									<div class="col-lg-9">
										<select class="form-control jsCityProvince" multiple name="txtArea[]"  data-placeholder="All Area" style="width:100%;">
											<option value=""></option>
											
										</select>
									</div>
								</div>
								<div class="form-group">
									<label for="norm" class="control-label col-lg-3" >Spare Part</label>
									<div class="col-lg-9">
										<select class="form-control sp-data" multiple name="txtSparePart[]" data-placeholder="All Spare Part" style="width:100%;">
											<option value=""></option>
											
										</select>
									</div>
								</div>
							</div>
							
						</div>
						<div class="panel-footer text-right">
							<button class="btn btn-primary btn-rect btn-lg">Search</button>
						</div>
						</form>
					</div>
					
				</div>
			</div>
		</div>
	</div>
	</div>
</section>
