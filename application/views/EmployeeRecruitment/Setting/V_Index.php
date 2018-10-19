<section class="content">
	<div class="inner" >
	<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11">
							<div class="text-right">
								<h1><b>Setting Rule</b></h1>
						
							</div>
						</div>
						<div class="col-lg-1 ">
							<div class="text-right hidden-md hidden-sm hidden-xs">
								<a class="btn btn-default btn-lg" href="<?php echo site_url('EmployeeRecruitment/Setting/index');?>">
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
								<a href="<?php echo site_url('EmployeeRecruitment/Setting/addnew') ?>" style="float:right;margin-right:1%;margin-top:-0.5%;" alt="Add New" title="Add New" >
									<button type="button" class="btn btn-default btn-sm">
									  <i class="icon-plus icon-2x"></i>
									</button>
								</a>
								List Kode Soal
							</div>
							<div class="box-body">
								<div class="table-responsive">
									
									<table class="table table-striped table-bordered table-hover text-left" id="tblUser" style="font-size:12px;">
										<thead>
											<tr class="bg-primary">
												<th width="5%"><center>No</center></th>
												<th width="20%"><center>Jenis Soal</center></th>
												<th width="20%"><center>Jumlah Soal</center></th>
												<th width="10%"><center>Action</center></th>
											</tr>
										</thead>
										<tbody>
											<?php $a=0; $no =1; foreach ($jenis_soal as $js) { ?>
											<tr>
												<td>
													<center>
														<?= $no++; ?>
													</center>
												</td>
												<td><?= $js['jenis_soal']; ?></td>
												<td><?= $js['jumlah']; ?></td>
												<td>
													<center>
														<a href="<?php echo base_url("EmployeeRecruitment/Setting/edit/$js[jenis_soal]"); ?>">
														<button class="btn btn-xs btn-primary"> <i class="fa fa-edit"></i> Edit </button>
														</a>
														<button data-toggle="modal" data-target="#confirmDel_<?= $a++; ?>" class="btn btn-xs btn-danger"> <i class="fa fa-remove"></i> Delete </button>
													</center>
												</td>
											</tr>
											<?php } ?>
										</tbody>
									</table>
									<!-- modal -->
										<?php $a=0; foreach ($jenis_soal as $jso) { ?>
											<div id="confirmDel_<?php echo $a++ ?>" class="modal fade" role="dialog">
												<div class="modal-dialog">
													<!-- konten modal-->
													<div class="modal-content">
														<!-- heading modal -->
														<div class="modal-header">
															<button type="button" class="close" data-dismiss="modal">&times;</button>
															<h4 class="modal-title">Are you sure?</h4>
														</div>
														<!-- body modal -->
														<div class="modal-body">
															<p>Jenis Soal : <?= $jso['jenis_soal']."(".$jso['jumlah']." nomor)"; ?></p>
														</div>
														<!-- footer modal -->
														<div class="modal-footer">
															<form method="post" action="<?= base_url("EmployeeRecruitment/Setting/delete") ?>">
																<input type="hidden" name="jenis_soal" value="<?= $jso['jenis_soal'] ?>">
															<button type="submit" class="btn btn-danger" >DELETE</button>
															<button type="button" class="btn btn-default" data-dismiss="modal">CANCEL</button>
															</form>
														</div>
													</div>
												</div>
											</div>
										<?php } ?>
									<!--  -->
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
	</div>
	</div>
</section>