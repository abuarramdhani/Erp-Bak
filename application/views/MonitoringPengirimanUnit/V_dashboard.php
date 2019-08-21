<style type="text/css">
	#filter tr td{padding: 5px}
	.text-left span {
		font-size: 36px;
tr:first-child {background-color: #ffccf9;}
	}
.blink_me {
  animation: blinker 1.5s linear infinite;
}

@keyframes blinker {
  50% {
    opacity: 0;
  }
}

tr:first-child {
  font-weight: bold;
}

tr.danger td{
	 background-color: #eb3d34;
}

tr.hidden td{
	display: none;
}

</style>
<head> <meta http-equiv="refresh" content="30"/> </head>
<section class="content">
	<div class="inner" >
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="text-left ">
							<span><b><i class="fa fa-calendar"></i> List Pengiriman Marketing Unit</b></span>
						</div>
					</div>
				</div>
				<br />
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-body">
								<table id="tbListSubmit_unit" class="table table-striped table-bordered table-hover text-center">
									<thead>
										<tr class="bg-primary">
											<th class="text-center">No</th>
											<th class="text-center">No Shipment</th>
											<th class="text-center">Kendaraan</th>
											<th class="text-center">Estimasi Berangkat</th>
											<th class="text-center">Finish Good</th>
											<th class="text-center">Cabang Tujuan</th>
											<th class="text-center">Muatan</th>
											<th class="text-center">Full</th>
											<th class="text-center">Actual Loading </th>
											<th class="text-center">Actual Depart </th>
										</tr>
									</thead>
									<tbody id="blinking_td">
										<?php $no=1; foreach($kirim as $k) { ?>

											<?php if ($k['actual_berangkat'] == NULL && $k['berangkat'] < date('Y-m-d H:i:s')) { ?>
												<tr class ="danger">
											<?php }elseif ($k['actual_berangkat'] != "" ) { ?>
												<tr class ="hidden">
											<?php }else{ ?>
												<tr>
											<?php } ?>

											<td><?php echo $no ?> </td>
											<td><?php echo  $k['no_shipment'] ?></td>
											<td><?php echo  $k['jenis_kendaraan'] ?></td>
											<td><?php echo  $k['berangkat'] ?></td>
											<td><?php echo  $k['asal_gudang'] ?></td>
											<td><?php echo  $k['cabang'] ?></td>
											<td><?php echo  $k['muatan'] ?></td>
											<td><?php echo  $k['status'] ?></td>
											<td id="actual_loading_td"><?php echo  $k['actual_loading'] ?></td>
											<td id="actual_brkt_td"><?php echo  $k['actual_berangkat'] ?> </td>
										</tr>
										<?php $no++; } ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>