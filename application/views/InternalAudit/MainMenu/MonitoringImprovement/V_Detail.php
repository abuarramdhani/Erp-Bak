<section class="content">
	<div class="inner" >
	<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11" style="height: 70px">
							<div class="text-right">
								<h1><b id="titleSrcFPD">Monitoring Improvement</b></h1>
							</div>
						</div>
						<div class="col-lg-1 " style="height: 70px">
							<div class="text-right ">
								<a class="" href="">
									<button class=" btn btn-default btn-md btnHoPg" style="border-radius: 50% !important">
										<b class="fa fa-desktop "></b>
									</button>
								</a>
							</div>
						</div>
					</div>
				</div>
				<div class="row" >
					<div class="col-lg-12" >
						<div class="box box-primary box-solid">
							<div class="box-header with-border">
								<button class="btn btn-md  btn-primary btnFrmFPDHome"><b>Detail Improvement</b></button>
								<a href="<?= base_url('InternalAudit/MonitoringImprovement/AddNewImprovement/'.$improvement_id); ?>">
								<button style="float: right;" class="btn btn-success btn-add "> Add New <b class="fa fa-plus"></b> </button>
								</a>
							</div>
							<div class="box-body" style="min-height: 350px" >
								<div class="res">
									<div class="col-lg-12">
										<table class="table table-curved table-striped table-hover tblDetailMonitoringIa" width="150%">
											<thead>
												<tr>
													<th rowspan="2" width="5%" >No.</th>
													<th rowspan="2" width="15%">Improvement</th>
													<th rowspan="2" width="10%">Status</th>
													<th rowspan="2" width="10%">Due Date</th>
													<th rowspan="2" width="10%">Target Indikator</th>
													<th rowspan="2" width="10%">PIC</th>
													<th rowspan="2" width="5%">Current Stage</th>
													<th colspan="2" width="20%">Last Modified</th>
													<th rowspan="2" width="15%">Action</th>
												</tr>
												<tr>
													<th width="10%">Date</th>
													<th width="10%">By</th>
												</tr>
												
											</thead>
											<tbody>
												<?php foreach ($detailImprovement as $k => $v) { ?>
												<tr class="<?= $v['type_progress'] == '5' ? 'bg-request' : '' ?>">
													<td  ><center><?= $v['no']?></center></td>
													<td class="det_improve" >
														<input type="hidden" class="kondisi" value="<?= $v['improve_kondisi'] ?>">
														<input type="hidden" class="kriteria" value="<?= $v['improve_kriteria'] ?>">
														<input type="hidden" class="akibat" value="<?= $v['improve_akibat'] ?>">
														<input type="hidden" class="penyebab" value="<?= $v['improve_penyebab'] ?>">
														<?=  $v['improve_rekomendasi'] ?>
													</td>
													<td >
														<center><?= $v['status_name'] ?></center>
													</td>
													<td >
														<center> 
															<span class="btn-xs btn <?= $v['duedate_sign'] ?>"> <?= $v['duedate'] ?></span>
														</center>
													</td>
													<td >
														<?= $v['target_indicator'] ?>
													</td>
													<td >
														<a class="userIa" data-id="<?= $v['pic_id'] ?>"><?= $v['pic_name'] ?></a>
													</td>
													<td >
														<center>
														<button data-type="2" data-id="<?= $v['id'] ?>" data-im="<?= $v['improvement_id'] ?>" data-toggle="modal" data-target="#ModDetProgHist" class="btn btn-xs btn-primary det_prog_hist_ia"> detail.. </button>
														</center>
													</td>
													<td > <center> <?= $v['last_modified_date']?> </center></td>
													<td > <center> <a class="userIa" data-id="<?= $v['last_modified_by_id'] ?>"><?= $v['last_modified_by'] ?></a> </center></td>
													<td >
														<center>
															
														<!-- <a href="<?= base_url('InternalAudit/MonitoringImprovement/Detail/'.$v['id']) ?>">
														<button class="btn btn-cust-f btn-md btn-primary" title="View Detail" data-toggle="tooltip"> <b class="fa fa-eye"></b></button>
														</a> -->
														<a href="<?= base_url('InternalAudit/MonitoringImprovement/EditDetail/'.$v['id']) ?>">
														<button class="btn btn-cust-f btn-md btn-info" title="Edit" data-toggle="tooltip"> <b class="fa fa-edit"></b></button>
														</a>
														<button class="btn btn-cust-e btn-md btn-danger btn-delete-improve-list" title="Delete" data-toggle="tooltip" data-imp-id="<?= $v['improvement_id'] ?>" data-id="<?=$v['id'] ?>"> <b class="fa fa-trash"></b></button>
														</center>
													</td>
												</tr>
												<?php } ?>
											</tbody>
										</table>
									</div>
									<div class="col-lg-12">
										
									</div>
								</div>
							</div>
							<div class="box-footer">
							</div>
						</div>
					</div>
				</div>
			</div>
	</div>
	</div>
	<!--  -->
		<div class="modal fade" id="ModDetailFinding" data-id="" role="dialog" aria-labelledby="ModDetailFinding" aria-hidden="true">
		<div class="modal-dialog" style="min-width:800px; border-radius: 20px">
			<div class="modal-content" style=" border-radius: 20px">
			  <div class="modal-header" style="background-color: #5fcdf2; border-top-right-radius: 20px; border-top-left-radius: 20px">
			  	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			  	<h4 class="modal-title"style="color: white; font-weight: bold;">Keterangan</h4>
			  </div>
			  <div class="modal-body" >
			  	<div class="form-group col-lg-12 text-center">
			  		<div class="col-lg-5"><hr class="grs"></div>
			  		<div class="col-lg-2 title-tengah">Detail</div>
			  		<div class="col-lg-5"><hr class="grs"></div>
			  	</div>
			  	<div class="form-group col-lg-12">
			  		<div class="col-lg-2">
			  			<label>Kondisi :</label>
			  		</div>
			  		<div class="col-lg-10">
			  			<textarea placeholder="Input Kondisi.." name="textareaImproveKon" readonly class="form-control"></textarea>
			  		</div>
			  	</div>
			  	<div class="form-group col-lg-12">
			  		<div class="col-lg-2">
			  			<label>Kriteria :</label>
			  		</div>
			  		<div class="col-lg-10">
			  			<textarea placeholder="Input Kriteria.." name="textareaImproveKri" readonly class="form-control"></textarea>
			  		</div>
			  	</div>
			  	<div class="form-group col-lg-12">
			  		<div class="col-lg-2">
			  			<label>Akibat :</label>
			  		</div>
			  		<div class="col-lg-10">
			  			<textarea placeholder="Input Akibat.." name="textareaImproveAki" readonly class="form-control"></textarea>
			  		</div>
			  	</div>
			  	<div class="form-group col-lg-12">
			  		<div class="col-lg-2">
			  			<label>Penyebab :</label>
			  		</div>
			  		<div class="col-lg-10">
			  			<textarea placeholder="Input Penyebab.." name="textareaImprovePenye" readonly class="form-control"></textarea>
			  		</div>
			  	</div>
			  </div>
			  <div class="modal-footer">
			    <button class="btn btn-md btn-default" data-dismiss="modal"> Close </button>
			  </div>
			</div>
		</div>
		</div>
	<!--  -->
	<div class="modal fade" id="ModDetProgHist" data-id="" role="dialog" aria-labelledby="ModDetProgHist" aria-hidden="true">
		<div class="modal-dialog" style="min-width:1000px; border-radius: 20px">
			<div class="modal-content" style=" border-radius: 20px">
			  <div class="modal-header" style="background-color: #5fcdf2; border-top-right-radius: 20px; border-top-left-radius: 20px">
			  	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			  	<h4 class="modal-title"style="color: white; font-weight: bold;">Progress History</h4>
			  </div>
			  <div class="modal-body" id="DetProgHistResult" >
			  	
			  </div>
			  <div class="modal-footer">
			  	<div class="col-lg-12">
				    <button class="btn btn-md btn-default" data-dismiss="modal"> Close </button>
				 </div>
			  </div>
			</div>
		</div>
		</div>
	<!--  -->
	<div class="modal fade" id="ModResponse" data-id="" role="dialog" aria-labelledby="ModResponse" aria-hidden="true">
		<div class="modal-dialog" style="min-width:400px; border-radius: 20px">
		<form method="post" action="<?= base_url('InternalAudit/MonitoringImprovement/SaveResponse') ?>" id="formResponseAuditor">
		<input type="hidden" name="id_response">
		<input type="hidden" name="id_detail">
		<input type="hidden" name="id_improvement">
			<div class="modal-content" style=" border-radius: 20px">
			  <div class="modal-header" style="background-color: #66d7ab; border-top-right-radius: 20px; border-top-left-radius: 20px">
			  	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			  	<h4 class="modal-title"style="color: white; font-weight: bold;">Auditor Response</h4>
			  </div>
			  <div class="modal-body" >
				  	<div class="col-lg-12">
				  	<textarea name="auditorReply" id="auditorReply" class="form-control" placeholder="Add Message Response.."></textarea>
				  	</div>
				  	<div class="col-lg-12" id="approveCheckbox">
				  		
				  	</div>
			  </div>
			  <div class="modal-footer">
			  	<div class="col-lg-12">
				    <button class="btn btn-md btn-default btn-cust-f" data-dismiss="modal"> Close </button>
				    <button class="btn btn-md btn-success btn-cust-e" type="submit"> <i class="fa fa-paper-plane "> Send </i> </button>
			  	</div>
			  </div>
			</div>
		</form>
		</div>
		</div>
			<!--  -->
		<div class="modal fade" id="ModDeleteImproveIa" data-id="" role="dialog" aria-labelledby="ModDeleteImproveIa" aria-hidden="true">
			<div class="modal-dialog" style="min-width:800px; border-radius: 20px">
				<div class="modal-content" style=" border-radius: 20px">
				  <div class="modal-header" style="background-color: #e45550; border-top-right-radius: 20px; border-top-left-radius: 20px">
				  	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				  	<h4 class="modal-title"style="color: white; font-weight: bold;">Delete Improvement</h4>
				  </div>
				  <div class="modal-body" id="detailPrintComplReport" >
				  	<center>Apakah anda Yakin?</center>
				  	<form id="formDelImprove" method="post" action="<?= base_url('InternalAudit/MonitoringImprovement/DeleteImprovementList') ?>">
				  		<input type="hidden" name="improvement_list_id" >
				  		<input type="hidden" name="improvement_id" >
				  	</form>
				  </div>
				  <div class="modal-footer">
				    <button class="btn btn-md btn-cust-f btn-default" data-dismiss="modal"> Close </button>
				    <button class="btn btn-md btn-cust-e btn-danger delImproveIa" > Delete </button>
				  </div>
				</div>
			</div>
			</div>
	<!--  -->
</section>