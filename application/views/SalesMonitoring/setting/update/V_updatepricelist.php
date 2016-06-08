<div class="wrapper">

	<div class="content-wrapper">
		<section class="content">
			<div class="box box-info">
				<div class="box-header with-border"  style="background:#22aadd; color:#FFFFFF;">
					<div class="col-md-6">
						<h4 style="color:white;">
							<b>
							<i class="fa fa-wrench"></i><abbr> Setting</abbr>
							<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
							<a style="color:#FFFFFF;" href="<?php echo base_url('setting/pricelist/')?>"> Pricelist Index </a>
							<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
							<abbr> Update</abbr></b><br>
						</h4>
					</div>
				</div>
				<div class="box-body"></br>
					<!-- NEW FORM -->
					<div class="row-fluid">
						<div class="col-md-12">
							<form class="form-horizontal" method="post" action="<?php echo base_url('setting/pricelist/updated')?>">
								<?php foreach($selected as $selected_item){ ?>
									<input type="hidden" name="txt_pricelist_index_id" value="<?php echo $selected_item['pricelist_index_id'] ?>"></input>
									<input type="hidden" name="txt_start_date" value="<?php echo $selected_item['start_date'] ?>"></input>
									<input type="hidden" name="txt_end_date" value ="NULL"></input>
									<input type="hidden" name="txt_last_updated" value="now()"></input>
									<input type="hidden" name="txt_last_update_by" value=0>
									<input type="hidden" name="txt_creation_date" value="<?php echo $selected_item['creation_date'] ?>"></input>
									<input type="hidden" name="txt_created_by" value="<?php echo $selected_item['created_by'] ?>"></input>				
								<?php } ?>
								<div class="box-body">
									<div class="col-md-6">
										<div class="form-group">
											<label class="col-sm-3 control-label">Item Code</label>
											<div class="col-sm-9">
												<input name="txt_item_code" class="form-control" placeholder="item code" value="<?php echo $selected_item['item_code'] ?>" required></input>
											</div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="col-sm-3 control-label">Price</label>
											<div class="col-sm-9">
												<input name="txt_price" class="form-control" placeholder="price" value="<?php echo $selected_item['price'] ?>" required></input>
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
							</form>
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>
  