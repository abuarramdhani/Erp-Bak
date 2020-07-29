<style type="text/css">
	.select2 {
		width: 100% !important;
	}
</style>
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
										<form class="form-horizontal" method="POST" action="<?php echo site_url('MasterPekerja/Surat/PengalamanKerja/Simpan') ?>">
											<div class="form-group">
												<label class="control-label col-lg-4">Pekerja</label>
												<div class="col-lg-4">
													<select class="slcMPSuratPengalamanKerjaPekerja" data-placeholder="Pekerja" name="slcMPSuratPengalamanKerjaPekerja" id="slcMPSuratPengalamanKerjaPekerja" style="width: 100%" required></select>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Seksi</label>
												<div class="col-lg-4">
													<input type="text" name="txtMPSuratPengalamanKerjaSeksi" id="txtMPSuratPengalamanKerjaSeksi" class="form-control " placeholder="Seksi"  readonly required>
												</div>
											</div>
											<input type="hidden"  value="<?php echo $nomor['0']['tahun_bulan'] ?>"  name="txtMPSuratPengalamanKerjaKodeSurat" id="txtMPSuratPengalamanKerjaKodeSurat">
											<input type="hidden"  value="<?php echo $nomor['0']['no_selanjutnya'] ?>"  name="txtMPSuratPengalamanKerjaNoSurat" id="txtMPSuratPengalamanKerjaNoSurat">
											<input type="hidden"  value="<?php echo $nomor['0']['tanggal_surat'] ?>"  name="txtMPSuratPengalamanKerjaTanggalSurat" id="txtMPSuratPengalamanKerjaTanggalSurat">
											<input type="hidden" name="txtMPSuratPengalamanKerjaKodesie" id="txtMPSuratPengalamanKerjaKodesie">
											<div class="form-group">
												<label class="control-label col-lg-4">Bidang</label>
												<div class="col-lg-4">
													<input type="text" name="txtMPSuratPengalamanKerjaBidang" id="txtMPSuratPengalamanKerjaBidang" class="form-control " placeholder="Bidang"  readonly required>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Unit</label>
												<div class="col-lg-4">
													<input type="text" name="txtMPSuratPengalamanKerjaUnit" id="txtMPSuratPengalamanKerjaUnit" class="form-control " placeholder="Unit"  readonly required>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Departemen</label>
												<div class="col-lg-4">
													<input type="text" name="txtMPSuratPengalamanKerjaDept" id="txtMPSuratPengalamanKerjaDept" class="form-control " placeholder="Departemen"  readonly required>
												</div>
											</div>
											<!--<div class="form-group">
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
													<input type="text" name="txtMPSuratPengalamanKerjaMasuk" id="txtMPSuratPengalamanKerjaMasuk" class="form-control " placeholder="Masuk Kerja"  readonly required>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Sampai</label>
												<div class="col-lg-4">
													<select name="txtMPSuratPengalamanKerjaSampai" id="txtMPSuratPengalamanKerjaSampai" class="form-control ">
    															<option value=""></option>
    															
    												</select>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Alamat</label>
												<div class="col-lg-4">
													<input type="text" name="txtMPSuratPengalamanKerjaAlamat" id="txtMPSuratPengalamanKerjaAlamat" class="form-control " placeholder="Alamat"   required>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Desa</label>
												<div class="col-lg-4">
													<input type="text" name="txtMPSuratPengalamanKerjaDesa" id="txtMPSuratPengalamanKerjaDesa" class="form-control " placeholder="Desa"  readonly required>
												</div>
											</div>
                                            <div class="form-group">
												<label class="control-label col-lg-4">Kabupaten</label>
												<div class="col-lg-4">
													<input type="text" name="txtMPSuratPengalamanKerjaKab" id="txtMPSuratPengalamanKerjaKab" class="form-control " placeholder="Kabupaten" readonly   required>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Kecamatan</label>
												<div class="col-lg-4">
													<input type="text" name="txtMPSuratPengalamanKerjaKec" id="txtMPSuratPengalamanKerjaKec" class="form-control " placeholder="Kecamatan"  readonly  required>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">NIK</label>
												<div class="col-lg-4">
													<input type="text" name="txtMPSuratPengalamanKerjaNIK" id="txtMPSuratPengalamanKerjaNIK" class="form-control " placeholder="NIK"  readonly  required>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Template Isi</label>
												<div class="col-lg-4">
													<select class="form-control select4" id="pengalaman" name="TxtIsiSuratPengalaman" data-placeholder="Pilih isi surat" required>
											             <option></option>
										               <?php foreach ($isisuratpengalaman as $isi) {?>
											            <option value="<?php echo $isi['kd_isi']?>"><?php echo $isi['kd_isi']?></option>
										             <?php }?>
									                     </select>
												</div>
												<div class="col-lg-2">
                                                  <button type="button" data-toggle="modal" data-target="#modalTemplateIsi" class="btn btn-default btn-sm"><i class="fa fa-plus"></i></button>
                                                </div>
											</div>
											
											<div class="form-group">
											  <label class="control-label col-lg-4"> Isi</label>
												<div class="col-lg-6">
                                                            <textarea required class="redactor MasterPekerja-Surat-txaPreview" name="txaPreview" id=""></textarea>
                                                 </div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Pengembalian ADP</label>
												<div class="col-lg-4">
													<input type="text" name="txtMPSuratPengalamanKerjaAPD" id="txtMPSuratPengalamanKerjaAPD" class="form-control " placeholder="Pengembalian APD"  readonly  required>
												</div>
											</div>
											<div class="form-group">
												<div class="col-lg-6 text-right">
													<button class="btn btn-primary" id="btnMPSuratPengalamanKerjaSubmit" type="submit" ><span class="fa fa-save"></span>&nbsp;Simpan</button>
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
		</div>
	</div>
</section>


<!-- Modal Loading -->
<div class="modal fade" id="modalTemplateIsi" role="dialog" aria-labelledby="loadMeLabel">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Tambah Template Isi</h4>
      </div>
      <div class="modal-body">
        <div class="loader"></div>
        <div clas="loader-txt">
          <div class="form-group">
	          <div class="col-lg-12">
	            <label class="control-label col-lg-3">Template Isi</label>
	            <div class="col-lg-9">
	                <select class="form-control" id="template" name="TxtTemplateSuratPengalaman" data-placeholder="Pilih isi surat" required>
						<option></option>
						<?php foreach ($isisuratpengalaman as $isi) {?>
						<option value="<?php echo $isi['kd_isi']?>"><?php echo $isi['kd_isi']?></option>
						<?php }?>
					</select>
					<input class="form-control hidden" id="template_name" placeholder="Masukkan nama template"></input>
	            </div>
	          </div>

	          <div class="col-md-12">
	         	<label class="control-label col-lg-3"> Isi</label>
				<div class="col-lg-9">
	                <textarea required readonly class="redactor form-control MasterPekerja-SuratPengalaman-txaPreview" name="txaPreviewne" id="template_content"></textarea>
	            </div>
	          </div>
	        </div>
          <div class="text-center">
            <button class="btn btn-primary" type="button" onclick="addTemplateSatuan()" id="btn-addSatuan" name="button">
            	 Tambah
            </button>
            <button class="btn btn-primary hidden" type="button" data-action="save" id="btn-saveSatuan" name="button">
            	 Simpan
            </button>
            <button class="btn btn-primary" type="button" onclick="editTemplateSatuan()" id="btn-editSatuan" name="button">
            	 Edit
            </button>
            <button class="btn btn-primary hidden" type="button" onclick="batalTemplateSatuan()" id="btn-batalSatuan" name="button">
            	 Batal
            </button>
            <button class="btn btn-primary" type="button" onclick="deleteTemplateSatuan()" id="btn-deleteSatuan" name="button">
            	Delete
            </button>
          </div>
        </div>
      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
        </div>
    </div>
  </div>
</div>
<!-- End Modal -->

<script type="text/javascript">
	// plugin init
	$(window).load(() => {
		$('#template').select2()
		//$('#template_content').redactor('core.editor').attr('contenteditable', 'false');
	})

	function request_edit(kd_isi, isi_surat) {
		$.ajax({
			url: baseurl + 'MasterPekerja/Surat/PengalamanKerja/edit_template',
			method: 'POST',
			data: {
				kd_isi,
				isi_surat
			},
			success() {
				$('#btn-saveSatuan').addClass('hidden')
				$('#btn-batalSatuan').addClass('hidden')
				$('#btn-addSatuan').removeClass('hidden')
				$('#btn-editSatuan').removeClass('hidden')

				$('#template').next('.select2-container').removeClass('hidden')
				$('#template_name').addClass('hidden')

				$('#template_content').prop('disabled', true)
			}
		})
	}

	function request_save(kd_isi, isi_surat) {
		$.ajax({
			url: baseurl + 'MasterPekerja/Surat/PengalamanKerja/add_template',
			method: 'POST',
			data: {
				kd_isi,
				isi_surat
			},
			success() {
				$('#btn-saveSatuan').addClass('hidden')
				$('#btn-batalSatuan').addClass('hidden')
				$('#btn-addSatuan').removeClass('hidden')
				$('#btn-editSatuan').removeClass('hidden')

				$('#template').next('.select2-container').removeClass('hidden')
				$('#template_name').addClass('hidden')

				$('#template_content').prop('disabled', true)
				$('#template').append(`<option value="${kd_isi}">${isi_surat}</option>`)
				$('#template_content').redactor('set', '')

			}
		})
	}

	// toogle list and add view
	function toggle() {
		$('#btn-batalSatuan').toggleClass('hidden')
		$('#btn-addSatuan').toggleClass('hidden')
		$('#btn-editSatuan').toggleClass('hidden')
		$('#btn-saveSatuan').toggleClass('hidden')
		$('#template').next('.select2-container').toggleClass('hidden')
	}

	// button tambah
	function addTemplateSatuan() {
		// show simpan, show batal
		$('#template').addClass('hidden') //select2
		$('#template_name').removeClass('hidden') // inputbox
		$('#btn-batalSatuan').removeClass('hidden')
		$('#btn-saveSatuan').removeClass('hidden')
		$('#btn-addSatuan').addClass('hidden')
		$('#btn-editSatuan').addClass('hidden')
		$('#template').next('.select2-container').addClass('hidden')

		$('#template_content').val('')
		$('#template_name').val('')

		$('#template_content').prop('disabled', false)
		$('btn-saveSatuan').data('action', 'save')
		$('#template_content').redactor('set', '')

	}

	// button edit
	function editTemplateSatuan() {
		// show simpan, show batal
		$('#template').removeClass('hidden')
		$('#btn-addSatuan').addClass('hidden')
		$('#btn-editSatuan').addClass('hidden')
		$('#btn-batalSatuan').removeClass('hidden')
		$('#btn-saveSatuan').removeClass('hidden')

		$('#btn-saveSatuan').data('action', 'edit')
	}

	// button simpan, -> tambah / edit
	$('#btn-saveSatuan').on('click', function() {
		const action = $(this).data('action')

		const template = $('#template').val()
		const template_name = $('#template_name').val()
		const template_content = $('#template_content').val()

		console.log(template, template_name, template_content)
		if(action === 'save') {
			if(!template_name || !template_content) return
			request_save(template_name, template_content)
		} else if(action === 'edit') {
			if(!template || !template_content) return
			request_edit(template, template_content)
		}
	})

	// button delete
	function deleteTemplateSatuan() {
		const template_name = $('#template').val()

		if(!template_name ) return

		swal.fire({
			title: 'Apakah anda yakin untuk menghapus template ini ?',
			text: '',
			showCancelButton: true,
			type: 'question'
		}).then(({  value }) => {
			if(!value) return 

			$.ajax({
				url: baseurl + 'MasterPekerja/Surat/PengalamanKerja/delete_template',
				method: 'POST',
				data: {
					kd_isi: template_name
				},
				success() {
					$('#template_content').redactor('set', '')
					$(`#template option[value="${template_name}"]`).remove()
					$('#template').val('').trigger('change')
				}
			})
		})
	}

	// button batal
	function batalTemplateSatuan() {
		// hide simpan, batal
		$('#btn-batalSatuan').addClass('hidden')
		$('#btn-saveSatuan').addClass('hidden')
		$('#btn-addSatuan').removeClass('hidden')
		$('#btn-editSatuan').removeClass('hidden')
		$('#template').next('.select2-container').removeClass('hidden')
		$('#template_name').addClass('hidden')
	}
</script>
