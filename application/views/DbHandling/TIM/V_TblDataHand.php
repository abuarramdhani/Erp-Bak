<style>
    .dataTables_filter {
        display: none;
    }
</style>
<form name="Orderform" action="<?php echo base_url('DbHandling/MonitoringHandling/tambahdatahandling'); ?>" class="form-horizontal" onsubmit="return validasi();window.location.reload();" method="post">
    <div style="text-align: right;">
        <button class="btn bg-teal">Tambah </button>
    </div>
</form>
<br>
<form name="Orderform" class="form-horizontal" onsubmit="return validasi();window.location.reload();" method="post">

    <table class="table table-bordered" id="datahandling" style="width: 100%;">
        <thead class="bg-aqua">
            <tr>
                <th class="text-center">No</th>
                <th class="text-center">Nama Dokumen</th>
                <th class="text-center">Rev. No</th>
                <th class="text-center">No Dokumen</th>
                <th class="text-center">Produk</th>
                <th class="text-center">Sarana Handling</th>
                <th class="text-center">Seksi</th>
                <th class="text-center">Rev. by</th>
                <th class="text-center">View</th>
                <th class="text-center">Action</th>


            </tr>
        </thead>
        <tbody>
            <?php $mo = 1;
            foreach ($datahandling as $data) { ?>
                <tr>
                    <input type="hidden" id="proseshandling<?= $data['id_handling'] ?>" value="<?= $data['proses'] ?>">
                    <td class="text-center"><?= $mo ?></td>
                    <td class="text-center"><?= $data['nama_komponen'] ?></td>
                    <td class="text-center"><?= $data['rev_no'] ?></td>
                    <td class="text-center"><?= $data['doc_number'] ?></td>
                    <td class="text-center"><?= $data['nama_produk'] ?></td>
                    <?php if ($data['sarana']  == 'Invalid') {
                        $color = 'red';
                        $bold = 'bold';
                    } else {
                        $color = '';
                        $bold = '';
                    } ?>
                    <td class="text-center" style="color: <?= $color ?>;font-weight:<?= $bold ?>;"><?= $data['sarana'] ?></td>
                    <td class="text-center"><?= $data['seksi'] ?></td>
                    <td class="text-center"><?= $data['last_update_by'].' - '.$data['nama_pic'].'<br>'.$data['seksi_pic'] ?></td>
                    <td class="text-center"><a onclick="imgcarousel(<?= $data['id_handling'] ?>)" class="btn btn-default btn-xs">Foto</a> <a onclick="proseshandling(<?= $data['id_handling'] ?>)" class="btn btn-warning btn-xs">proses</a></td>
                    <td class="text-center"><button type="submit" formaction="<?php echo base_url('DbHandling/MonitoringHandling/detaildatahandling/' . $data['id_handling']); ?>" class="btn btn-success btn-xs">Detail</button></td>

                </tr>
            <?php $mo++;
            } ?>
        </tbody>

    </table>
</form>