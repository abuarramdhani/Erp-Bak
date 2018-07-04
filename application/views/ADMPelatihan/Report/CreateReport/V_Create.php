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
					<form method="post" action="<?php echo base_url('ADMPelatihan/Report/AddReport')?>">
						<div class=" col-md-4">
							<div class="box-header with-border" style="margin-top: 10px">
						      <h3 class="box-title"><i class="fa fa-calendar-check-o"></i>   PELATIHAN</h3>
						    </div>
						    <div class="row" style="margin: 10px 10px">
								<div class="form-group">
									<label class="col-md-3 control-label">Kategori Pelatihan</label>
									<div class="col-md-9">
										<!-- <input name="txtIf" class="form-control toupper" value="" type="hidden"> -->
										<select id="KatPelatihan" onchange="funKatPelatihan()" class="form-control select4" name="txtKategoriPelatihan" data-placeholder="Kategori Pelatihan" required >
											<option></option>
											<option value="0">Reguler</option>
											<option value="1">Paket</option>
										</select>
									</div>
								</div>
							</div>
							<div class="row" style="margin: 10px 10px">
								<div class="form-group">
									<label class="col-md-3 control-label">Judul Training</label>
									<div class="col-md-9">
										<input name="idNama" id="idNama" type="hidden" placeholder="Nama Pelatihan">
										<select class="form-control select4" onchange="funGetPelatihan()" name="nama" id="nama" data-placeholder="Nama Pelatihan" required disabled="true">
											<option></option>
											<?php foreach($pelatihan as $pl){?>
											<option value="<?php echo $pl['scheduling_name']?>"><?php echo $pl['scheduling_name'] ?></option>
											<?php }?>
										</select>
									</div>
								</div>
							</div>
							<div class="row" style="margin: 10px 10px">
								<div class="form-group">
									<label class="col-md-3 control-label">Tanggal</label>
									<div class="col-md-9">
										<input name="idTanggal" id="idTanggal" type="hidden" placeholder="Tanggal Pelatihan" >
										<input name="tanggal" onchange="funGetPelatihan()" id="tanggal" class="form-control singledateADM" placeholder="Tanggal Mulai Pelatihan" id="txtTanggalPelaksanaan" required disabled="true">
									</div>
								</div>
							</div>
							<div class="row" style="margin: 10px 10px">
								<div class="form-group">
									<label class="col-md-3 control-label">Jenis Training</label>
									<div class="col-md-9">
										<select name="slcJenisPelatihan" class="select4 form-control" data-placeholder="Jenis Pelatihan" id="slcJenisPelatihan">
											<option></option>
											<option value="0">Softskill</option>
											<option value="1">Hardskill</option>
											<option value="2">Softskill & Hardskill</option>
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
										<input name="txtPesertaPelatihan" id="txtPesertaPelatihan" class="form-control" placeholder="Seluruh Peserta" readonly>
									</div>
								</div>
							</div>
							<div class="row" style="margin: 10px 10px">
								<div class="form-group">
									<label class="col-md-3 control-label">Peserta Hadir</label>
									<div class="col-md-9">
										<input name="txtPesertaHadir" id="txtPesertaHadir" class="form-control" placeholder="Peserta Hadir" readonly>
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
									<input name="txtPelaksana" class="form-control" id="txtPelaksana" placeholder="Nama Trainer" readonly>
									<input name="idtrainerOnly" id="idtrainerOnly" type="hidden">
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
				            <textarea class="textarea" name="txtdeskripsi" id="txtdeskripsi" placeholder="Masukkan deskripsi kegiatan..." style="width: 100%; height: 300px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
				          </div>
				        </div>
						<div class="col-lg-12">
				          <div class="form-group">
				            <div class="box-header with-border">
						      <h3 class="box-title" style="margin-top: 20px"></i>   EVALUASI REAKSI</h3>
						    </div>
							<div class="table-responsive" id="tbevalReaksi">
							</div>
				          </div>
				        </div>
				        <div class="col-lg-12">
				          <div class="form-group">
				            <div class="box-header with-border">
						      <h3 class="box-title" style="margin-top: 20px"></i>   EVALUASI PEMBELAJARAN</h3>
						    </div>
							<div class="table-responsive" style="overflow:scroll; max-height: 500px" id="tbevalPembelajaran">
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
											<td><input name="txtDocNo" value="FRM-HRM-03-13" class="form-control" placeholder="Nomor Dokumen" readonly></td>
											<td><input name="txtRevNo" class="form-control" placeholder="Nomor Revisi" value="01" readonly></td>
											<td><input name="txtRevDate" class="form-control" value="20/11/2017" placeholder="Tanggal Revisi" readonly></td>
											<td><input name="txtRevNote" value="-" class="form-control" placeholder="Catatan Revisi" readonly></td>
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
											<td><input name="txtTempat" class="form-control" value="Yogyakarta" readonly="true"></td>
											<td><input name="txtTglDibuat" class="form-control singledateADM" placeholder="Tanggal Dibuat"></td>
											<td><input name="txtNamaACC" class="form-control" placeholder="Nama Pengirim"></td>
											<td><input name="txtJabatanACC" class="form-control" placeholder="Jabatan"></td>
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
					</form>
					</div>
				</div>
				</div>
			</div>		
		</div>		
	</div>
	</div>
</section>
