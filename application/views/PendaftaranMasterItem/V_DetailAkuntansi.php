<script>
$(document).ready(function () {
    $('#tblakt').DataTable({
        "scrollX" : true,
        "scrollY" : 500,
        "paging" : false,
    });
})
</script>
<div class="panel-body" style="margin-top:-20px">
    <h2 style="color : #3F5359;text-align:center;font-weight:bold"><input type="hidden" name="no_document" value="<?= $header['no_dokumen']?>"><?= $header['no_dokumen']?></h2>
    <p style="color : #3F5359;text-align:center;font-weight:bold"><?= $header['seksi']?></p>
    <p style="color : #3F5359;text-align:center">Tanggal : <?= date('d-m-Y', strtotime($header['tgl'])) ?></p>
</div>
<div class="panel-body">
    <h4 style="color: #3F5359; font-weight:bold;margin-left: 15px">STATUS : <?= $header['status']?></h4>
    <div class="col-md-12">
    <?php $tbl = count($data) > 10 ? 'tblakt' : 'tbldetail';
        $tambahan = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';?>
        <table class="table table-bordered table-hover table-striped text-center" id="<?= $tbl?>" style="width: 100%;">
            <thead class="text-nowrap" style="background-color:#49D3F5">
                <tr>
                    <th rowspan="2" style="vertical-align:middle">No</th>
                    <th rowspan="2" style="vertical-align:middle">Status</th>
                    <th rowspan="2" style="vertical-align:middle"><?= $tambahan?>Item<?= $tambahan?></th>
                    <th rowspan="2" style="vertical-align:middle;"><?= $tambahan?>Deskripsi<?= $tambahan?></th>
                    <th rowspan="2" style="vertical-align:middle">Uom</th>
                    <th rowspan="2" style="vertical-align:middle">Dual Uom</th>
                    <th rowspan="2" style="vertical-align:middle">Secondary Uom</th>
                    <th rowspan="2" style="vertical-align:middle">Make/Buy</th>
                    <th rowspan="2" style="vertical-align:middle">Stock</th>
                    <th rowspan="2" style="vertical-align:middle">No. Serial</th>
                    <th rowspan="2" style="vertical-align:middle">Inspect At Receipt</th>
                    <th rowspan="2" style="vertical-align:middle">Org. Assign</th>
                    <th colspan="3">Proses Lanjut</th>
                    <th colspan="2">Accounting</th>
                    <th rowspan="2" style="vertical-align:middle"><?= $tambahan?>Keterangan<?= $tambahan?></th>
                    <th rowspan="2" style="vertical-align:middle"><?= $tambahan?>Comment<?= $tambahan?></th>
                </tr>
                <tr>
                    <th>ODM</th>
                    <th>OPM</th>
                    <th>Jual</th>
                    <th>Inv Value</th>
                    <th><?= $tambahan?>Exp Acc<?= $tambahan?></th>
                </tr>
            </thead>
            <tbody>
            <?php $no = 1; foreach ($data as $key => $val) {?>
                <tr>
                    <td><input type="hidden" id="id_item<?= $no?>" name="id_item[]" value="<?= $val['ID_ITEM']?>"><?= $no?></td>
                    <td><input type="hidden" id="status<?= $no?>" name="status[]" value="<?= $val['STATUS_REQUEST']?>"><?= $val['STATUS_REQUEST']?></td>
                    <td><input type="hidden" id="item<?= $no?>" name="item[]" value="<?= $val['ITEM_FIX']?>"><?= $val['ITEM_FIX']?></td>
                    <td><input type="hidden" id="desc<?= $no?>" name="desc[]" value="<?= $val['DESC_FIX']?>"><?= $val['DESC_FIX']?></td>
                    <td><?= $val['KODE_UOM']?></td>
                    <td><?= $val['STATUS_REQUEST'] == 'I' ? '-' : $val['DUAL_UOM']?></td>
                    <td><?= $val['STATUS_REQUEST'] == 'I' ? '-' : $val['SECONDARY_UOM']?></td>
                    <td><input type="hidden" id="make_buy<?= $no?>" name="make_buy[]" value="<?= $val['MAKE_BUY']?>"><?= $val['STATUS_REQUEST'] == 'I' ? '-' : $val['MAKE_BUY']?></td>
                    <td><?= $val['STATUS_REQUEST'] == 'I' ? '-' : $val['STOK']?></td>
                    <td><?= $val['STATUS_REQUEST'] == 'I' ? '-' : $val['NO_SERIAL']?></td>
                    <td><?= $val['STATUS_REQUEST'] == 'I' ? '-' : $val['INSPECT_AT_RECEIPT']?></td>
                    <td><?= $val['STATUS_REQUEST'] == 'I' ? '-' : $val['ORG_ASSIGN']?></td>
                    <td><?= $val['ODM'] == 'ODM' ? '<i class="fa fa-check" style="color:green"></i>' : '';?></td>
                    <td><?= $val['OPM'] == 'OPM' ? '<i class="fa fa-check" style="color:green"></i>' : '';?></td>
                    <td><?= $val['JUAL'] == 'JUAL' ? '<i class="fa fa-check" style="color:green"></i>' : '';?></td>
                    <td><select id="inv_value<?= $no?>" name="inv_value[]" class="form-control select2" onchange="inv_value(<?= $no?>)" style="width:100%" required>
                            <option></option>
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>
                    </td>
                    <td id="gantiExp<?= $no?>"><input id="exp_acc<?= $no?>" name="exp_acc[]" class="form-control" style="width:100%" autocomplete="off"></td>
                    <td><?= $val['KETERANGAN']?></td>
                    <td><input id="comment<?= $no?>" name="comment[]" class="form-control" style="width:100%" <?= $val['STATUS_REQUEST'] == 'I' ? 'required' : 'readonly' ?> autocomplete="off"></td>
                </tr>
            <?php $no++; }?>
            </tbody>
        </table>
    </div>
</div>
<div class="panel-body text-center" style="<?= $header['status'] != 'Pengecekan Akuntansi' ? 'display:none' : '';?>">
    <button class="btn btn-success" formaction="<?php echo base_url('MasterItemAkuntansi/Request/submitAkuntansi')?>"><i class="fa fa-check"></i> Submit</button>
</div>