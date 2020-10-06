<style>
    .dataTables_filter {
        float: right;
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
                                <h1><b>Rekap Perizinan Perseksi</b></h1>
                            </div>
                        </div>
                        <div class="col-lg-1">
                            <div class="text-right hidden-md hidden-sm hidden-xs">
                                <a class="btn btn-default btn-lg" href="<?php echo base_url('IzinKeluarPribadi'); ?>">
                                    <i class="icon-wrench icon-2x"></i>
                                    <br />
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
                                        <div class="col-lg-12 form-group">
                                            <label for="txtKodesie" class="col-lg-4 control-label text-right">Kodesie :</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="txtKodesie" class="form-control" value="<?= $data[0]['kodesie'] ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 form-group">
                                            <label for="txtSeksi" class="col-lg-4 control-label text-right">Kodesie :</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="txtSeksi" class="form-control" value="<?= $data[0]['seksi'] ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 form-group">
                                            <label for="txtTanggalCetak" class="col-lg-4 control-label text-right">Periode Rekap :</label>
                                            <div class="col-lg-4">
                                                <input class="form-control periodeRekap" autocomplete="off" type="text" name="periodeRekap" id="periodeRekap" placeholder="Masukkan Periode" value="" />
                                                <p style="color: red;">*kosongkan kolom periode , untuk menampilkan semua data</p>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="col-lg-12 text-center">
                                                <button class="btn btn-primary" id="RPP_Cari" value="Ya" style="width: 80px;">Cari</button>&emsp;
                                                <button class="btn btn-warning" onclick="window.location.reload()" style="width: 80px;">Reset</button>&emsp;
                                                <button class="btn btn-success fa fa-file-excel-o" style="padding: 9px; width: 80px;" value="Ya" id="izinRekapExcel">&emsp;Excel</button>&emsp;
                                                <button class="btn btn-danger fa fa-file-pdf-o" style="padding: 9px; width: 80px;" value="Ya" id="izinRekapPDF">&emsp;PDF</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12" id="areaRekapIKP">

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>