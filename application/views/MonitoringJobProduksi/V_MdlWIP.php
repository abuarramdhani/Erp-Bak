<div class="modal-header" style="font-size:25px;background-color:#82E5FA">
    <i class="fa fa-list-alt"></i> Detail WIP dan Picklist
    <button type="button" class="close" data-dismiss="modal">&times;</button>
</div>
<div class="modal-body">
    <div class="panel-body">
        <div class="col-md-2" style="font-weight:bold">Kode</div>
        <div class="col-md-10">: <?= $item?></div>
        <div class="col-md-2" style="font-weight:bold">Deskripsi</div>
        <div class="col-md-10">: <?= $desc?></div>
    </div>
    <div class="panel-body">
        <table class="table table-bordered table-hovered table-stripped text-center" id="tbl_modal_simulasi" style="width:100%;">
            <thead style="background-color:#82E5FA">
                <tr>
                    <th style="width:7%">No</th>
                    <th>No Job</th>
                    <th>Qty</th>
                    <th>Tanggal</th>
                    <th>Remaining Qty</th>
                    <th>Qty Picklist</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; foreach ($data as $key => $val) {?>
                    <tr>
                        <td><?= $no?></td>
                        <td><?= $val['NO_JOB']?></td>
                        <td><?= $val['START_QUANTITY']?></td>
                        <td><?= $val['SCHEDULED_START_DATE']?></td>
                        <td><?= $val['REMAINING_QTY']?></td>
                        <td><?= $val['QPL_ASSY']?></td>
                    </tr>
                <?php $no++; }?>
            </tbody>
        </table>
    </div>
</div>