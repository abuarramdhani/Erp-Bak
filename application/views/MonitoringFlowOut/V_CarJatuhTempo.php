<style>
    th {
        text-align: center;
    }
</style>
<input type="hidden" id="mfoTipe" value="car">
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
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('MonitoringFlowOut/CarJatuhTempo'); ?>">
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
                <div class="row">
                    <div class="col-lg-12">
                    <div class="box box-primary box-solid">
                            <div class="box-header with-border">
                                <b>Search</b>
                            </div>
                            <div class="box-body">
                            <form action="<?= base_url("MonitoringFlowOut/CarJatuhTempo/ExportCar")?>" method="post" autocomplete="off">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-lg-8">
                                            <select id="slcSeksiFAjx" name="seksi2" class="form-control">
                                                <option value=""></option>
                                                <?php foreach ($seksi2 as $s){ ?>
                                                    <option name="seksi2" value="<?= $s ?>"><?= $s ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-lg-3" style="text-align:center;vertical-align:middle;">
                                            <button type="button" id="subMfo" class="btn btn-success btn-sm"> <i class="fa fa-search"></i> Search</button>
                                            <a href="<?= base_url('MonitoringFlowOut/CarJatuhTempo/')?>" class="btn btn-warning btn-sm"><i class="fa fa-refresh"></i> Refresh</a>
                                            <button type="submit" class="btn btn-info btn-sm"> <i class="fa fa-file-excel-o"></i> Export</button>
                                        </div>
                                    </div> <br />
                                    <div class="row">
                                        <div class="col-lg-4">
                                                <input type="text" name="txtTglMFO1" id="txtTglMFO1" placeholder="Tanggal Due Date Awal"
                                                    class="form-control selectTgl"
                                                    oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');">
                                        </div> 
                                        <div class="col-lg-4">
                                                <input type="text" name="txtTglMFO2" id="txtTglMFO2" placeholder="Tanggal Due Date Akhir"
                                                    class="form-control selectTgl"
                                                    oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');">
                                        </div>
                                    </div>
                                </div>
                            </form>
                            </div>
                        </div>
                        <!-- Datatable -->
                        <div class="box box-primary box-solid" id="ajaxTblCar">
                            <div class="box-header with-border">
                                <b style="vertical-align:middle;"><b>CAR Jatuh Tempo</b></b>
                            </div>
                            <div class="box-body">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="table-responsive text-nowrap">
                                            <table class="datatable table table-striped table-bordered table-hover" id="MfovCAR">
                                                <thead class="bg-primary">
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Tgl</th>
                                                        <th>Kode Komponen</th>
                                                        <th>Nama Komponen</th>
                                                        <th>Tipe</th>
                                                        <th>Kronologi Permasalahan</th>
                                                        <th>Possible Failure</th>
                                                        <th>Status</th>
                                                        <th>QR</th>
                                                        <th>CAR</th>
                                                        <th>Seksi</th>
                                                        <th>Due Date Act</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    <?php $i = 1;
                                                    foreach ($dats as $Internal) {
                                                        // CONVERTING
                                                        $cTgl1 = date("d/m/Y", strtotime($Internal['tanggal']));
                                                        $cTgl4 = date("d/m/Y", strtotime($Internal['due_date']));
                                                        ?>
                                                        <tr data="<?= $Internal['id_int'] ?>">
                                                            <td><?= $i++; ?></td>
                                                            <td><?php echo $cTgl1 ?></td>
                                                            <td><?php echo $Internal['component_code_int'] ?></td>
                                                            <td><?php echo $Internal['component_name'] ?></td>
                                                            <td><?php echo $Internal['type'] ?></td>
                                                            <td><?php echo $Internal['kronologi_p'] ?></td>
                                                            <td><?php echo $Internal['possible_fail'] ?></td>
                                                            <td><?php echo $Internal['status'] ?></td>
                                                            <td style="text-align:center;">
                                                                <?php
                                                                $pdfQr = "./assets/upload/MonitoringFlowOut/uploadQr/" . $Internal['upload_qr'];
                                                                $pdfCar = "./assets/upload/MonitoringFlowOut/uploadCar/" . $Internal['upload_car'];
                                                                if ($Internal['upload_qr'] != NULL && file_exists($pdfQr)) { ?> <a class="btn btn-prymary btn-sm" href="<?= base_url('assets/upload/MonitoringFlowOut/uploadQr/') . "/" . $Internal['upload_qr']; ?> "><i class="fa fa-eye"></i></a>

                                                                <?php
                                                                } else { ?>
                                                                    <i class="fa fa-ban"></i>
                                                                <?php }; ?>
                                                            </td>
                                                            <td style="text-align:center;">
                                                                <?php if ($Internal['upload_car'] != NULL && file_exists($pdfCar)) { ?> <a class="btn btn-prymary btn-sm" href="<?= base_url('assets/upload/MonitoringFlowOut/uploadCar/') . "/" . $Internal['upload_car']; ?>"><i class="fa fa-eye"></i></a>

                                                                <?php
                                                                } else { ?>
                                                                    <i class="fa fa-ban"></i>
                                                                <?php }; ?>
                                                            </td>
                                                            <td><?php echo $Internal['seksi_penanggungjawab'] ?></td>
                                                            <td><?php echo $cTgl4 ?></td>
                                                        <?php } ?>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>