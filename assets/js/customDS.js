// 	Document Controller --------------------------------------------------------------------------start---
// 	{
		$(function()
		{
//			Input Mask
//			{
    			// $(".inputmask-date").inputmask("dd-mm-yyyy");		
//			}

// 			DataTables Main Menu
// 			{
				$('#dataTables-allDocument').DataTable({
					// "lengthChange": false,
					// "responsive": false,
					"scrollX": true,
					// "scroller": true,
					// "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
					// "pagingType": "full_numbers",
				});	
				$('#dataTables-businessProcess').DataTable({
					// "lengthChange": false,
					// "responsive": false,
					"scrollX": true,
					// "scroller": true,
					// "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
					// "pagingType": "full_numbers",
				});
				$('#dataTables-contextDiagram').DataTable({
					// "lengthChange": false,
					// "responsive": false,
					"scrollX": true,
					// "scroller": true,
					// "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
					// "pagingType": "full_numbers",
				});
				$('#dataTables-standardOperatingProcedure').DataTable({
					// "lengthChange": false,
					// "responsive": false,
					"scrollX": true,
					// "scroller": true,
					// "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
					// "pagingType": "full_numbers",
				});
				$('#dataTables-workInstruction').DataTable({
					// "lengthChange": false,
					// "responsive": false,
					"scrollX": true,
					// "scroller": true,
					// "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
					// "pagingType": "full_numbers",
				});
				$('#dataTables-COP').DataTable({
					// "lengthChange": false,
					"scrollX": true,
					// "scroller": true,
					// "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
					// "pagingType": "full_numbers",
				});
				// $('#dataTables-flowProcess').DataTable({
					// "lengthChange": false,
					// "responsive": false,
					// "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
					// "pagingType": "full_numbers",
				// });
				$('#dataTables-masterJobDescription').DataTable({
					// "lengthChange": true,
					// "responsive": false,
					"scrollX": true,
					// "scroller": true,
					// "fixedColumns" : true,
			  // 		"fixedColumns" : {
					// 	"leftColumns" : 3
					// },
					// "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
					// "pagingType": "full_numbers",
				});
				$('#dataTables-documentJobDescription').DataTable({
					// "lengthChange": false,
					// "responsive": false,
					"scrollX": true,
					// "scroller": true,
					// "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
					// "pagingType": "full_numbers",
				});
				$('#dataTables-jobDescriptionPekerja').DataTable({
			  //       lengthChange: true,
			  //       responsive: false,
			        scrollX:        true,
			  //       scrollCollapse: true,
			  //       paging:         true,
			  //       deferRender : true,
					// "lengthChange": true,
					// "responsive": false,
					// "scrollX": true,
					// "scroller": true,
					// fixedColumns: {
				 //        leftColumns: 3
				 //    },
					// "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
					// "pagingType": "full_numbers",
				});
				// $('#dataTables-DokumenPekerja-cariDokumen').DataTable({
					// "lengthChange": false,
     //    			"pageLength": 50,
					// "searching": false,
					// "responsive": {
					// 	details: false
					// }
					// ,
					// "scrollX": true,
					// fixedColumns:{
					// 	leftColumns: 3
					// },
					// scrollX: true,
					// "scroller": true,
			  //       dom: 'Bfrtip',
			  //       "pageLength": 10,
			  //       lengthMenu: [
			  //           [ 10, 25, 50, -1 ],
			  //           [ '10 rows', '25 rows', '50 rows', 'Show all' ]
			  //       ],
			  //       buttons: [
			  //           'pageLength'
			  //       ],
			  //       // scrollY:        "300px",
     //    			scrollCollapse: true,
     //    			paging:         false,
     //    			fixedColumns:   {
     //        			leftColumns: 3
     //    			},
     //    			scrollX:        true,
			  //       "lengthMenu": [[25, 50, 100, 500, 1000],[25, 50, 100, 500, "Max"]],
					// "pagingType": "full_numbers",
				// });			

//			}
//
// 			DateRangePicker
// 			{
				$('.DocumentStandarization-daterangepicker').daterangepicker({
				    "showDropdowns": true,
				    "autoApply": true,
				    "locale": {
				        "format": "DD-MM-YYYY",
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

				$('.DocumentStandarization-daterangepickersingledate').daterangepicker({
				    "singleDatePicker": true,
				    "showDropdowns": true,
				    "autoApply": true,
				    "mask": true,
				    "locale": {
				        "format": "DD-MM-YYYY",
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

				$('.DocumentStandarization-daterangepickersingledatewithtime').daterangepicker({
				    "timePicker": true,
				    "timePicker24Hour": true,
				    "singleDatePicker": true,
				    "showDropdowns": true,
				    "autoApply": true,
				    "locale": {
				        "format": "DD-MM-YYYY HH:mm",
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
// 			}

// 			Select2 AJAX
// 			{
				$('#cmbPekerjaPembuat').select2(
				{
					allowClear: true,
					placeholder: "Pilih",
					minimumInputLength: 4,
					ajax: 
					{
						url: baseurl+'DocumentStandarization/General/cariPekerjaPembuat',
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
									return {id: obj.id_pekerja, text: obj.nomor_induk+' - '+obj.nama_pekerja};
								})
							};
						}
					}
				});

				$('#cmbPekerjaPemeriksa1').select2(
				{
					allowClear: true,
					placeholder: "Pilih",
					minimumInputLength: 4,
					ajax: 
					{
						url: baseurl+'DocumentStandarization/General/cariPekerjaPemeriksa1',
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
									return {id: obj.id_pekerja, text: obj.nomor_induk+' - '+obj.nama_pekerja};
								})
							};
						}
					}
				});

				$('#cmbPekerjaPemeriksa2').select2(
				{
					allowClear: true,
					placeholder: "Pilih",
					minimumInputLength: 4,
					ajax: 
					{
						url: baseurl+'DocumentStandarization/General/cariPekerjaPemeriksa2',
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
									return {id: obj.id_pekerja, text: obj.nomor_induk+' - '+obj.nama_pekerja};
								})
							};
						}
					}
				});

				// Untuk toleransi agar Pekerja Pemberi Keputusan yang masih status Kepala Seksi bisa diinputkan.
				$('#cmbPekerjaPemberiKeputusan').select2(
				{
					allowClear: true,
					placeholder: "Pilih",
					minimumInputLength: 4,
					ajax: 
					{
						url: baseurl+'DocumentStandarization/General/cariPekerjaPemeriksa1',
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
									return {id: obj.id_pekerja, text: obj.nomor_induk+' - '+obj.nama_pekerja};
								})
							};
						}
					}
				});

				$('.cmbDokumenJobDescription').select2(
				{
					placeholder: "Pilih",
					ajax: 
					{
						url: baseurl+'DocumentStandarization/General/cariDokumenJobDescription',
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
									return {id: obj.kode_dokumen, text: obj.daftar_nama_dokumen};
								})
							};
						}
					}
				});


				$(document).on('change', '#cmbDepartemen', function(){
					var departemen = $(this).val();

					$('#cmbBidang').select2('val','');
					$('#cmbUnit').select2('val','');
					$('#cmbSeksi').select2('val','');

					$('#cmbBidang').select2(
					{
						allowClear: true,
						placeholder: "Pilih",
						ajax: 
						{
							url: baseurl+'DocumentStandarization/General/cariBidang',
							dataType: 'json',
							data: function (params){
								return {
									term: params.term,
									departemen: departemen
								}
							},
							processResults: function(data) {
								return {
									results: $.map(data, function(obj){
										return {id: obj.kode_bidang, text: obj.nama_bidang};
									})
								};
							}
						}
					});
				});

				$(document).on('change', '#cmbBidang', function(){
					var bidang 		= $(this).val();
					
					$('#cmbUnit').select2('val','');
					$('#cmbSeksi').select2('val','');					
					$('#cmbUnit').select2(
					{
						allowClear: true,
						placeholder: "Pilih",
						ajax: 
						{
							url: baseurl+'DocumentStandarization/General/cariUnit',
							dataType: 'json',
							data: function (params){
								return {
									term: params.term,
									bidang: bidang
								}
							},
							processResults: function(data) {
								return {
									results: $.map(data, function(obj){
										return {id: obj.kode_unit, text: obj.nama_unit};
									})
								};
							}
						}
					});
				});

				$(document).on('change', '#cmbUnit', function(){
					var unit 		= $(this).val();

					$('#cmbSeksi').select2('val','');
					$('#cmbSeksi').select2(
					{
						allowClear: true,
						placeholder: "Pilih",
						ajax: 
						{
							url: baseurl+'DocumentStandarization/General/cariSeksi',
							dataType: 'json',
							data: function (params){
								return {
									term: params.term,
									unit: unit
								}
							},
							processResults: function(data) {
								return {
									results: $.map(data, function(obj){
										return {id: obj.kode_seksi, text: obj.nama_seksi};
									})
								};
							}
						}
					});
				});

				$(document).on('change', '#cmbDepartemen-DocumentJobDesc', function(){
					var departemen = $(this).val();

					$('#cmbBidang-DocumentJobDesc').select2('val','');
					$('#cmbPekerja-JobDesc').select2('val','');
					// $('#cmbUnit-DocumentJobDesc').select2('val','');
					// $('#cmbSeksi-DocumentJobDesc').select2('val','');
					// $('#cmbJD').select2('val','');

					$('#cmbBidang-DocumentJobDesc').select2(
					{
						allowClear: true,
						placeholder: "Pilih",
						ajax: 
						{
							url: baseurl+'DocumentStandarization/General/cariBidang',
							dataType: 'json',
							data: function (params){
								return {
									term: params.term,
									departemen: departemen
								}
							},
							processResults: function(data) {
								return {
									results: $.map(data, function(obj){
										return {id: obj.kode_bidang, text: obj.nama_bidang};
									})
								};
							}
						}
					});

					$('#cmbPekerja-JobDesc').select2(
					{
						allowClear: false,
						placeholder: "Pilih",
						ajax: 
						{
							url: baseurl+'DocumentStandarization/General/cariPekerjaAktifBerdasarHirarki',
							dataType: 'json',
							data: function (params){
								return {
									term: params.term,
									kodesie: departemen
								}
							},
							processResults: function(data) {
								return {
									results: $.map(data, function(obj){
										return {id: obj.nomor_induk_pekerja, text: obj.nomor_induk_pekerja+' - '+obj.nama_pekerja};
									})
								};
							}
						}
					});

					$('#cmbJD').select2(
					{
						allowClear: false,
						placeholder: "Pilih",
						ajax: 
						{
							url: baseurl+'DocumentStandarization/General/cariJobDesc',
							dataType: 'json',
							data: function (params){
								return {
									term: params.term,
									kodesie: departemen
								}
							},
							processResults: function(data) {
								return {
									results: $.map(data, function(obj){
										return {id: obj.id_job_description, text: obj.nama_job_description};
									})
								};
							}
						}
					});

				});

				$(document).on('change', '#cmbBidang-DocumentJobDesc', function(){
					var bidang 		= $(this).val();
					
					$('#cmbUnit-DocumentJobDesc').select2('val','');
					$('#cmbSeksi-DocumentJobDesc').select2('val','');
					$('#cmbPekerja-JobDesc').select2('val', '');
					$('#cmbUnit-DocumentJobDesc').select2(
					{
						allowClear: true,
						placeholder: "Pilih",
						ajax: 
						{
							url: baseurl+'DocumentStandarization/General/cariUnit',
							dataType: 'json',
							data: function (params){
								return {
									term: params.term,
									bidang: bidang
								}
							},
							processResults: function(data) {
								return {
									results: $.map(data, function(obj){
										return {id: obj.kode_unit, text: obj.nama_unit};
									})
								};
							}
						}
					});

					$('#cmbPekerja-JobDesc').select2(
					{
						allowClear: false,
						placeholder: "Pilih",
						ajax: 
						{
							url: baseurl+'DocumentStandarization/General/cariPekerjaAktifBerdasarHirarki',
							dataType: 'json',
							data: function (params){
								return {
									term: params.term,
									kodesie: bidang
								}
							},
							processResults: function(data) {
								return {
									results: $.map(data, function(obj){
										return {id: obj.nomor_induk_pekerja, text: obj.nomor_induk_pekerja+' - '+obj.nama_pekerja};
									})
								};
							}
						}
					});

					$('#cmbJD').select2(
					{
						allowClear: true,
						placeholder: "Pilih",
						ajax: 
						{
							url: baseurl+'DocumentStandarization/General/cariJobDesc',
							dataType: 'json',
							data: function (params){
								return {
									term: params.term,
									kodesie: bidang
								}
							},
							processResults: function(data) {
								return {
									results: $.map(data, function(obj){
										return {id: obj.id_job_description, text: obj.nama_job_description};
									})
								};
							}
						}
					});

				});

				$(document).on('change', '#cmbUnit-DocumentJobDesc', function(){
					var unit 		= $(this).val();

					$('#cmbSeksi-DocumentJobDesc').select2('val','');
					$('#cmbPekerja-JobDesc').select2('val', '');
					$('#cmbJD').select2('val','');
					$('#cmbSeksi-DocumentJobDesc').select2(
					{
						allowClear: true,
						placeholder: "Pilih",
						ajax: 
						{
							url: baseurl+'DocumentStandarization/General/cariSeksi',
							dataType: 'json',
							data: function (params){
								return {
									term: params.term,
									unit: unit
								}
							},
							processResults: function(data) {
								return {
									results: $.map(data, function(obj){
										return {id: obj.kode_seksi, text: obj.nama_seksi};
									})
								};
							}
						}
					});

					$('#cmbPekerja-JobDesc').select2(
					{
						allowClear: false,
						placeholder: "Pilih",
						ajax: 
						{
							url: baseurl+'DocumentStandarization/General/cariPekerjaAktifBerdasarHirarki',
							dataType: 'json',
							data: function (params){
								return {
									term: params.term,
									kodesie: unit
								}
							},
							processResults: function(data) {
								return {
									results: $.map(data, function(obj){
										return {id: obj.nomor_induk_pekerja, text: obj.nomor_induk_pekerja+' - '+obj.nama_pekerja};
									})
								};
							}
						}
					});

					$('#cmbJD').select2(
					{
						allowClear: true,
						placeholder: "Pilih",
						ajax: 
						{
							url: baseurl+'DocumentStandarization/General/cariJobDesc',
							dataType: 'json',
							data: function (params){
								return {
									term: params.term,
									kodesie: unit
								}
							},
							processResults: function(data) {
								return {
									results: $.map(data, function(obj){
										return {id: obj.id_job_description, text: obj.nama_job_description};
									})
								};
							}
						}
					});

				});

				$(document).on('change', '#cmbSeksi-DocumentJobDesc', function(){
					var seksi 		= $(this).val();
					$('#cmbPekerja-JobDesc').select2('val', '');
					$('#cmbJD').select2('val','');
					$('#cmbJD').select2(
					{
						allowClear: false,
						placeholder: "Pilih",
						ajax: 
						{
							url: baseurl+'DocumentStandarization/General/cariJobDesc',
							dataType: 'json',
							data: function (params){
								return {
									term: params.term,
									kodesie: seksi
								}
							},
							processResults: function(data) {
								return {
									results: $.map(data, function(obj){
										return {id: obj.id_job_description, text: obj.nama_job_description};
									})
								};
							}
						}
					});

					$('#cmbPekerja-JobDesc').select2(
					{
						allowClear: false,
						placeholder: "Pilih",
						ajax: 
						{
							url: baseurl+'DocumentStandarization/General/cariPekerjaAktifBerdasarHirarki',
							dataType: 'json',
							data: function (params){
								return {
									term: params.term,
									kodesie: seksi
								}
							},
							processResults: function(data) {
								return {
									results: $.map(data, function(obj){
										return {id: obj.nomor_induk_pekerja, text: obj.nomor_induk_pekerja+' - '+obj.nama_pekerja};
									})
								};
							}
						}
					});

				});

				// $('#cmbJD').select2(
				// {
				// 	allowClear: false,
				// 	placeholder: "Pilih",
				// 	minimumInputLength: 4,
				// 	ajax: 
				// 	{
				// 		url: baseurl+'DocumentStandarization/General/cariJobDescription',
				// 		dataType: 'json',
				// 		delay: 500,
				// 		data: function (params){
				// 			return {
				// 				term: params.term
				// 			}
				// 		},
				// 		processResults: function(data) {
				// 			return {
				// 				results: $.map(data, function(obj){
				// 					return {id: obj.id_job_description, text: obj.nama_job_description};
				// 				})
				// 			};
				// 		}
				// 	}
				// });

//			}

//			QTip
//			{
				$('.bubbletip-character').qtip({
					content: {
						text: 'Jangan gunakan karakter "$+/:;=?@<>#%{}|\^~[]`"!'
					},
					style: {
						def: true
					},
				});

				$('#bubbletip-checkboxRevisi').qtip({
					content: {
						text: 'Check jika perubahan yang dilakukan adalah revisi baru dokumen.'
					},
					style: {
						def: true
					},
				});

				$('#txtTanggalHeader').qtip({
					content: {
						text: 'Ctrl+A terlebih dahulu jika akan input manual.'
					}
				})
//			}

// 			Form Behavior
//			{
				// $(document).ready(function(){
				    $(".sensitive-input").keypress(function(event){
				        var inputValue = event.which;
				        // allow letters and whitespaces only.
				        if(		inputValue != 32 && inputValue != 0 && inputValue!=39 && inputValue!=38 && inputValue!=95 && inputValue!=8 && inputValue!=40 && inputValue!= 41 &&
				        		!(inputValue>=43 && inputValue<=46) &&
				        		!(inputValue>=48 && inputValue<=57) &&
				        		!(inputValue>=65 && inputValue<=90) && 
				        		!(inputValue>=97 && inputValue<=122)
				        ) { 
				            event.preventDefault(); 
				        }
				    });


 

					$(document).on('click', '#deleteUpdateKecelakaan', function(){
					  var   id  =   $(this).attr('data-id');
					  var ini = $(this);
					  if(id!=null || id!='')
					  {
					    $.ajax(
					    {
					      type: 'POST',
					      url: baseurl+'GeneralAffair/FleetKecelakaan/deleteBarisDetail/'+id,
					      success: function()
					      {
					        ini.closest('tr').remove();
					      }
					    })
					  }
					});

//			}

//			iCheck
//			{
				$('input[name=checkboxRevisi]').iCheck({
					checkboxClass: 'icheckbox_flat-blue',
					radioClass: 'iradio_flat-blue'
				});
//			}

//			Bootstrap
// 			{
			    $(document).ready(function(){
			    	var highestBox = 0;
			        	$('.btn-group-vertical .buttonlistDocUpper').each(function(){  
			          		if($(this).height() > highestBox){  
			                	highestBox = $(this).height();  
			        	}
			    		});
			  		  $('.btn-group-vertical .buttonlistDocUpper').height(highestBox);

    				var largestBox = 0;
        			$('.btn-group-vertical .btn').each(function(){  
                		if($(this).width() > largestBox){  
                			largestBox = $(this).width();  
        				}
    				});
    				$('.btn-group-vertical .buttonlistDoc').width(largestBox);
				});
//			}

//			Iframe Dokumen Pekerja
//			{
				$(document).on('change', '#DokumenPekerja-COP', function(){
					var link_dokumen 	= 	$(this).val();
					var iframe = document.getElementById('DokumenPekerja-previewDokumen');
					iframe.src = link_dokumen;

				});
//			}


		});
//			General Behavior
//			{
				function previousPage()
				{
					window.history.back();
				};

				function TambahBarisDokumenJobDescription(base){  
					var newgroup = $('<tr>').addClass('clone');
					var e = jQuery.Event( "click" );
					e.preventDefault();
					$("select#cmbDokumenJobDescription:last").select2("destroy");

					$('.clone').last().clone().appendTo(newgroup).appendTo('#DokumenJobDescription');




					$(".cmbDokumenJobDescription").select2({
						placeholder: "Pilih",
						ajax: 
						{
							url: baseurl+'DocumentStandarization/General/cariDokumenJobDescription',
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
									return {id: obj.kode_dokumen, text: obj.daftar_nama_dokumen};
								})
							};
						}
					}
					});

					$(".cmbDokumenJobDescription:last").select2({
						placeholder: "Pilih",
						ajax: 
						{
							url: baseurl+'DocumentStandarization/General/cariDokumenJobDescription',
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
										return {id: obj.kode_dokumen, text: obj.daftar_nama_dokumen};
									})
								};
							}
						}
					});
					$(".cmbDokumenJobDescription:last").select2("val", "");
					$(".hdndetailDokumenJobDesc:last").val("").change();
					var count = $('.clone').length;
					$('#rowid').html(count);
				};
				function delSpesifikRowDokumenJobDescriptionCreate(th) {
					var count = $('.clone').length;
					if(count<=1)
					{
						alert('Minimal 1 baris!');
					}
					else
					{
						$(th).closest('tr').remove(); 				
					}   					   			  
				}

				setInterval(function() {
	  				$('#DokumenJobDescription tr').each(function (idx) {
	     				$(this).children("#DokumenJobDescription tr td:eq(0)").html(idx + 1);
	  				});
				}, 400);
//			}  

		//	Individual Functions
		//	{
				$(document).ready(function() {
				    // Setup - add a text input to each footer cell
				    $('#dataTables-DokumenPekerja-cariDokumen tfoot th').each( function () {
				        var title = $(this).text();
				        $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
				    } );
				 
				    // DataTable
				    var table = $('#dataTables-DokumenPekerja-cariDokumen').DataTable({
				    	ordering: false,
				    });
				 
				    // Apply the search
				    table.columns().every( function () {
				        var that = this;
				        console.log($( 'input', this.footer() ));
				        $( 'input', this.footer() ).on( 'keyup change', function () {
				            if ( that.search() !== this.value ) {
				                that
				                    .search( this.value )
				                    .draw();
				            }
				        } );
				    } );
				} );				
		//	}
// 	}

// 	Document Controller ----------------------------------------------------------------------------end---