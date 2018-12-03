
    	<?php $no=1; 
	    	// echo "<pre>";
	    	// print_r($list);
	    	// exit();
    $xi = $xj = 1;
   	for ($x=0; $x < sizeof($list['LIST']); $x++) { 
    	   
        	if ($no>1) {
    			echo "<pagebreak>";
    		}
    	?>
<!DOCTYPE html>
<html>
    <head>
        <style type="text/css">
            body {
                font-size: 12px;
            }

            .table {
                width: 100%;
            }

            .table td {
                padding: 3px 3px;
            }

            .table-bordered, .table-bordered td {
                border: 1px solid #000;
                border-collapse: collapse;
            }

            .table-head-bordered, .table-head-bordered td {
                border: 1px solid #d3d3d3;
                border-collapse: collapse;
            }

            .center-hor, .center-hor td {
                text-align: center;
            }

            .right-hor, .right-hor td {
                text-align: right;
            }

            .center-ver, .center-ver td {
                vertical-align: middle;
            }

            .text-bold , .text-bold td {
                font-weight: bold;
            }

            .top-ver {
                vertical-align: top;
            }
        </style>
    </head>
    <body>
<table class="table table-bordered">
    <tr>
        <td style="border-right: 0">
            <img alt="logo" src="<?php echo base_url('assets/img/logopatent.png') ?>" style="width:50px"/>
        </td>
        <td style="border-left: 0">
            <h4>
                CV. KARYA HIDUP SENTOSA
            </h4>
            <p style="font-size:8pt">
                <u>
                    PABRIK MESIN ALAT PERTANIAN.PENGECORAN LOGAM.DEALER UTAMA DIESEL KUBOTA
                </u>
                <br/>
                Kantor Pusat : JL. Magelang No. 144 Jogjakarta 55241 - Indonesia
                <br>
                    Telp.(0274)512095(hunting),563217;Fax(0274)563523;E-mail:operator1@quick.co.id
                </br>
            </p>
        </td>
        <td class="center-hor center-ver">
        	<h1>PACKING LIST</h1>
        </td>
    </tr>
</table>

<table class="table table-bordered">
	<?php foreach ($destination as $value) { ?>
		<tr> 
			<td class="top-ver" width="11%" height="80px" style="border-right: 0">
				Kepada YTH :
			</td>
			<td style="border-left: 0" width="39%">
				<?php echo $value['KEPADA_YTH']; ?>
			</td>
			<td class="top-ver" width="14%" style="border-right: 0">
				Dikirim Kepada :
			</td>
			<td style="border-left: 0">
				<?php echo $value['DIKIRIM_KEPADA']; ?>
			</td>
		</tr>
	<?php } ?>
</table>
        <div style="height:65mm;">
	      <table class="table table-bordered">
	            <tr>
	                <td width="20%">
	                    No SPB/DOSP : <strong><?php echo $spbNumber; ?></strong>
	                </td>
	                <td width="40%">
	                    No Coly : <strong><?php echo substr($list['PACKING_CODE'], 3).' ('.$list['DESC'].')'; ?></strong>
	                </td>
	                <td width="20%">
	                    Berat : <strong><?php echo number_format($list['WEIGHT'], 2, '.', ''); ?> Kg</strong>
	                </td>
	                <td style="width:20%">
	                    Total Coly :
	                    <strong>
	                        <span style="font-size: 12px">
                                <?php echo $list['LIST'][$x][0]['ITEM_COLY']; ?>
	                        </span>
	                    </strong>
	                </td>
	            </tr>
	        </table>
	        <table class="table table-bordered" style="font-size: 8px;">
	        	<tr class="text-bold">
	        		<td width="5%">NO</td>
	        		<td width="5%">QTY</td>
	        		<td width="6%">SATUAN</td>
	        		<td width="13%">KODE BARANG</td>
	        		<td width="56%">NAMA BARANG</td>
	        		<td width="15%">TIPE/NOMOR BARANG</td>
	        	</tr>
	        	
	        	<?php $i = 1; for($y = 0; $y < sizeof($list['LIST'][$x]);$y++) { ?>
	        		<tr>
	        			<td><?php echo $xi++; ?></td>
	        			<td><?php echo $list['LIST'][$x][$y]['PACKING_QTY'];?></td>
	        			<td><?php echo $list['LIST'][$x][$y]['PRIMARY_UOM_CODE'];?></td>
	        			<td><?php echo $list['LIST'][$x][$y]['SEGMENT1'];?></td>
	        			<td><?php echo $list['LIST'][$x][$y]['DESCRIPTION'];?></td>
	        			<td></td>
	        		</tr>
	        	<?php 
                    $i++;
                }
	        		$loop = 10 - $i;
	        		for($i = 0; $i < 0;$i++){
	        	?>
	        		<tr><td style="border:0px solid black;padding:10px;"></td></tr>
	        	<?php
	        		}
	        	 ?>
	        </table>
            </div>
	        <table class="table table-bordered">
    <tr>
        <!-- <td rowspan="2" width="13%" class="center-hor center-ver">
            <img src="<?php echo base_url('assets/upload/Warehouse/temp/qrcode/'.$spbNumber.'.png') ?>" style="height: 80px;"/> 
        </td> -->
        <td rowspan="2" class="top-ver">
            <p align="left">Catatan</p>
            <br>
            Ekspedisi : <h1 align="center-hor"><?php echo $ekspedisi[0]['EXPEDITION_CODE']; ?></h1>
        </td>
        <td colspan="2" class="center-hor">
            Gudang
        </td>
    </tr>
    <tr class="center-hor" style="font-size: 9px">
        <td style="width:15%;">
            tgl: .......................
            <br>
            Pengawas :
            <br>
            <br>
            <br>
            <br>
            (  Latifa H  )
        </td>
        <td style="width:15%;">
            tgl: .......................
            <br>
            Petugas Packing :
            <br>
            <br>
            <br>
            <br>
            ( ....................... )
        </td>
    </tr>
</table>
<table class="table" style="font-size: 9px">
	<tr>
		<td>
			FRM-WHS-02-SP-01, REV.02
		</td>
		<td class="right-hor">
		</td>
	</tr>
</table>
<hr>
<!DOCTYPE html>
<html>
    <head>
        <style type="text/css">
            body {
                font-size: 12px;
            }

            .table {
                width: 100%;
            }

            .table td {
                padding: 3px 3px;
            }

            .table-bordered, .table-bordered td {
                border: 1px solid #000;
                border-collapse: collapse;
            }

            .table-head-bordered, .table-head-bordered td {
                border: 1px solid #d3d3d3;
                border-collapse: collapse;
            }

            .center-hor, .center-hor td {
                text-align: center;
            }

            .right-hor, .right-hor td {
                text-align: right;
            }

            .center-ver, .center-ver td {
                vertical-align: middle;
            }

            .text-bold , .text-bold td {
                font-weight: bold;
            }

            .top-ver {
                vertical-align: top;
            }
        </style>
    </head>
    <body>
<table class="table table-bordered">
    <tr>
        <td style="border-right: 0">
            <img alt="logo" src="<?php echo base_url('assets/img/logopatent.png') ?>" style="width:50px"/>
        </td>
        <td style="border-left: 0">
            <h4>
                CV. KARYA HIDUP SENTOSA
            </h4>
            <p style="font-size:8pt">
                <u>
                    PABRIK MESIN ALAT PERTANIAN.PENGECORAN LOGAM.DEALER UTAMA DIESEL KUBOTA
                </u>
                <br/>
                Kantor Pusat : JL. Magelang No. 144 Jogjakarta 55241 - Indonesia
                <br>
                    Telp.(0274)512095(hunting),563217;Fax(0274)563523;E-mail:operator1@quick.co.id
                </br>
            </p>
        </td>
        <td class="center-hor center-ver">
        	<h1>PACKING LIST</h1>
        </td>
    </tr>
</table>

<table class="table table-bordered">
	<?php foreach ($destination as $value) { ?>
		<tr> 
			<td class="top-ver" width="11%" height="80px" style="border-right: 0">
				Kepada YTH :
			</td>
			<td style="border-left: 0" width="39%">
				<?php echo $value['KEPADA_YTH']; ?>
			</td>
			<td class="top-ver" width="14%" style="border-right: 0">
				Dikirim Kepada :
			</td>
			<td style="border-left: 0">
				<?php echo $value['DIKIRIM_KEPADA']; ?>
			</td>
		</tr>
	<?php } ?>
</table>
         <div style="height:65mm;">
	      <table class="table table-bordered">
	            <tr>
	                <td width="20%">
	                    No SPB/DOSP : <strong><?php echo $spbNumber; ?></strong>
	                </td>
	                <td width="40%">
	                    No Coly : <strong><?php echo substr($list['PACKING_CODE'], 3).' ('.$list['DESC'].')'; ?></strong>
	                </td>
	                <td width="20%">
	                    Berat : <strong><?php echo number_format($list['WEIGHT'], 2, '.', ''); ?> Kg</strong>
	                </td>
	                <td style="width:20%">
	                    Total Coly :
	                    <strong>
	                        <span style="font-size: 12px">
                                <?php echo $list['LIST'][$x][0]['ITEM_COLY']; ?>
                            </span>
	                    </strong>
	                </td>
	            </tr>
	        </table>
	        <table class="table table-bordered" style="font-size: 8px;">
	        	<tr class="text-bold">
	        		<td width="5%">NO</td>
	        		<td width="5%">QTY</td>
	        		<td width="6%">SATUAN</td>
	        		<td width="13%">KODE BARANG</td>
	        		<td width="56%">NAMA BARANG</td>
	        		<td width="15%">TIPE/NOMOR BARANG</td>
	        	</tr>
	        	
	        	<?php $i = 1; for($y = 0; $y < sizeof($list['LIST'][$x]);$y++) { ?>
	        		<tr>
	        			<td><?php echo $xj++; ?></td>
	        			<td><?php echo $list['LIST'][$x][$y]['PACKING_QTY'];?></td>
	        			<td><?php echo $list['LIST'][$x][$y]['PRIMARY_UOM_CODE'];?></td>
	        			<td><?php echo $list['LIST'][$x][$y]['SEGMENT1'];?></td>
	        			<td><?php echo $list['LIST'][$x][$y]['DESCRIPTION'];?></td>
	        			<td></td>
	        		</tr>
	        	<?php 
                        $i++;
                    }
	        		$loop = 8 - $i;
	        		for($i = 0; $i < 0;$i++){
	        	?>
	        		<tr><td style="border:0px solid black;padding:10px;"></td></tr>
	        	<?php
	        		}
	        	 ?>
	        </table>
            </div>
	        <table class="table table-bordered">
    <tr>
        <!-- <td rowspan="2" width="13%" class="center-hor center-ver">
            <img src="<?php echo base_url('assets/upload/Warehouse/temp/qrcode/'.$spbNumber.'.png') ?>" style="height: 80px;"/> 
        </td> -->
        <td rowspan="2" class="top-ver">
            <p align="left">Catatan</p>
            <br>

            Ekspedisi : <h1 align="center-hor"><?php echo $ekspedisi[0]['EXPEDITION_CODE']; ?></h1>
        </td>
        <td colspan="2" class="center-hor">
            Gudang
        </td>
    </tr>
    <tr class="center-hor" style="font-size: 9px">
        <td style="width:15%;">
            tgl: .......................
            <br>
            Pengawas :
            <br>
            <br>
            <br>
            <br>
            (  Latifa H  )
        </td>
        <td style="width:15%;">
            tgl: .......................
            <br>
            Petugas Packing :
            <br>
            <br>
            <br>
            <br>
            ( ....................... )
        </td>
    </tr>
</table>
<table class="table" style="font-size: 9px">
	<tr>
		<td>
			FRM-WHS-02-SP-01, REV.02
		</td>
		<td class="right-hor">
		</td>
	</tr>
</table>

	    <?php
			$no++;  
	      } ?>
    </body>
</html>