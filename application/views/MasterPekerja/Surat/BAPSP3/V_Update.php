<section class="content">
    <div class="inner" >
        <div class="row">
			<form id="MasterPekerja-FormCreate" method="post" action="<?= site_url('MasterPekerja/Surat/BAPSP3/edit/'.$view[0]['bap_id']);?>" class="form-horizontal">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-11">
                                <div class="text-right"><h1><b><?= $Title ?></b></h1></div>
                            </div>
                            <div class="col-lg-1 ">
                                <div class="text-right hidden-md hidden-sm hidden-xs">
                                    <a class="btn btn-default btn-lg" href="<?= site_url('MasterPekerja/Surat/BAPSP3/');?>">
                                        <i class="icon-wrench icon-2x"></i>
                                        <span ><br /></span>
                                    </a>                             
                                </div>
                            </div>
                        </div>
                    </div>
                    <br />
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="box box-primary box-solid">
                                <div class="box-header with-border">Edit BAP SP 3</div>
                                    <div class="box-body">
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="form-group hidden">
                                                    <label for="txtFormatSurat" class="col-lg-4 control-label">Format Surat</label>
                                                    <div class="col-lg-8">
                                                        <input type="text" name="txtFormatSurat" class="form-control" value="MUTASI" readonly />
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="cmbNoind" class="col-lg-4 control-label">Nomor Induk</label>
                                                        <div class="col-lg-8">
                                                            <select required class="select2" name="cmbNoind" id="MasterPekerja-BAPSP3-DaftarPekerja" style="width: 100%">
                                                                <option value="<?= $view[0]['noind']; ?>" selected><?= $view[0]['noind']." - ".$view[0]['employee_name']; ?></option>
                                                            </select>
                                                        </div>
                                                    </div>
													<div class="form-group">
                                                        <label for="txtAlamatPekerja" class="col-lg-4 control-label">Alamat Pekerja</label>
                                                        <div class="col-lg-8">
                                                            <input type="text" name="txtAlamatPekerja" class="form-control" id="MasterPekerja-txtAlamatPekerja" readonly="" value="<?= $view[0]['alamat']; ?>">
                                                        </div>
                                                    </div>
													<div class="form-group">
                                                        <label for="txtCustomJabatan" class="col-lg-4 control-label">Jabatan</label>
                                                        <div class="col-lg-8">
                                                            <input type="text" name="txtCustomJabatan" class="form-control" id="MasterPekerja-txtCustomJabatan" readonly="" value="<?= $view[0]['pekerjaan_jabatan']; ?>">
                                                        </div>
                                                    </div>
													
													<div class="form-group">
                                                        <label for="txtNamaPerusahaan" class="col-lg-4 control-label">Nama Perusahaan</label>
                                                        <div class="col-lg-8">
                                                            <input type="text" name="txtNamaPerusahaan" class="form-control" id="MasterPekerja-txtNamaPerusahaan" readonly="" value="<?= $view[0]['nama_perusahaan']; ?>">
                                                        </div>
                                                    </div>
													<div class="form-group">
                                                        <label for="txtAlamatPerusahaan" class="col-lg-4 control-label">Alamat Perusahaan</label>
                                                        <div class="col-lg-8">
                                                            <input type="text" name="txtAlamatPerusahaan" class="form-control" id="MasterPekerja-txtAlamatPerusahaan" readonly="" value="<?= $view[0]['alamat_perusahaan']; ?>">
                                                        </div>
                                                    </div>
													<div class="form-group">
                                                        <label for="txtWakilPerusahaan" class="col-lg-4 control-label">Nama Wakil Perusahaan</label>
                                                        <div class="col-lg-8">
                                                            <select class="select2" name="cmbWakilPerusahaan" id="MasterPekerja-BAPSP3-WakilPerusahaan" style="width: 100%">
                                                                <?php if(!empty($wakilPerusahaan)): ?>
                                                                <option value="<?= $wakilPerusahaan->noind ?>" selected><?= $wakilPerusahaan->noind." - ".$wakilPerusahaan->nama; ?></option>
                                                                <?php endif; ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
												<div class="col-lg-6">
													<div class="form-group">
                                                        <label for="txtTanggalPemeriksaan" class="col-lg-4 control-label">Tanggal Pemeriksaan</label>
                                                        <div class="col-lg-8">
                                                            <input type="text" name="txtTanggalPemeriksaan" class="form-control MasterPekerja-daterangepickersingledate" value="<?= $view[0]['tgl_pemeriksaan']; ?>">
                                                        </div>
                                                    </div>
													<div class="form-group">
                                                        <label for="txtTempatPemeriksaan" class="col-lg-4 control-label">Tempat Pemeriksaan</label>
                                                        <div class="col-lg-8">
                                                            <input type="text" name="txtTempatPemeriksaan" class="form-control" id="MasterPekerja-txtTempatPemeriksaan" value="<?= $view[0]['tempat_pemeriksaan']; ?>">
                                                        </div>
                                                    </div>
													<div class="form-group">
                                                        <label for="txtKeteranganPekerja" class="col-lg-4 control-label">Keterangan Pekerja</label>
                                                        <div class="col-lg-8">
															<textarea rows="3" name="txtKeteranganPekerja" class="form-control" id="MasterPekerja-txtKeteranganPekerja"><?= $view[0]['keterangan_pekerja']; ?></textarea>
                                                        </div>
                                                    </div>
													
													<div class="form-group">
                                                        <label for="txtUser01" class="col-lg-4 control-label">Tanda Tangan 1</label>
                                                        <div class="col-lg-8">
                                                            <select class="select2" name="cmbTandaTangan1" id="MasterPekerja-BAPSP3-TandaTangan1" style="width: 100%">
                                                                <?php if(!empty($tandaTangan1)): ?>
                                                                <option value="<?= $tandaTangan1->noind; ?>" selected><?= $tandaTangan1->noind." - ".$tandaTangan1->nama; ?></option>
                                                                <?php endif; ?>
                                                            </select>
                                                        </div>
                                                    </div>
													<div class="form-group">
                                                        <label for="txtUser02" class="col-lg-4 control-label">Tanda Tangan 2</label>
                                                        <div class="col-lg-8">
                                                            <select class="select2" name="cmbTandaTangan2" id="MasterPekerja-BAPSP3-TandaTangan2" style="width: 100%">
                                                                <?php if(!empty($tandaTangan2)): ?>
                                                                <option value="<?= $tandaTangan2->noind; ?>" selected><?= $tandaTangan2->noind." - ".$tandaTangan2->nama; ?></option>
                                                                <?php endif; ?>
                                                            </select>
                                                        </div>
                                                    </div>
													
												</div>
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <div class="col-lg-2 text-right">
                                                            <a id="MasterPekerja-BAPSP3-btnPreview" title="Preview" class="btn btn-info">Preview</a>
                                                        </div>
                                                        <div class="col-lg-10">
                                                            <textarea required class="redactor" name="txaPreview" id="MasterPekerja-Surat-txaPreview"><?= $view[0]['isi_bap']; ?></textarea>
                                                        </div>
                                                    </div>  
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel-footer">
                                            <div class="row text-right">
                                                <a href="javascript:history.back(1)" class="btn btn-primary btn-lg btn-rect">Back</a>
                                                <button type="submit" class="btn btn-primary btn-lg btn-rect">Save Data</button>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
<div id="surat-loading" hidden style="top: 0;left: 0;right: 0;bottom: 0; margin: auto; position: fixed; background: rgba(0,0,0,.5); z-index: 11;">
    <img src="<?= site_url('assets/img/gif/loadingtwo.gif');?>" style="position: fixed; top: 0;left: 0;right: 0;bottom: 0; margin: auto; width: 40%;">
</div>