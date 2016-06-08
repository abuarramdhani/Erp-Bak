<section class="content">
	<div class="inner" >
	<div class="row">
		<div class="col-lg-12">
			<div class="row">
				<div class="col-lg-12">
					<div class="col-lg-11">
						<div class="text-right">
							<h1><b> Report Rekap Costumer Visit </b></h1>
						
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
						<form class="form-horizontal" method="post" action="<?php echo site_url('CustomerRelationship/Report/ExportReportRekapCustomerVisit');?>">
						<div class="panel-body">
							<div class="col-lg-10">
								<!--<div class="form-group">
									<label for="norm" class="control-label col-lg-4" name="txtArea" name="txtArea">Search By</label>
									<div class="col-lg-8">
										<select class="form-control select4" data-placeholder="Option" style="width:100%;" required>
											<option value=""></option>
											<option value="Activity">Activity</option>
											<option value="City">City / Regency</option>
											<option value="Province">Province</option>
											<option value="Month">Month</option>
											
										</select>
									</div>
								</div>-->
								<div class="form-group">
									<label for="norm" class="control-label col-lg-4">Period</label>
									<div class="col-lg-8">
										<input type="text" placeholder="Period" name="txtPeriod" class="form-control daterange"/>
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