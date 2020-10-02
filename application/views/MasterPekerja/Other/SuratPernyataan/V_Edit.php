<style type="text/css">
    .mt{
        margin-top: 5px;
    }
</style>
<section class="content">
    <div class="inner" >
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-3">
                        </div>
                        <div class="col-lg-3"></div>
                        <div class="col-lg-5">
                            <div class="text-right"><h1><b><?=$Title?></b></h1></div>
                        </div>
                        <div class="col-lg-1">
                        </div>
                    </div>
                </div>
                <br/>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border">
                            </div>
                            <div class="box-body">
                                <form method="post" action="<?= base_url('MasterPekerja/surat_pernyataan/update_pernyataan') ?>" id="mpkfrmsubper">
                                    <div class="col-md-6">
                                        <div class="col-md-4 mt">
                                            <label>Pekerja</label>
                                        </div>
                                        <div class="col-md-8">
                                            <select class="form-control" id="mpkpkjsuper" name="pekerja" required="">
                                                <option selected="" value="<?=$l['pekerja']?>"><?=$l['pekerja'].' - '.$l['nama_pekerja']?></option>
                                            </select>
                                        </div>
                                        <br><br>
                                        <div class="col-md-4 mt">
                                            <label>Tanggal JKK</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input class="form-control mpktgljkk" name="tgl_jkk" value="<?= $l['tgl_jkk'] ?>" placeholder="Pilih Tanggal"/>
                                        </div>
                                        <br><br>
                                        <div class="col-md-4 mt">
                                            <label>Nama RS / Kinik</label>
                                        </div>
                                        <div class="col-md-8">
                                            <select class="form-control" id="mpklistrs" name="klinik" required="">
                                                <option selected="" value="<?= $l['rs_klinik_id'] ?>"><?= $listRs[$l['rs_klinik_id']] ?></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="col-md-4 mt">
                                            <label>Pihak Perusahaan</label>
                                        </div>
                                        <div class="col-md-8">
                                            <select class="form-control" id="mpklhubkrd" name="hubker" required="">
                                                <option selected="" value="<?=$l['hubker']?>"><?=$l['hubker'].' - '.$l['nama_hubker']?></option>
                                            </select>
                                        </div>
                                        <br><br>
                                        <div class="col-md-4 mt">
                                            <label>Nomor HP</label>
                                        </div>
                                        <div class="col-md-8">
                                            <select class="form-control" multiple="" id="mpslcnohubkrd" name="nohp[]" required="">
                                                <?php foreach (explode(',', $l['no_hp']) as $key): ?>
                                                    <option selected="" value="<?=$key?>"><?=$key?></option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                        <br><br>
                                        <div class="col-md-4 mt">
                                            <label>Tanggal Pernyataan</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input class="form-control mpktgljkk" name="tgl_pernyataan" required=""  value="<?= $l['tgl_pernyataan'] ?>" />
                                        </div>
                                        <br><br>
                                        <div class="col-md-4 mt">
                                            <label>Tanggal Cetak</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input class="form-control mpktgljkk" name="tgl_cetak" required="" value="<?= $l['tgl_cetak'] ?>" />
                                        </div>
                                        <br><br>
                                    </div>
                                    <div class="col-md-12 text-center" style="margin-top: 20px;">
                                        <label style="color: red;">*Pastikan Data Sudah Sesuai Sebelum Klik Simpan</label>
                                    </div>
                                    <div class="col-md-12 text-center" >
                                        <a href="<?= base_url('MasterPekerja/surat_pernyataan') ?>" class="btn btn-warning">
                                            Kembali
                                        </a>
                                        <button class="btn btn-info" type="button" id="btnprvsuper">
                                            Preview
                                        </button>
                                        <button class="btn btn-success" type="submit" name="id" value="<?= $_GET['id'] ?>">
                                            Update
                                        </button>
                                    </div>
                                </form>
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