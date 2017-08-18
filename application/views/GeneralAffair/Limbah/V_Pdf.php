<table style="width:100%;border: 1px solid black;">
	<tr>
		<td style="width: 50px;height: 100px"><img src="<?php echo base_url('/assets/img/logo.png'); ?>" width="80" heigth="60"></td>
		<td style="text-align: center; width: 600px;height: 100px">
			<h3 style="margin-bottom: 0; padding-bottom: 0;font-size: 21px">Koreksi Pengiriman Limbah B3 ke TPS</h3>
			<p style="font-size: 16px">Waste Management</p>
			<p style="font-size: 16px">CV Karya Hidup Sentosa</p>
		</td>
		<td style="width: 70px;height: 100px"><img src="<?php echo base_url('/assets/img/wm.png'); ?>" width="100" height="80"></td>
	</tr>
</table>
<?php foreach ($Limbah as $headerRow): ?>
<table style="width:100%;border: 1px solid black;">
	<tr>
		<td rowspan="2" style="width: 15%;border:1px solid black;font-size: 14px"><b>No :</b></td>
		<td rowspan="2" style="width: 25%;border:1px solid black;font-size: 14px"><b>Tgl. Kirim : </b><?php echo date('d M Y', strtotime($headerRow['tanggal_kirim'])) ;?></td>
		<td colspan="2" style="width: 50%;border:1px solid black;font-size: 14px"><b>Seksi Pengirim : </b><?php echo $headerRow['seksi']; ?></td>
	</tr>
	<tr>
		<td colspan="2" style="width: 50%;border:1px solid black;font-size: 14px"><b>Nama Pengirim : </b><?php echo $headerRow['nama_kirim']; ?></td>
	</tr>
</table>
<table style="width:100%;border: 1px solid black">
	<tr>
		<td colspan="2" style="width: 70%;border:1px solid black;font-size: 14px"><b>Nama Limbah : </b><?php echo $headerRow['nama_limbah']; ?></td>
		<td colspan="1" style="width: 30%;border:1px solid black;font-size: 14px"><b>Simbol B3 :</b></td>
	</tr>
	<tr>
		<td colspan="2" style="width: 70%;border:1px solid black;font-size: 14px"><b>Nomor Limbah : </b><?php echo $headerRow['nomor_limbah']; ?></td>
		<td rowspan="3" style="width: 30%;border:1px solid black;font-size: 14px;height: 100px"></td>
	</tr>
	<tr>
		<td colspan="2" style="width: 70%;border:1px solid black;font-size: 14px"><b>Jenis Limbah : </b><?php echo $headerRow['limbahjenis']; ?></td>
	</tr>
	<tr>
		<td colspan="2" style="width: 70%;border:1px solid black;font-size: 14px"><b>Karakteristik : </b><?php echo $headerRow['karakteristik_limbah']; ?></td>
	</tr>
</table>
<table style="width: 100%;border:1px solid black">
	<tr>
		<td colspan="1" style="width: 40%;border:1px solid black;font-size: 16px"><b>Kondisi Saat Pengiriman Limbah :</b></td>
		<td colspan="3" style="width: 60%;border:1px solid black;font-size: 16px"><b>Temuan Ketidaksesuaian :</b></td>
	</tr>
	<tr>
		<td rowspan="4" style="width: 50%;border:1px solid black;height: 100px"><center><img src="<?php echo base_url('/assets/limbah/kondisi-limbah/'.$headerRow['kondisi_limbah']);?>" width="100"></center></td>
		<td colspan="1" style="width: 25%;border:1px solid black;font-size: 14px"><b>Kemasan : </b><?php echo $headerRow['temuan_kemasan']; ?></td>
		<td rowspan="1" style="width: 25%;border:1px solid black;font-size: 14px;text-align: center;"><?php if($headerRow['temuan_kemasan_status']==1)
                                                                {echo "Ok";
                                                            }elseif ($headerRow['temuan_kemasan_status']==0) {echo "Not Ok";} ;?></td>
	</tr>
	<tr>
		<td colspan="1" style="width: 25%;border:1px solid black;font-size: 14px"><b>Kebocoran : </b><?php echo $headerRow['temuan_kebocoran']; ?></td>
		<td rowspan="1" style="width: 25%;border:1px solid black;font-size: 14px;text-align: center"><?php if($headerRow['temuan_kebocoran_status']==1) 
                                                                {echo "Ok";
                                                                }elseif ($headerRow['temuan_kebocoran_status']==0) {
                                                                   echo "Not Ok";} ;?></td>
	</tr>
	<tr>
		<td colspan="1" style="width: 25%;border:1px solid black;font-size: 14px"><b>Level Limbah : </b><?php echo $headerRow['temuan_level_limbah']; ?></td>
		<td rowspan="1" style="width: 25%;border:1px solid black;font-size: 14px;text-align: center"><?php if($headerRow['temuan_level_limbah_status']==1) 
                                                                {echo "Ok";
                                                                }elseif ($headerRow['temuan_level_limbah_status']==0) {
                                                                    echo "Not Ok";} ;?></td>
	</tr>
	<tr>
		<td colspan="1" style="width: 25%;border:1px solid black;font-size: 14px"><b>Lain - Lain : </b><?php echo $headerRow['temuan_lain_lain']; ?></td>
		<td rowspan="1" style="width: 25%;border:1px solid black;font-size: 14px;text-align: center"><?php if($headerRow['temuan_lain_lain_status']==1) 
                                                                {echo "Ok";
                                                                }elseif ($headerRow['temuan_lain_lain_status']==0) {
                                                                echo "Not Ok";} ;?></td>
	</tr>
</table>
<table style="width: 100%;border:1px solid black">
	<tr>
		<td style="font-size: 16px"><b>Standar Kemasan/Pengiriman :</b></td>
	</tr>
</table>
<table style="width: 100%;border:1px solid black">
	<tr> 
		<td rowspan="4" style="width: 50%;border:1px solid black;font-size: 16px;height: 100px;text-align: left"><b>Foto : </b></br>
		<img src="<?php echo base_url('/assets/limbah/standar-foto/'.$headerRow['standar_foto']);?>" width="100"></td>
		<td colspan="2" style="width: 50%;border:1px solid black;font-size: 14px;height: 100px"><b>Referensi : </b><?php echo $headerRow['standar_refrensi']; ?></td>
	</tr>
	<tr>
		<td colspan="2" style="width: 50%;border:1px solid black;font-size: 14px"><b>Kemasan : </b><?php echo $headerRow['standar_kemasan']; ?></td>
	</tr>
	<tr>
		<td colspan="2" style="width: 50%;border:1px solid black;font-size: 14px"><b>Kebocoran : </b><?php echo $headerRow['standar_kebocoran']; ?></td>
	</tr>
	<tr>
		<td colspan="2" style="width: 50%;border:1px solid black;font-size: 14px"><b>Lain - Lain : </b><?php echo $headerRow['standar_lain_lain']; ?></td>
	</tr>
</table>
<table style="width: 100%;border:1px solid black">
	<tr>
		<td rowspan="3" style="width: 65%;border:1px solid black;font-size: 14px"><b>Catatan / Saran : </b><?php echo $headerRow['catatan_saran']; ?></td>
		<td colspan="2" style="width: 35%;border:1px solid black;font-size: 14px"><b>Tanggal :</b></td>
	</tr>
	<tr>
		<td colspan="2" style="width: 35%;border:1px solid black;text-align:center;font-size: 14px"><b>Seksi Waste Management</b></td>
	</tr>
	<tr>
		<td colspan="2" style="width: 35%;border:1px solid black;height: 100px"><b></b>
		<br></br>
		<br></br>
		<br></br>
		<br></br>
		<center>
		<b>(</b>......................................<b>)</b>
		</center>
		</td>
	</tr>
</table>
<?php endforeach; ?>