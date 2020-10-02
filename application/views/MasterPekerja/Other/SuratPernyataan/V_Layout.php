<div style="width: 100%;height: 90%; border: 2px solid black; padding-left: 5px; padding-right: 5px;">
	<table style="width: 100%">
		<tr>
			<td style="text-align: center;">
				<h2>Surat Pernyataan</h2>
			</td>
		</tr>
		<tr>
			<td style="padding-top: 20px;">
				Pada hari <?= $hari_pernyataan ?> tanggal <?= date('d-m-Y', strtotime($tgl_pernyataan)) ?> saya yang bertanda tangan dibawah ini :
			</td>
		</tr>
	</table>
	<table style="width: 100%" border="0">
		<tr>
			<td style="width: 53%; height: 30px;" valign="top">
				<ul>
					<li>Nama Lengkap</li>
				</ul>
			</td>
			<td style="width: 2%; text-align: center;" valign="top">:</td>
			<td style="width: 45%" valign="top">
				<?= trim($detail_hubker['nama']) ?>
			</td>
		</tr>
		<tr>
			<td style="width: 53%; height: 30px;" valign="top">
				<ul>
					<li>Nomor Identitas (KTP)</li>
				</ul>
			</td>
			<td style="width: 2%; text-align: center;" valign="top">:</td>
			<td style="width: 45%" valign="top">
				<?= $detail_hubker['nik'] ?>
			</td>
		</tr>
		<tr>
			<td style="width: 53%; height: 30px;" valign="top">
				<ul>
					<li>Nama Perusahaan/Wadah/Jasa Konstruksi</li>
				</ul>
			</td>
			<td style="width: 2%; text-align: center;" valign="top">:</td>
			<td style="width: 45%" valign="top">
				CV KARYA HIDUP SENTOSA
			</td>
		</tr>
		<tr>
			<td style="width: 53%; height: 30px;" valign="top">
				<ul>
					<li>Jabatan Dalam Perusahaan/Wadah/Jasa Konstruksi</li>
				</ul>
			</td>
			<td style="width: 2%; text-align: center;" valign="top">:</td>
			<td style="width: 45%" valign="top">
				<?= trim($detail_hubker['jabatan']) ?>
			</td>
		</tr>
		<tr>
			<td style="width: 53%; height: 30px;" valign="top">
				<ul>
					<li>Nomor Telepon yang dapat dihubungi sewaktu-waktu*</li>
				</ul>
			</td>
			<td style="width: 2%; text-align: center;" valign="top">:</td>
			<td style="width: 45%" valign="top">
				<?php foreach ($nohp as $key): ?>
					<p><?= $key ?></p>
				<?php endforeach ?>
			</td>
		</tr>
	</table>
	<table style="margin-top: 10px;">
		<tr>
			<td>Dengan ini menyatajan bahwa saya:</td>
		</tr>
		<tr>
			<td>1. Mewakili mewakili peserta BPJS Ketenagakerjaan, yaitu:</td>
		</tr>
	</table>
	<table border="0" style="width: 100%">
		<tr>
			<td style="width: 40%; padding-left: 15px; padding-bottom: 10px;" valign="top">
				<ul>
					<li>Nama Peserta</li>
				</ul>
			</td>
			<td style="width: 5%" valign="top">:</td>
			<td valign="top">
				<?= trim($detail_pekerja['nama']) ?>
			</td>
		</tr>
		<tr>
			<td style="width: 40%; padding-left: 15px; padding-bottom: 10px;" valign="top">
				<ul>
					<li>Nomor Identitas Kependudukan</li>
				</ul>
			</td>
			<td style="width: 5%" valign="top">:</td>
			<td valign="top">
				<?= $detail_pekerja['nik'] ?>
			</td>
		</tr>
		<tr>
			<td style="width: 40%; padding-left: 15px; padding-bottom: 10px;" valign="top">
				<ul>
					<li>Tanggal JKK</li>
				</ul>
			</td>
			<td style="width: 5%" valign="top">:</td>
			<td valign="top">
				<?php if (empty($tgl_jkk)): ?>
					...............................................
				<?php else: ?>
					<?= date('d-m-Y', strtotime($tgl_jkk)) ?>
				<?php endif ?>
			</td>
		</tr>
		<tr>
			<td style="width: 40%; padding-left: 15px; padding-bottom: 10px;" valign="top">
				<ul>
					<li>Nama RS/Klinik</li>
				</ul>
			</td>
			<td style="width: 5%" valign="top">:</td>
			<td valign="top">
				<?= $detail_klinik['nmppk'] ?>
			</td>
		</tr>
	</table>
	<table>
		<tr>
			<td style="width: 10px; padding-top: 10px;" valign="top">
				2.
			</td>
			<td valign="top" style="padding-top: 10px; text-align: justify;">
				Bersedia membantu pihak fasilitas kesehatan yang ditunjuk sebagai Trauma Center BPJS dalam penyedtaan dan pelengakapan dokumen yang dipertukan untuk pelaporan Jaminan Kecelakaan Kerja Tahap I.
			</td>
		</tr>
		<tr>
			<td style="width: 10px; padding-top: 10px;" valign="top">
				3.
			</td>
			<td valign="top" style="padding-top: 10px; text-align: justify;">
				Mengizinkan BPJS Ketenagakerjaan dan pihak fasilitas Kesehatan yang ditunjuk sebagai Trauma Center BPJS Ketenagakerjaan dalam mempergunakan data dan informasi terkait perawatan dan pengobatan.
			</td>
		</tr>
		<tr>
			<td style="width: 10px; padding-top: 10px;" valign="top">
				4.
			</td>
			<td valign="top" style="padding-top: 10px; text-align: justify;">
				Bersedia mengganti biaya perawatan dan pengobatan peserta, jika berdasarkan pemeriksaan dikemudian hari dinyatakan bahwa perawatan dan pengobatan peserta tidak dijamin dalam Program Jaminan Kecelakaan Kerja akibat keterangan kronologis dan data pendukung yang diberikan tidak benar 
			</td>
		</tr>
		<tr>
			<td colspan="2" style="text-align: justify; padding-top: 10px;">
				Demikian Surat Pemyataan ini saya perbuat dengan sebenamya tanpa ada unsur paksaan dari pihak manapun untuk dipergunakan sebagaimana mestinya. Apabila dikemudian hari ternyata melanggar atau pemyataan ini tidak benar maka saya siap menerima segala konsekuensinya sesuai dengan hukum yang bertaku. 
			</td>
		</tr>
	</table>
	<table style="margin-top: 10px; width: 100%" border="0">
		<tr>
			<td style="width: 50%"> </td>
			<td>
				<table>
				<tr>
					<td>Kota/Kab</td>
					<td>:</td>
					<td><?= $detail_hubker['lokasi_kerja'] ?></td>
				</tr>
				<tr>
					<td>Tanggal</td>
					<td>:</td>
					<td><?= date('d-m-Y', strtotime($tgl_cetak)) ?></td>
				</tr>
				<tr>
					<td colspan="3">
						<br><br><br><br><br><br>
					</td>
				</tr>
				<tr>
					<td colspan="3" style="font-size: 12px;">(tanda tangan dan/atau stempel perusahaan)</td>
				</tr>
				<tr>
					<td>Nama</td>
					<td>:</td>
					<td><?= trim($detail_hubker['nama']) ?></td>
				</tr>
				</table>
			</td>
		</tr>
	</table>
</div>
<table>
	<tr>
		<td style="font-weight: bold;">
			NB : *Wajib diisi
		</td>
	</tr>
	<tr>
		<td style="padding-left: 35px;font-weight: bold;">
			Diserahkan ke RSTC dilampiri fc Kartu dan KTP Peserta yang mengalami kecelakaan kerja Laporan Tahap I beserta kelengkapannya tetap dikirimkan ke BPJS Ketenagakerjaan dan Dinsosnakertrans
		</td>
	</tr>
</table>