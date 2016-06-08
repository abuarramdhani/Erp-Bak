<script src="<?php echo base_url('assets/js/ajaxSearch.js');?>"></script>
<div id="content" style="margin:0;">
	<div class="inner addscroll" >
	<div class="row">
		<div class="col-lg-12">
			<div class="row">
				<div class="col-lg-3">
						<br />
						<h2>Report <small>Customer Data</small></h2>
					</div>
					<div class="col-lg-9">
						<div class="reright">
                           
                            <a class="quick-btn on" href="<?php echo site_url('CustomerRelationship/Report/ReportCustomer');?>">
                                <i class="icon-female icon-2x"></i>
                                <span style="font-size:10px;">Report <br />Customer Data</span>
                            </a>
							<a class="quick-btn" href="<?php echo site_url('CustomerRelationship/Report/ReportSoldUnit');?>">
                                <i class="icon-truck  icon-2x"></i>
                                <span style="font-size:10px;"> Report<br />Sold Unit</span>
                            </a>
							<a class="quick-btn" href="<?php echo site_url('CustomerRelationship/Report/ReportTroubledPart');?>">
                                <i class="icon-unlink icon-2x"></i>
                                <span style="font-size:10px;"> Report<br />Troubled Part</span>
                            </a>
							

                            
						</div>
					</div>
			</div>
			<hr />
			<div class="row addscroll">
				<div class="col-lg-12">
					<div class="panel panel-default">
					<div class="panel-heading">
						
						Filter data
					</div>
					<div class="panel-body" >
						<form method="post" action="<?php echo site_url('CustomerRelationship/Report/ExportCustomerReport');?>">
						<div class="table-responsive">
							<table class="table">
							
								<tr>
									<td width="30%">
									<!--
									<input type="text" class="form-control" placeholder="By name" name="txtbyname" id="txtbyname" />
									-->	
										<select class="form-control owner-name" name="txtbyname" id="txtbyname"  data-placeholder="By name" style="width:100%;">
											<option value=""></option>
										</select>
								
									</td>
									<td width="30%">
										<select name="txtbycategory" id="txtbycategory" data-placeholder="By category" class="form-control select3" style="width:100%;">
											<option value="">- By Category -</option>
											<?php
											foreach($categories as $ct){
											?>
											<option value="<?php echo $ct->customer_category_id;?>"><?php echo $ct->customer_category_name;?></option>
											<?php
											}
											?>
										</select>
									</td>
									<td width="35%">
										<select name="txtbyjob[]" id="txtbyjob" multiple data-placeholder="By additional info" class="form-control select4" style="width:100%;">
											<option value=""></option>
											<?php
											foreach($job as $jb){
											?>
											<option value="<?php echo $jb->additional_name;?>"><?php echo $jb->additional_name;?></option>
											<?php
											}
											?>
										</select>
									</td>
									
									
									
								</tr>
								<tr>
									<td style="border:none;">
										<select class="form-control district-data" name="txtbydistrict" id="txtbydistrict"  data-placeholder="By district" style="width:100%;">
											<option value=""></option>
										</select>
									
									<!--
									<input type="text" class="form-control" placeholder="By district" name="txtbydistrict" id="txtbydistrict" />
											-->
									</td>
									<td style="border:none;">
										<select class="form-control city-data" name="txtbycity" id="txtbycity"  data-placeholder="By city" style="width:100%;">
											<option value=""></option>
										</select>
										<!--
									<input type="text" class="form-control" placeholder="By city" name="txtbycity" id="txtbycity" />
									-->
									</td>
									<td style="border:none;">
										<select name="txtbyprovince" id="txtbyprovince" data-placeholder="By province" class="form-control province-data" style="width:100%;">
											<option value="">- By Province -</option>
											<?php
											//foreach($province as $pv){
											?>
											<!--
											<option value="<?php echo $pv->province_name;?>"><?php echo strtoupper($pv->province_name);?></option>
											-->
											<?php
											//}
											?>
										</select>
									</td>
									
									<td width="5%" rowspan="2" style="border:none;">
											
										<a href="#" onclick="searchCustomerReport('<?php echo base_url();?>');return false;" class="btn btn-primary btn-md btn-rect">Search</a>
										
									</td>
								</tr>
							
							</table>
							<hr />
							<div id="loading"></div>
							<div id="res">
								<br /><br /><br /><br /><br /><br /><br /><br />
								<br /><br /><br /><br /><br /><br /><br />
							</div>
						</div>
						</form>
					</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	</div>
</div>
