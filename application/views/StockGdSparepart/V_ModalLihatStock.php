<div class="panel-body">
        <div class="col-md-12">
            <div class="col-md-2">
                <label>Kode Barang</label>
            </div>
            <div class="col-md-10">: <?= $kode?></div>
        </div>
        <div class="col-md-12">
            <div class="col-md-2">
                <label>Deskripsi Barang</label>
            </div>
            <div class="col-md-10">: <?= $nama?></div>
        </div>
        <div class="col-md-12">
            <div class="col-md-2">
                <label>SubInventory</label>
            </div>
            <div class="col-md-10">: <?= $subinv?></div>
        </div>
        <div class="col-md-12">
            <div class="col-md-2">
                <label>Periode</label>
            </div>
            <div class="col-md-10">: <?= $tglAwl?> - <?= $tglAkh?></div>
        </div>
    </div>
<div class="panel-body">
    <div class="table-responsive">
        <table class="datatable table table-bordered table-hover table-striped text-center myTable" id="myTable" style="width: 100%;">
            <thead class="bg-info">
                <tr>
                    <th>No</th>
                    <th>Bukti Transaksi</th>
                    <th>Tanggal Transaksi</th>
                    <th>Jenis Transaksi</th>
                    <th>Satuan</th>
                    <th>In</th>
                    <th>Out</th>
                    <th>Saldo</th>
                    <th>Created By</th>
                    <th>Jam dibuat</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; foreach ($data as $key => $val) { ?>
                    <tr>
                        <td><?= $no?></td>
                        <td><?= $val['NO_BUKTI']?></td>
                        <td><?= $val['TRANSACTION_DATE']?></td>
                        <td><?= $val['TRANSACTION_TYPE_NAME']?></td>
                        <td><?= $val['UOM']?></td>
                        <td><?= $val['QTY_IN']?></td>
                        <td><?= $val['QTY_OUT_MMT']?></td>
                        <td class="bg-success"><?= $val['SALDO']?></td>
                        <td><?= $val['TRANSACT_BY']?></td>
                        <td><?= $val['TRANSACTION_DATE']?></td>
                    </tr>
                <?php $no++; }?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4"></td>
                    <td>Total : </td>
                    <td><b><?= $totalIN?></b></td>
                    <td><b><?= $totalOUT?></b></td>
                    <td class="bg-success"><b><?= $onhand?></b></td>
                    <td colspan="2"></td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>