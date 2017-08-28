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
								<a href="<?php echo site_url('Toolroom/Transaksi/CreatePeminjaman') ?>" style="float:right;margin-right:1%;margin-top:-0.5%;" alt="Add New" title="Add New" >
									<button type="button" class="btn btn-default btn-sm">
									  <i class="icon-plus icon-2x"></i>
									</button>
								</a>
							</div>
							<div class="box-body">
									<table class="table table-striped table-bordered table-hover text-left table-item-usable" id="table-item-usable" style="font-size:12px;">
										<thead>
											<tr class="bg-primary">
												<th width="10%"><center>Action</center></th>
												<th width="5%"><center>No</center></th>
												<th width="10%"><center>Noind</center></th>
												<th width="30%"><center>Name</center></th>
												<th width="15%"><center>Toolman</center></th>
												<th width="15%"><center>Date</center></th>
											</tr>
										</thead>
										<tbody>
											<?php $num = 0;
														foreach ($ListOutGroupTransaction as $ListOutGroupTransaction_item): 
														$num++;
														$encrypted_string = $this->encrypt->encode($ListOutGroupTransaction_item['id_transaction']);
														$encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
											?>
													<tr>
														<td align="center">
															<a class="btn btn-xs bg-green" href="<?php echo base_url('Toolroom/Transaksi/UpdateItemUsable/')."/".$encrypted_string."/".$ListOutGroupTransaction_item['creation_date'] ?>"><span title="Update Peminjaman <?php echo $ListOutGroupTransaction_item['noind'] ?>" class="fa fa-edit"></span></a>
															<a class="btn btn-xs bg-maroon" href="<?php echo base_url('Toolroom/Transaksi/RemoveItemUsable/')."/".$encrypted_string."/".$ListOutGroupTransaction_item['creation_date'] ?>" onclick="return confirm('are you sure to delete this tool ?')"><span title="Delete Peminjaman <?php echo $ListOutGroupTransaction_item['noind'] ?>" class="fa fa-remove"></span></a>
															<a class="btn btn-xs bg-blue" href="<?php echo base_url('Toolroom/Transaksi/ListItemUsable/')."/".$encrypted_string."/".$ListOutGroupTransaction_item['creation_date'] ?>"><span title="View List Peminjaman <?php echo $ListOutGroupTransaction_item['noind'] ?>" class="fa fa-search"></span></a>
														</td>
														<td align="center"><?php echo $num?></td>
														<td align="center"><?php echo $ListOutGroupTransaction_item['noind'] ?></td>
														<td></td>
														<td align="center"><?php echo $ListOutGroupTransaction_item['created_by'] ?></td>
														<td align="center"><?php echo $ListOutGroupTransaction_item['creation_date'] ?></td>
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