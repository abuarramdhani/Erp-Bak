<form name="Orderform" class="form-horizontal" onsubmit="return validasi();window.location.reload();" method="post">
    <?php if ($handling != null) { ?>
        <table class="table table-bordered">
            <thead class="bg-teal">
                <tr>
                    <th class="text-center">No</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Pengorder</th>
                    <th class="text-center">Seksi</th>
                    <th class="text-center">Nama Dokumen</th>
                    <th class="text-center">Produk</th>
                    <th class="text-center">Sarana Handling</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $n = 1;
                foreach ($handling as $hand) { ?>
                    <tr>
                        <td class="text-center"><?= $n ?></td>
                        <td class="text-center"><?= $hand['status'] ?></td>
                        <td class="text-center"><?= $hand['requester'] ?></td>
                        <td class="text-center"><?= $hand['seksi'] ?></td>
                        <td class="text-center"><?= $hand['nama_komponen'] ?></td>
                        <td class="text-center"><?= $hand['kode_produk'] ?> - <?= $hand['nama_produk'] ?></td>
                        <?php if ($hand['sarana']  == 'Invalid') {
                            $color = 'red';
                            $bold = 'bold';
                        } else {
                            $color = '';
                            $bold = '';
                        } ?>
                        <td class="text-center" style="color: <?= $color ?>;font-weight:<?= $bold ?>;"><?= $hand['sarana'] ?></td>
                        <td class="text-center"><button class="btn btn-default" formaction="<?php echo base_url('DbHandlingSeksi/MonitoringHandling/detaildatahandling/' . $hand['id_handling']); ?>">Detail</button></td>
                    </tr>
                <?php $n++;
                } ?>
            </tbody>
        </table>
    <?php } else { ?>
        <h4 style="font-weight : bold;text-align:center">Tidak Ada Request</h4>
    <?php } ?>
</form>