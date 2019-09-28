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
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('ManufacturingOperationUP2L/Absen'); ?>">
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
                                <form action="<?= base_url('ManufacturingOperationUP2L/Absen/save_update')?>" method="post">
                                    <input type="hidden" name="absId" value="<?= $show[0]['id_absensi'] ?>">
                                    <div class="col-lg-3"> </div>
                                    <div class="col-lg-6">
                                        <div class="form-group"> <br />
                                            <label for="absName" class="control-label">Nama</label>
                                            <select name="absName" id="ott_Name" class="form-control" required>
                                            <option selected value="<?php echo $show[0]['no_induk']. ' | ' .$show[0]['nama']?>"><?php echo $show[0]['no_induk']. ' | ' .$show[0]['nama']?></option>
                                                <?php
                                                foreach ($data_p as $key => $pekerja) { ?>
                                                    <option name="absName" value="<?= $pekerja?>"><?= $pekerja?></option>
                                                <?php } ?>
                                            </select>
                                        </div> <br />

                                        <div class="form-group">
                                            <label for="absTgl" class="control-label">Tanggal</label>
                                            <input type="text" name="absTgl" class="form-control time-form1 ajaxOnChange" placeholder="Tanggal" id="absTgl" value="<?= $show[0]['created_date']?>" required>
                                        </div> <br />
                                        <div class="form-group">
                                            <label for="absPrs" class="control-label">Presensi</label>
                                            <select name="absPrs" id="absPrs" class="form-control">
                                                <option selected value="<?= $show[0]['presensi'] ?>"><?= $show[0]['presensi'] ?></option>
                                                <option value="ABS">Absen</option>
                                                <option value="CT">Cuti</option>
                                                <option value="SK">SK</option>
                                            </select>
                                        </div> <br />
                                        <div class="form-group">
                                            <label for="absAls" class="control-label">Alasan</label><br />
                                            <textarea placeholder="Tuliskan alasan..." name="absAls" id="absAls" cols="80" rows="5" required><?= $show[0]['alasan'] ?></textarea>
                                        </div> <br />

                                    </div><br /> <br /><br />
                            </div><div class="col-lg-3"> </div>
                            <div class="box-footer text-right">
                                    <button type="submit" class="btn btn-success btn-lg"><i class="fa fa-save"></i></i>  Save</button>
                                    <a href="<?php echo site_url('ManufacturingOperationUP2L/Absen'); ?>" class="btn btn-danger btn-lg"><i class="fa fa-arrow-left"></i></i>  Back</a>
                            </div>
                                </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>