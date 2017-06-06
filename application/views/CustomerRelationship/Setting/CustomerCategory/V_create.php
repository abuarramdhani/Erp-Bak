<section class="content">
	<div class="inner" >
	<div class="row">
		<form method="post" action="<?php echo site_url('CustomerRelationship/Setting/CustomerCategory/Create/')?>" class="form-horizontal">
				<!-- action merupakan halaman yang dituju ketika tombol submit dalam suatu form ditekan -->
				<input type="hidden" value="<?php echo date("Y-m-d H:i:s")?>" name="hdnDate" />
				<input type="hidden" value="<?php echo $this->session->userid; ?>" name="hdnUser" />
		<div class="col-lg-12">
			<div class="row">
				<div class="col-lg-12">
					<div class="col-lg-11">
						<div class="text-right">
						<h1><b>New Customer Category</b></h1>
						</div>
					</div>
					<div class="col-lg-1">
						<div class="text-right hidden-md hidden-sm hidden-xs">
                            <a class="btn btn-default btn-lg" href="<?php echo site_url('CustomerRelationship/Setting/CustomerCategory');?>">
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
											<input type="text" placeholder="Customer Category" name="txtCustCategory" class="form-control toupper" />
										</div>
								</div>
								<div class="form-group">
										<label for="norm" class="control-label col-lg-4">Relation</label>
										<div class="col-lg-2" style="margin-top:5px;" >
											<input type="checkbox" name="chkOwner" id="chkOwner" />&nbsp;&nbsp;Owner
										</div>
										<div class="col-lg-2" style="margin-top:5px;">
											<input type="checkbox" name="chkOwner" id="chkOwner" />&nbsp;&nbsp;Driver
										</div>
								</div>
								<div class="form-group">
									<label class="control-label col-lg-4" for="dp2">Start Date</label>

									<div class="col-lg-4">
										<input type="text" maxlength="11" placeholder="<?php echo date("d-M-Y")?>" name="txtStartDate" class="form-control" data-date-format="dd-M-yyyy" id="dp2" />
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-lg-4" for="dp1">End Date</label>

									<div class="col-lg-4">
										<input type="text" maxlength="11" placeholder="<?php echo date("d-M-Y")?>" name="txtEndDate" class="form-control" data-date-format="dd-M-yyyy" id="dp3" />
									</div>
								</div>
						</div>
						<div class="panel-footer">
							<div class="row text-right">
								<a href="<?php echo site_url('CustomerRelationship/Setting/CustomerCategory');?>" class="btn btn-primary btn-lg btn-rect">Back</a>
								&nbsp;&nbsp;
								<button class="btn btn-primary btn-lg btn-rect">Save Data</button>
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
