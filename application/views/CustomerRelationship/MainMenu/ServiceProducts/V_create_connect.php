<form id="formConnectNew" name="formConnectNew" method="post" action="<?php echo site_url('CustomerRelationship/ServiceProducts/CreateConnect/')?>" class="form-horizontal">
<section class="content">
	<div class="inner" >
	<div class="row">
		<div class="col-lg-12">
			<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11">
							<div class="text-right">
							<h1><b> <?php echo $title;?></b></h1>
							
						
						</div>
						</div>
						<div class="col-lg-1 ">
							<div class="text-right hidden-md hidden-sm hidden-xs">
								<a class="btn btn-default btn-lg" href="<?php echo site_url('CustomerRelationship/ServiceProducts');?>">
									<i class="icon-gears icon-2x"></i>
									<span ><br /></span>
								</a>
								

								
							</div>
						</div>
					</div>
				</div>
			<br />
		<div class="box box-primary box-solid">
			<div class="box-header with-border">
			Header
			</div>
			<div class="box-body">
				<div class="row">
				<div class="col-lg-12">

					<input type="hidden" value="<?php echo date("Y-m-d H:i:s")?>" name="hdnDate" />
					<input type="hidden" value="<?php echo $this->session->userid; ?>" name="hdnUser" />
					<input type="hidden" name="txtConnectId" id="txtConnectId" value="0" />
					
					<div class="col-lg-6">
						<div class="form-group">
								<label for="norm" class="control-label col-lg-4">Activity Type</label>
								<div class="col-lg-8">
									<select  name="slcActivityType" id="slcActivityType" class="form-control select4" onchange="getLastActivityNumber('<?php echo site_url();?>');" required>
										<option value="" ></option>
									    <option value="call_in" >Call In</option>
									    <option value="call_out" >Call Out</option>
									    <option value="social" >Social Media</option>
									    <option value="email" >Email</option>
									</select>
								</div>
						</div>
						
						<div class="form-group">
								<label class="control-label col-lg-4" for="dp2">Activity Date</label>

								<div class="col-lg-8">
									<input type="text" maxlength="11" placeholder="<?php echo date("d-M-Y")?>" name="txtServiceDate" value="<?php echo date("d-M-Y")?>" class="form-control" data-date-format="dd-M-yyyy" id="dp2" />
								</div>

						</div>
						<div class="form-group">
								<label for="norm" class="control-label col-lg-4">Customer</label>
								<div class="col-lg-8">
									<!--<input type="text" placeholder="Customer Name" name="txtCustomerName" id="txtCustomerName" onblur="selectCustomer()" onchange="enadisLineOwner()" class="form-control2"/>-->
									<div class="input-group">
										<input type="text" placeholder="Search Customer" name="txtCustomerName" id="txtCustomerName" onfocus="callModal('<?php echo site_url('ajax/ModalCustomer')?>');" onkeypress="return noInput(event)" class="form-control" />
										<span class="input-group-btn">
											<a class="btn btn-primary" href="<?php echo site_url('ajax/ModalCustomer')?>" data-toggle="modal" data-target="#myModal"><i class="icon-search"></i></a>

										</span>
									</div>
									<input type="hidden" name="hdnCustomerId" id ="hdnCustomerId"/>
									<input type="hidden" name="hdnCategoryId" id ="hdnCategoryId"  />
								</div>
						</div>
						<div class="form-group">
								<label for="norm" class="control-label col-lg-4">Contact</label>
								
									<div class="col-lg-3">
										<!--<input type="text" placeholder="Customer Name" name="txtCustomerName" id="txtCustomerName" onblur="selectCustomer()" onchange="enadisLineOwner()" class="form-control2"/>-->
										
										<select  name="slcContactType" id="slcContactType" class="form-control select4" >
											<option value="" ></option>
											<option value="HANDPHONE" >HP</option>
											<option value="TELEPHONE" >TELP</option>
										</select>
										
									</div>
									<div class="col-lg-4">
										<!--<input type="text" placeholder="Customer Name" name="txtCustomerName" id="txtCustomerName" onblur="selectCustomer()" onchange="enadisLineOwner()" class="form-control2"/>-->
										
										<select  name="slcContact" id="slcContact" class="form-control jsContactNumber">
											<option value="" ></option>
										</select>
										
									</div>
									<div class="col-lg-1">
										<input type="checkbox" name="chkSave" value="Save">Save
										
									</div>
								
						</div>
					</div>
					<div class="col-lg-6">
						<div class="form-group">
								<label for="norm" class="control-label col-lg-4">Activity Number</label>
								<div class="col-lg-8">
									<input type="text" name="txtServiceNumber" id="txtServiceNumber" class="form-control" required readonly/>
								</div>
						</div>
						<div class="form-group">

								<label for="norm" class="control-label col-lg-4">Activity Status</label>
								<div class="col-lg-8">
									<input type="text" placeholder="Service Status" name="txtActivityStatus" id="txtActivityStatus" value="OPEN" readonly="readonly" class="form-control"/>
								</div>
						</div>
						<div class="form-group">
								<label for="norm" class="control-label col-lg-4">Service Num</label>
								<div class="col-lg-8">
									<select name="slcServiceNum" id="slcServiceNum" class="form-control jsServiceNumber" >
										<option value=""></option>
									</select>

								</div>
						</div>
						<div class="form-group">
								<label for="norm" class="control-label col-lg-4">Line Operator</label>
								<div class="col-lg-4">
									<input type="text" placeholder="12121" maxlength=12 name="txtLineOperator" id="txtLineOperator" onkeypress="return isNumberKey(event)" class="form-control" required/>
								</div>
								<div class="col-lg-4">
									<select name="slcEmployeeNum" id="slcEmployeeNum" class="form-control jsEmployeeData" data-placeholder="Employee" required>
										<option value=""></option>
									</select>
								</div>
						</div>
						<div class="form-group">
								<label for="norm" class="control-label col-lg-4">Description</label>
								<div class="col-lg-8">
									<textarea placeholder="Description" name="txtDescription" id="txtDescription" class="form-control"></textarea>

								</div>

						</div>
						
						<input type="hidden" id="spanEmployee" />
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-lg-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							Lines
						</div>
						<div class="panel-body">
							<ul class="nav nav-tabs">
								<li class="active"><a href="#unit" data-toggle="tab">Unit Questions</a>
								</li>
								<li><a href="#faq" data-toggle="tab">Customer Feedbacks & Questions</a>
								</li>
								<li><a href="#data" data-toggle="tab">Data Questions</a>
								</li>
								<li><a href="#checklist" data-toggle="tab">Checklist</a>
								</li>
							</ul>

							<div class="tab-content">
								<div class="tab-pane fade in active" id="unit">
									<div class="table-responsive" style="overflow:hidden;">
										<div class="row">
											<div class="col-lg-12" >

												<div class="panel panel-default">
													<div class="panel-heading text-right">
														<!--<a href="javascript:void(0);" id="addSpLine" style="pointer-events:none;cursor: default" title="Tambah Baris" onclick="addRowSpLine('<?php echo base_url(); ?>')"><img src="<?php echo base_url('assets/img/row_add2.png');?>" title="Add Row" alt="Add Row" ></a>
														&nbsp;&nbsp;&nbsp;
														<a href="javascript:void(0);" id="delSpLine" style="pointer-events:none;cursor: default" title="Hapus Baris" onclick="deleteRow('tblServiceLines')"><img src="<?php echo base_url('assets/img/row_delete.png');?>" style="pointer-events:none;cursor: default" title="Delete Row" alt="Delete Row" ></a>-->
													</div>
													<div class="panel-body">
														<div class="table-responsive">
															<table class="table table-striped table-bordered table-hover text-center"  style="font-size:12px;min-width:1000px;table-layout: fixed;" name="tblCallLines" id="tblCallLines">
																<thead>
																	<tr class="bg-primary">
																		<th width="15%">Unit</th>
																		<th width="35%">Description</th>
																		<th width="10%">Body Number</th>
																		<th width="10%">Engine Number</th>
																		<!--<th width="10%">Spare Part Description</th>-->
																		<th width="8%">Use(Ha)</th>
																		
																	</tr>
																</thead>
																<tbody id="result">
																	<tr>
																	<td>
																		
																		<input type="text" disabled name="txtOwnership[]" id="txtOwnership" placeholder="Product code" class="form-control" readonly/>
																		<input type="hidden" name="hdnOwnershipId[]" id ="hdnOwnershipId" />

																	</td>
																	<td><input type="text" name="txtItemDescription[]" id="txtItemDescription" class="form-control" readonly="readonly"/></td>
																	<td><input type="text" name="txtBody[]" class="form-control" id="txtBody" disabled="disabled" style="text-align:center;"/></td>
																	<td><input type="text" name="txtEngine[]" id="txtEngine" class="form-control" disabled="disabled"/></td>
																	<td>
																		<!--<input type="text" name="txtEmployeeNum[]" onblur="selectEmployee(1);" id="txtEmployeeNum" class="form-control2" disabled="disabled"/>-->
																		<input type="text" name="txtUse[]" id="txtUse" class="form-control" disabled="disabled"/>
																		<!--<input type="hidden" name="hdnEmployeeId[]" id ="hdnEmployeeId"/>-->
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
								<div class="tab-pane fade" id="faq">
									<div class="table-responsive" style="overflow:hidden;">
										<div class="row">
											<div class="col-lg-12" >

												<div class="panel panel-default">
													<div class="panel-heading text-right">
														<a href="javascript:void(0);" title="Tambah Baris" onclick="addRowSpFaqs('<?php echo site_url();?>')"><img src="<?php echo base_url('assets/img/row_add2.png');?>" title="Add Row" alt="Add Row" ></a>
														&nbsp;&nbsp;&nbsp;
														<a href="javascript:void(0);" title="Hapus Baris" onclick="deleteRow('tblFaq')"><img src="<?php echo base_url('assets/img/row_delete.png');?>" title="Delete Row" alt="Delete Row" ></a>
													</div>
													<div class="panel-body">
														<div class="table-responsive">
															<table class="table table-striped table-bordered table-hover text-center" style="font-size:12px;" name="tblFaq" id="tblFaq">
																<thead>
																	<tr class="bg-primary">
																		<th width="15%">Type</th>
																		<th width="20%">Problem</th>
																		<th width="50%">Description</th>
																	</tr>
																</thead>
																<tbody>
																	<tr>
																	<td><select  name="slcFaqType[]" id="slcFaqType" class="form-control">
																			<option value="" ></option>
																			<option value="Complain" >Complain</option>
																			<option value="Feedback" >Feedback</option>
																			<option value="Question" >Question</option>
																			<option value="Other" >Other</option>
																		</select></td>
																	<td><input type="text" name="txtFaqDescription1[]" id="txtFaqDescription1" class="form-control faq-descriptions" /></td>
																	<td><input type="text" name="txtFaqDescription2[]" id="txtFaqDescription2" class="form-control" /></td>
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
								<div class="tab-pane fade" id="data">
									<div class="table-responsive" style="overflow:hidden;">
										<div class="row">
											<div class="col-lg-12" >

												<div class="panel panel-default">
													<div class="panel-heading text-right">
														
													</div>
													<div class="panel-body">
														<div class="table-responsive">
															<table class="table table-striped table-bordered table-hover text-left" style="font-size:12px;" name="tblAddAct" id="tblAddAct">
																<thead>
																	<tr class="bg-primary">
																		<th width="1%"><center>Num</center></th>
																		<th width="15%"><center>Questions</center></th>
																		<th width="15%"><center>Answers</center></th>
																	</tr>
																</thead>
																<tbody>
																	<tr>
																	<td>1</td>
																	<td>When is the Harvest Time?</td>
																	<td><input type="text" name="txtHarvestTime" id="txtHarvestTime" class="form-control datePicker1" data-date-format="M-yyyy" /></td>
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
								<div class="tab-pane fade" id="checklist">
									<div class="table-responsive">
									<?php
										foreach ($Checklist as $Checklist_item):
									?>
										<div class="panel-body"><div class="col-lg-1"><?php echo $Checklist_item['no_urut_checklist']; ?></div>
										<div class="col-lg-8"><?php echo $Checklist_item['checklist_description']; ?></div></div>
									
									<?php endforeach ?>
									</div>
								</div>
							</div>
							<br />
							
							<div class="row text-right">
								<div class="col-lg-12">
									<a href="<?php echo site_url('CustomerRelationship/ServiceProducts');?>" class="btn btn-primary btn-lg btn-rect">Back</a>
									<button type="submit" class="btn btn-primary btn-lg btn-rect">Save Data</button>
								</div>
							</div>
							<br />
						</div>


					</div>
				</div>
			</div>
			</div>
		</div>
		</div>
		</div>
	</div>
	
	
<section class="content">
</form>

<!-- Modal Start -->
<div class="col-lg-12">
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog"  aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">

			</div>
					</div>
			</div>
	</div>
<!-- Modal End -->
