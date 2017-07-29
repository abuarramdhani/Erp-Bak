<section class="content">
	<div class="inner" >
		<div class="row">
			<form method="post" id="frmDeliveryRequest" action="<?php echo site_url('InventoryManagement/DeliveryRequest/CreateDeliveryRequest')?>" class="form-horizontal">
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
							<div class="panel-body">
								<div class="row">
									<div class="col-lg-6">
										<div class="form-group">
											<label class="control-label col-lg-4">Type</label>
											<div class="col-lg-8">
												<select name="slcRequestType" id="slcRequestType" class="form-control select4" required>
													<option value=""></option>
													<option value="UNIT">UNIT</option>
													<option value="SPARE PART">SPARE PART</option>
												</select>
											</div>
										</div>
									</div>
									
									<div class="col-lg-6">
										<div class="form-group">
											<label class="control-label col-lg-4">Delivery Request Num</label>
											<div class="col-lg-8">
												<input type="text" placeholder="M150BISAAA" name="txtDeliveryRequestNum" id="txtDeliveryRequestNum" class="form-control" required readonly/>
											</div>
											
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-6">
										<div class="form-group">
											<label class="control-label col-lg-4">Status</label>
											<div class="col-lg-8">
												<input type="text" value="REQUEST NEW" name="txtDeliveryStatus" id="txtDeliveryStatus" class="form-control" readonly/>
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
												<input type="text" placeholder="<?= date("d-M-Y")?>" name="txtOrderDate" id="txtOrderDate" class="form-control datepicker" data-date-format="dd-M-yyyy" required/>
											</div>
										</div>
									</div>
									<div class="col-lg-6">
										<div class="form-group">
											<label class="control-label col-lg-4">Ship Request Date</label>
											<div class="col-lg-8">
												<input type="text" placeholder="<?= date("d-M-Y")?>" name="txtShipRequestDate" id="txtShipRequestDate" class="form-control datepicker" data-date-format="dd-M-yyyy" required/>
											</div>
										</div>
									</div>
								</div>
								<?php if(intval($this->session->org_id) === 82){
								?>
								<div class="row">
									<div class="col-lg-6">
										<div class="form-group">
											<label class="control-label col-lg-4">IO Interorg</label>
											<div class="col-lg-8">
												<select name="slcIoInterOrg" id="slcIoInterOrg" class="form-control jsInvOrg" required>
													<option value=""></option>
												</select>
											</div>
										</div>
									</div>
									<div class="col-lg-6">
										<div class="form-group">
											<label class="control-label col-lg-4">SubInventory Interorg</label>
											<div class="col-lg-8">
												<select name="slcSubInventoryInterOrg" id="slcSubInventoryInterOrg" class="form-control jsSubInvOrg" required >
													<option value=""></option>
												</select>
											</div>
										</div>
									</div>
								</div>
								<?php }
								?>
								<!--
								<div class="row">
									<div class="col-lg-6">
										<div class="form-group">
											<label class="control-label col-lg-4">IO to</label>
											<div class="col-lg-8">
												<select name="slcIoTo" id="slcIoTo" class="form-control jsInvOrg" required>
													<option value=""></option>
												</select>
											</div>
										</div>
									</div>
									<div class="col-lg-6">
										<div class="form-group">
											<label class="control-label col-lg-4">SubInventory to</label>
											<div class="col-lg-8">
												<select name="slcSubInventoryTo" id="slcSubInventoryTo" class="form-control jsSubInvOrg" disabled required>
													<option value=""></option>
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
												<input type="text" placeholder="M150BISAAA" name="txtContractNumber" id="txtContractNumber" class="form-control" />
											</div>
										</div>
									</div>
									<div class="col-lg-6">
										<div class="form-group">
											<label class="control-label col-lg-4">Emblem</label>
											<div class="col-lg-8">
												<input type="text" placeholder="M150BISAAA" name="txtEmblem" id="txtEmblem" class="form-control" />
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-6">
										<div class="form-group">
											<label class="control-label col-lg-4">Allocation</label>
											<div class="col-lg-8">
												<textarea placeholder="Allocation" name="txtAllocation" id="txtAllocation" class="form-control"></textarea>
											</div>
										</div>
									</div>
									
									<div class="col-lg-6">
										<div class="form-group">
											<label class="control-label col-lg-4">Notes</label>
											<div class="col-lg-8">
												<textarea placeholder="Notes" name="txtNotes" id="txtNotes" class="form-control" ></textarea>
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
													<option value=""></option>
												</select>
											</div>
										</div>
									</div>
									<div class="col-lg-6">
										<div class="form-group">
											<label class="control-label col-lg-4">Blanket Number</label>
											<div class="col-lg-8">
												<input type="text" placeholder="M150BISAAA" name="txtBlanket" id="txtBlanket" class="form-control" />
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
												<input type="text" placeholder="KHS Ekspress" name="txtExpedition" id="txtExpedition" class="form-control" />
											</div>
										</div>
									</div>
								<?php } ?>
									<div class="col-lg-6">
										<div class="form-group">
											<div class="col-lg-8">
												<textarea placeholder="Destination" name="txtDestination" id="txtDestination" style="display:none;" class="form-control" required><?=$address ?>
												<?=$telp ?>
												</textarea>
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
														<a href="javascript:void(0);" id="addItemDelivery" title="Tambah Baris" onclick="addRowItemDelivery('<?php echo base_url(); ?>')"><img src="<?php echo base_url('assets/img/row_add2.png');?>" title="Add Row" alt="Add Row" ></a>
														&nbsp;&nbsp;&nbsp;
														<a href="javascript:void(0);" id="delItemDelivery" title="Hapus Baris" onclick="deleteRow('tblItemDelivery')"><img src="<?php echo base_url('assets/img/row_delete.png');?>" style="pointer-events:none;cursor: default" title="Delete Row" alt="Delete Row" ></a>
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
																	<tr  class="clone">
																		<td>
																			<input type="text" value="1" name="txtNumber[]" id="txtNumber" class="form-control text-center" readonly/>
																		</td>
																		<td>
																			<select class="form-control jsDeliveryItem" name="slcDeliveryItem[]" id="slcDeliveryItem" required>
																				<option value=""></option>
																			</select>
																		</td>
																		<td>
																			<input type="text" name="txtQuantity[]" id="txtQuantity" class="form-control" required/>
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
									<a href="javascript:history.back(1)" class="btn btn-primary btn-lg btn-rect">Back</a>
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