<script>
$(document).ready(function () {
    $('#tbltimkode').DataTable({
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
    <?php $tbl = count($data) > 10 ? 'tbltimkode' : 'tbldetail';
        $tambahan = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';?>
        <table class="table table-bordered table-hover table-striped text-center" id="<?= $tbl?>" style="width: 100%;">
            <thead style="background-color:#49D3F5">
                <tr>
                    <th rowspan="2" style="vertical-align:middle">No</th>
                    <th rowspan="2" style="vertical-align:middle">Status</th>
                    <th colspan="<?= $ket == 'needed' ? 3 : 2 ?>" style="vertical-align:middle;">Item</th>
                    <th colspan="<?= $ket == 'needed' ? 3 : 2 ?>" style="vertical-align:middle;">Deskripsi Item</th>
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
                </tr>
                <tr>
                    <th class="text-nowrap"><?= $tambahan?>Kode Item<?= $tambahan?></th>
                    <th class="text-nowrap"><?= $tambahan?>Revisi Item<?= $tambahan?></th>
                    <?= $ket == 'needed' ? '<th>Revisi</th>' : ''; ?>
                    <th class="text-nowrap"><?= $tambahan?>Deskripsi<?= $tambahan?></th>
                    <th class="text-nowrap"><?= $tambahan?>Revisi Deskripsi<?= $tambahan?></th>
                    <?= $ket == 'needed' ? '<th>Revisi</th>' : ''; ?>
                    <th>ODM</th>
                    <th>OPM</th>
                    <th>Jual</th>
                    <th>Inv Value</th>
                    <th>Exc Acc</th>
                </tr>
            </thead>
            <tbody>
            <?php $no = 1; foreach ($data as $key => $val) {?>
                <tr>
                    <td><input type="hidden" id="id_item<?= $no?>" name="id_item[]" value="<?= $val['ID_ITEM']?>"><?= $no?></td>
                    <td><input type="hidden" id="status<?= $no?>" name="status[]" value="<?= $val['STATUS_REQUEST']?>"><?= $val['STATUS_REQUEST']?></td>
                    <td><input type="hidden" id="kode_item<?= $no?>" name="kode_item[]" value="<?= $val['KODE_ITEM']?>"><?= $val['KODE_ITEM']?></td>
                    <td class="bg-success">
                        <?php if ($ket == 'needed') { //tempat taruh revisi kode item tabel needed tim kode barang ?>
                            <span id="ini_kode<?= $no?>"></span>
                            <input type="hidden" id="revisi_kode<?= $no?>" name="revisi_kode[]" value="-">
                        <?php }else { // modal performed tim kode barang
                            echo $val['ITEM'];
                        }?>
                    </td>
                    <?php if ($ket == 'needed') { //kolom tambahan utk button revisi kode barang tabel needed ?>
                        <td class="bg-success">
                            <?php if ($val['STATUS_REQUEST'] == 'P') {// button ada kalau statusnya P/pendaftaran baru ?>
                                <button id="btnrev_kode<?= $no?>" type="button" class="btn btn-xs btn-info" onclick="revisiTKB(<?= $no?>)">Revisi</button>
                            <?php }?>
                        </td>
                    <?php }?>
                    <td><input type="hidden" id="desc_item<?= $no?>" name="desc_item[]" value="<?= $val['DESKRIPSI']?>"><?= $val['DESKRIPSI']?></td>
                    <td style="background-color:#F0CA97">
                        <?php if ($ket == 'needed') { ?>
                            <span id="ini_desc<?= $no?>"></span>
                            <input type="hidden" id="revisi_desc<?= $no?>" name="revisi_desc[]" value="-">
                        <?php }else {
                            echo $val['DESC'];
                        }?>
                    </td>
                    <?php if ($ket == 'needed') { // kolom tambahan utk button revisi deskripsi tabel needed ?>
                        <td style="background-color:#F0CA97">
                            <?php if ($val['STATUS_REQUEST'] == 'P') { // button ada kalau statusnya P/pendaftaran baru ?>
                                <button id="btnrev_desc<?= $no?>" type="button" class="btn btn-xs btn-info" onclick="revisiTKB2(<?= $no?>)">Revisi</button>
                            <?php }?>
                        </td>
                    <?php }?>
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
                    <td><?= $val['KETERANGAN']?></td>
                </tr>
            <?php $no++; }?>
            </tbody>
        </table>
    </div>
</div>
<div class="panel-body text-center" style="<?= $header['status'] == 'Pengecekan Tim Kode Barang' ? '' : 'display:none'; ?>">
    <button class="btn btn-success" formaction="<?php echo base_url('MasterItemTimKode/Request/submitTimKode')?>"><i class="fa fa-check"></i> Submit</button>
</div>