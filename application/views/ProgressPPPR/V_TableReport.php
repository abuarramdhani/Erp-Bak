<table class="table table-striped table-hover table-bordered" id="tblReportPPR">
    <thead>
        <tr>
            <th>PP/Order Create Date</th>
            <th>Reference Number</th>
            <th>PR Create Date</th>
            <th>PR Number</th>
            <th>PR Line</th>
            <th>PR Approved Date</th>
            <th>PR Status</th>
            <th>Requestor</th>
            <th>Seksi Pemesan</th>
            <th>Item Code</th>
            <th>Item Description</th>
            <th>Note to Buyer</th>
            <th>Gudang</th>
            <th>Need By Date</th>
            <th>PO Number</th>
            <th>PO Line</th>
            <th>Promised Date Update</th>
            <th>PO Status</th>
            <th>UOM</th>
            <th>Quantity Ordered</th>
            <th>Quantity Received</th>
            <th>Quantity Rejected</th>
            <th>Quantity Due</th>
            <th>Buyer</th>
            <th>Receipt Date</th>
            <th>Keterangan Progress</th>

        </tr>
    </thead>
    <tbody>
        <?php foreach ($report as $key => $rep) { ?>
            <tr>
                <td><?= $rep['TANGGAL_PP_DIBUAT']; ?></td>
                <td><?= $rep['REFERENCE_NUM']; ?></td>
                <td><?= $rep['PR_CREATE_DATE']; ?></td>
                <td><?= $rep['PR_NUMBER']; ?></td>
                <td><?= $rep['PR_LINE']; ?></td>
                <td><?= $rep['PR_APPROVED_DATE']; ?></td>
                <td><?= $rep['PR_STATUS']; ?></td>
                <td><?= $rep['REQUESTOR']; ?></td>
                <td><?= $rep['SEKSI_PEMESAN']; ?></td>
                <td><?= $rep['ITEM_CODE']; ?></td>
                <td><?= $rep['ITEM_DESCRIPTION']; ?></td>
                <td><?= $rep['NOTE_TO_BUYER']; ?></td>
                <td><?= $rep['GUDANG']; ?></td>
                <td><?= $rep['NEED_BY_DATE']; ?></td>
                <td><?= $rep['PO_NUMBER']; ?></td>
                <td><?= $rep['PO_LINE']; ?></td>
                <td><?= $rep['PROMISED_DATE_UPDATE']; ?></td>
                <td><?= $rep['STATUS_LOOKUP_CODE']; ?></td>
                <td><?= $rep['UOM']; ?></td>
                <td><?= $rep['QUANTITY_ORDERED']; ?></td>
                <td><?= $rep['QUANTITY_RECEIVED']; ?></td>
                <td><?= $rep['QUANTITY_REJECTED']; ?></td>
                <td><?= $rep['QUANTITY_DUE']; ?></td>
                <td><?= $rep['BUYER']; ?></td>
                <td><?= $rep['RECEIPT_DATE']; ?></td>
                <td><?= $rep['KETERANGAN_PROGRESS']; ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>