<section class="content">
	<div class="inner" >
	<div class="row">
		<div class="col-lg-12">
			<div class="row">
				<div class="col-lg-12">
					<div class="col-lg-11">
						<div class="text-right">
							<h1><b> Report Data Keluhan dan Masukan </b></h1>
						
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
						<form class="form-horizontal" method="post" action="<?php echo site_url('CustomerRelationship/Report/ExportReportDataKeluhanMasukan');?>">
						<div class="panel-body">
							<div class="col-lg-11">
								<div class="form-group">
									<label for="norm" class="control-label col-lg-3">Time Period</label>
									<div class="col-lg-9">
										<input type="text" placeholder="Time Period" name="txtPeriod" class="form-control daterange" required/>
									</div>
								</div>
								<div class="form-group">
									<label for="norm" class="control-label col-lg-3" >Regency</label>
									<div class="col-lg-9">
										<select class="form-control jsCityProvince" multiple name="txtArea[]" data-placeholder="All Regency" style="width:100%;" required>
											<option value=""></option>
											
										</select>
									</div>
								</div>
								<div class="form-group">
									<label for="norm" class="control-label col-lg-3" >Activity</label>
									<div class="col-lg-9">
										<select class="form-control select4" multiple name="txtActivity[]" multiple data-placeholder="All Activity" style="width:100%;">
											<option value=""></option>
											<option value="Service Keliling">Service Keliling</option>
											<option value="Customer Visit">Customer Visit</option>
											<option value="Call Out">Call Out</option>
											<option value="Call In">Call In</option>
											<option value="Social Media">Social Media</option>
											<option value="Email">Email</option>
											<option value="Visit Us">Visit Us</option>
											<option value="Others">Others</option>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label for="norm" class="control-label col-lg-3" >Category Response</label>
									<div class="col-lg-9">
										<select class="form-control select4" multiple name="txtResponse[]" multiple data-placeholder="All Response" style="width:100%;">
											<option value=""></option>
											<option value="Complain">Complain</option>
											<option value="Feedback">Feedback</option>
											<option value="Question">Question</option>
											<option value="Other">Other</option>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label for="norm" class="control-label col-lg-3" >Sort By</label>
									<div class="col-lg-9">
										<select class="form-control select4" name="txtSortBy" data-placeholder="Sort By" style="width:100%;">
											<option selected value="OpenDate">Open Date</option>
											<option value="ResponseDescription">Response Description</option>
											<option value="ResponseTime">Response Time</option>
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
