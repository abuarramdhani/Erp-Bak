<!-- AdminLTE -->
		<!-- Bootstrap 3.3.5 -->
		<link href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet">
		<!-- DATA TABLES -->
        <link href="<?php echo base_url('assets/plugins/datatables/dataTables.bootstrap.css');?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url('assets/plugins/datatables/buttons.dataTables.min.css');?>" rel="stylesheet" type="text/css" />
		</head>


	<h3 align="center" > DATA STOCK CAT </h3>
	<h4 align="center" >Periode </h4>
<table id="tabelcari" class="table table-striped table-bordered table-hover text-left" style="font-size:12px;">
								<thead>
									<tr class="bg-primary">
										<td width="1%"><center><b>NO</center></td>
										<td width="4%"><center><b>KODE CAT</center></td>
										<td width="10%"><center><b>DESCRIPTION</center></td>
										<td width="4%"><center><b>TGL EXPIRED</center></td>
										<td width="2%"><center><b>QTY</center></td>
										<td width="2%"><center><b>UOM</center></td>
										<td width="4%"><center><b>BUKTI & NO BUKTI</center></td>
										<td width="4%"><center><b>PETUGAS</center></td>
										<td width="4%"><center><b>KETERANGAN</center></td>
									</tr>
								</thead>
								<tbody>
								<?php
									$no = 1;
									foreach ($getDataCat as $msk) {
										if($msk['on_hand'] == ''){
											$keterangan = 'Cat Masuk';
										}
										else{
											$keterangan = 'Cat Keluar';
										}
								?>
									<tr>
										<td><?php echo $no++ ?></td>
										<td><?php echo $msk['paint_code'] ?></td>
										<td><?php echo $msk['paint_description'] ?></td>
										<td><?php echo $msk['expired_date'] ?></td>
										<td><?php echo $msk['quantity'] ?></td>
										<td><?php echo "pcs"; ?></td>
										<td><?php echo $msk['evidence_number'] ?></td>
										<td><?php echo $msk['employee'] ?></td>
										<td><?php echo $keterangan ?></td>
									</tr>
								<?php
									}
								?>
								</tbody>
							</table>
							</div>