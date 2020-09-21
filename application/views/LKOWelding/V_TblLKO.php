<div class="col-md-12" style="margin-top: 10px;">
    <table class="table table-bordered" id="tbl_hasil_lko" style="font-size: 9pt">
        <thead class="bg-teal">
            <tr>
                <th class="text-center bg-teal" rowspan="2" style="vertical-align: middle;font-size: 8pt">NO</th>
                <th class="text-center bg-teal" rowspan="2" style="vertical-align: middle;font-size: 8pt">NO INDUK</th>
                <th class="text-center bg-teal" rowspan="2" style="vertical-align: middle;font-size: 8pt;width:200px">NAMA PEKERJA</th>
                <th class="text-center" rowspan="2" style="vertical-align: middle;font-size: 8pt;width:200px">URAIAN PEKERJAAN</th>
                <th class="text-center" colspan="3">PENCAPAIAN</th>
                <th class="text-center" rowspan="2" style="vertical-align: middle;font-size: 8pt">SHIFT</th>
                <th class="text-center" rowspan="2" style="vertical-align: middle;font-size: 8pt">KET</th>
                <th class="text-center" style="vertical-align: middle;font-size: 8pt" colspan="8">KONDITE</th>
                <!-- <th class="text-center" style="vertical-align: middle;font-size: 8pt" rowspan="2">ACTION</th> -->
            </tr>
            <tr>
                <th class="text-center" style="font-size: 8pt;">TGT</th>
                <th class="text-center" style="font-size: 8pt;">ACT</th>
                <th class="text-center" style="font-size: 8pt;">%</th>
                <th class="text-center" style="font-size: 8pt;">MK</th>
                <th class="text-center" style="font-size: 8pt;">I</th>
                <th class="text-center" style="font-size: 8pt;">BK</th>
                <th class="text-center" style="font-size: 8pt;">TKP</th>
                <th class="text-center" style="font-size: 8pt;">KP</th>
                <th class="text-center" style="font-size: 8pt;">KS</th>
                <th class="text-center" style="font-size: 8pt;">KK</th>
                <th class="text-center" style="font-size: 8pt;">PK</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1;
            foreach ($lko as $key => $lk) { ?>
                <tr>
                    <td class="text-center"><?= $no ?></td>
                    <td class="text-center"><?= $lk['NO_INDUK'] ?></td>
                    <td class="text-center"><?= $lk['NAMA_PEKERJA'] ?></td>
                    <td class="text-center"><?= $lk['URAIAN_PEKERJAAN'] ?></td>
                    <td class="text-center"><?= $lk['PENCAPAIAN_TGT'] ?></td>
                    <td class="text-center"><?= $lk['PENCAPAIAN_ACT'] ?></td>
                    <td class="text-center"><?= $lk['PENCAPAIAN_PERSEN'] ?></td>
                    <td class="text-center"><?= $lk['SHIFT'] ?></td>
                    <td class="text-center"><?= $lk['KETERANGAN'] ?></td>
                    <td class="text-center"><?= $lk['KONDITE_MK'] ?></td>
                    <td class="text-center"><?= $lk['KONDITE_I'] ?></td>
                    <td class="text-center"><?= $lk['KONDITE_BK'] ?></td>
                    <td class="text-center"><?= $lk['KONDITE_TKP'] ?></td>
                    <td class="text-center"><?= $lk['KONDITE_KP'] ?></td>
                    <td class="text-center"><?= $lk['KONDITE_KS'] ?></td>
                    <td class="text-center"><?= $lk['KONDITE_KK'] ?></td>
                    <td class="text-center"><?= $lk['KONDITE_PK'] ?></td>
                    <!-- <td class="text-center"><a class="btn btn-warning btn-xs" title="Edit"><i class="fa fa-pencil"></i></a> <a class="btn btn-danger btn-xs" title="Delete"><i class="fa fa-remove"></i></a></td> -->
                </tr>
            <?php $no++;
            } ?>
        </tbody>
    </table>
</div>