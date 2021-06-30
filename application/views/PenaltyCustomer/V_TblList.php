<table class="table table-bordered" id="TblListVendorPenalty">
    <thead class="bg-teal">
        <tr>
            <th class="text-center">No</th>
            <th class="text-center">Nama Customer</th>
            <th class="text-center">Cabang</th>
            <th class="text-center">Jumlah Invoice Berpenalty</th>
            <th class="text-center">Total Penalty</th>
            <th class="text-center">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1;
        foreach ($penalty_vendor as $key => $penalty) { ?>
            <tr>
                <td class="text-center"><?= $no ?></td>
                <td class="text-center"><?= $penalty['RELASI_NAME'] ?></td>
                <td class="text-center"><?= $penalty['NAME_OU'] ?></td>
                <td class="text-center"><?= $penalty['TOTAL_INVOICE'] ?></td>
                <td class="text-center">Rp <?= number_format($penalty['TOTAL_SISA_PENALTY'], 0) ?></td>
                <td class="text-center"><a class="btn btn-default" href="<?= base_url('PenaltyCustomer/List/Detail/' . $penalty['RELASI_ID']) ?>">Detail</a></td>
            </tr>
        <?php $no++;
        } ?>
    </tbody>
</table>