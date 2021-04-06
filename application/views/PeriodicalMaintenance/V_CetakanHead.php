<!-- <div id="page-border"> -->


<table style="border: 2px solid black; border-collapse: collapse; width: 100%">
	<tr>
		<td rowspan="4" width="5%" style="text-align: center; padding-left: 5px;">
			<img width="5%" style="height: 100px; width: 100px" src="<?= base_url('assets/img/logo.png'); ?>" style="display:block;">
		</td>
		<td rowspan="4" style="font-size: 12px; text-align: left; padding-left: 5px;width: 19%">
			<b>CV KARYA HIDUP SENTOSA</b><br>
			<b>YOGYAKARTA</b>
		</td>
		<td style="border: 2px solid black;border-collapse: collapse; font-weight: bold;font-size: 14pt;text-align: center; width: 45%;border-bottom: 1px solid black">FORM</td>
		<td style="border: 1px solid black;border-collapse: collapse;font-size: 12px;padding-left: 7px;width: 10%">Doc. No.</td>
		<td style="border: 1px solid black;border-collapse: collapse;font-size: 12px;padding-left: 7px;text-align: left;width: 20%"><?= $header[0]['NO_DOKUMEN'] ?></td>
	</tr>
	<tr>
		<td style="border: 2px solid black;border-collapse: collapse;font-size: 10pt;padding-left: 5px;font-weight: bold; text-align: center;border-top: 1px solid black">PERIODICAL MAINTENANCE</td>
		<td style="border: 1px solid black;border-collapse: collapse;font-size: 12px;padding-left: 7px">Rev No. </td>
		<td style="border: 1px solid black;border-collapse: collapse;font-size: 12px;padding-left: 7px;text-align: left;"<?= $header[0]['NO_REVISI'] ?>></td>

	</tr>

	<tr>
		<td style="border: 2px solid black;border-collapse: collapse;font-size: 10pt;padding-left: 5px;font-weight: bold; text-align: center;border-top: 1px solid black"><?= $datapdf['0']['NAMA_MESIN'] ?></td>
		<td style="border: 1px solid black;border-collapse: collapse;font-size: 12px;padding-left: 7px">Rev Date </td>
		<td style="border: 1px solid black;border-collapse: collapse;font-size: 12px;padding-left: 7px;text-align: left;"><?= $header[0]['TANGGAL_REVISI'] ?></td>

	</tr>

	<tr>
			
				

	<td style="border: 2px solid black;border-collapse: collapse;font-size: 10pt;padding-left: 5px;font-weight: bold; text-align: center;border-top: 1px solid black">
		<?= $datapdf['0']['TYPE_MESIN'] ?></td>  
		<td style="border: 1px solid black;border-collapse: collapse;font-size: 12px;padding-left: 7px">Page </td>
		<td style="border: 1px solid black;border-collapse: collapse;font-size: 12px;padding-left: 7px;text-align: left;"> {PAGENO} / {nbpg}</td>

	</tr>
</table>
<!-- </div> -->