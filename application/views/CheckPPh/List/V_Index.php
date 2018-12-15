
<section class="content">
	<div class="inner" >
	<div class="row">
		<div class="col-lg-12">
			<div class="row">
				<div class="col-lg-12">
					<div class="col-lg-11">
						<div class="text-right">
							<h1><b>Data List Batch Upload</b></h1>
					
						</div>
					</div>
					<div class="col-lg-1 ">
						<div class="text-right hidden-md hidden-sm hidden-xs">
							<a class="btn btn-default btn-lg" href="<?php echo base_url('AccountPayables/CheckPPh/List');?>">
								<i class="fa fa-list-alt fa-2x"></i>
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
							<b> Daftar Upload Batch PPH </b>
						</div>
						<div class="box-body">
							<div>
								<table class="table table-striped table-bordered table-hover text-left  tblDataPPH" >
									<thead>
										<tr class="bg-primary">
											<th width="5%"><center>No</center></th>
											<th width="10%"><center>Batch Number</center></th>
											<th width="15%"><center>Tanggal Upload</center></th>
											<th width="10%"><center>Jumlah Data</center></th>
											<th width="60%"><center>Action</center></th>
										</tr>
									</thead>
									<tbody>
										<?php $i = 1;  foreach ($list as $key => $value) { ?>
										<tr>
											<td><center><?= $i++; ?></center></td>
											<td><?= str_pad($value['batch_num'], 3, 0 , STR_PAD_LEFT);  ?></td>
											<td><?= date('d-M-Y', strtotime($value['tgl_upload']));  ?></td>
											<td><center><?= $value['jumlah'] ?></center></td>
											<td>
												<center>
												<form target="_blank" action="<?= base_url('AccountPayables/CheckPPh/List/action') ?>" method="POST">
													<input type="hidden" name="txtBatchNum" value="<?= $value['batch_num']; ?>">
													<button name="jenisAct" value="subPPH" class="btn btn-sm btn-primary"> 
														<b class="fa fa-file-text "></b> Lap. Subtotal PPH
													</button>
													<button name="jenisAct" value="sumPPH" class="btn btn-sm btn-primary"> 
														<b class="fa fa-file-text "></b> Lap. Summary PPH
													</button>
													<button name="jenisAct" value="recPPH" class="btn btn-sm btn-primary"> 
														<b class="fa fa-file-text "></b> Rekap Laporan PPH
													</button> 
													&nbsp;&nbsp;&nbsp;
													<?php if ($value['arsip'] == 1) { ?>
														<button type="button" id="btnDelPPh" class="btn btn-sm btn-default"> 
															<b class="fa fa-trash"></b> Delete
														</button>
														<button type="button" class="btn btn-sm btn-default" style="color: orange ; border-color: orange"> 
															<b class="fa fa-archive "></b> <b>Archived</b> <b class="fa fa-check" style="color:orange"></b>
														</button>
													<?php }else{ ?>
														<button type="button" id="btnDelPPh" onclick="delPPH(this)" data-toggle="modal" data-batch="<?= str_pad($value['batch_num'], 3, 0 , STR_PAD_LEFT);  ?>" data-target="#modalDelete" name="jenisAct" value="" class="btn btn-sm btn-danger"> 
															<b class="fa fa-trash"></b> Delete
														</button>
														<button name="jenisAct" value="arcPPH" class="btn btn-sm btn-warning"> 
															<b class="fa fa-archive "></b> <b>Archive</b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
														</button>
													<?php } ?>
												</form>
												</center>
											</td>
										</tr>
										<?php } ?>
									</tbody>
								</table>
										<div class="modal fade" id="modalDelete" role="dialog" aria-labelledby="modalDelete" aria-hidden="true">
				                          <div class="modal-dialog" style="min-width:800px;">
				                            <div class="modal-content">
				                            <form action="<?= base_url('AccountPayables/CheckPPh/List/action') ?>" method="POST">
				                            	<input type="hidden" name="txtBatchNum" id="batchNumbDelPPh" value="">
				                              <div class="modal-header">
				                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				                                <h4 class="modal-title" id="modalDelete">Apakah anda Yakin?</h4>
				                              </div>
				                              <div class="modal-body" >
				                                <center>
				                                  Menghapus : Batch <b id="showBatchPPH"></b>
				                                </center>
				                              </div>
				                              <div class="modal-footer">
				                                <button class="btn btn-danger" name="jenisAct" value="delPPH" >Delete</button>
				                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				                              </div>
				                            </form>
				                            </div>
				                          </div>
				                        </div>
				                        
							</div>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>
	</div>
</section>