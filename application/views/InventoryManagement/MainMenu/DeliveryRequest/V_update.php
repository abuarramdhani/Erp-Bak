<section class="content">
	<div class="inner" >
		<div class="row">
			<form method="post" id="frmDeliveryRequest" action="<?php echo site_url('InventoryManagement/DeliveryRequest/UpdateDeliveryRequest/'.$id)?>" class="form-horizontal">
					<!-- action merupakan halaman yang dituju ketika tombol submit dalam suatu form ditekan -->
					<input type="hidden" value="<?php echo date("Y-m-d H:i:s")?>" name="hdnDate" />
					<input type="hidden" value="<?php echo $this->session->userid; ?>" name="hdnUser" />
			<div class="col-lg-12">
				<div class="row">
						<div class="col-lg-12">
							<div class="col-lg-11">
								<div class="text-right">
								<h1><b><?= $Title?></b></h1>

								</div>
							</div>
							<div class="col-lg-1 ">
								<div class="text-right hidden-md hidden-sm hidden-xs">
									<a class="btn btn-default btn-lg" href="<?php echo site_url('InventoryManagement/DeliveryRequest/');?>">
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
								<?php foreach($DeliveryRequest as $DeliveryRequest_item){ ?>
								<div class="panel-body">
									<div class="row">
										<div class="col-lg-6">
										<div class="form-group">
											<label class="control-label col-lg-4">Type</label>
											<div class="col-lg-8">
												<select name="slcRequestType" id="slcRequestType" class="form-control select4" required>
													<option value=""></option>
													<option value="UNIT"<?php echo ($DeliveryRequest_item['REQUEST_TYPE']=="UNIT")?"selected":""?>>UNIT</option>
													<option value="SPARE PART" <?php echo ($DeliveryRequest_item['REQUEST_TYPE']=="SPARE PART")?"selected":""?> >SPARE PART</option>
												</select>
											</div>
										</div>
									</div>
										<div class="col-lg-6">
											<div class="form-group">
												<label class="control-label col-lg-4">Delivery Request Num</label>
												<div class="col-lg-8">
													<input type="text" value="<?= $DeliveryRequest_item['SEGMENT1']?>" name="txtDeliveryRequestNum" id="txtDeliveryRequestNum" class="form-control" required readonly/>
												</div>
												
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-6">
											<div class="form-group">
												<label class="control-label col-lg-4">Status</label>
												<div class="col-lg-8">
													<input type="text" value="<?= $DeliveryRequest_item['STATUS']?>" name="txtDeliveryStatus" id="txtDeliveryStatus" class="form-control" readonly/>
												</div>
											</div>
										</div>
										<div class="col-lg-6">
										<div class="form-group">
											<label class="control-label col-lg-4"></label>
											<div class="col-lg-8">
												<input type="text" name="txt" id="txt" class="form-control" readonly/>
											</div>
											
										</div>
									</div>
									</div>
									<div class="row">
										<div class="col-lg-6">
											<div class="form-group">
												<label class="control-label col-lg-4">Order Date</label>
												<div class="col-lg-8">
													<input type="text" value="<?= date_format(date_create($DeliveryRequest_item['ORDER_DATE']),'d-M-Y')?>" placeholder="<?= date("d-M-Y")?>" name="txtOrderDate" id="txtOrderDate" class="form-control datepicker" data-date-format="dd-M-yyyy" required/>
												</div>
											</div>
										</div>
										<div class="col-lg-6">
											<div class="form-group">
												<label class="control-label col-lg-4">Ship Request Date</label>
												<div class="col-lg-8">
													<input type="text" value="<?= date_format(date_create($DeliveryRequest_item['SHIP_REQUEST_DATE']),'d-M-Y')?>" placeholder="<?= date("d-M-Y")?>" name="txtShipRequestDate" id="txtShipRequestDate" class="form-control datepicker" data-date-format="dd-M-yyyy" required/>
												</div>
											</div>
										</div>
									</div><!--
									<div class="row">
										<div class="col-lg-6">
											<div class="form-group">
												<label class="control-label col-lg-4">IO</label>
												<div class="col-lg-8">
													<select name="slcIo" id="slcIo" class="form-control jsInvOrg" required>
														<option value="<?= $DeliveryRequest_item['ORGANIZATION_ID']?>" selected><?= $DeliveryRequest_item['ORGANIZATION_CODE']?></option>
													</select>
												</div>
											</div>
										</div>
										<div class="col-lg-6">
											<div class="form-group">
												<label class="control-label col-lg-4">SubInventory</label>
												<div class="col-lg-8">
													<select name="slcSubInventory" id="slcSubInventory" class="form-control jsSubInvOrg" <?php echo ($DeliveryRequest_item['ORGANIZATION_ID']=="")?"disabled":""; ?> required>
														<option value="<?= $DeliveryRequest_item['SUBINVENTORY']?>" selected><?= $DeliveryRequest_item['SUBINVENTORY']?></option>
													</select>
												</div>
											</div>
										</div>
									</div>-->
									<?php if(intval($this->session->org_id) === 82){
									?>
									<div class="row">
										<div class="col-lg-6">
											<div class="form-group">
												<label class="control-label col-lg-4">IO Interorg</label>
												<div class="col-lg-8">
													<select name="slcIoInterOrg" id="slcIoInterOrg" class="form-control jsInvOrg" required>
														<option value="<?= $DeliveryRequest_item['INTERORG_ORGANIZATION_ID']?>"><?= $DeliveryRequest_item['INTERORG_ORGANIZATION_CODE']?></option>
													</select>
												</div>
											</div>
										</div>
										<div class="col-lg-6">
											<div class="form-group">
												<label class="control-label col-lg-4">SubInventory Interorg</label>
												<div class="col-lg-8">
													<select name="slcSubInventoryInterOrg" id="slcSubInventoryInterOrg" class="form-control jsSubInvOrg" required >
														<option value="<?= $DeliveryRequest_item['INTERORG_SUBINVENTORY']?>"><?= $DeliveryRequest_item['INTERORG_SUBINVENTORY']?></option>
													</select>
												</div>
											</div>
										</div>
									</div>
									<?php }
									?>
									<div class="row">
										<div class="col-lg-6">
											<div class="form-group">
												<label class="control-label col-lg-4">Contract Number</label>
												<div class="col-lg-8">
													<input type="text" value="<?= $DeliveryRequest_item['CONTRACT_NUMBER']?>" placeholder="M150BISAAA" name="txtContractNumber" id="txtContractNumber" class="form-control" />
												</div>
											</div>
										</div>
										<div class="col-lg-6">
											<div class="form-group">
												<label class="control-label col-lg-4">Emblem</label>
												<div class="col-lg-8">
													<input type="text" value="<?= $DeliveryRequest_item['EMBLEM']?>" placeholder="M150BISAAA" name="txtEmblem" id="txtEmblem" class="form-control" />
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-6">
											<div class="form-group">
												<label class="control-label col-lg-4">Allocation</label>
												<div class="col-lg-8">
													<textarea placeholder="Allocation" name="txtAllocation" id="txtAllocation" class="form-control"><?= $DeliveryRequest_item['ALLOCATION']?></textarea>
												</div>
											</div>
										</div><!--
										<div class="col-lg-6">
											<div class="form-group">
												<label class="control-label col-lg-4">Destination</label>
												<div class="col-lg-8">
													<textarea placeholder="Destination" name="txtDestination" id="txtDestination" class="form-control" required><?= $DeliveryRequest_item['DESTINATION']?></textarea>
												</div>
												
											</div>
										</div>-->
										<div class="col-lg-6">
											<div class="form-group">
												<label class="control-label col-lg-4">Notes</label>
												<div class="col-lg-8">
													<textarea placeholder="Notes" name="txtNotes" id="txtNotes" class="form-control" ><?= $DeliveryRequest_item['NOTES']?></textarea>
												</div>
												
											</div>
										</div>
										
									</div>
									<div class="row">
										<div class="col-lg-6">
											<div class="form-group">
												<label class="control-label col-lg-4">Requestor</label>
												<div class="col-lg-8">
													<select name="slcRequestor" id="slcRequestor" class="form-control jsOracleEmployee" required>
															<option value="<?= $DeliveryRequest_item['REQUESTOR']?>"><?= $DeliveryRequest_item['NATIONAL_IDENTIFIER']." (".$DeliveryRequest_item['FULL_NAME'].")"?></option>
														</select>
												</div>
											</div>
										</div>
										<div class="col-lg-6">
											<div class="form-group">
												<label class="control-label col-lg-4">Blanket Number</label>
												<div class="col-lg-8">
													<input type="text" value="<?= $DeliveryRequest_item['BLANKET']?>" placeholder="M150BISAAA" name="txtBlanket" id="txtBlanket" class="form-control" />
												</div>
											</div>
										</div>
									</div>
									<div class="row">

									<?php if(intval($this->session->org_id) === 82){
									?>
										<div class="col-lg-6">
											<div class="form-group">
												<label class="control-label col-lg-4">Expedition</label>
												<div class="col-lg-8">
													<input type="text" value="<?= $DeliveryRequest_item['EXPEDITION']?>" placeholder="KHS Ekspress" name="txtExpedition" id="txtExpedition" class="form-control" />
												</div>
											</div>
										</div>
									
									<?php } ?>
									</div>
									<div class="row">
										<div class="table-responsive"  style="overflow:hidden;">
											<div class="row">
												<div class="col-lg-12" >

													<div class="panel panel-default">
														<div class="panel-heading text-right">
															<a href="javascript:void(0);" id="addItemDelivery" title="Tambah Baris" onclick=""><img src="<?php echo base_url('assets/img/row_add2.png');?>" title="Add Row" alt="Add Row" ></a>
															&nbsp;&nbsp;&nbsp;
															<a href="javascript:void(0);" id="delItemDelivery" title="Hapus Baris" onclick=""><img src="<?php echo base_url('assets/img/row_delete.png');?>" style="pointer-events:none;cursor: default" title="Delete Row" alt="Delete Row" ></a>
														</div>
														
														<div class="panel-body">
															<div class="table-responsive" >
																<table class="table table-bordered table-hover text-center"  style="table-layout: fixed;" name="tblItemDelivery" id="tblItemDelivery">
																	<thead>
																		<tr class="bg-primary">
																			<th width="7.5%">No.</th>
																			<th width="85%">Item</th>
																			<th width="7.5%">Quantity</th>
																		</tr>
																	</thead>
																	<tbody id="tbodyUserDeliveryItem">
																	<?php foreach($DeliveryRequestLines as $row => $DeliveryRequestLines_item){ ?>
																		<tr  >
																			<td>
																				<?php 	if($DeliveryRequestLines_item['CHECK_COMPONENT']!="0"){
																							if($DeliveryRequest_item['STATUS']==="REQUEST NEW"){
																				?>
																				<button name="btnDeliveryRequestApproval" id="btnLRequestApprovalLine" class="btn btn-danger btn-rect form-control" value="<?=$DeliveryRequestLines_item['LINE_ID']?>"><?= $row+1 ?></button>
																				<?php 		}else{
																								$encrypted_string = $this->encrypt->encode($DeliveryRequestLines_item['LINE_ID']);
																								$encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
																				?>
																				<a href="<?php echo site_url('InventoryManagement/DeliveryRequest/DeliveryRequestComponent/'.$id.'/'.$encrypted_string) ?>" class="btn btn-danger btn-rect form-control"><?= $row+1 ?></a>
																				<?php
																							}
																						}else{
																				?>
																				<input type="text" value="<?=$row+1?>" name="txtNumber[]" id="txtNumber" class="form-control text-center" readonly/>
																				<?php
																				} ?>
																				<input type="hidden" value="<?=$DeliveryRequestLines_item['LINE_ID']?>" name="hdnLineId[]" id="hdnLineId" class="form-control text-center" />
																			</td>
																			<td>
																				<select class="form-control" name="slcDeliveryItem[]" id="slcDeliveryItem" required readonly>
																					<option value="<?= $DeliveryRequestLines_item['LINE_ITEM_ID']?>"><?= $DeliveryRequestLines_item['SEGMENT1']." - ".$DeliveryRequestLines_item['DESCRIPTION']?></option>
																				</select>
																			</td>
																			<td>
																				<input type="text" value="<?= $DeliveryRequestLines_item['QUANTITY']?>" name="txtQuantity[]" id="txtQuantity" class="form-control" required
																				<?php echo ($DeliveryRequestLines_item['CHECK_COMPONENT']!="0")?"readonly":""?>/>
																			</td>
																		</tr>
																		
																	<?php } ?>
																		<!--<tr  class="clone">
																			<td>
																				<input type="text" value="<?=$num+1 ?>" name="txtNumber[]" id="txtNumber" class="form-control text-center" readonly/>
																				<input type="hidden" value="" name="hdnLineId[]" id="hdnLineId" class="form-control text-center" />
																			</td>
																			<td>
																				<select class="form-control jsDeliveryItem" name="slcDeliveryItem[]" id="slcDeliveryItem" >
																					<option value=""></option>
																				</select>
																			</td>
																			<td>
																				<input type="text" name="txtQuantity[]" id="txtQuantity" class="form-control" />
																			</td>
																		</tr>
																		-->
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
										<a href="<?php echo base_url('InventoryManagement/DeliveryRequest/') ?>" class="btn btn-primary btn-lg btn-rect">Back</a>
										&nbsp;&nbsp;
										<?php 
											if(count($Approver)>0){
										?>	<button name="btnDeliveryRequestApproval" id="btnDeliveryRequestApprovalA" value="REQUEST APPROVED" class="btn btn-warning btn-lg btn-rect" >Approve</button>
										<?php
											}
										?>
											<button name="btnDeliveryRequestApproval" id="btnDeliveryRequestApprovalWA" value="REQUEST WAITING APPROVAL" class="btn btn-warning btn-lg btn-rect" >Ask For Approval</button>
										
										<button name="btnDeliveryRequestApproval" id="btnDeliveryRequestApproval" value="REQUEST NEW" class="btn btn-primary btn-lg btn-rect">Save Data</button>
										
									</div>
								</div>
								<?php } ?>
							</div>
						</div>
					</div>
				</div>
			</div>
			</form>
		</div>
	</div>
</section>