<section class="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-11">
                            <div class="text-right"><h1><b><?php echo $Title ?></b></h1></div>
                        </div>
                        <div class="col-lg-1">
                            <div class="text-right hidden-md hidden-sm hidden-xs">
                                <i class="icon-envelope icon-4x"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row form-horizontal">
                    <div class="col-lg-12">
                        <div class="box box-primary">
                            <form class="form_submit_SP">
                            <div class="box-header with-border text-center" style="margin-top: 8px"><b>---  MONITORING SURAT PENYERAHAN ---</b>
                                <div class="col-lg-1">
                                    <div class="text-right">
                                        <a class="btn btn-default" href="<?php echo site_url('AdmSeleksi/SuratPenyerahan/Create');?>">
                                            <i class="fa fa-plus fa-2x"></i>
                                            <span ><br /></span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="margin-top: 20px">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="txt_tgl_SP" class="col-lg-5 control-label text-left">Tanggal Penyerahan</label>
                                        <div class="col-lg-5">
                                            <input type="text" name="txt_tgl_SP" class="form-control" id="txt_tgl_SP" value="<?php echo date('d F Y') ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6" id="gol_Pekerja_SP" hidden>
                                    <div class="form-group">
                                        <label for="slc_gol_pkj_SP" class="col-lg-5 control-label text-right">Gol</label>
                                        <div class="col-lg-3">
                                            <select class="select select2 form-control" name="slc_gol_pkj_SP" id="slc_gol_pkj_SP"></select>
                                        </div>
                                        <p class="col-lg-3 control-label" id="keteranganPKL"></p>
                                    </div>
                                    <input type="text" hidden id="HideMasaPKL">
                                </div>
                                <div class="col-lg-6" id="kelas_pkj_SP" hidden>
                                    <div class="form-group">
                                        <label for="slc_Kelas_SP" class="col-lg-5 control-label text-right">Kelas</label>
                                        <div class="col-lg-3">
                                            <select class="select select2 form-control" name="slc_Kelas_SP" id="slc_Kelas_SP">
                                                <option></option>
                                                <option value="A">A</option>
                                                <option value="B">B</option>
                                                <option value="C">C</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="slc_pkj_SP" class="col-lg-5 control-label ">Pekerja yang Diserahkan </label>
                                        <div class="col-lg-7">
                                            <select name="slc_pkj_SP" class="select select2 form-control" id="slc_pkj_SP">
                                                <option value="kosong" selected disabled>---Pekerja Yang Diserahkan---</option>
                                                <option value="10">[C] Cabang Trainee Non Staff</option>
                                                <option value="11">[C] Cabang Kontrak Non Staff</option>
                                                <option value="14">[C] Cabang Outsorcing</option>
                                                <option value="1">[D] Trainee Staff</option>
                                                <option value="2">[D] Supervisor</option>
                                                <option value="3">[E] Trainee Non Staf</option>
                                                <option value="7">[F] Praktik Kerja Lapangan</option>
                                                <option value="6">[G] Tenaga Kerja Paruh Waktu (TKPW)</option>
                                                <option value="4">[H] Pekerja Waktu Tertentu (Kontrak Non Staff)</option>
                                                <option value="5">[J] Pekerja Waktu Tertentu (Kontrak Staff)</option>
                                                <option value="9">[K] Outsorcing</option>
                                                <option value="8">[L] Magang D3/S1</option>
                                                <option value="16">[N] Freelance</option>
                                                <option value="12">[P] Pemborong</option>
                                                <option value="13">[Q] Praktik Kerja Lapangan D3/S1 (PKL D3/S1)</option>
                                                <option value="15">[T] Kontrak Non Staff Khusus</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <input type="text" name="inputKode" value="" id="inputKode" hidden>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="slc_RuangLingkup_SP" class="col-lg-5 control-label ">Ruang Lingkup Penyerahan</label>
                                        <div class="col-lg-6">
                                            <select class="select select2 form-control" name="slc_RuangLingkup_SP" id="slc_RuangLingkup_SP">
                                                <option value=""></option>
                                                <option value="Dept">Departemen</option>
                                                <option value="Bid">Bidang</option>
                                                <option value="Unit">Unit</option>
                                                <option value="Seksi">Seksi</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="margin-top: 40px">
                                <div class="box-header with-border text-center"><b>---  Data Seksi / Unit / Bidang / Departemen ---</b></div>
                                <div class="col-lg-2"></div>
                                <div class="col-lg-6">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="slc_kodesie_SP" class="col-lg-4 control-label ">Kodesie</label>
                                            <div class="col-lg-8">
                                                <select name="slc_kodesie_SP" class="form-control select select2" id="slc_kodesie_SP" placeholder="---Masukkan Kodesie--- " disabled>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="txtDeptPenyerahan" class="col-lg-4 control-label ">Departemen</label>
                                            <div class="col-lg-8">
                                                <input type="text" name="txtDeptPenyerahan" class="form-control" id="txtDeptPenyerahan" readonly="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="txtBidPenyerahan" class="col-lg-4 control-label">Bidang</label>
                                            <div class="col-lg-8">
                                                <input type="text" name="txtBidPenyerahan" class="form-control" id="txtBidPenyerahan"readonly="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="txtUnitPenyerahan" class="col-lg-4 control-label">Unit</label>
                                            <div class="col-lg-8">
                                                <input type="text" name="txtUnitPenyerahan" class="form-control" id="txtUnitPenyerahan"readonly="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="txtSeksiPenyerahan" class="col-lg-4 control-label ">Seksi</label>
                                            <div class="col-lg-8">
                                                <input type="text" name="txtSeksiPenyerahan" class="form-control" id="txtSeksiPenyerahan" readonly="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="txtKerja_SP" class="col-lg-4 control-label ">Pekerjaan</label>
                                            <div class="col-lg-8">
                                                <select class="select select2 form-control" name="txtKerja_SP" id="txtKerja_SP">
                                                    <option value=""></option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="txtTmpPenyerahan" class="col-lg-4 control-label ">Tempat</label>
                                            <div class="col-lg-8">
                                                <input type="text" name="txtTmpPenyerahan" class="form-control" id="txtTmpPenyerahan" readonly="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4"></div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <button type="button" name="button" class="btn btn-info col-lg-12" id="Cari_HasilPenyerahan">Cari</button>
                                    <button type="button" name="button" class="btn btn-danger col-lg-12" id="Reset_HasilPenyerahan">Reset</button>
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="row" id="tempelDataSP"></div>
                <div class="row hide_Perusahaan" hidden>
                    <div class="col-lg-12">
                        <div class="box form-horizontal">
                            <div class="row">
                                <div class="box-header with-border text-center" style="margin-top: 8px"><b>---  Diserahkan ---</b></div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="slc_petugas1_SP" class="col-lg-4 control-label">Petugas 1</label>
                                        <div class="col-lg-4">
                                            <input type="text" name="petugas" value="nbu" id="slc_petugas1_SP" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="slc_petugas2_SP" class="col-lg-4 control-label">Petugas 2</label>
                                        <div class="col-lg-4">
                                            <input type="text" name="petugas" value="hy" id="slc_petugas2_SP" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="slc_Kepada_SP" class="col-lg-4 control-label">Kepada</label>
                                        <div class="col-lg-4">
                                            <select class="select select2 form-control" name="slc_Kepada_SP" id="slc_Kepada_SP" style="width: 100% !important" required>
                                                <option value=""></option>
                                                <?php foreach ($kepada as $k) { ?>
                                                    <option value="<?php echo $k['kodesie']."|".$k['kd_jabatan']."|".$k['jabatan']; ?>"><?php echo $k['kodesie']." - ".$k['jabatan']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="slc_approval_SP" class="col-lg-4 control-label">Approval</label>
                                        <div class="col-lg-4">
                                            <select class="select select2 form-control" name="slc_approval_SP" id="slc_approval_SP" style="width: 100% !important" required>
                                                <option value=""></option>
                                                <?php foreach ($approval as $val) { ?>
                                                    <option <?php if ($val['noind'] == 'J1269') { echo'selected';} else {echo '';} ?> value="<?php echo $val['noind']; ?>"><?php echo $val['noind']." - ".$val['nama'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="txt_tglCetak_SP" class="col-lg-4 control-label">Tanggal Cetak</label>
                                        <div class="col-lg-4">
                                            <input type="text" name="txt_tglCetak_SP" class="form-control" id="txt_tglCetak_SP" value="<?php echo date('d F Y'); ?>" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-footer text-center">
                                <a type="button" class="btn btn-success" name="button" id="btn_Cetak_SP"><span class="fa fa-print-o">&emsp;Cetak</span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
