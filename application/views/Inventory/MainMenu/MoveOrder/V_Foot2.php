<!--table class="table table-head" style="font-size: 12px">
<?php foreach ($dataall['line'] as $key => $value) { ?>
	<tr><td colspan="3" style="text-align: right; padding-right: 10px;"><?=$value['CREATION_DATE'];?></td></tr>
	<tr><td colspan="3" style="font-size: 14px"><?=$value['PRODUK_DESC'];?></td></tr>
	<tr><td colspan="3" style="font-size: 14px"><?=$value['JOB_NO'];?></td></tr>
	<tr>
		<td width="80%"> </td>
		<td>Fajar Utomo</td>
		<td>Supriyanto</td>
	</tr>
<?php } ?> 
</table-->
<?php 
// echo "<pre>";
// print_r($dataall);
// exit();
$tanggal = $dataall['head'][0]['PRINT_DATE'] ;
// $date = date_create($tanggal);

$date = str_replace('/', '-', $tanggal);
$newDate = date("d-m-Y", strtotime($date));
?>
<table class="table table-head" style="font-size: 12px;">
	<tr>
		<td ></td>
		<td style="font-size: 14px;"></td></tr>
		<td colspan="2"></td>
	</tr>


	<tr>
		<td width="35%" style="font-size: 14px;padding-top: 30px;"><?=$dataall['line'][0]['PRODUK_DESC'];?></td>
		<td style="font-size: 11px;"></td>
		<td colspan="2" style="font-size: 11px;vertical-align: top;padding-top: 12px;text-align: right;"><?php echo $newDate?></td>

	</tr>
	<tr>
		<td style="text-align: left;padding-bottom: 5px;">(<?=$dataall['line'][0]['JOB_NO'];?>)</td>
		<td style="text-align: right;"></td>
		<td width="12%" style="text-align: right;padding-right: 10px;font-size: 12px;"><?=$dataall['head'][0]['NAMA_SATU']?></td>
		<td width="12%" style="text-align: right;padding-right: 10px;font-size: 12px;"><?=$dataall['head'][0]['NAMA_DUA']?></td>
	</tr>

</table>