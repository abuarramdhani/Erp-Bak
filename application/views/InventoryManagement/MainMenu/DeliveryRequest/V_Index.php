<section class="content">
	<div class="inner" >
	<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11">
							<div class="text-right">
								<h1><b><?= $Title ?></b></h1>
						
							</div>
						</div>
						<div class="col-lg-1 ">
							<div class="text-right hidden-md hidden-sm hidden-xs">
								<a class="btn btn-default btn-lg" href="<?php echo site_url('InventoryManagement/DeliveryRequest/');?>">
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
								<a href="<?php echo site_url('InventoryManagement/DeliveryRequest/CreateDeliveryRequest/') ?>" style="float:right;margin-right:1%;margin-top:-0.5%;" alt="Add New" title="Add New" >
									<button type="button" class="btn btn-default btn-sm">
									  <i class="icon-plus icon-2x"></i>
									</button>
								</a>
							</div>
							<div class="box-body">
								<div class="table-responsive">
									
									<table class="table table-striped table-bordered table-hover text-left" id="tblUser" style="font-size:12px;">
										<thead>
											<tr class="bg-primary">
												<th width="5%"><center>No</center></th>
												<th width="20%"><center>Delivery Request</center></th>
												<th width="20%"><center>Status</center></th>
												<th width="20%"><center>Menu Icon</center></th>
												<th width="15%"><center>Menu Title</center></th>
												<th width="10%"><center>Action</center></th>
											</tr>
										</thead>
										<tbody>
										<?php $num = 0;
													foreach ($DeliveryRequest as $DeliveryRequest_item): 
													$num++;
													$encrypted_string = $this->encrypt->encode($DeliveryRequest_item['DELIVERY_REQUEST_ID']);
													$encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
										?>
												<tr>
													<td align="center"><?php echo $num?></td>
													<td><?php echo $DeliveryRequest_item['SEGMENT1'] ?></td>
													<td><?php echo $DeliveryRequest_item['STATUS'] ?></td>
													<td></td>
													<td></td>
													<td align="center">
													<a href="<?php echo base_url('InventoryManagement/DeliveryRequest/UpdateDeliveryRequest/')."/".$encrypted_string ?>"><img src="<?php echo base_url('assets/img/edit.png');?>" title="Update <?php echo $DeliveryRequest_item['SEGMENT1'] ?>"></a>
													
													</td>
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
	</div>
</section>