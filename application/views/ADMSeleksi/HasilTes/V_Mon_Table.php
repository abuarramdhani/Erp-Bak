<table class="table table-bordered table-hover" style="width: 100%;" id="tb_<?= $id?>">
    <thead>
        <tr style="background-color: #3c8dbc; color:white;" class="text-nowrap">
            <th class="text-center" style="width:5%">No</th>
            <th class="text-center">Kode Tes</th>
            <th class="text-center">Nama Peserta</th>
            <th class="text-center">Tanggal Tes</th>
            <th class="text-center">Hasil Tes</th>
            <th class="text-center" style="width:25%">Option</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1; foreach ($data as $key => $val) {?>
            <tr>
                <td class="text-nowrap text-center"><?= $no?></td>
                <td class="text-nowrap text-center" style="vertical-align:middle"><?= $val['kode_test']?></td>
                <td class="text-nowrap" style="vertical-align:middle">
                        <input type="hidden" id="ket_<?= $val['kode_akses']?>" value="N">
                        <button type="button" class="btn" onclick="collect_peserta('<?= $val['kode_akses']?>', '<?= $id?>')" style="background-color:inherit"><i id="fa_<?= $val['kode_akses']?>" class="fa fa-2x fa-square-o"></i></button>
                        <?= $val['nama_peserta']?></td>
                <td class="text-nowrap text-center" style="vertical-align:middle"><?= DateTime::createFromFormat('Y-m-d', $val['tgl_test'])->format('d-m-Y')?></td>
                <td class="text-nowrap text-left"><?= $val['nama_tes']?></td>
                <td class="text-nowrap text-center">
                    <a href="<?= base_url("ADMSeleksi/MonitoringHasilTes/detailtes/".$val['kode_akses']."_".$val['id_tes']."") ?>" type="button" class="btn btn-xs btn-info"><i class="fa fa-eye"></i> Lihat</a>
                    <a href="<?= base_url("ADMSeleksi/MonitoringHasilTes/exportdetail/".$val['kode_akses']."_".$val['id_tes']."") ?>" type="button" style="margin-left:10px"  class="btn btn-xs btn-success"><i class="fa fa-download"></i> Export</a>
                    <button type="button" class="btn btn-xs btn-danger" style="margin-left:10px" onclick="delete_hasil_tes('<?= $val['kode_akses']?>', <?= $val['id_tes']?>)"><i class="fa fa-trash"></i> Hapus</button>
                </td>
            </tr>
        <?php  $no++; } ?>
    </tbody>
</table>
<form method="post">
<input type="hidden" id="collect_peserta_<?= $id?>" name="collect_peserta">
<button class="btn btn-info" formtarget="_blank" formaction="<?= base_url("ADMSeleksi/MonitoringHasilTes/Lihat_detail")?>"><i class="fa fa-check"></i>  Lihat Hasil Tes Kolektif</button>
<button class="btn btn-success" formaction="<?= base_url("ADMSeleksi/MonitoringHasilTes/Export_detail")?>"><i class="fa fa-check"></i>  Export Hasil Tes Kolektif</button>
</form>