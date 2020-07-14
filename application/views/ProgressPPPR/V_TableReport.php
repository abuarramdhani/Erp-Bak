<table class="table table-striped table-hover table-bordered" id="tblReportPPR">
    <thead>
        <tr>
            <th>Tanggal PP Dibuat</th>
            <th>Nomor PP</th>
            <th>Nomor PO</th>
            <th>Tanggal PO</th>
            <th>Nomor PR</th>
            <th>Tanggal PR</th>
            <th>Tanggal PP Diterima</th>
            <th>PP Approve</th>
            <th>NBD Seksi</th>
            <th>NBD Pembelian</th>
            <th>Promised Date</th>
            <th>Kode Item</th>
            <th>Item Desc PR</th>
            <th>Item Desc</th>
            <th>Quantity</th>
            <th>Satuan</th>
            <th>Keterangan</th>
            <th>No Induk</th>
            <th>Requestor</th>
            <th>Receipt Date</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($report as $key => $rep) { ?>
            <tr>
                <td><?= $rep['TANGGAL_PP_DIBUAT'];?></td>
                <td><?= $rep['NOMOR_PP'];?></td>
                <td><?= $rep['NO_PO'];?></td>
                <td><?= $rep['TANGGAL_PO'];?></td>
                <td><?= $rep['NO_PR'];?></td>
                <td><?= $rep['TANGGAL_PR'];?></td>
                <td><?= $rep['TANGGAL_PP_DITERIMA'];?></td>
                <td><?= $rep['PP_APPROVE'];?></td>
                <td><?= $rep['NBD_SEKSI'];?></td>
                <td><?= $rep['NBD_PEMBELIAN'];?></td>
                <td><?= $rep['PROMISED_DATE'];?></td>
                <td><?= $rep['KODE_ITEM'];?></td>
                <td><?= $rep['ITEM_DESCRIPTION_PR'];?></td>
                <td><?= $rep['ITEM_DESCRIPTION'];?></td>
                <td><?= $rep['QUANTITY'];?></td>
                <td><?= $rep['SATUAN'];?></td>
                <td><?= $rep['KETERANGAN'];?></td>
                <td><?= $rep['NO_INDUK'];?></td>
                <td><?= $rep['REQUESTOR'];?></td>
                <td><?= $rep['RECEIPT_DATE'];?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>
