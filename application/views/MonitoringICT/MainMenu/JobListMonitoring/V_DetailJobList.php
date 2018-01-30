<section class="content">
	<div class="inner" >
	<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11">
							<div class="text-right">
								<h1><b>Detail</b></h1>
						
							</div>
						</div>
						<div class="col-lg-1 ">
							<div class="text-right hidden-md hidden-sm hidden-xs">
								<a class="btn btn-default btn-lg" href="<?php echo site_url("MonitoringICT/JobListMonitoring/Detail/$id_perangkat/$id_periode");?>">
									<i class="icon-file icon-2x"></i>
									<span ><br /></span>
								</a>
							</div>
						</div>
					</div>
				</div>
				<br />
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header with-border">
								Detail Monitoring
							</div>
							<div class="box-body">
								<div >
									<div class="row">
										<div class="col-md-6 " ><h4> Perangkat : <b> <?= $DataPerangkat != null ? $DataPerangkat[0]['host'].' ('.$DataPerangkat[0]['jenis_perangkat'].') ' : ''?> </b></h4></div>
										<div class="col-md-6 pull-right" style="text-align: right;" ><h4> Periode Monitoring : <b><?= $DataPerangkat != null ? $DataPerangkat[0]['periode_monitoring'] : ''?></b></h4></div>
									</div>
								</div>
								<div class="panel panel-body" style="background-color: #dedede">
									<div class="row" style="margin-right: 5px">
									<button class="btn btn-danger pull-right" id="btnInputMon"><i class="fa fa-plus"></i>Input New</button>
									</div>
										<form method="post" action="<?php echo base_url('MonitoringICT/JobListMonitoring/create') ?>">
										<input type="hidden" name="idPerangkat" value="<?= $id_perangkat; ?>">
										<input type="hidden" name="idPeriod" value="<?= $DataPerangkat != null ? $DataPerangkat[0]['periode_monitoring_id'] : '' ?>">
										<input type="hidden" name="nmPerangkat" value="<?= $DataPerangkat != null ? $DataPerangkat[0]['host'].' ('.$DataPerangkat[0]['jenis_perangkat'].') ' : ''?>">
									<div id="formInputMon" class="row" style="display: none" >
									<div class="col-lg-12" style="margin: 5px">
											
										<div class="form-group " >
												<label for="norm" class="control-label col-lg-12">Aspek QC</label>
												<div class="col-lg-12 panel panel-body" style=" background-color: #f5f5f5">
													<table class="table table-bordered table-hover table-striped" >
														<thead>
															<tr style="text-align: center;" class="bg-blue">
																<th width="5%">No.</th>
																<th width="45%" style="text-align: center;">Aspek</th>
																<th width="10%" style="text-align: center;">Standar</th>
																<th width="20%" style="text-align: center;">Hasil</th>
																<th width="30%"> Cara Pengisian</th>
															</tr>
														</thead>
														<tbody>
														<?php $no=1; foreach ($Aspek as $asp) { ?>
														<tr>
															<td><center><?= $no++; ?></center></td>
															<td><?php echo $asp['aspek'] ?></td>
															<td><center><?php if ($asp['jenis_standar'] == 'nn') { 
																		echo $asp['standar'] == '=1' ? '<b>YA</b>' : '<b>TIDAK</b>';
																		}else{
																			echo '<b>'.$asp['standar'].'</b>';
																		}
																	?></center>
															</td>
															<td style="text-align: center;">
																<?php if ($asp['jenis_standar'] == 'nn') { ?>
																	<input type="radio" name="asp_<?php echo $asp['aspek_id'] ?>" value="1"><b>YA</b> &nbsp;
																	<input type="radio" name="asp_<?php echo $asp['aspek_id'] ?>" value="0"><b>TIDAK</b>
																<?php } elseif ($asp['jenis_standar'] == 'n') { ?>
																	<input style="width: 50%; margin-left: 25%" type="text" onkeypress='return event.charCode <= 66 && event.charCode <=91' class="form-control" name="asp_<?php echo $asp['aspek_id'] ?>">
																<?php } ?>
																<input type="hidden" value="<?= $asp['jenis_standar']; ?>" name="jns_asp_<?php echo $asp['aspek_id'] ?>" >
																<input type="hidden" value="<?= $asp['standar']; ?>" name="std_asp_<?php echo $asp['aspek_id'] ?>" >
																<input type="hidden" value="<?= $asp['aspek_id']; ?>" name="aspID[]" >
																<input type="hidden" value="<?= $asp['aspek']; ?>" name="aspDESC[]" >
															</td>
															<td><?= $asp['cara_pengisian']?></td>
														</tr>
														<?php } ?>
														</tbody>
													</table>
												</div>
										</div>
									</div>
									<div class="col-lg-12" style="margin: 5px">
										<div class="form-group">
												<label for="norm" class="control-label col-lg-12">Info Tambahan</label>
												<div class="col-lg-12">
													<textarea name="txtInfo" style="width: 100%"></textarea>
												</div>
										</div>
									</div>
									<div class="col-lg-12" style="margin: 5px">
										<div class="form-group">
												<div class="col-lg-12">
													<center>
													<button type="submit" class="btn btn-sm btn-success">SAVE</button>
													<!-- <a href="<?= base_url('MonitoringICT/JobListMonitoring') ?>">
													<button type="button" class="btn btn-sm btn-primary">BACK</button>
													</a> -->
													<button type="button" class="btn btn-sm btn-primary" onclick="btnInpMont()">CANCEL</button>
													</center>
												</div>
										</div>
									</div>
									</div>
										</form>
								</div>
								
								
								<div >
									<div class="row">
										<div class="col-md-6 " ><h4><strong>Hasil Monitoring </strong></h4>
										</div>
										<div class="col-md-6 pull-right" style="text-align: right;" >
											<b> LIMIT</b>
											<input type="hidden" name="perangkatID" value="<?= $id_perangkat ?>">
											<select style="width: 15% " class="form-control pull-right" onchange="ajaxGetHasil(this, '<?= base_url() ?>')">
												<option <?= $limit == '10' ? 'selected' : '' ?> value="10" >10</option>
												<option <?= $limit == '30' ? 'selected' : '' ?> value="30" >30</option>
												<option <?= $limit == '50' ? 'selected' : '' ?> value="50" >50</option>
												<option <?= $limit == 'No' ? 'selected' : '' ?> value="No" >No Limit</option>
											</select><br>
										</div>
									</div>
								</div>
								<div id="hasil" class="table-responsive">
									<table class="table table-striped table-bordered table-hover text-left" id="tblUser" style="font-size:12px;">
										<thead>
											<tr class="bg-primary">
												<th width="5%"><center>No</center></th>
												<th width="20%"><center>Tanggal Monitoring</center></th>
												<th width="30%"><center>Aspek</center></th>
												<th width="10%"><center>No. Order</center></th>
												<th width="20%"><center>info</center></th>
												<th width="15%"><center>Action</center></th>
											</tr>
										</thead>
										<tbody>
										<?php $no=1; foreach ($DataHasil as $DHasil) { ?>
											<tr >
												<td><center><?= $no++; ?></center></td>	
												<td><?= date('d M Y',strtotime($DHasil['tgl_monitoring']) ) ?> </td>
												<td><?php 
														foreach ($DHasil['aspek_hasil'] as $asp) {
															if ($asp['jenis_standar'] =='nn') {
																$hasil = $asp['hasil_pengecekan'] == '1' ? 'Y' : 'T';
															}else{
																$hasil = $asp['hasil_pengecekan'].' '.$asp['satuan'] ;
															}

															echo ' - '.$asp['aspek']. '<b>['.$hasil.']</b><br>';
														}
													?>
												</td>
												<td>
													<center>
													<?php 
														if ($DHasil['nomor_order'] != null) {
															if (isset($DHasil['status_order'])) {
															 echo $DHasil['status_order'] == 'closed' 
															 ?'<a target="_blank"  
															 	href="http://ictsupport.quick.com/ticket/upload/scp/tickets.php?id='.$DHasil['ticket_id'].'">
															 	<span class="badge bg-green ">'.$DHasil['nomor_order'].' (CLOSED)</span></a>'
															 :'<a target="_blank"  
															 	href="http://ictsupport.quick.com/ticket/upload/scp/tickets.php?id='.$DHasil['ticket_id'].'">
															 	<span class="badge bg-blue faa-flash faa-slow animated">'.$DHasil['nomor_order'].$DHasil['status_order'].'</span></a>';
															}else{
															 echo '<a target="_blank"  
															 	href="http://ictsupport.quick.com/ticket/upload/scp/tickets.php?id='.$DHasil['ticket_id'].'">
															 	<span class="badge bg-red faa-flash faa-slow animated">'.$DHasil['nomor_order'].'</span> </a>';
															}
														}else{
															echo '<span class="badge bg-green "> - </span>';
														}
													?>
													</center>
												</td>
												<td><?= $DHasil['info']; ?></td>
												<td><center>
													<a title="<?= 'Edit '.date('d M Y',strtotime($DHasil['tgl_monitoring']) ) ?>" href="<?= base_url("MonitoringICT/JobListMonitoring/Edit/$DHasil[hasil_monitoring_id]") ?>">
													<button  class="btn btn-sm btn-warning "> Edit </button>
													</a>
													<button data-toggle="modal" data-target="#confirmDel_<?= $DHasil['hasil_monitoring_id'] ?>" class="btn btn-sm btn-danger "> Delete </button>
													</center>
												</td>
											</tr>
										<?php } ?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
					<!-- modal -->
					<?php foreach ($DataHasil as $val) { ?>
											<div id="confirmDel_<?php echo $val['hasil_monitoring_id'] ?>" class="modal fade" role="dialog">
												<div class="modal-dialog">
													<!-- konten modal-->
													<div class="modal-content">
														<!-- heading modal -->
														<div class="modal-header">
															<button type="button" class="close" data-dismiss="modal">&times;</button>
															<h4 class="modal-title">Are you sure?</h4>
														</div>
														<!-- body modal -->
														<div class="modal-body">
															<p>Tanggal Monitoring : <?php echo $val['tgl_monitoring'] ?></p>
														</div>
														<!-- footer modal -->
														<div class="modal-footer">
															<form method="post" action="<?= base_url("MonitoringICT/JobListMonitoring/Delete") ?>">
																<input type="hidden" name="idPerangkat" value="<?= $id_perangkat ?>">
																<input type="hidden" name="idPeriod" value="<?= $DataPerangkat != null ? $DataPerangkat[0]['periode_monitoring_id'] : '' ?>">
																<input type="hidden" name="idMonitoring" value="<?= $val['hasil_monitoring_id'] ?>">
															<button type="submit" class="btn btn-danger" >DELETE</button>
															<button type="button" class="btn btn-default" data-dismiss="modal">CANCEL</button>
															</form>
														</div>
													</div>
												</div>
											</div>
									<?php } ?>
					<!-- end -->
			</div>
	</div>
	</div>
</section>