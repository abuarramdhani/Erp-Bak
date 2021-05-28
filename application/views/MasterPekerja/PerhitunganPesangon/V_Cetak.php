<html>
<head>
</head>
<body>
<?php
		set_time_limit(0);
		ini_set("memory_limit", "2048M");
		$bulan_singkat = array(
			'Jan',
			'Feb',
			'Mar',
			'Apr',
			'May',
			'Jun',
			'Jul',
			'Aug',
			'Sep',
			'Oct',
			'Nov',
			'Dec'
		);

		$bulan_panjang = array(
			'Januari',
			'Februari',
			'Maret',
			'April',
			'Mei',
			'Juni',
			'Juli',
			'Agustus',
			'September',
			'Oktober',
			'November',
			'Desember'
		);
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
			<td style="border-bottom: 1px solid black;width: 60%;padding-left: 20px"><?php echo $data->nama?></td>
			<td style="border-right: 1px solid black;border-left: 1px solid black;border-bottom: 1px solid black;width: 10%;padding-left: 20px"></td>
		</tr>
		<tr>
		    <td style="border-left: 1px solid black;border-bottom: 1px solid black;width: 29%;padding-left: 20px">NO.IND</td>
			<td style="border-bottom: 1px solid black;width: 1%;padding-left: 20px">:</td>
			<td style="border-bottom: 1px solid black;width: 60%;padding-left: 20px"><?php echo $data->noind?></td>
			<td style="border-right: 1px solid black;border-left: 1px solid black;border-bottom: 1px solid black;width: 10%;padding-left: 20px"></td>
		</tr>
		<tr>
		    <td style="border-left: 1px solid black;border-bottom: 1px solid black;width: 29%;padding-left: 20px">SEKSI</td>
			<td style="border-bottom: 1px solid black;width: 1%;padding-left: 20px">:</td>
			<td style="border-bottom: 1px solid black;width: 60%;padding-left: 20px"><?php echo $data->seksi?></td>
			<td style="border-right: 1px solid black;border-left: 1px solid black;border-bottom: 1px solid black;width: 10%;padding-left: 20px"></td>
		</tr>
		<tr>
		    <td style="border-left: 1px solid black;border-bottom: 1px solid black;width: 29%;padding-left: 20px">UNIT</td>
			<td style="border-bottom: 1px solid black;width: 1%;padding-left: 20px">:</td>
			<td style="border-bottom: 1px solid black;width: 60%;padding-left: 20px"><?php echo $data->unit?></td>
			<td style="border-right: 1px solid black;border-left: 1px solid black;border-bottom: 1px solid black;width: 10%;padding-left: 20px"></td>
		</tr>
		<tr>
		    <td style="border-left: 1px solid black;border-bottom: 1px solid black;width: 29%;padding-left: 20px">LOKASI</td>
			<td style="border-bottom: 1px solid black;width: 1%;padding-left: 20px">:</td>
			<td style="border-bottom: 1px solid black;width: 60%;padding-left: 20px"><?php echo $data->lokasi_kerja?></td>
			<td style="border-right: 1px solid black;border-left: 1px solid black;border-bottom: 1px solid black;width: 10%;padding-left: 20px"></td>
		</tr>
		<tr>
		    <td style="border-left: 1px solid black;border-bottom: 1px solid black;width: 29%;padding-left: 20px">JABATAN TERAKHIR
		    </td>
			<td style="border-bottom: 1px solid black;width: 1%;padding-left: 20px">:</td>
			<td style="border-bottom: 1px solid black;width: 60%;padding-left: 20px"><?php echo $data->jabatan_terakhir?></td>
			<td style="border-right: 1px solid black;border-left: 1px solid black;border-bottom: 1px solid black;width: 10%;padding-left: 20px"></td>
		</tr>
		<tr>
		    <td style="border-left: 1px solid black;border-bottom: 1px solid black;width: 29%;padding-left: 20px">TANGGAL DIANGKAT
		    </td>
			<td style="border-bottom: 1px solid black;width: 1%;padding-left: 20px">:</td>
			<td style="border-bottom: 1px solid black;width: 60%;padding-left: 20px">
				<?php echo str_replace($bulan_singkat,$bulan_panjang,date('d M Y',strtotime($data->diangkat)))?>
			</td>
			<td style="border-right: 1px solid black;border-left: 1px solid black;border-bottom: 1px solid black;width: 10%;padding-left: 20px"></td>
		</tr>
		<tr>
		    <td style="border-left: 1px solid black;border-bottom: 1px solid black;width: 29%;padding-left: 20px">MASA KERJA</td>
			<td style="border-bottom: 1px solid black;width: 1%;padding-left: 20px">:</td>
			<td style="border-bottom: 1px solid black;width: 60%;padding-left: 20px">
				<?php echo $data->masa_kerja_tahun." Tahun ".$data->masa_kerja_bulan." Bulan ".$data->masa_kerja_hari." Hari" ?>
			</td>
			<td style="border-right: 1px solid black;border-left: 1px solid black;border-bottom: 1px solid black;width: 10%;padding-left: 20px"></td>
		</tr>
		<tr>
		    <td style="border-left: 1px solid black;border-bottom: 1px solid black;width: 29%;padding-left: 20px">SISA CUTI</td>
			<td style="border-bottom: 1px solid black;width: 1%;padding-left: 20px">:</td>
			<td style="border-bottom: 1px solid black;width: 60%;padding-left: 20px"><?php echo $data->jml_cuti?></td>
			<td style="border-right: 1px solid black;border-left: 1px solid black;border-bottom: 1px solid black;width: 10%;padding-left: 20px"></td>
		</tr>
		<tr>
		    <td style="border-left: 1px solid black;border-bottom: 1px solid black;width: 29%;padding-left: 20px">TEMPAT/TGL LAHIR</td>
			<td style="border-bottom: 1px solid black;width: 1%;padding-left: 20px">:</td>
			<td style="border-bottom: 1px solid black;width: 60%;padding-left: 20px">
				<?php echo $data->tempat_lahir.", ".str_replace($bulan_singkat,$bulan_panjang,date('d M Y',strtotime($data->tanggal_lahir))) ?>
			</td>
			<td style="border-right: 1px solid black;border-left: 1px solid black;border-bottom: 1px solid black;width: 10%;padding-left: 20px"></td>
		</tr>
		<tr>
		    <td style="border-left: 1px solid black;border-bottom: 1px solid black;width: 29%;padding-left: 20px">ALAMAT</td>
			<td style="border-bottom: 1px solid black;width: 1%;padding-left: 20px">:</td>
			<td style="border-bottom: 1px solid black;width: 60%;padding-left: 20px"><?php echo $data->alamat?></td>
			<td style="border-right: 1px solid black;border-left: 1px solid black;border-bottom: 1px solid black;width: 10%;padding-left: 20px"></td>
		</tr>
		<tr>
		    <td style="border-left: 1px solid black;border-bottom: 1px solid black;width: 29%;padding-left: 20px">STATUS</td>
			<td style="border-bottom: 1px solid black;width: 1%;padding-left: 20px">:</td>
			<td style="border-bottom: 1px solid black;width: 60%;padding-left: 20px"><?php echo $data->sebab_keluar?></td>
			<td style="border-right: 1px solid black;border-left: 1px solid black;border-bottom: 1px solid black;width: 10%;padding-left: 20px"></td>
		</tr>
		<tr>
		    <td style="border-left: 1px solid black;border-bottom: 1px solid black;width: 29%;padding-left: 20px">TANGGAL KELUAR</td>
			<td style="border-bottom: 1px solid black;width: 1%;padding-left: 20px">:</td>
			<td style="border-bottom: 1px solid black;width: 60%;padding-left: 20px">
				<?php echo str_replace($bulan_singkat,$bulan_panjang,date('d M Y',strtotime($data->tglkeluar))) ?>
			</td>
			<td style="border-right: 1px solid black;border-left: 1px solid black;border-bottom: 1px solid black;width: 10%;padding-left: 20px"></td>
		</tr>
		<tr>
		    <td style="border-left: 1px solid black;border-bottom: 1px solid black;width: 29%;padding-left: 20px">PROSES PHK</td>
			<td style="border-bottom: 1px solid black;width: 1%;padding-left: 20px">:</td>
			<td style="border-bottom: 1px solid black;width: 60%;padding-left: 20px">
				<?php echo (!empty($data->tgl_proses_phk))? str_replace($bulan_singkat,$bulan_panjang,date('d M Y',strtotime($data->tgl_proses_phk))) :'' ?>
			</td>
			<td style="border-right: 1px solid black;border-left: 1px solid black;border-bottom: 1px solid black;width: 10%;padding-left: 20px"></td>
		</tr>
		<tr>
		    <td style="border-left: 1px solid black;border-bottom: 1px solid black;width: 29%;padding-left: 20px">NPWP</td>
			<td style="border-bottom: 1px solid black;width: 1%;padding-left: 20px">:</td>
			<td style="border-bottom: 1px solid black;width: 60%;padding-left: 20px"><?php echo $data->npwp?></td>
			<td style="border-right: 1px solid black;border-left: 1px solid black;border-bottom: 1px solid black;width: 10%;padding-left: 20px"></td>
		</tr>
		<tr>
		    <td style="border-left: 1px solid black;border-bottom: 1px solid black;width: 29%;padding-left: 20px">NIK</td>
			<td style="border-bottom: 1px solid black;width: 1%;padding-left: 20px">:</td>
			<td style="border-bottom: 1px solid black;width: 60%;padding-left: 20px"><?php echo $data->nik?></td>
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
						<td style="width: 30px"><?php echo $data->pengali_u_pesangon ?></td>
						<td style="width: 30px">X</td>
						<td style="width: 30px"><?php echo $data->jml_pesangon ?></td>
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
						<td style="width: 30px"><?php echo $data->pengali_upmk ?></td>
						<td style="width: 30px">X</td>
						<td style="width: 30px"><?php echo $data->jml_upmk ?></td>
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
						<td style="width: 30px"><?php echo $data->jml_cuti ?></td>
						<td style="width: 30px">X</td>
						<td style="width: 90px">(GP/30)</td>
					</tr>
				</table>
			</td>
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
			<td style="border-bottom: 1px solid black;width: 60%;padding-left: 20px">Rp. <?php echo number_format($data->hutang_koperasi,0,',','.')?>,00</td>
			<td style="border-right: 1px solid black;border-left: 1px solid black;border-bottom: 1px solid black;width: 10%;padding-left: 20px"></td>
		</tr>
		<tr>
		    <td style="border-left: 1px solid black;border-bottom: 1px solid black;width: 29%;padding-left: 20px">HUTANG PERUSAHAAN</td>
			<td style="border-bottom: 1px solid black;width: 1%;padding-left: 20px">:</td>
			<td style="border-bottom: 1px solid black;width: 60%;padding-left: 20px">Rp. <?php echo number_format($data->hutang_perusahaan,0,',','.')?>,00</td>
			<td style="border-right: 1px solid black;border-left: 1px solid black;border-bottom: 1px solid black;width: 10%;padding-left: 20px"></td>
		</tr>
		<tr>
		    <td style="border-left: 1px solid black;border-bottom: 1px solid black;width: 29%;padding-left: 20px">LAIN-LAIN</td>
			<td style="border-bottom: 1px solid black;width: 1%;padding-left: 20px">:</td>
			<td style="border-bottom: 1px solid black;width: 60%;padding-left: 20px">Rp. <?php echo number_format($data->lain_lain,0,',','.')?>,00</td>
			<td style="border-right: 1px solid black;border-left: 1px solid black;border-bottom: 1px solid black;width: 10%;padding-left: 20px"></td>
		</tr>
		<tr>
		    <td style="border-left: 1px solid black;border-bottom: 1px solid black;width: 29%;padding-left: 20px">NO REKENING</td>
			<td style="border-bottom: 1px solid black;width: 1%;padding-left: 20px">:</td>
			<td style="border-bottom: 1px solid black;width: 60%;padding-left: 20px"><?php echo $data->no_rekening.'              '.$data->bank.'       an        '.$data->nama_rekening?></td>
			<td style="border-right: 1px solid black;border-left: 1px solid black;border-bottom: 1px solid black;width: 10%;padding-left: 20px"></td>
		</tr>




	</table>
	<br>
	<p>Atas perhatian dan kerjasamanya kami ucapkan terimakasih.</p>

<table style="width: 100%; font-size: 17px;margin-top: 45px;text-align: center;">
		<tr>

			<td>Yogyakarta,
			<?php
				echo str_replace($bulan_singkat,$bulan_panjang,date('d M Y',strtotime($tglCetak)))
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
