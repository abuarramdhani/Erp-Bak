$(document).ready(function(){

	$('.select-nama').select2({
		ajax: {
			url: baseurl+"MasterPekerja/Other/pekerja",
			dataType: 'json',
			type: "get",
			data: function (params) {
				return { p: params.term };
			},
			processResults: function (data) {
				return {
					results: $.map(data, function (item) {
						return {
							id: item.noind,
							text: item.noind+' - '+item.nama,
						}
					})
				};
			},
			cache: true
		},
		minimumInputLength: 2,
		placeholder: 'Select Nama Pekerja',
		allowClear: false,
	});

	$(function() {
		$('#tabel-idcard').DataTable( {
			dom: 'frt',
		});
	});

	function SelectNama(){
		var val = $('#NamaPekerja').val();
		if (val) {
			$('#CariPekerja').removeAttr('disabled', 'disabled');
			$('#CariPekerja').removeClass('disabled'); 
		}else{
			$('#CariPekerja').attr('disabled', 'disabled');
			$('#CariPekerja').addClass('disabled', 'disabled');
		}
	}

	$(document).on('change', '#NamaPekerja', function() {
		SelectNama();
	});

	$(document).on('click', '#CariPekerja', function(e){
		e.preventDefault();
		var nama = $('#NamaPekerja').val();

		$.ajax({
			url: baseurl+"MasterPekerja/Other/DataIDCard",
			type: "get",
			data: {nama: nama}
		}).done(function(data){
			var html = '';
			var data = $.parseJSON(data);

			console.log(data['worker']);
			$('tbody#dataIDcard').empty(html);
			for (var i = 0; i < data['worker'].length; i++) {
				html += '<tr>';
				html += '<td>'+(i+1)+'</td>';
				html += '<td>'+data['worker'][i][0]['no_induk']+'<input type="hidden" name="noind[]" value="'+data['worker'][i][0]['noind']+'"></td>';
				html += '<td>'+data['worker'][i][0]['nama']+'</td>';
				if (data['worker'][i][0]['jabatan']!=null) {
					html += '<td>'+data['worker'][i][0]['jabatan']+' '+data['worker'][i][0]['seksi']+'</td>';
				}else{
					html += '<td>'+data['worker'][i][0]['seksi']+'</td>';
				}
				html += '<td><a target="_blank" href="'+data['worker'][i][0]['photo']+'">PHOTO</td>';
				html += '<td><input type="text" style="text-transform:uppercase" data-noind="'+data['worker'][i][0]['noind']+'" class="form-control" name="nick[]" id="nickname" maxlength="10"></td>'
				html += '</tr>';
			}
			$('tbody#dataIDcard').append(html);
			$('#tampil-data').removeClass('hidden');
			$('#print_card').removeAttr('disabled',false);
			$('#print_card').removeClass('disabled');
		})
	});

});

// 	-------Master Pekerja--------------------------------------------start
$(function()
{
		// 	Surat-surat
		// 	{
				//	DateRangePicker
				//	{
					$('.MasterPekerja-daterangepicker').daterangepicker({
						"showDropdowns": true,
						"autoApply": true,
						"locale": {
							"format": "YYYY-MM-DD",
							"separator": " - ",
							"applyLabel": "OK",
							"cancelLabel": "Batal",
							"fromLabel": "Dari",
							"toLabel": "Hingga",
							"customRangeLabel": "Custom",
							"weekLabel": "W",
							"daysOfWeek": [
							"Mg",
							"Sn",
							"Sl",
							"Rb",
							"Km",
							"Jm",
							"Sa"
							],
							"monthNames": [
							"Januari",
							"Februari",
							"Maret",
							"April",
							"Mei",
							"Juni",
							"Juli",
							"Agustus ",
							"September",
							"Oktober",
							"November",
							"Desember"
							],
							"firstDay": 1
						}
					}, function(start, end, label) {
						console.log("New date range selected: ' + start.format('YYYY-MM-DD H:i:s') + ' to ' + end.format('YYYY-MM-DD H:i:s') + ' (predefined range: ' + label + ')");
					});

					$('.MasterPekerja-daterangepickersingledate').daterangepicker({
						"singleDatePicker": true,
						"showDropdowns": true,
						"autoApply": true,
						"mask": true,
						"locale": {
							"format": "YYYY-MM-DD",
							"separator": " - ",
							"applyLabel": "OK",
							"cancelLabel": "Batal",
							"fromLabel": "Dari",
							"toLabel": "Hingga",
							"customRangeLabel": "Custom",
							"weekLabel": "W",
							"daysOfWeek": [
							"Mg",
							"Sn",
							"Sl",
							"Rb",
							"Km",
							"Jm",
							"Sa"
							],
							"monthNames": [
							"Januari",
							"Februari",
							"Maret",
							"April",
							"Mei",
							"Juni",
							"Juli",
							"Agustus ",
							"September",
							"Oktober",
							"November",
							"Desember"
							],
							"firstDay": 1
						}
					}, function(start, end, label) {
						console.log("New date range selected: ' + start.format('YYYY-MM-DD H:i:s') + ' to ' + end.format('YYYY-MM-DD H:i:s') + ' (predefined range: ' + label + ')");
					});

					$('.MasterPekerja-daterangepickersingledatewithtime').daterangepicker({
						"timePicker": true,
						"timePicker24Hour": true,
						"singleDatePicker": true,
						"showDropdowns": true,
						"autoApply": true,
						"locale": {
							"format": "YYYY-MM-DD HH:mm",
							"separator": " - ",
							"applyLabel": "OK",
							"cancelLabel": "Batal",
							"fromLabel": "Dari",
							"toLabel": "Hingga",
							"customRangeLabel": "Custom",
							"weekLabel": "W",
							"daysOfWeek": [
							"Mg",
							"Sn",
							"Sl",
							"Rb",
							"Km",
							"Jm",
							"Sa"
							],
							"monthNames": [
							"Januari",
							"Februari",
							"Maret",
							"April",
							"Mei",
							"Juni",
							"Juli",
							"Agustus ",
							"September",
							"Oktober",
							"November",
							"Desember"
							],
							"firstDay": 1
						}
					}, function(start, end, label) {
						console.log("New date range selected: ' + start.format('YYYY-MM-DD H:i:s') + ' to ' + end.format('YYYY-MM-DD H:i:s') + ' (predefined range: ' + label + ')");
					});
				//	}
				//  select3
				$('.MasterPekerja-PerhitunganPesangon-DaftarPekerja').select2(
				{
					allowClear: false,
					placeholder: "Pilih Pekerja",
					minimumInputLength: 3,
					ajax: 
					{
						url: baseurl+'MasterPekerja/PerhitunganPesangon/daftar_pekerja_aktif',
						dataType: 'json',
						delay: 500,
						data: function (params){
							return {
								term: params.term
							}
						},
						processResults: function(data) {
							return {
								results: $.map(data, function(obj){
									return {id: obj.noind, text: obj.pekerja};
								})
							};
						}
					}
				});

				$('#MasterPekerja-PerhitunganPesangon-DaftarPekerja').change(function(){
					var noind = $('#MasterPekerja-PerhitunganPesangon-DaftarPekerja').val();
					if(noind)
					{
						$.ajax({
							type:'POST',
							data:{noind: noind},
							url:baseurl+"MasterPekerja/PerhitunganPesangon/detailPekerja",
							success:function(result)
							{
								var res = JSON.parse(result);
								$('#txtSeksi').val(res[0]['seksi']);
								$('#txtUnit').val(res[0]['unit']);
								$('#txtDepartemen').val(res[0]['departemen']);
								$('#txtLokasi').val(res[0]['lokasi_kerja']);
								$('#txtJabatan').val(res[0]['pekerjaan']);
								$('#txtDiangkat').val(res[0]['diangkat']);
								$('#txtAlamat').val(res[0]['alamat']);
								$('#txtLahir').val(res[0]['tempat']);
								$('#txtMasaKerja').val(res[0]['masakerja']);
								$('#txtSisaCuti').val(res[0]['sisacuti']);
								$('#txtProses').val(res[0]['metu']);
								$('#txtStatus').val(res[0]['alasan']);
								$('#txtUangPesangon').val(res[0]['pengali']);
								$('#txtUangUMPK').val(res[0]['upmk']);
								$('#txtSisaCutiHari').val(res[0]['sisacutihari']);
								$('#txtUangGantiRugi').val(res[0]['gantirugi']);
								$('#txtTahun').val(res[0]['masakerja_tahun']);
								$('#txtBulan').val(res[0]['masakerja_bulan']);
								$('#txtHari').val(res[0]['masakerja_hari']);
								$('#txtPasal').val(res[0]['pasal']);
								$('#txtPesangon').val(res[0]['pesangon']);
								$('#txtUPMK').val(res[0]['up']);
								$('#txtCuti').val(res[0]['cuti']);
								$('#txtRugi').val(res[0]['rugi']);
								$('#txtAkhir').val(res[0]['akhir']);

							}
						});
					}
				});

				//	Select2
				//	{
					$('#MasterPekerja-Surat-DaftarPekerja').select2(
					{
						allowClear: false,
						placeholder: "Pilih Pekerja",
						minimumInputLength: 3,
						ajax: 
						{
							url: baseurl+'MasterPekerja/Surat/daftar_pekerja_aktif',
							dataType: 'json',
							delay: 500,
							data: function (params){
								return {
									term: params.term
								}
							},
							processResults: function(data) {
								return {
									results: $.map(data, function(obj){
										return {id: obj.noind, text: obj.noind+' - '+obj.nama};
									})
								};
							}
						}
					});

					$('.MasterPekerja-Surat-DaftarPekerja').select2(
					{
						allowClear: false,
						placeholder: "Pilih Pekerja",
						minimumInputLength: 3,
						ajax: 
						{
							url: baseurl+'MasterPekerja/Surat/daftar_pekerja_aktif',
							dataType: 'json',
							delay: 500,
							data: function (params){
								return {
									term: params.term
								}
							},
							processResults: function(data) {
								return {
									results: $.map(data, function(obj){
										return {id: obj.noind, text: obj.noind+' - '+obj.nama};
									})
								};
							}
						}
					});

					$('#MasterPekerja-DaftarSeksi').select2(
					{
						allowClear: false,
						placeholder: "Pilih Seksi",
						minimumInputLength: 3,
						ajax: 
						{
							url: baseurl+'MasterPekerja/Surat/daftar_seksi',
							dataType: 'json',
							delay: 500,
							type: "GET",
							data: function (params){
								return {
									term: params.term
								}
							},
							processResults: function(data) {
								return {
									results: $.map(data, function(obj){
										return {id: obj.kodesie, text: obj.daftar_tseksi};
									})
								};
							}
						}
					});

					$('#MasterPekerja-DaftarSeksi').change(function(){
						var kode_seksi 	=	$(this).val();
						var kode_seksi 	=	kode_seksi.substr(0, 7);

						$('#MasterPekerja-DaftarPekerjaan').select2(
						{
							allowClear: false,
							placeholder: "Pilih Pekerjaan",
							ajax: 
							{
								url: baseurl+'MasterPekerja/Surat/daftar_pekerjaan',
								dataType: 'json',
								delay: 500,
								type: "GET",
								data: function (params){
									return {
										term: params.term,
										kode_seksi: kode_seksi
									}
								},
								processResults: function(data) {
									return {
										results: $.map(data, function(obj){
											return {id: obj.kdpekerjaan, text: obj.kdpekerjaan+' - '+obj.pekerjaan};
										})
									};
								}
							}
						});
					});

					$('.MasterPekerja-SuratMutasi-DaftarSeksi').select2(
					{
						allowClear: false,
						placeholder: "Pilih Seksi",
						minimumInputLength: 3,
						ajax: 
						{
							url: baseurl+'MasterPekerja/Surat/daftar_seksi',
							dataType: 'json',
							delay: 500,
							type: "GET",
							data: function (params){
								return {
									term: params.term
								}
							},
							processResults: function(data) {
								return {
									results: $.map(data, function(obj){
										return {id: obj.kodesie, text: obj.daftar_tseksi};
									})
								};
							}
						}
					});

					$('.MasterPekerja-SuratMutasi-DaftarSeksi').change(function(){
						var kode_seksi 	=	$(this).val();
						var kode_seksi 	=	kode_seksi.substr(0, 7);

						$('#MasterPekerja-SuratMutasi-DaftarPekerjaan').select2(
						{
							allowClear: true,
							placeholder: "Pilih Pekerjaan",
							ajax: 
							{
								url: baseurl+'MasterPekerja/Surat/daftar_pekerjaan',
								dataType: 'json',
								delay: 500,
								type: "GET",
								data: function (params){
									return {
										term: params.term,
										kode_seksi: kode_seksi
									}
								},
								processResults: function(data) {
									return {
										results: $.map(data, function(obj){
											return {id: obj.kdpekerjaan, text: obj.kdpekerjaan+' - '+obj.pekerjaan};
										})
									};
								}
							}
						});
					});

					$('#MasterPekerja-DaftarGolonganPekerjaan').select2({
						allowClear: false,
						placeholder: 'Pilih Golongan Pekerjaan',
						ajax:
						{
							url: baseurl+'MasterPekerja/Surat/SuratMutasi/daftar_golongan_pekerjaan',
							dataType: 'json',
							data: function (params){
								return {
									term: params.term,
									kode_status_kerja: $('#MasterPekerja-Surat-DaftarPekerja').val().substr(0, 1)
								}

							},
							processResults: function(data) {
								return {
									results: $.map(data, function(obj){
										return {id: obj.golkerja, text: obj.golkerja};
									})
								};
							}
						}
					});

					// var a = $('.MasterPekerja-Surat-DaftarPekerja').val();
					// alert(a);
					$('.MasterPekerja-SuratMutasi-DaftarGolongan').select2({
						// alert('a');
						allowClear: true,
						placeholder: 'Pilih Golongan Pekerjaan',
						ajax:
						{
							url: baseurl+'MasterPekerja/Surat/daftar_golongan_pekerjaan',
							dataType: 'json',
							data: function (params){
								return {
									term: params.term,
									kode_status_kerja: $('.MasterPekerja-Surat-DaftarPekerja').val().substr(0, 1)
								}

							},
							processResults: function(data) {
								return {
									results: $.map(data, function(obj){
										return {id: obj.golkerja, text: obj.golkerja};
									})
								};
							}
						}
					});

					$('#MasterPekerja-DaftarPekerjaan').select2(
					{
						allowClear: false,
						placeholder: "Pilih Pekerjaan",
						ajax: 
						{
							url: baseurl+'MasterPekerja/Surat/daftar_pekerjaan',
							dataType: 'json',
							delay: 500,
							type: "GET",
							data: function (params){
								return {
									term: params.term
								}
							},
							processResults: function(data) {
								return {
									results: $.map(data, function(obj){
										return {id: obj.kdpekerjaan, text: obj.kdpekerjaan+' - '+obj.pekerjaan};
									})
								};
							}
						}
					});

					$('.MasterPekerja-SuratMutasi-DaftarPekerjaan').select2(
					{
						allowClear: true,
						placeholder: "Pilih Pekerjaan",
						minimumInputLength: 3,
						ajax: 
						{
							url: baseurl+'MasterPekerja/Surat/daftar_pekerjaan',
							dataType: 'json',
							delay: 500,
							type: "GET",
							data: function (params){
								return {
									term: params.term
								}
							},
							processResults: function(data) {
								return {
									results: $.map(data, function(obj){
										return {id: obj.kdpekerjaan, text: obj.kdpekerjaan+' - '+obj.pekerjaan};
									})
								};
							}
						}
					});

					$('#MasterPekerja-DaftarKodeJabatan').select2({
						allowClear: false,
						placeholder: "Pilih Kode Jabatan",
						minimumInputLength: 1,
						ajax: 
						{
							url: baseurl+'MasterPekerja/Surat/daftar_kode_jabatan_kerja',
							dataType: 'json',
							delay: 500,
							data: function (params){
								return {
									term: params.term
								}
							},
							processResults: function(data) {
								return {
									results: $.map(data, function(obj){
										return {id: obj.kd_jabatan, text: obj.kd_jabatan+' - '+obj.jabatan};
									})
								};
							}
						}
					});

					$('.MasterPekerja-DaftarKodeJabatan').select2({
						allowClear: false,
						placeholder: "Pilih Kode Jabatan",
						minimumInputLength: 1,
						ajax: 
						{
							url: baseurl+'MasterPekerja/Surat/daftar_kode_jabatan_kerja',
							dataType: 'json',
							delay: 500,
							data: function (params){
								return {
									term: params.term
								}
							},
							processResults: function(data) {
								return {
									results: $.map(data, function(obj){
										return {id: obj.kd_jabatan, text: obj.kd_jabatan+' - '+obj.jabatan};
									})
								};
							}
						}
					});

					$('#MasterPekerja-DaftarLokasiKerja').select2({
						allowClear: false,
						placeholder: "Pilih Lokasi Kerja",
						ajax: 
						{
							url: baseurl+'MasterPekerja/Surat/daftar_lokasi_kerja',
							dataType: 'json',
							delay: 500,
							data: function (params){
								return {
									term: params.term
								}
							},
							processResults: function(data) {
								return {
									results: $.map(data, function(obj){
										return {id: obj.id_+' - '+obj.lokasi_kerja, text: obj.id_+' - '+obj.lokasi_kerja};
									})
								};
							}
						}
					});

					$('.MasterPekerja-DaftarLokasiKerja').select2({
						allowClear: false,
						placeholder: "Pilih Lokasi Kerja",
						ajax: 
						{
							url: baseurl+'MasterPekerja/Surat/daftar_lokasi_kerja',
							dataType: 'json',
							delay: 500,
							data: function (params){
								return {
									term: params.term
								}
							},
							processResults: function(data) {
								return {
									results: $.map(data, function(obj){
										return {id: obj.id_+' - '+obj.lokasi_kerja, text: obj.id_+' - '+obj.lokasi_kerja};
									})
								};
							}
						}
					});

					$('.MasterPekerja-DaftarTempatMakan').select2({
						allowClear: false,
						placeholder: "Pilih Tempat Makan",
						ajax: 
						{
							url: baseurl+'MasterPekerja/Surat/daftar_tempat_makan',
							dataType: 'json',
							delay: 500,
							data: function (params){
								return {
									term: params.term
								}
							},
							processResults: function(data) {
								return {
									results: $.map(data, function(obj){
										return {id: obj.fs_tempat_makan, text: obj.fs_tempat_makan};
									})
								};
							}
						}
					});
				//	}

				// 	Redactor WYSIWYG Text Editor
				// 	{
					$('#MasterPekerja-Surat-txaPreview').redactor();
					$('.MasterPekerja-Surat-txaPreview').redactor();
					$('#MasterPekerja-SuratPerbantuan-txaPreview').redactor();
					$('.MasterPekerja-SuratRotasi-txaPreview').redactor();
					$('.MasterPekerja-SuratPromosi-txaPreview').redactor();
					// $('.MasterPekerja-Surat-txaPreview').redactor();
					$('#MasterPekerja-Surat-txaFormatSurat').redactor();
					$('#MasterPekerja-SuratDemosi-txaPreview').redactor();
					$('#MasterPekerja-SuratPengangkatanStaf-txaPreview').redactor();
				//	}


		//	}

	});


	// 	General Function
	// 	{
			//	Surat-surat
			//	{
				$('#MasterPekerja-Surat-DaftarPekerja').change(function(){
					var noind = $('#MasterPekerja-Surat-DaftarPekerja').val();
					var kode_status_kerja 	=	noind.substr(0, 1);
					if(noind)
					{
						$.ajax({
							type:'POST',
							data:{noind: noind},
							url:baseurl+"MasterPekerja/Surat/detail_pekerja",
							success:function(result)
							{
								var result = JSON.parse(result);

								$('#MasterPekerja-txtKodesieLama').val(result['kodesie'] + ' - ' + result['posisi']);
								$('#MasterPekerja-txtPekerjaanLama').val(result['kode_pekerjaan'] + ' - ' + result['nama_pekerjaan']);
								$('#MasterPekerja-txtGolonganKerjaLama').val(result['golongan_pekerjaan']);
								$('#MasterPekerja-txtLokasiKerjaLama').val(result['kode_lokasi_kerja'] + ' - ' + result['nama_lokasi_kerja']);
								$('#MasterPekerja-txtKdJabatanLama').val(result['kode_jabatan'] + ' - ' + result['jenis_jabatan']);
								$('#MasterPekerja-txtJabatanLama').val(result['nama_jabatan']);
								$('#MasterPekerja-txtTempatMakan1').val(result['tempat_makan1']);
								$('#MasterPekerja-txtTempatMakan2').val(result['tempat_makan2']);
								$('#MasterPekerja-txtStatusStaf').val(result['status_staf']);
							}
						});
						$('#MasterPekerja-DaftarGolonganPekerjaan').select2('val', '');
						$('#MasterPekerja-DaftarGolonganPekerjaan').select2({
							allowClear: false,
							placeholder: 'Pilih Golongan Pekerjaan',
							ajax:
							{
								url: baseurl+'MasterPekerja/Surat/daftar_golongan_pekerjaan',
								dataType: 'json',
								data: function (params){
									return {
										term: params.term,
										kode_status_kerja: kode_status_kerja
									}
								},
								processResults: function(data) {
									return {
										results: $.map(data, function(obj){
											return {id: obj.golkerja, text: obj.golkerja};
										})
									};
								}
							}
						});
					} 
					else 
					{
						$('#kodesieLama').select2();
						$('#MasterPekerja-DaftarGolonganPekerjaan').select2('val', '');
					}
				});

				$('.MasterPekerja-Surat-DaftarPekerja').change(function(){
					var noind = $('.MasterPekerja-Surat-DaftarPekerja').val();
					var kode_status_kerja 	=	noind.substr(0, 1);
					if(noind)
					{
						$.ajax({
							type:'POST',
							data:{noind: noind},
							url:baseurl+"MasterPekerja/Surat/detail_pekerja",
							success:function(result)
							{
								var result = JSON.parse(result);

								$('.MasterPekerja-txtKodesieLama').val(result['kodesie'] + ' - ' + result['posisi']);
								$('.MasterPekerja-txtPekerjaanLama').val(result['kode_pekerjaan'] + ' - ' + result['nama_pekerjaan']);
								$('.MasterPekerja-txtGolonganKerjaLama').val(result['golongan_pekerjaan']);
								$('.MasterPekerja-txtLokasiKerjaLama').val(result['kode_lokasi_kerja'] + ' - ' + result['nama_lokasi_kerja']);
								$('.MasterPekerja-txtKdJabatanLama').val(result['kode_jabatan'] + ' - ' + result['jenis_jabatan']);
								$('.MasterPekerja-txtJabatanLama').val(result['nama_jabatan']);
								$('.MasterPekerja-txtTempatMakan1').val(result['tempat_makan1']);
								$('.MasterPekerja-txtTempatMakan2').val(result['tempat_makan2']);
								$('.MasterPekerja-txtStatusStaf').val(result['status_staf']);
							}
						});
						$('.MasterPekerja-SuratMutasi-DaftarGolongan').select2('val', '');
						$('.MasterPekerja-SuratMutasi-DaftarGolongan').select2({
							allowClear: true,
							placeholder: 'Pilih Golongan Pekerjaan',
							ajax:
							{
								url: baseurl+'MasterPekerja/Surat/daftar_golongan_pekerjaan',
								dataType: 'json',
								data: function (params){
									return {
										term: params.term,
										kode_status_kerja: kode_status_kerja
									}
								},
								processResults: function(data) {
									return {
										results: $.map(data, function(obj){
											return {id: obj.golkerja, text: obj.golkerja};
										})
									};
								}
							}
						});
					} 
					else 
					{
						$('#kodesieLama').select2();
						$('.MasterPekerja-SuratMutasi-DaftarGolongan').select2('val', '');
					}
				});


				$('#MasterPekerja-Surat-btnPreview').click(function(){ 
					// alert($('#MasterPekerja-txtLokasiKerjaLama').val());
					$('#surat-loading').attr('hidden', false);
					$(document).ajaxStop(function(){
						$('#surat-loading').attr('hidden', true);
					});
					$.ajax({
						type: 'POST',
						data: $('#MasterPekerja-FormCreate').serialize(),
						url: baseurl+"MasterPekerja/Surat/SuratMutasi/prosesPreviewMutasi",
						success:function(result)
						{
							var result = JSON.parse(result);
							console.log(result);

							/*CKEDITOR.instances['MasterPekerja-Surat-txaPreview'].setData(result['preview']);*/
							$('.MasterPekerja-Surat-txaPreview').redactor('set', result['preview']);
							$('#MasterPekerja-Surat-txtNomorSurat').val(result['nomor_surat']);
							$('#MasterPekerja-Surat-txtHalSurat').val(result['hal_surat']);
							$('#MasterPekerja-Surat-txtKodeSurat').val(result['kode_surat']);
						}
					});

				});

				$('#MasterPekerja-SuratDemosi-btnPreview').click(function(){
					$('#surat-loading').attr('hidden', false);
					$(document).ajaxStop(function(){
						$('#surat-loading').attr('hidden', true);
					});
					$.ajax({
						type: 'POST',
						data: $('#MasterPekerja-SuratDemosi-FormCreate').serialize(),
						url: baseurl+"MasterPekerja/Surat/SuratDemosi/prosesPreviewDemosi",
						success:function(result)
						{
							var result = JSON.parse(result);
							console.log(result);

				    			// CKEDITOR.instances['MasterPekerja-SuratDemosi-txaPreview'].setData(result['preview']);
				    			$('#MasterPekerja-SuratDemosi-txaPreview').redactor('set', result['preview']);
				    			$('#MasterPekerja-SuratDemosi-txtNomorSurat').val(result['nomorSurat']);
				    			$('#MasterPekerja-SuratDemosi-txtHalSurat').val(result['halSurat']);
				    			$('#MasterPekerja-SuratDemosi-txtKodeSurat').val(result['kodeSurat']);
				    		}
				    	});

				});

				$('#MasterPekerja-SuratPromosi-btnPreview').click(function(){
					$('#surat-loading').attr('hidden', false);
					$(document).ajaxStop(function(){
						$('#surat-loading').attr('hidden', true);
					});
					$.ajax({
						type: 'POST',
						data: $('#MasterPekerja-SuratPromosi-FormCreate').serialize(),
						url: baseurl+"MasterPekerja/Surat/SuratPromosi/prosesPreviewPromosi",
						success:function(result)
						{
							var result = JSON.parse(result);
							console.log(result);

				    			// CKEDITOR.instances['MasterPekerja-SuratPromosi-txaPreview'].setData(result['preview']);
				    			$('.MasterPekerja-SuratPromosi-txaPreview').redactor('set', result['preview']);
				    			$('#MasterPekerja-SuratPromosi-txtNomorSurat').val('val', '');
				    			$('#MasterPekerja-SuratPromosi-txtNomorSurat').val(result['nomorSurat']);
				    			$('#MasterPekerja-SuratPromosi-txtHalSurat').val(result['halSurat']);
				    			$('#MasterPekerja-SuratPromosi-txtKodeSurat').val(result['kodeSurat']);
				    		}
				    	});

				});
				 //    $('#MasterPekerja-DaftarGolonganPekerjaan').select2({
					//     allowClear: false,
					//     placeholder: 'Pilih Golongan Pekerjaan',
					//     ajax:
					//     {
					// 		url: baseurl+"MasterPekerja/Surat/SuratMutasi/cariGolonganPekerjaan",
					// 		dataType: 'json',
					// 		data: function (params){
					// 			return {
					// 				term: params.term,
					// 				kode_status_kerja: $('#MasterPekerja-Surat-DaftarPekerja').val().substr(0, 1)
					// 			}
					// 		},
					// 		processResults: function(data) {
					// 			return {
					// 				results: $.map(data, function(obj){
					// 					return {id: obj.golkerja, text: obj.golkerja};
					// 				})
					// 			};
					// 		}
					// 	}
					// });

					$('.MasterPekerja-SuratPerbantuan-btnPreview').click(function(){
						$('#surat-loading').attr('hidden', false);
						$(document).ajaxStop(function(){
							$('#surat-loading').attr('hidden', true);
						});
							// alert('a');
							$.ajax({
								type: 'POST',
								data: $('#MasterPekerja-SuratPerbantuan-FormCreate').serialize(),
								url: baseurl+"MasterPekerja/Surat/SuratPerbantuan/prosesPreviewPerbantuan",
								success:function(result)
								{
									var result = JSON.parse(result);
									console.log(result);

									// CKEDITOR.instances['MasterPekerja-SuratPerbantuan-txaPreview'].setData(result['preview']);
									$('#MasterPekerja-SuratPerbantuan-txaPreview').redactor('set', result['preview']);
									$('#MasterPekerja-SuratPerbantuan-txtNomorSurat').val(result['nomorSurat']);
									$('#MasterPekerja-SuratPerbantuan-txtHalSurat').val(result['halSurat']);
									$('#MasterPekerja-SuratPerbantuan-txtKodeSurat').val(result['kodeSurat']);
								}
							});
						});



					$('.MasterPekerja-SuratRotasi-btnPreview').click(function(){
						$('#surat-loading').attr('hidden', false);
						$(document).ajaxStop(function(){
							$('#surat-loading').attr('hidden', true);
						});
				    	// var a = $('.MasterPekerja-Surat-DaftarPekerja').val(); alert(a);
				    	$.ajax({
				    		type: 'POST',
				    		data: $('#MasterPekerja-SuratRotasi-FormCreate').serialize(),
				    		url: baseurl+"MasterPekerja/Surat/SuratRotasi/prosesPreviewRotasi",
				    		success:function(result)
				    		{
				    			var result = JSON.parse(result);
				    			console.log(result);

				    			// CKEDITOR.instances['MasterPekerja-SuratRotasi-txaPreview'].setData(result['preview']);
				    			$('.MasterPekerja-SuratRotasi-txaPreview').redactor('set', result['preview']);
				    			$('.MasterPekerja-SuratMutasi-txtNomorSurat').val(result['nomorSurat']);
				    			$('.MasterPekerja-SuratMutasi-txtHalSurat').val(result['halSurat']);
				    			$('.MasterPekerja-SuratMutasi-txtKodeSurat').val(result['kodeSurat']);
				    		}
				    	});
				    	
				    });

					$('#MasterPekerja-SuratPengangkatanStaf-btnPreview').click(function(){
						$('#surat-loading').attr('hidden', false);
						$(document).ajaxStop(function(){
							$('#surat-loading').attr('hidden', true);
						});
						$.ajax({
							type: 'POST',
							data: $('#MasterPekerja-SuratPengangkatanStaff-FormCreate').serialize(),
							url: baseurl+"MasterPekerja/Surat/SuratPengangkatanStaff/prosesPreviewPengangkatan",
							success:function(result)
							{
								var result = JSON.parse(result);
								console.log(result);

				    			// CKEDITOR.instances['MasterPekerja-SuratPengangkatan-txaPreview'].setData(result['preview']);
				    			$('#MasterPekerja-SuratPengangkatanStaf-txaPreview').redactor('set', result['preview']);
				    			$('.MasterPekerja-SuratMutasi-txtNomorSurat').val(result['nomorSurat']);
				    			$('.MasterPekerja-SuratMutasi-txtHalSurat').val(result['halSurat']);
				    			$('.MasterPekerja-SuratMutasi-txtKodeSurat').val(result['kodeSurat']);
				    		}
				    	});

					});

			//	}

	// 	}	
// 	-------Master Pekerja----------------------------------------------end

// alert(top.location.pathname);
$(document).ready(function(){
	$('.jabatan').change(function(){
		var kd = $('.mpk-kdbaru').val();
		// alert(kd);
		var job = $('.kerja').val();
		var teks = $('.jabatan').val();
		var isi = $('.setjabatan').val().length;
		// if (isi < 1) {
			$.post(baseurl+"MasterPekerja/Surat/SuratDemosi/jabatan",
			{
				name: teks,
				job: job,
				kd: kd
			},
			function(data,status){
            // alert(data.trim());
            $('.setjabatan').val(data.trim().toUpperCase());
        });
		// }
	});
	$('.mpk-kdbaru').change(function(){
		var kd = $('.mpk-kdbaru').val();
		// alert(kd);
		var job = $('.kerja').val();
		var teks = $('.jabatan').val();
		var isi = $('.setjabatan').val().length;
		// if (isi < 1) {
			$.post(baseurl+"MasterPekerja/Surat/SuratDemosi/jabatan",
			{
				name: teks,
				job: job,
				kd: kd
			},
			function(data,status){
            // alert(data.trim());
            $('.setjabatan').val(data.trim().toUpperCase());
        });
		// }
	});
});
//-------------------------------------pengangkatan-----------------------------
$(document).ready(function(){
	var st = $('.stafStatus').val();
	if (st == '1') {
		st = 'daftar_pekerja_pengangkatan_non';
	}else{
		st = 'daftar_pekerja_pengangkatan';
	}
	$('.MasterPekerja-Surat-DaftarPekerja-staf').select2(
	{
		allowClear: false,
		placeholder: "Pilih Pekerja",
		minimumInputLength: 3,
		ajax: 
		{
			url: baseurl+'MasterPekerja/Surat/'+st,
			dataType: 'json',
			delay: 500,
			data: function (params){
				return {
					term: params.term
				}
			},
			processResults: function(data) {
				return {
					results: $.map(data, function(obj){
						return {id: obj.noind, text: obj.noind+' - '+obj.nama};
					})
				};
			}
		}
	});

	$('.MasterPekerja-Surat-DaftarPekerja-staf-pengangkatan').select2(
	{
		allowClear: false,
		placeholder: "Pilih Pekerja",
		minimumInputLength: 3,
		ajax: 
		{
			url: baseurl+'MasterPekerja/Surat/'+st,
			dataType: 'json',
			delay: 500,
			data: function (params){
				return {
					term: params.term
				}
			},
			processResults: function(data) {
				return {
					results: $.map(data, function(obj){
						return {id: obj.noind, text: obj.noind+' - '+obj.nama};
					})
				};
			}
		}
	});
});
$('.MasterPekerja-Surat-DaftarPekerja-staf').change(function(){
	var noind = $('.MasterPekerja-Surat-DaftarPekerja-staf').val();
	var kode_status_kerja 	=	noind.substr(0, 1);
	if(noind)
	{
		$.ajax({
			type:'POST',
			data:{noind: noind},
			url:baseurl+"MasterPekerja/Surat/detail_pekerja",
			success:function(result)
			{
				var result = JSON.parse(result);

				$('.MasterPekerja-txtKodesieLama').val(result['kodesie'] + ' - ' + result['posisi']);
				$('.MasterPekerja-txtPekerjaanLama').val(result['kode_pekerjaan'] + ' - ' + result['nama_pekerjaan']);
				$('.MasterPekerja-txtGolonganKerjaLama').val(result['golongan_pekerjaan']);
				$('.MasterPekerja-txtLokasiKerjaLama').val(result['kode_lokasi_kerja'] + ' - ' + result['nama_lokasi_kerja']);
				$('.MasterPekerja-txtKdJabatanLama').val(result['kode_jabatan'] + ' - ' + result['jenis_jabatan']);
				$('.MasterPekerja-txtJabatanLama').val(result['nama_jabatan']);
				$('.MasterPekerja-txtTempatMakan1').val(result['tempat_makan1']);
				$('.MasterPekerja-txtTempatMakan2').val(result['tempat_makan2']);
				$('.MasterPekerja-txtStatusStaf').val(result['status_staf']);
			}
		});
		$('.MasterPekerja-SuratMutasi-DaftarGolongan').select2('val', '');
		$('.MasterPekerja-SuratMutasi-DaftarGolongan').select2({
			allowClear: true,
			placeholder: 'Pilih Golongan Pekerjaan',
			ajax:
			{
				url: baseurl+'MasterPekerja/Surat/daftar_golongan_pekerjaan',
				dataType: 'json',
				data: function (params){
					return {
						term: params.term,
						kode_status_kerja: kode_status_kerja
					}
				},
				processResults: function(data) {
					return {
						results: $.map(data, function(obj){
							return {id: obj.golkerja, text: obj.golkerja};
						})
					};
				}
			}
		});
	} 
	else 
	{
		$('#kodesieLama').select2();
		$('.MasterPekerja-SuratMutasi-DaftarGolongan').select2('val', '');
	}
});

$('.MasterPekerja-Surat-DaftarPekerja-staf-pengangkatan').change(function(){
	var noind = $('.MasterPekerja-Surat-DaftarPekerja-staf-pengangkatan').val();
	var kode_status_kerja 	=	noind.substr(0, 1);
	if(noind)
	{
		$.ajax({
			type:'POST',
			data:{noind: noind},
			url:baseurl+"MasterPekerja/Surat/detail_pekerja",
			success:function(result)
			{
				var result = JSON.parse(result);
				// alert(result);

				$('.MasterPekerja-txtKodesieLama').val(result['kodesie'] + ' - ' + result['posisi']);
				$('.MasterPekerja-txtPekerjaanLama').val(result['kode_pekerjaan'] + ' - ' + result['nama_pekerjaan']);
				$('.MasterPekerja-txtGolonganKerjaLama').val(result['golongan_pekerjaan']);
				$('.MasterPekerja-txtLokasiKerjaLama').val(result['kode_lokasi_kerja'] + ' - ' + result['nama_lokasi_kerja']);
				$('.MasterPekerja-txtKdJabatanLama').val(result['kode_jabatan'] + ' - ' + result['jenis_jabatan']);
				$('.MasterPekerja-txtJabatanLama').val(result['nama_jabatan']);
				$('.MasterPekerja-txtTempatMakan1').val(result['tempat_makan1']);
				$('.MasterPekerja-txtTempatMakan2').val(result['tempat_makan2']);
				$('.MasterPekerja-txtStatusStaf').val(result['status_staf']);
				$('.MasterPekerja-txtjabatanDlLama').val(result['jabatan_dl']);
				// alert(result);
			}
		});
		$('.MasterPekerja-SuratMutasi-DaftarGolongan').select2('val', '');
		$('.MasterPekerja-SuratMutasi-DaftarGolongan').select2({
			allowClear: true,
			placeholder: 'Pilih Golongan Pekerjaan',
			ajax:
			{
				url: baseurl+'MasterPekerja/Surat/daftar_golongan_pekerjaan',
				dataType: 'json',
				data: function (params){
					return {
						term: params.term,
						kode_status_kerja: kode_status_kerja
					}
				},
				processResults: function(data) {
					return {
						results: $.map(data, function(obj){
							return {id: obj.golkerja, text: obj.golkerja};
						})
					};
				}
			}
		});
	} 
	else 
	{
		$('#kodesieLama').select2();
		$('.MasterPekerja-SuratMutasi-DaftarGolongan').select2('val', '');
	}
});

$(function () {
	$(document).on('change', '.noind', function(event) {
		var isi = $('.noind').val();
		if (isi.substring(0, 1) == 'J') {
			$('.MasterPekerja-txtNoindBaru').val(isi);
			$('.MasterPekerja-txtNoindBaru').attr('readonly', true);
		}else{
			$('.MasterPekerja-txtNoindBaru').val('');
			$('.MasterPekerja-txtNoindBaru').attr('readonly', false);
		}
	});
	if ($('select').hasClass('golker')) {
			// alert(top.location.pathname);
			var noind = $('.golker').val();
			var kode_status_kerja = noind.substr(0, 1);
			$('.MasterPekerja-SuratMutasi-DaftarGolongan').select2({
				allowClear: true,
				placeholder: 'Pilih Golongan Pekerjaan',
				ajax:
				{
					url: baseurl+'MasterPekerja/Surat/daftar_golongan_pekerjaan',
					dataType: 'json',
					data: function (params){
						return {
							term: params.term,
							kode_status_kerja: kode_status_kerja
						}
					},
					processResults: function(data) {
						return {
							results: $.map(data, function(obj){
								return {id: obj.golkerja, text: obj.golkerja};
							})
						};
					}
				}
			});
		}else{
		// alert('a');
	}
});

$(document).ready(function(){
	$('#tbl').DataTable();
});