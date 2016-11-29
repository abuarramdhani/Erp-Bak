<section class="content">
	<div class="inner" >
	<div class="row">
		<?php 
		foreach ($CustomerCategory as $CustomerCategory_item): 
				$tgl2 = $CustomerCategory_item['end_date'];
				//echo $tgl2;
				if($tgl2 != '')
				{	$tgl2 = date_format(date_create($CustomerCategory_item['start_date']), 'd-M-Y'); 	}
?>
		<form method="post" action="<?php echo site_url('/CustomerRelationship/Setting/CustomerCategory/PostUpdateToDb/')?>" class="form-horizontal">
				<!-- action merupakan halaman yang dituju ketika tombol submit dalam suatu form ditekan -->
				<input type="hidden" value="<?php echo $CustomerCategory_item['customer_category_id'] ?>" name="hdnCustomerCategoryId" />
				<input type="hidden" value="<?php echo date("Y-m-d H:i:s")?>" name="hdnDate" />
				<input type="hidden" value="<?php echo $this->session->userid; ?>" name="hdnUser" />
		<div class="col-lg-12">
			<div class="row">
				<div class="col-lg-12">
					<div class="col-lg-11">
						<div class="text-right">
						<h1><b>Update Customer Category</b></h1>
						</div>
					</div>
					<div class="col-lg-1">
						<div class="text-right hidden-md hidden-sm hidden-xs">
                            <a class="btn btn-default btn-lg" href="<?php echo site_url('CustomerRelationship/CustomerCategory');?>">
                                <i class="icon-wrench icon-2x"></i>
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
						<div class="panel-body">
								<div class="form-group">
										<label for="norm" class="control-label col-lg-4">Customer Category</label>
										<div class="col-lg-8">
											<input type="text" placeholder="Customer Category" name="txtCustCategory" value="<?php echo $CustomerCategory_item['customer_category_name'] ?>" class="form-control toupper" />
										</div>
								</div>
								<div class="form-group">
										<label for="norm" class="control-label col-lg-4">Relation</label>
										<div class="col-lg-2" style="margin-top:5px;" >
											<input type="checkbox" name="chkOwner" id="chkOwner" <?php if($CustomerCategory_item['owner'] == "Y") {echo "checked = checked";}?> />&nbsp;&nbsp;Owner
										</div>
										<div class="col-lg-2" style="margin-top:5px;">
											<input type="checkbox" name="chkDriver" id="chkDriver" <?php if($CustomerCategory_item['driver'] == "Y") {echo "checked = checked";}?> />&nbsp;&nbsp;Driver
										</div>
										<!--
										<div class="col-lg-1">
											<input type="checkbox" name="owner" id="owner" style="margin-top:30%;" <?php if($CustomerCategory_item['owner'] == "Y") {echo "checked = checked";}?> />
										</div>
										<label for="norm" class="control-label col-lg-1" style="margin-left:-5%;">Owner</label>
										<div class="col-lg-1">
											<input type="checkbox" name="driver" id="driver" style="margin-top:30%;" <?php if($CustomerCategory_item['driver'] == "Y") {echo "checked = checked";}?> />
										</div>
										<label for="norm" class="control-label col-lg-1" style="margin-left:-5%;">Driver</label>
										-->
								</div>
								<div class="form-group">
									<label class="control-label col-lg-4" for="dp2">Start Date</label>

									<div class="col-lg-4">
										<input type="text" maxlength="11" placeholder="<?php echo date("d-M-Y")?>" name="txtStartDate" value="<?php echo date_format(date_create($CustomerCategory_item['start_date']), 'd-M-Y') ?>" class="form-control" data-date-format="dd-M-yyyy" id="dp2" />
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-lg-4" for="dp1">End Date</label>

									<div class="col-lg-4">
										<input type="text" maxlength="11" placeholder="<?php echo date("d-M-Y")?>" name="txtEndDate" value="<?php echo $tgl2 ?>" class="form-control" data-date-format="dd-M-yyyy" id="dp3" />
									</div>
								</div>
						</div>
						<div class="panel-footer">
							<div class="row text-right">
								<a href="<?php echo site_url('CustomerRelationship/Setting/CustomerCategory');?>" class="btn btn-primary btn-lg btn-rect">Back</a>
								&nbsp;&nbsp;
								<button class="btn btn-primary btn-lg btn-rect">Save Changes</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		</form>
		<?php endforeach ?>
	</div>
	</div>
</section>