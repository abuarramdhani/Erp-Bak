<section class="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <h1><b><?=$Title ?></b></h1>    
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border text-left">
                                <label>Edit Kronologis Kecelakaan Kerja</label>
                            </div>
                            <form method="post" action="<?= base_url('MasterPekerja/KronologisKecelakaanKerja/update') ?>">
                                <div class="box-body">
                                    <div class="col-md-2">
                                        <label>Pekerja</label>
                                    </div>
                                    <div class="col-md-5">
                                        <select class="form-control" name="pkj" id="mpk_slckkkpkj" required="">
                                            <option value="<?= $kr['pekerja'] ?>"><?= $kr['pekerja'].' - '.$kr['nama'] ?></option>
                                        </select>
                                    </div>
                                    <div class="col-md-12" style="margin-top: 10px;"> </div>
                                    <div class="col-md-2">
                                        <label>No. KPJ</label>
                                    </div>
                                    <div class="col-md-5">
                                        <input class="form-control" name="no_kpj" id="mpk_innokpj" value="<?= $kr['no_kpj'] ?>" placeholder="Masukan No. KPJ"/>
                                    </div>
                                    <div class="col-md-12" style="margin-top: 10px;"> </div>
                                    <div class="col-md-2">
                                        <label>Tanggal</label>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="bootstrap-timepicker">
                                                    <div class="input-group">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-calendar"></i>
                                                        </div>
                                                        <input class="form-control MasterPekerja-daterangepickersingledate" name="tanggal" autocomplete="off" required="" value="<?= $kr['tanggal'] ?>" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="bootstrap-timepicker">
                                                    <div class="input-group">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-clock-o"></i>
                                                        </div>
                                                        <input class="form-control spl-time-mask" name="jam" autocomplete="off" placeholder="00:00:00 WIB" required=""  value="<?= $kr['jam'] ?>" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>                              
                                    <div class="col-md-12" style="margin-top: 10px;"> </div>
                                    <div class="col-md-2">
                                        <label>Tempat Kecelakaan</label>
                                    </div>
                                    <div class="col-md-5">
                                        <input class="form-control" name="tempat" required="" value="<?= $kr['tempat'] ?>" placeholder="Masukan Tempat Kecelakaan"/>
                                    </div>
                                    <div class="col-md-12" style="margin-top: 10px;"> </div>
                                    <div class="col-md-2">
                                        <label>Uraian Kejadian</label>
                                    </div>
                                    <div class="col-md-5">
                                        <input class="form-control" name="uraian_kejadian" required="" placeholder="Masukan Uraian Kejadian" value="<?= $kr['uraian_kejadian'] ?>" />
                                    </div>
                                    <div class="col-md-12" style="margin-top: 10px;"> </div>
                                    <div class="col-md-2">
                                        <label>Uraian</label>
                                    </div>
                                    <div class="col-md-12">
                                        <textarea class="form-control MasterPekerja-Surat-txaPreview" name="uraian" style="height: 200px;" placeholder="Masukan Uraian Kejadian" required=""><?= $kr['uraian'] ?></textarea>
                                    </div>
                                    <div class="col-md-12" style="margin-top: 30px;"> </div>
                                    <div class="col-md-2">
                                        <label>Wakil Perusahaan</label>
                                    </div>
                                    <div class="col-md-5">
                                        <select class="form-control mpk_slcclear" name="perusahaan" required="">
                                            <option <?= ($kr['wakil_perusahaan'] == 'DAMARIS OSCAR PARMASARI') ? 'selected':'' ?> >DAMARIS OSCAR PARMASARI</option>
                                            <option <?= ($kr['wakil_perusahaan'] == 'BAMBANG YUDHOSUSENO') ? 'selected':'' ?> >BAMBANG YUDHOSUSENO</option>
                                            <option <?= ($kr['wakil_perusahaan'] == 'TENGKU DIAN SYAHRUL RIZA SH') ? 'selected':'' ?> >TENGKU DIAN SYAHRUL RIZA SH</option>
                                            <option <?= ($kr['wakil_perusahaan'] == 'RENY SULISTIYANINGTYAS') ? 'selected':'' ?> >RENY SULISTIYANINGTYAS</option>
                                        </select>
                                    </div>
                                    <div class="col-md-12" style="margin-top: 10px;"> </div>
                                    <div class="col-md-2">
                                        <label>Saksi 1</label>
                                    </div>
                                    <div class="col-md-5">
                                        <select class="form-control mpk_slcclear" name="saksi_1" required="">
                                            <option <?= ($kr['saksi_1'] == 'WAHYU YULISTYARA HP') ? 'selected':'' ?> >WAHYU YULISTYARA HP</option>
                                            <option <?= ($kr['saksi_1'] == 'ALIFAH FITRIYANI</option>') ? 'selected':'' ?> >ALIFAH FITRIYANI</option>
                                            <option <?= ($kr['saksi_1'] == 'TANTRI SUMARYANI') ? 'selected':'' ?> >TANTRI SUMARYANI</option>
                                            <option <?= ($kr['saksi_1'] == 'SUHARTINI') ? 'selected':'' ?> >SUHARTINI</option>
                                        </select>
                                    </div>
                                    <div class="col-md-12" style="margin-top: 10px;"> </div>
                                    <div class="col-md-2">
                                        <label>Saksi 2</label>
                                    </div>
                                    <div class="col-md-5">
                                        <select class="form-control mpk_slcclear" name="saksi_2">
                                            <option <?= ($kr['saksi_2'] == 'ALIFAH FITRIYANI</option>') ? 'selected':'' ?> >ALIFAH FITRIYANI</option>
                                            <option <?= ($kr['saksi_2'] == 'WAHYU YULISTYARA HP') ? 'selected':'' ?> >WAHYU YULISTYARA HP</option>
                                            <option <?= ($kr['saksi_2'] == 'TANTRI SUMARYANI') ? 'selected':'' ?> >TANTRI SUMARYANI</option>
                                            <option <?= ($kr['saksi_2'] == 'SUHARTINI') ? 'selected':'' ?> >SUHARTINI</option>
                                        </select>
                                    </div>
                                    <div class="col-md-12 text-center" style="margin-top: 20px">
                                        <a href="<?= base_url('MasterPekerja/KronologisKecelakaanKerja') ?>" class="btn btn-warning"> Kembali </a>
                                        <button class="btn btn-success" type="submit" id="mpk_btnsbmtkkk" value="<?= $kr['id'] ?>" name="id">
                                            Simpan
                                        </button>
                                    </div>
                                    <div class="col-md-12 text-center" style="margin-top: 10px;">
                                        <label style="color: red">*Pastikan Data sudah Sesuai sebelum klik Simpan!</label>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript">
    var warn = 1;
    $('#mpk_btnsbmtkkk').click(function(){
        warn = 0;
    });
    window.onbeforeunload = function() {
        if (warn) {
            return "Data will be lost if you leave the page, are you sure?";
        }
  };
</script>