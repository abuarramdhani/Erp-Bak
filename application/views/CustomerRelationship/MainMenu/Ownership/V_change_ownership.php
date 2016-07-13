<script>
function sendValueCustomer(customer_id,customer_name,category_id){
		$('#txtOwnerName').val(customer_name);
		$('#hdnOwnerId').val(customer_id);
		$('#hdnCategoryId').val(category_id);
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
			
			<?php 
			foreach ($Ownership as $Ownership_item): 
			?>
			<form method="post" action="<?php echo site_url('CustomerRelationship/Ownership/ChangeOwnership/'.$id)?>" class="form-horizontal">
				<div class="box box-primary box-solid">
					<div class="box-header with-border">
					Header
					</div>
						<div class="row">
							<div class="col-lg-12">
					
						<input type="hidden" name="hdnUrl8" id ="hdnUrl8" value="<?php echo site_url('CustomerRelationship/Search/CustomerOwner')?>"/>
						
						<input type="hidden" value="<?php echo date("Y-m-d H:i:s")?>" name="hdnDate" />
						<input type="hidden" value="<?php echo 111111 ?>" name="hdnUser" />
						<input type="hidden" name="hdnCustomerOwnershipId" id="hdnCustomerOwnershipId" value="<?php echo $Ownership_item['customer_ownership_id']?>"/>
						<input type="hidden" name="hdnFromCustomerId" id="hdnFromCustomerId" value="<?php echo $Ownership_item['customer_id']?>" />
						<input type="hidden" name="hdnEmployeeId" id="hdnEmployeeId" value="<?php echo $Ownership_item['employee_id']?>" />
						<input type="hidden" name="hdnItemId" id="hdnItemId" value="<?php echo $Ownership_item['item_id']?>" />
						<input type="hidden" name="hdnNoBody" id="hdnNoBody" value="<?php echo $Ownership_item['no_body']?>" />
						<input type="hidden" name="hdnBuyingTypeId" id="hdnBuyingTyped" value="<?php echo $Ownership_item['buying_type_id']?>" />
						<input type="hidden" name="hdnNoEngine" id="hdnNoEngine" value="<?php echo $Ownership_item['no_engine']?>" />
						<input type="hidden" name="hdnWarranty" id="hdnWarranty" value="<?php echo $Ownership_item['warranty_expired_date']?>" />
						<input type="hidden" value="<?php echo date("Y-m-d H:i:s")?>" name="hdnDate" />
						<input type="hidden" value="<?php echo 111111 ?>" name="hdnUser" /> 
						
						<div class="box-body">
							
								<div class="form-group">
									<label for="norm" class="control-label col-lg-3">Item</label>
									<div class="col-lg-3" style="margin-top: 7px;">
										: <b><span id="spanItemCode" style="font-size:14px;"><?php echo $Ownership_item['segment1']  ?> </span></b>
									</div>
									<div class="col-lg-5" style="margin-top: 7px;">
										<span id="spanItemName" style="font-size:11px;">( <?php echo $Ownership_item['item_name']  ?> )</span>
									</div>
								</div>
								<div class="form-group">
									<label for="norm" class="control-label col-lg-3">Body Number</label>
									<div class="col-lg-8" style="margin-top: 7px;">
										: <span id="spanNoBody" style="font-size:14px;"><?php echo $Ownership_item['no_body']  ?> </span></b>
									</div>
								</div>
								<div class="form-group">
									<label for="norm" class="control-label col-lg-3">Engine Number</label>
									<div class="col-lg-8" style="margin-top: 7px;">
										: <span id="spanNoEngine" style="font-size:14px;"><?php echo $Ownership_item['no_engine']  ?> </span></b>
									</div>
								</div>
								<div class="form-group">
									<label for="norm" class="control-label col-lg-3">Buying Type</label>
									<div class="col-lg-8" style="margin-top: 7px;">
										: <span id="spanBuyingType" style="font-size:14px;"><?php echo $Ownership_item['buying_type_name']  ?> </span></b>
									</div>
								</div>
								<div class="form-group">
									<label for="norm" class="control-label col-lg-3">Warranty Expired Date</label>
									<div class="col-lg-8" style="margin-top: 7px;">
										: <span id="spanWarranty" style="font-size:14px;"><?php if($Ownership_item['warranty_expired_date'] != NULL) {echo date_format(date_create($Ownership_item['warranty_expired_date']), 'd-M-Y');} else {echo '-';}?> </span></b>
									</div>
								</div>
								<div class="form-group">
									<label for="norm" class="control-label col-lg-3">Ownership Change Date</label>
									<div class="col-lg-5">
										<input type="text" placeholder="<?php echo date("d-M-Y")?>" name="txtOwnershipChangeDate" class="form-control" data-date-format="dd-M-yyyy" id="dp2"/>
									</div>
								</div>
								<div class="form-group">
									<label for="norm" class="control-label col-lg-3">To Customer</label>
									<div class="col-lg-5">
										<input type="hidden" name="hdnCategoryId" id ="hdnCategoryId" class="form-control" />
										<input type="hidden" name="hdnOwnerId" id ="hdnOwnerId" class="form-control" />
										<!--
										<input type="text" placeholder="To Customer Name" name="txtOwnerName" id="txtOwnerName" onblur="selectCustomerOwner()" class="form-control2" />
										-->
										<div class="input-group">
										<input type="text" placeholder="To Customer Name" onfocus="callModal('<?php echo site_url('ajax/ModalCustomer')?>')" name="txtOwnerName" id="txtOwnerName" class="form-control" />
										<span class="input-group-btn">
											<a class="btn btn-primary" onclick="callModal('<?php echo site_url('ajax/ModalCustomer')?>')"><i class="icon-search"></i></a>
											
										</span>
									</div>
									</div>
									
								</div>
						
							
							<div class="panel-footer">
								<div class="row text-right">
									<a href="javascript:history.back(1)" class="btn btn-primary btn-lg btn-rect">Back</a>
									<button class="btn btn-primary btn-lg btn-rect">Save Data</button>
								</div>
							</div>
						</div>
						</div>
					</div>
				</div>
			</form>
				
				<div class="col-lg-1"></div>
				<?php endforeach ?>
			
					</div>
					</div>
						</div>
</section>

