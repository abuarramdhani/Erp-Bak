<script src="<?php echo base_url('assets/js/ChainArea.js');?>"></script>
<script>
function sendValueCustomerCategory(cat_id,cat_name){
	$('#txtCustomerCategory').val(cat_name);
	$('#txtCustomerCategoryId').val(cat_id);
}

function sendValueCustomerGroup(group_id,group_name){
	$('#txtCustomerGroup').val(group_name);
	$('#txtCustomerGroupId').val(group_id);
}
</script>
<?php
		foreach ($Customer as $Customer_item):
				$encrypted_string = $this->encrypt->encode($Customer_item['customer_id']);
				$encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
				$tgl2 = $Customer_item['end_date'];
				//echo $tgl2;
				if($tgl2 != '')
				{	$tgl2 = date_format(date_create($Customer_item['end_date']), 'd-M-Y'); 	}
?>

<section class="content">
	<div class="inner" >
	<div class="row">
		<div class="col-lg-12">
			<form method="post" action="<?php echo site_url('/CustomerRelationship/Customer/PostUpdateToDb/')?>" class="form-horizontal">
			<input type="hidden" value="<?php echo $Customer_item['customer_id'] ?>" name="hdnCustomerId" />
			<input type="hidden" value="<?php echo date("Y-m-d H:i:s")?>" name="hdnDate" />
			<input type="hidden" value="<?php echo $this->session->userid; ?>" name="hdnUser" />
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
												<input type="text" placeholder="Nama" name="txtCustomerName" value="<?php echo $Customer_item['customer_name'] ?>" class="form-control toupper" />
											</div>
									</div>
									<div class="form-group">
											<label for="norm" class="control-label col-lg-4">ID Number</label>
											<div class="col-lg-8">
												<input type="text" placeholder="KTP Number" name="txtIdNumber" class="form-control " value="<?php echo $Customer_item['id_number'] ?> " />
											</div>
									</div>
									<div class="form-group">
											<label for="autosize" class="control-label col-lg-4">Address</label>

											<div class="col-lg-8">
												<textarea id="autosize" placeholder="Address" name="txtAddress" class="form-control toupper"><?php echo $Customer_item['address'] ?></textarea>
											</div>
									</div>
									<div class="form-group">
											<label for="norm" class="control-label col-lg-4">Province</label>
											<div class="col-lg-8">
												<select name="txtProvince" id="txtProvince" data-placeholder="Province" onchange="getRegency('<?php echo base_url();?>')" class="form-control select4" required>
													<option value="">-- Option --</option>
													<?php
													foreach($Province as $ct){
														if($ct['province_id'] == $Customer_item['province_id'] ){
														?>
														<option value="<?php echo $ct['province_id'];?>" selected ><?php echo strtoupper($ct['province_name']);?></option>
														<?php
														}else{
														?>
														<option value="<?php echo $ct['province_id'];?>"><?php echo strtoupper($ct['province_name']);?></option>
														<?php
														}
													}
													?>
												</select>
											</div>
									</div>

									<div class="form-group">
											<label for="norm" class="control-label col-lg-4">City/Regency</label>
											<div class="col-lg-8">
												<!--
												<input type="text" placeholder="City / Regency" name="txtCityRegency" class="form-control toupper" value="<?php echo $Customer_item['city_regency'] ?> " />
												-->
												<select data-placeholder="City / Regency" name="txtCityRegency" id="txtCityRegency" onchange="getDistrict('<?php echo base_url();?>')" class="form-control select4" required>
													<option value="">-- Option --</option>
													<?php
													foreach($Regency as $rg){
														if($rg['city_regency_id'] == $Customer_item['city_regency_id'] ){
														?>
														<option value="<?php echo $rg['city_regency_id'];?>" selected ><?php echo strtoupper($rg['regency_name']);?></option>
														<?php
														}else{
														?>
														<option value="<?php echo $rg['city_regency_id'];?>"><?php echo strtoupper($rg['regency_name']);?></option>
														<?php
														}
													}
													?>
												</select>
											</div>
									</div>

									<div class="form-group">
											<label for="norm" class="control-label col-lg-4">District</label>
											<div class="col-lg-8">
												<!--
												<input type="text" placeholder="District" name="txtDistrict" class="form-control toupper" value="<?php echo $Customer_item['district'] ?> " />
												-->
												<select data-placeholder="District" name="txtDistrict" id="txtDistrict" onchange="getVillage('<?php echo base_url();?>')" class="form-control select4" required>
													<!--
													<option value="<?php echo $CustomerSite_item['district'] ?>" selected ><?php echo $CustomerSite_item['district'] ?></option>
													-->
													<option value="">-- Option --</option>
													<?php
													foreach($District as $ds){
														if($ds['district_id'] == $Customer_item['district_id'] ){
														?>
														<option value="<?php echo $ds['district_id'];?>" selected ><?php echo strtoupper($ds['district_name']);?></option>
														<?php
														}else{
														?>
														<option value="<?php echo $ds['district_id'];?>"><?php echo strtoupper($ds['district_name']);?></option>
														<?php
														}
													}
													?>
												</select>
											</div>
									</div>


								</div>
								<div class="col-lg-6">
									<div class="form-group">
											<label for="norm" class="control-label col-lg-4">Village</label>
											<div class="col-lg-8">
												<!--
												<input type="text" placeholder="Village" name="txtVillage" class="form-control toupper" value="<?php echo $Customer_item['village'] ?> " />
												-->
												<select data-placeholder="Village" name="txtVillage" id="txtVillage" class="form-control select4" required>
													<!--
													<option value="<?php echo $CustomerSite_item['village'] ?>"><?php echo $CustomerSite_item['village'] ?></option>
													-->
													<option value="">-- Option --</option>
													<?php
													foreach($Village as $vg){
														if($vg['village_id'] == $Customer_item['village_id'] ){
														?>
														<option value="<?php echo $vg['village_id'];?>" selected ><?php echo strtoupper($vg['village_name']);?></option>
														<?php
														}else{
														?>
														<option value="<?php echo $vg['village_id'];?>"><?php echo strtoupper($vg['village_name']);?></option>
														<?php
														}
													}
													?>
												</select>
											</div>
									</div>
									<div class="form-group">
											<label for="norm" class="control-label col-lg-4">RT</label>
											<div class="col-lg-2">
												<input type="text" placeholder="01" name="txtRt" class="form-control" value="<?php echo $Customer_item['rt'] ?>" maxlength="3"/>
											</div>
											<label for="norm" class="control-label col-lg-2">RW</label>
											<div class="col-lg-2">
												<input type="text" placeholder="02" name="txtRw" class="form-control" value="<?php echo $Customer_item['rw'] ?>" maxlength="3"/>
											</div>
									</div>



									<div class="form-group">
										<label class="control-label col-lg-4" for="dp2">Start Date</label>

										<div class="col-lg-8">
											<input type="text" maxlength="11" placeholder="<?php echo date("d-M-Y")?>" name="txtStartDate" value="<?php echo date_format(date_create($Customer_item['start_date']), 'd-M-Y') ?>" class="form-control" data-date-format="dd-M-yyyy" id="dp2" />
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-lg-4" for="dp3">End Date</label>

										<div class="col-lg-8">
											<input type="text" maxlength="11" placeholder="<?php echo date("d-M-Y")?>" name="txtEndDate" value="<?php echo $tgl2 ?>" class="form-control" data-date-format="dd-M-yyyy" id="dp10" />
										</div>
									</div>

									<div class="form-group">
											<label for="norm" class="control-label col-lg-4">Cust. Category</label>
											<div class="col-lg-8">
												<!--<input type="hidden" name="txtCustomerCategoryId" id="txtCustomerCategoryId" value="<?php echo $Customer_item['customer_category_id'] ?>" class="form-control" />
												<input type="text" placeholder="Customer Category" name="txtCustomerCategory" id="txtCustomerCategory"
												value="<?php echo $Customer_item['customer_category_name'] ?>"  onblur="selectCustomerCategory()" class="form-control2 toupper" />
												<div class="input-group">
													<input type="text" placeholder="Search Customer Category" onfocus="callModal('<?php echo site_url('ajax/ModalCustomerCategory')?>')" name="txtCustomerCategory" id="txtCustomerCategory" 	value="<?php echo $Customer_item['customer_category_name'] ?>" onkeypress="return noInput(event)" class="form-control" />
													<span class="input-group-btn">
														<a class="btn btn-primary" onclick="callModal('<?php echo site_url('ajax/ModalCustomerCategory')?>')"><i class="icon-search"></i></a>

													</span>
												</div>-->
												<select name="slcCustCategory" id="slcCustCategory" data-placeholder="Customer Category" class="form-control select4" >
													<option value="">-- Option --</option>
													<?php
													foreach($CustomerCategory as $CustomerCategory_item){
														if($CustomerCategory_item['customer_category_id'] == $Customer_item['customer_category_id'] ){
														?>
														<option value="<?php echo $CustomerCategory_item['customer_category_id'];?>" selected ><?php echo strtoupper($CustomerCategory_item['customer_category_name']);?></option>
														<?php
														}else{
														?>
														<option value="<?php echo $CustomerCategory_item['customer_category_id'];?>"><?php echo strtoupper($CustomerCategory_item['customer_category_name']);?></option>
														<?php
														}
													}
													?>
													</select>
											</div>
									</div>
									<div class="form-group">
											<label for="norm" class="control-label col-lg-4">Cust. Group</label>
											<div class="col-lg-8">
												<select name="slcCustGroup" id="slcCustGroup" data-placeholder="Customer Group" class="form-control jsCustomerGroup" >

												<option value="<?php echo $Customer_item['customer_group_id'] ?>">
														<?php 
															if($Customer_item['customer_group_id']==''){
																echo '';
															}
															else{
																echo strtoupper($Customer_item['customer_group_name']);
															}
														?>
														</option>
												</select>
											</div>
									</div>
								</div>
							</div>
							<div class="panel-footer">
								<div class="row text-right">
									<a href="javascript:history.back(1)" class="btn btn-primary btn-lg btn-rect">Back</a>
									&nbsp;&nbsp;
									<button class="btn btn-primary btn-lg btn-rect">Save Changes</button>
								</div>
							</div>
						</div>
						
					</div>
				</div>
			</div>

			</form>
		</div>
		
	</div>
	
	</div>
</section>
<?php endforeach ?>
