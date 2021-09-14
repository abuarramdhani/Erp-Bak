<div class="panel-body">
    <form action="<?= base_url('ReportPembuatanLPPB/Report/exportDataRPL'); ?>" method="post">
        <table class="datatable table table-bordered table-hover table-striped text-center" id="tblLppb" style="width: 100%;">
            <thead class="bg-primary">
                <tr>
                    <th>No</th>
                    <th>IO</th>
                    <th>No LPPB</th>
                    <th>Kode Item</th>
                    <th>Item</th>
                    <th>Tanggal & Jam Shipment</th>
                    <th>Tanggal & Jam Receipt</th>
                    <th>Tanggal & Jam Transfer</th>
                    <th>Tanggal & Jam Inspect</th>
                    <th>Tanggal & Jam Deliver</th>
                    <th>Subinventory/Locator Tujuan</th>
                    <th>Akun yang Mereceipt</th>
                </tr>
            </thead>
            <tbody>
                <?php $no=1; foreach ($lppb as $v) { ?>
                <tr>
                    <td>
                        <?= $no; ?>
                        <input type="hidden" name="tanggal[]" id="tanggal" value="<?= $tanggal ?>">
                        <input type="hidden" name="lokasi[]" id="lokasi" value="<?= $lokasi ?>">
                        <input type="hidden" name="io[]" id="io" value="<?= $io ?>">
                        <input type="hidden" name="shipment_line_id[]" id="shipment_line_id" value="<?= $v['SHIPMENT_LINE_ID']?>">
                    </td>
                    <td><input type="hidden" name="org_code[]" id="org_code" value="<?= $v['ORGANIZATION_CODE']?>"><?= $v['ORGANIZATION_CODE'] ?></td>
                    <td><input type="hidden" name="no_lppb[]" id="no_lppb" value="<?= $v['NO_LPPB']?>"><?= $v['NO_LPPB'] ?></td>
                    <td><input type="hidden" name="kode_item[]" id="kode_item" value="<?= $v['KODE_ITEM']?>"><?= $v['KODE_ITEM'] ?></td>
                    <td><input type="hidden" name="item[]" id="item" value="<?= $v['ITEM']?>"><?= $v['ITEM'] ?></td>
                    <td><input type="hidden" name="tgl_shipment[]" id="tgl_shipment" value="<?= $v['TGL_SHIPMENT']?>"><?= $v['TGL_SHIPMENT'] ?></td>
                    <td><input type="hidden" name="tgl_receive[]" id="tgl_receive" value="<?= $v['TGL_RECEIVE']?>"><?= $v['TGL_RECEIVE'] ?></td>
                    <td><input type="hidden" name="tgl_transfer[]" id="tgl_transfer" value="<?= $v['TGL_TRANSFER']?>"><?= $v['TGL_TRANSFER'] ?></td>
                    <td><input type="hidden" name="tgl_inspect[]" id="tgl_inspect" value="<?= $v['TGL_INSPECT']?>"><?= $v['TGL_INSPECT'] ?></td>
                    <td><input type="hidden" name="tgl_deliver[]" id="tgl_deliver" value="<?= $v['TGL_DELIVER']?>"><?= $v['TGL_DELIVER'] ?></td>
                    <td><input type="hidden" name="location_code[]" id="location_code" value="<?= $v['LOCATION_CODE']?>"><?= $v['LOCATION_CODE'] ?></td>
                    <td><input type="hidden" name="akun_receipt[]" id="akun_receipt" value="<?= $v['AKUN_RECEIPT']?>"><?= $v['AKUN_RECEIPT'] ?></td>
                </tr>
                <?php $no++; } ?>
        </table>
        <div class="text-center">
            <button type="submit" title="Export" class="btn btn-success">
                <i class="fa fa-download"></i> Export Excel
            </button>
        </div>
    </form>
</div>

<script type="text/javascript">
    $('#tblLppb').DataTable({
        scrollX: true,
        scrollY: 500,
        scrollCollapse: true,
        paging: false,
        info: true,
        ordering: true
    });
</script>