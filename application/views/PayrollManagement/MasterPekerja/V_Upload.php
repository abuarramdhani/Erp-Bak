<section class="content">
	<div class="inner" >
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11">
							<div class="text-right">
								<h2><b>Import Data Master Pekerja</b></h2>
							</div>
						</div>
					</div>
				</div>
				<br />
				<div class="row">
					<div class="col-lg-12">
					<div class="box box-primary box-solid">
						<div class="box-header with-border">
							<b>Data Master Pekerja dalam File</b>
						</div>
						
						<form method="post" action="<?php echo base_URL('PayrollManagement/MasterPekerja/importexist')?>">
						<div class="box-body">
							<div class="table-responsive">
								<table class="table table-striped table-bordered table-hover text-left" id="dataTables-masterPekerja" style="font-size:12px;">
									<thead class="bg-primary">
										<tr>
											<th style="text-align:center"><div style="width:40px"></div>NO</th>
											<th><div style="width:80px"></div>No Induk</th>
											<th><div style="width:80px"></div>Replace</th>
											<th><div style="width:50px"></div>Kode Hub Kerja</th>
											<th><div style="width:50px"></div>Kode Status Kerja</th>
											<th><div style="width:120px"></div>NIK</th>
											<th><div style="width:120px"></div>No KK</th>
											<th><div style="width:200px"></div>Nama</th>
											<th><div style="width:40px"></div>Id Kantor Asal</th>
											<th><div style="width:40px"></div>Id Lokasi Kerja</th>
											<th><div style="width:40px"></div>Jenis Kelamin</th>
											<th><div style="width:100px"></div>Tempat Lahir</th>
											<th><div style="width:120px"></div>Tanggal Lahir</th>
											<th><div style="width:350px"></div>Alamat</th>
											<th><div style="width:150px"></div>Desa</th>
											<th><div style="width:150px"></div>Kecamatan</th>
											<th><div style="width:150px"></div>Kabupaten</th>
											<th><div style="width:150px"></div>Provinsi</th>
											<th><div style="width:60px"></div>Kode Pos</th>
											<th><div style="width:120px"></div>No Hp</th>
											<th><div style="width:50px"></div>Gelar D</th>
											<th><div style="width:50px"></div>Gelar B</th>
											<th><div style="width:40px"></div>Pendidikan</th>
											<th><div style="width:200px"></div>Jurusan</th>
											<th><div style="width:300px"></div>Sekolah</th>
											<th><div style="width:50px"></div>Stat Nikah</th>
											<th><div style="width:120px"></div>Tanggal Nikah</th>
											<th><div style="width:50px"></div>Jumlah Anak</th>
											<th><div style="width:50px"></div>Jumlah Saudara</th>
											<th><div style="width:120px"></div>Diangkat</th>
											<th><div style="width:120px"></div>Masuk Kerja</th>
											<th><div style="width:50px"></div>Kodesie</th>
											<th><div style="width:50px"></div>Gol Kerja</th>
											<th><div style="width:50px"></div>Kode Asal Outsourcing</th>
											<th><div style="width:50px"></div>Kode Jabatan</th>
											<th><div style="width:500px"></div>Jabatan</th>
											<th><div style="width:200px"></div>NPWP</th>
											<th><div style="width:200px"></div>No KPJ</th>
											<th><div style="width:50px"></div>Lama Kontrak</th>
											<th><div style="width:120px"></div>Akhir Kontrak</th>
											<th><div style="width:100px"></div>Stat Pajak</th>
											<th><div style="width:50px"></div>Jt Anak</th>
											<th><div style="width:50px"></div>Jt Bukan Anak</th>
											<th><div style="width:120px"></div>Tanggal Spsi</th>
											<th><div style="width:200px"></div>No Spsi</th>
											<th><div style="width:120px"></div>Tanggal Kop</th>
											<th><div style="width:100px"></div>No Koperasi</th>
											<th><div style="width:40px"></div>Keluar</th>
											<th><div style="width:120px"></div>Tanggal Keluar</th>
											<th><div style="width:100px"></div>Kode Pkj</th>
											<th><div style="width:50px"></div>Angg Jkn</th>
										</tr>
									</thead>
									<tbody>
										<?php $no = 1; foreach($data_exist as $row) {?>
										<tr>
											<td align='center'><?php echo $no++;?></td>
											<td><input name="txtNoind[]" value="<?php echo $row['noind'] ?>" readonly/></td>
											<td>
												<select style="width:100%" name="replace[]" class="select2">
													<option value="yes" Selected>Yes</option>
													<option value="no">No</option>
                                                </select>
											</td>

											<td><input name="txtKdHubunganKerja[]" value="<?php echo $row['kd_hubungan_kerja'] ?>" readonly/></td>
											<td><input name="txtKdStatusKerja[]" value="<?php echo $row['kd_status_kerja'] ?>" readonly/></td>
											<td><input name="txtNik[]" value="<?php echo $row['nik'] ?>" readonly/></td>
											<td><input name="txtNoKk[]" value="<?php echo $row['no_kk'] ?>" readonly/></td>
											<td><input name="txtNama[]" value="<?php echo $row['nama'] ?>" readonly/></td>
											<td><input name="txtIdKantorAsal[]" value="<?php echo $row['id_kantor_asal'] ?>" readonly/></td>
											<td><input name="txtIdLokasiKerja[]" value="<?php echo $row['id_lokasi_kerja'] ?>" readonly/></td>
											<td><input name="txtJnsKelamin[]" value="<?php echo $row['jns_kelamin'] ?>" readonly/></td>
											<td><input name="txtTempatLahir[]" value="<?php echo $row['tempat_lahir'] ?>" readonly/></td>
											<td><input name="txtTglLahir[]" value="<?php echo $row['tgl_lahir'] ?>" readonly/></td>
											<td><input name="txtAlamat[]" value="<?php echo $row['alamat'] ?>" readonly/></td>
											<td><input name="txtDesa[]" value="<?php echo $row['desa'] ?>" readonly/></td>
											<td><input name="txtKecamatan[]" value="<?php echo $row['kecamatan'] ?>" readonly/></td>
											<td><input name="txtKabupaten[]" value="<?php echo $row['kabupaten'] ?>" readonly/></td>
											<td><input name="txtProvinsi[]" value="<?php echo $row['provinsi'] ?>" readonly/></td>
											<td><input name="txtKodePos[]" value="<?php echo $row['kode_pos'] ?>" readonly/></td>
											<td><input name="txtNoHp[]" value="<?php echo $row['no_hp'] ?>" readonly/></td>
											<td><input name="txtGelarD[]" value="<?php echo $row['gelar_d'] ?>" readonly/></td>
											<td><input name="txtGelarB[]" value="<?php echo $row['gelar_b'] ?>" readonly/></td>
											<td><input name="txtPendidikan[]" value="<?php echo $row['pendidikan'] ?>" readonly/></td>
											<td><input name="txtJurusan[]" value="<?php echo $row['jurusan'] ?>" readonly/></td>
											<td><input name="txtSekolah[]" value="<?php echo $row['sekolah'] ?>" readonly/></td>
											<td><input name="txtStatNikah[]" value="<?php echo $row['stat_nikah'] ?>" readonly/></td>
											<td><input name="txtTglNikah[]" value="<?php echo $row['tgl_nikah'] ?>" readonly/></td>
											<td><input name="txtJmlAnak[]" value="<?php echo $row['jml_anak'] ?>" readonly/></td>
											<td><input name="txtJmlSdr[]" value="<?php echo $row['jml_sdr'] ?>" readonly/></td>
											<td><input name="txtDiangkat[]" value="<?php echo $row['diangkat'] ?>" readonly/></td>
											<td><input name="txtMasukKerja[]" value="<?php echo $row['masuk_kerja'] ?>" readonly/></td>
											<td><input name="txtKodesie[]" value="<?php echo $row['kodesie'] ?>" readonly/></td>
											<td><input name="txtGolKerja[]" value="<?php echo $row['gol_kerja'] ?>" readonly/></td>
											<td><input name="txtKdAsalOutsourcing[]" value="<?php echo $row['kd_asal_outsourcing'] ?>" readonly/></td>
											<td><input name="txtKdJabatan[]" value="<?php echo $row['kd_jabatan'] ?>" readonly/></td>
											<td><input name="txtJabatan[]" value="<?php echo $row['jabatan'] ?>" readonly/></td>
											<td><input name="txtNpwp[]" value="<?php echo $row['npwp'] ?>" readonly/></td>
											<td><input name="txtNoKpj[]" value="<?php echo $row['no_kpj'] ?>" readonly/></td>
											<td><input name="txtLmKontrak[]" value="<?php echo $row['lm_kontrak'] ?>" readonly/></td>
											<td><input name="txtAkhKontrak[]" value="<?php echo $row['akh_kontrak'] ?>" readonly/></td>
											<td><input name="txtStatPajak[]" value="<?php echo $row['stat_pajak'] ?>" readonly/></td>
											<td><input name="txtJtAnak[]" value="<?php echo $row['jt_anak'] ?>" readonly/></td>
											<td><input name="txtJtBknAnak[]" value="<?php echo $row['jt_bkn_anak'] ?>" readonly/></td>
											<td><input name="txtTglSpsi[]" value="<?php echo $row['tgl_spsi'] ?>" readonly/></td>
											<td><input name="txtNoSpsi[]" value="<?php echo $row['no_spsi'] ?>" readonly/></td>
											<td><input name="txtTglKop[]" value="<?php echo $row['tgl_kop'] ?>" readonly/></td>
											<td><input name="txtNoKoperasi[]" value="<?php echo $row['no_koperasi'] ?>" readonly/></td>
											<td><input name="txtKeluar[]" value="<?php echo $row['keluar'] ?>" readonly/></td>
											<td><input name="txtTglKeluar[]" value="<?php echo $row['tgl_keluar'] ?>" readonly/></td>
											<td><input name="txtKdPkj[]" value="<?php echo $row['kd_pkj'] ?>" readonly/></td>
											<td><input name="txtAnggJkn[]" value="<?php echo $row['angg_jkn'] ?>" readonly/></td>

											</tr>
										<?php }?>
									</tbody>																			
								</table>
							</div>
							<div class="row">
								<div class="form-group">
									<div class="col-md-offset-10 col-md-2">
										<button class="btn btn-success btn-block" type="submit">Submit</button>
									</div>
								</div>
							</div>
						</div>
						</form>
					</div>
					</div>
				</div>	
			</div>
		</div>
	</div>
</section>