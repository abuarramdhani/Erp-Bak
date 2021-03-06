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
	</head>
	<body class="hold-transition skin-blue-light sidebar-mini" style="background-color: #ECF7FF">
		<header class="main-header">
		</header>
		
		<!-- HEADER -->
	<div class="container-fluid">
		<div class="row" style="margin-bottom: 20px;">
			
			<div class="col-md-8 col-md-offset-2" align="center">
				<h3><b>"MONITORING KEKURANGAN KOMPONEN"</b></h3>
			</div>
			<div class="col-md-2" align="center">
				<h3 class="pull-right">
					<button id="export_excel" data-toggle="tooltip" data-placement="left" title="Export All Data to Excel File" class="btn btn-xs btn-primary faa-parent animated-hover"><i class="fa fa-file-excel-o faa-flash"></i></button>
					<button id="export_pdf" data-toggle="tooltip" data-placement="left" title="Export All Data to PDF File" class="btn btn-xs btn-primary faa-parent animated-hover"><i class="fa fa-file-pdf-o faa-flash"></i></button>
					<span data-toggle="tooltip" data-placement="left" title="Refresh" onclick="window.location.reload()" class="btn btn-xs btn-success faa-parent animated-hover"><i class="fa fa-refresh faa-spin"></i></span>
					<a data-toggle="tooltip" data-placement="left" title="Close Monitoring" href="<?php echo site_url('StockControl/stock-control-new')?>" class="btn btn-xs btn-danger faa-parent animated-hover"><i class="fa fa-close faa-flash"></i></a>
				</h3>
			</div>
		</div>
		<div class="row">
			<form id="filter_periode" method="post">
			<div class="form-group">
				<div class="row" style="margin: 10px 10px">
					<div class="col-lg-1">
						<label class="control-label">Periode</label>
					</div>
					<div class="col-lg-4">
						<div class="row">
							<div class="col-lg-6">
								<input type="text" class="form-control" placeholder="From" id="periode1" name="txt_date_from_kekurangan" value="<?php echo $from ?>" required></input>
							</div>
							<div class="col-lg-6">
								<input type="text" class="form-control" placeholder="To" id="periode2" name="txt_date_to_kekurangan" value="<?php echo $to ?>" required></input>
							</div>
						</div>
					</div>
					<div class="col-lg-1" id="loadingImage">
					</div>
				</div>
			</div>
			</form>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<div class="table-responsive">
					<fieldset class="row2" style="background:#ECF7FF;">
						<div id="table_div">