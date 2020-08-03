<style media="screen">
    .addColorIfSuccess {
        background-color: #e6ffec
    }
</style>
<section class="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-11">
                            <div class="text-right">
                                <h1><b><?= $Title ?></b></h1>
                            </div>
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
                            <div class="box-header with-border"><b>
                                    <p style="font-size: 15px">--- Create Surat Penyerahan ---</p>
                                </b></div>
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
                                                            <option selected value="Seksi">Seksi</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="text" name="inputKode" value="" id="inputKode" hidden>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="box box-solid box-default">
                                                    <div class="box-header with-border"><b>
                                                            <p style="font-size: 15px">--- Data Seksi / Unit / Bidang / Departemen ---</p>
                                                        </b></div>
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
                                                                        <input type="text" name="txtBidPenyerahan" class="form-control" id="txtBidPenyerahan" readonly="">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-12">
                                                                <div class="form-group">
                                                                    <label for="txtUnitPenyerahan" class="col-lg-4 control-label">Unit</label>
                                                                    <div class="col-lg-8">
                                                                        <input type="text" name="txtUnitPenyerahan" class="form-control" id="txtUnitPenyerahan" readonly="">
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
                                                    <div class="box-header with-border hideAllHubker"><b>
                                                            <p style="font-size: 15px;">--- Hubungan Kerja ---</p>
                                                        </b></div>
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
                                                            <div class="col-lg-12" style="margin-bottom: 13px" id="tgl_ik_hubker">
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
                                                    <div class="box-header with-border nambahStyle"><b>
                                                            <p style="font-size: 15px">--- Seleksi ---</p>
                                                        </b></div>
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
                    <!-- this value from js -->
                </div>
                <div class="row daftarPekerja" hidden>
                    <div class="col-lg-12">
                        <div class="box box-solid box-primary">
                            <div class="box-header">
                                <span class="fa fa-users">&nbsp;Daftar Pekerja</span>
                            </div>
                            <div class="box-body">
                                <table class="table dataTable table-striped tabel-hover" id="tabelDaftarPekerjaSP">
                                    <thead class="bg-info">
                                        <tr>
                                            <th style="width: 5px"><input type="checkbox" id="cekAll_Create" class="cekAll_Create"></th>
                                            <th>Noind</th>
                                            <th>Nama</th>
                                            <th>Kodesie</th>
                                            <th>Seksi</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row hide_Perusahaan" hidden>
                    <div class="col-lg-12">
                        <div class="box form-horizontal">
                            <div class="row">
                                <div class="box-header with-border text-center" style="margin-top: 8px"><b>--- Diserahkan ---</b></div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="slc_petugas1_SP" class="col-lg-4 control-label">Petugas 1</label>
                                        <div class="col-lg-4">
                                            <input type="text" name="petugas" value="in" id="slc_petugas1_SP" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="slc_petugas2_SP" class="col-lg-4 control-label">Petugas 2</label>
                                        <div class="col-lg-4">
                                            <input type="text" name="petugas" value="lna" id="slc_petugas2_SP" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="slc_Kepada_SP" class="col-lg-4 control-label">Kepada</label>
                                        <div class="col-lg-4">
                                            <select class="select select2 form-control" name="slc_Kepada_SP" id="slc_Kepada_SP" style="width: 100% !important" required>
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
                                                    <option <?php if ($val['noind'] == 'B0624') {
                                                                echo 'selected';
                                                            } else {
                                                                echo '';
                                                            } ?> value="<?php echo $val['noind']; ?>"><?php echo $val['noind'] . " - " . $val['nama'] ?></option>
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
                                <a type="button" class="btn btn-success" name="button" id="btn_Cetak_SP"><span class="fa fa-print">&emsp;Cetak</span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div id="surat-loading" hidden style="top: 0;left: 0;right: 0;bottom: 0; margin: auto; position: fixed; background: rgba(0,0,0,.5); z-index: 11;">
    <img src="<?php echo site_url('assets/img/gif/loadingtwo.gif'); ?>" style="position: fixed; top: 0;left: 0;right: 0;bottom: 0; margin: auto; width: 40%;">
</div>
<script type="text/javascript">
    $(function() {
        let cekAll = $('input.cekAll_Create'),
            cekin = $('input.childCekAll')
        cekAll.on('ifChecked ifUnchecked', function(e) {
            if (e.type === 'ifChecked') {
                $('input.childCekAll').iCheck('check');
                $('.hide_Perusahaan').attr('hidden', false)
            } else {
                $('input.childCekAll').iCheck('uncheck');
                $('.hide_Perusahaan').attr('hidden', true)
            }
        })
    })
</script>