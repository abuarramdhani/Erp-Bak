<section class="content">
	<div class="inner" >
	<div class="row">
		<div class="col-lg-12">
			<div class="row">
				<div class="col-lg-12">
					<div class="col-lg-11">
						<div class="text-right">
							<h1><b> Update Costumer Contact </b></h1>

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
						<form method="post" action="<?php echo site_url('CustomerRelationship/Customer/UpdateContact/'.$id.'/')?>" class="form-horizontal">
						<div class="panel-heading text-left">
							
						</div>
						<div class="panel-body">
							
							<?php 
							foreach ($CustomerContact as $CustomerContact_item): 
							?>
							<input type="hidden" value="<?php echo $CustomerContact_item['customer_contact_id'] ?>" name="hdnContactId" />
							<input type="hidden" value="<?php echo $CustomerContact_item['connector_id'] ?>" name="hdnConnectorId" />
							<input type="hidden" value="<?php echo date("Y-m-d H:i:s")?>" name="hdnDate" />
							<input type="hidden" value="<?php echo $this->session->userid; ?>" name="hdnUser" />
							<?php
								$customer_id = $this->encrypt->encode($CustomerContact_item['connector_id']);
								$customer_id = str_replace(array('+', '/', '='), array('-', '_', '~'), $customer_id);
							?>
							
							<div class="form-group">
								<label for="norm" class="control-label col-lg-3">Type</label>
								<div class="col-lg-7">
									<select  name="txtType" id="txtType" data-placeholder="Contact type" onchange="contact();" class="form-control select2">
									  <option value="" ></option>
									  <option value="HANDPHONE" <?php if($CustomerContact_item['type'] == 'HANDPHONE'){echo "selected";}?>>HANDPHONE</option>
									  <option value="TELEPHONE" <?php if($CustomerContact_item['type'] == 'TELEPHONE'){echo "selected";}?>>TELEPHONE</option>
									  <option value="EMAIL" <?php if($CustomerContact_item['type'] == 'EMAIL'){echo "selected";}?>>EMAIL</option>
									  <option value="PIN BBM" <?php if($CustomerContact_item['type'] == 'PIN BBM'){echo "selected";}?>>PIN BBM</option>
									</select>									
								</div>
							</div>
							<div class="form-group">
								<label for="norm" class="control-label col-lg-3">Data</label>
								<div class="col-lg-7">
									<input type="text" placeholder="Data" name="txtData" id="txtData" value="<?php echo $CustomerContact_item['data'] ?>" class="form-control" />
								</div>
							</div>
							<div class="form-group">
								<label for="norm" class="control-label col-lg-3">Description</label>
								<div class="col-lg-7">
									<textarea placeholder="Description" name="txtContactName" value="" class="form-control" /><?php echo $CustomerContact_item['name'] ?></textarea>
								</div>
							</div>
							<?php endforeach ?>
							
						</div>
						<div class="panel-footer text-right">
							<div class="row text-right">
								<a href="javascript:history.back(1)" class="btn btn-primary btn-lg btn-rect">Back</a>
								<button class="btn btn-primary btn-lg btn-rect">Save Changes</button>
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