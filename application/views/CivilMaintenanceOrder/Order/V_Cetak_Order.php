<style>
	.textKiri{
		text-align: right;
	}
	tr.padding10 td{
		padding-top: 10px;
	}
</style>
<div style="width: 100%;height: 100%;border: 1px solid black">
	<table style="width: 100%">
		<tr>
			<td>
				<img src="<?php echo base_url('assets/img/logo.png') ?>" style='height: 60px;'>
			</td>
			<td>
				<h1>E-Order - Civil Maintenance</h1>
			</td>
		</tr>
	</table>
	<hr>
	<table style="width: 100%">
		<tr>
			<td style="width: 18%">Tanggal Order</td>
			<td style="width: 2%;">:</td>
			<td style="width: 30%">
				<?= strftime('%d %B %Y',strtotime($order['tgl_order']));
				 ?>
			</td>
			<td style="width: 18%">Lokasi</td>
			<td style="width: 2%">:</td>
			<td style="width: 30%"><?= empty($order['location_name']) ? '-':ucwords(strtolower($order['location_name'])) ?></td>
		</tr>
		<tr>
			<td>Dari Pekerja</td>
			<td>:</td>
			<td><?= ucwords(strtolower($order['pengorder'].' - '.$order['dari'])) ?></td>
			<td>Voip</td>
			<td>:</td>
			<td><?= empty($order['voip']) ? '-':$order['voip'] ?></td>
		</tr>
		<tr>
			<td>Jabatan</td>
			<td>:</td>
			<td><?= empty($order['pengorder']) ? '-':ucwords(strtolower($this->M_civil->getJabatanPKJ($order['pengorder'])->row()->jabatan)); ?></td>
			<td>Jenis Order</td>
			<td>:</td>
			<td><?= $order['jenis_order'] ?></td>
		</tr>
		<tr>
			<td>Seksi</td>
			<td>:</td>
			<td><?= empty($order['section_name']) ? '-':ucwords(strtolower($order['section_name'])) ?></td>
			<td>Jenis Pekerjaan</td>
			<td>:</td>
			<td><?= $order['jenis_pekerjaan'] ?></td>
		</tr>
		<tr>
			<td valign="top" >Detail Pekerjaan</td>
			<td valign="top">:</td>
			<td></td>
		</tr>
		<tr>
			<td valign="bottom" colspan="6">
				<table border="1" style="border-collapse: collapse;width: 100%">
					<tr>
						<th style="width: 30px;">No</th>
						<th>Pekerjaan</th>
						<th width="15%">Qty</th>
						<th width="15%">Satuan</th>
						<th>Keterangan</th>
					</tr>
					<?php if (empty($ket)): ?>
						<tr class="text-center">
							<td colspan="5">No Data</td>
						</tr>
					<?php endif ?>
					<?php $x=1; foreach ($ket as $k): ?>
					<tr >
						<td style="text-align: center;" ><?= $x; ?></td>
						<td>
							<?= $k['pekerjaan'] ?>
						</td>
						<td style="text-align: center;">
							<?= $k['qty'] ?>
						</td>
						<td style="text-align: center;">
							<?= $k['satuan'] ?>
						</td>
						<td>
							<?= $k['keterangan'] ?>
						</td>
					</tr>
					<?php $x++; endforeach ?>
				</table>
			</td>
		</tr>
		<tr>
			<td>Status Order</td>
			<td>:</td>
			<td><?php echo $order['status'] ?></td>
		</tr>
		<?php if($order['status'] == 'Urgent'){
			?>
		<tr>
			<td>Status Order</td>
			<td>:</td>
			<td><?php echo $order['alasan'] ?></td>
		</tr>
			<?php
		} ?>
		<tr>
			<td>Tanggal Dibutuhkan</td>
			<td>:</td>
			<td><?= strftime('%d %B %Y', strtotime($order['tgl_dibutuhkan'])) ?></td>
		</tr>
	</table>
</div>
