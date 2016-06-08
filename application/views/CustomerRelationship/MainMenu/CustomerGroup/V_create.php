<form method="post" action="<?php echo site_url('CustomerRelationship/CustomerGroup/Create/')?>" class="form-horizontal">
<section class="content" >
	<div class="inner" >
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
						<div class="col-lg-12">
							<div class="col-lg-11">
								<div class="text-right">
								<h1><b> New Customer Group</b></h1>
								</div>
							</div>
							<div class="col-lg-1 ">
								<div class="text-right hidden-md hidden-sm hidden-xs">
									<a class="btn btn-default btn-lg" href="<?php echo site_url('CustomerRelationship/CustomerGroup');?>">
										<i class="icon-group icon-2x"></i>
										<span><br /></span>
									</a>
								</div>
							</div>
						</div>
				</div>
				<div class="box box-primary box-solid">
					<div class="box-header with-border">
					Header
					</div>
					<div class="box-body">
						<div class="row">
							<div class="col-lg-12">
								
								<input type="hidden" value="<?php echo date("Y-m-d H:i:s")?>" name="hdnDate" />
								<input type="hidden" value="<?php echo $this->session->userid; ?>" name="hdnUser" />
									<div class="box-body">
										<div class="col-lg-12">
											<div class="form-group">
												<label for="norm" class="control-label col-lg-2">Group Name</label>
												<div class="col-lg-4">
													<input type="text" placeholder="Customer Group" name="txtCustomerGroup" class="form-control toupper" required/>
												</div>
											</div>
											<div class="form-group">
												<label for="autosize" class="control-label col-lg-2">Address</label>

												<div class="col-lg-4">
													<textarea id="autosize" placeholder="Address Customer Group" name="txtAddress" class="form-control toupper"></textarea>
												</div>
											</div>

										</div>
										<div class="col-lg-6">
											<div class="form-group">
												<label for="norm" class="control-label col-lg-4">Province</label>
												<div class="col-lg-8">
													<select name="txtProvince" id="txtProvince" data-placeholder="Province" onchange="getRegency('<?php echo base_url();?>')" class="form-control select4" required>
														<option value="">-- Option --</option>
														<?php
														foreach($Province as $ct){
														?>
														<option value="<?php echo $ct['province_id'];?>"><?php echo strtoupper($ct['province_name']);?></option>
														<?php
														}
														?>
													</select>
												</div>
											</div>
											<div class="form-group">
												<label for="norm" class="control-label col-lg-4">City / Regency</label>
												<div class="col-lg-8">
													<select data-placeholder="City / Regency" name="txtCityRegency" id="txtCityRegency" onchange="getDistrict('<?php echo base_url();?>')" class="form-control select4" disabled required>
														<option value="">-- Option --</option>

													</select>
												</div>

											</div>
											<div class="form-group">
												<label for="norm" class="control-label col-lg-4">District</label>
												<div class="col-lg-8">
													<select data-placeholder="District" name="txtDistrict" id="txtDistrict" onchange="getVillage('<?php echo base_url();?>')" class="form-control select4" disabled required>
														<option value="">-- Option --</option>

													</select>
												</div>

											</div>
											<div class="form-group">
												<label for="norm" class="control-label col-lg-4">Village</label>
												<div class="col-lg-8">
													<select data-placeholder="Village" name="txtVillage" id="txtVillage" class="form-control select4" disabled required>
														<option value="">-- Option --</option>

													</select>
												</div>
											</div>
										</div>
									</div>
									<div class="panel-footer text-right">
										<div class="row text-right">
											<a href="javascript:history.back(1)" class="btn btn-primary btn-lg btn-rect">Back</a>
											&nbsp;&nbsp;
											<button class="btn btn-primary btn-lg btn-rect" type="submit">Save Data</button>
										</div>
									</div>
									
									
								
							</div>
						</div>
					</div>
					<div class="col-lg-2"></div>
				</div>
			</div>
		</div>
	</div>
</section>
</form>