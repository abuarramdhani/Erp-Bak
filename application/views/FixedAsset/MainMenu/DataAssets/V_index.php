<script src="<?php echo base_url('assets/js/ajaxSearch.js');?>"></script>
<section class="content">
	<div class="inner">
	<div class="row">
		<div class="col-lg-12">
			<div class="row">
				<div class="col-lg-12">
					<div class="col-lg-11">
						<div class="text-right">
						<h1><b>Data Assets</b></h1>
						
						</div>
					</div>
					<div class="col-lg-1">
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
		<div class="row">
		<div class="col-md-12">
			<ol class="breadcrumb text-right">
				<li class ="active"><?php echo date('d F Y') ?></a></li>
				<li class ="active"><span id="clockbox"><?php echo date('H:i:s') ?></span></li>
				<li class ="active">Data Assets</li>
			</ol>
		</div>
			<div class="col-lg-12">
				<div class="box box-primary box-solid">
					<div class="box-header with-border">
						<a href="<?php echo site_url('FixedAsset/DataAssets/Create') ?>" style="float:right;margin-right:1%;margin-top:-0.5%;" alt="Add New" title="Add New" >
							<button type="button" class="btn btn-default btn-sm">
							  <i class="fa fa-plus fa-2x"></i>
							</button>
						</a>
						Assets Data List 
					</div>
					
					<div class="box-body">
						
						<div class="table-responsive" style="overflow:hidden;">
							
							<div class="table-responsive">
								<div style="margin-bottom:10px">
								<button data-toggle="collapse" data-target="#demo" class="btn btn-warning">Dangerous Function</button>
								<button data-toggle="collapse" data-target="#filter" class="btn btn-primary">Filter Data</button>
								</div>
							<form method="post" id="frmUploadAsset" action="<?php echo site_url('FixedAsset/DataAssets/ExportImport') ?>"  enctype="multipart/form-data"> </form>
							<form method="post" id="frmDeleteAsset" action="<?php echo site_url('FixedAsset/DataAssets/DeleteShown') ?>" > </form>
							<form method="post" id="frmUpdateAsset" action="<?php echo site_url('FixedAsset/DataAssets/UpdateShown') ?>" > </form>
								<div id="demo" class="collapse" style="margin-bottom:10px">
									<div class="col-lg-12" style="margin-bottom:10px">
										
										<div class="col-lg-4">
											<input name="fileSheet" type="file" value="Export to Excel" form="frmUploadAsset"/> 
											
										</div>
										<div class="col-lg-2">
											<input name="btnUpload" type="submit" class="btn btn-default" value="Import"  form="frmUploadAsset"/>
										</div>
										
										<!--<div class="col-lg-3">
											<input name="btnDownload" style="margin-left:15px" type="submit" class="btn btn-success" value="Export" />  
										</div>-->
									</div>
									<div class="col-lg-12" style="margin-bottom:10px">
										
										<div class="form-group">
											<label for="norm" class="control-label col-lg-1">Column</label>
											<div class="col-lg-4">
												<select name="slcColumn" id="slcColumn" class="form-control" form="frmUpdateAsset">
													<option value="" ></option>
													<option value="location" >Location</option>
													<option value="asset_category" >Asset Category</option>
													<option value="item_code" >Item</option>
													<option value="specification" >Specification</option>
													<option value="power" >Power</option>
													<option value="person_in_charge" >Person In Charge</option>
													<option value="bppba_number" >BPPBA Number</option>
													<option value="bppba_date" >BPPBA Date</option>
													<option value="lpa_number" >LPA Number</option>
													<option value="lpa_date" >LPA Date</option>
													<option value="transfer_number" >Transfer Number</option>
													<option value="transfer_date" >Transfer Date</option>
													<option value="retirement_number" >Retirement Number</option>
													<option value="retirement_date" >Retirement Date</option>
													<option value="pp_number" >PP Number</option>
													<option value="pr_number" >PR Number</option>
													<option value="po_number" >PO Number</option>
													<option value="upload_oracle" >Upload Oracle</option>
													<option value="upload_oracle_date" >Upload Oracle Date</option>
													<option value="insurance" >Insurance</option>
													<option value="appraisal" >Appraisal</option>
													<option value="stock_opname" >Stock Opname</option>
													<option value="asset_age" >Asset Age</option>
													<option value="asset_group" >Asset Group</option>
												</select>
											</div>
											<label for="norm" class="control-label col-lg-1">Value</label>
											<div class="col-lg-2">
												<input name="txtColumnValue" type="text" class="form-control" form="frmUpdateAsset"/>
											</div>
											<div class="col-lg-2">
												<input name="btnUpdateAssets" id="btnUpdateAssets" type="submit" class="btn btn-danger" value="Update Data Shown" form="frmUpdateAsset"/>
											</div>
											<div class="col-lg-2">
												<input name="btnDeleteAssets" id="btnDeleteAssets" type="submit" class="btn btn-danger" value="Delete Data Shown" form="frmDeleteAsset"/>
											</div>
										</div>
										
										<!--<div class="col-lg-3">
											<input name="btnDownload" style="margin-left:15px" type="submit" class="btn btn-success" value="Export" />  
										</div>-->
									</div>
								</div>
								<div id="filter" class="collapse" style="margin-bottom:10px">
									<table class="table">
										<tr>
											<td width="20%"><input type="text" class="form-control toupper" placeholder="Location" name="txtSearchByLocation" id="txtSearchByLocation" /></td>
											<td width="20%"><input type="text" class="form-control toupper" placeholder="Item" name="txtSearchByItem" id="txtSearchByItem" /></td>											
											<td width="10%"><a href="#" onclick="searchServiceProducts('<?php echo base_url();?>');return false;" class="btn btn-primary btn-md btn-rect">Search</a></td>
										</tr>
									</table>
									
								</div>
								<div id="loading"></div>
								<div id="res">
									<table class="table table-striped table-bordered table-hover text-left display" style="font-size:12px;min-width:4800px;table-layout: fixed;" id="dataAssetdataTables" style="font-size:12px;">
										<thead>
											<tr class="bg-primary">
												<th width="100px"><center>Action</center></th>
												<th width="20px"><center>No</center></th>
												<th width="100px"><center>Tag Number</center></th>
												<th width="200px"><center>Location</center></th>
												<th width="120px"><center>Asset Category</center></th>
												<th width="400px"><center>Item</center></th>
												<th width="200px"><center>Specification</center></th>
												<th width="80px"><center>Serial Number</center></th>
												<th width="50px"><center>Power</center></th>
												<th width="100px"><center>Old Number</center></th>
												<th width="80px"><center>Ownership Date</center></th>
												<th width="200px"><center>Person In Charge</center></th>
												<th width="80px"><center>BPPBA Number</center></th>
												<th width="80px"><center>BPPBA Date</center></th>
												<th width="80px"><center>LPA Number</center></th>
												<th width="80px"><center>LPA Date</center></th>
												<th width="80px"><center>Transfer Number</center></th>
												<th width="80px"><center>Transfer Date</center></th>
												<th width="80px"><center>Retirement Number</center></th>
												<th width="80px"><center>Retirement Date</center></th>
												<th width="80px"><center>PP Number</center></th>
												<th width="80px"><center>PO Number</center></th>
												<th width="80px"><center>PR Number</center></th>
												<th width="80px"><center>Add-by</center></th>
												<th width="80px"><center>Add-by Date</center></th>
												<th width="80px"><center>Upload Oracle</center></th>
												<th width="80px"><center>Upload Oracle Date</center></th>
												<th width="180px"><center>Description</center></th>
												<th width="80px"><center>Insurance</center></th>
												<th width="80px"><center>Appraisal</center></th>
												<th width="80px"><center>Stock Opname</center></th>
												<th width="50px"><center>Sticker</center></th>
												<th width="80px"><center>Asset Value</center></th>
												<th width="80px"><center>Asset Age (Yr)</center></th>
												<th width="80px"><center>Asset Group (Tax)</center></th>
											</tr>
										</thead>
										<tbody>
										
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
	</div>
</div>
</div>
</section>