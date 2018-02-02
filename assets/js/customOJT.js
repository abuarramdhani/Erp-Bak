// 	-------Monitoring OJT--------------------------------------------start
	$(function()
	{
		//	DataTables
		//	{
				$('#MonitoringOJT-tabelDaftarOrientasi').DataTable({
					scrollX: true,
				});
		//	}

		//	Select2
		//	{
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

	// 	}	
// 	-------Monitoring OJT----------------------------------------------end