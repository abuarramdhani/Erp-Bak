<section class="content">
	<div class="inner" >
	<div class="row">
		<form method="post" action="<?php echo site_url('CustomerRelationship/Setting/AdditionalActivity/Create/')?>" class="form-horizontal">
				<!-- action merupakan halaman yang dituju ketika tombol submit dalam suatu form ditekan -->
				<input type="hidden" value="<?php echo date("Y-m-d H:i:s")?>" name="hdnDate" id="hdnDate" />
				<input type="hidden" value="<?php echo $this->session->userid; ?>" name="hdnUser" id="hdnUser" />
		<div class="col-lg-12">
			<div class="row">
				<div class="col-lg-12">
					<div class="col-lg-11">
						<div class="text-right">
							<h1><b> New Additional Activity</b></h1>

						</div>
					</div>
					<div class="col-lg-1 ">
							<div class="text-right hidden-md hidden-sm hidden-xs">
								<a class="btn btn-default btn-lg" href="<?php echo site_url('CustomerRelationship/Setting/AdditionalActivity');?>">
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
										<label for="norm" class="control-label col-lg-4">Additional Activity</label>
										<div class="col-lg-8">
											<input type="text" placeholder="Additional" name="txtAdditional" id="txtAdditional" class="form-control toupper" />
										</div>
								</div>
								<div class="form-group">
										<label for="norm" class="control-label col-lg-4">Description</label>
										<div class="col-lg-8">
											<textarea rows="4" placeholder="Description" name="txtDescription" id="txtDescription" class="form-control toupper"></textarea>
										</div>
								</div>
								
							</div>
						<div class="panel-footer">
							<div class="row text-right">
								<a href="<?php echo site_url('CustomerRelationship/Setting/AdditionalActivity/');?>" class="btn btn-primary btn-lg btn-rect">Back</a>
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