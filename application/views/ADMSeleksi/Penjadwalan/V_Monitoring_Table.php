<table class="table table-bordered table-hover table-striped" style="width: 100%;" id="tb_<?= $id?>">
    <thead>
        <tr style="background-color: #3c8dbc; color:white;" class="text-nowrap">
            <th class="text-center" style="width:5%">No</th>
            <th class="text-center">Kode Tes</th>
            <th class="text-center">Tanggal Tes</th>
            <th class="text-center">Waktu Tes</th>
            <th class="text-center">Daftar Peserta</th>
            <th class="text-center" style="width:15%">Option</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1; foreach ($data as $key => $val) {
            $kodetes = str_replace('/','_',$val['kode_test']);
            $tgltes = DateTime::createFromFormat('Y-m-d', $val['tgl_test'])->format('dmy');
            $kodetgl = $kodetes.'_'.$tgltes;
        ?>
            <tr>
                <td class="text-center"><?= $no?></td>
                <td class="text-nowrap text-center"><?= $val['kode_test']?></td>
                <td class="text-nowrap text-center"><?= DateTime::createFromFormat('Y-m-d', $val['tgl_test'])->format('d-m-Y')?></td>
                <td class="text-nowrap text-center"><?= $val['waktu_mulai']?> <?= $val['zona']?> - <?= $val['waktu_selesai']?> <?= $val['zona']?></td>
                <td syle="text-align:left">
                    <?php for ($i=0; $i < count($val['peserta']); $i++) { 
                            if ($i == 2) {?>
                                <a href="#" class="list_show_<?= $kodetgl?>" onclick="readmorepsikotest('<?= $kodetgl?>', 'read more')">read more...</a>
                                <span class="list_peserta_<?= $kodetgl?> hide">
                            <?php } ?>
                            <li><?=$val['peserta'][$i]?></li>
                            <?php if ($i == (count($val['peserta']))-1) { ?>
                                <a href="#" class="list_hide_<?= $kodetgl?> hide" onclick="readmorepsikotest('<?= $kodetgl?>', 'read less...')">read less...</a></span>
                            <?php }
                        }
                    ?>
                </td>
                <td class="text-nowrap text-center"><a href="<?php echo base_url('ADMSeleksi/MonitoringPenjadwalan/edit_jadwal_psikotest/'.$kodetes.'/'.$tgltes.'')?>" type="button" class="btn btn-warning"><i class="fa fa-edit"></i></a>
                <button type="button" class="btn btn-danger" style="margin-left:15px" onclick="delete_jadwal_psikotest('<?= $val['kode_test']?>', '<?= $val['tgl_test']?>')"><i class="fa fa-trash"></i></button></td>
            </tr>
        <?php $no++; } ?>
    </tbody>
</table>
