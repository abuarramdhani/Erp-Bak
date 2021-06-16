<div class="panel-body">
    <h2 style="font-weight: bold; text-align: center;"><?= $subname; ?></h2>
    <table class="datatable table table-bordered table-hover table-striped text-center" id="tblMon" style="width: 100%;">
        <thead class="bg-primary">
            <tr>
                <th style="width: 5%; vertical-align: middle;">No</th>
                <th style="vertical-align: middle;">Nama Subkon</th>
                <th style="width: 10%; vertical-align: middle;">KIS</th>
                <th style="width: 5%; vertical-align: middle;">Kode Handling</th>
                <th style="width: 25%; vertical-align: middle;">Nama Handling</th>
                <th style="width: 5%; vertical-align: middle;">In / Out</th>
                <th style="width: 5%; vertical-align: middle;">Qty</th>
                <th style="width: 10%; vertical-align: middle;">Transaction Date</th>
                <th style="width: 15%; vertical-align: middle;">Transaction By</th>
            </tr>
        </thead>
        <tbody>
            <?php $no=1; foreach ($mon as $i) { ?>
            <?php
                foreach ($pic as $p) {
                    if ($p['noind'] == $i['TRANSACTION_BY']) {
                        $nama = $p['nama'];
                    }
                }

                if ($i['TRANSACTION_TYPE'] == 'OUT') {
                    $color = 'color: red';
                }
                else {
                    $color = 'color: blue';
                }
            ?>
            <tr style="<?= $color; ?>">
                <td style="width: 5%;">
                    <?= $no; ?>
                </td>
                <td style="text-align: left;">
                    <?= $i['SUBKON'] ?>
                </td>
                <td style="width: 10%; text-align: left;">
                    <?= $i['KIS'] ?>
                </td>
                <td style="width: 5%;">
                    <?= $i['HANDLING_CODE'] ?>
                </td>
                <td style="width: 20%; text-align: left;">
                    <?= $i['HANDLING_NAME'] ?>
                </td>
                <td style="width: 5%;">
                    <?= $i['TRANSACTION_TYPE'].' KHS' ?>
                </td>
                <td style="width: 5%;">
                    <?= $i['TRANSACTION_QUANTITY'] ?>
                </td>
                <td style="width: 10%;">
                    <?= $i['TANGGAL'].'<br>'.$i['WAKTU'] ?>
                </td>
                <td style="width: 15%;">                    
                    <?= $i['TRANSACTION_BY'] ?><br>
                    <?= $nama ?>
                </td>
            </tr>
            <?php $nama = ''; $no++;} ?>
        </tbody>
    </table>
</div>

<script type="text/javascript">
  $('#tblMon').DataTable({})
</script>