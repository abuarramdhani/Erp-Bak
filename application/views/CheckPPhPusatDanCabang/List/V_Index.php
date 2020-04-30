<style type="text/css">
	.table-but td {
		/*border: 1px solid black;*/
		padding: 2px;
	}

	.table-but td:first-child{
		padding-right: 20px;
		width: 60%;
	}

	.table-but{
		width: 80%;
	}

	.btns {
		width: 100%;
	}
	.td-center{
		vertical-align: top
	}

	.btns2 {
		width: 100%;
	}

	.tblDataPPHCabang {
		/*border: 1px solid black;*/
	}

</style>
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
							<a class="btn btn-default btn-lg" href="<?php echo base_url('AccountPayables/CheckPPhCabang/List');?>">
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
							<b> Daftar Upload Batch PPH Pusat Dan Cabang </b>
						</div>
						<div class="box-body">
							<div>
								<table class="table table-striped table-bordered table-hover text-left  tblDataPPHCabang" >
									<thead>
										<tr class="bg-primary">
											<th width="5%"><center>No</center></th>
											<th width="25%"><center>Nama File</center></th>
											<th width="10%"><center>Batch Number</center></th>
											<th width="15%"><center>Tanggal Upload</center></th>
											<th width="10%"><center>Jumlah Data</center></th>
											<th width="35%"><center>Action</center></th>
										</tr>
									</thead>
									<tbody>
										<?php $i = 1;  foreach ($list as $key => $value) { ?>
										<tr>
											<td><center><b><?= $i++; ?></b></center></td>
											<td><?= $value['nama_file'] ?></td>
											<td><center><?= str_pad($value['batch_num'], 3, 0 , STR_PAD_LEFT);  ?></center></td>
											<td><center><?= date('d-M-Y', strtotime($value['tgl_upload']));  ?></center></td>
											<td><center><?= $value['jumlah'] ?></center></td>
											<td>
												<center>
												<form target="_blank" action="<?= base_url('AccountPayables/CheckPPhPusatDanCabang/List/action') ?>" method="POST">
												<table class="table-but">
													<tr>
														<td>
															<input type="hidden" name="txtBatchNum" value="<?= $value['batch_num']; ?>">
															<button name="jenisAct" value="subPPH" class="btn btn-xs btn-primary btns"> 
																<b class="fa fa-file-text "></b> Lap. Subtotal PPH Pusat Dan Cabang
															</button>
														</td>
														<td rowspan="3" class="td-center">
															<?php if ($value['arsip'] == 1) { ?>
																<button type="button" id="btnDelPPhCabang" class="btn btn-sm btn-default btns2"> 
																	<b class="fa fa-trash"></b> Delete
																</button><br/><br />
																<button type="button" class="btn btn-sm btn-default btns2" style="color: orange ; border-color: orange"> 
																	<b class="fa fa-archive "></b> <b>Archived</b> <b class="fa fa-check" style="color:orange"></b>
																</button>
															<?php }else{ ?>
																<button type="button" id="btnDelPPhCabang" onclick="delPPHCabang(this)" data-toggle="modal" data-batch="<?= str_pad($value['batch_num'], 3, 0 , STR_PAD_LEFT);  ?>" data-target="#modalDelete" name="jenisAct" value="" class="btn btn-sm btn-danger btns2"> 
																	<b class="fa fa-trash"></b> Delete
																</button><br/><br />
																<button name="jenisAct" value="arcPPH" class="btn btn-sm btn-warning btns2"> 
																	<b class="fa fa-archive "></b> <b>Archive</b>
																</button>
															<?php } ?>
															
														</td>
													</tr>
														<td>
															<button name="jenisAct" value="sumPPH" class="btn btn-xs btn-primary btns"> 
																<b class="fa fa-file-text "></b> Lap. Summary PPH Pusat Dan Cabang
															</button>
														</td>
													</tr>
														<td>
															<button name="jenisAct" value="recPPH" class="btn btn-xs btn-primary btns"> 
																<b class="fa fa-file-text "></b> Rekap Laporan PPH Pusat Dan Cabang
															</button> 
															
														</td>
													</tr>

												</table>
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
				                            <form action="<?= base_url('AccountPayables/CheckPPhPusatDanCabang/List/action') ?>" method="POST">
				                            	<input type="hidden" name="txtBatchNum" id="batchNumbDelPPhCabang" value="">
				                              <div class="modal-header">
				                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				                                <h4 class="modal-title" id="modalDelete">Apakah anda Yakin?</h4>
				                              </div>
				                              <div class="modal-body" >
				                                <center>
				                                  Menghapus : Batch <b id="showBatchPPHCabang"></b>
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