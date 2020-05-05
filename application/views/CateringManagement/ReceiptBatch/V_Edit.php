<script src="<?php echo base_url('assets/js/ajaxSearch.js');?>"></script>

<section class="content">
	<div class="inner" >
	<div class="row">
		<div class="col-lg-12">
			<div class="row" >
				<div class="col-lg-12">
					<div class="col-lg-11">
						<div class="text-right">
						<h1><b>Catering Receipt</b></h1>
						</div>
					</div>
					<div class="col-lg-1">
						<div class="text-right hidden-md hidden-sm hidden-xs">
                            <a class="btn btn-default btn-lg" href="<?php echo site_url('CateringManagement/ReceiptBatch');?>">
                                <i class="icon-wrench icon-2x"></i>
                                <span><br/></span>	
                            </a>
						</div>
					</div>
				</div>
			</div>
			<br/>
			
			<div class="row">
				<div class="col-lg-12">
				<div class="box box-primary box-solid">
					<div class="box-header with-border">
						<b>Catering Receipt</b>
					</div>
					
					<div class="box-body">
					<form method="post" action="<?php echo base_url('CateringManagement/ReceiptBatch/Update')?>">
					<?php foreach ($Receipt as $rc) {?>
						<input type="hidden" name="TxtID" class="form-control" value="<?php echo $rc['receipt_id']?>" required>
						<!-- INPUT GROUP 1 ROW 1 -->
						<div class="row" style="margin: 10px 10px">
							<div class="form-group">
								<label class="col-lg-2 control-label">No.</label>
								<div class="col-lg-6">
									<input name="TxtNo" class="form-control toupper" placeholder="No." value="<?php echo $rc['receipt_no']?>" required>
								</div>
							</div>
						</div>
						<!-- INPUT GROUP 1 ROW 2 -->
						<div class="row" style="margin: 10px 10px">
							<div class="form-group">
								<label class="col-lg-2 control-label">Receipt Date</label>
								<div class="col-lg-3">
									<input type="text" name="TxtReceiptDate" class="date form-control cmsingledate" placeholder="Receipt Date" data-date-format="dd-mm-yyyy" value="<?php echo date('d-m-Y', strtotime($rc['receipt_date']));?>" required >
									<input type="hidden" id="receipt-dateBatch" value="<?php echo date('d-m-Y', strtotime($rc['receipt_date']));?>" />
								</div>
								<label class="col-lg-1 control-label" align="right">Place</label>
								<div class="col-lg-2">
									<input name="TxtPlace" class="form-control toupper" placeholder="Place" value="<?php echo $rc['receipt_place']?>" required >
								</div>
							</div>
						</div>
						<!-- INPUT GROUP 1 ROW 3 -->
						<div class="row" style="margin: 10px 10px">
							<div class="form-group">
								<label class="col-lg-2 control-label">From</label>
								<div class="col-lg-3">
									<input name="TxtFrom" class="form-control toupper" placeholder="Company Name" value="<?php echo $rc['receipt_from']?>" required >
								</div>
								<label class="col-lg-1 control-label" align="right">Signer</label>
								<div class="col-lg-2">
									<input name="TxtSigner" class="form-control toupper" placeholder="Signer" value="<?php echo $rc['receipt_signer']?>" required >
								</div>
							</div>
						</div>
						<hr>
											
						<!-- INPUT GROUP 2 ROW 1 -->
						<div class="row" style="margin: 10px 10px">
							<div class="form-group">
								<label class="col-lg-2 control-label">Order Type</label>
								<div class="col-lg-6">
									<select class="form-control select4" id="ordertypeBatch" name="TxtOrderType" placeholder="Select Order Type" required>
											<option></option>
										<?php
											foreach ($Type as $tp) {
											$status1='';
											if ($tp['type_id'] == $rc['order_type_id']){$status1='selected';}
										?>
										<option <?php echo $status1 ?> value="<?php echo $tp['type_id']?>"><?php echo $tp['type_description']?></option>
										<?php }?>
									</select>
								</div>
							</div>
						</div>
						<!-- INPUT GROUP 2 ROW 1.2 -->
						<div class="row" style="margin: 10px 10px">
							<div class="form-group">
								<label class="col-lg-2 control-label">Catering</label>
								<div class="col-lg-6">
									<select class="form-control select4" id="cateringBatch" name="TxtCatering" data-placeholder="Select Catering" required>
											<option></option>
										<?php 
											foreach ($Catering as $cr) {
											$status2='';
											if ($cr['catering_id'] == $rc['catering_id']){$status2='selected';}
										?>
											<option <?php echo $status2 ?> value="<?php echo $cr['catering_id']?>"><?php echo $cr['catering_name']?></option>
										<?php }?>
									</select>
								</div>
							</div>
						</div>
						<!-- INPUT GROUP 2 ROW 1.2 -->
						<div class="row" style="margin: 10px 10px">
							<div class="form-group">
								<label class="col-lg-2 control-label">Menu</label>
								<div class="col-lg-6">
									<input name="TxtMenu" class="form-control toupper" placeholder="Snack or Food" value="<?php echo $rc['order_description']?>">
								</div>
							</div>
						</div>
						<!-- INPUT GROUP 2 ROW 2 -->
						<div class="row" style="margin: 10px 10px">
							<div class="form-group">
								<label class="col-lg-2 control-label">Order Date</label>
								<div class="col-lg-6">
									<input type="text" name="TxtOrderDate" class="form-control cmdaterange" placeholder="Order Date" value="<?php echo date('d-m-Y', strtotime($rc['order_start_date'])).' - '.date('d-m-Y', strtotime($rc['order_end_date']));?>" required >
								</div>
							</div>
						</div>
						
						<!-- INPUT GROUP 2 ROW 1.2 -->
						<div class="row" style="margin: 10px 10px">
							<div class="form-group">
								<label class="col-lg-2 control-label">Bonus</label>
								<div class="col-lg-6">
									<select class="form-control select4" id="bonusBatch" name="TxtBonus" required>
										<option value="1" <?php if($rc['bonus'] == 1){ echo "selected"; } ?> >Active</option>
										<option value="0" <?php if($rc['bonus'] == 0){ echo "selected"; } ?>>Inactive</option>
									</select>
								</div>
							</div>
						</div>
						<!-- INPUT GROUP 2 ROW 3 -->
						<div class="row" style="margin: 10px 10px">
							<div class="form-group">
								<label class="col-lg-2 control-label">Location</label>
								<div class="col-lg-6">
									<select class="select2" data-placeholder="Location" name="slcLocation" id="slcLocationBatch" style="width: 100%">
										<option></option>
										<option value="01" <?php echo $rc['kd_lokasi'] == '01' ? 'selected' : '' ?>>Yogyakarta & Mlati</option>
										<option value="02" <?php echo $rc['kd_lokasi'] == '02' ? 'selected' : '' ?>>Tuksono</option>
									</select>
								</div>
							</div>
						</div>
						<div class="row" style="margin: 10px 10px">
							<div class="form-group">
								<label class="col-lg-2 control-label">Price per Qty</label>
								<div class="col-lg-6">
									<input id="singlepriceBatch" name="TxtSinglePrice" class="form-control" value="<?php echo $rc['order_price']?>" onkeypress="return isNumberKey(event)" placeholder="Price per qty" required >
								</div>
							</div>
						</div>
						<div class="row" style="margin: 10px 10px">
							<div class="form-group">
								<label class="col-lg-2 control-label">Order Qty</label>
								<div class="col-lg-6">
									<table class="table table-bordered table-hover table-striped">
										<thead class="bg-primary">
											<tr>
												<th style="text-align: center;">Departement</th>
												<th style="text-align: center;">Qty</th>
											</tr>
										</thead>
										<tbody>
											<?php 
											$keuangan = "";
											$pemasaran = "";
											$produksi = "";
											$personalia = "";
											foreach ($ReceiptQty as $rq) {
												if ($rq['dept'] == 'KEUANGAN') {
													$keuangan = $rq['qty'];
												}
												if ($rq['dept'] == 'PEMASARAN') {
													$pemasaran = $rq['qty'];
												}
												if ($rq['dept'] == 'PRODUKSI') {
													$produksi = $rq['qty'];
												}
												if ($rq['dept'] == 'PERSONALIA') {
													$personalia = $rq['qty'];
												}
											}

											 ?>
											<tr>
												<td>Keuangan</td>
												<td class="text-center">
													<input type="text" name="txtDeptQty1" id="txtDeptQtyBatch1" class="form-control" value="<?php echo $keuangan ?>" required>
												</td>
											</tr>
											<tr>
												<td>Pemasaran</td>
												<td class="text-center">
													<input type="text" name="txtDeptQty2" id="txtDeptQtyBatch2" class="form-control" value="<?php echo $pemasaran ?>" required>
												</td>
											</tr>
											<tr>
												<td>Produksi</td>
												<td class="text-center">
													<input type="text" name="txtDeptQty3" id="txtDeptQtyBatch3" class="form-control" value="<?php echo $produksi ?>" required>
												</td>
											</tr>
											<tr>
												<td>Personalia</td>
												<td class="text-center">
													<input type="text" name="txtDeptQty4" id="txtDeptQtyBatch4" class="form-control" value="<?php echo $personalia ?>" required>
												</td>
											</tr>
											<tr>
												<td>Total Order Qty</td>
												<td class="text-center">
													<input id="orderqtyBatch" name="TxtOrderQty" class="form-control" onkeypress="return isNumberKey(event)" placeholder="Order Qty" readonly value="<?php echo $rc['order_qty']?>" required >
												</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
						<hr>
						
						<div class="row" style="margin 10px 10px">
							<div class="col-md-12">
								<div class="panel panel-default">
									<div class="panel-heading text-right">
										<a href="javascript:void(0);" class="btn btn-sm btn-primary" id="AddFineBatch" title="Tambah Baris" onclick="AddFine('<?php echo base_url(); ?>')"><i class="fa fa-plus"></i></a>
										<a href="javascript:void(0);" class="btn btn-sm btn-danger" id="DelFineBatch" title="Hapus Baris" onclick="deleteRow('tblFineCateringBatch')"><i class="fa fa-remove"></i></a>
										<a id="HiddenDelFineBatch" onclick="deleteRow('tblFineCateringBatch')" hidden >Hidden</a>
										<a id="ReCalculateBatch" hidden >Hidden</a>
									</div>
									<div class="panel-body">
										<div class="table-responsive" >
											<table class="table table-sm table-bordered table-hover text-center" style="table-layout: fixed;" name="tblFineCatering" id="tblFineCateringBatch">
												<thead>
													<tr class="bg-primary">
														<th width="15%">DATE</th>
														<th width="15%">QTY</th>
														<th width="15%">PRICE</th>
														<th width="20%">TYPE</th>
														<th width="20%">DESC</th>
														<th width="15%">FINE</th>
													</tr>
												</thead>
												<tbody id="tbodyFineCateringBatch">
													<?php foreach($ReceiptFine as $rf){ ?>
													<tr class="clone">
														<td>
															<input type="text" id="finedateBatch" name="TxtFineDate[]" class="date form-control finedate cmsingledate" placeholder="Fine Date" value="<?php echo date('d-m-Y', strtotime($rf['receipt_fine_date']))?>">
														</td>
														<td><input id="fineqtyBatch" name="TxtFineQty[]" class="form-control fineqty" onkeypress="return isNumberKey(event)" placeholder="Order Qty" value="<?php echo $rf['receipt_fine_qty']?>" ></td>
														<td><input id="finepriceBatch" name="TxtFinePrice[]" class="form-control fineprice" onkeypress="return isNumberKey(event)" placeholder="Order Price" value="<?php echo $rf['receipt_fine_price']?>" ></td>
														<td>
															<select class="form-control select4 finetype" id="finetypeBatch" name="TxtFineType[]" data-placeholder="Select Type">
																	<option></option>
																<?php foreach ($FineType as $ft) {
																	$fts='';
																	if ($rf['fine_type_percentage'] == $ft['percentage']){$fts='selected';}
																?>
																	<option <?php echo $fts ?>  value="<?php echo $ft['percentage']?>"><?php echo $ft['fine_type']?></option>
																<?php }?>
															</select>
														</td>
														<td><input id="finedescBatch" name="TxtFineDesc[]" class="form-control finedesc toupper" placeholder="Description" value="<?php echo $rf['fine_description']?>"></td>
														<td><input id="finenominalBatch" name="TxtFineNominal[]" class="form-control finenominal" placeholder="Fine" value="<?php echo $rf['fine_nominal']?>" readonly></td>
													</tr>
													<?php } ?>
													<tr class="clone">
														<td><input type="text" id="finedateBatch" name="TxtFineDate[]" class="date form-control cmsingledate" placeholder="Fine Date"></td>
														<td><input id="fineqtyBatch" name="TxtFineQty[]" class="form-control fineqty" onkeypress="return isNumberKey(event)" placeholder="Order Qty"></td>
														<td><input id="finepriceBatch" name="TxtFinePrice[]" class="form-control fineprice" onkeypress="return isNumberKey(event)" placeholder="Order Price"></td>
														<td>
															<select class="form-control select4 finetype" id="finetypeBatch" name="TxtFineType[]" data-placeholder="Select Type">
																	<option></option>
																<?php foreach ($FineType as $ft) {?>
																	<option value="<?php echo $ft['percentage']?>"><?php echo $ft['fine_type']?></option>
																<?php }?>
															</select>
														</td>
														<td><input id="finedescBatch" name="TxtFineDesc[]" class="form-control finedesc toupper" placeholder="Description"></td>
														<td><input id="finenominalBatch" name="TxtFineNominal[]" class="form-control finenominal" placeholder="Fine" readonly></td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>
						
						<!-- INPUT GROUP 3 ROW 1 -->
						<div class="row" style="margin: 10px 10px">
							<div class="form-group">
								<label class="col-lg-2 control-label">Order Net</label>
								<div class="col-lg-3">
									<input id="ordernetBatch" name="TxtOrderNet" class="form-control" onkeypress="return isNumberKey(event)" placeholder="Net" value="0" readonly>
								</div>								
							</div>
						</div>
						<!-- INPUT GROUP 3 ROW 1 -->
						<div class="row" style="margin: 10px 10px">
							<div class="form-group">
								<label class="col-lg-2 control-label">Calculation</label>
								<div class="col-lg-3">
									<input id="calcBatch" name="TxtCalc" class="form-control" onkeypress="return isNumberKey(event)" placeholder="Calc" value="0" readonly>
								</div>								
							</div>
						</div>
						<!-- INPUT GROUP 3 ROW 1 -->
						<div class="row" style="margin: 10px 10px">
							<div class="form-group">
								<label class="col-lg-2 control-label">Fine</label>
								<div class="col-lg-3">
									<input id="fineBatch" name="TxtFine" class="form-control" onkeypress="return isNumberKey(event)" placeholder="Fine" value="<?php echo $rc['fine']?>">
								</div>								
							</div>
						</div>
						<!-- INPUT GROUP 3 ROW 2 -->
						<div class="row" style="margin: 10px 10px">
							<div class="form-group">
								<div class="form-group">
									<label class="col-lg-2 control-label">PPH (2%)</label>
									<div class="col-lg-3">
										<input id="pphBatch" name="TxtPPH" class="form-control" onkeypress="return isNumberKey(event)" placeholder="PPH" value="<?php echo $rc['pph']?>" readonly>
									</div>
								</div>
							</div>
						</div>
						<!-- INPUT GROUP 3 ROW 3 -->
						<div class="row" style="margin: 10px 10px">
							<div class="form-group">
								<label class="col-lg-2 control-label">Total</label>
								<div class="col-lg-3">
									<input id="totalBatch" name="TxtTotal" class="form-control" onkeypress="return isNumberKey(event)" placeholder="Total" readonly>
								</div>								
							</div>
						</div>
												
						<hr>
						<!-- submit -->
						<div class="form-group">
							<div class="col-lg-8 text-right">
								<a href="<?php echo site_url('CateringManagement/ReceiptBatch/Details/'.$rc['receipt_id']);?>"  class="btn btn-success btn-lg btn-rect">Back</a>
								&nbsp;&nbsp;
								<button type="submit" class="btn btn-success btn-lg btn-rect">Save Change</button>
							</div>
						</div>
					<?php }?>
					<form>
					</div>
				</div>
				</div>
			</div>		
		</div>		
	</div>
	</div>
</section>			
			
				
