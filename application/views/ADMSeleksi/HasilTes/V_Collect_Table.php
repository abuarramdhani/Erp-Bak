<table class="table table-bordered table-hover table-striped text-center" id="tb_Monitoring_tes" style="width: 100%;">
    <thead style="background-color:#63E1EB">
        <tr class="text-nowrap">
            <th style="width:7%;">No</th>
            <th>Kode Tes</th>
            <th>Tanggal Tes</th>
            <th>Nama Peserta</th>
            <th>Hasil Tes</th>
            <th style="width:15%">Option</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1; foreach ($data as $key => $value) {?>
        <tr id="tr_peserta<?= $no?>">
            <td><?= $no?></td>
            <td><?= $value['kode_test']?></td>
            <td><?= DateTime::createFromFormat('Y-m-d', $value['tgl_test'])->format('d-m-Y')?></td>
            <td><?= $value['nama_peserta']?></td>
            <td><?= $value['nama_tes']?></td>
            <td><a href="<?= base_url("ADMSeleksi/MonitoringHasilTes/detailtes/".$value['kode_akses']."_".$value['id_tes']."") ?>" target="_blank" type="button" class="btn btn-xs btn-info"><i class="fa fa-eye"></i> Lihat</a>
                <a href="<?= base_url("ADMSeleksi/MonitoringHasilTes/exportdetail/".$value['kode_akses']."_".$value['id_tes']."") ?>" type="button" class="btn btn-xs btn-success" ><i class="fa fa-download"></i> Export</a>
            </td>
        </tr>
        <?php $no++; }?>
    </tbody>
</table>