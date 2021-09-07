<table style="width: 100%; margin-top: 0px; border:2px solid black; border-collapse: collapse;">
	<tr>
		<td rowspan="2" style="width: 10%; padding-top: 5px; padding-bottom: 5px; border: 2px solid black;" align="center">
			<img style="height:79px" src="<?php echo base_url('assets/img/quick.jpg') ?>">
		</td>
		<td style="width: 40%; border: 2px solid black; padding-left: 5px;line-height:15px;">
			<p style="font-size: 12px;"><strong>CV. KARYA HIDUP SENTOSA</strong></p>
			<p style="font-size: 12px;">Jl. Magelang No. 144 YOGYAKARTA</p>
			<br>
		</td>
		<td colspan="2" style="border:2px solid black;line-height:15px;" align="left">
			<table style="font-size: 11px;font-weight:bold;width:62.4%">
				<tr>
					<td>Tanggal</td>
					<td>:</td>
					<td><?php echo $get[0]['CREATED_DATE'] ?></td>
				</tr>
				<tr>
					<td>No</td>
					<td>:</td>
					<td><?php echo $get[0]['DOCUMENT_NUMBER'] ?></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td style="font-size: 15px; border:2px solid black">
			<center><strong>PENGIRIMAN BARANG BEKAS <br><?php echo $get[0]['TYPE_DOCUMENT'] === 'PBB-NS' ? 'NON STOK' : 'STOK' ?> (<?php echo $get[0]['TYPE_DOCUMENT'] ?>)</strong> </center>
		</td>
		<td style="border:2px solid black;line-height:17px;">
			<?php
				$seksi = explode(' - ', $get[0]['SEKSI']);
			 ?>
			<table style="font-size: 11px;font-weight:bold;width:100%">
				<tr>
					<td>Seksi Pengirim</td>
					<td>:</td>
					<td><?php echo $seksi[0] ?></td>
				</tr>
				<tr>
					<td>Cost Center</td>
					<td>:</td>
					<td><?php echo $get[0]['COST_CENTER'] ?></td>
				</tr>
				<tr>
					<td>Subinv Asal</td>
					<td>:</td>
					<td><?php echo !empty($get[0]['SUB_INVENTORY']) ? $get[0]['SUB_INVENTORY'] : '-' ?></td>
				</tr>
				<tr>
					<td>Locator Asal</td>
					<td>:</td>
					<td><?php echo !empty($get[0]['LOCATOR']) ? $get[0]['LOCATOR'] : '-' ?></td>
				</tr>
			</table>
			<!-- &nbsp;<strong> &emsp;:</strong>&emsp;<strong><?php  echo $get['tgl']?></strong> <br>
			&nbsp;<strong> &emsp;&emsp;&nbsp;&nbsp;&nbsp;:</strong>&emsp;<strong>123456</strong> <br>
			&nbsp;<strong> &emsp;&emsp;&nbsp;&nbsp;&nbsp;:</strong>&emsp;<strong><?php echo 'kerr'?></strong> <br>
			&nbsp;<strong> &emsp;&emsp;&nbsp;&nbsp;:</strong>&emsp;<strong>123456</strong> -->
		</td>
		<td style="border: 2px solid black; text-align: center;">
			<img style="height: 79px" src="<?php echo base_url('/assets/img/PBIQRCode/'.$get[0]['DOCUMENT_NUMBER'].'.png')?>">
		</td>
	</tr>
</table>

<table style="border:2px solid black; overflow: wrap; width:100%; margin-top:10px;border-collapse: collapse;" >
		<thead>
			<tr>
				<th align="center" width="5%" style=" font-size: 11px;border:1px solid black;" rowspan="2">No</th>
				<th align="center" width="20%" style=" font-size: 11px;border:1px solid black;" rowspan="2">Kode Barang</th>
				<th align="center" width="35%" style="font-size: 11px;border:1px solid black;" rowspan="2">Deskripsi</th>
				<th align="center" width="20%" style="font-size: 11px;border:1px solid black;" colspan="2">Satuan</th>
				<th align="center" width="20%" style="height:20px;font-size: 11px;border:1px solid black;" colspan="2">Jumlah</th>
      </tr>
      <tr>
				<th align="center" width="10%" style="font-size: 11px; border:1px solid black;">Serah</th>
				<th align="center" width="10%" style="font-size: 11px; border:1px solid black;">Terima</th>
				<th align="center" width="10%" style="font-size: 11px; border:1px solid black;">Serah</th>
				<th align="center" width="10%" style="height:20px; font-size: 11px; border:1px solid black;">Terima</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($get as $key => $data): ?>
				<tr>
					<td align="center" style="height: 20px; font-size: 10px; border: 1px solid black"><?php echo $key+1?></td>"
					<td align="center" style="height: 20px; font-size: 10px; border: 1px solid black"><?php echo $data['ITEM']?></td>
					<td style="height: 20px; font-size: 10px; border: 1px solid black">&nbsp;<?php echo $data['DESCRIPTION']?></td>
					<td align="center" style="height: 20px; font-size: 10px; border: 1px solid black"><?php echo $data['UOM'] ?></td>
					<td align="center" style="height: 20px; font-size: 10px; border: 1px solid black"></td>
					<td align="center" style="font-size: 10px; border: 1px solid black"><?php echo $data['JUMLAH'] ?></td>
					<td align="center" style="font-size: 10px; border: 1px solid black"></td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>

	<table style="width: 100%; margin-top: 10px ;border:1px solid black; text-align: center;vertical-align: text-top; font-size: 11px;border-collapse: collapse;" >
		<tr>
			<td style="padding: 5px;border-right: 1px solid black;" >Gudang</td>
			<td style="padding: 5px;border-right: 1px solid black;" >Menyerahkan</td>

			<?php if ($get[0]['TYPE_DOCUMENT'] == 'PBB-S'): ?>
				<td style="padding: 5px;border-right: 1px solid black;" >Disetujui :<br/> Kepala Departemen </td>
				<td style="padding: 5px;border-right: 1px solid black;" >Disetujui :<br/> PPIC </td>
			<?php endif; ?>

			<td style="padding: 5px;border-right: 1px solid black;" >Diserahkan : <br/> Kepala Unit</td>
			<td style="padding: 5px;height: 70px; " >Diserahkan : <br/> Kepala Seksi</td>
		</tr>
		<tr>
			<?php if ($get[0]['TYPE_DOCUMENT'] == 'PBB-S'): ?>
				<td style="padding: 5px;border-right: 1px solid black;">(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)</td>
				<td style="padding: 5px;border-right: 1px solid black;">(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)</td>
			<?php endif; ?>
			<td style="padding: 5px;border-right: 1px solid black;">(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)</td>
			<td style="padding: 5px;border-right: 1px solid black;">(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)</td>
			<td style="padding: 5px;border-right: 1px solid black;">(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)</td>
			<td>(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)</td>
		</tr>
	</table>
