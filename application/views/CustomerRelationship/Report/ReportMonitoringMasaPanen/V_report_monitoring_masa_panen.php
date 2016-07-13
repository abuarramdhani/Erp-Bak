<section class="content">
	<div class="inner" >
	<div class="row">
		<div class="col-lg-12">
			<div class="row">
				<div class="col-lg-12">
					<div class="col-lg-11">
						<div class="text-right">
							<h1><b> Report Monitoring Masa Panen </b></h1>
						
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
						<form class="form-horizontal" method="post" action="<?php echo site_url('CustomerRelationship/Report/ExportReportMonitoringMasaPanen');?>">
						<div class="panel-body">
							<div class="col-lg-10">
								<div class="form-group">
									<label for="norm" class="control-label col-lg-4">Time Period</label>
									<div class="col-lg-8">
										<input type="text" placeholder="Ownership Period" name="txtPeriod" class="form-control daterange"/>
									</div>
								</div>
								<div class="form-group">
									<label for="norm" class="control-label col-lg-4" >Area</label>
									<div class="col-lg-8">
										<select class="form-control city-data" multiple name="txtArea[]" data-placeholder="All City / Regency" style="width:100%;">
											<option value=""></option>
											
										</select>
									</div>
								</div>
								<div class="form-group">
									<label for="norm" class="control-label col-lg-4">Buying Type</label>
									<div class="col-lg-8">
										<select class="form-control select4" multiple name="txtBuyingType[]" data-placeholder="All Buying Type" style="width:100%;">
											<option value=""></option>
											<?php
											foreach($buyingtype as $bt){
											?>
											<option value="<?php echo $bt->buying_type_id;?>"><?php echo strtoupper($bt->buying_type_name);?></option>
											<?php
											}
											?>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label for="norm" class="control-label col-lg-4">Sort By</label>
									<div class="col-lg-8">
										<select class="form-control select4" name="txtFilter" data-placeholder="Filter" style="width:100%;">
											<option value="OwnershipDate">Ownership Date</option>
											<option value="CityRegency">City / Regency</option>
											<option value="CustomerName">Customer Name</option>
											<option value="HarvestTime">Harvest Time</option>
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