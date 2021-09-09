<table class="table table-bordered" id="tbl_simulasi">
    <thead class="bg-teal">
        <tr>
            <th class="text-center" rowspan="2">Kapasitas Muat</th>
            <th class="text-center" rowspan="2">Jenis</th>
            <th class="text-center" colspan="3">
                Kendaraan : <?= $simulasi[0]['kendaraan'] ?>
                <br>
                Presentase :
                <span id="percent_muatan_kendaraan">0</span>%
                <input type="hidden" id="percent_muatan_kendaraan_hide" value="0">
            </th>
        </tr>
        <tr>
            <th class="text-center">Body</th>
            <th class="text-center">Kopel</th>
            <th class="text-center">Peti</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($simulasi as $key => $simul) { ?>
            <tr>
                <td><b><?= $simul['item'] ?></b></td>
                <td><b><?= $simul['jenis'] ?></b></td>
                <?php foreach ($simul['muatan'] as $keys => $muatan) {
                    if ($muatan['JENIS_MUATAN'] == 'disable') {
                        $disabled = 'disabled="disabled"';
                    } else {
                        $disabled = '';
                    } ?>
                    <td>
                        <input type="number" name="jumlah_muatan_sims" <?= $disabled ?> id="jumlah_muatan_sims<?= $key . $keys ?>" onkeyup="HitungPresentase()" class="form-control">
                        <input type="hidden" id="last_val_muatan_sims<?= $key . $keys ?>" value="0">
                        <input type="hidden" name="percent_muatan_sims" id="percent_muatan_sims<?= $key . $keys ?>" value="<?= $muatan['PROSENTASE'] ?>">
                    </td>
                <?php } ?>
            </tr>
        <?php } ?>
    </tbody>
</table>