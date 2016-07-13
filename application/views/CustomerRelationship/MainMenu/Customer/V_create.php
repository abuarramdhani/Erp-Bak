<input type="hidden" value="<?php echo date("Y-m-d H:i:s")?>" name="hdnDate" />
<input type="hidden" value="<?php echo $this->session->userid; ?>" name="hdnUser" />
<section class="content">
	<div class="inner" >
	<div class="row">
		<div class="col-lg-12">
			<form method="post" action="<?php echo site_url('CustomerRelationship/Customer/Create/')?>" class="form-horizontal">
			<div class="row">
				<div class="col-lg-12">
					<div class="col-lg-11">
						<div class="text-right">
							<h1><b> <?php echo $title;?></b></h1>

						</div>
					</div>
						<div class="col-lg-1 ">
							<div class="text-right hidden-md hidden-sm hidden-xs">
								<a class="btn btn-default btn-lg" href="<?php echo site_url('CustomerRelationship/Customer');?>">
									<i class="icon-male icon-2x"></i>
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
						Header
						</div>
						<div class="box-body">
							<div class="row">
								<div class="col-lg-6">
									<div class="form-group">
											<label for="norm" class="control-label col-lg-4">Cust. Name</label>
											<div class="col-lg-8">
												<input type="text" placeholder="Nama" name="txtCustomerName" class="form-control toupper" required/>
											</div>
									</div>
									<div class="form-group">
											<label for="norm" class="control-label col-lg-4">ID Number</label>
											<div class="col-lg-8">
												<input type="text" placeholder="KTP Number" maxlength=16 onkeypress="return isNumberKey(event)" name="txtIdNumber" class="form-control" />
											</div>
									</div>


									<div class="form-group">
											<label for="autosize" class="control-label col-lg-4">Address</label>

											<div class="col-lg-8">
												<textarea id="autosize" placeholder="Address" name="txtAddress" class="form-control toupper" required></textarea>
											</div>
									</div>
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
												<!--
												<input type="text" placeholder="City / Regency" name="txtCityRegency" id="txtCityRegency" class="form-control toupper" />
												-->
												<select data-placeholder="City / Regency" name="txtCityRegency" id="txtCityRegency" onchange="getDistrict('<?php echo base_url();?>')" class="form-control select4" disabled required>
													<option value="">-- Option --</option>

												</select>
											</div>
										</div>
										<div class="form-group">
											<label for="norm" class="control-label col-lg-4">District</label>
											<div class="col-lg-8">
												<!--
												<input type="text" placeholder="Dusun" name="txtDistrict" id="txtDistrict" class="form-control toupper" />
												-->
												<select data-placeholder="District" name="txtDistrict" id="txtDistrict" onchange="getVillage('<?php echo base_url();?>')" class="form-control select4" disabled required>
													<option value="">-- Option --</option>

												</select>
											</div>
										</div>

								</div>
								<div class="col-lg-6">
									<div class="form-group">
											<label for="norm" class="control-label col-lg-4">Village</label>
											<div class="col-lg-8">
												<!--
												<input type="text"placeholder="Village" name="txtVillage" class="form-control toupper" />
												-->
												<select data-placeholder="Village" name="txtVillage" id="txtVillage" class="form-control select4" disabled required>
													<option value="">-- Option --</option>

												</select>
											</div>
										</div>
									<div class="form-group">
											<label for="norm" class="control-label col-lg-4">RT</label>
											<div class="col-lg-2">
												<input type="text" placeholder="01" name="txtRt" onkeypress="return isNumberKey(event)" class="form-control" maxlength="3"/>
											</div>

											<label for="norm" class="control-label col-lg-2">RW</label>
											<div class="col-lg-2">
												<input type="text" placeholder="01" name="txtRw" onkeypress="return isNumberKey(event)" class="form-control" maxlength="3"/>
											</div>
									</div>
									<div class="form-group">
										<label class="control-label col-lg-4" for="dp2">Start Date</label>

										<div class="col-lg-8">
											<input type="text" maxlength="11" placeholder="<?php echo date("d-M-Y")?>" name="txtStartDate" value="" class="form-control datepicker"  data-date-format="dd-M-yyyy" required />
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-lg-4" for="dp3">End Date</label>

										<div class="col-lg-8">
											<input type="text" maxlength="11" placeholder="<?php echo date("d-M-Y")?>" name="txtEndDate" value="" class="form-control datepicker" data-date-format="dd-M-yyyy" />
										</div>
									</div>
									<div class="form-group">
											<label for="norm" class="control-label col-lg-4">Cust. Category</label>
											<div class="col-lg-8">
												<!--<input type="hidden" name="txtCustomerCategoryId" id="txtCustomerCategoryId" class="form-control" />
												
												<input type="text" placeholder="Customer Category" name="txtCustomerCategory" id="txtCustomerCategory" onblur="selectCustomerCategory()" class="form-control2 toupper" />
													<input type="text" placeholder="Search Customer Category" name="txtCustomerCategory" id="txtCustomerCategory" onfocus="callModal('<?php echo site_url('ajax/ModalCustomerCategory')?>')" class="form-control" required/>
													<span class="input-group-btn">
														<a class="btn btn-primary" onclick="callModal('<?php echo site_url('ajax/ModalCustomerCategory')?>')"><i class="icon-search"></i></a>

													</span>-->
													<select name="slcCustCategory" id="slcCustCategory" data-placeholder="Customer Category" class="form-control select4" >
													<option value="">-- Option --</option>
													<?php
													foreach($CustomerCategory as $CustomerCategory_item){
													?>
													<option value="<?php echo $CustomerCategory_item['customer_category_id'];?>"><?php echo strtoupper($CustomerCategory_item['customer_category_name']);?></option>
													<?php
													}
													?>
													</select>
											</div>

									</div>
									<div class="form-group">
											<label for="norm" class="control-label col-lg-4">Cust. Group</label>
											<div class="col-lg-8">
												<!--<input type="hidden" name="txtCustomerGroupId" id="txtCustomerGroupId" class="form-control" />
												
												<input type="text" placeholder="Customer Group" name="txtCustomerGroup" id="txtCustomerGroup" onblur="selectCustomerGroup()" class="form-control2 toupper" />
												
												<div class="input-group">
													<input type="text" placeholder="Search Customer Group" name="txtCustomerGroup" id="txtCustomerGroup" onfocus="callModal('<?php echo site_url('ajax/ModalCustomerGroup')?>')" onkeypress="return noInput(event)" class="form-control" />
													<span class="input-group-btn">
														<a class="btn btn-primary" onclick="callModal('<?php echo site_url('ajax/ModalCustomerGroup')?>')"><i class="icon-search"></i></a>

													</span>
												</div>
												-->
												<select name="slcCustGroup" id="slcCustGroup" data-placeholder="Customer Group" class="form-control jsCustomerGroup" >
												<option value=""></option>
												</select>
											</div>
									</div>
								</div>
							</div>
							<div class="panel-footer">
								<div class="row text-right">
									<a href="<?php echo site_url('CustomerRelationship/Customer');?>" class="btn btn-primary btn-lg btn-rect">Back</a>
									&nbsp;&nbsp;
									<button class="btn btn-primary btn-lg btn-rect">Save Data</button>
								</div>
							</div>
						</div>
					</div>

				</div>
			</div>

			</form>
		</div>
		<div class="col-lg-2"></div>
	</div>
	
	
	</div>
<section class="content">
