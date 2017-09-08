<div class="row">
	<table style="font-size:10px; border: 1px solid;">
		<tr>
			<td style="padding: 5px; width: 40px; vertical-align: top; text-align: left; border: 1px solid;">
				<img src="<?php echo base_url('assets/img/logo.png')?>" style="width:35px;"/>
			</td>
			<td style="font-size:12px; padding: 5px; width: 200px; vertical-align: top; text-align: left;">
				CV. KARYA HIDUP SENTOSA<br>
				JOGJAKARTA
			</td>
			<td style="padding-left: 5px; padding-right: 5px; width: 400px; vertical-align: bottom;">
				<h4>
					<b>
					FORM PENDAFTARAN ASSET
					</b>
				</h4>
			</td>
			<td style="font-size:12px; padding: 5px; width: 150px; vertical-align: top; text-align: left;">
				No : <?php echo $DocNum; ?>
			</td>
		</tr>
	</table>
</div><br>
<div class="row" style="overflow-wrap: break-word; word-wrap: break-word;">
	<table class="table table-bordered" style="font-size:10px; border: 1px solid; overflow-wrap: break-word; word-wrap: break-word;">
		<tr>
			<th style="text-align: center; width: 30px">01.</th>
			<th style="padding: 4px; width: 180px">No. PP / BPPBG</th>
			<td style="padding: 4px; width:500px; overflow-wrap: break-word; word-wrap: break-word;"><?php echo $no_pp ?></td>
		</tr>
		<tr>
			<th style="text-align: center; width: 30px">02.</th>
			<th style="padding: 4px; width: 180px">Kode Barang</th>
			<td style="padding: 4px; width:500px; overflow-wrap: break-word; word-wrap: break-word;"><?php echo $kode_barang ?></td>
		</tr>
		<tr>
			<th style="text-align: center; width: 30px">03.</th>
			<th style="padding: 4px; width: 180px">Nama Barang</th>
			<td style="padding: 4px; width:500px; overflow-wrap: break-word; word-wrap: break-word;"><?php echo $nama_barang ?></td>
		</tr>
		<tr>
			<th style="text-align: center; width: 30px">04.</th>
			<th style="padding: 4px; width: 180px">Spesifikasi Barang</th>
			<td style="padding: 4px; width:500px; overflow-wrap: break-word; word-wrap: break-word;"><?php echo $spesifikasi ?></td>
		</tr>
		<tr>
			<th style="text-align: center; width: 30px">05.</th>
			<th style="padding: 4px; width: 180px">Negara Pembuat</th>
			<td style="padding: 4px; width:500px; overflow-wrap: break-word; word-wrap: break-word;"><?php echo $negara_pembuat ?></td>
		</tr>
		<tr>
			<th style="text-align: center; width: 30px">06.</th>
			<th style="padding: 4px; width: 180px">Jumlah Barang</th>
			<td style="padding: 4px; width:500px; overflow-wrap: break-word; word-wrap: break-word;"><?php echo $quantity ?></td>
		</tr>
		<tr>
			<th style="text-align: center; width: 30px">07.</th>
			<th style="padding: 4px; width: 180px">Power (KVA)</th>
			<td style="padding: 4px; width:500px; overflow-wrap: break-word; word-wrap: break-word;"><?php echo $kva ?></td>
		</tr>
		<tr>
			<th style="text-align: center; width: 30px">08.</th>
			<th style="padding: 4px; width: 180px">Serial Number / No. Polisi</th>
			<td style="padding: 4px; width:500px; overflow-wrap: break-word; word-wrap: break-word;"><?php echo $plat ?></td>
		</tr>
		<tr>
			<th style="text-align: center; width: 30px">09.</th>
			<th style="padding: 4px; width: 180px">Tanggal Mulai digunakan</th>
			<td style="padding: 4px; width:500px; overflow-wrap: break-word; word-wrap: break-word;"><?php echo $tgl_digunakan ?></td>
		</tr>
		<tr>
			<th style="text-align: center; width: 30px">10.</th>
			<th style="padding: 4px; width: 180px">Informasi Lain-lain</th>
			<td style="padding: 4px; width:500px; overflow-wrap: break-word; word-wrap: break-word;"><?php echo $info_lain ?></td>
		</tr>
		<tr>
			<th style="text-align: center; width: 30px">11.</th>
			<th style="padding: 4px; width: 180px">Tag Number</th>
			<td style="padding: 4px; width:500px; overflow-wrap: break-word; word-wrap: break-word;"></td>
		</tr>
		<tr>
			<th style="text-align: center; width: 30px">12.</th>
			<th style="padding: 4px; width: 180px">Cost Center</th>
			<td style="padding: 4px; width:500px; overflow-wrap: break-word; word-wrap: break-word;"></td>
		</tr>
		<tr>
			<th style="text-align: center; width: 30px">13.</th>
			<th style="padding: 4px; width: 180px">Umur Teknis</th>
			<td style="padding: 4px; width:500px; overflow-wrap: break-word; word-wrap: break-word;"></td>
		</tr>
	</table>
</div>
<div class="row" style="width: 50%; float: left;">
	<table class="table table-bordered" style="font-size:9px;">
		<tr>
			<th style="width: 25%; height: 17px; padding: 3px;" colspan="2">Seksi Pemakai</th>
			<td style="width: 65%; padding: 3px;"><?php echo $seksi_pemakai ?></td>
		</tr>
		<tr>
			<th style="text-align: center; width: 5%; padding: 1px;">a.</th>
			<th style="height: 17px; padding: 3px;"> Kota</th>
			<td style=" padding: 3px;"><?php echo $kota ?></td>
		</tr>
		<tr>
			<th style="text-align: center; width: 5%; padding: 1px;">b.</th>
			<th style="height: 17px; padding: 3px;"> Gedung</th>
			<td style=" padding: 3px;"><?php echo $gedung ?></td>
		</tr>
		<tr>
			<th style="text-align: center; width: 5%; padding: 1px;">c.</th>
			<th style="height: 17px; padding: 3px;"> Lantai</th>
			<td style=" padding: 3px;"><?php echo $lantai ?></td>
		</tr>
		<tr>
			<th style="text-align: center; width: 5%; padding: 1px;">d.</th>
			<th style="height: 17px; padding: 3px;"> Ruang</th>
			<td style=" padding: 3px;"><?php echo $ruang ?></td>
		</tr>

	</table>
</div>
<div class="row" style="width: 50%; float: right; text-align: right;">
	<table class="table table-bordered" style="font-size:9px;">
		<tr>
			<th style="width: 33%; text-align: center;">Kepala Seksi</th>
			<th style="width: 34%; text-align: center;">Pengelola asset</th>
			<th style="width: 33%; text-align: center;">Kepala Seksi Akuntansi</th>
		</tr>
		<tr>
			<td style="height: 53px; vertical-align: bottom; text-align: center;">(..........................)</td>
			<td style="height: 53px; vertical-align: bottom; text-align: center;">(..........................)</td>
			<td style="height: 53px; vertical-align: bottom; text-align: center;">(..........................)</td>
		</tr>
		<tr>
			<td style="height: 15px; vertical-align: bottom; text-align: center;">Tgl :.....................</td>
			<td style="height: 15px; vertical-align: bottom; text-align: center;">Tgl :.....................</td>
			<td style="height: 15px; vertical-align: bottom; text-align: center;">Tgl :.....................</td>
		</tr>
	</table>
</div>