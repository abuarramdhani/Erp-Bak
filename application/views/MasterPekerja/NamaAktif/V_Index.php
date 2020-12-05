<section class="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-3">
                        </div>
                        <div class="col-lg-3"></div>
                        <div class="col-lg-5">
                            <div class="text-right">
                            </div>
                        </div>
                        <div class="col-lg-1">
                        </div>
                    </div>
                </div>
                <br />

                <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border">
                                <h1 style="text-align:center">DAFTAR NAMA AKTIF</h1>
                            </div>

                            <!-- main content 1-->
                            <div class="bg-light box-body">
                                <div class="row ">


                                    <!-- input tanggal -->
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Tanggal :</label>
                                            <div class="input-group ">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                <input type="text" class="form-control pull-right" id="MPK_Datepicker">
                                            </div>
                                        </div>
                                    </div>


                                    <!-- radio button -->
                                    <div class="col-sm-4 text-right">
                                        <label class="radio-inline control-label"><input value="seksi" type="radio" name="optradio" checked> Seksi</label>
                                        <label class="radio-inline"><input value="unit" type="radio" name="optradio"> Unit</label>
                                        <label class="radio-inline"><input value="dept" type="radio" name="optradio"> Departemen</label>
                                    </div>

                                    <!-- Detail -->
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <select class="form-control" id="MPK_IsiRadio">
                                            </select>
                                            <div class="small text-danger"> *Kosongi untuk pilih semua kategori</div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Main Content 2 -->
                                <div class="row">
                                    <!-- Input Kode Induk -->
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Kode Induk :</label>
                                            <select class="form-control pull-right" id="MPK_NoIndukAktif" multiple>
                                                <?php foreach ($NamaAktif as $key) { ?>
                                                    <option value="<?= $key['fs_noind'] ?>"><?= $key['fs_noind'] ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                            <div class="small text-danger"> *Kosongi untuk pilih semua kode</div>
                                        </div>
                                    </div>

                                    <!-- Input Lokasi -->
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Lokasi Kerja :</label>
                                            <select class="form-control" id="MPK_LokasiKerjaAktif">
                                                <option value="">Semua Lokasi</option>
                                                <?php foreach ($LokasiKerja as $key) { ?>
                                                    <option value="<?= $key['id_'] ?>"> <?= $key['id_'], ' ', $key['lokasi_kerja'] ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <br>

                                    <!-- Button Action -->
                                    <div class="col-sm-4">
                                        <button type="button" class="btn btn-primary" id="MPK_TampilAktif">TAMPIL DATA</button>

                                    </div>
                                </div>
                                <div class="box-body">
                                </div>

                                <div class="col-md-12" id="MPK_Tabledata">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
</section>