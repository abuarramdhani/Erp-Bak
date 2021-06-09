<div class="panel-body">
    <h2 style="font-weight: bold; text-align: center;"><?= $subname; ?></h2>
    <table class="datatable table table-bordered table-hover table-striped text-center" id="tblStock" style="width: 100%;">
        <thead class="bg-primary">
            <tr>
                <th style="width: 5%; vertical-align: middle;">No</th>
                <th style="vertical-align: middle;">Nama Subkon</th>
                <th style="width: 5%; vertical-align: middle;">Kode Handling</th>
                <th style="vertical-align: middle;">Nama Handling</th>
                <th style="width: 5%; vertical-align: middle;">Saldo Awal</th>
                <th style="width: 5%; vertical-align: middle;">Qty di Subkon</th>
                <th style="width: 5%; vertical-align: middle;">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php $no=1; foreach ($stock as $i) { ?>
            <tr>
                <td style="width: 5%;">
                    <?= $no; ?>
                </td>
                <td style="text-align: left;">
                    <?= $i['SUBKON'] ?>
                </td>
                <td style="width: 5%;">
                    <?= $i['HANDLING_CODE'] ?>
                </td>
                <td style="text-align: left;">
                    <?= $i['HANDLING_NAME'] ?>
                </td>
                <td style="width: 5%;">
                    <?= $i['SALDO_AWAL'] ?>
                </td>
                <td style="width: 5%; font-size: 18px; font-weight: bold; color: red;">
                    <?= $i['DI_SUBKON'] ?>
                </td>
                <td style="width: 5%;">
                    <button type="button" class="btn btn-primary btn-xs" onclick="editModal(`<?= $i['LOCATOR_NAME'] ?>`,`<?= $i['SUBKON'] ?>`,`<?= $i['HANDLING_CODE'] ?>`,`<?= $i['HANDLING_NAME'] ?>`,<?= $i['SALDO_AWAL'] ?>)" data-toggle="modal" data-target="#editModal">
                        <i class="fa fa-edit"></i> Edit Saldo
                    </button>
                </td>
            </tr>
            <?php $no++;} ?>
        </tbody>
    </table>
</div>

<script type="text/javascript">
  $('#tblStock').DataTable({})
</script>