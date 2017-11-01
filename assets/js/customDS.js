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
					"lengthChange": false,
					"responsive": true,
					"scrollX": true,
					"scroller": true
				});	
				$('#dataTables-businessProcess').DataTable({
					"lengthChange": false,
					"responsive": true,
					"scrollX": true,
					"scroller": true
				});
				$('#dataTables-contextDiagram').DataTable({
					"lengthChange": false,
					"responsive": true,
					"scrollX": true,
					"scroller": true
				});
				$('#dataTables-standardOperatingProcedure').DataTable({
					"lengthChange": false,
					"responsive": true,
					"scrollX": true,
					"scroller": true
				});
				$('#dataTables-workInstruction').DataTable({
					"lengthChange": false,
					"responsive": true,
					"scrollX": true,
					"scroller": true
				});
				$('#dataTables-COP').DataTable({
					"lengthChange": false,
					"scrollX": true,
					"scroller": true
				});
				$('#dataTables-flowProcess').DataTable({
					"lengthChange": false,
					"responsive": true
				});
				$('#dataTables-masterJobDescription').DataTable({
					"lengthChange": false,
					"responsive": true,
					"scrollX": true,
					"scroller": true
				});
				$('#dataTables-documentJobDescription').DataTable({
					"lengthChange": false,
					"responsive": true,
					"scrollX": true,
					"scroller": true
				});
				$('#dataTables-jobdeskEmployee').DataTable({
					"lengthChange": false,
					"responsive": true,
					"scrollX": true,
					"scroller": true
				});
				$('#dataTables-Pekerja-cariDokumen').DataTable({
					"lengthChange": false,
					"responsive": true,
					"scrollX": true,
					"scroller": true
				});

//			}
//
// 			DateRangePicker
// 			{
				$('.daterangepicker').daterangepicker({
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

				$('.daterangepickersingledate').daterangepicker({
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

				$('.daterangepickersingledatewithtime').daterangepicker({
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
				}, 10);
//			}  
// 	}

// 	Document Controller ----------------------------------------------------------------------------end---