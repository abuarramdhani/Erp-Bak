<form name="Orderform" class="form-horizontal" onsubmit="return validasi();window.location.reload();" method="post">

    <table class="table table-bordered">
        <thead class="bg-primary">
            <tr>
                <th class="text-center">No</th>
                <th class="text-center">Nama Dokumen</th>
                <th class="text-center">Rev No</th>
                <th class="text-center">No Dokumen</th>
                <th class="text-center">Produk</th>
                <th class="text-center">Sarana Handling</th>
                <th class="text-center">Seksi</th>
                <th class="text-center">View</th>
                <th class="text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php $r = 1;
            foreach ($datahandling as $handling) { ?>
                <tr>
                    <input type="hidden" id="prosesHand<?= $handling['id_handling'] ?>" value="<?= $handling['proses'] ?>">
                    <td class="text-center"><?= $r ?></td>
                    <td class="text-center"><?= $handling['nama_komponen'] ?></td>
                    <td class="text-center"><?= $handling['rev_no'] ?></td>
                    <td class="text-center"><?= $handling['doc_number'] ?></td>
                    <td class="text-center"><?= $handling['kode_produk'] ?> - <?= $handling['nama_produk'] ?></td>
                    <?php if ($handling['sarana']  == 'Invalid') {
                        $color = 'red';
                        $bold = 'bold';
                    } else {
                        $color = '';
                        $bold = '';
                    } ?>
                    <td class="text-center" style="color: <?= $color ?>;font-weight:<?= $bold ?>;"><?= $handling['sarana'] ?></td>
                    <td class="text-center"><?= $handling['seksi'] ?></td>
                    <td class="text-center"><a class="btn btn-default" onclick="slideshow(<?= $handling['id_handling'] ?>)">Foto</a> <a class="btn btn-danger" onclick="showproses(<?= $handling['id_handling'] ?>)">Proses</a></td>
                    <td class="text-center"><button class="btn btn-default" formaction="<?php echo base_url('DbHandlingSeksi/MonitoringHandling/detaildatahandling/' . $handling['id_handling']); ?>">Detail</button></td>
                </tr>
            <?php $r++;
            } ?>
        </tbody>
    </table>
</form>