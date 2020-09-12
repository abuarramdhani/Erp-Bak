<style>
	.form-control {
		padding: 0 1em;
		height: 2em !important;
	}

	.bordered {
		border: 1px solid #a6a6a6;
	}

	.float-right {
		float: right;
	}

	.mr-\.5em {
		margin-right: .5em;
	}

	.ml-\.5em {
		margin-left: .5em;
	}

	.bl-none {
		border-left: none;
	}

	.br-none {
		border-right: none;
	}

	.mt-10 {
		margin-top: 5px;
	}

	.mt-20 {
		margin-top: 20px;
	}

	.mb-1 {
		margin-bottom: .25em;
	}

	.mb-2 {
		margin-bottom: .5em;
	}

	.p-0 {
		padding: 0;
	}

	.px-1 {
		padding-left: .25em;
		padding-right: .25em;
	}

	.pl-4 {
		padding-left: 1em !important;
	}

	.p-2 {
		padding: .5em;
	}

	.p-4 {
		padding: 1em !important;
	}

	.inner-box {
		padding: 5px 15px;
		margin-bottom: 0.5em;
		width: 100%;
	}

	.inner-box.min {
		min-height: 270px;
	}

	.flex {
		display: flex;
	}

	select.form-control {
		padding: 0 .5em;
	}

	input::-webkit-inner-spin-button {
		-webkit-appearance: none;
		margin: 0;
	}

	.radio-inline {
		padding-left: 0;
	}

	legend {
		width: auto !important;
		margin-bottom: 0.25em;
	}

	button[disabled] {
		opacity: 0.8;
	}

	.uppercase {
		text-transform: uppercase;
	}

	/* not work */
	.hover-pointer:hover {
		cursor: pointer;
	}

	.hover-pointer>*:hover {
		cursor: pointer;
	}

	/* Firefox */
	input[type=number] {
		-moz-appearance: textfield;
	}

	/* component styling */
	#table-jabatan>tbody>tr.activex,
	#table-jabatan>tbody>tr.activex:active,
	#table-jabatan>tbody>tr.activex:focus {
		background-color: #3c8dbc !important;
		color: white;
	}

	.bigdrop {
		width: 200px !important;
	}

	.select2 {
		width: 100% !important;
	}

	#table-anggota-keluarga tbody tr:hover,
	#table-jabatan tbody tr:hover {
		background-color: #7fa9ce;
		cursor: pointer;
		color: white;
	}
</style>

<body class="hold-transition login-page">
	<section class="content">
		<div class="panel-group">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h3>Edit Data Pekerja</h3>
				</div>
				<div class="panel-body">
					<div class="row" id="search-container">
						<form method="GET" action="<?= base_url('MasterPekerja/DataPekerjaKeluar/viewEdit'); ?>">
							<div class="col-lg-4">
								<div class="form-group">
									<label>Cari Pekerja</label>
									<label class="radio-inline pl-4">
										<input type="radio" name="keluar" value="f" <?= $param['keluar'] == 'f' ? 'checked' : '' ?>>
										<span>Aktif</span>
									</label>
									<label class="radio-inline">
										<input type="radio" name="keluar" value="t" <?= $param['keluar'] == 't' ? 'checked' : '' ?>>
										<span>Keluar</span>
									</label>
								</div>
							</div>
							<div class="col-lg-4">
								<div class="form-group">
									<select name="noind" id="select-pekerja" data-placeholder="Ketik nama atau nomor induk" class="form-control" required>
										<option value="<?= $param['noind'] ?>"><?= $param['text'] ?></option>
									</select>
								</div>
							</div>
							<div class="col-lg-2">
								<button type="submit" class="btn btn-primary" id="btn_cari">Tampil</button>
							</div>
						</form>
					</div>
					<div class="row">
						<hr>
					</div>
					<div id="app" class="row">
						<div class="col-md-12">
							<!-- NAV -->
							<div class="nav-tabs-custom" style="position: relative;">
								<button class="btn btn-fullscreen hidden" style="position: absolute; top: 0; right: 1em;">
									<ion-icon name="expand-outline"></ion-icon>
									<i class="ion-android-contract"></i>
								</button>
								<ul class="nav nav-tabs">
									<li class="active">
										<a href="#tab_1" data-toggle="tab">Data Pribadi</a>
									</li>
									<li class="">
										<a href="#tab_2" data-toggle="tab">Hubungan Kerja</a>
									</li>
									<li class="">
										<a href="#tab_3" data-toggle="tab">Jamsostek</a>
									</li>
								</ul>
								<div class="tab-content">
									<div class="tab-pane active" id="tab_1">
										<div class="row">
											<div class="col-md-12">
												<div class="col-md-4 mb-2 p-0 px-1 br-none">
													<div class="inner-box bordered">
														<div class="form-group">
															<h3>Data Pribadi</h3>
															<div class="mt-20">
																<div style="width: 3cm; height: 4cm; background-color: #e8e8e8; margin: 0 auto; position: relative;">
																	<img style="width: 100%; height: 100%;" src="<?= $data['photo'] ?>">
																</div>
															</div>
															<div class="row mt-20">
																<div class="col-lg-4">
																	<label for="PK_txt_noinduk">No Induk </label>
																</div>
																<div class="col-lg-4">
																	<input type="text" name="noind" id="" class="form-control" value="<?= $data['noind'] ?>" readonly>
																</div>
															</div>
															<div class="row mt-10">
																<div class="col-lg-4">
																	<label for="PK_txt_namaPekerja">Nama </label>
																</div>
																<div class="col-lg-8">
																	<input type="text" name="nama" id="" class="form-control uppercase" value="<?= $data['nama'] ?>">
																</div>
															</div>
															<div class="row mt-10">
																<div class="col-lg-4">
																	<label for="PK_txt_namaPekerja">Jns. Kelamin</label>
																</div>
																<div class="col-lg-4">
																	<?php
																	$arrJenkel = ['L', 'P', '-'];
																	?>
																	<select name="jenkel" id="" class="form-control">
																		<?php foreach ($arrJenkel as $item) : ?>
																			<option value="<?= $item ?>" <?= $item === $data['jenkel'] ? 'selected' : '' ?>><?= $item ?></option>
																		<?php endforeach ?>
																	</select>
																</div>
															</div>
															<div class="row mt-10">
																<div class="col-lg-4">
																	<label for="PK_txt_namaPekerja">Agama</label>
																</div>
																<div class="col-lg-5">
																	<?php
																	$arrAgama = array('ISLAM', 'KATHOLIK', 'KRISTEN', 'BUDDHA', 'KONGHUCU', 'LAIN');
																	$agama = $data['agama'];
																	// mencegah data yang tidak beraturan tidak terpilih
																	if (!in_array($agama, $arrAgama)) {
																		array_push($arrAgama, $agama);
																	}
																	?>
																	<select name="agama" id="" class="form-control">
																		<?php foreach ($arrAgama as $item) : ?>
																			<option value="<?= $item ?>" <?= ($item === $agama) ? 'selected' : '' ?>><?= $item ?></option>
																		<?php endforeach ?>
																	</select>
																</div>
															</div>
															<div class="row mt-10">
																<div class="col-lg-4">
																	<label for="PK_txt_kotaLahir">Tempat Lahir </label>
																</div>
																<div class="col-lg-8">
																	<input type="text" name="templahir" id="" class="form-control uppercase" value="<?= $data['templahir'] ?>">
																</div>
															</div>
															<div class="row mt-10">
																<div class="col-lg-4">
																	<label for="PK_txt_tanggalLahir">Tanggal Lahir </label>
																</div>
																<div class="col-lg-8">
																	<input type="text" name="tgllahir" id="" class="form-control date" value="<?= $data['tgllahir'] ?>">
																</div>
															</div>
															<div class="row mt-10">
																<div class="col-lg-4">
																	<label for="">Gol. Darah</label>
																</div>
																<div class="col-lg-4">
																	<?php
																	$arrGoldarah = array('A', 'B', 'AB', 'O');
																	$goldar = $data['goldarah'];
																	if (!in_array($goldar, $arrGoldarah)) {
																		array_push($arrGoldarah, $goldar);
																	}
																	?>
																	<select name="goldarah" id="" class="form-control">
																		<?php foreach ($arrGoldarah as $item) : ?>
																			<option value="<?= $item ?>" <?= ($item === $goldar) ? 'selected' : '' ?>><?= $item ?></option>
																		<?php endforeach ?>
																	</select>
																</div>
															</div>
															<div class="row mt-10">
																<div class="col-lg-4">
																	<label for="PK_txt_nikPekerja">NIK </label>
																</div>
																<div class="col-lg-8">
																	<input type="text" name="nik" id="" class="form-control numberOnly" value="<?= $data['nik'] ?>">
																</div>
															</div>
															<div class="row mt-10">
																<div class="col-lg-4">
																	<label for="PK_txt_nikPekerja">No. KK </label>
																</div>
																<div class="col-lg-8">
																	<input type="text" name="no_kk" id="" class="form-control numberOnly" value="<?= $data['no_kk'] ?>">
																</div>
															</div>
														</div>
													</div>
												</div>
												<div class="col-md-4 mb-2 p-0 px-1 br-none">
													<div class="inner-box bordered">
														<div class="form-group">
															<h3>Alamat Pekerja</h3>
															<div class="row mt-20">
																<div class="col-lg-4">
																	<label for="PK_txt_alamatPekerja">Alamat </label>
																</div>
																<div class="col-lg-8">
																	<textarea class="form-control uppercase" style="resize: vertical !important; max-height: 250px; min-height: 90px;" name="alamat" id=""><?= $data['alamat'] ?></textarea>
																</div>
															</div>
															<div class="row mt-10">
																<div class="col-lg-4">
																	<label for="select-desa">Desa </label>
																</div>
																<div class="col-lg-8">
																	<!-- <input type="text" name="desa" id="" class="form-control uppercase" value="<?= $data['desa'] ?>"> -->
																	<select name="desa" id="select-desa" class="form-control">
																		<option value="<?= $data['desa_id'] ?>" selected><?= $data['desa'] ?></option>
																	</select>
																</div>
															</div>
															<div class="row mt-10">
																<div class="col-lg-4">
																	<label for="PK_txt_kecamatanPekerja">Kecamatan </label>
																</div>
																<div class="col-lg-8">
																	<!-- <input type="text" name="kec" id="" class="form-control" value="<?= $data['kec'] ?>"> -->
																	<select name="kec" id="select-kecamatan" class="form-control">
																		<option value="<?= $data['kec_id'] ?>" selected><?= $data['kec'] ?></option>
																	</select>
																</div>
															</div>
															<div class="row mt-10">
																<div class="col-lg-4">
																	<label for="PK_txt_kabupatenPekerja">Kabupaten </label>
																</div>
																<div class="col-lg-8">
																	<!-- <input type="text" name="kab" id="" class="form-control" value="<?= $data['kab'] ?>"> -->
																	<select name="kab" id="select-kabupaten" class="form-control">
																		<option value="<?= $data['kab_id'] ?>" selected><?= $data['kab'] ?></option>
																	</select>
																</div>
															</div>
															<div class="row mt-10">
																<div class="col-lg-4">
																	<label for="PK_txt_provinsiPekerja">Provinsi </label>
																</div>
																<div class="col-lg-8">
																	<select name="prop" id="select-provinsi" class="form-control">
																		<option value="<?= $data['prop_id'] ?>" selected><?= $data['prop'] ?></option>
																	</select>
																</div>
															</div>
															<div class="row mt-10">
																<div class="col-lg-4">
																	<label for="PK_txt_kodePosPekerja">Kode Pos </label>
																</div>
																<div class="col-lg-4">
																	<input type="number" name="kodepos" id="" pattern="\d*" maxlength="5" class="form-control numberOnly" value="<?= $data['kodepos'] ?>">
																</div>
															</div>
															<div class="row mt-10">
																<div class="col-lg-4">
																	<label for="PK_txt_kodePosPekerja">Stat Rumah </label>
																</div>
																<div class="col-lg-4">
																	<?php
																	$arrStatRumah = array('RK', 'RO', 'RS', '-');
																	$statrumah = $data['statrumah'];
																	if (!in_array($statrumah, $arrStatRumah)) {
																		array_push($arrStatRumah, $statrumah);
																	}
																	?>
																	<select class="form-control" name="statrumah" id="">
																		<?php foreach ($arrStatRumah as $item) : ?>
																			<option value="<?= $item ?>" <?= ($item === $statrumah) ? 'selected' : '' ?>><?= $item ?></option>
																		<?php endforeach ?>
																	</select>
																</div>
															</div>
															<div class="row mt-10">
																<div class="col-lg-4">
																	<label for="PK_txt_teleponPekerja">Telepon </label>
																</div>
																<div class="col-lg-8">
																	<input type="number" name="telepon" id="" class="form-control numberOnly" value="<?= $data['telepon'] ?>">
																</div>
															</div>
															<div class="row mt-10">
																<div class="col-lg-4">
																	<label for="PK_txt_nohpPekerja">No Hp </label>
																</div>
																<div class="col-lg-8">
																	<input type="tel" name="nohp" id="" class="form-control numberOnly" value="<?= $data['nohp'] ?>">
																</div>
															</div>
															<div class="row mt-10">
																<div class="col-lg-4">
																	<label for="PK_txt_nohpPekerja">Email </label>
																</div>
																<div class="col-lg-8">
																	<input type="email" name="email" id="" class="form-control email" value="<?= $data['email'] ?>">
																</div>
															</div>
															<div class="row mt-10">
																<div class="col-lg-4">
																	<label for="PK_txt_alamatPekerja">Alamat Kos </label>
																</div>
																<div class="col-lg-8">
																	<textarea class="form-control uppercase" style="resize: vertical !important; max-height: 250px; min-height: 90px;" name="almt_kost" id=""><?= $data['almt_kost'] ?></textarea>
																</div>
															</div>
														</div>
													</div>
												</div>
												<div class="col-md-4 mb-2 p-0 px-1 ">
													<div class="inner-box bordered">
														<div class="form-group">
															<h3>Pendidikan</h3>
															<div class="row mt-20">
																<div class="col-lg-5">
																	<label for="PK_txt_alamatPekerja">Gelar Depan </label>
																</div>
																<div class="col-lg-7">
																	<input type="text" name="gelard" id="" class="form-control" value="<?= $data['gelard'] ?>">
																</div>
															</div>
															<div class=" row mt-10">
																<div class="col-lg-5">
																	<label for="PK_txt_alamatPekerja">Gelar Belakang </label>
																</div>
																<div class="col-lg-7">
																	<input type="text" name="gelarb" id="" class="form-control" value="<?= $data['gelarb'] ?>">
																</div>
															</div>
															<div class=" row mt-10">
																<div class="col-lg-5">
																	<label for="PK_txt_alamatPekerja">Pendidikan </label>
																</div>
																<div class="col-lg-7">
																	<?php
																	$pendidikan = ['SD', 'SLTP', 'SLTA', 'SMK', 'STM', 'D1', 'D2', 'D3', 'S1', 'S2', 'S3', '-'];
																	if (!in_array($data['pendidikan'], $pendidikan)) {
																		array_push($pendidikan, $data['pendidikan']);
																	}
																	?>
																	<select name="pendidikan" class="form-control select2" data-allow-clear="false" id="">
																		<?php foreach ($pendidikan as $item) : ?>
																			<option value="<?= $item ?>" <?= ($item === $data['pendidikan']) ? 'selected' : '' ?>><?= $item ?></option>
																		<?php endforeach ?>
																	</select>
																</div>
															</div>
															<div class=" row mt-10">
																<div class="col-lg-5">
																	<label for="PK_txt_alamatPekerja">Jurusan </label>
																</div>
																<div class="col-lg-7">
																	<input type="text" name="jurusan" id="" class="form-control uppercase" value="<?= $data['jurusan'] ?>">
																</div>
															</div>
															<div class=" row mt-10">
																<div class="col-lg-5">
																	<label for="PK_txt_alamatPekerja">Asal Sekolah </label>
																</div>
																<div class="col-lg-7">
																	<input type="text" name="sekolah" id="" class="form-control uppercase" value="<?= $data['sekolah'] ?>">
																</div>
															</div>
														</div>
													</div>
													<div class=" inner-box bordered">
														<div class="form-group">
															<h3>Anak dan Keluarga</h3>
															<div class="row mt-20">
																<div class="col-md-12 text-center">
																	<button class="btn btn-primary" data-toggle="modal" id="toggle-modal-keluarga" data-target="#modal-keluarga">
																		<i class="fa fa-child"></i>
																		<span> Keluarga ... </span>
																	</button>
																</div>
															</div>
															<div class="row mt-20">
																<div class="col-lg-5">
																	<label for="PK_txt_alamatPekerja">Jumlah Anak </label>
																</div>
																<div class="col-lg-4">
																	<input type="number" name="jumanak" id="" class="form-control numberOnly" value="<?= $data['jumanak'] ?>">
																</div>
															</div>
															<div class="row mt-10">
																<div class="col-lg-5">
																	<label for="PK_txt_alamatPekerja">Jumlah Saudara </label>
																</div>
																<div class="col-lg-4">
																	<input type="number" name="jumsdr" id="" class="form-control numberOnly" value="<?= $data['jumsdr'] ?>">
																</div>
															</div>
														</div>
													</div>
													<div class=" inner-box bordered">
														<div class="form-group">
															<h3>Ambil Data</h3>
															<div class="flex" style="justify-content: center;">
																<button class="btn" id="ambil-data" data-toggle="modal" data-target="#modal-ambil-data" style="font-size: 15px;">Ambil Data Dari <br> Noind Lama</button>
															</div>
														</div>
													</div>
												</div>
											</div>
											<div class="col-md-12">
												<div class="col-md-6">
													<div class="form-group">
														<h3>Lain-lain</h3>
														<div class="row" style="margin-top: 10px;">
															<div class="col-lg-4">
																<label for="PK_txt_internalmail">Internal Mail</label>
															</div>
															<div class="col-lg-8">
																<input type="email" name="email_internal" id="" class="form-control" value="<?= $data['email_internal'] ?>">
															</div>
														</div>
														<div class="row" style="margin-top: 10px;">
															<div class="col-lg-4">
																<label for="PK_txt_externalmail">External Mail </label>
															</div>
															<div class="col-lg-8">
																<input type="email" name="external_mail" id="" class="form-control" value="<?= $data['external_mail'] ?>">
															</div>
														</div>
														<div class="row" style="margin-top: 10px;">
															<div class="col-lg-4">
																<label for="PK_txt_telkomselmygroup">Telkomsel Mygroup </label>
															</div>
															<div class="col-lg-8">
																<input type="text" name="telkomsel_mygroup" id="" class="form-control" value="<?= $data['telkomsel_mygroup'] ?>">
															</div>
														</div>
														<div class="row" style="margin-top: 10px;">
															<div class="col-lg-4">
																<label for="PK_txt_pidginaccount">Pidgin Account </label>
															</div>
															<div class="col-lg-8">
																<input type="text" name="pidgin_account" id="" class="form-control" value="<?= $data['pidgin_account'] ?>">
															</div>
														</div>
														<div class="row" style="margin-top: 10px;">
															<div class="col-lg-4">
																<label for="PK_txt_ukuranbaju">Ukuran Baju </label>
															</div>
															<div class="col-lg-8">
																<input type="text" name="uk_baju" id="" class="form-control" value="<?= $data['uk_baju'] ?>">
															</div>
														</div>
														<div class="row" style="margin-top: 10px;">
															<div class="col-lg-4">
																<label for="PK_txt_ukurancelana">Ukuran Celana </label>
															</div>
															<div class="col-lg-8">
																<input type="text" name="uk_celana" id="" class="form-control" value="<?= $data['uk_celana'] ?>">
															</div>
														</div>
														<div class="row" style="margin-top: 10px;">
															<div class="col-lg-4">
																<label for="PK_txt_ukuransepatu">Ukuran Sepatu </label>
															</div>
															<div class="col-lg-8">
																<input type="text" name="uk_sepatu" id="" class="form-control numberOnly" value="<?= $data['uk_sepatu'] ?>">
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="tab-pane" id="tab_2">
										<div class="row">
											<div class="col-md-12">
												<div class="col-md-8 mb-2 p-0 px-1 br-none">
													<div class="inner-box min bordered">
														<h3>Dari Seksi Hubungan Kerja</h3>
														<div class="form-group">
															<div class="row mt-10">
																<div class="col-md-6">
																	<div class="col-md-6">
																		<label for="" class="label-control">No. Keb</label>
																	</div>
																	<div class="col-md-6">
																		<input type="number" name="nokeb" class="form-control" value="<?= $data['nokeb'] ?>">
																	</div>
																</div>
																<div class="col-md-6">
																	<div class="col-md-5">
																		<label for="" class="label-control">Tgl. Diangkat</label>
																	</div>
																	<div class="col-md-5">
																		<input type="text" name="diangkat" class="form-control date" value="<?= $data['diangkat'] ?>">
																	</div>
																	<div class="col-md-2">
																		<button id="toggle-perpanjangan-orientasi" data-toggle="modal" data-target="#modal-perpanjangan-orientasi" class="btn-primary">
																			<i class="fa fa-toggle-right"></i>
																		</button>
																	</div>
																</div>
															</div>
															<div class="row mt-10">
																<div class="col-md-6">
																	<div class="col-md-6">
																		<label for="" class="label-control">Tgl Masuk Kerja</label>
																	</div>
																	<div class="col-md-6">
																		<input type="text" name="masukkerja" class="form-control date" value="<?= $data['masukkerja'] ?>">
																	</div>
																</div>
																<div class="col-md-6">
																	<label class="radio-inline pl-4">
																		<input type="radio" name="status_diangkat" value="f" <?= !$data['status_diangkat'] ? 'checked' : '' ?>>
																		<span>Belum Diangkat</span>
																	</label>
																	<label class="radio-inline">
																		<input type="radio" name="status_diangkat" value="t" <?= $data['status_diangkat'] ? 'checked' : '' ?>>
																		<span>Sudah Diangkat</span>
																	</label>
																</div>
															</div>
															<div class="row mt-20">
																<div class="col-md-12">
																	<fieldset class="bordered p-2" id="penempatan-jabatan">
																		<legend>Penempatan Jabatan Pekerja</legend>
																		<div class="table-responsive">
																			<table class="table" id="table-jabatan">
																				<thead>
																					<tr>
																						<th>Kodesie</th>
																						<th>Dept/Bidang/Unit/Seksi</th>
																						<th>Kode</th>
																						<th>Jabatan</th>
																					</tr>
																				</thead>
																				<tbody>
																					<?php foreach ($reffjabatan as $i => $item) : ?>
																						<tr data-id="<?= $i ?>" class="hover-pointer">
																							<td class="kodesie"><?= $item['kodesie'] ?></td>
																							<td class="seksi"><?= $item['seksi'] ?></td>
																							<td><?= $item['kd_jabatan'] ?></td>
																							<td><?= $item['jabatan'] ?></td>
																						</tr>
																					<?php endforeach ?>
																				</tbody>
																			</table>
																		</div>
																		<div>
																			<button class="btn btn-primary" id="add" data-toggle="modal" data-target="#modal-jabatan">Tambah Jabatan</button>
																			<button class="btn btn-primary" id="edit" data-toggle="modal" data-target="#modal-jabatan" disabled>Edit Jabatan</button>
																			<button class="btn btn-primary" id="delete" disabled>Hapus Jabatan</button>
																		</div>
																	</fieldset>
																</div>
															</div>
															<div class="row mt-10">
																<div class="col-md-12">
																	<div class="col-md-3">
																		<label for="">Kode Jbtn DL</label>
																	</div>
																	<div class="col-md-2">
																		<!-- <input type="text" name="kd_jbt_dl" class="form-control" value="<?= $data['kd_jbt_dl'] ?>"> -->
																		<select name="kd_jbt_dl" class="form-control" id="select-kd_jbt_dl">
																			<?php foreach ($arrjabatandl as $item) : ?>
																				<option value="<?= $item['kd_jbt_dl'] ?>" <?= ($item['kd_jbt_dl'] === $data['kd_jbt_dl']) ? 'selected' : '' ?>><?= $item['kd_jbt_dl'] . " - " . $item['nm_jbt_dl'] ?></option>
																			<?php endforeach ?>
																		</select>
																	</div>
																	<div class="col-md-7">
																		<div class="row">
																			<div class="col-md-3">
																				<label for="">Jabatan</label>
																			</div>
																			<div class="col-md-9">
																				<input type="text" name="jabatan" class="form-control" value="<?= $data['jabatan'] ?>" readonly>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
															<div class="row mt-10">
																<div class="col-md-12">
																	<div class="col-md-3">
																		<label for="">Pekerjaan/Gol</label>
																	</div>
																	<div class="col-md-6 col-sm-6">
																		<select name="kd_pkj" id="" class="form-control">
																			<option value=""></option>
																			<?php foreach ($arrlistpekerjaan as $item) : ?>
																				<option value="<?= $item['kdpekerjaan'] ?>" <?= ($item['kdpekerjaan'] === $data['kd_pkj']) ? 'selected' : '' ?>><?= $item['pekerjaan'] ?></option>
																			<?php endforeach ?>
																		</select>
																	</div>
																	<div class="col-md-3 col-sm-6">
																		<input type="text" name="golkerja" class="form-control uppercase" value="<?= $data['golkerja'] ?>">
																	</div>
																</div>
															</div>
															<div class="row mt-10">
																<div class="col-md-12">
																	<div class="col-md-3">
																		<label for="">Jenis Pekerjaan</label>
																	</div>
																	<div class="col-md-7">
																		<label class="radio-inline">
																			<input type="radio" name="jenispekerjaan" value="f" <?= !$data['jenispekerjaan'] ? 'checked' : '' ?> disabled>
																			<span>Direct Labour</span>
																		</label>
																		<label class="radio-inline">
																			<input type="radio" name="jenispekerjaan" value="t" <?= $data['jenispekerjaan'] ? 'checked' : '' ?> disabled>
																			<span>Indirect Labour</span>
																		</label>
																	</div>
																</div>
															</div>
															<div class="row mt-10">
																<div class="col-md-12">
																	<div class="col-md-3">
																		<label for="">Ruang</label>
																	</div>
																	<div class="col-md-3">
																		<input type="text" name="ruang" class="form-control uppercase" value="<?= $data['ruang'] ?>">
																	</div>
																	<div class="col-md-2">
																		<label for="">NPWP</label>
																	</div>
																	<div class="col-md-4">
																		<input type="text" name="npwp" class="form-control" value="<?= $data['npwp'] ?>">
																	</div>
																</div>
															</div>
															<div class="row mt-10">
																<div class="col-md-12">
																	<div class="col-md-3">
																		<label for="">Lama Kontrak</label>
																	</div>
																	<div class="col-md-2">
																		<input type="text" name="lmkontrak" class="form-control" value="<?= $data['lmkontrak'] ?>">
																	</div>
																	<div class="col-md-3">
																		<label for="">Berakhirnya Kontrak</label>
																	</div>
																	<div class="col-md-3">
																		<input type="text" name="akhkontrak" class="form-control date" value="<?= $data['akhkontrak'] ?>">
																	</div>
																</div>
															</div>
															<div class="row mt-10">
																<div class="col-md-12">
																	<div class="col-md-3">
																		<button class="btn btn-primary" data-toggle="modal" id="btn-pengaturan" data-target="#modal-work-location">
																			<i class="ion-android-settings"></i>
																			<span>Pengaturan</span>
																		</button>
																	</div>
																	<div class="col-md-8">
																		<?php
																		$id_kantor_asal = $data['kantor_asal'];
																		$id_lokasi_kerja = $data['lokasi_kerja'];

																		$kantor_asal = array_values(array_filter($arrlokasikerja, function ($item) use ($id_kantor_asal) {
																			return $item['id_'] == $id_kantor_asal;
																		}));
																		$lokasi_kerja = array_values(array_filter($arrlokasikerja, function ($item) use ($id_lokasi_kerja) {
																			return $item['id_'] == $id_lokasi_kerja;
																		}));

																		?>
																		<p>
																			<!-- ini nanti pakai alur sendiri -->
																			Kantor Asal : <span id="kantor_asal_text"><?= @$kantor_asal[0]['lokasi_kerja'] ?: '-' ?></span> <br>
																			Lokasi Kerja : <span id="lokasi_kerja_text"><?= @$lokasi_kerja[0]['lokasi_kerja'] ?: '-' ?></span>
																		</p>
																	</div>
																</div>
															</div>
															<div class="row mt-10">
																<div class="col-md-12">
																	<fieldset class="bordered p-2">
																		<legend>Status & Jabatan Upah</legend>
																		<div class="form-group">
																			<div class="col-md-10">
																				<div class="row">
																					<div class="col-md-12">
																						<div class="col-md-3">
																							<label for="">Status Jabatan</label>
																						</div>
																						<div class="col-md-9">
																							<input type="text" class="form-control" value="<?= $data['status_jabatan'] ?>" readonly>
																						</div>
																					</div>
																					<div class="col-md-12 mt-10">
																						<div class="col-md-3">
																							<label for="">Jabatan Upah</label>
																						</div>
																						<div class="col-md-9">
																							<input type="text" class="form-control" value="<?= $data['upah_jabatan'] ?>" readonly>
																						</div>
																					</div>
																				</div>
																			</div>
																		</div>
																	</fieldset>
																</div>
															</div>
														</div>
													</div>
												</div>
												<div class="col-md-4 mb-2 p-0 px-1 br-none">
													<div>
														<div class="inner-box min bordered">
															<h3>SPSI & Koperasi</h3>
															<div class="form-group">
																<div class="row mt-10">
																	<div class="col-md-7">
																		<label for="">Tgl. Pendaftaran SPSI</label>
																	</div>
																	<div class="col-md-5">
																		<input type="text" name="tglspsi" class="form-control date" value="<?= $data['tglspsi'] ?>">
																	</div>
																</div>
																<div class="row mt-10">
																	<div class="col-md-7">
																		<label for="">No. SPSI</label>
																	</div>
																	<div class="col-md-5">
																		<input type="text" name="nospsi" class="form-control" value="<?= $data['nospsi'] ?>">
																	</div>
																</div>
																<div class="row mt-10">
																	<div class="col-md-7">
																		<label for="">Tgl. Pendaftaran Koperasi</label>
																	</div>
																	<div class="col-md-5">
																		<input type="text" name="tglkop" class="form-control date" value="<?= $data['tglkop'] ?>">
																	</div>
																</div>
																<div class="row mt-10">
																	<div class="col-md-7">
																		<label for="">No. Koperasi</label>
																	</div>
																	<div class="col-md-5">
																		<input type="text" name="nokoperasi" class="form-control" value="<?= $data['nokoperasi'] ?>">
																	</div>
																</div>
															</div>
															<div class="row mt-10 pl-4">
																<p style="color: red;">
																	*) U/pek.tetap. Jika menjadi anggota koperasi. No koperasi diisi dengan kata "Ya". Jika tidak maka isi dengan "Tidak"
																</p>
															</div>
														</div>
														<div class="inner-box min bordered">
															<h3>Putus Hubungan Kerja</h3>
															<div class="form-group">
																<div class="row mt-10">
																	<div class="col-md-4">
																		<label for="">Tgl. Keluar</label>
																	</div>
																	<div class="col-md-6">
																		<input type="text" name="tglkeluar" class="form-control date" value="<?= $data['tglkeluar'] ?>">
																	</div>
																</div>
																<div class="row mt-10">
																	<div class="col-md-4">
																		<label for="">Sebab Keluar</label>
																	</div>
																	<div class="col-md-8">
																		<?php
																		if (!in_array($data['sebabklr'], $arrsebabkeluar)) {
																			array_push($arrsebabkeluar, array(
																				'fs_sbb_keluar' => $data['sebabklr']
																			));
																		}
																		?>
																		<select name="sebabklr" id="" class="form-control">
																			<option value="-">-</option>
																			<?php foreach ($arrsebabkeluar as $item) : ?>
																				<option value="<?= $item['fs_sbb_keluar'] ?>" <?= ($item['fs_sbb_keluar'] === $data['sebabklr']) ? 'selected' : '' ?>><?= $item['fs_sbb_keluar'] ?></option>
																			<?php endforeach ?>
																		</select>
																	</div>
																</div>
																<div class="row mt-10">
																	<div class="col-md-12">
																		<label for="pekerja_keluar">
																			<input type="checkbox" name="pekerja_keluar" id="pekerja_keluar" <?= $pekerja_keluar ? 'checked' : '' ?>>
																			<span>Pekerja Keluar</span>
																		</label>
																		<label for="non_perpanjang">
																			<input type="checkbox" name="non_perpanjang" id="non_perpanjang" <?= $non_perpanjang ? 'checked' : '' ?>>
																			<span>Non Perpanjang</span>
																		</label>
																	</div>
																</div>
																<div class="row mt-10">
																	<div class="col-md-4">
																		<label for="">Td. Tangan</label>
																	</div>
																	<div class="col-md-8">
																		<select name="tanda_tangan" id="active-worker" class="form-control"></select>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="tab-pane" id="tab_3">
										<div class="row">
											<div class="col-md-12">
												<div class="col-md-6 mb-2 p-0 px-1 br-none">
													<div class="inner-box min bordered">
														<div class="form-group">
															<h3>Pernikahan</h3>
															<div class="row mt-10">
																<div class="col-lg-5">
																	<label for="PK_txt_alamatPekerja">Status Pernikahan </label>
																</div>
																<div class="col-lg-4">
																	<?php
																	$arrStatNikah = ['-', 'BK', 'K', 'KS'];
																	?>
																	<select name="statnikah" id="" class="form-control">
																		<?php foreach ($arrStatNikah as $item) : ?>
																			<option value="<?= $item ?>" <?= $item === $data['statnikah'] ? 'selected' : '' ?>><?= $item ?></option>
																		<?php endforeach ?>
																	</select>
																</div>
															</div>
															<div class="row mt-10">
																<div class="col-lg-5">
																	<label for="PK_txt_alamatPekerja">Tanggal Pernikahan </label>
																</div>
																<div class="col-lg-4">
																	<input type="text" name="tglnikah" id="" class="form-control" value="<?= $data['tglnikah'] ?>">
																</div>
															</div>
														</div>
													</div>
												</div>
												<div class="col-md-6 mb-2 p-0 px-1 br-none">
													<div class="inner-box min bordered">
														<div class="form-group">
															<h3>BPJS</h3>
															<div class="row mt-10">
																<div class="col-lg-4 text-right">
																	<label for="PK_txt_alamatPekerja">Kesehatan </label>
																</div>
																<div class="col-lg-8">
																	<label class="radio-inline">
																		<input type="radio" name="bpjs_kes" value="t" <?= $data['bpjs_kes'] ? 'checked' : '' ?>>
																		<span>Ya</span>
																	</label>
																	<label class="radio-inline">
																		<input type="radio" name="bpjs_kes" value="f" <?= !$data['bpjs_kes'] ? 'checked' : '' ?>>
																		<span>Tidak</span>
																	</label>
																</div>
															</div>
															<div class="row mt-10">
																<div class="col-lg-4 text-right">
																	<label for="PK_txt_alamatPekerja">Per Tanggal </label>
																</div>
																<div class="col-lg-8">
																	<input type="text" name="tglberlaku_kes" class="form-control date" value="<?= $data['tglberlaku_kes'] ?>">
																</div>
															</div>
															<div class="row mt-10">
																<div class="col-lg-4 text-right">
																	<label for="PK_txt_alamatPekerja">Ketenagakerjaan </label>
																</div>
																<div class="col-lg-8">
																	<label class="radio-inline">
																		<input type="radio" name="bpjs_ket" value="t" <?= $data['bpjs_ket'] ? 'checked' : '' ?>>
																		<span>Ya</span>
																	</label>
																	<label class="radio-inline">
																		<input type="radio" name="bpjs_ket" value="f" <?= !$data['bpjs_ket'] ? 'checked' : '' ?>>
																		<span>Tidak</span>
																	</label>
																</div>
															</div>
															<div class="row mt-10">
																<div class="col-lg-4 text-right">
																	<label for="PK_txt_alamatPekerja">Per Tanggal </label>
																</div>
																<div class="col-lg-8">
																	<input type="text" name="tglberlaku_ket" class="form-control date" value="<?= $data['tglberlaku_ket'] ?>">
																</div>
															</div>
															<div class="row mt-10">
																<div class="col-lg-4 text-right">
																	<label for="PK_txt_alamatPekerja">Dana Pensiun </label>
																</div>
																<div class="col-lg-8">
																	<label class="radio-inline">
																		<input type="radio" name="bpjs_jht" value="t" <?= $data['bpjs_jht'] ? 'checked' : '' ?>>
																		<span>Ya</span>
																	</label>
																	<label class="radio-inline">
																		<input type="radio" name="bpjs_jht" value="f" <?= !$data['bpjs_jht'] ? 'checked' : '' ?>>
																		<span>Tidak</span>
																	</label>
																</div>
															</div>
															<div class="row mt-10">
																<div class="col-lg-4 text-right">
																	<label for="PK_txt_alamatPekerja">Per Tanggal </label>
																</div>
																<div class="col-lg-8">
																	<input type="text" name="tglberlaku_jht" class="form-control date" value="<?= $data['tglberlaku_jht'] ?>">
																</div>
															</div>
														</div>
													</div>
												</div>
												<div class="col-md-6 mb-2 p-0 px-1 br-none">
													<div class="inner-box min bordered">
														<div class="form-group">
															<h3>Perpajakan</h3>
															<div class="row mt-10">
																<div class="col-lg-6">
																	<label for="PK_txt_alamatPekerja">Status Pajak </label>
																</div>
																<div class="col-lg-4">
																	<?php
																	$arrStatusPajak = ['-', 'BK', 'K', 'KS'];
																	$statpajak = $data['statpajak'];
																	?>
																	<select name="statpajak" id="" class="form-control">
																		<?php foreach ($arrStatusPajak as $item) : ?>
																			<option value="<?= $item ?>" <?= $item === $statpajak ? 'selected' : '' ?>><?= $item ?></option>
																		<?php endforeach ?>
																	</select>
																</div>
															</div>
															<div class="row mt-10">
																<div class="col-lg-6">
																	<label for="PK_txt_alamatPekerja">Jumlah Tanggungan Anak </label>
																</div>
																<div class="col-lg-4">
																	<input type="number" name="jtanak" id="" class="form-control" value="<?= $data['jtanak'] ?>">
																</div>
															</div>
															<div class="row mt-10">
																<div class="col-lg-6">
																	<label for="PK_txt_alamatPekerja">Jumlah Tanggungan Bukan Anak </label>
																</div>
																<div class="col-lg-4">
																	<input type="number" name="jtbknanak" id="" class="form-control" value="<?= $data['jtbknanak'] ?>">
																</div>
															</div>
														</div>
													</div>
												</div>
												<div class="col-md-6 mb-2 p-0 px-1 br-none">
													<div class="inner-box min bordered">
														<div class="form-group">
															<h3>Rekening</h3>
															<div class="row mt-10" style="display: flex; align-items: center; justify-content: center;">
																<!-- <div class="col-lg-6">
																	<label for="PK_txt_alamatPekerja">Status No. Rekening </label>
																</div>
																<div class="col-lg-4">

																</div> -->
																<h1 style="margin: 0 auto; width: 100px;"></h1>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-12 mt-20 submit-container">
									<button class="btn btn-success" id="submit_update">Update Data</button>
								</div>
							</div>
							<!-- NAV -->
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- MODAL AREA -->
	<!-- /**
	 * MODAL PENGATURAN LOKASI KERJA
	 * untuk mengatur lokasi kerja pekerja
	*/ -->
	<div class="modal" id="modal-work-location">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<label class="modal-title" id="exampleModalLongTitle">Pengaturan Kantor Asal & Lokasi Kerja</label>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="bordered p-4">
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<div class="row mt-10">
										<div class="col-md-3">
											<label for="">Noind</label>
										</div>
										<div class="col-md-3">
											<input type="text" class="form-control" value="<?= $data['noind'] ?>" readonly>
										</div>
									</div>
									<div class="row mt-10">
										<div class="col-md-3">
											<label for="">Nama</label>
										</div>
										<div class="col-md-9">
											<input type="text" class="form-control" value="<?= $data['nama'] ?>" readonly>
										</div>
									</div>
									<div class="row mt-10">
										<div class="col-md-3">
											<label for="">Kodesie</label>
										</div>
										<div class="col-md-9">
											<input type="text" class="form-control" value="<?= $data['kodesie'] ?>" readonly>
										</div>
									</div>
									<div class="row mt-10">
										<div class="col-md-3">
											<label for="">Seksi / Unit</label>
										</div>
										<div class="col-md-9">
											<input type="text" class="form-control" value="<?= $data['seksi'] ?>" readonly>
										</div>
									</div>
									<div class="row mt-10">
										<div class="col-md-3">
											<label for="">Kantor Asal</label>
										</div>
										<div class="col-md-9">
											<select name="" id="kantor_asal" class="form-control select2">
												<?php foreach ($arrlokasikerja as $item) : ?>
													<option value="<?= $item['id_'] ?>" <?= ($item['id_'] === $data['kantor_asal']) ? 'selected' : '' ?>><?= $item['id_'] . " - " . $item['lokasi_kerja'] ?></option>
												<?php endforeach ?>
											</select>
										</div>
									</div>
									<div class="row mt-10">
										<div class="col-md-3">
											<label for="">Lokasi Kerja</label>
										</div>
										<div class="col-md-9">
											<select name="" id="lokasi_kerja" class="form-control select2">
												<?php foreach ($arrlokasikerja as $item) : ?>
													<option value="<?= $item['id_'] ?>" <?= ($item['id_'] === $data['lokasi_kerja']) ? 'selected' : '' ?>><?= $item['id_'] . " - " . $item['lokasi_kerja'] ?></option>
												<?php endforeach ?>
											</select>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="mt-10 flex">
							<div class="mr-.5em">
								<input type="checkbox" name="" id="agree">
							</div>
							<div>
								<p>Saya yakin untuk mengubah Kantor Asal dan Lokasi pekerja ini terhitung mulai tanggal <?= date('d/m/Y') ?></p>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer text-right">
					<button type="button" class="btn btn-primary" id="save" disabled>Simpan</button>
					<button type="submit" class="btn btn-secondary" data-dismiss="modal">Batal</button>
				</div>
			</div>
		</div>
	</div>
	<!-- 
	/**
	 * MODAL EDIT/ADD JABATAN
	 * Modal untuk mengatur jabatan 
	 */ -->
	<div class="modal" id="modal-jabatan">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<label class="modal-title" id="exampleModalLongTitle">Penempatan Jabatan Pekerja</label>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="bordered p-4">
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<div class="row mt-10">
										<div class="col-md-3">
											<label for="">Kodesie</label>
										</div>
										<div class="col-md-9">
											<select name="kodesie" id="select-seksi" class="form-control select2">

											</select>
										</div>
									</div>
									<div class="row mt-10">
										<div class="col-md-3">
											<label for="">Seksi</label>
										</div>
										<div class="col-md-9">
											<input type="text" id="seksi" class="form-control" readonly>
										</div>
									</div>
									<div class="row mt-10">
										<div class="col-md-3">
											<label for="">Unit</label>
										</div>
										<div class="col-md-9">
											<input type="text" id="unit" class="form-control" readonly>
										</div>
									</div>
									<div class="row mt-10">
										<div class="col-md-3">
											<label for="">Bidang</label>
										</div>
										<div class="col-md-9">
											<input type="text" id="bidang" class="form-control" readonly>
										</div>
									</div>
									<div class="row mt-10">
										<div class="col-md-3">
											<label for="">Departemen</label>
										</div>
										<div class="col-md-9">
											<input type="text" id="dept" class="form-control" readonly>
										</div>
									</div>
									<div class="row mt-10">
										<div class="col-md-3">
											<label for="">Kode Jabatan</label>
										</div>
										<div class="col-md-2">
											<input type="text" id="kd_jabatan" class="form-control" readonly>
										</div>
									</div>
									<div class="row mt-10">
										<div class="col-md-3">
											<label for="">Jabatan</label>
										</div>
										<div class="col-md-9">
											<input type="text" id="jabatan" class="form-control" readonly>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer text-right">
					<button type="button" id="jbtn_save" data-mode="save" class="btn btn-primary">Simpan</button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
				</div>
			</div>
		</div>
	</div>

	<!-- /**
	* MODAL CRUD KELUARGA
	* Modal untuk setup keluarga
	*/ -->
	<div class="modal" id="modal-keluarga">
		<div class="modal-dialog" style="width: 768px;" role="document">
			<div class="modal-content">
				<div class="modal-header" style="padding: 0.4em">
					<label class="modal-title" id="exampleModalLongTitle">Setup Anggota Keluarga</label>
					<button type="button" class="btn btn-sm btn-danger float-right" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true" class="text-white">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<fieldset class="bordered p-2">
						<legend>Anggota Keluarga</legend>
						<div class="col-md-12">
							<form action="#" method="post" id="form-anggota-keluarga" class="form-horizontal">
								<div class="row mt-10">
									<div class="col-lg-4 text-right">
										<label for="" class="control-label text-right">No Induk</label>
									</div>
									<div class="col-lg-3">
										<input type="text" name="noind" id="" class="form-control" value="<?= $data['noind'] ?>" disabled>
									</div>
									<div class="col-md-4">
										<span><?= $data['nama'] ?></span>
									</div>
								</div>
								<div class="row mt-10">
									<div class="col-lg-4 text-right">
										<label for="" class="control-label text-right">Jenis Anggota</label>
									</div>
									<div class="col-lg-4">
										<select name="nokel" class="select2" id="modal-keluarga_anggota" required>
											<option value=""></option>
											<?php foreach ($listanggotakel as $item) : ?>
												<option value="<?= $item['nokel'] ?>"><?= $item['nokel'] . ' - ' . $item['jenisanggota'] ?></option>
											<?php endforeach ?>
										</select>
									</div>
								</div>
								<div class="row mt-10">
									<div class="col-lg-4 text-right">
										<label for="" class="control-label text-right">Nama</label>
									</div>
									<div class="col-lg-4">
										<input type="text" name="nama" id="modal-keluarga_nama" class="form-control uppercase" required>
									</div>
								</div>
								<div class="row mt-10">
									<div class="col-lg-4 text-right">
										<label for="" class="control-label text-right">Alamat</label>
									</div>
									<div class="col-lg-4">
										<!-- <input type="text" name="alamat" id="modal-keluarga_alamat uppercase" class="form-control"> -->
										<textarea class="form-control uppercase" style="resize: vertical !important; max-height: 200px; min-height: 80px;" name="alamat" id="modal-keluarga_alamat"></textarea>
									</div>
								</div>
								<div class="row mt-10">
									<div class="col-lg-4 text-right">
										<label for="" class="control-label text-right">NIK</label>
									</div>
									<div class="col-lg-4">
										<input type="text" name="nik" id="modal-keluarga_nik" class="form-control">
									</div>
								</div>
								<div class="row mt-10">
									<div class="col-lg-4 text-right">
										<label for="" class="control-label text-right">Tanggal Lahir</label>
									</div>
									<div class="col-lg-4">
										<input type="text" name="tgllahir" id="modal-keluarga_tgllahir" class="form-control date">
									</div>
								</div>
								<div class="row mt-10">
									<div class="col-lg-4 text-right">
										<label for="" class="control-label text-right">Ditanggung</label>
									</div>
									<div class="col-lg-2">
										<select name="ditanggung" class="select2" id="modal-keluarga_tanggung">
											<option value="Y">Ya</option>
											<option value="T">Tidak</option>
										</select>
									</div>
									<div class="col-lg-4 text-right">
										<label for="" class="control-label text-right">Tanggungan Pajak</label>
									</div>
									<div class="col-lg-2">
										<select name="tanggungpajak" class="select2" id="modal-keluarga_tanggungpajak">
											<option value="Y">Ya</option>
											<option value="T">Tidak</option>
										</select>
									</div>
								</div>
								<div class="row mt-10">
									<div class="col-lg-4 text-right">
										<label for="" class="control-label text-right">Status Nikah</label>
									</div>
									<div class="col-lg-4">
										<?php
										$arrStatNikah = array('-', 'BK', 'K', 'KS', 'TK');
										?>
										<select name="statnikah" id="modal-keluarga_statnikah" class="form-control select2">
											<?php foreach ($arrStatNikah as $item) : ?>
												<option value="<?= $item ?>"><?= $item ?></option>
											<?php endforeach ?>
										</select>
									</div>
								</div>
								<div class="row mt-10">
									<div class="col-lg-4 text-right">
										<label for="" class="control-label text-right">Status BPJS</label>
									</div>
									<div class="col-lg-2">
										<select name="statusbpjs" class="select2" id="modal-keluarga_statbpjs">
											<option value="Y">Ya</option>
											<option value="T">Tidak</option>
										</select>
									</div>
								</div>
								<div class="row mt-10">
									<div class="col-lg-4 text-right">
										<label for="" class="control-label text-right">Keterangan</label>
									</div>
									<div class="col-lg-4">
										<input type="text" name="keterangan" id="modal-keluarga_keterangan" class="form-control" value="">
									</div>
								</div>
							</form>
						</div>
						<div class="col-md-12 text-center" style="margin-top: 1em;">
							<div id="main-wrapper">
								<button id="add" class="btn btn-primary">Tambah</button>
								<button id="edit" class="btn btn-primary" disabled>Edit</button>
								<button id="delete" class="btn btn-danger" disabled>Hapus</button>
								<!-- <button id="print" comment="TIDAK DIGUNAKAN" class="btn btn-primary">Cetak</button> -->
								<button class="btn btn-primary" role="button" id="refresh" style="margin-left: 3em;">
									<fa class="fa fa-refresh"></fa>
								</button>
							</div>
							<div id="add-wrapper" class="hidden">
								<button id="add_submit" class="btn btn-primary">Simpan</button>
								<button id="cancel" class="btn btn-secondary">Batal</button>
							</div>
							<div id="edit-wrapper" class="hidden">
								<button id="update_submit" class="btn btn-primary">Update</button>
								<button id="cancel" class="btn btn-secondary">Batal</button>
							</div>
						</div>
					</fieldset>
					<fieldset class="bordered p-2">
						<legend>Pencarian Data</legend>
						<div class="col-md-12">
							<div class="table-responsive">
								<table id="table-anggota-keluarga" class="table table-bordered table-striped datatable">
									<thead style="background-color: #0028bf; color: white;">
										<tr>
											<td class="text-center">Noind</td>
											<td class="text-center">Nokel</td>
											<td class="text-center">Jenis Anggota</td>
											<td class="text-center">Nama</td>
											<td class="text-center">Alamat</td>
											<td class="text-center">Tgl.Lahir</td>
											<td class="text-center">NIK</td>
										</tr>
									</thead>
									<tbody>
										<!-- <?php foreach ($anggotakeluarga as $member) : ?>
											<tr>
												<td><?= $member['noind'] ?></td>
												<td><?= $member['nokel'] ?></td>
												<td><?= $member['jenisanggota'] ?></td>
												<td><?= $member['nama'] ?></td>
												<td><?= $member['alamat'] ?></td>
												<td><?= (new DateTime($member['tgllahir']))->format('d-m-Y') ?></td>
												<td><?= $member['nik'] ?></td>
											</tr>
										<?php endforeach ?> -->
									</tbody>
								</table>
							</div>
						</div>
					</fieldset>
				</div>
			</div>
		</div>
	</div>

	<!-- /**
	 * MODAL CETAK SURAT PERPANJANGAN ORIENTASI
	 * Cetak PDF
	*/ -->
	<div class="modal" id="modal-perpanjangan-orientasi">
		<div class="modal-dialog" style="width: 300px;" role="document">
			<div class="modal-content" style="border-radius: 5px;">
				<div class=" modal-header bg-primary" style="padding: 0.4em; border-radius: 5px 5px 0 0;">
					<label class=" modal-title" id="exampleModalLongTitle">Perpanjangan Orientasi</label>
					<button type="button" class="btn btn-sm btn-danger float-right" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true" class="text-white">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="table-responsive">
						<table class="table table-bordered">
							<thead class="" style="background-color: black; color: white;">
								<tr>
									<td>Ke</td>
									<td>Mulai</td>
									<td>Akhir</td>
								</tr>
							</thead>
							<tbody>
								<!-- <?php for ($x = 1; $x <= 3; $x++) : ?>
									<tr>
										<td><?= $x ?></td>
										<td>2020-01-01</td>
										<td>2020-05-01</td>
									</tr>
								<?php endfor ?> -->
								<!-- using AJAX ? -->
							</tbody>
						</table>
					</div>
					<div class="row">
						<div class="col-md-12 mb-1">
							<div class="row">
								<div class="col-md-5">
									<label for="">Nomor Surat</label>
								</div>
								<div class="col-md-7">
									<input type="text" name="no_surat" value id="no_surat" class="form-control">
								</div>
							</div>
						</div>
						<div class="col-md-12 mb-1">
							<div class="row">
								<div class="col-md-5">
									<label for="">Kode Arsip</label>
								</div>
								<div class="col-md-3">
									<input type="text" name="kode" value="ted" id="code" class="form-control" style="padding: 5px;">
								</div>
								<div class="col-md-1" style="padding: 0;">
									<span>/</span>
								</div>
								<div class="col-md-3" style="padding-left: 0;">
									<input type="text" name="arsip" value id="archives" class="form-control" style="padding: 5px;">
								</div>
							</div>
						</div>
						<!-- <div class="col-md-12 mb-1" mb-1>
							<div class="row">
								<div class="col-md-5">
									<label for="">Ruang Lingkup</label>
								</div>
								<div class="col-md-7">
									<select name="" id="" class="form-control">
										<option value=""></option>
										<option value=""></option>
									</select>
								</div>
							</div>
						</div> -->
						<div class="col-md-12 mb-1" mb-1>
							<div class="row">
								<div class="col-md-5">
									<label for="">Atasan</label>
								</div>
								<div class="col-md-7">
									<select name="" id="assignment_atasan" data-placeholder="-- Pilih --" class="form-control select2">
										<!-- <option value=""></option> -->
										<?php foreach ($atasan as $item) : ?>
											<option value="<?= $item['noind'] ?>"><?= $item['noind'] . " - " . $item['nama'] ?></option>
										<?php endforeach ?>
									</select>
								</div>
							</div>
						</div>
						<div class="col-md-12 mb-1" mb-1>
							<div class="row">
								<div class="col-md-5">
									<label for="">Hubker</label>
								</div>
								<div class="col-md-7">
									<select name="" id="assignment_hubker" data-placeholder="-- Pilih --" class="form-control select2">
										<!-- <option value=""></option> -->
										<?php foreach ($atasanhubker as $item) : ?>
											<option value="<?= $item['noind'] ?>"><?= $item['noind'] . " - " . $item['nama'] ?></option>
										<?php endforeach ?>
									</select>
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<button class="btn btn-danger btn-block" id="print">
								<i class="fa fa-file-pdf-o"></i>
								<span>Cetak Memo</span>
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- /**
		Modal ambil noind lama
	*/ -->
	<div class="modal" id="modal-ambil-data">
		<div class="modal-dialog" role="document">
			<div class="modal-content" style="border-radius: 5px; width: 470px; border: 2px solid #337ab7;">
				<div class=" modal-header bg-primary" style="padding: 0.4em;">
					<label class=" modal-title" id="exampleModalLongTitle">Ambil Data dari Noind Lama - Master Pekerja</label>
					<button type="button" class="btn btn-sm btn-danger float-right" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true" class="text-white">&times;</span>
					</button>
				</div>
				<div class="modal-body" style="padding-top: 0;">
					<div class="row mb-2" style="background: aliceblue; border-bottom: 2px solid #e8e8e8;">
						<div class="col-md-12">
							<h1>Ambil Data Noind Lama</h1>
							<p>Mengambil data dari noind lama dan merubah data noind sekarang</p>
						</div>
					</div>
					<div class="row mb-2">
						<div class="col-md-12">
							<p>Pilih noind lama untuk mengambil data pribadi dan jamsostek</p>
							<div class="row mb-2">
								<div class="form-group">
									<label for="" class="label-control col-md-4">Noind Lama</label>
									<div class="col-md-8">
										<select name="" id="" class="select2-active-noind" data-placeholder="Noind lama"></select>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="form-group">
									<label for="" class="label-control col-md-4">Noind Sekarang</label>
									<div class="col-md-3">
										<input type="text" value="<?= $data['noind'] ?>" class="form-control" disabled>
									</div>
									<div class="col-md-5">
										<span><?= $data['nama'] ?></span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<div class="row">
						<div class="col-md-12 text-center">
							<button class="btn btn-primary" id="submit">Ambil</button>
							<button class="btn btn-default" data-dismiss="modal">Batal</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- MODAL AREA -->

	<!-- LOADING -->
	<div id=fake-loading style="top: 0;left: 0;right: 0;bottom: 0; margin: auto; position: fixed; background: rgba(0,0,0,.5); z-index: 11;" class="hidden">
		<img src="http://erp.quick.com/assets/img/gif/loadingtwo.gif" style="position: fixed; top: 0;left: 0;right: 0;bottom: 0; margin: auto; width: 40%;">
	</div>

	<!--
			Oh no.... we are lost
		 	  _      _      _
			>(.)__ <(.)__ =(.)__
			 (___/  (___/  (___/ .... guide me to find my mother
	-->
</body>
<script>
	/**
	 * Global Function
	 * Toggle loading, Fullscreen loading
	 * @param void
	 * @return void
	 */
	function toggle_loading() {
		const loading_element = $('#fake-loading')

		let isLoading = loading_element.hasClass('hidden') // Boolean

		if (isLoading) {
			loading_element.removeClass('hidden')
		} else {
			loading_element.addClass('hidden')
		}
	}

	$(() => {
		// Global Selector
		$('input.numberOnly').on('keyup', function(e) {
			if (e.target.value.match(/\D/)) e.target.value = e.target.value.replace(/\D/, '')
		})
		$('input[type=radio], input[type=checkbox]').iCheck({
			checkboxClass: 'icheckbox_flat-blue',
			radioClass: 'iradio_flat-blue'
		});
		$('select.select2').select2()
		$('input.uppercase, textarea.uppercase').on('change', function() {
			console.log(this.value.toUpperCase())
			return $(this).val(this.value.toUpperCase())
		})
		// global selector
		$('input.date').datepicker({
			changeMonth: true,
			changeYear: true,
			format: 'dd-mm-yyyy'
		})
		// // Experimental
		// $.urlParam = function(name) {
		// 	var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
		// 	return results[1] || 0;
		// }

		// const tab = $.urlParam('tab')
		// $(`a[href=#tab_${tab}]`).click()
		// // Experimental

		/**
		 * SELECT PEKERJA
		 */
		$('select#active-worker').select2({
			minimumInputLength: 1,
			allowClear: true,
			ajax: {
				url: baseurl + "MasterPekerja/DataPekerjaKeluar/data_pekerja",
				dataType: "json",
				type: "GET",
				data: (query) => ({
					term: query.term,
					rd_keluar: false
				}),
				processResults: function(data) {
					return {
						results: data.map((item) => {
							return {
								id: item.noind,
								text: item.noind + " - " + item.nama,
							};
						}),
					};
				},
			},
		})
	})
</script>
<!-- Go go go reach 3000 line  -->