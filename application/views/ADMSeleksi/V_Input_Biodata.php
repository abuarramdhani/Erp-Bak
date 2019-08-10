<style type="text/css">
	.as_label{
		color: red;
		font-style: italic;
		font-size: 12px;
	}
	.as_span{
		color: red;
		font-style: italic;
		font-size: 12px;
		padding-left: 15px;
	}
</style>
<section class="content">
	<div class="inner" >
		<div class="row">
			<div class="col-lg-12">
				<div class="col-lg-11">
					<div class="text-right">
						<h1><b>Input Biodata</b></h1>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11"></div>
						<div class="col-lg-1 "></div>
					</div>
				</div>
				<br />
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header with-border"></div>
							<div class="box-body">
								<form method="post" class="form-horizontal" action="<?php echo site_url('ADMSeleksi/Menu/SubmitBiodata'); ?>">
									<div class="panel-body">
										<div class="col-md-12">
											<div style="font-weight: bold; margin-bottom: 1px solid;">
												<h2>IDENTITAS</h2>
											</div>
											<div class="row">
												<div class="col-md-12 form-group" style="margin-top: 10px;">
													<label style="margin-top: 5px;" class="col-sm-2 col-form-label" for="name">NIK / No. KTP</label>
													<div class="col-md-6">
														<input minlength="16" placeholder="NIK / No. KTP" id="input_KTP" class="form-control valKTP" name="nik">
													</div>
													<div style="margin-top: 5px;">
														<span id="as_alert_nik"></span>
													</div>
												</div>
												<div class="col-md-12 form-group" style="margin-top: 10px;">
													<label style="margin-top: 5px;" class="col-sm-2 col-form-label" for="name">Nama</label>
													<div class="col-md-6">
														<input placeholder="Nama" name="nama" oninput="this.value = this.value.toUpperCase()" class="form-control">
														<span class="as_label">* isi sesuai KTP</span>
													</div>
												</div>
												<div class="col-md-12 form-group" style="margin-top: 10px;">
													<label style="margin-top: 5px;" class="col-sm-2 col-form-label" for="name">Email</label>
													<div class="col-md-6">
														<input placeholder="Email" type="email" name="email" class="form-control">
													</div>
												</div>
												<div class="col-md-12 form-group" style="margin-top: 10px;">
													<label style="margin-top: 5px;" class="col-sm-2 col-form-label" for="name">Tempat Lahir</label>
													<div class="col-md-6">
														<select name="tmp_lahir" class="form-control bio_tempat_lahir">
															<option></option>
														</select>
													</div>
												</div>
												<div class="col-md-12 form-group" style="margin-top: 10px;">
													<label style="margin-top: 5px;" class="col-sm-2 col-form-label" for="name">Tanggal Lahir</label>
													<div class="col-md-6">
														<input name="tgl_lahir" class="form-control as_tglLahir" placeholder="DD/MM/YYYY">
													</div>
												</div>
												<div class="col-md-12 form-group" style="margin-top: 10px;">
													<label style="margin-top: 5px;" class="col-sm-2 col-form-label" for="name">Jenis Kelamin</label>
													<div class="col-md-6">
														<div class="col-md-6">
															<label><input value="Laki-Laki" type="radio" name="jen_kel" class="form-control"> Laki - laki</label>
														</div>
														<div class="col-md-6">
															<label><input value="Perempuan" type="radio" name="jen_kel" class="form-control"> Perempuan</label>
														</div>
													</div>
												</div>
												<div class="col-md-12 form-group" style="margin-top: 10px;">
													<label style="margin-top: 5px;" class="col-sm-2 col-form-label" for="name">Agama</label>
													<div class="col-md-6">
														<select name="agama" class="form-control as_agama">
															<option value=""></option>
															<option value="islam">ISLAM</option>
															<option value="kristen">KRISTEN</option>
															<option value="katholik">KATHOLIK</option>
															<option value="hindu">HINDU</option>
															<option value="budha">BUDHA</option>
															<option value="konghucu">KONGHUCU</option>
														</select>
													</div>
												</div>
												<div class="col-md-12 form-group" style="margin-top: 10px;">
													<label style="margin-top: 5px;" class="col-sm-2 col-form-label" for="name">Alamat</label>
													<div class="col-md-6">
														<textarea oninput="this.value = this.value.toUpperCase()" placeholder="Alamat" class="form-control" name="alamat"></textarea>
													</div>
												</div>
												<div class="col-md-12 form-group" style="margin-top: 10px;">
													<label style="margin-top: 5px;" class="col-sm-2 col-form-label" for="name">Kota</label>
													<div class="col-md-6">
														<select name="kota" class="form-control select-kota2">
															<option></option>
														</select>
													</div>
												</div>
												<div class="col-md-12 form-group" style="margin-top: 10px;">
													<label style="margin-top: 5px;" class="col-sm-2 col-form-label" for="name">Nomor Hp</label>
													<div class="col-md-6">
														<input id="as_noHP" name="no_hp" value="" placeholder="+6283333469xxxx" class="form-control valHp" minlength="5">
													</div>
												</div>
												<!-- <div class="col-md-12">
												<input type="checkbox" id="as_checkNoHp"><span class="as_span"> )* jika nomor whatsapp sama dengan nomor hp</span>
											</div> -->
											<div class="col-md-12 form-group" style="margin-top: 10px;">
												<span class="as_span"><input type="checkbox" id="as_checkNoHp">  )* jika nomor whatsapp sama dengan nomor hp</span>
												<br>
												<label style="margin-top: 5px;" class="col-sm-2 col-form-label" for="name">Nomor WhatsApp</label>
												<div class="col-md-6">
													<input id="as_noWA" name="no_wa" value="" placeholder="+6283333469xxxx" class="form-control valHp" minlength="5">
												</div>
											</div>
										</div>
										<div style="font-weight: bold;">
											<h2>Pendidikan</h2>
										</div>
										<div class="row">
											<div class="col-md-12 form-group" style="margin-top: 10px;">
												<label style="margin-top: 5px;" class="col-sm-2 col-form-label" for="name">Tingkat Pendidikan</label>
												<div class="col-md-6">
													<select name="pendidikan" class="form-control as_select_pendidikan" id="as_pendidikan">
														<option></option>
													</select>
												</div>
											</div>
											<div class="col-md-12 form-group" style="margin-top: 10px;">
												<label style="margin-top: 5px;" class="col-sm-2 col-form-label" for="name">Institusi</label>
												<div class="col-md-6">
													<select class="form-control as_select_institusi" name="institusi">
														<option></option>
													</select>
													<span class="as_label">*apabila institusi tidak ada silahkan isi sendiri</span>
												</div>
											</div>
											<div class="col-md-12 form-group" style="margin-top: 10px;">
												<label style="margin-top: 5px;" class="col-sm-2 col-form-label" for="name">Jurusan</label>
												<div class="col-md-6">
													<select name="jurusan" class="form-control as_select_jurusan">
														<option></option>
													</select>
													<span class="as_label">*apabila jurusan tidak ada silahkan isi sendiri</span>
												</div>
											</div>
											<div class="col-md-12 form-group" style="margin-top: 10px;">
												<label style="margin-top: 5px;" class="col-sm-2 col-form-label" for="name">Status Ijazah</label>
												<div class="col-md-6">
													<div class="col-md-4">
														<label><input value="BL" type="radio" id="as_bl" name="ijazah" class="form-control rd_ijazah"> Belum Lulus</label>
													</div>
													<div class="col-md-3">
														<label><input value="SK" type="radio" id="as_sk" name="ijazah" class="form-control rd_ijazah"> SK</label>
													</div>
													<div class="col-md-3">
														<label><input value="Ijazah" type="radio" id="as_ijazah" name="ijazah" class="form-control rd_ijazah"> Ijazah</label>
													</div>
												</div>
											</div>
											<div class="col-md-12 form-group" style="margin-top: 10px;">
												<label style="margin-top: 5px;" class="col-sm-2 col-form-label" for="name">Nomor Ijazah</label>
												<div class="col-md-6">
													<input id="as_noIjazah" name="no_ijazah" class="form-control" placeholder="254/S-1/TN/XVII/TI/301/20">
												</div>
											</div>
											<div class="col-md-12 form-group" style="margin-top: 10px;">
												<label style="margin-top: 5px;" class="col-sm-2 col-form-label" for="name">Nilai / IPK</label>
												<div class="col-md-6">
													<input id="as_nilaiIjazah" name="nilai_ijazah" class="form-control valNilaiIjazah" placeholder="Nilai">
												</div>
											</div>
										</div>
										<div style="font-weight: bold;">
											<h2>POSISI YANG DIINGINKAN</h2>
										</div>
										<div class="row">
											<div class="col-md-12 form-group" style="margin-top: 10px;">
												<label style="margin-top: 5px;" class="col-sm-2 col-form-label" for="name">Penempatan</label>
												<div class="col-md-6">
													<select name="penempatan" class="form-control as_select_penempatan">
														<option></option>
													</select>
												</div>
											</div>
											<div class="col-md-12 form-group" style="margin-top: 10px;">
												<label style="margin-top: 5px;" class="col-sm-2 col-form-label" for="name">Pekerjaan</label>
												<div class="col-md-6">
													<select name="pekerjaan" class="form-control as_select_pekerjaan" disabled="">
														<option></option>
													</select>
												</div>
											</div>
										</div>
										<br>
										<br>
										<div class="col-md-12 text-center">
											<button type="button" class="btn btn-success btn-lg" id="as_btn_submit">Submit</button>
											<button type="submit" hidden="" class="" id="as_btn_submit_true">Submit</button>
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
</div>
</section>
<div id="surat-loading" style="top: 0;left: 0;right: 0;bottom: 0; margin: auto; position: fixed; background: rgba(0,0,0,.5); z-index: 11;" hidden="hidden">
	<img src="http://erp.quick.com/assets/img/gif/loadingtwo.gif" style="position: fixed; top: 0;left: 0;right: 0;bottom: 0; margin: auto; width: 40%;">
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$('input').attr('required', true);
		$('input:checkbox').attr('required', false);
		$('select').attr('required', true);
		$('input').css('width', '100%');
		$('select').css('width', '100%');
	});
	function setInputFilter(textbox, inputFilter) {
		["input", "keydown", "keyup", "mousedown", "mouseup", "select", "contextmenu", "drop"].forEach(function(event) {
			textbox.addEventListener(event, function() {
				if (inputFilter(this.value)) {
					this.oldValue = this.value;
					this.oldSelectionStart = this.selectionStart;
					this.oldSelectionEnd = this.selectionEnd;
				} else if (this.hasOwnProperty("oldValue")) {
					this.value = this.oldValue;
					this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
				}
			});
		});
	}
	//plugin dari https://jsfiddle.net/emkey08/zgvtjc51

	// Install input filters.
	setInputFilter(document.getElementById("input_KTP"), function(value) {
		return /^\d*$/.test(value); });
</script>