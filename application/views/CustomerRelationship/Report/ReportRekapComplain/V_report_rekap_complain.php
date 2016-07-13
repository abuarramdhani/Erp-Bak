<section class="content">
	<div class="inner" >
	<div class="row">
		<div class="col-lg-12">
			<div class="row">
				<div class="col-lg-12">
					<div class="col-lg-11">
						<div class="text-right">
							<h1><b> Report Rekap Complain </b></h1>
						
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
						<form class="form-horizontal" method="post" action="<?php echo site_url('CustomerRelationship/Report/ExportReportRekapComplain');?>">
						<div class="panel-body">
							<div class="col-lg-11">
								<!--<div class="form-group">
									<label class="control-label col-lg-3" >Time Period</label>

									<div class="col-lg-4">
										<input type="text" placeholder="Time Period" name="txtPeriod" class="form-control daterange"/>
									</div>
								</div>
								-->
								 <div class="form-group">
									<label class="control-label col-lg-3" >Time Period</label>

									<div class="col-lg-3">
										<input type="text" placeholder="Start" name="txtStartDate" style="width:100%;" class="form-control datepickermonth" required/>
									</div>
									
									<label class="control-label col-lg-2" style="text-align:center;" >To</label>

									<div class="col-lg-3">
										<input type="text" placeholder="End" name="txtEndDate" class="form-control datepickermonth" required/>
									</div>
								</div>
								<div class="form-group">
									<label for="norm" class="control-label col-lg-3" >Category Service</label>
									<div class="col-lg-9">
										<select class="form-control select4" name="txtCategoryService" data-placeholder="All Category" style="width:100%;">
											<option value="All">All</option>
											<option value="WithBKE">With BKE</option>
											<option value="NonBKE">Non BKE</option>
											
										</select>
									</div>
								</div>
								<div class="form-group">
									<label for="norm" class="control-label col-lg-3" >Province / City / Regency</label>
									<div class="col-lg-9">
										<select class="form-control jsCityProvince" multiple name="txtArea[]" name="txtArea" data-placeholder="All Province" style="width:100%;">
											<option value=""></option>
											
										</select>
									</div>
								</div>
								<div class="form-group">
									<label for="norm" class="control-label col-lg-3" >Sort By</label>
									<div class="col-lg-9">
										<select class="form-control select4" name="txtSortBy" data-placeholder="All Category" style="width:100%;">
											
											<option value="TroubledPart">Troubled Part</option>
											<option value="Complain">Complain</option>
											
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