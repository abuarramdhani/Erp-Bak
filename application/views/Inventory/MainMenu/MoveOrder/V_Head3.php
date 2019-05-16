
<table style="width:100%;border: 0px solid black; padding: 0px;height:16mm">
        <tr>
            <td style="width: 17mm; height:19mm;border-right: 0px solid black" rowspan="2">
                <!-- <img style="height:16mm;height:16mm;" src="<?php echo base_url('assets/img/logo.png'); ?>" /> -->
            </td>
            <td style="text-align: left; width: 150mm; height:19mm;border-bottom: 0px solid black;">
                <h2 style="margin-bottom: 0; padding-bottom: 0;font-size: 15px;">
                <!-- CV.KARYA HIDUP SENTOSA -->
                </h2><p>
                <span style="margin-bottom: 0; padding-bottom: 0;font-size: 12px;">
                <!-- PABRIK MESIN ALAT PERTANIAN - PENGECORAN LOGAM - DEALER UTAMA DIESEL KUBOTA -->
                </span>
            </td>
            <td style="width: 61mm;border-left: 1px height:19mm;padding-left: 5px;font-size: 13px;text-align: center;" rowspan="2">
                <!-- <b>SURAT PENGIRIMAN BARANG<p> -->
                <!-- KEPADA SUBKONTRAKTOR</b> -->
            </td>
        </tr>
        <tr>
            <td style="text-align: left;">
                <span style="margin-bottom: 5px; padding-bottom: 0;font-size: 12px;">
                    <!-- JL. MAGELANG 144, YOGYAKARTA 55241 - INDONESIA -->
                </span><p>
                <span style="margin-bottom: 5px;font-size: 12px">
                    <!-- Telp.(62-274) 512095 (H), 563217, Fax 563523, 554069, E-mail : purchasing3@quick.co.id -->
                </span>
            </td>
        </tr>
        <!-- <tr>
            <td style="width: 400px;border-right: 1px solid black">Kepada Yth. :</td>
        </tr> -->
    </table>
        <table style="width: 100%; border-left: 0px solid black;border-right: 0px solid black; padding: 0px;">
            <?php foreach ($dataall['head'] as $key => $value) { ?>
            <tr>
                <td style="width:91mm;font-size: 12px ;border-right: 0px solid black;color: white; ">Kepada Yth. :</td>
                <td style="text-align: center;width:42mm;font-size: 12px ;border-right: 0px solid black;color: white;">Jenis Pengiriman Barang :*</td>
                <td style="text-align: right;width: 34mm;height: 18mm;font-size: 12px ;border-right: 0px solid black" rowspan="3">
                    <img style="width: 60px; height: auto" src="<?php echo base_url('assets/img/'.$value['MOVE_ORDER_NO'].'.png') ?>">
                </td> <!-- QR CODE -->
                <td style="text-align: center;width:30mm;font-size: 12px ;border-right: 0px solid black;color: white;">Tgl. Brg. Dikirim :</td>
                <td style="text-align: center;width:30mm;font-size: 12px;color: white;">No. SPBS :</td>
            </tr>
            <tr>
                <td style="text-align: right;padding-right: 10px;font-size: 12px;height: 18mm;border-right: 0px solid black" rowspan="2">
                    <?=$value['ALAMAT'][0]['PARTY_NAME']?><p>
                    <?=$value['ALAMAT'][0]['ADDRESS_LINE1']?><p>
                   <?=$value['ALAMAT'][0]['CITY']?>
                </td>
                <td style="text-align: right;font-size: 12px;height: 18mm;border-right: 0px solid black" rowspan="2">PROSES<br><?=$value['LOKASI']?></td>
                <td style="text-align: left;font-size: 12px;height: 60px;" rowspan="2">
                </td>
                <td style="text-align: center;font-size: 12px;height: 9mm;border-bottom: 0px solid black;border-right: 0px solid black" rowspan="1"></td>
                <td style="text-align: center;font-size: 11px;height: 9mm;border-bottom: 0px solid black;" rowspan="1"><b><?=$value['MOVE_ORDER_NO']?></b></td>
            </tr>
            <?php 
                $date = str_replace('/', '-', $value['DATE_REQUIRED']);
            ?>
            <tr>
                <td style="height: 9mm; text-align: center; " colspan="2">
                <span style="font-size: 12px;"><!-- PsP/ no PO : --></span>
                <span style="padding-left: 20px; font-size: 12px"><?=$value['ALAMAT'][0]['SEGMENT1']?></span>
                <br>
                <span style="font-size: 12px"><!-- Tanggal : --></span>
                <span style="padding-left: 20px; font-size: 12px"><?=$date?></span>  
                
                </td>
            </tr>
            <?php } ?>
        </table>

