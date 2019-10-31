<table class="table table-curved table-striped table-hover tblSrcFPD">
										<thead>
											<tr>
												<th>No.</th>
												<th><input type="checkbox" name="select-all"></th>
												<th>Operation Std</th>
												<th>Operation Std Desc</th>
												<th>Operation Group</th>
												<th>Start Date Active</th>
												<th>End Date Active</th>
											</tr>
										</thead>
										<tbody>
											<?php foreach ($OprProcessOpr as $key => $value) { ?>
												<tr class="row-ops">
													<td><center><?= $key+1 ?></center></td>
													<td><center><input type="checkbox" name="check[]" value="<?= $value['operation_process_std_id'] ?>"></center></td>
													<td class="opr_pro_std"><?= $value['operation_process_std'] ?></td>
													<td><?= $value['operation_process_std_desc'] ?></td>
													<td><?= $value['operation_group'] ?></td>
													<td><?= $value['start_date_active'] ?></td>
													<td><?= $value['end_date_active'] ?></td>
												</tr>
											<?php } ?>
										</tbody>
									</table>
									<div class="col-lg-12" style="margin-top: 20px">
										<button class="btn btn-md btn-success btnFPD" data-id="" ><i class="fa fa-plus "></i><b> ADD New </b></button>
										<button disabled="disabled" class="btn btn-md btn-danger  btnFPD1 " data-toggle="modal" data-target="#modalDelFPD"> <i class="fa fa-times"></i> <b> Delete </b> </button>
										<button disabled="disabled" class="btn btn-md btn-primary  btnFPD2 " data-id=""> <i class="fa fa-edit"></i> <b> Edit </b> </button>
									</div>
									<!-- modal delete -->
									<div class="modal fade" id="modalDelFPD" role="dialog" aria-labelledby="modalDelFPDtit" aria-hidden="true">
										<div class="modal-dialog" style="min-width:800px; border-radius: 20px">
										<div class="modal-content" style=" border-radius: 20px">
										  <div class="modal-header" style="background-color: #dd4b39; border-top-right-radius: 20px; border-top-left-radius: 20px">
										    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
										    <h4 class="modal-title" id="modalDelFPDtit" style="color: white; font-weight: bold;">Apakah anda Yakin?</h4>
										  </div>
										  <div class="modal-body" >
										    <center>
										      Menghapus <b id="jmlDelFPD"></b> item ?
										    </center>
										    <div id="apaajaDelFPD" class="text-center">
										    </div>
											<input type="hidden" name="ops_id" >
										  </div>
										  <div class="modal-footer">
										    <button class="btn btn-danger actionModalFPD" data-id="" >Delete</button>
										    <button type="button" class="btn btn-default closeModalFPD" data-dismiss="modal">Close</button>
										  </div>
										</div>
										</div>
									</div>