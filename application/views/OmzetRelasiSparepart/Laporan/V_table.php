<table class="table table-bordered table-hover tblReportORS">
    <thead>
        <tr class="bg-primary">
            <th class="bg-primary">Cust Account ID</th>
            <th class="bg-primary">Cust Numb</th>
            <th class="bg-primary">Relasi</th>
            <th>JAN</th>
            <th>FEB</th>
            <th>MAR</th>
            <th>APR</th>
            <th>MEI</th>
            <th>JUN</th>
            <th>JUL</th>
            <th>AGT</th>
            <th>SEP</th>
            <th>OKT</th>
            <th>NOV</th>
            <th>DES</th>
            <th>TOTAL</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($report as $key => $rpt) { ?>
            <tr>
                <td><?= $rpt['CUST_ACCOUNT_ID'];?></td>
                <td><?= $rpt['ACCOUNT_NUMBER'];?></td>
                <td><?= $rpt['PARTY_NAME'];?></td>
                <td><?= $rpt['JAN'];?></td>
                <td><?= $rpt['FEB'];?></td>
                <td><?= $rpt['MAR'];?></td>
                <td><?= $rpt['APR'];?></td>
                <td><?= $rpt['MAY'];?></td>
                <td><?= $rpt['JUN'];?></td>
                <td><?= $rpt['JUL'];?></td>
                <td><?= $rpt['AUG'];?></td>
                <td><?= $rpt['SEP'];?></td>
                <td><?= $rpt['OKT'];?></td>
                <td><?= $rpt['NOV'];?></td>
                <td><?= $rpt['DEC'];?></td>
                <td><?= $rpt['JUMLAH'];?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>
