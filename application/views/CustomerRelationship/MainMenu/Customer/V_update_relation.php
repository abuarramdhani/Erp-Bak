<section class="content">
	<div class="inner" >
	<div class="row">
		<div class="col-lg-12">
			<div class="row">
				<div class="col-lg-12">
					<div class="col-lg-11">
						<div class="text-right">
							<h1><b> Update Customer Job </b></h1>

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
						<form method="post" action="<?php echo site_url('CustomerRelationship/Customer/UpdateRelation/'.$id.'/')?>" class="form-horizontal">
						<div class="panel-heading text-left">
							
						</div>
						<div class="panel-body">
							<?php 
							foreach ($CustomerRelation as $CustomerRelation_item): 
							?>
							<input type="hidden" name="hdnUrl8" id ="hdnUrl8" value="<?php echo site_url('/CustomerRelationship/Search/CustomerOwner')?>"/>
							<input type="hidden" value="<?php echo $CustomerRelation_item['creation_date'] ?>" name="hdnDate" id="hdnDate"/>
							<input type="hidden" name="hdnCustRelationId" id="hdnCustRelationId" value="<?php echo $CustomerRelation_item['customer_id'] ?>"/>
							<input type="hidden" value="<?php echo date("Y-m-d H:i:s")?>" name="hdnDate" />
							<input type="hidden" value="<?php echo $this->session->userid; ?>" name="hdnUser" />
							<?php
								$customer_id = $this->encrypt->encode($CustomerRelation_item['customer_id']);
								$customer_id = str_replace(array('+', '/', '='), array('-', '_', '~'), $customer_id);
							?>
							
							<div class="form-group">
								<label for="norm" class="control-label col-lg-3">Category</label>
								<div class="col-lg-7">
									<select name="txtCategory" id="txtCategory" data-placeholder="Category" onchange="enadisDriverOwner();" class="form-control select4">
											<option value="">-- Please Select --</option>
											
											<?php
											foreach($categories as $ct){
											?>
												<option value="<?php echo $ct->customer_category_id;?>" <?php if ($ct->customer_category_name == $CustomerRelation_item['customer_category_name']) { echo 'selected=selected';}?>"><?php echo $ct->customer_category_name ?></option>
											<?php
												
											}
											?>
										</select>
								</div>
								
							</div>
							<div class="form-group">
								<label for="norm" class="control-label col-lg-3">Owner</label>
								<div class="col-lg-7">
									<!--<input type="hidden" name="hdnCategoryId" id="hdnCategoryId" class="form-control" />
									<input type="hidden" name="hdnOwnerId" id="hdnOwnerId" class="form-control" value="<?php echo $CustomerRelation_item['owner_id'] ?>" />
									
									<input type="text" placeholder="Owner Name" name="txtOwnerName" id="txtOwnerName" value="<?php echo $CustomerRelation_item['owner_name'] ?>" onblur="selectCustomerOwner()" class="form-control2"/>
									
									<div class="input-group">
										<input type="text" placeholder="Owner Name" onfocus="callModal('<?php echo site_url('ajax/ModalOwner')?>')" name="txtOwnerName" id="txtOwnerName" value="<?php echo $CustomerRelation_item['owner_name'] ?>" class="form-control"/>
										<span class="input-group-btn">
											<a class="btn btn-primary" onclick="callModal('<?php echo site_url('ajax/ModalOwner')?>')"><i class="icon-search"></i></a>
											
										</span>
									</div>-->
									<select name="slcCustOwner" id="slcCustOwner" data-placeholder="Owner" class="form-control select4" disabled>
										<option value="">-- Option --</option>
										<?php
										foreach($CustomerOwner as $CustomerOwner_item){
										if($CustomerOwner_item['customer_id'] == $CustomerRelation_item['owner_id'] ){
											?>
											<option value="<?php echo $CustomerOwner_item['customer_id'];?>" selected ><?php echo strtoupper($CustomerOwner_item['customer_name']);?></option>
											<?php
											}else{
											?>
											<option value="<?php echo $CustomerOwner_item['customer_id'];?>"><?php echo strtoupper($CustomerOwner_item['customer_name']);?></option>
											<?php
											}
										}
										?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-lg-3" for="dp2">Description</label>
								<div class="col-lg-7">
									<textarea placeholder="Description" name="txtDescription" class="form-control" value="" /><?php echo $CustomerRelation_item['description'] ?></textarea>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-lg-3" for="dp2">Start Date</label>
								<div class="col-lg-4">
									<input type="text" maxlength="11" placeholder="<?php echo date("d-M-Y")?>" name="txtStartDate" value="<?php echo date_format(date_create($CustomerRelation_item['start_date']), 'd-M-Y') ?>" class="form-control" data-date-format="dd-M-yyyy" id="dp2" />
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-lg-3" for="dp2">End Date</label>
								<div class="col-lg-4">
									<input type="text" maxlength="11" placeholder="<?php echo date("d-M-Y")?>" name="txtEndDate" value="<?php if ($CustomerRelation_item['end_date'] == null) {echo $CustomerRelation_item['end_date'];} else {echo date_format(date_create($CustomerRelation_item['end_date']), 'd-M-Y');} ?>" class="form-control" data-date-format="dd-M-yyyy" id="dp3" />
								</div>
							</div>
						</div>
						<?php endforeach ?>
						<div class="panel-footer text-right">
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
					</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-4"></div>
	</div>
	
	</div>
</section>