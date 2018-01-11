<script src="<?php echo base_url('assets/js/ajaxSearch.js');?>"></script>

<section class="content">
	<div class="inner" >
	<div class="row">
		<div class="col-lg-12">
			<div class="row" >
				<div class="col-lg-12">
					<div class="col-lg-11">
						<div class="text-right">
						<h1><b>Record Pelatihan</b></h1>
						</div>
					</div>
					<div class="col-lg-1">
						<div class="text-right hidden-md hidden-sm hidden-xs">
                            <a class="btn btn-default btn-lg" href="<?php echo site_url('ADMPelatihan/MasterTraining');?>">
                                <i class="icon-wrench icon-2x"></i>
                                <span><br/></span>	
                            </a>
						</div>
					</div>
				</div>
			</div>
			<br/>
			
			<div class="row">
				<div class="col-lg-12">
				<div class="box box-primary box-solid">
					<div class="box-header with-border">
						<b>Form Konfirmasi Pelaksanaan Pelatihan</b>
					</div>
					<div class="box-body">
					<?php foreach($record as $rc){?>
						<div class="row" style="margin: 10px 10px">
							<label class="col-lg-offset-2 col-lg-8 control-label" align="center">
								<h3><b><?php echo $rc['training_name']?></b></h3>
							</label>
						</div>
						<div class="col-lg-offset-2 col-lg-8">
							<div class="row" style="margin: 10px 10px">
								<div class="form-group">
									<label class="col-lg-3 control-label">Nama Pelatihan</label>
									<div class="col-lg-9">
										<input class="form-control" value="<?php echo $rc['scheduling_name']?>" readonly>
									</div>
								</div>
							</div>

							<div class="row" style="margin: 10px 10px">
								<div class="form-group">
									<label class="col-lg-3 control-label">Tanggal</label>
									<div class="col-lg-9">
										<input class="form-control" value="<?php echo $rc['date_format']?>" readonly >
									</div>	
								</div>
							</div>

							<?php if ($rc['package_scheduling_id']==0 && $rc['package_training_id']==0) {?>
								<div class="row" style="margin: 10px 10px">
									<div class="form-group">
										<label class="col-lg-3 control-label">Waktu</label>
										<div class="col-lg-4 ">
											<input class="form-control" value="<?php echo $rc['start_time']?>" readonly>
										</div>
										<label class="col-lg-1 control-label" align="center">-</label>
										<div class="col-lg-4">
											<input class="form-control" value="<?php echo $rc['end_time']?>" readonly>
										</div>
									</div>
								</div>
							<?php }?>

							<div class="row" style="margin: 10px 10px">
								<div class="form-group">
									<label class="col-lg-3 control-label">Ruang</label>
									<div class="col-lg-9">
										<input class="form-control" value="<?php echo $rc['room']?>" readonly >
									</div>
								</div>
							</div>
							<hr>
							<div class="row" style="margin: 10px 10px">
								<div class="form-group">
								<label class="col-lg-3 control-label">Evaluasi</label>
									<div class="col-lg-9">
 										<?php
											$eval='';$ev1='';$ev2='';$ev3='';
											// if($rc['evaluation']=='1'){$eval='Reaksi';$ev1='Y';}
											if($rc['evaluation']=='2'){$eval='Pembelajaran';$ev2='Y';}
											if($rc['evaluation']=='3'){$eval='Evaluasi Lapangan';$ev3='Y';}
											// if($rc['evaluation']=='1,2' || $rc['evaluation']=='2,1'){$eval='Reaksi, Pembelajaran';$ev1='Y';$ev2='Y';}
											// if($rc['evaluation']=='1,3' || $rc['evaluation']=='3,1'){$eval='Reaksi, Evaluasi Lapangan';$ev1='Y';$ev3='Y';}
											if($rc['evaluation']=='2,3' || $rc['evaluation']=='3,2'){$eval='Pembelajaran, Evaluasi Lapangan';$ev2='Y';$ev3='Y';}
											// if($rc['evaluation']=='1,2,3' || $rc['evaluation']=='3,1,2' || $rc['evaluation']=='3,2,1' || $rc['evaluation']=='2,1,3' || $rc['evaluation']=='2,3,1')
											// 	{$eval='Reaksi, Pembelajaran, Evaluasi Lapangan';$ev1='Y';$ev2='Y';$ev3='Y';}
										?>
										<input class="form-control" value="<?php echo $eval ?>" readonly >
									</div>
								</div>
							</div>
							<div class="row" style="margin: 10px 10px">
								<div class="form-group">
									<label class="col-lg-3 control-label">Sifat</label>
									<div class="col-lg-9">
										<?php if ($rc['sifat']==1) {?>
											<input class="form-control" value="<?php echo "Order"?>" readonly >
										<?php } ?>
										<?php if ($rc['sifat']==2) {?>
											<input class="form-control" value="<?php echo "Tahunan"?>" readonly >
										<?php } ?>
									</div>
								</div>
							</div>
							<div class="row" style="margin: 10px 10px">
								<div class="form-group">
									<label class="col-lg-3 control-label">Peserta</label>
									<div class="col-lg-3">
										<input class="form-control" value="<?php echo $rc['participant_type_description'] ?>" readonly >
									</div>
									<label class="col-lg-3 control-label" align="right">Jumlah Peserta</label>
									<div class="col-lg-3">
										<input class="form-control" value="<?php echo $rc['participant_number']?>" readonly >
									</div>
								</div>
							</div>
							<hr>
						</div>
						<div class="col-lg-12">
							<div class="row" style="margin: 10px 10px">
								<div class="col-lg-12">
									<div class="panel panel-default">
										<div class="panel-heading">
											<b>Tujuan Pelatihan :</b>
										</div>
										<div class="panel-body">
											<?php foreach($purpose as $pp){ ?>
											<i class="fa fa-angle-right"></i><?php echo ' '.$pp['purpose'] ?><br>
											<?php } ?>
										</div>
									</div>
								</div>
							</div>
							<hr>
							<div class="row" style="margin: 10px 10px">
								<div class="form-group">
									<label class="col-lg-12 control-label">Trainer : </label>
								</div>
							</div>
							<div class="row" style="margin: 10px 10px">
								<div class="col-md-12">
									<table class="table table-sm table-bordered table-hover" style="table-layout: fixed;">
										<thead class="bg-primary">
											<tr>
												<th width="5%">No</th>
												<th width="15%">No Induk</th>
												<th width="60%">Nama Trainer</th>
												<th width="20%">Status</th>
											</tr>
										</thead>
										<tbody>
											<?php
												$no=0;
												$strainer = explode(',', $rc['trainer']);
												foreach ($strainer as $st){ $no++;
													foreach ($trainer as $tr){
														if($st == $tr['trainer_id']){
															$status='Internal';
															if($tr['trainer_status']==0){
																$status='Eksternal';
															}
											?>
											<tr>
												<td><?php echo $no ?></td>
												<td><?php echo $tr['noind'] ?></td>
												<td><?php echo $tr['trainer_name'] ?></td>
												<td><?php echo $status ?></td>
											</tr>
											<?php }}} ?>
										</tbody>
									</table>
								</div>
							</div>
							<hr>
							<div class="row" style="margin: 10px 10px">
								<div class="form-group">
									<label class="col-lg-12 control-label">Peserta : </label>
								</div>
							</div>
							<form method="post" action="<?php echo base_url('ADMPelatihan/Record/DoConfirm')?>">
							<div class="row" style="margin: 10px 10px">
								<div class="col-md-12" >
									<input type="text" name="txtSchnum" value="<?php echo $rc['scheduling_id']?>" hidden></input>
									<div style="overflow: scroll;">
									<table class="datatable table table-striped table-bordered table-hover" style="min-width: 1500px">
										<thead class="bg-primary">
											<tr>
												<th  rowspan="2"  class="header_table">No</th>
												<th  rowspan="2" class="header_table">No Induk</th>
												<th  rowspan="2" style="min-width: 300px" class="header_table" >Nama Peserta</th>
												<th  rowspan="2" style="min-width: 200px" class="header_table">Status</th>
													<!-- <?php if ($ev1=='Y') { ?>
														<th  rowspan="2"  class="header_table">Reaksi (Post)</th>
													<?php } ?> -->
													<?php if($ev2=='Y'){ ?>
														<th colspan="2" class="header_table">Pembelajaran</th>
													<?php } if($ev3=='Y'){ ?>
														<th  colspan="2" class="header_table">Perubahan Perilaku (Evaluasi Lapangan)</th>
													<?php } ?>
											</tr>
											<tr>
												<?php if($ev2=='Y'){ ?>
													<th   class="header_table">(Pre)</th>
													<th   class="header_table">(Post)</th>
												<?php } if($ev3=='Y'){ ?>
													<th   class="header_table">Kompetensi</th>
													<th   class="header_table" style="min-width: 300px">Keterangan</th>
												<?php } ?>
											</tr>
										</thead>
										<tbody>
											<?php $no=0;
												$stafdata = array();
												$nonstafdata = array();
												foreach ($participant as $pt){ $no++;

												// STATUS HADIR/TIDAK HADIR
												if('2'==$pt['status'])
												{
													$hadir='';
													$tidakhadir='selected';
												}
												else
												{
													$hadir='selected';
													$tidakhadir='';
												}

												// NOMOR INDUK YANG STAF
												$staffCode = array('B', 'D', 'J', 'Q');
												$indCode = substr($pt['noind'], 0, 1);
												if (in_array($indCode, $staffCode)) {
													$a='stafKKM';
													array_push($stafdata, $pt['noind'] );
												}else{
													$a='nonstafKKM';
													array_push($nonstafdata, $pt['noind'] );
												}

												?>
											<tr row-id="<?php echo $no ?>">
												<td><?php echo $no ?></td>
												<td><?php echo $pt['noind'] ?></td>
												<td><?php echo $pt['participant_name'] ?></td>
												<td>
													<input type="text" name="txtId[]" value="<?php echo $pt['participant_id']?>" hidden>
													<select class="form-control select4" name="slcStatus[]">
														<option value="1" <?php echo $hadir;?> >Hadir</option>
														<option value="2" <?php echo $tidakhadir;?> >Tidak Hadir</option>
													</select>
												</td>
												<!-- <td col-id="reaksi">
														<input type="text" class="form-control" name="txtReaksiPost[]" Placeholder="Reaksi" onchange="<?php echo $a; ?>(this,'reaksi','<?php echo $no; ?>')" onkeypress="return isNumberKey(event)" value="<?php echo $pt['score_eval1_post'];?>">
												</td>  -->
													<?php if($ev2=='Y'){ ?>
												<td col-id="pre">
													<input type="text" class="form-control" name="txtPengetahuanPre[]" Placeholder="Pengetahuan (pre)" onchange="<?php echo $a; ?>(this,'pre','<?php echo $no; ?>')" onkeypress="return isNumberKey(event)" value="<?php echo $pt['score_eval2_pre'];?>">
												</td>
												<td col-id="post">
													<input type="text" class="form-control" name="txtPengetahuanPost[]" Placeholder="Pengetahuan (post)" onchange="<?php echo $a; ?>(this,'post','<?php echo $no; ?>')" onkeypress="return isNumberKey(event)" value="<?php echo $pt['score_eval2_post'];?>">
												</td>
													<?php } if($ev3=='Y'){ ?>
												<td>
													<select class="form-control SlcRuang" name="txtPerilakuEvalLap[]" data-placeholder="Eval" required>
														<option value="0" <?php if ($pt['score_eval3_post2'] == 0) {
															echo "selected";
														} ?> >Tidak Kompeten</option>
														<option value="1" <?php if ($pt['score_eval3_post2'] == 1) {
															echo "selected";
														} ?> >Kompeten</option>
													</select>
												</td>
												<td>
													<input type="text" class="form-control" name="txtKeterangan[]" Placeholder="Keterangan" value="<?php echo $pt['comment'];?>">
												</td>
													<?php } ?>
											</tr>
											<?php } ?>
										</tbody>
									</table>
								</div>
								</div>
							</div>
							<div class="bg-primary disabled color-palette">
								<div class="row" style="margin: 10px 10px">
									<div class="form-group">
										<label class="col-lg-12 control-label">*) Standar kelulusan :
										<?php
										echo '<input type="hidden" id="kkmStaff" value="'.$rc['limit_1'].'">';
										echo '<input type="hidden" id="kkmNonStaff" value="'.$rc['limit_2'].'">';

										if ($stafdata!=null && $nonstafdata!=null) {
											echo '<br><br> <b>Staf:</b> <br> '.implode($stafdata, ', ').' = '.$rc['limit_1'];
											echo '<br><br> <b>Non Staf:</b> <br>'.implode($nonstafdata, ', ').' = '.$rc['limit_2'];
										} elseif ($stafdata!=null && $nonstafdata==null) {
											echo '<br><br> <b>Staf:</b> <br>'.implode($stafdata, ', ').' = '.$rc['limit_1'];
										} else {
											echo '<br><br> <b>Non Staf:</b> <br>'.implode($nonstafdata, ', ').' = '.$rc['limit_2'];
										}
										?></label>
									</div>
								</div>
							</div>
							<hr>
							<div class="row" style="margin: 10px 10px">
								<div class="col-md-12">
									<div class="table-responsive" style="overflow:hidden;overflow:scroll;max-height: 380px;">
									<table class="table table-striped table-bordered table-hover text-left" id="tblrecord" style="font-size:14px;width:1800px;">
										<?php 
												$no=0; $no++;
											?>
										<thead>
											<tr class="bg-primary">
												<th>No</th>
												<th>Segmen</th>
												<th>Statement</th>
												<?php foreach($sheet as $se){ ?>
													<td style="min-width:150px;text-align: center;"><?php echo '<b>Subjek - '.$no++.'</b>'; ?></td>
												<?php } ?>
												<th style="min-width: 70px">Total</th>
												<th style="min-width: 70px">Rata-Rata</th>
											</tr>
										</thead>
										<tbody>
											<?php
												$no=1; foreach ($GetSchName_QuesName_detail as $gsq) { ?>
												<input type="text" name="txtID" value="<?php echo $gsq['scheduling_id'];?>" hidden>
											<tr>	
												<?php
												$n=0;
												$i=0;
												foreach($segment as $sg){
													if ($sg['scheduling_id']==$gsq['scheduling_id']) {
														$checkpoint_sg_desc = 0;
														foreach($statement as $st => $val){
															if ($sg['segment_id'] == $val['segment_id']) {
													?>
														<tr>
															<?php if ($checkpoint_sg_desc == 0) {
																foreach ($sgstCount as $key => $value) {
																	if ($value['segment_id'] == $sg['segment_id']) { ?>
																		<td rowspan="<?php echo $value['rowspan']; ?>" align="center" style="max-width: 5px"> <?php echo $no++; ?> </td>
																		<td rowspan="<?php echo $value['rowspan']; ?>" style="min-width: 100px"><?php echo $sg['segment_description']; ?></td>
																	<?php }
																}
																$checkpoint_sg_desc = 1;
															} ?>
															<td style="min-width: 300px"><?php echo $val['statement_description']; ?></td>
															<?php
																$indeks_sheet = 0;
																foreach($sheet as $se){
																	$stj = explode('||', $se['join_input']);
																	$stj_id = explode('||', $se['join_statement_id']);
																	$stj_temp[$i][$indeks_sheet++] = array(
																		'join_statement_id' => $stj_id[$i],
																		'join_input'		=> $stj[$i]
																	);
																if($stj[$i] == 1) echo "<td>1</td>";
																else if($stj[$i] == 2) echo "<td>2</td>";
																else if($stj[$i] == 3) echo "<td>3</td>";
																else if($stj[$i] == 4) echo "<td>4</td>";
																else if(empty($stj[$i]))echo "<td>-</td>";
																else echo '<td style="min-width:150px">'.$stj[$i].'</td>';}
															?>
															<td style="min-width: 70px">
																<?php
																	$total = 0;
																	for ($n=0; $n < count($stj_temp[$i]); $n++) { 
																		$total = $total + $stj_temp[$i][$n]['join_input'];
																	}
																	echo $total;
																?>
															</td>
															<td style="min-width: 70px">
																<?php
																	$total = 0;
																	for ($n=0; $n < count($stj_temp[$i]); $n++) { 
																		$total = $total + $stj_temp[$i][$n]['join_input'];
																		foreach ($GetQuestParticipant as $key => $qp) {
																			$rata_rata = $total/$qp['peserta_kuesioner'];
																		}
																	}
																	echo $rata_rata;
																?>
															</td>
														</tr>
															<?php
																$i++;
															}
														}
													}
													?>
												<?php }
												}
											?>
										</tbody>
									</table>
								</div>
								</div>
							</div>
							<hr>
							<div class="row" style="margin: 10px 10px">
								<div class="form-group">
									<div class="col-lg-12 text-right">
										<a href="javascript:window.history.go(-1);" class="btn btn-primary btn btn-flat">Back</a>
									&nbsp;&nbsp;
										<button type="submit" class="btn btn-success btn btn-flat">Confirm</button>
									</div>
								</div>
							</div>
							</form>
						</div>
					<?php } ?>
					</div>
				</div>
				</div>
			</div>		
		</div>		
	</div>
	</div>
</section>			
			
				