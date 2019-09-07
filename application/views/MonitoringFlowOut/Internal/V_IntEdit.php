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
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('MonitoringFlowOut/InternalView'); ?>">
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
                    <form enctype="multipart/form-data" autocomplete="off" action="<?php echo site_url('MonitoringFlowOut/InternalView/update/') . '/' . $id; ?>" method="POST">
                        <?php
                        $tglbaru = date('d-m-Y', strtotime($getEdit[0]['tanggal']));
                        $duedate = date('d-m-Y', strtotime($getEdit[0]['due_date']));
                        $tgldistr = date('d-m-Y', strtotime($getEdit[0]['tgl_distr']));
                        $tglkirim = date('d-m-Y', strtotime($getEdit[0]['tgl_kirim']));
                        ?>
                        <div class="col-lg-12">
                            <div class="box box-primary box-solid">
                                <div class="box-header with-border">
                                    <b>Internal Edit</b>
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
                                                    <input type="text" class="form-control selectTgl" name="txtTanggal" value="<?= $tglbaru ?>">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Seksi Penemu</label>
                                                <select style="width:100%;" id="mfo_select" name="txtSeksiPenemu" class="form-control">
                                                    <option selected value="<?= $getEdit[0]['seksi_penemu'] ?>">
                                                        <?= $getEdit[0]['seksi_penemu'] ?></option>
                                                    <?php foreach ($seksi as $pil) { ?>
                                                        <option value="<?= $pil['seksi'] ?>"><?= $pil['seksi'] ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Kode Komponen</label>
                                                <select type="text" class="form-control codecompMFO" id="codecompMFO" placeholder="Masukkan Kode Komponen" name="txtComponentCode">
                                                    <option checked value="<?= $getEdit[0]['component_code_int'] ?>">
                                                        <?= $getEdit[0]['component_code_int'] ?></option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Nama Komponen</label>
                                                <input type="text" class="form-control" name="txtComponentName" id="ComponentName" value="<?= $getEdit[0]['component_name'] ?>" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label>Tipe</label> <br>
                                                <input type="text" class="form-control" name="txtType" id="Type" value="<?= $getEdit[0]['type'] ?>" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label>Jumlah</label>
                                                <input type="number" class="form-control numeric" name="txtJumlah" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" placeholder="Masukkan Jumlah" value="<?= $getEdit[0]['jumlah'] ?>">
                                            </div>
                                            <div class="form-group">
                                                <label>Kronologi Permasalahan</label>
                                                <textarea type="text" class="form-control" style="width: 450px; height: 130px;" placeholder="Kronologi Permasalahan" name="txtKronologiPerm" value="<?= $getEdit[0]['kronologi_p'] ?>"><?= $getEdit[0]['kronologi_p'] ?></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label>Possible Failure</label>
                                                <select style="width:100%;" id="mfo_select3" name="txtPoss" class="form-control">
                                                    <option selected value="<?= $getEdit[0]['possible_fail'] ?>">
                                                        <?= $getEdit[0]['possible_fail'] ?></option>
                                                    <?php foreach ($fail as $faila) { ?>
                                                        <option selected value="<?= $faila['possible_failure'] ?>">
                                                            <?= $faila['possible_failure'] ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div><br />
                                        </div>
                                        <!-- Input Bagian Kanan -->
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Status Flow Out QC</label><br />
                                                <select name="txtQC" class="form-control" id="txtQC">
                                                    <option selected value="<?= $getEdit[0]['status_fo'] ?>">
                                                        <?= $getEdit[0]['status_fo'] ?></option>
                                                    <option value="True">True</option>
                                                    <option value="False">False</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Label</label>
                                                <select style="width:100%;" class="form-control" name="txtMeth">
                                                    <option selected value="<?= $getEdit[0]['metode'] ?>">
                                                        <?= $getEdit[0]['metode'] ?></option>
                                                    <option name="txtMeth" value="CMP">CMP</option>
                                                    <option name="txtMeth" value="Sampel">Sampel</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Seksi Penanggungjawab</label>
                                                <select name="txtSeksiPenanggungJawab[]" style="width:100%;" id="mfo_selectPJ" multiple="multiple" class="form-control">
                                                        <?php $txtSeksiPenanggungJawab = explode(",", $getEdit[0]['seksi_penanggungjawab']);
                                                        foreach ($txtSeksiPenanggungJawab as $key => $value) { ?>
                                                            <option selected value="<?= $value?>"> <?= $value?> </option>
                                                        <?php } ?>
                                                        <?php foreach ($seksi as $pil) { ?>
                                                            <option value="<?= $pil['seksi'] ?>"><?= $pil['seksi'] ?></option>
                                                        <?php } ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Upload QR</label><br />
                                                <input type="file" class="form-control-file" placeholder="Upload QR" name="upQr" style="float:left;" accept=".pdf">
                                                <input type="text" style="float:left; background:#fff; border-color:transparent;" name="fileLamaQr" value="<?php echo $getEdit[0]['upload_qr'] ?>" placeholder="<?= $getEdit[0]['upload_qr'] ?>" readonly="">
                                            </div><br />
                                            <div class="form-check form-check-inline">
                                                <label>Tanggal Distribusi</label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-calendar"></i>
                                                    </div>
                                                    <input type="text" class="form-control selectTgl" name="tglDistr" value="<?= $tgldistr ?>">
                                                </div>
                                            </div><br />
                                            <div class="form-group">
                                                <label>Upload CAR</label><br />
                                                <input type="file" class="form-control-file" placeholder="Upload CAR" name="upCar" class="upCarEd" accept=".pdf" style="float:left;">
                                                <input type="text" style="float:left; background:#fff; border-color:transparent;" name="fileLamaCar" class="fileLamaCar" value="<?php echo $getEdit[0]['upload_car'] ?>" placeholder="<?= $getEdit[0]['upload_car'] ?>" readonly="">
                                            </div><br />
                                            <div class="form-check form-check-inline">
                                                <label>Tanggal Kirim</label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-calendar"></i>
                                                    </div>
                                                    <input type="text" class="form-control selectTgl" name="tglKirim" value="<?= $tglkirim ?>">
                                                </div>
                                            </div><br />
                                            <div class="form-group">
                                                <label>Due Date Action CAR</label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-calendar"></i>
                                                    </div>
                                                    <input type="text" class="form-control selectTgl" id="disDDACEd" name="txtDueDateActCar" value="<?= $duedate ?>" disabled>
                                                </div>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <label>Status</label><br />
                                                <select class="form-control" name="txtStatus" id="txtStatus">
                                                    <option selected value="<?= $getEdit[0]['status'] ?>">
                                                        <?= $getEdit[0]['status'] ?></option>
                                                    <option value="Open">Open</option>
                                                    <option value="Hold">Hold</option>
                                                    <option value="Close">Close</option>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Quality Inspection -->
                                        <div class="col-lg-12">
                                            <div class="box box-primary box-solid">
                                                <div class="box-header with-border">
                                                    <div class="col-lg-11" style="vertical-align:middle;">
                                                        <b style="vertical-align:middle;">Quality Inspection</b>
                                                    </div>
                                                    <div class="col-lg-1">
                                                        <a style="text-align:right;" href="#qw" id="qw" class="btn btn-info add_qi" onclick="newInputEdit()"><i style="text-align:right;" class="fa fa-plus"></i></a>
                                                    </div>
                                                </div>
                                                <div class="panel-body">
                                                    <div id="quality-inspection1" class="parentMFO">
                                                        <?php foreach ($getEdIns as $gE) {
                                                            $due_dateQi = date('d-m-Y', strtotime($gE['d_date']));
                                                            $realQi = date('d-m-Y', strtotime($gE['realisasi']));
                                                            ?>
                                                            <div class="col-lg-12 boxInput">
                                                                <div class="form-group">
                                                                    <label>Verifikasi </label><br />
                                                                    <div class="row">
                                                                        <div class="col-lg-5">
                                                                            <label>Due Date</label>
                                                                            <input type="hidden" name="txtId[]" value="<?php echo $gE['id'] ?>">
                                                                            <input type="hidden" name="hdnNomorUrut[]" value="1">
                                                                            <div class="input-group">
                                                                                <div class="input-group-addon">
                                                                                    <i class="fa fa-calendar"></i>
                                                                                </div>
                                                                                <input type="text" class="form-control selectTgl" name="txtVerDueDate[]" value="<?= $due_dateQi ?>">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-5">
                                                                            <label>Realisasi</label>
                                                                            <div class="input-group">
                                                                                <div class="input-group-addon">
                                                                                    <i class="fa fa-calendar"></i>
                                                                                </div>
                                                                                <input type="text" class="form-control selectTgl" name="txtRealisasi[]" value="<?= $realQi ?>">
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="row">
                                                                        <div class="col-lg-5">
                                                                            <label>PIC</label>
                                                                            <div class="input-group">
                                                                                <div class="input-group-addon">
                                                                                    <i class="fa fa-font"></i>
                                                                                </div>
                                                                                <input type="text" class="form-control" placeholder="PIC" name="txtPic[]" value="<?= $gE['pic'] ?>">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-5">
                                                                            <label>Catatan</label>
                                                                            <textarea class="form-control" placeholder="Catatan" name="txtCat[]" value="<?= $gE['catatan'] ?>"><?= $gE['catatan'] ?></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php } ?>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-footer">
                                        <div class="row text-right" style="margin:1px;">
                                            <a href="<?php echo base_url('MonitoringFlowOut'); ?>/InternalView" class="btn btn-danger btn-lg">Back</a>
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