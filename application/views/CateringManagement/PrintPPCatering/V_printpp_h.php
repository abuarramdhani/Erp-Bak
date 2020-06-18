<?php foreach ($Printpp as $value): ?>
<table style="width:100%;">
	<tr>
		<td rowspan="2" style="padding-left: 10px;"><img src="<?php echo base_url('/assets/img/logo.png'); ?>" width="40px" heigth="auto"></td>
		<td rowspan="2" style="text-align: left">
			<h4 style="margin-bottom: 0; padding-bottom: 0;font-size: 10px">CV. KARYA HIDUP SENTOSA</h4>
			<p style="font-size: 9px">JOGJAKARTA</p>
		</td>
		<td style="text-align: center;font-size: 13px" colspan="4" rowspan="2">
				<b>PERMINTAAN PEMBELIAN (PP)</b>
		</td>
		<td colspan="2" style="border:1px solid black;font-size: 10px;padding-left: 10px;"><b>No. PP : </b><?php echo $value['no_pp'];?></td>
	</tr>
	<tr>
		<td colspan="2" style="border:1px solid black;font-size: 10px;padding-left: 10px;"><b>Tgl Dibuat : </b><?php echo date("d F Y", strtotime($value['tgl_buat']));?></td>
	</tr>
	<tr>
		<td colspan="3" style="border:1px solid black;font-size: 10px; padding-left: 10px;"><b>Kepada Sie Pembelian : </b>
			<?php if($value['pp_kepada']==1) {
					echo "SUPPLIER";
				}else{
					echo "SUBKONTRAKTOR";}?>
		</td>
		<td colspan="2" style="border:1px solid black;font-size: 10px; padding-left: 10px;"><b>Jenis PP : </b>
			<?php if($value['pp_jenis']==1) {
					echo "ASET";
				}else{
					echo "NON ASET";}?>
		</td>
		<td colspan="3" style="border:1px solid black;font-size: 10px; padding-left: 10px;"><b>No. Proposal Pengadaan Aset : </b><?php echo $value['pp_no_proposal'];?></td>
	</tr>
	<tr>
		<td rowspan="2" colspan="2" style="border:1px solid black;font-size: 10px;text-align: center">
		<b>Seksi Pemesan : </b>
		<p style="margin-bottom: 0;">
			<?php foreach ($Section as $seksi) {
					if ($value['pp_seksi_pemesan'] == $seksi['er_section_id']) {
						echo $seksi['section_name'];
			}}?>
		</p>
		</td>
		<td rowspan="2" style="border:1px solid black;font-size: 10px;text-align: center">
		<b>Branch : </b>
		<p style="margin-bottom: 0;">
			<?php foreach ($Branch as $cab ) {
					if ($value['pp_branch'] == $cab['branch_id']) {
						echo $cab['branch_code'];
			}} ?>
		</p>
		</td>
		<td rowspan="2" style="border:1px solid black;font-size: 10px;text-align: center">
		<b>Cost Center : </b>
		<p style="margin-bottom: 0;">
			<?php foreach ($CostCenter as $coser) {
					if ($value['pp_cost_center'] == $coser['cc_id']) {
						echo $coser['cc_code'];
			}} ?>
		</p>
		</td>
		<td rowspan="2" colspan="3" style="border:1px solid black;font-size: 10px;text-align: center">
		<b>Barang Untuk : </b>
		<p style="margin-bottom: 0;">
			<?php if($value['pp_kat_barang']==1) {
					echo "PRODUKSI";
				}else{
					echo "NON PRODUKSI";}?>
		</p>
		</td>
		<td rowspan="2" style="border:1px solid black;font-size: 10px;text-align: center">
		<b>Sub Inventory : </b>
		<p style="margin-bottom: 0;"><?php echo $value['pp_sub_invent'];?></p>
		</td>
	</tr>
</table>
<?php endforeach; ?>