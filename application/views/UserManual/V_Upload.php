<section class="content">
	<div class="inner" >
		<div class="row">
			<div class="col-lg-12">
				<div class="col-lg-11">
					<div class="text-right">
						<h1><b>User Manual</b></h1>
					</div>
				</div>
				<div class="col-lg-1">
					<div class="text-right hidden-md hidden-sm hidden-xs">
						<a class="btn btn-default btn-lg" href="<?php echo site_url('usermanual/upload');?>">
							<i class="icon-wrench icon-2x"></i>
							<span><br/></span>  
						</a>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div hidden class="box-header with-border" style="height: 30px;">
							</div>
							<div class="box-body">
								<div class="col-md-12">
									<form class="form-horizontal" method="POST" action="<?php echo site_url('usermanual/upload/add'); ?>" enctype="multipart/form-data">
										<div class="col-md-12">
											<div class="form-group">
												<?php
												//echo form_open_multipart(site_url('usermanual/upload/do_upload'));
												?>
												<label for="erp-um" style="margin-top: 5px" class="col-md-2 col-form-label">
													Pilih Responsiboility
												</label>
												<div class="col-md-5">
													<select style="width: 100%" required class="form-control erp-um" name="um-select" id="erp-um">
														<option value=""></option>
													</select>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-2 col-control-label" style="margin-top: 5px">
													Nama File User Manual
												</label>
												<div class="col-md-5">
													<input class="form-control" required type="text" name="um-input" id="erp-um-input">
												</div>
												<div class="col-md-4">
													<input type="file" name="fileum" style="margin-top: 5px" id="um-fileinput">
													<p style="font-size: 12px">*File : PDF *Max Size 20MB</p>
												</div>
											</div>
											<div class="col-md-7">
												<button style="float: right" type="submit" class="btn btn-primary">
													Upload
												</button>
											</div>
										</div>
									</form>                               	
								</div>
								<div class="col-md-12" style="margin-top: 50px">
									<table class="table table-striped table-bordered text-center" style="width: 100%" id="um-table">
										<thead style="background-color: #337ab7">
											<tr style="color: white">
												<th width="5%">No</th>
												<th>Responsibility</th>
												<th>File</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody>
											<?php $no = 1;
											// $key = '1!Qq';
											foreach ($tabel as $row) { 
												$encripty = $this->general->enkripsi($row['id_um']); ?>
												<tr>
													<td><?php echo $no; ?></td>
													<td><?php echo $row['user_group_menu_name']; ?></td>
													<td>
														<a href="<?php $link = $row['path_file'];
														 $link = preg_replace('/\s+/', '_', $link); 
															echo site_url('assets/upload/um/'.$link.'.pdf'); ?>" target="_blank">
														<?php echo $row['path_file']; ?>
														</a>
													</td>
													<td>
														<button title="copy link" class="btn btn-default um_copyclip" value="<?= site_url('assets/upload/um/'.$link.'.pdf'); ?>"><i class="fa fa-clipboard "></i></button>
														<button class="btn btn-primary glyphicon glyphicon-edit" style="color: white" data-toggle="modal" data-target="#umModal<?= $no ?>" title="edit">
														</button>
														<a href="<?php echo site_url('usermanual/upload/delete/'.$encripty); ?>"  onclick="return confirm('Hapus file <?php echo $row['path_file']; ?>');" class="btn btn-danger glyphicon glyphicon-trash" style="color: white" title="delete">
														</a>
														<div class="modal fade" id="umModal<?= $no ?>" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
															<div class="modal-dialog modal-md" role="document">
																<div class="modal-content">
																	<div class="modal-header">
																		<h5 class="modal-title" id="exampleModalLabel">Update File</h5>
																		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																			<span aria-hidden="true">&times;</span>
																		</button>
																	</div>
																	<div class="modal-body">
																		<div class="container-fluid">
																			<form class="form-horizontal" method="POST" action="<?php echo site_url('usermanual/upload/edit'); ?>" enctype="multipart/form-data">
																				<div class="col-md-12" align="center">
																					<div class="row">
																						<label for="erp-um" style="margin-top: 5px" class="col-md-12 col-form-label">
																							Pilih Responsiboility
																						</label>
																						<div class="col-md-12">
																							<select style="width: 100%;" required class="form-control erp-um" name="um-select-modal" id="erp-um-modal">
																								<option selected value="<?php echo $row['module_id'].' - '.$row['user_group_menu_name']; ?>"><?php echo $row['module_id'].' - '.$row['user_group_menu_name']; ?></option>
																								<input name="umRes" hidden value="<?php echo $row['path_file']; ?>">
																							</select>
																						</div>
																					</div>
																					<div class="row">
																						<label class="col-md-12 col-control-label" style="margin-top: 15px">
																							Nama File User Manual
																						</label>
																						<div class="col-md-12">
																							<input style="width: 100%;" class="form-control" required type="text" name="um-input-modal" id="erp-um-input-modal" value="<?php echo $row['path_file']; ?>">
																							<input hidden name="um-id-modal" value="<?php echo $encripty; ?>">
																						</div>
																					</div>
																				</div>
																			</div>
																		</div>
																		<br />
																		<div class="modal-footer">
																			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
																			<button type="submit" class="btn btn-primary">Save</button>
																		</div>
																	</form>
																</div>
															</div>
														</div>
													</td>
												</tr>
												<?php $no++; } ?>
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