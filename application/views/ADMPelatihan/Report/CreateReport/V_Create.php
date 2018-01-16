<script src="<?php echo base_url('assets/js/ajaxSearch.js');?>"></script>

<section class="content">
	<div class="inner" >
	<div class="row">
		<div class="col-lg-12">
			<div class="row" >
				<div class="col-lg-12">
					<div class="col-lg-11">
						<div class="text-right">
						<h1><b>Create Training Report</b></h1>
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
						<b>Form Pembuatan Report Pelatihan</b>
					</div>
					<div class="box-body">
					<form method="post" action="<?php echo base_url('ADMPelatihan/Report/createReport')?>">
						<div class=" col-md-4">
							<div class="box-header with-border" style="margin-top: 10px">
						      <h3 class="box-title"><i class="fa fa-calendar-check-o"></i>   PELATIHAN</h3>
						    </div>
							<div class="row" style="margin: 10px 10px">
								<div class="form-group">
									<label class="col-md-3 control-label">Tanggal</label>
									<div class="col-md-9">
										<input name="txtTanggalPelaksanaan" class="form-control singledateADM checkdateSch" placeholder="Tanggal" id="checkdateSch" required >
									</div>
								</div>
							</div>
							<div class="row" style="margin: 10px 10px">
								<div class="form-group">
									<label class="col-md-3 control-label">Judul Training</label>
									<div class="col-md-9">
										<input name="txtNamaPelatihan" class="form-control toupper" placeholder="Nama Pelatihan" required value="" >
										<input name="txtTrainingId" value="" hidden>
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
										<input name="txtPesertaPelatihan" class="form-control toupper" placeholder="Seluruh Peserta" required value="" >
									</div>
								</div>
							</div>
							<div class="row" style="margin: 10px 10px">
								<div class="form-group">
									<label class="col-md-3 control-label">Peserta Hadir</label>
									<div class="col-md-9">
										<input name="txtPesertaHadir" class="form-control toupper" placeholder="Peserta Hadir" required value="" >
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
										<input name="txtPelaksana" class="form-control toupper" placeholder="Pelaksana" required value="">
									</div>
								</div>
							</div>
							<div class="row" style="margin: 10px 10px">
								<div class="form-group">
									<label class="col-md-3 control-label">Index Materi</label>
									<div class="col-md-9">
										<input name="txtIndexMateri" class="form-control toupper" placeholder="Index Materi" required value="">
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-12">
				          <div class="form-group">
				          	<div class="box-header with-border" style=" border-top: 1px solid #f4f4f4">
						      <h3 class="box-title" style="margin-top: 20px"></i>   DESKRIPSI KEGIATAN</h3>
						    </div>
				            <textarea class="textarea" name="txtdeskripsi" id="txtdeskripsi" placeholder="Masukkan deskripsi kegiatan..." style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
				          </div>
				        </div>
						<div class="col-lg-12">
				          <div class="form-group">
				            <div class="box-header with-border">
						      <h3 class="box-title" style="margin-top: 20px"></i>   EVALUASI REAKSI</h3>
						    </div>
				          </div>
				        </div>
						<div class="col-lg-12">
				          <div class="form-group">
				            <div class="box-header with-border">
						      <h3 class="box-title" style="margin-top: 20px"></i>   EVALUASI PEMBELAJARAN</h3>
						    </div>
				          </div>
				        </div>
						<div class="col-lg-12">
				          <div class="form-group">
				            <div class="box-header with-border">
						      <h3 class="box-title" style="margin-top: 20px"></i>   KENDALA YANG DIALAMI</h3>
						    </div>
				            <textarea class="textarea" name="txtkendala" id="txtkendala" placeholder="Masukkan kendala kegiatan..." style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
				          </div>
				        </div>
						<div class="col-lg-12">
				          <div class="form-group">
				          	<div class="box-header with-border">
						      <h3 class="box-title" style="margin-top: 20px"></i>   CATATAN PENTING</h3>
						    </div>
				            <textarea class="textarea" name="textcatatan" id="textcatatan" placeholder="Masukkan catatan penting..." style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
				          </div>
				        </div>
						<div class="form-group">
							<div class="col-md-12 text-right">
								<a href="<?php echo site_url('ADMPelatihan/Report/CreateReport');?>"  class="btn btn-primary btn btn-flat">Back</a>
								&nbsp;&nbsp;
								<button type="submit" class="btn btn-success btn btn-flat">Save Data</button>
							</div>
						</div>
					</form>
					</div>
				</div>
				</div>
			</div>		
		</div>		
	</div>
	</div>
</section>
