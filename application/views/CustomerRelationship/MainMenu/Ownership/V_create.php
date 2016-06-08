<script>
function sendValueItem(item_id,segment1,item_name){
		$('#txtItemCode').val(segment1);
		$('#hdnItemId').val(item_id);
		$('#spanItem').html(item_name);
}
function sendValueEmployee(emp_id,emp_code,emp_name){
		$('#txtEmployeeNum1').val(emp_code);
		$('#hdnEmployeeId1').val(emp_id);
		$('#spanEmployee').html(emp_name);
}
function sendValueBuyingType(by_id,by_name,by_desc){
		$('#txtBuyingType').val(by_name);
		$('#hdnBuyingTypeId').val(by_id);
		$('#spanBuyingType').html(by_desc);
}
</script>
<section class="content">
	<div class="inner" >
	<div class="row">
		<div class="col-lg-12">
			<div class="row">
				<div class="col-lg-12">
					<div class="col-lg-11">
						<div class="text-right">
						<h1><b>New Ownership</b></h1>
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
						<form method="post" action="<?php echo site_url('CustomerRelationship/Ownership/New/'.$id)?>" class="form-horizontal">
						<input type="hidden" value="<?php echo date("Y-m-d H:i:s")?>" name="hdnDate" />
						<input type="hidden" value="<?php echo $this->session->userid; ?>" name="hdnUser" />
						
						<div class="panel-heading text-left">
							
						</div>
						<div class="panel-body">
							<div class="col-lg-12">
								<div class="form-group">
									<label for="norm" class="control-label col-lg-3">Item Code</label>
									<div class="col-lg-8">
										<!--<input type="hidden" name="hdnItemId" id ="hdnItemId" class="form-control"/>
										
										<input type="text"  placeholder="Item Code" name="txtItemCode" id="txtItemCode" onblur="selectItem()" class="form-control2 toupper" />
										
										<div class="input-group">
											<input type="text"  placeholder="Item Code" name="txtItemCode" id="txtItemCode" onfocus="callModal('<?php echo site_url('ajax/ModalItem')?>')" class="form-control toupper" />
											<span class="input-group-btn">
												<a class="btn btn-primary" onclick="callModal('<?php echo site_url('ajax/ModalItem')?>')"><i class="icon-search"></i></a>
												
											</span>
										</div>-->
										<select name="slcUnit" id="slcUnit" data-placeholder="Customer Unit" class="form-control select4" required>
											<option value="">-- Option --</option>
											<?php
											foreach($Unit as $Unit_item){
											?>
											<option value="<?php echo $Unit_item['item_id'];?>"><?php echo strtoupper($Unit_item['segment1'])." | ".strtoupper($Unit_item['item_name']);?></option>
											<?php
											}
											?>
										</select>
									</div>
									<div class="col-lg-4" style="margin-left:1%;width:35%;line-height: 90%;margin-top:0.5%;">
										<b><span id="spanItem" style="font-size:10px;"></span></b>
									</div>
								</div>
								<div class="form-group">
									<label for="norm" class="control-label col-lg-3">Body Number</label>
									<div class="col-lg-4">
										<input type="text" placeholder="Body Number" name="txtBodyNumber" class="form-control toupper" required/>
									</div>
								</div>
								<div class="form-group">
									<label for="norm" class="control-label col-lg-3">Engine Number</label>
									<div class="col-lg-4">
										<input type="text" placeholder="Engine Number" name="txtEngineNumber" class="form-control toupper" required/>
									</div>
								</div>
	
								<div class="form-group">
									<label for="norm" class="control-label col-lg-3">Employee</label>
									<div class="col-lg-6">
										<!--<input type="hidden" name="hdnEmployeeId" id ="hdnEmployeeId1" class="form-control" />
										<div class="input-group">
											<input type="text" placeholder="G1025" name="txtEmployeeNum" id="txtEmployeeNum1" onfocus="callModal('<?php echo site_url('ajax/ModalEmployee')?>')" class="form-control toupper" />
											<span class="input-group-btn">
												<a class="btn btn-primary" onclick="callModal('<?php echo site_url('ajax/ModalEmployee')?>')"><i class="icon-search"></i></a>
												
											</span>
										</div>
										
										<input type="text" placeholder="G1025" name="txtEmployeeNum" id="txtEmployeeNum1" onblur="selectEmployee(1)" class="form-control2 toupper" />
										-->
										<select name="slcEmployee" id="slcEmployee" data-placeholder="KHS Seller" class="form-control select4" >
											<option value="">-- Option --</option>
											<?php
											foreach($Employee as $Employee_item){
											?>
											<option value="<?php echo $Employee_item['employee_id'];?>"><?php echo strtoupper($Employee_item['employee_code'])." | ".strtoupper($Employee_item['employee_name']);?></option>
											<?php
											}
											?>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label for="norm" class="control-label col-lg-3">Buying Type</label>
									<div class="col-lg-6">
										<select name="slcBuyingType" id="slcBuyingType" data-placeholder="Buying Type" class="form-control select4" >
											<option value="">-- Option --</option>
											<?php
											foreach($BuyingType as $BuyingType_item){ 
											?>
											<option value="<?php echo $BuyingType_item['buying_type_id'];?>"><?php echo strtoupper($BuyingType_item['buying_type_name'])." | ".strtoupper($BuyingType_item['buying_type_description']);?></option>
											<?php
											}
											?>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-lg-3" for="dp2">Warranty Expired Date</label>
									<div class="col-lg-4">
										<input type="text" maxlength="11" placeholder="<?php echo date("d-M-Y")?>" name="txtWarrantyExpiredDate" value="" class="form-control" data-date-format="dd-M-yyyy" id="dp2" />
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-lg-3" for="dp2">Ownership Date</label>
									<div class="col-lg-4">
										<input type="text" maxlength="11" placeholder="<?php echo date("d-M-Y")?>" name="txtOwnershipDate" value="" class="form-control" data-date-format="dd-M-yyyy" id="dp3" required/>
									</div>
									
								</div>
								
							</div>
							<div class="col-lg-4">
								
							</div>
						</div>
						<div class="panel-footer">
							<div class="row text-right">
								<a href="javascript:history.back(1)" class="btn btn-primary btn-lg btn-rect">Back</a>
								<button class="btn btn-primary btn-lg btn-rect">Save Data</button>
							</div>
						</div>
						</form>
					</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-1"></div>
	</div>
	
	</div>
</section>
