<?php
if(stripos($fix['jenis'], 'FIXTURE') !== FALSE || stripos($fix['jenis'], 'MASTER') !== FALSE || stripos($fix['jenis'], 'GAUGE') !== FALSE || stripos($fix['jenis'], 'ALAT LAIN') !== FALSE) {
    // memisahkan jenis dan keterangan jenis
    if (stripos($fix['jenis'], 'FIXTURE') !== FALSE) {
        $nama = substr($fix['jenis'],0,7);
    }elseif (stripos($fix['jenis'], 'MASTER') !== FALSE) {
        $nama = substr($fix['jenis'],0,6);
    }elseif (stripos($fix['jenis'], 'GAUGE') !== FALSE) {
        $nama = substr($fix['jenis'],0,5);
    }elseif (stripos($fix['jenis'], 'ALAT LAIN') !== FALSE) {
        $nama = substr($fix['jenis'],0,9);
    }
}else{
    $nama = $fix['jenis'];
}
?>
<div class="row" id="page-border" style="padding:0px;">
<table style="width: 100%; border-bottom :0px; border-collapse: collapse; font-size: 11.5px" >
    <tr>
        <td rowspan="3" style="width: 7%; border-bottom :0px; border-collapse: collapse;text-align:center;border: 1px solid black">
            <img style="width: 50px;height: 70px" src="<?php echo base_url('assets/img/logo.png'); ?>">
        </td>
        <td style="width: 50%; border-bottom :0px; border-collapse: collapse;text-align:left; border-top: 1px solid black; border-left: 1px solid black">
            <p style="font-size:15px; ">CV. KARYA HIDUP SENTOSA</p>
            <p style="font-size:15px; ">YOGYAKARTA</p>
        </td>
        <td style="width:12%;border-bottom :0px; border-collapse: collapse; border-top: 1px solid black;border-right: 1px solid black; font-weight:bold">
            No : <?= $fix['no_proposal']?>
        </td>
    </tr>
    <tr>
        <td colspan="2" style="border-bottom :0px; border-collapse: collapse;text-align:center; border-left: 1px solid black; border-bottom: 1px solid black; border-right: 1px solid black; font-weight:bold">
            <p style="font-size:20px; ">PROPOSAL PENGADAAN ASSET</p>
        </td>
    </tr>
</table>
</div>
<div class="row" id="page-border" style="padding-top:10px;">
<table style="width: 100%; border-bottom :0px; border-collapse: collapse; font-size: 13px" >
    <tr>
        <td colspan="4" style="width: 50%; border-bottom :0px; border-collapse: collapse;text-align:left; border: 0px solid black;font-weight:bold">
            <p style="font-size:15px; ">I. Asset yang Dibutuhkan</p>
        </td>
    </tr>
    <tr>
        <td colspan="4" style="border-bottom :0px; border-collapse: collapse;text-align:left; border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; ">
            <p>a. Kategori Asset : (Pilih salah satu dengan tanda V)</p>
        </td>
    </tr>
    <tr>
        <td style="padding-left:17px;border-bottom :0px; border-collapse: collapse;text-align:left; border-left: 1px solid black;">
            <span style="font-family: DejaVu Sans, sans-serif;font-size:15px">&#9744;</span> Tanah
        </td>
        <td style="width:25%;border-bottom :0px; border-collapse: collapse;text-align:left; ">
            <span style="font-family: DejaVu Sans, sans-serif;font-size:15px">&#9744;</span> Mobil / Truk
        </td>
        <td  style="width:25%;border-bottom :0px; border-collapse: collapse;text-align:left; ">
            <span style="font-family: DejaVu Sans, sans-serif;font-size:15px">
            <?php if ($fix['jenis'] == 'TEMPLATE' || stripos($fix['jenis'], 'MASTER') !== FALSE || stripos($fix['jenis'], 'GAUGE') !== FALSE ) {
                echo '&#9745;'; }else{ echo '&#9744;'; }?>
            </span> Peralatan Pabrik ***)
        </td>
        <td style="border-bottom :0px; border-collapse: collapse;text-align:left; border-right: 1px solid black;">
            <span style="font-family: DejaVu Sans, sans-serif;font-size:15px">&#9744;</span> Asset Takk Berwujud ****)
        </td>
    </tr>
    <tr>
        <td style="padding-left:17px;border-bottom :0px; border-collapse: collapse;text-align:left; border-left: 1px solid black;">
            <span style="font-family: DejaVu Sans, sans-serif;font-size:15px">&#9744;</span> Bangunan
        </td>
        <td style="width:25%;border-bottom :0px; border-collapse: collapse;text-align:left; ">
            <span style="font-family: DejaVu Sans, sans-serif;font-size:15px">&#9744;</span> Kendaraan Roda 2 / 3
        </td>
        <td colspan="2" style="border-bottom :0px; border-collapse: collapse;text-align:left; border-right: 1px solid black;">
            <span style="font-family: DejaVu Sans, sans-serif;font-size:15px">
            <?php if ($fix['jenis'] == 'IJSM' || $fix['jenis'] == 'INSPECTION JIG' || $fix['jenis'] == 'DRILL JIG' || stripos($fix['jenis'], 'FIXTURE') !== FALSE ) {
                echo '&#9745;'; }else{ echo '&#9744;'; }?>
            </span> Jig & Fixtures
        </td>
    </tr>
    <tr>
        <td style="padding-left:17px;border-bottom :0px; border-collapse: collapse;text-align:left; border-left: 1px solid black;border-bottom: 1px solid black;">
            <span style="font-family: DejaVu Sans, sans-serif;font-size:15px">&#9744;</span> Mesin
        </td>
        <td style="width:25%;border-bottom :0px; border-collapse: collapse;text-align:left;border-bottom: 1px solid black; ">
            <span style="font-family: DejaVu Sans, sans-serif;font-size:15px">&#9744;</span> Perlengkapan Kantor **)
        </td>
        <td colspan="2" style="border-bottom :0px; border-collapse: collapse;text-align:left;border-bottom: 1px solid black; border-right: 1px solid black;">
            <span style="font-family: DejaVu Sans, sans-serif;font-size:15px">
            <?php if ($fix['jenis'] == 'DIES' || $fix['jenis'] == 'MOULD/POLA') {
                echo '&#9745;'; }else{ echo '&#9744;'; }?>
            </span> Dies & Pola (Pattern / Mould)
        </td>
    </tr>
</table>
<table style="width: 100%; border-bottom :0px; border-collapse: collapse; font-size: 13px" >
    <tr>
        <td colspan="2" style="border-bottom :0px; border-collapse: collapse;text-align:left; border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; ">
            <p>b. Jenis Asset : <span style="font-style:italic">(Pilih salah satu dengan tanda V)</span></p>
        </td>
    </tr>
    <tr>
        <td style="padding-left:17px;border-bottom :0px; border-collapse: collapse;text-align:left; border-left: 1px solid black;border-bottom: 1px solid black;">
            <span style="font-family: DejaVu Sans, sans-serif;font-size:15px">&#9744;</span> Asset yang Dibiayakan (Expaned Asset)
        </td>
        <td style="border-bottom :0px; border-collapse: collapse;text-align:left; border-bottom: 1px solid black; border-right: 1px solid black;">
            <span style="font-family: DejaVu Sans, sans-serif;font-size:15px">&#9745;</span> Asset Tetap (Capitalized Asset)
        </td>
        </td>
    </tr>
</table>
<table style="width: 100%; border-bottom :0px; border-collapse: collapse; font-size: 13px" >
    <tr>
        <td colspan="3" style="border-bottom :0px; border-collapse: collapse;text-align:left; border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; ">
            <p>c. Perolehan Asset : <span style="font-style:italic">(Pilih salah satu dengan tanda </span></p>
        </td>
    </tr>
    <tr>
        <td style="padding-left:17px;border-bottom :0px; border-collapse: collapse;text-align:left; border-left: 1px solid black;border-bottom: 1px solid black;">
            <span style="font-family: DejaVu Sans, sans-serif;font-size:15px">&#9744;</span> Dibeli melalui Pembelian
        </td>
        <td style="border-bottom :0px; border-collapse: collapse;text-align:left;border-bottom: 1px solid black; ">
            <span style="font-family: DejaVu Sans, sans-serif;font-size:15px">&#9745;</span> Dibuat di KHS
        </td>
        <td style="border-bottom :0px; border-collapse: collapse;text-align:left; border-bottom: 1px solid black; border-right: 1px solid black;">
            <span style="font-family: DejaVu Sans, sans-serif;font-size:15px">&#9744;</span> Diambil dari Stock Gudang
        </td>
        </td>
    </tr>
</table>
<table style="width: 100%; border-bottom :0px; border-collapse: collapse; font-size: 13px" >
    <tr>
        <td style="border-bottom :0px; border-collapse: collapse;text-align:left; border-left: 1px solid black; border: 1px solid black; ">
            <p>d. Seksi Pemakai : <?= $fix['user_nama']?></p>
        </td>
    </tr>
</table>
</div>

<div class="row" id="page-border" style="padding-top:10px;">
<table style="width: 100%; border-bottom :0px; border-collapse: collapse; font-size: 13px;" >
    <tr>
        <td colspan="6" style="border-bottom :0px; border-collapse: collapse;text-align:left; border: 1px solid black; ">
            <p>e. Rencana Kebuatuhan <span style="font-style:italic">(dalam satu kategori)</span></p>
        </td>
    </tr>
    <tr>
        <td style="width:5%;border-bottom :0px; border-collapse: collapse;text-align:center; border: 1px solid black; ">No.</td>
        <td style="border-bottom :0px; border-collapse: collapse;text-align:center; border: 1px solid black; ">Kode Barang</td>
        <td style="border-bottom :0px; border-collapse: collapse;text-align:center; border: 1px solid black; ">Nama Asset</td>
        <td style="width:40%;border-bottom :0px; border-collapse: collapse;text-align:center; border: 1px solid black; ">Spesifikasi Asset</td>
        <td style="width:10%;border-bottom :0px; border-collapse: collapse;text-align:center; border: 1px solid black; ">Jumlah Kebutuhan</td>
        <td style="width:10%;border-bottom :0px; border-collapse: collapse;text-align:center; border: 1px solid black; ">Umur Teknis (Th)</td>
    </tr>
    <tr>
        <td style="width:5%;border-bottom :0px; border-collapse: collapse;text-align:center; border: 1px solid black; ">1</td>
        <td style="border-bottom :0px; border-collapse: collapse;text-align:center; border: 1px solid black; "></td>
        <td style="border-bottom :0px; border-collapse: collapse;text-align:center; border: 1px solid black; "><?= $nama?></td>
        <td style="width:40%;border-bottom :0px; border-collapse: collapse;text-align:center; border: 1px solid black; "><?= $fix['namakomp']?></td>
        <td style="width:10%;border-bottom :0px; border-collapse: collapse;text-align:center; border: 1px solid black; "><?= $fix['jml_alat']?></td>
        <td style="width:10%;border-bottom :0px; border-collapse: collapse;text-align:center; border: 1px solid black; "></td>
    </tr>
    <?php for ($i=0; $i < 6; $i++) { ?>
    <tr>
        <td style="height:20px;border-bottom :0px; border-collapse: collapse;text-align:center; border: 1px solid black; "></td>
        <td style="height:20px;border-bottom :0px; border-collapse: collapse;text-align:center; border: 1px solid black; "></td>
        <td style="height:20px;border-bottom :0px; border-collapse: collapse;text-align:center; border: 1px solid black; "></td>
        <td style="height:20px;border-bottom :0px; border-collapse: collapse;text-align:center; border: 1px solid black; "></td>
        <td style="height:20px;border-bottom :0px; border-collapse: collapse;text-align:center; border: 1px solid black; "></td>
        <td style="height:20px;border-bottom :0px; border-collapse: collapse;text-align:center; border: 1px solid black; "></td>
    </tr>
    <?php }?>
</table>
</div>
<div class="row" id="page-border" style="padding-top:10px;">
<table style="width: 100%; border-bottom :0px; border-collapse: collapse; font-size: 13px" >
    <tr>
        <td style="border-bottom :0px; border-collapse: collapse;text-align:left; border: 0px solid black;font-weight:bold">
            <p style="font-size:15px; ">II. Alasan Pengadaan Asset</p>
        </td>
    </tr>
    <tr>
        <td style="height:100px;vertical-align:top;border-bottom :0px; border-collapse: collapse;text-align:left; border: 1px solid black; ">
            <?= $fix['alasan_asset']?>
        </td>
    </tr>
</table>
</div>
<div class="row" id="page-border" style="padding-top:10px;">
<table style="width: 100%; border-bottom :0px; border-collapse: collapse; font-size: 13px" >
    <tr>
        <td style="border-bottom :0px; border-collapse: collapse;text-align:center; border: 1px solid black; ">Kepala Seksi</td>
        <td style="border-bottom :0px; border-collapse: collapse;text-align:center; border: 1px solid black; ">Kepala Unit</td>
        <td style="border-bottom :0px; border-collapse: collapse;text-align:center; border: 1px solid black; ">Pengelola Asset</td>
        <td style="border-bottom :0px; border-collapse: collapse;text-align:center; border: 1px solid black; ">Kepala Department</td>
        <td style="border-bottom :0px; border-collapse: collapse;text-align:center; border: 1px solid black; ">Direktur Utama *)</td>
    </tr>
    <tr>
        <td style="height:100px;width:20%;border-bottom :0px; border-collapse: collapse;text-align:center;vertical-align:bottom; border: 1px solid black; ">(<?= $fix['pengorder'].' - '.$fix['nama_pengorder']?>)</td>
        <td style="height:100px;width:20%;border-bottom :0px; border-collapse: collapse;text-align:center;vertical-align:bottom; border: 1px solid black; ">(<?= !empty($approval[2]) ? $fix['assign_approval'].' - '.$fix['nama_assignapproval'] : '.........................'?>)</td>
        <td style="height:100px;width:20%;border-bottom :0px; border-collapse: collapse;text-align:center;vertical-align:bottom; border: 1px solid black; ">
        (<?php if ($fix['jenis'] == 'DIES' || $fix['jenis'] == 'MOULD/POLA' || $fix['jenis'] == 'TEMPLATE' || $fix['jenis'] == 'DRILL JIG' || stripos($fix['jenis'], 'FIXTURE') !== FALSE ) {
            echo !empty($approval[9]) ? $approval[9]['approved_by'].' - '.$approval[9]['nama_approver'] : '.........................';
        }else{
            echo !empty($approval[6]) ? $approval[6]['approved_by'].' - '.$approval[6]['nama_approver'] : '.........................';
        }  ?>)</td>
        <td style="height:100px;width:20%;border-bottom :0px; border-collapse: collapse;text-align:center;vertical-align:bottom; border: 1px solid black; ">(<?= !empty($approval[7]) ? $approval[7]['approved_by'].' - '.$approval[7]['nama_approver'] : '.........................'?>)</td>
        <td style="height:100px;width:20%;border-bottom :0px; border-collapse: collapse;text-align:center;vertical-align:bottom; border: 1px solid black; ">(.........................)</td>
    </tr>
    <tr>
        <td style="border-bottom :0px; border-collapse: collapse;text-align:left; border: 1px solid black; ">Tgl. <?= $fix['tgl_order']?></td>
        <td style="border-bottom :0px; border-collapse: collapse;text-align:left; border: 1px solid black; ">Tgl : 
        (<?php if ($fix['jenis'] == 'DIES' || $fix['jenis'] == 'MOULD/POLA' || $fix['jenis'] == 'TEMPLATE' || $fix['jenis'] == 'DRILL JIG' || stripos($fix['jenis'], 'FIXTURE') !== FALSE ) {
            echo !empty($approval[9]) ? $approval[9]['approve_date'] : '.........................';
        }else{
            echo !empty($approval[6]) ? $approval[6]['approve_date'] : '.........................';
        }  ?>) </td>
        <td style="border-bottom :0px; border-collapse: collapse;text-align:left; border: 1px solid black; ">Tgl : <?= !empty($approval[2]) ? $approval[2]['approve_date'] : '.........................'?> </td>
        <td style="border-bottom :0px; border-collapse: collapse;text-align:left; border: 1px solid black; ">Tgl : <?= !empty($approval[7]) ? $approval[7]['approve_date'] : '.........................'?> </td>
        <td style="border-bottom :0px; border-collapse: collapse;text-align:left; border: 1px solid black; ">Tgl : ......................... </td>
    </tr>
</table>
</div>
<div class="row" id="page-border" style="padding-top:10px;">
<table style="width: 100%; border-bottom :0px; border-collapse: collapse; font-size: 11px" >
    <tr>
        <td colspan="2" style="border-bottom :0px; border-collapse: collapse;text-align:left;">
            <p>Note : Form ini dilampirkan dalam pengajuan PP yang masuk kategori Asset.</p>
        </td>
    </tr>
    <tr>
        <td style="width: 5%; border-bottom :0px; border-collapse: collapse;text-align:right;">
            <p>*)</p>
        </td>
        <td style="padding-left:10px;border-bottom :0px; border-collapse: collapse;text-align:left;">
            <p>Otorisasi Proposal Pengadaan Asset sesuai dengan SOP F&A-10 proposal pengadaan asset</p>
        </td>
    </tr>
    <tr>
        <td style="width: 5%; vertical-align:top; border-bottom :0px; border-collapse: collapse;text-align:right;">
            <p>**)</p>
        </td>
        <td style="padding-left:10px;border-bottom :0px; border-collapse: collapse;text-align:left;">
            <p><b>Perlengkapan Kantor</b> meliputi : <u>Hardware</u> <i>(laptop, viewer, server, CPU, printer, dll)</i>, 
            <u>Furniture</u> <i>(meja, kursi, almari, rak, cabinet, dll)</i>, 
            <u>Alat Komunikasi</u> </i>(handphone, handset, HT, PABX, TV, faksimili, GPS tracker, kamera, handycame, pesawat telephone, dll)</i>, 
            <u>Alat Pendukung Kantor</u> <i>(scanner, barcode scanner, penghancur kertas, mesin fotocopy, penghitung uang, dll)</i>, 
            <u>Alat Penyegar Udara</u> <i>(AC, fan, dll)</i>.</p>
        </td>
    </tr>
    <tr>
        <td style="width: 5%; border-bottom :0px; border-collapse: collapse;text-align:right;">
            <p>***)</p>
        </td>
        <td style="padding-left:10px;border-bottom :0px; border-collapse: collapse;text-align:left;">
            <p><b>Peralatan Pabrik</b> meliputi : <u>Alat Ukur & Alat Bantu</u> <i>(plug gauge, bore gauge, holetest, vernier caliper, dial indicator, dll)</i>, 
            <u>Alat Angkat - Angkut</u> </i>(hand pallet, chain hoist, crane, forklift, stacker, dll)</i>, 
            <u>Pneumatic & Electric Tools</u> <i>(sander, die grinder, impact wrench, disc grinder, gerinda potong, jigsaw, dll)</i>,
            <u>Tools Holder</u> </i>(arbor, pull stud, adaptor, collet, holder insert, dll)</i>, 
            <u>Perkakas Kerja</u> <i>(tanggam, chuck, centorfix, magnetic block, dll)</i>, 
            <u>Peralatan K3</u> <i>(APAR, dll)</i>, 
            <u>Sarana Handling</u> <i>(container, jolly box, keranjang lipat, dll)</i>, 
            <u>Barang Dangangan menjadi Asset</u> <i>(Traktor, Diesel, dll)<i>,</p>
        </td>
    </tr>
    <tr>
        <td style="width: 5%; border-bottom :0px; border-collapse: collapse;text-align:right;">
            <p>****)</p>
        </td>
        <td style="padding-left:10px;border-bottom :0px; border-collapse: collapse;text-align:left;">
            <p><b>Asset Tak Berwujud</b> meliputi : Software, Hak Guna Bangunan</p>
        </td>
    </tr>
    <tr>
        <td colspan="2" style="border-bottom :0px; border-collapse: collapse;text-align:left;">
            <p>No. Form : FRM-F&A-10-01</p>
        </td>
    </tr>
    <tr>
        <td colspan="2" style="border-bottom :0px; border-collapse: collapse;text-align:left;">
            <p>No. Rev : 02</p>
        </td>
    </tr>
</table>
</div>