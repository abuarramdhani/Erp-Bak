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
								<div class="panel">
									<ul class="nav nav-tabs" role="tablist">
										<li role="presentation" class="active">
											<a href="#general" aria-controls="general" role="tab" data-toggle="tab">General</a>
										</li>
										<li role="presentation">
											<a href="#ClaimDescription" aria-controls="ClaimDescription" role="tab" data-toggle="tab">Claim Description</a>
										</li>
										<li role="presentation">
											<a href="#location" aria-controls="location" role="tab" data-toggle="tab">Location Incident</a>
										</li>
										<li role="presentation">
											<a href="#Condition" aria-controls="Condition" role="tab" data-toggle="tab">Item Condition</a>
										</li>
										<li role="presentation">
											<a href="#Details" aria-controls="Details" role="tab" data-toggle="tab">Details</a>
										</li>
									</ul>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-12">
								<div class="tab-content">
									<div role="tabpanel" class="tab-pane active" id="general">
										<input type="hidden" name="approvedis" id="approvedis" value="">
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
													<select name="officer" id="slcEmployeeNum" class="form-control jsEmployeeData" data-placeholder="Employee">
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
									<div role="tabpanel" class="tab-pane" id="ClaimDescription">
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label col-lg-4">Duration of Use</label>
												<div class="col-lg-8">
													<input type="number" class="form-control" name="durationUse" placeholder="Duration of Use" data-toggle="tooltip" data-placement="top" title="Masukkan lama waktu pemakaian" required>
													<select style="width:100%;" name="durationUseType" data-placeholder="Duration of Use Type" class="form-control select2" required>
														<option value="" disabled selected><-- PILIH TIPE SATUAN WAKTU --></option>
														<option value="muach" disabled><-- PILIH TIPE SATUAN WAKTU --></option>
														<option value="DAYS">DAYS</option>
														<option value="MONTHS">MONTHS</option>
														<option value="YEARS">YEARS</option>
													</select>
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="row">
												<div class="col-lg-12">
													<p class="help-block" style="text-align:center;">
														Choose one action for Item Claims!
													</p>
													<div class="btn-group btn-group-justified" role="group">
														<div class="btn-group" role="group">
															<button type="button" class="btn btn-default" id="claimsItem1">
																Shipment Date
															</button>
														</div>
														<div class="btn-group" role="group">
															<button type="button" class="btn btn-default" id="claimsItem2">
																Not Shipped
															</button>
														</div>
														<div class="btn-group" role="group">
															<button type="button" class="btn btn-default" id="claimsItem3">
																No Evidence
															</button>
														</div>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-lg-10 col-lg-offset-1">
													<div id="showClaimsItem"></div>
												</div>
											</div>
										</div>
									</div>
									<div role="tabpanel" class="tab-pane" id="location">
										<div class="col-lg-6">
											<div class="form-group">
												<label class="control-label col-lg-4">Province</label>
												<div class="col-lg-8">
													<select class="form-control select4" name="provinceIncident" id="provinceIncident" style="width: 100%;">
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
												<label class="control-label col-lg-4">City / Regency</label>
												<div class="col-lg-8">
													<select class="form-control select4" name="CityIncident" id="CityIncident" style="width: 100%;" disabled></select>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">District</label>
												<div class="col-lg-8">
													<select class="form-control select4" name="DistrictIncident" id="DistrictIncident" style="width: 100%;" disabled></select>
												</div>
											</div>
										</div>
										<div class="col-lg-6">
											<div class="form-group">
												<label class="control-label col-lg-4">Village</label>
												<div class="col-lg-8">
													<select class="form-control select4" name="VillageIncident" id="VillageIncident" style="width: 100%;" disabled></select>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Address</label>
												<div class="col-lg-8">
													<textarea class="form-control" rows="4" name="AddressIncident" placeholder="Address"></textarea>
												</div>
											</div>
										</div>
									</div>
									<div role="tabpanel" class="tab-pane" id="Condition">
										<div class="col-md-2 col-md-offset-1">
											<div class="form-group">
												<label>Area Category</label>
												<div class="input-group">
													<input type="checkbox" name="area[]" value="Basah tidak berair"> Basah tidak berair
													<br><input type="checkbox" name="area[]" value="Basah berair"> Basah berair
													<br><input type="checkbox" name="area[]" value="Kering"> Kering
													<br><input type="checkbox" name="area[]" value="Rawa"> Rawa
												</div>
											</div>
										</div>
										<div class="col-md-2">
											<div class="form-group">
												<label>Type of Soil</label>
												<div class="input-group">
													<input type="checkbox" name="Soil[]" value="Lempung"> Lempung
													<br><input type="checkbox" name="Soil[]" value="Berpasir"> Lempung berpasir
													<br><input type="checkbox" name="Soil[]" value="Normal"> Normal
												</div>
											</div>
										</div>
										<div class="col-md-2">
											<div class="form-group">
												<label>Depth</label>
												<div class="input-group">
													<input type="checkbox" name="Depth[]" value="Normal (10-17 cm)"> Normal (10-17 cm)
													<br><input type="checkbox" name="Depth[]" value="Sedang (17-30 cm)"> Sedang (17-30 cm)
													<br><input type="checkbox" name="Depth[]" value="Dalam (30-40 cm)"> Dalam (30-40 cm)
													<br><input type="checkbox" name="Depth[]" value="Sangat Dalam (lebih dari 40 cm)"> Sangat Dalam (lebih dari 40 cm)
												</div>
											</div>
										</div>
										<div class="col-md-2">
											<div class="form-group">
												<label>Weeds</label>
												<div class="input-group">
		      											<input type="checkbox" name="Weeds[]" value="Rumput liar">Rumput liar
													<br><input type="checkbox" name="Weeds[]" value="Tanaman perdu"> Tanaman perdu
													<br><input type="checkbox" name="Weeds[]" value="Alang - alang"> Alang - alang
												</div>
											</div>
										</div>
										<div class="col-md-2">
											<div class="form-group">
												<label>Topography</label>
												<div class="input-group">
													<input type="checkbox" name="Topography[]" value="Dataran rendah"> Dataran rendah
													<br><input type="checkbox" name="Topography[]" value="Dataran tinggi"> Dataran tinggi
													<br><input type="checkbox" name="Topography[]" value="Terasiring"> Terasiring
												</div>
											</div>
										</div>
									</div>
									<div role="tabpanel" class="tab-pane" id="Details">
										<div class="col-md-10 col-md-offset-1">
											<div class="form-group">
												<label>Details Chronology of Events</label>
												<textarea name="Chronology" placeholder="Details Chronology of Events" class="form-control" rows="4" data-toggle="tooltip" data-placement="top" title="Masukkan detail kronologis kejadian" required></textarea>
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
																						<option value="Y">PROCESS</option>
																						<option value="N">NO PROCESS</option>
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
