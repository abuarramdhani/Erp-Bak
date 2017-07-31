<section class="content">
	<div class="inner" >
		<div class="row">
			<form  id="frmDeliveryRequestComponent" method="post" action="<?php echo site_url('InventoryManagement/DeliveryRequest/DeliveryRequestComponent/'.$delivery_id.'/'.$line_id)?>" class="form-horizontal">
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
													<input type="hidden" value="<?= $ComponenHeader_item['STATUS']?>" name="txtDeliveryStatus" id="txtDeliveryStatus" class="form-control" /> 
													
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
																<table class="table table-bordered table-hover text-center"  style="table-layout: fixed;" name="tblItemDelivery" id="tblItemDelivery">
																	<thead>
																		<tr class="bg-primary">
																			<th width="7.5%">No.</th>
																			<th width="42.5%">Component</th>
																			<th width="42.5%">Optional</th>
																			<th width="7.5%">Pick</th>
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
																				<?php
																					if($Component_item['KODE_OPTION']==""){
																						$check = 'onclick="return false" checked';
																					}elseif($Component_item['PICKED']=="Y"){
																						$check = "checked";																					
																					}else{
																						$check = "";																					
																					}
																				?>
																				<input type="text" value="<?= $Component_item['PICKED_QUANTITY']?>" name="txtPickedQuantity[]" id="txtPickedQuantity" class="form-control" /> 
																			</td>
																		</tr>
																		
																	<?php 
																		$part_seq = $Component_item['PART_SEQUENCE'];
																		} 
																	?>
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
								<?php } ?>
								<div class="panel-footer">
									<div class="row text-right">
										<a href="<?php echo base_url('InventoryManagement/DeliveryRequest/UpdateDeliveryRequest/')."/".$delivery_id ?>" class="btn btn-primary btn-lg btn-rect">Back</a>
										&nbsp;&nbsp;
										<button id="btnComponent" class="btn btn-primary btn-lg btn-rect">Confrim Component</button>
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