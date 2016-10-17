<section class="content">
	<div class="row">
		<div class="col-lg-12">
			<div class="col-lg-11">
				<div class="text-right">
					<h1><b>Update Data Assets</b></h1>
				</div>
			</div>
				<div class="col-lg-1 ">
					<div class="text-right hidden-md hidden-sm hidden-xs">
						<a class="btn btn-default btn-lg" href="<?php echo site_url('FixedAsset/DataAssets');?>">
							<i class="fa fa-bookmark fa-2x"></i>
							<span ><br /></span>
						</a>
					</div>
				</div>
		</div>
	</div>
	<br />
	<?php foreach ($DataAsset as $row) { ('FixedAsset/DataAssets/Update')."/".$row['asset_data_id'] ?>
	<form  id="frmDataAsset" method="post" action="<?php echo site_URL('FixedAsset/DataAssets/Update')."/".$row['asset_data_id'] ?>" class="form-horizontal">
		<div class="row">
			<div class="col-lg-12">
				<div class="box box-primary box-solid">
					<div class="box-header with-border">
					Header
					</div>
					<div class="box-body">
						<div class="row">
							<div class="col-lg-12">
								<div class="panel-body">
									<div class ="row">
										<div class="col-lg-6">
											<div class="form-group">
												<label for="norm" class="control-label col-lg-4">Tag Number</label>
												<div class="col-lg-8">
													<input type="text" placeholder="Tag Number" id="txtTagNumber" name="txtTagNumber" class="form-control toupper jsTagNumber" value="<?php echo $row['tag_number'];?>" />
													<input type="hidden" id="hdnTemp" name="hdnTemp" value="<?php echo $row['asset_data_id'];?>"/>
												</div>
											</div>
											<div class="form-group">
												<label for="norm" class="control-label col-lg-4">Location</label>
												<div class="col-lg-6">
													<!--<select name="slcLocation" id="slcLocation" class="form-control jsLocation" />
														<option value="<?php echo $row['location'] ?>">
															<?php 
																if($row['location']==''){
																	echo '';
																}
																else{
																	echo strtoupper($row['location']);
																}
															?>
															</option>
													</select>-->
													<input type="text" placeholder="Location" id="slcLocation" name="slcLocation" class="form-control jsLocation" value="<?php echo strtoupper($row['location']);?>" />
												</div>
												<div class="col-lg-2">
													<a style="margin-right:8px;" href="#" data-toggle="modal" data-target="#locationHistory"  alt="History" title="Location History">
														<i class="fa fa-history fa-2x"></i>
													</a>
												</div>
												
											</div>
											<div class="form-group">
												<label for="norm" class="control-label col-lg-4">Asset Category</label>
												<div class="col-lg-8">
													<!--<select name="slcAssetCategory" id="getAssetCategory" class="form-control jsAssetCategory">
														<option value="<?php echo $row['asset_category'] ?>">
														<?php 
															if($row['asset_category']==''){
																echo '';
															}
															else{
																echo strtoupper($row['asset_category']);
															}
														?>
														</option>
													</select>-->
													<input type="text" placeholder="Asset Category" id="slcAssetCategory" name="slcAssetCategory" value="<?= strtoupper($row['asset_category'])?>" class="form-control jsAssetCategory" />
												</div>
											</div>
											<div class="form-group">
												<label for="norm" class="control-label col-lg-4">Item </label>
												<div class="col-lg-8">
													<!--<select name="slcItemCode" id="slcItemCode" class="form-control jsItemCode" >
														<option value="<?php echo $row['item_code'] ?>">
															<?php 
																if($row['item_code']==''){
																	echo '';
																}
																else{
																	echo strtoupper($row['item_code']);
																}
															?>
															</option>
													</select>-->
													<input type="text" placeholder="Item" id="slcItemCode" name="slcItemCode" required value="<?= strtoupper($row['item_code'])?>" class="form-control jsItemCode" />
												</div>
											</div>
											<div class="form-group">
												<label for="norm" class="control-label col-lg-4">Specification</label>
												<div class="col-lg-8">
													<!--<input type="text" placeholder="Specification" id="txtSpecification" name="txtSpecification" class="form-control toupper" value="<?php echo $row->specification;?>"/>
													<select name="slcSpecification" id="slcSpecification" class="form-control jsSpecification" value="<?php echo $row['specification'];?>">
														<option value="<?php echo $row['specification'] ?>">
														<?php 
															if($row['specification']==''){
																echo '';
															}
															else{
																echo strtoupper($row['specification']);
															}
														?>
														</option>
													</select>-->
													<input type="text" placeholder="Specification" id="slcSpecification" name="slcSpecification" VALUE="<?= strtoupper($row['specification'])?>" class="form-control jsSpecification toupper" />
												</div>
											</div>
											<div class="form-group">
												<label for="norm" class="control-label col-lg-4">Serial Number</label>
												<div class="col-lg-8">
													<input type="text" placeholder="Serial Number" id="txtSerialNumber" name="txtSerialNumber" class="form-control toupper" value="<?php echo $row['serial_number'];?>"/>
												</div>
											</div>
											<div class="form-group">
												<label for="norm" class="control-label col-lg-4">Power</label>
												<div class="col-lg-8">
													<input type="text" placeholder="Power" id="txtPower" name="txtPower" class="form-control toupper" value="<?php echo $row['power'];?>"/>
												</div>
											</div>
											<div class="form-group">
												<label for="norm" class="control-label col-lg-4">Old Number</label>
												<div class="col-lg-8">
													<input type="text" placeholder="Old Number" id="txtOldNumber" name="txtOldNumber" class="form-control toupper" value="<?php echo $row['old_number'];?>"/>
												</div>
											</div>
											<div class="form-group">
												<label for="norm" class="control-label col-lg-4">Ownership Date</label>
												<div class="col-lg-8">
													<?php $change5 = (empty($row['ownership_date']))?'':date("d-M-Y",strtotime($row['ownership_date'])); ?>
													<input type="text" placeholder="<?php echo date("d-M-Y")?>" id="txtOwnershipDate" name="txtOwnershipDate" value="<?php echo $change5;?>" class="form-control datepicker"  data-date-format="dd-M-yyyy"/>
												</div>
											</div>
											<div class="form-group">
												<label for="norm" class="control-label col-lg-4">Person in Charge</label>
												<div class="col-lg-8">
													<input type="text" placeholder="PIC" id="txtPic" name="txtPic" class="form-control toupper" value="<?php echo $row['person_in_charge'];?>"/>
												</div>
											</div>
											<div class="form-group">
												<label for="norm" class="control-label col-lg-4">BPPBA Number</label>
												<div class="col-lg-8">
													<input type="text" placeholder="BPPBA Number" id="slcBppbaNumber" name="slcBppbaNumber" value="<?php echo $row['bppba_number'];?>" onchange="getBppbaDate('<?php echo site_URL() ?>')" class="form-control jsBppbaNumber" />
												</div>
											</div>
											<div class="form-group">
												<label for="norm" class="control-label col-lg-4">BPPBA Date</label>
												<div class="col-lg-8">
													<?php $change = (empty($row['bppba_date']))?'':date("d-M-Y",strtotime($row['bppba_date'])); ?>
													<input type="text" placeholder="<?php echo date("d-M-Y")?>" id="txtBppbaDate" name="txtBppbaDate" class="form-control datepicker" value="<?php echo $change;?>" data-date-format="dd-M-yyyy"/>
												</div>
											</div>
											<div class="form-group">
												<label for="norm" class="control-label col-lg-4">LPA Number</label>
												<div class="col-lg-8">
													<input type="text" placeholder="LPA Number" id="slcLpaNumber" name="slcLpaNumber" value="<?php echo $row['lpa_number'];?>" onchange="getLpabaDate('<?php echo site_URL() ?>')" class="form-control jsLpaNumber" />
												</div>
											</div>
											<div class="form-group">
												<label for="norm" class="control-label col-lg-4">LPA Date</label>
												<div class="col-lg-8">
												<?php $change2 = (empty($row['lpa_date']))?'':date("d-M-Y",strtotime($row['lpa_date'])); ?>
													<input type="text" placeholder="<?php echo date("d-M-Y")?>" id="txtLpaDate" name="txtLpaDate" class="form-control datepicker" value="<?php echo $change2;?>" data-date-format="dd-M-yyyy"/>
												</div>
											</div>
											
											<div class="form-group">
												<label for="norm" class="control-label col-lg-4">Asset Value</label>
												<div class="col-lg-8">
													<input type="text" id="txtAssetValue" name="txtAssetValue" value="<?php echo  (!isset($row['asset_value']))?"":number_format($row['asset_value'],2,'.','');?>" class="form-control" />
												</div>
											</div>
											<div class="form-group">
												<label for="norm" class="control-label col-lg-4">Asset Age (Yr)</label>
												<div class="col-lg-8">
													<input type="number" id="txtAssetAge" name="txtAssetAge" value="<?php echo $row['asset_age'];?>" class="form-control"/>
												</div>
											</div>
										</div>
										<div class="col-lg-6">
											<div class="form-group">
												<label for="norm" class="control-label col-lg-4">Transfer Number</label>
												<div class="col-lg-8">
													<input type="text" placeholder="Transfer Number" id="slcTransferNumber" name="slcTransferNumber" value="<?php echo $row['transfer_number'];?>" onchange="getTransferDate('<?php echo site_URL() ?>')" class="form-control jsTransferNumber" />
												</div>
											</div>
											<div class="form-group">
												<label for="norm" class="control-label col-lg-4">Transfer Date</label>
												<div class="col-lg-8">
												<?php $change3 = (empty($row['transfer_date']))?'':date("d-M-Y",strtotime($row['transfer_date'])); ?>
													<input type="text" placeholder="<?php echo date("d-M-Y")?>" id="txtTransferDate" name="txtTransferDate" class="form-control datepicker" value="<?php echo $change3;?>" data-date-format="dd-M-yyyy"/>
												</div>
											</div>
											<div class="form-group">
												<label for="norm" class="control-label col-lg-4">Retirement Number</label>
												<div class="col-lg-8">
													<input type="text" placeholder="Retirement Number" id="slcRetirementNumber" name="slcRetirementNumber" value="<?php echo $row['retirement_number'];?>" onchange="getRetirementDate('<?php echo site_URL() ?>')" class="form-control jsRetirementNumber" />
												</div>
											</div>
											<div class="form-group">
												<label for="norm" class="control-label col-lg-4">Retirement Date</label>
												<div class="col-lg-8">
												<?php $change4 = (empty($row['retirement_date']))?'':date("d-M-Y",strtotime($row['retirement_date'])); ?>
													<input type="text" placeholder="<?php echo date("d-M-Y")?>" id="txtRetirementDate" name="txtRetirementDate" class="form-control datepicker" value="<?php echo $change4;?>" data-date-format="dd-M-yyyy"/>
												</div>
											</div>
											<div class="form-group">
												<label for="norm" class="control-label col-lg-4">PP Number</label>
												<div class="col-lg-8">
													<input type="text" placeholder="PP Number" id="slcPpNumber" name="slcPpNumber" value="<?php echo $row['pp_number'];?>"  class="form-control jsPpNumber" />
												</div>
											</div>
											<div class="form-group">
												<label for="norm" class="control-label col-lg-4">PO Number</label>
												<div class="col-lg-8">
													<input type="text" placeholder="PO Number" id="slcPoNumber" name="slcPoNumber" value="<?php echo $row['po_number'];?>"  class="form-control jsPoNumber" />
												</div>
											</div>
											<div class="form-group">
												<label for="norm" class="control-label col-lg-4">PR Number</label>
												<div class="col-lg-8">
													<input type="text" placeholder="PR Number" id="slcPrNumber" name="slcPrNumber" value="<?php echo $row['pr_number'];?>"  class="form-control jsPrNumber" />
												</div>
											</div>
											<!--
											<div class="form-group">
												<label for="norm" class="control-label col-lg-4">Add-by</label>
												<div class="col-lg-8">
													<select name="slcAddBy" id="slcAddBy" class="form-control jsAddBy" value="<?php echo $row['Add_by']?>">
												<option value="<?php echo $row['add_by'] ?>">
													<?php 
														if($row['add_by']==''){
															echo '';
														}
														else{
															echo strtoupper($row['add_by']);
														}
													?>
													</option>
												</select>
												</div>
											</div>
											<div class="form-group">
												<label for="norm" class="control-label col-lg-4">Add-by Date</label>
												<div class="col-lg-8">
												<?php $change5 = date("d-M-Y",strtotime($row['add_by_date'])); ?>
													<input type="text" placeholder="<?php echo date("d-M-Y")?>" id="txtAddByDate" name="txtAddByDate" class="form-control datepicker" value="<?php echo $change5;?>" data-date-format="dd-M-yyyy"/>
												</div>
											</div>
											-->
											<div class="form-group">
												<label for="norm" class="control-label col-lg-4">Upload Oracle</label>
												<div class="col-lg-8">
													<select name="slcUploadOracle" id="slcUploadOracle" class="form-control jsUploadOracle" value="<?php echo $row['Upload_Oracle']?>">
														<option value="<?php echo $row['upload_oracle'] ?>">
															<?php 
																if($row['upload_oracle']==''){
																	echo '';
																}
																else{
																	echo strtoupper($row['upload_oracle']);
																}
															?>
														</option>
													</select>
												
												</div>
											</div>
											<div class="form-group">
												<label for="norm" class="control-label col-lg-4">Upload Oracle Date</label>
												<div class="col-lg-8">
												<?php $change6 = (empty($row['upload_oracle_date']))?'':date("d-M-Y",strtotime($row['upload_oracle_date'])); ?>
													<input type="text" placeholder="<?php echo date("d-M-Y")?>" id="txtUploadOracleDate" name="txtUploadOracleDate" class="form-control datepicker" value="<?php echo $change6;?>" data-date-format="dd-M-yyyy"/>
												</div>
											</div>
											<div class="form-group">
												<label for="norm" class="control-label col-lg-4">Description</label>
												<div class="col-lg-8">
													<textarea id="autosize" placeholder="Description" id="txtDescription" name="txtDescription" class="form-control toupper" /><?php echo $row['description'];?></textarea>
												</div>
											</div>
											<div class="form-group">
												<label for="norm" class="control-label col-lg-4">Insurance</label>
												<div class="col-lg-8">
													<input type="text" placeholder="Insurance" id="txtInsurance" name="txtInsurance" class="form-control toupper" value="<?php echo $row['insurance'];?>"/>
												</div>
											</div>
											<div class="form-group">
												<label for="norm" class="control-label col-lg-4">Appraisal</label>
												<div class="col-lg-8">
													<input type="text" placeholder="Appraisal" id="txtAppraisal" name="txtAppraisal" class="form-control toupper" value="<?php echo $row['appraisal'];?>"/>
												</div>
											</div>
											<div class="form-group">
												<label for="norm" class="control-label col-lg-4">SO</label>
												<div class="col-lg-8">
													<input type="text" placeholder="Stock Opname" id="txtSo" name="txtSo" class="form-control toupper" value="<?php echo $row['stock_opname'];?>"/>
												</div>
											</div>
											<div class="form-group">
												<label for="norm" class="control-label col-lg-4">Sticker</label>
												<div class="col-lg-8">
													<select name="slcSticker" id="slcSticker" class="form-control select4">
														<option value="No" <?php if($row['sticker']==="No"){echo "selected";}?>>No</option>
														<option value="Yes" <?php if($row['sticker']==="Yes"){echo "selected";}?>>Yes</option>
													</select>
												</div>
											</div>
											<div class="form-group">
												<label for="norm" class="control-label col-lg-4">Asset Group</label>
												<div class="col-lg-8">
													<input type="text" id="txtAssetGroup" name="txtAssetGroup" class="form-control" value="<?php echo $row['asset_group'];?>"/>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="modal" id="locationHistory" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
									<div class="modal-dialog" style="min-width:800px;">
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
												<h4 class="modal-title" id="myModalLabel">Location History</h4>
											</div>
											
											<div class="modal-body" >
												<table class="table table-striped table-bordered table-hover text-center"   style="font-size:12px;" name="tblServiceLines" id="dataTables-customer">
												<thead>
													<tr>
														<th width="70%">Location</th>
														<th width="8%">Employee</th>
														<th width="22%">Date Changed</th>
													</tr>
												</thead>
												<tbody>
													<?php
													foreach($AssetHistories as $p => $AssetHistories_item){
													?>
													<tr>
														<td><?php echo $AssetHistories_item['location'] ?></td>
														<td><?php echo $AssetHistories_item['created_by'] ?></td>
														<td><?php echo $AssetHistories_item['creation_date'] ?></td>
													</tr>
													<?php
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
								<div class="panel-footer">
									<div class="row text-right">
										<a href="<?php echo site_url('FixedAsset/DataAssets');?>" class="btn btn-primary btn-lg btn-rect">Back</a>
										&nbsp;&nbsp;
										<button id="btnSaveAssets" type="submit" class="btn btn-primary btn-lg btn-rect">Save Data</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>
	<?php } ?>
<div class="control-sidebar-bg"></div>
</div>
</section>