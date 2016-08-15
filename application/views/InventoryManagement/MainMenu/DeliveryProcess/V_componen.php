<section class="content">
	<div class="inner" >
		<div class="row">
			<form method="post" action="<?php echo site_url('InventoryManagement/DeliveryProcess/DeliveryProcessComponent/'.$delivery_id.'/'.$line_id)?>" class="form-horizontal">
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
								<?php foreach($ComponenHeader as $ComponenHeader_item){ ?>
								<div class="panel-body">
									<div class="row">
										<div class="form-group">
												<label for="norm" class="control-label col-lg-4">Delivery Request Num</label>
												<div class="col-lg-4">
													<input type="text" value="<?= $ComponenHeader_item['DELIVERY_NUMBER']?>" name="txtDeliveryRequestNum" id="txtDeliveryRequestNum" class="form-control" readonly required/>
												</div>
										</div>
										<div class="form-group">
												<label for="norm" class="control-label col-lg-4">Item</label>
												<div class="col-lg-6">
													<input type="text" value="<?= $ComponenHeader_item['SEGMENT1']." - ".$ComponenHeader_item['DESCRIPTION']?>" name="txtItem" id="txtItem" class="form-control"readonly required/> 
													
												</div>
										</div>
									</div>
									
									<div class="row">
										<div class="table-responsive"  style="overflow:hidden;">
											<div class="row">
												<div class="col-lg-12" >

													<div class="panel panel-default">
														
														<div class="panel-body">
															<div class="table-responsive" >
																<table class="table table-bordered table-hover text-center"  style="table-layout: fixed;" name="tblComponentDeliveryProcess" id="tblComponentDeliveryProcess">
																	<thead>
																		<tr class="bg-primary">
																			<th width="6%">No.</th>
																			<th width="30%">Component</th>
																			<th width="30%">Optional</th>
																			<th width="8%">Qty</th>
																			<th width="8%">Qty Processed</th>
																			<th width="8%">Qty to Prosess</th>
																			<th width="8%">Check</th>
																		</tr>
																	</thead>
																	<tbody id="tbodyUserDeliveryItem">
																	<?php	$part_seq = ""; 
																		foreach($Component as $row => $Component_item){ 
																	?>
																		<tr>
																			<?php if($part_seq != $Component_item['PART_SEQUENCE']){
																			?>
																			<td rowspan=<?=$Component_item['JUMLAH']?>>
																				
																				<input type="text" value="<?=$Component_item['PART_SEQUENCE']?>" name="txtPartSequence[]" id="txtPartSequence" class="form-control text-center" readonly/>
																			</td>
																			<td rowspan=<?=$Component_item['JUMLAH']?>>
																				<input type="text" value="<?= $Component_item['KODE_COMPONENT']." - ".$Component_item['DESCRIPTION_COMPONENT']?>" name="txtComponent[]" id="txtComponent" class="form-control" readonly required/> 
																			</td>
																			<?php } ?>
																			<td>
																				<input type="hidden" value="<?=$Component_item['PART_ID']?>" name="hdnPartId[]" id="hdnPartId" class="form-control text-center" readonly/>
																				<input type="text" value="<?= $Component_item['KODE_OPTION']." - ".$Component_item['DESCRIPTION_OPTION']?>" name="txtOption[]" id="txtOption" class="form-control" readonly required/> 
																			</td>
																			<td>
																				<input type="text" value="<?= $Component_item['PICKED_QUANTITY'] ?>" name="txtPickedQuantity[]" id="txtPickedQuantity" class="form-control" readonly required/> 
																			</td>
																			<td>
																				<input type="text" value="<?php echo (isset($Component_item['PART_PROCESSED_QUANTITY']))?$Component_item['PART_PROCESSED_QUANTITY']:"0" ?>" name="txtProcessedQuantity[]" id="txtProcessedQuantity" class="form-control" readonly/> 
																			</td>
																			<td>
																				<input type="number" min="0" name="txtQtyToProcess[]" id="txtQtyToProcess" onkepress="qtyProcessCheck(<?=$row?>)" class="form-control" 
																				<?php echo (intval($Component_item['PART_PROCESSED_QUANTITY'])>=intval($Component_item['PICKED_QUANTITY']))?"readonly":""?>/> 
																			</td>
																			<td>
																				<a href="#" data-toggle="modal" data-target="#history<?php echo $row;?>">
																					<img src="<?php echo base_url('assets/img/history5.png');?>" width="30px">
																				</a>
																			</td>
																		</tr>
																		
																	<?php 
																		$part_seq = $Component_item['PART_SEQUENCE'];
																		} 
																	?>
																	</tbody>
																</table>
																<?php
																	foreach ($Component as $row => $Component_item){
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
																										<div class="col-lg-2">:&nbsp;&nbsp;<?php echo (isset($Component_item['KODE_OPTION']))?$Component_item['KODE_OPTION']:$Component_item['KODE_COMPONENT'] ?></div>
																										<div class="col-lg-6">&nbsp;<?php echo (isset($Component_item['DESCRIPTION_OPTION']))?$Component_item['DESCRIPTION_OPTION']:$Component_item['DESCRIPTION_COMPONENT'] ?></div>
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
																								foreach($ComponentProcessed as $p => $ComponentProcessed_item){
																					
																									if($ComponentProcessed_item['PART_ID'] == $Component_item['PART_ID'])
																									{
																								?>
																									<tr>
																										<td align="left"><?php echo $ComponentProcessed_item['MOVE_ORDER_NUMBER'] ?></td>
																										<td align="left"><?php echo $ComponentProcessed_item['QUANTITY_PROCESSED'] ?></td>
																										<td align="left"><?php echo $ComponentProcessed_item['PROCESS_DATE2'] ?></td>
																										<td><?php echo $ComponentProcessed_item['WORKER'] ?></td>
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
										<a href="<?php echo base_url('InventoryManagement/DeliveryProcess/UpdateDeliveryProcess/')."/".$delivery_id ?>" class="btn btn-primary btn-lg btn-rect">Back</a>
										&nbsp;&nbsp;
										<button name="btnProcessComponen" id="btnProcessComponen" class="btn btn-info btn-lg btn-rect">Process Component</button>
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