<section class="content">
	<div class="inner" >
	<div class="row">
		<div class="col-lg-12">
			<div class="row">
				<div class="col-lg-12">
					<div class="col-lg-11">
						<div class="text-right">
							<h1><b> New Costumer Contact </b></h1>

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
						<form method="post" action="<?php echo site_url('CustomerRelationship/Customer/CreateContact/'.$id.'/')?>" class="form-horizontal">
						<div class="panel-heading text-left">
							
						</div>
						<div class="panel-body">
							
							<input type="hidden" value="<?php echo date("Y-m-d H:i:s")?>" name="hdnDate" />
							<input type="hidden" value="<?php echo $this->session->userid; ?>" name="hdnUser" />
							
							
							<div class="form-group">
								<label for="norm" class="control-label col-lg-3">Type</label>
								<div class="col-lg-7">
									<select  name="txtType" data-placeholder="Contact type" onchange="contact();" class="form-control select4">
									  <option value="" ></option>
									  <option value="HANDPHONE" >HANDPHONE</option>
									  <option value="TELEPHONE" >TELEPHONE</option>
									  <option value="EMAIL">EMAIL</option>
									  <option value="PIN BBM">PIN BBM</option>
									</select>									
								</div>
							</div>
							<div class="form-group">
								<label for="norm" class="control-label col-lg-3">Data</label>
								<div class="col-lg-7">
									<input type="text" placeholder="Data" name="txtData" id="txtData" class="form-control" />
								</div>
							</div>
							<div class="form-group">
								<label for="norm" class="control-label col-lg-3">Description</label>
								<div class="col-lg-7">
									<textarea placeholder="Description" name="txtContactName" class="form-control" /></textarea>
								</div>
							</div>
						</div>
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
</section>
