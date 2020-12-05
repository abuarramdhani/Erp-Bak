		 <div style="border-bottom: 1.5px solid black;border-top: 1.5px solid black;border-left: 1.5px solid black;border-right: 1.5px solid black;background:white">
			<!-- header -->
			<table style="width:100%;border-bottom: 1px solid black;border-collapse: collapse !important;page-break-inside:avoid;">
				<tr>
					<td rowspan="2" style="width:13%;padding:5px;">
						<center><img style="height: auto;padding:5px; width: 75px;" src="<?php echo base_url('assets/img/logo.png'); ?>" /></center>
					</td>
					<td style="width:29%;padding:5px;font-size:18px;border-left:1px solid black;border-right:1px solid black;">
						<div style="font-size:13px;font-weight:bold;">
							CV. Karya Hidup Sentosa <br>
							Jl. Magelang 144, Yogyakarta
						</div>
					</td>
					<td rowspan="2" style="width:45%;padding:5px;font-size:18px;">
						<center>
							<h3  style="font-size:18px !important">SURAT JALAN <br>
							PENGIRIMAN BARANG INTERNAL KHS</h3>
							<!-- <h3  style="font-size:18px !important">TRIAL > 10 <br>
							PENGIRIMAN BARANG INTERNAL KHS</h3> -->
						</center>
					</td>
					<td rowspan="2" style="width:11%; height: 25px;">
						<center>
							<img style="width: 21.312mm; height: auto;" src="<?php echo base_url('assets/upload/QR_MSJ/'.$get['Header'][0]['NO_SURATJALAN'].'.png') ?>">
						</center>
						<div style="font-size:12px;text-align:left !important">
							<b><?php echo $get['Header'][0]['NO_SURATJALAN'] ?></b>
						</div>
					</td>
				</tr>
				<tr>
					<td style="width:29%;padding:5px;border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;">
						<center><h2 style="color:red;font-size:19px"><?php echo $get['Header'][0]['DARI'] ?> KE <?php echo $get['Header'][0]['TUJUAN'] ?></h2></center>
					</td>
				</tr>
			</table>
			<!-- isi -->
			<div style="padding:15.534px;">

				<div style="width:30%;margin-left:11px;float:right">
					<label><b>Pengiriman melalui :</b></label><br>
					<span><?php echo $get['Header'][0]['JENIS_KENDARAAN'] ?></span><br><br>
					<label><b>Nomor Polisi :</b></label><br>
					<span><?php echo $get['Header'][0]['PLAT_NUMBER'] ?></span> <br><br>
					<label><b>Tanggal :</b></label><br>
					<span><?php echo date('d-M-Y H:i:s',strtotime($get['Header'][0]['PRINT_DATE'])) ?></span>
				</div>
				<div style="width:69.15%;float:left">
					<table style="width:100%;border-bottom: 1px solid black; font-size: 12px; border-collapse: collapse !important;">
						<tr>
							<th style="padding: 3px;width: 5%;border-left:1px solid black;border-top:1px solid black;">NO</th>
							<th style="padding: 3px;width: 40%;border-left:1px solid black;border-top:1px solid black;">
								NOMOR FPB <br> (Form Pengiriman Barang)
							</th>
							<th style="padding: 3px;width: 55%;border-left:1px solid black;border-top:1px solid black;border-right:1px solid black;">JENIS BARANG</th>
						</tr>
						<?php foreach ($get['Item'] as $key => $g): ?>
								<tr>
									<td style="text-align: center;padding: 3px;border-bottom:1px solid black;border-left:1px solid black;border-top:1px solid black;"><?php echo $key+1 ?></td>
									<td style="text-align: center;padding: 3px;border-bottom:1px solid black;border-left:1px solid black;border-top:1px solid black;"><?php echo $g['DOC_CUSTOM'] ?></td>
									<td style="text-align: center;padding: 3px;border-bottom:1px solid black;border-left:1px solid black;border-top:1px solid black;border-right:1px solid black;"><?php echo $g['KETERANGAN'] ?></td>
								</tr>
						<?php endforeach; ?>
						<!-- <?php foreach ($ge as $key => $g): ?>
								<tr>
									<td style="text-align: center;padding: 3px;border-bottom:1px solid black;border-left:1px solid black;border-top:1px solid black;"><?php echo $key+1 ?></td>
									<td style="text-align: center;padding: 3px;border-bottom:1px solid black;border-left:1px solid black;border-top:1px solid black;"><?php echo $g ?></td>
									<td style="text-align: center;padding: 3px;border-bottom:1px solid black;border-left:1px solid black;border-top:1px solid black;border-right:1px solid black;"><?php echo $g ?></td>
								</tr>
						<?php endforeach; ?> -->
					</table>
				</div>
			</div>

			<!-- footer -->
			<div style="background:white">
					<table style="width:100%;height: 320px;border-collapse: collapse !important;">
						<tr>
							<td style="width:48%;padding:5px;">
									<br><br><br>
									<i style="font-size:11px;">*) Untuk melihat detail barang, cek web Monitoring Pengiriman Barang Internal KHS.
									<span style="color:blue;">http://produksi.quick.com/PengirimanBarangInternal</span></i style="font-size:10px;">
							</td>
							<td style="width:26%;padding:5px;font-size:12px;vertical-align: text-top">
								<center>
									<br><b>DIKIRIM OLEH :</b>
									<br>
									<br>
									<br>
									<br>
									<br>
									<?php echo $get['Header'][0]['NAMA_SUPIR']?>
									<!-- STEV -->
								</center>
							</td>
							<td style="width:26%;padding:5px;font-size:12px;vertical-align: text-top">
								<center>
									<br><b>DITERIMA OLEH :</b><br>
									<br>
									<br>
									<br>
									<br>
									GUDANG PENERIMAAN
								</center>
							</td>
						</tr>
					</table>
				</div>
		</div>
		<table style="width: 100%;">
			<tr>
				<td style="font-size: 11px;width:83%;font-weight:bold">
					FRM-PPB-02-02
				</td>
				<td style="width:17%;font-size: 11px;">
					<?php  $get['Header'][0]['FLAG_CETAK'] == 'Y' ? $f = "<b style='color:red'>Sudah Pernah Dicetak</b>" : $f = ''; echo $f?>
				</td>
			</tr>
		</table>
