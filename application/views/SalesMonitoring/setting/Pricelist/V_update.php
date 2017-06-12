<section class="content">
	<div class="inner" >
	<div class="row">
		<div class="col-lg-12">
			<div class="row">
				<div class="col-lg-12">
					<div class="col-lg-11">
						<div class="text-right">
						<h1><b>Edit Pricelist Index</b></h1>
						</div>
					</div>
					<div class="col-lg-1">
						<div class="text-right hidden-md hidden-sm hidden-xs">
                            <a class="btn btn-default btn-lg" href="<?php echo site_url('SalesMonitoring/pricelist');?>">
                                <i class="icon-wrench icon-2x"></i>
                                <span ><br /></span>
                            </a>
						</div>
					</div>
				</div>
			</div>
			<br />
			<div class="row">
			<form class="form-horizontal" method="post" action="<?php echo base_url('SalesMonitoring/pricelist/updated')?>">
				<?php foreach($selected as $selected_item){ ?>
					<input type="hidden" name="txt_pricelist_index_id" value="<?php echo $selected_item['pricelist_index_id'] ?>"></input>
					<input type="hidden" name="txt_start_date" value="<?php echo $selected_item['start_date'] ?>"></input>
					<input type="hidden" name="txt_end_date" value ="NULL"></input>
					<input type="hidden" name="txt_last_updated" value="now()"></input>
					<input type="hidden" name="txt_last_update_by" value="<?php echo $this->session->userid; ?>"></input>
					<input type="hidden" name="txt_creation_date" value="<?php echo $selected_item['creation_date'] ?>"></input>
					<input type="hidden" name="txt_created_by" value="<?php echo $selected_item['created_by'] ?>"></input>							
				<?php } ?>
				<div class="col-lg-12">
				<div class="box box-primary box-solid">
				<div class="box-header with-border">
					Pricelist Index
				</div>
				<div class="box-body">
					<div class="panel-body">
						<div class="form-group">
							<label class="col-lg-2 control-label">Item Code</label>
							<div class="col-lg-4">
								<input name="txt_item_code" class="form-control toupper" placeholder="item code" value="<?php echo $selected_item['item_code'] ?>" required></input>
							</div>
							<label class="col-lg-1 control-label">Price</label>
							<div class="col-lg-4">
								<input name="txt_price" class="form-control" onkeypress="return isNumberKeyAndComma(event)" placeholder="price" value="<?php echo $selected_item['price'] ?>" required></input>
							</div>
						</div>		
					</div>
					<div class="panel-footer">
						<div class="row text-right">
							<div class="col-md-12">
								<a href="<?php echo site_url('SalesMonitoring/pricelist');?>" class="btn btn-primary btn-lg btn-rect">Back</a>
								&nbsp;&nbsp;
								<button type="submit" class="btn btn-primary btn-lg btn-rect">Save Data</button>
							</div>
						</div>
					</div>
				</div>
				</div>
				</div>
			</form>
			</div>
		</div>
	</div>
	</div>
</section>