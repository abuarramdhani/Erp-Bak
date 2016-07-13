<form method="post" id="form-service" action="<?php echo site_url('CustomerRelationship/ServiceProducts/Update/'.$id)?>" class="form-horizontal">
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
								<?php 
								foreach ($ServiceProducts as $ServiceProducts_item): 
								?>	
								<input type="hidden" value="<?php echo date("Y-m-d H:i:s")?>" name="hdnDate" />
								<input type="hidden" value="<?php echo $this->session->userid; ?>" name="hdnUser" />
								<input type="hidden" name="hdnEmployeeId" id ="hdnEmployeeId" value="<?php echo $ServiceProducts_item['employee_id']?>"/>
								<input type="hidden" name="hdnServiceProductId" id ="hdnServiceProductId" value="<?php echo $ServiceProducts_item['service_product_id']?>"/>
								<div class="col-lg-6">
									<div class="form-group">
											<label for="norm" class="control-label col-lg-4">Activity Type</label>
											<div class="col-lg-8">									
												<select  name="slcActivityType" id="slcActivityType" class="form-control select4" required>
													<option value="" <?php if($ServiceProducts_item['service_type']=='') echo 'selected="selected"'; ?>></option>
													<option value="service_keliling" <?php if($ServiceProducts_item['service_type']=='service_keliling') echo 'selected="selected"'; ?>>Service Keliling</option>
													<option value="customer_visit" <?php if($ServiceProducts_item['service_type']=='customer_visit') echo 'selected="selected"'; ?>>Customer Visit</option>
													<option value="visit_us" <?php if($ServiceProducts_item['service_type']=='visit_us') echo 'selected="selected"'; ?>>Visit Us</option>
													<option value="kirim_part" <?php if($ServiceProducts_item['service_type']=='kirim_part') echo 'selected="selected"'; ?>>Kirim Part</option>
													<!--<option value="others" <?php if($ServiceProducts_item['service_type']=='others') echo 'selected="selected"'; ?>>Others</option>-->
												</select>									
											</div>
									</div>
									<!--<div class="form-group">
											<label for="norm" class="control-label col-lg-4">Others Type</label>
											<div class="col-lg-8">
												<input type="text" name="txtOtherType" id="txtOtherType"  class="form-control" value="<?php echo $ServiceProducts_item['claim_method']?>" disabled="disabled"/>
											</div>
									</div>-->
									<div class="form-group">
											<label for="norm" class="control-label col-lg-4">Service Date</label>
											<div class="col-lg-8">
												<input type="text" placeholder="<?php echo date("d-M-Y")?>" class="form-control" value="<?php echo date_format(date_create($ServiceProducts_item['service_date']),'d-M-Y')?>" name="txtServiceDate" name="txtServiceDate" data-date-format="dd-M-yyyy" id="dp2" />
											</div>
									</div>
									
									<div class="form-group">
											<label for="norm" class="control-label col-lg-4">Customer</label>
											<div class="col-lg-8">
												<!--<input type="text" placeholder="Customer Name" name="txtCustomerName" id="txtCustomerName" onblur="selectCustomer()" onchange="enadisLineOwner()" value="<?php echo $ServiceProducts_item['customer_name']?>" class="form-control2" <?php if($counter>0){ echo "disabled='disabled'";}?>/>
												<input type="hidden" name="hdnCustomerId" id ="hdnCustomerId" value="<?php echo $ServiceProducts_item['customer_id']?>"/>-->
												<div class="input-group">
													<input type="text" placeholder="Search Customer" name="txtCustomerName" id="txtCustomerName" value="<?php echo strtoupper($ServiceProducts_item['customer_name'])?>" 
														onfocus="callModal('<?php echo site_url('ajax/ModalCustomer')?>');" onkeypress="return noInput(event)" class="form-control" <?php if($counter>0){ echo "disabled='disabled'";}?>/>
													<span class="input-group-btn">
														<a class="btn btn-primary" href="<?php echo site_url('ajax/ModalCustomer')?>" data-toggle="modal" data-target="#myModal"><i class="icon-search"></i></a>

													</span>
													</div>
													<input type="hidden" name="hdnCustomerId" id ="hdnCustomerId" value="<?php echo $ServiceProducts_item['customer_id']?>"/>
													<input type="hidden" name="hdnCategoryId" id ="hdnCategoryId"  />
											</div>
											
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
											<label for="norm" class="control-label col-lg-4">Service Number</label>
											<div class="col-lg-8">
												<input type="text" placeholder="Service Number" name="txtServiceNumber" id="txtServiceNumber" class="form-control" value="<?php echo $ServiceProducts_item['service_number']?>" />
											</div>
											
									</div>
									<div class="form-group">
											<label for="norm" class="control-label col-lg-4">Activity Status</label>
											<div class="col-lg-8">
												<input type="text" name="txtActivityStatus" id="txtActivityStatus" class="form-control" readonly="readonly" value="<?php echo $ServiceProducts_item['service_status']?>"/> 
											</div>
									</div>
									<div class="form-group">
										<label for="norm" class="control-label col-lg-4">Connect Num</label>
										<div class="col-lg-8">
											<select name="slcConnectNum" id="slcConnectNum" class="form-control jsConnectNumber">
												<!--<option value=""></option>-->
												<option value="<?php echo $ServiceProducts_item['connect_id'] ?>">
												<?php 
													if($ServiceProducts_item['connect_id']==''){
														echo '';
													}
													else{
														echo $ServiceProducts_item['connect_number'];
													}
												?>
												</option>
											</select>
											
										</div>
									</div>
									<div class="form-group">
											<label for="norm" class="control-label col-lg-4">Description</label>
											<div class="col-lg-8">
												<textarea placeholder="Description" name="txtDescription" id="txtDescription" class="form-control"><?php echo $ServiceProducts_item['description']?></textarea>
												
											</div>
									</div>

									
								</div>
								<?php 	endforeach ?>
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
												<div class="table-responsive" style="overflow:hidden;">
													<div class="row">
														<div class="panel panel-default">
															<div class="panel-heading text-right">
																<a href="javascript:void(0);" title="Tambah Baris" onclick="addRowSpLine('<?php echo base_url(); ?>')"><img src="<?php echo base_url('assets/img/row_add2.png');?>" title="Add Row" alt="Add Row" ></a>
																&nbsp;&nbsp;&nbsp;
																<a href="javascript:void(0);" title="Hapus Baris" onclick="deleteRow('tblServiceLines')"><img src="<?php echo base_url('assets/img/row_delete.png');?>" title="Delete Row" alt="Delete Row" ></a>
															</div>
															<div class="panel-body">
																<div class="table-responsive">
																	<table class="table table-striped table-bordered table-hover text-center"  style="font-size:12px;min-width:2800px;table-layout: fixed;" name="tblServiceLines" id="tblServiceLines">
																		<thead>
																			<tr class="bg-primary">
																				<th width="5%">Product</th>
																				<th width="10%">Product Description</th>
																				<th width="3%">Warranty</th>
																				<th width="4%">Claim Number</th>
																				<th width="15%">Spare Part</th>
																				<!--<th width="10%">Spare Part Description</th>-->
																				<th width="5%">Problem</th>
																				<th width="14%">Problem Description</th>
																				<th width="14%">Actions</th>
																				<th width="5%">Technician</th>
																				<th width="5%">Status</th>
																				<th width="4%">Action Date</th>
																				<th width="3%">History</th>
																			</tr>
																		</thead>
																		<tbody>
																			<?php $i=0;
																					foreach ($ServiceProductLines as $ServiceProductLines_item):
																					if($ServiceProductLines_item['finish_date']==""){
																						$tgl_finish = "";
																					}
																					else{
																						$tgl_finish = date_format(date_create($ServiceProductLines_item['finish_date']),'d-M-Y');
																					};
																					if($ServiceProductLines_item['action_date']==""){
																						$tgl_action= "";
																					}
																					else{
																						$tgl_action = date_format(date_create($ServiceProductLines_item['action_date']),'d-M-Y');
																					};
																					
																			?>
																			<tr>
																			<td>
																				<!--<input type="text" name="txtOwnership[]" id="txtOwnership<?php echo $i; ?>" class="form-control2" onblur="selectOwnership(<?php echo $i; ?>)" onchange="enadisServiceLine(<?php echo $i; ?>)" value="<?php echo $ServiceProductLines_item['segment1'] ?>" />-->
																				<input type="text" name="txtOwnership[]" id="txtOwnership" value="<?php echo $ServiceProductLines_item['segment1'] ?>" onchange="enadisServiceLine(0);" onfocus="callModal('<?php echo site_url('ajax/ModalItemLines/'.$i.'/')?>');" placeholder="Product code" class="form-control" />
																				<input type="hidden" name="hdnServiceLinesId[]" id="hdnServiceLinesId" class="id" value="<?php echo $ServiceProductLines_item['service_product_line_id'] ?>"/>
																				<input type="hidden" name="hdnOwnershipId[]" id ="hdnOwnershipId" value="<?php echo $ServiceProductLines_item['ownership_id'] ?>" />

																			</td>
																			<td><input type="text" name="txtItemDescription[]" id="txtItemDescription" value="<?php echo $ServiceProductLines_item['item_name'] ?>" class="form-control" readonly="readonly"/></td>
																			<td><input type="text" name="txtWarranty[]" class="form-control" id="txtWarranty" readonly="readonly" value="<?php echo $ServiceProductLines_item['warranty'] ?>" style="text-align:center;"/></td>
																			<td><input type="text" name="txtClaimNum[]" class="form-control" id="txtClaimNum" value="<?php echo $ServiceProductLines_item['claim_number'] ?>" style="text-align:center;"/></td>
																			<td>
																			<!--<input type="text" name="txtSparePart[]" id="txtSparePart<?php echo $i; ?>" value="<?php echo $ServiceProductLines_item['spare_part'] ?>" onblur="selectItemSparePart(<?php echo $i; ?>)" class="form-control2 txtSparePart" />
																			<input type="hidden" name="hdnSparePartId[]" id ="hdnSparePartId<?php echo $i; ?>" value="<?php echo $ServiceProductLines_item['spare_part_id'] ?>" />-->
																			<select name="slcSparePart[]" id="slcSparePart" class="form-control jsSparePart" data-placeholder="Spare part" >
																				<option value="<?php echo $ServiceProductLines_item['spare_part_id'] ?>">
																				<?php 
																					if($ServiceProductLines_item['spare_part_id']==''){
																						echo '';
																					}
																					else{
																						echo $ServiceProductLines_item['spare_part']." (".$ServiceProductLines_item['spare_part_name'].")";
																					}
																				?>
																				</option>
																			</select>
												
																			</td>
																			<!--<td><input type="text" name="txtSparePartDescription[]" id="txtSparePartDescription<?php echo $i; ?>" value="<?php echo $ServiceProductLines_item['spare_part_name'] ?>" class="form-control" readonly="readonly"/></td>-->
																			<td><select  name="slcProblem[]" id="slcProblem" class="form-control js-problem">
																				<option value="<?php echo $ServiceProductLines_item['service_problem_id'] ?>" selected="selected"><?php echo $ServiceProductLines_item['service_problem_name'] ?></option>
																			</select></td>
																			
																			<td><input type="text" name="txtProblemDescription[]" class="form-control" id="txtProblemDescription" value="<?php echo $ServiceProductLines_item['problem_description'] ?>"/></td>																
																			<td><input type="text" name="txtAction[]" class="form-control" id="txtAction" value="<?php echo $ServiceProductLines_item['action'] ?>"/></td>
																			<td>
																			<!--<input type="text" name="txtEmployeeNum[]" id="txtEmployeeNum" onblur="selectEmployee(<?php echo $i; ?>)" value="<?php echo $ServiceProductLines_item['technician_num'] ?>" class="form-control2" />
																			<input type="hidden" name="hdnEmployeeId[]" id ="hdnEmployeeId"value="<?php echo $ServiceProductLines_item['technician_id'] ?>" />
																			<span id="spanEmployee" style="display:none;"></span>-->
																			<select name="slcEmployeeNum[]" id="slcEmployeeNum" class="form-control jsEmployeeData" data-placeholder="Employee">
																				<option value="<?php echo $ServiceProductLines_item['technician_id'] ?>">
																				<?php 
																					if($ServiceProductLines_item['technician_id']==''){
																						echo '';
																					}
																					else{
																						echo $ServiceProductLines_item['technician_num']." (".$ServiceProductLines_item['technician_name'].")";
																					}
																				?>
																				</option>
																			</select>
																			</td>
																			<td>
																				<!--<input type="text" name="txtServiceLineStatus[]" onblur="selectServiceLineStatus(<?php echo $i; ?>)" id="txtServiceLineStatus<?php echo $i; ?>" value="<?php echo $ServiceProductLines_item['service_line_status_name'] ?>" class="form-control2" />-->
																				<select name="slcServiceLineStatus[]" id="slcServiceLineStatus" onchange="changeLineStatus(<?php echo $i ?>);" class="form-control">
																					
																					<option value="OPEN" <?php if($ServiceProductLines_item['line_status']=='OPEN') echo 'selected="selected"'; ?>>OPEN</option>
																					<option value="CLOSE" <?php if($ServiceProductLines_item['line_status']=='CLOSE') echo 'selected="selected"'; ?>>CLOSE</option>
																				</select>
																				
																			</td>
																			<td>
																			<input type="text" name="txtActionDate[]" id="txtActionDate"  value="<?php echo $tgl_action; ?>" placeholder="<?php echo date("d-M-Y")?>" class="form-control" data-date-format="dd-M-yyyy" required/></td>
																			<td><a href="#" data-toggle="modal" data-target="#history<?php echo $i+1;?>">
																					<img src="<?php echo base_url('assets/img/history5.png');?>" width="30px">
																				</a>
																			</td>
										
																			</tr>
																			
																			<?php $i++; endforeach ?>
																		</tbody>
																	</table>
																	<?php
																	$i=1;
																	foreach ($ServiceProductLines as $ServiceProductLines_item){
																	?>
																	<div class="modal" id="history<?php echo $i;?>" tabindex="-1"    role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
																				<div class="modal-dialog" style="min-width:1200px;">
																					<div class="modal-content">
																						<div class="modal-header">
																							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
																							<h4 class="modal-title" id="myModalLabel">History Service Lines</h4>
																						</div>
																						
																						<div class="modal-body" >
																							<form class="form-horizontal">
																							<div class="row">
																								<div class="col-lg-6">
																									<div class="row">
																										<div class="col-lg-4"><label>Product Code</label></div>
																										<div class="col-lg-8">:&nbsp;&nbsp;<?php echo $ServiceProductLines_item['segment1'];?></div>
																									</div>
																									<div class="row">
																										<div class="col-lg-4"><label>Product Description</label></div>
																										<div class="col-lg-8">:&nbsp;&nbsp;<?php echo $ServiceProductLines_item['item_name'];?></div>
																									</div>
																									<div class="row">
																										<div class="col-lg-4"><label>Warranty</label></div>
																										<div class="col-lg-8">:&nbsp;&nbsp;<?php echo $ServiceProductLines_item['warranty'];?></div>
																									</div>
																								</div>
																								<div class="col-lg-6">
																									<div class="row">
																										<div class="col-lg-4"><label>Spare Part</label></div>
																										<div class="col-lg-8">:&nbsp;&nbsp;<?php echo $ServiceProductLines_item['spare_part'];?></div>
																									</div>
																									<div class="row">
																										<div class="col-lg-4"><label>Spare Part Description</label></div>
																										<div class="col-lg-8">:&nbsp;&nbsp;<?php echo $ServiceProductLines_item['spare_part_name'];?></div>
																									</div>
																								</div>
																							</div>
																							</form>
																							<br />
																							<table class="table table-striped table-bordered table-hover text-center"   style="font-size:12px;" name="tblServiceLines" id="dataTables-customer">
																							<thead>
																								<tr>
																									<th width="5%"></th>
																									<th width="10%">Problem</th>
																									<th width="20%">Problem Description</th>
																									<th width="20%">Actions</th>
																									<th width="15%">Technician</th>
																									<th width="15%">Status</th>
																									<th width="15%">Action Date</th>
																								</tr>
																							</thead>
																							<tbody>
																								<?php
																								$linehistories = ${'history' . $i};
																								//foreach($linehistories as $lh){
																								$p=1;
																								foreach($ServiceProductLineHistories as $ServiceProductLineHistories_item){
																									
																									if($ServiceProductLineHistories_item['action_date']==""){
																										$tgl_action= "";
																									}
																									else{
																										$tgl_action = date_format(date_create($ServiceProductLineHistories_item['action_date']),'d-M-Y');
																									};
																					
																									if($ServiceProductLineHistories_item['service_product_line_id'] == $ServiceProductLines_item['service_product_line_id'])
																									{
																								?>
																									<tr>
																										<td> <?php echo $p; ?> </td>
																										<td align="left"><?php echo $ServiceProductLineHistories_item['service_problem_name'] ?></td>
																										<td align="left"><?php echo $ServiceProductLineHistories_item['problem_description'] ?></td>
																										<td align="left"><?php echo $ServiceProductLineHistories_item['action'] ?></td>
																										<td><?php echo $ServiceProductLineHistories_item['technician_num'] ?></td>
																										<td><?php echo $ServiceProductLineHistories_item['line_status'] ?></td>
																										<td><?php echo $tgl_action ?></td>
																									</tr>
																								<?php
																									$p++;
																									}
																									
																								}
																								?>
																								</tbody>
																							</table>
																							<!--
																							
																									
																								
																							-->
																						</div>
																						<div class="modal-footer">
																							<button type="button" class="btn btn-primary btn-rect" data-dismiss="modal">Close</button>
																						</div>
																					</div>
																				</div>
																	</div>
																	<?php
																		$i++;
																	}
																	?>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
											<div class="tab-pane fade" id="faq">
												<div class="table-responsive" style="overflow:hidden;">
													<div class="row">
														
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
																			<!--<tr> 
																			<td><select  name="slcFaqType[]" id="slcFaqType" class="form-control">
																					<option value="" ></option>
																					<option value="questions" >Questions</option>
																					<option value="feedbacks" >Feedback</option>
																				</select>
																				<input type="text" name="hdnFaqId[]" id="hdnFaqId[]" /></td></td>
																			<td><input type="text" name="txtFaqDescription[]" class="form-control"/></td>
																			</tr>-->
																		</tbody>
																	</table>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
											<div class="tab-pane fade" id="additional">
											<div class="table-responsive" style="overflow:hidden;">
												<div class="row">
													
													<div class="panel panel-default">
														<div class="panel-heading text-right">
															<a href="javascript:void(0);" title="Tambah Baris" onclick="addRowAddAct('<?php echo site_url();?>')"><img src="<?php echo base_url('assets/img/row_add2.png');?>" title="Add Row" alt="Add Row" ></a>
															&nbsp;&nbsp;&nbsp;
															<a href="javascript:void(0);" title="Hapus Baris" onclick="deleteRow('tblAddAct')"><img src="<?php echo base_url('assets/img/row_delete.png');?>" title="Delete Row" alt="Delete Row" ></a>
														</div>
														<div class="panel-body">
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
																	<?php $i = 1;
																		  foreach ($ServiceProductAdditionalAct as $ServiceProductAdditionalAct_item): 
																			?>
																		<tr> 
																		<td><?php echo $i ?></td>
																		<td><select name="txtAdditionalAct[]" id="txtAdditionalAct" style="width: 100%" class="form-control jsAdditionalActivity" >
																				<option value="<?php echo $ServiceProductAdditionalAct_item['additional_activity'] ?>">
																				<?php 
																					if($ServiceProductAdditionalAct_item['service_additional_activity_id']==''){
																						echo '';
																					}
																					else{
																						echo $ServiceProductAdditionalAct_item['additional_activity_desc'];
																					}
																				?>
																				</option>
																			</select>
																			<input type="hidden" name="hdnAddActId[]" id="hdnAddActId" class="id" value="<?php echo $ServiceProductAdditionalAct_item['service_additional_activity_id'] ?>"/>
																		</td>
																		<td><input type="text" name="txtActDescription[]" id="txtActDescription" value="<?php echo $ServiceProductAdditionalAct_item['description'] ?>"  class="form-control" /></td>
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
										<br />
									<div class="row text-right">
										<div class="col-lg-12">
											<a href="<?php echo site_url('CustomerRelationship/ServiceProducts');?>" class="btn btn-primary btn-lg btn-rect">Back</a>
											<button type="submit" class="btn btn-primary btn-lg btn-rect">Update Data</button>
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
