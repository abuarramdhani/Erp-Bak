<table class="table">
	<tr>
		<td width="20%" style="height: 67px;"> </td>
	</tr>
</table>

<table class="table" style=" font-size: 12px; width: 100%;">
	<?php foreach ($dataall['head'] as $key => $value) { ?>
	<tr style="">
		<td width="40%" rowspan="3" style="text-align: right;padding-right: 10px;">
			<?=$value['ALAMAT'][0]['PARTY_NAME']?><br>
			<?=$value['ALAMAT'][0]['ADDRESS_LINE1']?><br>
			<?=$value['ALAMAT'][0]['CITY']?><br>
		</td>
		<td width="15%" rowspan="3" style="text-align: right;">PROSES <br><?=$value['LOKASI']?></td>
		<td width="15%" rowspan="3" style="text-align: right;padding-right: 5px;vertical-align: top;">
			<img style="width: 55px; height: auto" src="<?php echo base_url('assets/img/'.$value['MOVE_ORDER_NO'].'.png') ?>">
						<?php 
							if (strlen($value['MOVE_ORDER_NO'])>11) {
								$no_mo = substr_replace($value['MOVE_ORDER_NO'], '<br>', 12, 0);
							}else{
								$no_mo = $value['MOVE_ORDER_NO'];
							}
						?>
		</td>
		<td style="text-align: right;padding-right: 30px;font-weight: bold;font-size: 11PX;padding-top: 0;height: 7px;padding-top: 8px;"><?=$value['MOVE_ORDER_NO']?></td>
	</tr>
	<?php 
		$date = str_replace('/', '-', $value['DATE_REQUIRED']);
	?>
	<tr>
		<td rowspan = "2" style="text-align: center;padding-right: 0px; padding-top: 10px;vertical-align: top;font-size: 11px;"><?=$value['ALAMAT'][0]['SEGMENT1']?><br><?=$date;?></td>
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
         </table>
     </div>