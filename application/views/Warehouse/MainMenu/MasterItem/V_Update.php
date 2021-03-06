<section class="content">
	<div class="inner" >
		<div class="row">
			<form method="post" action="<?php echo base_url('Warehouse/MasterItem/saveCreateUsableItem/'.$id)?>" class="form-horizontal">
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
									<a class="btn btn-default btn-lg" href="<?php echo site_url('Warehouse');?>">
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
						foreach ($AllUsableItem as $AllUsableItem_item): 
						?>
							<div class="panel-body">
								<input type="hidden" name="idCount" value="<?php echo $AllUsableItem_item['item_count_id'] ?>">
								<div class="row col-lg-12">
									<div class="form-group">
											<label for="norm" class="control-label col-md-2 text-center">Barcode</label>
											<div class="col-md-3">
												<input type="text" placeholder="Barcode" name="txtBarcodeId" style="text-transform:uppercase;" id="txtBarcodeId" value="<?php echo $AllUsableItem_item['item_id'] ?>" class="form-control" required/>
											</div>
									</div>
									<div class="form-group">
											<label for="norm" class="control-label col-md-2 text-center">Tool</label>
											<div class="col-md-6">
												<input type="text" placeholder="Tool Name" name="txtTool" style="text-transform:uppercase;" value="<?php echo $AllUsableItem_item['item_name'] ?>" id="txtTool" class="form-control" required/>
											</div>
									</div>
									<div class="form-group">
											<label for="norm" class="control-label col-md-2 text-center">Quantity</label>
											<div class="col-md-2">
												<input type="text" placeholder="Item Quantity" name="txtQuantity" id="txtQuantity" value="<?php echo $AllUsableItem_item['item_qty'] ?>" class="form-control" required/>
											</div>
											<label for="norm" class="control-label col-md-2 text-center">min Qty</label>
											<div class="col-md-2">
												<input type="text" placeholder="Item Qty Minimal" name="txtStockOpname" value="<?php echo $AllUsableItem_item['item_qty_min'] ?>" id="txtStockOpname" class="form-control"/>
											</div>
									</div>
									<div class="form-group">
											<label for="norm" class="control-label col-md-2 text-center">Merk</label>
											<div class="col-md-2">
												<input type="text" placeholder="Merk" name="txtItemMerk" value="<?php echo $AllUsableItem_item['merk'] ?>" id="txtItemMerk" class="form-control"/>
											</div>
									</div>
									<div class="form-group">
											<label for="norm" class="control-label col-md-2 text-center">Tool Description</label>
											<div class="col-md-10">
												<input type="text" placeholder="Description" name="txtDesc" value="<?php echo $AllUsableItem_item['item_desc'] ?>" id="txtDesc" class="form-control"/>
											</div>
									</div>
								</div>
							</div>
							<div class="panel-footer">
								<div class="row text-right">
									<a href="<?php echo site_url('Warehouse/MasterItem/Usable') ?>" class="btn btn-primary btn-lg btn-rect">Close</a>
									&nbsp;&nbsp;
									<button id="btnUser" class="btn btn-primary btn-lg btn-rect">Update Data</button>
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