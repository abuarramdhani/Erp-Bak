<?php
if ($ket == 'MIN') {
    $tanda = 1;
    $warna = '#F6D673';
    $judul = 'A - P';
}elseif ($ket == 'PLMIN') {
    $tanda = 2;
    $warna = '#FFB670';
    $judul = 'PL - P';
}else {
    $tanda = 3;
    $warna = '#F5817F';
    $judul = 'C - P';
}
if (!empty($comment)) {
    $komen = $comment[0]['KETERANGAN'];
    $save = 'style="display:none"';
    $edit = '';
    $diss = 'disabled';
}else {
    $komen = $save = $diss = '';
    $edit = 'style="display:none"';
}
?>
<div class="modal-header" style="font-size:25px;background-color:<?= $warna?>">
    <i class="fa fa-list-alt"></i> Comment <?= $judul?>
    <button type="button" class="close" data-dismiss="modal">&times;</button>
</div>
<div class="modal-body">
    <div class="panel-body">
        <input type="hidden" id="kategori" value="<?= $kategori?>">
        <input type="hidden" id="bulanmin" value="<?= $bulan2?>">
        <input type="hidden" id="inv" value="<?= $inv?>">
        <input type="hidden" id="tgl" value="<?= $tgl?>">
        <div class="col-md-2" style="font-weight:bold">Kode</div>
        <div class="col-md-10">: <?= $item?></div>
        <div class="col-md-2" style="font-weight:bold">Deskripsi</div>
        <div class="col-md-10">: <?= $desc?></div>
        <div class="col-md-2" style="font-weight:bold">Tanggal</div>
        <div class="col-md-10">: <?= $tgl?>/<?= $bulan?></div>
    </div>
    <div class="panel-body">
        <div class="input-group">
            <!-- <input name="comment" id="comment" class="form-control" value="<?= $komen?>" placeholder="comment..." <?= $diss?> autocomplete="off"> -->
            <textarea name="comment" id="comment" style="width:450px;height:120px" <?= $diss?>><?= $komen?></textarea>
            <span class="input-group-btn">
                <button type="button" id="editcommentmin" class="btn bg-orange" onclick="editcomment()" <?= $edit?>><i class="fa fa-pencil"></i> Edit</button>
                <button type="button" id="savecommentmin" class="btn btn-danger" onclick="saveCommentmin(<?= $tanda?>)" <?= $save?>><i class="fa fa-save"></i> Save</button>
            </span>
        </div>
    </div>
</div>