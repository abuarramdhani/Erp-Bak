<table class="datatable table table-bordered table-hover table-striped text-center" id="tb<?= $ket?>" style="width: 100%">
    <thead style="background-color:<?= $warna?>">
        <tr>
            <th style="width: 5%">No</th>
            <th>Tanggal Order</th>
            <th>No Order</th>
            <th>Pengorder</th>
            <th>Jenis</th>
            <th>Nama Komponen</th>
            <th>No Tool</th>
            <th>Status</th>
            <th>Permintaan Selesai</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    <?php $no = 1; foreach ($data as $key => $val) {
        if(stripos($val['jenis'], 'FIXTURE') !== FALSE) { 
            $jenis = substr($val['jenis'],0,7);
        }elseif (stripos($val['jenis'], 'MASTER') !== FALSE) {
            $jenis = substr($val['jenis'],0,6);
        }elseif (stripos($val['jenis'], 'GAUGE') !== FALSE) {
            $jenis = substr($val['jenis'],0,5);
        }elseif (stripos($val['jenis'], 'ALAT LAIN') !== FALSE) {
            $jenis = substr($val['jenis'],0,9);
        }else {
            $jenis = $val['jenis'];
        }
        $print = $siapa == 'Kasie PPC TM' ? '' : 'display:none'; //print cuma bisa di resp otm - tool making
        if ($ket == 'modif') {
            $asset = 'display:none';
            $detail = 'viewmodif('.$no.')';
            $action_print = base_url("OrderToolMakingTM/MonitoringOrder/PrintOrderModifikasi/".$val['no_order']."");
            $asset_print = '';
        }elseif ($ket == 'rekon') {
            $asset = 'display:none';
            $detail = 'viewrekon('.$no.')';
            $action_print = base_url("OrderToolMakingTM/MonitoringOrder/PrintOrderRekondisi/".$val['no_order']."");
            $asset_print = '';
        }else {
            $asset = $siapa == 'Kasie PPC TM' ? '' : 'display:none';
            $detail = 'viewbaru('.$no.')';
            $action_print = base_url("OrderToolMakingTM/MonitoringOrder/PrintOrderBaru/".$val['no_order']."");
            $asset_print = base_url("OrderToolMakingTM/MonitoringOrder/PrintAsset/".$val['no_order']."");
        }
    ?>
        <tr>
            <td><?= $no?></td>
            <td><?= $val['tgl_order']?></td>
            <td><input type="hidden" id="no_order_<?= $ket?><?= $no?>" value="<?= $val['no_order']?>"><?= $val['no_order']?></td>
            <td><?= $val['seksi']?></td>
            <td><?= $jenis?></td>
            <td><?= $val['nama_komponen']?></td>
            <td><?= $val['no_tool']?></td>
            <td><input type="hidden" id="status_<?= $ket?><?= $no?>" value="<?= $val['status']?>"><?= $val['status']?></td>
            <td><?= $val['tgl_usulan']?></td>
            <td>
                <button type="button" id="view_<?= $ket?>" class="btn btn-info" onclick="<?= $detail?>"><i class="fa fa-search"></i> View</button>
                <button type="submit" id="print_<?= $ket?>" class="btn btn-danger" style="<?= $print?>" formtarget="_blank" formaction="<?php echo $action_print?>"><i class="fa fa-print"></i> Print</button>
                <button type="submit" id="asset_<?= $ket?>" class="btn btn-danger" style="<?= $asset?>" formtarget="_blank" formaction="<?php echo $asset_print?>"><i class="fa fa-print"></i> Proposal Asset</button>
            </td>
        </tr>
    <?php $no++; }?>
    </tbody>
</table>