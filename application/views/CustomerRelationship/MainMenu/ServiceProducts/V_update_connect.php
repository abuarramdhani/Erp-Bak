<script src="<?php echo base_url('assets/js/SearchFunction.js')?>" type="text/javascript"></script>

<script type="text/javascript">



 </script>
<form id="formConnectUpdate" name="formConnectUpdate" method="post" action="<?php echo site_url('CustomerRelationship/ServiceProducts/UpdateConnect/'.$id)?>" class="form-horizontal">
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
				<?php //print_r($Connect) 
				?>
					<?php 
					
					foreach ($Connect as $Connect_item): 
					 if($Connect_item['connect_date']==""){
							$activity_date= "";
						  }
						  else{
							$activity_date = date_format(date_create($Connect_item['connect_date']),'d-M-Y');
						  };
					?>
						
					<input type="hidden" value="<?php echo date("Y-m-d H:i:s")?>" name="hdnDate" />
					<input type="hidden" value="<?php echo $this->session->userid; ?>" name="hdnUser" />
					<input type="hidden" value="<?php echo $Connect_item['connect_id']; ?>" name="txtConnectId" id="txtConnectId"/>

					<div class="col-lg-6">
						<div class="form-group">
								<label for="norm" class="control-label col-lg-4">Activity Type</label>
								<div class="col-lg-8">
									<select  name="slcActivityType" id="slcActivityType" class="form-control select4" required>
										<option value="" <?php if($Connect_item['connect_type']=='') echo 'selected="selected"'; ?>></option>
									    <option value="call_in" <?php if($Connect_item['connect_type']=='call_in') echo 'selected="selected"'; ?> >Call In</option>
									    <option value="call_out" <?php if($Connect_item['connect_type']=='call_out') echo 'selected="selected"'; ?> >Call Out</option>
									    <option value="social" <?php if($Connect_item['connect_type']=='social') echo 'selected="selected"'; ?> >Social Media</option>
									    <option value="email" <?php if($Connect_item['connect_type']=='email') echo 'selected="selected"'; ?> >Email</option>
									    
									</select>
								</div>

						</div>
						
						<div class="form-group">
								<label class="control-label col-lg-4" for="dp2">Activity Date</label>

								<div class="col-lg-8">
									<input type="text" maxlength="11" placeholder="<?php echo date("d-M-Y")?>" name="txtServiceDate" value="<?php echo $activity_date ?>" class="form-control" data-date-format="dd-M-yyyy" id="dp2" />
								</div>

						</div>
						<div class="form-group">
								<label for="norm" class="control-label col-lg-4">Customer</label>
								<div class="col-lg-8">
									<!--<input type="text" placeholder="Customer Name" name="txtCustomerName" id="txtCustomerName" onblur="selectCustomer()" onchange="enadisLineOwner()" class="form-control2"/>-->
									<div class="input-group">
										<input type="text" placeholder="Search Customer" name="txtCustomerName" id="txtCustomerName" value="<?php echo strtoupper($Connect_item['customer_name'])?>" onfocus="callModal('<?php echo site_url('ajax/ModalCustomer')?>');" onkeypress="return noInput(event)" class="form-control" disabled/>
										<span class="input-group-btn">
											<a class="btn btn-primary" href="<?php echo site_url('ajax/ModalCustomer')?>" data-toggle="modal" data-target="#myModal" disabled><i class="icon-search"></i></a>

										</span>
									</div>
									<input type="hidden" name="hdnCustomerId" id ="hdnCustomerId" value="<?php echo $Connect_item['customer_id']?>"/>
									<!--<input type="hidden" name="hdnCategoryId" id ="hdnCategoryId" value="<?php echo $Connect_item['other_type']?>" />-->
								</div>
						</div>
						<div class="form-group">
								<label for="norm" class="control-label col-lg-4">Contact</label>
								
									<div class="col-lg-3">
										<!--<input type="text" placeholder="Customer Name" name="txtCustomerName" id="txtCustomerName" onblur="selectCustomer()" onchange="enadisLineOwner()" class="form-control2"/>-->
										
										<select  name="slcContactType" id="slcContactType" class="form-control select4" disabled>
											<option value="" <?php if($Connect_item['contact_type']=='') echo 'selected="selected"'; ?> ></option>
											<option value="HANDPHONE" <?php if($Connect_item['contact_type']=='HANDPHONE') echo 'selected="selected"'; ?> >HP</option>
											<option value="TELEPHONE" <?php if($Connect_item['contact_type']=='TELEPHONE') echo 'selected="selected"'; ?> >TELP</option>
										</select>
										
									</div>
									<div class="col-lg-4">
										<!--<input type="text" placeholder="Customer Name" name="txtCustomerName" id="txtCustomerName" onblur="selectCustomer()" onchange="enadisLineOwner()" class="form-control2"/>-->
										
											<select  name="slcContact" id="slcContact" class="form-control jsContactNumber" disabled>
											<option value="<?php echo $Connect_item['contact_number'] ?>">
												<?php 
													if($Connect_item['contact_number']==''){
														echo '';
													}
													else{
														echo $Connect_item['contact_number'];
													}
												?>
											</option>
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
									<input type="text" name="txtServiceNumber" class="form-control" value="<?php echo $Connect_item['connect_number']?>" readonly required />
								</div>
						</div>
						<div class="form-group">

								<label for="norm" class="control-label col-lg-4">Activity Status</label>
								<div class="col-lg-8">
									<input type="text" placeholder="Service Status" name="txtActivityStatus" id="txtActivityStatus" value="<?php echo $Connect_item['connect_status']?>" readonly="readonly" class="form-control"/>
								</div>
						</div>
						<div class="form-group">
								<label for="norm" class="control-label col-lg-4">Service Num</label>
								<div class="col-lg-8">
									<select name="slcServiceNum" id="slcServiceNum" class="form-control jsServiceNumber">
										<!--<option value=""></option>-->
										<option value="<?php echo $Connect_item['service_product_id'] ?>">
										<?php 
											if($Connect_item['service_number']==''){
												echo '';
											}
											else{
												echo $Connect_item['service_number'];
											}
										?>
										</option>
									</select>

								</div>
						</div>
						<div class="form-group">
								<label for="norm" class="control-label col-lg-4">Line Operator</label>
								<div class="col-lg-4">
									<input type="text" placeholder="12121" maxlength=12 name="txtLineOperator" id="txtLineOperator" value="<?php echo $Connect_item['line_operator']?>" onkeypress="return isNumberKey(event)" class="form-control" required/>
								</div>
								<div class="col-lg-4">
									<select name="slcEmployeeNum" id="slcEmployeeNum" class="form-control jsEmployeeData" data-placeholder="Employee" required>
										
										<option value="<?php echo $Connect_item['employee_id'] ?>">
										<?php 
											if($Connect_item['employee_id']==''){
												echo '';
											}
											else{
												echo $Connect_item['employee_code']." (".$Connect_item['employee_name'].")";
											}
										?>
										</option>
									</select>
								</div>
						</div>
						<div class="form-group">
								<label for="norm" class="control-label col-lg-4">Description</label>
								<div class="col-lg-8">
									<textarea placeholder="Description" name="txtDescription" id="txtDescription" class="form-control"><?php echo $Connect_item['description']?></textarea>

								</div>

						</div>
						
						<input type="hidden" name="txtEmployee" id="txtEmployee" value="<?php echo $Connect_item['employee_id']?>" />
						<?php 	endforeach ?>
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
															
																<?php $i=0;
																		foreach ($ConnectUnit as $ConnectUnit_item):
																		
																		
																?>
																<tr>
																<td>
																	<input type="hidden" value="<?php echo $ConnectUnit_item['used_unit_id']; ?>" name="txtUsedUnitId" id="txtUsedUnitId"/>
																	<input type="text" name="txtOwnership[]" id="txtOwnership" value="<?php echo $ConnectUnit_item['segment1'] ?>" placeholder="Product code" class="form-control" readonly/>
																	<input type="hidden" name="hdnOwnershipId[]" id ="hdnOwnershipId" value="<?php echo $ConnectUnit_item['ownership_id'] ?>" />
	
																</td>
																<td><input type="text" name="txtItemDescription[]" id="txtItemDescription" value="<?php echo $ConnectUnit_item['description'] ?>" class="form-control" readonly="readonly"/></td>
																<td><input type="text" name="txtBody[]" class="form-control" id="txtBody"value="<?php echo $ConnectUnit_item['body_num'] ?>" readonly="readonly" style="text-align:center;"/></td>
																<td><input type="text" name="txtEngine[]" id="txtEngine" class="form-control" value="<?php echo $ConnectUnit_item['engine_num'] ?>" readonly="readonly"/></td>
																<td>
																	<!--<input type="text" name="txtEmployeeNum[]" onblur="selectEmployee(1);" id="txtEmployeeNum" class="form-control2" disabled="disabled"/>-->
																	<input type="text" name="txtUse[]" id="txtUse" class="form-control" value="<?php echo $ConnectUnit_item['use'] ?>"/>
																	<!--<input type="hidden" name="hdnEmployeeId[]" id ="hdnEmployeeId"/>-->
																</td>
																
																</tr>
																<?php $i++; endforeach ?>
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
													<div class="table-responsive" style="overflow:hidden;">
														<table class="table table-striped table-bordered table-hover text-center" style="font-size:12px;" name="tblFaq" id="tblFaq">
															<thead>
																<tr class="bg-primary">
																	<th width="15%">Type</th>
																	<th width="20%">Problem</th>
																	<th width="50%">Description</th>
																</tr>
															</thead>
															<tbody>
																<?php $i = 1;
																			foreach ($ServiceProductFaqs as $ServiceProductFaqs_item): 
																	?>
																	<tr> 
																	<td><select  name="slcFaqType[]" id="slcFaqType" class="form-control">
																			<option value="" <?php if($ServiceProductFaqs_item['faq_type']=='') echo 'selected="selected"'; ?>></option>
																			<option value="Complain" <?php if($ServiceProductFaqs_item['faq_type']=='Complain') echo 'selected="selected"'; ?>>Complain</option>
																			<option value="Feedback" <?php if($ServiceProductFaqs_item['faq_type']=='Feedback') echo 'selected="selected"'; ?>>Feedback</option>
																			<option value="Question" <?php if($ServiceProductFaqs_item['faq_type']=='Question') echo 'selected="selected"'; ?>>Question</option>
																			<option value="Other" <?php if($ServiceProductFaqs_item['faq_type']=='Other') echo 'selected="selected"'; ?>>Other</option>
																		</select>
																		<input type="hidden" name="hdnFaqId[]" id="hdnFaqId" class="id" value="<?php echo $ServiceProductFaqs_item['faq_id'] ?>"/></td>
																	<td><input type="text" name="txtFaqDescription1[]" id="txtFaqDescription1" class="form-control  faq-descriptions" value="<?php echo $ServiceProductFaqs_item['faq_description1'] ?>" /></td>
																	<td><input type="text" name="txtFaqDescription2[]" id="txtFaqDescription2" class="form-control" value="<?php echo $ServiceProductFaqs_item['faq_description2'] ?>" /></td>
																	</tr>
																	
																	<?php 	$i++;
																			endforeach ?>

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
													<div class="table-responsive" style="overflow:hidden;">
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
																<td align="center">1</td>
																<td>When is the Harvest Time?</td>
																<?php if($Connect_item['harvest_time']==""){
																		$harvest_time= "";
																	  }
																	  else{
																		$harvest_time = date_format(date_create($Connect_item['harvest_time']),'M-Y');
																	  };
																?>
																<td><input type="text" name="txtHarvestTime" id="txtHarvestTime" value="<?php echo $harvest_time ?>" class="form-control datePicker1" data-date-format="M-yyyy" /></td>
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
									<button type="submit" name="btnClose" class="btn btn-danger btn-lg btn-rect">Close</button>
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
</section>
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
