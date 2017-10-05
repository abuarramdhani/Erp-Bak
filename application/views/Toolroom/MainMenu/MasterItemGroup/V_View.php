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
							<b>Header</b>
							</div>
							<div class="box-body">
									<table class="table table-striped table-bordered table-hover text-left table-item-usable" id="table-item-usable" style="font-size:12px;">
										<thead>
											<tr class="bg-primary">
												<th width="10%"><center>Action</center></th>
												<th width="5%"><center>No</center></th>
												<th width="10%"><center>Code Barcode</center></th>
												<th width="30%"><center>Tool</center></th>
												<th width="15%"><center>Qty</center></th>
												<th width="20%"><center>Min Qty</center></th>
												<th width="10%"><center>Description</center></th>
											</tr>
										</thead>
										<tbody>
											<?php $num = 0;
														foreach ($AllUsableItem as $AllUsableItem_item): 
														$num++;
														$encrypted_string = $this->encrypt->encode($AllUsableItem_item['item_id']);
														$encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
											?>
													<tr>
														<td align="center">
															<a class="btn btn-xs bg-blue" href="<?php echo base_url('Toolroom/MasterItem/UpdateItemUsable/')."/".$encrypted_string ?>"><span title="Update <?php echo $AllUsableItem_item['item_name'] ?>" class="fa fa-edit"></span></a>
															<a class="btn btn-xs bg-maroon" href="<?php echo base_url('Toolroom/MasterItem/RemoveItemUsable/')."/".$encrypted_string ?>" onclick="return confirm('are you sure to delete this tool ?')"><span title="Update <?php echo $AllUsableItem_item['item_name'] ?>" class="fa fa-remove"></span></a>
														</td>
														<td align="center"><?php echo $num?></td>
														<td align="center"><?php echo $AllUsableItem_item['item_barcode'] ?></td>
														<td><?php echo $AllUsableItem_item['item_name'] ?></td>
														<td align="center"><?php echo $AllUsableItem_item['item_qty'] ?></td>
														<td align="center"><?php echo $AllUsableItem_item['item_qty_min'] ?></td>
														<td><?php echo $AllUsableItem_item['item_desc'] ?></td>
													</tr>
											<?php endforeach ?>
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