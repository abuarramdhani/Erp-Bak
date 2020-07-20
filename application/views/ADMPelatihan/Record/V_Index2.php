						<div class="table-responsive" style="overflow:hidden;">
							<table class="table table-striped table-bordered table-hover text-left" id="tblrecord" style="font-size:14px;table-layout:fixed;width:1300px;">
								<thead class="bg-primary">
									<tr>
										<th width="5%" style="text-align:center;">NO</th>
										<th width="20%">Action</th>
										<th width="15%">Trainer</th>
										<th width="20%">Nama Pelatihan</th>
										<th width="10%">Tanggal</th>
										<th width="15%">Nama Paket</th>
										<th width="10%">Tanggal Paket</th>
										<th width="5%" style="text-align:center;">Jumlah Peserta</th>
									</tr>
								</thead>
								<tbody>
									<?php
										$no=0; foreach($record as $rc){
											$no++;
											$strainer = explode(',', $rc['trainer']);

											$time = strtotime($rc['date']);
											$newformat = date('Y-m-d',$time);

											$dday 		= date('Y-m-d', strtotime($newformat));
											$today 		= date('Y-m-d');
											$tomorrow 	= date('Y-m-d', strtotime('tomorrow'));
											$week		= date('Y-m-d', strtotime('today + 7 day'));

											$datestatus="";
											if($dday == $tomorrow || $dday == $today){$datestatus="danger";}
											elseif ($dday>$today && $dday<$week){$datestatus="warning";}
											elseif ($dday<$today && $dday<$week){$datestatus="success";}

											$packagedate=$rc['start_date_format'].' - '.$rc['end_date_format'];
											if(is_null($rc['start_date_format']) OR is_null($rc['start_date_format'])){$packagedate="";}

											if ($dday<$today && $dday<$week && $rc['tidak_terlaksana']==1) {
											?>
												<tr style="background-color: #C39BD3; <?php echo $rc['quest_status'];?>"> 
											<?php } else{?>
												<tr class=" <?php echo $datestatus;?>" style="<?php echo $rc['quest_status'];?>"> 
											<?php }
									?>
													<input type="text"  name="viewPackage" value="<?php echo $rc['package_scheduling_id']?>" hidden>		
													<td align="center"><?php echo $no ?></td>
													<td>
														<?php if ($rc['package_scheduling_id']==0) {?>
														   <a target="_blank" href="<?php echo site_url('ADMPelatihan/Record/CetakSertifikat/'.$rc['scheduling_id']);?>" class="btn btn-flat btn-sm btn-primary" data-toggle="tooltip" title="Cetak Serifikat"><i class="fa fa-file-text-o"></i></a>
															<a target="_blank" href="<?php echo site_url('ADMPelatihan/Cetak/Undangan/CetakUndanganPelatihan/'.$rc['scheduling_id']) ?>" class="btn btn-flat btn-sm btn-danger" data-toggle="tooltip" title="Cetak Undangan"><i class="fa fa-file-pdf-o"></i></a>
															<a href="<?php echo site_url('ADMPelatihan/Record/Detail/'.$rc['scheduling_id']);?>" class="btn btn-flat btn-sm btn-warning" data-toggle="tooltip1" title="View" ><i class="fa fa-search"></i></a>
															<a href="<?php echo site_url('ADMPelatihan/Record/Confirm/'.$rc['scheduling_id']);?>" class="btn btn-flat btn-sm btn-success" data-toggle="tooltip1" title="Input Kehadiran & Nilai"><i class="fa fa-check"></i></a>
															
															<?php $sudahCetak = 0; foreach ($participant_confirm as $pc) {
																if ($pc['scheduling_id']==$rc['scheduling_id'] && $sudahCetak==0) {
																	$sudahCetak=1;
																	if ($pc['status']==NULL && $pc['score_eval2_pre']==NULL && $pc['score_eval2_post']==NULL ) { ?>
																		<a href="<?php echo site_url('ADMPelatihan/InputQuestionnaire/ToCreate/'.$rc['scheduling_id']);?>" class="btn btn-flat btn-sm btn-primary" data-toggle="tooltip1" title="Input Kuesioner" ><i class="fa fa-file-text-o"></i></a>
																	<?php }
																	elseif ($pc['status']==NULL && $pc['score_eval3_post']==NULL && $pc['comment']==NULL) {?>
																		<a href="<?php echo site_url('ADMPelatihan/InputQuestionnaire/ToCreate/'.$rc['scheduling_id']);?>" class="btn btn-flat btn-sm btn-primary" data-toggle="tooltip1" title="Input Kuesioner" ><i class="fa fa-file-text-o"></i></a>
																	<?php }
																	else{?>
																		<a href="<?php echo site_url('ADMPelatihan/InputQuestionnaire/ToCreate/'.$rc['scheduling_id']);?>" class="btn btn-flat btn-sm btn-primary" data-toggle="tooltip1" title="Input Kuesioner"><i class="fa fa-file-text-o"></i></a>
																	<?php }
																}
															} ?>

															<a data-toggle="modal" data-target="<?php echo '#deletealert'.$rc['scheduling_id'] ?>" class="btn btn-flat btn-danger btn-sm" data-toggle="tooltip1" title="Hapus Pelatihan"><i class="fa fa-remove"></i></a>
														<?php } else 
															{
															if ($rc['status']==1) { ?>
																<a class="btn btn-flat btn-sm btn-warning" onclick="recordPackageFinish('<?php echo $rc['package_scheduling_id']; ?>')" title="View">
																	<i class="fa fa-search" ></i>
																</a>
															<?php } 
															else {?> 
																<a class="btn btn-flat btn-sm btn-warning" onclick="recordPackage('<?php echo $rc['package_scheduling_id']; ?>')" title="View">
																	<i class="fa fa-search" ></i>
																</a>
															<?php }?>
																<a class="btn btn-flat btn-sm btn-success" title="Input Kehadiran & Nilai" ><i class="fa fa-check"></i></a>
																<a class="btn btn-flat btn-sm btn-primary" title="Input Kuesioner" ><i class="fa fa-file-text-o" ></i></a>
																<a data-toggle="modal" class="btn btn-flat btn-danger btn-sm" title="Hapus Pelatihan" ><i class="fa fa-remove"></i></a>
														<?php }?>
													</td>
													<td>
														<?php 
															foreach ($strainer as $st){
																foreach ($trainer as $tr){
																	if ($st == $tr['trainer_id']){
																		echo '<i class="fa fa-angle-right"></i> '.$tr['trainer_name'].'<br>';
																	}
																}
															};
														?>
													</td>
													<td><?php echo $rc['scheduling_name'] ?></td>
													<td><?php echo $rc['date_format'] ?></td>
													<td><?php echo $rc['package_scheduling_name'] ?></td>
													<td><?php echo $packagedate ?></td>
													<td align="center"><?php echo $rc['participant_number'] ?></td>
												</tr>
									
									
												<!-- MODAL  DELETE-->
												<div class="modal fade modal-danger" id="<?php echo 'deletealert'.$rc['scheduling_id'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
													<div class="modal-dialog" role="document">
														<div class="modal-content">
															<div class="modal-header">
																<div class="col-sm-2"></div>
																<div class="col-sm-8" align="center"><h5><b>PERHATIAN !</b></h5></div>
																<div class="col-sm-2"><h5><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></h5></div>
																<br>
															</div>
															<div class="modal-body" align="center">
																Apakah anda yakin ingin menghapus <b><?php echo $rc['scheduling_name'] ?></b> dari jadwal pelatihan ? <br>
																<small>*) Data yang sudah dihapus tidak dapat dikembalikan lagi.</small>
																<div class="row">
																	<br>
																	<a href="<?php echo base_url('ADMPelatihan/Record/Delete/'.$rc['scheduling_id'])?>" class="btn btn-default"><i class="fa fa-remove"></i> DELETE</a>
																</div>
															</div>
														</div>
													</div>
												</div>
									<?php } ?>
								</tbody>															
							</table>
						</div>
						<div id="modalPaketArea"></div>
						<div id="modalPaketAreafinish"></div>
