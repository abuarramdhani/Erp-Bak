<?php
// echo "<pre>";
// print_r($no_awal);
// exit();
?>

<?php if ($ket == 'baru') { ?>
<form action="<?php echo base_url('CetakKartuBody/Cetak/generate'); ?>" method="post" target="_blank">
<div id="tablebaru">
    <table class="table" style="width: 100%;table-layout:fixed">
        <tbody>
            <tr>
                <th width="25%" style="padding-left:15px">No Serial terakhir telah cetak</th>
                <th width="1%">:</th>
                <th><input type="hidden" name="qty" value="<?= $qty?>"><?= $tercetak ?></th>
            </tr>
            <tr>
                <th style="padding-left:15px">No Serial yang akan dicetak</th>
                <th>:</th>
                <th><?= $no_awal ?> - <?= $no_akhir?>
                    <input type="hidden" name="no_awal" value="<?= $no_awal?>">
                    <input type="hidden" name="no_akhir" value="<?= $no_akhir?>">
                    <input type="hidden" name="size" value="<?= $size?>">
                </th>
            </tr>
            <tr>
                <th style="padding-left:15px">Komponen</th>
                <th>:</th>
                <th><input type="hidden" name="komponen" value="<?= $komponen?>"><?= $komponen ?></th>
            </tr>
        </tbody>
    </table>
<button type="submit" class="btn btn-primary" style="margin-left:15px">Generate</button>
</div>
</form>
<?php }else { ?>
<div id="tablelagi">
    <table class="table table-striped table-bordered table-responsive table-hover text-center" style="width: 100%">
    <thead class="bg-primary">
    <tr>
        <th>No</th>
        <th>No Serial</th>
        <th>Nama Komponen</th>
        <th>Jumlah</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
    <?php $no = 1;
    if ($data == '') {
    }else{
    foreach ($data as $val) {?>
        <tr>
            <td><?= $no?>
            <input type="hidden" id="awal<?= $no?>" value="<?= $val['awal']?>">
            <input type="hidden" id="akhir<?= $no?>" value="<?= $val['akhir']?>">
            <input type="hidden" id="komponen<?= $no?>" value="<?= $val['item']?>">
            <input type="hidden" id="size<?= $no?>" value="<?= $val['size']?>">
            <input type="hidden" id="qty<?= $no?>" value="<?= $val['jumlah']?>"></td>
            <td><?= $val['no_awal'] ?> - <?= $val['no_akhir']?></td>
            <td><?= $val['item'] ?></td>
            <td><?= $val['jumlah']?></td>
            <td>
            <a target="_blank" href="http://produksi.quick.com/cetak-kartu-body/kartubody.php?serial1=<?= $val['awal']?>&serial2=<?= $val['akhir']?>&produk=<?= $val['item']?>&size=<?= $val['size']?>" >
                <button type="button" class="btn btn-xs btn-info" style="margin-left:15px" onclick="generateLagi(<?= $no?>)">Generate</button>
            </a>
            </td>
        </tr>
    <?php } $no++; }?>
    </tbody>
</table>
</div>
<br>
<?php }?>