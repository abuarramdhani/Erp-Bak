<style>
	table {
		page-break-inside: avoid;
	}
</style>
<?php $i = 1;
foreach ($kumpulandata as $data) { ?>
	<div class="row" style="margin-top:200px;">
		<table style="width: 100%; margin-top: 40px; border-top:1px solid black; border-left:1px solid black; border-right:1px solid black;">
			<tr>
				<td rowspan="4" style="width: 12%; padding-top: 5px; padding-bottom: 5px; border-bottom: 1px solid black;" align="center">
					<img style="height:79px" src="<?php echo base_url('assets/img/quick.jpg') ?>">
				</td>
				<td rowspan="2" style="width: 30%;">
					<p style="font-size: 11px;"><strong>CV. KARYA HIDUP SENTOSA</strong></p>
					<p style="font-size: 9px;">Jl. Magelang No. 144 YOGYAKARTA</p>
					<br />

				</td>
				<td rowspan="2" style="width: 8%; padding-left: 30px;">
					<b style="font-size: 45px; color: red;">K3</b>
				</td>
				<td rowspan="4" style="width: 8%; border-right: 1px solid black; border-bottom: 1px solid black; text-align: center;">
					<img style="height: 79px" src="<?php echo base_url('assets/img/temp_qrcode/' . $data['nomor'] . '.png'); ?>">
				</td>
				<td style="width: 20%;font-size: 10px;border-right: 1px solid black; border-bottom:1px solid black">&nbsp;Tanggal :&nbsp;<strong><?php echo $data['tgl'] ?></strong>
				</td>
				<td style="width: 20%;font-size: 10px;border-right: 1px solid black; border-bottom:1px solid black">&nbsp;No : &nbsp;<strong><?php echo $data['nomor'] ?></strong>
				</td>
			</tr>
			<tr>
				<td style="width: 20%;font-size: 8px;border-right: 1px solid black;">&nbsp;Seksi Pengebon :</td>
				<td style="width: 20%;font-size: 8px;">&nbsp;Pengebonan ke Gudang :</td>
			</tr>
			<tr>
				<td rowspan="2" colspan="2" align="left" style="width: 20%;font-size: 10px; border-bottom: 1px solid black">&nbsp; <strong>
						<p style="font-size: 14px;"><strong>BUKTI PERMINTAAN & PEMAKAIAN BARANG GUDANG (BPPBG)</strong></p>
					</strong>
				</td>
				<td align="center" style="white-space: nowrap; width: 20%;font-size: 10px;border-right: 1px solid black; border-bottom: 1px solid black">&nbsp; <strong><?php echo $data['seksi'] ?></strong>
				</td>
				<td align="center" style="width: 20%;font-size: 10px;border-bottom: 1px solid black;">&nbsp;<strong><?php echo $data['gudang'] ?></strong>
				</td>
			</tr>
			<tr>
				<td style="width: 20%;font-size: 8px;border-right: 1px solid black;">&nbsp;<?php echo $data['rdPemakai'] ?> Pemakai :</td>
				<td style="width: 20%;font-size: 8px;border-right: 1px solid black;">&nbsp;Cost Center/ Branch :</td>
			</tr>
			<tr>
				<td colspan="4" style="border-right: 1px solid black; font-size: 11px; height: 30px;">
					&nbsp;Untuk : &nbsp;<strong><?php echo $data['fungsi'] ?></strong>
				</td>
				<td align="center" style="width: 10%;font-size: 10px;border-right: 1px solid black;">&nbsp; <strong><?php echo $data['pemakai'] ?></strong>
				</td>
				<td align="center">
					<strong style="font-size: 11px;"><?php echo $data['cost'] . ' / ' . $data['kocab'] ?></strong></td>
			</tr>
		</table>
		<table style="width: 100%;border-right:1px solid black; border-top: 1px solid black; border-left: 1px solid black">
			<thead>
				<tr>
					<th align="center" width="4%" style=" font-size: 11px; border:1px solid black; border-left: 0px; border-top: 0px" rowspan="2">NO</th>
					<th align="center" width="13%" style=" font-size: 11px; border:1px solid black; border-left: 0px; border-top: 0px" rowspan="2">Kode</th>
					<th colspan="2" align="center" style="font-size: 11px; border:1px solid black; border-left: 0px; border-top: 0px" rowspan="2">Nama Barang</th>
					<th align="center" width="8%" style="font-size: 11px; border:1px solid black; border-left: 0px; border-top: 0px" rowspan="2">Satuan</th>
					<th align="center" style="height:20px; font-size: 11px; border:1px solid black; border-left: 0px; border-top: 0px" colspan="2">Qty</th>
					<th align="center" width="15%" style="font-size: 11px; border-bottom:1px solid black;" rowspan="2">Keterangan Pemakaian dan No. Order/target</th>
					<th align="center" width="8%" style=" font-size: 11px; border:1px solid black; border-left: 1px solid black; border-top: 0px" rowspan="2">Account</th>
				</tr>
				<tr>
					<th align="center" width="8%" style="font-size: 11px; border:1px solid black; border-left: 0px; border-top: 0px">Diminta</th>
					<th align="center" width="10%" style="height:20px; font-size: 11px; border:1px solid black; border-left: 0px; border-top: 0px">Diserahkan</th>
				</tr>
			</thead>
			<tbody>

				<?php

				foreach ($data['data_body'] as $data_body) {

				?>
					<tr>
						<td align="center" style="height: 25px; font-size: 10px; border-right: 1px solid black; border-bottom: 1px solid black">&nbsp;<?php echo $i ?></td>
						<td align="center" style="height: 25px; font-size: 10px; border-right: 1px solid black; border-bottom: 1px solid black">&nbsp;<?php echo $data_body['kode'] ?></td>
						<td style="font-size: 10px; border-bottom: 1px solid black">&nbsp;<?php echo $data_body['nama'] . ' ' . $data_body['produk']; ?></td>
						<td style="font-size: 10px; border-right: 1px solid black; border-bottom: 1px solid black">&nbsp;<?php echo $data_body['lokasi_simpanku'] ?>&nbsp;&nbsp;</td>
						<td align="center" style="font-size: 10px; border-right: 1px solid black; border-bottom: 1px solid black">&nbsp;<?php echo $data_body['satuan'] ?></td>
						<td align="center" style="font-size: 10px; border-right: 1px solid black; border-bottom: 1px solid black">&nbsp;<?php echo $data_body['diminta'] ?></td>
						<?php if (isset($data_body['penyerahan'])) : ?>
							<td align="center" style="font-size: 10px; border-right: 1px solid black; border-bottom: 1px solid black">&nbsp;<?= ((int) $data_body['penyerahan'] < (int) $data_body['diminta']) ? "<span style='font-weight: bold; color: #ff6b61'>" . $data_body['penyerahan'] . "</span>" : $data_body['penyerahan'] ?></td>
						<?php else : ?>
							<td align="center" style="font-size: 10px; border-right: 1px solid black; border-bottom: 1px solid black">&nbsp;<?= '0' ?></td>
						<?php endif ?>
						<td align="center" style="font-size: 10px; border-bottom: 1px solid black">&nbsp;<?php echo $data_body['ket'] ?></td>
						<td align="center" style="height: 25px; font-size: 10px; border-left: 1px solid black; border-bottom: 1px solid black">&nbsp;<?php echo $data_body['account'] ?></td>
					</tr>
				<?php
					$i++;
				}
				?>
			</tbody>

		</table>
		<table style="width: 100%; border:1px solid black; border-top: 1px solid black; text-align: center;vertical-align: text-top; font-size: 11px">
			<tr>
				<td style="width: 20%; border-right: 1px solid black;">Gudang :</td>
				<td style="width: 20%; border-right: 1px solid black;">Diterima : </td>
				<td style="width: 20%; border-right: 1px solid black;">Disetujui : **) <br /> PPIC </td>
				<td style="width: 20%; border-right: 1px solid black; ">Disetujui : <br /> Kepala Unit</td>
				<td style="width: 20%; height: 70px; ">Diminta : <br /> Kepala Seksi</td>
			</tr>
			<tr>
				<td style="border-right: 1px solid black;">(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)</td>
				<td style="border-right: 1px solid black;">(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)</td>
				<td style="border-right: 1px solid black;">(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)</td>
				<td style="border-right: 1px solid black;">(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)</td>
				<td>(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)</td>
			</tr>
		</table>
	</div>
<?php } ?>