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
                                <h1><b><?= $Title; ?></b></h1>
                            </div>
                        </div>
                        <div class="col-lg-1">
                            <div class="text-right hidden-md hidden-sm hidden-xs">
                                <a class="btn btn-default btn-lg" href="<?php echo base_url('PerizinanPribadi/RekapKritikan'); ?>">
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
                                        <div class="col-lg-12">
                                            <label for="txtTanggalCetak" class="col-lg-2 control-label text-left">Periode Rekap:</label>
                                            <div class="col-lg-5">
                                                <input class="form-control periodeRekap" autocomplete="off" type="text" name="periodeRekap" id="periodeRekap" placeholder="Masukkan Periode" value="" />
                                                <p style="color: red;">*kosongkan kolom periode , untuk menampilkan semua data</p>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 panel-footer">
                                            <div class="col-lg-12 text-center">
                                                <button class="btn btn-primary" id="RPP_Saran" style="width: 80px;">Cari</button>&emsp;
                                                <button class="btn btn-warning" onclick="window.location.reload()" style="width: 80px;">Reset</button>&emsp;
                                                <button class="btn btn-success fa fa-file-excel-o" style="padding: 9px; width: 80px;" id="SaranRekapExcel">&emsp;Excel</button>&emsp;
                                                <button class="btn btn-danger fa fa-file-pdf-o" style="padding: 9px; width: 80px;" id="SaranRekapPDF">&emsp;PDF</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12" id="tempelSaran"></div>
                </div>
            </div>
        </div>
    </div>
</section>