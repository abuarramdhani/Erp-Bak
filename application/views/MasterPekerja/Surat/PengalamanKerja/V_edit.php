<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<br><h1><?=$Title ?></h1></div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header with-border">
							</div>
							<div class="box-body">
								<div class="row">
									<div class="col-lg-12">
										<?php 
										if (isset($data) && !empty($data)) {
											foreach ($data as $dt) {
												?>
										<form class="form-horizontal" method="POST" action="<?php echo site_url('MasterPekerja/Surat/PengalamanKerja/Update/'.$datane) ?>">
											<div class="form-group">
												<label class="control-label col-lg-4">Pekerja</label>
												<div class="col-lg-4">
													<select class="slcMPSuratPengalamanKerjaPekerja" data-placeholder="Pekerja" name="slcMPSuratPengalamanKerjaPekerja" id="slcMPSuratPengalamanKerjaPekerja" style="width: 100%" required>
													<option value="<?php echo $dt['noind'] ?>"><?php echo $dt['noind'].' - '.$dt['nama'] ?></option>
													</select>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Seksi</label>
												<div class="col-lg-4">
													<input type="text" name="txtMPSuratPengalamanKerjaSeksi" id="txtMPSuratPengalamanKerjaSeksi" class="form-control " value="<?php echo $dt['seksi'] ?>" placeholder="Seksi"  readonly required>
												</div>
											</div>
											<input type="hidden"  value="<?php echo $dt['kd_surat'] ?>"  name="txtMPSuratPengalamanKerjaKodeSurat" id="txtMPSuratPengalamanKerjaKodeSurat">
											<input type="hidden"  value="<?php echo $dt['no_surat'] ?>"  name="txtMPSuratPengalamanKerjaNoSurat" id="txtMPSuratPengalamanKerjaNoSurat">
											<input type="hidden"  value="<?php echo $dt['tgl_surat'] ?>"  name="txtMPSuratPengalamanKerjaTanggalSurat" id="txtMPSuratPengalamanKerjaTanggalSurat">
											<input type="hidden" name="txtMPSuratPengalamanKerjaKodesie" id="txtMPSuratPengalamanKerjaKodesie" value="<?php echo $dt['kodesie'] ?>">
											<input type="hidden"  value="<?php echo $dt['cetak'] ?>"  name="txtMPSuratPengalamanKerjaCetak" id="txtMPSuratPengalamanKerjaCetak">
											<input type="hidden"  value="<?php echo $dt['tgl_cetak'] ?>"  name="txtMPSuratPengalamanKerjaTglCetak" id="txtMPSuratPengalamanKerjaTglCetak">
											<div class="form-group">
												<label class="control-label col-lg-4">Bidang</label>
												<div class="col-lg-4">
													<input type="text" name="txtMPSuratPengalamanKerjaBidang" id="txtMPSuratPengalamanKerjaBidang" class="form-control "  value="<?php echo $dt['bidang'] ?>" placeholder="Bidang"  readonly required>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Unit</label>
												<div class="col-lg-4">
													<input type="text" name="txtMPSuratPengalamanKerjaUnit" id="txtMPSuratPengalamanKerjaUnit" class="form-control "  value="<?php echo $dt['unit'] ?>" placeholder="Unit"  readonly required>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Departemen</label>
												<div class="col-lg-4">
													<input type="text" name="txtMPSuratPengalamanKerjaDept" id="txtMPSuratPengalamanKerjaDept" class="form-control "  value="<?php echo $dt['dept'] ?>" placeholder="Departemen"  readonly required>
												</div>
											</div>
											<!-- 
											<div class="form-group">
												<label class="control-label col-lg-4">Jabatan</label>
												<div class="col-lg-4">
													<select name="txtMPSuratPengalamanKerjaJabatan" id="txtMPSuratPengalamanKerjaJabatan" class="form-control ">
    															
    															<option value=""></option>
    												</select>
												</div>
											</div>
											-->
											<div class="form-group">
												<label class="control-label col-lg-4">Masuk</label>
												<div class="col-lg-4">
													<input type="text" name="txtMPSuratPengalamanKerjaMasuk" id="txtMPSuratPengalamanKerjaMasuk" class="form-control "   value="<?php echo $dt['masukkerja'] ?>" placeholder="Masuk Kerja"  readonly required>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Sampai</label>
												<div class="col-lg-4">
													<select name="txtMPSuratPengalamanKerjaSampai" id="txtMPSuratPengalamanKerjaSampai" class="form-control ">
													            <option value="<?php echo $dt['tgl_kena'] ?>"><?php echo $dt['tgl_kena'] ?></option>
    															<option value="1900-01-01" <?php if ($dt['tgl_kena'] == '1900-01-01'){ echo 'selected'; } ?>>Tanggal dibuatnya surat keterangan ini dan masih bekerja</option>
    												</select>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Alamat</label>
												<div class="col-lg-4">
													<input type="text" name="txtMPSuratPengalamanKerjaAlamat" id="txtMPSuratPengalamanKerjaAlamat" class="form-control "  value="<?php echo $dt['alamat'] ?>" placeholder="Alamat"   required>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Desa</label>
												<div class="col-lg-4">
													<input type="text" name="txtMPSuratPengalamanKerjaDesa" id="txtMPSuratPengalamanKerjaDesa" class="form-control "  value="<?php echo $dt['desa'] ?>" placeholder="Desa"  readonly required>
												</div>
											</div>
                                            <div class="form-group">
												<label class="control-label col-lg-4">Kabupaten</label>
												<div class="col-lg-4">
													<input type="text" name="txtMPSuratPengalamanKerjaKab" id="txtMPSuratPengalamanKerjaKab" class="form-control " value="<?php echo $dt['kab'] ?>" placeholder="Kabupaten" readonly   required>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Kecamatan</label>
												<div class="col-lg-4">
													<input type="text" name="txtMPSuratPengalamanKerjaKec" id="txtMPSuratPengalamanKerjaKec" class="form-control " value="<?php echo $dt['kec'] ?>" placeholder="Kecamatan"  readonly  required>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">NIK</label>
												<div class="col-lg-4">
													<input type="text" name="txtMPSuratPengalamanKerjaNIK" id="txtMPSuratPengalamanKerjaNIK" class="form-control " value="<?php echo $dt['nik'] ?>" placeholder="NIK"  readonly  required>
												</div>
											</div>
											<!--<div class="form-group">
												<label class="control-label col-lg-4">Template Isi</label>
												<div class="col-lg-4">
													<select  class="form-control select4" id="pengalaman" name="TxtIsiSuratPengalaman" data-placeholder="Pilih isi surat" required>
											             <option></option>
										               <?php foreach ($isisuratpengalaman as $isi) {?>
											            <option value="<?php echo $isi['kd_isi']?>"><?php echo $isi['kd_isi']?></option>
										             <?php }?>
									                     </select>
												</div>
											</div>
											-->
											<div class="form-group">
											  <label class="control-label col-lg-4"> Isi</label>
												<div class="col-lg-6">
                                                            <textarea required class="redactor MasterPekerja-Surat-txaPreview"  name="txaPreview" id="" >
                                                            	<?php echo $dt['isi_surat'] ?>
                                                            </textarea>
                                                 </div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Pengembalian ADP</label>
												<div class="col-lg-4">
													<input type="text" name="txtMPSuratPengalamanKerjaAPD" id="txtMPSuratPengalamanKerjaAPD" class="form-control "  value="<?php echo $dt['apd'] ?>"placeholder="Pengembalian APD"  readonly  required>
												</div>
											</div>
											<div class="form-group">
												<div class="col-lg-6 text-right">
													<button class="btn btn-primary" id="btnMPSuratPengalamanKerjaSubmit" type="submit" ><span class="fa fa-save"></span>&nbsp;Simpan</button>
												</div>
											</div>
										</form>
												<?php
											}
										}
										?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
					