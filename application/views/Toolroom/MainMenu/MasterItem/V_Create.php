<section class="content">
	<div class="inner" >
		<div class="row">
			<form method="post" action="<?php echo site_url('Toolroom/MasterItem/saveCreateUsableItem')?>" class="form-horizontal">
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
						<div> <?php echo $message; ?></div>
							<div class="panel-body">
								<div class="row col-lg-12">
									<div class="form-group">
											<label for="norm" class="control-label col-md-2 text-center">Group Toolkit</label>
											<div class="col-md-3">
												<select name="txtGroupItem" id="txtGroupItem" class="form-control select-group-item">
													<option value=""></option>
													<?php
														foreach ($AllUsableItemGroup as $AllUsableItemGroup_item){
															echo "<option value='".$AllUsableItemGroup_item['item_group_id']."'>".$AllUsableItemGroup_item['item_group']."</option>";
														}
													?>
												</select>
											</div>
									</div>
									<div class="form-group">
											<label for="norm" class="control-label col-md-2 text-center">Barcode</label>
											<div class="col-md-3">
												<input type="text" placeholder="Barcode" style="text-transform:uppercase;" name="txtBarcodeId" id="txtBarcodeId" class="form-control" required/>
											</div>
									</div>
									<div class="form-group">
											<label for="norm" class="control-label col-md-2 text-center">Tool</label>
											<div class="col-md-6">
												<input type="text" placeholder="Tool Name" style="text-transform:uppercase;" name="txtTool" id="txtTool" class="form-control" required/>
											</div>
									</div>
									<div class="form-group">
											<label for="norm" class="control-label col-md-2 text-center">Quantity</label>
											<div class="col-md-2">
												<input type="text" placeholder="Item Quantity" name="txtQuantity" id="txtQuantity" class="form-control" required/>
											</div>
											<label for="norm" class="control-label col-md-2 text-center">Min Qty</label>
											<div class="col-md-2">
												<input type="text" placeholder="Item Qty Minimal" name="txtStockOpname" id="txtStockOpname" class="form-control"/>
											</div>
									</div>
									<div class="form-group">
											<label for="norm" class="control-label col-md-2 text-center">Tool Description</label>
											<div class="col-md-10">
												<input type="text" placeholder="Description" name="txtDesc" id="txtDesc" class="form-control"/>
											</div>
									</div>
								</div>
							</div>
							<div class="panel-footer">
								<div class="row text-right">
									<a href="<?php echo site_url('Toolroom/MasterItem/Usable') ?>" class="btn btn-primary btn-lg btn-rect">Close</a>
									&nbsp;&nbsp;
									<button id="btnUser" class="btn btn-primary btn-lg btn-rect">Save</button>
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