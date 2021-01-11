<script>
        $(document).ready(function () {
        $('.myTable').dataTable({
            "scrollX": true,
        });
        });
</script>
<div class="table-responsive">
    <table class="datatable table table-bordered table-hover table-striped myTable text-center" id="myTable" style="width: 100%;">
        <thead class="btn-info text-nowrap">
            <tr>
                <th>No</th>
                <th>Shipment Num</th>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Tanggal Transaksi</th>
                <th>Quantity Intransit</th>
                <th>Jumlah Hari</th>
                <th>IO Asal</th>
                <th>SubInventory Asal</th>
                <th>IO Tujuan</th>
                <th>SubInventory Tujuan</th>
                <th>Quantity Kirim</th>
                <th>Quantity Terima</th>
                <th>Receipt Num</th>
                <th>Serial Number</th>
                <th>Lokasi Asal</th>
                <th>Lokasi Tujuan</th>
                <th>Comments</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; foreach ($data as $key => $val) { ?>
                <tr>
                    <td><?= $no?></td>
                    <td><?= $val['SHIPMENT_NUM']?></td>
                    <td><?= $val['KODE_BRG']?></td>
                    <td><?= $val['NAMA_BRG']?></td>
                    <td><?= $val['TGL_TRANSAKSI']?></td>
                    <td><?= $val['QTY_INTRANSIT']?></td>
                    <td><?= $val['JUMLAH_HARI']?></td>
                    <td><?= $val['FROM_IO']?></td>
                    <td><?= $val['FROM_SUBINVENTORY']?></td>
                    <td><?= $val['TO_IO']?></td>
                    <td><?= $val['TO_SUBINVENTORY']?></td>
                    <td><?= $val['QTY_KIRIM']?></td>
                    <td><?= $val['QTY_TERIMA']?></td>
                    <td><?= $val['RECEIPT_NUM']?></td>
                    <td><?= $val['SERIAL_NUMBER']?></td>
                    <td><?= $val['FROM_LOC']?></td>
                    <td><?= $val['TO_LOC']?></td>
                    <td><?= $val['COMMENTS']?></td>
                </tr>
            <?php $no++; }?>
        </tbody>
    </table>
</div>