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
					 //print_r ($Driver);
					foreach ($CustomerDriver as $CustomerDriver_item): 
							//$tgl2 = $CustomerDriver_item['end_date'];
							//echo $tgl2;
							//if($tgl2 != '')
							//{	$tgl2 = date_format(date_create($CustomerDriver_item['end_date']), 'd-M-Y'); 	}
				?>
				<div class="col-lg-2"></div>
				<div class="col-lg-8">
					<div class="panel panel-default">
						<form method="post" action="<?php echo site_url('/CustomerRelationship/CustomerDriver/Update/'.$id)?>" class="form-horizontal">
						<input type="hidden" name="hdnOwnerId" id="hdnOwnerId" value="<?php echo $CustomerDriver_item['owner_id']?>"/>
						<input type="hidden" value="<?php echo date("Y-m-d H:i:s")?>" name="hdnDate" />
						<input type="hidden" value="<?php echo $this->session->userid; ?>" name="hdnUser" />
						
						<div class="panel-heading text-left">
							
						</div>
						<div class="panel-body">
							<div class="form-group">
								<label for="norm" class="control-label col-lg-3">Driver Name</label>
								<div class="col-lg-7">
									<!--<input type="hidden" name="hdnDriverId" id="hdnDriverId" value="<?php echo $CustomerDriver_item['customer_id']?>" class="form-control"/>
									
									<input type="text" placeholder="Tractor Driver Name" name="txtDriverName" id="txtDriverName" value="<?php echo $CustomerDriver_item['customer_name'] ?>" onblur="selectCustomerDriver()" class="form-control2" />
									
									<div class="input-group">
										<input type="text" placeholder="Driver Name" name="txtDriverName" onfocus="callModal('<?php echo site_url('ajax/ModalDriver')?>')" id="txtDriverName" class="form-control" value="<?php echo $CustomerDriver_item['customer_name'] ?>"/>
										<span class="input-group-btn">
											<a class="btn btn-primary" onclick="callModal('<?php echo site_url('ajax/ModalDriver')?>')"><i class="icon-search"></i></a>
											
										</span>
									</div>-->
									<select name="slcCustDriver" id="slcCustDriver" data-placeholder="Customer Driver" class="form-control select4" required>
									<option value="">-- Option --</option>
									<?php
									foreach($Driver as $Driver_item){
										if($Driver_item['customer_id'] == $CustomerDriver_item['customer_id'] ){
										?>
										<option value="<?php echo $Driver_item['customer_id']."-".$Driver_item['customer_category_id'];?>" selected ><?php echo strtoupper($Driver_item['customer_name']);?></option>
										<?php
										}else{
										?>
										<option value="<?php echo $Driver_item['customer_id']."-".$Driver_item['customer_category_id'];?>"><?php echo strtoupper($Driver_item['customer_name']);?></option>
										
										<?php
										}
									}
									?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-lg-3" for="dp2">Start Date</label>
								<div class="col-lg-4">
									<input type="text" maxlength="11" placeholder="<?php echo date("d-M-Y")?>" name="txtStartDate" value="<?php echo date_format(date_create($CustomerDriver_item['start_date']), 'd-M-Y') ?>" class="form-control" data-date-format="dd-M-yyyy" id="dp2" />
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-lg-3" for="dp2">End Date</label>
								<div class="col-lg-4">
									<input type="text" maxlength="11" placeholder="<?php echo date("d-M-Y")?>" name="txtEndDate" value="<?php if ($CustomerDriver_item['end_date'] == null) {echo $CustomerDriver_item['end_date'];} else {echo date_format(date_create($CustomerDriver_item['end_date']), 'd-M-Y');}?>" class="form-control" data-date-format="dd-M-yyyy" id="dp3" />
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-lg-3" for="dp2">Description</label>
								<div class="col-lg-7">
									<textarea placeholder="Description" value="" name="txtDescription" class="form-control"  /><?php echo $CustomerDriver_item['description'] ?></textarea>
								</div>
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
								<button class="btn btn-primary btn-lg btn-rect">Save Changes</button>
							</div>
						</div>
						</form>
					</div>	
				</div>
				<?php endforeach ?>
					</div>
				</div>
				</div>
			</div>
		</div>
		<div class="col-lg-3"></div>
	</div>
	
	</div>
</section>
