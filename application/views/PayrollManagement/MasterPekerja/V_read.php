<section class="content">
    <div class="inner" >
        <div class="row">
            <form class="form-horizontal">
            <div class="col-lg-12">
                <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-11">
                                <div class="text-right">
                                <h1><b>Master Pekerja</b></h1>

                                </div>
                            </div>
                            <div class="col-lg-1 ">
                                <div class="text-right hidden-md hidden-sm hidden-xs">
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('PayrollManagement/MasterPekerja/');?>">
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
                            <div class="box-header with-border">
                                Read Master Pekerja
                            </div>
                        <div class="box-body">
                            <div class="panel-body">
                                <div class="row">
<div class="form-group">
                                            <label for="txtKdHubunganKerja" class="control-label col-lg-4">Kd Hubungan Kerja</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="txtKdHubunganKerja" id="txtKdHubunganKerja" class="form-control" value="<?php echo $kd_hubungan_kerja; ?>" readonly/>
                                            </div>
                                        </div>
<div class="form-group">
                                            <label for="txtKdStatusKerja" class="control-label col-lg-4">Kd Status Kerja</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="txtKdStatusKerja" id="txtKdStatusKerja" class="form-control" value="<?php echo $kd_status_kerja; ?>" readonly/>
                                            </div>
                                        </div>
<div class="form-group">
                                            <label for="txtNik" class="control-label col-lg-4">Nik</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="txtNik" id="txtNik" class="form-control" value="<?php echo $nik; ?>" readonly/>
                                            </div>
                                        </div>
<div class="form-group">
                                            <label for="txtNoKk" class="control-label col-lg-4">No Kk</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="txtNoKk" id="txtNoKk" class="form-control" value="<?php echo $no_kk; ?>" readonly/>
                                            </div>
                                        </div>
<div class="form-group">
                                            <label for="txtNama" class="control-label col-lg-4">Nama</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="txtNama" id="txtNama" class="form-control" value="<?php echo $nama; ?>" readonly/>
                                            </div>
                                        </div>
<div class="form-group">
                                            <label for="txtIdKantorAsal" class="control-label col-lg-4">Id Kantor Asal</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="txtIdKantorAsal" id="txtIdKantorAsal" class="form-control" value="<?php echo $id_kantor_asal; ?>" readonly/>
                                            </div>
                                        </div>
<div class="form-group">
                                            <label for="txtIdLokasiKerja" class="control-label col-lg-4">Id Lokasi Kerja</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="txtIdLokasiKerja" id="txtIdLokasiKerja" class="form-control" value="<?php echo $id_lokasi_kerja; ?>" readonly/>
                                            </div>
                                        </div>
<div class="form-group">
                                            <label for="txtJnsKelamin" class="control-label col-lg-4">Jns Kelamin</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="txtJnsKelamin" id="txtJnsKelamin" class="form-control" value="<?php echo $jns_kelamin; ?>" readonly/>
                                            </div>
                                        </div>
<div class="form-group">
                                            <label for="txtTempatLahir" class="control-label col-lg-4">Tempat Lahir</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="txtTempatLahir" id="txtTempatLahir" class="form-control" value="<?php echo $tempat_lahir; ?>" readonly/>
                                            </div>
                                        </div>
<div class="form-group">
                                            <label for="txtTglLahir" class="control-label col-lg-4">Tgl Lahir</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="txtTglLahir" id="txtTglLahir" class="form-control" value="<?php echo $tgl_lahir; ?>" readonly/>
                                            </div>
                                        </div>
<div class="form-group">
                                            <label for="txtAlamat" class="control-label col-lg-4">Alamat</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="txtAlamat" id="txtAlamat" class="form-control" value="<?php echo $alamat; ?>" readonly/>
                                            </div>
                                        </div>
<div class="form-group">
                                            <label for="txtDesa" class="control-label col-lg-4">Desa</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="txtDesa" id="txtDesa" class="form-control" value="<?php echo $desa; ?>" readonly/>
                                            </div>
                                        </div>
<div class="form-group">
                                            <label for="txtKecamatan" class="control-label col-lg-4">Kecamatan</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="txtKecamatan" id="txtKecamatan" class="form-control" value="<?php echo $kecamatan; ?>" readonly/>
                                            </div>
                                        </div>
<div class="form-group">
                                            <label for="txtKabupaten" class="control-label col-lg-4">Kabupaten</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="txtKabupaten" id="txtKabupaten" class="form-control" value="<?php echo $kabupaten; ?>" readonly/>
                                            </div>
                                        </div>
<div class="form-group">
                                            <label for="txtProvinsi" class="control-label col-lg-4">Provinsi</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="txtProvinsi" id="txtProvinsi" class="form-control" value="<?php echo $provinsi; ?>" readonly/>
                                            </div>
                                        </div>
<div class="form-group">
                                            <label for="txtKodePos" class="control-label col-lg-4">Kode Pos</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="txtKodePos" id="txtKodePos" class="form-control" value="<?php echo $kode_pos; ?>" readonly/>
                                            </div>
                                        </div>
<div class="form-group">
                                            <label for="txtNoHp" class="control-label col-lg-4">No Hp</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="txtNoHp" id="txtNoHp" class="form-control" value="<?php echo $no_hp; ?>" readonly/>
                                            </div>
                                        </div>
<div class="form-group">
                                            <label for="txtGelarD" class="control-label col-lg-4">Gelar D</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="txtGelarD" id="txtGelarD" class="form-control" value="<?php echo $gelar_d; ?>" readonly/>
                                            </div>
                                        </div>
<div class="form-group">
                                            <label for="txtGelarB" class="control-label col-lg-4">Gelar B</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="txtGelarB" id="txtGelarB" class="form-control" value="<?php echo $gelar_b; ?>" readonly/>
                                            </div>
                                        </div>
<div class="form-group">
                                            <label for="txtPendidikan" class="control-label col-lg-4">Pendidikan</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="txtPendidikan" id="txtPendidikan" class="form-control" value="<?php echo $pendidikan; ?>" readonly/>
                                            </div>
                                        </div>
<div class="form-group">
                                            <label for="txtJurusan" class="control-label col-lg-4">Jurusan</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="txtJurusan" id="txtJurusan" class="form-control" value="<?php echo $jurusan; ?>" readonly/>
                                            </div>
                                        </div>
<div class="form-group">
                                            <label for="txtSekolah" class="control-label col-lg-4">Sekolah</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="txtSekolah" id="txtSekolah" class="form-control" value="<?php echo $sekolah; ?>" readonly/>
                                            </div>
                                        </div>
<div class="form-group">
                                            <label for="txtStatNikah" class="control-label col-lg-4">Stat Nikah</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="txtStatNikah" id="txtStatNikah" class="form-control" value="<?php echo $stat_nikah; ?>" readonly/>
                                            </div>
                                        </div>
<div class="form-group">
                                            <label for="txtTglNikah" class="control-label col-lg-4">Tgl Nikah</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="txtTglNikah" id="txtTglNikah" class="form-control" value="<?php echo $tgl_nikah; ?>" readonly/>
                                            </div>
                                        </div>
<div class="form-group">
                                            <label for="txtJmlAnak" class="control-label col-lg-4">Jml Anak</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="txtJmlAnak" id="txtJmlAnak" class="form-control" value="<?php echo $jml_anak; ?>" readonly/>
                                            </div>
                                        </div>
<div class="form-group">
                                            <label for="txtJmlSdr" class="control-label col-lg-4">Jml Sdr</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="txtJmlSdr" id="txtJmlSdr" class="form-control" value="<?php echo $jml_sdr; ?>" readonly/>
                                            </div>
                                        </div>
<div class="form-group">
                                            <label for="txtDiangkat" class="control-label col-lg-4">Diangkat</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="txtDiangkat" id="txtDiangkat" class="form-control" value="<?php echo $diangkat; ?>" readonly/>
                                            </div>
                                        </div>
<div class="form-group">
                                            <label for="txtMasukKerja" class="control-label col-lg-4">Masuk Kerja</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="txtMasukKerja" id="txtMasukKerja" class="form-control" value="<?php echo $masuk_kerja; ?>" readonly/>
                                            </div>
                                        </div>
<div class="form-group">
                                            <label for="txtKodesie" class="control-label col-lg-4">Kodesie</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="txtKodesie" id="txtKodesie" class="form-control" value="<?php echo $kodesie; ?>" readonly/>
                                            </div>
                                        </div>
<div class="form-group">
                                            <label for="txtGolKerja" class="control-label col-lg-4">Gol Kerja</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="txtGolKerja" id="txtGolKerja" class="form-control" value="<?php echo $gol_kerja; ?>" readonly/>
                                            </div>
                                        </div>
<div class="form-group">
                                            <label for="txtKdAsalOutsourcing" class="control-label col-lg-4">Kd Asal Outsourcing</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="txtKdAsalOutsourcing" id="txtKdAsalOutsourcing" class="form-control" value="<?php echo $kd_asal_outsourcing; ?>" readonly/>
                                            </div>
                                        </div>
<div class="form-group">
                                            <label for="txtKdJabatan" class="control-label col-lg-4">Kd Jabatan</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="txtKdJabatan" id="txtKdJabatan" class="form-control" value="<?php echo $kd_jabatan; ?>" readonly/>
                                            </div>
                                        </div>
<div class="form-group">
                                            <label for="txtJabatan" class="control-label col-lg-4">Jabatan</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="txtJabatan" id="txtJabatan" class="form-control" value="<?php echo $jabatan; ?>" readonly/>
                                            </div>
                                        </div>
<div class="form-group">
                                            <label for="txtNpwp" class="control-label col-lg-4">Npwp</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="txtNpwp" id="txtNpwp" class="form-control" value="<?php echo $npwp; ?>" readonly/>
                                            </div>
                                        </div>
<div class="form-group">
                                            <label for="txtNoKpj" class="control-label col-lg-4">No Kpj</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="txtNoKpj" id="txtNoKpj" class="form-control" value="<?php echo $no_kpj; ?>" readonly/>
                                            </div>
                                        </div>
<div class="form-group">
                                            <label for="txtLmKontrak" class="control-label col-lg-4">Lm Kontrak</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="txtLmKontrak" id="txtLmKontrak" class="form-control" value="<?php echo $lm_kontrak; ?>" readonly/>
                                            </div>
                                        </div>
<div class="form-group">
                                            <label for="txtAkhKontrak" class="control-label col-lg-4">Akh Kontrak</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="txtAkhKontrak" id="txtAkhKontrak" class="form-control" value="<?php echo $akh_kontrak; ?>" readonly/>
                                            </div>
                                        </div>
<div class="form-group">
                                            <label for="txtStatPajak" class="control-label col-lg-4">Stat Pajak</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="txtStatPajak" id="txtStatPajak" class="form-control" value="<?php echo $stat_pajak; ?>" readonly/>
                                            </div>
                                        </div>
<div class="form-group">
                                            <label for="txtJtAnak" class="control-label col-lg-4">Jt Anak</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="txtJtAnak" id="txtJtAnak" class="form-control" value="<?php echo $jt_anak; ?>" readonly/>
                                            </div>
                                        </div>
<div class="form-group">
                                            <label for="txtJtBknAnak" class="control-label col-lg-4">Jt Bkn Anak</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="txtJtBknAnak" id="txtJtBknAnak" class="form-control" value="<?php echo $jt_bkn_anak; ?>" readonly/>
                                            </div>
                                        </div>
<div class="form-group">
                                            <label for="txtTglSpsi" class="control-label col-lg-4">Tgl Spsi</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="txtTglSpsi" id="txtTglSpsi" class="form-control" value="<?php echo $tgl_spsi; ?>" readonly/>
                                            </div>
                                        </div>
<div class="form-group">
                                            <label for="txtNoSpsi" class="control-label col-lg-4">No Spsi</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="txtNoSpsi" id="txtNoSpsi" class="form-control" value="<?php echo $no_spsi; ?>" readonly/>
                                            </div>
                                        </div>
<div class="form-group">
                                            <label for="txtTglKop" class="control-label col-lg-4">Tgl Kop</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="txtTglKop" id="txtTglKop" class="form-control" value="<?php echo $tgl_kop; ?>" readonly/>
                                            </div>
                                        </div>
<div class="form-group">
                                            <label for="txtNoKoperasi" class="control-label col-lg-4">No Koperasi</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="txtNoKoperasi" id="txtNoKoperasi" class="form-control" value="<?php echo $no_koperasi; ?>" readonly/>
                                            </div>
                                        </div>
<div class="form-group">
                                            <label for="txtKeluar" class="control-label col-lg-4">Keluar</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="txtKeluar" id="txtKeluar" class="form-control" value="<?php echo $keluar; ?>" readonly/>
                                            </div>
                                        </div>
<div class="form-group">
                                            <label for="txtTglKeluar" class="control-label col-lg-4">Tgl Keluar</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="txtTglKeluar" id="txtTglKeluar" class="form-control" value="<?php echo $tgl_keluar; ?>" readonly/>
                                            </div>
                                        </div>
<div class="form-group">
                                            <label for="txtKdPkj" class="control-label col-lg-4">Kd Pkj</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="txtKdPkj" id="txtKdPkj" class="form-control" value="<?php echo $kd_pkj; ?>" readonly/>
                                            </div>
                                        </div>
<div class="form-group">
                                            <label for="txtAnggJkn" class="control-label col-lg-4">Angg Jkn</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="txtAnggJkn" id="txtAnggJkn" class="form-control" value="<?php echo $angg_jkn; ?>" readonly/>
                                            </div>
                                        </div>
</div>
                                
                            </div>
                            <div class="panel-footer">
                                <div class="row text-right">
                                    <a href="javascript:history.back(1)" class="btn btn-primary btn-lg btn-rect">Back</a>
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