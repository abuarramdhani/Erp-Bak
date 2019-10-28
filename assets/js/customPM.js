$(document).ready(function() {
	$("div#loading1").hide();
	$("div#loading2").hide();
	$("div#loading3").hide();
	$("div#loading4").hide();
	//========
	// JAVASCRIPT & JQUERY PRESENCE MANAGEMENT > PIC : ALFIAN AFIEF N
	//======== START
	$('#datatable-presensi-presence-management').dataTable({
	 // "bLengthChange": false,
	 // "ordering": false
	});

	// $('#data-presensi-data-pekerja').dataTable({
	//  	'paging'      : true,
	// });
	//
	$('#registered-presensi').dataTable({
	 "bLengthChange": false,
	 "ordering": false,
	 "scrollX": true
	});
	
	$('#confirm-delete').on('show.bs.modal', function(e) {
		$(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
	});
	
	$(document).on("click", ".modalmutation", function () {
		 var id = $(this).data('id');
		 var name = $(this).data('filter');
		 $(".modal-body #txtID").val(id);
		 $(".modal-body #txtNoind").text(id);
		 $(".modal-body #txtName").text(name);
	});
	
	$(document).on("click", ".btn-delete-finger", function () {
		alert('test');
	});
	
	$(document).on("click", ".modalcheckfinger", function () {
		 var id = $(this).data('id');
		 var name = $(this).data('filter');
		 $(".modal-body #txtID").val(id);
		 $(".modal-body #txtNoind").text(id);
		 $(".modal-body #txtName").text(name);
	});
	
	$(document).on("click", "#modaladd", function () {
		 var id = $(this).data('id');
		 $(".modal-body #txtID").val(id);
	});
	
	$(document).on("click", ".modalchangelocationname", function () {
		 var loc = $(this).data('filter');
		 var name = $(this).data('id');
		 $(".modal-body #txtLocation").val(loc);
		 $(".modal-body #txtName").val(name);
	});
	
	$(document).on("click", ".distribusi-presensi", function () {
		 var loc = $(this).data('filter');
		 var name = $(this).data('id');
		 $(".modal-body #txtLocation").val(loc);
		 $(".modal-body #txtName").val(name);
	});
	
	$(document).on("click", "#refreshRegPers", function () {
		   window.open('http://quick.com/aplikasi/cronjob/cronjob.fphrdkhs.php','_blank');
	});
	
	$(document).on("click", "#refreshFinger", function () {
		   window.open('http://quick.com/aplikasi/cronjob/cronjob.fpupdatefingerlocal.php','_blank');
	});
	
	$(document).on("click", "#updateFinger", function () {
		   window.open('http://quick.com/aplikasi/cronjob/cronjob.fpupdatefingerquickcom.php','_blank');
	});
	
	$(".select-presence").select2({
			allowClear: true,
			placeholder: "[ Select Noind or Name ]",
			minimumInputLength: 1,
			ajax: {
				url:baseurl+"PresenceManagement/Monitoring/JsonNoind",
				dataType: 'json',
				type: "GET",
				data: function (params) {
					var queryParameters = {
						term: params.term,
						loc : $("#txtLocation").val()
					}
					return queryParameters;
				},
				processResults: function (data) {
					return {
						results: $.map(data, function(obj) {
							return { id: obj.noind, text: obj.noind +" / "+ obj.nama.toUpperCase() };
						})
					};
				}
			}
		});
		
		$(".select-presence-section").select2({
			allowClear: true,
			placeholder: "[ Select Section or ID Section ]",
			minimumInputLength: 1,
			ajax: {
				url:baseurl+"PresenceManagement/Monitoring/JsonSection",
				dataType: 'json',
				type: "GET",
				data: function (params) {
					var queryParameters = {
						term: params.term,
						loc : $("#txtLocation").val()
					}
					return queryParameters;
				},
				processResults: function (data) {
					return {
						results: $.map(data, function(obj) {
							return { id: obj.kodesie, text: obj.kodesie +" / "+ obj.seksi.toUpperCase() };
						})
					};
				}
			}
		});
		
	$(".select2-location-single-access").select2({
			allowClear: true,
			tags: true,
			placeholder: "[ Select Location Device ]",
			minimumInputLength: 0,
			ajax: {
				delay: 500,
				url:baseurl+"PresenceManagement/Monitoring/JsonLocation",
				dataType: 'json',
				type: "GET",
				data: function (params) {
					var queryParameters = {
						term: params.term
					}
					return queryParameters;
				},
				processResults: function (data) {
					return {
						results: $.map(data, function(obj) {
							return { id: obj.id_lokasi, text: obj.lokasi };
						})
					};
				}
			}
		});
		
	//========================
	// END PRESENCE MANAGEMENT
	//========================
	setTimeout(function(){$(".alert").slideUp();}, 1000);
	
	$("#datatable-presensi tbody tr").each(function() {
		var con = $(this).find("#stat_con").html(); 
		if( con == "0"){
			$(this).find("#btn-reg-person").addClass("disabled");
			$(this).find("#btn-change-name").addClass("disabled");
		}
	});
	
	$(document).on("click", "#refresh-cronjob-hrd", function () {
		$.ajax({
			url 	: baseurl + 'PresenceManagement/Cronjob/CronjobRefreshDatabase',
			beforeSend	: function(){
									 $("#loading2").slideDown();
								   },
			complete		: function(){
									 $("#loading2").slideUp();
								   },
			success:  function (data) {
				alert(data);
			}
		});
	});
	
	$(document).on("click", "#update-section-cronjob-hrd", function () {
		$.ajax({
			url 	: baseurl + 'PresenceManagement/Cronjob/UpdateSection',
			beforeSend	: function(){
									 $("#loading3").slideDown();
								   },
			complete		: function(){
									 $("#loading3").slideUp();
								   },
			success:  function (data) {
				alert(data);
			}
		});
	});
	
	
	$('#fr_start').daterangepicker({
			"singleDatePicker": true,
			"timePicker": false,
			"timePicker24Hour": true,
			"showDropdowns": true,
			locale: {
					format: 'YYYY-MM-DD'
				},
		});
		
		$('#fr_end').daterangepicker({
			"singleDatePicker": true,
			"timePicker": false,
			"timePicker24Hour": true,
			"showDropdowns": true,
			locale: {
					format: 'YYYY-MM-DD'
				},
		});
		
		$(document).on("click", ".btn-distribute-presence", function () {
			var start	= $("input#fr_start").val();
			var end		= $("input#fr_end").val();
			if( start == '' || end == ''){
				alert('plesae complete your fill data !!!');
			}else{
				window.open("http://personalia.quick.com/cronjob/postgres/fingerprint/cronjob.frontpresensi.tpresensi.all.php?start="+start+"&end="+end+"", '_blank');
			}
		});
		
		$(document).on("click", ".release_presence", function () {
			var start	= $("input#txtLoc").val();
			var end		= $("input#txtStart").val();
			var loc		= $("input#txtEnd").val();
			if( start == '' || end == ''){
				alert('plesae complete your fill data !!!');
			}else{
				window.open("http://personalia.quick.com/cronjob/postgres/fingerprint/cronjob.frontpresensi.tpresensi.loc.php?start="+start+"&end="+end+"&loc="+loc+"", '_blank');
			}
		});
		
		$(document).on("click", "#execute-cronjob-hrd", function () {
				window.open("http://personalia.quick.com/cronjob/postgres/fingerprint/cronjob.presence.monitoring.php", '_blank');
		});
		
		$(document).on("click", "#update-fingercode", function () {
				window.open("http://quick.com/aplikasi/cronjob/cronjob.dbupdatefinger.php", '_blank');
		});
		
		var host	= window.location.origin;
		var url_loc	= baseurl+"PresenceManagement/Monitoring";
		var url_mon	= window.location.href;
		if(url_mon == url_loc){
			setTimeout(function(){
				window.location.href = url_loc;
			  }, 60000);
		}
		
	// $(document).on("click", "a[href='"+baseurl+"PresenceManagement/Monitoring']", function () {
		// alert('test'); 
	// });
	
	$(document).on("click", ".btn-refresh-db", function () {
		$('#modal-loader').modal('show');
	});

	$(document).on("change", "#txtLocation", function () {
		 var loc = $('#txtLocation').val();
		 var host	= window.location.origin;
		 $.ajax({
			  type:"POST",
			  dataType: 'html',
			  url: baseurl+"PresenceManagement/Monitoring/SwitchTable",
			  data: {loc:loc},
			  success: function(data) {
			  	$('#btn-excel').removeClass('hidden');
			  	$('#excelLokasi').val(loc);
				$('#datatable-presensi-presence-management tbody').html(data);
				$('#desLocationSection').val(loc);
				$('#desLocationPerson').val(loc);
				$('#txtLocation-Mutation').val(loc);
			  }
			});
	});
	//========================================================
	//				SKRONISASI PRESENCE MANAGEMENT
	//========================================================
	var url_loc2	= baseurl+"PresenceManagement/Monitoring/ListPresensi";
	if(url_mon.slice(0,-3) == url_loc2){
		var rows=0;
		$("#table-finger-per-lokasi tbody tr").each(function() {
			rows = rows+1;
			var loc = $('span#txtloc'+rows).text();
			$.ajax({
			  type:"POST",
			  dataType: 'json',
			  url: baseurl+"PresenceManagement/Monitoring/LoadPresensiFinger",
			  data: {loc:loc},
			  success: function(data) {
				$('span#txtnum'+rows).text(data);
			  }
			});
		});
	}

	$(document).on('click', '.pagination', function() {
		$('.select_lokasi_finger').select2({
		ajax: {
		  	url: baseurl+"PresenceManagement/Monitoring/LokasiKerja",
		  	dataType: 'json',
		  	type: 'get',
		  	data: function(params){
		  		return { p: params.term };
		  	},
		  	processResults: function (data) {
		  		return {
		  			results: $.map(data, function(item) {
		  				return {
		  					id: item.id_lokasi,
		  					text: item.lokasi,
		  				}
		  			})
		  		};
		  	},
		  	cache: true
		  },
		  minimumInputLength: 2,
		  placeholder: 'Select Lokasi Kerja',
		  allowClear: true,
		});
	});

	$('.select-nama').select2({
		ajax: {
		    url: baseurl+"PresenceManagement/Monitoring/pekerja",
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
	  allowClear: true,
	});

	function SelectNama(){
		var val = $('#NamaPekerja').val();
		if (val) {
			$('#CariLokasiPekerja').removeAttr('disabled', 'disabled'); 
		    $('#CariLokasiPekerja').removeClass('disabled'); 
		  }else{
		    $('#CariLokasiPekerja').attr('disabled', 'disabled');
		    $('#CariLokasiPekerja').addClass('disabled', 'disabled');
		  }
	}

	$(document).on('change', '#NamaPekerja', function() {
		SelectNama();
	});

	$(document).on('click', '#CariLokasiPekerja', function(e) {
		e.preventDefault();
		var nama = $('#NamaPekerja').val();
		$.ajax({
			url: baseurl+"PresenceManagement/Monitoring/DataLokasiFinger",
		    type: "get",
		    data: {nama: nama}
		}).done(function(data) {
			var html = '';
			var data = $.parseJSON(data);
			
			var lokasi = data['cariLokasiFinger'][0]['lokasi'];
			var idlokasi = data['cariLokasiFinger'][0]['id_lokasi'];

			if (lokasi && idlokasi) {
				var lokasiSplit = lokasi.split(',');
				var idlokasiSplit = idlokasi.split(',');
				var count = lokasiSplit.length;

				console.log(data['cariLokasiFinger']);
				$('tbody#TampilDataLokasi').empty(html);
				html += '<tr>';
				html += '<td>'+data['cariLokasiFinger'][0]['noind']+'</td>';
				html += '<td>'+data['cariLokasiFinger'][0]['nama']+'</td>';
				html += '<td>'+data['cariLokasiFinger'][0]['seksi']+'</td>';
				html += '<td>';
				for (var i = 0; i < count; i++) {
					html += '<button class="btn btn-warning" id="DeleteLokasi"><a onclick="return confirm(\'Apakah yakin ingin menghapus?\');" href="'+baseurl+'PresenceManagement/Monitoring/deleteLokasiFinger/'+data['cariLokasiFinger'][0]['noind']+'/'+idlokasiSplit[i]+'"><b> X </b> </a>'+lokasiSplit[i]+'</button> ';
				}
				html += '</td>';
				html += '<td><Select class="form-control select_lokasi_finger" style="width:100%" data-noind="'+data['cariLokasiFinger'][0]['noind']+'" id="lokasi_finger" onchange="InsertLokasiFinger(this)"></Select</td>';
				html += '</tr>';
			} else {
				console.log(data['cariLokasiFinger']);
				$('tbody#TampilDataLokasi').empty(html);
				html += '<tr>';
				html += '<td>'+data['cariLokasiFinger'][0]['noind']+'</td>';
				html += '<td>'+data['cariLokasiFinger'][0]['nama']+'</td>';
				html += '<td>'+data['cariLokasiFinger'][0]['seksi']+'</td>';
				html += '<td>';
				html += '</td>';
				html += '<td><Select class="form-control select_lokasi_finger" style="width:100%" data-noind="'+data['cariLokasiFinger'][0]['noind']+'" id="lokasi_finger" onchange="InsertLokasiFinger(this)"></Select</td>';
				html += '</tr>';
				
				
			}
			$('tbody#TampilDataLokasi').append(html);

				$('.select_lokasi_finger').select2({
				  ajax: {
				  	url: baseurl+"PresenceManagement/Monitoring/LokasiKerja",
				  	dataType: 'json',
				  	type: 'get',
				  	data: function(params){
				  		return { p: params.term };
				  	},
				  	processResults: function (data) {
				  		return {
				  			results: $.map(data, function(item) {
				  				return {
				  					id: item.id_lokasi,
				  					text: item.lokasi,
				  				}
				  			})
				  		};
				  	},
				  	cache: true
				  },
				  minimumInputLength: 2,
				  placeholder: 'Select Lokasi Kerja',
				  allowClear: true,
				});

			$('#table-presensi').removeClass('hidden');
		})
	});

});

$(document).ready(function(){
	$('.select_lokasi_finger').select2({
	  ajax: {
	  	url: baseurl+"PresenceManagement/Monitoring/LokasiKerja",
	  	dataType: 'json',
	  	type: 'get',
	  	data: function(params){
	  		return { p: params.term };
	  	},
	  	processResults: function (data) {
	  		return {
	  			results: $.map(data, function(item) {
	  				return {
	  					id: item.id_lokasi,
	  					text: item.lokasi,
	  				}
	  			})
	  		};
	  	},
	  	cache: true
	  },
	  minimumInputLength: 2,
	  placeholder: 'Select Lokasi Kerja',
	  allowClear: true,
	});
})


$('#data-presensi-data-pekerja').on( 'search.dt', function () {
    $('.select_lokasi_finger').select2({
       ajax: {
	  	url: baseurl+"PresenceManagement/Monitoring/LokasiKerja",
	  	dataType: 'json',
	  	type: 'get',
	  	data: function(params){
	  		return { p: params.term };
	  	},
	  	processResults: function (data) {
	  		return {
	  			results: $.map(data, function(item) {
	  				return {
	  					id: item.id_lokasi,
	  					text: item.lokasi,
	  				}
	  			})
	  		};
	  	},
	  	cache: true
	  },
	  minimumInputLength: 2,
	  placeholder: 'Select Lokasi Kerja',
	  allowClear: true,
	});
} );

function InsertLokasiFinger(th) {
	var noind = $(th).attr('data-noind');
	var lokasi = $('#lokasi_finger[data-noind="'+noind+'"]').val();

	var check = confirm("Apakah anda yakin ingin menambahkan lokasi finger tersebut?");
	if (check) {
		$.ajax({
		    url: baseurl+"PresenceManagement/Monitoring/SaveLokasiFinger",
		    type: "POST",
		    data: {lokasi: lokasi, noind: noind}
		  }).done(function(data) {
		    window.location = baseurl+"PresenceManagement/Monitoring/DaftarPekerja";
		  });
	}else{
		alert("batal memilih");
	}
}

// 	-------Presence Management--------------------------------------------start
	$(function()
	{
		// 	Daterangepicker
		// 	{

		//	}

		// 	Input Mask
		//	{
				// $('#PresenceManagement-MonitoringPresensi-Pengaturan-txtIPServerSDK').inputmask('ip');
		//	}

		//	Select2
		//	{
				$('#PresenceManagement-MonitoringPresensi-Pengaturan-cmbLokasiKerja').select2({
					ajax:
					{
						url: baseurl+'PresenceManagement/MonitoringPresensiPengaturan/lokasi_kerja',
						dataType: 'json',
						data: function(params){
							return {
								term: params.term
							}
						},
						processResults: function (data){
							return {
								results: $.map(data, function(obj){
									return {id: obj.id_, text: obj.id_ + ' - ' + obj.lokasi_kerja};
								})
							}
						}
					}
				});

				$('#PresenceManagement-MonitoringPresensi-PengaturanEdit-cmbLokasiKerja').select2({
					ajax:
					{
						url: baseurl+'PresenceManagement/MonitoringPresensiPengaturan/lokasi_kerja',
						dataType: 'json',
						data: function(params){
							return {
								term: params.term
							}
						},
						processResults: function (data){
							return {
								results: $.map(data, function(obj){
									return {id: obj.id_, text: obj.id_ + ' - ' + obj.lokasi_kerja};
								})
							}
						}
					}
				});

				$('#PresenceManagement-MonitoringPresensi-Pengaturan-cmbPekerja').select2({
					minimumInputLength: 3,
					ajax:
					{
						url: baseurl+'PresenceManagement/MonitoringPresensiPengaturan/pekerja',
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
									return {id: obj.noind_baru, text: obj.noind_baru + ' - ' + obj.noind + ' - ' + obj.nama};
								})
							}
						}
					}
				});

				$('#PresenceManagement-MonitoringPresensi-DeviceUserList-cmbUserRegistered').select2({
					minimumInputLength: 3,
					ajax:
					{
						url: baseurl+'PresenceManagement/MonitoringPresensi/registered_user',
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
									return {id: obj.noind_baru, text: obj.noind_baru + ' - ' + obj.noind + ' - ' + obj.nama};
								})
							}
						}
					}
				});
				
				$('#PresenceManagement-MonitoringPresensi-DeviceUserList-cmbJariRef').select2({
					ajax:
					{
						url: baseurl+'PresenceManagement/MonitoringPresensi/finger_reference',
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
									return {id: obj.kode_finger, text: obj.kode_finger + ' - ' + obj.nama_jari};
								})
							}
						}
					}
				});
		//	}

		//	DataTables
		//	{
				// $('#PresenceManagement-daftarPerangkat').DataTable({
				// });

				$(document).ready(function(){
					var table = $('#PresenceManagement-daftarPerangkat').DataTable({
									scrollX : true,
								});
					$('a.toggle-vis').on('click',function(e){
						e.preventDefault();
						var column = table.column($(this).attr('data-column'));
						if (column.visible()) {
							$(this).addClass('btn-default');
							$(this).removeClass('btn-primary');
						}else{
							$(this).addClass('btn-primary');
							$(this).removeClass('btn-default');
						}
						column.visible(!column.visible());
					});
				});

				$('#PresenceManagement-daftarUser').DataTable({
				});
				$('#PresenceManagement-cekdata').DataTable({
					'paging'      : true,
			      	'lengthChange': true,
			      	'searching'   : true,
			      	'ordering'    : true,
			      	'info'        : true,
			      	'autoWidth'   : true,
				});

				$('#PresenceManagement-daftarAksesUser').DataTable({
					scrollY: '250px',
				});

				$(document).ready(function(){
					$('#PresenceManagement-daftarUser-ServerSide').DataTable({
						"processing" : true,
						"serverSide" : true,
						"order" : [],
						"ajax":{
							"url": baseurl+'PresenceManagement/MonitoringPresensiPengaturan/UserListTable',
							"type": "post"
						},

						"columnDefs" : [
						{
							"targets":[0],
							"orderable":false,
							"className": 'dt-body-center'
						},
						{
							"targets": -1,
							"orderable":false,
							"data": function(row, type, val, meta){
								var f_noindbaru = row[1];
								return "<a class='btn btn-info' href='"+baseurl+'PresenceManagement/MonitoringPresensiPengaturan/ChangeStatus/'+f_noindbaru+"_"+row[4]+"'>Change Status</a>";
							},
							"className": 'dt-body-center'
						},
						{
							"targets": [5],
							"data": function(row, type, val, meta){
								// return row[4];
								if (row[4] == 0) {
									return 'User';
								}else{
									return 'Admin';
								}
							},
							"className": 'dt-body-center'
						}
						],
					});
				});
		//	}

		//	Form Behavior
		//	{
				$('#PresenceManagement-MonitoringPresensi-Pengaturan-cmbPekerja').change(function()
				{
					var noind_baru 	=	$('#PresenceManagement-MonitoringPresensi-Pengaturan-cmbPekerja').val();
					$.ajax
					({
						type: 'POST',
						delay: 500,
						data: 
						{
							noind_baru: noind_baru
						},
						url: baseurl+'PresenceManagement/MonitoringPresensiPengaturan/user_cek',
						success:function(result)
						{
							if ( result['kode_cek'] == 1 )
							{
								alert('Already registered!');
								$('#PresenceManagement-MonitoringPresensi-Pengaturan-labelStatusUser').html('Already registered!');
								$('#PresenceManagement-MonitoringPresensi-Pengaturan-btnProceed').prop('disabled', true);
							}
							else if ( result['kode_cek'] == 0 )
							{
								$('#PresenceManagement-MonitoringPresensi-Pengaturan-btnProceed').prop('disabled', false);
							}
						}
					});
				});
		//	}
	});

	//	Individual Functions
	//	{
			function PresenceManagement_device_update
			(
					server_ip,
					server_port,
					device_sn,
					device_ip,
					device_port,
					device_name,
					inisial_lokasi,
					id_lokasi,
					kode_lokasi_kerja,
					nama_lokasi_kerja,
					voip
			) 
			{
				// alert(voip);
				$('#PresenceManagement-MonitoringPresensi-PengaturanEdit-txtIDLokasi').val(id_lokasi);
				$('#PresenceManagement-MonitoringPresensi-PengaturanEdit-txtIPServerSDK').val(server_ip);
				$('#PresenceManagement-MonitoringPresensi-PengaturanEdit-txtPortServerSDK').val(server_port);
				$('#PresenceManagement-MonitoringPresensi-PengaturanEdit-txtDeviceSN').val(device_sn);
				$('#PresenceManagement-MonitoringPresensi-PengaturanEdit-txtIPDevice').val(device_ip);
				$('#PresenceManagement-MonitoringPresensi-PengaturanEdit-txtPortDevice').val(device_port);
				$('#PresenceManagement-MonitoringPresensi-PengaturanEdit-txtNameDevice').val(device_name);
				$('#PresenceManagement-MonitoringPresensi-PengaturanEdit-txtInisialLokasi').val(inisial_lokasi);
				$('#PresenceManagement-MonitoringPresensi-PengaturanEdit-cmbLokasiKerja').select2('data', {id: kode_lokasi_kerja, a_key: kode_lokasi_kerja + ' - ' + nama_lokasi_kerja});
				$('#PresenceManagement-MonitoringPresensi-PengaturanEdit-txtVoipPS').val(voip);
				$('#deviceUpdate').modal("show");
			}

			function PresenceManagement_user_register(id_lokasi)
			{
				$('#PresenceManagement-MonitoringPresensi-DeviceUserList-txtIDLokasi').val(id_lokasi);
				$('#userRegister').modal("show");
			}
	//	}
// 	-------Presence Management----------------------------------------------end
