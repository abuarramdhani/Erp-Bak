<html>
<head>
	<style type="text/css">
		*{
			font-family: 'Times New Roman';
			margin:0px;
		}
		.header, .header td{	
			border:1px solid black;
			border-collapse: collapse;

		}
		.cuk{
			padding:2px;
			padding-top: 1%;
		}
		.isi,.isi th, .isi td{
			border:1px solid black;
			margin-top: 10%;
			font-size:11px; 
			text-align: center;
			border-collapse: collapse; 
			     
		}

		.footer, .footer td{
			border:1px solid black; 
			font-size:11px;
			text-align: center;
			border-collapse: collapse;
			
		}
	</style>
</head>	
<body >
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
    	    <td style="width: 61mm;border-left: 1px height:19mm;solid black;padding-left: 5px;font-size: 13px;text-align: center;" rowspan="2">
    	    	<!-- <b>SURAT PENGIRIMAN BARANG<p>
    	    	KEPADA SUBKONTRAKTOR</b> -->
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
        		<td style="text-align: center;width: 34mm;height: 18mm;font-size: 12px ;border-right: 0px solid black" rowspan="3">
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
        		<td style="text-align: center;font-size: 12px;height: 18mm;border-right: 0px solid black" rowspan="2">PROSES<br><?=$value['LOKASI']?></td>
        		<!-- <td style="text-align: center;font-size: 12px;height: 60px;border-right: 1px solid black" rowspan="2"></td> -->
        		<td style="text-align: center;font-size: 12px;height: 9mm;border-bottom: 0px solid black;border-right: 0px solid black" rowspan="1"><!-- <?php echo $value['DATALIST'][0]['TGL']; ?> --></td>
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
        <div style="height: 66.5mm">
        <table style="width: 100%; border-left: 0px solid black;border-right: 0px solid black;border-top: 0px solid black;border-bottom: 0px solid black; padding: 0px;">
        	<tr >
        		<td style="width:7mm; text-align: center; font-size: 12px; border-bottom:0px solid black;border-right: 0px solid black;color: white;" rowspan="2">No</td>
        		<td style="width:29mm; text-align: center; font-size: 12px; border-bottom:0px solid black;border-right: 0px solid black; border-bottom: 0px solid black;color: white;" colspan="2">QTY</td>
        		<td style="width:8mm; text-align: center; font-size: 12px; border-bottom:0px solid black;border-right: 0px solid black;color: white;" rowspan="2">Satuan</td>
        		<td style="width:27mm; text-align: center; font-size: 12px; border-bottom:0px solid black;border-right: 0px solid black;color: white;" rowspan="2">Kode Barang</td>
        		<td style="width:83mm; text-align: center; font-size: 12px; border-bottom:0px solid black;border-right: 0px solid black;color: white;" rowspan="2">Nama Barang</td>
        		<td style="width:50mm;border-bottom:0px solid black; text-align: center; font-size: 12px;color: white;" rowspan="2">Lokasi Simpan</td>
        	</tr>
        	<tr >
        		<td style="text-align: center; font-size: 12px; border-bottom:0px solid black;border-right: 0px solid black;color: white;">Minta</td>
        		<td style="text-align: center; font-size: 12px; border-bottom:0px solid black;border-right: 0px solid black;color: white;">Kirim</td>
        	</tr>
        	<?php $p=1;
             $no=1;
            foreach ($dataall['line'] as $k => $ln) { 
              $height = 7.5;
        	?>
        	<tr>
        		<td style="border-bottom: 0px solid black;border-right: 0px solid black;font-size: 12px; text-align: center;"><?php echo $no++; ?></td>
        		<td style="border-bottom: 0px solid black;border-right: 0px solid black;font-size: 12px; text-align: center;"><?php echo $ln['QTY_MINTA']; ?></td>
        		<td style="border-bottom: 0px solid black;border-right: 0px solid black;font-size: 12px;text-align: center;">......</td>
        		<td style="border-bottom: 0px solid black;border-right: 0px solid black;font-size: 12px;text-align: center;"><?php echo $ln['UOM']; ?></td>
        		<td style="border-bottom: 0px solid black;border-right: 0px solid black;font-size: 12px;text-align: center;"><?php echo $ln['KODE_KOMPONEN']; ?></td>
        		<td style="border-bottom: 0px solid black;border-right: 0px solid black;font-size: 12px"><?php echo $ln['KODE_DESC']; ?></td>
        		<td style="border-bottom: 0px solid black;font-size: 12px">K</td>
        	</tr>
        	<?php

                        $height += 0.8;
             }
                    $loop = 12 - $p;
                    for($l = 0; $l < 0;$l++){
                ?>
                    <tr><td style="border:0px solid black;padding:<?php echo $height; ?>px;"></td></tr>

                <?php
                    }
            ?>
        </table>
        </div>
        <table style="width: 100%; border-left: 0px solid black; border-right: 0px solid black; border-bottom: 0px solid black;position: relative;bottom: 0px;">
        <?php 
            $tanggal = $dataall['head'][0]['PRINT_DATE'] ;

            $date = str_replace('/', '-', $tanggal);
            $newDate = date("d-m-Y", strtotime($date));
            ?>
        <tr>
            <td style="width: 40% ;border-right: 0px solid black; border-top: 0px solid black;" rowspan="3">
                <span><h4 style="color:white;">KETERANGAN : </h4></span>
                <?=$dataall['line'][0]['PRODUK_DESC'];?><br>
                (<?=$dataall['line'][0]['JOB_NO'];?>)
            </td>
            <td style="width: 14% ;height: 10px;font-size: 11px;border-right: 0px solid black; border-top: 0px solid black;color: white;">
                <span>Diterima Oleh,</span><p>
                <span>Tgl. :</span>
            </td>
            <td style="width: 14% ;height: 10px;font-size: 11px;border-right: 0px solid black; border-top: 0px solid black;color: white;">
                <span>Unit Pengeluaran,</span><p>
                <span>Tgl. :</span>
            </td>
            <td style="width: 13% ;height: 10px;font-size: 11px;border-right: 0px solid black; border-top: 0px solid black;color: white;">
                <span>Gudang,</span><p>
                <span>Tgl. :</span>
            </td>
            <td style="width: 12% ;height: 10px;font-size: 11px;border-right: 0px solid black; border-top: 0px solid black;color: white;">
                <span>Disetujui Oleh,</span><p>
                <span>Tgl. :</span>
            </td>
            <td style="width: 12% ;height: 10px;font-size: 11px; border-top: 0px solid black;">
                <span style="color: white;">Pemb. Subkont,</span><p>
                <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:<?php echo $newDate?></span>
            </td>
        </tr>
        <tr>
            <td style="height: 50px;border-right: 0px solid black"></td>
            <td style="height: 50px;border-right: 0px solid black"></td>
            <td style="height: 50px;border-right: 0px solid black"></td>
            <td style="height: 50px;border-right: 0px solid black"></td>
            <td style="height: 50px;"></td>
        </tr>
        <tr>
            <td style="height: 15px;text-align: center;font-size: 11px;border-right: 0px solid black"></td>
            <td style="height: 15px;text-align: center;font-size: 11px;border-right: 0px solid black"></td>
            <td style="height: 15px;text-align: center;font-size: 11px;border-right: 0px solid black"></td>
            <td style="height: 15px;text-align: center;font-size: 11px;border-right: 0px solid black"><?=$dataall['head'][0]['NAMA_SATU']?></td>
            <td style="height: 15px;text-align: center;font-size: 11px;"><?=$dataall['head'][0]['NAMA_DUA']?></td>
        </tr>
    </table>
    <!-- <p style="font-size: 12px"></p> -->
</body>
</html>
