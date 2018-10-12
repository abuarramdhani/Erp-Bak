<html>
<head>
</head>
<body>
<?php 
		set_time_limit(0);
		ini_set("memory_limit", "2048M");
							
	?>
<div style="width: 100%;padding-right: 30px;">
	<table style="width:100%;font-size: 18px;text-align: center;padding-left: 20px;">
		<tr>
			<td style="width: 5%" rowspan="3">
				<img style="height: 110px; width: 90px" src="<?php echo base_url('/assets/img/logo.png') ?>" />
			</td>
			<td>
				<p><b>MEMO</b></p>
			</td>
		</tr>
		<tr>
			<td><b>SEKSI CIVIL MAINTENANCE CV. KARYA HIDUP</b></td>
		</tr>
		<tr>
			<td><b>JL. MAGELANG NO. 144 YOGYAKARTA</b></td>
		</tr>
	</table>
	<div style="width: 100%; height: 4px; background-color: grey;">
		
	</div>
	<table style="width: 100%;font-size: 15px;margin-top:20px;">
		<tr>
			<td style="width: 45px;">No</td>
			<td style="width: 5px;">: </td>
			<td><?php echo $nmr_memo;?></td>
		</tr>
		<tr>
			<td style="width: 20px;">Hal</td>
			<td>: </td>
			<td>Transfer Upah Pekerja Harian Lepas Tgl <?php $period=explode(' - ',$periode); echo date('d F Y',strtotime($period[0]));echo " - ";echo date('d F Y',strtotime($period[1]));?></td>
		</tr>
	</table>
	<table style="font-size: 16px;margin-top: 38px;">
		<tr>
			<td>Kepada Yth:</td>
		</tr>
		<tr>
			<td><b>Bp. Agus Wahyudi ( Keuangan )</b></td>
		</tr>
		<tr>
			<td><b>Ditempat</b></td>
		</tr>
	</table>
	<table style="width: 100%; font-size: 15px;margin-top: 28px;">
		<tr>
			<td>Dengan hormat,</td>
		</tr>
		<tr>
			<td>Dengan ini mohon agar dilakukan transfer uang untuk pembayaran upah pekerja harian</td>
		</tr>
		<tr>
			<td>lepas KHS Pusat dan Tuksono , periode tanggal <?php $period=explode(' - ',$periode); echo date('d F Y',strtotime($period[0]));echo " - ";echo date('d F Y',strtotime($period[1]));?></td>
		</tr>
	</table>
	<table style="margin-left: 60px;font-size: 15px;margin-top: 10px;border-collapse: collapse;">
		<tr>
			<td style="border: 1px solid black;width: 140px;">KEPALA TUKANG</td>
			<td style="border: 1px solid black;width: 120px;">Rp <?php echo $total['t_ktukang']?></td>
			<td style="width: 20px"></td>
			<td style="border: 1px solid black;width: 150px;">KEPALA TUKANG</td>
			<td style="border: 1px solid black;width: 120px;">Rp <?php echo $total['p_ktukang'] ?></td>
		</tr>
		<tr>
			<td style="border: 1px solid black;">TUKANG</td>
			<td style="border: 1px solid black;">Rp <?php echo $total['t_tukang'] ?></td>
			<td></td>
			<td style="border: 1px solid black;">TUKANG</td>
			<td style="border: 1px solid black;">Rp <?php echo $total['p_tukang'] ?></td>
		</tr>
		<tr>
			<td style="border: 1px solid black;">SERABUTAN</td>
			<td style="border: 1px solid black;">Rp <?php echo $total['t_serabutan'] ?></td>
			<td></td>
			<td style="border: 1px solid black;">SERABUTAN</td>
			<td style="border: 1px solid black;">Rp <?php echo $total['p_serabutan'] ?></td>
		</tr>
		<tr>
			<td style="border: 1px solid black;">TENAGA</td>
			<td style="border: 1px solid black;">Rp <?php echo $total['t_tenaga'] ?></td>
			<td></td>
			<td style="border: 1px solid black;">TENAGA</td>
			<td style="border: 1px solid black;">Rp <?php echo $total['p_tenaga'] ?></td>
		</tr>
		<tr>
			<td height="20px;"></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td style="border: 1px solid black;">TOTAL TUKSONO</td>
			<td style="border: 1px solid black;">Rp <?php echo $total['total_t'] ?></td>
			<td></td>
			<td style="border: 1px solid black;">TOTAL KHS PUSAT</td>
			<td style="border: 1px solid black;">Rp <?php echo $total['total_p'] ?></td>
		</tr>
		<tr>
			<td height="20px;"></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td style="border: 1px solid black;">TOTAL SEMUA</td>
			<td style="border: 1px solid black;">Rp <?php echo $total['total_semua'] ?></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
	</table>
	<table style="width: 100%; font-size: 15px;margin-top: 15px;">
		<tr>
			<td>Demikian memo ini kami sampaikan. Atas perhatian dan kerjasamanya kami sampaikan banyak terimakasih.</td>
		</tr>
	</table>
	<table style="width: 100%; font-size: 15px;margin-top: 45px;text-align: center;">
		<tr>
			<td style="width: 45%"></td>
			<td>Yogyakarta <?php echo date('d F Y');?></td>
		</tr>
		<tr>
			<td>Mengetahui</td>
			<td>Dibuat Oleh</td>
		</tr>
	</table>
	<table style="width: 100%;font-size: 15px;text-align: center; margin-top: 55px;">
		<tr>
			<td><u>Bambang Yudhosuseno</u></td>
			<td><u>Eko Prasetyo A</u></td>
		</tr>
		<tr>
			<td>Ass.Ka Dept.Personalia</td>
			<td>Kepala Seksi Civil Maintenance</td>
		</tr>
	</table>
</div>
</body>
</html>

