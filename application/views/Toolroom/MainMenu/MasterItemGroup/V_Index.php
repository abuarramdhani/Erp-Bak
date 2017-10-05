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
								<a href="<?php echo site_url('Toolroom/MasterItem/CreateUsableItemGroup') ?>" style="float:right;margin-right:1%;margin-top:-0.5%;" alt="Add New" title="Add New" >
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
												<th width="30%"><center>Toolkit Group</center></th>
											</tr>
										</thead>
										<tbody>
											<?php $num = 0;
														foreach ($AllUsableItemGroup as $AllUsableItemGroup_item): 
														$num++;
														$encrypted_string = $this->encrypt->encode($AllUsableItemGroup_item['item_group_id']);
														$encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
											?>
													<tr>
														<td align="center">
															<a class="btn btn-xs bg-blue" href="<?php echo base_url('Toolroom/MasterItem/ListGroupItemUsable')."/".$encrypted_string ?>"><span title="View <?php echo $AllUsableItemGroup_item['item_group'] ?>" class="fa fa-search"></span></a>
															<a class="btn btn-xs bg-green" href="<?php echo base_url('Toolroom/MasterItem/UpdateGroupItemUsable')."/".$encrypted_string ?>"><span title="Update <?php echo $AllUsableItemGroup_item['item_group'] ?>" class="fa fa-edit"></span></a>
															<a class="btn btn-xs bg-maroon" href="<?php echo base_url('Toolroom/MasterItem/RemoveGroupItemUsable')."/".$encrypted_string ?>" onclick="return confirm('are you sure to delete this tool ?')"><span title="Remove <?php echo $AllUsableItemGroup_item['item_group'] ?>" class="fa fa-remove"></span></a>
																</td>
														<td align="center"><?php echo $num?></td>
														<td align="center"><?php echo $AllUsableItemGroup_item['item_group'] ?></td>
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