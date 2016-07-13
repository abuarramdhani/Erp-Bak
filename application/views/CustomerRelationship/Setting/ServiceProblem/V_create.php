<section class="content">
	<div class="inner" >
	<div class="row">
		<form method="post" action="<?php echo site_url('CustomerRelationship/Setting/ServiceProblem/Create/')?>" class="form-horizontal">
				<!-- action merupakan halaman yang dituju ketika tombol submit dalam suatu form ditekan -->
				<input type="hidden" value="<?php echo date("Y-m-d H:i:s")?>" name="hdnDate" id="hdnDate" />
				<input type="hidden" value="<?php echo 111111 ?>" name="hdnUser" id="hdnUser" />
		<div class="col-lg-12">
			<div class="row">
				<div class="col-lg-12">
					<div class="col-lg-11">
						<div class="text-right">
						<h1><b>New Service Problem</b></h1>
						</div>
					</div>
					<div class="col-lg-1">
						<div class="text-right hidden-md hidden-sm hidden-xs">
                            <a class="btn btn-default btn-lg" href="<?php echo site_url('CustomerRelationship/Setting/ServiceProblem');?>">
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
								<div class="form-group">
										<label for="norm" class="control-label col-lg-4">Problem Name</label>
										<div class="col-lg-8">
											<input type="text" placeholder="Problem" name="txtProblemName" id="txtProblemName" class="form-control toupper" />
										</div>
								</div>
								<div class="form-group">
										<label for="norm" class="control-label col-lg-4">Description</label>
										<div class="col-lg-8">
											<textarea rows="4" placeholder="Description" name="txtDescription" id="txtDescription" class="form-control toupper"></textarea>
										</div>
								</div>
								<div class="form-group">
										<label for="norm" class="control-label col-lg-4">Active</label>
										<div class="col-lg-3">
											<select  name="slcActive" id="slcActive" class="form-control">
												<option value="Y" >Active</option>
												<option value="N" >Not Active</option>
											</select>	
										</div>
								</div>
						</div>
						<div class="panel-footer">
							<div class="row text-right">
								<a href="<?php echo site_url('CustomerRelationship/Setting/ServiceProblem/');?>" class="btn btn-primary btn-lg btn-rect">Back</a>
								&nbsp;&nbsp;
								<button class="btn btn-primary btn-lg btn-rect">Save Data</button>
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
