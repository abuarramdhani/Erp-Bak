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
			<td style="width: 5%" rowspan="4">
				<img style="height: 110px; width: 90px" src="<?php echo base_url('/assets/img/logo.png') ?>" />
			</td>
			<td>
				<p><b>MEMO</b></p>
			</td>
		</tr>
		<tr>
			<td><b>PAYROLL NON STAFF</b></td>
		</tr>
		<tr>
			<td><b>CV. KARYA HIDUP SENTOSA</b></td>
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
			<td>Transfer Upah Pekerja Harian Lepas (<?php $period=explode(' - ',$periode); echo date('d/m/Y',strtotime($period[0]));echo " - ";echo date('d/m/Y',strtotime($period[1]));?>)</td>
		</tr>
	</table>
	<table style="font-size: 16px;margin-top: 38px;">
		<tr>
			<td>Kepada Yth:</td>
		</tr>
		<tr>
			<td><b><?=$tujuan ?></b></td>
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
			<td>lepas KHS Pusat dan Tuksono , periode (<?php $period=explode(' - ',$periode); echo date('d/m/Y',strtotime($period[0]));echo " - ";echo date('d/m/Y',strtotime($period[1]));?>)</td>
		</tr>
	</table>
	<table style="margin-left: 60px;font-size: 13px;margin-top: 10px;border-collapse: collapse;">
		<tr>
			<td style="border: 1px solid black;width: 140px;">KEPALA TUKANG</td>
			<td style="border: 1px solid black;width: 160px;">Rp <?php echo number_format(ceil($total['t_ktukang']),2,',','.')?></td>
			<td style="width: 20px"></td>
			<td style="border: 1px solid black;width: 150px;">KEPALA TUKANG</td>
			<td style="border: 1px solid black;width: 160px;">Rp <?php echo number_format(ceil($total['p_ktukang']),2,',','.') ?></td>
		</tr>
		<tr>
			<td style="border: 1px solid black;">TUKANG</td>
			<td style="border: 1px solid black;">Rp <?php echo number_format(ceil($total['t_tukang']),2,',','.') ?></td>
			<td></td>
			<td style="border: 1px solid black;">TUKANG</td>
			<td style="border: 1px solid black;">Rp <?php echo number_format(ceil($total['p_tukang']),2,',','.') ?></td>
		</tr>
		<tr>
			<td style="border: 1px solid black;">SERABUTAN</td>
			<td style="border: 1px solid black;">Rp <?php echo number_format(ceil($total['t_serabutan']),2,',','.') ?></td>
			<td></td>
			<td style="border: 1px solid black;">SERABUTAN</td>
			<td style="border: 1px solid black;">Rp <?php echo number_format(ceil($total['p_serabutan']),2,',','.') ?></td>
		</tr>
		<tr>
			<td style="border: 1px solid black;">TENAGA</td>
			<td style="border: 1px solid black;">Rp <?php echo number_format(ceil($total['t_tenaga']),2,',','.') ?></td>
			<td></td>
			<td style="border: 1px solid black;">TENAGA</td>
			<td style="border: 1px solid black;">Rp <?php echo number_format(ceil($total['p_tenaga']),2,',','.') ?></td>
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
			<td style="border: 1px solid black;">Rp <?php echo number_format(ceil($total['total_t']),2,',','.') ?></td>
			<td></td>
			<td style="border: 1px solid black;">TOTAL KHS PUSAT</td>
			<td style="border: 1px solid black;">Rp <?php echo number_format(ceil($total['total_p']),2,',','.') ?></td>
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
			<td style="border: 1px solid black;">Rp <?php echo number_format(ceil($total['total_semua']),2,',','.') ?></td>
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
			<td style=""></td>
			<td colspan="2" style="text-align: right;">Yogyakarta, 
			<?php 
				echo date('d');
				$month=date('m');
				if ($month=='01') {
					echo " Januari ";
				}elseif ($month=='02') {
					echo " Februari ";
				}elseif ($month=='03') {
					echo " Maret ";
				}elseif ($month=='04') {
					echo " April ";
				}elseif ($month=='05') {
					echo " Mei ";
				}elseif ($month=='06') {
					echo " Juni ";
				}elseif ($month=='07') {
					echo " Juli ";
				}elseif ($month=='08') {
					echo " Agustus ";
				}elseif ($month=='09') {
					echo " September ";
				}elseif ($month=='10') {
					echo " Oktober ";
				}elseif ($month=='11') {
					echo " November ";
				}elseif ($month=='12') {
					echo " Desember ";
				};
				echo date('Y');
			?></td>
		</tr>
		<tr>
			<td style="text-align: center;width: 33%">Mengetahui,</td>
			<td style="text-align: center;width: 34%">Menyetujui,</td>
			<td style="text-align: center;width: 33%">Dibuat Oleh</td>
		</tr>
	</table>
	<table style="width: 100%;font-size: 15px;text-align: center; margin-top: 55px;">
		<tr>
			<?php 
			foreach ($ttd as $ttd_mengetahui) {
				if($ttd_mengetahui['posisi'] == "mengetahui"){
					echo "<td width='33%'><u>".ucwords(strtolower($ttd_mengetahui['nama']))."</u></td>";
			
				}
			}
			foreach ($ttd as $ttd_mengetahui) {
				if($ttd_mengetahui['posisi'] == "menyetujui"){
					echo "<td width='34%'><u>".ucwords(strtolower($ttd_mengetahui['nama']))."</u></td>";
			
				}
			}
			foreach ($ttd as $ttd_dibuat) {
				if($ttd_dibuat['posisi'] == "dibuat"){
					echo "<td width='33%'><u>".ucwords(strtolower($ttd_dibuat['nama']))."</u></td>";
			
				}
			}
			?>
		</tr>
		<tr>
			<?php 
			foreach ($ttd as $ttd_mengetahui) {
				if($ttd_mengetahui['posisi'] == "mengetahui"){
					echo "<td>".ucwords(strtolower($ttd_mengetahui['jabatan']))."</td>";
			
				}
			}
			foreach ($ttd as $ttd_mengetahui) {
				if($ttd_mengetahui['posisi'] == "menyetujui"){
					echo "<td>".ucwords(strtolower($ttd_mengetahui['jabatan']))."</td>";
			
				}
			}
			foreach ($ttd as $ttd_dibuat) {
				if($ttd_dibuat['posisi'] == "dibuat"){
					echo "<td>".ucwords(strtolower($ttd_dibuat['jabatan']))."</td>";
			
				}
			}
			?>
		</tr>
	</table>
</div>
</body>
</html>

