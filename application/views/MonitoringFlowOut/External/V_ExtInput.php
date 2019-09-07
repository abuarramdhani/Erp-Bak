<style>
    input::-webkit-input-placeholder {
        color: #999;
    }

    input:focus::-webkit-input-placeholder {
        color: teal;
    }

    input:-moz-placeholder {
        color: #999;
    }

    input:focus:-moz-placeholder {
        color: teal;
    }

    input::-moz-placeholder {
        color: #999;
    }

    input:focus::-moz-placeholder {
        color: teal;
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
                                <h1>
                                    <b>
                                        <?= $Title ?>
                                    </b>
                                </h1>
                            </div>
                        </div>
                        <div class="col-lg-1 ">
                            <div class="text-right hidden-md hidden-sm hidden-xs">
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('MonitoringFlowOut/ExternalInput'); ?>">
                                    <i class="icon-wrench icon-2x">
                                    </i>
                                    <span>
                                        <br />
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <br />
                <!-- Input Form -->
                <div class="row">
                    <form enctype="multipart/form-data" autocomplete="off" action="<?php echo site_url('MonitoringFlowOut/ExternalInput/create'); ?>" method="POST">
                        <div class="col-lg-12">
                            <div class="box box-primary box-solid">
                                <div class="box-header with-border">
                                    <b>External Input</b>
                                </div>
                                <div class="box-body">
                                    <div class="panel-body">
                                        <!-- Input Bagian Kiri -->
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Tanggal</label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-calendar"></i>
                                                    </div>
                                                    <input type="text" class="form-control selectTgl" name="txtTanggal" required="">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Seksi Penemu</label>
                                                <select style="width:100%;" name="txtSeksiPenemu" id="mfo_select" class="form-control" required="">
                                                    <option value="" selected>Select your option</option>
                                                    <?php foreach ($seksi as $pil) { ?>
                                                        <option value="<?php echo $pil['seksi'] ?>">
                                                            <?php echo $pil['seksi'] ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Kode Komponen</label>
                                                <select type="text" class="form-control codecompMFO2" id="codecompMFO2" placeholder="Masukkan Kode Komponen" name="txtComponentCode" required="">
                                                    <!-- <option></option> -->
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Nama Komponen</label>
                                                <input type="text" class="form-control" name="txtComponentName" id="ComponentName" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label>Tipe</label> <br>
                                                <input type="text" class="form-control" name="txtType" id="Type" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label>Jumlah</label>
                                                <input type="number" class="form-control numeric" name="txtJumlah" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" placeholder="Masukkan Jumlah" required="">
                                            </div>
                                            <div class="form-group">
                                                <label>Kronologi Permasalahan</label>
                                                <textarea type="text" class="form-control" placeholder="Kronologi Permasalahan" style="width: 450px; height: 130px;" name="txtKronologiPerm" required=""></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label>Possible Failure</label>
                                                <select style="width:100%;" name="txtPoss" id="mfo_select3" class="form-control" required="">
                                                    <option name="" value="" selected>Select your choice</option>
                                                    <?php foreach ($fail as $faila) { ?>
                                                        <option value="<?= $faila['possible_failure'] ?>">
                                                            <?= $faila['possible_failure'] ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Input Bagian Kanan -->
                                        <div class="col-lg-6">
                                            <div class="form-check form-check-inline">
                                                <label>Status Flow Out QC</label><br />
                                                <select name="txtQC" class="form-control" id="txtQC" required="">
                                                    <option value="" selected>Select your choice</option>
                                                    <option value="True">True</option>
                                                    <option value="False">False</option>
                                                </select>
                                            </div><br />
                                            <div class="form-group">
                                                <label>Label</label>
                                                <select style="width:100%;" class="form-control" name="txtMeth" required="">
                                                    <option value="" selected>Select your option</option>
                                                    <option name="txtMeth" value="CMP">CMP</option>
                                                    <option name="txtMeth" value="Sampel">Sampel</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Seksi Penanggungjawab</label>
                                                <select name="txtSeksiPenanggungJawab[]" style="width:100%;" id="mfo_selectPJ" multiple="multiple" class="form-control" required="">
                                                    <?php foreach ($seksi as $pil) { ?>
                                                        <option value="<?php echo $pil['seksi'] ?>">
                                                            <?php echo $pil['seksi'] ?></option>
                                                    <?php  } ?>
                                                </select>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Vendor</label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-font"></i>
                                                    </div>
                                                    <input type="text" class="form-control" placeholder="Vendor" name="txtVendor">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Upload QR</label>
                                                <input type="file" class="form-control-file" placeholder="Upload QR" name="upQr" accept=".pdf" required="">
                                            </div>
                                            <div class="form-group">
                                                <label>Tanggal Distribusi</label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-calendar"></i>
                                                    </div>
                                                    <input type="text" class="form-control selectTgl" name="tglDistr" required="">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Upload CAR</label>
                                                <input type="file" class="form-control-file" placeholder="Upload CAR" class="upCar" name="upCar" accept=".pdf">
                                            </div>
                                            <div class="form-group">
                                                <label>Tanggal Kirim</label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-calendar"></i>
                                                    </div>
                                                    <input type="text" class="form-control selectTgl" name="tglKirim">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Due Date Action CAR</label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-calendar"></i>
                                                    </div>
                                                    <input type="text" class="form-control selectTgl" id="disDDAC" name="txtDueDateActCar" disabled>
                                                </div>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <label>Status</label><br />
                                                <select class="form-control" name="txtStatus" id="txtStatus">
                                                    <option value="" selected>Select your choice</option>
                                                    <option value="Open">Open</option>
                                                    <option value="Hold">Hold</option>
                                                    <option value="Close">Close</option>
                                                </select>
                                            </div><br /><br />
                                        </div>

                                        <!-- Quality Inspection -->
                                        <input type="hidden" name="hdnNomorUrut[]" value="1">
                                        <div class="col-lg-12">
                                            <div class="box box-primary box-solid">
                                                <div class="box-header with-border">
                                                    <div class="col-lg-11" style="vertical-align:middle;">
                                                        <b style="vertical-align:middle;">Quality Inspection</b>
                                                    </div>
                                                    <div class="col-lg-1">
                                                        <a style="text-align:right;" href="#qw" id="qw" class="btn btn-info add_qi" onclick="newInput()"><i style="text-align:right;" class="fa fa-plus"></i></a>
                                                    </div>
                                                </div>
                                                <div class="panel-body">
                                                    <div id="quality-inspection1" class="parentMFO">
                                                        <div class="col-lg-12 boxInput">
                                                            <div class="form-group">
                                                                <label>Verifikasi </label><br />
                                                                <div class="row">
                                                                    <div class="col-lg-5">
                                                                        <label>Due Date</label>
                                                                        <div class="input-group">
                                                                            <div class="input-group-addon">
                                                                                <i class="fa fa-calendar"></i>
                                                                            </div>
                                                                            <input type="text" class="form-control selectTgl" name="txtVerDueDate[]">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-5">
                                                                        <label>Realisasi</label>
                                                                        <div class="input-group">
                                                                            <div class="input-group-addon">
                                                                                <i class="fa fa-calendar"></i>
                                                                            </div>
                                                                            <input type="text" class="form-control selectTgl" name="txtRealisasi[]">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-2">
                                                                        <a href="#qw" id="qw" class="btn btn-danger remove_qi" style="display:none;" onclick="deleteInput($(this))">
                                                                            <i class="fa fa-close"></i></a>
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-lg-5">
                                                                        <label>PIC</label>
                                                                        <div class="input-group">
                                                                            <div class="input-group-addon">
                                                                                <i class="fa fa-font"></i>
                                                                            </div>
                                                                            <input type="text" class="form-control" placeholder="PIC" name="txtPic[]">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-5">
                                                                        <label>Catatan</label>
                                                                        <textarea class="form-control" placeholder="Catatan" name="txtCat[]"></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-footer">
                                        <div class="row text-right" style="margin:1px;">
                                            <a href="<?php echo base_url('MonitoringFlowOut'); ?>/ExternalView" class="btn btn-danger btn-lg">Back</a>
                                            &nbsp;&nbsp;
                                            <button type="submit" class="btn btn-primary btn-lg">Save
                                                Data</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>