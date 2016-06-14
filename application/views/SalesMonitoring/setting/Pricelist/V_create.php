<section class="content">
	<div class="inner" >
	<div class="row">
		<div class="col-lg-12">
			<div class="row">
				<div class="col-lg-12">
					<div class="col-lg-11">
						<div class="text-right">
						<h1><b>New Pricelist Index</b></h1>
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
			<form class="form-horizontal" method="post" action="<?php echo base_url('SalesMonitoring/pricelist/Created')?>">
				<div class="col-lg-12">
				<div class="box box-primary box-solid">
				<div class="box-header with-border">
					Header
				</div>
				<div class="box-body">
					<div class="panel-body">
						<div class="form-group">
							<label class="col-lg-2 control-label">Item Code</label>
							<div class="col-lg-4">
								<input type="text" class="form-control" placeholder="item code" name="txt_item_code" required></input>
							</div>
							<label class="col-lg-1 control-label">Price</label>
							<div class="col-lg-4">
								<input type="text" class="form-control" placeholder="price" name="txt_price" required></input>
							</div>
						</div>		
					</div>
					<div class="panel-footer">
						<div class="row text-right">
							<div class="col-md-12">
								<a href="<?php echo site_url('SalesMonitoring/pricelist');?>" class="btn btn-primary btn-lg btn-rect">Back</a>
								&nbsp;&nbsp;
								<button type="submit" class="btn btn-primary btn-lg btn-rect">Save Changes</button>
							</div>
						</div>
					</div>
					<input type="hidden" name="txt_start_date" value ="now()"></input>
					<input type="hidden" name="txt_end_date" value ="NULL"></input>
					<input type="hidden" name="txt_last_updated" value ="NULL"></input>		
					<input type="hidden" name="txt_last_update_by" value ="NULL"></input>
					<input type="hidden" name="txt_creation_date" value ="now()"></input>	
					<input type="hidden" name="txt_created_by" value ="<?php echo $this->session->userid; ?>" ></input>	
					<input type="hidden" name="txt_last_update_by" value ="NULL"></input>	
				</div>
				</div>
				</div>
			</form>
			</div>
		</div>
	</div>
	</div>
</section>
