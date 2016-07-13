<section class="content">
	<div class="inner" >
	<div class="row">
		<div class="col-lg-12">
			<div class="row">
				<div class="col-lg-12">
					<div class="col-lg-11">
						<div class="text-right">
							<h1><b> Update Additional Activity</b></h1>
						
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
						<?php 
					foreach ($AdditionalActivity as $AdditionalActivity_item): 
					?>
						<form method="post" action="<?php echo site_url('/CustomerRelationship/Setting/AdditionalActivity/Update/'.$id)?>" class="form-horizontal validator">
						<!-- action merupakan halaman yang dituju ketika tombol submit dalam suatu form ditekan -->
						<input type="hidden" value="<?php echo date("Y-m-d H:i:s")?>" name="hdnDate" />
						<input type="hidden" value="<?php echo $this->session->userid; ?>" name="hdnUser" />
						<input type="hidden" value="<?php echo $AdditionalActivity_item['setup_service_additional_activity_id'] ?>" name="hdnAdditionalActivityId" id="hdnAdditionalActivityId"/>
						<div class="panel-heading text-left">
						</div>
						<div class="panel-body">
								<div class="form-group">
										<label for="norm" class="control-label col-lg-4">Additional Activity</label>
										<div class="col-lg-8">
											<input type="text" placeholder="Additional" name="txtAdditional" id="txtAdditional" value="<?php echo $AdditionalActivity_item['additional_activity'] ?>" class="form-control toupper" />
										</div>
								</div>
								<div class="form-group">
										<label for="norm" class="control-label col-lg-4">Description</label>
										<div class="col-lg-8">
											<textarea rows="4" placeholder="Description" name="txtDescription" id="txtDescription" class="form-control toupper"><?php echo $AdditionalActivity_item['description'] ?></textarea>
										</div>
								</div>
								
						</div>
						<div class="panel-footer">
							<div class="row text-right">
								<a href="<?php echo site_url('CustomerRelationship/Setting/AdditionalActivity');?>" class="btn btn-primary btn-lg btn-rect">Back</a>
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