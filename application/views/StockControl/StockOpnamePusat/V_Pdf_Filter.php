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
	<!--<link href="<?php echo base_url('assets/css/font-awesome-animation.min.css') ?>" rel="stylesheet" type="text/css" />-->
		<link href="<?php echo base_url('assets/plugins/ionicons/css/ionicons.min.css') ?>" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url('assets/theme/css/skins/skin-blue-light.min.css') ?>" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" href="<?php echo base_url('assets/plugins/daterangepicker-master/daterangepicker.css');?>" />
		<script src="<?php echo base_url('assets/plugins/jquery-2.1.4.min.js');?>" type="text/javascript"></script>
		<script src="<?php echo base_url('assets/plugins/jQueryUI/jquery-ui.min.js');?>" type="text/javascript"></script>
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
					<span data-toggle="tooltip" data-placement="left" title="Back" onclick="window.history.back()" class="btn btn-xs btn-primary faa-parent animated-hover"><i class="fa fa-arrow-left faa-spin"></i></span>
					<span data-toggle="tooltip" data-placement="left" title="Refresh" onclick="window.location.reload()" class="btn btn-xs btn-success faa-parent animated-hover"><i class="fa fa-refresh faa-spin"></i></span>
					<a data-toggle="tooltip" data-placement="left" title="Close Monitoring" href="<?php echo site_url('StockControl/stock-opname-pusat')?>" class="btn btn-xs btn-danger faa-parent animated-hover"><i class="fa fa-close faa-flash"></i></a>
				</h3>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-6 col-lg-offset-3">
				<form id="filter-form" method="post" action="<?php echo base_url('StockControl/stock-opname-pusat/export_pdf') ?>">
					<div class="form-group">
						<div class="row" style="margin: 10px 10px">
							<div class="col-lg-3">
								<label class="control-label">IO</label>
							</div>
							<div class="col-lg-9">
								<select class="form-control select2" name="txt_pdf_io_name" data-placeholder="Pilih Salah Satu!">
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
								<select class="form-control select2" name="txt_pdf_sub_inventory" data-placeholder="Pilih Salah Satu!">
									<option></option>
									<option>All</option>
									<?php
										foreach ($sub_inventory as $sub_inventory) {
									?>
										<option><?php echo $sub_inventory['sub_inventory'] ?></option>
									<?php
										}
									?>
								</select>
							</div>
						</div>
						<div class="row" style="margin: 10px 10px">
							<div class="col-lg-3">
								<label class="control-label">Area</label>
							</div>
							<div class="col-lg-9">
								<select class="form-control select2" name="txt_pdf_area_pusat" data-placeholder="Pilih Salah Satu!">
									<option></option>
									<option>All</option>
									<?php
										foreach ($area as $area) {
									?>
										<option><?php echo $area['area'] ?></option>
									<?php
										}
									?>
								</select>
							</div>
						</div>
						<div class="row" style="margin: 10px 10px">
							<div class="col-lg-3">
								<label class="control-label">Locator</label>
							</div>
							<div class="col-lg-9">
								<select class="form-control select2" name="txt_pdf_locator" data-placeholder="Pilih Salah Satu!">
									<option></option>
									<option>All</option>
									<?php
										foreach ($locator as $locator) {
									?>
										<option><?php echo $locator['locator'] ?></option>
									<?php
										}
									?>
								</select>
							</div>
						</div>
						<div class="row" style="margin: 10px 10px">
							<div class="col-lg-3">
								<label class="control-label">Tanggal SO</label>
							</div>
							<div class="col-lg-9">
								<input type="text" name="txt_pdf_tgl_so" class="form-control tgl-so">
							</div>
						</div>
						<div class="row" style="margin: 10px 10px">
							<div class="col-lg-12">
								<button type="submit" class="btn btn-primary btn-lg pull-right">Print to PDF</button>
							</div>
						</div>
					</div>
				</form>
			</div>
			
		</div>
		<div class="row">
			<div class="col-lg-12">
				<div class="table-responsive">
					<fieldset class="row2" style="background:#ECF7FF;">
						<div class="pull-right">
							<div id="loadingImage"></div>
						</div>
						<div id="table-full">
							