<section class="content">
	<div class="inner" >
	<div class="row">
		<div class="col-lg-12">
			<div class="row">
				<div class="col-lg-12">
					<div class="col-lg-11">
						<div class="text-right">
						<h1><b>Update Service Problem</b></h1>
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
						<?php 
					foreach ($ServiceProblem as $ServiceProblem_item): 
					?>
						<form method="post" action="<?php echo site_url('/CustomerRelationship/Setting/ServiceProblem/Update/'.$id)?>" class="form-horizontal validator">
						<!-- action merupakan halaman yang dituju ketika tombol submit dalam suatu form ditekan -->
						<input type="hidden" value="<?php echo $ServiceProblem_item['service_problem_id'] ?>" name="hdnServiceProblemId" id="hdnServiceProblemId" />
						<input type="hidden" value="<?php echo date("Y-m-d H:i:s")?>" name="hdnDate" id="hdnDate" />
						<input type="hidden" value="<?php echo 111111 ?>" name="hdnUser" id="hdnUser" />
						<div class="panel-heading text-left">
						</div>
						<div class="panel-body">
								<div class="form-group">
										<label for="norm" class="control-label col-lg-4">Problem Name</label>
										<div class="col-lg-8">
											<input type="text" placeholder="1" name="txtProblemName" id="txtProblemName" value="<?php echo $ServiceProblem_item['service_problem_name'] ?>" class="form-control toupper" />
										</div>
								</div>
								<div class="form-group">
										<label for="norm" class="control-label col-lg-4">Description</label>
										<div class="col-lg-8">
											<textarea rows="4" placeholder="Description" name="txtDescription" id="txtDescription"  class="form-control toupper"><?php echo $ServiceProblem_item['description'] ?></textarea>
										</div>
								</div>
								<div class="form-group">
										<label for="norm" class="control-label col-lg-4">Active</label>
										<div class="col-lg-3">
											<select  name="slcActive" id="slcActive" class="form-control">
												<option value="Y" <?php if($ServiceProblem_item['active']=='Y') echo 'selected="selected"'; ?>>Active</option>
												<option value="N" <?php if($ServiceProblem_item['active']=='N') echo 'selected="selected"'; ?>>Not Active</option>
											</select>	
										</div>
								</div>
						</div>
						<div class="panel-footer">
							<div class="row text-right">
								<a href="<?php echo site_url('CustomerRelationship/Setting/ServiceProblem');?>" class="btn btn-primary btn-lg btn-rect">Back</a>
								&nbsp;&nbsp;
								<button type="submit" class="btn btn-primary btn-lg btn-rect">Save Changes</button>
							</div>
						</div>
						</form>
						<?php endforeach ?>
					</div>
				</div>
				</div>
			</div>
		</div>
		
	</div>
	</div>
</section>