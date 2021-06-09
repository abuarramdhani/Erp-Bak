<table class="datatable table table-bordered table-hover table-striped text-center" id="tbl_req<?= $iniket?>" style="width: 100%;">
    <thead style="background-color:<?= $warna?>">
    <tr>
        <th style="width: 5%">No
            <input type="hidden" id="jml_data" value="<?= count($data)?>">
        </th>
        <th>No Dokumen</th>
        <th>Nama IO</th>
        <th>Tanggal Transaksi</th>
        <th>Status</th>
        <?php if ($jenisket == 'finished') {
            echo '<th>Tanggal Input</th>';
        }else {
            echo '<th>Keterangan Approval</th>';
        }?>
        <th style="width: 15%">Action</th>
    </tr>
    </thead>
    <tbody>
    <?php $no = 1; foreach ($data as $val) {
        if ($jenisket == 'finished') {
            $col = $val['status'] == 'REJECTED' ? '#CF3222;font-weight:bold' : 'green;font-weight:bold';
        }else {
            $col = '#444';
        }
    ?>
        <tr>
            <td><?= $no?>
                <input type="hidden" id="idheader<?= $iniket?><?= $no?>" name="idheader<?= $iniket?><?= $no?>" value="<?= $val['id']?>">
                <input type="hidden" id="nodoc<?= $iniket?><?= $no?>" name="nodoc<?= $iniket?><?= $no?>" value="<?= $val['no_dokumen']?>">
                <input type="hidden" id="io<?= $iniket?><?= $no?>" name="io<?= $iniket?><?= $no?>" value="<?= $val['io']?>">
                <input type="hidden" id="tgl_transact<?= $iniket?><?= $no?>" name="tgl_transact<?= $iniket?><?= $no?>" value="<?= $val['tgl_request']?>">
                <input type="hidden" id="pic<?= $iniket?><?= $no?>" name="pic<?= $iniket?><?= $no?>" value="<?= $val['pic']?>">
                <input type="hidden" id="status<?= $iniket?><?= $no?>" name="status<?= $iniket?><?= $no?>" value="<?= $val['status']?>">
                <input type="hidden" id="approval<?= $iniket?><?= $no?>" name="approval<?= $iniket?><?= $no?>" value="">
            </td>
            <td class="text-nowrap"><?= $val['no_dokumen']?></td>
            <td><?= $val['io']?></td>
            <td><?= $val['tgl_request']?></td>
            <td class="text-nowrap" style="color:<?= $col?>"><?= $val['status']?></td>
            <?php if ($jenisket == 'finished') { ?>
                <td><?= $val['tgl_input'] ?></td>
            <?php }else { //bukan tabel finished
                if ($val['ket_approval'] == '') { //semua item approved
                    $clr = '#444'; 
                    $ket_app = '-';
                }else { // ada item reject
                    $clr = '#CF3222'; 
                    $ket_app = $val['ket_approval'];
                }?>
                <td style="color:<?= $clr?>"><?= $ket_app?></td>
            <?php }?>
            <td>
                <button class="btn btn-xs btn-info" style="<?= $iniket != 'approvemanualCosting' ? '' : 'display:none'?>" formaction="<?= base_url("".$linkdetail."DetailMiscellaneous/".$iniket."".$no."")?>"> Detail</button>
                <!-- <button type="button" class="btn btn-xs btn-danger" style="<?= $iniket == 'approvemanualCosting' ? '' : 'display:none'?>"> Print</button> -->
                <button type="button" class="btn btn-xs btn-success" style="<?= $iniket == 'approvemanualCosting' ? '' : 'display:none'?>" onclick="mdlapprovemanual('<?= $iniket?>', <?= $no?>)"> Approve Manual</button>
            </td>
        </tr>
    <?php $no++; }?>
    </tbody>
</table>