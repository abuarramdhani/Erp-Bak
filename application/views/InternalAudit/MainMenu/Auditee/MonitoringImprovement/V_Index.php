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
								<button class="btn btn-md  btn-primary btnFrmFPDHome"><b>List Improvement</b></button>
							</div>
							<div class="box-body" style="min-height: 350px" >
								<div class="res">
									<div class="col-lg-12">
										<table class="table table-curved table-striped table-hover dtb">
											<thead>
												<tr>
													<th width="5%">No.</th>
													<th width="15%">Seksi</th>
													<th width="15%">Audit Object</th>
													<th width="10%">Project Number</th>
													<th width="20%">Period</th>
													<th width="15%">Laporan Hasil Audit</th>
													<th width="10%">Improvement Completion</th>
													<th width="10%">Action</th>
												</tr>
											</thead>
											<tbody>
												<?php foreach ($dataImprovement as $k => $v) { ?>
													<tr>
													<td><center><?= $v['no'] ?></center></td>
													<td> <?= $v['section_name'] ?> </td>
													<td> <?= $v['audit_object_name'] ?> </td>
													<td>
														<center> 
															<?= $v['project_number'] ?> &nbsp;
															<?php if ($v['file_surat_tugas']) { ?>
																<a href="<?= $v['link_file_st'] ?>" target="blank_" data-toggle="tooltip" title="View Surat Tugas"><b class="fa fa-paperclip"></b> </a>
															<?php } ?>
														</center> 
													</td>
													<td>
														<center>
														<?= $v['start_period'].' - '.$v['end_period'] ?></td>
														</center> 
													<td>
														<center>
														<?php if ($v['file_hasil_audit']) { ?>
															<a href="<?= $v['link_file_ha'] ?>" target="blank_">
															<button class="btn btn-xs btn-info"> <b class="fa fa-search"> </b> View Attachment</button>
															</a>
														<?php }else{ ?>
															<button class="btn btn-xs btn-default"> <b class="fa fa-search"> </b> No Attachment..</button>
														<?php } ?>
														</center>
													</td>
													<td>
														<center>
															<span class="btn btn-xs <?= $v['sign_progress'] ?> "> <b> <?= $v['progress'] ?> % </b> </span>
														</center>
													</td>
													<td>
														<center>
															
														<a href="<?= base_url('InternalAudit/MonitoringImprovementAuditee/Detail/'.$v['id']) ?>">
														<button class="btn btn-md btn-primary" title="View Detail" data-toggle="tooltip"> <b class="fa fa-eye"></b></button>
														</a>
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
	<div class="modal fade" id="ModPrintCompReport" data-id="" role="dialog" aria-labelledby="ModPrintCompReport" aria-hidden="true">
		<div class="modal-dialog" style="min-width:1200px; border-radius: 20px">
			<div class="modal-content" style=" border-radius: 20px">
			  <div class="modal-header" style="background-color: #5fcdf2; border-top-right-radius: 20px; border-top-left-radius: 20px">
			  	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			  	<h4 class="modal-title"style="color: white; font-weight: bold;">Completion Report</h4>
			  </div>
			  <div class="modal-body" id="detailPrintComplReport" >
			  	
			  </div>
			  <div class="modal-footer">
			    <button class="btn btn-md btn-default" data-dismiss="modal"> Close </button>
			    <button class="btn btn-md btn-success" > <b class="fa fa-print"></b> Print </button>
			  </div>
			</div>
		</div>
		</div>
	<!--  -->
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
			  	<form id="formDelImprove" method="post" action="<?= base_url('InternalAudit/MonitoringImprovement/DeleteImprovement') ?>">
			  		<input type="hidden" name="improvement_id" >
			  	</form>
			  </div>
			  <div class="modal-footer">
			    <button class="btn btn-md btn-default" data-dismiss="modal"> Close </button>
			    <button class="btn btn-md btn-danger delImproveIa" > Delete </button>
			  </div>
			</div>
		</div>
		</div>
	<!--  -->
</section>