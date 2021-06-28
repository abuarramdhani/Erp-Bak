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
            <form action="<?= base_url('AdmSeleksi/SuratPenyerahan/saveEditPenyerahan') ?>" class="form-horizontal" method="post">
              <div class="box box-solid box-primary">
                <div class="box-header with-border">
                  <b>
                    <p style="font-size: 15px">--- Edit Surat Penyerahan ---</p>
                  </b>
                </div>
                <div class="box-body">
                  <div class="panel-body">
                    <div class="row">
                      <div class="col-lg-6" style="margin-top: 10px">
                        <div class="form-group">
                          <label for="txt_tgl_SP" class="col-lg-4 control-label text-left">Tanggal Penyerahan</label>
                          <div class="col-lg-5">
                            <input type="text" name="txt_tgl_SP" class="form-control" id="txt_tgl_SP_edit" value="<?= $data[0]['tgl_masuk'] ?>" readonly>
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-6" style="margin-top: 10px" id="gol_Pekerja_SP">
                        <div class="form-group">
                          <label for="slc_gol_pkj_SP" class="col-lg-5 control-label text-right">Gol</label>
                          <div class="col-lg-3">
                            <select class="select select2 form-control" name="slc_gol_pkj_SP" id="slc_gol_pkj_SP">
                              <option <?= $data[0]['gol'] == '-' ? 'Selected' : '' ?> value="-">-</option>
                              <?php foreach ($gol as $gol) { ?>
                                <option <?= $gol == $data[0]['gol'] ? 'Selected' : '' ?> value="<?= $gol ?>"><?= $gol ?></option>
                              <?php } ?>
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
                            <input name="slc_pkj_SP" class="form-control" id="slc_pkj_SP" value="<?= $data[0]['jenis_pkj'] ?>" readonly>
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-6">
                        <div class="form-group">
                          <label for="slc_RuangLingkup_SP" class="col-lg-5 control-label ">Ruang Lingkup Penyerahan</label>
                          <div class="col-lg-7">
                            <input class="form-control" type="text" name="" value="<?php echo $data[0]['ruang_lingkup'] ?>" readonly>
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
                              <div class="col-lg-12" />
                              <div class="form-group">
                                <label for="inpKodesie_SP" class="col-lg-4 control-label ">Kodesie</label>
                                <div class="col-lg-8">
                                  <input class="form-control inpKodesie_SP" type="text" name="inpKodesie_SP" value="<?php echo $data[0]['kodesie'] ?>" readonly>
                                </div>
                              </div>
                            </div>
                            <div class="col-lg-12">
                              <div class="form-group">
                                <label for="txtDeptPenyerahan" class="col-lg-4 control-label ">Departemen</label>
                                <div class="col-lg-8">
                                  <input type="text" name="txtDeptPenyerahan" class="form-control" id="txtDeptPenyerahan" readonly="" value="<?php echo $data[0]['dept'] ?>">
                                </div>
                              </div>
                            </div>
                            <div class="col-lg-12">
                              <div class="form-group">
                                <label for="txtBidPenyerahan" class="col-lg-4 control-label">Bidang</label>
                                <div class="col-lg-8">
                                  <input type="text" name="txtBidPenyerahan" class="form-control" id="txtBidPenyerahan" readonly="" value="<?php echo $data[0]['bidang'] ?>">
                                </div>
                              </div>
                            </div>
                            <div class="col-lg-12">
                              <div class="form-group">
                                <label for="txtUnitPenyerahan" class="col-lg-4 control-label">Unit</label>
                                <div class="col-lg-8">
                                  <input type="text" name="txtUnitPenyerahan" class="form-control" id="txtUnitPenyerahan" readonly="" value="<?php echo $data[0]['unit'] ?>">
                                </div>
                              </div>
                            </div>
                            <div class="col-lg-12">
                              <div class="form-group">
                                <label for="txtSeksiPenyerahan" class="col-lg-4 control-label ">Seksi</label>
                                <div class="col-lg-8">
                                  <input type="text" name="txtSeksiPenyerahan" class="form-control" id="txtSeksiPenyerahan" readonly="" value="<?php echo $data[0]['seksi'] ?>">
                                </div>
                              </div>
                            </div>
                            <div class="col-lg-12">
                              <div class="form-group">
                                <label for="txtKerja_SP" class="col-lg-4 control-label ">Pekerjaan</label>
                                <div class="col-lg-8">
                                  <select class="select select2 form-control" name="inpt_pekerjaan" id="inpt_pekerjaan">
                                    <?php foreach ($pekerjaan as $kerja) { ?>
                                      <option <?= $kerja['pekerjaan'] == $data[0]['pekerjaan'] ? 'selected' : '' ?> value="<?= $kerja['kdpekerjaan'] ?>"><?= $kerja['pekerjaan'] ?></option>
                                    <?php } ?>
                                  </select>
                                </div>
                              </div>
                            </div>
                            <div class="col-lg-12">
                              <div class="form-group">
                                <label for="txtTmpPenyerahan" class="col-lg-4 control-label ">Tempat</label>
                                <div class="col-lg-8">
                                  <input type="text" name="txtTmpPenyerahan" class="form-control" id="txtTmpPenyerahan" readonly="" value="<?php echo $data[0]['seksi'] ?>">
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="box box-solid box-default">
                        <div class="box-header with-border"><b>
                            <p style="font-size: 15px">--- Hubungan Kerja ---</p>
                          </b></div>
                        <div class="row">
                          <div class="col-lg-12">
                            <div class="col-lg-12" id="LM_Hide_Hubker">
                              <div class="form-group">
                                <label for="txt_try_hubker" class="col-lg-4 control-label">Lama Orientasi</label>
                                <div class="col-lg-3">
                                  <input type="text" name="txt_try_hubker" class="form-control" id="txt_try_hubker" value="<?= $data[0]['lama_trainee'] ?>">
                                </div>
                                <p for="txt_try_hubker" class="col-lg-1 control-label">Bulan</p>
                              </div>
                            </div>
                            <div class="col-lg-12" id="LM_K_Hubker">
                              <div class="form-group">
                                <label for="txt_lama_kontrak" class="col-lg-4 control-label">Lama Kontrak</label>
                                <div class="col-lg-3">
                                  <input type="text" name="txt_lama_kontrak" class="form-control" id="txt_lama_kontrak" value="<?= $data[0]['lama_kontrak'] ?>">
                                </div>
                                <p for="txt_lama_kontrak" class="col-lg-1 control-label">Bulan</p>
                              </div>
                            </div>
                            <div class="col-lg-12" style="margin-bottom: 13px" id="tgl_ik_hubker">
                              <div class="form-group">
                                <label for="txt_IK_hubker" class="col-lg-4 control-label">Tanggal Mulai IK
                                </label>
                                <div class="col-lg-5">
                                  <input type="text" name="txt_IK_hubker" class="form-control" id="txt_IK_hubker" value="<?= $data[0]['tgl_mulaiik'] ?>">
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="box-header with-border" style=" margin-top: 23px"><b>
                            <p style="font-size: 15px">--- Seleksi ---</p>
                          </b></div>
                        <div class="row">
                          <div class="col-lg-12">
                            <div class="col-lg-12">
                              <div class="form-group">
                                <label for="txt_try_seleksi" class="col-lg-4 control-label">Lama Trainee</label>
                                <div class="col-lg-3">
                                  <input type="text" name="txt_try_seleksi" class="form-control" id="txt_try_seleksi" value="<?= $data[0]['lama_orientasi'] ?>">
                                </div>
                                <p for="txt_try_seleksi" class="col-lg-1 control-label">Bulan</p>
                              </div>
                            </div>
                            <div class="col-lg-12">
                              <div class="form-group">
                                <label for="inp_tgl_angkat_SP" class="col-lg-4 control-label">Tanggal Diangkat</label>
                                <div class="col-lg-5">
                                  <input type="text" name="inp_tgl_angkat_SP" class="form-control" id="inp_tgl_angkat_SP" value="<?= $data[0]['tgl_diangkat'] ?>">
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-12">
                      <div class="box box-solid box-default">
                        <div class="box-header with-border" style="background-color: #d2d6de;">
                          <b>
                            <p style="font-size: 15px">--- Data Perusahaan ---</p>
                          </b>
                        </div>
                        <div class="box-body">
                          <div class="col-lg-6">
                            <div class="col-lg-12">
                              <div class="form-group">
                                <label for="input_noind_baru_SP" class="col-lg-4 control-label">Nomor Induk</label>
                                <div class="col-lg-3">
                                  <input type="text" name="input_noind_baru_SP" class="form-control text-left input_noind_baru_SP" value="<?= $data[0]['noind'] ?>" readonly>
                                </div>
                              </div>
                            </div>
                            <div class="col-lg-12">
                              <div class="form-group">
                                <label for="txt_Shift_SP" class="col-lg-4 control-label ">Shift</label>
                                <div class="col-lg-8">
                                  <select class="select select2 form-control txt_Shift_SP" name="txt_Shift_SP" style="width: 100% !important" required>
                                    <option></option>
                                    <?php foreach ($shift as $key) : ?>
                                      <option <?= $key['kd_shift'] == $data[0]['pola_shift'] ? 'selected' : ''  ?> value="<?php echo $key['kd_shift'] ?>"><?php echo "[" . $key['kd_shift'] . "] - " . $key['shift'] ?></option>
                                    <?php endforeach; ?>
                                  </select>
                                </div>
                              </div>
                            </div>
                            <div class="col-lg-12">
                              <div class="form-group">
                                <label for="txt_kd_jabatan_SP" class="col-lg-4 control-label ">Kd Jabatan</label>
                                <div class="col-lg-8">
                                  <select class="select select2 form-control txt_kd_jabatan_SP" name="txt_kd_jabatan_SP" style="width: 100% !important" required>
                                    <option></option>
                                    <?php foreach ($kodejabatan as $key) : ?>
                                      <option <?= ($key['kd_jabatan'] == $data[0]['kd_jabatan']) ? 'selected' : ''  ?> value="<?php echo $key['kd_jabatan'] ?>"><?php echo '[' . $key['kd_jabatan'] . '] - ' . $key['jabatan'] ?></option>
                                    <?php endforeach; ?>
                                  </select>
                                </div>
                              </div>
                            </div>
                            <div class="col-lg-12">
                              <div class="form-group">
                                <label for="txt_jabatan_SP" class="col-lg-4 control-label ">Jabatan</label>
                                <div class="col-lg-8">
                                  <input type="text" name="txt_jabatan_SP" class="form-control text-left txt_jabatan_SP" value="<?= $data[0]['jabatan'] ?>" readonly>
                                </div>
                              </div>
                            </div>
                            <div class="col-lg-12">
                              <div class="form-group">
                                <label for="inp_stat_jbtn" class="col-lg-4 control-label ">Status Jabatan</label>
                                <div class="col-lg-8">
                                  <input type="text" name="inp_stat_jbtn" class="form-control text-left inp_stat_jbtn" value="<?= $data[0]['nama_status'] ?>" readonly>
                                </div>
                              </div>
                            </div>
                            <div class="col-lg-12">
                              <div class="form-group">
                                <label for="slc_jab_upah" class="col-lg-4 control-label ">Jabatan Upah</label>
                                <div class="col-lg-8">
                                  <select class="select select2 form-control slc_jab_upah" name="slc_jab_upah" style="width: 100% !important">
                                    <option></option>
                                    <?php
                                    foreach ($jabatan_upah as $key) { ?>
                                      <option <?= ($key['kd_upah'] == $data[0]['jab_upah']) ? 'Selected' : '' ?> value="<?= $key['kd_upah'] . '|' . $key['nama_jabatan'] ?>"><?= $key['nama_jabatan'] ?></option>
                                    <?php } ?>
                                  </select>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="col-lg-6">
                            <div class="col-lg-12">
                              <div class="form-group">
                                <label for="no_kebutuhan_SP" class="col-lg-4 control-label">Nomor Kebutuhan</label>
                                <div class="col-lg-5">
                                  <input type="text" name="no_kebutuhan_SP" class="form-control text-left no_kebutuhan_SP" value="<?php echo $data[0]['nokeb'] ?>" readonly>
                                </div>
                              </div>
                            </div>
                            <div class="col-lg-12">
                              <div class="form-group">
                                <label for="txt_Lamaran_SP" class="col-lg-4 control-label">Kode Lamaran</label>
                                <div class="col-lg-8">
                                  <input type="text" name="txt_Lamaran_SP" class="form-control txt_Lamaran_SP" value="<?= $data[0]['kodelamaran'] ?>" readonly>
                                </div>
                              </div>
                            </div>
                            <div class="col-lg-12">
                              <div class="form-group">
                                <label for="slc_kantor_SP" class="col-lg-4 control-label ">Kantor Asal</label>
                                <div class="col-lg-8">
                                  <select class="select select2 form-control slc_kantor_SP" name="slc_kantor_SP" style="width: 100% !important" required>
                                    <option></option>
                                    <?php foreach ($kantor as $key) : ?>
                                      <option <?= ($key['id_'] == $data[0]['kantor_asal']) ? 'selected' : ''  ?> value="<?php echo $key['id_'] ?>"><?php echo $key['kantor_asal'] ?></option>
                                    <?php endforeach; ?>
                                  </select>
                                </div>
                              </div>
                            </div>
                            <div class="col-lg-12">
                              <div class="form-group">
                                <label for="slc_loker_SP" class="col-lg-4 control-label ">Lokasi Kerja</label>
                                <div class="col-lg-8">
                                  <select class="select select2 form-control slc_loker_SP" name="slc_loker_SP" style="width: 100% !important" required>
                                    <option></option>
                                    <?php foreach ($lokasi as $key) : ?>
                                      <option <?= ($key['id_'] == $data[0]['lokasi_kerja']) ? 'selected' : ''  ?> value="<?php echo $key['id_'] ?>"><?php echo $key['lokasi_kerja'] ?></option>
                                    <?php endforeach; ?>
                                  </select>
                                </div>
                              </div>
                            </div>
                            <div class="col-lg-12">
                              <div class="form-group">
                                <label for="slc_makan_SP" class="col-lg-4 control-label">Tempat Makan</label>
                                <div class="col-lg-8">
                                  <select class="select select2 form-control slc_makan_SP" name="slc_makan_SP" style="width: 100% !important" required>
                                    <option></option>
                                    <?php foreach ($tempat_makan as $key) : ?>
                                      <option <?= ($key['fs_tempat_makan'] == $data[0]['tempat_makan']) ? 'selected' : ''  ?> value="<?php echo $key['fs_tempat_makan'] ?>"><?php echo $key['fs_tempat_makan'] ?></option>
                                    <?php endforeach; ?>
                                  </select>
                                </div>
                              </div>
                            </div>
                            <div class="col-lg-12">
                              <div class="form-group">
                                <label for="txt_ruang_SP" class="col-lg-4 control-label ">Ruang</label>
                                <div class="col-lg-8">
                                  <select class="select select2 form-control txt_ruang_SP" name="txt_ruang_SP" style="width: 100% !important" required>
                                    <option></option>
                                    <?php foreach ($tempat_makan as $key) : ?>
                                      <option <?= ($key['fs_tempat_makan'] == $data[0]['ruang']) ? 'selected' : ''  ?> value="<?php echo $key['fs_tempat_makan'] ?>"><?php echo $key['fs_tempat_makan'] ?></option>
                                    <?php endforeach; ?>
                                  </select>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="box-header with-border" style="background-color: #d2d6de;">
                          <b>
                            <p style="font-size: 15px;">--- Data Pribadi ---</p>
                          </b>
                        </div>
                        <div class="box-body">
                          <div class="col-lg-6">
                            <div class="col-lg-12">
                              <div class="form-group">
                                <label for="def_Nama_pkj" class="col-lg-4 control-label">Nama</label>
                                <div class="col-lg-8">
                                  <input type="text" class="form-control def_Nama_pkj" style="text-transform: uppercase !important" name="def_Nama_pkj" value="<?= $data[0]['nama'] ?>">
                                </div>
                              </div>
                            </div>
                            <div class="col-lg-12">
                              <div class="form-group">
                                <label for="inp_Agama_SP" class="col-lg-4 control-label">Agama</label>
                                <div class="col-lg-5">
                                  <select class="select select2 form-control inp_Agama_SP" name="inp_Agama_SP" style="width: 100% !important" required>
                                    <option></option>
                                    <?php
                                    $agama = array("ISLAM", "KATHOLIK", "KRISTEN", "HINDU", "BUDHA", "KONGHUCU");
                                    foreach ($agama as $key) : ?>
                                      <option <?= ($key == $data[0]['agama']) ? 'selected' : ''  ?> value="<?php echo $key ?>"><?php echo $key ?></option>
                                    <?php endforeach; ?>
                                  </select>
                                </div>
                                <label for="inp_jenkel_SP" class="col-lg-1 control-label" style="margin-left: -15px">Gender</label>
                                <div class="col-lg-2" style="margin-left: 15px">
                                  <select class="select select2 form-control inp_jenkel_SP" name="inp_jenkel_SP" style="width: 100% !important" required>
                                    <?php
                                    $jenkel = array("L", "P");
                                    foreach ($jenkel as $key) : ?>
                                      <option <?= ($key == $data[0]['jenkel']) ? 'selected' : ''  ?> value="<?php echo $key ?>"><?php echo $key ?></option>
                                    <?php endforeach; ?>
                                  </select>
                                </div>
                              </div>
                            </div>
                            <div class="col-lg-12">
                              <div class="form-group">
                                <label for="txtLokasi_Lahir" class="col-lg-4 control-label">TTL</label>
                                <div class="col-lg-4">
                                  <input type="text" name="txtLokasi_Lahir" style="text-transform: uppercase !important" class="form-control txtLokasi_Lahir" value="<?= $data[0]['templahir'] ?>" required>
                                </div>
                                <div class="col-lg-4">
                                  <input type="text" name="inp_tgl_lahir" class="form-control inp_tgl_lahir" value="<?= $data[0]['tgllahir'] ?>" required>
                                </div>
                              </div>
                            </div>
                            <div class="col-lg-12">
                              <div class="form-group">
                                <label for="txt_status_pri" class="col-lg-4 control-label">Status Nikah</label>
                                <div class="col-lg-8">
                                  <select class="select select2 form-control txt_status_pri" name="txt_status_pri" style="width: 100% !important" required>
                                    <option></option>
                                    <option value="-">-</option>
                                    <?php
                                    $status_nikah = array(
                                      array("K", "KAWIN"),
                                      array("BK", "BELUM KAWIN"),
                                      array("KS", "KAWIN SIRI")
                                    );
                                    foreach ($status_nikah as $key) : ?>
                                      <option <?= ($key[0] == $data[0]['statnikah']) ? 'selected' : ''  ?> value="<?php echo $key[0] ?>"><?php echo "[" . $key[0] . "] - " . $key[1] ?></option>
                                    <?php endforeach; ?>
                                  </select>
                                </div>
                              </div>
                            </div>
                            <div class="col-lg-12">
                              <div class="form-group">
                                <label for="txtNIK_SP" class="col-lg-4 control-label">NIK</label>
                                <div class="col-lg-8">
                                  <input type="number" max="9999999999999999" name="txtNIK_SP" class="form-control txtNIK_SP" value="<?= $data[0]['nik'] ?>" required>
                                </div>
                              </div>
                            </div>
                            <div class="col-lg-12">
                              <div class="form-group">
                                <label for="txtNPWP_SP" class="col-lg-4 control-label">NPWP</label>
                                <div class="col-lg-8">
                                  <input type="text" name="txtNPWP_SP" class="form-control txtNPWP_SP" value="<?= $data[0]['npwp'] ?>">
                                </div>
                              </div>
                            </div>
                            <div class="col-lg-12">
                              <div class="form-group">
                                <label for="txt_noKK_SP" class="col-lg-4 control-label">Nomor KK</label>
                                <div class="col-lg-8">
                                  <input type="number" max="9999999999999999" name="txt_noKK_SP" class="form-control txt_noKK_SP" value="<?= $data[0]['no_kk'] ?>">
                                </div>
                              </div>
                            </div>
                            <div class="col-lg-12">
                              <div class="form-group">
                                <label for="txtPend_SP" class="col-lg-4 control-label">Pendidikan
                                </label>
                                <div class="col-lg-8">
                                  <select class="select select2 form-control txtPend_SP" name="txtPend_SP" style="width: 100% !important; text-transform: uppercase !important" required>
                                    <option></option>
                                    <?php
                                    $pendidikan = array("SD", "SMP", "SMA", "SMK", "D1", "D3", "D4", "S1", "S2", "S3");
                                    foreach ($pendidikan as $key) : ?>
                                      <option <?= ($key == $data[0]['pendidikan']) ? 'selected' : ''  ?> value="<?php echo $key ?>"><?php echo $key ?></option>
                                    <?php endforeach; ?>
                                  </select>
                                </div>
                              </div>
                            </div>
                            <div class="col-lg-12">
                              <div class="form-group">
                                <label for="txtSkul_SP" class="col-lg-4 control-label">Sekolah</label>
                                <?php
                                $search = false;
                                foreach ($skul as $key) {
                                  if ($key['nama_univ'] == $data[0]['sekolah']) {
                                    $search = true;
                                  }
                                }
                                if ($search) { ?>
                                  <div class="col-lg-8">
                                    <select class="select select2 form-control txtSkul_SP" name="txtSkul_SP">
                                      <?php foreach ($skul as $key) : ?>
                                        <option <?= ($key['nama_univ'] == $data[0]['sekolah']) ? 'selected' : '' ?> value="<?php echo $key['nama_univ'] ?>"><?php echo $key['nama_univ'] ?></option>
                                      <?php endforeach; ?>
                                    </select>
                                  </div>
                                <?php } else { ?>
                                  <div class="col-lg-8">
                                    <input class="form-control txtSkul_SP" type="text" name="txtSkul_SP" value="<?= $data[0]['sekolah'] ?>" style="width: 100% !important; text-transform: uppercase; !important" required>
                                  </div>
                                <?php } ?>
                              </div>
                            </div>
                            <div class="col-lg-12">
                              <div class="form-group">
                                <label for="txtJurusan_SP" class="col-lg-4 control-label">Jurusan</label>
                                <div class="col-lg-8">
                                  <input class="form-control txtJurusan_SP" type="text" name="txtJurusan_SP" value="<?= $data[0]['jurusan'] ?>" style="width: 100% !important; text-transform: uppercase; !important" required>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="col-lg-6">
                            <div class="col-lg-12">
                              <div class="form-group">
                                <label for="txt_alamat_SP" class="col-lg-4 control-label">Alamat</label>
                                <div class="col-lg-8">
                                  <input type="text" name="txt_alamat_SP" class="form-control txt_alamat_SP" style="text-transform: uppercase !important" value="<?= $data[0]['alamat'] ?>" required>
                                </div>
                              </div>
                            </div>
                            <div class="col-lg-12">
                              <div class="form-group">
                                <label for="txt_Prov_SP" class="col-lg-4 control-label">Provinsi</label>
                                <div class="col-lg-8">
                                  <select class="select select2 form-control Provinsi_SP" name="txt_Prov_SP" style="width: 100% !important" required>
                                    <option value="<?= $data[0]['prop'] ?>"><?= $data[0]['prop'] ?></option>
                                  </select>
                                </div>
                              </div>
                            </div>
                            <div class="col-lg-12">
                              <div class="form-group">
                                <label for="txt_Kota_SP" class="col-lg-4 control-label">Kabupaten / Kota</label>
                                <div class="col-lg-8">
                                  <select class="select select2 form-control Kabupaten_SP" name="txt_Kota_SP" style="width: 100% !important" required>
                                    <option value="<?= $data[0]['kab'] ?>"><?= $data[0]['kab'] ?></option>
                                  </select>
                                </div>
                              </div>
                            </div>
                            <div class="col-lg-12">
                              <div class="form-group">
                                <label for="txtKec_SP" class="col-lg-4 control-label">Kecamatan</label>
                                <div class="col-lg-8">
                                  <select class="select select2 form-control Kecamatan_SP" name="txtKec_SP" style="width: 100% !important" required>
                                    <option value="<?= $data[0]['kec'] ?>"><?= $data[0]['kec'] ?></option>
                                  </select>
                                </div>
                              </div>
                            </div>
                            <div class="col-lg-12">
                              <div class="form-group">
                                <label for="txtDesa_SP" class="col-lg-4 control-label">Desa</label>
                                <div class="col-lg-8">
                                  <select class="select select2 form-control Desa_SP" name="txtDesa_SP" style="width: 100% !important" required>
                                    <option value="<?= $data[0]['desa'] ?>"><?= $data[0]['desa'] ?></option>
                                  </select>
                                </div>
                              </div>
                            </div>
                            <div class="col-lg-12">
                              <div class="form-group">
                                <label for="inp_kodepos_SP" class="col-lg-4 control-label">Kodepos</label>
                                <div class="col-lg-8">
                                  <input type="number" name="inp_kodepos_SP" class="form-control inp_kodepos_SP" max="99999" value="<?= $data[0]['kodepos'] ?>">
                                </div>
                              </div>
                            </div>
                            <div class="col-lg-12">
                              <div class="form-group">
                                <label for="txt_noHP_SP" class="col-lg-4 control-label">Nomor HP</label>
                                <div class="col-lg-8">
                                  <input type="text" name="txt_noHP_SP" class="form-control txt_noHP_SP" value="<?= $data[0]['nohp'] ?>">
                                </div>
                              </div>
                            </div>
                            <div class="col-lg-12">
                              <div class="form-group">
                                <div class="col-lg-1"></div>
                                <div class="col-lg-1">
                                  <input type="checkbox" class="cekSameNoHP">
                                </div>
                                <div class="col-lg-10">
                                  <p style="color: red;"><i>*) Beri tanda centang apabila No. Telp sama dengan No. HP</i></p>
                                </div>
                              </div>
                            </div>
                            <div class="col-lg-12">
                              <div class="form-group">
                                <label for="txt_noTlp_SP" class="col-lg-4 control-label">Telephone</label>
                                <div class="col-lg-8">
                                  <input type="text" name="txt_noTlp_SP" class="form-control txt_noTlp_SP" value="<?= $data[0]['telepon'] ?>">
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="box-header with-border" style="background-color: #d2d6de;">
                          <b>
                            <p style="font-size: 15px;">---Akun Email & Pidgin ---</p>
                          </b>
                        </div>
                        <div class="box-body">
                          <div class="col-lg-6">
                            <div class="col-lg-12">
                              <form></form>
                              <form class="form-horizontal" id="form_email_account">
                                <div class="form-group">
                                  <label class="control-label col-lg-4"></label>
                                  <div class="col-lg-8">
                                    <label>Akun email (Zimbra)</label>
                                  </div>
                                </div>
                                <div class="form-group">
                                  <label class="control-label col-lg-4">Alamat Email</label>
                                  <div class="col-lg-8">
                                    <input class="form-control" type="text" name="email_address" value="<?= $tpribadi->email_internal ?>" />
                                  </div>
                                </div>
                              </form>
                            </div>
                          </div>
                          <div class="col-lg-6">
                            <div class="col-lg-12">
                              <form class="form-horizontal" id="form_pidgin_account">
                                <div class="form-group">
                                  <label class="control-label col-lg-4"></label>
                                  <div class="col-lg-8">
                                    <label>Akun Pidgin</label>
                                  </div>
                                </div>
                                <div class="form-group">
                                  <label class="control-label col-lg-4">Email Pidgin</label>
                                  <div class="col-lg-8">
                                    <input class="form-control" placeholder="nama_email@chat.quick.com" value="<?= $tpribadi->pidgin_account ?>" type="text" name="pidgin_email"/>
                                  </div>
                                </div>
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-12">
                    <div class="panel-footer row text-center" style="margin-top: 20px;">
                      <button type="button" name="button" class="btn btn-success" id="button_edit">Simpan</button>
                      <button type="submit" class="hide" id="button_simpan_edit">Simpan</button>
                      <button onclick="window.close()" type="button" name="button" class="btn btn-danger">Back</button>
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>