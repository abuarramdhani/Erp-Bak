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