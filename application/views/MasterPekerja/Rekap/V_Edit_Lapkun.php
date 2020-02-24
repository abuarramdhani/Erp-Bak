<section class="content">
	<div class="inner" >
			<div class="box box-header"  style="padding-left:20px">
				<h3 class="pull-left"><i class="fa fa-print">&nbsp;</i><strong> Edit Laporan Kunjungan Pekerja </strong></h3>
			</div>
		</div>
		<div class="panel box-body" style="font-size: 13px;">
			<form id="formLap" method="post" action="<?php echo base_url('MasterPekerja/LaporanKunjungan/updateLaporanKunjungan'); ?>">

			<input type="hidden" name="id_laporan" value="<?= $id_laporan ?>"></input>

			<div class="row">
				<div class="col-md-12">
				<div class="col-md-1"></div>
				<div class="col-md-1"> <label for="no_surat">Nomor Surat</label></div>
					<div class="form-group col-md-6">
				  	     <input required type="text" name="no_surat" readonly class="form-control" id="no_surat" value="<?= $no_surat ?>">
				  </div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<div class="col-md-1"></div>
					<div class="col-md-1"><label for="atasan">Atasan</label></div>
					<div class="form-group col-md-6">

							<select required style="width: 100%" class="form-control slc-namaatasan" name="atasan" id="atasan"><option value="<?= $noinduk_atasan?>"><?= $noinduk_atasan." - ".$nama_atasan." - ".$jabatan_atasan  ?></option></select>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<div class="col-md-1"></div>
					<div class="col-md-1"><label for="nolap">Petugas</label></div>
					<div class="form-group col-md-6">

							<select required style="width: 100%" class="form-control slc-namapetugas" name="petugas" id="nolap">
							<option value="<?= $noinduk_petugas?>"><?= $noinduk_petugas." - ".$nama_petugas." - ".$seksi_petugas ?></option>
							</select>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
				<div class="col-md-1"></div>
				<div class="col-md-1"><label for="pekerja">Pekerja</label></div>
					<div class="form-group col-md-6">

						    <select required style="width: 100%" class="form-control slc-laporankunjungan" name="pekerja" id="pekerja"><option value="<?= $noinduk_pekerja?>"><?= $noinduk_pekerja." - ".$nama_pekerja." - ".$seksi_pekerja." - ".$alamat_pekerja ?></option></select>
					 </div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
				<div class="col-md-1"></div>
				<div class="col-md-1"> <label for="diagnosa">Diagnosa</label></div>
					<div class="form-group col-md-6">
				  	     <input required type="text" name="diagnosa" class="form-control" id="diagnosa" placeholder="Diagnosa" value="<?= $diagnosa ?>">
				  </div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
				<div class="col-md-1"></div>
				<div class="col-md-1"><label for="hal">Hal</label></div>
					<div class="form-group col-md-6">

					    <input required name="hal" type="text" class="form-control" id="hal" placeholder="Hal" value="<?= $hal_laporan ?>">
				  </div>
				</div>
			</div>

			<?php foreach ($latar_belakang as $key => $latbel): ?>
			<div class="row latar-belakang">
				<div class="col-md-12">
				<div class="col-md-1"></div>

				<div class="col-md-1"> <label for="latbel">Latar Belakang </label></div>
					<div class="form-group col-md-6">

					    <input required name="latar_belakang[]" type="text" class="form-control latbel" id="latbel" placeholder="Latar Belakang" value="<?= $latbel ?>">

					  </div>
				</div>
			</div>
			<?php endforeach; ?>


			<div class="row">
				<div class="col-md-12">
				<div class="col-md-2"></div>
					<div class="col-md-2">
						<button id="addLatarBelakang" type="button" class="btn btn-info">Tambah Latar Belakang</button>
					</div>
					<div class="col-md-2">
						<button id="deleteLatarBelakang" type="button" class="btn btn-warning">Hapus Latar Belakang</button>
					</div>
				</div>
			</div>
			<br/>
			<br/>

			<div class="row">
				<div class="col-md-12">
				<div class="col-md-1"></div>
				<div class="col-md-1"><label for="lapkun"><i class="fa fa-pencil-square">&nbsp;&nbsp;</i>Laporan Hasil Kunjungan</label></div>
					<div class="form-group col-md-8">

					  	<textarea required class="form-control txtLapKun preview-Lapkun ckeditor" id="lapkun" name="LapKun" rows="10" ><?= $hasil_laporan ?></textarea>
					</div>
				</div>
			</div>
			</form>
		</div>

<div class="panel box-body">
	<div class="row">
				<div class="col-md-12">
				<div class="col-md-1"></div>
					<div class="col-md-1">
						<center><a type="button" class="btn btn-danger" onclick="window.history.back()"><b>Back</b></a></center>
					</div>
					<div class="col-md-1">
						<button type="button" class="btn btn-info btn-preview"><i class="fa fa-file-pdf-o">&nbsp;&nbsp;</i><b> Preview</b></button>
					</div>

					<div class="col-md-2">
						<center>
						<img class="pv-loading" style="display: none;" src="<?php echo base_url('assets/img/gif/spinner.gif'); ?>">
						</center>
					</div>

				</div>
			</div>
<div class="box-preview" style="width: 100%;background: white;padding-top: 20px;display: none">
	<div class="row">
		<div class="col-md-12">
			<div class="col-md-2"></div>
			<div class="col-md-8">
				<div style="width: 100%;margin-bottom: 10px;">
					<h3 style="text-align: center;font-size: 20px;font-weight: bold;">
						LAPORAN HASIL KUNJUNGAN PEKERJA
					</h3>
				</div>
				<div style="width: 100%;margin-bottom: 10px;">

					<table width="100%;" border="1">
						<tr>
							<td style="width: 33%;font-weight: bold;padding: 5px;">No. Induk / Nama Petugas</td>
							<td style="width: 3%;text-align: center;font-weight: bold;">:</td>
							<td id="PvinfoPetugas" style="width: 64%;padding-left: 5px;"></td>
						</tr>
						<tr>
							<td style="width: 33%;font-weight: bold;padding: 5px;">Nama Pekerja yg dikunjungi</td>
							<td style="width: 3%;text-align: center;font-weight: bold;">:</td>
							<td id="PvnamaPekerja" style="width: 64%;padding-left: 5px;"></td>
						</tr>
						<tr>
							<td style="width: 33%;font-weight: bold;padding: 5px;">No. Induk</td>
							<td style="width: 3%;text-align: center;font-weight: bold;">:</td>
							<td id="PvnoIndukPekerja" style="width: 64%;padding-left: 5px;"></td>
						</tr>
						<tr>
							<td style="width: 33%;font-weight: bold;padding: 5px;">Seksi</td>
							<td style="width: 3%;text-align: center;font-weight: bold;">:</td>
							<td id="PvseksiPekerja" style="width: 64%;padding-left: 5px;"></td>
						</tr>
						<tr>
							<td style="width: 33%;font-weight: bold;padding: 5px;">Alamat</td>
							<td style="width: 3%;text-align: center;font-weight: bold;">:</td>
							<td id="PvalamatPekerja" style="width: 64%;padding-left: 5px;"></td>
						</tr>
						<tr>
							<td style="width: 33%;font-weight: bold;padding: 5px;">Diagnosa</td>
							<td style="width: 3%;text-align: center;font-weight: bold;">:</td>
							<td id="Pvdiagnosa" style="width: 64%;padding-left: 5px;"></td>
						</tr>
					</table>
				</div>

				<div style="width: 100%;height: 7%;border: 1px solid black;" >
					<div>
						<table width="100%" style="margin: 5px;">
							<thead><tr><th>Latar Belakang</th></tr></thead>
							<tbody id="PvlatarBelakang">
							</tbody>
						</table>
					</div>
				</div>

				<div style="width: 100%;height: 300px;border-left: 1px solid black;border-right: 1px solid black;border-bottom: 1px solid black">
					<div style="margin: 5px;">
					<p style="font-weight: bold;">Laporan Hasil Kunjungan : </p>
					<p class="Pvhasil_laporan"></p>
					</div>
				</div>

				<div style="margin-top: 40px;">
					<table style="width: 100%">
						<tr><td style="width: 33%"></td><td style="width: 33%;text-align: center;">Mengetahui,</td><td style="width: 33%;text-align: center;">Seksi Hubungan Kerja</td></tr>
						<tr><td height="60px"></td></tr>

						<tr><td style="width: 33%"></td><td id="Pvttdatasan" style="width: 33%;text-align: center;font-weight: bold;text-decoration: underline;"></td><td id="Pvttdpetugas" style="width: 33%;text-align: center;font-weight: bold;text-decoration: underline;"></td></tr>

						<tr><td style="width: 33%"></td><td id="Pvjabatasan" style="width: 33%;text-align: center;"></td><td style="width: 33%;text-align: center;">Petugas</td></tr>
					</table>
				</div>
			</div>
		</div>
	</div>

	<div class="row" style="margin-top: 20px;">
	<div class="col-md-12">
		<div class="col-md-2"></div>
		<div class="col-md-8" style="display: none;" id="divCetak">
			<center><button type="button" class="btn btn-primary btn-cetak btn-lg"><i class="fa fa-file-pdf-o">&nbsp;&nbsp;</i><b>Update</b></button></center>
		</div>
	</div>
	</div>


</div>
</div>




	</div>
</section>
