<html><head></head>
<body>
<?php
		set_time_limit(0);
		ini_set("memory_limit", "2048M");

		foreach ($cekData as $cek) {
			$explode = explode('-', date('Y-m-d', strtotime($tgl_cetak)));
			$tgl_ik = explode('-', date('Y-m-d', strtotime($cek['tgl_mulaiik'])));
			$plusOJT = date('Y-m-d', strtotime('+'.$cek['lama_trainee'].' months', strtotime($cek['tgl_masuk'])));
			$OJT1 = date('Y-m-d', strtotime('-6 months', strtotime($plusOJT)));
			$actualOJT1 = date('Y-m-d', strtotime('-1 days', strtotime($OJT1)));
			$explodeOJT1 = explode('-', date('Y-m-d', strtotime($actualOJT1)));
			$actualOJT2 = date('Y-m-d', strtotime('-1 days', strtotime($plusOJT)));
			$explodeOJT2 = explode('-', date('Y-m-d', strtotime($actualOJT2)));
			$ttd =$explode[1];
			$month = $tgl_ik[1];
			$ojt1 = $explodeOJT1[1];
			$ojt2 = $explodeOJT2[1];

			if ($ttd == '01') {
				$month = " Januari ";
				$ttd   = " Januari ";
			}elseif ($ttd == '02') {
				$ttd   = " Februari ";
			}elseif ($ttd == '03') {
				$ttd   = " Maret ";
			}elseif ($ttd == '04') {
				$ttd   = " April ";
			}elseif ($ttd == '05') {
				$ttd   = " Mei ";
			}elseif ($ttd == '06') {
				$ttd   = " Juni ";
			}elseif ($ttd == '07') {
				$ttd   = " Juli ";
			}elseif ($ttd == '08') {
				$ttd   = " Agustus ";
			}elseif ($ttd == '09') {
				$ttd   = " September ";
			}elseif ($ttd == '10') {
				$ttd   = " Oktober ";
			}elseif ($ttd == '11') {
				$ttd   = " November ";
			}elseif ($ttd == '12') {
				$ttd   = " Desember ";
			};
			if ($ojt1 == '01') {
				$ojt1  = " Januari ";
			}elseif ($ojt1 == '02') {
				$ojt1  = " Februari ";
			}elseif ($ojt1 == '03') {
				$ojt1  = " Maret ";
			}elseif ($ojt1 == '04') {
				$ojt1  = " April ";
			}elseif ($ojt1 == '05') {
				$ojt1  = " Mei ";
			}elseif ($ojt1 == '06') {
				$ojt1  = " Juni ";
			}elseif ($ojt1 == '07') {
				$ojt1  = " Juli ";
			}elseif ($ojt1 == '08') {
				$ojt1  = " Agustus ";
			}elseif ($ojt1 == '09') {
				$ojt1  = " September ";
			}elseif ($ojt1 == '10') {
				$ojt1  = " Oktober ";
			}elseif ($ojt1 == '11') {
				$ojt1  = " November ";
			}elseif ($ojt1 == '12') {
				$ojt1  = " Desember ";
			};
			if ($ojt2 == '01') {
				$ojt2  = " Januari ";
			}elseif ($ojt2 == '02') {
				$ojt2  = " Februari ";
			}elseif ($ojt2 == '03') {
				$ojt2  = " Maret ";
			}elseif ($ojt2 == '04') {
				$ojt2  = " April ";
			}elseif ($ojt2 == '05') {
				$ojt2  = " Mei ";
			}elseif ($ojt2 == '06') {
				$ojt2  = " Juni ";
			}elseif ($ojt2 == '07') {
				$ojt2  = " Juli ";
			}elseif ($ojt2 == '08') {
				$ojt2  = " Agustus ";
			}elseif ($ojt2 == '09') {
				$ojt2  = " September ";
			}elseif ($ojt2 == '10') {
				$ojt2  = " Oktober ";
			}elseif ($ojt2 == '11') {
				$ojt2  = " November ";
			}elseif ($ojt2 == '12') {
				$ojt2  = " Desember ";
			};
			if ($month == '01') {
				$month = " Januari ";
			}elseif ($month == '02') {
				$month = " Februari ";
			}elseif ($month == '03') {
				$month = " Maret ";
			}elseif ($month == '04') {
				$month = " April ";
			}elseif ($month == '05') {
				$month = " Mei ";
			}elseif ($month == '06') {
				$month = " Juni ";
			}elseif ($month == '07') {
				$month = " Juli ";
			}elseif ($month == '08') {
				$month = " Agustus ";
			}elseif ($month == '09') {
				$month = " September ";
			}elseif ($month == '10') {
				$month = " Oktober ";
			}elseif ($month == '11') {
				$month = " November ";
			}elseif ($month == '12') {
				$month = " Desember ";
			};

		}

	?>
<div style="width: 100%;padding-right: 30px;">
    <table style="font-size: 13px">
        <tr>
            <td>No<td>:<td><?= $no_surat ?></td>
        </tr>
        <tr>
            <td>Hal<td>:<td>Penyerahan <?= $allinOne == '7' || $allinOne == '8' || $allinOne == '13' ? 'Siswa '.$jenis: $jenis?></td>
        </tr>
    </table>
	<br>
    <table style="font-size: 13px">
        <tr>
            <td>Kepada Yth. :</td>
        </tr>
        <tr>
            <td><?= $kepada ?></td>
        </tr>
        <tr>
            <td><u>di tempat</u></td>
        </tr>
    </table>
<!-- Custom Body Surat -->
	  <?php if ($allinOne == '1'){ ?>
		  <p style="font-size: 13px;">Dengan ini kami serahkan <?= count($cekData) ?> (<?=$terbilang?>) orang pekerja <?= $jenis ?> untuk ditempatkan di <b><?= $cekData[0]['seksi'] == '-'?'': 'SEKSI '.$cekData[0]['seksi'].',' ?> <?= $cekData[0]['unit'] == '-'?'':'UNIT '.$cekData[0]['unit'].',' ?> <?= $cekData[0]['dept'] == '-'?'':'DEPARTEMEN '.$cekData[0]['dept'] ?>.</b></p>
		  <p style="font-size: 13px;">Adapun nama pekerja <?= $jenis ?> adalah :</p>
		  <table style="font-size: 13px;  width: 100%; border-collapse: collapse;">
			  <tr>
				  <td colspan="3"><b>Kantor Asal : <?= $cekData[0]['kantor_asal'] ?><td colspan="6"><b>Lokasi Kerja : <?= $cekData[0]['lokasi_kerja'] ?></b></td>
			  </tr>
			  <thead>
				  <tr>
					  <th style="border: 1px solid;"><i>No</i></th>
					  <th style="border: 1px solid;"><i>Nama</i></th>
					  <th style="border: 1px solid;"><i>Temp.Lhr</i></th>
					  <th style="border: 1px solid;"><i>Tgl.Lhr</i></th>
					  <th style="border: 1px solid;"><i>Noind</i></th>
					  <th style="border: 1px solid;"><i>Lama Trainee</i></th>
					  <th style="border: 1px solid;"><i>Terhitung Tanggal</i></th>
				  </tr>
			  </thead>
			  <tbody>
				  <?php
				  $no = 1;
				  foreach ($cekData as $key) {
					  $lama_trainee = explode('-', date('Y-m-d', strtotime($cekData[0]['akhkontrak'])));
					  if ($lama_trainee[1] == '01') {
					  	$trainee = " Januari ";
					}elseif ($lama_trainee[1] == '02') {
						$trainee = " Februari ";
					}elseif ($lama_trainee[1] == '03') {
						$trainee = " Maret ";
					}elseif ($lama_trainee[1] == '04') {
						$trainee = " April ";
					}elseif ($lama_trainee[1] == '05') {
						$trainee = " Mei ";
					}elseif ($lama_trainee[1] == '06') {
						$trainee = " Juni ";
					}elseif ($lama_trainee[1] == '07') {
						$trainee = " Juli ";
					}elseif ($lama_trainee[1] == '08') {
						$trainee = " Agustus ";
					}elseif ($lama_trainee[1] == '09') {
						$trainee = " September ";
					}elseif ($lama_trainee[1] == '10') {
						$trainee = " Oktober ";
					}elseif ($lama_trainee[1] == '11') {
						$trainee = " November ";
					}elseif ($lama_trainee[1] == '12') {
						$trainee = " Desember ";
					}
					  ?>
					  <tr>
						  <td style="border: 1px solid;"><?= $no++; ?></td>
						  <td style="border: 1px solid;"><?= $key['nama'] ?></td>
						  <td style="border: 1px solid;"><?= $key['templahir'] ?></td>
						  <td style="border: 1px solid;"><?= date('d/m/Y', strtotime($key['tgllahir'])) ?></td>
						  <td style="border: 1px solid;"><?= $key['noind'] ?></td>
						  <td style="border: 1px solid;"><?= $key['lama_trainee'].' bulan' ?></td>
						  <td style="border: 1px solid;"><?= date('d/m/Y', strtotime($key['tgl_masuk'])).' - '.date('d/m/Y', strtotime($key['akhkontrak'])) ?></td>
					  </tr>
				  <?php } ?>
			  </tbody>
		  </table>
		  <ul>
		  	<li style="font-size: 13px;">Evaluasi trainee berakhir pada tanggal <?= $lama_trainee[2].$trainee.$lama_trainee[0]?></li>
		  </ul>
		  <p style="font-size: 13px;">Kami menantikan hasil evaluasi trainee yang bersangkutan.</p>
		  <p style="font-size: 13px;">Mohon seksi dapat menginformasikan pola shift pekerja yang bersangkutan kepada sie hubungan kerja periode bulan berjalan maksimal 1 hari setelah pekerja masuk seksi.</p>
	  <?php }else if($allinOne == '2' || $allinOne == '4' || $allinOne == '5' || $allinOne == '15') { ?>
		  <!-- Kode induk D, H, T -->
		  <p style="font-size: 13px;">Dengan ini kami serahkan <?= count($cekData) ?> (<?=$terbilang?>) orang pekerja <?= $jenis ?> untuk ditempatkan di <b><?= $cekData[0]['seksi'] == '-'?'': 'SEKSI '.$cekData[0]['seksi'].',' ?> <?= $cekData[0]['unit'] == '-'?'':'UNIT '.$cekData[0]['unit'].',' ?> <?= $cekData[0]['dept'] == '-'?'':'DEPARTEMEN '.$cekData[0]['dept'] ?>.</b></p>
		  <p style="font-size: 13px;">Adapun nama pekerja <?= $jenis ?> adalah :</p>

		  <table style="font-size: 13px;  width: 100%; border-collapse: collapse;">
			  <tr>
				  <td colspan="3"><b>Kantor Asal : <?= $cekData[0]['kantor_asal'] ?><td colspan="6"><b>Lokasi Kerja : <?= $cekData[0]['lokasi_kerja'] ?></b></td>
			  </tr>
				<thead>
					<tr>
						<th style="border: 1px solid;"><i>No</i></th>
						<th style="border: 1px solid;"><i>Nama</i></th>
						<th style="border: 1px solid;"><i>Temp.Lhr</i></th>
						<th style="border: 1px solid;"><i>Tgl.Lhr</i></th>
						<th style="border: 1px solid;"><i>Noind</i></th>
						<th style="border: 1px solid;"><i>Gol</i></th>
						<th style="border: 1px solid;"><i>Orientasi Kerja</i></th>
						<th style="border: 1px solid;"><i>Kontrak Kerja</i></th>
					</tr>
				</thead>
				<tbody>
					<?php
					$no = 1;
					foreach ($cekData as $key) {
						?>
						<tr>
							<td style="border: 1px solid;"><?= $no++; ?></td>
							<td style="border: 1px solid;"><?= $key['nama'] ?></td>
							<td style="border: 1px solid;"><?= $key['templahir'] ?></td>
							<td style="border: 1px solid;"><?= date('d/m/Y', strtotime($key['tgllahir'])) ?></td>
							<td style="border: 1px solid;"><?= $key['noind'] ?></td>
							<td style="border: 1px solid;"><?= $key['gol']? $key['gol']:'-' ?></td>
							<td style="border: 1px solid;"><?= date('d/m/Y', strtotime($key['tgl_masuk'])).' - '.date('d/m/Y', strtotime($key['diangkat'].'-1 day')) ?></td>
							<td style="border: 1px solid;"><?= date('d/m/Y', strtotime($key['diangkat'])).' - '.date('d/m/Y', strtotime($key['akhkontrak'])) ?></td>
						</tr>
					<?php } ?>
				</tbody>
		  </table>
		  <p style="font-size: 13px;">Dan untuk kemudian apabila berdasarkan hasil evaluasi selama menjalani orientasi pekerja tersebut dapat menunjukkan unjuk kerja yang diharapkan,
			  maka pekerja <?= $jenis ?> akan bekerja di CV. Karya Hidup Sentosa dengan masa kontrak kerja sebagaimana tersebut di atas.</p>
		  <p style="font-size: 13px;">Pekerja tersebut akan mendapatkan <u>Insentif Kerajinan</u> mulai tanggal <u><?= $tgl_ik[2].$month.$tgl_ik[0];?></u>.</p>
		  <p style="font-size: 13px;">Mohon seksi dapat menginformasikan pola shift pekerja yang bersangkutan kepada sie hubungan kerja periode bulan berjalan maksimal 1 hari setelah pekerja masuk seksi.</p>

	  <?php }elseif ($allinOne == '3') { ?>
		  <!-- Kode induk E -->
		  <p style="font-size: 13px;">Dengan ini kami serahkan <?= count($cekData) ?> (<?=$terbilang?>) orang <?= $jenis ?> untuk ditempatkan di <b><?= $cekData[0]['seksi'] == '-'?'': 'SEKSI '.$cekData[0]['seksi'].',' ?> <?= $cekData[0]['unit'] == '-'?'':'UNIT '.$cekData[0]['unit'].',' ?> <?= $cekData[0]['dept'] == '-'?'':'DEPARTEMEN '.$cekData[0]['dept'] ?>.</b></p>
		  <p style="font-size: 13px;">Adapun nama trainee tersebut adalah :</p>

		  <table style="font-size: 13px;  width: 100%; border-collapse: collapse;">
			  <tr>
				  <td colspan="3"><b>Kantor Asal : <?= $cekData[0]['kantor_asal'] ?><td colspan="6"><b>Lokasi Kerja : <?= $cekData[0]['lokasi_kerja'] ?></b></td>
			  </tr>
  			<thead>
  				<tr>
  					<th style="border: 1px solid;"><i>No</i></th>
  					<th style="border: 1px solid;"><i>Nama</i></th>
  					<th style="border: 1px solid;"><i>Temp.Lhr</i></th>
  					<th style="border: 1px solid;"><i>Tgl.Lhr</i></th>
  					<th style="border: 1px solid;"><i>Noind</i></th>
  					<th style="border: 1px solid;"><i>Gol</i></th>
  					<th style="border: 1px solid;"><i>Trainee</i></th>
  					<th style="border: 1px solid;"><i>Terhitung Tanggal</i></th>
  				</tr>
  			</thead>
  			<tbody>
  				<?php
  				$no = 1;
  				foreach ($cekData as $key) {
  					?>
  					<tr>
  						<td style="border: 1px solid;"><?= $no++; ?></td>
  						<td style="border: 1px solid;"><?= $key['nama'] ?></td>
  						<td style="border: 1px solid;"><?= $key['templahir'] ?></td>
  						<td style="border: 1px solid;"><?= date('d/m/Y', strtotime($key['tgllahir'])) ?></td>
  						<td style="border: 1px solid;"><?= $key['noind'] ?></td>
  						<td style="border: 1px solid;"><?= $key['gol']? $key['gol']:'-' ?></td>
  						<td style="border: 1px solid;"><?= $key['lama_trainee'].' bulan' ?></td>
  						<td style="border: 1px solid;"><?= date('d/m/Y', strtotime($key['tgl_masuk'])).' - '.date('d/m/Y', strtotime($key['akhkontrak'])) ?></td>
  					</tr>
  				<?php } ?>
  			</tbody>
  		</table>
		<ul>
			<li>Evaluasi OJT-1 berakhir pada tanggal <?= $explodeOJT1[2].$ojt1.$explodeOJT1[0] ?></li>
			<li>Evaluasi OJT-2 berakhir pada tanggal <?= $explodeOJT2[2].$ojt2.$explodeOJT2[0] ?></li>
		</ul>
  		<p style="font-size: 13px;">Kami menantikan hasil evaluasi kerja trainee yang bersangkutan.</p>
		<p style="font-size: 13px;">Mohon seksi dapat menginformasikan pola shift pekerja yang bersangkutan kepada sie hubungan kerja periode bulan berjalan maksimal 1 hari setelah pekerja masuk seksi.</p>

	<?php }elseif ($allinOne == '6'|| $allinOne == '16') {  ?>
		<p style="font-size: 13px;">Dengan ini kami serahkan <?= count($cekData) ?> (<?=$terbilang?>) orang <?= $allinOne == '6'? $jenis : 'Tenaga Kerja '.$jenis ?> untuk ditempatkan di <b><?= $cekData[0]['seksi'] == '-'?'': 'SEKSI '.$cekData[0]['seksi'].',' ?> <?= $cekData[0]['unit'] == '-'?'':'UNIT '.$cekData[0]['unit'].',' ?> <?= $cekData[0]['dept'] == '-'?'':'DEPARTEMEN '.$cekData[0]['dept'] ?>.</b></p>
		<p style="font-size: 13px;">Adapun nama <?= $allinOne == '6'? $jenis : 'Tenaga Kerja '.$jenis ?> tersebut adalah :</p>

		<table style="font-size: 13px;  width: 100%; border-collapse: collapse;">
			<tr>
				<td colspan="3"><b>Kantor Asal : <?= $cekData[0]['kantor_asal'] ?><td colspan="6"><b>Lokasi Kerja : <?= $cekData[0]['lokasi_kerja'] ?></b></td>
			</tr>
		  <thead>
			  <tr>
				  <th style="border: 1px solid;"><i>No</i></th>
				  <th style="border: 1px solid;"><i>Nama</i></th>
				  <th style="border: 1px solid;"><i>Temp.Lhr</i></th>
				  <th style="border: 1px solid;"><i>Tgl.Lhr</i></th>
				  <th style="border: 1px solid;"><i>Noind</i></th>
				  <th style="border: 1px solid;"><i>Masa Kerja</i></th>
			  </tr>
		  </thead>
		  <tbody>
			  <?php
			  $no = 1;
			  foreach ($cekData as $key) {
				  ?>
				  <tr>
					  <td style="border: 1px solid;"><?= $no++; ?></td>
					  <td style="border: 1px solid;"><?= $key['nama'] ?></td>
					  <td style="border: 1px solid;"><?= $key['templahir'] ?></td>
					  <td style="border: 1px solid;"><?= date('d/m/Y', strtotime($key['tgllahir'])) ?></td>
					  <td style="border: 1px solid;"><?= $key['noind'] ?></td>
					  <td style="border: 1px solid;"><?= date('d/m/Y', strtotime($key['tgl_masuk'])).' - '.date('d/m/Y', strtotime($key['akhkontrak'])) ?></td>
				  </tr>
			  <?php } ?>
		  </tbody>
	  </table>
  <?php }elseif ($allinOne == '7'||$allinOne =='8'||$allinOne =='13') {  ?>
	  <!-- Kode Induk F, L, Q -->
  	<p style="font-size: 13px;">Dengan ini kami serahkan <?= count($cekData) ?> (<?=$terbilang?>) orang siswa <?= $jenis ?> untuk ditempatkan di <b><?= $cekData[0]['seksi'] == '-'?'': 'SEKSI '.$cekData[0]['seksi'].',' ?> <?= $cekData[0]['unit'] == '-'?'':'UNIT '.$cekData[0]['unit'].',' ?> <?= $cekData[0]['dept'] == '-'?'':'DEPARTEMEN '.$cekData[0]['dept'] ?>.</b></p>
  	<p style="font-size: 13px;">Adapun nama siswa <?= $jenis ?> tersebut adalah :</p>

  	<table style="font-size: 13px;  width: 100%; border-collapse: collapse;">
  		<tr>
  			<td colspan="3"><b>Kantor Asal : <?= $cekData[0]['kantor_asal'] ?><td colspan="6"><b>Lokasi Kerja : <?= $cekData[0]['lokasi_kerja'] ?></b></td>
  		</tr>
  		<thead>
  			<tr>
  				<th style="border: 1px solid;"><i>No</i></th>
  				<th style="border: 1px solid;"><i>Nama</i></th>
  				<th style="border: 1px solid;"><i>Temp.Lhr</i></th>
  				<th style="border: 1px solid;"><i>Tgl.Lhr</i></th>
  				<th style="border: 1px solid;"><i>Asal Sekolah</i></th>
				<th style="border: 1px solid;"><i>Noind</i></th>
  				<th style="border: 1px solid;"><i><?= $allinOne == '8'? 'Masa Magang': 'Masa PKL' ?></i></th>
  			</tr>
  		</thead>
  		<tbody>
  			<?php
  			$no = 1;
  			foreach ($cekData as $key) { ?>
  				<tr>
  					<td style="border: 1px solid;"><?= $no++; ?></td>
  					<td style="border: 1px solid;"><?= $key['nama'] ?></td>
  					<td style="border: 1px solid;"><?= $key['templahir'] ?></td>
  					<td style="border: 1px solid;"><?= date('d/m/Y', strtotime($key['tgllahir'])) ?></td>
  					<td style="border: 1px solid;"><?= $key['sekolah'] ?></td>
					<td style="border: 1px solid;"><?= $key['noind'] ?></td>
  					<td style="border: 1px solid;"><?= date('d/m/Y', strtotime($key['tgl_masuk'])).' - '.date('d/m/Y', strtotime($key['akhkontrak'])) ?></td>
  				</tr>
  			<?php } ?>
  		</tbody>
  	</table>
	<p style="font-size: 13px;">Mohon seksi dapat menginformasikan pola shift pekerja yang bersangkutan kepada sie hubungan kerja periode bulan berjalan maksimal 1 hari setelah pekerja masuk seksi.</p>

<?php } elseif ($allinOne == '9' ||$allinOne == '12'|| $allinOne =='14') { ?>
	  <!-- Kode Induk K -->
	  <p style="font-size: 13px;">Dengan ini kami serahkan <?= count($cekData) ?> (<?=$terbilang?>) orang pekerja <?= $jenis ?> untuk ditempatkan di <b><?= $cekData[0]['seksi'] == '-'?'': 'SEKSI '.$cekData[0]['seksi'].',' ?> <?= $cekData[0]['unit'] == '-'?'':'UNIT '.$cekData[0]['unit'].',' ?> <?= $cekData[0]['dept'] == '-'?'':'DEPARTEMEN '.$cekData[0]['dept'] ?>.</b></p>
    	<p style="font-size: 13px;">Adapun nama pekerja <?= $jenis ?> tersebut adalah :</p>

    	<table style="font-size: 13px;  width: 100%; border-collapse: collapse;">
    		<tr>
    			<td colspan="3"><b>Kantor Asal : <?= $cekData[0]['kantor_asal'] ?><td colspan="6"><b>Lokasi Kerja : <?= $cekData[0]['lokasi_kerja'] ?></b></td>
    		</tr>
    		<thead>
    			<tr>
    				<th style="border: 1px solid;"><i>No</i></th>
    				<th style="border: 1px solid;"><i>Nama</i></th>
    				<th style="border: 1px solid;"><i>Temp.Lhr</i></th>
    				<th style="border: 1px solid;"><i>Tgl.Lhr</i></th>
    				<th style="border: 1px solid;"><i>Noind</i></th>
	  				<th style="border: 1px solid;"><i>Asal Outsourcing</i></th>
    				<th style="border: 1px solid;"><i>Mulai Kerja</i></th>
    			</tr>
    		</thead>
    		<tbody>
    			<?php
    			$no = 1;
    			foreach ($cekData as $key) {
    				?>
    				<tr>
    					<td style="border: 1px solid;"><?= $no++; ?></td>
    					<td style="border: 1px solid;"><?= $key['nama'] ?></td>
    					<td style="border: 1px solid;"><?= $key['templahir'] ?></td>
    					<td style="border: 1px solid;"><?= date('d/m/Y', strtotime($key['tgllahir'])) ?></td>
						<td style="border: 1px solid;"><?= $key['noind'] ?></td>
    					<td style="border: 1px solid;"><?= $key['asal_outsourcing'] ?></td>
    					<td style="border: 1px solid;"><?= date('d/m/Y', strtotime($key['tgl_masuk'])) ?></td>
    				</tr>
    			<?php } ?>
    		</tbody>
    	</table>
		<p style="font-size: 13px;">Pekerja tersebut akan mendapatkan <u>Insentif Kerajinan</u> mulai tanggal <u><?= $tgl_ik[2].$month.$tgl_ik[0];?></u>.</p>
		<p style="font-size: 13px;">Mohon seksi dapat menginformasikan pola shift pekerja yang bersangkutan kepada sie hubungan kerja periode bulan berjalan maksimal 1 hari setelah pekerja masuk seksi.</p>
  <?php }elseif ($allinOne == '10' || $allinOne =='11') { ?>
	  <!-- Kode Induk K -->
	  <p style="font-size: 13px;">Dengan ini kami serahkan <?= count($cekData) ?> (<?=$terbilang?>) orang Tenaga kerja <?= $jenis ?> untuk ditempatkan di <b><?= $cekData[0]['seksi'] == '-'?'': 'SEKSI '.$cekData[0]['seksi'].',' ?> <?= $cekData[0]['unit'] == '-'?'':'UNIT '.$cekData[0]['unit'].',' ?> <?= $cekData[0]['dept'] == '-'?'':'DEPARTEMEN '.$cekData[0]['dept'] ?>.</b></p>
    	<p style="font-size: 13px;">Adapun nama tenaga kerja <?= $jenis ?> tersebut adalah :</p>

    	<table style="font-size: 13px;  width: 100%; border-collapse: collapse;">
    		<tr>
    			<td colspan="3"><b>Kantor Asal : <?= $cekData[0]['kantor_asal'] ?><td colspan="6"><b>Lokasi Kerja : <?= $cekData[0]['lokasi_kerja'] ?></b></td>
    		</tr>
    		<thead>
    			<tr>
    				<th style="border: 1px solid;"><i>No</i></th>
    				<th style="border: 1px solid;"><i>Nama</i></th>
    				<th style="border: 1px solid;"><i>Temp.Lhr</i></th>
    				<th style="border: 1px solid;"><i>Tgl.Lhr</i></th>
    				<th style="border: 1px solid;"><i>Noind</i></th>
    				<th style="border: 1px solid;"><i>Gol</i></th>
	  				<th style="border: 1px solid;"><i>Orientasi Kerja</i></th>
    				<th style="border: 1px solid;"><i>Kontrak Kerja</i></th>
    			</tr>
    		</thead>
    		<tbody>
    			<?php
    			$no = 1;
    			foreach ($cekData as $key) {
    				?>
    				<tr>
    					<td style="border: 1px solid;"><?= $no++; ?></td>
    					<td style="border: 1px solid;"><?= $key['nama'] ?></td>
    					<td style="border: 1px solid;"><?= $key['templahir'] ?></td>
    					<td style="border: 1px solid;"><?= date('d/m/Y', strtotime($key['tgllahir'])) ?></td>
						<td style="border: 1px solid;"><?= $key['noind'] ?></td>
						<td style="border: 1px solid;"><?= $key['gol']? $key['gol']:'-' ?></td>
    					<td style="border: 1px solid;"><?= $key['asal_outsourcing'] ?></td>
						<td style="border: 1px solid;"><?= date('d/m/Y', strtotime($key['tgl_masuk'])).' - '.date('d/m/Y', strtotime($key['diangkat'].'-1 day')) ?></td>
						<td style="border: 1px solid;"><?= date('d/m/Y', strtotime($key['diangkat'])).' - '.date('d/m/Y', strtotime($key['akhkontrak'])) ?></td>
    				</tr>
    			<?php } ?>
    		</tbody>
    	</table>
		<p style="font-size: 13px;">Dan untuk kemudian apabila berdasarkan hasil evaluasi selama menjalani orientasi pekerja tersebut dapat menunjukkan unjuk kerja yang diharapkan,
			maka pekerja <?= $jenis ?> akan bekerja di CV. Karya Hidup Sentosa dengan masa kontrak kerja sebagaimana tersebut di atas.</p>
		<p style="font-size: 13px;">Mohon seksi dapat menginformasikan pola shift pekerja yang bersangkutan kepada sie hubungan kerja periode bulan berjalan maksimal 1 hari setelah pekerja masuk seksi.</p>
  <?php }

	if ($allinOne == '3'||$allinOne == '13') {
		echo "<p style='font-size: 13px;'>Demikian untuk menjadikan periksa, dan kami menantikan hasil evaluasi kerja siswa PKL bersangkutan.<br><br>Atas bantuan dan kerjasamanya kami ucapkan terimakasih.</p>";
	}else {
		echo "<p style='font-size: 13px;'>Demikian surat penyerahan ini, atas bantuan dan kerjasamanya kami ucapkan terimakasih.</p>";
	}
  ?>
    <table style="width: 100%; font-size: 13px; margin-top: 10px;">
		<tr>
			<td>Yogyakarta,
			<?= $explode[2].$ttd.$explode[0];
			?></td>
		</tr>
		<tr>
			<td style="width: 60%">Departemen Personalia</td>
        </tr>
        <tr>
            <td style="width: 60%">ub. Kepala,</td>
		</tr>
	</table>
	<table style="font-size: 13px;margin-top: 45px;margin-bottom: 20px;">
		<tr>
		    <td style="width: 60%"><u><?php echo ucwords(strtolower($approval[0]['nama'])) ?> </u></td>

		</tr>
		<tr>
		    <td><?php echo ucwords(strtolower($approval[0]['jabatan'])) ?></td>

		</tr>
	</table>
    Tembusan :<br>
		<?php $no = 1;
		if ($tembusan) {
			foreach ($tembusan as $value) {
				echo $no++.'. '.$value.'<br>';
			}
			echo $no++.'. ADMINISTRATOR PENGGAJIAN <br>';
			echo $no++.'. ARSIP';
		}?>
    <p style="font-size: 13px;"><?= $petugas.'/'.$petugas2 ?></p>
</div>
</body>
</html>
