<section class="content">
	<div class="inner" >
	<div class="row">
		<form method="post" action="<?php echo site_url('CustomerRelationship/Setting/ApprovalClaim/Create')?>" class="form-horizontal">
			<input type="hidden" value="<?php echo date("Y-m-d H:i:s")?>" name="hdnDate" id="hdnDate" />
			<input type="hidden" value="<?php echo $this->session->userid; ?>" name="hdnUser" id="hdnUser" />
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11">
							<div class="text-right">
								<h1><b> New Approval Claim</b></h1>
							</div>
						</div>
						<div class="col-lg-1 ">
							<div class="text-right hidden-md hidden-sm hidden-xs">
								<a class="btn btn-default btn-lg" href="<?php echo site_url('CustomerRelationship/Setting/ApprovalClaim');?>">
									<i class="icon-wrench icon-2x"></i>
									<span ><br /></span>
								</a>
							</div>
						</div>
				</div>
			</div>
			<br />
			<div class="row">
				<div class="col-lg-12">
					<div class="box box-default box-solid">
						<div class="box-body">
							<div class="panel-body">
								<div class="form-group">
										<label for="norm" class="control-label col-lg-1 col-lg-offset-3">Branch</label>
										<div class="col-lg-5">
											<select class="form-control select2" name="branch" id="slcBranchApproval" required>
												<option disabled selected></option>
												<?php foreach ($branch as $b) { ?>
													<option value="<?php echo $b['location_code']; ?>">
														<?php echo $b['location_name']; ?>
													</option>
												<?php } ?>
											</select>
										</div>
								</div>
								<div class="form-group">
										<label for="norm" class="control-label col-lg-1 col-lg-offset-3">Employee</label>
										<div class="col-lg-5">
											<!--<select class="form-control select2" name="employee" id="slcEmployeeApproval" disabled></select>-->
											<select class="form-control select2" name="employee" required>
												<option disabled selected></option>
												<?php foreach ($employee as $e) { ?>
													<option value="<?php echo $e['employee_id']; ?>">
														<?php echo $e['employee_code'].' - '.$e['employee_name']; ?>
													</option>
												<?php } ?>
											</select>
										</div>
								</div>
								<div class="form-group">
									<label class="control-label col-lg-1 col-lg-offset-3">Start Date</label>
									<div class="col-lg-5">
										<input type="text" name="startDate" class="form-control" id="start"/>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-lg-1 col-lg-offset-3">End Date</label>
									<div class="col-lg-5">
										<input type="text" name="endDate" class="form-control" id="end"/>
									</div>
								</div>
							</div>
						<div class="panel-footer">
							<div class="row text-right">
								<a href="<?php echo site_url('CustomerRelationship/Setting/ApprovalClaim/');?>" class="btn btn-primary btn-lg btn-rect">Back</a>
								&nbsp;&nbsp;
								<button class="btn btn-primary btn-lg btn-rect" type="submit">Save Data</button>
							</div>
						</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		</form>
	</div>
	</div>
</section>