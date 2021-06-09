<div class="table-responsive">
  <div class="panel-body">
    <div class="table-responsive" >
    <table class="datatable table table-bordered table-hover table-striped text-center" id="tblDetailDOSP" style="width: inherit; table-layout: fixed">
        <thead class="bg-primary">
            <tr>
                <th style="width: 20px!important;">NO</th>
                <th style="width: 150px!important;">ITEM CODE</th>
                <th style="width: 300px!important;">DESCRIPTION</th>
                <th style="width: 50px!important;">QTY</th>
            </tr>
        </thead>
        <tbody>
            <?php $i=0; $no=1; foreach($detail as $val) { ?>
                <tr id="baris<?= $val['REQUEST_NUMBER']?>">
                    <td>
                        <?= $no; ?>
                    </td>
                    <td>
                        <?= $val['SEGMENT1']?>
                    </td>
                    <td>
                        <?= $val['DESCRIPTION']?>
                    </td>
                    <td>
                        <?= $val['QUANTITY']?>
                    </td>
                </tr>
            <?php $no++; $i++; } ?>
        </tbody>
    </table>
    </div>
</div>
</div>

<script type="text/javascript">
  $('#tblDetailDOSP').DataTable();  
</script>
