<section class="content">
  <div class="inner">
    <div class="row">
      <form enctype="multipart/form-data" id="" method="post" action="<?php echo site_url('PolaShiftSeksi/ImportPolaShift/DocumentProcess'); ?>" class="form-horizontal">
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
                  <a class="btn btn-default btn-lg" href="<?php echo site_url('PolaShiftSeksi/ImportPolaShift'); ?>">
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
                <div class="box-header with-border"></div>
                <div class="box-body">
                  <div class="panel-body">
                    <div class="row">
                      <div class="col-lg-6">
                        <div data-step="1" data-intro="Masukkan periode shift yang akan diimport" class="form-group">
                          <label for="txtTanggalCetak" class="col-lg-4 control-label">Periode Shift</label>
                          <div class="col-lg-8">
                            <input class="form-control importpola_periode" autocomplete="off" type="text" name="periodeshift" id="yangPentingtdkKosong" placeholder="Masukkan Periode" value="" required="" />
                          </div>
                        </div>
                        <div class="form-group" hidden="">
                          <label for="txtKodesieBaru" class="col-lg-4 control-label">Seksi</label>
                          <div class="col-lg-8">
                            <!-- required name="kodeseksi" -->
                            <select class="select2" id="ImportPola-DaftarSeksi" style="width: 100%">
                              <option value=""></option>
                            </select>
                          </div>
                        </div>
                        <div data-step="2" data-intro="Pilih berkas file shift yang berformat .xls/.xlsx" class="form-group">
                          <label for="lb_approval" class="control-label col-lg-4">Import Document</label>
                          <div class="col-lg-8">
                            <input style="" required="" type="file" name="importdocument" class="form-control" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel, .ods, .xls, .xlsx" />
                            <span style="color: red;">* file yang dapat di upload hanya file yang berformat .xls, .xlsx, .ods, dan .csv</span>
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="col-lg-12 text-right">
                            <button data-step="3" data-intro="Klik tombol untuk memproses jika sudah terisi dengan benar" type="submit" class="btn btn-primary">Process Document</button>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="col-md-12 text-right">
                          <button type="button" class="btn btn-primary" onclick="start_introjs()" style="background-color: #007bff; border-color: #007bff;">
                            <i class="fa fa-mouse-pointer"></i>
                            Petunjuk Penggunaan Aplikasi
                          </button>
                        </div>
                        <div class="form-group">
                          <div class="col-lg-12">
                            <?php if (isset($gakDueSh)) : ?>
                              <div class="callout callout-danger">
                                <i class="fa fa-ban"></i>
                                <label style="margin-left: 5px;">Gagal !</label>
                                <p>Data Pekerja yang di inputkan tidak memiliki Shift pada periode <?= $pr ?> :</p>
                              </div>
                            <?php endif ?>
                          </div>
                        </div>
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
  function start_introjs() {
    introJs().start()
  }
</script>