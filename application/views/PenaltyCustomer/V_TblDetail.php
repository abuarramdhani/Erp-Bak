<div class="panel-body">
    <div class="col-md-2"><Label>Nama Customer</Label></div>
    <div class="col-md-9">: <?= $penalty_detail[0]['RELASI_NAME'] ?></div>
</div>
<div class="panel-body">
    <div class="col-md-2"><Label>Cabang</Label></div>
    <div class="col-md-9">: <?= $penalty_detail[0]['NAME_OU'] ?></div>
    <input type="hidden" id="organis_id" value="<?= $penalty_detail[0]['ORG_ID'] ?>">
</div>
<div class="panel-body">
    <div class="col-md-2"><Label>Total Penalty</Label></div>
    <div class="col-md-9">: Rp <?= number_format($total_penalty, 0) ?></div>
</div>
<div class="panel-body">
    <div class="col-md-2"><Label>Daftar Invoice :</Label></div>
</div>
<div class="panel-body">
    <table class="table table-bordered" id="TblListDetailPenalty">
        <thead class="bg-teal">
            <tr>
                <th class="text-center"><input type="checkbox" class="checksemuapenalty"></th>
                <th class="text-center">Invoice Number</th>
                <th class="text-center">Nominal Invoice</th>
                <th class="text-center">Nominal Penalty</th>
                <th class="text-center">Pembayaran Penalty</th>
                <th class="text-center">Sisa Penalty</th>
                <th class="text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1;
            foreach ($penalty_detail as $key => $penalty) { ?>
                <tr>
                    <td class="text-center"><input type="checkbox" class="checkpenalty" data-row="<?= $no ?>"></td>
                    <td class="text-center"><?= $penalty['INVOICE_NUMBER'] ?></td>
                    <td class="text-center">Rp <?= number_format($penalty['NOMINAL_INVOICE'], 0) ?></td>
                    <td class="text-center">Rp <?= number_format($penalty['NOMINAL_PENALTY'], 0) ?></td>
                    <td class="text-center">Rp <?= number_format($penalty['TOTAL_PEMBAYARAN'], 0) ?></td>
                    <input type="hidden" class="total_byr_penalty" data-row="<?= $no ?>" id="total_byr_penalty<?= $no ?>" value="<?= $penalty['NOMINAL_PENALTY'] ?>">
                    <input type="hidden" class="org_id_penalty" data-row="<?= $no ?>" id="org_id_penalty<?= $no ?>" value="<?= $penalty['ORG_ID'] ?>">
                    <input type="hidden" class="invoice_num_penalty" data-row="<?= $no ?>" id="invoice_num_penalty<?= $no ?>" value="<?= $penalty['INVOICE_NUMBER'] ?>">

                    <td class="text-center">Rp <?= number_format($penalty['SISA_PENALTY'], 0) ?></td>
                    <td class="text-center">
                        <buttton class="btn btn-default" onclick="ModalCreateSingle(<?= $no ?>)">Create Single Misc. Recipt</button>
                    </td>
                </tr>
            <?php $no++;
            } ?>
        </tbody>
    </table>
</div>
<div class="panel-body">
    <div class="col-md-4">
        <select id="SlcCreateMultipleMiscRecipt" data-placeholder="Select" style="width: 100%;">
            <option></option>
            <option value="CreateMultipleMiscRecipt">Create Multiple Misc. Recipt</option>
        </select>
    </div>
    <div class="col-md-2">
        <button class="btn btn-success" onclick="ModalCreateMultiple()">Proses</button>
    </div>
</div>