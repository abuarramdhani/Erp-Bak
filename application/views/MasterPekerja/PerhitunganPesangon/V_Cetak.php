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
			<td style="width: 1%" rowspan="4">
				<img style="height: 110px; width: 90px;margin-left: 80px" src="<?php echo base_url('/assets/img/logo.png') ?>" />
			</td>
		</tr>
		<tr>
			<td><b>SEKSI HUBUNGAN KERJA</b></td>
		</tr>
		<tr>
			<td><b>CV. KARYA HIDUP SENTOSA</b></td>
		</tr>
		<tr>
			<td><b>JL. MAGELANG NO. 144 YOGYAKARTA</b></td>
		</tr>
	</table>
	<div style="width: 100%; height: 4px; font-size: 15px ;background-color: grey;">

	</div>
	<br>
		<p>Kepada Yth.<br><?php echo ucwords(strtolower($penerima['0']['penerima'])) ?> <br>di Seksi Akuntansi</p>
	<br>
	   <p>Dengan hormat,<br>
	   Mohon untuk diperhitungkan pesangon atas pekerja dengan data di bawah ini : </p>
	 <br>
	 <p style="text-align: center; font-size: 15px ;">DATA UNTUK PERHITUNGAN PESANGON</p>
	 <table style="margin-left: 5px;font-size: 12px;margin-top: 10px;border-collapse: collapse;width: 100%">
		<tr>
		    <td style="border-left: 1px solid black;border-top: 1px solid black;width: 29%;padding-left: 5px" ><b><u>A. DATA PEKERJA</u></b></td>
			<td style="border-top:1px solid black;border-bottom: 1px;border-bottom: 1px solid black;width: 1%;padding-left: 20px"></td>
			<td style="border-top: 1px solid black;border-bottom: 1px solid black;width: 60%;order-bottom: 1px solid black;padding-left: 1px"></td>
			<td style="border: 1px solid black;width: 10%;padding-left: 20px">CEK</td>
		</tr>
		<tr>
		    <td style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;width: 29%;padding-left: 20px">NAMA</td>
			<td style="border-bottom: 1px solid black;width: 1%;padding-left: 20px">:</td>
			<td style="border-bottom: 1px solid black;width: 60%;padding-left: 20px"><?php echo $data['0']['nama']?></td>
			<td style="border-right: 1px solid black;border-left: 1px solid black;border-bottom: 1px solid black;width: 10%;padding-left: 20px"></td>
		</tr>
		<tr>
		    <td style="border-left: 1px solid black;border-bottom: 1px solid black;width: 29%;padding-left: 20px">NO.IND</td>
			<td style="border-bottom: 1px solid black;width: 1%;padding-left: 20px">:</td>
			<td style="border-bottom: 1px solid black;width: 60%;padding-left: 20px"><?php echo $data['0']['noind']?></td>
			<td style="border-right: 1px solid black;border-left: 1px solid black;border-bottom: 1px solid black;width: 10%;padding-left: 20px"></td>
		</tr>
		<tr>
		    <td style="border-left: 1px solid black;border-bottom: 1px solid black;width: 29%;padding-left: 20px">SEKSI</td>
			<td style="border-bottom: 1px solid black;width: 1%;padding-left: 20px">:</td>
			<td style="border-bottom: 1px solid black;width: 60%;padding-left: 20px"><?php echo $data['0']['seksi']?></td>
			<td style="border-right: 1px solid black;border-left: 1px solid black;border-bottom: 1px solid black;width: 10%;padding-left: 20px"></td>
		</tr>
		<tr>
		    <td style="border-left: 1px solid black;border-bottom: 1px solid black;width: 29%;padding-left: 20px">UNIT</td>
			<td style="border-bottom: 1px solid black;width: 1%;padding-left: 20px">:</td>
			<td style="border-bottom: 1px solid black;width: 60%;padding-left: 20px"><?php echo $data['0']['unit']?></td>
			<td style="border-right: 1px solid black;border-left: 1px solid black;border-bottom: 1px solid black;width: 10%;padding-left: 20px"></td>
		</tr>
		<tr>
		    <td style="border-left: 1px solid black;border-bottom: 1px solid black;width: 29%;padding-left: 20px">LOKASI</td>
			<td style="border-bottom: 1px solid black;width: 1%;padding-left: 20px">:</td>
			<td style="border-bottom: 1px solid black;width: 60%;padding-left: 20px"><?php echo $data['0']['lokasi_kerja']?></td>
			<td style="border-right: 1px solid black;border-left: 1px solid black;border-bottom: 1px solid black;width: 10%;padding-left: 20px"></td>
		</tr>
		<tr>
		    <td style="border-left: 1px solid black;border-bottom: 1px solid black;width: 29%;padding-left: 20px">JABATAN TERAKHIR
		    </td>
			<td style="border-bottom: 1px solid black;width: 1%;padding-left: 20px">:</td>
			<td style="border-bottom: 1px solid black;width: 60%;padding-left: 20px"><?php echo $data['0']['pekerjaan']?></td>
			<td style="border-right: 1px solid black;border-left: 1px solid black;border-bottom: 1px solid black;width: 10%;padding-left: 20px"></td>
		</tr>
		<tr>
		    <td style="border-left: 1px solid black;border-bottom: 1px solid black;width: 29%;padding-left: 20px">TANGGAL DIANGKAT
		    </td>
			<td style="border-bottom: 1px solid black;width: 1%;padding-left: 20px">:</td>
			<td style="border-bottom: 1px solid black;width: 60%;padding-left: 20px"><?php echo $data['0']['diangkat']?></td>
			<td style="border-right: 1px solid black;border-left: 1px solid black;border-bottom: 1px solid black;width: 10%;padding-left: 20px"></td>
		</tr>
		<tr>
		    <td style="border-left: 1px solid black;border-bottom: 1px solid black;width: 29%;padding-left: 20px">MASA KERJA</td>
			<td style="border-bottom: 1px solid black;width: 1%;padding-left: 20px">:</td>
			<td style="border-bottom: 1px solid black;width: 60%;padding-left: 20px"><?php echo $data['0']['masakerja']?></td>
			<td style="border-right: 1px solid black;border-left: 1px solid black;border-bottom: 1px solid black;width: 10%;padding-left: 20px"></td>
		</tr>
		<tr>
		    <td style="border-left: 1px solid black;border-bottom: 1px solid black;width: 29%;padding-left: 20px">SISA CUTI</td>
			<td style="border-bottom: 1px solid black;width: 1%;padding-left: 20px">:</td>
			<td style="border-bottom: 1px solid black;width: 60%;padding-left: 20px"><?php echo $data['0']['sisacuti']?></td>
			<td style="border-right: 1px solid black;border-left: 1px solid black;border-bottom: 1px solid black;width: 10%;padding-left: 20px"></td>
		</tr>
		<tr>
		    <td style="border-left: 1px solid black;border-bottom: 1px solid black;width: 29%;padding-left: 20px">TEMPAT/TGL LAHIR</td>
			<td style="border-bottom: 1px solid black;width: 1%;padding-left: 20px">:</td>
			<td style="border-bottom: 1px solid black;width: 60%;padding-left: 20px"><?php echo $data['0']['tempat']?></td>
			<td style="border-right: 1px solid black;border-left: 1px solid black;border-bottom: 1px solid black;width: 10%;padding-left: 20px"></td>
		</tr>
		<tr>
		    <td style="border-left: 1px solid black;border-bottom: 1px solid black;width: 29%;padding-left: 20px">ALAMAT</td>
			<td style="border-bottom: 1px solid black;width: 1%;padding-left: 20px">:</td>
			<td style="border-bottom: 1px solid black;width: 60%;padding-left: 20px"><?php echo $data['0']['alamat']?></td>
			<td style="border-right: 1px solid black;border-left: 1px solid black;border-bottom: 1px solid black;width: 10%;padding-left: 20px"></td>
		</tr>
		<tr>
		    <td style="border-left: 1px solid black;border-bottom: 1px solid black;width: 29%;padding-left: 20px">STATUS</td>
			<td style="border-bottom: 1px solid black;width: 1%;padding-left: 20px">:</td>
			<td style="border-bottom: 1px solid black;width: 60%;padding-left: 20px"><?php echo $data['0']['alasan']?></td>
			<td style="border-right: 1px solid black;border-left: 1px solid black;border-bottom: 1px solid black;width: 10%;padding-left: 20px"></td>
		</tr>
		<tr>
		    <td style="border-left: 1px solid black;border-bottom: 1px solid black;width: 29%;padding-left: 20px">TANGGAL KELUAR</td>
			<td style="border-bottom: 1px solid black;width: 1%;padding-left: 20px">:</td>
			<td style="border-bottom: 1px solid black;width: 60%;padding-left: 20px"><?php echo $data['0']['metu']?></td>
			<td style="border-right: 1px solid black;border-left: 1px solid black;border-bottom: 1px solid black;width: 10%;padding-left: 20px"></td>
		</tr>
		<tr>
		    <td style="border-left: 1px solid black;border-bottom: 1px solid black;width: 29%;padding-left: 20px">PROSES PHK</td>
			<td style="border-bottom: 1px solid black;width: 1%;padding-left: 20px">:</td>
			<td style="border-bottom: 1px solid black;width: 60%;padding-left: 20px"><?php echo (!empty($data['0']['tgl_phk']))? $data['0']['tgl_phk']:''?></td>
			<td style="border-right: 1px solid black;border-left: 1px solid black;border-bottom: 1px solid black;width: 10%;padding-left: 20px"></td>
		</tr>
		<tr>
		    <td style="border-left: 1px solid black;border-bottom: 1px solid black;width: 29%;padding-left: 20px">NPWP</td>
			<td style="border-bottom: 1px solid black;width: 1%;padding-left: 20px">:</td>
			<td style="border-bottom: 1px solid black;width: 60%;padding-left: 20px"><?php echo $data['0']['npwp']?></td>
			<td style="border-right: 1px solid black;border-left: 1px solid black;border-bottom: 1px solid black;width: 10%;padding-left: 20px"></td>
		</tr>
		<tr>
		    <td style="border-left: 1px solid black;border-bottom: 1px solid black;width: 29%;padding-left: 20px">NIK</td>
			<td style="border-bottom: 1px solid black;width: 1%;padding-left: 20px">:</td>
			<td style="border-bottom: 1px solid black;width: 60%;padding-left: 20px"><?php echo $data['0']['nik']?></td>
			<td style="border-right: 1px solid black;border-left: 1px solid black;border-bottom: 1px solid black;width: 10%;padding-left: 20px"></td>
		</tr>
		<tr>
		    <td style="border-left: 1px solid black;border-bottom: 1px solid black;width: 29%;padding-left: 20px">&nbsp;</td>
			<td style="border-bottom: 1px solid black;width: 1%;padding-left: 20px"></td>
			<td style="border-bottom: 1px solid black;width: 60%;padding-left: 20px"></td>
			<td style="border-right: 1px solid black;border-left: 1px solid black;border-bottom: 1px solid black;width: 10%;padding-left: 20px"></td>
		</tr>
		<tr>
		    <td style="border-left: 1px solid black;border-bottom: 1px solid black;width: 29%;padding-left: 5px"><b><u> B.RINCIAN</b></u></td>
			<td style="border-bottom: 1px solid black;width: 1%;padding-left: 20px">&nbsp;</td>
			<td style="border-bottom: 1px solid black;width: 60%;padding-left: 20px">&nbsp;</td>
			<td style="border-right: 1px solid black;border-left: 1px solid black;border-bottom: 1px solid black;width: 10%;padding-left: 20px"></td>
		</tr>
		<tr>
		    <td style="border-left: 1px solid black;border-bottom: 1px solid black;width: 29%;padding-left: 20px">PERHITUNGAN PESANGON</td>
			<td style="border-bottom: 1px solid black;width: 1%;padding-left: 20px">:</td>
			<td style="border-bottom: 1px solid black;width: 60%;padding-left: 80px">
				<table>
					<tr>
						<td style="width: 30px"><?php echo $data['0']['pasal'] ?></td>
						<td style="width: 30px">X</td>
						<td style="width: 30px"><?php echo $data['0']['pesangon'] ?></td>
						<td style="width: 30px">X</td>
						<td style="width: 30px">GP</td>
					</tr>
				</table>

			</td>
			<td style="border-right: 1px solid black;border-left: 1px solid black;border-bottom: 1px solid black;width: 10%;padding-left: 20px"></td>
		</tr>
		<tr>
		    <td style="border-left: 1px solid black;border-bottom: 1px solid black;width: 29%;padding-left: 20px">PENGHARGAAN MASA KERJA</td>
			<<td style="border-bottom: 1px solid black;width: 1%;padding-left: 20px">:</td>
			<td style="border-bottom: 1px solid black;width: 60%;padding-left: 80px">
				<table>
					<tr>
						<td style="width: 30px">&nbsp;</td>
						<td style="width: 30px">&nbsp;</td>
						<td style="width: 30px"><?php echo $data['0']['up'] ?></td>
						<td style="width: 30px">X</td>
						<td style="width: 30px">GP</td>
					</tr>
				</table>
			</td>
			<td style="border-right: 1px solid black;border-left: 1px solid black;border-bottom: 1px solid black;width: 10%;padding-left: 20px"></td>
		</tr>
		<tr>
		    <td style="border-left: 1px solid black;border-bottom: 1px solid black;width: 29%;padding-left: 20px">SISA CUTI (Hari)</td>
			<td style="border-bottom: 1px solid black;width: 1%;padding-left: 20px">:</td>
				<td style="border-bottom: 1px solid black;width: 60%;padding-left: 80px">
				<table>
					<tr>
						<td style="width: 30px">&nbsp;</td>
						<td style="width: 30px">&nbsp;</td>
						<td style="width: 30px"><?php echo $data['0']['cuti'] ?></td>
						<td style="width: 30px">X</td>
						<td style="width: 90px">(GP/30)</td>
					</tr>
				</table>
			</td>
			<td style="border-right: 1px solid black;border-left: 1px solid black;border-bottom: 1px solid black;width: 10%;padding-left: 20px"></td>
		</tr>
		<tr>
		    <td style="border-left: 1px solid black;border-bottom: 1px solid black;width: 29%;padding-left: 20px">UANG GANTI KERUGIAN</td>
			<td style="border-bottom: 1px solid black;width: 1%;padding-left: 20px">:</td>
			<td style="border-bottom: 1px solid black;width: 60%;padding-left: 80px"><?php echo $data['0']['gantirugi']?></td>
			<td style="border-right: 1px solid black;border-left: 1px solid black;border-bottom: 1px solid black;width: 10%;padding-left: 20px"></td>
		</tr>
		<tr>
		    <td style="border-left: 1px solid black;border-bottom: 1px solid black;width: 29%;padding-left: 20px">&nbsp;</td>
			<td style="border-bottom: 1px solid black;width: 1%;padding-left: 20px"></td>
			<td style="border-bottom: 1px solid black;width: 60%;padding-left: 20px"></td>
			<td style="border-right: 1px solid black;border-left: 1px solid black;border-bottom: 1px solid black;width: 10%;padding-left: 20px"></td>
		</tr>
		<tr>
		    <td style="border-left: 1px solid black;border-bottom: 1px solid black;width: 29%;padding-left: 20px">POTONGAN</td>
			<td style="border-bottom: 1px solid black;width: 1%;padding-left: 20px">&nbsp;</td>
			<td style="border-bottom: 1px solid black;width: 60%;padding-left: 20px">&nbsp;</td>
			<td style="border-right: 1px solid black;border-left: 1px solid black;border-bottom: 1px solid black;width: 10%;padding-left: 20px"></td>
		</tr>
		<tr>
		    <td style="border-left: 1px solid black;border-bottom: 1px solid black;width: 29%;padding-left: 20px">HUTANG KOPERASI</td>
			<td style="border-bottom: 1px solid black;width: 1%;padding-left: 20px">:</td>
			<td style="border-bottom: 1px solid black;width: 60%;padding-left: 20px">Rp <?php echo number_format($data['0']['hutang_koperasi'],0,',','.')?>,00</td>
			<td style="border-right: 1px solid black;border-left: 1px solid black;border-bottom: 1px solid black;width: 10%;padding-left: 20px"></td>
		</tr>
		<tr>
		    <td style="border-left: 1px solid black;border-bottom: 1px solid black;width: 29%;padding-left: 20px">HUTANG PERUSAHAAN</td>
			<td style="border-bottom: 1px solid black;width: 1%;padding-left: 20px">:</td>
			<td style="border-bottom: 1px solid black;width: 60%;padding-left: 20px">Rp <?php echo number_format($data['0']['hutang_perusahaan'],0,',','.')?>,00</td>
			<td style="border-right: 1px solid black;border-left: 1px solid black;border-bottom: 1px solid black;width: 10%;padding-left: 20px"></td>
		</tr>
		<tr>
		    <td style="border-left: 1px solid black;border-bottom: 1px solid black;width: 29%;padding-left: 20px">LAIN-LAIN</td>
			<td style="border-bottom: 1px solid black;width: 1%;padding-left: 20px">:</td>
			<td style="border-bottom: 1px solid black;width: 60%;padding-left: 20px">Rp <?php echo number_format($data['0']['lain_lain'],0,',','.')?>,00</td>
			<td style="border-right: 1px solid black;border-left: 1px solid black;border-bottom: 1px solid black;width: 10%;padding-left: 20px"></td>
		</tr>
		<tr>
		    <td style="border-left: 1px solid black;border-bottom: 1px solid black;width: 29%;padding-left: 20px">NO REKENING</td>
			<td style="border-bottom: 1px solid black;width: 1%;padding-left: 20px">:</td>
			<td style="border-bottom: 1px solid black;width: 60%;padding-left: 20px"><?php echo $data['0']
			[no_rek].'              '.$data['0']['bank'].'       an        '.$data['0']['nama_rek']?></td>
			<td style="border-right: 1px solid black;border-left: 1px solid black;border-bottom: 1px solid black;width: 10%;padding-left: 20px"></td>
		</tr>




	</table>
	<br>
	<p>Atas perhatian dan kerjasamanya kami ucapkan terimakasih.</p>

<table style="width: 100%; font-size: 17px;margin-top: 45px;text-align: center;">
		<tr>

			<td>Yogyakarta,
			<?php
				echo $tglCetak[2];
				$month=$tglCetak[1];
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
				echo $tglCetak[0];
			?></td>
			<td>Mengetahui</td>
		</tr>
		<tr>
			<td style="width: 60%">Hubungan Kerja</td>
			<td style="width: 60%">Departemen Personalia</td>
		</tr>

	</table>
	<table style="width: 100%;font-size: 17px;text-align: center; margin-top: 45px;">
		<tr>
		    <td style="width: 60%"><u><?php echo ucwords(strtolower($approver1['0']['nama'])) ?> </u></td>
			<td style="width: 60%"><u><?php echo ucwords(strtolower($approver2['0']['nama'])) ?></u></td>

		</tr>

		<tr>
		    <td><?php echo ucwords(strtolower($approver1['0']['jabatan'])) ?></td>
			<td><?php echo ucwords(strtolower($approver2['0']['jabatan'])) ?></td>

		</tr>
	</table>
</div>
</body>
</html>
