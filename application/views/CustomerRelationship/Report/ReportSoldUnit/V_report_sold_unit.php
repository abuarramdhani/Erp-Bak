<script src="<?php echo base_url('assets/js/ajaxSearch.js');?>"></script>
<div id="content" style="margin:0;">
	<div class="inner addscroll" >
	<div class="row">
		<div class="col-lg-12">
			<div class="row">
				<div class="col-lg-3">
						<br />
						<h2>Report <small>Sold Unit</small></h2>
					</div>
					<div class="col-lg-9">
						<div class="reright">
                           
                            <a class="quick-btn" href="<?php echo site_url('CustomerRelationship/Report/ReportCustomer');?>">
                                <i class="icon-female icon-2x"></i>
                                <span style="font-size:10px;">Report <br />Customer Data</span>
                            </a>
							<a class="quick-btn on" href="<?php echo site_url('CustomerRelationship/Report/ReportSoldUnit');?>">
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
					<div class="panel-body ">
						<form method="post" action="<?php echo site_url('CustomerRelationship/Report/ExportSoldUnitReport');?>">
						<div class="table-responsive" >
							<table class="table">
							
								<tr>
									<td width="25%">
										<select name="txtbyitem" id="txtbyitem" data-placeholder="By item" class="form-control select3" style="width:100%;">
											<option value="">- By item -</option>
											<?php
											foreach($items as $im){
											?>
											<option value="<?php echo $im->segment1;?>"><?php echo strtoupper($im->item_name);?></option>
											<?php
											}
											?>
										</select>
									</td>
									<td width="20%">
										<select class="form-control body-number" name="txtbybodynumber" id="txtbybodynumber" style="width:100%;">
											<option value=""></option>
										</select>
									</td>
									<td width="20%">
										<select class="form-control engine-number" name="txtbyenginenumber" id="txtbyenginenumber" style="width:100%;">
											<option value=""></option>
										</select>
									</td>
									<td colspan=2 width="30%">
										<select class="form-control owner-name" name="txtbyownername" id="txtbyownername"  data-placeholder="By owner name" style="width:100%;">
											<option value=""></option>
										</select>
									</td>
									
									
									
								</tr>
								<tr style="border:none;">
									<td style="border:none;">
										 <div class="form-group">
											<div class="input-group">
													
													<input type="text" name="txtbyrangesoldunit" id="txtbyrangesoldunit" placeholder="By range of date" class="form-control" style="width:100%;" />
													<span class="input-group-addon"><i class="icon-calendar"></i></span>
											</div>
										</div>
									</td>
									<td style="border:none;">
										<select name="txtbyprovince" id="txtbyprovince" data-placeholder="By province" class="form-control select3" style="width:100%;">
											<option value="">- By province -</option>
											<?php
											foreach($province as $pv){
											?>
											<option value="<?php echo $pv->province_name;?>"><?php echo strtoupper($pv->province_name);?></option>
											<?php
											}
											?>
										</select>
									</td>
									<td style="border:none;">
										<select class="form-control city-data" name="txtbycity" id="txtbycity"  data-placeholder="By city" style="width:100%;">
											<option value=""></option>
										</select>
										<!--
										<input type="text" class="form-control toupper" placeholder="By city" name="txtbycity" id="txtbycity" style="width:100%;" />
										-->
									</td>
									<td style="border:none;" width="18%"> 
										<select class="form-control district-data" name="txtbydistrict" id="txtbydistrict"  data-placeholder="By district" style="width:100%;">
											<option value=""></option>
										</select>
										<!--
										<input type="text" class="form-control toupper" placeholder="By district" name="txtbydistrict" id="txtbydistrict" style="width:100%;" />
										-->
									</td>
									
									
									<td style="border:none;">
										<select class="form-control buying-type" name="txtbybuyingtype" id="txtbybuyingtype"  data-placeholder="By buying type" style="width:100%;">
											<option value=""></option>
										</select>
									</td>
									
									<td width="5%" rowspan=2 style="border:none;">
											
										<a href="#" onclick="searchSoldUnitReport('<?php echo base_url();?>');return false;" class="btn btn-primary btn-md btn-rect">Search</a>
										
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
