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
				<h3><b>"STOCK CONTROL"</b></h3>
			</div>
			<div class="col-md-2" align="center">
				<h3 class="pull-right">
					<a data-toggle="tooltip" data-placement="left" title="Export All Data to Excel File" href="<?php echo base_url('StockControl/stock-control-new/monitoring_kekurangan')?>" class="btn btn-xs btn-primary faa-parent animated-hover"><i class="fa fa-file-excel-o faa-flash"></i></a>
					<a data-toggle="tooltip" data-placement="left" title="Export All Data to PDF File" href="<?php echo base_url('StockControl/stock-control-new/monitoring_kekurangan')?>" class="btn btn-xs btn-primary faa-parent animated-hover"><i class="fa fa-file-pdf-o faa-flash"></i></a>
					<span data-toggle="tooltip" data-placement="left" title="Refresh" onclick="window.location.reload()" class="btn btn-xs btn-success faa-parent animated-hover"><i class="fa fa-refresh faa-spin"></i></span>
					<a data-toggle="tooltip" data-placement="left" title="Close Monitoring" href="<?php echo site_url('StockControl/stock-control-new')?>" class="btn btn-xs btn-danger faa-parent animated-hover"><i class="fa fa-close faa-flash"></i></a>
				</h3>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-6">
				<form id="filter-form" method="post">
					<div class="form-group">
						<div class="row" style="margin: 10px 10px">
							<div class="col-lg-2">
								<label class="control-label">Area</label>
							</div>
							<div class="col-lg-10">
								<select class="form-control select2" name="txt_area" data-placeholder="Pilih Salah Satu!">
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
							<div class="col-lg-2">
								<label class="control-label">Sub Assy</label>
							</div>
							<div class="col-lg-10">
								<select class="form-control select2" name="txt_subassy" data-placeholder="Pilih Salah Satu!" disabled>
									<option></option>
									<option>All</option>
									<?php
										foreach ($subassy as $subassy) {
									?>
										<option><?php echo $subassy['subassy_desc'] ?></option>
									<?php
										}
									?>
								</select>
							</div>
						</div>
						<div class="row" style="margin: 10px 10px">
							<div class="col-lg-2">
								<label class="control-label">Periode</label>
							</div>
							<div class="col-lg-9">
								<div class="row">
									<div class="col-lg-6">
										<input type="text" class="form-control filter_from" placeholder="From" name="txt_date_from" value="<?php echo $from ?>" disabled required></input>
									</div>
									<div class="col-lg-6">
										<input type="text" class="form-control filter_to" placeholder="To" name="txt_date_to" value="<?php echo $to ?>" disabled required></input>
									</div>
								</div>
							</div>
							<div class="col-lg-1" id="loadingImage">
							</div>
						</div>
					</div>
				</form>
			</div>
			<div class="col-lg-3">
				<div class="row" style="margin: 10px 10px;vertical-align: middle">
					<div class="col-lg-3" style="">
						<div style="background-color: #008d4c;" class="color-palette"></div>
					</div>
					<div class="col-lg-9">
						LENGKAP
					</div>
				</div>
				<div class="row" style="margin: 10px 10px;vertical-align: middle">
					<div class="col-lg-3" style="">
						<div style="background-color: #d33724;" class="color-palette"></div>
					</div>
					<div class="col-lg-9">
						KURANG
					</div>
				</div>
				<div class="row" style="margin: 10px 10px;vertical-align: middle">
					<div class="col-lg-3" style="">
						<div style="background-color: #357ca5;" class="color-palette"></div>
					</div>
					<div class="col-lg-9">
						DILENGKAPI
					</div>
				</div>
				<div class="row" style="margin: 10px 10px;vertical-align: middle">
					<div class="col-lg-3" style="">
						<div style="background-color: #db8b0b;" class="color-palette"></div>
					</div>
					<div class="col-lg-9">
						ON PPIC
					</div>
				</div>
			</div>
			<div class="col-lg-3">
				<div class="row" style="margin: 10px 10px;vertical-align: middle">
					<div class="col-lg-3" style="">
						<div style="background-color: #D81B60;" class="color-palette"></div>
					</div>
					<div class="col-lg-9">
						PPIC READY
					</div>
				</div>
				<div class="row" style="margin: 10px 10px;vertical-align: middle">
					<div class="col-lg-3" style="">
						<div style="background-color: #39CCCC;" class="color-palette"></div>
					</div>
					<div class="col-lg-9">
						GUDANG READY
					</div>
				</div>
				<div class="row" style="margin: 10px 10px;vertical-align: middle">
					<div class="col-lg-3" style="">
						<div style="background-color: #001a35;" class="color-palette"></div>
					</div>
					<div class="col-lg-9">
						WIP
					</div>
				</div>
				<div class="row" style="margin: 10px 10px;vertical-align: middle">
					<div class="col-lg-3" style="">
						<div style="background-color: #555299;" class="color-palette"></div>
					</div>
					<div class="col-lg-9">
						NEW
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<div class="table-responsive">
					<fieldset class="row2" style="background:#ECF7FF;">
						<div id="table-full">
							