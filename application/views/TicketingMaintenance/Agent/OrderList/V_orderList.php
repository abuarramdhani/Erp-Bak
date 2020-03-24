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
																	<div class="row text-center" ></div>
																	<label>Order Open</label>
																</div>
																<br>
																<form method="POST" action="<?php echo site_url('CateringManagement/Extra/EditTempatMakan/getShow'); ?>">
																<table class="datatable table table-striped table-bordered table-hover text-left" id="tblOrderListAgent" style="">
															<thead class="bg-primary">
																<tr>
																	<th class="text-center">No Order</th>
																	<th class="text-center">Tanggal Order</th>
																	<th class="text-center">Nama Mesin</th>
																	<th class="text-center">Kerusakan</th>
																	<th class="text-center">Pengorder</th>
																	<!-- <th class="text-center">Last Response</th> -->
																	<th class="text-center">Action</th>
																</tr>
															</thead>
															<form action="" method="post">
															<tbody>
															<?php foreach ($orderListWithName as $nganggur) {
															if ($nganggur['status_order'] !== 'open') {
															}else{
															?>
                                                <tr>
													<input type="hidden" name="noOrder<?= $nganggur['no_order']?>" id="noOrder<?= $nganggur['no_order']?>" value="<?= $nganggur['no_order']?>">
													<input type="hidden" name="no_OrderReject<?= $nganggur['no_order']?>" id="no_OrderReject<?= $nganggur['no_order']?>" value="<?= $nganggur['no_order']?>">
													<input type="hidden" name="namaMesin<?= $nganggur['no_order']?>" id="namaMesin<?= $nganggur['no_order']?>" value="<?= $nganggur['nama_mesin']?>">
													<input type="hidden" name="noMesin<?= $nganggur['no_order']?>" id="noMesin<?= $nganggur['no_order']?>" value="<?= $nganggur['nomor_mesin']?>">
													<input type="hidden" name="line<?= $nganggur['no_order']?>" id="line<?= $nganggur['no_order']?>" value="<?= $nganggur['line']?>">
													<input type="hidden" name="analisis<?= $nganggur['no_order']?>" id="analisis<?= $nganggur['no_order']?>" value="<?= $nganggur['kerusakan']?>">
													<input type="hidden" name="duedate<?= $nganggur['no_order']?>" id="duedate<?= $nganggur['no_order']?>" value="<?= $nganggur['need_by_date']?>">
													<input type="hidden" name="reason<?= $nganggur['no_order']?>" id="reason<?= $nganggur['no_order']?>" value="<?= $nganggur['reason_need_by_date']?>">
													<input type="hidden" name="kondisi<?= $nganggur['no_order']?>" id="kondisi<?= $nganggur['no_order']?>" value="<?= $nganggur['kondisi_mesin']?>">
													<input type="hidden" name="running_hour<?= $nganggur['no_order']?>" id="running_hour<?= $nganggur['no_order']?>" value="<?= $nganggur['running_hour']?>">

                                                    <td class="text-center"><?= $nganggur['no_order']?></td>
                                                    <td class="text-center"><?= date("d-M-Y H:i:s", strtotime($nganggur['tgl_order']));?></td>
                                                    <td><?= $nganggur['nama_mesin']?></td>
                                                    <td><?= $nganggur['kerusakan']?></td>
                                                    <td><?= $nganggur['seksi']." - ".$nganggur['name']?></td>
                                                    <td style="text-align:center;">
													<?php //echo $nganggur['no_order']; ?>
                                                        <a class="btn btn-success btn-sm modalApprove" data-toggle="modal" data-target="#ModalApprove" data-noOrder="<?php echo $nganggur['no_order']?>" title="Approve Order"><span class="fa fa-check"></span></a>
                                                        <a class="btn btn-danger btn-sm modalReject" title="Reject Order" data-toggle="modal" data-target="#ModalReject" data-no_OrderReject="<?php echo $nganggur['no_order']?>"><span class="fa fa-times"></span></a> 
                                                    <!-- <a href="<?= base_url("TicketingMaintenance/Agent/OrderList/detail/".$nganggur['no_order']) ?>" class="btn btn-primary btn-sm"> <i class="fa fa-search"> Detail</i></a> -->
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
																<form method="POST" action="<?php echo site_url('CateringManagement/Extra/EditTempatMakan/getShow'); ?>">
																<table class="datatable table table-striped table-bordered table-hover text-left tblOrderListACC" id="tblOrderListACC" style="">
															<thead class="bg-green">
																<tr>
																	<th class="text-center">No Order</th>
																	<th class="text-center">Tanggal Order</th>
																	<th class="text-center">Nama Mesin</th>
																	<th class="text-center">Kerusakan</th>
																	<th class="text-center">Pengorder</th>
																	<th class="text-center">Last Response</th>
																	<th class="text-center">Action</th>
																</tr>
															</thead>
															<form action="" method="post">
															<tbody>
															<?php foreach ($orderListWithName as $nganggur) {
															if ($nganggur['status_order'] == 'acc' && $nganggur['perkiraan_selesai'] >= date('Y-m-d')) {
															// }else{
															?>
																<tr>
																	<td class="text-center"><?= $nganggur['no_order']?></td>
																	<td class="text-center"><?= date("d-M-Y H:i:s", strtotime($nganggur['tgl_order']));?></td>
																	<td><?= $nganggur['nama_mesin']?></td>
																	<td><?= $nganggur['kerusakan']?></td>
																	<td><?= $nganggur['seksi']." - ".$nganggur['name']?></td>
																	<td class="text-center"><?= date("d-M-Y H:i:s", strtotime($nganggur['last_response']));?></td>
																	<td style="text-align:center;"><a href="<?= base_url("TicketingMaintenance/Agent/OrderList/detail/". $nganggur['no_order']) ?>" class="btn btn-primary btn-sm"> <i class="fa fa-search"> Detail</i></a></td>
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
																<table class="datatable table table-striped table-bordered table-hover text-left tblOrderListReviewed" id="tblOrderListReviewed" style="">
															<thead style="background-color:#3fc5f0;">
																<tr>
																	<th class="text-center">No Order</th>
																	<th class="text-center">Tanggal Order</th>
																	<th class="text-center">Nama Mesin</th>
																	<th class="text-center">Kerusakan</th>
																	<th class="text-center">Pengorder</th>
																	<th class="text-center">Last Response</th>
																	<th class="text-center">Action</th>
																</tr>
															</thead>
															<form action="" method="post">
															<tbody>
															<?php foreach ($orderListWithName as $nganggur) {
																// echo "<pre>";print_r($nganggur);exit();
																// if ($nganggur['status_order'] == 'reviewed' && $nganggur['status_order'] !== 'acc' && 
																// $nganggur['status_order'] !== 'open' && $nganggur['status_order'] !== 'overdue' && 
																// $nganggur['status_order'] !== 'action' && $nganggur['status_order'] !== 'done' &&
																// $nganggur['perkiraan_selesai'] <= date('Y-m-d')) {
																if ($nganggur['status_order'] == 'reviewed' && $nganggur['perkiraan_selesai'] >= date('Y-m-d')) {
																	# code...
																// }else{
																?>
																<tr>
																	<td class="text-center"><?= $nganggur['no_order']?></td>
																	<td  class="text-center"><?= date("d-M-Y H:i:s", strtotime($nganggur['tgl_order']));?></td>
																	<td><?= $nganggur['nama_mesin']?></td>
																	<td><?= $nganggur['kerusakan']?></td>
																	<td><?= $nganggur['seksi']." - ".$nganggur['name']?></td>
																	<td class="text-center"><?= date("d-M-Y H:i:s", strtotime($nganggur['last_response']));?></td>
																	<td style="text-align:center;"><a href="<?= base_url("TicketingMaintenance/Agent/OrderList/detail/". $nganggur['no_order']) ?>" class="btn btn-primary btn-sm"> <i class="fa fa-search"> Detail</i></a></td>
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
																<table class="datatable table table-striped table-bordered table-hover text-left tblOrderListAction" id="tblOrderListAction" style="">
															<thead style="background-color:#6decb9;">
																<tr>
																	<th class="text-center">No Order</th>
																	<th class="text-center">Tanggal Order</th>
																	<th class="text-center">Nama Mesin</th>
																	<th class="text-center">Kerusakan</th>
																	<th class="text-center">Pengorder</th>
																	<th class="text-center">Last Response</th>
																	<th class="text-center">Action</th>
																</tr>
															</thead>
															<form action="" method="post">
															<tbody>
															<?php foreach ($orderListWithName as $nganggur) {
																if ($nganggur['status_order'] == 'action' && $nganggur['perkiraan_selesai'] >= date('Y-m-d')) {
															?>
																<tr>
																	<td class="text-center"><?= $nganggur['no_order']?></td>
																	<td class="text-center"><?= date("d-M-Y H:i:s", strtotime($nganggur['tgl_order']));?></td>
																	<td><?= $nganggur['nama_mesin']?></td>
																	<td><?= $nganggur['kerusakan']?></td>
																	<td><?= $nganggur['seksi']." - ".$nganggur['name']?></td>
																	<td class="text-center"><?= date("d-M-Y H:i:s", strtotime($nganggur['last_response']));?></td>
																	<td style="text-align:center;"><a href="<?= base_url("TicketingMaintenance/Agent/OrderList/detail/". $nganggur['no_order']) ?>" class="btn btn-primary btn-sm"> <i class="fa fa-search"> Detail</i></a></td>
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
																<table class="datatable table table-striped table-bordered table-hover text-left tblOrderListOverdue" id="tblOrderListOverdue" style="">
															<thead style="background-color:#eef5b2;">
																<tr>
																	<th class="text-center">No Order</th>
																	<th class="text-center">Tanggal Order</th>
																	<th class="text-center">Nama Mesin</th>
																	<th class="text-center">Kerusakan</th>
																	<th class="text-center">Pengorder</th>
																	<th class="text-center">Overdue</th>
																	<th class="text-center">Last Response</th>
																	<th class="text-center">Action</th>
																</tr>
															</thead>
															<form action="" method="post">
															<tbody>
															<?php foreach ($orderListWithName as $nganggur) {
																// echo "<pre>";print_r($nganggur);exit();
																if ($nganggur['perkiraan_selesai'] < date('Y-m-d') && $nganggur['status_order'] !== 'close' && $nganggur['status_order'] !== 'reject' && $nganggur['status_order'] !== 'open' && $nganggur['status_order'] !== 'done'){						
															?>
																<tr>
																	<td class="text-center"><?= $nganggur['no_order']?></td>
																	<td  class="text-center"><?= date("d-M-Y H:i:s", strtotime($nganggur['tgl_order']));?></td>
																	<td><?= $nganggur['nama_mesin']?></td>
																	<td><?= $nganggur['kerusakan']?></td>
																	<td><?= $nganggur['seksi']." - ".$nganggur['name']?></td>
																	<td><?= $nganggur['perkiraan_selesai']?></td>
																	<td class="text-center"><?= date("d-M-Y H:i:s", strtotime($nganggur['last_response']));?></td>
																	<td style="text-align:center;"><a href="<?= base_url("TicketingMaintenance/Agent/OrderList/detail/". $nganggur['no_order']) ?>" class="btn btn-primary btn-sm"> <i class="fa fa-search"> Detail</i></a></td>
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
																<form method="POST" action="<?php echo site_url('CateringManagement/Extra/EditTempatMakan/getShow'); ?>">
																<table class="datatable table table-striped table-bordered table-hover text-left tblOrderListDone" id="tblOrderListDone" style="">
															<thead style="background-color:#42dee1;">
																<tr>
																	<th class="text-center">No Order</th>
																	<th class="text-center">Tanggal Order</th>
																	<th class="text-center">Nama Mesin</th>
																	<th class="text-center">Kerusakan</th>
																	<th class="text-center">Pengorder</th>
																	<th class="text-center">Last Response</th>
																	<th class="text-center">Action</th>
																</tr>
															</thead>
															<form action="" method="post">
															<tbody>
															<?php foreach ($orderListWithName as $nganggur) {
																		$tanggal_order_selesai = $nganggur['tgl_order_selesai'];
																		$tos = explode(" ", $tanggal_order_selesai);
																		$tanggal = $tos[0];
																		$batas_order = date('Y-m-d', strtotime($tanggal. '+3 day'));

																if ($nganggur['status_order'] == 'done' && date('Y-m-d') < $batas_order) {
															?>
																<tr>
																	<td class="text-center"><?= $nganggur['no_order']?></td>
																	<td class="text-center"><?= date("d-M-Y H:i:s", strtotime($nganggur['tgl_order']));?></td>
																	<td><?= $nganggur['nama_mesin']." & ".$nganggur['tgl_order_selesai']?></td>
																	<td><?= $nganggur['kerusakan']." & ".$batas_order?></td>
																	<td><?= $nganggur['seksi']." - ".$nganggur['name']?></td>
																	<td class="text-center"><?=date("d-M-Y H:i:s", strtotime($nganggur['last_response']));?></td>
																	<td style="text-align:center;"><a href="<?= base_url("TicketingMaintenance/Agent/OrderList/detail/". $nganggur['no_order']) ?>" class="btn btn-primary btn-sm"> <i class="fa fa-search"> Detail</i></a></td>
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
																	<th class="text-center" style="background-color:black;">Pengorder</th>
																	<th class="text-center" style="background-color:black;">Last Response</th>
																	<th class="text-center" style="background-color:black;">Action</th>
																</tr>
															</thead>
															<form action="" method="post">
															<tbody>
															<?php foreach ($orderListWithName as $nganggur) {
																if ($nganggur['status_order'] == 'done') {
																	$tanggal_order_selesai = $nganggur['tgl_order_selesai'];
																	$tos = explode(" ", $tanggal_order_selesai);
																	$tanggal = $tos[0];
																	// $tanggal_done = strtodate($tanggal_order_selesai);
																	// echo "<pre>"; echo "tanggal";
																	// echo "<pre>";print_r($tanggal_done);
																	// echo "<pre>"; echo "batas order";
																	$batas_order = date('Y-m-d', strtotime($tanggal. '+3 day'));
																	// echo "<pre>";print_r($tanggal_order_selesai);															
																}
																if ($nganggur['status_order'] == 'close' || $nganggur['status_order'] == 'done' || date('Y-m-d') < $batas_order) {
															?>
																<tr>
																	<td class="text-center"><?= $nganggur['no_order']?></td>
																	<td  class="text-center"><?= date("d-M-Y H:i:s", strtotime($nganggur['tgl_order']));?></td>
																	<td><?= $nganggur['nama_mesin']?></td>
																	<td><?= $nganggur['kerusakan']?></td>
																	<td><?= $nganggur['seksi']." - ".$nganggur['name']?></td>
																	<td class="text-center"><?=date("d-M-Y H:i:s", strtotime($nganggur['last_response']));?></td>
																	<td style="text-align:center;"><a href="<?= base_url("TicketingMaintenance/Agent/OrderList/detail/". $nganggur['no_order']) ?>" class="btn btn-primary btn-sm"> <i class="fa fa-search"> Detail</i></a></td>
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
																	<th class="text-center" style="color:white;">Pengorder</th>
																	<th class="text-center" style="color:white;">Last Response</th>
																	<th class="text-center" style="color:white;">Alasan Reject</th>
																	<th class="text-center" style="color:white;">Action</th>
																</tr>
															</thead>
															<form action="" method="post">
															<tbody>
															<?php foreach ($orderListWithName as $nganggur) {
																// echo "<pre>";print_r($orderList);exit();
																if ($nganggur['status_order'] == 'reject') {
																	# code...
																// }else{
															?>
																<tr>
																	<td class="text-center"><?= $nganggur['no_order']?></td>
																	<td  class="text-center"><?= date("d-M-Y H:i:s", strtotime($nganggur['tgl_order']));?></td>
																	<td><?= $nganggur['nama_mesin']?></td>
																	<td><?= $nganggur['kerusakan']?></td>
																	<td><?= $nganggur['seksi']." - ".$nganggur['name']?></td>
																	<td class="text-center"><?=date("d-M-Y H:i:s", strtotime($nganggur['last_response']));?></td>
																	<td class="text-center"><?=$nganggur['alasan_reject']?></td>
																	<td style="text-align:center;"><a href="<?= base_url("TicketingMaintenance/Agent/OrderList/detail/". $nganggur['no_order']) ?>" class="btn btn-primary btn-sm"> <i class="fa fa-search"> Detail</i></a></td>
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

<!-- MODAL Approve ORDER -->
<div class="modal fade" id="ModalApprove" tabindex="1" role="dialog" aria-labelledby="judulModal" aria-hidden="true">
    <div class="modal-dialog">
      <!-- Modal content-->
        <div class="modal-content">
        	<section class="content">
			<?php //echo $nganggur['no_order'];?>
				<form method="post" action="<?= base_url('TicketingMaintenance/Agent/OrderList/savePerkiraanSelesai/'); ?>">
					<input type="hidden" name="no_Order" id="no_Order" class="form-control" style="width: 350px">
					<div class="inner" style="padding-top: 20px">
						<div class="box box-success">
							<div class="box-header with-border">
								<h2><b><center>APPROVE ORDER</center></b></h2>
							</div>
							<div class="box-body">
						<div class="row" style="padding-top: 20px">
				    	    <div class="col-md-12" > <div class="table">
				                    <div class="panel-body">
										<div class="row">
										<div class="col-lg-2"></div>
                                    <div class="col-lg-12">
                                        <table class="datatable table table-bordered text-left" style="">
                                            <tr>
                                                <td class="title" style="width:200px;">Nama Mesin</td>
                                                <td id="namaMesin">: </td>
                                            </tr>
                                            <tr>
                                                <td class="title">No Mesin</td>
                                                <td id="noMesin">: </td>
                                            </tr>
                                            <tr>
                                                <td class="title">Line</td>
                                                <td id="line">: </td>
                                            </tr>
                                            <tr>
                                                <td class="title">Analisis Kerusakan awal</td>
                                                <td id="analisis">: </p></td>
                                            </tr>
                                            <tr>
                                                <td class="title">Need by Date</td>
                                                <td id="duedate">: </td>
                                            </tr>
                                            <tr>
                                                <td class="title">Reason Need by Date</td>
                                                <td id="reason">: </td>
                                            </tr>
                                            <tr>
                                                <td class="title">Kondisi Mesin saat Order</td>
                                                <td id="kondisi">: </td>
                                            </tr>
                                            <tr>
                                                <td class="title">Running Hour</td>
                                                <td id="running_hour">: </td>
                                            </tr>
                                        </table>
                                    </div>

											<div class="col-md-3" style="text-align: right;">
													<label>Perkiraan Selesai</label>
											</div>
											<div class="col-md-9">
												<div class="form-group">
													<input type="date" name="perkiraanSelesai" class="form-control perkiraanSelesai" id="txtperkiraanSelesai" placeholder="Input Tanggal Perkiraan Selesai" required />													
												</div>
											</div>
										</div>
										<div class="col-lg-12" style="padding-top: 8px;" >
											<div style="text-align: center;">
												<button type="submit" style="float: center; margin-right: 3%; margin-top: -0.5%;" class="btn btn-success btn-md" id="btnSaveApprove"><i class="fa fa-check"></i> APPROVE</button>
											</div>
										</div>
				                    	</div>
				             		</div>
				         		</div>
							</div>
							<div class="box box-success"></div>
							</div>
						</div>
					</div>
				</form>
			</section>
        </div>
    </div>
</div>
<!-- MODAL Approve ORDER END -->

<!-- Modal REJECT-->
<div class="modal fade" id="ModalReject" role="dialog">
     <div class="modal-dialog">
      <!-- Modal content-->
        <div class="modal-content">
        	<section class="content">
			<?php //echo $nganggur['no_order'];?>
				<form method="post" action="<?= base_url("TicketingMaintenance/Agent/OrderList/saveReject/") ?>">
					<input type="hidden" name="no_OrderReject" id="no_OrderReject" class="form-control" style="width: 350px">	
					<div class="inner" style="padding-top: 20px">
						<div class="box box-danger">
							<div class="box-header with-border">
								<h2><b><center>REJECT</center></b></h2>
							</div>
							<div class="box-body">
						<div class="row" style="padding-top: 20px">
				    	    <div class="col-md-12" > <div class="table">
				                    <div class="panel-body">
										<div class="row">
											<div class="col-md-3" style="text-align: right;">
													<label>Alasan Reject</label>
											</div>
											<div class="col-md-9">
												<div class="form-group">
													<textarea name="alasan_Reject" id="alasan_Reject" class="form-control" style="width: 350px" required>
													</textarea>
												</div>
											</div>
										</div>
											<div class="row col-md-12" style="padding-top: 10px;">
												<div class="col-md-10"><button type="button" style="float: right;" class="btn btn-default btn-lg" data-dismiss="modal">CANCEL</button></div>
												<div class="col-md-2"><button type="submit" class=" btn btn-success btn-lg">SAVE</button></div>
											</div>
											<!-- <div class="row" style="padding-left: 430px;padding-top: 10px">
												<button type="submit" class="btn btn-success btn-lg">SAVE</button>
												<button type="button" class="btn btn-default" data-dismiss="modal">CANCEL</button>
											</div> -->
				                    	</div>
				             		</div>
				         		</div>
							</div>
							<div class="box box-danger"></div>
							</div>
						</div>
					</div>
				</form>
			</section>
        </div>
    </div>
</div>
<!-- MODAL REJECT END -->