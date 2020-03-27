		$(function()
		{
			//	DataTables
			//	{

					$('.JurnalPenilaian-evaluasiSeksi').DataTable({
						lengthChange: false,
						scrollX: true,
						scrollY: 300,
						responsive: false,
						fixedColumns: {
							leftColumns: 4,
							rightColumns: 4
						},
						lengthMenu: [ [-1, 5, 10, 25, 50, 100], ["All", 5, 10, 25, 50, 100] ],
					});

					// $(document).ready(function(){
					// 	var evaluasiSeksi 	=	$('.JurnalPenilaian-evaluasiSeksi').DataTable({
					// 		lengthChange: false,
					// 		scrollX: true,
					// 		scrollY: 300,
					// 		responsive: true,
					// 		fixedColumns: {
					// 			leftColumns: 4,
					// 			rightColumns: 4
					// 		},
					// 		lengthMenu: [ [-1, 5, 10, 25, 50, 100], ["All", 5, 10, 25, 50, 100] ],
					// 	});
					// 	new $.fn.DataTable.FixedColumns(evaluasiSeksi);
					// })

					// $(document).ready(function(){
					//     var oTable = $('.JurnalPenilaian-evaluasiSeksi').dataTable( {
					//         "sScrollY": "300px",
					//         "sScrollX": "100%",
					//         "sScrollXInner": "150%",
					//         "bScrollCollapse": true,
					//         // "bPaginate": false
					//     } );
					//     new $.fn.dataTable.FixedColumns(oTable).leftColumns(4);
					// });

					$('#JurnalPenilaian-masterBobot').DataTable({
						lengthChange: false,
					});

					$('#JurnalPenilaian-masterKategoriNilai').DataTable();

					$('#JurnalPenilaian-masterRangeNilai').DataTable({
						lengthChange: false,
						searching: false,
						paging: false,
						scrollY: 225,
					});

					$('#JurnalPenilaian-masterKenaikan').DataTable({
						lengthChange: false,
						searching: false,
						paging: false,
						scrollY: 225,
					});

					$('#JurnalPenilaian-masterSuratPeringatan').DataTable({
						lengthChange: false,
					});

					$('#JurnalPenilaian-masterTIM').DataTable({
						lengthChange: false,
					});

					$('#JurnalPenilaian-reportPenilaian').DataTable({
						paging: false,
						scrollX: true,
						scrollY: 400,
						lengthChange: false,
						fixedColumns: {
							leftColumns: 7,
						},
						dom: 'Bfrtip',
						buttons: [
							'excelHtml5', 'print'
						]
					});

					var count_unit = $(".num_record").text();
					for(k=0;k<count_unit;k++)
					{
						$('#tableAssessment'+k+'').DataTable( {
						  destroy: true,
						  lengthChange: false,
					      pageLength: 8,
					    });
					}

			//	}

			// 	Select2
			//	{
					$(".PenilaianKinerja-daftarSeksi").select2({
						allowClear: false,
						placeholder: "Pilih seksi...",
						ajax:
						{
							delay: 500,
							url: baseurl+'PenilaianKinerja/General/cariSeksi',
							dataType:'json',
							data: function(params){
								return {
									term:params.term
								}
							},
							processResults: function(data){
								return {
									results: $.map(data, function(obj){
										return {id: obj.kodesie+' = '+obj.nama_seksi, text: obj.kodesie+' - '+obj.nama_seksi};
									})
								};
							}
						}
					});
			//	}

			//	DateRangePicker
			//	{

					$('.JurnalPenilaian-daterangepicker').daterangepicker({
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

					$('.JurnalPenilaian-daterangepickersingledate').daterangepicker({
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

					$('.JurnalPenilaian-daterangepickersingledatewithtime').daterangepicker({
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
					  console.log("New date range selected: ' + start.format('DD-MM-YYYY H:i:s') + ' to ' + end.format('DD-MM-YYYY H:i:s') + ' (predefined range: ' + label + ')");
					});						

			//	}

			//	Form Behavior
			//	{

					

			//	}
			$('#txtPeriode_pk').datepicker({
			    autoclose: true,
			    format: "yyyy",
			    viewMode: "years", 
			    minViewMode: "years"
			  });

			$('#txtTanggalSKDU').datepicker({
			    autoclose: true,
			    format: "yyyy-mm-dd"
			  });

		});

		function PenilaianKinerja_tambahUnitGroup() 
		{
			var counter 	= 0;
	        var n 			= $('#daftarUnitGroup tr').length;
	        // alert(n);
			counter 		= 0+n;

			$(".PenilaianKinerja-daftarSeksi").select2("destroy");			

	        var newRow = jQuery(				'<tr id="unitGroup">'
													+'<div class="row">'
														+'<td style="text-align: center; vertical-align: middle;width:100px;">'
															+'<button type="button" class="btn btn-danger btn-sm PenilaianKinerja-deleteUnitGroup" onclick="PenilaianKinerja_hapusUnitGroup(this)" >'
																+'<i class="fa fa-times"></i>'
															+'</button>'
														+'</td>'
														+'<td>'
															+'<div class="form-group">'
																+'<input type="text" class="form-control hidden" hidden="" name="idUnitGroup['+counter+']" value="-">'
																+'<input type="text" class="form-control txtnamaUnitGroup" placeholder="Nama Unit Group" style="text-transform: uppercase;" name="txtnamaUnitGroup['+counter+']" />'
															+'</div>'
															+'<div class="form-group">'
																	+'<select name="cmbseksiUnitGroup['+counter+'][]" class="select2 PenilaianKinerja-daftarSeksi" style="width: 100%" multiple="">'
																	+'</select>'
																+'</div>'
														+'</td>'
													+'</div>'
												+'</tr>');
	   		jQuery("#daftarUnitGroup").append(newRow);

			$(".PenilaianKinerja-daftarSeksi").select2({
				allowClear: false,
				placeholder: "Pilih seksi...",
				ajax:
				{
					delay: 500,
					url: baseurl+'PenilaianKinerja/General/cariSeksi',
					dataType:'json',
					data: function(params){
						return {
							term:params.term
						}
					},
					processResults: function(data){
						return {
							results: $.map(data, function(obj){
								return {id: obj.kodesie+' = '+obj.nama_seksi, text: obj.kodesie+' - '+obj.nama_seksi};
							})
						};
					}
				}
			});
			$('.txtnamaUnitGroup:last').val("");
			$('.PenilaianKinerja-deleteUnitGroup:last').removeAttr('data-toggle');
			$('.PenilaianKinerja-deleteUnitGroup:last').removeAttr('data-target');
			$('input[name="idUnitGroup"]:last').val("");	   		
		}

		function PenilaianKinerja_hapusUnitGroup(th) 
		{
			var count = $('#daftarUnitGroup #unitGroup').length;
			if(count<=1)
			{
				alert('Minimal 1 baris!');
			}
			else
			{
				$(th).closest('tr').remove(); 				
			}   		
		}

		function hapusUnitGroup(idUnitGroup, namaUnitGroup)
		{
			$('#hapusUnitGroup').modal('show');
			$('#txtDeleteUnitGroup').html(namaUnitGroup);
			$('input[name="txtDeleteIDUnitGroup"]').val(idUnitGroup);
		}

		function PenilaianKinerja_tambahSKPengurangPrestasi()
		{
	        var n 			= $('#PenilaianKinerja-daftarSKPengurangPrestasi tr').length;
			var newRow 	= jQuery(	'<tr id="PenilaianKinerja-SKPengurangPrestasi">'
										+'<td style="vertical-align: middle; text-align: center;">'
											+(n)
											+'<input type="text" class="hidden form-control" name="txtIDSKPrestasi['+(n-1)+']" value="-" />'
											+'<br/>'
											+'<button type="button" class="btn btn-danger btn-xs" onclick="PenilaianKinerja_hapusInputBaruSKPengurangPrestasi(this)"><i class="fa fa-times"></i></button>'
										+'<td>'
											+'<input type="number" class="form-control" min="0" step="1" value="0" name="txtBatasBawahJumlahSKPrestasi['+(n-1)+']" />'
										+'</td>'
										+'<td>'
											+'<input type="number" class="form-control" min="0" step="1" value="0" name="txtBatasAtasJumlahSKPrestasi['+(n-1)+']" />'
										+'</td>'
										+'<td>'
											+'<input type="number" class="form-control" min="0" step="1" value="0" name="txtPengurangSKPrestasi['+(n-1)+']"></input>'
										+'</td>'
									+'</tr>');
	   		jQuery("#PenilaianKinerja-daftarSKPengurangPrestasi").append(newRow);
		}

		function PenilaianKinerja_hapusInputBaruSKPengurangPrestasi(th)
		{
			var count = $('#PenilaianKinerja-daftarSKPengurangPrestasi #PenilaianKinerja-SKPengurangPrestasi').length;
			if(count<=1)
			{
				alert('Minimal 1 baris!');
			}
			else
			{
				$(th).closest('tr').remove(); 				
			} 			
		}

		function PenilaianKinerja_hapusDataSKPengurangPrestasi(id)
		{
			$('#deleteSKPengurangPrestasi').modal('show');
			$('#txtIDSKPrestasiDelete').val(id);

		}

		function PenilaianKinerja_tambahSKPengurangKemauan()
		{
	        var n 		= $('#PenilaianKinerja-daftarSKPengurangKemauan tr').length;
			var newRow 	= jQuery(	'<tr id="PenilaianKinerja-SKPengurangKemauan">'
										+'<td style="vertical-align: middle; text-align: center;">'
											+(n)
											+'<input type="text" class="hidden form-control" name="txtIDSKKemauan['+(n-1)+']" value="-" />'
											+'<br/>'
											+'<button type="button" class="btn btn-danger btn-xs" onclick="PenilaianKinerja_hapusInputBaruSKPengurangKemauan(this)"><i class="fa fa-times"></i></button>'
										+'</td>'
										+'<td>'
											+'<input type="number" class="form-control" min="0" step="1" value="0" name="txtBatasBawahJumlahSKKemauan['+(n-1)+']" />'
										+'</td>'
										+'<td>'
											+'<input type="number" class="form-control" min="0" step="1" value="0" name="txtBatasAtasJumlahSKKemauan['+(n-1)+']" />'
										+'</td>'
										+'<td>'
											+'<input type="number" class="form-control" min="0" step="1" value="0" name="txtPengurangSKKemauan['+(n-1)+']"></input>'
										+'</td>'
									+'</tr>');
	   		jQuery("#PenilaianKinerja-daftarSKPengurangKemauan").append(newRow);			
		}

		function PenilaianKinerja_hapusInputBaruSKPengurangKemauan(th)
		{
			var count = $('#PenilaianKinerja-daftarSKPengurangKemauan #PenilaianKinerja-SKPengurangKemauan').length;
			if(count<=1)
			{
				alert('Minimal 1 baris!');
			}
			else
			{
				$(th).closest('tr').remove(); 				
			} 			
		}

		function PenilaianKinerja_hapusDataSKPengurangKemauan(id)
		{
			$('#deleteSKPengurangKemauan').modal('show');
			$('#txtIDSKKemauanDelete').val(id);

		}		

		function hapusJurnalPenilaian(periode)
		{
			$('#hapusJurnalPenilaian').modal('show');
			$('#labelPeriode').html(periode);
			$('#periodeJurnalPernilaian').val(periode);
		}


//	}
// 	Penilaian Kinerja ---------------------------------------------------- end
