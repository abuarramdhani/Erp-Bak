<div class="box-header with-border">
    <div class="col-lg-11" style="vertical-align:middle;">
        <b style="vertical-align:middle;"><b>Internal View</b></b>
    </div>
    <div class="col-lg-1">
        <a href="<?= base_url('MonitoringFlowOut/InternalView/Grafik')?>" class="btn btn-default"><i
                class="fa fa-area-chart"></i></i></a>
    </div>
</div>
<div class="box-body">
    <div class="panel-body">
        <div class="row">
            <div class="table-responsive">
                <table class="datatable table table-striped table-bordered table-hover" id="MFO"
                    style="max-width: 100%;">
                    <thead class="bg-primary">
                        <tr>
                            <th rowspan="2">No</th>
                            <th colspan="6">Penemu Masalah</th>
                            <th colspan="2">Status</th>
                            <th colspan="7">Seksi yg Bertanggung Jawab</th>
                            <th rowspan="2">Action</th>
                        </tr>
                        <tr>
                            <th>Tgl</th>
                            <th width="120px">Kode Komponen</th>
                            <th width="100px">Nama Komponen</th>
                            <th>Tipe</th>
                            <th width="300px">Kronologi Masalah</th>
                            <th>Possible Failure</th>
                            <th>Status FlowOut QC</th>
                            <th>Meth</th>
                            <th>Seksi</th>
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
                            // CONVERTING
                            $cTgl1 = date("d/m/Y", strtotime($s['tanggal']));
                            $cTgl2 = date("d/m/Y", strtotime($s['tgl_kirim']));
                            $cTgl3 = date("d/m/Y", strtotime($s['tgl_distr']));
                            $cTgl4 = date("d/m/Y", strtotime($s['due_date']));
                            ?> <tr data="<?= $s['id_int'] ?>">
                            <td><?= $i++; ?></td>
                            <td><?php echo $cTgl1 ?><input hidden name="tanggal[]" value="<?php echo $cTgl1 ?>" /></td>
                            <td><?php echo $s['component_code_int'] ?><input hidden name="component_code_int[]"
                                    value="<?php echo $s['component_code_int'] ?>" />
                            </td>
                            <td><?php echo $s['component_name'] ?><input hidden name="component_name[]"
                                    value="<?php echo $s['component_name'] ?>"></td>
                            <td><?php echo $s['type'] ?><input hidden name="type[]" value="<?php echo $s['type'] ?>">
                            </td>
                            <td><?php echo $s['kronologi_p'] ?><input hidden name="kronologi_p[]"
                                    value="<?php echo $s['kronologi_p'] ?>"></td>
                            <td><?php echo $s['possible_fail'] ?><input type="hidden" name="poss_fail[]"
                                    value="<?php echo $s['possible_fail'] ?>"></td>
                            <td><?php echo $s['status_fo'] ?><input hidden name="status_fo[]"
                                    value="<?php echo $s['status_fo'] ?>"></td>
                            <td><?php echo $s['metode'] ?><input hidden name="meth[]"
                                    value="<?php echo $s['metode'] ?>"></td>
                            <td><?php echo $s['seksi_penanggungjawab'] ?><input hidden name="seksipj[]"
                                    value="<?php echo $s['seksi_penanggungjawab'] ?>">
                            </td>
                            <td style="text-align:center;">
                                <?php
                                    $pdfQr = "./assets/upload/MonitoringFlowOut/uploadQr/" . $s['upload_qr'];
                                    $pdfCar = "./assets/upload/MonitoringFlowOut/uploadCar/" . $s['upload_car'];
                                    if ($s['upload_qr'] != NULL && file_exists($pdfQr)) { ?>
                                <a class="btn btn-prymary btn-sm"
                                    href="<?= base_url('assets/upload/MonitoringFlowOut/uploadQr/') . "/" . $s['upload_qr']; ?> "><i
                                        class="fa fa-eye"></i></a>

                                <?php
                                    } else { ?>
                                <i class="fa fa-ban"></i>
                                <?php }; ?>
                            </td>
                            <td><?php echo $cTgl3 ?><input hidden name="tgldistr[]" value="<?php echo $cTgl3 ?>"></td>
                            <td style="text-align:center;">
                                <?php if ($s['upload_car'] != NULL && file_exists($pdfCar)) { ?>
                                <a class="btn btn-prymary btn-sm"
                                    href="<?= base_url('assets/upload/MonitoringFlowOut/uploadCar/') . "/" . $s['upload_car']; ?>"><i
                                        class="fa fa-eye"></i></a>

                                <?php
                                    } else { ?>
                                <i class="fa fa-ban"></i>
                                <?php }; ?>
                            </td>
                            <td><?php echo $cTgl2 ?><input hidden name="tglkirim[]" value="<?php echo $cTgl2 ?>"></td>
                            <td><?php echo $cTgl4 ?><input hidden name="due_date[]" value="<?php echo $cTgl4 ?>"></td>
                            <td><?php echo $s['status'] ?><input hidden name="status[]"
                                    value="<?php echo $s['status'] ?>"></td>
                            <td>
                                <button onclick="readInternal(<?= $s['id_int'] ?>)" class="btn btn-primary btn-sm"><i
                                        class="fa fa-list-alt"></i></button>
                                <a class="btn btn-success btn-sm"
                                    href="<?php echo base_url() ?>MonitoringFlowOut/InternalView/edit/<?= $s['id_int'] ?>">
                                    <i class="fa fa-pencil"></i></a>
                                <button onclick="delInternal(<?= $s['id_int'] ?>)" class="btn btn-danger btn-sm"><i
                                        class="fa fa-trash"></i></button>
                            </td>
                            <?php } ?>
                        </tr>
                    </tbody>
                </table>
                <div class="modal fade" id="readModalInt">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Quality Inspection</h4>
                            </div>
                            <div class="modal-body">
                                <table class="table table-striped">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col">Due Date</th>
                                            <th scope="col">Realisasi</th>
                                            <th scope="col">PIC</th>
                                            <th scope="col">Catatan</th>
                                            <th scope="col">Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody id="modalQi1">

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