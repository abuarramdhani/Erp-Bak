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
								<button class="btn btn-md  btn-primary btnFrmFPDHome"><b>Form New Improvementt</b></button>
								
								</a>
							</div>
							<div class="box-body" style="min-height: 300PX" >
								<div class="res">
									<div class="col-lg-12">
										<form id="formAddNewImprove" method="post" action="<?= base_url('InternalAudit/MonitoringImprovement/SaveNewImprovement') ?>" >
										<input type="hidden" name="improvement_id" value="<?= $improvement_id ?>">
									<div class="form-group col-lg-12">
										<table class="table table-curved table-striped table-hover" id="tblImproveIA">
											<thead>
												<tr>
													<th width="5%" >No.</th>
													<th width="5%" ></th>
													<th width="25%" >Improvement</th>
													<th width="15%" >Status</th>
													<th width="15%" >Due Date</th>
													<th width="15%" >Target Indicator</th>
													<th width="20%" >PIC</th>
												</tr>
											</thead>
											<tbody>
												<tr id_ur="1">
													<td class="no_ur"><center> 1 </center></td>
													<td class="chk"><center> <input type="checkbox" name="chkIA" class="chkIA"> </center></td>
													<td>
														<center>
															<input type="hidden" name="txtImproveRekomendasi[]">
															<input type="hidden" name="txtImproveKon[]">
															<input type="hidden" name="txtImproveKrit[]">
															<input type="hidden" name="txtImproveAkib[]">
															<input type="hidden" name="txtImprovePenyeb[]">
															<span id="prevImprove">
																
															</span>
															<a class="hrefDet" href="#ModImprove" onclick="btnAhrefModImprove(this)" data-toggle="modal" > 
																<b class="fa fa-edit"></b> <i>Input Improve..</i> 
															</a>
														</center>
													</td>
													<td class="text-center">
														<select class="slc2" name="slcStatusImprove[]" data-placeholder="Select Status..">
															<option></option>
															<option value="0">OPEN</option>
															<option value="1">CLOSE</option>
															<option value="2">HOLD</option>
															<option value="3">CANCEL</option>
														</select>
													</td>
													<td class="text-center">
														<input type="" class="form-control dtpc text-center" name="dueDateImprove[]">
													</td>
													<td>
														<input type="text" class="form-control" name="targetIndicatorImprove[]">
													</td>
													<td>
														<select class="slc2 " name="slcPicImprove[]" data-placeholder="Select PIC..">
															<option></option>
															<<?php foreach ($auditeeOption as $key => $value): ?>
																<option value="<?= isset($value['staff_id']) ? $value['staff_id'] : $value['pic'] ?>"> <?= $value['employee_name'] ?></option>
															<?php endforeach ?>
														</select>
													</td>
												</tr>
											</tbody>
										</table>
										<div class="form-group col-lg-12 text-right">
											<span class="btn-add-row btn" data-toggle="tooltip" title="Add Improvement" onclick="addRowTblIA('#tblImproveIA')"> <b class="fa fa-plus"></b></span>
											<span class="btn-delete-row btn disabled btndis " onclick="delRowTblIA(this,'#tblImproveIA')" data-toggle="tooltip" title="Delete Improvement"> <b class="fa fa-times"></b></span>
										</div>
									</div>
								</form>
									<!-- Modal -->
									<div class="modal fade" id="ModImprove" data-id="" role="dialog" aria-labelledby="ModImprove" aria-hidden="true">
										<div class="modal-dialog" style="min-width:800px; border-radius: 20px">
											<div class="modal-content" style=" border-radius: 20px">
											  <div class="modal-header" style="background-color: #5fcdf2; border-top-right-radius: 20px; border-top-left-radius: 20px">
											  	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
											  	<h4 class="modal-title" id="modalDelFPDtit" style="color: white; font-weight: bold;">Add Improvement</h4>
											  </div>
											  <div class="modal-body" >
											  	<div class="form-group col-lg-12">
											  		<div class="col-lg-4">
											  			<label>Rekomendasi Improvement :</label>
											  		</div>
											  		<div class="col-lg-8">
											  			<input type="text" class="form-control" placeholder="Input Rekomendasi Improvement" name="txtRekomendasiImprovement">
											  		</div>
											  	</div>
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
											  			<textarea placeholder="Input Kondisi.." name="textareaImproveKon" class="form-control"></textarea>
											  		</div>
											  	</div>
											  	<div class="form-group col-lg-12">
											  		<div class="col-lg-2">
											  			<label>Kriteria :</label>
											  		</div>
											  		<div class="col-lg-10">
											  			<textarea placeholder="Input Kriteria.." name="textareaImproveKri" class="form-control"></textarea>
											  		</div>
											  	</div>
											  	<div class="form-group col-lg-12">
											  		<div class="col-lg-2">
											  			<label>Akibat :</label>
											  		</div>
											  		<div class="col-lg-10">
											  			<textarea placeholder="Input Akibat.." name="textareaImproveAki" class="form-control"></textarea>
											  		</div>
											  	</div>
											  	<div class="form-group col-lg-12">
											  		<div class="col-lg-2">
											  			<label>Penyebab :</label>
											  		</div>
											  		<div class="col-lg-10">
											  			<textarea placeholder="Input Penyebab.." name="textareaImprovePenye" class="form-control"></textarea>
											  		</div>
											  	</div>

											    
											  </div>
											  <div class="modal-footer">
											  	<div class="form-group col-lg-12">
											  		<div class="col-lg-12">
												    <button class="btn btn-md btn-default btn-cust-f" type="button" data-dismiss="modal"> Cancel </button>
												    <button class="btn btn-md btn-primary btn-cust-e " type="button" onclick="btnSaveImproveIA()"> Save </button>
												  	</div>
											  	</div>
											  </div>
											</div>
										</div>
									</div>
									<!-- End of modal -->
									</div>
								</div>
							</div>
							<div class="box-footer text-center">
								<a href="<?= base_url('InternalAudit/MonitoringImprovement') ?>">
								<button class="btn btn-md btn-cust-f btn-default"> BACK </button>
								</a>
								<button class="btn btn-md btn-cust-e btn-success btn-submit-newimprove"> SUBMIT </button>
							</div>
						</div>
					</div>
				</div>
			</div>
	</div>
	</div>
</section>