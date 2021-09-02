<style>
.col-md-3{
    color : #556F78;
}
.col-md-2{
    color : #556F78;
}
</style>

<?php
// echo "<pre>";print_r($val);exit();

if ($val['ket'] == 'Baru') { // view tabel baru
    $modifrekon = 'display:none'; // style inputan khusus modifikasi dan rekondisi
    $baru = ''; // style inputan khusus baru
    $height = $val['revisi'] == 1 ? 2000 : 1500; // tinggi modal berdasarkan data tersebut sudah accept / belum (revisi 1 = belum accept, jadi masih bisa di revisi)
}else { // view tabel modifikasi dan rekondisi
    $modifrekon = '';
    $baru = 'display:none';
    $height = $val['revisi'] == 1 ? 1500 : 1300;
}

if(stripos($val['jenis'], 'FIXTURE') !== FALSE || stripos($val['jenis'], 'MASTER') !== FALSE || stripos($val['jenis'], 'GAUGE') !== FALSE || stripos($val['jenis'], 'ALAT LAIN') !== FALSE) {
    // memisahkan jenis dan keterangan jenis
    if (stripos($val['jenis'], 'FIXTURE') !== FALSE) {
        $value = substr($val['jenis'],8);
        $nama = substr($val['jenis'],0,7);
    }elseif (stripos($val['jenis'], 'MASTER') !== FALSE) {
        $value = substr($val['jenis'],7);
        $nama = substr($val['jenis'],0,6);
    }elseif (stripos($val['jenis'], 'GAUGE') !== FALSE) {
        $value = substr($val['jenis'],6);
        $nama = substr($val['jenis'],0,5);
    }elseif (stripos($val['jenis'], 'ALAT LAIN') !== FALSE) {
        $value = substr($val['jenis'],10);
        $nama = substr($val['jenis'],0,9);
    }
    $valjenis = '<div class="col-md-3">
                <input id="jenis" name="jenis" class="form-control" value="'.$nama.'" readonly>
            </div>
            <div class="col-md-5">
                <input readonly class="form-control" value="'.$value.'">
            </div>';
}else {
    $valjenis = '<div class="col-md-8">
                <input id="jenis" name="jenis" class="form-control" value="'.$val['jenis'].'" readonly>
            </div>';
}

if ($val['ket'] == 'Baru') { // view dari tabel baru
    if ($val['material'] != 'Afval' && $val['material'] != '' && $val['jenis'] == 'DIES') {
        $isi = explode(" ",$val['material']);
        $lembar = explode("X", $isi[1]); 
        $material = '<div class="col-md-3">
                        <input class="form-control" value="'.$isi[0].'" readonly>
                    </div>
                    <div class="col-md-2">
                        <input type="number" name="lembar1" class="form-control lembar" value="'.$isi[1].'" readonly>
                    </div>
                    <div class="col-md-1 text-center"><label>X</label></div>
                    <div class="col-md-2">
                        <input type="number" name="lembar2" class="form-control lembar" value="'.$isi[3].'" readonly>
                    </div>';
    }else {
       $material = '<div class="col-md-8">
                        <input readonly class="form-control" value="'.$val['material'].'">
                    </div>';
    }
    if ($val['layout_alat'] != 'Tunggal' && $val['layout_alat'] != '') {
        $layout = '<div class="col-md-4">
                        <input class="form-control" value="Multi" readonly>
                    </div>
                    <div class="col-md-4">
                        <input class="form-control" value="'.$val['layout_alat'].'" readonly>
                    </div>';
    }else {
        $layout = '<div class="col-md-8">
                        <input class="form-control" value="'.$val['layout_alat'].'" readonly>
                    </div>';
    }
}else { // view tabel modifikasi dan rekondisi
    $material = $layout = '';
}

$revisi = $val['revisi'] == 1 ? '' : 'display:none;'; // style button revisi
$proses = ($val['status'] == 'FINISH : AB SUDAH JADI' || $val['status'] == 'DALAM PROSES PENGIRIMAN') ? 'display:none;' : ''; // style button revisi
?>
<!-- #71D9FF -->
<div class="panel-body">
    <div class="col-md-4" style="background-color:#5A93C9;margin-left:-30px;margin-top:-30px;box-shadow: 0 4px 9px -3px #367da6;height:60px">
        <div class="panel-body">
            <div class="col-md-3" style="color:white;">
                STATUS: 
            </div>
            <div class="col-md-9">
                <span style="color:white;font-weight:bold"><?= $val['status']?></span>
                <input type="hidden" name="no_order" value="<?= $val['no_order']?>">
                <input type="hidden" id="pengorder" name="pengorder" value="<?= $val['pengorder']?>">
                <input type="hidden" id="ket" name="ket" value="<?= $val['ket']?>">
                <input type="hidden" id="siapa" name="siapa" value="<?= $val['siapa']?>">
                <input type="hidden" id="seksi_order" name="seksi_order" value="<?= $val['seksi']?>">
                <input type="hidden" id="tinggi" value="<?= $height?>">
                <input type="hidden" id="gambar_produk" value="<?= $val['gamker']?>">
                <input type="hidden" id="status" name="status" value="<?= $val['status']?>">
                <input type="hidden" id="status_order" name="status_order" value="<?= $val['status_order']?>">
            </div>
        </div>
    </div>
    <div class="col-md-8" style="margin-top:-15px;">
        <div class="modal-header">
            <center><h3 class="modal-title" style="color : #556F78">Detail Order</h3></center>
        </div>
    </div>
</div>
<div class="panel-body">
    <div class="col-md-4" id="panelbiru" style="background-color:#77BEED;margin-left:-30px;margin-top:-50px;margin-bottom:-30px;box-shadow: 0 4px 9px -3px #367da6;height:<?= $height?>px;">
        <div class="col-md-12"><br>
            <span style="color:#3A4C52;">NO ORDER</span> <br><span style="color:#3A4C52;font-weight:bold"><?= $val['no_order'] ?></span>
        </div>
        <div class="col-md-12"><br>
            <span style="color:#3A4C52;">TANGGAL ORDER</span> <br><span style="color:#3A4C52;font-weight:bold"><?= $val['tgl_order'] ?></span>
        </div>
        <div class="col-md-12"><br>
            <span style="color:#3A4C52;">SEKSI</span> <br><span style="color:#3A4C52;font-weight:bold"><?= $val['seksi'] ?></span>
        </div>
        <div class="col-md-12"><br>
            <span style="color:#3A4C52;">UNIT</span> <br><span style="color:#3A4C52;font-weight:bold"><?= $val['unit'] ?></span>
        </div>
        <div class="col-md-12"><br>
            <span style="color:#3A4C52;">GAMBAR PRODUK </span>
            <br>
            <span style="color:#3A4C52">
                <?php $gb = explode(';', $val['gamker']);
                for ($i=0; $i < count($val['folder_gamker']) ; $i++) { 
                    $filename = "assets/upload/OrderToolMaking/Gambar_kerja/".$val['folder_gamker'][$i]."/".$gb[$i]."";
                        if (file_exists($filename)) {?>
                        <div id="edit_19_<?= ($i+1)?>">
                            <span><br><label><?= ($i+1)?>. </label></span>
                            <a href="<?php echo base_url($filename)?>" target="_blank">
                                <img style="max-width: 250px;max-height: 250px" src="<?php echo base_url($filename)?>">
                            </a>
                            <button type="button" class="btn btn-sm btn-info" onclick="editorder('Gambar Produk', '19_<?= ($i+1)?>')"><i class="fa fa-edit"></i></button>
                            <input type="hidden" id="ket_edit_19_<?= ($i+1)?>" name="ket_edit[]" value="N">
                            <br><span style="color:#3A4C52;font-size:11px;margin-left:15px">*Klik gambar untuk membuka di Tab baru</span>
                        </div>
                    <?php }else {
                        echo '<span style="font-size:12px">Gambar Produk Tidak Ditemukan...</span>';
                    }
                }?>
            </span>
        </div>
        <div class="col-md-12" id="edit_20"><br>
            <span style="color:#3A4C52;">SKETS / REFERENSI AB  </span>
            <br>
            <span style="color:#3A4C52">
                <?php $filename = "assets/upload/OrderToolMaking/Skets/".$val['folder_skets']."/".$val['skets']."";
                    if (file_exists($filename)) {?>
                        <a href="<?php echo base_url($filename)?>" target="_blank">
                            <img style="max-width: 250px;max-height: 250px" src="<?php echo base_url($filename)?>">
                        </a>
                        <button type="button" class="btn btn-sm btn-info" onclick="editorder('Skets', 20)"><i class="fa fa-edit"></i></button>
                        <input type="hidden" id="ket_edit_20" name="ket_edit[]" value="N">
                        <br><span style="color:#3A4C52;font-size:11px">*Klik gambar untuk membuka di Tab baru</span>
                <?php }else {
                    echo '<span style="font-size:12px">Skets Tidak Ditemukan...</span>';
                }?>
            </span>
        </div>
    </div>
    
    <div class="col-md-8">
        <div class="col-md-12" style="<?= $modifrekon?>" id="edit_0"><br>
            <div class="col-md-3">
                User : 
            </div>
            <div class="col-md-8">
                <input readonly class="form-control" value="<?= $val['user_nama'] ?>">
            </div>
            <div class="col-md-1">
                <button type="button" class="btn btn-sm btn-info" onclick="editorder('User', 0)"><i class="fa fa-edit"></i></button>
                <input type="hidden" id="ket_edit_0" name="ket_edit[]" value="N">
            </div>
        </div>
        <?php if ($val['ket'] == 'Baru') { ?>
        <div class="col-md-12" style="<?= $baru?>"><br>
            <div class="col-md-3">
                Proposal Asset :
            </div>
            <!-- <div class="col-md-2">
                <?php $filename = "assets/upload/OrderToolMaking/Proposal/".$val['file_proposal']."";
                $proposal =  (file_exists($filename)) ? 'href="'.base_url($filename).'" target="_blank"' : '' ; ?>
                <a <?= $proposal?>>
                    <span class="btn btn-info" style="border-radius:25px"><i class="fa fa-eye"></i> View</span>
                </a>
            </div> -->
            <div class="col-md-8">
                <input readonly class="form-control" value="<?= $val['no_proposal'] ?>">
            </div>
        </div>
        <div class="col-md-12" style="<?= $baru?>"><br>
            <div class="col-md-3">
                Alasan Pengadaan Asset:
            </div>
            <div class="col-md-8">
                <textarea style="width:100%;height:100px" disabled><?= $val['alasan_asset'] ?></textarea>
            </div>
        </div>
        <?php } ?>
        <div class="col-md-12" id="edit_1"><br>
            <div class="col-md-3">
                Usulan Order Selesai:
            </div>
            <div class="col-md-8">
                <div class="input-group date">
                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                    <input readonly name="tgl_usul" class="form-control" value="<?= $val['tgl_usul'] ?>">
                </div>
            </div>
            <div class="col-md-1">
                <button type="button" class="btn btn-sm btn-info" onclick="editorder('Usulan Order Selesai', 1)"><i class="fa fa-edit"></i></button>
                <input type="hidden" id="ket_edit_1" name="ket_edit[]" value="N">
            </div>
        </div>
        <div class="col-md-12"><br>
            <div class="col-md-3">
                Jenis :
            </div>
            <?= $valjenis ?>
        </div>
        <?php if ($val['ket'] != 'Baru') { ?>
        <div class="col-md-12" style="<?= $modifrekon?>"><br>
            <div class="col-md-3">
                Inspection Report :
            </div>
            <div class="col-md-9">
                <!-- <input readonly class="form-control" value="<?php echo $val['ket'] != 'Baru' ? $val['inspection_report'] : ''; ?>"> -->
                <?php $filename = "assets/upload/OrderToolMaking/Inspect_Report/".$val['inspection_report']."";
                $inspect =  (file_exists($filename)) && !empty($val['inspection_report']) ? 'href="'.base_url($filename).'" target="_blank"' : '' ; ?>
                <a <?= $inspect?>>
                    <span class="btn btn-info" style="border-radius:25px" <?= empty($val['inspection_report']) ? 'disabled' : ''; ?>><i class="fa fa-eye"></i> View</span>
                </a>
            </div>
        </div>
        <?php }?>
        <div class="col-md-12" id="edit_2"><br>
            <div class="col-md-3">
                Kode Komponen :
            </div>
            <div class="col-md-8">
                <input readonly class="form-control" value="<?= $val['kodekomp'] ?>">
            </div>
            <div class="col-md-1">
                <button type="button" class="btn btn-sm btn-info" onclick="editorder('Kode Komponen', 2)"><i class="fa fa-edit"></i></button>
                <input type="hidden" id="ket_edit_2" name="ket_edit[]" value="N">
            </div>
        </div>
        <div class="col-md-12" id="edit_3"><br>
            <div class="col-md-3">
                Nama Komponen :
            </div>
            <div class="col-md-8">
                <input readonly class="form-control" value="<?= $val['namakomp'] ?>">
            </div>
            <div class="col-md-1">
                <button type="button" class="btn btn-sm btn-info" onclick="editorder('Nama Komponen', 3)"><i class="fa fa-edit"></i></button>
                <input type="hidden" id="ket_edit_3" name="ket_edit[]" value="N">
            </div>
        </div>
        <div class="col-md-12" id="edit_4"><br>
            <div class="col-md-3">
                Tipe Produk :
            </div>
            <div class="col-md-8">
                <input readonly class="form-control" value="<?= $val['tipe_produk'] ?>">
            </div>
            <div class="col-md-1">
                <button type="button" class="btn btn-sm btn-info" onclick="editorder('Tipe Produk', 4)"><i class="fa fa-edit"></i></button>
                <input type="hidden" id="ket_edit_4" name="ket_edit[]" value="N">
            </div>
        </div>
        <div class="col-md-12" id="edit_5"><br>
            <div class="col-md-3">
                Tanggal Rilis Gambar:
            </div>
            <div class="col-md-8">
                <div class="input-group date">
                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                    <input readonly name="tgl_rilis" class="form-control" value="<?= $val['tgl_rilis'] ?>">
                </div>
            </div>
            <div class="col-md-1">
                <button type="button" class="btn btn-sm btn-info" onclick="editorder('Tanggal Rilis Gambar', 5)"><i class="fa fa-edit"></i></button>
                <input type="hidden" id="ket_edit_5" name="ket_edit[]" value="N">
            </div>
        </div>
        <div class="col-md-12" style="<?= $baru?>" id="edit_6"><br>
            <div class="col-md-3">
                Mesin Yang Digunakan:
            </div>
            <div class="col-md-8">
                <input readonly class="form-control" value="<?php echo $val['ket'] == 'Baru' ? $val['mesin'] : ''; ?>">
            </div>
            <div class="col-md-1">
                <button type="button" class="btn btn-sm btn-info" onclick="editorder('Mesin Yang Digunakan', 6)"><i class="fa fa-edit"></i></button>
                <input type="hidden" id="ket_edit_6" name="ket_edit[]" value="N">
            </div>
        </div>
        <div class="col-md-12" style="<?= $modifrekon?>" id="edit_7"><br>
            <div class="col-md-3">
                No Alat Bantu :
            </div>
            <div class="col-md-8">
                <input readonly class="form-control" value="<?php echo $val['ket'] != 'Baru' ? $val['no_alat'] : ''; ?>">
            </div>
            <div class="col-md-1">
                <button type="button" class="btn btn-sm btn-info" onclick="editorder('No Alat Bantu', 7)"><i class="fa fa-edit"></i></button>
                <input type="hidden" id="ket_edit_7" name="ket_edit[]" value="N">
            </div>
        </div>
        <div class="col-md-12" id="edit_8"><br>
            <div class="col-md-3">
                Proses :
            </div>
            <div class="col-md-8">
                <input readonly class="form-control" value="<?= $val['poin'] ?>">
            </div>
            <div class="col-md-1">
                <button type="button" class="btn btn-sm btn-info" onclick="editorder('Proses', 8)"><i class="fa fa-edit"></i></button>
                <input type="hidden" id="ket_edit_8" name="ket_edit[]" value="N">
            </div>
        </div>
        <div class="col-md-12" id="edit_9"><br>
            <div class="col-md-3">
                Proses Ke :
            </div>
            <div class="col-md-8">
                <input readonly name="proses_ke" class="form-control" value="<?= $val['proses_ke'] ?>">
            </div>
            <div class="col-md-1">
                <button type="button" class="btn btn-sm btn-info" onclick="editorder('Proses Ke', 9)"><i class="fa fa-edit"></i></button>
                <input type="hidden" id="ket_edit_9" name="ket_edit[]" value="N">
            </div>
        </div>
        <div class="col-md-12" id="edit_10"><br>
            <div class="col-md-3">
                Dari :
            </div>
            <div class="col-md-8">
                <input readonly name="dari" class="form-control" value="<?= $val['dari'] ?>">
            </div>
            <div class="col-md-1">
                <button type="button" class="btn btn-sm btn-info" onclick="editorder('Dari', 10)"><i class="fa fa-edit"></i></button>
                <input type="hidden" id="ket_edit_10" name="ket_edit[]" value="N">
            </div>
        </div>
        <div class="col-md-12" style="<?= $baru?>" id="edit_11"><br>
            <div class="col-md-3">
                Jumlah Alat :
            </div>
            <div class="col-md-8">
                <input readonly name="jml_alat" class="form-control" value="<?php echo $val['ket'] == 'Baru' ? $val['jml_alat'] : ''; ?>">
            </div>
            <div class="col-md-1">
                <button type="button" class="btn btn-sm btn-info" onclick="editorder('Jumlah Alat', 11)"><i class="fa fa-edit"></i></button>
                <input type="hidden" id="ket_edit_11" name="ket_edit[]" value="N">
            </div>
        </div>
        <div class="col-md-12" style="<?= $baru?>" id="edit_12"><br>
            <div class="col-md-3">
                Distribusi :
            </div>
            <div class="col-md-8">
                <input readonly name="distribusi" class="form-control" value="<?php echo $val['ket'] == 'Baru' ? $val['distribusi'] : ''; ?>">
            </div>
            <div class="col-md-1">
                <button type="button" class="btn btn-sm btn-info" onclick="editorder('Distribusi', 12)"><i class="fa fa-edit"></i></button>
                <input type="hidden" id="ket_edit_12" name="ket_edit[]" value="N">
            </div>
        </div>
        <div class="col-md-12" style="<?= $baru?>" id="edit_13"><br>
            <div class="col-md-3">
                Dimensi & Toleransi (Untuk Gauge) :
            </div>
            <div class="col-md-8">
                <input readonly class="form-control" value="<?php echo $val['ket'] == 'Baru' ? $val['dimensi'] : ''; ?>">
            </div>
            <div class="col-md-1">
                <button type="button" class="btn btn-sm btn-info" onclick="editorder('Dimensi & Toleransi (Untuk Gauge)', 13)"><i class="fa fa-edit"></i></button>
                <input type="hidden" id="ket_edit_13" name="ket_edit[]" value="N">
            </div>
        </div>
        <div class="col-md-12" style="<?= $baru?>" id="edit_14"><br>
            <div class="col-md-3">
                Flow Proses
            </div>
            <div class="col-md-2">
                Sebelumnya:
            </div>
            <div class="col-md-6">
                <input readonly name="flow_sebelum" class="form-control" value="<?php echo $val['ket'] == 'Baru' ? $val['flow_sebelum'] : ''; ?>">
            </div>
            <div class="col-md-1">
                <button type="button" class="btn btn-sm btn-info" onclick="editorder('Flow Proses Sebelumnya', 14)"><i class="fa fa-edit"></i></button>
                <input type="hidden" id="ket_edit_14" name="ket_edit[]" value="N">
            </div>
        </div>
        <div class="col-md-12" style="<?= $baru?>" id="edit_15"><br>
            <div class="col-md-3"></div>
            <div class="col-md-2">
                Sesudahnya:
            </div>
            <div class="col-md-6">
                <input readonly name="flow_sebelum" class="form-control" value="<?php echo $val['ket'] == 'Baru' ? $val['flow_sesudah'] : ''; ?>">
            </div>
            <div class="col-md-1">
                <button type="button" class="btn btn-sm btn-info" onclick="editorder('Flow Proses Sesudahnya', 15)"><i class="fa fa-edit"></i></button>
                <input type="hidden" id="ket_edit_15" name="ket_edit[]" value="N">
            </div>
        </div>
        <div class="col-md-12" style="<?= $baru?>" id="edit_16"><br>
            <div class="col-md-3">
                Acuan Alat Bantu :
            </div>
            <div class="col-md-8">
                <input readonly class="form-control" value="<?php echo $val['ket'] == 'Baru' ? $val['acuan_alat'] : ''; ?>">
            </div>
            <div class="col-md-1">
                <button type="button" class="btn btn-sm btn-info" onclick="editorder('Acuan Alat Bantu', 16)"><i class="fa fa-edit"></i></button>
                <input type="hidden" id="ket_edit_16" name="ket_edit[]" value="N">
            </div>
        </div>
        <div class="col-md-12" style="<?= $baru?>" id="edit_17"><br>
            <div class="col-md-3">
                Layout Alat Bantu :
            </div>
            <?= $layout?>
            <div class="col-md-1">
                <button type="button" class="btn btn-sm btn-info" onclick="editorder('Layout Alat Bantu', 17)"><i class="fa fa-edit"></i></button>
                <input type="hidden" id="ket_edit_17" name="ket_edit[]" value="N">
            </div>
        </div>
        <div class="col-md-12" style="<?= $baru?>" id="edit_18"><br>
            <div class="col-md-3">
                Material Blank (Khusus DIES) :
            </div>
            <?= $material?>
            <div class="col-md-1">
                <button type="button" class="btn btn-sm btn-info" onclick="editorder('Material Blank (Khusus DIES)', 18)"><i class="fa fa-edit"></i></button>
                <input type="hidden" id="ket_edit_18" name="ket_edit[]" value="N">
            </div>
        </div>
        <div class="col-md-12" style="<?= $modifrekon?>" id="edit_21"><br>
            <div class="col-md-3">
                Alasan Modifikasi :
            </div>
            <div class="col-md-8">
                <textarea disabled style="width:100%"><?php echo $val['ket'] != 'Baru' ? $val['alasan'] : ''; ?></textarea>
            </div>
            <div class="col-md-1">
                <button type="button" class="btn btn-sm btn-info" onclick="editorder('Alasan Modifikasi', 21)"><i class="fa fa-edit"></i></button>
                <input type="hidden" id="ket_edit_21" name="ket_edit[]" value="N">
            </div>
        </div>
        <div class="col-md-12" id="edit_22"><br>
            <div class="col-md-3">
                Referensi / Datum Alat Bantu :
            </div>
            <div class="col-md-8">
                <textarea disabled style="width:100%"><?= $val['referensi'] ?></textarea>
            </div>
            <div class="col-md-1">
                <button type="button" class="btn btn-sm btn-info" onclick="editorder('Referensi / Datum Alat Bantu', 22)"><i class="fa fa-edit"></i></button>
                <input type="hidden" id="ket_edit_22" name="ket_edit[]" value="N">
            </div>
        </div>
        <?php if ($val['status'] == 'DIPERIKSA DESIGNER PRODUK') { ?>
        <div class="col-md-12"><br>
            <div class="col-md-3">
                STP Gambar Kerja :
            </div>
            <div class="col-md-8">
                <!-- <span id="view_skets" style="display:none"><img id="previewskets" style="width:100%;max-width: 350px;max-height: 350px"></span> -->
                <input name="file_stp" type="file" id="img_stp" accept="" required>
            </div>
        </div>
        <?php }else{
            if(!empty($val['stp_gambar_kerja'])){?>
                <div class="col-md-12"><br>
                    <div class="col-md-3">
                        STP Gambar Kerja :
                    </div>
                    <div class="col-md-9">
                        <?php $filename = "assets/upload/OrderToolMaking/STP_GAMKER/".$val['stp_gambar_kerja']."";
                        $inspect =  (file_exists($filename)) && !empty($val['stp_gambar_kerja']) ? 'href="'.base_url($filename).'" download="'.$val['stp_gambar_kerja'].'" target="_blank"' : '' ; ?>
                        <a <?= $inspect?>>
                            <span class="btn btn-info" style="border-radius:25px" <?= empty($val['stp_gambar_kerja']) ? 'disabled' : ''; ?>><i class="fa fa-download"></i> Download</span>
                        </a>
                    </div>
                </div>
        <?php } }?>
        <div class="col-md-12"><br>
            <div class="col-md-3">
                Assign Desainer :
            </div>
            <div class="col-md-8">
                <input readonly class="form-control" value="<?= $val['assign_desainer'] ?>">
            </div>
        </div>
        <div class="col-md-12" style="display:none"><br>
            <div class="col-md-3">
                Action :
            </div>
            <div class="col-md-9">
                <input readonly id="action" name="action" class="form-control" value="Accept">
            </div>
        </div>
        <div class="col-md-12"><br>
        <div class="box box-info box-solid" style="<?= $revisi ?>">
        <?php if ($val['status'] == 'DIPERIKSA KEPALA SEKSI PE') { ?>
            <div class="panel-body">
                <div class="col-md-3">
                    <label>Assign Desainer</label>
                </div>
                <div class="col-md-9">
                    <select id="assign_desain" name="assign_desainer" class="form-control select2" style="width:100%" data-placeholder="pilih assign desainer" required>
                        <option></option>
                        <option value="Desainer A">Desainer A</option>
                        <option value="Desainer B">Desainer B</option>
                        <option value="Desainer C">Desainer C</option>
                    </select>
                </div>
            </div>
        <?php }?>
            <!-- <div class="panel-body" id="tambahTarget">
                <div class="col-md-12" style="color : #556F78">
                    <label>Edit :</label>
                </div>
                <div class="col-md-3">
                    <select class="form-control select2 revisi" id="revisi1" name="revisi[]" style="width:100%">
                        <option></option>
                    </select>
                </div>
                <div class="col-md-8 ganti" id="ganti1">
                    <input class="form-control isi_rev" id="isi_rev1" name="isi_rev[]" placeholder="masukkan hasil revisi" autocomplete="off">
                </div>
                <div class="col-md-1" style="text-align:left">
                    <a href="javascript:void(0);" id="addrevkolom" onclick="addrevkolom()" class="btn btn-default"><i class="fa fa-plus"></i></a>
                </div><br>
            </div> -->
            
            <div class="panel-body" id="tambahTarget2">
                <div class="col-md-12" style="color : #556F78">
                    <label>Revisi :</label>
                </div>
                <div class="col-md-11">
                    <select class="form-control select2 revisi2" id="poinrevisi1" name="poinrevisi[]" style="width:100%" data-placeholder="pilih poin revisi">
                        <option></option>
                    </select>
                </div>
                <div class="col-md-1" style="text-align:left">
                    <a href="javascript:void(0);" id="addrevkolom" onclick="addrevkolom2()" class="btn btn-default"><i class="fa fa-plus"></i></a>
                </div><br>
            </div>
            <div class="panel-body">
                <div class="col-md-3">
                    <label>Keterangan :</label>
                </div>
                <div class="col-md-9">
                    <textarea id="keterangan" name="keterangan" placeholder="keterangan" style="height:70px;width:100%"><?= $val['action']['keterangan'] ?></textarea>
                </div>
            </div>
        </div>
        </div>

        <div class="col-md-12 text-center" style="<?= $proses?><?= $revisi?>"><br>
            <button class="btn btn-warning" formaction="<?php echo base_url("ApprovalToolMaking/MonitoringOrder/saveRevisiProses")?>"><i class="fa fa-refresh"></i> Revisi Order</button>
            <button class="btn btn-success" formaction="<?php echo base_url("ApprovalToolMaking/MonitoringOrder/saveRevisiProses")?>"><i class="fa fa-spinner"></i> Proses Order</button>
            <button type="button" class="btn btn-danger" onclick="tolakorder('<?= $val['no_order']?>', '<?= $val['ket']?>')"><i class="fa fa-close"></i> Tolak Order</button>
        </div>
    </div>
</div>
