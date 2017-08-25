<section class="content">
	<div class="inner" >
		<div class="row">
			<form method="post" action="<?php echo site_url('Toolroom/Transaksi/savePeminjaman')?>" enctype="multipart/form-data" class="form-horizontal">
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
							<div class="panel-body">
								<div class="row col-lg-12">
									<div class="form-group">
											<label for="norm" class="control-label col-md-1 text-center">Barcode</label>
											<div class="col-md-4">
												<select name="txtBarcode" id="txtBarcode" class="form-control select-item" onChange="AddPinjamItem()" style="width:100%;">
													<option value=""></option>
													<?php 
														foreach($AllUsableItem as $AllUsableItem_item){
															echo "<option value='".$AllUsableItem_item['item_id']."'>".$AllUsableItem_item['item_barcode']."</option>";
														}
													?>
												</select>
											</div>
									</div>
								</div>
								<br>
								<div class="row col-lg-12">
									<table class="table table-striped table-bordered table-hover text-left table-create-peminjaman" id="table-create-peminjaman" style="font-size:12px;">
										<thead>
											<tr class="bg-primary">
												<th width="5%">No.</th>
												<th width="15%"><center>Code Barcode</center></th>
												<th width="55%"><center>Tool</center></th>
												<th width="10%"><center>Stock</center></th>
												<th width="10%"><center>Pinjam</center></th>
												<th width="5%"><center>Act</center></th>
											</tr>
										</thead>
										<tbody>
										</tbody>
									</table>
								</div>
								<br>
								<div class="row col-lg-12">
									<div class="form-group">
											<label for="norm" class="control-label col-md-1 text-center">Peminjam</label>
											<div class="col-md-4">
												<select name="txtNoind" class="form-control select-noind" style="width:100%;text-transform:uppercase;">
													<option value=""></option>
												</select>
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
						</div>
						</div>
					</div>
				</div>
			</div>
			</form>
		</div>
	</div>
</section>