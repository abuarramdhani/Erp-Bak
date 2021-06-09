<section class="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-3">
                        </div>
                        <div class="col-lg-3"></div>
                        <div class="col-lg-5">
                            <div class="text-right">
                            </div>
                        </div>
                        <div class="col-lg-1">
                        </div>
                    </div>
                </div>
                <br />

                <div class="row">

                    <div class="col-lg-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border">
                                <h1 style="text-align:left padding:5px;">Cetak Kategori</h1>
                            </div>


                            <div class="box-body bg-white">

                                <div class="box box-primary">

                                    <div class="box-header with-border">
                                        <h2 class="box-title text-primary"><b>Cari Pekerja</b></h2>
                                        <br>

                                    </div>

                                    <div class="bg-light box-body">


                                        <div class="col-sm-6">
                                            <div class="form-group row">
                                                <div class="col-sm-4">
                                                    <label> Pendidikan</label>
                                                </div>

                                                <div class="col-sm-8">
                                                    <select class="form-control" id="TDP_Tarikpendidikan">
                                                        <option value="">Semua</option>
                                                        <?php foreach ($Tarikpendidikan as $key) { ?>
                                                            <option value="<?= $key['pendidikan'] ?>"><?= $key['pendidikan'] ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>

                                            </div>

                                            <div class="form-group row">
                                                <div class="col-sm-4">
                                                    <label> Jenis Kelamin</label>
                                                </div>

                                                <div class=" col-sm-8">
                                                    <select class="form-control" id="TDP_Tarikjenkel">
                                                        <option value="">Semua</option>
                                                        <?php foreach ($Tarikjenkel as $key) { ?>
                                                            <option value="<?= $key['jenkel'] ?>"><?= $key['jenkel'] ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <div class="col-sm-4">
                                                    <label>Lokasi Kerja</label>
                                                </div>

                                                <div class="col-sm-8">
                                                    <select class="form-control" id="TDP_Tariklokasi">
                                                        <option value="">Semua</option>
                                                        <?php foreach ($Tariklokasi as $key) { ?>
                                                            <option value="<?= $key['id_'] ?>"><?= $key['id_'], ' - ', $key['lokasi_kerja']  ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="small text-danger">*Pilih salah satu :</div>
                                            <div class="form-group row">
                                                <div class="col-sm-4">
                                                    <input type="radio" name="rbt_TDPRange" id="rbt_TDPRange1" />
                                                    <label>Tgl. Masuk Kerja</label>
                                                </div>

                                                <div class="col-sm-8">
                                                    <div class="input-group ">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-calendar"></i>
                                                        </div>

                                                        <input type="text" name="tdpdrp" class="form-control pull-right" id="TDP_Rangemasuk" value="" disabled>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <div class="col-sm-4">

                                                    <input type="radio" name="rbt_TDPRange" id="rbt_TDPRange2" />
                                                    <label>Tgl. Keluar Kerja</label>
                                                </div>

                                                <div class="col-sm-8">
                                                    <div class="input-group ">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-calendar"></i>
                                                        </div>
                                                        <input type="text" name="tdpdrp" class="form-control pull-right" id="TDP_Rangekeluar" value="" disabled>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>


                                        <div class="col-sm-6">
                                            <div class="form-group row">
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label class="form-check-label">Kode Induk :</label>
                                                        <br>
                                                        <select class="form-control pull-right" id="TDP_Tariknoind" multiple>
                                                            <?php foreach ($Tariknoind as $key) { ?>
                                                                <option value="<?= $key['fs_noind'] ?>"><?= $key['fs_noind'], ' - ', $key['fs_ket'] ?></option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="form-group row">

                                                <div class="col-sm-12">
                                                    <label class="form-check-label">Kategori :</label>
                                                    <br>
                                                </div>

                                                <div class="col-sm-4">
                                                    <select class="form-control" id="TDP_Tarikkategori">
                                                        <option selected>Seksi</option>
                                                        <option>Unit</option>
                                                        <option value="Dept">Departemen</option>
                                                    </select>
                                                </div>

                                                <div class="col-sm-8">
                                                    <select class="form-control" id="TDP_IsiKategoritarik">
                                                    </select>
                                                </div>
                                                <br>

                                            </div>
                                            <br>


                                            <div class="col-sm-6 textt-left ">
                                                <label class="radio-inline control-label float-left"><input value="f" type="radio" name="tdpstatus" checked> &nbsp; <b>Aktif</b></label>
                                                <label class="radio-inline control-label float-left"><input value="t" type="radio" name="tdpstatus"> &nbsp; <b>Keluar</b></label>


                                            </div>


                                        </div>
                                    </div>

                                </div>


                            </div>

                            <div class="box-body bg-white" id="Div_ProsesTarik">

                                <div class="box box-primary">

                                    <div class="box-header with-border">
                                        <h2 class="box-title text-primary"><b>Tarik Data</b></h2>
                                        <br>
                                        <div class="small text-danger">*Pilih minimal satu</div>
                                    </div>
                                    <br>

                                    <div class="nav-tabs-custom" style="position: relative;">

                                        <ul class="nav nav-tabs">
                                            <li class="active">
                                                <a href="#Data_pribadi" data-toggle="tab">Data Pribadi</a>
                                            </li>
                                            <li class="">
                                                <a href="#Hubungan_kerja" data-toggle="tab">Hubungan Kerja</a>
                                            </li>
                                            <li class="">
                                                <a href="#Jamsostek" data-toggle="tab">Jamsostek</a>
                                            </li>
                                        </ul>

                                    </div>
                                    <div class="tab-content">

                                        <div class="tab-pane active" id="Data_pribadi">

                                            <div class="col-sm-3">
                                                <h3 class="text-primary">Data Pribadi</h3>
                                                <input name="induk" type="checkbox" class="chk_FilterTarikData" value="tp.noind" checked>
                                                <label> No Induk</label><br>
                                                <input name="nama" type="checkbox" class="chk_FilterTarikData" value="tp.nama">
                                                <label> Nama</label><br>
                                                <input name="jenkel" type="checkbox" class="chk_FilterTarikData" value="tp.jenkel">
                                                <label> Jenis Kelamin</label><br>
                                                <input name="agama" type="checkbox" class="chk_FilterTarikData" value="tp.agama">
                                                <label> Agama</label><br>
                                                <input name="tempatlahir" type="checkbox" class="chk_FilterTarikData" value="tp.templahir">
                                                <label> Tempat Lahir</label><br>
                                                <input name="tgllahir" type="checkbox" class="chk_FilterTarikData" value="to_char(tgllahir, 'DD-MM-YYYY') AS tgllahir">
                                                <label> Tanggal Lahir</label><br>
                                                <input name="goldarah" type="checkbox" class="chk_FilterTarikData" value="tp.goldarah">
                                                <label> Gol. Darah</label><br>
                                                <input name="nik" type="checkbox" class="chk_FilterTarikData" value="tp.nik">
                                                <label> NIK</label><br>
                                                <input name="no_kk" type="checkbox" class="chk_FilterTarikData" value="tp.no_kk">
                                                <label> No. KK</label><br>
                                                <input name="nohp" type="checkbox" class="chk_FilterTarikData" value="tp.nohp">
                                                <label> No. HP</label><br>
                                                <input name="notelepon" type="checkbox" class="chk_FilterTarikData" value="tp.telepon">
                                                <label> No. Telepon</label><br>
                                            </div>

                                            <div class="col-sm-3">
                                                <h3 class="text-primary">Alamat Pekerja</h3>
                                                <input name="alamat" type="checkbox" class="chk_FilterTarikData" value="tp.alamat">
                                                <label> Alamat</label><br>
                                                <input name="prop" type="checkbox" class="chk_FilterTarikData" value="tp.prop">
                                                <label> Provinsi</label><br>
                                                <input name="kab" type="checkbox" class="chk_FilterTarikData" value="tp.kab">
                                                <label> Kabupaten</label><br>
                                                <input name="kec" type="checkbox" class="chk_FilterTarikData" value="tp.kec">
                                                <label> Kecamatan</label><br>
                                                <input name="desa" type="checkbox" class="chk_FilterTarikData" value="tp.desa">
                                                <label> Desa</label><br>
                                                <input name="kodepos" type="checkbox" class="chk_FilterTarikData" value="tp.kodepos">
                                                <label> Kode Pos</label><br>
                                                <input name="statrumah" type="checkbox" class="chk_FilterTarikData" value="tp.statrumah">
                                                <label> Status Rumah</label><br>
                                                <input name="almt_kost" type="checkbox" class="chk_FilterTarikData" value="tp.almt_kost">
                                                <label> Alamat Kos</label><br>
                                            </div>

                                            <div class="col-sm-3">
                                                <h3 class="text-primary">Anak dan Keluarga</h3>
                                                <input name="namaayah" type="checkbox" class="chk_FilterTarikData" value="(select tk.nama from hrd_khs.tkeluarga tk where nokel = '01A' and tk.noind = tp.noind limit 1) ayah">
                                                <label> Nama Ayah</label><br>
                                                <input name="namaibu" type="checkbox" class="chk_FilterTarikData" value="(select tk.nama from hrd_khs.tkeluarga tk where nokel = '02A' and tk.noind = tp.noind limit 1) ibu">
                                                <label> Nama Ibu</label><br>
                                                <input name="statnikah" type="checkbox" class="chk_FilterTarikData" value="tp.statnikah">
                                                <label> Status Nikah</label><br>
                                                <input name="tglnikah" type="checkbox" class="chk_FilterTarikData" value="to_char(tglnikah, 'DD-MM-YYYY') AS tglnikah">
                                                <label> Tanggal Nikah</label><br>
                                                <input name="jumanak" type="checkbox" class="chk_FilterTarikData" value="tp.jumanak">
                                                <label> Jumlah Anak</label><br>
                                                <input name="jumsdr" type="checkbox" class="chk_FilterTarikData" value="tp.jumsdr">
                                                <label> Jumlah Saudara</label><br>
                                                <input name="jtanak" type="checkbox" class="chk_FilterTarikData" value="tp.jtanak">
                                                <label> JT Anak</label><br>
                                                <input name="jtbknanak" type="checkbox" class="chk_FilterTarikData" value="tp.jtbknanak">
                                                <label> JTBKN Anak</label>
                                            </div>

                                            <div class=" col-sm-3">
                                                <h3 class="text-primary">Pendidikan</h3>
                                                <input name="gelard" type="checkbox" class="chk_FilterTarikData" value="tp.gelard">
                                                <label> Gelar Depan</label><br>
                                                <input name="gelarb" type="checkbox" class="chk_FilterTarikData" value="tp.gelarb">
                                                <label> Gelar Belakang</label><br>
                                                <input name="pendidikan" type="checkbox" class="chk_FilterTarikData" value="tp.pendidikan">
                                                <label> Pendidikan Terakhir</label><br>
                                                <input name="jurusan" type="checkbox" class="chk_FilterTarikData" value="tp.jurusan">
                                                <label> Jurusan</label><br>
                                                <input name="sekolah" type="checkbox" class="chk_FilterTarikData" value="tp.sekolah">
                                                <label> Asal Sekolah</label><br>
                                            </div>

                                            <div class="col-sm-3 pull-right">
                                                <h3 class="text-primary">Lain-lain</h3>
                                                <input name="email_internal" type="checkbox" class="chk_FilterTarikData" value="tp.email_internal">
                                                <label> Email Internal</label><br>
                                                <input name="email_external" type="checkbox" class="chk_FilterTarikData" value="tp.email">
                                                <label> Email External</label><br>
                                                <input name="telkomsel_mygroup" type="checkbox" class="chk_FilterTarikData" value="tp.telkomsel_mygroup">
                                                <label> Telkomsel Mygroup</label><br>
                                                <input name="pidgin" type="checkbox" class="chk_FilterTarikData" value="tp.pidgin_account">
                                                <label> Akun Pidgin</label><br>
                                                <input name="uk_baju" type="checkbox" class="chk_FilterTarikData" value="tp.uk_baju">
                                                <label> Ukuran Baju</label><br>
                                                <input name="jenis_baju" type="checkbox" class="chk_FilterTarikData" value="tp.jenis_baju">
                                                <label> Jenis Baju</label><br>
                                                <input name="uk_celana" type="checkbox" class="chk_FilterTarikData" value="tp.uk_celana">
                                                <label> Ukuran Celana</label><br>
                                                <input name="uk_sepatu" type="checkbox" class="chk_FilterTarikData" value="tp.uk_sepatu">
                                                <label> Ukuran Sepatu</label><br>
                                            </div>

                                        </div>


                                        <div class="tab-pane" id="Hubungan_kerja">
                                            <div class="col-sm-3">
                                                <h3 class="text-primary">Penempatan</h3>
                                                <input name="kodesie" type="checkbox" class="chk_FilterTarikData" value="tp.kodesie">
                                                <label> Kodesie</label><br>
                                                <input name="kodejabatan" type="checkbox" class="chk_FilterTarikData" value="tp.kd_jabatan">
                                                <label> Kode Jabatan</label><br>
                                                <input name="jabatan" type="checkbox" class="chk_FilterTarikData" value="tp.jabatan">
                                                <label> Jabatan</label><br>
                                                <input name="dept" type="checkbox" class="chk_FilterTarikData" value="ts.dept">
                                                <label> Departemen</label><br>
                                                <input name="unit" type="checkbox" class="chk_FilterTarikData" value="ts.unit">
                                                <label> Unit</label><br>
                                                <input name="seksi" type="checkbox" class="chk_FilterTarikData" value="ts.seksi">
                                                <label> Seksi</label><br>
                                                <input name="bidang" type="checkbox" class="chk_FilterTarikData" value="ts.bidang">
                                                <label> Bidang</label><br>
                                                <input name="pekerjaan" type="checkbox" class="chk_FilterTarikData" value="case when tp.kd_pkj is null then null else (select pekerjaan from hrd_khs.tpekerjaan tpe where tp.kd_pkj = tpe.kdpekerjaan) end pekerjaan">
                                                <label> Pekerjaan</label><br>
                                                <input name="asalkantor" type="checkbox" class="chk_FilterTarikData" value="tp.kantor_asal">
                                                <label> Kantor Asal</label><br>
                                                <input name="lokasi_kerja" type="checkbox" class="chk_FilterTarikData" value="tp.lokasi_kerja">
                                                <label> Lokasi Kerja</label><br>
                                                <input name="ruang" type="checkbox" class="chk_FilterTarikData" value="tp.ruang">
                                                <label> Ruang</label><br>
                                            </div>

                                            <div class="col-sm-3">
                                                <h3 class="text-primary">Hubungan Kerja</h3>
                                                <input name="asal_outsourcing" type="checkbox" class="chk_FilterTarikData" value="tp.asal_outsourcing">
                                                <label> Asal Outsorcing</label><br>
                                                <input name="golkerja" type="checkbox" class="chk_FilterTarikData" value="tp.golkerja">
                                                <label> Golongan Kerja</label><br>
                                                <input name="masukkerja" type="checkbox" class="chk_FilterTarikData" value="to_char(masukkerja, 'DD-MM-YYYY') AS masukkerja">
                                                <label> Tanggal Masuk Kerja</label><br>
                                                <input name="diangkat" type="checkbox" class="chk_FilterTarikData" value="to_char(diangkat, 'DD-MM-YYYY') AS diangkat">
                                                <label> Tanggal Diangkat</label><br>
                                                <input name="lmkontrak" type="checkbox" class="chk_FilterTarikData" value="tp.lmkontrak">
                                                <label> Lama Kontrak</label><br>
                                                <input name="akhkontrak" type="checkbox" class="chk_FilterTarikData" value="to_char(akhkontrak, 'DD-MM-YYYY') AS akhkontrak">
                                                <label> Akhir Kontrak</label><br>
                                                <input name="tglkeluar" type="checkbox" class="chk_FilterTarikData" value="to_char(tglkeluar, 'DD-MM-YYYY') AS tglkeluar">
                                                <label> Tanggal Keluar</label><br>
                                                <input name="sebabklr" type="checkbox" class="chk_FilterTarikData" value="tp.sebabklr">
                                                <label> Sebab Keluar</label><br>
                                                <input name="status_diangkat" type="checkbox" class="chk_FilterTarikData" value="tp.status_diangkat">
                                                <label> Status Diangkat</label><br>
                                                <input name="masa_kerja" type="checkbox" class="chk_FilterTarikData_masakerja" value=",to_char(diangkat, 'DD-MM-YYYY') AS diangkat,to_char(masukkerja, 'DD-MM-YYYY') AS masukkerja">
                                                <label> Masa Kerja</label><br>
                                            </div>

                                            <div class="col-sm-3">
                                                <h3 class="text-primary">Pajak</h3>
                                                <input name="statpajak" type="checkbox" class="chk_FilterTarikData" value="tp.statpajak">
                                                <label> Status Pajak</label><br>
                                                <input name="npwp" type="checkbox" class="chk_FilterTarikData" value="tp.npwp">
                                                <label> NPWP</label><br>
                                            </div>

                                            <div class="col-sm-3">
                                                <h3 class="text-primary">Tempat Makan</h3>
                                                <input name="makan" type="checkbox" class="chk_FilterTarikData" value="tp.tempat_makan">
                                                <label> Tempat Makan</label><br>
                                                <input name="makan1" type="checkbox" class="chk_FilterTarikData" value="tp.tempat_makan1">
                                                <label>Tempat Makan 1</label><br>
                                                <input name="makan2" type="checkbox" class="chk_FilterTarikData" value="tp.tempat_makan2">
                                                <label>Tempat Makan 2</label><br>
                                            </div>

                                            <div class="col-sm-3">
                                                <h3 class="text-primary">SPSI & Koperasi</h3>
                                                <input name="tglspsi" type="checkbox" class="chk_FilterTarikData" value="to_char(tglspsi, 'DD-MM-YYYY') AS tglspsi">
                                                <label> Tgl. Pendaftaran SPSI</label><br>
                                                <input name="nospsi" type="checkbox" class="chk_FilterTarikData" value="tp.nospsi">
                                                <label> No. SPSI</label><br>
                                                <input name="tglkop" type="checkbox" class="chk_FilterTarikData" value="to_char(tglkop, 'DD-MM-YYYY') AS tglkop">
                                                <label> Tgl. Pendaftaran Koperasi</label><br>
                                                <input name="nokop" type="checkbox" class="chk_FilterTarikData" value="tp.nokoperasi">
                                                <label> No. Koperasi</label><br>
                                            </div>

                                            <div class="col-sm-3">
                                                <h3 class="text-primary">Lain - lain</h3>
                                                <input name="nokeb" type="checkbox" class="chk_FilterTarikData" value="tp.nokeb">
                                                <label> No. Keb</label><br>
                                                <input name="upamk" type="checkbox" class="chk_FilterTarikData" value="tp.ang_upamk">
                                                <label> Ang_upamk</label><br>
                                            </div>


                                        </div>

                                        <div class="tab-pane" id="Jamsostek">

                                            <div class="col-sm-3">
                                                <h3 class="text-primary">BPJS Kes</h3>
                                                <input name="nokes" type="checkbox" class="chk_FilterTarikData" value="tb.no_peserta as no_bpjskes">
                                                <label> No Kes</label><br>
                                                <input name="tglmulaik" type="checkbox" class="chk_FilterTarikData" value="to_char(tb.tglmulai, 'DD-MM-YYYY') AS tglmulaik">
                                                <label> Tgl. mulai</label><br>
                                                <input name="tglakhirk" type="checkbox" class="chk_FilterTarikData" value="to_char(tb.tglakhir, 'DD-MM-YYYY') AS tglakhirk">
                                                <label> Tgl. Akhir</label><br>
                                                <input name="bpu" type="checkbox" class="chk_FilterTarikData" value="tb.bpu">
                                                <label> BPU</label><br>
                                                <input name="bpg" type="checkbox" class="chk_FilterTarikData" value="tb.bpg">
                                                <label> BPG</label><br>
                                                <input name="rsb" type="checkbox" class="chk_FilterTarikData" value="tb.rsb">
                                                <label> RSB</label><br>
                                                <input name="dokterjpk" type="checkbox" class="chk_FilterTarikData" value="tb.dokterjpk">
                                                <label> Dokter JPK</label><br>
                                            </div>

                                            <div class="col-sm-3">
                                                <h3 class="text-primary">BPJS TK</h3>
                                                <input name="nokpj" type="checkbox" class="chk_FilterTarikData" value="ttk.no_peserta as no_bpjstk">
                                                <label> No KPJ</label><br>
                                                <input name="tglmulai" type="checkbox" class="chk_FilterTarikData" value="to_char(ttk.tglmulai, 'DD-MM-YYYY') AS tglmulai">
                                                <label> Tgl. Mulai</label><br>
                                                <input name="tglakhir" type="checkbox" class="chk_FilterTarikData" value="to_char(ttk.tglakhir, 'DD-MM-YYYY') AS tglakhir">
                                                <label> Tgl. Akhir</label><br>
                                                <input name="pensiun" type="checkbox" class="chk_FilterTarikData" value="ttk.kartu_jaminan_pensiun">
                                                <label> Kartu Jaminan Pensiun</label><br>
                                            </div>


                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="box-footer with-border"><button class="btn btn-lg btn-rect btn-primary" id="TDP_TarikDataAll">TAMPIL DATA</button></div>
                            <div class="box-body bg-white" id="Div_viewall"></div>
                        </div>


                    </div>
</section>