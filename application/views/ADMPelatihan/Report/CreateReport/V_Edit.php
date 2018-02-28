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
									<!-- <?php foreach ($peserta_regular as $pr) {?> -->
										<input name="txtPesertaPelatihan" class="form-control toupper" placeholder="Seluruh Peserta" required type="number" value="<?php echo $rpt['peserta_total'];?>">
									<!-- <?php } ?> -->
									</div>
								</div>
							</div>
							<div class="row" style="margin: 10px 10px">
								<div class="form-group">
									<label class="col-md-3 control-label">Peserta Hadir</label>
									<div class="col-md-9">
									<!-- <?php foreach ($participant as $pt) {?> -->
										<input name="txtPesertaHadir" class="form-control toupper" placeholder="Peserta Hadir" required type="number" value="<?php echo $rpt['peserta_hadir'];?>">
									<!-- <?php } ?> -->
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
										<select class="form-control select4" name="txtPelaksana[]" id="txtPelaksana" data-placeholder="Pelaksana" multiple="multiple" required >
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
				            <textarea class="textarea" name="txtdeskripsi" id="txtdeskripsi" placeholder="Masukkan deskripsi kegiatan..." style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px; table-layout: auto;"><?php echo $rpt['description']?></textarea>
				          </div>
				        </div>
						<div class="col-lg-12">
				          <div class="form-group">
				            <div class="box-header with-border">
						      <h3 class="box-title" style="margin-top: 20px"></i>   EVALUASI REAKSI</h3>
						    </div>
							<div class="table-responsive" style="overflow:scroll; max-height: 500px" id="tbevalReaksi">
								<table class="table table-bordered table-striped table-condensed" id="tbodyevalReaksi">
									<thead class="bg-blue">
										<tr>
											<th width="5%" style="text-align:center;">No</th>
											<th width="60%">Komponen Evaluasi</th>
											<th width="35%%">Rata-rata</th>
										</tr>
									</thead>
									<tbody>
										<?php
											$no=1; foreach($GetSchName_QuesName_RPT as $sq){ ?>
												<input type="text" name="txtSchId[]" value="<?php echo $sq['scheduling_id']?>" hidden="true">
												<input type="text" name="txtPckSchId" value="0" hidden="true">
												<?php 
												foreach ($GetSchName_QuesName_segmen as $segmen) {
													if ($sq['scheduling_id'] == $segmen['scheduling_id'] && $sq['questionnaire_id'] == $segmen['questionnaire_id']) {
														$n=0;
														$i=0;
												?>
													<tr>
														<td style="text-align:center;"><?php echo $no++; ?></td>
														<?php
															echo '<td>'.$segmen['segment_description'].'</td>';
														?>
														<td>
															<?php 
																foreach ($t_nilai as $tot) {
																	if ($tot['scheduling_id'] == $segmen['scheduling_id'] && $tot['questionnaire_id'] == $segmen['questionnaire_id'] && $tot['segment_id'] == $segmen['segment_id']) {
																		echo round($tot['f_rata'],2);
																	}
																}
															?>
														</td>
													</tr>
										<?php $i++; }
											}
										}?>
									</tbody>
								</table>
							</div>
				          </div>
				        </div>
				        <div class="col-lg-12">
				          <div class="form-group">
				            <div class="box-header with-border">
						      <h3 class="box-title" style="margin-top: 20px"></i>   EVALUASI PEMBELAJARAN</h3>
						    </div>
							<div class="table-responsive" style="overflow:scroll; max-height: 500px" id="tbevalPembelajaran">
								<table class="table table-bordered table-striped table-condensed" style="table-layout: fixed;" name="tbodyevalPembelajaran" id="tbodyevalPembelajaran">
									<thead>
										<tr class="bg-primary">
											<th width="5%" style="text-align:center;">No</th>
											<th width="50%">Nama</th>
											<th >Noind</th>
											<th >Post-Test</th>
										</tr>
									</thead>
									<tbody id="tbodyEvalPembelajaran">
											<?php 
												$no=1; foreach ($participant_reg as $prt) {		
											?>
										<tr class="clone" row-id="<?php echo $no; ?>">
											<td style="text-align:center;"><?php echo $no++; ?></td>
											<td>
												<?php echo $prt['participant_name'];?>
											</td>
											<td>
												<?php echo $prt['noind']; ?>
											</td>
											<td>
												<?php if ($prt['score_eval2_post']==NULL) {
													echo "-";
												}else{
													echo $prt['score_eval2_post']; 
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
