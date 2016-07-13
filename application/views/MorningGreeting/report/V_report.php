<section class="content">
	<div class="inner">
	<div class="box box-info">
	<div style="padding-top: 10px">
	<!-- HEADER MENU REPORT -->
		<div class="box-header with-border">
			<h4><b>REPORT MENU</b></h4>
		</div>

		<!-- BODY OPTION MENU REPORT -->
		<div class="box-body">
			
			<!-- SHOW ALL REPORT -->
			<div class="box box-solid collapsed-box">
            	<div class="box-header with-border">
              		<h3 class="box-title">Show All Reports</h3>
              		<div class="box-tools">
           			     <button type="button" class="btn btn-box-tool" data-widget="collapse">
           			     	<i class="fa fa-plus"></i> SHOW MENU 
                		</button>
              		</div>
            	</div>
            	<div class="box-body no-padding">
              		<ul class="nav nav-pills nav-stacked">
              			<div class="box box-primary">
              			<form method="post" action="<?php echo base_url('MorningGreeting/report/showAll')?>">
							<div class="box-header">
								<h3 class="box-title">KHS GROUP REPORT</h3>
							</div>
							<div class="box-body">
								<div class="row">
									<div class="col-md-2"></div>
            						<div class="col-md-8">
										<div class="form-group">
											<label>Date Range:</label>
											<div class="input-group">
												<div class="input-group-addon">
													<i class="fa fa-calendar"></i>
												</div>
												<input type="text" class="form-control" name="rangeAll" id="reportAll" required>
											</div>
										</div>
										<div>
             								<button class="btn btn-primary pull-right" type="submit">
             									<span class="glyphicon glyphicon-search" aria-hidden="true"></span> SEARCH DATA
             								</button>
             							</div>
             						</div>
             					</div>
							</div>
						</form>
						</div>
           	 		</ul>
            	</div>
          	</div>

				<!-- SHOW Branch REPORT -->
          	<div class="box box-solid collapsed-box">
            	<div class="box-header with-border">
              		<h3 class="box-title">Show Branch Report</h3>
              		<div class="box-tools">
           			     <button type="button" class="btn btn-box-tool" data-widget="collapse">
           			     	<i class="fa fa-plus"></i> SHOW MENU 
                		</button>
              		</div>
            	</div>
            	<div class="box-body no-padding">
              		<ul class="nav nav-pills nav-stacked">
              			<div class="box box-primary">
              			<form method="post" action="<?php echo base_url('MorningGreeting/report/showByBranch')?>">
							<div class="box-header">
								<h3 class="box-title">KHS BRANCH REPORT</h3>
							</div>
							<div class="box-body">
								<div class="row">
									<div class="col-md-2"></div>
            						<div class="col-md-8">
										<div class="form-group">
											<label>Date range:</label>
											<div class="input-group">
												<div class="input-group-addon">
													<i class="fa fa-calendar"></i>
												</div>
												<input type="text" class="form-control" name="rangeBranch" id="reportBranch" required>
											</div>
										</div>
										<div class="form-group">
                							<label>Branch</label>
                							<select data-placeholder="Branch" class="form-control select4" style="width:100%;" name ="org_id" required>
												<option value="" disabled selected>-- PILIH SALAH SATU --</option>
												<option value="muach" disabled >-- PILIH SALAH SATU --</option>
												<?php foreach ($data_branch as $data_branch_item){?>
													<option value="<?php echo $data_branch_item['org_id'];?>">
														<?php echo $data_branch_item['org_name']; ?>
													</option>
												<?php }?>
											</select>
             							</div>
             							<div>
             								<button class="btn btn-primary pull-right" type="submit">
             									<span class="glyphicon glyphicon-search" aria-hidden="true"></span> SEARCH DATA
             								</button>
             							</div>
             						</div>
             					</div>
							</div>
						</form>
						</div>
           	 		</ul>
            	</div>
          	</div>
          	
          	<!-- SHOW Relation REPORT -->
          	<div class="box box-solid collapsed-box">
            	<div class="box-header with-border">
              		<h3 class="box-title">Show Relation Report</h3>
              		<div class="box-tools">
           			     <button type="button" class="btn btn-box-tool" data-widget="collapse">
           			     	<i class="fa fa-plus"></i> SHOW MENU 
                		</button>
              		</div>
            	</div>
            	<div class="box-body no-padding">
              		<ul class="nav nav-pills nav-stacked">
              			<div class="box box-primary">
							<div class="box-header">
								<h3 class="box-title">KHS RELATION REPORT</h3>
							</div>
							<div class="box-body">
							<form method="post" action="<?php echo base_url('MorningGreeting/report/showByRelation')?>">
								<div class="row">
									<div class="col-md-2"></div>
            						<div class="col-md-8">
             							<div class="form-group">
                							<label>Branch</label>
                							<select data-placeholder="Branch" class="form-control select4" style="width:100%;" name ="org_id" required>
												<option value="" disabled selected>-- PILIH SALAH SATU --</option>
												<option value="muach" disabled >-- PILIH SALAH SATU --</option>
												<?php foreach ($data_branch as $data_branch_item){?>
													<option value="<?php echo $data_branch_item['org_id'];?>">
														<?php echo $data_branch_item['org_name']; ?>
													</option>
												<?php }?>
											</select>
             							</div>
             							<div class="form-group">
             								<label>Month</label>
             								<select data-placeholder="Month" class="form-control select4" style="width:100%;" name ="month" required>
												<option value="" disabled selected>-- PILIH SALAH SATU --</option>
												<option value="muach" disabled >-- PILIH SALAH SATU --</option>
												<option value="JANUARI">JANUARI</option>
												<option value="FEBRUARI">FEBRUARI</option>
												<option value="MARET">MARET</option>
												<option value="APRIL">APRIL</option>
												<option value="MEI">MEI</option>
												<option value="JUNI">JUNI</option>
												<option value="JULI">JULI</option>
												<option value="AGUSTUS">AGUSTUS</option>
												<option value="SEPTEMBER">SEPTEMBER</option>
												<option value="OKTOBER">OKTOBER</option>
												<option value="NOVEMBER">NOVEMBER</option>
												<option value="DESEMBER">DESEMBER</option>
											</select>
             							</div>
             							<div>
             								<button class="btn btn-primary pull-right" type="submit">
             									<span class="glyphicon glyphicon-search" aria-hidden="true"></span> SEARCH DATA
             								</button>
             							</div>
            						</div>
            					</div>
							</form>
            				</div>
            			</div>
           	 		</ul>
            	</div>
          	</div>
		</div>
	</div>
	</div>
	</div>
</section>
