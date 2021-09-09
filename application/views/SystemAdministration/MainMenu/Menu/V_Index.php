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
								<a class="btn btn-default btn-lg" href="<?php echo site_url('SystemAdministration/User/');?>">
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
								<a href="<?php echo site_url('SystemAdministration/Menu/CreateMenu/') ?>" style="float:right;margin-right:1%;margin-top:-0.5%;" alt="Add New" title="Add New" >
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
									<table class="table table-striped table-bordered table-hover text-left" id="tblUser" style="font-size:12px;">
										<thead>
											<tr class="bg-primary">
												<th width="5%"><center>No</center></th>
												<th width="20%"><center>Menu Name</center></th>
												<th width="20%"><center>Menu Link</center></th>
												<th width="5%"><center>Menu Icon</center></th>
												<th width="15%"><center>Menu Title</center></th>
												<th width="10%"><center>Action</center></th>
											</tr>
										</thead>
										<tbody>
											<?php $num = 0;
														foreach ($AllMenu as $AllMenu_item): 
														$num++;
														$encrypted_string = $this->encrypt->encode($AllMenu_item['menu_id']);
														$encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
											?>
												<tr>
													<td style="min-width: 20px; max-width: 20px; text-align: center;"><?php echo $num?></td>
													<td style="min-width: 250px; max-width: 250px;"><?php echo $AllMenu_item['menu_name'] ?></td>
													<td style="min-width: 250px; max-width: 250px;"><?php echo $AllMenu_item['menu_link'] ?></td>
													<td style="min-width: 80px; max-width: 80px;"><?php echo $AllMenu_item['menu_fa'] ?></td>
													<td style="min-width: 250px; max-width: 250px;"><?php echo $AllMenu_item['menu_title'] ?></td>
													<td style="min-width: 120px; max-width: 120px; text-align: center;">
														<a class="btn btn-success" href="<?= base_url('SystemAdministration/Menu/UpdateMenu/').'/'.$encrypted_string ?>" title="Update <?= $AllMenu_item['menu_name'] ?>" style="margin-right: 6px;"><i class="fa fa-edit"></i></a>
														<a class="btn btn-danger" href="#!" onclick="javascript:deleteMenu('<?= $encrypted_string ?>', '<?= $AllMenu_item['menu_name'] ?>');" title="Delete <?= $AllMenu_item['menu_name'] ?>"><i class="fa fa-trash"></i></a>
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
		function deleteMenu(id, menu = 'dummy') {
			if(id) {
				Swal.fire({
					text: "Anda yakin ingin menghapus menu " + menu + " ?",
					showCancelButton: true,
					confirmButtonText: 'Ya',
					cancelButtonText: 'Batal'
				}).then((result) => {
					if (result.value) {
						window.location.href = '<?php echo base_url('SystemAdministration/Menu/DeleteMenu/').'/' ?>' + id + '/' + menu;
					}
				});
			}
		}
</script>