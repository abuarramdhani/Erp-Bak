<form id="form-service" method="post" action="<?php echo site_url('CustomerRelationship/ServiceProducts/Create/')?>" class="form-horizontal">
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
								<div class="col-lg-6">
									<div class="form-group">
											<label for="norm" class="control-label col-lg-4">Activity Type</label>
											<div class="col-lg-8">
												<select  name="slcActivityType" id="slcActivityType" class="form-control select4" onchange="getLastActivityNumber('<?php echo site_url();?>');" required>
													<option value="" ></option>
													<option value="service_keliling" >Service Keliling</option>
													<option value="customer_visit" >Customer Visit</option>
													<option value="visit_us" >Visit Us</option>
													<option value="kirim_part" >Kirim Part</option>
													<!--<option value="others">Others</option>-->
												</select>
											</div>

									</div>
									<div class="form-group">
										<label for="norm" class="control-label col-lg-4">Officer</label>
										<div class="col-lg-8">
											<select name="slcEmployeeNum[]" id="slcEmployeeNum" class="form-control jsEmployeeData" data-placeholder="Employee">
												<option value=""></option>
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
													<input type="text" placeholder="Search Customer" name="txtCustomerName" id="txtCustomerName" onfocus="callModal('<?php echo site_url('ajax/ModalCustomer')?>');" onkeypress="return noInput(event)" class="form-control toupper" />
													<span class="input-group-btn">
														<a class="btn btn-primary" href="<?php echo site_url('ajax/ModalCustomer')?>" data-toggle="modal" data-target="#myModal"><i class="icon-search"></i></a>

													</span>
												</div>
												<input type="hidden" name="hdnCustomerId" id ="hdnCustomerId" />
												<input type="hidden" name="hdnCategoryId" id ="hdnCategoryId"  />
											</div>
									</div>
									<div class="form-group">
										<label class="control-label col-lg-4">Condition</label>
										<div class="col-lg-8">
											<textarea type="text" class="form-control" name="ConditionClaim" id="ConditionClaim" rows="1" placeholder="Condition"></textarea>
										</div>
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
											<label for="norm" class="control-label col-lg-4">Activity Number</label>
											<div class="col-lg-8">
												<input type="text" name="txtServiceNumber" id="txtServiceNumber" class="form-control" required />
											</div>
									</div>
									<div class="form-group">

											<label for="norm" class="control-label col-lg-4">Activity Status</label>
											<div class="col-lg-8">
												<input type="text" placeholder="Service Status" name="txtActivityStatus" id="txtActivityStatus" value="OPEN" readonly="readonly" class="form-control"/>
											</div>
									</div>
									<div class="form-group">
											<label for="norm" class="control-label col-lg-4">Connect Num</label>
											<div class="col-lg-8">
												<select name="slcConnectNum" id="slcConnectNum" class="form-control jsConnectNumber">
													<option value=""></option>
												</select>
											</div>
										</div>
									<div class="form-group">
											<label for="norm" class="control-label col-lg-4">Description</label>
											<div class="col-lg-8">
												<textarea placeholder="Description" name="txtDescription" id="txtDescription" class="form-control" rows="1"></textarea>
											</div>
									</div>
									<div class="form-group">
										<label class="control-label col-lg-4">Qty</label>
										<div class="col-lg-8">
											<input type="number" class="form-control" name="QtyClaim" id="QtyClaim" placeholder="Qty">
										</div>
									</div>
									<input type="hidden" id="spanEmployee" />
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-12">
								<div class="col-lg-12">
									<div class="panel panel-default">
										<div class="panel-body">
											<h5><b>Location Incident</b></h5>
											<div class="form-group">
												<label class="control-label col-lg-3">Province</label>
												<div class="col-lg-9">
													<select class="form-control select4" name="provinceIncident[]" id="provinceIncident">
														<option value=""></option>
														<option value="muach" disabled >-- Choose One --</option>
														<?php foreach ($province as $p) { ?>
															<option value="<?php echo $p['province_name']; ?>">
																<?php echo strtoupper($p['province_name']); ?>
															</option>
														<?php } ?>
													</select>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-3">City / Regency</label>
												<div class="col-lg-9">
													<select class="form-control select4" name="CityIncident[]" id="CityIncident" disabled></select>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-3">District</label>
												<div class="col-lg-9">
													<select class="form-control select4" name="DistrictIncident[]" id="DistrictIncident" disabled></select>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-3">Village</label>
												<div class="col-lg-9">
													<select class="form-control select4" name="VillageIncident[]" id="VillageIncident" disabled></select>
												</div>
											</div>
										</div>
									</div>
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
											<li class="active"><a href="#service" data-toggle="tab">Service</a>
											</li>
											<li><a href="#faq" data-toggle="tab">Customer Feedbacks & Questions</a>
											</li>
											<li><a href="#additional" data-toggle="tab">Additional Activity</a>
											</li>
											
										</ul>

										<div class="tab-content">
											<div class="tab-pane fade in active" id="service">
												<div class="table-responsive"  style="overflow:hidden;">
													<div class="row">
														<div class="col-lg-12" >

															<div class="panel panel-default">
																<div class="panel-heading text-right">
																	<a href="javascript:void(0);" id="addSpLine" style="pointer-events:none;cursor: default" title="Tambah Baris" onclick="addRowSpLine('<?php echo base_url(); ?>')"><img src="<?php echo base_url('assets/img/row_add2.png');?>" title="Add Row" alt="Add Row" ></a>
																	&nbsp;&nbsp;&nbsp;
																	<a href="javascript:void(0);" id="delSpLine" style="pointer-events:none;cursor: default" title="Hapus Baris" onclick="deleteRow('tblServiceLines')"><img src="<?php echo base_url('assets/img/row_delete.png');?>" style="pointer-events:none;cursor: default" title="Delete Row" alt="Delete Row" ></a>
																</div>
																<div class="panel-body">
																	<div class="table-responsive" >
																		<table class="table table-bordered table-hover text-center"  style="font-size:12px;min-width:2800px;table-layout: fixed;" name="tblServiceLines" id="tblServiceLines">
																			<thead>
																				<tr class="bg-primary">
																					<th width="5%">Product</th>
																					<th width="10%">Product Description</th>
																					<th width="3%">Warranty</th>
																					<th width="4%">Claim Number</th>
																					<th width="15%">Spare Part</th>
																					<th width="5%">Problem</th>
																					<th width="14%">Problem Description</th>
																					<th width="5%">Action Claim</th>
																					<th width="5%">Upload</th>
																					<th width="3%">History</th>
																				</tr>
																			</thead>
																			<tbody>
																				<tr>
																				<td>
																					
																					<input type="text" disabled name="txtOwnership[]" id="txtOwnership" onchange="enadisServiceLine(0);" onfocus="callModal('<?php echo site_url('ajax/ModalItemLines/0/')?>');" placeholder="Product code" class="form-control" />
																					<input type="hidden" name="hdnOwnershipId[]" id ="hdnOwnershipId" />

																				</td>
																				<td><input type="text" name="txtItemDescription[]" id="txtItemDescription" class="form-control" readonly="readonly"/></td>
																				<td><input type="text" name="txtWarranty[]" id="txtWarranty" class="form-control" readonly="readonly" style="text-align:center;"/></td>
																				<td><input type="text" name="txtClaimNum[]" class="form-control" id="txtClaimNum" disabled="disabled" style="text-align:center;"/></td>
																				<td>
																					<select name="slcSparePart[]" id="slcSparePart" disabled="disabled" class="form-control jsSparePart" data-placeholder="Spare part">
																						<option value=""></option>
																					</select>
																				</td>
																				<td><select  name="slcProblem[]" id="slcProblem" class="form-control jsProblem" disabled="disabled">

																						<option value="" ></option>
																					</select></td>
																				<td><input type="text" name="txtProblemDescription[]" id="txtProblemDescription" class="form-control" disabled="disabled"/></td>
																				<td>
																					<select name="actionClaim[]" id="actionClaim" class="form-control select4" data-placeholder="Action Claim" disabled>
																						<option value="" disabled selected>-- CHOOSE ONE --</option>
																						<option value="PROCESS">PROCESS</option>
																						<option value="NO">NO PROCESS</option>
																					</select>
																				</td>
																				<td>
																					<input type="file" name="claimImage" id='claimImage' disabled>
																				</td>
																				<td></td>
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
												<div class="table-responsive"  style="overflow:hidden;">
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
											<div class="tab-pane fade" id="additional">
												<div class="table-responsive"   style="overflow:hidden;">
													<div class="row">
														<div class="col-lg-12" >

															<div class="panel panel-default">
																<div class="panel-heading text-right">
																	<a href="javascript:void(0);" title="Tambah Baris" onclick="addRowAddAct('<?php echo site_url();?>')"><img src="<?php echo base_url('assets/img/row_add2.png');?>" title="Add Row" alt="Add Row" ></a>
																	&nbsp;&nbsp;&nbsp;
																	<a href="javascript:void(0);" title="Hapus Baris" onclick="deleteRow('tblAddAct')"><img src="<?php echo base_url('assets/img/row_delete.png');?>" title="Delete Row" alt="Delete Row" ></a>
																</div>
																<div class="panel-body" >
																	<div class="table-responsive">
																		<table class="table table-striped table-bordered table-hover text-center" style="font-size:12px;" name="tblAddAct" id="tblAddAct">
																			<thead>
																				<tr class="bg-primary">
																					<th width="4%">No</th>
																					<th width="36%">Additional Activity</th>
																					<th width="60%">Description</th>
																				</tr>
																			</thead>
																			<tbody>
																				<tr>
																				<td>1</td>
																				<td>
																					<select name="txtAdditionalAct[]" id="txtAdditionalAct" style="width: 100%" class="form-control jsAdditionalActivity" >
																						<option value=""></option>
																					</select>
																				</td>
																				<td><input type="text" name="txtActDescription[]" id="txtActDescription" class="form-control" /></td>
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
