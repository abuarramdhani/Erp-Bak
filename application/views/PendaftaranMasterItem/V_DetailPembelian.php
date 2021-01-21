<script>
$(document).ready(function () {
    $('#tblreq').DataTable({
        "scrollX" : true,
        "scrollY" : 500,
        "paging" : false,
    });
})
</script>
<div class="panel-body" style="margin-top:-20px">
    <h2 style="color : #3F5359;text-align:center;font-weight:bold"><input type="hidden" name="no_dokumen" value="<?= $header['no_dokumen']?>"><?= $header['no_dokumen']?></h2>
    <p style="color : #3F5359;text-align:center;font-weight:bold"><?= $header['seksi']?></p>
    <p style="color : #3F5359;text-align:center">Tanggal : <?= date('d-m-Y', strtotime($header['tgl'])) ?></p>
</div>
<div class="panel-body">
    <h4 style="color: #3F5359; font-weight:bold;margin-left: 15px">STATUS : <?= $header['status']?></h4>
    <div class="col-md-12">
        <?php $tbl = count($data) > 10 ? 'tblreq' : 'tbldetail';
        $tambahan = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';?>
        <table class="table table-bordered table-hover table-striped text-center" id="tbldetail" style="width: 100%;">
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
                    <th rowspan="2" style="vertical-align:middle"><?= $tambahan?><?= $tambahan?>Buyer<?= $tambahan?></th>
                    <th rowspan="2" style="vertical-align:middle">Pre-Processing Lead Time (hari)</th>
                    <th rowspan="2" style="vertical-align:middle">Preparation PO (hari)</th>
                    <th rowspan="2" style="vertical-align:middle">Delivery (hari)</th>
                    <th rowspan="2" style="vertical-align:middle">Total Processing (hari)</th>
                    <th rowspan="2" style="vertical-align:middle">Post-Processing PO (hari)</th>
                    <th rowspan="2" style="vertical-align:middle">Total Lead Time (hari)</th>
                    <th rowspan="2" style="vertical-align:middle"><?= $tambahan?>MOQ<?= $tambahan?></th>
                    <th rowspan="2" style="vertical-align:middle"><?= $tambahan?>FLM<?= $tambahan?></th>
                    <th rowspan="2" style="vertical-align:middle"><?= $tambahan?>Nama Approver PO<?= $tambahan?></th>
                    <th rowspan="2" style="vertical-align:middle"><?= $tambahan?>Keterangan<?= $tambahan?></th>
                    <th rowspan="2" style="vertical-align:middle">Receive Close Tolerance</th>
                    <th rowspan="2" style="vertical-align:middle"><?= $tambahan?>Tolerance<?= $tambahan?></th>
                    <th rowspan="2" style="vertical-align:middle"><?= $tambahan?>Keterangan<?= $tambahan?></th>
                    <th rowspan="2" style="vertical-align:middle"><?= $tambahan?>Comment<?= $tambahan?></th>
                </tr>
                <tr>
                    <th>ODM</th>
                    <th>OPM</th>
                    <th>Jual</th>
                    <th>Inv Value</th>
                    <th>Exc Acc</th>
                </tr>
            </thead>
            <tbody>
            <?php $no = 1; foreach ($data as $key => $val) {
                $ksg = '';
                if($ket == 'needpembelian'){ // modal tabel needed PEMBELIAN
                    if ($val['STATUS_REQUEST'] == 'P') { // status pendaftaran baru
                        $beli = '';
                        $buyer = '<select id="buyer'.$no.'" name="buyer[]" class="form-control select2 getBuyer" style="width:200px">
                                    <option></option>
                                </select>';
                        $approve = '<select id="approver'.$no.'" name="approver[]" class="form-control select2 getapprover" style="width:100%">
                                        <option value="'.$val['APPROVER'].'">'.$val['APPROVER'].'</option>
                                    </select>';
                    }else { // status revisi(R) dan inactive(I)
                        $beli = 'readonly';
                        $b = !empty($val['PEMBELIAN']) ? $val['PEMBELIAN'][0]['FULL_NAME'] : '';
                        $a = !empty($val['PEMBELIAN']) ? $val['PEMBELIAN'][0]['ATTRIBUTE18'] : '';
                        $buyer = '<input id="buyer'.$no.'" name="buyer[]" class="form-control" style="width:100%" value="'.$b.'"  readonly>';
                        $approve = '<input id="approver'.$no.'" name="approver[]" class="form-control" style="width:100%" value="'.$a.'"  readonly>';
                    }
                }
            ?>
                <tr>
                    <td><input type="hidden" id="id_request<?= $no?>" name="id_request[]" value="<?= $val['ID_REQUEST']?>"><?= $no?></td>
                    <td><input type="hidden" id="id_item<?= $no?>" name="id_item[]" value="<?= $val['ID_ITEM']?>"><?= $val['STATUS_REQUEST']?></td>
                    <td><input type="hidden" id="item<?= $no?>" name="item[]" value="<?= $val['ITEM_FIX']?>"><?= $val['ITEM_FIX']?></td>
                    <td><input type="hidden" id="desc<?= $no?>" name="desc[]" value="<?= $val['DESC_FIX']?>"><?= $val['DESC_FIX']?></td>
                    <td><?= $val['KODE_UOM']?></td>
                    <td><?= $val['STATUS_REQUEST'] == 'I' ? '-' : $val['DUAL_UOM']?></td>
                    <td><?= $val['STATUS_REQUEST'] == 'I' ? '-' : $val['SECONDARY_UOM']?></td>
                    <td><?= $val['STATUS_REQUEST'] == 'I' ? '-' : $val['MAKE_BUY']?></td>
                    <td><?= $val['STATUS_REQUEST'] == 'I' ? '-' : $val['STOK']?></td>
                    <td><?= $val['STATUS_REQUEST'] == 'I' ? '-' : $val['NO_SERIAL']?></td>
                    <td><?= $val['STATUS_REQUEST'] == 'I' ? '-' : $val['INSPECT_AT_RECEIPT']?></td>
                    <td><?= $val['STATUS_REQUEST'] == 'I' ? '-' : $val['ORG_ASSIGN']?></td>
                    <td><?= $val['ODM'] == 'ODM' ? '<i class="fa fa-check" style="color:green"></i>' : '';?></td>
                    <td><?= $val['OPM'] == 'OPM' ? '<i class="fa fa-check" style="color:green"></i>' : '';?></td>
                    <td><?= $val['JUAL'] == 'JUAL' ? '<i class="fa fa-check" style="color:green"></i>' : '';?></td>
                    <td><?= $val['INV_VALUE']?></td>
                    <td><?= $val['EXP_ACC']?></td>
                    <?php if($ket == 'needpembelian'){ // modal tabel needed PEMBELIAN ?>
                        <td><?= $buyer?></td>
                        <td><input type="number" step="0.01" id="pre_process<?= $no?>" name="pre_process[]" class="form-control" style="width:100%" onchange="perhitunganTotal(<?= $no?>)" value="<?= $val['STATUS_REQUEST'] != 'P' && !empty($val['PEMBELIAN']) ? $val['PEMBELIAN'][0]['PREPROCESSING_LEAD_TIME'] : '' ?>" <?= $beli?>></td>
                        <td><input type="number" step="0.01" id="preparation<?= $no?>" name="preparation[]" class="form-control" style="width:100%" onchange="perhitunganTotal(<?= $no?>)" value="<?= $val['STATUS_REQUEST'] != 'P' && !empty($val['PEMBELIAN']) ? $val['PEMBELIAN'][0]['ATTRIBUTE6'] : '' ?>" <?= $beli?>></td>
                        <td><input type="number" step="0.01" id="delivery<?= $no?>" name="delivery[]" class="form-control" style="width:100%" onchange="perhitunganTotal(<?= $no?>)" value="<?= $val['STATUS_REQUEST'] != 'P' && !empty($val['PEMBELIAN']) ? $val['PEMBELIAN'][0]['ATTRIBUTE8'] : '' ?>" <?= $beli?>></td>
                        <td><input type="hidden" id="total_process<?= $no?>" name="total_process[]" value="<?= $val['STATUS_REQUEST'] != 'P' && !empty($val['PEMBELIAN']) ? $val['PEMBELIAN'][0]['FULL_LEAD_TIME'] : '' ?>" >
                            <span id="ini_total_process<?= $no?>"></span><?= $val['STATUS_REQUEST'] != 'P' && !empty($val['PEMBELIAN']) ? $val['PEMBELIAN'][0]['FULL_LEAD_TIME'] : '' ?>
                        </td>
                        <td><input type="number" step="0.01" id="post_process<?= $no?>" name="post_process[]" class="form-control" style="width:100%" onchange="perhitunganTotal(<?= $no?>)" value="<?= $val['STATUS_REQUEST'] != 'P' && !empty($val['PEMBELIAN']) ? $val['PEMBELIAN'][0]['POSTPROCESSING_LEAD_TIME'] : '' ?>" <?= $beli?>></td>
                        <td><input type="hidden" id="total_lead<?= $no?>" name="total_lead[]" value="<?= $val['STATUS_REQUEST'] != 'P' && !empty($val['PEMBELIAN']) ? $val['PEMBELIAN'][0]['TOTAL_LEADTIME'] : '' ?>" >
                            <span id="ini_total_lead<?= $no?>"></span><?= $val['STATUS_REQUEST'] != 'P' && !empty($val['PEMBELIAN']) ? $val['PEMBELIAN'][0]['TOTAL_LEADTIME'] : '' ?>
                        </td>
                        <td><input id="moq<?= $no?>" name="moq[]" class="form-control" style="width:100%" autocomplete="off" value="<?= $val['STATUS_REQUEST'] != 'P' && !empty($val['PEMBELIAN']) ? $val['PEMBELIAN'][0]['MINIMUM_ORDER_QUANTITY'] : '' ?>" <?= $beli?>></td>
                        <td><input id="flm<?= $no?>" name="flm[]" class="form-control" style="width:100%" autocomplete="off" value="<?= $val['STATUS_REQUEST'] != 'P' && !empty($val['PEMBELIAN']) ? $val['PEMBELIAN'][0]['FIXED_LOT_MULTIPLIER'] : '' ?>" <?= $beli?>></td>
                        <td><?= $approve?></td>
                        <td><input id="ket<?= $no?>" name="ket[]" class="form-control" style="width:100%" autocomplete="off" value="" <?= $beli?>></td>
                        <td><input id="receive_close<?= $no?>" name="receive_close[]" class="form-control" style="width:100%" autocomplete="off" value="<?= $val['STATUS_REQUEST'] != 'P' && !empty($val['PEMBELIAN']) ? $val['PEMBELIAN'][0]['RECEIVE_CLOSE_TOLERANCE'] : '' ?>" <?= $beli?>></td>
                        <td><input id="tolerance<?= $no?>" name="tolerance[]" class="form-control" style="width:100%" autocomplete="off" value="<?= $val['STATUS_REQUEST'] != 'P' && !empty($val['PEMBELIAN']) ? $val['PEMBELIAN'][0]['QTY_RCV_TOLERANCE'] : '' ?>" <?= $beli?>></td>
                        
                    <?php }else{ // modal performed PEMBELIAN ?>
                        <td><?= $val['MAKE_BUY'] == 'MAKE' ? '-' : $val['BUYER']?></td>
                        <td><?= $val['MAKE_BUY'] == 'MAKE' ? '-' : $val['PRE_PROCESSING']?></td>
                        <td><?= $val['MAKE_BUY'] == 'MAKE' ? '-' : $val['PREPARATION_PO']?></td>
                        <td><?= $val['MAKE_BUY'] == 'MAKE' ? '-' : $val['DELIVERY']?></td>
                        <td><?= $val['MAKE_BUY'] == 'MAKE' ? '-' : $val['TOTAL_PROSES']?></td>
                        <td><?= $val['MAKE_BUY'] == 'MAKE' ? '-' : $val['POST_PROCESSING']?></td>
                        <td><?= $val['MAKE_BUY'] == 'MAKE' ? '-' : $val['TOTAL_LEAD_TIME']?></td>
                        <td><?= $val['MAKE_BUY'] == 'MAKE' ? '-' : $val['MOQ']?></td>
                        <td><?= $val['MAKE_BUY'] == 'MAKE' ? '-' : $val['FLM']?></td>
                        <td><?= $val['MAKE_BUY'] == 'MAKE' ? '-' : $val['APPROVER_PO']?></td>
                        <td><?= $val['MAKE_BUY'] == 'MAKE' ? '-' : $val['KET_PEMBELIAN']?></td>
                        <td><?= $val['MAKE_BUY'] == 'MAKE' ? '-' : $val['RECEIVE_CLOSE_TOLERANCE']?></td>
                        <td><?= $val['MAKE_BUY'] == 'MAKE' ? '-' : $val['TOLERANCE']?></td>
                    <?php }?>
                    <td><?= $val['KETERANGAN']?></td>
                    <td><input id="comment<?= $no?>" name="comment[]" class="form-control" style="width:100%" <?= $val['STATUS_REQUEST'] == 'I' && $ket == 'needpembelian' ? 'required' : 'readonly' ?> autocomplete="off"></td>
                </tr>
            <?php $no++; }?>
            </tbody>
        </table>
    </div>
</div>

<div class="panel-body text-center" style="<?php echo $ket == 'needpembelian' && $header['status'] == 'Pengecekan Pembelian' ? '' : 'display:none'?>">
    <button class="btn btn-success" formaction="<?php echo base_url('MasterItemPembelian/Request/submitpembelian')?>"><i class="fa fa-check"></i> Submit</button>
</div>