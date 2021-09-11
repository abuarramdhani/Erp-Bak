<?php 
		// echo "<pre>";print_r($approval);exit();?>
<div class="row" id="page-border" style="padding:0px;">
<table style="width: 100%; border-bottom :0px; border-collapse: collapse; font-size: 11.5px" >
    <tr>
        <td rowspan="6" colspan="2" style="width: 15%; border-bottom :0px; border-collapse: collapse;text-align:center; border: 1px solid black">
            <img style="width: 50px;height: 70px" src="<?php echo base_url('assets/img/logo.png'); ?>">
            <p style="font-size: 11px">CV KARYA HIDUP SENTOSA</p>
            <p style="font-size: 10px">Jl Magelang 144, Yogyakarta</p>
        </td>
        <td rowspan="6" colspan="5" style="width: 50%; border-bottom :0px; border-collapse: collapse;text-align:center;font-weight:bold;border: 1px solid black">
            <p style="font-size:30px; ">ORDER</p>
            <p style="font-size:18px; ">PEMBUATAN ALAT BANTU PRODUKSI DAN SPARE PART di UNIT TOOL MAKING</p>
        </td>
        <td style="width:12%;border-bottom :0px; border-collapse: collapse; border: 1px solid black">
            No. Order
        </td>
        <td style="width:14%;border-bottom :0px; border-collapse: collapse;text-align:center; border: 1px solid black">
            <?= $fix['no_order']?>
        </td>
        <td rowspan="2" style="border-bottom :0px; border-collapse: collapse; border: 1px solid black">
            User : <span style="font-size:9px"><?= $fix['user_nama']?></span>
        </td>
    </tr>
    
    <tr>
        <td style="border-bottom :0px; border-collapse: collapse; border: 1px solid black">
            Tanggal Order
        </td>
        <td style="border-bottom :0px; border-collapse: collapse; border: 1px solid black">
            <?= $fix['tgl_order']?>
        </td>
    </tr>
    
    <tr>
        <td style="border-bottom :0px; border-collapse: collapse; border: 1px solid black">
            Seksi Pengorder
        </td>
        <td style="border-bottom :0px; border-collapse: collapse; border: 1px solid black;font-size:9px">
            <?= $fix['seksi']?>
        </td>
        <td rowspan="2" style="border-bottom :0px; border-collapse: collapse;text-align:center; border: 1px solid black">
            No. Proposal : <br><?= $fix['no_proposal'] ?>
        </td>
    </tr>
    
    <tr>
        <td style="border-bottom :0px; border-collapse: collapse; border: 1px solid black">
            Unit Pengorder
        </td>
        <td style="border-bottom :0px; border-collapse: collapse; border: 1px solid black;font-size:9px">
            <?= $fix['unit'] ?>
        </td>
    </tr>
    
    <tr>
        <td rowspan="2" style="border-bottom :0px; border-collapse: collapse; border: 1px solid black">
           Tanggal Estimasi Order Selesai
        </td>
        <td style="border-bottom :0px; border-collapse: collapse;text-align:center; border: 1px solid black">
            Usulan Seksi
        </td>
        <td style="border-bottom :0px; border-collapse: collapse; border: 1px solid black">
            Estimasi PPC TM **)
        </td>
    </tr>
    
    <tr>
        <td style="border-bottom :0px; border-collapse: collapse; border: 1px solid black;text-align:center;">
            <?= $fix['tgl_usul'] ?>
        </td>
        <td style="border-bottom :0px; border-collapse: collapse; border: 1px solid black;text-align:center;">
            <?= $fix['estimasi_finish'] ?>
        </td>
    </tr>
    
    <tr>
        <td style="width:8%;border-bottom :0px; border-collapse: collapse;text-align:center; border: 1px solid black">
        <?php $tanda = $fix['jenis'] == 'DIES' ? '&#9745;' : '&#9744;'; ?>
            <p style="font-family: DejaVu Sans, sans-serif;font-size:20px"><?= $tanda?></p>
            <p>DIES</p>
        </td>
        <td style="width:8%;border-bottom :0px; border-collapse: collapse;text-align:center; border: 1px solid black">
        <?php $tanda = $fix['jenis'] == 'MOULD/POLA' ? '&#9745;' : '&#9744;'; ?>
            <p style="font-family: DejaVu Sans, sans-serif;font-size:20px"><?= $tanda?></p>
            <p>MOULD/POLA</p>
        </td>
        <td style="width:8%;border-bottom :0px; border-collapse: collapse;text-align:center; border: 1px solid black">
        <?php $tanda = $fix['jenis'] == 'IJSM' ? '&#9745;' : '&#9744;'; ?>
            <p style="font-family: DejaVu Sans, sans-serif;font-size:20px"><?= $tanda?></p>
            <p>IJSM</p>
        </td>
        <td style="width:10%;border-bottom :0px; border-collapse: collapse;text-align:center; border: 1px solid black">
        <?php $tanda = $fix['jenis'] == 'INSPECTION JIG' ? '&#9745;' : '&#9744;'; ?>
            <p style="font-family: DejaVu Sans, sans-serif;font-size:20px"><?= $tanda?></p>
            <p>INSPECTION JIG</p>
        </td>
        <td style="width:9%;border-bottom :0px; border-collapse: collapse;text-align:center; border: 1px solid black">
        <?php $tanda = $fix['jenis'] == 'TEMPLATE' ? '&#9745;' : '&#9744;'; ?>
            <p style="font-family: DejaVu Sans, sans-serif;font-size:20px"><?= $tanda?></p>
            <p>TEMPLATE</p>
        </td>
        <td style="width:9%;border-bottom :0px; border-collapse: collapse;text-align:center; border: 1px solid black">
        <?php $tanda = $fix['jenis'] == 'DRILL JIG' ? '&#9745;' : '&#9744;'; ?>
            <p style="font-family: DejaVu Sans, sans-serif;font-size:20px"><?= $tanda?></p>
            <p>DRILL JIG</p>
        </td>
        <td style="width:12%;border-bottom :0px; border-collapse: collapse;text-align:center; border: 1px solid black">
        <?php $tanda = stripos($fix['jenis'], 'FIXTURE') !== FALSE ? '&#9745;' : '&#9744;'; 
            $value = stripos($fix['jenis'], 'FIXTURE') !== FALSE ? substr($fix['jenis'],8) : '_________________'; ?>
            <p><span style="font-family: DejaVu Sans, sans-serif;font-size:20px"><?= $tanda?></span> FIXTURE</p>
            <p>( <?= $value?> )</p>
        </td>
        <td style="border-bottom :0px; border-collapse: collapse; text-align:center; border: 1px solid black">
        <?php $tanda = stripos($fix['jenis'], 'MASTER') !== FALSE ? '&#9745;' : '&#9744;';
            $value = stripos($fix['jenis'], 'MASTER') !== FALSE ? substr($fix['jenis'],7) : '_________________'; ?>
            <p><span style="font-family: DejaVu Sans, sans-serif;font-size:20px"><?= $tanda?></span> MASTER</p>
            <p>( <?= $value?> )</p>
        </td>
        <td style="border-bottom :0px; border-collapse: collapse; text-align:center; border: 1px solid black">        
        <?php $tanda = stripos($fix['jenis'], 'GAUGE') !== FALSE ? '&#9745;' : '&#9744;'; 
            $value = stripos($fix['jenis'], 'GAUGE') !== FALSE ? substr($fix['jenis'],6) : '_________________';?>
            <p><span style="font-family: DejaVu Sans, sans-serif;font-size:20px"><?= $tanda?></span> GAUGE</p>
            <p>( <?= $value?> )</p>
        </td>
        <td style="border-bottom :0px; border-collapse: collapse; text-align:center; border: 1px solid black"> 
        <?php $tanda = stripos($fix['jenis'], 'ALAT LAIN') !== FALSE ? '&#9745;' : '&#9744;';
            $value = stripos($fix['jenis'], 'ALAT LAIN') !== FALSE ? substr($fix['jenis'],10) : '_________________'; ?>
            <p><span style="font-family: DejaVu Sans, sans-serif;font-size:20px"><?= $tanda?></span> ALAT LAIN</p>
            <p>( <?= $value?> )</p>
        </td>
    </tr>
    <tr>
        <td colspan="7" style="border-bottom :0px; border-collapse: collapse; text-align:center; border: 1px solid black;font-weight:bold;font-style:italic">RINCIAN ORDER</td>
        <td colspan="3" style="border-bottom :0px; border-collapse: collapse; border-right: 1px solid black;font-size:11px">SKETS : </td>
    </tr>
    <tr>
        <td colspan="2" style="border-bottom :0px; border-collapse: collapse; border-left: 1px solid black;text-align:center;font-size:12px">
        <span style="font-family: DejaVu Sans, sans-serif;font-size:15px"><?php echo $fix['ket'] == 'Modifikasi' ? '&#9745;' : '&#9744;' ?></span> MODIFIKASI</td>
        <td colspan="2" style="border-bottom :0px; border-collapse: collapse; border-right: 1px solid black;text-align:center;font-size:12px">
        <span style="font-family: DejaVu Sans, sans-serif;font-size:15px"><?php echo $fix['ket'] == 'Rekondisi' ? '&#9745;' : '&#9744;' ?></span> REKONDISI</td>
        <td colspan="3" style="border-bottom :0px; border-collapse: collapse; border: 1px solid black;text-align:center;font-size:12px">
        <span style="font-family: DejaVu Sans, sans-serif;font-size:15px"><?php echo $fix['ket'] == 'Baru' ? '&#9745;' : '&#9744;' ?></span> BARU</td>
        <td colspan="3" rowspan="11" style="border-bottom :0px; border-collapse: collapse; border-right: 1px solid black;border-bottom: 1px solid black;vertical-align:top">
            <br><br>
            <span style="font-size:11px">KOMEN REVISI :</span>
            <?php foreach ($komen as $key => $k) {?>
                <p style="font-size:11px">- <?= $k['person'] ?> : <?= $k['keterangan'] ?></p>
            <?php }?>
            <br> <br>
            <span style="font-size:11px">ALASAN CANCEL / DITOLAK :</span><br>
            <span style="font-size:11px"><?= $fix['alasan_reject']?></span>
        </td>
    </tr>
    <tr>
        <td colspan="4" style="border-bottom :0px; border-collapse: collapse; border: 1px solid black;">Kode Komponen : <span style="font-size:11px"><?php echo $fix['ket'] != 'Baru' ? $fix['kodekomp'] : '' ?></span></td>
        <td colspan="3" style="border-bottom :0px; border-collapse: collapse; border: 1px solid black;">Kode Komponen : <span style="font-size:11px"><?php echo $fix['ket'] == 'Baru' ? $fix['kodekomp'] : '' ?></span></td>
    </tr>
    <tr>
        <td colspan="4" style="border-bottom :0px; border-collapse: collapse; border: 1px solid black;">Nama Komponen : <span style="font-size:11px"><?php echo $fix['ket'] != 'Baru' ? $fix['namakomp'] : '' ?></span></td>
        <td colspan="3" style="border-bottom :0px; border-collapse: collapse; border: 1px solid black;">Nama Komponen : <span style="font-size:11px"><?php echo $fix['ket'] == 'Baru' ? $fix['namakomp'] : '' ?></span></td>
    </tr>
    <tr>
        <td colspan="4" style="border-bottom :0px; border-collapse: collapse; border: 1px solid black;">Tipe Produk : <span style="font-size:11px"><?php echo $fix['ket'] != 'Baru' ? $fix['tipe_produk'] : '' ?></span></td>
        <td colspan="3" style="border-bottom :0px; border-collapse: collapse; border: 1px solid black;">Tipe Produk : <span style="font-size:11px"><?php echo $fix['ket'] == 'Baru' ? $fix['tipe_produk'] : '' ?></span></td>
    </tr>
    <tr>
        <td colspan="4" style="border-bottom :0px; border-collapse: collapse; border: 1px solid black;">Tanggal Rilis Gambar : <?php echo $fix['ket'] != 'Baru' ? $fix['tgl_rilis'] : '' ?></td>
        <td colspan="3" style="border-bottom :0px; border-collapse: collapse; border: 1px solid black;">Tanggal Rilis Gambar : <?php echo $fix['ket'] == 'Baru' ? $fix['tgl_rilis'] : '' ?></td>
    </tr>
    <tr>
        <td colspan="4" style="border-bottom :0px; border-collapse: collapse; border: 1px solid black;">No. Alat Bantu : <span style="font-size:11px"><?php echo $fix['ket'] != 'Baru' ? $fix['no_alat'] : '' ?></span></td>
        <td colspan="3" style="border-bottom :0px; border-collapse: collapse; border: 1px solid black;">Mesin Yang Diproses : <span style="font-size:11px"><?php echo $fix['ket'] == 'Baru' ? $fix['mesin'] : '' ?></span></td>
    </tr>
    <tr>
        <td colspan="4" style="border-bottom :0px; border-collapse: collapse; border-left: 1px solid black;border-top: 1px solid black;border-right: 1px solid black;">Poin Yang Diproses : </td>
        <td colspan="3" style="border-bottom :0px; border-collapse: collapse; border: 1px solid black;">Poin Yang Diproses : <span style="font-size:11px"><?php echo $fix['ket'] == 'Baru' ? $fix['poin'] : '' ?></span></td>
    </tr>
    <tr>
        <td colspan="4" rowspan="5" style="border-bottom :0px; border-collapse: collapse; border-left: 1px solid black;border-right: 1px solid black;vertical-align:top;font-size:11px">
            <?php if ($fix['ket'] != 'Baru') {
                echo $fix['poin_awal'] == $fix['poin'] ? $fix['poin'] : '<s>'.$fix['poin_awal'].'</s><br>'.$fix['rev_poin_by'].' : '.$fix['poin'];
            } ?>
        </td>
        <td style="border-bottom :0px; border-collapse: collapse; border-bottom: 1px solid black;">Proses Ke <?php echo $fix['ket'] == 'Baru' ? $fix['proses_ke'] : '....' ?></td>
        <td colspan="2" style="border-bottom :0px; border-collapse: collapse; border-bottom: 1px solid black; border-right: 1px solid black;">dari <?php echo $fix['ket'] == 'Baru' ? $fix['dari'] : '....' ?> </td>
    </tr>
    <tr>
        <td style="border-bottom :0px; border-collapse: collapse; border-bottom: 1px solid black;">Jumlah Alat :  <?php echo $fix['ket'] == 'Baru' ? $fix['jml_alat'] : '....' ?></td>
        <td colspan="2" style="border-bottom :0px; border-collapse: collapse; border-bottom: 1px solid black;border-right: 1px solid black;">Distribusi:  <?php echo $fix['ket'] == 'Baru' ? '<span style="font-size:10px">'.$fix['distribusi'].'</span>' : '....' ?> </td>
    </tr>
    <tr>
        <td colspan="3" style="border-bottom :0px; border-collapse: collapse; border-right: 1px solid black;">Dimensi dan Toleransi (Untuk Gauge) : </td>
    </tr>
    <tr>
        <td colspan="3" style="border-bottom :0px; border-collapse: collapse; border-right: 1px solid black;"><span style="font-size:11px"><?php echo $fix['ket'] == 'Baru' && !empty($fix['dimensi']) ? $fix['dimensi'] : '&nbsp;' ?></span></td>
    </tr>
    <tr>
        <td style="border-bottom :0px; border-collapse: collapse; border-left: 1px solid black;border-top: 1px solid black;">Flow Proses</td>
        <td colspan="2" style="border-bottom :0px; border-collapse: collapse; border-right: 1px solid black;border-top: 1px solid black;">sebelumnya : <span style="font-size:11px"><?php echo $fix['ket'] == 'Baru' ? $fix['flow_sebelum'] : '_________' ?></span></td>
        <td rowspan="2" style="border-bottom :0px; border-collapse: collapse; border: 1px solid black;font-size:11px">NO. ALAT BANTU****)</td>
        <td colspan="2" rowspan="2" style="border-bottom :0px; border-collapse: collapse; border: 1px solid black;text-align:center"><?= $fix['no_alat_tm'] ?></td>
    </tr>
    <tr>
        <td style="border-bottom :0px; border-collapse: collapse; border-left: 1px solid black;border-top: 1px solid black;">Proses Ke <?php echo $fix['ket'] != 'Baru' ? $fix['proses_ke'] : '....' ?></td>
        <td style="border-bottom :0px; border-collapse: collapse; border-right: 1px solid black;border-top: 1px solid black;">dari <?php echo $fix['ket'] != 'Baru' ? $fix['dari'] : '....' ?> </td>
        <td colspan="2" style="border-bottom :0px; border-collapse: collapse; border-bottom: 1px solid black;"></td>
        <td style="border-bottom :0px; border-collapse: collapse; border-left: 1px solid black;border-bottom: 1px solid black;"></td>
        <td colspan="2" style="border-bottom :0px; border-collapse: collapse; border-right: 1px solid black;border-bottom: 1px solid black;">sesudahnya : <span style="font-size:11px"><?php echo $fix['ket'] == 'Baru' ? $fix['flow_sesudah'] : '_________' ?></span></td>
    </tr>
    <tr>
        <td colspan="4" style="border-bottom :0px; border-collapse: collapse; border-left: 1px solid black;border-top: 1px solid black;border-right: 1px solid black;">Alasan Modifikasi : </td>
        <td style="border-bottom :0px; border-collapse: collapse; border-left: 1px solid black; border-top: 1px solid black;">Acuan Alat </td>
        <td colspan="2" style="border-bottom :0px; border-collapse: collapse; border-right: 1px solid black; border-top: 1px solid black;"><span style="font-family: DejaVu Sans, sans-serif;font-size:13px"><?php echo $fix['ket'] == 'Baru' && $fix['acuan_alat'] == 'Produk' ? '&#9745;' : '&#9744;'; ?></span> Produk***)</td>
        <td colspan="3" style="border-bottom :0px; border-collapse: collapse;  border-right: 1px solid black; border-top: 1px solid black;font-size:11px">REFERENSI / DATUM ALAT BANTU : </td>
    </tr>
    <tr>
        <td colspan="4" rowspan="5" style="border-bottom :0px; border-collapse: collapse; border-left: 1px solid black;border-right: 1px solid black;vertical-align:top;font-size:11px"><?php echo $fix['ket'] != 'Baru' ? $fix['alasan'] : '' ?></td>
        <td style="border-bottom :0px; border-collapse: collapse; border-left: 1px solid black;">Bantu : </td>
        <td colspan="2" style="border-bottom :0px; border-collapse: collapse; border-right: 1px solid black;"><span style="font-family: DejaVu Sans, sans-serif;font-size:13px"><?php echo $fix['ket'] == 'Baru' && $fix['acuan_alat'] != 'Produk' ? '&#9745;' : '&#9744;'; ?></span> Gambar Produk</td>
        <td colspan="3" style="border-bottom :0px; border-collapse: collapse;  border-right: 1px solid black; font-size:9px">(diisi oleh pengorder)</td>
    </tr>
    <tr>
        <td style="border-bottom :0px; border-collapse: collapse; border-left: 1px solid black;border-top: 1px solid black;">Layout Alat </td>
        <td colspan="2" style="border-bottom :0px; border-collapse: collapse; border-right: 1px solid black;border-top: 1px solid black;"><span style="font-family: DejaVu Sans, sans-serif;font-size:13px"><?php echo $fix['ket'] == 'Baru' && $fix['layout_alat'] == 'Tunggal' ? '&#9745;' : '&#9744;'; ?></span> Tunggal</td>
        <td colspan="3" rowspan="4" style="border-bottom :0px; border-collapse: collapse;  border-right: 1px solid black;vertical-align:top;font-size:11px"><?= $fix['referensi'] ?></td>
    </tr>
    <tr>
        <td style="border-bottom :0px; border-collapse: collapse; border-left: 1px solid black;">Bantu : </td>
        <td colspan="2" style="border-bottom :0px; border-collapse: collapse; border-right: 1px solid black;"><span style="font-family: DejaVu Sans, sans-serif;font-size:13px"><?php echo $fix['ket'] == 'Baru' && $fix['layout_alat'] != 'Tunggal' ? '&#9745;' : '&#9744;'; ?></span> Multi (QTY <?php echo $fix['ket'] == 'Baru' && $fix['layout_alat'] != 'Tunggal' ? $fix['layout_alat'] : '_____'; ?> )</td>
    </tr>
    <tr>
        <td style="border-bottom :0px; border-collapse: collapse; border-left: 1px solid black;border-top: 1px solid black;">Material Blank </td>
        <td colspan="2" style="border-bottom :0px; border-collapse: collapse; border-right: 1px solid black;border-top: 1px solid black;"><span style="font-family: DejaVu Sans, sans-serif;font-size:13px"><?php echo $fix['ket'] == 'Baru' && $fix['material'] == 'Afval' ? '&#9745;' : '&#9744;'; ?></span> Afval</td>
    </tr>
    <tr>
        <td style="border-bottom :0px; border-collapse: collapse; border-left: 1px solid black;">(Khusus Dies) : </td>
        <td colspan="2" style="border-bottom :0px; border-collapse: collapse; border-right: 1px solid black;"><span style="font-family: DejaVu Sans, sans-serif;font-size:13px"><?php echo $fix['ket'] == 'Baru' && $fix['material'] != 'Afval' && $fix['jenis'] == 'DIES' ? '&#9745;' : '&#9744;'; ?></span> Lembaran 
        <?php if ($fix['ket'] == 'Baru' && $fix['material'] != 'Afval' && $fix['jenis'] == 'DIES') {
                $material = substr($fix['material'],9);
                $value 	= explode(" X ", $material);
                echo '( '.$value[0].' X '.$value[1].' )';
            }else{ echo "( ... X ... )"; }?>
        </td>
    </tr>
    <tr>
        <td colspan="4" style="border-bottom :0px; border-collapse: collapse; border: 1px solid black;text-align:center; ">Pemberi Order</td>
        <td colspan="4" style="border-bottom :0px; border-collapse: collapse; border: 1px solid black;text-align:center; ">Menyetujui</td>
        <td colspan="2" style="border-bottom :0px; border-collapse: collapse; border: 1px solid black;text-align:center; ">Penerima Order</td>
    </tr>
    <tr>
        <td style="border-bottom :0px; border-collapse: collapse; border: 1px solid black;text-align:center;height:35px ">Approved</td>
        <td style="border-bottom :0px; border-collapse: collapse; border: 1px solid black;text-align:center; "><?= in_array(2, $approval) ? 'Approved' : '-'; ?></td>
        <td style="border-bottom :0px; border-collapse: collapse; border: 1px solid black;text-align:center; "><?= in_array(3, $approval) ? 'Approved' : '-'; ?></td>
        <td style="border-bottom :0px; border-collapse: collapse; border: 1px solid black;text-align:center; "><?= in_array(4, $approval) ? 'Approved' : '-'; ?></td>
        <td colspan="2" style="border-bottom :0px; border-collapse: collapse; border: 1px solid black;text-align:center; "><?= in_array(5, $approval) ? 'Approved' : '-'; ?></td>
        <td style="border-bottom :0px; border-collapse: collapse; border: 1px solid black;text-align:center; "><?= in_array(6, $approval) ? 'Approved' : '-'; ?></td>
        <td style="border-bottom :0px; border-collapse: collapse; border: 1px solid black;text-align:center; "><?= in_array(7, $approval) ? 'Approved' : '-'; ?></td>
        <td style="border-bottom :0px; border-collapse: collapse; border: 1px solid black;text-align:center; "><?= in_array(4, $approval) ? 'Approved' : '-'; ?></td>
        <td style="border-bottom :0px; border-collapse: collapse; border: 1px solid black;text-align:center; "><?= in_array(9, $approval) ? 'Approved' : '-'; ?></td>
    </tr>
    <tr>
        <td style="border-bottom :0px; border-collapse: collapse; border: 1px solid black;text-align:center; ">Kepala Seksi Pengorder</td>
        <td style="border-bottom :0px; border-collapse: collapse; border: 1px solid black;text-align:center; ">Ass./Ka.Unit Pengorder</td>
        <td style="border-bottom :0px; border-collapse: collapse; border: 1px solid black;text-align:center; ">Kepala Seksi PE</td>
        <td style="border-bottom :0px; border-collapse: collapse; border: 1px solid black;text-align:center; ">Ass./Ka.Unit PE</td>
        <td colspan="2" style="border-bottom :0px; border-collapse: collapse; border: 1px solid black;text-align:center; ">Ka.Dep Produksi</td>
        <td style="border-bottom :0px; border-collapse: collapse; border: 1px solid black;text-align:center; ">Unit QC/QA*)</td>
        <td style="border-bottom :0px; border-collapse: collapse; border: 1px solid black;text-align:center; ">Designer Produk</td>
        <td style="border-bottom :0px; border-collapse: collapse; border: 1px solid black;text-align:center; ">Ass./Ka.Unit Tool Making</td>
        <td style="border-bottom :0px; border-collapse: collapse; border: 1px solid black;text-align:center; ">Kepala Seksi Tool Making</td>
    </tr>
    <tr>
        <td colspan="7" style="border-bottom :0px; border-collapse: collapse; border-left: 1px solid black;">Note :</td>
        <td colspan="3" style="border-bottom :0px; border-collapse: collapse; border-right: 1px solid black;border-left: 1px solid black;font-weight:bold"> Tanggung Jawab dan Wewenang Approve:</td>
    </tr>
    <tr>
        <td colspan="7" style="border-bottom :0px; border-collapse: collapse; border-left: 1px solid black;border-bottom: 1px solid black;vertical-align:top;font-size:10.5px">
            <p>1. Berilah tanda ( <span style="font-family: DejaVu Sans, sans-serif;font-size:14px">&#10003;</span> ) pada kotak ( <span style="font-family: DejaVu Sans, sans-serif;font-size:11px">&#9744;</span> ) yang tersedia.</p>
            <p>2. (*) Khusus untuk Order Gauge dan Inspection Jig harus diketahui minimal Ka.Si.</p>
            <p>3. (**) Kolom "Tanggal Estimasi Order Selesai" diisi oleh PPC TM dan hanya untuk hal <strong>EMERGENCY</strong> atau mengganggu rutin bulan berjalan. Untuk Alat Bantu yang tidak Emergency, Estimasi Finish ditentukan berdasarkan prioritas mingguan dan diisi oleh PPC TM berdasarkan instruksi Kepala Unit Tool Making.</p>
            <p>4. Jalur order mengikuti COP Alur Order ke Tool Making (COP-TMK-02-01).</p>
            <p>5. (***) Apabila Acuan Alat Bantu adalah Produk, maka pengorder menyatakan Data Inspection Report dari Produk tersebut.</p>
            <p>6. (****) No. Alat Bantu Diisi oleh Desain Tool Making untuk Order Alat Bantu / Alat Bantu Ukur baru.</p>
        </td>
        <td style="border-bottom :0px; border-collapse: collapse; border-bottom: 1px solid black;border-left: 1px solid black;width:11%;vertical-align:top;font-size:10.5px"> 
            <p>1. Ka. Dep. Produksi</p>
            <p>2. Unit QC / QA</p>
            <p>3. Design Produk</p><br>
            <p>4. Ka. Si. Pemberi Order</p>
        </td>
        <td colspan="2" style="border-bottom :0px; border-collapse: collapse; border-right: 1px solid black;border-bottom: 1px solid black;vertical-align:top;font-size:10.5px"> 
            <p>: Nilai Prioritas perusahaan</p>
            <p>: Toleransi dan Fungsional Alat Bantu Ukur</p>
            <p>: Tanggal Rilis Gambar, kode komponen terbaru, kemungkinan terjadi perubahan Gambar Produk</p>
            <p>: Sesuai kebutuhan, perhatikan ukuran produk termasuk kestabilan dalam penggunaan</p>
            <br><br>
            <p style="text-style:italic;text-align:right; font-size:10px">FRM- TMK - 02 - 09 (Rev.06-27Februari 2017)</p>
        </td>
    </tr>
</table>
</div>