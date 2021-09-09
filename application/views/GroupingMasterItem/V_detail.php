<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary box-solid">
                <div class="box-header">
                    <div class="col-md-6 text-left">
                        <h4>
                            <strong>
                                Daftar Group <?= $datas[0]['GROUP_NAME'] ?>
                            </strong>
                        </h4>
                    </div>
                </div>
                <div class="box-body">
                    <table id="tbl-group-line-GMI" wdith="100%" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="text-center" width="5%">No.</th>
                                <th class="text-center" width="25%">Item Code</th>
                                <th class="text-center" width="40%">Item Description</th>
                                <th class="text-center" width="10%">Creation Date</th>
                                <th class="text-center" width="20%">Item Type</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 0;
                            $header_id = $datas[0]['HEADER_ID'];
                            foreach ($datas as $key => $data) {
                                $no++;
                                ?>
                                <tr>
                                    <td style="text-align: center;"><?= $no ?></td>
                                    <td style="text-align: center;"><?= $data['SEGMENT1'] ?></td>
                                    <td><?= $data['DESCRIPTION'] ?></td>
                                    <td style="text-align: center;"><?= $data['CREATION_DATE'] ?></td>
                                    <td><?= $data['TYPE_CODE'] ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="5">
                                    <div class="col-md-6" align="left">
                                        <a class="btn btn-primary btn-xl" href="<?= base_url('grouping-master-item/') ?>">Back</a>
                                    </div>
                                    <div class="col-md-6" align="right">
                                        <a class="btn btn-warning btn-xl" href="<?= base_url('grouping-master-item/update/' . $header_id) ?>">Edit</a>
                                    </div>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>