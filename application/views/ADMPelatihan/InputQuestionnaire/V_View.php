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
						<b>View Edit Kuesioner di Record</b>
					</div>
					<?php foreach($attendant as $at){$attendant=$at['attendant'];}?>
					<div class="box-body">
						<div class="col-lg-12" align="right">
							<button class="btn btn-success" data-toogle="tooltip" title="Jumlah lembar kuesioner serupa yang telah diinputkan" ><?php foreach($submitted as $sb){$sbm=$sb['submitted']; echo $sbm;} ?></button>
						</div>
					<form method="post" action="<?php echo base_url('ADMPelatihan/InputQuestionnaire/Add')?>">
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
						<?php $bagnum=0;?>
						<div class="col-lg-12 text-right">
							<div class="form-group">
								<div class="col-lg-12 text-right">
									<a href="<?php echo site_url('ADMPelatihan/InputQuestionnaire/cetakExcel/'.$SchedulingId.'/'.$QuestionnaireId)?>" class="btn btn-warning btn-flat" target="_blank">Export Excel</a>
								</div>
							</div>
						</div>
						<div class="row" style="margin: 10px 10px">
							<div class=" col-lg-12">
							<div  style="overflow-x: auto;">
								 <table class="datatable table table-striped table-bordered table-hover text-left" id="tblPenjadwalan">
										<?php 
											$no=0; $no++;
										?>
									<thead>
										<tr class="bg-primary">
											<td style="background-color: white; min-width:800px; margin: 0px;" hidden="true"></td>
											<td style="background-color: #337ab7; position: absolute; min-width:800px; height: 100px;text-align:center"><h4><b>Komponen Evaluasi</b></h4></td>
											<?php foreach($sheet as $se){ ?>
												<td style="min-width:300px;"><?php echo '<b>'.$no++.'</b>'; ?></td>
											<?php } ?>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td style="background-color: white; min-width:800px; margin: 0px;"></td>
											<?php foreach($sheet as $se){ ?>
												<td style="min-width:150px"><a href="<?php echo base_url('ADMPelatihan/InputQuestionnaire/edit/'.$se['scheduling_id'].'/'.$se['questionnaire_id'].'/'.$se['questionnaire_sheet_id']);?>" class="btn btn-xs btn-success"><i class="fa fa-edit"></i> Edit</a>
													<a href="<?php $id1=$SchedulingId;$id2=$QuestionnaireId;$id3=$se['questionnaire_sheet_id'];echo base_url('ADMPelatihan/InputQuestionnaire/delete/'.$id1.'/'.$id2.'/'.$id3)?>"  class="btn btn-danger btn-xs"><i class="fa fa-remove"></i> Delete</a>
													<?php foreach($statement as $st){ ?>
															<input type="text" name="txtStatementId[]" value="<?php echo $st['statement_id']?>" hidden>
													<?php } ?>
												</td>
										<?php } ?>
										</tr> 
										
											<?php
												$n=0;
												$i=0;
												$number=1;
											foreach($segment as $sg){
												foreach($statement as $st => $val){
													if ($sg['segment_id'] == $val['segment_id']) {
											?>
												<tr>
													<td style="position: absolute; background-color: white; outline: transparent; min-width:800px; margin: 0px;">
														<?php
															echo "<b>".$number++.'. '.$sg['segment_description']."</b>".' - '.$val['statement_description'];
														?>
													</td>
													<?php
														foreach($sheet as $se){
															$stj = explode('||', $se['join_input']);

														if($stj[$i] == 1) echo "<td>Sangat Tidak Setuju</td>";
														else if($stj[$i] == 2) echo "<td>Tidak Setuju</td>";
														else if($stj[$i] == 3) echo "<td>Setuju</td>";
														else if($stj[$i] == 4) echo "<td>Sangat Setuju</td>";
														else if(empty($stj[$i]))echo "<td>-</td>";
														else echo '<td>'.$stj[$i].'</td>';										
														}
														$i++;
													?>
												</tr>
													<?php
													}
												}
											}
											?>
									</tbody>
								</table>
							</div>
							</div>
						</div>
						<br>
						<?php ?>
						<hr>
						<div class="form-group">
							<div class="col-lg-12 text-right">
								<div class="form-group">
								<div class="col-lg-12 text-right">
								<a href="javascript:window.history.go(-1);" class="btn btn-primary btn btn-flat">Back</a>
								&nbsp;&nbsp;
								<a href="<?php echo base_url('ADMPelatihan/Record/Finished')?>" class="btn btn-danger btn btn-flat">Close</a>
								&nbsp;&nbsp;
								<?php if($sbm<$participant_number){?>
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