<section class="content">
	<div class="inner" >
	<div class="row">
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
								<a class="btn btn-default btn-lg" href="<?php echo site_url('SystemAdministration/MenuGroup/');?>">
									<i class="icon-wrench icon-2x"></i>
									<span ><br/></span>
								</a>
							</div>
						</div>
					</div>
				</div>
				<br/>
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header with-border">
								<a href="<?php echo site_url('SystemAdministration/MenuGroup/CreateMenuGroup/') ?>" style="float:right;margin-right:1%;margin-top:-0.5%;" alt="Add New" title="Add New" >
									<button type="button" class="btn btn-default btn-sm">
									  <i class="icon-plus icon-2x"></i>
									</button>
								</a>
							</div>
							<div class="box-body">
								<div class="table-responsive">
									<style type="text/css">
										.dataTables_length,.dataTables_info {
											float: left;
											width: 33%;
										}
										.dataTables_filter, .dataTables_paginate {
											float: right;
										}
									</style>
									<table class="table table-striped table-bordered table-hover text-left" id="tblMenuGroup" style="font-size:12px;">
										<thead>
											<tr class="bg-primary">
												<th width="5%"><center>No</center></th>
												<th width="20%"><center>MenuGroup Name</center></th>
												<th width="20%"><center>Total Menu</center></th>
												<th width="10%"><center>Action</center></th>
											</tr>
										</thead>
										<tbody>
											<?php
												$num = 0;
												foreach ($MenuGroup as $MenuGroup_item): 
												$num++;
												$encrypted_string = $this->encrypt->encode($MenuGroup_item['group_menu_id']);
												$encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
											?>
											<tr>
												<td align="center"><?php echo $num?></td>
												<td><?php echo $MenuGroup_item['group_menu_name'] ?></td>
												<td><?php echo $MenuGroup_item['menu'] ?></td>
												<td align="center">
													<a class="btn btn-success" href="<?= base_url('SystemAdministration/MenuGroup/UpdateMenuGroup/').'/'.$encrypted_string ?>" title="Update <?= strtoupper($MenuGroup_item['group_menu_name']) ?>" style="margin-right: 6px;"><i class="fa fa-edit"></i></a>
													<a class="btn btn-danger" href="#!" onclick="javascript:deleteMenuGroup('<?= $encrypted_string ?>', '<?= strtoupper($MenuGroup_item['group_menu_name']) ?>');" title="Delete <?= strtoupper($MenuGroup_item['group_menu_name']) ?>"><i class="fa fa-trash"></i></a>
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
<script type="text/javascript">
		function deleteMenuGroup(id, menu = 'dummy') {
			if(id) {
				Swal.fire({
					text: "Anda yakin ingin menghapus menu list " + menu + " ?",
					showCancelButton: true,
					confirmButtonText: 'Ya',
					cancelButtonText: 'Batal'
				}).then((result) => {
					if (result.value) {
						window.location.href = '<?php echo base_url('SystemAdministration/MenuGroup/DeleteMenuGroup/').'/' ?>' + id + '/' + menu;
					}
				});
			}
		}
</script>