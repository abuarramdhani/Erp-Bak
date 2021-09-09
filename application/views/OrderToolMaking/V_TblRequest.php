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
        if ($siapa == 'Kasie Pengorder' && ($val['status_order'] == 1 || $val['status_order'] == 6 || empty($val['status_order']))  && $val['status'] != 'FINISH : AB SUDAH JADI') {
            $cancel = '';
        }elseif (($siapa == 'Kasie PE' || $siapa == 'Askanit PE' || $siapa == 'Kasie PPC TM') &&  empty($val['status_order']) && $val['status'] != 'FINISH : AB SUDAH JADI') {
            $cancel = '';
        }else{
            $cancel = 'display:none';
        }
        if ($siapa == 'Kasie Pengorder' && ($val['status_order'] == 3 || $val['status_order'] == 34 || $val['status_order'] == 5)) {
            $konfirm = '';
        }elseif($siapa == 'Kasie PPC TM' && ($val['status_order'] == 4 || $val['status_order'] == 34)){
            $konfirm = '';
        }else{
            $konfirm = 'display:none';
        }
        
        $nama   = $this->M_monitoringorder->getseksiunit($val['reject_by']); // cari seksi pic ass ka nit pengorder
        $nama   = !empty($nama) ? $nama[0]['nama'] : '';
        $reject	 = $val['reject_by'].' - '.$nama; 
        if ($val['status_order'] == 1) {
            $statusnya = 'Order Belum Dikirim';
        }elseif ($val['status_order'] == 3 || $val['status_order'] == 4 || $val['status_order'] == 34) {
            $statusnya = 'Order telah dicancel oleh '.$reject.'';
        }elseif ($val['status_order'] == 5) {
            $statusnya = 'Order telah ditolak oleh '.$reject.'';
        }elseif ($val['status_order'] == 6) {
            $statusnya = 'REVISI';
        }else  {
            $statusnya = $val['status'];
        }
        $print = $siapa == 'Kasie PPC TM'  || $siapa == 'Admin PPC' ? '' : 'display:none'; //print cuma bisa di resp otm - tool making
        if ($ket == 'modif') {
            $asset = 'display:none';
            $edit = 'editmodif('.$no.')';
            $detail = 'viewmodif('.$no.')';
            $action_print = base_url("OrderToolMakingTM/MonitoringOrder/PrintOrderModifikasi/".$val['no_order']."");
            $asset_print = '';
        }elseif ($ket == 'rekon') {
            $asset = 'display:none';
            $edit = 'editrekon('.$no.')';
            $detail = 'viewrekon('.$no.')';
            $action_print = base_url("OrderToolMakingTM/MonitoringOrder/PrintOrderRekondisi/".$val['no_order']."");
            $asset_print = '';
        }else {
            $asset = $siapa == 'Kasie PPC TM' || $siapa == 'Admin PPC' ? '' : 'display:none';
            $edit = 'editbaru('.$no.')';
            $detail = 'viewbaru('.$no.')';
            $action_print = base_url("OrderToolMakingTM/MonitoringOrder/PrintOrderBaru/".$val['no_order']."");
            $asset_print = base_url("OrderToolMakingTM/MonitoringOrder/PrintAsset/".$val['no_order']."");
        }
    ?>
        <tr>
            <td><?= $no?>
            <input type="hidden" id="assign_<?= $ket?><?= $no?>" value="<?= $val['assign_approval']?>">
            <input type="hidden" id="pengorder_<?= $ket?><?= $no?>" value="<?= $val['pengorder']?>">
            <input type="hidden" id="seksi_order_<?= $ket?><?= $no?>" value="<?= $val['seksi']?>">
            <input type="hidden" id="siapa_<?= $ket?><?= $no?>" value="<?= $siapa?>">
            <input type="hidden" id="status_order_<?= $ket?><?= $no?>" value="<?= $val['status_order']?>">
            </td>
            <td><?= $val['tgl_order']?></td>
            <td><input type="hidden" id="no_order_<?= $ket?><?= $no?>" value="<?= $val['no_order']?>"><?= $val['no_order']?></td>
            <td><?= $val['seksi']?></td>
            <td><input type="hidden" id="jenis_<?= $ket?><?= $no?>" value="<?= $jenis?>"><?= $jenis?></td>
            <td><?= $val['nama_komponen']?></td>
            <td><?= $val['no_tool']?></td>
            <td><input type="hidden" id="status_<?= $ket?><?= $no?>" value="<?= $statusnya?>"><?= $statusnya?></td>
            <td><?= $val['tgl_usulan']?></td>
            <td>
                <button type="button" id="send_<?= $ket?>" class="btn btn-warning" onclick="sendorder(<?= $no ?>, '<?= $ket?>')" style="<?= $val['status_order'] == 1 && $siapa == 'Kasie Pengorder' ? '' : 'display:none'; ?>"><i class="fa fa-send"></i> Send</button>
                <button type="button" id="edit_<?= $ket?>" class="btn btn-warning" onclick="<?= $edit?>" style="<?= ($val['status_order'] == 1 || $val['status_order'] == 6) && $siapa == 'Kasie Pengorder' ? '' : 'display:none'; ?>"><i class="fa fa-edit"></i> Edit</button>
                <button type="button" id="view_<?= $ket?>" class="btn btn-info" onclick="<?= $detail?>"><i class="fa fa-search"></i> View</button>
                <button type="button" id="cancel_<?= $ket?>" class="btn btn-danger" style="<?= $cancel?>" onclick="cancelorder(<?= $no ?>, '<?= $ket?>')"><i class="fa fa-close"></i> Cancel</button>
                <button type="submit" id="konfirmasi_<?= $ket?>" class="btn btn-primary" style="<?= $konfirm?>" formtarget="_blank" formaction="<?php echo base_url("OrderToolMaking/MonitoringOrder/konfirmasicancel/".$val['no_order']."_".$ket."/".$siapa."")?>"><i class="fa fa-check"></i> Setuju</button>
                <button type="submit" id="print_<?= $ket?>" class="btn btn-danger" style="<?= $print?>" formtarget="_blank" formaction="<?php echo $action_print?>"><i class="fa fa-print"></i> Print</button>
                <button type="submit" id="asset_<?= $ket?>" class="btn btn-danger" style="<?= $asset?>" formtarget="_blank" formaction="<?php echo $asset_print?>"><i class="fa fa-print"></i> Proposal Asset</button>
            </td>
        </tr>
    <?php $no++; }?>
    </tbody>
</table>