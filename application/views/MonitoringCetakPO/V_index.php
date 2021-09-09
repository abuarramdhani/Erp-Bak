<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-danger box-solid">
                <div class="box-header">
                    <div class="col-md-6 text-left">
                        <h4>
                            <strong>PO Belum Cetak</strong>
                        </h4>
                    </div>
                </div>
                <div class="box-body">
                    <table id="tbl-data-unprinted-MCO" wdith="100%" class="table table-bordered table-striped">
                        <thead>
                            <th width="5%">No.</th>
                            <th width="29%">No. PO</th>
                            <th width="25%">Vendor Name</th>
                            <th width="25%">Creation Date</th>
                            <th width="25%">Approved Date</th>
                        </thead>
                        <tbody>
                            <?php
                            $num = 0;
                            foreach ($unprinted as $key => $unprint) {
                                $num++;
                                ?>
                                <tr>
                                    <td><?= $num ?></td>
                                    <td><?= $unprint['NO_PO']; ?></td>
                                    <td><?= $unprint['VENDOR_NAME']; ?></td>
                                    <td><?= $unprint['CREATION_DATE']; ?></td>
                                    <td><?= $unprint['APPROVE_DATE']; ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="box box-primary box-solid">
                <div class="box-header">
                    <div class="col-md-6 text-left">
                        <h4>
                            <strong>PO Sudah Cetak</strong>
                        </h4>
                    </div>
                </div>
                <div class="box-body">
                    <table id="tbl-data-printed-MCO" wdith="100%" class="table table-bordered table-striped">
                        <thead>
                            <th width="5%">No.</th>
                            <th width="29%">No. PO</th>
                            <th width="25%">Vendor Name</th>
                            <th width="25%">Creation Date</th>
                            <th width="25%">Approved Date</th>
                        </thead>
                        <tbody>
                            <?php
                            $no = 0;
                            foreach ($printed as $key => $print) {
                                $no++;
                                ?>
                                <tr>
                                    <td><?= $no ?></td>
                                    <td><?= $print['NO_PO']; ?></td>
                                    <td><?= $print['VENDOR_NAME']; ?></td>
                                    <td><?= $print['CREATION_DATE']; ?></td>
                                    <td><?= $print['APPROVE_DATE']; ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>


<script>
    $(document).ready(function() {
        $('#tbl-data-printed-MCO').DataTable();
        $('#tbl-data-unprinted-MCO').DataTable();
    })
</script>