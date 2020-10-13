<table class="table table-bordered">
    <thead class="bg-teal">
        <tr>
            <th class="text-center">No</th>
            <th class="text-center">Kode Handling</th>
            <th class="text-center">Nama handling</th>
            <th class="text-center">Tgl Request</th>
            <th class="text-center">Status</th>
            <th class="text-center">Tanggal Acc</th>
            <th class="text-center">Action</th>

        </tr>
    </thead>
    <tbody>
        <?php $no = 1;
        foreach ($req as $key => $r) { ?>
            <tr>
                <td class="text-center"><?= $no ?></td>
                <td class="text-center"><?= $r['kode'] ?></td>
                <td class="text-center"><?= $r['nama'] ?></td>
                <td class="text-center"><?= date('d-M-Y', strtotime($r['tgl_request']))  ?></td>
                <?php if ($r['status'] == 0) {
                    $status = 'Belum di Acc oleh Tim Handling';
                } else if ($r['status'] == 1) {
                    $status = 'Sudah Di Acc Oleh Tim Handling';
                } else {
                    $status = 'Di Reject Oleh Tim Handling';
                } ?>
                <td class="text-center"><?= $status ?></td>
                <?php if ($r['tgl_acc'] == null) {
                    $tgl_acc = '-';
                } else {
                    $tgl_acc = date('d-M-Y', strtotime($r['tgl_acc']));
                } ?>
                <td class="text-center"><?= $tgl_acc ?></td>
                <td class="text-center"><button onclick="deletereqmashand(<?= $r['id'] ?>)" class="btn btn-danger btn-sm">Delete</button></td>
            </tr>
        <?php $no++;
        } ?>
    </tbody>
</table>