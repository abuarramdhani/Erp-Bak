<section class="content">
	<div class="inner" >
		<div class="row">
			<form method="post" id="frmDeliveryProcess" action="<?php echo site_url('InventoryManagement/DeliveryProcess/UpdateDeliveryProcess/'.$id)?>" class="form-horizontal" >
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
									<a class="btn btn-default btn-lg" href="<?php echo site_url('InventoryManagement/DeliveryProcess/');?>">
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
													<select name="slcRequestType" id="slcRequestType" class="form-control" disabled>
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
									</div>
									<div class="row">
										<div class="col-lg-6">
											<div class="form-group">
												<label class="control-label col-lg-4">Order Date</label>
												<div class="col-lg-8">
													<input type="text" value="<?= date_format(date_create($DeliveryRequest_item['ORDER_DATE']),'d-M-Y')?>" placeholder="<?= date("d-M-Y")?>" name="txtOrderDate" id="txtOrderDate" class="form-control datepicker" data-date-format="dd-M-yyyy" disabled/>
												</div>
											</div>
										</div>
										<div class="col-lg-6">
											<div class="form-group">
												<label class="control-label col-lg-4">Ship Request Date</label>
												<div class="col-lg-8">
													<input type="text" value="<?= date_format(date_create($DeliveryRequest_item['SHIP_REQUEST_DATE']),'d-M-Y')?>" placeholder="<?= date("d-M-Y")?>" name="txtShipRequestDate" id="txtShipRequestDate" class="form-control datepicker" data-date-format="dd-M-yyyy" disabled/>
												</div>
											</div>
										</div>
									</div><!--
									<div class="row">
										<div class="col-lg-6">
											<div class="form-group">
												<label class="control-label col-lg-4">IO</label>
												<div class="col-lg-8">
													<select name="slcIo" id="slcIo" class="form-control jsInvOrg" disabled>
														<option value="<?= $DeliveryRequest_item['ORGANIZATION_ID']?>" selected><?= $DeliveryRequest_item['ORGANIZATION_CODE']?></option>
													</select>
												</div>
											</div>
										</div>
										<div class="col-lg-6">
											<div class="form-group">
												<label class="control-label col-lg-4">SubInventory</label>
												<div class="col-lg-8">
													<select name="slcSubInventory" id="slcSubInventory" class="form-control jsSubInvOrg" <?php echo ($DeliveryRequest_item['ORGANIZATION_ID']=="")?"disabled":""; ?> disabled>
														<option value="<?= $DeliveryRequest_item['SUBINVENTORY']?>" selected><?= $DeliveryRequest_item['SUBINVENTORY']?></option>
													</select>
												</div>
											</div>
										</div>
									</div>-->
									<div class="row">
										<div class="col-lg-6">
											<div class="form-group">
												<label class="control-label col-lg-4">Contract Number</label>
												<div class="col-lg-8">
													<input type="text" value="<?= $DeliveryRequest_item['CONTRACT_NUMBER']?>" placeholder="M150BISAAA" name="txtContractNumber" id="txtContractNumber" class="form-control" disabled/>
												</div>
											</div>
										</div>
										<div class="col-lg-6">
											<div class="form-group">
												<label class="control-label col-lg-4">Emblem</label>
												<div class="col-lg-8">
													<input type="text" value="<?= $DeliveryRequest_item['EMBLEM']?>" placeholder="M150BISAAA" name="txtEmblem" id="txtEmblem" class="form-control" disabled/>
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-6">
											<div class="form-group">
												<label class="control-label col-lg-4">Allocation</label>
												<div class="col-lg-8">
													<textarea placeholder="Allocation" name="txtAllocation" id="txtAllocation" class="form-control" disabled><?= $DeliveryRequest_item['ALLOCATION']?></textarea>
												</div>
											</div>
										</div>
										<div class="col-lg-6">
											<div class="form-group">
												<label class="control-label col-lg-4">Destination</label>
												<div class="col-lg-8">
													<textarea placeholder="Destination" name="txtDestination" id="txtDestination" class="form-control" disabled><?= $DeliveryRequest_item['DESTINATION']?></textarea>
												</div>
												
											</div>
										</div>
										
									</div>
									<div class="row">
										<div class="col-lg-6">
											<div class="form-group">
												<label class="control-label col-lg-4">Requestor</label>
												<div class="col-lg-8">
													<select name="slcRequestor" id="slcRequestor" class="form-control jsOracleEmployee" disabled>
															<option value="<?= $DeliveryRequest_item['REQUESTOR']?>"><?= $DeliveryRequest_item['NATIONAL_IDENTIFIER']." (".$DeliveryRequest_item['FULL_NAME'].")"?></option>
														</select>
												</div>
											</div>
										</div>
										<div class="col-lg-6">
											<div class="form-group">
												<label class="control-label col-lg-4">Notes</label>
												<div class="col-lg-8">
													<textarea placeholder="Notes" name="txtNotes" id="txtNotes" class="form-control" disabled><?= $DeliveryRequest_item['NOTES']?></textarea>
												</div>
												
											</div>
										</div>
									</div>
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
									</div>
									<div class="row">
										<div class="col-lg-6">
											<div class="form-group">
												<label class="control-label col-lg-4">From SubInventory</label>
												<div class="col-lg-8">
													<select name="slcSubInventory" id="slcSubInventory" class="form-control jsSubInvOrg" <?php echo ($DeliveryRequest_item['ORGANIZATION_ID']=="")?"disabled":""; ?> required>
														<option value="<?= $DeliveryRequest_item['SUBINVENTORY']?>" selected><?= $DeliveryRequest_item['SUBINVENTORY']?></option>
													</select>
												</div>
											</div>
										</div>
										<div class="col-lg-6">
											<div class="form-group">
												<label class="control-label col-lg-4">To SubInventory</label>
												<div class="col-lg-8">
													<select name="slcToSubInventory" id="slcToSubInventory" class="form-control jsSubInvOrg" <?php echo ($DeliveryRequest_item['ORGANIZATION_ID']=="")?"disabled":""; ?> required>
														<option value="<?= $DeliveryRequest_item['TO_SUBINVENTORY']?>" selected><?= $DeliveryRequest_item['TO_SUBINVENTORY']?></option>
													</select>
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-6">
											<div class="form-group">
												<label class="control-label col-lg-4">IO Interorg</label>
												<div class="col-lg-8">
													<select name="slcIoInterOrg" id="slcIoInterOrg" class="form-control jsInvOrg" disabled>
														<option value="<?= $DeliveryRequest_item['INTERORG_ORGANIZATION_ID']?>"><?= $DeliveryRequest_item['INTERORG_ORGANIZATION_CODE']?></option>
													</select>
												</div>
											</div>
										</div>
										<div class="col-lg-6">
											<div class="form-group">
												<label class="control-label col-lg-4">SubInventory Interorg</label>
												<div class="col-lg-8">
													<select name="slcSubInventoryInterOrg" id="slcSubInventoryInterOrg" class="form-control jsSubInvOrg" disabled >
														<option value="<?= $DeliveryRequest_item['INTERORG_SUBINVENTORY']?>"><?= $DeliveryRequest_item['INTERORG_SUBINVENTORY']?></option>
													</select>
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-6">
											<div class="form-group">
												<label class="control-label col-lg-4">Blanket Number</label>
												<div class="col-lg-8">
													<input type="text" value="<?= $DeliveryRequest_item['BLANKET']?>" placeholder="M150BISAAA" name="txtBlanket" id="txtBlanket" class="form-control" />
												</div>
											</div>
										</div>
										<div class="col-lg-6">
											<div class="form-group">
												<label class="control-label col-lg-4">Expedition</label>
												<div class="col-lg-8">
													<input type="text" value="<?= $DeliveryRequest_item['EXPEDITION']?>" placeholder="KHS Ekspress" name="txtExpedition" id="txtExpedition" class="form-control" />
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-6">
											<div class="form-group">
												<label class="control-label col-lg-4">Engine Location</label>
												<div class="col-lg-8">
													
													<select name="slcEngine" id="slcEngine" class="form-control jsTes" >
														<option value="" ></option>
														<option value="HONDA" <?php echo ($DeliveryRequest_item['ENGINE']=="HONDA")?"selected":""; ?>>HONDA</option>
														<option value="KI" <?php echo ($DeliveryRequest_item['ENGINE']=="KI")?"selected":""; ?>>KI</option>
														<option value="KHS PUSAT" <?php echo ($DeliveryRequest_item['ENGINE']=="KHS PUSAT")?"selected":""; ?>>KHS PUSAT</option>
													</select>
												</div>
											</div>
										</div>
										<div class="col-lg-6">
											<div class="form-group">
												<label class="control-label col-lg-4">Tractor Location</label>
												<div class="col-lg-8">
													
													<select name="slcTractor" id="slcTractor" class="form-control jsTes" >
														<option value="" selected></option>
														<option value="MELATI" <?php echo ($DeliveryRequest_item['TRACTOR']=="MELATI")?"selected":""; ?>>MELATI</option>
														<option value="TUKSONO" <?php echo ($DeliveryRequest_item['TRACTOR']=="TUKSONO")?"selected":""; ?>>TUKSONO</option>
													</select>
												</div>
											</div>
										</div>
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
																<table class="table table-bordered table-hover text-center"  style="table-layout: fixed;" name="tblDeliveryRequestLinesDeliveryProcess" id="tblDeliveryRequestLinesDeliveryProcess">
																	<thead>
																		<tr class="bg-primary">
																			<th width="7.5%">No.</th>
																			<th width="38%">Item</th>
																			<th width="7.5%"><input type="text" value="External" size="4" name="txtBtnExIn" id="txtBtnExIn" class="btn btn-default btn-rect btn-xs" readonly/><br />Type</th>
																			<th width="7.5%">Qty</th>
																			<th width="7.5%">Qty Processed</th>
																			<th width="7.5%">Qty to Process</th>
																			<th width="7%">Check</th>
																		</tr>
																	</thead>
																	<tbody id="tbodyUserDeliveryItem">
																	<?php foreach($DeliveryRequestLines as $row => $DeliveryRequestLines_item){ ?>
																		<tr  >
																			<td>
																				<?php if($DeliveryRequestLines_item['CHECK_COMPONENT']!="0"){
																				?>
																				<button name="btnDeliveryRequest" ID="btnDeliveryRequestComponent" class="btn btn-info btn-rect form-control" value="<?=$DeliveryRequestLines_item['LINE_ID']?>"><?= $row+1 ?></button>
																				<?php }else{
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
																				<?php if($DeliveryRequestLines_item['CHECK_COMPONENT']=="0"){ ?>
																				<select class="form-control" name="slcLineType[]" id="slcLineType" >
																					<option value="Internal">Internal</option>
																					<?php if($DeliveryRequestLines_item['PURCHASING_FLAG']==="Y"){ ?>
																					<option value="External" <?php echo ($DeliveryRequestLines_item['LINE_TYPE']==="External")?"selected":""?>>External</option>
																					<?php } ?>
																				</select>
																				<?php }else{
																				?>
																				<input type="hidden" value="" name="slcLineType[]" id="slcLineType" class="form-control" />
																				<?php
																				} ?>
																			</td>
																			<td>
																				<input type="text" value="<?= $DeliveryRequestLines_item['QUANTITY']?>" name="txtPickedQuantity[]" id="txtPickedQuantity" class="form-control" readonly/>
																				
																			</td>
																			<td>
																				<?php if($DeliveryRequestLines_item['CHECK_COMPONENT']=="0"){ ?>
																				<input type="number" value="<?= $DeliveryRequestLines_item['PROCESSED_QUANTITY']?>" name="txtProcessedQuantity[]" id="txtProcessedQuantity" class="form-control" readonly/>
																				<?php } ?>
																			</td>
																			<td>
																				<?php if($DeliveryRequestLines_item['CHECK_COMPONENT']=="0"){ ?>
																				<input type="number" min="0" name="txtQtyToProcess[]" id="txtQtyToProcess" class="form-control" <?php echo ($DeliveryRequestLines_item['CHECK_COMPONENT']!="0")?"readonly":""?>
																				<?php echo (intval($DeliveryRequestLines_item['PROCESSED_QUANTITY'])>=intval($DeliveryRequestLines_item['QUANTITY']))?"readonly":""?>/>
																				<?php } ?>
																			</td>
																			<td>
																				<?php if($DeliveryRequestLines_item['CHECK_COMPONENT']=="0"){
																				?>
																				<a href="#" data-toggle="modal" data-target="#history<?php echo $row;?>">
																					<img src="<?php echo base_url('assets/img/history5.png');?>" width="30px">
																				</a>
																				<?php } ?>
																			</td>
																		</tr>
																		
																	<?php } ?>
																	</tbody>
																</table>
																<?php
																	foreach ($DeliveryRequestLines as $row => $DeliveryRequestLines_item){
																	?>
																	<div class="modal" id="history<?php echo $row;?>" tabindex="-1"    role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
																				<div class="modal-dialog" style="min-width:1200px;">
																					<div class="modal-content">
																						<div class="modal-header">
																							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
																							<h4 class="modal-title" id="myModalLabel">Item Processed</h4>
																						</div>
																						
																						<div class="modal-body" >
																							<form class="form-horizontal">
																							<div class="row">
																								<div class="col-lg-10">
																									<div class="row">
																										<div class="col-lg-2"><label>Product</label></div>
																										<div class="col-lg-2">:&nbsp;&nbsp;<?php echo $DeliveryRequestLines_item['SEGMENT1'] ?></div>
																										<div class="col-lg-6">&nbsp;<?php echo $DeliveryRequestLines_item['DESCRIPTION'] ?></div>
																									</div>
																								</div>
																							</div>
																							</form>
																							<br />
																							<table class="table table-striped table-bordered table-hover text-center"   style="font-size:12px;" name="tblServiceLines" id="dataTables-customer">
																							<thead>
																								<tr>
																									<th width="20%">Move Order Number</th>
																									<th width="10%">Processed Quantity</th>
																									<th width="20%">Date Processed</th>
																									<th width="15%">Employee</th>
																								</tr>
																							</thead>
																							<tbody>
																								<?php
																								foreach($ItemProcessed as $p => $ItemProcessed_item){
																					
																									if($ItemProcessed_item['LINE_ID'] == $DeliveryRequestLines_item['LINE_ID'])
																									{
																								?>
																									<tr>
																										<td align="left"><?php echo $ItemProcessed_item['MOVE_ORDER_NUMBER'] ?></td>
																										<td align="left"><?php echo $ItemProcessed_item['QUANTITY_PROCESSED'] ?></td>
																										<td align="left"><?php echo $ItemProcessed_item['PROCESS_DATE2'] ?></td>
																										<td><?php echo $ItemProcessed_item['WORKER'] ?></td>
																									</tr>
																								<?php
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
																	}
																	?>
															</div>
														</div>
													
													</div>
												</div>
											</div>
										</div>
												
									</div>
								</div>
								<?php } ?>
								<div class="panel-footer">
									<div class="row text-right">
										<a href="<?php echo base_url('InventoryManagement/DeliveryProcess/') ?>" class="btn btn-primary btn-lg btn-rect">Back</a>
										&nbsp;&nbsp;
										<button name="btnDeliveryRequest" id="btnRequestClose" class="btn btn-danger btn-lg btn-rect" value="Close">Close</button>
										<button name="btnDeliveryRequest" id="btnRequestProcess" class="btn btn-warning btn-lg btn-rect" value="Process">Process</button>
										<button name="btnDeliveryRequest" id="btnRequestSave" class="btn btn-info btn-lg btn-rect" value="Save">Save Header</button>
										
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