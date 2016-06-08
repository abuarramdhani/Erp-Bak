<script src="<?php echo base_url('assets/js/ajaxSearch.js');?>"></script>
<div id="content" style="margin:0;">
	<div class="inner addscroll" >
	<div class="row">
		<div class="col-lg-12">
			<div class="row">
				<div class="col-lg-3">
						<br />
						<h2>Report <small>Troubled Part</small></h2>
					</div>
					<div class="col-lg-9">
						<div class="reright">
                           
                            <a class="quick-btn" href="<?php echo site_url('CustomerRelationship/Report/ReportCustomer');?>">
                                <i class="icon-female icon-2x"></i>
                                <span style="font-size:10px;">Report <br />Customer Data</span>
                            </a>
							<a class="quick-btn" href="<?php echo site_url('CustomerRelationship/Report/ReportSoldUnit');?>">
                                <i class="icon-truck  icon-2x"></i>
                                <span style="font-size:10px;"> Report<br />Sold Unit</span>
                            </a>
							<a class="quick-btn on" href="<?php echo site_url('CustomerRelationship/Report/ReportTroubledPart');?>">
                                <i class="icon-unlink icon-2x"></i>
                                <span style="font-size:10px;"> Report<br />Troubled Part</span>
                            </a>
							

                            
						</div>
					</div>
			</div>
			<hr />
			<div class="row">
				<div class="col-lg-12">
					<div class="panel panel-default">
					<div class="panel-heading">
						
						Filter data
					</div>
					<div class="panel-body">
						<form method="post" action="<?php echo site_url('CustomerRelationship/Report/ExportTroubledPartReport');?>">
						<div class="table-responsive">
							<table class="table">
							
								<tr>
									<td width="32.5%">
										<select class="form-control sp-code" name="txtbysparepart" id="txtbysparepart">
											<option value=""></option>
										</select>
										<!--
										<input type="text" class="form-control" placeholder="By part code" name="txtbypartcode" id="txtbypartcode" /></textarea>
										-->
									</td>
									<td width="32.5%">
										<select class="form-control item-name" name="txtbyitem" id="txtbyitem">
											<option value=""></option>
										</select>
									</td>
									<td width="15%">
										<select class="form-control body-number" name="txtbybodynumber" id="txtbybodynumber">
											<option value=""></option>
										</select>
									</td>
									<td width="15%">
										<select name="txtbycategory" id="txtbycategory" data-placeholder="By problem" class="form-control select-rusak">
											<option value="">- By category -</option>
											<?php
											foreach($problem as $pb){
											?>
											<option value="<?php echo $pb->service_problem_id;?>"><?php echo $pb->service_problem_name;?></option>
											<?php
											}
											?>
											
										</select>
									</td>
									<td width="5%">
											
										<a href="#" onclick="searchTroubledPartReport('<?php echo base_url();?>');return false;" class="btn btn-primary btn-md btn-rect">Search</a>
										
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
