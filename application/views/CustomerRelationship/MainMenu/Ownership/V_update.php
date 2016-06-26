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
			<div class="box box-primary box-solid">
					<div class="box-header with-border">
					Header
					</div>
					<div class="box-body">
						<div class="row">
							<div class="col-lg-12">
					<?php 
					foreach ($Ownership as $Ownership_item): 
					?>
						<form method="post" action="<?php echo site_url('CustomerRelationship/Ownership/Update/'.$id)?>" class="form-horizontal">
						<input type="hidden" name="hdnCustomerOwnershipId" id="hdnCustomerOwnershipId" value="<?php echo $Ownership_item['customer_ownership_id']?>"/>
						<input type="hidden" name="hdnCustomerId" id="hdnCustomerId" value="<?php echo $Ownership_item['customer_id']?>" />
						
						
						<input type="hidden" value="<?php echo date("Y-m-d H:i:s")?>" name="hdnDate" />
						<input type="hidden" value="<?php echo $this->session->userid; ?>" name="hdnUser" /> 
						
						<div class="panel-heading text-left">
							
						</div>
						<div class="panel-body">
							<div class="col-lg-12">
								<div class="form-group">
									<label for="norm" class="control-label col-lg-3">Item Code</label>
									<div class="col-lg-8">
										<!--<input type="hidden" name="hdnItemId" id="hdnItemId" value="<?php echo $Ownership_item['item_id']?>" class="form-control" />
										
										<input type="text"  placeholder="Item Code" name="txtItemCode" id="txtItemCode" value="<?php echo $Ownership_item['segment1'] ?>" onblur="selectItem()" class="form-control2 toupper" />
										
										<div class="input-group">
											<input type="text"  placeholder="Item Code" onfocus="callModal('<?php echo site_url('ajax/ModalItem')?>')" name="txtItemCode" id="txtItemCode" value="<?php echo $Ownership_item['segment1'] ?>"  class="form-control toupper" />
											<span class="input-group-btn">
												<a class="btn btn-primary" onclick="callModal('<?php echo site_url('ajax/ModalItem')?>')"><i class="icon-search"></i></a>
												
											</span>
										</div>-->
										<select name="slcUnit" id="slcUnit" data-placeholder="Customer Unit" class="form-control select4" required>
											<option value="">-- Option --</option>
											<?php
											foreach($Unit as $Unit_item){
												if($Unit_item['item_id'] == $Ownership_item['item_id'] ){
												?>
												<option value="<?php echo $Unit_item['item_id'];?>" selected ><?php echo strtoupper($Unit_item['segment1'])." | ".strtoupper($Unit_item['item_name']);?></option>
												<?php
												}else{
											?>
											<option value="<?php echo $Unit_item['item_id'];?>"><?php echo strtoupper($Unit_item['segment1'])." | ".strtoupper($Unit_item['item_name']);?></option>
											<?php
												}
											}
											?>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label for="norm" class="control-label col-lg-3">Body Number</label>
									<div class="col-lg-4">
										<input type="text" placeholder="Body Number" name="txtBodyNumber" value="<?php echo $Ownership_item['no_body'] ?>" class="form-control toupper" />
									</div>
								</div>
								<div class="form-group">
									<label for="norm" class="control-label col-lg-3">Engine Number</label>
									<div class="col-lg-4">
										<input type="text" placeholder="Engine Number" name="txtEngineNumber" value="<?php echo $Ownership_item['no_engine'] ?>" class="form-control toupper" />
									</div>
								</div>
								<div class="form-group">
									<label for="norm" class="control-label col-lg-3">Employee Number</label>
									<div class="col-lg-6">
										<!--<input type="hidden" name="hdnEmployeeId" id="hdnEmployeeId1" value="<?php echo $Ownership_item['employee_id']?>" class="form-control" />
										
										<input type="text" placeholder="G1025" name="txtEmployeeNum" id="txtEmployeeNum1" value="<?php echo $Ownership_item['employee_code'] ?>" onblur="selectEmployee(1)" class="form-control2 toupper"  />
										
										<div class="input-group">
											<input type="text" placeholder="G1025" name="txtEmployeeNum" onfocus="callModal('<?php echo site_url('ajax/ModalEmployee')?>')" id="txtEmployeeNum1" value="<?php echo $Ownership_item['employee_code'] ?>" class="form-control toupper" />
											<span class="input-group-btn">
												<a class="btn btn-primary" onclick="callModal('<?php echo site_url('ajax/ModalEmployee')?>')"><i class="icon-search"></i></a>
												
											</span>
										</div>-->
										<select name="slcEmployee" id="slcEmployee" data-placeholder="KHS Seller" class="form-control select4" >
											<option value="">-- Option --</option>
											<?php
											foreach($Employee as $Employee_item){
												if($Employee_item['employee_id'] == $Ownership_item['employee_id'] ){
												?>
												<option value="<?php echo $Employee_item['employee_id'];?>" selected ><?php echo strtoupper($Employee_item['employee_code'])." | ".strtoupper($Employee_item['employee_name']);?></option>
												<?php
												}else{
											?>
											<option value="<?php echo $Employee_item['employee_id'];?>"><?php echo strtoupper($Employee_item['employee_code'])." | ".strtoupper($Employee_item['employee_name']);?></option>
											<?php
												}
											}
											?>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label for="norm" class="control-label col-lg-3">Buying Type</label>
									<div class="col-lg-6">
										<!--<input type="hidden" name="hdnBuyingTypeId" id ="hdnBuyingTypeId" value="<?php echo $Ownership_item['buying_type_id'] ?>" class="form-control" />
										
										<input type="text" placeholder="Buying Type" name="txtBuyingType" id="txtBuyingType" value="<?php echo $Ownership_item['buying_type_name'] ?>" onblur="selectBuyingType()" class="form-control2" />
										
										<div class="input-group">
											<input type="text" placeholder="Buying Type" name="txtBuyingType" onfocus="callModal('<?php echo site_url('ajax/ModalBuyingType')?>')" id="txtBuyingType" value="<?php echo $Ownership_item['buying_type_name'] ?>"  class="form-control" />
											<span class="input-group-btn">
												<a class="btn btn-primary"  onclick="callModal('<?php echo site_url('ajax/ModalBuyingType')?>')"><i class="icon-search"></i></a>
												
											</span>
										</div>-->
										<select name="slcBuyingType" id="slcBuyingType" data-placeholder="Buying Type" class="form-control select4" >
											<option value="">-- Option --</option>
											<?php
											foreach($BuyingType as $BuyingType_item){ 
												if($BuyingType_item['buying_type_id'] == $Ownership_item['buying_type_id'] ){
												?>
												<option value="<?php echo $BuyingType_item['buying_type_id'];?>" selected ><?php echo strtoupper($BuyingType_item['buying_type_name'])." | ".strtoupper($BuyingType_item['buying_type_description']);?></option>
												<?php
												}else{
											?>
											<option value="<?php echo $BuyingType_item['buying_type_id'];?>"><?php echo strtoupper($BuyingType_item['buying_type_name'])." | ".strtoupper($BuyingType_item['buying_type_description']);?></option>
											<?php
												}
											}
											?>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label for="norm" class="control-label col-lg-3">Warranty Expired Date</label>
									<div class="col-lg-4">
										<input type="text"placeholder="<?php echo date("d-M-Y")?>" name="txtWarrantyExpiredDate" value="<?php echo date_format(date_create($Ownership_item['warranty_expired_date']), 'd-M-Y')?>" class="form-control" data-date-format="dd-M-yyyy" id="dp2" />
									</div>
								</div>
								<div class="form-group">
									<label for="norm" class="control-label col-lg-3">Ownership Date</label>
									<div class="col-lg-4">
										<input type="text"placeholder="<?php echo date("d-M-Y")?>" name="txtOwnershipDate" value="<?php echo date_format(date_create($Ownership_item['ownership_date']), 'd-M-Y')?>" class="form-control" data-date-format="dd-M-yyyy" id="dp3"/>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-lg-3" for="dp2">Goverment Project</label>
									<div class="col-lg-4">
										<select name="slcGov" id="slcGov" data-placeholder="Goverment" class="form-control select4" >
											<option value="">-- Option --</option>
											<?php
											foreach($Goverment as $Goverment_item){ 
											?>
											<option value="<?php echo $Goverment_item['BILL_CUST_NAME'];?>"
											<?php echo ($Goverment_item['BILL_CUST_NAME']==$Ownership_item['goverment_project'])?"selected":""; ?> ><?php echo strtoupper($Goverment_item['BILL_CUST_NAME']);?></option>
											<?php
											}
											?>
										</select>
									</div>
									
								</div>
								
							</div>
							<div class="col-lg-4">
								
							</div>
						</div>
						<div class="panel-footer">
							<div class="row text-right">
								<?php
								if (isset($_SERVER["HTTP_REFERER"])) {
									$location = $_SERVER["HTTP_REFERER"];
								}else{
									$location="";
								}
								?>
								<a href="javascript:history.back(1)" class="btn btn-primary btn-lg btn-rect">Back</a>
								<button class="btn btn-primary btn-lg btn-rect">Save Data</button>
							</div>
						</div>
						</form>
						<?php endforeach ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-1"></div>
	</div>
	
	</div>
</section>

