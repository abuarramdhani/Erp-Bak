<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11">
							<div class="text-right"><h1><b><?=$Title ?></b></h1></div>
						</div>
						<div class="col-lg-1">
							<a href="<?php echo site_url('TicketingMaintenance/Agent/OrderList') ?>" class="btn btn-default btn-lg">
								<span class="fa fa-file-text-o fa-2x"></span>
							</a>
						</div>
					</div>
				</div>
				<!---->
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-body">
								<ul class="nav nav-pills nav-justified">
								<li class="active"><a data-toggle="pill" href="#order_open">OPEN</a></li>
								<li><a data-toggle="pill" href="#order_acc">ACC</a></li>
								<li><a data-toggle="pill" href="#order_reviewed">REVIEWED</a></li>
								<li><a data-toggle="pill" href="#order_action">ACTION</a></li>
								<li><a data-toggle="pill" href="#order_overdue">OVERDUE</a></li>
								<li><a data-toggle="pill" href="#order_done">DONE</a></li>
								<li><a data-toggle="pill" href="#order_close">CLOSE</a></li>
								<li><a data-toggle="pill" href="#order_reject">REJECT</a></li>
							</ul>
							<div class="tab-content">
								<!--TAB OPEN-->
								<div id="order_open" class="tab-pane fade in active">
									<div class="row text-center">
										<div class="col-lg-12">
											<br>
											<div class="box box-primary box-solid">
													<div class="table-responsive">
													<div class="row" style="margin: 1px;">
														<div class="col-lg-12">
																<div class="box-header with-border">
																	<div class="row text-center"></div>
																	<label>Order Open</label>
																</div>
																<br>
																<!-- <form method="POST" action="<?php echo site_url('CateringManagement/Extra/EditTempatMakan/getShow'); ?>"> -->
																<table class="datatable table table-striped table-bordered table-hover text-left tblOrderListACC" id="tblOrderListACC" style="">
															<thead class="bg-primary">
																<tr>
																	<th class="text-center">No Order</th>
																	<th class="text-center">Tanggal Order</th>
																	<th class="text-center">Nama Mesin</th>
																	<th class="text-center">Kerusakan</th>
																	<th class="text-center">Action</th>
																</tr>
															</thead>
															<form action="" method="post">
															<tbody>
															<?php foreach ($order as $nganggur) {
															if ($nganggur['status_order'] !== 'open') {
																# code...
															}else{
															?>
																<tr>
																	<td class="text-center"><?= $nganggur['no_order']?></td>
																	<td class="text-center"><?= date("d-M-Y H:i:s", strtotime($nganggur['tgl_order']));?></td>
																	<td><?= $nganggur['nama_mesin']?></td>
																	<td><?= $nganggur['kerusakan']?></td>
																	<!-- <td class="text-center"><?= $nganggur['last_response']?></td> -->
																	<td style="text-align:center;">
                                                                    <a href="<?= base_url("TicketingMaintenance/Seksi/MyOrder/detail/". $nganggur['no_order']) ?>" class="btn btn-primary btn-sm"> <i class="fa fa-search"> Detail</i></a>
                                                                    <!-- <a href="<?= base_url("TicketingMaintenance/Agent/OrderList/detail/". $nganggur['no_order']) ?>" class="btn btn-primary btn-sm"> <i class="fa fa-search"> Detail</i></a> -->
                                                                    </td>
																</tr>
															<?php } } ?>
															</tbody>
															<!-- </form> -->
														</table>
												 </div>
													</div>
												</div>
										</div>
									</div>
								</div>
							</div>

								<!--TAB ACC-->
								<div id="order_acc" class="tab-pane fade">
									<div class="row text-center">
										<div class="col-lg-12">
											<br>
											<div class="box box-primary box-solid">
													<div class="table-responsive">
													<div class="row" style="margin: 1px;">
														<div class="col-lg-12">
																<div class="box-header with-border">
																	<div class="row text-center" ></div>
																	<label>Order ACC</label>
																</div>
																<br>
																<!-- <form method="POST" action="<?php echo site_url('CateringManagement/Extra/EditTempatMakan/getShow'); ?>"> -->
																<table class="datatable table table-striped table-bordered table-hover text-left tblOrderListACC" id="tblOrderListACC" style="">
															<thead class="bg-green">
																<tr>
																	<th class="text-center">No Order</th>
																	<th class="text-center">Tanggal Order</th>
																	<th class="text-center">Nama Mesin</th>
																	<th class="text-center">Kerusakan</th>
																	<th class="text-center">Last Response</th>
																	<th class="text-center">Action</th>
																</tr>
															</thead>
															<form action="" method="post">
															<tbody>
															<?php foreach ($order as $nganggur) {
															if ($nganggur['status_order'] == 'acc' && $nganggur['perkiraan_selesai'] >= date('Y-m-d')) {
																# code...
															// }else{
															?>
																<tr>
																	<td class="text-center"><?= $nganggur['no_order']?></td>
																	<td class="text-center"><?= date("d-M-Y H:i:s", strtotime($nganggur['tgl_order']));?></td>
																	<td><?= $nganggur['nama_mesin']?></td>
																	<td><?= $nganggur['kerusakan']?></td>
																	<td class="text-center"><?= date("d-M-Y H:i:s", strtotime($nganggur['last_response']));?></td>
																	<td style="text-align:center;">
                                                                    <a href="<?= base_url("TicketingMaintenance/Seksi/MyOrder/detail/". $nganggur['no_order']) ?>" class="btn btn-primary btn-sm"> <i class="fa fa-search"> Detail</i></a>
                                                                    <!-- <a href="<?= base_url("TicketingMaintenance/Agent/OrderList/detail/". $nganggur['no_order']) ?>" class="btn btn-primary btn-sm"> <i class="fa fa-search"> Detail</i></a> -->
                                                                    </td>
																</tr>
															<?php } } ?>
															</tbody>
															<!-- </form> -->
														</table>
												 </div>
													</div>
												</div>
										</div>
									</div>
								</div>
							</div>

							<!--TAB REVIEWED-->
								<div id="order_reviewed" class="tab-pane fade">
									<div class="row text-center">
										<div class="col-lg-12">
											<br>
											<div class="box box-primary box-solid">
													<div class="table-responsive">
													<div class="row" style="margin: 1px;">
														<div class="col-lg-12">
																<div class="box-header with-border">
																	<div class="row text-center" ></div>
																	<label>Order Reviewed</label>
																</div>
																<br>
																<form method="POST" action="<?php echo site_url('CateringManagement/Extra/EditTempatMakan/getShow'); ?>">
																<table class="datatable table table-striped table-bordered table-hover text-left tblOrderListReviewed" id="tblOrderListReviewed" style="">
															<thead style="background-color:#3fc5f0;">
																<tr>
																	<th class="text-center">No Order</th>
																	<th class="text-center">Tanggal Order</th>
																	<th class="text-center">Nama Mesin</th>
																	<th class="text-center">Kerusakan</th>
																	<th class="text-center">Last Response</th>
																	<th class="text-center">Action</th>
																</tr>
															</thead>
															<form action="" method="post">
															<tbody>
															<?php foreach ($order as $nganggur) {
																if ($nganggur['status_order'] == 'reviewed' && $nganggur['perkiraan_selesai'] >= date('Y-m-d')) {
																	# code...
																// }else{
																?>
																<tr>
																	<td class="text-center"><?= $nganggur['no_order']?></td>
																	<td  class="text-center"><?= date("d-M-Y H:i:s", strtotime($nganggur['tgl_order']));?></td>
																	<td><?= $nganggur['nama_mesin']?></td>
																	<td><?= $nganggur['kerusakan']?></td>
																	<td class="text-center"><?= date("d-M-Y H:i:s", strtotime($nganggur['last_response']));?></td>
																	<td style="text-align:center;">
                                                                    <a href="<?= base_url("TicketingMaintenance/Seksi/MyOrder/detail/". $nganggur['no_order']) ?>" class="btn btn-primary btn-sm"> <i class="fa fa-search"> Detail</i></a>
                                                                    <!-- <a href="<?= base_url("TicketingMaintenance/Agent/OrderList/detail/". $nganggur['no_order']) ?>" class="btn btn-primary btn-sm"> <i class="fa fa-search"> Detail</i></a> -->
                                                                    </td>
																</tr>
															<?php } } ?>
															</tbody>
															</form>
														</table>
												 </div>
													</div>
												</div>
										</div>
									</div>

								</div>
							</div>

							<!--TAB ACTION-->
								<div id="order_action" class="tab-pane fade">
									<div class="row text-center">
										<div class="col-lg-12">
											<br>
											<div class="box box-primary box-solid">
													<div class="table-responsive">
													<div class="row" style="margin: 1px;">
														<div class="col-lg-12">
																<div class="box-header with-border">
																	<div class="row text-center" ></div>
																	<label>Order Action</label>
																</div>
																<br>
																<form method="POST" action="<?php echo site_url('CateringManagement/Extra/EditTempatMakan/getShow'); ?>">
																<table class="datatable table table-striped table-bordered table-hover text-left tblOrderListAction" id="tblOrderListAction" style="">
															<thead style="background-color:#6decb9;">
																<tr>
																	<th class="text-center">No Order</th>
																	<th class="text-center">Tanggal Order</th>
																	<th class="text-center">Nama Mesin</th>
																	<th class="text-center">Kerusakan</th>
																	<th class="text-center">Last Response</th>
																	<th class="text-center">Action</th>
																</tr>
															</thead>
															<form action="" method="post">
															<tbody>
															<?php foreach ($order as $nganggur) {
																if ($nganggur['status_order'] == 'action' && $nganggur['perkiraan_selesai'] >= date('Y-m-d')) {
																	# code...
																// }else{	
															?>
																<tr>
																	<td class="text-center"><?= $nganggur['no_order']?></td>
																	<td class="text-center"><?= date("d-M-Y H:i:s", strtotime($nganggur['tgl_order']));?></td>
																	<td><?= $nganggur['nama_mesin']?></td>
																	<td><?= $nganggur['kerusakan']?></td>
																	<td class="text-center"><?= date("d-M-Y H:i:s", strtotime($nganggur['last_response']));?></td>
																	<td style="text-align:center;">
                                                                    <a href="<?= base_url("TicketingMaintenance/Seksi/MyOrder/detail/". $nganggur['no_order']) ?>" class="btn btn-primary btn-sm"> <i class="fa fa-search"> Detail</i></a>
                                                                    <!-- <a href="<?= base_url("TicketingMaintenance/Agent/OrderList/detail/". $nganggur['no_order']) ?>" class="btn btn-primary btn-sm"> <i class="fa fa-search"> Detail</i></a> -->
                                                                    </td>
																</tr>
															<?php } } ?>
															</tbody>
															</form>
														</table>
												 </div>
													</div>
												</div>
										</div>
									</div>

								</div>
							</div>

							<!--TAB OVERDUE-->
								<div id="order_overdue" class="tab-pane fade">
									<div class="row text-center">
										<div class="col-lg-12">
											<br>
											<div class="box box-primary box-solid">
													<div class="table-responsive">
													<div class="row" style="margin: 1px;">
														<div class="col-lg-12">
																<div class="box-header with-border">
																	<div class="row text-center" ></div>
																	<label>Order Overdue</label>
																</div>
																<br>
																<form method="POST" action="<?php echo site_url('CateringManagement/Extra/EditTempatMakan/getShow'); ?>">
																<table class="datatable table table-striped table-bordered table-hover text-left tblOrderListOverdue" id="tblOrderListOverdue" style="">
															<thead style="background-color:#eef5b2;">
																<tr>
																	<th class="text-center">No Order</th>
																	<th class="text-center">Tanggal Order</th>
																	<th class="text-center">Nama Mesin</th>
																	<th class="text-center">Kerusakan</th>
																	<th class="text-center">Last Response</th>
																	<th class="text-center">Action</th>
																</tr>
															</thead>
															<form action="" method="post">
															<tbody>
															<?php foreach ($order as $nganggur) {
																if ($nganggur['perkiraan_selesai'] < date('Y-m-d') && $nganggur['status_order'] !== 'close' && $nganggur['status_order'] !== 'reject' && $nganggur['status_order'] !== 'open' && $nganggur['status_order'] !== 'done') {						
															?>
																<tr>
																	<td class="text-center"><?= $nganggur['no_order']?></td>
																	<td  class="text-center"><?= date("d-M-Y H:i:s", strtotime($nganggur['tgl_order']));?></td>
																	<td><?= $nganggur['nama_mesin']?></td>
																	<td><?= $nganggur['kerusakan']?></td>
																	<td class="text-center"><?= date("d-M-Y H:i:s", strtotime($nganggur['last_response']));?></td>
																	<td style="text-align:center;">
                                                                    <a href="<?= base_url("TicketingMaintenance/Seksi/MyOrder/detail/". $nganggur['no_order']) ?>" class="btn btn-primary btn-sm"> <i class="fa fa-search"> Detail</i></a>
                                                                    <!-- <a href="<?= base_url("TicketingMaintenance/Agent/OrderList/detail/". $nganggur['no_order']) ?>" class="btn btn-primary btn-sm"> <i class="fa fa-search"> Detail</i></a> -->
                                                                    </td>
																</tr>
															<?php } } ?>
															</tbody>
															</form>
														</table>
												 </div>
													</div>
												</div>
										</div>
									</div>

								</div>
							</div>

							<!--TAB DONE-->
								<div id="order_done" class="tab-pane fade">
									<div class="row text-center">
										<div class="col-lg-12">
											<br>
											<div class="box box-primary box-solid">
													<div class="table-responsive">
													<div class="row" style="margin: 1px;">
														<div class="col-lg-12">
																<div class="box-header with-border">
																	<div class="row text-center" ></div>
																	<label>Order Done</label>
																</div>
																	<br>
																<table class="datatable table table-striped table-bordered table-hover text-left tblOrderListDone" id="tblOrderListDone" style="">
															<thead style="background-color:#42dee1;">
																<tr>
																	<th class="text-center">No Order</th>
																	<th class="text-center">Tanggal Order</th>
																	<th class="text-center">Nama Mesin</th>
																	<th class="text-center">Kerusakan</th>
																	<th class="text-center">Last Response</th>
																	<th class="text-center">Action</th>
																</tr>
															</thead>
															<form action="" method="post">
															<tbody>
															<?php foreach ($order as $nganggur) {
																$tanggal_order_selesai = $nganggur['tgl_order_selesai'];
																$tos = explode(" ", $tanggal_order_selesai);
																$tanggal = $tos[0];
																$batas_order = date('Y-m-d', strtotime($tanggal. '+3 day'));	

																	if ($nganggur['status_order'] == 'done' && date('Y-m-d') < $batas_order) {
															?>
																<tr>
																	<td class="text-center"><?= $nganggur['no_order']?></td>
																	<td class="text-center"><?= date("d-M-Y H:i:s", strtotime($nganggur['tgl_order']));?></td>
																	<td><?= $nganggur['nama_mesin']?></td>
																	<td><?= $nganggur['kerusakan']?></td>
																	<td class="text-center"><?= date("d-M-Y H:i:s", strtotime($nganggur['last_response']));?></td>
																	<td style="text-align:center;">
																	<!-- href="<?= base_url("TicketingMaintenance/Seksi/MyOrder/closeOrder/".$nganggur['no_order']) ?>" -->
                                                                    <a class="btn btn-primary btn-sm" title="Detail Order" href="<?= base_url("TicketingMaintenance/Seksi/MyOrder/detail/". $nganggur['no_order']) ?>"><span class="fa fa-search"> Detail</span></a> 
                                                                    <a class="btn btn-danger btn-sm" title="Close Order" onclick="AreYouSureWantToCloseYourOrder(this)"><span class="fa fa-times"> Close</span></a> 
                                                                    </td>
																</tr>
															<?php } } ?>
															</tbody>
															</form>
														</table>
												 </div>
													</div>
												</div>
										</div>
									</div>

								</div>
							</div>

							<!--TAB CLOSE-->
								<div id="order_close" class="tab-pane fade">
									<div class="row text-center">
										<div class="col-lg-12">
											<br>
											<div class="box box-primary box-solid">
													<div class="table-responsive">
													<div class="row" style="margin: 1px;">
														<div class="col-lg-12">
																<div class="box-header with-border">
																	<div class="row text-center" ></div>
																	<label>Order Close</label>
																</div>
																	<br>
																<form method="POST" action="<?php echo site_url('CateringManagement/Extra/EditTempatMakan/getShow'); ?>">
																<table class="datatable table table-striped table-bordered table-hover text-left tblOrderListClose" id="tblOrderListClose" style="">
															<thead style="color:white">
																<tr>
																	<th class="text-center" style="background-color:black;">No Order</th>
																	<th class="text-center" style="background-color:black;">Tanggal Order</th>
																	<th class="text-center" style="background-color:black;">Nama Mesin</th>
																	<th class="text-center" style="background-color:black;">Kerusakan</th>
																	<th class="text-center" style="background-color:black;">Last Response</th>
																	<th class="text-center" style="background-color:black;">Action</th>
																</tr>
															</thead>
															<form action="" method="post">
															<tbody>
															<?php foreach ($order as $nganggur) {
																if ($nganggur['status_order'] == 'done') {
																	$tanggal_order_selesai = $nganggur['tgl_order_selesai'];
																	$tos = explode(" ", $tanggal_order_selesai);
																	$tanggal = $tos[0];
																	$batas_order = date('Y-m-d', strtotime($tanggal. '+3 day'));														
																}
																if ($nganggur['status_order'] == 'close' || $nganggur['status_order'] == 'done' || date('Y-m-d') < $batas_order && $nganggur['status_order'] != 'open') {
															?>
																<tr>
																	<td class="text-center"><?= $nganggur['no_order']?></td>
																	<td  class="text-center"><?= date("d-M-Y H:i:s", strtotime($nganggur['tgl_order']));?></td>
																	<td><?= $nganggur['nama_mesin']?></td>
																	<td><?= $nganggur['kerusakan']?></td>
																	<td class="text-center"><?= date("d-M-Y H:i:s", strtotime($nganggur['last_response']));?></td>
																	<td style="text-align:center;">
                                                                    <a href="<?= base_url("TicketingMaintenance/Seksi/MyOrder/detail/". $nganggur['no_order']) ?>" class="btn btn-primary btn-sm"> <i class="fa fa-search"> Detail</i></a>
                                                                    <!-- <a href="<?= base_url("TicketingMaintenance/Agent/OrderList/detail/". $nganggur['no_order']) ?>" class="btn btn-primary btn-sm"> <i class="fa fa-search"> Detail</i></a> -->
                                                                    </td>
																</tr>
															<?php } } ?>
															</tbody>
															</form>
														</table>
												 </div>
													</div>
												</div>
										</div>
									</div>

								</div>
							</div>

							<!--TAB REJECT-->
								<div id="order_reject" class="tab-pane fade">
									<div class="row text-center">
										<div class="col-lg-12">
											<br>
											<div class="box box-primary box-solid">
													<div class="table-responsive">
													<div class="row" style="margin: 1px;">
														<div class="col-lg-12">
																<div class="box-header with-border">
																	<div class="row text-center" ></div>
																	<label>Order Rejected</label>
																</div>
																<br>
																<form method="POST" action="<?php echo site_url('CateringManagement/Extra/EditTempatMakan/getShow'); ?>">
																<table class="datatable table table-striped table-bordered table-hover text-left tblOrderListRejected" id="tblOrderListRejected" style="">
															<thead style="background-color: #f0134d">
																<tr>
																	<th class="text-center" style="color:white;">No Order</th>
																	<th class="text-center" style="color:white;">Tanggal Order</th>
																	<th class="text-center" style="color:white;">Nama Mesin</th>
																	<th class="text-center" style="color:white;">Kerusakan</th>
																	<th class="text-center" style="color:white;">Last Response</th>
																	<th class="text-center" style="color:white;">Alasan Reject</th>
																	<th class="text-center" style="color:white;">Action</th>
																</tr>
															</thead>
															<form action="" method="post">
															<tbody>
															<?php foreach ($order as $nganggur) {
																if ($nganggur['status_order'] == 'reject') {
																	# code...
																// }else{
															?>
																<tr>
																	<td class="text-center"><?= $nganggur['no_order']?></td>
																	<td  class="text-center"><?= date("d-M-Y H:i:s", strtotime($nganggur['tgl_order']));?></td>
																	<td><?= $nganggur['nama_mesin']?></td>
																	<td><?= $nganggur['kerusakan']?></td>
																	<td class="text-center"><?= date("d-M-Y H:i:s", strtotime($nganggur['last_response']));?></td>
																	<td class="text-center"><?=$nganggur['alasan_reject']?></td>
																	<td style="text-align:center;">
                                                                    <a href="<?= base_url("TicketingMaintenance/Seksi/MyOrder/detail/". $nganggur['no_order']) ?>" class="btn btn-primary btn-sm"> <i class="fa fa-search"> Detail</i></a>
                                                                    <!-- <a href="<?= base_url("TicketingMaintenance/Agent/OrderList/detail/". $nganggur['no_order']) ?>" class="btn btn-primary btn-sm"> <i class="fa fa-search"> Detail</i></a> -->
                                                                    </td>
																</tr>
															<?php } } ?>
															</tbody>
															</form>
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
			</div>
		</div>
	</div>

</section>