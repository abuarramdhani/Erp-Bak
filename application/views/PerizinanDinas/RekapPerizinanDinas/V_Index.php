<section class="content">
    <div class="inner" >
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-11">
                            <div class="text-right"><h1><b>Rekap Perizinan Dinas Perusahaan</b></h1></div>
                        </div>
                        <div class="col-lg-1">
                            <div class="text-right hidden-md hidden-sm hidden-xs">
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('PerizinanDinas/AtasanApproval/V_Index');?>">
                                    <i class="icon-wrench icon-2x"></i>
                                    <br/>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <br/>
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
                                               <input class="form-control periodeRekap"  autocomplete="off" type="text" name="periodeRekap" id="periodeRekap" placeholder="Masukkan Periode" value=""/>
                                               <p style="color: red;">*kosongkan kolom periode , untuk menampilkan semua data</p>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <label class="col-lg-2">Jenis Rekap :</label>
                                            <div class="form-group col-lg-5">
                                                <input type="radio" name="PerSurat" class="RD_radioDinas" value="1" required>Rekap Per Surat<br>
                                                <input type="radio" name="PerSurat" class="RD_radioDinas" value="2" required>Rekap Per Pekerja
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="col-lg-5 text-center">
                                                <button class="btn btn-primary" id="PD_Cari">Cari</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                             </div>
                        </div>
                    </div>
                    <div class="col-lg-12" id="areaRekapIzin">

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
