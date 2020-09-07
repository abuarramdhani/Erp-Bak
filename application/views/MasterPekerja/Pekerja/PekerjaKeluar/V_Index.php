<style>
	.form-control {
		height: 2em !important;
	}

	.bordered {
		border: 1px solid #a6a6a6;
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

	table#table-jabatan tbody tr {
		user-select: none;
		cursor: pointer;
	}

	/* Firefox */
	input[type=number] {
		-moz-appearance: textfield;
	}
</style>

<style>
	/* component styling */
	#table-jabatan>tbody>tr.activex,
	#table-jabatan>tbody>tr.activex:active,
	#table-jabatan>tbody>tr.activex:focus {
		background-color: #3c8dbc !important;
		color: white;
	}

	.select2 {
		width: 100% !important;
	}
</style>

<section class="content">
	<div class="panel-group">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3>Edit Data Pekerja</h3>
			</div>
			<div class="panel-body">
				<div class="row" id="search-container">
					<form method="GET" action="<?= base_url('MasterPekerja/DataPekerjaKeluar/viewEdit') ?>">
						<div class="col-lg-4">
							<div class="form-group">
								<label>Cari Pekerja</label>
								<label class="radio-inline pl-4">
									<input type="radio" value="f" name="keluar" required checked>
									<span>Aktif</span>
								</label>
								<label class="radio-inline">
									<input type="radio" value="t" name="keluar" required>
									<span>Keluar</span>
								</label>
							</div>
						</div>
						<div class="col-lg-4">
							<div class="form-group">
								<select name="noind" id="select-pekerja" data-placeholder="Ketik nama atau nomor induk" class="form-control" required>
									<option></option>
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
				<div class="row">
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
							<div class="tab-content" style="opacity: 0.5; pointer-events: none;">
								<div class="tab-pane active" id="tab_1">
									<div class="row">
										<div class="col-md-12">
											<div class="col-md-4 mb-2 p-0 px-1 br-none">
												<div class="inner-box bordered">
													<div class="form-group">
														<h3>Data Pribadi</h3>
														<div class="mt-20">
															<div style="width: 3cm; height: 4cm; background-color: #e8e8e8; margin: 0 auto;">
																<!-- <img style="width: 100%;" src=""> -->
																<img style="width: 100%;" src="">
															</div>
														</div>
														<div class="row mt-20">
															<div class="col-lg-4">
																<label for="PK_txt_noinduk">No Induk </label>
															</div>
															<div class="col-lg-4">
																<input type="text" name="noind" id="" class="form-control" readonly>
															</div>
														</div>
														<div class="row mt-10">
															<div class="col-lg-4">
																<label for="PK_txt_namaPekerja">Nama </label>
															</div>
															<div class="col-lg-8">
																<input type="text" name="nama" id="" class="form-control uppercase">
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
																	<option> </option>
																</select>
															</div>
														</div>
														<div class="row mt-10">
															<div class="col-lg-4">
																<label for="PK_txt_namaPekerja">Agama</label>
															</div>
															<div class="col-lg-5">
																<select name="agama" id="" class="form-control">
																	<option> </option>
																</select>
															</div>
														</div>
														<div class="row mt-10">
															<div class="col-lg-4">
																<label for="PK_txt_kotaLahir">Tempat Lahir </label>
															</div>
															<div class="col-lg-8">
																<input type="text" name="templahir" id="" class="form-control uppercase">
															</div>
														</div>
														<div class="row mt-10">
															<div class="col-lg-4">
																<label for="PK_txt_tanggalLahir">Tanggal Lahir </label>
															</div>
															<div class="col-lg-8">
																<input type="text" name="tgllahir" id="" class="form-control date">
															</div>
														</div>
														<div class="row mt-10">
															<div class="col-lg-4">
																<label for="">Gol. Darah</label>
															</div>
															<div class="col-lg-4">
																<select name="goldarah" id="" class="form-control">

																	<option> </option>

																</select>
															</div>
														</div>
														<div class="row mt-10">
															<div class="col-lg-4">
																<label for="PK_txt_nikPekerja">NIK </label>
															</div>
															<div class="col-lg-8">
																<input type="text" name="nik" id="" class="form-control numberOnly">
															</div>
														</div>
														<div class="row mt-10">
															<div class="col-lg-4">
																<label for="PK_txt_nikPekerja">No. KK </label>
															</div>
															<div class="col-lg-8">
																<input type="text" name="no_kk" id="" class="form-control numberOnly">
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
																<textarea class="form-control uppercase" style="resize: vertical !important; max-height: 250px; min-height: 90px;" name="alamat" id=""></textarea>
															</div>
														</div>
														<div class="row mt-10">
															<div class="col-lg-4">
																<label for="PK_txt_provinsiPekerja">Provinsi </label>
															</div>
															<div class="col-lg-8">
																<!-- <input type="text" name="prop" id="" class="form-control" > -->
																<select name="prop" id="select-provinsi" class="form-control">
																	<option selected></option>
																</select>
															</div>
														</div>
														<div class="row mt-10">
															<div class="col-lg-4">
																<label for="PK_txt_kabupatenPekerja">Kabupaten </label>
															</div>
															<div class="col-lg-8">
																<!-- <input type="text" name="kab" id="" class="form-control" > -->
																<select name="kab" id="select-kabupaten" class="form-control">
																	<option selected></option>
																</select>
															</div>
														</div>
														<div class="row mt-10">
															<div class="col-lg-4">
																<label for="PK_txt_kecamatanPekerja">Kecamatan </label>
															</div>
															<div class="col-lg-8">
																<!-- <input type="text" name="kec" id="" class="form-control" > -->
																<select name="kec" id="select-kecamatan" class="form-control">
																	<option selected></option>
																</select>
															</div>
														</div>
														<div class="row mt-10">
															<div class="col-lg-4">
																<label for="select-desa">Desa </label>
															</div>
															<div class="col-lg-8">
																<!-- <input type="text" name="desa" id="" class="form-control uppercase" > -->
																<select name="desa" id="select-desa" class="form-control">
																	<option selected></option>
																</select>
															</div>
														</div>
														<div class="row mt-10">
															<div class="col-lg-4">
																<label for="PK_txt_kodePosPekerja">Kode Pos </label>
															</div>
															<div class="col-lg-4">
																<input type="number" name="kodepos" id="" pattern="\d*" maxlength="5" class="form-control numberOnly">
															</div>
														</div>
														<div class="row mt-10">
															<div class="col-lg-4">
																<label for="PK_txt_kodePosPekerja">Stat Rumah </label>
															</div>
															<div class="col-lg-4">
																<select class="form-control" name="statrumah" id="">

																	<option> </option>

																</select>
															</div>
														</div>
														<div class="row mt-10">
															<div class="col-lg-4">
																<label for="PK_txt_teleponPekerja">Telepon </label>
															</div>
															<div class="col-lg-8">
																<input type="number" name="telepon" id="" class="form-control numberOnly">
															</div>
														</div>
														<div class="row mt-10">
															<div class="col-lg-4">
																<label for="PK_txt_nohpPekerja">No Hp </label>
															</div>
															<div class="col-lg-8">
																<input type="tel" name="nohp" id="" class="form-control numberOnly">
															</div>
														</div>
														<div class="row mt-10">
															<div class="col-lg-4">
																<label for="PK_txt_nohpPekerja">Email </label>
															</div>
															<div class="col-lg-8">
																<input type="email" name="email" id="" class="form-control email">
															</div>
														</div>
														<div class="row mt-10">
															<div class="col-lg-4">
																<label for="PK_txt_alamatPekerja">Alamat Kos </label>
															</div>
															<div class="col-lg-8">
																<textarea class="form-control uppercase" style="resize: vertical !important; max-height: 250px; min-height: 90px;" name="almt_kost" id=""></textarea>
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
																<input type="text" name="gelard" id="" class="form-control">
															</div>
														</div>
														<div class=" row mt-10">
															<div class="col-lg-5">
																<label for="PK_txt_alamatPekerja">Gelar Belakang </label>
															</div>
															<div class="col-lg-7">
																<input type="text" name="gelarb" id="" class="form-control">
															</div>
														</div>
														<div class=" row mt-10">
															<div class="col-lg-5">
																<label for="PK_txt_alamatPekerja">Pendidikan </label>
															</div>
															<div class="col-lg-7">
																<input type="text" name="pendidikan" id="" class="form-control uppercase">
															</div>
														</div>
														<div class=" row mt-10">
															<div class="col-lg-5">
																<label for="PK_txt_alamatPekerja">Jurusan </label>
															</div>
															<div class="col-lg-7">
																<input type="text" name="jurusan" id="" class="form-control uppercase">
															</div>
														</div>
														<div class=" row mt-10">
															<div class="col-lg-5">
																<label for="PK_txt_alamatPekerja">Asal Sekolah </label>
															</div>
															<div class="col-lg-7">
																<input type="text" name="sekolah" id="" class="form-control uppercase">
															</div>
														</div>
													</div>
												</div>
												<div class=" inner-box bordered">
													<div class="form-group">
														<h3>Anak dan Keluarga</h3>
														<div class="row mt-20">
															<div class="col-lg-5">
																<label for="PK_txt_alamatPekerja">Jumlah Anak </label>
															</div>
															<div class="col-lg-4">
																<input type="number" name="jumanak" id="" class="form-control numberOnly">
															</div>
														</div>
														<div class="row mt-10">
															<div class="col-lg-5">
																<label for="PK_txt_alamatPekerja">Jumlah Saudara </label>
															</div>
															<div class="col-lg-4">
																<input type="number" name="jumsdr" id="" class="form-control numberOnly">
															</div>
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
															<input type="email" name="email_internal" id="" class="form-control">
														</div>
													</div>
													<div class="row" style="margin-top: 10px;">
														<div class="col-lg-4">
															<label for="PK_txt_externalmail">External Mail </label>
														</div>
														<div class="col-lg-8">
															<input type="email" name="external_mail" id="" class="form-control">
														</div>
													</div>
													<div class="row" style="margin-top: 10px;">
														<div class="col-lg-4">
															<label for="PK_txt_telkomselmygroup">Telkomsel Mygroup </label>
														</div>
														<div class="col-lg-8">
															<input type="text" name="telkomsel_mygroup" id="" class="form-control">
														</div>
													</div>
													<div class="row" style="margin-top: 10px;">
														<div class="col-lg-4">
															<label for="PK_txt_pidginaccount">Pidgin Account </label>
														</div>
														<div class="col-lg-8">
															<input type="text" name="pidgin_account" id="" class="form-control">
														</div>
													</div>
													<div class="row" style="margin-top: 10px;">
														<div class="col-lg-4">
															<label for="PK_txt_ukuranbaju">Ukuran Baju </label>
														</div>
														<div class="col-lg-8">
															<input type="text" name="uk_baju" id="" class="form-control">
														</div>
													</div>
													<div class="row" style="margin-top: 10px;">
														<div class="col-lg-4">
															<label for="PK_txt_ukurancelana">Ukuran Celana </label>
														</div>
														<div class="col-lg-8">
															<input type="text" name="uk_celana" id="" class="form-control">
														</div>
													</div>
													<div class="row" style="margin-top: 10px;">
														<div class="col-lg-4">
															<label for="PK_txt_ukuransepatu">Ukuran Sepatu </label>
														</div>
														<div class="col-lg-8">
															<input type="text" name="uk_sepatu" id="" class="form-control numberOnly">
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
																	<input type="number" name="nokeb" class="form-control">
																</div>
															</div>
															<div class="col-md-6">
																<div class="col-md-6">
																	<label for="" class="label-control">Tgl. Diangkat</label>
																</div>
																<div class="col-md-6">
																	<input type="text" name="diangkat" class="form-control date">
																</div>
															</div>
														</div>
														<div class="row mt-10">
															<div class="col-md-6">
																<div class="col-md-6">
																	<label for="" class="label-control">Tgl Masuk Kerja</label>
																</div>
																<div class="col-md-6">
																	<input type="text" name="masukkerja" class="form-control date">
																</div>
															</div>
															<div class="col-md-6">
																<label class="radio-inline pl-4">
																	<input type="radio" name="status_diangkat">
																	<span>Belum Diangkat</span>
																</label>
																<label class="radio-inline">
																	<input type="radio" name="status_diangkat">
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

																				<tr data-id="">
																					<td class="kodesie"></td>
																					<td class="seksi"></td>
																					<td></td>
																					<td></td>
																				</tr>

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
																	<input type="text" name="kd_jbt_dl" class="form-control">
																</div>
																<div class="col-md-7">
																	<div class="row">
																		<div class="col-md-3">
																			<label for="">Jabatan</label>
																		</div>
																		<div class="col-md-9">
																			<input type="text" name="jabatan" class="form-control" readonly>
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
																<div class="col-md-6">
																	<select name="kd_pkj" id="" class="form-control">
																		<option></option>

																		<option </option> </select> </div> <div class="col-md-3">
																			<input type="text" name="golkerja" class="form-control uppercase">
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
																		<input type="radio" name="jenispekerjaan" disabled>
																		<span>Direct Labour</span>
																	</label>
																	<label class="radio-inline">
																		<input type="radio" name="jenispekerjaan" disabled>
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
																	<input type="text" name="ruang" class="form-control uppercase">
																</div>
																<div class="col-md-2">
																	<label for="">NPWP</label>
																</div>
																<div class="col-md-4">
																	<input type="text" name="npwp" class="form-control">
																</div>
															</div>
														</div>
														<div class="row mt-10">
															<div class="col-md-12">
																<div class="col-md-3">
																	<label for="">Lama Kontrak</label>
																</div>
																<div class="col-md-2">
																	<input type="text" name="lmkontrak" class="form-control">
																</div>
																<div class="col-md-3">
																	<label for="">Berakhirnya Kontrak</label>
																</div>
																<div class="col-md-3">
																	<input type="text" name="akhkontrak" class="form-control date">
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
																	<p>
																		<!-- ini nanti pakai alur sendiri -->
																		Kantor Asal : <span id="kantor_asal_text"></span> <br>
																		Lokasi Kerja : <span id="lokasi_kerja_text"></span>
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
																						<input type="text" class="form-control" readonly>
																					</div>
																				</div>
																				<div class="col-md-12 mt-10">
																					<div class="col-md-3">
																						<label for="">Jabatan Upah</label>
																					</div>
																					<div class="col-md-9">
																						<input type="text" class="form-control" readonly>
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
																	<input type="text" name="tglspsi" class="form-control date">
																</div>
															</div>
															<div class="row mt-10">
																<div class="col-md-7">
																	<label for="">No. SPSI</label>
																</div>
																<div class="col-md-5">
																	<input type="text" name="nospsi" class="form-control">
																</div>
															</div>
															<div class="row mt-10">
																<div class="col-md-7">
																	<label for="">Tgl. Pendaftaran Koperasi</label>
																</div>
																<div class="col-md-5">
																	<input type="text" name="tglkop" class="form-control date">
																</div>
															</div>
															<div class="row mt-10">
																<div class="col-md-7">
																	<label for="">No. Koperasi</label>
																</div>
																<div class="col-md-5">
																	<input type="text" name="nokoperasi" class="form-control">
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
																	<input type="text" name="tglkeluar" class="form-control date">
																</div>
															</div>
															<div class="row mt-10">
																<div class="col-md-4">
																	<label for="">Sebab Keluar</label>
																</div>
																<div class="col-md-8">
																	<select name="sebabklr" id="" class="form-control">
																		<option>-</option>

																	</select>
																</div>
															</div>
															<div class="row mt-10">
																<div class="col-md-12">
																	<label for="">
																		<input type="checkbox" name="nani" id="">
																		Pekerja Keluar
																	</label>
																	<label for="">
																		<input type="checkbox" name="nani" id="">
																		Non Perpanjang
																	</label>
																</div>
															</div>
															<div class="row mt-10">
																<div class="col-md-4">
																	<label for="">Td. Tangan</label>
																</div>
																<div class="col-md-8">
																	<select name="nanii" id="" class="form-control"></select>
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
																	<option> </option>
																</select>
															</div>
														</div>
														<div class="row mt-10">
															<div class="col-lg-5">
																<label for="PK_txt_alamatPekerja">Tanggal Pernikahan </label>
															</div>
															<div class="col-lg-4">
																<input type="text" name="tglnikah" id="" class="form-control">
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
																	<input type="radio" name="bpjs_kes">
																	<span>Ya</span>
																</label>
																<label class="radio-inline">
																	<input type="radio" name="bpjs_kes">
																	<span>Tidak</span>
																</label>
															</div>
														</div>
														<div class="row mt-10">
															<div class="col-lg-4 text-right">
																<label for="PK_txt_alamatPekerja">Per Tanggal </label>
															</div>
															<div class="col-lg-8">
																<input type="text" name="tglberlaku_kes" class="form-control date">
															</div>
														</div>
														<div class="row mt-10">
															<div class="col-lg-4 text-right">
																<label for="PK_txt_alamatPekerja">Ketenagakerjaan </label>
															</div>
															<div class="col-lg-8">
																<label class="radio-inline">
																	<input type="radio" name="bpjs_ket">
																	<span>Ya</span>
																</label>
																<label class="radio-inline">
																	<input type="radio" name="bpjs_ket">
																	<span>Tidak</span>
																</label>
															</div>
														</div>
														<div class="row mt-10">
															<div class="col-lg-4 text-right">
																<label for="PK_txt_alamatPekerja">Per Tanggal </label>
															</div>
															<div class="col-lg-8">
																<input type="text" name="tglberlaku_ket" class="form-control date">
															</div>
														</div>
														<div class="row mt-10">
															<div class="col-lg-4 text-right">
																<label for="PK_txt_alamatPekerja">Dana Pensiun </label>
															</div>
															<div class="col-lg-8">
																<label class="radio-inline">
																	<input type="radio" name="bpjs_jht">
																	<span>Ya</span>
																</label>
																<label class="radio-inline">
																	<input type="radio" name="bpjs_jht">
																	<span>Tidak</span>
																</label>
															</div>
														</div>
														<div class="row mt-10">
															<div class="col-lg-4 text-right">
																<label for="PK_txt_alamatPekerja">Per Tanggal </label>
															</div>
															<div class="col-lg-8">
																<input type="text" name="tglberlaku_jht" class="form-control date">
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
																<select name="statpajak" id="" class="form-control">

																	<option> </option>

																</select>
															</div>
														</div>
														<div class="row mt-10">
															<div class="col-lg-6">
																<label for="PK_txt_alamatPekerja">Jumlah Tanggungan Anak </label>
															</div>
															<div class="col-lg-4">
																<input type="number" name="jtanak" id="" class="form-control">
															</div>
														</div>
														<div class="row mt-10">
															<div class="col-lg-6">
																<label for="PK_txt_alamatPekerja">Jumlah Tanggungan Bukan Anak </label>
															</div>
															<div class="col-lg-4">
																<input type="number" name="jtbknanak" id="" class="form-control">
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
															<h1 style="margin: 0 auto; width: 100px;">SOON</h1>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-12 mt-20">
							</div>
						</div>
						<!-- NAV -->
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<script>
	$(() => {
		$('input[type=radio]').iCheck({
			checkboxClass: 'icheckbox_flat-blue',
			radioClass: 'iradio_flat-blue'
		});
	})
</script>