<div class="panel-body">
    <div style="background: #95f576; color: transparent; width: 20%; display: inline;">______</div>
    <span style="display: inline;">: SUDAH TRANSACT</span><br>
    <div style="background: #f06f4f; color: transparent; width: 20%; display: inline;">______</div>
    <span style="display: inline;">: BELUM TRANSACT</span><br><br>
    <table class="datatable table table-bordered table-hover table-striped text-center" id="tblMon" style="width: 100%;">
        <thead class="bg-primary">
            <tr>
                <th style="width: 5%; vertical-align: middle;">No</th>
                <th style="width: 10%; vertical-align: middle;">No Bon</th>
                <th style="width: 20%; vertical-align: middle;">Seksi Pengebon</th>
                <!-- <th style="width: 15%; vertical-align: middle;">Keterangan</th> -->
                <th style="width: 10%; vertical-align: middle;">Tanggal Pembuatan Bppbg</th>
                <th style="width: 10%; vertical-align: middle;">Gudang</th>
            </tr>
        </thead>
        <tbody>
            <?php $no=1; foreach ($mon as $i) { ?>
            <?php
                if ($i['FLAG'] == 'Y') {
                    $color = '#95f576';
                }
                else {
                    $color = '#f06f4f';
                }
            ?>
            <tr style="background-color: <?= $color ?>">
                <td style="width: 5%;"><?= $no; ?></td>
                <td style="width: 10%;"><?= $i['NO_BON'] ?></td>
                <td style="width: 20%; text-align: left;"><?= $i['SEKSI_BON'] ?></td>
                <!-- <td style="width: 15%; text-align: left;"><?= $i['KETERANGAN'] ?></td> -->
                <td style="width: 10%;"><?= $i['TANGGAL'] ?></td>
                <td style="width: 10%;"><?= $i['TUJUAN_GUDANG'] ?></td>
            </tr>
            <?php $no++;} ?>
        </tbody>
    </table>
</div>

<script type="text/javascript">
  $('#tblMon').DataTable({})
</script>