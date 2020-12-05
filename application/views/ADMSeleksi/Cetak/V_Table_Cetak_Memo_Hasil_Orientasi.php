<?php foreach ($getDaftarMemo as $data) : ?>
    <tr id="<?= $data['kdmemo'] ?>" title="Double klik" style="color:<?= ($data['cetak'] == 't') ? "#008000" :  "#000"  ?> ;">
        <td><?= $data['nosurat'] ?></td>
        <td><?= $data['hal'] ?></td>
        <td><?= $data['tanggal'] ?></td>
        <td><?= $data['periode'] ?></td>
        <td><?= $data['seksitujuan'] ?></td>
        <td class="hidden"><?= $data['kdmemo'] ?></td>
    </tr>
<?php endforeach ?>