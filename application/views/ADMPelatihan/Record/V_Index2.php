						<div class="table-responsive" style="overflow:hidden;">
							<table class="table table-striped table-bordered table-hover text-left" id="tblrecord" style="font-size:14px;table-layout:fixed;width:1300px;">
								<thead class="bg-primary">
									<tr>
										<th width="5%" style="text-align:center;">NO</th>
										<th width="10%">Action</th>
										<th width="20%">Trainer</th>
										<th width="20%">Nama Pelatihan</th>
										<th width="10%">Tanggal</th>
										<th width="20%">Nama Paket</th>
										<th width="10%">Tanggal Paket</th>
										<th width="5%" style="text-align:center;">Jumlah Peserta</th>
									</tr>
								</thead>
								<tbody>
									<?php
										$no=0; foreach($record as $rc){ $no++;
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
									?>
									<tr class="<?php echo $datestatus ?>">
										<td align="center"><?php echo $no ?></td>
										<td>
											<a href="<?php echo site_url('ADMPelatihan/Record/Detail/'.$rc['scheduling_id']);?>" class="btn btn-flat btn-sm btn-warning" data-toggle="tooltip" title="View"><i class="fa fa-search"></i></a>
											<a href="<?php echo site_url('ADMPelatihan/Record/Confirm/'.$rc['scheduling_id']);?>" class="btn btn-flat btn-sm btn-success" data-toggle="tooltip" title="Input Kehadiran & Nilai"><i class="fa fa-check"></i></a>
											<a href="<?php echo site_url('ADMPelatihan/InputQuestionnaire/ToCreate/'.$rc['scheduling_id']);?>" class="btn btn-flat btn-sm btn-primary" data-toggle="tooltip" title="Input Kuesioner"><i class="fa fa-file-text-o"></i></a>
											

											<?php if($rc['status']==0){ ?>
											<!--<a href="<?php echo site_url('ADMPelatihan/Record/Confirm/'.$rc['scheduling_id']);?>" class="btn btn-flat btn-sm btn-success" data-toggle="tooltip" title="Confirm"><i class="fa fa-check"></i></a>-->
											<?php } ?>

											<!--<a href="<?php echo site_url('ADMPelatihan/Record/Edit/'.$rc['scheduling_id']);?>" class="btn btn-flat btn-sm btn-success" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></a>-->

											<?php if($rc['status']==1){ ?>
											<!--<a href="<?php echo site_url('ADMPelatihan/InputQuestionnaire/ToCreate/'.$rc['scheduling_id']);?>" class="btn btn-flat btn-sm btn-primary" data-toggle="tooltip" title="Input Questionnaire"><i class="fa fa-file-text-o"></i></a>-->
											<?php } ?>

											<a data-toggle="modal" data-target="<?php echo '#deletealert'.$rc['scheduling_id'] ?>" class="btn btn-flat btn-danger btn-sm"><i class="fa fa-remove"></i></a>
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
									
									<div class="modal fade modal-danger" id="<?php echo 'deletealert'.$rc['scheduling_id'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
										<div class="modal-dialog" role="document">
											<div class="modal-content">
												<div class="modal-header">
													<div class="col-sm-2"></div>
													<div class="col-sm-8" align="center"><h5><b>PERHATIAN !</b></h5></div>
													<div class="col-sm-2"><h5><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></h5></div>
													</br>
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
					
