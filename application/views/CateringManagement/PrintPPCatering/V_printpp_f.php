<?php foreach ($Printpp as $value): ?>
<table style="width:100%;">
	<tr>
		<td style="border:1px solid black;font-size: 10px;width: 20%;padding-left: 10px"><b>No. PR: </b>
		</td>	
		<td rowspan = "2" style="border:1px solid black;font-size: 8px;text-align: center;width:16%"><b>Diterima</b>
			<p style="margin-bottom: 0"><b>Sie Pembelian</b></p>
		</td>
		<td rowspan = "2" style="border:1px solid black;font-size: 8px;text-align: center;width:16%"><b>Disetujui</b>
			<p style="margin-bottom: 0"><b>Direksi</b></p>
		</td>
		<td rowspan = "2" style="border:1px solid black;font-size: 8px;text-align: center;width:16%"><b>Disetujui</b>
			<p style="margin-bottom: 0"><b>Kepala Departemen</b></p>
		</td>
		<td rowspan = "2" style="border:1px solid black;font-size: 8px;text-align: center;width:16%"><b>Disetujui</b>
			<p style="margin-bottom: 0"><b>Kepala Unit</b></p>
		</td>
		<td rowspan = "2" style="border:1px solid black;font-size: 8px;text-align: center;width:16%"><b>Diminta</b>
			<p style="margin-bottom: 0"><b>Kasie / SPV</b></p>
		</td>
	</tr>
	<tr>
		<td style="font-size: 10px;padding-left: 10px"><b>Approve : </b>
		</td>
	</tr>
	<tr>
		<td style="text-align: center;padding: 10px;">&nbsp;</td>
		<td style="border:1px solid black;text-align: center;">
		
		</td>
		<td style="border:1px solid black;text-align: center;">
		
		</td>
		<td style="border:1px solid black;text-align: center;">
		
		</td>
		<td style="border:1px solid black;text-align: center;">
		
		</td>
		<td style="border:1px solid black;text-align: center;">
		
		</td>
	</tr>
	<tr>
		<td style="border:1px solid black;font-size: 7px;padding-left: 10px">Lembar Putih -> Pembelian</td>
		<td style="border:1px solid black;font-size: 7px;text-align: center;">
			<b><?php foreach ($Employee as $pekerja) {
					if ($value['pp_siepembelian'] == $pekerja['employee_id']) {
						echo $pekerja['employee_name'];
			}}?></b>
		</td>
		<td style="border:1px solid black;font-size: 7px;text-align: center;">
			<b><?php foreach ($Employee as $pekerja) {
					if ($value['pp_direksi'] == $pekerja['employee_id']) {
						echo $pekerja['employee_name'];
			}}?></b>
		</td>
		<td style="border:1px solid black;font-size: 7px;text-align: center;">
			<b><?php foreach ($Employee as $pekerja) {
					if ($value['pp_kadept'] == $pekerja['employee_id']) {
						echo $pekerja['employee_name'];
			}}?></b>
		</td>
		<td style="border:1px solid black;font-size: 7px;text-align: center;">
			<b><?php foreach ($Employee as $pekerja) {
					if ($value['pp_kaunit'] == $pekerja['employee_id']) {
						echo $pekerja['employee_name'];
			}}?></b>
		</td>
		<td style="border:1px solid black;font-size: 7px;text-align: center;">
			<b><?php foreach ($Employee as $pekerja) {
					if ($value['pp_kasie'] == $pekerja['employee_id']) {
						echo $pekerja['employee_name'];
			}}?></b>
		</td>
	</tr>
	<tr>
		<td style="border:1px solid black;font-size: 7px;padding-left: 10px">Lembar Merah -> Seksi Pemesan</td>
		<td style="border:1px solid black;font-size: 7px;padding-left: 5px"><b>Tgl : </b><?php if($value['pp_tgl_siepembelian'] != null) {echo date("d M Y", strtotime($value['pp_tgl_siepembelian'])); }?></td>
		<td style="border:1px solid black;font-size: 7px;padding-left: 5px"><b>Tgl : </b><?php if($value['pp_tgl_direksi'] != null) {echo date("d M Y", strtotime($value['pp_tgl_direksi'])); }?></td>
		<td style="border:1px solid black;font-size: 7px;padding-left: 5px"><b>Tgl : </b><?php if($value['pp_tgl_kadept'] != null) {echo date("d M Y", strtotime($value['pp_tgl_kadept'])); }?></td>
		<td style="border:1px solid black;font-size: 7px;padding-left: 5px"><b>Tgl : </b><?php if($value['pp_tgl_kaunit'] != null) {echo date("d M Y", strtotime($value['pp_tgl_kaunit'])); }?></td>
		<td style="border:1px solid black;font-size: 7px;padding-left: 5px"><b>Tgl : </b><?php if($value['pp_tgl_kasie'] != null) {echo date("d M Y", strtotime($value['pp_tgl_kasie'])); }?></td>
	</tr>
	<tr>
		<td colspan="6" style="border:1px solid black;font-size: 10px;padding-bottom: 10px;padding-left: 10px"><b>Catatan Sie Pembelian : </b><?php echo $value['pp_catatan'];?></td>
	</tr>
	<tr>
		<td colspan="2" style="font-size: 9px;vertical-align: middle;padding-left: 10px">
			FRM-PUR-00-02 (Rev.05)
			<span>&nbsp;</span>
		</td>
		<td colspan="4" rowspan="2" style="font-size: 8px;padding-bottom: 0px;padding-left: 10px;">
			<b>Catatan : </b> 
			<p style="margin-bottom: 0px">- NBD (Need By Date) : Tanggal dibutuhkan barang</p>
			<p style="margin-bottom: 0px">- PP Aset dilampiri dengan Proposal Pengadaan Aset yang telah diotorisasi pihak yang terkait</p>
			<p style="margin-bottom: 0px">- Otorisasi Permintaan Pembelian minimal sampai Kepala Departemen dan sampai ke Direksi jika ada kriteria khusus</p>
		</td>
	</tr>
	<tr>
		<td colspan="2" style="font-size: 9px;vertical-align: middle;padding-left: 10px">
			<i>
				halaman {PAGENO} dari {nb} &nbsp;&nbsp;&nbsp;&nbsp;
				<?php echo 'dicetak '.$waktu ?>
			</i>
		</td>
	</tr>
</table>
<?php endforeach; ?>