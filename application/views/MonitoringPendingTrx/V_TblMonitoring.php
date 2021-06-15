<style type="text/css">
    .green {
        color:  white;
        background-color: green;
    }
</style>
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
            <?php 
                if ($i['FROM_SUBINVENTORY_CODE'] == $subinv || $i['FROM_LOCATOR'] == $loc2) {
                    $fw1 = 'font-weight: bold; font-size: 16px; color: red;';
                }
                else {
                    $fw1 = '';
                }

                if ($i['TO_SUBINVENTORY_CODE'] == $subinv || $i['TO_LOCATOR'] == $loc2) {
                    $fw2 = 'font-weight: bold; font-size: 16px; color: red;';
                }
                else {
                    $fw2 = '';
                }
            ?>
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
                <td style="width: 10%; <?= $fw1 ?>">
                    <?= $i['FROM_SUBINVENTORY_CODE'] ?>
                </td>
                <td style="width: 10%; <?= $fw1 ?>">
                    <?= $i['FROM_LOCATOR'] ?>
                </td>
                <td style="width: 5%;">
                    <?= $i['TO_ORGANIZATION'] ?>
                </td>
                <td style="width: 10%; <?= $fw2 ?>">
                    <?= $i['TO_SUBINVENTORY_CODE'] ?>
                </td>
                <td style="width: 10%; <?= $fw2 ?>">
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
    $('#tblMon').DataTable({
        dom: "<'row'<'col-sm-6'l><'col-sm-3 text-right'B><'col-sm-3'f>>" +
        "<'row'<'col-sm-12'tr>>" +
        "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        buttons: [
            {
              extend: 'excelHtml5',
              text: 'Export Excel',
              className: 'green'
            }
        ]
    })
</script>