<table class="table table-bordered" id="list_SPB" style="width: 100%;">
    <thead class="bg-teal">
        <tr>
            <th class="text-center">No</th>
            <th class="text-center">Nomor SPB</th>
            <th class="text-center">Creation Date</th>
            <th class="text-center">Nomor SO</th>
            <th class="text-center">Transact Status</th>
            <th class="text-center">Interorg Status</th>
            <th class="text-center">IO Tujuan</th>
            <th class="text-center">Receipt Date</th>
            <th class="text-center">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php $i = 1;
        foreach ($header as $v) { ?>
            <tr>
                <td class="text-center"><?= $i ?></td>
                <td class="text-center"><?= $v['NO_SPB'] ?></td>
                <input type="hidden" id="no_spb<?= $i ?>" value="<?= $v['NO_SPB'] ?>">
                <td class="text-center"><?= $v['CREATION_DATE'] ?></td>
                <td class="text-center"><?= $v['NO_SO'] ?></td>
                <td class="text-center"><?= $v['TRANSACT_STATUS'] ?></td>
                <td class="text-center"><?= $v['INTERORG_STATUS'] ?></td>
                <td class="text-center"><?= $v['IO_TUJUAN'] ?></td>
                <td class="text-center"><?= $v['TANGGAL_RECEIPT'] ?></td>
                <td class="text-center"><button class="btn btn-sm btn-default" onclick="DetailSPB(<?= $i ?>)">Detail</button></td>
            </tr>
        <?php $i++;
        } ?>
    </tbody>
</table>