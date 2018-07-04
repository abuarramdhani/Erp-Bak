<script src="<?php echo base_url('assets/js/ajaxSearch.js');?>"></script>

<section class="content">
	<div class="inner" >
	<div class="row">
		<div class="col-lg-12">
			<div class="row" >
				<div class="col-lg-12">
					<div class="col-lg-11">
						<div class="text-right">
						<h1><b>Edit Training Report</b></h1>
						</div>
					</div>
					<div class="col-lg-1">
						<div class="text-right hidden-md hidden-sm hidden-xs">
                            <a class="btn btn-default btn-lg" href="<?php echo site_url('ADMPelatihan/Report/CreateReport');?>">
                                <i class="icon-wrench icon-2x"></i>
                                <span><br/></span>	
                            </a>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
				<div class="box box-primary box-solid">
					<div class="box-header with-border">
						<b>Form Edit Report Pelatihan</b>
					</div>
					<div class="box-body">
					<form method="post" action="<?php echo base_url('ADMPelatihan/Report/UpdateReport')?>">
					<?php foreach ($report as $rpt) {?>
						<div class=" col-md-4">
							<div class="box-header with-border" style="margin-top: 10px">
						      <h3 class="box-title"><i class="fa fa-calendar-check-o"></i>   PELATIHAN</h3>
						    </div>
							<div class="row" style="margin: 10px 10px">
								<div class="form-group">
									<label class="col-md-3 control-label">Judul Training</label>
									<div class="col-md-9">
										<input name="txtNamaPelatihan" class="form-control toupper" placeholder="Nama Pelatihan" required value="<?php echo $rpt['scheduling_or_package_name']?>" readonly>
										<input type="text" name="idReport" value="<?php echo $rpt['id_report']; ?>" hidden>
									</div>
								</div>
							</div>
							<div class="row" style="margin: 10px 10px">
								<div class="form-group">
									<label class="col-md-3 control-label">Tanggal</label>
									<div class="col-md-9">
									<?php 
										$date=$rpt['tanggal']; 
										$newDate=date("d/m/Y", strtotime($date));
									?>
										<input name="txtTanggalPelaksanaan" class="form-control singledateADM" placeholder="Tanggal" id="txtTanggalPelaksanaan" required 
										value="<?php echo $newDate; ?>" readonly>
									</div>
								</div>
							</div>
							<div class="row" style="margin: 10px 10px">
								<div class="form-group">
									<label class="col-md-3 control-label">Jenis Training</label>
									<div class="col-md-9">
										<select class="form-control select4" data-placeholder="Jenis Pelatihan" name="slcJenisPelatihan" required>
											<option></option>
												<?php $selected1=''; $selected2=''; $selected3='';
													if ($rpt['jenis']==0) { $selected1="selected"; } 
													if ($rpt['jenis']==1) { $selected2="selected";}
													if ($rpt['jenis']==2) { $selected3="selected";}
												?>
											<option <?php echo $selected1?> value="0">Softskill</option>
											<option <?php echo $selected2?> value="1">Hardskill</option>
											<option <?php echo $selected3?> value="2">Softskill & Hardskill</option>
										</select>
									</div>
								</div>
							</div>
						</div>
						<div class=" col-md-4">
							<div class="row" style="margin: 10px 10px">
								<div class="box-header with-border">
							      <h3 class="box-title"><i class="fa fa-users"></i>   PESERTA</h3>
							    </div>
							</div>
							<div class="row" style="margin: 10px 10px">
								<div class="form-group">
									<label class="col-md-3 control-label">Jumlah Peserta</label>
									<div class="col-md-9">
										<input name="txtPesertaPelatihan" class="form-control toupper" placeholder="Seluruh Peserta" required type="number" value="<?php echo $rpt['peserta_total'];?>">
									</div>
								</div>
							</div>
							<div class="row" style="margin: 10px 10px">
								<div class="form-group">
									<label class="col-md-3 control-label">Peserta Hadir</label>
									<div class="col-md-9">
										<input name="txtPesertaHadir" class="form-control toupper" placeholder="Peserta Hadir" required type="number" value="<?php echo $rpt['peserta_hadir'];?>">
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="row" style="margin: 10px 10px">
								<div class="box-header with-border">
							      <h3 class="box-title"><i class="fa fa-map-o"></i>   PELAKSANA & MATERI</h3>
							    </div>
							</div>
							<div class="row" style="margin: 10px 10px">
								<div class="form-group">
									<label class="col-md-3 control-label">Pelaksana</label>
									<div class="col-md-9">
										<select class="form-control select4" name="txtPelaksana[]" data-placeholder="Pelaksana" multiple="multiple" required>
											<option></option>
											<!-- <?php //foreach($trainer as $tr){?> -->
											<?php
												$slctedtrainer = explode(',', $rpt['pelaksana']);
												foreach($trainer as $tr){
														$trainers='';
														if(in_array($tr['trainer_id'], $slctedtrainer)){$trainers='selected';}
											?>
											<option <?php echo $trainers ?> value="<?php echo $tr['trainer_id']?>" value="<?php echo $rpt['pelaksana']?>"><?php echo $tr['trainer_name'] ?></option>
											<?php }?>
										</select>
										<!-- <input name="txtPelaksana" class="form-control toupper" placeholder="Pelaksana" required value="<?php echo $rpt['pelaksana']?>"> -->
									</div>
								</div>
							</div>
							<div class="row" style="margin: 10px 10px">
								<div class="form-group">
									<label class="col-md-3 control-label">Index Materi</label>
									<div class="col-md-9">
										<input name="txtIndexMateri" class="form-control toupper" placeholder="Index Materi" required value="<?php echo $rpt['index_materi']?>">
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-12">
				          <div class="form-group">
				          	<div class="box-header with-border" style=" border-top: 1px solid #f4f4f4">
						      <h3 class="box-title" style="margin-top: 20px"></i>   DESKRIPSI KEGIATAN</h3>
						    </div>
				            <textarea class="textarea" name="txtdeskripsi" id="txtdeskripsi" placeholder="Masukkan deskripsi kegiatan..." style="width: 100%; height: 300px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px; table-layout: auto;"><?php echo $rpt['description']?></textarea>
				          </div>
				        </div>
						<div class="col-lg-12">
				          <div class="form-group">
				            <div class="box-header with-border">
						      <h3 class="box-title" style="margin-top: 20px"></i>   EVALUASI REAKSI</h3>
						    </div>
							<div class="table-responsive" style="overflow:scroll; max-height: 500px;max-width: 2000px" id="tbevalReaksi">
								<table class="table table-bordered table-striped table-hover table-condensed" id="tbodyevalReaksi">
									<thead class="bg-blue">
										<tr>
											<th style="text-align:center;vertical-align: middle; width: 50px" rowspan="2">No</th>
											<th style="vertical-align: middle;text-align:center; width: 250px" rowspan="2">Komponen Evaluasi</th>
											<th style="vertical-align: middle;text-align:center;" rowspan="2" hidden="true">Id</th>
											<th style="vertical-align: middle;text-align:center;" rowspan="2" hidden="true">Segmen</th>
											<th colspan="<?php echo $jmlrowPck; ?>" style="text-align:center;">Rata-rata</th>
										</tr>
										<tr>
											<?php foreach ($countPel as $ct) {
												foreach ($GetSchName_QuesName_RPTPCK as $sp) { ?>
													<td style="text-align:center;">
														<?php
															echo $sp['scheduling_name'];
														?>
														<input type="text" name="txtSchId[]" value="<?php echo $sp['scheduling_id']?>" hidden="true">
														<input type="text" name="txtPckSchId" value="<?php echo $sp['package_scheduling_id']?>" hidden="true">
													</td>
												<?php }
											} ?>
										</tr>
									</thead>
									<tbody>
									<?php
										$no=1;
										foreach ($justSegmentPck as $jspk) {
											?>
											<tr>
												<td style="text-align:center;"><?php echo $no++; ?></td>
												<td>
													<?php
														echo $jspk['segment_description'];
													?>
												</td>
												<td hidden="true">
													<?php foreach ($GetQueIdReportPaket as $qidp) {
														print_r($qidp);
													} ?>
												</td>
												<td hidden="true">
													<?php
													foreach ($GetSchName_QuesName_RPTPCK as $schid) {
														foreach ($GetSchName_QuesName_segmen as $sgm) {
															if ($schid['scheduling_id'] == $sgm['scheduling_id'] && $jspk['segment_description'] == $sgm['segment_description']) {
																print_r($sgm);
																echo "<br>";
															}
														} 
													}?>
												</td>
												<?php 
												foreach ($GetSchName_QuesName_RPTPCK as $spk) {
													$checkpoint=0;
													foreach ($t_nilai as $tot) {
														if ($jspk['segment_description'] == $tot['segment_description'] && $spk['scheduling_id'] == $tot['scheduling_id']) {
															echo '<td>'.round($tot['f_rata'],2).'</td>';
															$checkpoint++;
														}
													}
													
													if ($checkpoint==0) {
														echo "<td>-</td>";
														$checkpoint++;
													}
												}
												?>
											</tr>
										<?php }?>	
									</tbody>
								</table>
							</div>
				          </div>
				        </div>
				         <div class="form-group">
							<div class="box-header with-border">
						      <h3 class="box-title" style="margin-top: 20px"></i>   KOMENTAR</h3>
						    </div>
						    <?php ?>
							    <ul style="list-style: disc;">
							    	<?php
							    		echo '<li>'.implode('</li><li>', $komen);
							    		for ($i=0; $i < count($komen) ; $i++) { 
							    			echo ''; //agar bullet hanya sesuai jumlah row
							    		}
							    	?>
							    </ul>
						    <?php ?>
						</div>
				        <div class="col-lg-12">
				          <div class="form-group">
				            <div class="box-header with-border">
						      <h3 class="box-title" style="margin-top: 20px"></i>   EVALUASI PEMBELAJARAN</h3>
						    </div>
							<div class="table-responsive" style="overflow:scroll; max-height: 500px; max-width: 2000px" id="tbevalPembelajaran">
								<table class="table table-bordered table-striped table-hover table-condensed" style="table-layout: fixed;" name="tbodyevalPembelajaran" id="tbodyevalPembelajaran">
									<thead class="bg-blue">
										<tr>
											<th style="text-align:center;vertical-align: middle; width: 50px" rowspan="2">No</th>
											<th style="text-align:center;vertical-align: middle;width: 300px" rowspan="2">Nama</th>
											<th style="text-align:center;vertical-align: middle; width: 100px" rowspan="2">Noind</th>
											<th colspan="<?php echo $jmlrowPck; ?>" style="text-align:center;vertical-align: middle">Nilai Test</th>
										</tr>
										<tr>
											<?php foreach ($countPel as $ct) {
												foreach ($GetSchName_QuesName_RPTPCK as $sp) { ?>
													<td style="text-align:center;">
														<?php
															echo $sp['scheduling_name'];
														?>
														<input type="text" name="txtSchId2[]" value="<?php echo $sp['scheduling_id']?>" hidden="true">
														<input type="text" name="txtPckSchId2" value="<?php echo $sp['package_scheduling_id']?>" hidden="true">
													</td>
												<?php }
											} ?>
										</tr>
									</thead>
									<tbody id="tbodyEvalPembelajaran">
											<?php 
												$no=1; foreach ($participantName as $prt) {		
											?>
										<tr class="clone" row-id="<?php echo $no; ?>">
											<td style="text-align:center;"><?php echo $no++; ?></td>
											<td>
												<?php echo $prt['participant_name'];?>
											</td>
											<td style="text-align: center;">
												<?php echo $prt['noind']; ?>
											</td>
												<?php 
												$stafdata = array();
												$nonstafdata = array();
												foreach ($GetSchName_QuesName_RPTPCK as $spk) {
													$checkpoint=0;
													foreach ($participant as $p) 
													{
														// AMBIL STANDAR KELULUSAN STAF DAN NONSTAF-------------------
														$nilai_minimum = explode(',', $spk['standar_kelulusan']);
														$min_s = $nilai_minimum[0];
														$min_n = $nilai_minimum[1];
														if ($spk['scheduling_id'] == $p['scheduling_id'] && $prt['participant_name'] == $p['participant_name']) 
														{
															// NOMOR INDUK YANG STAF DAN NONSTAFF UNTUK MEMBEDAKAN 
															$staffCode = array('B', 'D', 'J', 'Q');
															$indCode = substr($p['noind'], 0, 1);
															if (in_array($indCode, $staffCode)) 
															{
																$a='stafKKM';
																array_push($stafdata, $p['noind'] );
															}
															else
															{
																$a='nonstafKKM';
																array_push($nonstafdata, $p['noind'] );
															}
															// --------------------------------------------------------------------------------------------------------------
															// KONDISI APABILA ADA PESERTA REMIDI
															// STAF
															if ($p['score_eval2_post']>=$min_s) 
															{
																$nilai_s='<td>'.$p['score_eval2_post'].'</td>';
															}
															elseif ($p['score_eval2_r1']>=$min_s)
															{
																$nilai_s='<td><font color="red">'.$p['score_eval2_post'].'</font> /'.$p['score_eval2_r1'].'</td>';
															}
															elseif ($p['score_eval2_r2']>=$min_s)
															{
																$nilai_s='<td><font color="red">'.$p['score_eval2_post'].'/'.$p['score_eval2_r1'].'</font> /'.$p['score_eval2_r2'].'</td>';
															}
															elseif ($p['score_eval2_r3']>=$min_s)
															{
																$nilai_s='<td><font color="red">'.$p['score_eval2_post'].'/'.$p['score_eval2_r1'].'/'.$p['score_eval2_r2'].'</font> /'.$p['score_eval2_r3'].'</td>';
															}
															else
															{
																$nilai_s='<td>-</td>';
															}
															//NONSTAF---------------------------------------------------------------------------------------------------------
															if ($p['score_eval2_post']>=$min_n) 
															{
																$nilai_n='<td>'.$p['score_eval2_post'].'</td>';
															}
															elseif ($p['score_eval2_r1']>=$min_n)
															{
																$nilai_n='<td><font color="red">'.$p['score_eval2_post'].'</font> /'.$p['score_eval2_r1'].'</td>';
															}
															elseif ($p['score_eval2_r2']>=$min_n)
															{
																$nilai_n='<td><font color="red">'.$p['score_eval2_post'].'/'.$p['score_eval2_r1'].'</font> /'.$p['score_eval2_r2'].'</td>';
															}
															elseif ($p['score_eval2_r3']>=$min_n)
															{
																$nilai_n='<td><font color="red">'.$p['score_eval2_post'].'/'.$p['score_eval2_r1'].'/'.$p['score_eval2_r2'].'</font> /'.$p['score_eval2_r3'].'</td>';
															}
															else
															{
																$nilai_n='<td>-</td>';
															}
															// --------------------------------------------------------------------------------------------------------------
															// ISI STAFDATA DAN NONSTAFDATA
															if ($stafdata!=null && $nonstafdata==null) 
															{
																echo $nilai_s;
															} 
															else 
															{
																echo $nilai_n;
															}
															// --------------------------------------------------------------------------------------------------------------
															$checkpoint++;
														}
													}
													if ($checkpoint==0) {
														echo "<td>-</td>";
														$checkpoint++;
													}
												}
												?>  										
											</td>
										</tr>
										<?php } ?>
									</tbody>
								</table>
							</div>
				          </div>
				        </div>
						<div class="col-lg-12">
				          <div class="form-group">
				            <div class="box-header with-border">
						      <h3 class="box-title" style="margin-top: 20px"></i>   KENDALA YANG DIALAMI</h3>
						    </div>
				            <textarea class="textarea" name="txtkendala" id="txtkendala" placeholder="Masukkan kendala kegiatan..." style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php echo $rpt['kendala'] ?></textarea>
				          </div>
				        </div>
						<div class="col-lg-12">
				          <div class="form-group">
				          	<div class="box-header with-border">
						      <h3 class="box-title" style="margin-top: 20px"></i>   CATATAN PENTING</h3>
						    </div>
				            <textarea class="textarea" name="textcatatan" id="textcatatan" placeholder="Masukkan catatan penting..." style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php echo $rpt['catatan'] ?></textarea>
				          </div>
				        </div>
				        <div class="col-md-12">
							<div class="box-header with-border" style="margin-top: 10px">
						      <h3 class="box-title"><i class="fa fa-file"></i>   KETERANGAN DOKUMEN</h3>
						    </div>
							<div class="table-responsive">
								<table class="table table-sm table-bordered table-hover text-center">
									<thead>
										<tr style="background-color: lightblue;">
											<th>Document No</th>
											<th>Rev No</th>
											<th>Rev Date</th>
											<th>Rev Note</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td><input name="txtDocNo" class="form-control" placeholder="Nomor Dokumen" value="<?php echo $rpt['doc_no']?>"></td>
											<td><input name="txtRevNo" class="form-control" placeholder="Nomor Revisi" value="<?php echo $rpt['rev_no']?>"></td>
											<td>
											<?php 
												$date=$rpt['rev_date']; 
												$newDate=date("d/m/Y", strtotime($date));
												$nulldate=$rpt['rev_date'];
												if ($nulldate=='0001-01-01 BC' || $nulldate=='0001-01-01') {
													$givenull='';
													$rpt['rev_date']=$givenull;
													?>
													<input name="txtRevDate" class="form-control singledateADM" placeholder="Tanggal Revisi" value="<?php echo $givenull ?>">
												<?php }else{ ?>
													<input name="txtRevDate" class="form-control singledateADM" placeholder="Tanggal Revisi" value="<?php echo $newDate ?>">
												<?php }
											?>
											</td>
											<td><input name="txtRevNote" class="form-control" placeholder="Catatan Revisi" value="<?php echo $rpt['rev_note']?>"></td>
										</tr>
									</tbody>
								</table>
								<table class="table table-sm table-bordered table-hover text-center">
									<thead>
										<tr style="background-color: mistyrose;">
											<th>Tempat</th>
											<th>Tanggal Dibuat</th>
											<th>Nama</th>
											<th>Jabatan</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td><input name="txtTempat" class="form-control" value="Yogyakarta" readonly="true" value="<?php echo $rpt['tmptdoc']?>"></td>
											<td>
											<?php 
												$date=$rpt['tgldoc']; 
												$newDate=date("d/m/Y", strtotime($date));
											?>
												<input name="txtTglDibuat" class="form-control singledateADM" placeholder="Tanggal Dibuat" value="<?php echo $newDate?>"></td>
											<td><input name="txtNamaACC" class="form-control" placeholder="Nama Pengirim" value="<?php echo $rpt['nama_acc']?>"></td>
											<td><input name="txtJabatanACC" class="form-control" placeholder="Jabatan" value="<?php echo $rpt['jabatan_acc']?>"></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-12 text-right">
								<a href="<?php echo site_url('ADMPelatihan/Report/CreateReport');?>"  class="btn btn-primary btn btn-flat">Back</a>
								&nbsp;&nbsp;
								<button type="submit" class="btn btn-success btn btn-flat">Save Data</button>
							</div>
						</div>
					<?php } ?>
					</form>
					</div>
				</div>
				</div>
			</div>		
		</div>		
	</div>
	</div>
</section>
