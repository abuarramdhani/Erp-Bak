<script src="<?php echo base_url('assets/js/ChainArea.js');?>"></script>
<section class="content">
	<div class="inner" >
	<div class="row">
		<div class="col-lg-12">
			<div class="row">
				<div class="col-lg-12">
					<div class="col-lg-11">
						<div class="text-right">
							<h1><b> Update Costumer Site </b></h1>

						</div>
					</div>
					<div class="col-lg-1">
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
						<?php 
						foreach ($CustomerSite as $CustomerSite_item): 
						?>
						<form method="post" action="<?php echo site_url('/CustomerRelationship/Customer/UpdateSite/'.$id.'/')?>" class="form-horizontal">
						<div class="panel-heading text-left">
							
						</div>
						<div class="panel-body">
							<input type="hidden" value="<?php echo $CustomerSite_item['customer_id'] ?>" name="hdnCustomerSiteId" />
							<input type="hidden" value="<?php echo date("Y-m-d H:i:s")?>" name="hdnDate" />
							<input type="hidden" value="<?php echo $this->session->userid; ?>" name="hdnUser" />
							<?php
								$customer_id = $this->encrypt->encode($CustomerSite_item['customer_id']);
								$customer_id = str_replace(array('+', '/', '='), array('-', '_', '~'), $customer_id);
							?>
							<div class="col-lg-6">
								<div class="form-group">
									<label for="norm" class="control-label col-lg-4">Site Name</label>
									<div class="col-lg-8">
										<input type="text" placeholder="Name" name="txtSiteName" value="<?php echo $CustomerSite_item['site_name'] ?>" class="form-control toupper" required/>
									</div>
								</div>
								<div class="form-group">
									<label for="norm" class="control-label col-lg-4">Address</label>
									<div class="col-lg-8">
										<textarea id="autosize" placeholder="Address" name="txtAddress" class="form-control toupper"><?php echo $CustomerSite_item['address'] ?></textarea>
																			
									</div>
								</div>
								<div class="form-group">
									<label for="norm" class="control-label col-lg-4">Province</label>
									<div class="col-lg-8">
										<select name="txtProvince" id="txtProvince" data-placeholder="Province" onchange="getRegency('<?php echo base_url();?>')" class="form-control select4">
											<option value="">-- Option --</option>
											<?php
											foreach($Province as $ct){
												if($ct['province_id'] == $CustomerSite_item['province_id'] ){
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
										<!--
										<input type="text" placeholder="Province" name="txtProvince" value="<?php echo $CustomerSite_item['province'] ?> " class="form-control" />
										-->
									</div>
								</div>
								<div class="form-group">
									<label for="norm" class="control-label col-lg-4">City / Regency</label>
									<div class="col-lg-8">
										<!--
										<input type="text" placeholder="City / Regency" name="txtCityRegency" value="<?php echo $CustomerSite_item['city_regency'] ?> " class="form-control" />
										-->
										<select data-placeholder="City / Regency" name="txtCityRegency" id="txtCityRegency" onchange="getDistrict('<?php echo base_url();?>')" class="form-control select4">
											<option value="">-- Option --</option>
											<?php
											foreach($Regency as $rg){
												if($rg['city_regency_id'] == $CustomerSite_item['city_regency_id'] ){
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
										<input type="text" placeholder="Dusun" name="txtDusun" value="<?php echo $CustomerSite_item['district'] ?> " class="form-control" />
										-->
										<select data-placeholder="District" name="txtDistrict" id="txtDistrict" onchange="getVillage('<?php echo base_url();?>')" class="form-control select4">
											<!--
											<option value="<?php echo $CustomerSite_item['district'] ?>" selected ><?php echo $CustomerSite_item['district'] ?></option>
											-->
											<option value="">-- Option --</option>
											<?php
											foreach($District as $ds){
												if($ds['district_id'] == $CustomerSite_item['district_id'] ){
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
							<div class="col-lg-6" style="margin-top:11%;">
								
								<div class="form-group">
									<label for="norm" class="control-label col-lg-4">Village</label>
									<div class="col-lg-8">
										<!--
										<input type="text"placeholder="Village" name="txtVillage" value="<?php echo $CustomerSite_item['village'] ?> " class="form-control" />
										-->
										<select data-placeholder="Village" name="txtVillage" id="txtVillage" class="form-control select4">
											<!--
											<option value="<?php echo $CustomerSite_item['village'] ?>"><?php echo $CustomerSite_item['village'] ?></option>
											-->
											<option value="">-- Option --</option>
											<?php
											foreach($Village as $vg){
												if($vg['village_id'] == $CustomerSite_item['village_id'] ){
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
									<label for="norm" class="control-label col-lg-4">RW</label>
									<div class="col-lg-8">
										<input type="text" placeholder="02" name="txtRw" value="<?php echo $CustomerSite_item['rw'] ?>" class="form-control" maxlength="3"/>
									</div>
								</div>
								<div class="form-group">
									<label for="norm" class="control-label col-lg-4">RT</label>
									<div class="col-lg-8">
										<input type="text" placeholder="01" name="txtRt" value="<?php echo $CustomerSite_item['rt'] ?>" class="form-control" maxlength="3"/>
									</div>
								</div>
								
							</div>
						</div>
						
						<div class="panel-footer text-right">
							<div class="row text-right">
								<a href="javascript:history.back(1)" class="btn btn-primary btn-lg btn-rect">Back</a>
								<button class="btn btn-primary btn-lg btn-rect">Save Changes</button>
							</div>
						</div>
						</form>
						<?php endforeach ?>
					</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-2"></div>
	</div>
	</div>
</section>
