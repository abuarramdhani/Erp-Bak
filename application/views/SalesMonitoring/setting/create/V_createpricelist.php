<section class="content">
	<div class="inner" >
	<div class="row">
		<div class="col-lg-12">
			<div class="row">
				<div class="col-lg-12">
				<div class="box box-info">
				<div class="box-header with-border"  style="background:#22aadd; color:#FFFFFF;">
					<div class="col-md-6">
						<h4 style="color:white;">
							 <b>
								<i class="fa fa-wrench"></i>
								<abbr>Setting</abbr>
								<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
								<a style="color:#FFFFFF;" href="<?php echo base_url('SalesMonitoring/pricelist/')?>">Pricelist Index </a>
								<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
								<abbr> Create</abbr>
							</b><br>
						</h4>
					</div>
				</div>
				<div class="box-body">
					<!-- NEW FORM -->
					<div class="row-fluid">
						<div class="col-md-12">
							<form class="form-horizontal" method="post" action="<?php echo base_url('SalesMonitoring/pricelist/created')?>">
								<div class="box-body">
									<div class="col-md-6">
										<div class="form-group">
											<label class="col-lg-4 control-label">Item Code</label>
											<div class="col-lg-8">
												<input type="text" class="form-control" placeholder="item code" name="txt_item_code" required></input>
											</div>
										</div>
									</div>
									<div class="col-lg-6">
										<div class="form-group">
											<label class="col-lg-4 control-label">Price</label>
											<div class="col-lg-8">
												<input type="text" class="form-control" placeholder="price" name="txt_price" required></input>
											</div>
										</div>
									</div>
								</div>
								<div class="box-footer pull-right">
									<div class="col-md-12">
										<a class="btn btn-default" type="button" onclick="goBack()"><span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Back</a>
										<button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-check" aria-hidden="true"></span> Save Changes</button>
									</div>
								</div>
								<input type="hidden" name="txt_start_date" value ="now()"></input>
								<input type="hidden" name="txt_end_date" value ="NULL"></input>
								<input type="hidden" name="txt_last_updated" value ="NULL"></input>		
								<input type="hidden" name="txt_last_update_by" value ="NULL"></input>
								<input type="hidden" name="txt_creation_date" value ="now()"></input>	
								<input type="hidden" name="txt_created_by" value = 0 ></input>	
								<input type="hidden" name="txt_last_update_by" value ="NULL"></input>	
							</form>
						</div>
					</div>
				</div>
			</div>
		
				</div>
			</div>
		</div>
	</div>
	</div>
</section>
