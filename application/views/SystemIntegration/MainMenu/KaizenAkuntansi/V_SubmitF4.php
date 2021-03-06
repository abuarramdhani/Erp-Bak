<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<b><h1><?=$Title ?></h1></b>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header with-border">
								
							</div>
							<div class="box-body">
								<div class="row">
									<div class="col-lg-12">
										<form>
											<div class="col-lg-6">
												<div class="form-group">
													<label>Ide Kaizen</label>														
													<select class="select2" style="width: 100%" id="slc-SI-SubmitF4-IdeKaizen" data-placeholder="Pilih Judul..."> 
														<option></option>
														<?php 
														if (isset($ide) && !empty($ide)) {
															foreach ($ide as $key => $value) {
																$encrypted_string = $this->encrypt->encode($value['kaizen_id']);
																$encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
															?>
															<option value="<?php echo $encrypted_string ?>"><?php echo $value['ide'] ?></option>
															<?php
															}
														}else{
															if (isset($kaizen[0]['kaizen_id'])) {
																$encrypted_string = $this->encrypt->encode($kaizen[0]['kaizen_id']);
																$encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
																?>
																<option value="<?php echo $encrypted_string ?>" selected><?php echo $kaizen[0]['ide'] ?></option>
																<?php
															}
														}
														?>
													</select>
												</div>
											</div>
											<div class="col-lg-3">
												<div class="form-group">
													<label>Nama Pencetus Ide</label>
													<input type="text" class="form-control" id="txt-SI-SubmitF4-NamaPencetus" readonly value="<?php echo $this->session->employee ?>">
												</div>
											</div>
											<div class="col-lg-3">
												<div class="form-group">
													<label>Nomor Induk Pencetus Ide</label>
													<input type="text" class="form-control" id="txt-SI-SubmitF4-NoindPencetus" readonly value="<?php echo $this->session->user ?>">
												</div>
											</div>
											<div class="col-lg-12">
												<div class="form-group">
													<label>Judul Kaizen</label>
													<input type="text" id="txt-SI-SubmitF4-JudulKaizen" placeholder="Masukkan judul kaizen..." class="form-control" value="<?php echo isset($kaizen[0]['judul']) ? $kaizen[0]['judul'] : '' ?>">
												</div>
											</div>
											<div class="col-lg-12">
												<div class="form-group">
													<input type="checkbox" id="chk-SI-SubmitF4-Komponen" class="form-control">
													&nbsp;&nbsp;&nbsp;
													<label>Kaizen Komponen</label>
													<select id="slc-SI-SubmitF4-Komponen" style="width: 100%" multiple="multiple" data-placeholder="Pilih Komponen..." disabled></select>
												</div>
											</div>
											<div class="col-lg-12">
												<div class="form-group">
													<label>Kondisi Saat Ini</label>
													<textarea class="form-control" id="txa-SI-SubmitF4-KondisiSaatIni" placeholder="Masukkan kondisi awal..." style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">
														<?php echo isset($kaizen[0]['kondisi_awal']) ? $kaizen[0]['kondisi_awal'] : '' ?>
													</textarea>
												</div>
											</div>
											<div class="col-lg-12">
												<div class="form-group">
													<label>Usulan Kaizen</label>
													<textarea class="form-control" id="txa-SI-SubmitF4-UsulanKaizen" placeholder="Masukkan Usulan Kaizen..." style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">
														<?php echo isset($kaizen[0]['usulan_kaizen']) ? $kaizen[0]['usulan_kaizen'] : '' ?>
													</textarea>
												</div>
											</div>
											<div class="col-lg-12">
												<div class="form-group">
													<label>Pertimbangan Usulan Kaizen</label>
													<textarea class="form-control" id="txa-SI-SubmitF4-PertimbanganUsulanKaizen" placeholder="Masukkan Pertimbangan Usulan Kaizen..." style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">
														<?php echo isset($kaizen[0]['pertimbangan']) ? $kaizen[0]['pertimbangan'] : '' ?>
													</textarea>
												</div>
											</div>
											<div class="col-lg-6">
												<div class="form-group">
													<label>Tanggal Realisasi</label>
													<div class="input-group date">
											            <div class="input-group-addon">
											            	<i class="fa fa-calendar"></i>
											            </div>
														<input type="text" placeholder="Pilih Tanggal Realisasi..." class="form-control" name="txt-SI-SubmitF4-TanggalRealisasi" id="txt-SI-SubmitF4-TanggalRealisasi" value="<?php echo isset($kaizen[0]['tanggal_realisasi']) ? $kaizen[0]['tanggal_realisasi'] : '' ?>">
													</div>
												</div>
											</div>
											<div class="col-lg-12">
												<div class="form-group text-right">
													<button type="button" class="btn btn-primary" id="btn-SI-SubmitF4-Submit"><span class="fa fa-save"></span> Simpan</button>
													<button type="button" class="btn btn-danger" id="btn-SI-SubmitF4-Cetak" disabled><span class="fa fa-file-pdf-o"></span> Cetak</button>
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
		</div>
	</div>
</section>
<style type="text/css">
	.loading {
    width: 100%;
    height: 100%;
    position: fixed;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    background-color: rgba(0,0,0,.5);
    z-index: 9999;
}
.loading-wheel {
    width: 40px;
    height: 40px;
    margin-top: -80px;
    margin-left: -40px;
    
    position: absolute;
    top: 50%;
    left: 50%;
}
.loading-wheel-2 {
    width: 100%;
    height: 20px;
    margin-top: -50px;
    
    position: absolute;
    top: 70%;
    font-weight: bold;
    font-size: 30pt;
    color: white;
    text-align: center;
}

</style>
<div class="loading" id="ldg-SI-SubmitF4" style="display: none;">
	<div class="loading-wheel"><img height="100px" width="100px" src="<?php echo site_url('assets/img/gif/loadingquick.gif') ?>"></div>
	<div class="loading-wheel-2">Permintaan Anda Sedang Di Proses ..</div>
</div>