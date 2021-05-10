<style>
  .hello {
    color: azure
  }
</style>
<section class="content">
  <div class="inner">
    <div class="row">
      <form method="post" action="<?php echo site_url('MasterPekerja/Surat/BapAkhirKerja/add'); ?>" class="form-horizontal">
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
                  <a class="btn btn-default btn-lg" href="<?php echo site_url('MasterPekerja/Surat/BapAkhirKerja/'); ?>">
                    <i class="icon-wrench icon-2x"></i>
                    <span><br /></span>
                  </a>
                </div>
              </div>
            </div>
          </div>
          <br />
          <div class="row">
            <div class="col-lg-12">
              <div class="box box-primary box-solid">
                <div class="box-header with-border">Input BAP AKHIR KERJA</div>
                <div class="box-body">
                  <div class="panel-body">
                    <div class="row">
                      <div class="col-lg-6">
                        <div class="form-group">
                          <label class="control-label col-lg-4">Tanggal Panggilan</label>
                          <div class="col-lg-8">
                            <input required class="form-control " type="text" name="tanggalSurat" id="MasterPekerja-tanggalSuratBak-singledate" autocomplete="off" placeholder="Tanggal Panggilan">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-lg-4">Lokasi Kerja</label>
                          <div class="col-lg-8">
                            <input class="form-control" type="text" name="lokasiKerja" id="MasterPekerja-lokasiKerja" readonly placeholder="Lokasi Kerja">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-lg-4">Nama Pekerja</label>
                          <div class="col-lg-8">
                            <select required class="form-control select2" type="text" name="namaPekerja" id="MasterPekerja-namaPekerja">
                              <option></option>
                            </select>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-lg-4">Jabatan</label>
                          <div class="col-lg-8">
                            <input class="form-control" type="text" name="jabatanPekerja" id="MasterPekerja-jabatanPekerja" readonly placeholder="Jabatan Pekerja">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-lg-4">Seksi/Unit</label>
                          <div class="col-lg-8">
                            <input class="form-control" type="text" name="seksiPekerja" id="MasterPekerja-seksiPekerja" readonly placeholder="Seksi Pekerja">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-lg-4">Nama Petugas</label>
                          <div class="col-lg-8">
                            <select required class="form-control select2" type="text" name="namaPetugas" id="MasterPekerja-namaPetugas">
                              <option></option>
                            </select>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-lg-4">Jabatan Petugas</label>
                          <div class="col-lg-8">
                            <input class="form-control" type="text" name="jabatanPetugas" id="MasterPekerja-jabatanPetugas" readonly placeholder="Jabatan Petugas">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-lg-4">Tanggal Akhir Kerja</label>
                          <div class="col-lg-8">
                            <input required class="form-control " type="text" name="tanggalAkhirKerja" id="MasterPekerja-tanggalAkhirKerja-singledate" autocomplete="off" placeholder="Akhir Kerja">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-lg-4">Tanggal Berhenti Kerja</label>
                          <div class="col-lg-8">
                            <input required class="form-control " type="text" name="tanggalBerhentiKerja" id="MasterPekerja-tanggalBerhentiKerja-singledate" autocomplete="off" placeholder="Berhenti Kerja">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-lg-4">Sebab Berakhir</label>
                          <div class="col-lg-8">
                            <select required class="form-control select2" type="text" name="sebabBerakhir" id="MasterPekerja-sebabBerakhir">
                              <option></option>
                              <?php foreach ($sebab_berakhir as $sb) : ?>
                                <option value="<?= $sb['sebab_keluar']; ?>"><?= $sb['sebab_keluar']; ?></option>
                              <?php endforeach; ?>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-6">
                        <div class="form-group">
                          <label class="control-label col-lg-4">Tanggal Penggajian</label>
                          <div class="col-lg-8">
                            <input required class="form-control " type="text" name="tanggalPenggajian" id="MasterPekerja-tanggalPenggajian-singledate" autocomplete="off" placeholder="Tanggal Penggajian">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-lg-4">Keterangan Penggajian</label>
                          <div class="col-lg-8">
                            <textarea style="resize:none;" class="form-control" type="text" name="keteranganPenggajian" id="MasterPekerja-keteranganPenggajian" placeholder="Keterangan Penggajian"></textarea>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-lg-4">Tgl. Aktif BPJS Kes</label>
                          <div class="col-lg-8" style="position:relative;">
                            <input required class="form-control" type=" text" name="tanggalAktifBpjs" id="MasterPekerja-tanggalAktifBpjs-singledate" autocomplete="off" placeholder="BPJS Aktif">
                            <input class="form-control" style="position:absolute;right:10px; top:50%; transform:translateY(-50%); border:none; border-left:1px solid #ccc; outline:none; background:transparent; height:100%;width:60%;" name="no_bpjskes" id="MasterPekerja-noBpjskes" placeholder="Nomor BPJS Kes" autocomplete="off">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-lg-4">Tgl. Non Aktif BPJS Ket</label>
                          <div class="col-lg-8" style="position:relative;">
                            <input required class="form-control" type="text" name="tanggalNonAktifBpjs" id="MasterPekerja-tanggalNonAktifBpjs-singledate" autocomplete="off" placeholder="BPJS Non Aktif">
                            <input class="form-control" style="position:absolute;right:10px; top:50%; transform:translateY(-50%); border:none; border-left:1px solid #ccc; outline:none; background:transparent; height:100%;width:60%;" name="no_bpjsket" id="MasterPekerja-noBpjsket" placeholder="Nomor BPJS Ket" autocomplete="off">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-lg-4">Tanggal Pencairan JHT</label>
                          <div class="col-lg-8">
                            <input required class="form-control " type="text" name="tanggalPencairanJHT" id="MasterPekerja-tanggalPencairanJHT-singledate" autocomplete="off" placeholder="Pencairan JHT">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-lg-4">Pengambilan Surat Pengalaman Kerja</label>
                          <div class="col-lg-8">
                            <input required class="form-control " type="text" name="tanggalSuratPengalamanKerja" id="MasterPekerja-tanggalSuratPengalamanKerja-singledate" autocomplete="off" placeholder="Surat Pengalaman">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-lg-4">Laporan Pajak</label>
                          <div class="col-lg-8">
                            <input class="form-control" type="text" name="laporanPajak" id="MasterPekerja-laporanPajak-yearonly" autocomplete="off" placeholder="Laporan Pajak">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-lg-4">Kontak Hp HR</label>
                          <div class="col-lg-8">
                            <select required class="form-control select2" type="text" name="kontakHpHr" id="MasterPekerja-kontakHpHr">
                              <option></option>
                              <?php $no_hp = ['Pusat - 0811 2545 940', 'Tuksono - 0812 1567 1166'] ?>
                              <?php foreach ($no_hp as  $np) : ?>
                                <?php if ($np == $data_surat[0]['kontakhp_hr']) continue; ?>
                                <option id="nohp" value="<?= $np; ?>"><?= $np; ?></option>
                              <?php endforeach; ?>
                            </select>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-lg-4">Pihak 1</label>
                          <div class="col-lg-8">
                            <input class="form-control" type="text" name="pihak1" id="MasterPekerja-pihak1" readonly placeholder="Pihak 1">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-lg-4">Pihak 2</label>
                          <div class="col-lg-8">
                            <input class="form-control" type="text" name="pihak2" id="MasterPekerja-pihak2" readonly placeholder="Pihak 2">
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-12">
                        <div class="form-group">
                          <div class="col-lg-2 text-right">
                            <a id="MasterPekerja-bapAkhirKerja-btnPreview" title="Preview" class="btn btn-info">Preview</a>
                          </div>
                          <div class="col-lg-10">
                            <textarea class="redactor" name="bapAkhirKerjatxaPreview" id="reviewBapak" placeholder="Preview Surat"></textarea>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="panel-footer" style="display:flex; align-items:center; justify-content:space-between;">
                    <div class="text-left" style=" ">
                      <small class="text-danger" style="font-style: italic">
                        *mohon cek kembali data agar sesuai
                      </small>
                    </div>
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
  <img src="<?php echo site_url('assets/img/gif/loadingtwo.gif'); ?>" style="position: fixed; top: 0;left: 0;right: 0;bottom: 0; margin: auto; width: 40%;">
</div>

<script>
  document.addEventListener('DOMContentLoaded', _ => {
    $('#MasterPekerja-tanggalSuratBak-singledate').datepicker({
      format: 'yyyy-mm-dd',
      todayHighlight: true,
      autoClose: true,
      autoApply: true,
      showButtonPanel: true
    })
    $('#MasterPekerja-tanggalBerhentiKerja-singledate').datepicker({
      format: 'yyyy-mm-dd',
      todayHighlight: true,
      autoClose: true,
      autoApply: true
    })
    $('#MasterPekerja-tanggalPenggajian-singledate').datepicker({
      format: 'yyyy-mm-dd',
      todayHighlight: true,
      autoClose: true,
      autoApply: true
    })
    $('#MasterPekerja-tanggalAktifBpjs-singledate').datepicker({
      format: 'MM yyyy',
      autoClose: true,
      autoApply: true,
      minViewMode: "months"
    })
    $('#MasterPekerja-tanggalPencairanJHT-singledate').datepicker({
      format: 'MM yyyy',
      autoClose: true,
      autoApply: true,
      minViewMode: "months"
    })
    $("#MasterPekerja-tanggalSuratPengalamanKerja-singledate").datepicker({
      format: 'yyyy-mm-dd',
      todayHighlight: true,
      autoClose: true,
      autoApply: true
    });
    $("#MasterPekerja-laporanPajak-yearonly").datepicker({
      format: "yyyy",
      viewMode: "years",
      minViewMode: "years",
    });
  })
</script>