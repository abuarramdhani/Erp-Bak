<section class="content">
	<div class="inner" >
		<div class="row">
			<form method="post" id="frmDeliveryRequestApproval" action="<?php echo site_url('InventoryManagement/DeliveryRequestApproval/Create')?>" class="form-horizontal">
					<!-- action merupakan halaman yang dituju ketika tombol submit dalam suatu form ditekan -->
					<input type="hidden" value="<?php echo date("Y-m-d H:i:s")?>" name="hdnDate" />
					<input type="hidden" value="<?php echo $this->session->userid; ?>" name="hdnUser" />
			<div class="col-lg-12">
				<div class="row">
						<div class="col-lg-12">
							<div class="col-lg-11">
								<div class="text-right">
								<h1><b><?= $Title?></b></h1>

								</div>
							</div>
							<div class="col-lg-1 ">
								<div class="text-right hidden-md hidden-sm hidden-xs">
									<a class="btn btn-default btn-lg" href="<?php echo site_url('InventoryManagement/DeliveryRequestApproval/');?>">
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
						<div class="box-body">
							<div class="panel-body">
								<div class="row">
									<div class="col-lg-12">
										<div class="form-group">
											<label class="control-label col-lg-4">Approver</label>
											<div class="col-lg-4">
												<select name="slcApprover" id="slcApprover" class="form-control jsOracleEmployee"  >
													<option value=""></option>
												</select>
											</div>
										</div>
									</div><!--
									<div class="col-lg-12">
										<div class="form-group">
											<label class="control-label col-lg-4">Branch</label>
											<div class="col-lg-4">
												<select name="slcBranch[]" id="slcBranch" multiple="multiple" class="form-control select4"  >
													<?php 	foreach($Branch as $Branch_item){
													?>	<option value="<?=$Branch_item['ORGANIZATION_ID']?>"><?=$Branch_item['NAME']?></option>
													<?php
													}
													?>
												</select>
											</div>
										</div>
									</div>-->
									<div class="col-lg-12">
										<div class="form-group">
											<label class="control-label col-lg-4">Active</label>
											<div class="col-lg-2">
												<select name="slcActive" id="slcActive" class="form-control select4"  >
													<option value=""></option>
													<option value="Y">Yes</option>
													<option value="N">No</option>
												</select>
											</div>
										</div>
									</div>
								</div>
								
								
							</div>
							<div class="panel-footer">
								<div class="row text-right">
									<a href="javascript:history.back(1)" class="btn btn-primary btn-lg btn-rect">Back</a>
									&nbsp;&nbsp;
									<button id="btnUser" class="btn btn-primary btn-lg btn-rect">Save Data</button>
								</div>
							</div>
						</div>
						</div>
					</div>
				</div>
			</div>
			</form>
		</div>
	</div>
</section>