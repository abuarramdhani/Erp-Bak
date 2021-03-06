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
								<a class="btn btn-default btn-lg" href="<?php echo site_url('Warehouse');?>">
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
								<?php 
								$no_ind = $this->session->userdata('user');
								if(in_array($no_ind, $admin)){
									?>
									<a href="<?php echo site_url('Warehouse/MasterItem/CreateUsableItem') ?>" style="float:right;margin-right:1%;margin-top:-0.5%;" alt="Add New" title="Add New" >
										<button type="button" class="btn btn-default btn-sm">
											<i class="icon-plus icon-2x"></i>
										</button>
									</a>
									<a href="<?php echo site_url('Warehouse/MasterItem/ImportUsableItem') ?>" style="float:right;margin-right:1%;margin-top:-0.5%;" alt="Import" title="Import" >
										<button type="button" class="btn btn-default btn-sm">
											<i class="icon-download icon-2x"></i>
										</button>
									</a>
									<?php 
								}

								?>
							</div>
							<div class="box-body">
								<table class="table table-striped table-bordered table-hover text-left table-item-usable" id="table-item-usable" style="font-size:12px;">
									<thead>
										<tr class="bg-primary">

											<th width="10%"><center>Action</center></th>
											<th width="5%"><center>No</center></th>
											<th width="10%"><center>Tool ID</center></th>
											<th width="30%"><center>Tool</center></th>
											<th width="15%"><center>Total</center></th>
											<th width="20%"><center>Total Dipinjam</center></th>
											<th width="20%"><center>Sisa</center></th>
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
												<?php 
												$no_ind = $this->session->userdata('user');
												if(in_array($no_ind, $admin)){
													?>
													<a class="btn btn-xs bg-green" href="<?php echo base_url('Warehouse/MasterItem/UpdateItemUsable/')."/".$encrypted_string ?>"><span title="Update <?php echo $AllUsableItem_item['item_name'] ?>" class="fa fa-edit"></span></a>
													<a class="btn btn-xs bg-maroon" href="<?php echo base_url('Warehouse/MasterItem/RemoveItemUsable/')."/".$encrypted_string ?>" onclick="return confirm('are you sure to delete this tool ?')"><span title="Update <?php echo $AllUsableItem_item['item_name'] ?>" class="fa fa-remove"></span></a>
													<?php		
												}
												?>
											</td>
											<td align="center"><?php echo $num?></td>
											<td align="center"><?php echo $AllUsableItem_item['item_id'] ?></td>
											<td><?php echo $AllUsableItem_item['item_name'] ?></td>
											<td align="center"><?php echo $AllUsableItem_item['total'] ?></td>
											<td align="center"><?php echo $AllUsableItem_item['total_dipinjam'] ?></td>
											<td align="center"><?php echo $AllUsableItem_item['sisa'] ?></td>
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