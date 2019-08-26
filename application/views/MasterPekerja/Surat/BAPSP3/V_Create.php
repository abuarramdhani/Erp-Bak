<section class="content">
    <div class="inner" >
        <div class="row">
            <form id="MasterPekerja-FormCreate" method="post" action="<?php echo site_url('MasterPekerja/Surat/BAPSP3/add');?>" class="form-horizontal" >
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-11">
                                <div class="text-right"><h1><b><?= $Title ?></b></h1></div>
                            </div>
                            <div class="col-lg-1 ">
                                <div class="text-right hidden-md hidden-sm hidden-xs">
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('MasterPekerja/Surat/BAPSP3/');?>">
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
                                <div class="box-header with-border">Input BAP SP 3</div>
                                    <div class="box-body">
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="cmbNoind" class="col-lg-4 control-label">Nomor Induk</label>
                                                        <div class="col-lg-8">
                                                            <select required class="select2" name="cmbNoind" id="MasterPekerja-BAPSP3-DaftarPekerja" style="width: 100%">
                                                                <option></option>
                                                            </select>
                                                        </div>
                                                    </div>
													<div class="form-group">
                                                        <label for="txtAlamatPekerja" class="col-lg-4 control-label">Alamat Pekerja</label>
                                                        <div class="col-lg-8">
                                                            <input type="text" name="txtAlamatPekerja" class="form-control" id="MasterPekerja-txtAlamatPekerja" readonly="">
                                                        </div>
                                                    </div>
													<div class="form-group">
                                                        <label for="txtCustomJabatan" class="col-lg-4 control-label">Jabatan</label>
                                                        <div class="col-lg-8">
                                                            <input type="text" name="txtCustomJabatan" class="form-control" id="MasterPekerja-txtCustomJabatan" readonly="">
                                                        </div>
                                                    </div>
													
													<div class="form-group">
                                                        <label for="txtNamaPerusahaan" class="col-lg-4 control-label">Nama Perusahaan</label>
                                                        <div class="col-lg-8">
                                                            <input type="text" name="txtNamaPerusahaan" class="form-control" id="MasterPekerja-txtNamaPerusahaan" readonly="">
                                                        </div>
                                                    </div>
													<div class="form-group">
                                                        <label for="txtAlamatPerusahaan" class="col-lg-4 control-label">Alamat Perusahaan</label>
                                                        <div class="col-lg-8">
                                                            <input type="text" name="txtAlamatPerusahaan" class="form-control" id="MasterPekerja-txtAlamatPerusahaan" readonly="">
                                                        </div>
                                                    </div>
													<div class="form-group">
                                                        <label for="cmbWakilPerusahaan" class="col-lg-4 control-label">Nama Wakil Perusahaan</label>
                                                        <div class="col-lg-8">
                                                            <select required class="select2" name="cmbWakilPerusahaan" id="MasterPekerja-BAPSP3-WakilPerusahaan" style="width: 100%">
                                                                <option></option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
												<div class="col-lg-6">
													<div class="form-group">
                                                        <label for="txtTanggalPemeriksaan" class="col-lg-4 control-label">Tanggal Pemeriksaan</label>
                                                        <div class="col-lg-8">
                                                            <input type="text" name="txtTanggalPemeriksaan" class="form-control MasterPekerja-daterangepickersingledate">
                                                        </div>
                                                    </div>
													<div class="form-group">
                                                        <label for="txtTempatPemeriksaan" class="col-lg-4 control-label">Tempat Pemeriksaan</label>
                                                        <div class="col-lg-8">
                                                            <input type="text" name="txtTempatPemeriksaan" class="form-control" id="MasterPekerja-txtTempatPemeriksaan">
                                                        </div>
                                                    </div>
													<div class="form-group">
                                                        <label for="txtKeteranganPekerja" class="col-lg-4 control-label">Keterangan Pekerja</label>
                                                        <div class="col-lg-8">
															<textarea rows="3" name="txtKeteranganPekerja" class="form-control" id="MasterPekerja-txtKeteranganPekerja" style="resize: none;"></textarea>
                                                        </div>
                                                    </div>
													<!-- <div class="form-group">
                                                        <label for="txtPokokMasalah" class="col-lg-4 control-label">Pokok Masalah</label>
                                                        <div class="col-lg-8">
															<textarea rows="3" name="txtPokokMasalah" class="redactor" id="MasterPekerja-txtPokokMasalah"></textarea>
                                                        </div>
                                                    </div> -->
													<div class="form-group">
                                                        <label for="cmbTandaTangan1" class="col-lg-4 control-label">Tanda Tangan 1</label>
                                                        <div class="col-lg-8">
                                                            <select required class="select2" name="cmbTandaTangan1" id="MasterPekerja-BAPSP3-TandaTangan1" style="width: 100%">
                                                                <option></option>
                                                            </select>
                                                        </div>
                                                    </div>
													<div class="form-group">
                                                        <label for="cmbTandaTangan2" class="col-lg-4 control-label">Tanda Tangan 2</label>
                                                        <div class="col-lg-8">
                                                            <select required class="select2" name="cmbTandaTangan2" id="MasterPekerja-BAPSP3-TandaTangan2" style="width: 100%">
                                                                <option></option>
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
                                                            <textarea required class="redactor" name="txaPreview" id="MasterPekerja-Surat-txaPreview"></textarea>
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
    <img src="<?php echo site_url('assets/img/gif/loadingtwo.gif');?>" style="position: fixed; top: 0;left: 0;right: 0;bottom: 0; margin: auto; width: 40%;">
</div>