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
					<a data-toggle="tooltip" data-placement="left" title="Export All Data to Excel File" href="<?php echo base_url('StockControl/stock-control-new/export_excel')?>" class="btn btn-xs btn-primary faa-parent animated-hover"><i class="fa fa-file-excel-o faa-flash"></i></a>
					<a data-toggle="tooltip" data-placement="left" title="Export All Data to PDF File" href="<?php echo base_url('StockControl/stock-control-new/export_pdf')?>" class="btn btn-xs btn-primary faa-parent animated-hover"><i class="fa fa-file-pdf-o faa-flash"></i></a>
					<span data-toggle="tooltip" data-placement="left" title="Refresh" onclick="window.location.reload()" class="btn btn-xs btn-success faa-parent animated-hover"><i class="fa fa-refresh faa-spin"></i></span>
					<a data-toggle="tooltip" data-placement="left" title="Close Monitoring" href="<?php echo site_url('StockControl/stock-control-new')?>" class="btn btn-xs btn-danger faa-parent animated-hover"><i class="fa fa-close faa-flash"></i></a>
				</h3>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<div class="table-responsive">
					<fieldset class="row2" style="background:#ECF7FF;">
						<table width="100%" class="table table-hover table-striped table-bordered" id="monitoring-kekurangan" style="font-size:12px;">
							<thead class="bg-primary">
								<tr>
									<td rowspan="2" style="width: 20px;text-align: center; vertical-align : middle">
										<div style="width: 20px;text-align: center;margin: 0 auto">
											<b>NO</b>
										</div>
									</td>
									<!--
									<td rowspan="2" style="width: 95px;text-align: center; vertical-align : middle">
										<div style="width: 95px;text-align: center;margin: 0 auto">
											<b>AREA</b>
										</div>
									</td>
									<td rowspan="2" style="width: 95px;text-align: center; vertical-align : middle">
										<div style="width: 95px;text-align: center;margin: 0 auto">
											<b>SUBASSY</b>
										</div>
									</td>
									-->
									<td rowspan="2" style="width: 95px;text-align: center; vertical-align : middle">
										<div style="width: 95px;text-align: center;margin: 0 auto">
											<b>KODE</b>
										</div>
									</td>
									<td rowspan="2" style="width: 100px;text-align: center; vertical-align : middle">
										<div style="width: 100px;text-align: center;margin: 0 auto">
											<b>KOMPONEN</b>
										</div>
									</td>
									<td rowspan="2" style="width: 30px;text-align: center; vertical-align : middle">
										<div style="width: 30px;text-align: center;margin: 0 auto">
											<b>PER UNIT</b>
										</div>
									</td>
									
								<?php
									foreach ($periode as $per) {
								?>
									<td colspan="4" style="text-align: center; vertical-align : middle">
										<div>
											<b><?php echo date('Y-m-d', strtotime($per['plan_date'])) ?></b>
										</div>
									</td>
								<?php
									}
								?>
								</tr>
								<tr>
								<?php
									$col = 1;
									foreach ($periode as $per) {
										$col++;
								?>
									<td style="text-align: center; vertical-align : middle;font-size: 10px">
										
											<b>QTY NEEDED</b>
										
									</td>
									<td style="text-align: center; vertical-align : middle;font-size: 10px">
									
											<b>QTY ACTUAL</b>
									
									</td>
									<td style="text-align: center; vertical-align : middle;background-color: #e9897e;font-size: 10px">
										
											<b>QTY KURANG</b>
										
									</td>
									<td style="text-align: center; vertical-align : middle;font-size: 10px">
										
											<b>STATUS</b>
										
									</td>
								<?php
									}
								?>
								</tr>
							</thead>
							<!-- Versi Datatable -->
							<!--
							<tbody>
								<?php
									$no=1;
									foreach ($component_list as $comp) {
								?>
								<tr>
									<td align="center"><?php echo $no; ?></td>
									<td><b><?php echo $comp['area']; ?></b></td>
									<td><b><?php echo $comp['subassy_desc']; ?></b></td>
									<td><?php echo $comp['component_code']; ?></td>
									<td><?php echo $comp['component_desc']; ?></td>
									<td align="center" style="width: 30px;"><div style="width: 30px;text-align: center;margin: 0 auto"><?php echo $comp['qty_component_needed']; ?></div></td>
									<?php
										foreach ($periode as $per) {
											if (empty(${'data_'.$comp['master_data_id'].'_'.$per['plan_id']})) {
												$qty_needed = '-';
												$qty_actual = '-';
												$qty_kurang = '-';
												$status = '-';
											}
											foreach (${'data_'.$comp['master_data_id'].'_'.$per['plan_id']} as $tr_status) {
												$qty_needed = $tr_status['qty_plan']*$tr_status['qty_component_needed'];
												$qty_actual = $tr_status['qty'];
												$qty_kurang = ($tr_status['qty_plan']*$tr_status['qty_component_needed'])-$tr_status['qty'];
												$status = $tr_status['status'];
											}
									?>
									<td align="center"><?php echo $qty_needed?></td>
									<td align="center"><?php echo $qty_actual?></td>
									<td align="center" style="background-color: #FFD1CB"><?php echo $qty_kurang?></td>
									<td align="center"><?php echo $status?></td>
								<?php
										}
									$no++;
									}
								?>
								</tr>
							</tbody>
							-->
							<!-- Versi Datatable.end -->

							<!-- Versi Lain -->
							
							<tbody>
								<?php
									foreach ($area_list as $ar) {
								?>
								<tr>
									<td colspan="4" align="center" style="width:240px;background-color: #cecece">
										<div style="width: 240px">
											<b>AREA <?php echo $ar['area']; ?></b>
										</div>
									</td>
									<td style="display: none"></td>
									<td style="display: none"></td>
									<td style="display: none"></td>
									<?php
										foreach ($periode as $per) {
									?>
									<td></td>
									<td></td>
									<td style="background-color: #FFD1CB"></td>
									<td></td>
									<?php
										}
									?>
								</tr>
								<?php
										foreach ($subassy_list as $sub) {
											if ($sub['area'] == $ar['area']) {
												if ($sub['subassy_desc'] != '') {
								?>
								<tr>
									<td colspan="4">
										<b><?php 
											$no = 1;
											echo $sub['subassy_desc'];
										?></b>
									</td>
									<td style="display: none"></td>
									<td style="display: none"></td>
									<td style="display: none"></td>
									<?php
										foreach ($periode as $per) {
									?>
									<td></td>
									<td></td>
									<td style="background-color: #FFD1CB"></td>
									<td></td>
									<?php
											}
										}
									?>
								</tr>
								<?php
												foreach ($component_list as $comp) {
													if ($comp['subassy_desc'] == $sub['subassy_desc']) {
								?>
								<tr>
									<td align="center"><?php echo $no; ?></td>
									<td><?php echo $comp['component_code']; ?></td>
									<td><?php echo $comp['component_desc']; ?></td>
									<td align="center" style="width: 30px;"><div style="width: 30px;text-align: center;margin: 0 auto"><?php echo $comp['qty_component_needed']; ?></div></td>
								<?php
														foreach ($periode as $per) {
															//if ($per['plan_date'] == $comp['plan_date']) {
																${'data_'.$comp['master_data_id'].'_'.$per['plan_id']} = $this->M_stock_control_new->transaction_export($comp['master_data_id'],$per['plan_id']);
																if (empty(${'data_'.$comp['master_data_id'].'_'.$per['plan_id']})) {
																	$qty_needed = '-';
																	$qty_actual = '-';
																	$qty_kurang = '-';
																	$status = '-';
																}
																foreach (${'data_'.$comp['master_data_id'].'_'.$per['plan_id']} as $tr_status) {
																	$qty_needed = $tr_status['qty_plan']*$tr_status['qty_component_needed'];
																	$qty_actual = $tr_status['qty'];
																	$qty_kurang = ($tr_status['qty_plan']*$tr_status['qty_component_needed'])-$tr_status['qty'];
																	$status = $tr_status['status'];
																}
								?>
									<td align="center"><?php echo $qty_needed?></td>
									<td align="center"><?php echo $qty_actual?></td>
									<td align="center" style="background-color: #FFD1CB"><?php echo $qty_kurang?></td>
									<td align="center"><?php echo $status?></td>
								<?php
															}
														$no++;
								?>
								</tr>
								
								<?php
													}
												}
											}
										}
									}
								?>
							</tbody>
							
							<!--Versi Lain.end-->
						</table>
						<div class="clear"></div>
					</fieldset>
				</div>
			</div>
		</div>
		<!-- SCRIPT -->
		
		<script src="<?php echo base_url('assets/plugins/modernizr-2.6.2-respond-1.1.0.min.js');?>" type="text/javascript"></script>
		<script src="<?php echo base_url('assets/plugins/slimScroll/jquery.slimscroll.min.js');?>" type="text/javascript"></script>
		<script src="<?php echo base_url('assets/plugins/fastclick/fastclick.min.js');?>" type="text/javascript"></script>
		<script src="<?php echo base_url('assets/theme/js/app.min.js');?>" type="text/javascript"></script>
		<script src="<?php echo base_url('assets/plugins/dataTables/jquery.dataTables.js');?>"></script>
		<script src="<?php echo base_url('assets/plugins/dataTables/dataTables.bootstrap.js');?>"></script>
		<script src="<?php echo base_url('assets/js/custom.js');?>" type="text/javascript"></script>
		<script src="<?php echo base_url('assets/js/jquery-maskmoney.js');?>" type="text/javascript"></script>
		<script src="<?php echo base_url('assets/plugins/uniform/jquery.uniform.min.js');?>"></script>
		<script src="<?php echo base_url('assets/plugins/inputlimiter/jquery.inputlimiter.1.3.1.min.js');?>"></script>
		<script src="<?php echo base_url('assets/plugins/select2/select2.full.min.js');?>"></script>
		<script src="<?php echo base_url('assets/plugins/chosen/chosen.jquery.min.js');?>"></script>
		<script src="<?php echo base_url('assets/plugins/colorpicker/js/bootstrap-colorpicker.js');?>"></script>
		<script src="<?php echo base_url('assets/plugins/tagsinput/jquery.tagsinput.min.js');?>"></script>
		<script src="<?php echo base_url('assets/plugins/validVal/js/jquery.validVal.min.js');?>"></script>
		<script src="<?php echo base_url('assets/plugins/daterangepicker-master/moment.min.js');?>"></script>
		<script src="<?php echo base_url('assets/plugins/datepicker/js/bootstrap-datepicker.js');?>"></script>
		<script src="<?php echo base_url('assets/plugins/daterangepicker-master/daterangepicker.js');?>"></script>
		<script src="<?php echo base_url('assets/plugins/timepicker/js/bootstrap-timepicker.min.js');?>"></script>
		<script src="<?php echo base_url('assets/plugins/switch/static/js/bootstrap-switch.min.js');?>"></script>
		<script src="<?php echo base_url('assets/plugins/jquery.dualListbox-1.3/jquery.dualListBox-1.3.min.js');?>"></script>
		<script src="<?php echo base_url('assets/plugins/autosize/jquery.autosize.min.js');?>"></script>
		<script src="<?php echo base_url('assets/plugins/jasny/js/bootstrap-inputmask.js');?>"></script>
		<script src="<?php echo base_url('assets/plugins/jquery-validation-1.11.1/dist/jquery.validate.min.js');?>"></script>
		<script src="<?php echo base_url('assets/plugins/validator/bootstrapValidator.min.js');?>"></script>
		<script src="<?php echo base_url('assets/plugins/validator/bootstrapValidator.js');?>"></script>
		<script src="<?php echo base_url('assets/plugins/jquery.mask.js');?>"></script>
		<script type="text/javascript" src="<?php echo base_url('assets/theme/js/app.min.js')?>"></script>
		<script type="text/javascript" src="<?php echo base_url('assets/js/slider.js')?>"></script>
		<script type="text/javascript">
			var baseurl = "<?php echo base_url() ?>";

			var table = $('#monitoring-kekurangan').DataTable({
				responsive: true,
				"scrollX": true,
				scrollCollapse: true,
				"lengthChange": false,
				"dom": 'tp',
				"info": false,
				"paging": false,
				"ordering": false,
				language: {
					search: "_INPUT_",
				},
				/*
				"columnDefs": [
		            { "visible": false, "targets": 1 },
		            { "visible": false, "targets": 2 },
		        ],
		        "drawCallback": function ( settings ) {
		            var api = this.api();
		            var rows = api.rows( {page:'current'} ).nodes();
		            var last=null;
		 
		            api.column(1, {page:'current'} ).data().each( function ( group, i ) {
		                if ( last !== group ) {
		                    $(rows).eq( i ).before(
		                        '<tr><td colspan="<?php echo ($col*4)+4; ?>" align="left" style="background-color: #cecece">'+group+'</td></tr>'
		                    );
		 
		                    last = group;
		                }
		            } );

		            api.column(2, {page:'current'} ).data().each( function ( group, i ) {
		                if ( last !== group ) {
		                    $(rows).eq( i ).before(
		                        '<tr class="group"><td colspan="<?php echo ($col*4)+4; ?>">&emsp;&emsp;'+group+'</td></tr>'
		                    );

		                    last = group;
		                }
		            } );
		        }*/
		        
			});

			setTimeout(function () {
				window.location.reload();
			},(900000));
		</script>
	</body>
</html>