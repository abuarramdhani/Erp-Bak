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

thead.toscahead tr th {
        background-color: #5f6769;
       	font-family: sans-serif;
      }

      .itsfun1 {
        border-top-color: #5f6769;
      }

</style>
<!-- <head> <meta http-equiv="refresh" content="30"/> </head> -->
<form action="<?php echo base_url('ShipmentMonitoringSystem/ShipmentHistory/export') ?>" method="post">
<section class="content">
	<div class="inner" >
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="text-left ">
							<span style="font-family: sans-serif;"><b><i class="fa fa-clock-o"></i> List Shipment History</b></span>
						</div>
						<div class="col-lg-12">
							<button type="submit" style="color: white;" class="btn btn-success pull-right" id="btnExportShp">Export Excel</button>
						</div>
					</div>
				</div>
				<br />
				<div class="row">
					<div class="col-lg-12">
						<div class="box itsfun1">
					  		<div class="box-header with-border">
					  			<div class="text-left">
					  				<span style="font-family: sans-serif;font-size:16px;"><i class="fa fa-bookmark" style="color: #ffc400"></i> List Semua Shipment Terdahulu</span> 
					  			</div>
					  		</div>
								<div class="box-body">
									<table style="width: 100%" id="table-history" class="table table-striped table-bordered table-hover table-historysms text-center">
	<thead class="toscahead">
										<tr class="bg-primary">
											<th style="width: 3%;"  class="text-center">No</th>
											<th style="width: 5%;"  class="text-center">No Shipment</th>
											<th style="width: 7%;" class="text-center">Kendaraan</th>
											<th style="width: 10%;" class="text-center">Estimasi Berangkat</th>
											<th style="width: 10%;" class="text-center">Estimasi Loading</th>
											<th style="width: 10%;" class="text-center">Actual Berangkat</th>
											<th style="width: 7%;" class="text-center">Finish Good</th>
											<th style="width: 8%;" class="text-center">Cabang Tujuan</th>
											<th style="width: 25%;" class="text-center">Muatan</th>
											<th style="width: 5%;"  class="text-center">Full</th>
											<th style="width: 10%;" class="text-center">Creation Date</th>
											<th style="width: 10%;" class="text-center">Nomor DO</th>
											<th style="width: 10%;" class="text-center">Nomor SPB</th>
											<th style="width: 10%;" class="text-center">Created by</th>
											<!-- <th style="width: 10%;" class="text-center">Action</th> -->
										</tr>
									</thead>
									<tbody>
										<?php $no=1; foreach($find as $k) { ?>
										<tr>
											<td><?php echo $no ?> </td>
											<td><?php echo  $k['no_shipment'] ?></td>
											<td><?php echo  $k['jenis_kendaraan'] ?></td>
											<td><?php echo  $k['berangkat'] ?></td>
											<td><?php echo  $k['loading'] ?></td>
											<?php if ($k['actual_loading'] == NULL) { ?>
											<td style="background-color: #fd7979;"></td>
											<?php }else{ ?>
											<td><?php echo $k['actual_loading'] ?></td>
											<?php } ?>
											<td><?php echo  $k['asal_gudang'] ?></td>
											<?php if (!empty($k['cabang'])) { ?>											
											<td><?php echo  $k['cabang'] ?></td>
											<?php }else if (empty($k['cabang'])) { ?>
											<td><?php echo  $k['tujuan'] ?></td>
											<?php } ?>
											<td><?php echo  $k['muatan'] ?></td>
											<?php if ($k['status'] == NULL) { ?>
											<td>UNCONFIRMED</td>
											<?php }else{ ?>
											<td><?php echo $k['status'] ?> </td>
											<?php }?>
											<td><?php echo  $k['creation_date'] ?></td>
											<td><?php echo  $k['no_do'] ?></td>
											<td><?php echo  $k['no_spb'] ?></td>
											<td><?php echo  $k['created_by'] ?></td>

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
</form>

