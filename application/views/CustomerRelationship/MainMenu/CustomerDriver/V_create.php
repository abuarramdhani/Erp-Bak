<section class="content">
	<div class="inner" >
	<div class="row">
		<div class="col-lg-12">
			<div class="row">
				<div class="col-lg-12">
					<div class="col-lg-11">
						<div class="text-right">
						<h1><b>New Driver</b></h1>
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
						<form method="post" action="<?php echo site_url('CustomerRelationship/CustomerDriver/Create/'.$id)?>" class="form-horizontal" >
						<input type="hidden" value="<?php echo date("Y-m-d H:i:s")?>" name="hdnDate" />
						<input type="hidden" value="<?php echo $this->session->userid; ?>" name="hdnUser" />
						<input type="hidden" name="hdnOwnerId" id="hdnOwnerId" />
						
						<div class="panel-heading text-left">
							
						</div>
						<div class="panel-body">
							<div class="form-group">
								<label for="norm" class="control-label col-lg-3">Driver Name</label>
								<div class="col-lg-7">
									<!--<input type="hidden" name="hdnDriverId" id="hdnDriverId" class="form-control"/>
									<div class="input-group">
										<input type="text" placeholder="Driver Name" name="txtDriverName" id="txtDriverName" onfocus="callModal('<?php echo site_url('ajax/ModalDriver')?>')" class="form-control" />
										<span class="input-group-btn">
											<a class="btn btn-primary" onclick="callModal('<?php echo site_url('ajax/ModalDriver')?>')"><i class="icon-search"></i></a>
											
										</span>
									</div>
									
									<input type="text" placeholder="Driver Name" name="txtDriverName" id="txtDriverName" onblur="selectCustomerDriver()" class="form-control" readonly="true"/>
									-->
									<select name="slcCustDriver" id="slcCustDriver" data-placeholder="Customer Driver" class="form-control select4" required>
									<option value="">-- Option --</option>
									<?php
									foreach($Driver as $Driver_item){
									?>
									<option value="<?php echo $Driver_item['customer_id']."-".$Driver_item['customer_category_id'];?>"><?php echo strtoupper($Driver_item['customer_name']);?></option>
									
									<?php
									}
									?>
									</select>
								</div>
								
							</div>
							
							<div class="form-group">
								<label class="control-label col-lg-3" for="dp2">Start Date</label>
								<div class="col-lg-4">
									<input type="text" maxlength="11" placeholder="<?php echo date("d-M-Y")?>" name="txtStartDate" value="" class="form-control" data-date-format="dd-M-yyyy" id="dp2" />
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-lg-3" for="dp2">End Date</label>
								<div class="col-lg-4">
									<input type="text" maxlength="11" placeholder="<?php echo date("d-M-Y")?>" name="txtEndDate" value="" class="form-control" data-date-format="dd-M-yyyy" id="dp3" />
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-lg-3" for="dp2">Description</label>
								<div class="col-lg-7">
									<textarea placeholder="Description" name="txtDescription" class="form-control"  /></textarea>
								</div>
							</div>
						</div>
						<div class="panel-footer">
							<div class="row text-right">
								<a href="javascript:history.back(1)" class="btn btn-primary btn-lg btn-rect">Back</a>
								<button class="btn btn-primary btn-lg btn-rect">Save Data</button>
								<!--
								<a class="btn btn-success" href="<?php echo site_url('ajax/tesModal')?>" data-toggle="modal" data-target="#CustomerModal">
                                Click Here To Launch
								</a>
								-->
							</div>
						</div>
						</form>
					</div>	
					</div>	
				</div>
			</div>
		</div>
		<div class="col-lg-3"></div>
	</div>
	<!-- Modal Start -->
	<!--
	<div class="col-lg-12">
		<div class="modal fade" id="myModal" tabindex="-1" role="dialog"  aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
				
				</div>
            </div>
        </div>
    </div>
	-->
	<!-- Modal End -->
	</div>
</section>
