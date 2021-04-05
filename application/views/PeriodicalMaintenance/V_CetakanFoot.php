<table style="border: 2px solid black; border-collapse: collapse; width: 100%;margin-top:20px">
	<!-- <tr>
		<td style="border: 2px solid black;border-collapse: collapse; text-align: left;vertical-align: top;padding-left: 7px;font-size: 12px;width: 30%" rowspan="5">Catatan Umum : </td>
		<td colspan="2" style="border: 2px solid black;border-collapse: collapse; text-align: center;font-size: 12px;width: 24%; border-bottom: 1px solid black">Production Engineering</td>
		<td style="border: 2px solid black;border-collapse: collapse; text-align: center;font-size: 12px; border-bottom: 1px solid black">PPIC</td>
		<td colspan="2" style="border: 2px solid black;border-collapse: collapse; text-align: center;font-size: 12px;width: 46%; border-bottom: 1px solid black">Fabrikasi</td>

	</tr>
	<tr>
		<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;width: 14%;border-top: 1px solid black">Prepared</td>
		<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;width: 14%;border-top: 1px solid black;border-right: 2px solid black">Checked</td>
		<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;width: 14%;border-top: 1px solid black;border-right: 2px solid black">Checked</td>
		<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;width: 14%;border-top: 1px solid black">Checked</td>
		<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;width: 14%;border-top: 1px solid black">Approved</td>
	</tr>
	<tr>
		<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px">&nbsp;&nbsp;<br>&nbsp;&nbsp;<br>&nbsp;&nbsp;<br>&nbsp;&nbsp;</td>
		<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;border-right: 2px solid black"><br></td>
		<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;border-right: 2px solid black"><br></td>
		<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><br></td>
		<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><br></td>

	</tr>
	<tr>
		<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><br></td>
		<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;border-right: 2px solid black"><br></td>
		<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;border-right: 2px solid black"><br></td>
		<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><br></td>
		<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><br></td>

	</tr>
	<tr> -->
	<tr>
		<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px; border-bottom: 1px solid black">Tgl Terjadwal</td>
		<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px; border-bottom: 1px solid black">Tgl Aktual</td>
		<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px; border-bottom: 1px solid black">Status</td>
		<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px; border-bottom: 1px solid black">Jam Mulai</td>
		<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px; border-bottom: 1px solid black">Jam Selesai</td>
		<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px; border-bottom: 1px solid black">Pelaksana</td>
		<td colspan="2" style="border: 2px solid black;border-collapse: collapse; text-align: left;font-size: 12px; border-bottom: 0px solid black">Instruksi Khusus K3 :</td>
	</tr>
	<tr>
		<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px">&nbsp;&nbsp;<br><?= $datapdf['0']['SCHEDULE_DATE'] ?><br>&nbsp;&nbsp;</td>
		<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><?= $datapdf['0']['ACTUAL_DATE'] ?><br></td>
		<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><i><?= $datapdf['0']['STATUS'] ?></i><br></td>
		<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><?= $datapdf['0']['JAM_MULAI'] ?><br><br></td>
		<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><?= $datapdf['0']['JAM_SELESAI'] ?><br><br></td>
		<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><?= $datapdf['0']['PELAKSANA'] ?><br><br></td>
		<td style="border: 0px solid black;border-collapse: collapse; text-align: left;font-size: 12px"> 
	
		<input type="checkbox" name="instruksi1" value="Baju kerja" checked="checked">
							<label for="instruksi1"> Baju kerja</label>
							
							<br/>
							<input type="checkbox" name="instruksi3" value="Ear Plug" checked="checked">
							<label for="instruksi3"> Ear Plug</label>
							
							<br/>
							<input type="checkbox" name="instruksi5" value="Masker Kain" checked="checked">
							<label for="instruksi5">  Masker Kain</label>
							
	</td>
	<td style="border: 0px solid black;border-collapse: collapse; text-align: left;font-size: 12px">
	<input type="checkbox" name="instruksi2" value="Sepatu Safety" checked="checked">
							<label for="instruksi2"> Sepatu Safety</label> <br/>
							<input type="checkbox" name="instruksi4" value="Sarung Tangan" checked="checked">
							<label for="instruksi4"> Sarung Tangan</label> <br/>
							<input type="checkbox" name="instruksi6" value="Helm" checked="checked">
							<label for="instruksi6"> Helm</label>
	</td>

	</tr>
	<tr>
		<td colspan="2" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px; border-bottom: 1px solid black">Sparepart yang digunakan</td>
		<td colspan="2" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px; border-bottom: 1px solid black">Spesifikasi / Part Number</td>
		<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px; border-bottom: 1px solid black">Jumlah</td>
		<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px; border-bottom: 1px solid black">Satuan</td>
		<td colspan="2" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px; border-bottom: 0px solid black"> Catatan Revisi Dokumen :</td>

	</tr>
	<?php
        $no = 1;

        for ($i = 0; $i < sizeof($sparepart); $i++) {
        ?>
	<tr>
		<td colspan="2" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><?= $sparepart[$i]['SPAREPART'] ?><br></td>
		<td colspan="2" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><?= $sparepart[$i]['SPESIFIKASI'] ?><br></td>
		<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><?= $sparepart[$i]['JUMLAH'] ?></td>
		<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><?= $sparepart[$i]['SATUAN'] ?></td>
		<td style="border: 0px solid black;border-collapse: collapse; text-align: left;font-size: 12px">
		<!-- 1. Penggantian Durasi menjadi Durasi (menit), Cek Pressure Cairan Pendingin menjadi Coil dan VIP, Tgl Aktual, Tipe menjadi Spesifikasi / Part Number
		<br/>	
		2. Penambahan pilihan “Mesin”, Nilai Standard Cek Pressure Cairan Pendingin Coil dan VIP, Tgl Terjadwal, Status, Satuan.
	 -->
		</td>

	</tr>
		<?php } ?>
	<tr>
		<td colspan="2" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px; border-bottom: 1px solid black">Staff Seksi Terkait</td>
		<td colspan="2" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px; border-bottom: 1px solid black">Staff Maintenance</td>
		<td colspan="2" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px; border-bottom: 1px solid black">Opt Maintenance</td>
	</tr>
	<tr>
		<td colspan="2" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><br><h3><i><b> DISETUJUI </b></i></h3><br><?= $datapdf['0']['APPROVED_DATE_2'] ?></td>
		<td colspan="2" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;border-right: 2px solid black"><br><h3><i><b> DICEK </b></i></h3><br><?= $datapdf['0']['APPROVED_DATE'] ?></td>
		<td colspan="2" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;border-right: 2px solid black"><br><h3><i><b> DILAPORKAN </b></i></h3><br><?= $datapdf['0']['CREATION_DATE'] ?></td>

	</tr>
	<tr>
		<td colspan="2" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><?= $datapdf['0']['APPROVED_BY_2'] ?></td>
		<td colspan="2" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;border-right: 2px solid black"><?= $datapdf['0']['APPROVED_BY'] ?></td>
		<td colspan="2" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;border-right: 2px solid black"><?= $datapdf['0']['REQUEST_BY'] ?></td>

	</tr>
</table>
<!-- <p style="text-align: right;font-style: italic;margin-top: 2px;font-size: 8pt;margin-right: 7px">FRM-PDE-03-09 (rev00 - 21 Sept 2020)</p> -->