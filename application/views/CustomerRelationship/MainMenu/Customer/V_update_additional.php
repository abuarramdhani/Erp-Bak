<script>
function sendValueAdditionalInfo(add_id,add_name,add_desc){
		$('#txtAdditionalName').val(add_name);
		$('#hdnAdditionalId').val(add_id);
		$('#spanAdditional').html(add_desc);
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
			<div class="box box-primary box-solid">
					<div class="box-header with-border">
					Header
					</div>
					<div class="box-body">
						<div class="row">
							<div class="col-lg-12">
						<form method="post" action="<?php echo site_url('CustomerRelationship/Customer/UpdateAdditionalInfo/'.$id.'/')?>" class="form-horizontal">
						<div class="panel-heading text-left">
							
						</div>
						<div class="panel-body">
							<?php 
							foreach ($AdditionalInfo as $AdditionalInfo_item): 
							?>
							<input type="hidden" name="hdnCustomerId" id="hdnCustomerId" value="<?php echo $AdditionalInfo_item['customer_id'] ?>" />
							<input type="hidden" value="<?php echo date("Y-m-d H:i:s")?>" name="hdnDate" />
							<input type="hidden" value="<?php echo $this->session->userid; ?>" name="hdnUser" />
							<?php
								$customer_id = $this->encrypt->encode($AdditionalInfo_item['customer_id']);
								$customer_id = str_replace(array('+', '/', '='), array('-', '_', '~'), $customer_id);
							?>
							
							<div class="form-group">
							<label for="norm" class="control-label col-lg-4">Additional Information</label>
								<div class="col-lg-4">
									<!--<input type="hidden" name="hdnAdditionalId" id ="hdnAdditionalId" value="<?php echo $AdditionalInfo_item['additional_id'] ?>" class="form-control"  />
									
									<input type="text"  placeholder="Additional" value="<?php echo $AdditionalInfo_item['additional_name'] ?>" name="txtAdditionalName" id="txtAdditionalName" onblur="selectCustomerAdditional()" class="form-control2" />
									
									<div class="input-group">
										<input type="text"  placeholder="Additional" name="txtAdditionalName" onfocus="callModal('<?php echo site_url('ajax/ModalAdditionalInfo')?>')" id="txtAdditionalName" value="<?php echo $AdditionalInfo_item['additional_name'] ?>"  class="form-control" />
										<span class="input-group-btn">
											<a class="btn btn-primary" onclick="callModal('<?php echo site_url('ajax/ModalAdditionalInfo')?>')"><i class="icon-search"></i></a>
											
										</span>
									</div>-->
									<select name="slcCustAdditional" id="slcCustAdditional" data-placeholder="Customer Additional" class="form-control select2" required>
										<option value="">-- Option --</option>
										<?php
										foreach($Additional as $Additional_item){
										if($Additional_item['additional_id'] == $AdditionalInfo_item['additional_id'] ){
											?>
											<option value="<?php echo $Additional_item['additional_id'];?>" selected ><?php echo strtoupper($Additional_item['additional_name'])." | ".strtoupper($Additional_item['additional_description']);?></option>
											<?php
											}else{
										?>
										<option value="<?php echo $Additional_item['additional_id'];?>"><?php echo strtoupper($Additional_item['additional_name'])." | ".strtoupper($Additional_item['additional_description']);?></option>
										<?php
											}
										}
										?>
									</select>
								</div>
								<div class="col-lg-3" style="margin-left:1%;line-height: 90%;margin-top:1%;">
									<b><span id="spanAdditional" style="font-size:10px;"><?php if ('txtEmployeeNum' != NULL) {echo $AdditionalInfo_item['additional_description'];}  ?></span></b>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-lg-4" for="dp2">Start Date</label>
								<div class="col-lg-4">
									<input type="text" maxlength="11" placeholder="<?php echo date("d-M-Y")?>" name="txtStartDate" value="<?php echo date_format(date_create($AdditionalInfo_item['start_date']), 'd-M-Y') ?>" class="form-control" data-date-format="dd-M-yyyy" id="dp2" />
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-lg-4" for="dp2">End Date</label>
								<div class="col-lg-4">
									<input type="text" maxlength="11" placeholder="<?php echo date("d-M-Y")?>" name="txtEndDate" value="<?php if ($AdditionalInfo_item['end_date'] == null) {echo $AdditionalInfo_item['end_date'];} else {echo date_format(date_create($AdditionalInfo_item['end_date']), 'd-M-Y');} ?>" class="form-control" data-date-format="dd-M-yyyy" id="dp3" />
								</div>
							</div>
						</div>
						<?php endforeach ?>
						<div class="panel-footer text-right">
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
		<div class="col-lg-4"></div>
	</div>
	
	</div>
</div>
</section>