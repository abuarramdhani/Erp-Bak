<div class="panel-body">
    <div class="col-md-12">
        <table class="table table-bordered" id="tbl_do_on_process">
            <thead class="bg-teal">
                <tr>
                    <th class="text-center">NO</th>
                    <th class="text-center">NO DO</th>
                    <th class="text-center">SO NUMBER</th>
                    <th class="text-center">OU</th>
                    <th class="text-center">ACTION</th>
                </tr>
            </thead>
            <tbody>
                <?php $angka = 1;
                foreach ($DoProcess as $key => $red) { ?>
                    <tr>
                        <td class="text-center"><?= $angka ?></td>
                        <td class="text-center"><?= $red['NO_DO'] ?></td>
                        <td class="text-center"><?= $red['SO_NUMBER'] ?></td>
                        <td class="text-center"><?= $red['OU'] ?></td>
                        <td class="text-center"><button class="btn btn-default btn-sm" onclick="DetDo(<?= $red['NO_DO'] ?>)">Detail</button></td>
                    </tr>
                <?php $angka++;
                } ?>
            </tbody>
        </table>
    </div>
</div>