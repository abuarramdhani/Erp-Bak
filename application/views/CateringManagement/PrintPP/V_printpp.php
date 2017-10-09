<?php foreach ($Printpp as $value): ?>
<table style="width:100%;border: 1px solid black;">
	<tr>
		<td rowspan="2" style="padding-left: 10px;"><img src="<?php echo base_url('/assets/img/logo.png'); ?>" width="40px" heigth="auto"></td>
		<td rowspan="2" style="text-align: left">
			<h4 style="margin-bottom: 0; padding-bottom: 0;font-size: 10px">CV. KARYA HIDUP SENTOSA</h4>
			<p style="font-size: 9px">JOGJAKARTA</p>
		</td>
		<td style="text-align: center;font-size: 12px" colspan="4" rowspan="2">
				<b>PERMINTAAN PEMBELIAN (PP)</b>
		</td>
		<td colspan="2" style="border:1px solid black;font-size: 10px;padding-left: 10px;"><b>No. PP : </b><?php echo $value['no_pp'];?></td>
	</tr>
	<tr>
		<td colspan="2" style="border:1px solid black;font-size: 10px;padding-left: 10px;"><b>Tgl Dibuat : </b><?php echo date("d M Y", strtotime($value['tgl_buat']));?></td>
	</tr>
	<tr>
		<td colspan="3" style="border:1px solid black;font-size: 8px; padding-left: 10px;"><b>Kepada Sie Pembelian : </b>
			<?php if($value['pp_kepada']==1) {
					echo "SUPPLIER";
				}else{
					echo "SUBKONTRAKTOR";}?>
		</td>
		<td colspan="2" style="border:1px solid black;font-size: 8px; padding-left: 10px;"><b>Jenis PP : </b>
			<?php if($value['pp_jenis']==1) {
					echo "ASET";
				}else{
					echo "NON ASET";}?>
		</td>
		<td colspan="3" style="border:1px solid black;font-size: 8px; padding-left: 10px;"><b>No. Proposal Pengadaan Aset : </b><?php echo $value['pp_no_proposal'];?></td>
	</tr>
	<tr>
		<td rowspan="2" colspan="2" style="border:1px solid black;font-size: 8px;text-align: center">
		<b>Seksi Pemesan : </b>
		<p style="margin-bottom: 0;">
			<?php foreach ($Section as $seksi) {
					if ($value['pp_seksi_pemesan'] == $seksi['er_section_id']) {
						echo $seksi['section_name'];
			}}?>
		</p>
		</td>
		<td rowspan="2" style="border:1px solid black;font-size: 8px;text-align: center">
		<b>Branch : </b>
		<p style="margin-bottom: 0;">
			<?php foreach ($Branch as $cab ) {
					if ($value['pp_branch'] == $cab['branch_id']) {
						echo $cab['branch_code'];
			}} ?>
		</p>
		</td>
		<td rowspan="2" style="border:1px solid black;font-size: 8px;text-align: center">
		<b>Cost Center : </b>
		<p style="margin-bottom: 0;">
			<?php foreach ($CostCenter as $coser) {
					if ($value['pp_cost_center'] == $coser['cc_id']) {
						echo $coser['cc_code'];
			}} ?>
		</p>
		</td>
		<td rowspan="2" colspan="3" style="border:1px solid black;font-size: 8px;text-align: center">
		<b>Barang Untuk : </b>
		<p style="margin-bottom: 0;">
			<?php if($value['pp_kat_barang']==1) {
					echo "PRODUKSI";
				}else{
					echo "NON PRODUKSI";}?>
		</p>
		</td>
		<td rowspan="2" style="border:1px solid black;font-size: 8px;text-align: center">
		<b>Sub Inventory : </b>
		<p style="margin-bottom: 0;"><?php echo $value['pp_sub_invent'];?></p>
		</td>
	</tr>
</table>
<table style="width:100%;border: 1px solid black;">
	<tr>
		<td style="border:1px solid black;font-size: 10px;text-align: center; width: 20%"><b>Kode Barang</b></td>
		<td style="border:1px solid black;font-size: 10px;text-align: center; width: 5%"><b>Qty</b></td>
		<td style="border:1px solid black;font-size: 10px;text-align: center; width: 5%"><b>Satuan</b></td>
		<td style="border:1px solid black;font-size: 10px;text-align: center; width: 28%"><b>Nama Barang</b></td>
		<td style="border:1px solid black;font-size: 10px;text-align: center; width: 22%"><b>NBD</b></td>
		<td style="border:1px solid black;font-size: 10px;text-align: center; width: 10%"><b>Keterangan</b></td>
		<td style="border:1px solid black;font-size: 10px;text-align: center; width: 10%"><b>Supplier</b></td>
	</tr>
	<?php $count=0; ?>
		<?php foreach ($PrintppDetail as $key): ?>
			<?php $count++; ?>
				<tr>
					<td style="border:1px solid black;font-size: 10px;text-align: center;"><?php echo $key['pp_kode_barang'];?></td>
					<td style="border:1px solid black;font-size: 10px;text-align: center;"><?php echo $key['pp_jumlah'];?></td>
					<td style="border:1px solid black;font-size: 10px;text-align: center;"><?php echo $key['pp_satuan'];?></td>
					<td style="border:1px solid black;font-size: 10px;text-align: center;"><?php echo $key['pp_nama_barang'];?></td>
					<td style="border:1px solid black;font-size: 10px;text-align: center;"><?php echo date("d M Y", strtotime($key['pp_nbd']));?></td>
					<td style="border:1px solid black;font-size: 10px;text-align: center;"><?php echo $key['pp_keterangan'];?></td>
					<td style="border:1px solid black;font-size: 10px;text-align: center;"><?php echo $key['pp_supplier'];?></td>
				</tr>
	<?php endforeach; ?>
	<?php if($count <= 14) : ?>
		<?php for ($i=$count; $i<(14-$count); $i++) : ?>
				<tr>
					<td style="border:1px solid black;">&nbsp;</td>
					<td style="border:1px solid black;">&nbsp;</td>
					<td style="border:1px solid black;">&nbsp;</td>
					<td style="border:1px solid black;">&nbsp;</td>
					<td style="border:1px solid black;">&nbsp;</td>
					<td style="border:1px solid black;">&nbsp;</td>
					<td style="border:1px solid black;">&nbsp;</td>
				</tr>
		<?php endfor; ?>
	<?php endif; ?>
</table>
<table style="width:100%;border: 1px solid black;">
	<tr>
		<td style="border:1px solid black;font-size: 7px;width: 20%;padding-left: 10px"><b>No. PR: </b>
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
		<td style="border:1px solid black;font-size: 7px;text-align: center;"><b>Tgl : </b><?php if($value['pp_tgl_siepembelian'] != null) {echo date("d M Y", strtotime($value['pp_tgl_siepembelian'])); }?></td>
		<td style="border:1px solid black;font-size: 7px;text-align: center;"><b>Tgl : </b><?php if($value['pp_tgl_direksi'] != null) {echo date("d M Y", strtotime($value['pp_tgl_direksi'])); }?></td>
		<td style="border:1px solid black;font-size: 7px;text-align: center;"><b>Tgl : </b><?php if($value['pp_tgl_kadept'] != null) {echo date("d M Y", strtotime($value['pp_tgl_kadept'])); }?></td>
		<td style="border:1px solid black;font-size: 7px;text-align: center;"><b>Tgl : </b><?php if($value['pp_tgl_kaunit'] != null) {echo date("d M Y", strtotime($value['pp_tgl_kaunit'])); }?></td>
		<td style="border:1px solid black;font-size: 7px;text-align: center;"><b>Tgl : </b><?php if($value['pp_tgl_kasie'] != null) {echo date("d M Y", strtotime($value['pp_tgl_kasie'])); }?></td>
	</tr>
	<tr>
		<td colspan="6" style="border:1px solid black;font-size: 10px;padding-bottom: 10px;padding-left: 10px"><b>Catatan Sie Pembelian : </b><?php echo $value['pp_catatan'];?></td>
	</tr>
	<tr>
		<td colspan="2" style="font-size: 8px;padding-bottom: 10px;padding-left: 10px">FRM-PUR-00-02 (Rev.05)
			<span>&nbsp;</span>
		</td>
		<td colspan="4" style="font-size: 7px;padding-bottom: 10px;padding-left: 10px;"><b>Catatan : </b> <p style="margin-bottom: 0px">- NBD (Need By Date) : Tanggal dibutuhkan barang</p>
				<p style="margin-bottom: 0px">- PP Aset dilampiri dengan Proposal Pengadaan Aset yang telah diotorisasi pihak yang terkait</p>
				<p style="margin-bottom: 0px">- Otorisasi Permintaan Pembelian minimal sampai Kepala Departemen dan sampai ke Direksi jika ada kriteria khusus</p>
	</td>
	</tr>
</table>
<?php endforeach; ?>
