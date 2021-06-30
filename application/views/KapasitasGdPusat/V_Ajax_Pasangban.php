<table class="table text-center">
    <thead>
        <tr>
            <th colspan="3"><?= $title?></th>
        <tr>
        <tr>
            <th>No Induk</th>
            <th>Nama</th>
            <th></th>
        <tr>
    </thead>
    <tbody id="<?= $ket?>_<?= $ket2?>">
    <?php if (!empty($getpasang)) { ?>
        <?php foreach ($getpasang as $i) { ?>
        <tr>
            <td><input id="no_induk" name="no_induk_<?= $ket?>[]" class="form-control no_induk_<?= $ket?>" style="width:150px" value="<?= $i['NO_INDUK']?>"></td>
            <td><input id="nama" name="nama_<?= $ket?>[]" class="form-control nama_<?= $ket?>" style="width:200px" readonly value="<?= $i['NAMA']?>"></td>
            <td><button type="button" onclick="add_new_line('<?= $ket?>', '<?= $ket2?>', '<?= $warna?>')" class="btn btn-<?= $warna?>"> <i class="fa fa-plus"></i></button></td>
        </tr>
        <?php }?>
    <?php }else{?>
        <tr>
            <td><select id="no_induk" name="no_induk_<?= $ket?>[]" class="form-control no_induk_<?= $ket?> select2 getPICBan" style="width:150px" ></select></td>
            <td><input id="nama" name="nama_<?= $ket?>[]" class="form-control nama_<?= $ket?>" style="width:200px" readonly></td>
            <td><button type="button" onclick="add_new_line('<?= $ket?>', '<?= $ket2?>', '<?= $warna?>')" class="btn btn-<?= $warna?>"> <i class="fa fa-plus"></i></button></td>
        </tr>
    <?php }?>
    <tbody>
    <tfoot>
        <tr>
            <th colspan="3">
            <?php if (!empty($getmulai)) { ?>
                <?php foreach ($getmulai as $i) { ?>
                    <p id="timer_<?= $ket?>" style="">
                        Mulai <?= $i['JAM_MULAI'] ?>
                    </p>
                <?php }?>
                <input type="button" class="btn btn-lg btn-danger" id="button_selesai_<?= $ket?>" value="Selesai" onclick="pasangban_timer('<?= $ket?>', 'selesai')">
            <?php }else{?>
                <p id="timer_<?= $ket?>" style="">
                    <label id="hours_<?= $ket?>" >00</label>:<label id="minutes_<?= $ket?>">00</label>:<label id="seconds_<?= $ket?>">00</label>
                </p>
                <input type="button" class="btn btn-lg btn-warning" id="button_mulai_<?= $ket?>" value="Mulai" onclick="pasangban_timer('<?= $ket?>', 'mulai')">
                <input type="button" class="btn btn-lg btn-danger" id="button_selesai_<?= $ket?>" style="display:none"  value="Selesai" onclick="pasangban_timer('<?= $ket?>', 'selesai')">
            <?php }?>
                <!-- <p id="timer_<?= $ket?>" style="">
                    <label id="hours_<?= $ket?>" >00</label>:<label id="minutes_<?= $ket?>">00</label>:<label id="seconds_<?= $ket?>">00</label>
                    <input type="hidden" id="jam_<?= $ket?>" value="00">
                    <input type="hidden" id="menit_<?= $ket?>" value="00">
                    <input type="hidden" id="detik_<?= $ket?>" value="00">
                    <input type="hidden" id="aktual_<?= $ket?>">
                </p>
                <input type="button" class="btn btn-lg btn-warning" id="button_mulai_<?= $ket?>" value="Mulai" onclick="pasangban_timer('<?= $ket?>', 'mulai')">
                <input type="button" class="btn btn-lg btn-danger" id="button_selesai_<?= $ket?>" style="display:none"  value="Selesai" onclick="pasangban_timer('<?= $ket?>', 'selesai')"> -->
            </th>
        <tr>
    </tfoot>
</table>