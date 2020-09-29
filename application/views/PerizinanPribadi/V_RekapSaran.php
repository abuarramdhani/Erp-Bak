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
                                        <!-- <div class="col-lg-12">
                                            <label class="col-lg-2">Jenis Rekap :</label>
                                            <div class="form-group col-lg-5">
                                                <input checked type="radio" name="PerSurat" class="RD_radioDinas" value="1" required>Rekap Per Surat<br>
                                                <input type="radio" name="PerSurat" class="RD_radioDinas" value="2" required>Rekap Per Pekerja
                                            </div>
                                        </div> -->
                                        <!-- <div class="col-lg-12" id="RPD_ID">
                                            <label for="id_rekap" class="col-lg-2">ID Izin :</label>
                                            <div class="form-group col-lg-5">
                                                <select name="id_rekap[]" class="form-control select select2 RPD_id_rekap" multiple>
                                                    <?php foreach ($list_izin as $key) : ?>
                                                        <option value="<?php echo $key['id'] ?>"><?php echo $key['id'] ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                                <p style="color: red;">*kosongkan ID Izin, untuk menampilkan semua data</p>
                                            </div>
                                        </div>
                                        <div class="col-lg-12" id="RPD_Noind">
                                            <label for="perNoind" class="col-lg-2">Nomor Induk :</label>
                                            <div class="form-group col-lg-5">
                                                <select name="perNoind[]" class="form-control select select2 RPD_perNoind" multiple>
                                                    <?php foreach ($list_noind as $key) : ?>
                                                        <option value="<?php echo $key['noind'] ?>"><?php echo $key['noind'] . ' - ' . $key['nama'] ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                                <p style="color: red;">*kosongkan Nomor Induk, untuk menampilkan semua data</p>
                                            </div>
                                        </div> -->
                                        <div class="col-lg-12 panel-footer">
                                            <div class="col-lg-12 text-center">
                                                <button class="btn btn-primary" id="RPP_Saran" value="Tidak" style="width: 80px;">Cari</button>&emsp;
                                                <button class="btn btn-warning" onclick="window.location.reload()" style="width: 80px;">Reset</button>&emsp;
                                                <button class="btn btn-success fa fa-file-excel-o" style="padding: 9px; width: 80px;" value="Tidak" id="izinRekapExcel">&emsp;Excel</button>&emsp;
                                                <button class="btn btn-danger fa fa-file-pdf-o" style="padding: 9px; width: 80px;" value="Tidak" id="izinRekapPDF">&emsp;PDF</button>
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