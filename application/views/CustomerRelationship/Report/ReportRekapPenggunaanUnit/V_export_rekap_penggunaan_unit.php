<h2 style="margin-left: 33%">Report Rekap Penggunaan Unit</h2>
<div style="width:49%;">
	<table width="100%">
		<tr>
			<td width="15%"><b>Period</b></td>
			<td width="3%">:</td>
			<td width="20%"><?php if($start_date==""){echo "-";}else{echo date_format(date_create($start_date),'d-M-Y');};?></td>
			<td width="3%">-</td>
			<td><?php if($start_date==""){echo "-";}else{echo date_format(date_create($end_date),'d-M-Y');}?></td>
		</tr>
	</table>
	<table width="100%">
		<tr>
			<td width="15%"><b>Province</b></td>
			<td width="3%">:</td>
			<td width="82%"><?php echo $province_chosen;?></td>
		</tr>
		<tr>
			<td width="15%"><b>Buying Type</b></td>
			<td width="3%">:</td>
			<td width="20%"><?php echo $buying_type;?></td>
		</tr>
		<tr>
			<td width="15%"><b>Sort By</b></td>
			<td width="3%">:</td>
			<td width="20%"><?php echo $sort_by ;?></td>
		</tr>
	</table>
	
</div>
<table border="1" style="border-collapse:collapse;table-layout:fixed;" width="100%">
	<thead>
		<tr>
			<th width="30" rowspan=2>No</th>
			<th width="120" rowspan=2>Buying Type</th>
			<th width="120" rowspan=2>Province</th>
			<th width="50" rowspan=2>Jumlah</th>
			<th width="100" colspan=2>Belum Dipakai</th>
			<th width="100" colspan=2>Belum Diketahui</th>
			<th width="100" colspan=2>Sudah Dipakai</th>
			<th width="100" colspan=2>Rusak</th>
			<th width="200" rowspan=2>Jumlah Kerusakan per Unit</th>
		</tr>
		<tr>
			<th width="50">Jumlah</th>
			<th width="50">%</th>
			<th width="50">Jumlah</th>
			<th width="50">%</th>
			<th width="50">Jumlah</th>
			<th width="50">%</th>
			<th width="50">Jumlah</th>
			<th width="50">%</th>
			
		</tr>
	</thead>
	<tbody>
		<?php foreach($RekapPenggunaanUnit as $no => $RekapPenggunaanUnit_item){ ?>
		<tr>
			<td align="center"><?= $no+1; ?></td>
			<td style="padding-left:10px;"><?= $RekapPenggunaanUnit_item['buying_type_name']; ?></td>
			<td style="padding-left:10px;"><?= $RekapPenggunaanUnit_item['province']; ?></td>
			<td align="right" style="padding-right:10px;"><?= $RekapPenggunaanUnit_item['jumlah']; ?></td>
			<td align="right" style="padding-right:10px;"><?= $RekapPenggunaanUnit_item['jlh_blm_dpakai']; ?></td>
			<td align="right" style="padding-right:10px;"><?= round($RekapPenggunaanUnit_item['jlh_blm_dpakai']*100/$RekapPenggunaanUnit_item['jumlah'],2)."%"; ?></td>
			<td align="right" style="padding-right:10px;"><?= $RekapPenggunaanUnit_item['jlh_blm_diketahui']; ?></td>
			<td align="right" style="padding-right:10px;"><?= round($RekapPenggunaanUnit_item['jlh_blm_diketahui']*100/$RekapPenggunaanUnit_item['jumlah'],2)."%"; ?></td>
			<td align="right" style="padding-right:10px;"><?= $RekapPenggunaanUnit_item['jlh_sudah_dpakai']; ?></td>
			<td align="right" style="padding-right:10px;"><?= round($RekapPenggunaanUnit_item['jlh_sudah_dpakai']*100/$RekapPenggunaanUnit_item['jumlah'],2)."%"; ?></td>
			<td align="right" style="padding-right:10px;"><?= $RekapPenggunaanUnit_item['jlh_rusak']; ?></td>
			<td align="right" style="padding-right:10px;"><?= round($RekapPenggunaanUnit_item['jlh_rusak']*100/$RekapPenggunaanUnit_item['jumlah'],2)."%"; ?></td>
			<td>
				<ul style="list-style-type:none">
					<?php foreach($RusakPerUnit as $RusakPerUnit_item){ 
							if($RusakPerUnit_item['buying_type_name']==$RekapPenggunaanUnit_item['buying_type_name'] 
								and $RusakPerUnit_item['province']==$RekapPenggunaanUnit_item['province'])
								{
					?>
					<li><?= $RusakPerUnit_item['jlh_rusak']." kali kerusakan : ".$RusakPerUnit_item['jlh_unit']." unit" ?></li>
					<?php 		}
							} 
					?>
				</ul>
			</td>
		</tr>
		<?php } ?>
	</tbody>
</table>