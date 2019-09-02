<style>
    th {
        text-align: center;
    }
</style>
<input type="hidden" id="mfoTipe" value="ext">
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
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('MonitoringFlowOut/ExternalView'); ?>">
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
                                    <div class="panel-body">
                                    <div class="box-body">
                                        <div class="panel-body">
                                            <form action="<?= base_url("MonitoringFlowOut/ExternalView/ExportExt")?>" method="post" autocomplete="off">
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
                                                    <a href="<?= base_url('MonitoringFlowOut/ExternalView/')?>"
                                                        class="btn btn-warning btn-sm"><i class="fa fa-refresh"></i> Refresh</a>
                                                    <button type="submit" class="btn btn-info btn-sm"> <i class="fa fa-file-excel-o"></i> Export</button>
                                                </div>
                                            </div> <br />
                                            <div class="row">
                                                <div class="col-lg-4">
                                                        <input type="text" name="txtTglMFO1" id="txtTglMFO1" name="txtTglMFO1" placeholder="Tanggal Awal"
                                                            class="form-control selectTgl"
                                                            oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');">
                                                </div> 
                                                <div class="col-lg-4">
                                                        <input type="text" name="txtTglMFO2" id="txtTglMFO2" name="txtTglMFO2" placeholder="Tanggal Akhir"
                                                            class="form-control selectTgl"
                                                            oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');">
                                                </div>
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Datatable -->
                            <div class="box box-primary box-solid" id="ajaxTblExt">
                                <div class="box-header with-border">
                                    <div class="col-lg-11" style="vertical-align:middle;">
                                        <b style="vertical-align:middle;"><b>External View</b></b>
                                    </div>
                                    <div class="col-lg-1">
                                        <a href="<?= base_url('MonitoringFlowOut/ExternalView/Grafik')?>"
                                            class="btn btn-default"><i class="fa fa-area-chart"></i></i></a>
                                    </div>
                                </div>
                                <div class="box-body">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="table-responsive">
                                                <table class="datatable table table-striped table-bordered table-hover" id="MFO2">
                                                    <thead class="bg-primary">
                                                        <tr>
                                                            <th rowspan="2">No</th>
                                                            <th colspan="6">Penemu Masalah</th>
                                                            <th colspan="2">Status</th>
                                                            <th colspan="8">Seksi yg Bertanggung Jawab</th>
                                                            <th width="120px" rowspan="2">Action</th>
                                                        </tr>
                                                        <tr>
                                                            <th>Tgl</th>
                                                            <th width="120px">Kode Komponen</th>
                                                            <th width="120px">Nama Komponen</th>
                                                            <th>Tipe</th>
                                                            <th width="300px">Kronologi Masalah</th>
                                                            <th>Possible Failure</th>
                                                            <th>Status FlowOut QC</th>
                                                            <th>Meth</th>
                                                            <th>Seksi</th>
                                                            <th>Vendor</th>
                                                            <th>QR</th>
                                                            <th>Tgl Distribusi</th>
                                                            <th>CAR</th>
                                                            <th>Tgl Kirim</th>
                                                            <th>Due Date Act</th>
                                                            <th>Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                        <?php $i = 1;
                                                        foreach ($dats as $s) {
                                                            //CONVERTING
                                                            $cTgl1 = date("d/m/Y", strtotime($s['tanggal']));
                                                            $cTgl2 = date("d/m/Y", strtotime($s['tgl_kirim']));
                                                            $cTgl3 = date("d/m/Y", strtotime($s['tgl_distr']));
                                                            $cTgl4 = date("d/m/Y", strtotime($s['due_date']));
                                                            ?>
                                                            <tr data="<?php echo $s['id_ext'] ?>">
                                                                <td><?php echo $i++; ?></td>

                                                                <td><?php echo $cTgl1 ?></td>
                                                                <td><?php echo $s['component_code_ext'] ?></td>
                                                                <td><?php echo $s['component_name'] ?></td>
                                                                <td><?php echo $s['type'] ?></td>
                                                                <td><?php echo $s['kronologi_p'] ?></td>
                                                                <td><?php echo $s['possible_fail'] ?></td>
                                                                <td><?php echo $s['status_fo'] ?></td>
                                                                <td><?php echo $s['metode'] ?></td>
                                                                <td><?php echo $s['seksi_penanggungjawab'] ?></td>
                                                                <td><?php echo $s['vendor'] ?></td>
                                                                <td>
                                                                    <?php
                                                                    $pdfQr = "./assets/upload/MonitoringFlowOut/uploadQr/" . $s['upload_qr'];
                                                                    $pdfCar = "./assets/upload/MonitoringFlowOut/uploadCar/" . $s['upload_car'];
                                                                    if ($s['upload_qr'] != NULL && file_exists($pdfQr)) { ?> <a href="<?= base_url('assets/upload/MonitoringFlowOut/uploadQr/') . "/" . $s['upload_qr']; ?> "><i class="fa fa-eye"></i></a>
                                                                    <?php
                                                                    } else { ?>
                                                                        <i class="fa fa-ban"></i>
                                                                    <?php }; ?>
                                                                </td>
                                                                <td><?php echo $cTgl3 ?></td>
                                                                <td>
                                                                    <?php if ($s['upload_car'] != NULL && file_exists($pdfCar)) { ?> <a href="<?= base_url('assets/upload/MonitoringFlowOut/uploadCar/') . "/" . $s['upload_car']; ?>"><i class="fa fa-eye"></i></a>
                                                                    <?php
                                                                    } else { ?>
                                                                        <i class="fa fa-ban"></i>
                                                                    <?php }; ?>
                                                                </td>
                                                                <td><?php echo $cTgl2 ?></td>
                                                                <td><?php echo $cTgl4 ?></td>
                                                                <td><?php echo $s['status'] ?></td>
                                                                <td>
                                                                    <button onclick="readExternal(<?php echo $s['id_ext'] ?>)" class="btn btn-primary btn-sm"><i class="fa fa-list-alt"></i></button>
                                                                    <a class="btn btn-success btn-sm" href="<?php echo base_url() ?>MonitoringFlowOut/ExternalView/edit/<?php echo $s['id_ext'] ?>"> <i class="fa fa-pencil"></i></a>
                                                                    <button onclick="delExternal(<?php echo $s['id_ext'] ?>)" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                                                                </td>
                                                            <?php  } ?>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="modal fade" id="readModalExt">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span></button>
                                                            <h4 class="modal-title">Quality Inspection</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <table class="table">
                                                                <thead class="thead-dark">
                                                                    <tr>
                                                                        <th scope="col">No</th>
                                                                        <th scope="col">Due Date</th>
                                                                        <th scope="col">Realisasi</th>
                                                                        <th scope="col">PIC</th>
                                                                        <th scope="col">Catatan</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="modalQi2">

                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
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
            </div>
        </div>
</section>