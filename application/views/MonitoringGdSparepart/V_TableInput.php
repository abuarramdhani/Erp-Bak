<?php 
date_default_timezone_set('Asia/Jakarta');
$no=1; foreach ($input as $i) { ?>
<tr id="addRow<?=$no?>">
    <td width="5%"><?= $no; ?></td>
    <input type="hidden" name="no_document[]" value="<?= $i['NO_INTERORG'] ?>"/>
    <input type="hidden" name="jenis_dokumen[]" value="<?= $i['JENIS_DOKUMEN'] ?>"/>
    <input type="hidden" name="creation_date[]" value="<?= $tanggal = date("Y/m/d H:i:s"); ;?>"/>
    <td style="width:15%; text-align:left;"><input type="hidden" name="item[]" value="<?= $i['ITEM'] ?>"/><?= $i['ITEM'] ?> </td>
    <td style="width:50%; text-align:left;"><input type="hidden" name="desc[]" value="<?= $i['DESCRIPTION'] ?>"/><?= $i['DESCRIPTION'] ?></td>
    <td><input type="hidden" name="qty[]" value="<?= $i['QTY'] ?>"/><?= $i['QTY'] ?></td>
    <td><input type="hidden" name="uom[]" value="<?= $i['UOM'] ?>"/><?= $i['UOM'] ?></td>
    <td><input type="hidden" name="status[]" value="OK"/>OK</td>
    <input type="hidden" name="subinv[]" value="<?= $i['SUBINV'] ?>"/>
</tr>

<?php $no++;} ?>
