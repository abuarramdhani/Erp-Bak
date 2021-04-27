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
                        <div class="col-lg-1">
                            <div class="text-right hidden-md hidden-sm hidden-xs">
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('ManufacturingOperationUP2L/OTT'); ?>">
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
                            <div class="box-header with-border">
                                Create
                            </div>
                            <div class="box-body">
                                <form autocomplete="off" action="<?= base_url('ManufacturingOperationUP2L/OTT/save_create')?>" method="post">
                                    <div class="col-lg-3"> </div>
                                    <div class="col-lg-6">
                                        <div class="panel panel-default">
                                            <div class="panel-heading"><b>Nama</b></div>
                                            <div class="panel-body" id="container-emplott">
                                                <div class="form-group"> <br />
                                                    <div class="col-lg-10" id="tmpNama">
                                                        <select name="ottName[]" class="form-control ott_Name" required>
                                                            <option value="">Pilih Pekerja</option>
                                                            <?php
                                                            foreach ($data_p as $key => $pekerja) { ?>
                                                                <option name="ottName" value="<?= $pekerja?>"><?= $pekerja?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                    <button type="button" class="btn btn-info ottPlusBtn"><i class="fa fa-plus"></i></button>
                                                    <button type="button" class="btn btn-danger ottTimesBtn" style="display:none"><i class="fa fa-times"></i></button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="ottName" class="control-label">Tanggal</label>
                                            <input type="text" name="ottTgl" class="form-control time-form1 ajaxOnChange" placeholder="Tanggal" id="ottTgl" required>
                                        </div> <br />

                                        <div class="form-group">
                                            <label for="ottKode" class="control-label">Kode Cor</label>
                                            <div id="print_code_area">
                                                        <small>-- Isi tanggal terlebih dahulu
                                                            --</small>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                        <br />
                                            <select class="form-control slcShift" id="txtShift" name="txtShift" required>
                                            </select>
                                        </div> <br />

                                        <div class="form-group">
                                        <label for="ottNilai" class="control-label">Nilai OTT</label>
                                            <input type="text" class="form-control" name="ottNilai" id="ottNilai">
                                        </div>

                                        <div class="form-group">
                                            <label for="ottKodeP" class="control-label">Kode Kelompok</label>
                                            <select class="form-control" id="ottKodeP" name="ottKodeP" required>
                                                <option name="ottKodeP" selected value="">--- Kode Kelompok ---</option>
                                                <option name="ottKodeP" value="A">A</option>
                                                <option name="ottKodeP" value="B">B</option>
                                                <option name="ottKodeP" value="C">C</option>
                                                <option name="ottKodeP" value="D">D</option>
                                                <option name="ottKodeP" value="E">E</option>
                                                <option name="ottKodeP" value="F">F</option>
                                                <option name="ottKodeP" value="G">G</option>
                                                <option name="ottKodeP" value="H">H</option>
                                                <option name="ottKodeP" value="I">I</option>
                                                <option name="ottKodeP" value="J">J</option>
                                                <option name="ottKodeP" value="K">K</option>
                                                <option name="ottKodeP" value="L">L</option>
                                                <option name="ottKodeP" value="M">M</option>
                                                <option name="ottKodeP" value="N">N</option>
                                            </select>
                                        </div> <br />

                                        <div class="form-group">
                                            <label for="ottPekerjaan" class="control-label">Pekerjaan</label>
                                            <input type="text" name="ottPekerjaan" class="form-control" placeholder="Pekerjaan" id="ottPekerjaan" required>
                                        </div>
                                    </div> <br /> <br /><br />
                            </div><div class="col-lg-3"> </div>
                            <div class="box-footer text-right">
                                    <button type="submit" class="btn btn-success btn-lg"><i class="fa fa-save"></i></i>  Save</button>
                                    <a href="<?php echo site_url('ManufacturingOperationUP2L/OTT'); ?>" class="btn btn-danger btn-lg"><i class="fa fa-arrow-left"></i></i>  Back</a>
                            </div>
                                </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
