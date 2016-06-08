<section class="content">
	<div class="inner" >
	<div class="row">
		<div class="col-lg-12">
			<div class="row">
				<div class="col-lg-12">
					<div class="col-lg-11">
						<div class="text-right">
						<h1><b>Update Customer Buying Type</b></h1>
						</div>
					</div>
					<div class="col-lg-1">
						<div class="text-right hidden-md hidden-sm hidden-xs">
                            <a class="btn btn-default btn-lg" href="<?php echo site_url('CustomerRelationship/Setting/BuyingType');?>">
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
					foreach ($BuyingType as $BuyingType_item): 
					?>
						<form method="post" id="form-buying-type" action="<?php echo site_url('/CustomerRelationship/Setting/BuyingType/PostUpdateToDb/')?>" class="form-horizontal">
						<!-- action merupakan halaman yang dituju ketika tombol submit dalam suatu form ditekan -->
						<input type="hidden" value="<?php echo $BuyingType_item['buying_type_id'] ?>" name="hdnBuyingTypeId" id="hdnBuyingTypeId" />
						<input type="hidden" value="<?php echo date("Y-m-d H:i:s")?>" name="hdnDate" id="hdnDate" />
						<input type="hidden" value="<?php echo $this->session->userid; ?>" name="hdnUser" id="hdnUser" />
						<div class="panel-heading text-left">
						</div>
						<div class="panel-body">
								<div class="form-group">
										<label for="norm" class="control-label col-lg-4">Buying Type</label>
										<div class="col-lg-4">
											<input type="text" type="text" placeholder="Buying Type" name="txtBuyingType" value="<?php echo $BuyingType_item['buying_type_name'] ?>" class="form-control toupper" />
										</div>
								</div>
								<div class="form-group">
										<label for="norm" class="control-label col-lg-4">Description</label>
										<div class="col-lg-8">
											<textarea type="text" type="text" name="txtDescription" class="form-control toupper" /><?php echo $BuyingType_item['buying_type_description'] ?></textarea>
										</div>
								</div>
						</div>
						<div class="panel-footer">
							<div class="row text-right">
								<a href="<?php echo site_url('CustomerRelationship/Setting/BuyingType');?>" class="btn btn-primary btn-lg btn-rect">Back</a>
								&nbsp;&nbsp;
								<button type="submit" class="btn btn-primary btn-lg btn-rect">Save Changes</button>
							</div>
						</div>
					</div>
				</div>
			</div>
			</div>
		</div>
		</form>
		<?php endforeach ?>
	</div>
	</section>
</div>