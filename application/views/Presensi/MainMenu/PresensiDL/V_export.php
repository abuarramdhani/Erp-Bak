<?php
$atasan1="...";
if(!empty($atasan)){ foreach($atasan as $ats){
		if($ats['level'] == 1){
			$atasan_nama=$ats['nama'];
			$atasan_jbt=$ats['jabatan'];
		}
}	}
if(!empty($rec)){	foreach($rec as $rr){
	$pekerja_nama=$rr->nama;
	$pekerja_noind=$rr->noind;
	$pekerja_jbt=$rr->jabatan;
}	}
if(!empty($data_spdl_detail)){	foreach($data_spdl_detail as $dsd){
	$lokasi=$lokasi.$dsd['provinsi'].' - '.$dsd['namakota'].', ';
	if ($tujuan!=$dsd['tujuan'])
	{	
	$tujuan=$tujuan.$dsd['tujuan'].', ';
	}
	
	if($dsd['dari']<$berangkat || empty($berangkat)){
		$berangkat=$dsd['dari'];
		$berangkat_ex=explode(' ',$berangkat);
		$b_hr=nama_hari($berangkat_ex[0]);
		$b_tgl=$berangkat_ex[0];

		$b_tgl=str_replace('-', '/',$b_tgl);
		$b_tgl=strtotime($b_tgl);
		$b_tgl=date('d-M-Y',$b_tgl);

		$b_wkt=$berangkat_ex[1];
	}
	
	if($dsd['sampai']>$kembali || empty($kembali)){
		$kembali=$dsd['sampai'];
		$kembali_ex=explode(' ',$kembali);
		$k_hr=nama_hari($kembali_ex[0]);
		$k_tgl=$kembali_ex[0];
		$k_wkt=$kembali_ex[1];
	}
	
}	}
?>
<div style="width: 100%; height: 50%;">
<div style="width: 48%; float: left;">
	<div style="border: 2px solid #000; border-bottom: 2px solid #000; height: 10%">	<!-- header -->
		<table>
			<tr>
				<td height="100px" width="100px">
					<img src="<?php echo base_url('assets/AdminLTE-2.3.11/dist/img/quick-traktor-logo.jpg') ?>" style="width:100;height:100px;"/>
				</td>
				<td style="padding-left:25px; font-weight:bold;">
					<h3>CV. KARYA HIDUP SENTOSA</h3>
					<h4>Jl. Magelang No. 144 <br>Yogyakarta</h4>
				</td>
			</tr>
		</table>
	</div>
	<div style="border: 2px solid #000; border-bottom: 0px solid #000; height: 58%">	<!-- body -->
		<br><p style="text-align: center; font-size:18px; font-weight:bold" ><u>SURAT TUGAS PERJALANAN DINAS LUAR KOTA</u><br>(RUTIN/TIDAK RUTIN)</p>
		
		<table style="width: 100%; margin: 10px" border="0">
			<tr>
				<td style="width:22%">&nbsp;</td><td style="width:3%"></td><td style="width:25%"></td><td style="width:25%"></td><td style="width:25%"></td>
			</tr>
			<tr>
				<td>1.Nama</td><td>:</td><td colspan="3"> <?php echo $atasan_nama; ?></td>
			</tr>
			<tr>
				<td>2.Jabatan</td><td>:</td><td colspan="3"> <?php echo $atasan_jbt; ?></td>
			</tr>
			<tr><td colspan="5">&nbsp;</td></tr>
			
			<tr>
				<td colspan="5">Memberikan tugas untuk melakukan perjalanan dinas luar kota kepada :</td>
			</tr>
			<tr><td colspan="5">&nbsp;</td></tr>
			
			<tr>
				<td>1.Nama</td><td>:</td><td colspan="2"> <?php echo $pekerja_nama ?></td><td>No.Induk: <?php echo $pekerja_noind; ?></td>
			</tr>
			<tr>
				<td>2.Jabatan</td><td>:</td><td colspan="3"> <?php echo $pekerja_jbt; ?></td>
			</tr>
			<tr>
				<td>3.Kota Tujuan</td><td>:</td><td colspan="3"> <?php echo $lokasi; ?></td>
			</tr>
			<tr>
				<td>4.Keperluan</td><td>:</td><td colspan="3"> <?php echo $tujuan; ?></td>
			</tr>
			<tr><td colspan="5">&nbsp;</td></tr>
			
			<tr>
				<td>5.Berangkat</td><td>:</td><td> Hari <?php echo $b_hr; ?></td><td>Tgl. <?php echo tgl_indo($b_tgl); ?></td><td>Jam <?php echo $b_wkt; ?> WIB</td>
			</tr>
			<tr>
				<td>6.Kembali</td><td>:</td><td> Hari </td><td>Tgl. </td><td>Jam </td>
			</tr>
			<tr><td colspan="5">&nbsp;</td></tr>
			
			<tr>
				<td>7.Transportasi</td><td>:</td><td colspan="3"> ........................... km</td>
			</tr>
			<tr>
				<td>8.Km.Berangkat</td><td>:</td><td colspan="3"> ........................... km</td>
			</tr>
		</table>
	</div>
	<div style="border: 2px solid #000; border-top: 0px solid #000; height: 25%">	<!-- footer -->
		<table style="width: 100%; margin: 10px" border="0">
			<tr>
				<td colspan="2"></td><td>Yogyakarta, <?php echo tgl_indo(date("d F Y")); ?></td>
			</tr>
			<tr>
				<td style="width:40%; text-align:center">Pekerja yang bertugas,</td><td style="width:20%"></td><td style="width:40%; text-align:center">Atasan yang memberi tugas,</td>
			</tr>
			<tr>
				<td colspan="3" style="height:50px"></td>
			</td>
			<tr>
				<td style="width:40%; text-align:center">( <?php echo $pekerja_nama; ?> )</td><td style="width:20%"></td><td style="width:40%; text-align:center">( <?php echo $atasan_nama; ?> )</td>
			</tr>
			
			<tr>
				<td colspan="3">
				<small>Catatan:<br>&nbsp;&nbsp;&nbsp;Setelah dinas luar kota, harap saudara masuk bekerja kembali pada :<br>
				&nbsp;&nbsp;&nbsp;Hari : ......... Tgl. ......... Jam ......... WIB.</small><br>
				<small>Halaman ini di cetak melalui Sistem Dinas Luar Online v.1.0.16 : <?php echo date('d-M-Y H:i:s'); ?>.<br> Kode SPDL : <?php echo $spdl_id['id']; ?><br>
				FRM-HRM-00-03 . Rev. 02 26/06/2015</small>
				</td>
			</tr>
		</table>
	</div>
</div>

<div style="width: 48%; float: right;">
	<div style="border: 2px solid #000; border-bottom: 2px solid #000; height: 10%">	<!-- header -->
		<table>
			<tr>
				<td height="100px" width="100px">
					<img src="<?php echo base_url('assets/AdminLTE-2.3.11/dist/img/quick-traktor-logo.jpg') ?>" style="width:100;height:100px;"/>
				</td>
				<td style="padding-left:25px; font-weight:bold;">
					<h3>CV. KARYA HIDUP SENTOSA</h3>
					<h4>Jl. Magelang No. 144 <br>Yogyakarta</h4>
				</td>
			</tr>
		</table>
	</div>
	<div style="border: 2px solid #000; border-bottom: 0px solid #000; height: 58%">	<!-- body -->
		<br><p style="text-align: center; font-size:18px; font-weight:bold" ><u>SURAT TUGAS PERJALANAN DINAS LUAR KOTA</u><br>(RUTIN/TIDAK RUTIN)</p>
		
		<table style="width: 100%; margin: 10px" border="0">
			<tr>
				<td style="width:22%">&nbsp;</td><td style="width:3%"></td><td style="width:25%"></td><td style="width:25%"></td><td style="width:25%"></td>
			</tr>
			<tr>
				<td>1.Nama</td><td>:</td><td colspan="3"> <?php echo $atasan_nama; ?></td>
			</tr>
			<tr>
				<td>2.Jabatan</td><td>:</td><td colspan="3"> <?php echo $atasan_jbt; ?></td>
			</tr>
			<tr><td colspan="5">&nbsp;</td></tr>
			
			<tr>
				<td colspan="5">Memberikan tugas untuk melakukan perjalanan dinas luar kota kepada :</td>
			</tr>
			<tr><td colspan="5">&nbsp;</td></tr>
			
			<tr>
				<td>1.Nama</td><td>:</td><td colspan="2"> <?php echo $pekerja_nama; ?></td><td>No.Induk: <?php echo $pekerja_noind; ?></td>
			</tr>
			<tr>
				<td>2.Jabatan</td><td>:</td><td colspan="3"> <?php echo $pekerja_jbt; ?></td>
			</tr>
			<tr>
				<td>3.Kota Tujuan</td><td>:</td><td colspan="3"> <?php echo $lokasi; ?></td>
			</tr>
			<tr>
				<td>4.Keperluan</td><td>:</td><td colspan="3"> <?php echo $tujuan; ?></td>
			</tr>
			<tr><td colspan="5">&nbsp;</td></tr>
			
			<tr>
				<td>5.Berangkat</td><td>:</td><td> Hari <?php echo $b_hr; ?></td><td>Tgl. <?php echo tgl_indo($b_tgl); ?></td><td>Jam <?php echo $b_wkt; ?> WIB</td>
			</tr>
			<tr>
				<td>6.Kembali</td><td>:</td><td> Hari </td><td>Tgl. </td><td>Jam </td>
			</tr>
			<tr><td colspan="5">&nbsp;</td></tr>
			
			<tr>
				<td>7.Transportasi</td><td>:</td><td colspan="3"> ........................... km</td>
			</tr>
			<tr>
				<td>8.Km.Berangkat</td><td>:</td><td colspan="3"> ........................... km</td>
			</tr>
		</table>
	</div>
	<div style="border: 2px solid #000; border-top: 0px solid #000; height: 25%">	<!-- footer -->
		<table style="width: 100%; margin: 10px" border="0">
			<tr>
				<td colspan="2"></td><td>Yogyakarta, <?php echo tgl_indo(date("d F Y")); ?></td>
			</tr>
			<tr>
				<td style="width:40%; text-align:center">Pekerja yang bertugas,</td><td style="width:20%"></td><td style="width:40%; text-align:center">Atasan yang memberi tugas,</td>
			</tr>
			<tr>
				<td colspan="3" style="height:50px"></td>
			</td>
			<tr>
				<td style="width:40%; text-align:center">( <?php echo $pekerja_nama; ?> )</td><td style="width:20%"></td><td style="width:40%; text-align:center">( <?php echo $atasan_nama; ?> )</td>
			</tr>
			
			<tr>
				<td colspan="3">
				<small>Catatan:<br>&nbsp;&nbsp;&nbsp;Setelah dinas luar kota, harap saudara masuk bekerja kembali pada :<br>
				&nbsp;&nbsp;&nbsp;Hari : ......... Tgl. ......... Jam ......... WIB.</small><br>
				<small>Halaman ini di cetak melalui Sistem Dinas Luar Online v.1.0.16 : <?php echo date('d-M-Y H:i:s'); ?>.<br> Kode SPDL : <?php echo $spdl_id['id']; ?><br>
				FRM-HRM-00-03 . Rev. 02 26/06/2015</small>
				</td>
			</tr>
		</table>
	</div>
</div>
</div>





