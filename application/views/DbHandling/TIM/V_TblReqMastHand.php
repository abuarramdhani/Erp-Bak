<?php if ($req != null) { ?>
    <table class="table table-bordered">
        <thead class="bg-teal">
            <tr>
                <th class="text-center">No</th>
                <th class="text-center">Kode Handling</th>
                <th class="text-center">Nama handling</th>
                <th class="text-center">Tgl Request</th>
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
                    <td class="text-center"><?= $r['tgl_request'] ?></td>
                    <td class="text-center"><button onclick="accreqmasthand(<?= $r['id'] ?>)" class="btn btn-sm btn-success">Acc</button> <button onclick="rejectreqmasthand(<?= $r['id'] ?>)" class="btn btn-sm btn-danger">Reject</button></td>
                </tr>
            <?php $no++;
            } ?>
        </tbody>
    </table>
<?php } else { ?>
    <div class="col-md-12" style="text-align: center;">
        <h4>Tidak Ada Request</h4>
    </div>
<?php } ?>