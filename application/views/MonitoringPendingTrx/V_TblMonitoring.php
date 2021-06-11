<div class="panel-body">
    <table class="datatable table table-bordered table-hover table-striped text-center" id="tblMon" style="width: 100%;">
        <thead class="bg-primary">
            <tr>
                <th style="width: 5%; vertical-align: middle;">No</th>
                <th style="vertical-align: middle;">Document Number</th>
                <th style="width: 10%; vertical-align: middle;">Jenis</th>
                <th style="width: 10%; vertical-align: middle;">From Subinventory</th>
                <th style="width: 10%; vertical-align: middle;">From Locator</th>
                <th style="width: 5%; vertical-align: middle;">To Org</th>
                <th style="width: 10%; vertical-align: middle;">To Subinventory</th>
                <th style="width: 10%; vertical-align: middle;">To Locator</th>
                <th style="vertical-align: middle;">Creation Date</th>
                <th style="width: 5%; vertical-align: middle;">Detail</th>
            </tr>
        </thead>
        <tbody>
            <?php $no=1; foreach ($mon as $i) { ?>
            <tr>
                <td style="width: 5%;">
                    <?= $no; ?>
                </td>
                <td style="text-align: left;">
                    <?= $i['REQUEST_NUMBER'] ?>
                </td>
                <td style="width: 10%;">
                    <?= $i['JENIS'] ?>
                </td>
                <td style="width: 10%;">
                    <?= $i['FROM_SUBINVENTORY_CODE'] ?>
                </td>
                <td style="width: 10%;">
                    <?= $i['FROM_LOCATOR'] ?>
                </td>
                <td style="width: 5%;">
                    <?= $i['TO_ORGANIZATION'] ?>
                </td>
                <td style="width: 10%;">
                    <?= $i['TO_SUBINVENTORY_CODE'] ?>
                </td>
                <td style="width: 10%;">
                    <?= $i['TO_LOCATOR'] ?>
                </td>
                <td>
                    <?= $i['CREATION_DATE2'] ?>
                </td>
                <td style="width: 5%;">
                    <button type="button" class="btn btn-info btn-sm" style="font-weight: bold;" onclick="detailData('<?= $i['REQUEST_NUMBER'] ?>','<?= $i['JENIS'] ?>')" data-toggle="modal" data-target="#detailData"><i class="fa fa-eye"></i>
                    </button>
                </td>
            </tr>
            <?php $no++;} ?>
        </tbody>
    </table>
</div>

<script type="text/javascript">
  $('#tblMon').DataTable({})
</script>