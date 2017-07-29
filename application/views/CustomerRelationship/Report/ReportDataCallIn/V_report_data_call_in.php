<section class="content">
	<div class="inner" >
	<div class="row">
		<div class="col-lg-12">
			<div class="row">
				<div class="col-lg-12">
					<div class="col-lg-11">
						<div class="text-right">
							<h1><b> Report Data Call-In </b></h1>
						
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
						<form class="form-horizontal" method="post" action="<?php echo site_url('CustomerRelationship/Report/ExportReportDataCallIn');?>">
						<div class="panel-body">
							<div class="col-lg-11">
								<div class="form-group">
									<label for="norm" class="control-label col-lg-3">Time Period</label>
									<div class="col-lg-9">
										<input type="text" placeholder="Time Period" name="txtPeriod" class="form-control daterange"/>
									</div>
								</div>
								<div class="form-group">
									<label for="norm" class="control-label col-lg-3">Customer Name</label>
									<div class="col-lg-9">
										<select class="form-control select4" multiple name="txtCustomer[]"  data-placeholder="Customer" style="width:100%;">
											<?php
											foreach($Customer as $Customer_item){
											?>
											<option value="<?php echo $Customer_item['customer_id']; ?>"><?php echo strtoupper($Customer_item['customer_name']); ?></option>
											<?php
											}
											?>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label for="norm" class="control-label col-lg-3" >Area</label>
									<div class="col-lg-9">
										<select class="form-control city-data" multiple name="txtArea[]" data-placeholder="All City / Regency" style="width:100%;">
											<option value=""></option>
											
										</select>
									</div>
								</div>
								<div class="form-group">
									<label for="norm" class="control-label col-lg-3" >Unit</label>
									<div class="col-lg-9">
										<select class="form-control item-name" multiple name="txtUnit[]"  data-placeholder="All Unit" style="width:100%;">
											<option value=""></option>
											
										</select>
									</div>
								</div><div class="form-group">
									<label for="norm" class="control-label col-lg-3" >Line</label>
									<div class="col-lg-9">
										<input type="text" placeholder="Line Telephone" name="txtLine" class="form-control" style="width:100%;"/>
									</div>
								</div>
								<div class="form-group">
									<label for="norm" class="control-label col-lg-3" >Response Category</label>
									<div class="col-lg-9">
										<select class="form-control select4" multiple name="txtResponse[]" data-placeholder="All Response" style="width:100%;">
											<option value=""></option>
											<option value="Complain">Complain</option>
											<option value="Feedback">Feedback</option>
											<option value="Question">Question</option>
											<option value="Other">Other</option>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label for="norm" class="control-label col-lg-3" >Operator</label>
									<div class="col-lg-9">
										<select class="form-control employee-data" name="txtOperator" data-placeholder="All Operator" style="width:100%;">
											<option value=""></option>
											
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