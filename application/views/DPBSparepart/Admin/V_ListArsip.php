<div class="table-responsive">
    <table class="datatable table table-bordered table-hover table-striped text-center tblarsipdpb" style="width: 100%;">
        <thead class="bg-primary">
            <tr>
                <th>No</th>
                <th>Tanggal Dibuat</th>
                <th>Tanggal Input</th>
                <th>Jenis Dokumen</th>
                <th>No Dokumen</th>
                <th>Jumlah Item</th>
                <th>Jumlah Pcs</th>
                <th>Mulai Pelayanan</th>
                <th>Selesai Pelayanan</th>
                <th>Waktu Pelayanan</th>
                <th>PIC Pelayanan</th>
                <th>Mulai Pengecekan</th>
                <th>Selesai Pengecekan</th>
                <th>Waktu Pengecekan</th>
                <th>PIC Pengecekan</th>
                <th>Mulai Packing</th>
                <th>Selesai Packing</th>
                <th>Waktu Packing</th>
                <th>PIC Packing</th>
                <th>Keterangan</th>
                <th>Tanggal Cancel</th>
                <th>Jumlah Coly</th>
                <th>Berat</th>
                <th>Total Waktu Proses</th>
                <th>Ekspedisi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1;
            foreach ($getdata as $val) { ?>
                <tr>
                    <td class="text-center"><?= $no ?></td>
                    <td class="text-center"><?= $val['TGL_DIBUAT'] ?></td>
                    <td class="text-center"><?= $val['JAM_INPUT'] ?></td>
                    <td class="text-center"><?= $val['JENIS_DOKUMEN'] ?></td>
                    <td class="text-center"><?= $val['NO_DOKUMEN'] ?></td>
                    <td class="text-center"><?= $val['JUMLAH_ITEM'] ?></td>
                    <td class="text-center"><?= $val['JUMLAH_PCS'] ?></td>
                    <td class="text-center"><?= $val['MULAI_PELAYANAN'] ?></td>
                    <td class="text-center"><?= $val['SELESAI_PELAYANAN'] ?></td>
                    <td class="text-center"><?= $val['WAKTU_PELAYANAN'] ?></td>
                    <td class="text-center"><?= $val['PIC_PELAYAN'] ?></td>
                    <td class="text-center"><?= $val['MULAI_PENGELUARAN'] ?></td>
                    <td class="text-center"><?= $val['SELESAI_PENGELUARAN'] ?></td>
                    <td class="text-center"><?= $val['WAKTU_PENGELUARAN'] ?></td>
                    <td class="text-center"><?= $val['PIC_PENGELUARAN'] ?></td>
                    <td class="text-center"><?= $val['MULAI_PACKING'] ?></td>
                    <td class="text-center"><?= $val['SELESAI_PACKING'] ?></td>
                    <td class="text-center"><?= $val['WAKTU_PACKING'] ?></td>
                    <td class="text-center"><?= $val['PIC_PACKING'] ?></td>
                    <td class="text-center"><?= $val['URGENT'] . ' ' . $val['BON'] ?></td>
                    <td class="text-center"><?= $val['CANCEL'] ?></td>
                    <td class="text-center"><?= $val['COLY'] ?></td>
                    <td class="text-center"><?= $val['BERAT'] ?></td>
                    <td class="text-center"><?= $val['TOTAL_WAKTU_PROSES'] ?> Hari</td>
                    <td class="text-center"><?= $val['EKSPEDISI'] ?></td>
                </tr>
            <?php $no++;
            } ?>
        </tbody>
    </table>
</div>