<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>Stock Monitoring | Component Monitoring</title>
		<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
		<link rel="shortcut icon" href="<?php echo base_url('assets/img/logo.ico');?>" type="image/x-icon">
		<link href="<?php echo base_url('assets/plugins/bootstrap/3.3.6/css/bootstrap.min.css') ?>" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" href="<?php echo base_url('assets/plugins/select2/select2.min.css');?>" type="text/css" />
		<link href="<?php echo base_url('assets/theme/css/AdminLTE.min.css') ?>" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url('assets/plugins/dataTables/dataTables.bootstrap.css') ?>" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url('assets/plugins/Font-Awesome/4.3.0/css/font-awesome.min.css') ?>" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url('assets/plugins/jQueryUI/jquery-ui.css') ?>" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url('assets/plugins/jquery-autocomplete/jquery.autocomplete.css') ?>" rel="stylesheet" type="text/css" />
	<!--<link href="<?php echo base_url('assets/css/font-awesome-animation.min.css') ?>" rel="stylesheet" type="text/css" />-->
		<link href="<?php echo base_url('assets/plugins/ionicons/css/ionicons.min.css') ?>" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url('assets/theme/css/skins/skin-blue-light.min.css') ?>" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" href="<?php echo base_url('assets/plugins/daterangepicker-master/daterangepicker.css');?>" />
		<link rel="stylesheet" href="<?php echo base_url('assets/css/custom.css');?>" />
		<script src="<?php echo base_url('assets/plugins/jquery-2.1.4.min.js');?>" type="text/javascript"></script>
		<script src="<?php echo base_url('assets/plugins/jQueryUI/jquery-ui.min.js');?>" type="text/javascript"></script>
		<script src="<?php echo base_url('assets/plugins/jquery-autocomplete/jquery.autocomplete.js');?>" type="text/javascript"></script>
		<script src="<?php echo base_url('assets/plugins/bootstrap/3.3.6/js/bootstrap.min.js');?>" type="text/javascript"></script>
		<style type="text/css">
			.color-palette {
				width: 30px;
				height: 10px;
				margin-top: 5px;
				line-height: 35px;
				text-align: center;
			}
		</style>
	</head>
	<body class="hold-transition skin-blue-light sidebar-mini" style="background-color: #ECF7FF">
		<header class="main-header">
		</header>
		
		<!-- HEADER -->
	<div class="container-fluid">
		<div class="row">
			
			<div class="col-md-8 col-md-offset-2" align="center">
				<h3><b>"STOCK OPNAME PUSAT"</b></h3>
			</div>
			<div class="col-md-2" align="center">
				<h3 class="pull-right">
					<a data-toggle="tooltip" data-placement="left" title="Export All Data to PDF File" href="<?php echo base_url('StockControl/stock-opname-pusat/print_to_pdf')?>" class="btn btn-xs btn-primary faa-parent animated-hover"><i class="fa fa-file-pdf-o faa-flash"></i></a>
					<span data-toggle="tooltip" data-placement="left" title="Refresh" onclick="window.location.reload()" class="btn btn-xs btn-success faa-parent animated-hover"><i class="fa fa-refresh faa-spin"></i></span>
					<a data-toggle="tooltip" data-placement="left" title="Close Monitoring" href="<?php echo site_url('StockControl/stock-opname-pusat')?>" class="btn btn-xs btn-danger faa-parent animated-hover"><i class="fa fa-close faa-flash"></i></a>
				</h3>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-6">
				<form id="filter-form-pusat" method="post">
					<div class="form-group">
						<div class="row" style="margin: 10px 10px">
							<div class="col-lg-3">
								<label class="control-label">IO</label>
							</div>
							<div class="col-lg-9">
								<select class="form-control select2" name="txt_io_name" data-placeholder="Pilih Salah Satu!">
									<option></option>
									<option>All</option>
									<?php
										foreach ($io_name as $io_name) {
									?>
										<option><?php echo $io_name['io_name'] ?></option>
									<?php
										}
									?>
								</select>
							</div>
						</div>
						<div class="row" style="margin: 10px 10px">
							<div class="col-lg-3">
								<label class="control-label">Sub Inventory</label>
							</div>
							<div class="col-lg-9">
								<select class="form-control select2" name="txt_sub_inventory" data-placeholder="Pilih Salah Satu!" disabled>
									<option></option>
								</select>
							</div>
						</div>
						<div class="row" style="margin: 10px 10px">
							<div class="col-lg-3">
								<label class="control-label">Area</label>
							</div>
							<div class="col-lg-9">
								<select class="form-control select2" name="txt_area_pusat" data-placeholder="Pilih Salah Satu!" disabled>
								</select>
							</div>
						</div>
						<div class="row" style="margin: 10px 10px">
							<div class="col-lg-3">
								<label class="control-label">Locator</label>
							</div>
							<div class="col-lg-9">
								<select class="form-control select2" name="txt_locator" data-placeholder="Pilih Salah Satu!" disabled>
								</select>
							</div>
						</div>
					</div>
				</form>
			</div>
			<div class="row">
				<div class="col-lg-6">
					<div class="row" style="margin: 10px 10px; padding-top: 19%">
						<div class="col-lg-12">
							<button type="button" id="show-result" class="btn btn-primary btn-lg" disabled><b><i class="fa fa-search"></i> Search</b></button>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<div class="table-responsive">
					<fieldset class="row2" style="background:#ECF7FF;">
						<div class="pull-right">
							<div id="loadingImage" style="display: inline-block;"></div>
							&emsp;&emsp;
							<button data-toggle="modal" data-target="#add-form" type="button" class="btn btn-primary btn-lg" style="display: inline-block;"><b><i class="fa fa-plus"></i> NEW</b></button>
							<div class="modal fade" id="add-form">
								<div class="modal-dialog modal-lg">
									<div class="modal-content">
										<form method="post" action="<?php echo base_url('StockControl/stock-opname-pusat/new_component') ?>">
											<div class="modal-header bg-primary">
												<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
												<h4 class="modal-title">Input Data Component</h4>
											</div>
											<div class="modal-body no-padding">
												<div class="row">
													<div class="col-lg-6">
														<div class="row" style="margin: 10px 0">
															<div class="col-lg-4">
																<label class="control-label">IO</label>
															</div>
															<div class="col-lg-8">
																<input id="io_name" type="text" name="txt_new_io_name" class="form-control io_name">
																<div class="io_name_list" style="position:absolute; width: 90%;"></div>
															</div>
														</div>
														<div class="row" style="margin: 10px 0">
															<div class="col-lg-4">
																<label class="control-label">Sub Inventory</label>
															</div>
															<div class="col-lg-8">
																<input id="sub_inventory" type="text" name="txt_new_sub_inventory" class="form-control sub_inventory">
																<div class="sub_inventory_list" style="position:absolute; width: 90%;"></div>
															</div>
														</div>
														<div class="row" style="margin: 10px 0">
															<div class="col-lg-4">
																<label class="control-label">Area</label>
															</div>
															<div class="col-lg-8">
																<input id="area" type="text" name="txt_new_area" class="form-control area">
																<div class="area_list" style="position:absolute; width: 90%;"></div>
															</div>
														</div>
														<div class="row" style="margin: 10px 0">
															<div class="col-lg-4">
																<label class="control-label">Locator</label>
															</div>
															<div class="col-lg-8">
																<input id="locator" type="text" name="txt_new_locator" class="form-control locator">
																<div class="locator_list" style="position:absolute; width: 90%;"></div>
															</div>
														</div>
														<div class="row" style="margin: 10px 0">
															<div class="col-lg-4">
																<label class="control-label">Save Location</label>
															</div>
															<div class="col-lg-8">
																<input id="saving_place" type="text" name="txt_new_saving_place" class="form-control saving_place">
																<div class="saving_place_list" style="position:absolute; width: 90%;"></div>
															</div>
														</div>
														<div class="row" style="margin: 10px 0">
															<div class="col-lg-4">
																<label class="control-label">Cost Center</label>
															</div>
															<div class="col-lg-8">
																<input id="cost_center" type="text" name="txt_new_cost_center" class="form-control cost_center">
																<div class="cost_center_list" style="position:absolute; width: 90%;"></div>
															</div>
														</div>
														<div class="row" style="margin: 10px 0">
															<div class="col-lg-4">
																<label class="control-label">Sequence</label>
															</div>
															<div class="col-lg-8">
																<input id="seq" type="text" name="txt_new_seq" class="form-control" value="<?php echo $next_seq; ?>" onkeypress="return isNumberKey(event)">
															</div>
														</div>
													</div>
													<div class="col-lg-6">
														<div class="row" style="margin: 10px 0">
															<div class="col-lg-4">
																<label class="control-label">Component Code</label>
															</div>
															<div class="col-lg-8">
																<input id="component_code" type="text" name="txt_new_component_code" class="form-control">
															</div>
														</div>
														<div class="row" style="margin: 10px 0">
															<div class="col-lg-4">
																<label class="control-label">Component Desc</label>
															</div>
															<div class="col-lg-8">
																<input id="component_desc" type="text" name="txt_new_component_desc" class="form-control">
															</div>
														</div>
														<div class="row" style="margin: 10px 0">
															<div class="col-lg-4">
																<label class="control-label">Type</label>
															</div>
															<div class="col-lg-8">
																<input id="type" type="text" name="txt_new_type" class="form-control type">
																<div class="type_list" style="position:absolute; width: 90%;"></div>
															</div>
														</div>
														<div class="row" style="margin: 10px 0">
															<div class="col-lg-4">
																<label class="control-label">On Hand QTY</label>
															</div>
															<div class="col-lg-8">
																<input id="onhand_qty" type="text" name="txt_new_onhand_qty" class="form-control"  onkeypress="return isNumberKey(event)">
															</div>
														</div>
														<div class="row" style="margin: 10px 0">
															<div class="col-lg-4">
																<label class="control-label">SO QTY</label>
															</div>
															<div class="col-lg-8">
																<input id="so_qty" type="text" name="txt_new_so_qty" class="form-control"  onkeypress="return isNumberKey(event)">
															</div>
														</div>
														<div class="row" style="margin: 10px 0">
															<div class="col-lg-4">
																<label class="control-label">UOM</label>
															</div>
															<div class="col-lg-8">
																<input id="uom" type="text" name="txt_new_uom" class="form-control uom">
																<div class="uom_list" style="position:absolute; width: 90%;"></div>
															</div>
														</div>
													</div>
												</div>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
												<button type="submit" class="btn btn-primary">Save</button>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
						<div id="table-full">
							