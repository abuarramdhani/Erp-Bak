<section class="content">
	<div class="inner" >
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11">
							<div class="text-right">
							<h1><b> Update User</b></h1>
						
							</div>
						</div>
						<div class="col-lg-1 ">
							<div class="text-right hidden-md hidden-sm hidden-xs">
								<a class="btn btn-default btn-lg" href="<?php echo site_url('SystemAdministration/User');?>">
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
						Header
						</div>
						<div class="box-body">
							<?php 
						foreach ($UserData as $UserData_item): 
						?>
							<form method="post" id="form-buying-type" action="<?php echo site_url('SystemAdministration/User/UpdateUser/'.$id)?>" class="form-horizontal">
							<!-- action merupakan halaman yang dituju ketika tombol submit dalam suatu form ditekan -->
							
							<input type="hidden" value="<?php echo date("Y-m-d H:i:s")?>" name="hdnDate" id="hdnDate" />
							<input type="hidden" value="<?php echo $this->session->userid; ?>" name="hdnUser" id="hdnUser" />
							<div class="panel-heading text-left">
							</div>
							
							<div class="panel-body">
								<div class="row">
									<div class="form-group">
											<label for="norm" class="control-label col-lg-4">NIK</label>
											<div class="col-lg-4">
												<input type="text" placeholder="Username" name="txtUsername" value="<?php echo $UserData_item['user_name'] ?>" class="form-control toupper" readonly/>
											</div>
									</div>
									<div class="form-group">
											<label for="norm" class="control-label col-lg-4">New Password</label>
											<div class="col-lg-4">
												<input type="password" placeholder="Password" name="txtPassword" value="" id="txtPassword" class="form-control" />
											</div>
									</div>
									<div class="form-group">
											<label for="norm" class="control-label col-lg-4">Re-Enter Password</label>
											<div id="divPassCheck" class="col-lg-4">
												<input type="password" onkeyup="checkPass();" placeholder="Password" name="txtPasswordCheck" value="" id="txtPasswordCheck" class="form-control" />
											</div>
									</div>
									<div class="form-group">
											<label for="norm" class="control-label col-lg-4">Employee</label>
											<div class="col-lg-4">
												<select class="form-control employee-data" name="slcEmployee" data-placeholder="All Employee" style="width:100%;">
													<option value="<?php echo $UserData_item['employee_id'] ?>"><?php echo $UserData_item['employee_name'] ?></option>
												</select>
											</div>
									</div>
								</div>
								<div class="row">
									<div class="table-responsive"  style="overflow:hidden;">
										<div class="row">
											<div class="col-lg-12" >

												<div class="panel panel-default">
													<div class="panel-heading text-right">
														<a href="javascript:void(0);" id="addSpLine"  title="Tambah Baris" onclick="addRowResponsibility('<?php echo base_url(); ?>')"><img src="<?php echo base_url('assets/img/row_add2.png');?>" title="Add Row" alt="Add Row" ></a>
														&nbsp;&nbsp;&nbsp;
														<!-- <a href="javascript:void(0);" id="delSpLine" title="Hapus Baris" onclick="deleteRow('tblUserResponsbility')"><img src="<?php echo base_url('assets/img/row_delete.png');?>" style="pointer-events:none;cursor: default" title="Delete Row" alt="Delete Row" ></a> -->
													</div>
													<div class="panel-body">
														<div class="table-responsive" >
															<table class="table table-bordered table-hover text-center"  style="table-layout: fixed;" name="tblUserResponsbility" id="tblUserResponsbility">
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
																	<?php foreach($UserResponsibility as $UserResponsibility_item){
																	?>
																	<tr class="clone">
																	
																		<td>
																			<select class="form-control select4" name="slcUserResponsbility[]" id="slcUserResponsbility" required>
																				<?php foreach($Responsibility as $Responsibility_item){
																				?>
																				<option value="<?php echo $Responsibility_item['user_group_menu_id']?>"<?php if($Responsibility_item['user_group_menu_id']==$UserResponsibility_item['user_group_menu_id']){echo "selected";} ?>><?=$Responsibility_item['user_group_menu_name']?></option>
																				<?php } ?>
																			</select>
																			<input type="hidden" name="hdnUserApplicationId[]" id="hdnUserApplicationId" value="<?= $UserResponsibility_item['user_application_id']?>">
																		</td>
																		<td>
																			<select class="form-control select4" name="slcActive[]" id="slcActive" required>
																				<option value="" <?php if($UserResponsibility_item['active']=="N"){echo "selected";} ?>></option>
																				<option value="Y" <?php if($UserResponsibility_item['active']=="Y"){echo "selected";} ?>>Yes</option>
																				<option value="N" <?php if($UserResponsibility_item['active']=="N"){echo "selected";} ?>>No</option>
																			</select>
																		</td>
																		<td>
																			<select class="form-control select4" name="slcLokal[]" id="slcLokal" >
																				<option <?php if($UserResponsibility_item['lokal']==0){echo "selected";} ?> value="" ></option>
																				<option <?php if($UserResponsibility_item['lokal']==1){echo "selected";} ?>  value="1">Yes</option>
																				<option <?php if($UserResponsibility_item['lokal']==0){echo "selected";}?> value="0">No</option>
																			</select>
																		</td>
																		<td>
																			<select class="form-control select4" name="slcInternet[]" id="slcInternet" >
																				<option <?php if($UserResponsibility_item['internet']==0){echo "selected";} ?> value="" ></option>
																				<option <?php if($UserResponsibility_item['internet']==1){echo "selected";} ?> value="1">Yes</option>
																				<option <?php if($UserResponsibility_item['internet']==0){echo "selected";} ?> value="0">No</option>
																			</select>
																		</td>
																		<td>
																			<img class="loadingDeleteMenu" src="<?= base_url('assets/img/gif/loading5.gif')?>" alt="loading" style="display:none;">
																			<button type="button" id-user-responsibility="<?= $UserResponsibility_item['user_application_id'] ?>" class="btn btn-md btn-danger btnDeleteUserResponsibility"><i class="fa fa-close"></i></button>
																		</td>
																	</tr>
																	<?php } ?>

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
									<a href="<?php echo site_url('SystemAdministration/User/');?>" class="btn btn-primary btn-lg btn-rect">Back</a>
									&nbsp;&nbsp;
									<button type="button" id="btnUser" class="btn btn-primary btn-lg btn-rect" onclick="checkSave()">Save Changes</button>
								</div>
							</div>
						</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		</form>
		<?php endforeach ?>
	</div>
</section>