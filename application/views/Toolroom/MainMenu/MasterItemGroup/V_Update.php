<section class="content">
	<div class="inner" >
		<div class="row">
			<form method="post" action="<?php echo site_url('Toolroom/MasterItem/UpdateGroupItemUsable/'.$id)?>" enctype="multipart/form-data" class="form-horizontal">
					<!-- action merupakan halaman yang dituju ketika tombol submit dalam suatu form ditekan -->
					<input type="hidden" value="<?php echo date("Y-m-d H:i:s")?>" name="hdnDate" />
					<input type="hidden" value="<?php echo $this->session->userid; ?>" name="hdnUser" />
			<div class="col-lg-12">
				<div class="row">
						<div class="col-lg-12">
							<div class="col-lg-11">
								<div class="text-right">
								<h1><b><?= $Title?></b></h1>

								</div>
							</div>
							<div class="col-lg-1 ">
								<div class="text-right hidden-md hidden-sm hidden-xs">
									<a class="btn btn-default btn-lg" href="<?php echo site_url('Toolroom');?>">
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
						foreach ($AllUsableItemGroup as $AllUsableItemGroup_item): 
						?>
							<div class="panel-body">
								<div class="row col-lg-12">
									<div class="form-group">
											<label for="norm" class="control-label col-md-4 text-center">Group Toolkit</label>
											<div class="col-md-4">
												<input type="text" placeholder="Group Toolkit" name="txtGroupName" id="txtGroupName" value="<?php echo $AllUsableItemGroup_item['item_group'] ?>" class="form-control" required/>
											</div>
									</div>
									<div class="form-group">
											<label for="norm" class="control-label col-md-4 text-center">Description</label>
											<div class="col-md-8">
												<input type="text" placeholder="Description" name="txtDesc" id="txtDesc" value="<?php echo $AllUsableItemGroup_item['item_group_desc'] ?>" class="form-control" />
											</div>
									</div>
								</div>
							</div>
							<div class="panel-footer">
								<div class="row text-right">
									<a href="<?php echo site_url('Toolroom/MasterItem/UsableGroup') ?>" class="btn btn-primary btn-lg btn-rect">Close</a>
									&nbsp;&nbsp;
									<button id="btnUser" class="btn btn-primary btn-lg btn-rect">Save</button>
								</div>
							</div>
							<?php endforeach ?>
						</div>
						</div>
					</div>
				</div>
			</div>
			</form>
		</div>
	</div>
</section>