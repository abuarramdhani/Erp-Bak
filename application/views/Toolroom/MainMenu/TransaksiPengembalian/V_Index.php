<section class="content">
	<div class="inner" >
	<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11">
							<div class="text-right">
								<h1><b> <?= strtoupper($Title)?></b></h1>
						
							</div>
						</div>
						<div class="col-lg-1 ">
							<div class="text-right hidden-md hidden-sm hidden-xs">
								<a class="btn btn-default btn-lg" href="<?php echo site_url('Toolroom');?>">
									<i class="icon-calendar icon-2x"></i>
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
							</div>
							<div class="box-body">
								<div class="panel-body">
									<div class="row col-lg-12">
										<div class="form-group">
												<label for="norm" class="control-label col-md-1 text-center">Barcode</label>
												<div class="col-md-3">
													<input type="text" name="txtBarcode" id="txtBarcode" class="form-control" onChange="AddPengembalianItem('<?php echo null; ?>','<?php echo null ?>')" placeholder="[Barcode]" autofocus></input>
												</div>
												<div class="col-md-1">
													<a class="btn btn-md btn-default" id="showModalItem"><span class="fa fa-search"></span></a>
												</div>
												<div class="col-md-3">
												</div>
												<div class="col-md-3">
													<span style="color:red;float:right;font-size:15px;"><b><i>)* List Tool di pinjam Hari ini</i></b></span>
												</div>
										</div>
									</div>
								</div>
									<table class="table table-striped table-bordered table-hover text-left table-create-pengembalian-today" id="table-create-pengembalian-today" style="font-size:12px;">
										<thead>
											<tr class="bg-primary">
												<th width="5%"><center>No</center></th>
												<th width="10%"><center>Tool Code</center></th>
												<th width="55%"><center>Tool</center></th>
												<th width="10%"><center>Qty Awal</center></th>
												<th width="10%"><center>Qty Akh</center></th>
												<th width="10%"><center>Qty Pakai</center></th>
												<th width="10%"><center>Qty Return</center></th>
											</tr>
										</thead>
										<tbody>
											<?php
												if(!empty($ListOutTransaction)){
													$no = 0;
													foreach($ListOutTransaction as $ListOutTransaction_item){
														$no++;
														echo "
															<tr>
																<td class='text-center'>".$no."</td>
																<td class='text-center'>".$ListOutTransaction_item['item_id']."</td>
																<td>".$ListOutTransaction_item['item_name']."</td>
																<td class='text-center'>".$ListOutTransaction_item['item_qty']."</td>
																<td class='text-center'>".$ListOutTransaction_item['item_sisa']."</td>
																<td class='text-center'>".$ListOutTransaction_item['item_dipakai']."</td>
																<td class='text-center'>".$ListOutTransaction_item['item_qty_return']."</td>
															</tr>
														";
													}
												}
											?>
										</tbody>
									</table>
							</div>
						</div>
					</div>
				</div>
			</div>
	</div>
	</div>
</section>