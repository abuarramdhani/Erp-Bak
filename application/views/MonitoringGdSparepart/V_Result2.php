<div class="panel-body">
<div class="table-responsive">
    <table class="table table-bordered table-hover table-striped text-center" id="tblMGS" style="width: 100%; table-layout:fixed;">
        <thead class="bg-primary">
            <tr class="text-center">
                <th width="5%">No</th>
                <th>Jenis Dokumen</th>
                <th>No Dokumen</th>
                <th>Tanggal</th>
                <th>Jam Input</th>
                <th>PIC</th>
                <th>Asal</th>
                <th>Keterangan</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        <?php $no=1; foreach ($value as $k => $row) {
            if ($row['header']['statusket'] == "Sudah terlayani") {
                
            }else{ ?>
            <tr class="text-center">
                <td width="5%"><?= $no; ?></td>
                <td><?= $row['header']['JENIS_DOKUMEN'] ?></td>
                <td><?= $row['header']['NO_DOCUMENT'] ?></td>
                <td><?= $row['header']['CREATION_DATE'] ?></td>
                <td><?= $row['header']['JAM_INPUT'] ?></td>
                <td><?= $row['header']['PIC'] ?></td>
                <td><?= $row['header']['gd_asal'] ?></td>
                <td><?= $row['header']['statusket']  ?></td>
                <td><span class="btn btn-success" onclick="addDetailMGS(this, <?= $no ?>)" >Detail</span></td>
            </tr>
            <tr>
                <td></td>
                <td colspan="8" >
                    <div id="detail<?= $no ?>" style="display:none">
                        <table class="table table-bordered table-hover table-striped table-responsive " style="width: 100%; border: 2px solid #ddd;">
                            <thead class="bg-teal">
                                <tr>
                                    <th>No</th>
                                    <th>Item</th>
                                    <th>Deskripsi</th>
                                    <th>Jumlah</th>
                                    <th width="10%">OK</th>
                                    <th width="10%">NOT OK</th>
                                    <th>Keterangan</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php $nomor=1; foreach ($row['body'] as $v) { ?>
                                <tr>
                                    <td><?= $nomor++ ?>
                                        <input type="hidden" name="doc[]" id="doc<?=$no?><?= $nomor ?>" value="<?= $v['NO_DOCUMENT'] ?>"/>
                                        <input type="hidden" name="jenis[]" value="<?= $v['JENIS_DOKUMEN'] ?>"/>
                                        <input type="hidden" name="uom[]" value="<?= $v['UOM'] ?>"/>
                                        <input type="hidden" name="tanggal[]" value="<?= $v['CREATION_DATE'] ?>"/>
                                        <input type="hidden" name="ktrgn[]" value="<?= $row['header']['statusket'] ?>"/>
                                        <input type="hidden" name="gd_asal[]" value="<?= $row['header']['gd_asal'] ?>"/>
                                    </td>
                                    <td style="text-align:left"><input type="hidden" name="item[]" id="item<?=$no?><?= $nomor ?>" value="<?= $v['ITEM'] ?>"/><?= $v['ITEM'] ?></td>
                                    <td style="text-align:left"><input type="hidden" name="nama_brg[]" value="<?= $v['DESCRIPTION'] ?>"/><?= $v['DESCRIPTION'] ?></td>
                                    <td><input type="hidden" name="qty[]" value="<?= $v['QTY'] ?>"/><?= $v['QTY'] ?></td>
                                    <td><input type="text" style="width:100%; text-align:center" name="qty_ok[]" id="jml_ok<?=$no?><?= $nomor ?>" onchange="saveJmlOk(<?=$no?>,<?= $nomor ?>)" value="<?= $v['JML_OK'] ?>" readonly /></td>
                                    <td><input type="text" style="width:100%; text-align:center" name="qty_not[]" id="jml_not_ok<?=$no?><?= $nomor ?>" onchange="saveNotOk(<?=$no?>,<?= $nomor ?>)" value="<?= $v['JML_NOT_OK'] ?>" readonly /></td>
                                    <td style="text-align:left"><input type="text" style="width:100%" name="ketr[]" id="keterangan<?=$no?><?= $nomor ?>" onchange="saveKetr(<?=$no?>,<?= $nomor ?>)" value="<?= $v['KETERANGAN'] ?>" readonly /></td>
                                    <td style="text-align:left"><input type="text" style="width:100%" name="action[]" id="action<?=$no?><?= $nomor ?>" onchange="saveAction(<?=$no?>,<?= $nomor ?>)" value="<?= $v['ACTION'] ?>" readonly /></td>
                                <?php } ?>
                            </tbody>                                        
                        </table>
                    </div>
                </td>
            </tr>
            <?php $no++;} }?>
        </tbody>
    </table>
</div>
</div>


