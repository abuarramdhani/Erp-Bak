<style>
	.samaDengan{
		padding-left: 40px;
	}
	.textKiri{
		text-align: right;
	}
	tr.padding10 td{
		padding-top: 10px;
	}
</style>
<h2>E-Order - Civil Maintenance</h2>
<hr>
<table>
	<tr>
		<td>Tanggal Order</td>
		<td class="samaDengan">:</td>
		<td>
			<?= //$this->konversibulan->KonversiAngkaKeBulan($order['tgl_order'])
				// date('d F Y', strtotime($order['tgl_order']))
				strftime('%d %B %Y',strtotime($order['tgl_order']));
			 ?>
		</td>
	</tr>
	<tr>
		<td style="padding-top: 10px;">Dari</td>
	</tr>
	<tr>
		<td>Pekerja</td>
		<td class="samaDengan">:</td>
		<td><?= $order['pengorder'].' - '.$order['dari'] ?></td>
	</tr>
	<tr>
		<td>Jabatan</td>
		<td class="samaDengan">:</td>
		<td><?= empty($order['pengorder']) ? '-':$this->M_civil->getJabatanPKJ($order['pengorder'])->row()->jabatan; ?></td>
	</tr>
	<tr>
		<td>Seksi</td>
		<td class="samaDengan">:</td>
		<td><?= empty($order['section_name']) ? '-':$order['section_name'] ?></td>
	</tr>
	<tr>
		<td>Lokasi</td>
		<td class="samaDengan">:</td>
		<td><?= empty($order['location_name']) ? '-':$order['location_name'] ?></td>
	</tr>
	<tr class="padding10">
		<td>Jenis Order</td>
		<td class="samaDengan">:</td>
		<td><?= $order['jenis_order'] ?></td>
	</tr>
	<tr>
		<td>Jenis Pekerjaan</td>
		<td class="samaDengan">:</td>
		<td><?= $order['jenis_pekerjaan'] ?></td>
	</tr>
	<tr>
		<td>Judul</td>
		<td class="samaDengan">:</td>
		<td><?= $order['judul'] ?></td>
	</tr>
	<tr>
		<td valign="top" >Detail Pekerjaan</td>
		<td valign="top" class="samaDengan">:</td>
		<td valign="bottom">
			<table border="1" style="border-collapse: collapse;">
				<tr>
					<th>No</th>
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
					<td>
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
		<td>Tanggal Dibutuhkan</td>
		<td class="samaDengan">:</td>
		<td><?= strftime('%d %B %Y', strtotime($order['tgl_dibutuhkan'])) ?></td>
	</tr>
</table>
<table border="1" style="border-collapse: collapse; width: 100%; margin-top: 100px;">
	<tr>
		<td colspan="3" style="text-align: center;">Penerima Order</td>
	</tr>
	<tr>
		<td style="text-align: center;">Kepala Seksi</td>
		<td style="text-align: center;">Kepala Unit</td>
		<td style="text-align: center;">Kepala Departemen</td>
	</tr>
	<tr>
		<td style="text-align: center; padding-top: 100px;"></td>
		<td style="text-align: center; padding-top: 100px;"></td>
		<td style="text-align: center; padding-top: 100px;"></td>
	</tr>
	<tr>
		<td style="text-align: center; padding-top: 10px;">(.............................................)</td>
		<td style="text-align: center; padding-top: 10px;">(.............................................)</td>
		<td style="text-align: center; padding-top: 10px;">(.............................................)</td>
	</tr>
	<tr>
		<td style="padding-left: 10px;">tgl.</td>
		<td style="padding-left: 10px;">tgl.</td>
		<td style="padding-left: 10px;">tgl.</td>
	</tr>
</table>