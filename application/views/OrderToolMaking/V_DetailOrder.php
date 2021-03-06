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
    $height = 1600; // tinggi modal
}else { // view tabel modifikasi dan rekondisi
    $modifrekon = '';
    $baru = 'display:none';
    $height = 1300;
}

if(stripos($val['jenis'], 'FIXTURE') !== FALSE || stripos($val['jenis'], 'MASTER') !== FALSE || stripos($val['jenis'], 'GAUGE') !== FALSE || stripos($val['jenis'], 'ALAT LAIN') !== FALSE) {
    //memisahkan jenis dan keterangan jenis
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
            <div class="col-md-6">
                <input readonly class="form-control" value="'.$value.'">
            </div>';
}else {
    $valjenis = '<div class="col-md-9">
                <input id="jenis" name="jenis" class="form-control" value="'.$val['jenis'].'" readonly>
            </div>';
}

if ($val['ket'] == 'Baru') {
    if ($val['material'] != 'Afval' && $val['material'] != '' && $val['jenis'] == 'DIES') {
        $isi = explode(" ",$val['material']);
        $material = '<div class="col-md-4">
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
       $material = '<div class="col-md-9">
                        <input readonly class="form-control" value="'.$val['material'].'">
                    </div>';
    }
    if ($val['layout_alat'] != 'Tunggal' && $val['layout_alat'] != '') {
        $layout = '<div class="col-md-4">
                        <input class="form-control" value="Multi" readonly>
                    </div>
                    <div class="col-md-5">
                        <input class="form-control" value="'.$val['layout_alat'].'" readonly>
                    </div>';
    }else {
        $layout = '<div class="col-md-9">
                        <input class="form-control" value="'.$val['layout_alat'].'" readonly>
                    </div>';
    }
}else {
    $material = $layout = '';
}

$terima = $val['status'] == 'DALAM PROSES PENGIRIMAN' ? '' : 'display:none'; // style button terima barang
?>
<div class="panel-body">
    <div class="col-md-4" style="background-color:#5A93C9;margin-left:-30px;margin-top:-30px;box-shadow: 0 4px 9px -3px #367da6;height:60px">
        <div class="panel-body">
            <div class="col-md-3" style="color:white;">
                STATUS: 
            </div>
            <div class="col-md-9">
                <span style="color:white;font-weight:bold"><?= $val['status']?></span>
                <input type="hidden" name="no_order" value="<?= $val['no_order']?>">
                <input type="hidden" id="ket" name="ket" value="<?= $val['ket']?>">
                <input type="hidden" name="siapa" value="<?= $val['siapa']?>">
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
                            <span><br><label><?= ($i+1)?>. </label></span>
                            <a href="<?php echo base_url($filename)?>" target="_blank">
                                <img style="max-width: 250px;max-height: 250px" src="<?php echo base_url($filename)?>">
                            </a>
                            <br><span style="color:#3A4C52;font-size:11px;margin-left:15px">*Klik gambar untuk membuka di Tab baru</span>
                    <?php }else {
                        echo '<span style="font-size:12px">Gambar Produk Tidak Ditemukan...</span>';
                    }
                }?>
            </span>
        </div>
        <div class="col-md-12"><br>
            <span style="color:#3A4C52;">SKETS / REFERENSI AB </span>
            <br>
            <span style="color:#3A4C52">
                <?php $filename = "assets/upload/OrderToolMaking/Skets/".$val['folder_skets']."/".$val['skets']."";
                    if (file_exists($filename)) {?>
                        <a href="<?php echo base_url($filename)?>" target="_blank">
                            <img style="max-width: 250px;max-height: 250px" src="<?php echo base_url($filename)?>">
                        </a>
                        <br><span style="color:#3A4C52;font-size:11px">*Klik gambar untuk membuka di Tab baru</span>
                <?php }else {
                    echo '<span style="font-size:12px">Skets Tidak Ditemukan...</span>';
                }?>
            </span>
        </div>
    </div>
    
    <div class="col-md-8">
        <div class="col-md-12" style="<?= $modifrekon?>"><br>
            <div class="col-md-3">
                User : 
            </div>
            <div class="col-md-9">
                <input readonly class="form-control" value="<?= $val['user_nama'] ?>">
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
            <div class="col-md-9">
                <input readonly class="form-control" value="<?= $val['no_proposal'] ?>">
            </div>
        </div>
        <div class="col-md-12" style="<?= $baru?>"><br>
            <div class="col-md-3">
                Alasan Pengadaan Asset:
            </div>
            <div class="col-md-9">
                <textarea style="width:100%;height:100px" disabled><?= $val['alasan_asset'] ?></textarea>
            </div>
        </div>
        <?php } ?>
        <div class="col-md-12"><br>
            <div class="col-md-3">
                Usulan Order Selesai:
            </div>
            <div class="col-md-9">
                <div class="input-group date">
                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                    <input readonly name="tgl_usul" class="form-control" value="<?= $val['tgl_usul'] ?>">
                </div>
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
        <div class="col-md-12"><br>
            <div class="col-md-3">
                Kode Komponen :
            </div>
            <div class="col-md-9">
                <input readonly class="form-control" value="<?= $val['kodekomp'] ?>">
            </div>
        </div>
        <div class="col-md-12"><br>
            <div class="col-md-3">
                Nama Komponen :
            </div>
            <div class="col-md-9">
                <input readonly class="form-control" value="<?= $val['namakomp'] ?>">
            </div>
        </div>
        <div class="col-md-12"><br>
            <div class="col-md-3">
                Tipe Produk :
            </div>
            <div class="col-md-9">
                <input readonly class="form-control" value="<?= $val['tipe_produk'] ?>">
            </div>
        </div>
        <div class="col-md-12"><br>
            <div class="col-md-3">
                Tanggal Rilis Gambar:
            </div>
            <div class="col-md-9">
                <div class="input-group date">
                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                    <input readonly name="tgl_rilis" class="form-control" value="<?= $val['tgl_rilis'] ?>">
                </div>
            </div>
        </div>
        <div class="col-md-12" style="<?= $baru?>"><br>
            <div class="col-md-3">
                Mesin Yang Digunakan:
            </div>
            <div class="col-md-9">
                <input readonly class="form-control" value="<?php echo $val['ket'] == 'Baru' ? $val['mesin'] : ''; ?>">
            </div>
        </div>
        <div class="col-md-12" style="<?= $modifrekon?>"><br>
            <div class="col-md-3">
                No Alat Bantu :
            </div>
            <div class="col-md-9">
                <input readonly class="form-control" value="<?php echo $val['ket'] != 'Baru' ? $val['no_alat'] : ''; ?>">
            </div>
        </div>
        <div class="col-md-12"><br>
            <div class="col-md-3">
                Proses :
            </div>
            <div class="col-md-9">
                <input readonly class="form-control" value="<?= $val['poin'] ?>">
            </div>
        </div>
        <div class="col-md-12"><br>
            <div class="col-md-3">
                Proses Ke :
            </div>
            <div class="col-md-3">
                <input readonly name="proses_ke" class="form-control" value="<?= $val['proses_ke'] ?>">
            </div>
            <div class="col-md-2">
                Dari :
            </div>
            <div class="col-md-4">
                <input readonly name="dari" class="form-control" value="<?= $val['dari'] ?>">
            </div>
        </div>
        <div class="col-md-12" style="<?= $baru?>"><br>
            <div class="col-md-3">
                Jumlah Alat :
            </div>
            <div class="col-md-9">
                <input readonly name="jml_alat" class="form-control" value="<?php echo $val['ket'] == 'Baru' ? $val['jml_alat'] : ''; ?>">
            </div>
        </div>
        <div class="col-md-12" style="<?= $baru?>"><br>
            <div class="col-md-3">
                Distribusi :
            </div>
            <div class="col-md-9">
                <input readonly name="distribusi" class="form-control" value="<?php echo $val['ket'] == 'Baru' ? $val['distribusi'] : ''; ?>">
            </div>
        </div>
        <div class="col-md-12" style="<?= $baru?>"><br>
            <div class="col-md-3">
                Dimensi & Toleransi (Untuk Gauge) :
            </div>
            <div class="col-md-9">
                <input readonly class="form-control" value="<?php echo $val['ket'] == 'Baru' ? $val['dimensi'] : ''; ?>">
            </div>
        </div>
        <div class="col-md-12" style="<?= $baru?>"><br>
            <div class="col-md-3">
                Flow Proses
            </div>
            <div class="col-md-2">
                Sebelumnya:
            </div>
            <div class="col-md-7">
                <input readonly name="flow_sebelum" class="form-control" value="<?php echo $val['ket'] == 'Baru' ? $val['flow_sebelum'] : ''; ?>">
            </div>
        </div>
        <div class="col-md-12" style="<?= $baru?>"><br>
            <div class="col-md-3"></div>
            <div class="col-md-2">
                Sesudahnya:
            </div>
            <div class="col-md-7">
                <input readonly name="flow_sebelum" class="form-control" value="<?php echo $val['ket'] == 'Baru' ? $val['flow_sesudah'] : ''; ?>">
            </div>
        </div>
        <div class="col-md-12" style="<?= $baru?>"><br>
            <div class="col-md-3">
                Acuan Alat Bantu :
            </div>
            <div class="col-md-9">
                <input readonly class="form-control" value="<?php echo $val['ket'] == 'Baru' ? $val['acuan_alat'] : ''; ?>">
            </div>
        </div>
        <div class="col-md-12" style="<?= $baru?>"><br>
            <div class="col-md-3">
                Layout Alat Bantu :
            </div>
            <?= $layout?>
        </div>
        <div class="col-md-12" style="<?= $baru?>"><br>
            <div class="col-md-3">
                Material Blank (Khusus DIES) :
            </div>
            <?= $material?>
        </div>
        <div class="col-md-12" style="<?= $modifrekon?>"><br>
            <div class="col-md-3">
                Alasan Modifikasi :
            </div>
            <div class="col-md-9">
                <textarea disabled style="width:100%"><?php echo $val['ket'] != 'Baru' ? $val['alasan'] : ''; ?></textarea>
            </div>
        </div>
        <div class="col-md-12"><br>
            <div class="col-md-3">
                Referensi / Datum Alat Bantu :
            </div>
            <div class="col-md-9">
                <textarea disabled style="width:100%"><?= $val['referensi'] ?></textarea>
            </div>
        </div>
        <?php if(!empty($val['stp_gambar_kerja'])){?>
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
        <?php }?>
        <div class="col-md-12"><br>
            <div class="col-md-3">
                Assign Approval :
            </div>
            <div class="col-md-9">
                <input readonly class="form-control" value="<?= $val['assign'] ?>">
            </div>
        </div>
        <div class="col-md-12"><br>
            <div class="col-md-3">
                Assign Desainer :
            </div>
            <div class="col-md-9">
                <input readonly class="form-control" value="<?= $val['assign_desainer'] ?>">
            </div>
        </div>
        <div class="col-md-12 text-center" style="<?= $terima?>"><br>
            <button class="btn btn-danger" formaction="<?php echo base_url("OrderToolMaking/MonitoringOrder/terimabarang")?>"><i class="fa fa-check"></i> Terima</button>
        </div>
    </div>
</div>
