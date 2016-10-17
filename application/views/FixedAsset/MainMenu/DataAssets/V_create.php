<section class="content">
	<div class="row">
		<div class="col-lg-12">
			<div class="col-lg-11">
				<div class="text-right">
					<h1><b>New Data Assets</b></h1>

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
	<form method="post" action="<?php echo site_url('FixedAsset/DataAssets/Create')?>" class="form-horizontal" id="frmDataAsset">
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
													<input type="text" placeholder="Tag Number" id="txtTagNumber" name="txtTagNumber" class="form-control toupper jsTagNumber" />
												</div>
											</div>
											<div class="form-group">
												<label for="norm" class="control-label col-lg-4">Location</label>
												<div class="col-lg-8">
													<input type="text" placeholder="Location" id="slcLocation" name="slcLocation" class="form-control jsLocation" />
												</div>
											</div>
											<div class="form-group">
												<label for="norm" class="control-label col-lg-4">Asset Category</label>
												<div class="col-lg-8">
													<input type="text" placeholder="Asset Category" id="slcAssetCategory" name="slcAssetCategory" class="form-control jsAssetCategory" />
												</div>
											</div>
											<div class="form-group">
												<label for="norm" class="control-label col-lg-4">Item code</label>
												<div class="col-lg-8">
													<input type="text" placeholder="Item" id="slcItemCode" required name="slcItemCode" class="form-control jsItemCode" />
												</div>
											</div>
											<div class="form-group">
												<label for="norm" class="control-label col-lg-4">Specification</label>
												<div class="col-lg-8">
													<input type="text" placeholder="Specification" id="slcSpecification" name="slcSpecification" class="form-control jsSpecification" />
													
												</div>
											</div>
											<div class="form-group">
												<label for="norm" class="control-label col-lg-4">Serial Number</label>
												<div class="col-lg-8">
													<input type="text" placeholder="Serial Number" id="txtSerialNumber" name="txtSerialNumber" class="form-control toupper"/>
												</div>
											</div>
											<div class="form-group">
												<label for="norm" class="control-label col-lg-4">Power</label>
												<div class="col-lg-8">
													<input type="text" placeholder="Power" id="txtPower" name="txtPower" class="form-control toupper"/>
												</div>
											</div>
											<div class="form-group">
												<label for="norm" class="control-label col-lg-4">Old Number</label>
												<div class="col-lg-8">
													<input type="text" placeholder="Old Number" id="txtOldNumber" name="txtOldNumber" class="form-control toupper"/>
												</div>
											</div>
											<div class="form-group">
												<label for="norm" class="control-label col-lg-4">Ownership Date</label>
												<div class="col-lg-8">
													<input type="text" placeholder="<?php echo date("d-M-Y")?>" id="txtOwnershipDate" name="txtOwnershipDate" class="form-control datepicker"  data-date-format="dd-M-yyyy"/>
												</div>
											</div>
											<div class="form-group">
												<label for="norm" class="control-label col-lg-4">Person in Charge</label>
												<div class="col-lg-8">
													<input type="text" placeholder="PIC" id="txtPic" name="txtPic" class="form-control toupper"/>
												</div>
											</div>
											<div class="form-group">
												<label for="norm" class="control-label col-lg-4">BPPBA Number</label>
												<div class="col-lg-8">
												<!--<select name="slcBppbaNumber" id="slcBppbaNumber" class="form-control jsBppbaNumber" >
												<option value="" ></option>
												</select>-->
													<input type="text" placeholder="BPPBA Number" id="slcBppbaNumber" name="slcBppbaNumber" onchange="getBppbaDate('<?php echo site_URL() ?>')" class="form-control jsBppbaNumber" />
												</div>
											</div>
											<div class="form-group">
												<label for="norm" class="control-label col-lg-4">BPPBA Date</label>
												<div class="col-lg-8">
													<input type="text" placeholder="<?php echo date("d-M-Y")?>" id="txtBppbaDate" name="txtBppbaDate" class="form-control datepicker"  data-date-format="dd-M-yyyy"/>
												</div>
											</div>
											<div class="form-group">
												<label for="norm" class="control-label col-lg-4">LPA Number</label>
												<div class="col-lg-8">
													<input type="text" placeholder="LPA Number" id="slcLpaNumber" name="slcLpaNumber" onchange="getLpabaDate('<?php echo site_URL() ?>')" class="form-control jsLpaNumber" />
												</div>
											</div>
											<div class="form-group">
												<label for="norm" class="control-label col-lg-4">LPA Date</label>
												<div class="col-lg-8">
													<input type="text" placeholder="<?php echo date("d-M-Y")?>" id="txtLpaDate" name="txtLpaDate" class="form-control datepicker"  data-date-format="dd-M-yyyy"/>
												</div>
											</div>
											<div class="form-group">
												<label for="norm" class="control-label col-lg-4">Asset Value</label>
												<div class="col-lg-8">
													<input type="text" id="txtAssetValue" name="txtAssetValue" class="form-control"/>
												</div>
											</div>
											<div class="form-group">
												<label for="norm" class="control-label col-lg-4">Asset Age (Yr)</label>
												<div class="col-lg-8">
													<input type="number" id="txtAssetAge" name="txtAssetAge" class="form-control"/>
												</div>
											</div>
										</div>
										<div class="col-lg-6">
											<div class="form-group">
												<label for="norm" class="control-label col-lg-4">Transfer Number</label>
												<div class="col-lg-8">
													<input type="text" placeholder="Transfer Number" id="slcTransferNumber" name="slcTransferNumber" onchange="getTransferDate('<?php echo site_URL() ?>')" class="form-control jsTransferNumber" />
												</div>
											</div>
											<div class="form-group">
												<label for="norm" class="control-label col-lg-4">Transfer Date</label>
												<div class="col-lg-8">
													<input type="text" placeholder="<?php echo date("d-M-Y")?>" id="txtTransferDate" name="txtTransferDate" class="form-control datepicker"  data-date-format="dd-M-yyyy"/>
												</div>
											</div>
											<div class="form-group">
												<label for="norm" class="control-label col-lg-4">Retirement Number</label>
												<div class="col-lg-8">
													<input type="text" placeholder="Retirement Number" id="slcRetirementNumber" name="slcRetirementNumber" onchange="getRetirementDate('<?php echo site_URL() ?>')" class="form-control jsRetirementNumber" />
												</div>
											</div>
											<div class="form-group">
												<label for="norm" class="control-label col-lg-4">Retirement Date</label>
												<div class="col-lg-8">
													<input type="text" placeholder="<?php echo date("d-M-Y")?>" id="txtRetirementDate" name="txtRetirementDate" class="form-control datepicker"  data-date-format="dd-M-yyyy"/>
												</div>
											</div>
											<div class="form-group">
												<label for="norm" class="control-label col-lg-4">PP Number</label>
												<div class="col-lg-8">
													<input type="text" placeholder="PP Number" id="slcPpNumber" name="slcPpNumber" class="form-control jsPpNumber" />
												</div>
											</div>
											<div class="form-group">
												<label for="norm" class="control-label col-lg-4">PO Number</label>
												<div class="col-lg-8">
													<input type="text" placeholder="PO Number" id="slcPoNumber" name="slcPoNumber" class="form-control jsPoNumber" />
												</div>
											</div>
											<div class="form-group">
												<label for="norm" class="control-label col-lg-4">PR Number</label>
												<div class="col-lg-8">
													<input type="text" placeholder="PR Number" id="slcPrNumber" name="slcPrNumber" class="form-control jsPrNumber" />
												</div>
											</div>
											<!--
											<div class="form-group">
												<label for="norm" class="control-label col-lg-4">Add-by</label>
												<div class="col-lg-8">
												<select name="slcAddBy" id="slcAddBy" class="form-control jsAddBy" onchange="getAddByDate('<?php echo site_URL() ?>')">
												<option value="" ></option>
												</select>
												</div>
											</div>
											<div class="form-group">
												<label for="norm" class="control-label col-lg-4">Add-by Date</label>
												<div class="col-lg-8">
													<input type="text" placeholder="<?php echo date("d-M-Y")?>" id="txtAddByDate" name="txtAddByDate" class="form-control datepicker"  data-date-format="dd-M-yyyy"/>
												</div>
											</div>
											-->
											<div class="form-group">
												<label for="norm" class="control-label col-lg-4">Upload Oracle</label>
												<div class="col-lg-8">
													<select name="slcUploadOracle" id="slcUploadOracle" class="form-control jsUploadOracle">
														<option value="" ></option>
													</select>
												</div>
											</div>
											<div class="form-group">
												<label for="norm" class="control-label col-lg-4">Upload Oracle Date</label>
												<div class="col-lg-8">
													<input type="text" placeholder="<?php echo date("d-M-Y")?>" id="txtUploadOracleDate" name="txtUploadOracleDate" class="form-control datepicker"  data-date-format="dd-M-yyyy"/>
												</div>
											</div>
											<div class="form-group">
												<label for="norm" class="control-label col-lg-4">Description</label>
												<div class="col-lg-8">
													<textarea id="autosize" placeholder="Description" id="txtDescription" name="txtDescription" class="form-control toupper"></textarea>
												</div>
											</div>
											<div class="form-group">
												<label for="norm" class="control-label col-lg-4">Insurance</label>
												<div class="col-lg-8">
													<input type="text" placeholder="Insurance" id="txtInsurance" name="txtInsurance" class="form-control toupper"/>
												</div>
											</div>
											<div class="form-group">
												<label for="norm" class="control-label col-lg-4">Appraisal</label>
												<div class="col-lg-8">
													<input type="text" placeholder="Appraisal" id="txtAppraisal" name="txtAppraisal" class="form-control toupper"/>
												</div>
											</div>
											<div class="form-group">
												<label for="norm" class="control-label col-lg-4">SO</label>
												<div class="col-lg-8">
													<input type="text" placeholder="Stock Opname" id="txtSo" name="txtSo" class="form-control toupper"/>
												</div>
											</div>
											<div class="form-group">
												<label for="norm" class="control-label col-lg-4">Sticker</label>
												<div class="col-lg-8">
													<select name="slcSticker" id="slcSticker" class="form-control select4">
														<option value="No" >No</option>
														<option value="Yes" >Yes</option>
													</select>
												</div>
											</div>
											<div class="form-group">
												<label for="norm" class="control-label col-lg-4">Asset Group</label>
												<div class="col-lg-8">
													<input type="text" id="txtAssetGroup" name="txtAssetGroup" class="form-control"/>
												</div>
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

<div class="control-sidebar-bg"></div>
</div>
</section>