<style>
	.select2 {
		width: 100% !important;
	}
</style>
<section class="content">
	<div class="inner">
		<div class="row">
			<form method="post" action="<?php echo site_url('SystemAdministration/User/NewUser') ?>" class="form-horizontal">
				<!-- action merupakan halaman yang dituju ketika tombol submit dalam suatu form ditekan -->
				<input type="hidden" value="<?php echo date("Y-m-d H:i:s") ?>" name="hdnDate" />
				<input type="hidden" value="<?php echo $this->session->userid; ?>" name="hdnUser" />
				<div class="col-lg-12">
					<div class="row">
						<div class="col-lg-12">
							<div class="col-lg-11">
								<div class="text-right">
									<h1><b> New User</b></h1>

								</div>
							</div>
							<div class="col-lg-1 ">
								<div class="text-right hidden-md hidden-sm hidden-xs">
									<a class="btn btn-default btn-lg" href="<?php echo site_url('SystemAdministration/User/'); ?>">
										<i class="icon-wrench icon-2x"></i>
										<span><br /></span>
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
									Header
								</div>
								<div class="box-body">
									<div class="panel-body">
										<div class="row">
											<div class="form-group">
												<label for="norm" class="control-label col-lg-4">UserName</label>
												<div class="col-lg-4">
													<input type="text" placeholder="Username" name="txtUsername" class="form-control toupper" id="txtUsernameSys" required />
												</div>
											</div>
											<div class="form-group collapse" id="txtUsernameSysExistCollapse">
												<label class="col-lg-4 col-lg-offset-4" id="txtUsernameSysExist" style="color: red"></label>
											</div>
											<div class="form-group">
												<label for="norm" class="control-label col-lg-4">Password</label>
												<div class="col-lg-4">
													<input type="password" placeholder="Password" name="txtPassword" id="txtPassword" class="form-control" required />
												</div>
											</div>
											<div class="form-group">
												<label for="norm" class="control-label col-lg-4">Re-Enter Password</label>
												<div id="divPassCheck" class="col-lg-4">
													<input type="password" onkeyup="checkPass();" placeholder="Password" name="txtPasswordCheck" id="txtPasswordCheck" class="form-control" />
												</div>
											</div>
											<div class="form-group">
												<label for="norm" class="control-label col-lg-4">Employee</label>
												<div class="col-lg-4">
													<select class="form-control employee-data" name="slcEmployee" id="slcEmployeeSys" data-placeholder="All Employee" style="width:100%;">
														<option value=""></option>
													</select>
												</div>
											</div>
											<div class="form-group collapse" id="slcEmployeeExistCollapse">
												<label class="col-lg-4 col-lg-offset-4" id="slcEmployeeExist" style="color: red"></label>
											</div>
										</div>
										<div class="row">
											<div class="table-responsive" style="overflow:hidden;">
												<div class="row">
													<div class="col-lg-12">

														<div class="panel panel-default">
															<div class="panel-heading text-right">
																<a href="javascript:void(0);" id="addResponsbility" title="Tambah Baris" onclick="addRowResponsibility('<?php echo base_url(); ?>')"><img src="<?php echo base_url('assets/img/row_add2.png'); ?>" title="Add Row" alt="Add Row"></a>
																&nbsp;&nbsp;&nbsp;
																<!-- <a href="javascript:void(0);" id="delResponsbility" title="Hapus Baris" onclick="deleteRow('tblUserResponsbility')"><img src="<?php echo base_url('assets/img/row_delete.png'); ?>" style="pointer-events:none;cursor: default" title="Delete Row" alt="Delete Row" ></a> -->
															</div>
															<div class="panel-body">
																<div class="table-responsive">
																	<table class="table table-bordered table-hover text-center" style="table-layout: fixed;" name="tblUserResponsbility" id="tblUserResponsbility">
																		<thead>
																			<tr class="bg-primary">
																				<th width="60%">Responsibility</th>
																				<th width="10%">Active</th>
																				<th width="10%">Lokal</th>
																				<th width="10%">Internet</th>
																				<th width="10%">Delete</th>
																			</tr>
																		</thead>
																		<tbody id="tbodyUserResponsibility">
																			<tr class="clone">
																				<td>
																					<select class="form-control select4" name="slcUserResponsbility[]" id="slcUserResponsbility" required>
																						<option value=""></option>
																						<?php foreach ($Responsibility as $Responsibility_item) {
																						?>
																							<option value="<?= $Responsibility_item['user_group_menu_id'] ?>"><?= $Responsibility_item['user_group_menu_name'] ?></option>
																						<?php } ?>
																					</select>
																				</td>
																				<td>
																					<select class="form-control select4" name="slcActive[]" id="slcActive" required>
																						<option value=""></option>
																						<option value="Y" selected>Yes</option>
																						<option value="N">No</option>
																					</select>
																				</td>
																				<td>
																					<select class="form-control select4" name="slcLokal[]" id="slcLokal">
																						<option value=""></option>
																						<option value="1" selected>Yes</option>
																						<option value="0">No</option>
																					</select>
																				</td>
																				<td>
																					<select class="form-control select4" name="slcInternet[]" id="slcInternet">
																						<option value=""></option>
																						<option value="1">Yes</option>
																						<option value="0" selected>No</option>
																					</select>
																				</td>
																				<td>
																					<button type="button" class="btn btn-md btn-danger btnRemoveUserResponsibility"><i class="fa fa-close"></i></button>
																				</td>
																			</tr>
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
									<div class="panel-footer">
										<div class="row text-right">
											<a href="<?php echo site_url('SystemAdministration/User/'); ?>" class="btn btn-primary btn-lg btn-rect">Back</a>
											&nbsp;&nbsp;
											<button id="btnUser" class="btn btn-primary btn-lg btn-rect">Save Data</button>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</section>