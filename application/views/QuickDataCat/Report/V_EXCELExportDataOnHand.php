<!-- AdminLTE -->
		<!-- Bootstrap 3.3.5 -->
		<link href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet">
		<!-- DATA TABLES -->
        <link href="<?php echo base_url('assets/plugins/datatables/dataTables.bootstrap.css');?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url('assets/plugins/datatables/buttons.dataTables.min.css');?>" rel="stylesheet" type="text/css" />
		</head>

<?php
header("Content-Type:application/vnd.ms-excel");
header('Content-Disposition:attachment; filename="datastockcat.xls"');
?>

	<h3 align="center" > DATA ON HAND </h3>
	<h4 align="center" >Periode </h4>
<table id="tabelcari" class="table table-striped table-bordered table-hover text-left" style="font-size:12px;">
								<thead>
									<tr class="bg-primary">
										<td width="1%" rowspan="2"><center><b>NO</center></td>
										<td width="4%" rowspan="2"><center><b>KODE CAT</center></td>
										<td width="10%" rowspan="2"><center><b>DESCRIPTION</center></td>
										<td width="4%"><center><b>ON HAND</center></td>
									</tr>
									<tr class="bg-primary">
										<td width="2%"><center><b>TGL EXPIRED</center></td>
										<td width="2%"><center><b>QTY</center></td>
									</tr>
								</thead>
								<tbody>
								<?php
									$no = 1;
									foreach ($data_stok_onhand as $oh) {
								?>
									<tr>
										<td><?php echo $no++ ?></td>
										<td><?php echo $oh['paint_code'] ?></td>
										<td><?php echo $oh['paint_description'] ?></td>
										<td><?php echo $oh['expired_date'] ?></td>
										<td><?php echo $oh['on_hand'] ?></td>
									</tr>
								<?php
									}
								?>
								</tbody>
							</table>
							</div>