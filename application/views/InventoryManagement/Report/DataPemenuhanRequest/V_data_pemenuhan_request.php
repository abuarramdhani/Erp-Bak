<section class="content">
	<div class="inner" >
	<div class="row">
		<div class="col-lg-12">
			<div class="row">
				<div class="col-lg-12">
					<div class="col-lg-11">
						<div class="text-right">
							<h1><b> Report Data Pemenuhan Request</b></h1>
						
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
						<form class="form-horizontal" method="post" action="<?php echo site_url('InventoryManagement/Report/ExportReportDataCallIn');?>">
						<div class="panel-body">
							<div class="col-lg-11">
								<div class="form-group">
									<label for="norm" class="control-label col-lg-3">Time Period</label>
									<div class="col-lg-9">
										<input type="text" placeholder="Time Period" name="txtPeriod" class="form-control daterange3"/>
									</div>
								</div>
								<div class="form-group">
									<label for="norm" class="control-label col-lg-3" >Branch</label>
									<div class="col-lg-9">
										<select class="form-control select4" name="txtOrg" style="width:100%;">
											<option value=""></option>
										<?php
											foreach($Org as $Org_item){
										?>
											<option value="<?=$Org_item['org_id']?>"><?=$Org_item['org_name']?></option>
										<?php
											}
										?>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label for="norm" class="control-label col-lg-3" >Delivery Num.</label>
									<div class="col-lg-9">
										<select class="form-control item-name" multiple name="txtUnit[]"  data-placeholder="All Unit" style="width:100%;">
											<option value=""></option>
											
										</select>
									</div>
								</div><div class="form-group">
									<label for="norm" class="control-label col-lg-3" >Status</label>
									<div class="col-lg-9">
										<input type="text" placeholder="Line Telephone" name="txtLine" class="form-control" style="width:100%;"/>
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