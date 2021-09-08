<section class="content">
	<div class="inner" >
	<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11">
							<div class="text-right">
								<h1><b>Data Module</b></h1>
						
							</div>
						</div>
						<div class="col-lg-1 ">
							<div class="text-right hidden-md hidden-sm hidden-xs">
								<a class="btn btn-default btn-lg" href="<?php echo site_url('SystemAdministration/Module/');?>">
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
								<a href="<?php echo site_url('SystemAdministration/Module/CreateModule/') ?>" style="float:right;margin-right:1%;margin-top:-0.5%;" alt="Add New" title="Add New" >
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
									<table class="table table-striped table-bordered table-hover text-left" id="tblModule" style="font-size:12px;">
										<thead>
											<tr class="bg-primary">
												<th width="5%"><center>No</center></th>
												<th width="20%"><center>Module Name</center></th>
												<th width="20%"><center>Module Link</center></th>
												<th width="20%"><center>Module Shortname</center></th>
												<th width="20%"><center>Module Image</center></th>
												<th width="10%"><center>Action</center></th>
											</tr>
										</thead>
										<tbody>
										<?php $num = 0;
													foreach ($AllModule as $Module): 
													$num++;
													$encrypted_string = $this->encrypt->encode($Module['module_id']);
													$encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
										?>
												<tr>
													<td align="center"><?php echo $num?></td>
													<td><?php echo $Module['module_name'] ?></td>
													<td><?php echo $Module['module_link'] ?></td>
													<td><?php echo $Module['module_shortname'] ?></td>
													<td><?php echo $Module['module_image'] ?> | <i class="fa <?php echo $Module['module_image'] ?>" </i></td>
													<td align="center">
													<a href="<?php echo base_url('SystemAdministration/Module/UpdateModule/')."/".$encrypted_string ?>"><img src="<?php echo base_url('assets/img/edit.png');?>" title="Update <?php echo strtoupper($Module['module_name']) ?>"></a>
													
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