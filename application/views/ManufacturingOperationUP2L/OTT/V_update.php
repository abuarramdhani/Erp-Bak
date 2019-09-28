<?php
?>
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
                                Update
                            </div>
                            <div class="box-body">
                                <form action="<?= base_url('ManufacturingOperationUP2L/OTT/save_update')?>" method="post">
                                    <input type="hidden" name="ottId" value="<?= $show[0]['id'] ?>">
                                    <div class="col-lg-3"> </div>
                                    <div class="col-lg-6">
                                        <div class="form-group"> <br />
                                            <label for="ott_Name" class="control-label">Nama</label>
                                            <select name="ottName" id="ott_Name" class="form-control" required> 
                                                <option selected value="<?php echo $show[0]['nama']?>"><?php echo $show[0]['nama']?></option>
                                                <?php
                                                foreach ($data_p as $key => $pekerja) { ?>
                                                    <option name="ottName" value="<?= $pekerja?>"><?= $pekerja?></option>
                                                <?php } ?>
                                            </select>
                                        </div> <br />

                                        <div class="form-group">
                                            <label for="ottName" class="control-label">Tanggal</label>
                                            <input type="text" name="otttgl" class="form-control time-form1 ajaxOnChange" placeholder="Tanggal" id="ottTgl" value="<?= $show[0]['otttgl']?>" required>
                                        </div> <br />

                                        <div class="form-group">
                                            <label for="ottKode" class="control-label">Kode Cor</label>
                                            <div id="print_code_area">
                                                <input type="text" name="print_code" placeholder="--- Isi tanggal terlebih dahulu ---" id="print_code" value="<?= $show[0]['kode_cor'] ?>" class="form-control">
                                            </div>
                                        </div>
                                            
                                        <div class="form-group">
                                        <br />
                                                <select class="form-control slcShift" id="txtShift" name="txtShift" required>
                                                    <option selected value="<?= $show[0]['shift'] ?>"><?= $show[0]['shift'] ?></option>
                                                </select>
                                        </div> <br />

                                        <div class="form-group">
                                            <label for="ottNilai" class="control-label">Nilai OTT</label>
                                            <input type="text" class="form-control" name="ottNilai" id="ottNilai" value="<?= $show[0]['nil_ott'] ?>" />
                                        </div>

                                        <div class="form-group">
                                            <label for="ottKodeP" class="control-label">Kode Kelompok</label>
                                            <select class="form-control" id="ottKodeP" name="ottKodeP" required>
                                                <option name="ottKodeP" selected value="<?= $show[0]['kode'] ?>"><?= $show[0]['kode'] ?></option>
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
                                            </select>
                                            
                                        </div> <br />
                                        <!-- Tekan kode coy -->
                                        <div class="form-group">
                                            <label for="ottPekerjaan" class="control-label">Pekerjaan</label>
                                            <input type="text" name="ottPekerjaan" class="form-control" placeholder="Pekerjaan" id="ottPekerjaan" value="<?= $show[0]['pekerjaan']?>" required>
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