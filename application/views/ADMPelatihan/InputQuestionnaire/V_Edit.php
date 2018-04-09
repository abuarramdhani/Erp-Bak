<script src="<?php echo base_url('assets/js/ajaxSearch.js');?>"></script>

<section class="content">
	<div class="inner" >
	<div class="row">
		<div class="col-lg-12">
			<div class="row" >
				<div class="col-lg-12">
					<div class="col-lg-11">
						<div class="text-right">
						<h1><b>Input Kuesioner</b></h1>
						</div>
					</div>
					<div class="col-lg-1">
						<div class="text-right hidden-md hidden-sm hidden-xs">
                            <a class="btn btn-default btn-lg" href="<?php echo site_url('ADMPelatihan/Record/Finished');?>">
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
						<b>Form Pembuatan Master Training</b>
					</div>
					<?php foreach($attendant as $at){$attendant=$at['attendant'];}?>
					<div class="box-body">
						<div class="col-lg-12" align="right">
							<button class="btn btn-success" data-toogle="tooltip" title="Jumlah lembar kuesioner serupa yang telah diinputkan" ><?php foreach($submitted as $sb){$sbm=$sb['submitted']; echo $sbm;} ?></button>
						</div>
					<form method="post" action="<?php echo base_url('ADMPelatihan/InputQuestionnaire/update');?>">
						<?php
							foreach($training as $tr) { 
							$participant_number = $tr['participant_number'];
							$strainer = explode(',', $tr['trainer']);
								foreach ($questionnaire as $qe) {
						?>
							<div class="row" align="center">
								<h3><b><?php echo $qe['questionnaire_title']?></b></h3>
								<br>
							</div>
						<?php }?>
						<div class="row" style="margin: 10px 10px">
							<div class="form-group">
								<label class="col-lg-2 control-label">Nama Trainer</label>
								<div class="col-lg-4">
									<?php
										foreach($strainer as $st){
											foreach($trainer as $tn){
												if($st==$tn['trainer_id']){
										?>
									<input class="form-control" value="<?php echo $tn['trainer_name'] ?>" readonly >
									<input type="text" name="txtSchedulingId" value="<?php echo $SchedulingId ?>" hidden >
									<input type="text" name="txtQuestionnaireId" value="<?php echo $QuestionnaireId ?>" hidden >
									<input type="text" name="txtQuestionnaireSheetId" value="<?php echo $QuestionnaireSheetId ?>" hidden >
									<?php }}} ?>
								</div>
								<label class="col-lg-2 control-label">Prog. Pelatihan</label>
								<div class="col-lg-4">
									<input name="txtNamaPelatihan" class="form-control toupper" value="<?php echo $tr['scheduling_name'] ?>" readonly >
								</div>
							</div>
						</div>
						<div class="row" style="margin: 10px 10px">
							<div class="form-group">
								<label class="col-lg-2 control-label">Ruang</label>
								<div class="col-lg-4">
									<input name="txtRuang" class="form-control" value="<?php echo $tr['room'] ?>" readonly >
								</div>
								<label class="col-lg-2 control-label">Tanggal</label>
								<div class="col-lg-4">
									<input name="txtBatas" class="form-control" value="<?php echo $tr['date_format'] ?>" readonly >
								</div>
							</div>
						</div>
						<br>
						<?php } ?>
						<?php
						$bagnum=0;
						$sgIdDat = array();
						foreach($segmentessay as $sge){
							$sgIdDat[] = $sge['segment_id'];
						}
						foreach($segment as $sg){
								if (!in_array($sg['segment_id'], $sgIdDat)) {
							$bagnum++ ?>
							<div class="row" style="margin: 10px 10px">
								<div class="table-responsive col-lg-12" >
									<table class="table table-sm table-bordered table-hover text-center" style="table-layout: fixed;">
										<thead>
											<tr class="bg-primary">
												<th width="5%">No</th>
												<th width="55%"><?php echo 'Bagian '.$bagnum.' - '.$sg['segment_description'] ?></th>
												<th>Sangat Setuju</th>
												<th>Setuju</th>
												<th>Tidak Setuju</th>
												<th>Sangat Tidak Setuju</th>
											</tr>
										</thead>
										<tbody>
											<?php 
												$no=0;
												foreach($statement as $st){
													if($sg['segment_id']==$st['segment_id']){
														$no++;
														$check4 ='';
														$check3 ='';
														$check2 ='';
														$check1 ='';
														foreach ($sheetEdit as $se1) {
															if ($se1['questionnaire_id'] == $st['questionnaire_id']) {
																$chck 	= explode('||', $se1['join_input']);
																$chckId	= explode('||', $se1['join_statement_id']);
																for ($chkNum=0; $chkNum < count($chck) ; $chkNum++) { 
																	if ($chckId[$chkNum] == $st['statement_id']) {
																		if ($chck[$chkNum] == 4) {
																			$check4 ='checked';
																		}elseif ($chck[$chkNum] == 3) {
																			$check3 ='checked';
																		}elseif ($chck[$chkNum] == 2) {
																			$check2 ='checked';
																		}elseif ($chck[$chkNum] == 1) {
																			$check1 ='checked';
																		}
																	}
																}
															}
														}
											?>
											<tr>
												<td><?php echo $no?></td>
												<td style="text-align:left;"><?php echo $st['statement_description']?><input type="text" name="txtStatementId[]" value="<?php echo $st['statement_id']?>" hidden></td>
												<td style="padding: 0px;vertical-align: middle;"><input type="radio" class="radio2" name="<?php echo 'txtInput'.$st['statement_id'] ?>" value="4" <?php echo $check4; ?>></td>
												<td style="padding: 0px;vertical-align: middle;"><input type="radio" class="radio2" name="<?php echo 'txtInput'.$st['statement_id'] ?>" value="3" <?php echo $check3; ?>></td>
												<td style="padding: 0px;vertical-align: middle;"><input type="radio" class="radio2" name="<?php echo 'txtInput'.$st['statement_id'] ?>" value="2" <?php echo $check2; ?>></td>
												<td style="padding: 0px;vertical-align: middle;"><input type="radio" class="radio2" name="<?php echo 'txtInput'.$st['statement_id'] ?>" value="1" <?php echo $check1; ?>></td>
											</tr>
											<?php 	}
												}
												?>
										</tbody>
									</table>
								</div>
							</div>
							<br>
						<?php }
						}?>
						<?php
						foreach($segmentessay as $sge){
							$bagnum++ ?>
							<div class="row" style="margin: 10px 10px">
								<div class="table-responsive col-lg-12" >
									<table class="table table-sm table-bordered table-hover text-center" style="table-layout: fixed;">
										<thead>
											<tr class="bg-primary">
												<th width="5%">No</th>
												<th width="40%"><?php echo 'Bagian '.$bagnum.' - '.$sg['segment_description'] ?></th>
												<th>Jawab</th>
											</tr>
										</thead>
										<tbody>
											<?php 
												$no=0;
												foreach($statement as $st){
													if($sge['segment_id']==$st['segment_id']){ $no++
											?>
											<tr>
												<td><?php echo $no?></td>
												<td style="text-align:left;"><?php echo $st['statement_description']?><input type="text" name="txtStatementId[]" value="<?php echo $st['statement_id']?>" hidden></td>
												<td>
												<?php
													$jawabVal = '';
													foreach ($sheetEdit as $se1) {
															$chck 			= explode('||', $se1['join_input']);
															$chckId			= explode('||', $se1['join_statement_id']);
																for ($chkNum=0; $chkNum < count($chck) ; $chkNum++) {
																	if ($chckId[$chkNum] == $st['statement_id']) {
																			$jawabVal = $chck[$chkNum];
																	}
																}
													?>
													<input class="form-control" type="text" placeholder="komentar" name="<?php echo 'txtInput'.$st['statement_id'] ?>" value="<?php echo $jawabVal; ?>" >
												<?php }?>
												</td>
											</tr>
											<?php }} ?>
										</tbody>
									</table>
								</div>
							</div>
							<br>
						<?php }?>
						<hr>
						<div class="form-group">
							<div class="col-lg-12 text-right">
								<a href="javascript:window.history.go(-1);" class="btn btn-primary btn btn-flat">Back</a>
								&nbsp;&nbsp;
								<a href="<?php echo base_url('ADMPelatihan/Record/Finished')?>" class="btn btn-danger btn btn-flat">Close</a>
								&nbsp;&nbsp;
								<?php if($sbm<$participant_number){?>
								<button type="submit" class="btn btn-success btn btn-flat">Save Data</button>
								<?php } elseif($sbm==$participant_number){?>
								<button type="submit" class="btn btn-success btn btn-flat">Save Data</button>
								<?php } ?>
							</div>
						</div>
					<form>
					</div>
				</div>
				</div>
			</div>		
		</div>		
	</div>
	</div>
</section>

<script type="text/javascript">

	var submitted 	= <?php echo $sbm?>;
	var attendant 	= <?php echo $attendant?>;
	if (submitted > attendant) {
		if (confirm("Jumlah kuesioner yang diinput telah melebihi jumlah peserta yang hadir. Namun Anda masih dapat melanjutkan hingga jumlahnya mencapai jumlah peserta yang dijadwalkan. \nIngin melanjutkan penginputan?") != true) {
		window.location  = "<?php echo base_url('ADMPelatihan/InputQuestionnaire/ToCreate/'.$SchedulingId)?>";
		}
	}

</script>