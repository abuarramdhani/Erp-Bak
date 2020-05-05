<style media="screen">
    .addColorIfSuccess{
        background-color: #e6ffec
    }
</style>
<section class="content">
    <div class="inner" >
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-11">
                            <div class="text-right"><h1><b><?= $Title ?></b></h1></div>
                        </div>
                        <div class="col-lg-1 ">
                            <div class="text-right hidden-md hidden-sm hidden-xs">
                                <i class="icon-envelope icon-4x"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <br />
                <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border"><b><p style="font-size: 15px">--- Create Surat Penyerahan ---</p></b></div>
                                <div class="box-body">
                                    <div class="panel-body">
                                        <form id="SuratPenyerahan_utama" class="form-horizontal">
                                        <div class="row">
                                            <div class="col-lg-6" style="margin-top: 10px">
                                                <div class="form-group">
                                                    <label for="txt_tgl_SP" class="col-lg-4 control-label text-left">Tanggal Penyerahan</label>
                                                    <div class="col-lg-5">
                                                        <input type="text" name="txt_tgl_SP" class="form-control" id="txt_tgl_SP" value="<?php echo date('d F Y') ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6" style="margin-top: 10px" id="gol_Pekerja_SP" hidden>
                                                <div class="form-group">
                                                    <label for="slc_gol_pkj_SP" class="col-lg-5 control-label text-right">Gol</label>
                                                    <div class="col-lg-3">
                                                        <select class="select select2 form-control" name="slc_gol_pkj_SP" id="slc_gol_pkj_SP"></select>
                                                    </div>
                                                    <p class="col-lg-3 control-label" id="keteranganPKL"></p>
                                                </div>
                                                <input type="text" hidden id="HideMasaPKL">
                                            </div>
                                            <div class="col-lg-6" style="margin-top: 10px" id="kelas_pkj_SP" hidden>
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
                                                    <label for="slc_pkj_SP" class="col-lg-4 control-label ">Pekerja yang Diserahkan </label>
                                                    <div class="col-lg-8">
                                                        <select name="slc_pkj_SP" class="select select2 form-control" id="slc_pkj_SP">
                                                            <option value="" selected disabled>---Pekerja Yang Diserahkan---</option>
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
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="slc_RuangLingkup_SP" class="col-lg-5 control-label ">Ruang Lingkup Penyerahan</label>
                                                    <div class="col-lg-7">
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
                                        <input type="text" name="inputKode" value="" id="inputKode" hidden>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="box box-solid box-default">
                                                    <div class="box-header with-border"><b><p style="font-size: 15px">--- Data Seksi / Unit / Bidang / Departemen ---</p></b></div>
                                                    <div class="row">
                                                        <div class="col-lg-12">
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
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="box box-default box-solid">
                                                    <div class="box-header with-border hideAllHubker"><b><p style="font-size: 15px;">---  Hubungan Kerja ---</p></b></div>
                                                    <div class="row hideAllHubker">
                                                        <div class="col-lg-12">
                                                            <div class="col-lg-12" id="LM_Hide_Hubker">
                                                                <div class="form-group">
                                                                    <label for="txt_try_hubker" class="col-lg-4 control-label">Lama Orientasi</label>
                                                                    <div class="col-lg-3">
                                                                        <input type="text" name="txt_try_hubker" class="form-control" id="txt_try_hubker">
                                                                    </div>
                                                                    <p for="txt_try_hubker" class="col-lg-1 control-label">Bulan</p>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-12" id="LM_K_Hubker">
                                                                <div class="form-group">
                                                                    <label for="txt_lama_kontrak" class="col-lg-4 control-label">Lama Kontrak</label>
                                                                    <div class="col-lg-3">
                                                                        <input type="text" name="txt_lama_kontrak" class="form-control" id="txt_lama_kontrak">
                                                                    </div>
                                                                    <p for="txt_lama_kontrak" class="col-lg-1 control-label">Bulan</p>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-12"  style="margin-bottom: 13px" id="tgl_ik_hubker">
                                                                <div class="form-group">
                                                                    <label for="txt_IK_hubker" class="col-lg-4 control-label">Tanggal Mulai IK
                                                                    </label>
                                                                    <div class="col-lg-5">
                                                                        <input type="text" name="txt_IK_hubker" class="form-control" id="txt_IK_hubker" value="">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="box-header with-border nambahStyle"><b><p style="font-size: 15px">---  Seleksi ---</p></b></div>
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="col-lg-12">
                                                                <div class="form-group">
                                                                    <label for="txt_try_seleksi" class="col-lg-4 control-label">Lama Trainee</label>
                                                                    <div class="col-lg-3">
                                                                        <input type="text" name="txt_try_seleksi" class="form-control" id="txt_try_seleksi">
                                                                    </div>
                                                                    <p for="txt_try_seleksi" class="col-lg-1 control-label">Bulan</p>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-12">
                                                                <div class="form-group">
                                                                    <label for="inp_tgl_angkat_SP" class="col-lg-4 control-label">Tanggal Diangkat</label>
                                                                    <div class="col-lg-5">
                                                                        <input type="text" name="inp_tgl_angkat_SP" class="form-control" id="inp_tgl_angkat_SP">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row" id="hide_tgl_Selesai_SP" hidden>
                                                        <div class="col-lg-12">
                                                            <div class="col-lg-12">
                                                                <div class="form-group">
                                                                    <label for="inp_tgl_Keluar_SP" class="col-lg-4 control-label">Tanggal Selesai</label>
                                                                    <div class="col-lg-5">
                                                                        <input type="text" name="inp_tgl_Keluar_SP" class="form-control" id="inp_tgl_Keluar_SP" value="<?= date('Y-m-d') ?>">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" id="hide_plus_SP" style="margin-top: 20px; margin-bottom: 20px">
                                            <div class="col-lg-12">
                                                <div class="col-lg-1"></div>
                                                <div class="col-lg-2">
                                                    <label for="">Cari Pekerja :</label>
                                                </div>
                                                <div class="col-lg-2">
                                                    <div class="col-lg-2">
                                                        <input type="radio" name="input_Pekerja_SP" class="input_Pekerja_SP" value="1">
                                                    </div>
                                                    <label for="input_Pekerja_SP" style="margin-left: 10px">Pekerja Baru</label>
                                                </div>
                                                <div class="col-lg-2">
                                                    <div class="col-lg-2">
                                                        <input type="radio" name="input_Pekerja_SP" class="input_Pekerja_SP" value="2">
                                                    </div>
                                                    <label for="input_Pekerja_SP" style="margin-left: 10px">Pekerja KHS</label>
                                                </div>
                                                <div class="col-lg-1 text-right">
                                                    <label for="slc_pri_pkj_SP">Nama: </label>
                                                </div>
                                                <div class="col-lg-3">
                                                    <select class="select select2 form-control" name="slc_pri_pkj_SP" id="slc_pri_pkj_SP" placeholder="Pilih Pekerja" style="width: 100% !important" required>
                                                        <option value=""></option>
                                                    </select>
                                                </div>
                                                <a type="button" name="button" class="btn btn-success" id="btn_Plus_Pekerja_SP"><span class="fa fa-plus"></span></a>
                                            </div>
                                        </div>
                                        <div class="panel-footer row text-center" style="margin-top: 20px;">
                                            <a href="<?= base_url('AdmSeleksi/SuratPenyerahan/') ?>" type="button" name="button" class="btn btn-danger">Back</a>
                                            <a type="button" name="button" class="btn btn-primary" onclick="window.location.reload()">Reset</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <div id="plus_pkj_SP">
                    <!-- <div class="box">
                        <form class="form-horizontal" id="addReadonlyForm">
                        <div class="box-body">
                            <div class="box-header with-border"><b>---  Data Perusahaan ---</b></div>
                            <div class="col-lg-6">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="input_noind_baru_SP" class="col-lg-4 control-label">Nomor Induk</label>
                                        <div class="col-lg-3">
                                            <input type="text" name="input_noind_baru_SP" class="form-control text-left input_noind_baru_SP" readonly>
                                        </div>
                                        <label for="input_noind_lama_SP" class="col-lg-2 control-label cekHide">Lama</label>
                                        <div class="col-lg-3 cekHide">
                                            <input type="text" name="input_noind_lama_SP" class="form-control text-left input_noind_lama_SP" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="slc_kantor_SP" class="col-lg-4 control-label ">Kantor Asal</label>
                                        <div class="col-lg-8">
                                            <select class="select select2 form-control slc_kantor_SP" name="slc_kantor_SP" style="width: 100% !important" required><option></option></select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="slc_loker_SP" class="col-lg-4 control-label ">Lokasi Kerja</label>
                                        <div class="col-lg-8">
                                            <select class="select select2 form-control slc_loker_SP" name="slc_loker_SP" style="width: 100% !important" required></select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="txt_ruang_SP" class="col-lg-4 control-label ">Ruang</label>
                                        <div class="col-lg-8">
                                            <select class="select select2 form-control txt_ruang_SP" name="txt_ruang_SP" style="width: 100% !important" required></select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="no_kebutuhan_SP" class="col-lg-4 control-label">Nomor Kebutuhan</label>
                                        <div class="col-lg-5">
                                            <input type="text" name="no_kebutuhan_SP" class="form-control text-left no_kebutuhan_SP" readonly>
                                        </div>
                                        <div class="col-lg-1">
                                            <input type="checkbox" name="cekGanti" class="ganti_hide" value="1">
                                        </div>
                                        <p for="cekGanti" class="col-lg-2 ganti_hide">Pengganti</p>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="txt_Lamaran_SP" class="col-lg-4 control-label">Kode Lamaran</label>
                                        <div class="col-lg-8">
                                            <input type="text" name="txt_Lamaran_SP" class="form-control txt_Lamaran_SP" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="slc_makan_SP" class="col-lg-4 control-label">Tempat Makan</label>
                                        <div class="col-lg-8">
                                            <select class="select select2 form-control slc_makan_SP" name="slc_makan_SP" style="width: 100% !important" required></select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="txt_Shift_SP" class="col-lg-4 control-label ">Shift</label>
                                        <div class="col-lg-8">
                                            <select class="select select2 form-control txt_Shift_SP" name="txt_Shift_SP" style="width: 100% !important" required></select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="box-header with-border"><b>---  Data Pribadi ---</b></div>
                            <div class="col-lg-6">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="def_Nama_pkj" class="col-lg-4 control-label">Nama</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control def_Nama_pkj"  style="text-transform: uppercase !important" name="def_Nama_pkj">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="inp_Agama_SP" class="col-lg-4 control-label">Agama</label>
                                        <div class="col-lg-5">
                                            <select class="select select2 form-control inp_Agama_SP" name="inp_jenkel_SP" style="width: 100% !important" required></select>
                                        </div>
                                        <label for="inp_jenkel_SP" class="col-lg-1 control-label"  style="margin-left: -15px">Gender</label>
                                        <div class="col-lg-2"  style="margin-left: 15px">
                                            <select class="select select2 form-control inp_jenkel_SP" name="inp_jenkel_SP" style="width: 100% !important" required></select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="txtLokasi_Lahir" class="col-lg-4 control-label">TTL</label>
                                        <div class="col-lg-4">
                                            <input type="text" name="txtLokasi_Lahir" style="text-transform: uppercase !important" class="form-control txtLokasi_Lahir" required>
                                        </div>
                                        <div class="col-lg-4">
                                            <input type="text" name="inp_tgl_lahir" class="form-control inp_tgl_lahir" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="txt_status_pri" class="col-lg-4 control-label">Status Nikah</label>
                                        <div class="col-lg-8">
                                            <select class="select select2 form-control txt_status_pri" name="txt_status_pri" style="width: 100% !important" required></select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="txtNIK_SP" class="col-lg-4 control-label">NIK</label>
                                        <div class="col-lg-8">
                                            <input type="number" max="9999999999999999" name="txtNIK_SP" class="form-control txtNIK_SP" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="txt_noKK_SP" class="col-lg-4 control-label">Nomor KK</label>
                                        <div class="col-lg-8">
                                            <input type="number" max="9999999999999999" name="txt_noKK_SP" class="form-control txt_noKK_SP">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="txtPend_SP" class="col-lg-4 control-label">Pendidikan
                                        </label>
                                        <div class="col-lg-8">
                                            <select class="select select2 form-control txtPend_SP" name="txtPend_SP" style="width: 100% !important; text-transform: uppercase !important" required></select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="txtSkul_SP" class="col-lg-4 control-label">Sekolah
                                        </label>
                                        <div class="col-lg-8">
                                            <select class="select select2 form-control txtSkul_SP" name="txtSkul_SP" style="width: 100% !important; text-transform: uppercase !important" required></select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="txtJurusan_SP" class="col-lg-4 control-label">Jurusan
                                        </label>
                                        <div class="col-lg-8">
                                            <select class="select select2 form-control txtJurusan_SP" name="txtJurusan_SP" autocapitalize="on" style="width: 100% !important; text-transform: capitalize; !important" required></select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="txt_alamat_SP" class="col-lg-4 control-label">Alamat</label>
                                        <div class="col-lg-8">
                                            <input type="text" name="txt_alamat_SP" class="form-control txt_alamat_SP" style="text-transform: uppercase !important" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="txt_Prov_SP" class="col-lg-4 control-label">Provinsi
                                        </label>
                                        <div class="col-lg-8">
                                            <select class="select select2 form-control Provinsi_SP" name="txt_Prov_SP" style="width: 100% !important" required></select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="txt_Kota_SP" class="col-lg-4 control-label">Kabupaten / Kota
                                        </label>
                                        <div class="col-lg-8">
                                            <select class="select select2 form-control Kabupaten_SP" name="txt_Kota_SP" style="width: 100% !important" required></select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="txtKec_SP" class="col-lg-4 control-label">Kecamatan
                                        </label>
                                        <div class="col-lg-8">
                                            <select class="select select2 form-control Kecamatan_SP" name="txtKec_SP" style="width: 100% !important" required></select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="txtDesa_SP" class="col-lg-4 control-label">Desa
                                        </label>
                                        <div class="col-lg-8">
                                            <select class="select select2 form-control Desa_SP" name="txtDesa_SP" style="width: 100% !important" required></select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="inp_kodepos_SP" class="col-lg-4 control-label">Kodepos
                                        </label>
                                        <div class="col-lg-8">
                                            <input type="number" name="inp_kodepos_SP" class="form-control inp_kodepos_SP" max="99999">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="txt_noTlp_SP" class="col-lg-4 control-label">Telephone
                                        </label>
                                        <div class="col-lg-8">
                                            <input type="text" name="txt_noTlp_SP" class="form-control txt_noTlp_SP">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="txt_noHP_SP" class="col-lg-4 control-label">Nomor HP
                                        </label>
                                        <div class="col-lg-8">
                                            <input type="text" name="txt_noHP_SP" class="form-control txt_noHP_SP">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box-body panel-footer text-center">
                            <button type="button" class="btn btn-success btn_Save_SP" name="button"><span class="fa fa-check">&emsp;Simpan</span></button>
                        </div>
                    </form>
                    </div> -->
                </div>
                <!-- <div id="find_pkj_SP"></div> -->
            </div>
        </div>
    </div>
</section>
<div id="surat-loading" hidden style="top: 0;left: 0;right: 0;bottom: 0; margin: auto; position: fixed; background: rgba(0,0,0,.5); z-index: 11;">
    <img src="<?php echo site_url('assets/img/gif/loadingtwo.gif');?>" style="position: fixed; top: 0;left: 0;right: 0;bottom: 0; margin: auto; width: 40%;">
</div>
<script type="text/javascript">

    // $(document).ready(function () {
    //     function refreshSelect() {
    //         $('.select2').select2()
    //     }
    //
    //     $("#txt_tgl_SP").datepicker({
    //         'format': 'd MM yyyy',
    //         'todayHighlight': true,
    //         'autoApply': true,
    //         'autoclose': true
    //     })
    //
    //     $("#txt_tglCetak_SP").datepicker({
    //         'format': 'd MM yyyy',
    //         'todayHighlight': true,
    //         'autoApply': true,
    //         'autoclose': true
    //     })
    //
    //     $('input[type=number][max]:not([max=""])').on('input', function(ev) {
    //       var $this = $(this);
    //       var maxlength = $this.attr('max').length;
    //       var value = $this.val();
    //       if (value && value.length >= maxlength) {
    //         $this.val(value.substr(0, maxlength));
    //       }
    //     })




        // $('#btn_Find_Pekerja_SP').on('click', function () {
        //     let kodesie = $('#slc_kodesie_SP').val()
        //     let lingkup = $('#slc_RuangLingkup_SP').val()
        //     let pkj_apa = $('#slc_pkj_SP').val()
        //     let kode    = $('#inputKode').val()
        //     $('.input_Pekerja_SP').iCheck('uncheck')
        //
        //     if (pkj_apa == null) {
        //         swal.fire({
        //             title: 'Warning',
        //             text: 'Harap Pilih Jenis Pekerja Yang diserahkan !',
        //             type: 'warning',
        //             allowOutsideClick: false
        //         })
        //     }else if (lingkup == null || lingkup == '') {
        //         swal.fire({
        //             title: 'Warning',
        //             text: 'Harap Mengisi Ruang Lingkup Penyerahan!',
        //             type: 'warning',
        //             allowOutsideClick: false
        //         })
        //     }else if (kodesie == null) {
        //         swal.fire({
        //             title: 'Warning',
        //             text: 'Harap Isikan data Seksi !',
        //             type: 'warning',
        //             allowOutsideClick: false
        //         })
        //     }else {
        //         $.ajax({
        //             type: 'post',
        //             data:{
        //                 kode: kode,
        //                 kodesie: kodesie,
        //                 lingkup: lingkup
        //             },
        //             dataType: 'json',
        //             beforeSend: function () {
        //                 swal.fire({
        //                     html: '<img src="'+loading+'">',
        //                     allowOutsideClick: false,
        //                     showConfirmButton: false,
        //                     background: 'transparent',
        //                 })
        //             },
        //             url: baseurl+'AdmSeleksi/SuratPenyerahan/getSudahDiserahkan',
        //             success: function (result) {
                        // if (result.pkj == '') {
                        //     swal.fire({
                        //         title: 'Informasi',
                        //         text: 'Belum ada data...',
                        //         type: 'info',
                        //         allowOutsideClick: false
                        //     })
                        // }
                        //
                        // refreshSelect()
                        // $('#find_pkj_SP').html('')
                        // $('#hide_plus_SP').removeClass('hidden')
                        // $('#btn_Plus_Pekerja_SP').removeClass('hidden')
                        //
                        // swal.close()
                        // let agama = ["ISLAM","KATHOLIK","KRISTEN","HINDU","BUDHA","KONGHUCU"]
                        // let jenkel = ["L","P"]
                        // let nikah = [
                        //     ["K","KAWIN"],
                        //     ["BK","BELUM KAWIN"],
                        //     ["KS","KAWIN SIRI"]
                        // ]
                        // let sekulah = ["SD","SMP","SMA","SMK","D1","D3","D4","S1","S2","S3"]
                        // let pendidikan = ''
                        //
                        // let datatoAppend = ''
                        // for (var i = 0; i < result.pkj.length; i++) {
                        //     console.log(result[i]);
                        //     if (result.pkj[i]['pendidikan'] == 'SLTP') {
                        //         pendidikan += 'SMP'
                        //     }else if (result.pkj[i]['pendidikan'] == 'SLTA') {
                        //         pendidikan += 'SMA'
                        //     }else {
                        //         pendidikan += result.pkj[i]['pendidikan']
                        //     }
                        //
                        //     let ana = result.pkj[i]['tgllahir'].split('/')
                        //     let lahir1 = new Date(ana[2]+'-'+ana[1]+'-'+ana[0])
                        //     let lahir = moment(lahir1).format('YYYY-MM-DD')
                        //
                        //     datatoAppend += `<div class="box collapsed-box"><form class="form-horizontal">
                        //                         <div class="box-header with-border" style="background-color:#e6ffec">
                        //                             <input type="checkbox" class="check_SP" value="${result.pkj[i]['noind']}">
                        //                             <label class="nama_pekerja"> ${result.pkj[i]['noind']} - ${result.pkj[i]['nama']}</label>
                        //                             <div class="box-tools pull-right">
                        //                                 <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                        //                             </div>
                        //                         </div>
                        //                     <div class="box-body">
                        //                     <div class="box-header with-border"><b>---  Data Perusahaan ---</b></div>
                        //                     <div class="col-lg-6">
                        //                         <div class="col-lg-12">
                        //                             <div class="form-group">
                        //                                 <label for="input_noind_baru_SP" class="col-lg-4 control-label">Nomor Induk</label>
                        //                                 <div class="col-lg-3">
                        //                                     <input type="text" name="input_noind_baru_SP" class="form-control text-left input_noind_baru_SP" value="${result.pkj[i]['noind']}" readonly>
                        //                                 </div>
                        //                             </div>
                        //                         </div>
                        //                         <div class="col-lg-12">
                        //                             <div class="form-group">
                        //                                 <label for="slc_kantor_SP" class="col-lg-4 control-label ">Kantor Asal</label>
                        //                                 <div class="col-lg-8">
                        //                                     <select class="select select2 form-control slc_kantor_SP" name="slc_kantor_SP" style="width: 100% !important" required>
                        //                                         <option></option>
                        //                                         ${
                        //                                             result.kantor.map(item => {
                        //                                                 return `<option value="${item.id_}">${item.kantor_asal}</option>`
                        //                                             }).join('')
                        //                                         }
                        //                                     </select>
                        //                                 </div>
                        //                             </div>
                        //                         </div>
                        //                         <div class="col-lg-12">
                        //                             <div class="form-group">
                        //                                 <label for="slc_loker_SP" class="col-lg-4 control-label ">Lokasi Kerja</label>
                        //                                 <div class="col-lg-8">
                        //                                     <select class="select select2 form-control slc_loker_SP" name="slc_loker_SP" style="width: 100% !important" required>
                        //                                         <option></option>
                        //                                         ${
                        //                                             result.lokasi.map(item => {
                        //                                                 return `<option value="${item.id_}">${item.lokasi_kerja}</option>`
                        //                                             }).join('')
                        //                                         }
                        //                                     </select>
                        //                                 </div>
                        //                             </div>
                        //                         </div>
                        //                         <div class="col-lg-12">
                        //                             <div class="form-group">
                        //                                 <label for="txt_ruang_SP" class="col-lg-4 control-label ">Ruang</label>
                        //                                 <div class="col-lg-8">
                        //                                     <select class="select select2 form-control txt_ruang_SP" name="txt_ruang_SP" style="width: 100% !important" required>
                        //                                         <option></option>
                        //                                         ${
                        //                                             result.tempat_makan.map(item => {
                        //                                                 return `<option value="${item.fs_tempat_makan}">${item.fs_tempat_makan}</option>`
                        //                                             }).join('')
                        //                                         }
                        //                                     </select>
                        //                                 </div>
                        //                             </div>
                        //                         </div>
                        //                     </div>
                        //                     <div class="col-lg-6">
                        //                         <div class="col-lg-12">
                        //                             <div class="form-group">
                        //                                 <label for="no_kebutuhan_SP" class="col-lg-4 control-label">Nomor Kebutuhan</label>
                        //                                 <div class="col-lg-5">
                        //                                     <input type="text" name="no_kebutuhan_SP" class="form-control text-left no_kebutuhan_SP" value="${result.pkj[i]['nokeb']}" readonly>
                        //                                 </div>
                        //                             </div>
                        //                         </div>
                        //                         <div class="col-lg-12">
                        //                             <div class="form-group">
                        //                                 <label for="txt_Lamaran_SP" class="col-lg-4 control-label">Kode Lamaran</label>
                        //                                 <div class="col-lg-8">
                        //                                     <input type="text" name="txt_Lamaran_SP" class="form-control txt_Lamaran_SP" value="${result.pkj[i]['kd_lamaran']}" readonly>
                        //                                 </div>
                        //                             </div>
                        //                         </div>
                        //                         <div class="col-lg-12">
                        //                             <div class="form-group">
                        //                                 <label for="slc_makan_SP" class="col-lg-4 control-label">Tempat Makan</label>
                        //                                 <div class="col-lg-8">
                        //                                     <select class="select select2 form-control slc_makan_SP" name="slc_makan_SP" style="width: 100% !important" required>
                        //                                         <option></option>
                        //                                         ${
                        //                                             result.tempat_makan.map(item => {
                        //                                                 return `<option value="${item.fs_tempat_makan}">${item.fs_tempat_makan}</option>`
                        //                                             }).join('')
                        //                                         }
                        //                                     </select>
                        //                                 </div>
                        //                             </div>
                        //                         </div>
                        //                         <div class="col-lg-12">
                        //                             <div class="form-group">
                        //                                 <label for="txt_Shift_SP" class="col-lg-4 control-label ">Shift</label>
                        //                                 <div class="col-lg-8">
                        //                                     <select class="select select2 form-control txt_Shift_SP" name="txt_Shift_SP" style="width: 100% !important" required>
                        //                                         <option></option>
                        //                                         ${
                        //                                             result.shift.map(item => {
                        //                                                 return `<option value="${item.kd_shift}">[${item.kd_shift}] - ${item.shift}</option>`
                        //                                             }).join('')
                        //                                         }
                        //                                     </select>
                        //                                 </div>
                        //                             </div>
                        //                         </div>
                        //                     </div>
                        //                     <div class="col-lg-12">
                        //                         <div class="box-header with-border"><b>---  Data Pribadi ---</b></div>
                        //                         <div class="col-lg-6">
                        //                             <div class="col-lg-12">
                        //                                 <div class="form-group">
                        //                                     <label for="def_Nama_pkj" class="col-lg-4 control-label">Nama</label>
                        //                                     <div class="col-lg-8">
                        //                                         <input type="text" class="form-control def_Nama_pkj"  style="text-transform: uppercase !important" name="def_Nama_pkj" value="${result.pkj[i]['nama']}">
                        //                                     </div>
                        //                                 </div>
                        //                             </div>
                        //                             <div class="col-lg-12">
                        //                                 <div class="form-group">
                        //                                     <label for="inp_Agama_SP" class="col-lg-4 control-label">Agama</label>
                        //                                     <div class="col-lg-5">
                        //                                         <select class="select select2 form-control inp_Agama_SP" name="inp_jenkel_SP" value="${result.pkj[i]['agama']}" style="width: 100% !important" required>
                        //                                             <option></option>
                        //                                             ${
                        //                                                 agama.map(item => {
                        //                                                     return `<option ${item == result.pkj[i]['agama']? 'selected': ''} value="${item}">${item}</option>`
                        //                                                 }).join('')
                        //                                             }
                        //                                         </select>
                        //                                     </div>
                        //                                     <label for="inp_jenkel_SP" class="col-lg-1 control-label"  style="margin-left: -15px">Gender</label>
                        //                                     <div class="col-lg-2"  style="margin-left: 15px">
                        //                                         <select class="select select2 form-control inp_jenkel_SP" name="inp_jenkel_SP" style="width: 100% !important" required>
                        //                                             <option></option>
                        //                                             ${
                        //                                                 jenkel.map(item => {
                        //                                                     return `<option ${item == result.pkj[i]['jenkel']? 'selected': ''} value="${item}">${item}</option>`
                        //                                                 }).join('')
                        //                                             }
                        //                                         </select>
                        //                                     </div>
                        //                                 </div>
                        //                             </div>
                        //                             <div class="col-lg-12">
                        //                                 <div class="form-group">
                        //                                     <label for="txtLokasi_Lahir" class="col-lg-4 control-label">TTL</label>
                        //                                     <div class="col-lg-4">
                        //                                         <input type="text" name="txtLokasi_Lahir" style="text-transform: uppercase !important" class="form-control txtLokasi_Lahir" value="${result.pkj[i]['templahir']}" required>
                        //                                     </div>
                        //                                     <div class="col-lg-4">
                        //                                         <input type="text" name="inp_tgl_lahir" class="form-control inp_tgl_lahir" value="${lahir}" required>
                        //                                     </div>
                        //                                 </div>
                        //                             </div>
                        //                             <div class="col-lg-12">
                        //                                 <div class="form-group">
                        //                                     <label for="txt_status_pri" class="col-lg-4 control-label">Status Nikah</label>
                        //                                     <div class="col-lg-8">
                        //                                         <select class="select select2 form-control txt_status_pri" name="txt_status_pri" style="width: 100% !important" required>
                        //                                             <option></option>
                        //                                             <option value="-">-</option>
                        //                                             ${
                        //                                                 nikah.map(item => {
                        //                                                     return `<option ${item[0] == result.pkj[i]['statnikah'] ? 'selected': ''} value="${item[0]}">[${item[0]}] - ${item[1]}</option>`
                        //                                                 }).join('')
                        //                                             }
                        //                                         </select>
                        //                                     </div>
                        //                                 </div>
                        //                             </div>
                        //                             <div class="col-lg-12">
                        //                                 <div class="form-group">
                        //                                     <label for="txtNIK_SP" class="col-lg-4 control-label">NIK</label>
                        //                                     <div class="col-lg-8">
                        //                                         <input type="number" max="9999999999999999" name="txtNIK_SP" class="form-control txtNIK_SP" value="${result.pkj[i]['nik']}" required>
                        //                                     </div>
                        //                                 </div>
                        //                             </div>
                        //                             <div class="col-lg-12">
                        //                                 <div class="form-group">
                        //                                     <label for="txt_noKK_SP" class="col-lg-4 control-label">Nomor KK</label>
                        //                                     <div class="col-lg-8">
                        //                                         <input type="number" max="9999999999999999" name="txt_noKK_SP" class="form-control txt_noKK_SP" value="${result.pkj[i]['no_kk']}">
                        //                                     </div>
                        //                                 </div>
                        //                             </div>
                        //                             <div class="col-lg-12">
                        //                                 <div class="form-group">
                        //                                     <label for="txtPend_SP" class="col-lg-4 control-label">Pendidikan
                        //                                     </label>
                        //                                     <div class="col-lg-8">
                        //                                         <select class="select select2 form-control txtPend_SP" name="txtPend_SP" style="width: 100% !important; text-transform: uppercase !important" required>
                        //                                             <option></option>
                        //                                             ${
                        //                                                 sekulah.map(item => {
                        //                                                     return `<option ${item == result.pkj[i]['pendidikan'] ? 'selected': ''} value="${item}">${item}</option>`
                        //                                                 }).join('')
                        //                                             }
                        //                                         </select>
                        //                                     </div>
                        //                                 </div>
                        //                             </div>
                        //                             <div class="col-lg-12">
                        //                                 <div class="form-group">
                        //                                     <label for="txtSkul_SP" class="col-lg-4 control-label">Sekolah
                        //                                     </label>
                        //                                     <div class="col-lg-8">
                        //                                         <select class="select select2 form-control txtSkul_SP" name="txtSkul_SP" style="width: 100% !important; text-transform: uppercase !important" required>
                        //                                             <option></option>
                        //                                             ${
                        //                                                 result.skul.map(item => {
                        //                                                     return `<option ${item.nama_univ == result.pkj[i]['sekolah'] ? 'selected': ''} value="${item.nama_univ}">${item.nama_univ}</option>`
                        //                                                 }).join('')
                        //                                             }
                        //                                         </select>
                        //                                     </div>
                        //                                 </div>
                        //                             </div>
                        //                             <div class="col-lg-12">
                        //                                 <div class="form-group">
                        //                                     <label for="txtJurusan_SP" class="col-lg-4 control-label">Jurusan
                        //                                     </label>
                        //                                     <div class="col-lg-8">
                        //                                         <select class="select select2 form-control txtJurusan_SP" name="txtJurusan_SP" autocapitalize="on" style="width: 100% !important; text-transform: capitalize; !important" required>
                        //                                             <option></option>
                        //                                             ${
                        //                                                 result.jurusan.map(item => {
                        //                                                     return `<option ${item.nama_jurusan == result.pkj[i]['jurusan'] ? 'selected': ''} value="${item.nama_jurusan}">${item.nama_jurusan}</option>`
                        //                                                 }).join('')
                        //                                             }
                        //                                         </select>
                        //                                     </div>
                        //                                 </div>
                        //                             </div>
                        //                         </div>
                        //                         <div class="col-lg-6">
                        //                             <div class="col-lg-12">
                        //                                 <div class="form-group">
                        //                                     <label for="txt_alamat_SP" class="col-lg-4 control-label">Alamat</label>
                        //                                     <div class="col-lg-8">
                        //                                         <input type="text" name="txt_alamat_SP" class="form-control txt_alamat_SP" style="text-transform: uppercase !important" value="${result.pkj[i]['alamat']}" required>
                        //                                     </div>
                        //                                 </div>
                        //                             </div>
                        //                             <div class="col-lg-12">
                        //                                 <div class="form-group">
                        //                                     <label for="txt_Prov_SP" class="col-lg-4 control-label">Provinsi
                        //                                     </label>
                        //                                     <div class="col-lg-8">
                        //                                         <select class="select select2 form-control Provinsi_SP" name="txt_Prov_SP" style="width: 100% !important" required>
                        //                                             <option value="${result.pkj[i]['prop']}">${result.pkj[i]['prop']}</option>
                        //                                         </select>
                        //                                     </div>
                        //                                 </div>
                        //                             </div>
                        //                             <div class="col-lg-12">
                        //                                 <div class="form-group">
                        //                                     <label for="txt_Kota_SP" class="col-lg-4 control-label">Kabupaten / Kota
                        //                                     </label>
                        //                                     <div class="col-lg-8">
                        //                                         <select class="select select2 form-control Kabupaten_SP" name="txt_Kota_SP" style="width: 100% !important" required>
                        //                                             <option value="${result.pkj[i]['kab']}">${result.pkj[i]['kab']}</option>
                        //                                         </select>
                        //                                     </div>
                        //                                 </div>
                        //                             </div>
                        //                             <div class="col-lg-12">
                        //                                 <div class="form-group">
                        //                                     <label for="txtKec_SP" class="col-lg-4 control-label">Kecamatan
                        //                                     </label>
                        //                                     <div class="col-lg-8">
                        //                                         <select class="select select2 form-control Kecamatan_SP" name="txtKec_SP" style="width: 100% !important" required>
                        //                                             <option value="${result.pkj[i]['kec']}">${result.pkj[i]['kec']}</option>
                        //                                         </select>
                        //                                     </div>
                        //                                 </div>
                        //                             </div>
                        //                             <div class="col-lg-12">
                        //                                 <div class="form-group">
                        //                                     <label for="txtDesa_SP" class="col-lg-4 control-label">Desa
                        //                                     </label>
                        //                                     <div class="col-lg-8">
                        //                                         <select class="select select2 form-control Desa_SP" name="txtDesa_SP" style="width: 100% !important" required>
                        //                                             <option value="${result.pkj[i]['desa']}">${result.pkj[i]['desa']}</option>
                        //                                         </select>
                        //                                     </div>
                        //                                 </div>
                        //                             </div>
                        //                             <div class="col-lg-12">
                        //                                 <div class="form-group">
                        //                                     <label for="inp_kodepos_SP" class="col-lg-4 control-label">Kodepos
                        //                                     </label>
                        //                                     <div class="col-lg-8">
                        //                                         <input type="number" name="inp_kodepos_SP" class="form-control inp_kodepos_SP" max="99999" value="${result.pkj[i]['kodepos']}">
                        //                                     </div>
                        //                                 </div>
                        //                             </div>
                        //                             <div class="col-lg-12">
                        //                                 <div class="form-group">
                        //                                     <label for="txt_noTlp_SP" class="col-lg-4 control-label">Telephone
                        //                                     </label>
                        //                                     <div class="col-lg-8">
                        //                                         <input type="text" name="txt_noTlp_SP" class="form-control txt_noTlp_SP" value="${result.pkj[i]['telepon']}">
                        //                                     </div>
                        //                                 </div>
                        //                             </div>
                        //                             <div class="col-lg-12">
                        //                                 <div class="form-group">
                        //                                     <label for="txt_noHP_SP" class="col-lg-4 control-label">Nomor HP
                        //                                     </label>
                        //                                     <div class="col-lg-8">
                        //                                         <input type="text" name="txt_noHP_SP" class="form-control txt_noHP_SP" value="${result.pkj[i]['nohp']}">
                        //                                     </div>
                        //                                 </div>
                        //                             </div>
                        //                         </div>
                        //                     </div>
                        //                 </div>
                        //                 <div class="box-body panel-footer text-center">
                        //                     <button type="button" class="btn btn-success btn_Save_SP" name="button"><span class="fa fa-check">&emsp;Simpan</span></button>
                        //                 </div>
                        //             </form>
                        //         </div>`
                        //     }
                        //     $('#find_pkj_SP').append(datatoAppend)
        //             }
        //         })
        //     }
        // })



    // })
</script>
