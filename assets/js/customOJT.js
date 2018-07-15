// 	-------Monitoring OJT--------------------------------------------start
	$(function()
	{
		// 	Daterangepicker
		// 	{
				$('.MonitoringOJT-daterangepicker').daterangepicker({
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
				  console.log("New date range selected: ' + start.format('DD-MM-YYYY H:i:s') + ' to ' + end.format('DD-MM-YYYY H:i:s') + ' (predefined range: ' + label + ')");
				});

				$('.MonitoringOJT-daterangepickersingledate').daterangepicker({
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
				  console.log("New date range selected: ' + start.format('DD-MM-YYYY H:i:s') + ' to ' + end.format('DD-MM-YYYY H:i:s') + ' (predefined range: ' + label + ')");
				});

				$('.MonitoringOJT-daterangepicker-noautoupdateinput').daterangepicker({
				    "showDropdowns": true,
				    /*"autoApply": true,*/
				    "autoUpdateInput" : false,
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
				  console.log("New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')");
				});

				$('.MonitoringOJT-daterangepicker-noautoupdateinput').on('apply.daterangepicker', function(ev, picker) {
				    $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
				});

				$('.MonitoringOJT-daterangepicker-noautoupdateinput').on('cancel.daterangepicker', function(ev, picker) {
				    $(this).val('');
				});
		//	}

		//	DataTables
		//	{
				$('#MonitoringOJT-tabelDaftarOrientasi').DataTable({
					scrollX: true,
				});

				$('#MonitoringOJT-daftarFormatMemo').DataTable({
					scrollX: false,
				});

				$('#MonitoringOJT-daftarFormatUndangan').DataTable({
					scrollX: false,
				});

				$('#MonitoringOJT-daftarCetakUndangan').DataTable({
					scrollX: false,
				});

				$('#MonitoringOJT-monitoringPekerjaAktif').DataTable({
					scrollX: true,
					// scrollY: '275px',
				});

				$('#MonitoringOJT-monitoringPekerjaTunda').DataTable({
				});

				$('#MonitoringOJT-monitoringPekerjaSelesai').DataTable({
				});

				$('#MonitoringOJT-monitoringPekerjaKeluar').DataTable({
				});

				/*$('#MonitoringOJT-rekapKegiatanHarian').DataTable({
					scrollX: false,
					searching: false,
					sorting: false
				});*/

				// $('#MonitoringOJT-monitoringPekerja').DataTable({
				// 	scrollX: true,
				// });
		//	}

		//	Select2
		//	{
				$('#MonitoringOJT-cmbFormatCetak').select2({
					minimumResultsForSearch: -1,
					allowClear: true,
					ajax:
					{
						url: baseurl+'OnJobTraining/MasterOrientasi/daftarFormatCetak',
						dataType: 'json',
						data: function(params){
							return {
								term: params.term
							}
						},
						processResults: function (data){
							return {
								results: $.map(data, function(obj){
									return {id: obj.id_memo, text: obj.judul};
								})
							}
						}
					}
				});

				$('.MonitoringOJT-cmbPemberitahuanPelaksanaan').select2({
					placeholder: 'Pelaksanaan',
				});

				$('.MonitoringOJT-cmbPemberitahuanTujuan').select2({
					placeholder: 'Tujuan',
				});

				$('.MonitoringOJT-cmbUndanganPelaksanaan').select2({
					placeholder: 'Pelaksanaan',
				});

				$('.MonitoringOJT-cmbUndanganTujuan').select2({
					placeholder: 'Tujuan',
				});

				$('.MonitoringOJT-cmbJadwalPelaksanaan').select2({
					placeholder: 'Pelaksanaan',
				});

				$('.MonitoringOJT-cmbJadwalTahapan').select2({
					placeholder: 'Tahapan Orientasi',
				});

				$('select#MonitoringOJT-cmbDaftarPekerjaOJT').select2({
					placeholder: "Pilih pekerja OJT baru",
					searching: true,
					minimumInputLength: 3,
					allowClear: false,
					ajax:
					{
						url: baseurl+'OnJobTraining/Monitoring/tambahPekerjaOJT',
						dataType: 'json',
						delay: 500,
						type: 'GET',
						data: function(params){
							return {
								term: params.term
							}
						},
						processResults: function (data){
							return {
								results: $.map(data, function(obj){
									return {id: obj.noind, text: obj.noind + ' - ' + obj.nama};
								})
							}
						}
					}
				});

				$('#MonitoringOJT-cmbDaftarAtasanPekerja').select2({
					placeholder: "Pilih atasan pekerja",
					searching: true,
					minimumInputLength: 3,
					allowClear: false,
					ajax:
					{
						url: baseurl+'OnJobTraining/Monitoring/tambahAtasanPekerja',
						dataType: 'json',
						delay: 500,
						data: function(params){
							return {
								term: params.term,
								pekerja: $('#MonitoringOJT-cmbDaftarPekerjaOJT').val(),
							}
						},
						processResults: function (data){
							return {
								results: $.map(data, function(obj){
									return {id: obj.noind, text: obj.noind + ' - ' + obj.nama + ' - ' + obj.jabatan + ' ' + obj.lingkup};
								})
							}
						}
					}
				});

				$('#MonitoringOJT-cmbFormatUndangan').select2({
					ajax:
					{
						url: baseurl+'OnJobTraining/CetakUndangan/daftar_format_undangan',
						dataType: 'json',
						delay: 500,
						data: function(params){
							return {
								term: params.term
							}
						},
						processResults: function (data){
							return {
								results: $.map(data, function(obj){
									return {id: obj.id_undangan, text: obj.judul};
								})
							}
						}
					}
				});

				$('#MonitoringOJT-cmbPekerjaOJT').select2({
					searching: true,
					minimumInputLength: 3,
					allowClear: false,
					ajax:
					{
						url: baseurl+'OnJobTraining/Monitoring/daftar_pekerja_ojt',
						dataType: 'json',
						delay: 500,
						type: 'GET',
						data: function(params){
							return {
								term: params.term
							}
						},
						processResults: function (data){
							return {
								results: $.map(data, function(obj){
									return {id: obj.pekerja_id, text: obj.noind + ' - ' + obj.nama};
								})
							}
						}
					}
				});

				$('#MonitoringOJT-cmbPekerjaOJTMemoJadwalTraining').select2({
					searching: true,
					minimumInputLength: 3,
					allowClear: false,
					ajax:
					{
						url: baseurl+'OnJobTraining/CetakMemoJadwalTraining/daftar_pekerja_ojt',
						dataType: 'json',
						delay: 500,
						type: 'GET',
						data: function(params){
							return {
								term: params.term,
								periode: $('#MonitoringOJT-txtPeriode').val().replace(' - ', '|')
							}
						},
						processResults: function (data){
							return {
								results: $.map(data, function(obj){
									return {id: obj.pekerja_id, text: obj.noind + ' - ' + obj.nama};
								})
							}
						}
					}
				});

				$('#MonitoringOJT-cmbTahapanOJT').select2({
					searching: true,
					allowClear: false,
					ajax:
					{
						url: baseurl+'OnJobTraining/Monitoring/tahapan_pekerja_ojt',
						dataType: 'json',
						delay: 500,
						type: 'GET',
						data: function(params){
							return {
								term: params.term,
								id_pekerja: $('#MonitoringOJT-cmbPekerjaOJT').val()
							}
						},
						processResults: function (data){
							return {
								results: $.map(data, function(obj){
									return {id: obj.id_proses, text: obj.tahapan};
								})
							}
						}
					}
				});

				$('.MonitoringOJT-txtTanggalPDCA').select2({
					searching: true,
					allowClear: false,
					ajax:
					{
						url: baseurl+'OnJobTraining/CetakMemoPDCA/proses_ojt_pekerja',
						dataType: 'json',
						delay: 500,
						type: 'GET',
						data: function(params){
							return {
								term: params.term,
								id_pekerja: $('#MonitoringOJT-cmbPekerjaOJT').val()
							}
						},
						processResults: function (data){
							return {
								results: $.map(data, function(obj){
									return {id: obj.id_proses, text: obj.tahapan + ' (' + obj.tgl_awal + ' - ' + obj.tgl_akhir +')'};
								})
							}
						}
					}
				});
		//	}

		//	Form Behavior
		// 	{
				$('#MonitoringOJT-radioTanggalOtomatisFalse').click(function(){
					$('#MonitoringOJT-PengaturanAlurOrientasiBaru').addClass('hidden');
				});

				$('#MonitoringOJT-radioPemberitahuanFalse').click(function(){
					$('#MonitoringOJT-PengaturanPemberitahuanOrientasiBaru').addClass('hidden');
				});

				$('#MonitoringOJT-radioCetakFalse').click(function(){
					$('#MonitoringOJT-PengaturanUndanganOrientasiBaru').addClass('hidden');
				});

				$('#MonitoringOJT-radioTanggalOtomatisTrue').click(function(){
					$('#MonitoringOJT-PengaturanAlurOrientasiBaru').removeClass('hidden');
				});

				$('#MonitoringOJT-radioPemberitahuanTrue').click(function(){
					$('#MonitoringOJT-PengaturanPemberitahuanOrientasiBaru').removeClass('hidden');
				});

				$('#MonitoringOJT-radioCetakTrue').click(function(){
					$('#MonitoringOJT-PengaturanUndanganOrientasiBaru').removeClass('hidden');
				});

				$('#MonitoringOJT-chkOrientasi-checkAll').click(function(){
					$('.MonitoringOJT-chkOrientasi').prop('checked',true);
				});

				$('#MonitoringOJT-chkOrientasi-uncheckAll').click(function(){
					$('.MonitoringOJT-chkOrientasi').prop('checked', false);
				});

				$('#MonitoringOJT-btnPratinjauUndangan').click(function(){
					$.ajax({
						type: 'POST',
						data: $('#MonitoringOJT-frmCetakUndangan').serialize(),
						url: baseurl+'OnJobTraining/CetakUndangan/isi_undangan',
						success: function(result)
						{
							var result = JSON.parse(result);
							$('#MonitoringOJT-txaIsiUndangan').redactor('set', result['isi_undangan']);
						}
					});
				});
				
				$('#MonitoringOJT-btnPratinjauMemoJadwalTraining').click(function(){
					$.ajax({
						type: 'POST',
						data: $('#MonitoringOJT-frmCetakMemoJadwalTraining').serialize(),
						url: baseurl+'OnJobTraining/CetakMemoJadwalTraining/isi_memo_jadwal_training',
						success: function(result)
						{
							var result = JSON.parse(result);
							$('#MonitoringOJT-txaIsiMemoJadwalTraining').redactor('set', result['isi_memo_jadwal_training']);
							$('#MonitoringOJT-txaIsiLampiranJadwalTraining').redactor('set', result['isi_lampiran_jadwal_training']);
						}
					});
				});
				
				$('#MonitoringOJT-btnPratinjauMemoPDCA').click(function(){
					$.ajax({
						type: 'POST',
						data: $('#MonitoringOJT-frmCetakMemoPDCA').serialize(),
						url: baseurl+'OnJobTraining/CetakMemoPDCA/isi_memo_pdca',
						success: function(result)
						{
							var result = JSON.parse(result);
							$('#MonitoringOJT-txaIsiMemoPDCA').redactor('set', result['isi_memo_pdca']);
						}
					});
				});

		//	}

		//	Redactor
		//	{
				$('#MonitoringOJT-Undangan-txaFormatUndangan').redactor();
				$('#MonitoringOJT-Memo-txaFormatMemo').redactor();
				$('#MonitoringOJT-txaIsiUndangan').redactor();
				$('#MonitoringOJT-txaIsiMemoJadwalTraining').redactor();
				$('#MonitoringOJT-txaIsiLampiranJadwalTraining').redactor();
				$('#MonitoringOJT-txaIsiMemoPDCA').redactor();
		//	}
	});
	// 	General Function
	// 	{
			function MonitoringOJT_tambahPemberitahuan()
			{
				var counter 	= 0;
			    var n 			= $('#MonitoringOJT-pengaturanPemberitahuan tr').length;
			       // alert(n);
				counter 		= n-1;

				$(".MonitoringOJT-cmbPemberitahuanPelaksanaan").select2("destroy");
				$(".MonitoringOJT-cmbPemberitahuanTujuan").select2("destroy");

			       var newRow = jQuery(				'<tr>'
														+'<td>'
															+'<a class="btn btn-sm btn-danger" onclick="MonitoringOJT_hapusPemberitahuan(this)" ><i class="fa fa-times"></i></a>'
															+'<input class="hidden" type="text" name="idPemberitahuan['+counter+']" value="" />'
														+'</td>'
														+'<td>'
															+'<div class="row">'
																+'<input type="checkbox" name="chkPemberitahuanAllDay['+counter+']" value="1" />'
																+'<label for="chkPemberitahuanAllDay['+counter+']" class="control-label">All Day</label>'
															+'</div>'
														+'</td>'
														+'<td>'
															+'<input type="number" name="numPemberitahuanIntervalHari['+counter+']" class="form-control" min="0" max="99" step="1" placeholder="Hari" />'
														+'</td>'
														+'<td>'
															+'<input type="number" name="numPemberitahuanIntervalMinggu['+counter+']" class="form-control" min="0" max="10" step="1" placeholder="Minggu" />'
														+'</td>'
														+'<td>'
															+'<input type="number" name="numPemberitahuanIntervalBulan['+counter+']" class="form-control" min="0" max="10" step="1" placeholder="Bulan" />'
														+'</td>'
														+'<td>'
															+'<select class="select2 form-control MonitoringOJT-cmbPemberitahuanPelaksanaan" style="width: 100%" name="cmbPemberitahuanPelaksanaan['+counter+']" placeholder="Pelaksanaan">'
																+'<option value="0">Sebelum</option>'
																+'<option value="1">Sesudah</option>'
															+'</select>'
														+'</td>'
														+'<td>'
															+'<select class="select2 form-control MonitoringOJT-cmbPemberitahuanTujuan" style="width: 100%" name="cmbPemberitahuanTujuan['+counter+']" placeholder="Tujuan">'
																+'<option></option>'
																+'<option value="1">People Development</option>'
																+'<option value="2">Pekerja</option>'
																+'<option value="3">Atasan Pekerja</option>'
															+'</select>'
														+'</td>'
													+'</tr>');
			   	jQuery("#MonitoringOJT-pengaturanPemberitahuan").append(newRow);

			   	$(".MonitoringOJT-cmbPemberitahuanPelaksanaan").select2();
				$(".MonitoringOJT-cmbPemberitahuanTujuan").select2();
			}

			function MonitoringOJT_hapusPemberitahuan(th)
			{
				var 	count = $('#MonitoringOJT-pengaturanPemberitahuan tr').length;
				// alert(count);
				if(count<=2)
				{
					alert('Minimal 1 baris!');
				}
				else
				{
					$(th).closest('tr').remove(); 				
				}   		
			}

			function MonitoringOJT_tambahUndangan()
			{
				var counter 	= 0;
			    var n 			= $('#MonitoringOJT-pengaturanUndangan tr').length;
			       // alert(n);
				counter 		= n-1;

				$(".MonitoringOJT-cmbUndanganPelaksanaan").select2("destroy");
				$(".MonitoringOJT-cmbUndanganTujuan").select2("destroy");

			       var newRow = jQuery(				'<tr>'
														+'<td>'
															+'<a class="btn btn-sm btn-danger" onclick="MonitoringOJT_hapusUndangan(this)" ><i class="fa fa-times"></i></a>'
															+'<input class="hidden" type="text" name="idUndangan['+counter+']" value="" />'
														+'</td>'
														+'<td>'
															+'<input type="number" name="numUndanganIntervalHari['+counter+']" class="form-control" min="0" max="99" step="1" placeholder="Hari" />'
														+'</td>'
														+'<td>'
															+'<input type="number" name="numUndanganIntervalMinggu['+counter+']" class="form-control" min="0" max="10" step="1" placeholder="Minggu" />'
														+'</td>'
														+'<td>'
															+'<input type="number" name="numUndanganIntervalBulan['+counter+']" class="form-control" min="0" max="10" step="1" placeholder="Bulan" />'
														+'</td>'
														+'<td>'
															+'<select class="select2 form-control MonitoringOJT-cmbUndanganPelaksanaan" style="width: 100%" name="cmbUndanganPelaksanaan['+counter+']" placeholder="Pelaksanaan">'
																+'<option value="0">Sebelum</option>'
																+'<option value="1">Sesudah</option>'
															+'</select>'
														+'</td>'
														+'<td>'
															+'<select class="select2 form-control MonitoringOJT-cmbUndanganTujuan" style="width: 100%" name="cmbUndanganTujuan['+counter+']" placeholder="Tujuan">'
																+'<option></option>'
																+'<option value="1">People Development</option>'
																+'<option value="2">Pekerja</option>'
																+'<option value="3">Atasan Pekerja</option>'
															+'</select>'
														+'</td>'
													+'</tr>');
			   	jQuery("#MonitoringOJT-pengaturanUndangan").append(newRow);

			   	$(".MonitoringOJT-cmbUndanganPelaksanaan").select2();
				$(".MonitoringOJT-cmbUndanganTujuan").select2();
			}

			function MonitoringOJT_hapusUndangan(th)
			{
				var 	count = $('#MonitoringOJT-pengaturanUndangan tr').length;
				// alert(count);
				if(count<=2)
				{
					alert('Minimal 1 baris!');
				}
				else
				{
					$(th).closest('tr').remove(); 				
				}   		
			}

			function MonitoringOJT_ubahStatusPekerjaKeluar(pekerja_id, noind, nama)
			{
				$('#MonitoringOJT-monitoring-pekerjaKeluar-txtPekerjaID').val(pekerja_id);
				$('#MonitoringOJT-monitoring-pekerjaKeluar-txtPekerjaInfo').val(noind + ' - ' + nama);
				$('#MonitoringOJT-ubahStatusPekerjaKeluar').modal("show");
			}

			function MonitoringOJT_ubahStatusPekerjaTunda(pekerja_id, noind, nama)
			{
				$('#MonitoringOJT-monitoring-pekerjaTunda-txtPekerjaID').val(pekerja_id);
				$('#MonitoringOJT-monitoring-pekerjaTunda-txtPekerjaInfo').val(noind + ' - ' + nama);
				$('#MonitoringOJT-ubahStatusPekerjaTunda').modal("show");
			}

			function MonitoringOJT_ubahStatusPekerjaSelesai(pekerja_id, noind, nama)
			{
				$('#MonitoringOJT-scheduling-pekerjaSelesai-txtPekerjaID').val(pekerja_id);
				$('#MonitoringOJT-scheduling-pekerjaSelesai-txtNoind').html(noind);
				$('#MonitoringOJT-scheduling-pekerjaSelesai-txtNama').html(nama);
				$('#MonitoringOJT-ubahStatusPekerjaSelesai').modal("show");
			}

			function MonitoringOJT_ubahEmail(pekerja_id, email_pekerja, email_atasan)
			{
				
				$('#MonitoringOJT-monitoring-ubahEmail-txtPekerjaID').val(pekerja_id);
				$('#MonitoringOJT-monitoring-ubahEmail-txtEmailPekerja').val(email_pekerja);
				$('#MonitoringOJT-monitoring-ubahEmail-txtEmailAtasan').val(email_atasan);
				$('#MonitoringOJT-ubahEmail').modal("show");
			}

	// 	}	
// 	-------Monitoring OJT----------------------------------------------end