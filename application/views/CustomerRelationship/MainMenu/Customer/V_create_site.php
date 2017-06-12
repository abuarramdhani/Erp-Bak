<script src="<?php echo base_url('assets/js/ChainArea.js');?>"></script>
<script>

var confirmOnPageExit = function (e) 
{
    // If we haven't been passed the event get the window.event
    e = e || window.event;

    //var message = 'Any text will block the navigation and display a prompt';
	var message = '!!!';
	
    // For IE6-8 and Firefox prior to version 4
    if (e) 
    {
        e.returnValue = message;
    }

    // For Chrome, Safari, IE8+ and Opera 12+
    return message;
};

window.onbeforeunload = confirmOnPageExit;

</script>
<section class="content">
	<div class="inner" >
	<div class="row">
		<div class="col-lg-12">
			<div class="row">
				<div class="col-lg-12">
					<div class="col-lg-11">
						<div class="text-right">
							<h1><b> New Costumer Site </b></h1>

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
						<form method="post" action="<?php echo site_url('CustomerRelationship/Customer/CreateSite/'.$id.'/')?>" class="form-horizontal">
						<div class="panel-heading text-left">
							
						</div>
						<div class="panel-body">
							<input type="hidden" value="<?php echo date("Y-m-d H:i:s")?>" name="hdnDate" />
							<input type="hidden" value="<?php echo $this->session->userid; ?>" name="hdnUser" />
							
							<div class="col-lg-6">
								<div class="form-group">
									<label for="norm" class="control-label col-lg-4">Site Name</label>
									<div class="col-lg-8">
										<input type="text" placeholder="Name" name="txtSiteName" class="form-control toupper" required/>
									</div>
								</div>
								<div class="form-group">
									<label for="norm" class="control-label col-lg-4">Address</label>
									<div class="col-lg-8">
										<textarea id="autosize" placeholder="Address" name="txtAddress" class="form-control toupper" required></textarea>										
									</div>
								</div>
								<div class="form-group">
									<label for="norm" class="control-label col-lg-4">Province</label>
									<div class="col-lg-8">
										<select name="txtProvince" id="txtProvince" data-placeholder="Province" onchange="getRegency('<?php echo base_url();?>')" class="form-control select4" required>
											<option value="">-- Option --</option>
											<?php
											foreach($Province as $ct){
											?>
											<option value="<?php echo $ct['province_id'];?>"><?php echo strtoupper($ct['province_name']);?></option>
											<?php
											}
											?>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label for="norm" class="control-label col-lg-4">City / Regency</label>
									<div class="col-lg-8">
										<!--
										<input type="text" placeholder="City / Regency" name="txtCityRegency" id="txtCityRegency" class="form-control toupper" />
										-->
										<select data-placeholder="City / Regency" name="txtCityRegency" id="txtCityRegency" onchange="getDistrict('<?php echo base_url();?>')" class="form-control select4" disabled required>
											<option value="">-- Option --</option>

										</select>
									</div>
								</div>
								<div class="form-group">
									<label for="norm" class="control-label col-lg-4">District</label>
									<div class="col-lg-8">
										<!--
										<input type="text" placeholder="Dusun" name="txtDistrict" id="txtDistrict" class="form-control toupper" />
										-->
										<select data-placeholder="District" name="txtDistrict" id="txtDistrict" onchange="getVillage('<?php echo base_url();?>')" class="form-control select4" disabled required>
											<option value="">-- Option --</option>

										</select>
									</div>
								</div>
							</div>
							<div class="col-lg-6" style="margin-top:11%;">
								
								<div class="form-group">
									<label for="norm" class="control-label col-lg-4">Village</label>
									<div class="col-lg-8">
										<!--
										<input type="text"placeholder="Village" name="txtVillage" class="form-control toupper" />
										-->
										<select data-placeholder="Village" name="txtVillage" id="txtVillage" class="form-control select4" disabled required>
											<option value="">-- Option --</option>

										</select>
									</div>
								</div>
								
								<div class="form-group">
									<label for="norm" class="control-label col-lg-4">RW</label>
									<div class="col-lg-8">
										<input type="text" placeholder="02" name="txtRw" class="form-control toupper" onkeypress="return isNumberKey(event)"  maxlength="3"/>
									</div>
								</div>
								<div class="form-group">
									<label for="norm" class="control-label col-lg-4">RT</label>
									<div class="col-lg-8">
										<input type="text" placeholder="01" name="txtRt" class="form-control toupper" onkeypress="return isNumberKey(event)"  maxlength="3"/>
									</div>
								</div>
							</div>
						</div>
						
						<div class="panel-footer text-right">
							<div class="row text-right">
								<a href="javascript:history.back(1)" class="btn btn-primary btn-lg btn-rect">Back</a>
								<button class="btn btn-primary btn-lg btn-rect" onclick="window.onbeforeunload = null;">Save Data</button>
							</div>
						</div>
						</form>
					</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-2"></div>
	</div>
	</div>
</section>
