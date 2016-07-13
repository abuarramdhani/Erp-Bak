<section class="content">
	<div class="inner" >
	<div class="row">
		<div class="col-lg-12">
			<div class="row">
				<div class="col-lg-12">
					<div class="col-lg-11">
						<div class="text-right">
							<h1><b> Report Data Troubled Part </b></h1>
						
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
						<form class="form-horizontal" method="post" action="<?php echo site_url('CustomerRelationship/Report/ExportReportDataTroubledPart');?>">
						<div class="panel-body">
							<div class="col-lg-11">
								<div class="form-group">
									<label for="norm" class="control-label col-lg-3">Claim Date Period</label>
									<div class="col-lg-9">
										<input type="text" placeholder="Time Period" name="txtPeriod" class="form-control daterange"/>
									</div>
								</div>
								<div class="form-group">
									<label for="norm" class="control-label col-lg-3">Customer Name</label>
									<div class="col-lg-9">
										<select class="form-control owner-name" name="txtCustomerName" name="txtCustomerName" data-placeholder="All Customer" style="width:100%;">
											<option value=""></option>
											
										</select>
									</div>
								</div>
								<div class="form-group">
									<label for="norm" class="control-label col-lg-3" >Province</label>
									<div class="col-lg-9">
										<select class="form-control province-data" multiple name="txtProvince[]" id="txtProvince" data-placeholder="All City / Regency" style="width:100%;">
											<option value=""></option>
											
										</select>
									</div>
								</div>
								<div class="form-group">
									<label for="norm" class="control-label col-lg-3" >Unit</label>
									<div class="col-lg-9">
										<select class="form-control item-name" multiple name="txtUnit[]" id="txtUnit" data-placeholder="All Unit" style="width:100%;">
											<option value=""></option>
											
										</select>
									</div>
								</div>
								<div class="form-group">
									<label for="norm" class="control-label col-lg-3" >Body Number</label>
									<div class="col-lg-9">
										<select class="form-control body-number" name="txtBodyNumber" id="txtBodyNumber" data-placeholder="All Body Number" style="width:100%;">
											<option value=""></option>
											
										</select>
									</div>
								</div>
								<div class="form-group">
									<label for="norm" class="control-label col-lg-3" >Activity</label>
									<div class="col-lg-9">
										<select class="form-control select4" multiple name="txtActivity[]" id="txtActivity" data-placeholder="All Activity" style="width:100%;">
											<option value=""></option>
											<option value="service_keliling">Service Keliling</option>
											<option value="customer_visit">Customer Visit</option>
											<option value="call_out">Call Out</option>
											<option value="call_in">Call In</option>
											<option value="social_media">Social Media</option>
											<option value="email">Email</option>
											<option value="visit_us">Visit Us</option>
											<option value="others">Others</option>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label for="norm" class="control-label col-lg-3" >Spare Part</label>
									<div class="col-lg-9">
										<select class="form-control sp-data" name="txtSparePart" name="txtSparePart" data-placeholder="All Spare Part" style="width:100%;">
											<option value=""></option>
											
										</select>
									</div>
								</div>
								<div class="form-group">
									<label for="norm" class="control-label col-lg-3" >Technician</label>
									<div class="col-lg-9">
										<select class="form-control employee-data" name="txtTechnician" name="txtTechnician" data-placeholder="All Operator" style="width:100%;">
											<option value=""></option>
											
										</select>
									</div>
								</div>
								<div class="form-group">
									<label for="norm" class="control-label col-lg-3" >Status</label>
									<div class="col-lg-9">
										<select class="form-control select4" name="txtStatus" name="txtStatus" data-placeholder="All Status" style="width:100%;">
											<option value=""></option>
											<option value="OPEN">OPEN</option>
											<option value="CLOSE">CLOSE</option>
										</select>
									</div>
								</div>
								
							</div>
							<div class="col-lg-6">
								
								
								
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