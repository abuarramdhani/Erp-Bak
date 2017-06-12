<form method="post" id="form-customer-group" action="<?php echo site_url('/CustomerRelationship/CustomerGroup/PostUpdateToDb/')?>" class="form-horizontal">
<input type="hidden" value="<?php echo date("Y-m-d H:i:s")?>" name="hdnDate" />
<input type="hidden" value="<?php echo $this->session->userid; ?>" name="hdnUser" />
<section class="content">
	<div class="inner" >
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11">
							<div class="text-right">
								<h1><b> <?php echo $title;?></b></h1>
							
							</div>
						</div>
							<div class="col-lg-1 ">
								<div class="text-right hidden-md hidden-sm hidden-xs">
									<a class="btn btn-default btn-lg" href="<?php echo site_url('CustomerRelationship/CustomerGroup');?>">
										<i class="icon-group icon-2x"></i>
										<span ><br /></span>
									</a>
									

								</div>
							</div>
					</div>
				</div>
					<?php
					foreach ($CustomerGroup as $CustomerGroup_item):
							$encrypted_string = $this->encrypt->encode($CustomerGroup_item['customer_group_id']);
							$encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
						
					?>	
					<input type="hidden" value="<?php echo $CustomerGroup_item['customer_group_id'] ?>" name="hdnCustomerGroupId" />
				<div class="box box-primary box-solid">
					<div class="box-header with-border">
					Header
					</div>
					<div class="box-body">
						<div class="row">
							<div class="col-lg-12">
								<div class="box-body">
									<div class="col-lg-12">
										<div class="form-group">
											<label for="norm" class="control-label col-lg-2">Group Name</label>
											<div class="col-lg-4">
												<input type="text" placeholder="Customer Group" name="txtCustomerGroup" value="<?php echo $CustomerGroup_item['customer_group_name'] ?>" class="form-control toupper" required/>
											</div>
										</div>
										<div class="form-group">
											<label for="autosize" class="control-label col-lg-2">Address</label>

											<div class="col-lg-4">
												<textarea id="autosize" placeholder="Address Customer Group" name="txtAddress" class="form-control toupper"><?php echo $CustomerGroup_item['address'] ?></textarea>
											</div>
										</div>

										</div>
									<div class="col-lg-6">
										<div class="form-group">
											<label for="norm" class="control-label col-lg-4">Province</label>
											<div class="col-lg-8">
												<select name="txtProvince" id="txtProvince" data-placeholder="Province" onchange="getRegency('<?php echo base_url();?>')" class="form-control select4">
													<option value="">-- Option --</option>
													<?php
													foreach($Province as $ct){
														if($ct['province_id'] == $CustomerGroup_item['province_id'] ){
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
											<label for="norm" class="control-label col-lg-4">City / Regency</label>
											<div class="col-lg-8">
												<select data-placeholder="City / Regency" name="txtCityRegency" id="txtCityRegency" onchange="getDistrict('<?php echo base_url();?>')" class="form-control select4">
													<option value="">-- Option --</option>
													<?php
													foreach($Regency as $rg){
														if($rg['city_regency_id'] == $CustomerGroup_item['city_regency_id'] ){
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
												<select data-placeholder="District" name="txtDistrict" id="txtDistrict" onchange="getVillage('<?php echo base_url();?>')" class="form-control select4">
													
													<option value="">-- Option --</option>
													<?php
													foreach($District as $ds){
														if($ds['district_id'] == $CustomerGroup_item['district_id'] ){
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
										<div class="form-group">
											<label for="norm" class="control-label col-lg-4">Village</label>
											<div class="col-lg-8">
												<select data-placeholder="Village" name="txtVillage" id="txtVillage" class="form-control select4">
													<option value="">-- Option --</option>
													<?php
													foreach($Village as $vg){
														if($vg['village_id'] == $CustomerGroup_item['village_id'] ){
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
										
									</div>
								</div>
								<div class="panel-footer text-right">
									<div class="row text-right">
										<a href="javascript:history.back(1)" class="btn btn-primary btn-lg btn-rect">Back</a>
										&nbsp;&nbsp;
										<button class="btn btn-primary btn-lg btn-rect" type="submit">Save Changes</button>
									</div>
								</div>
							</div>
						</div>
					</div>
					
				
				<?php endforeach ?>
				</div>	
				<div class="col-lg-2"></div>
			</div>
		</div>
	</div>
</section>
</form>