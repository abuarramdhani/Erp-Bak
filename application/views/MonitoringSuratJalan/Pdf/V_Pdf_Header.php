
		<table style="width:100%;border-bottom: 1px solid black;border-collapse: collapse !important;page-break-inside:avoid;">
			<tr>
				<td rowspan="2" style="width:13%;padding:5px;border-top:1px solid black;border-left:1px solid black">
					<center><img style="height: auto;padding:5px; width: 75px;" src="<?php echo base_url('assets/img/logo.png'); ?>" /></center>
				</td>
				<td style="width:29%;padding:5px;font-size:18px;border-left:1px solid black;border-top:1px solid black">
					<div style="font-size:13px;font-weight:bold;">
						CV. Karya Hidup Sentosa <br>
						Jl. Magelang 144, Yogyakarta
					</div>
				</td>
				<td rowspan="2" style="width:45%;padding:5px;font-size:18px;border-left:1px solid black;border-top:1px solid black">
					<center>
					<h3  style="font-size:18px !important">SURAT JALAN <br>
					PENGIRIMAN BARANG INTERNAL KHS</h3>
					</center>
				</td>
				<td rowspan="2" style="width:11%; height: 25px;border-right:1px solid black;border-top:1px solid black">
					<center>
						<img style="width: 21.312mm; height: auto;" src="<?php echo base_url('assets/upload/QR_MSJ/'.$get['Header'][0]['NO_SURATJALAN'].'.png') ?>">
					</center>
					<div style="font-size:12px;text-align:left !important">
						<b><?php echo $get['Header'][0]['NO_SURATJALAN'] ?></b>
					</div>
				</td>
			</tr>
			<tr>
				<td style="width:29%;padding:5px;border-top:1px solid black;border-left:1px solid black;">
					<center><h2 style="color:red;font-size:19px"><?php echo $get['Header'][0]['DARI'] ?> KE <?php echo $get['Header'][0]['TUJUAN'] ?></h2></center>
				</td>
			</tr>
		</table>
