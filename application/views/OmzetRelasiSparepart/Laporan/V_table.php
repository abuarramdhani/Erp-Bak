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
                <td><?= number_format($rpt['JAN']);?></td>
                <td><?= number_format($rpt['FEB']);?></td>
                <td><?= number_format($rpt['MAR']);?></td>
                <td><?= number_format($rpt['APR']);?></td>
                <td><?= number_format($rpt['MAY']);?></td>
                <td><?= number_format($rpt['JUN']);?></td>
                <td><?= number_format($rpt['JUL']);?></td>
                <td><?= number_format($rpt['AUG']);?></td>
                <td><?= number_format($rpt['SEP']);?></td>
                <td><?= number_format($rpt['OKT']);?></td>
                <td><?= number_format($rpt['NOV']);?></td>
                <td><?= number_format($rpt['DEC']);?></td>
                <td><?= number_format($rpt['JUMLAH']);?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>
