$(document).ready(function(){
	var tblCVDMonitoringCovid = $('#tbl-CVD-MonitoringCovid').DataTable({
        "lengthMenu": [
            [ 5, 10, 25, 50, -1 ],
            [ '5 rows', '10 rows', '25 rows', '50 rows', 'Show all' ]
        ],
        "dom" : 'Bfrtip',
        "buttons" : [
            'copy', 'csv', 'excel', 
            {
                extend: 'pdfHtml5',
                orientation: 'landscape',
                pageSize: 'LEGAL'
            },
            'print', 'pageLength'
        ],
		// "scrollX" : true,
		// "fixedColumns":   {
  //           leftColumns: 4
  //       }
	});

	$('#slc-CVD-MonitoringCovid-Tambah-Pekerja').select2({
		minimumInputLength: 0,
		allowClear: true,
		ajax: {
			url: baseurl+'Covid/MonitoringCovid/getPekerja',
			dataType:'json',
			type: "GET",
			data: function (params) {
				return {
					term: params.term
				};
			},
			processResults: function (data) {
				return {
					results: $.map(data, function (item) {
						return {
							id: item.noind,
							text: item.noind + " - " + item.nama
						};
					})

				};
			},
		}
	})

	$('#slc-CVD-MonitoringCovid-Tambah-Pekerja').on('change', function(){
		var noind = $(this).val();
		$.ajax({
			data: {noind: noind},
			method: 'GET',
			url: baseurl + 'Covid/MonitoringCovid/getDetailPekerja',
			error: function(xhr,status,error){
				swal.fire({
	                title: xhr['status'] + "(" + xhr['statusText'] + ")",
	                html: xhr['responseText'],
	                type: "error",
	                confirmButtonText: 'OK',
	                confirmButtonColor: '#d63031',
	            })
			},
			success: function(data){
				var obj = JSON.parse(data);
				if (obj.status == 'success') {
					$('#txt-CVD-MonitoringCovid-Tambah-Seksi').val(obj.seksi);
					$('#txt-CVD-MonitoringCovid-Tambah-Departemen').val(obj.dept);

				}
			}
		})
	})

	$('#txt-CVD-MonitoringCovid-Tambah-TanggalInteraksi').datepicker({
		"autoclose": true,
		"todayHighlight": true,
		"todayBtn": "linked",
		"format":'yyyy-mm-dd'
	});

	$('#txa-CVD-MonitoringCovid-Tambah-Wawancara').redactor({
        imageUpload: baseurl + 'Covid/MonitoringCovid/uploadRedactor',
        imageUploadErrorCallback: function(json) {
            alert(json.error);
        }
    })

	$('#txt-CVD-MonitoringCovid-Tambah-Keterangan').redactor({
        imageUpload: baseurl + 'Covid/MonitoringCovid/uploadRedactor',
        imageUploadErrorCallback: function(json) {
            alert(json.error);
        }
    })

	$('.btn-CVD-MonitoringCovid-Hapus').on('click', function(){
		var params = {
		  				id		: $(this).attr('data-href'),
		  				status 	: $(this).attr('data-status'),
		  			}
		Swal.fire({
			title: 'Hapus Data',
			text: "Apakah Anda Yakin Akan Menghapus Data Ini ?",
			type: 'question',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Ya',
			cancelButtonText: 'Tidak'
		}).then((result) => {
		  	if (result.value) {
		  		$.ajax({
		  			data: params,
					method: 'GET',
					url: baseurl + 'Covid/MonitoringCovid/hapus',
					error: function(xhr,status,error){
						swal.fire({
			                title: xhr['status'] + "(" + xhr['statusText'] + ")",
			                html: xhr['responseText'],
			                type: "error",
			                confirmButtonText: 'OK',
			                confirmButtonColor: '#d63031',
			            })
					},
					success: function(data){
						obj = JSON.parse(data);
						if (obj.status == "sukses") {
							Swal.fire(
								'Sukses !!!',
								'Data Berhasil Dihapus',
								'success'
							).then( () => {
								window.location.href = baseurl + 'Covid/MonitoringCovid';
							})
						}
					}
		  		})
		  	}
		});
	})

	$('.btn-CVD-MonitoringCovid-Tambah-Lampiran').on('click', function(){
		$('.file-CVD-MonitoringCovid-Tambah-Lampiran').last().click();
	})

	$(document).on('change','.file-CVD-MonitoringCovid-Tambah-Lampiran', function(){
		$(this).closest('div').append('<label class="label label-success" style="margin: 5px;">' + $(this).val().substring(12) + '</label>');
		$(this).clone().val('').appendTo($(this).closest('div'));
	})

	$('.btn-CVD-MonitoringCovid-FollowUp').on('click', function(){
		var status = $(this).attr('data-status');
		var link = $(this).attr('data-href');
		if (status.toLowerCase() == "Follow Up Pekerja Masuk".toLowerCase()) {
			Swal.fire({
				title: "Apakah Anda sudah Melakukan Follow Up Pekerja?",
				text: 'Follow Up Pekerja Question 1',
				type: 'question',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Ya',
				cancelButtonText: 'Tidak'
			}).then((result1) => {
			  	if (result1.value) {
			  		Swal.fire({
						title: "Apakah Anda akan membuat laporan hasil wawancara pekerja selesai isolasi?",
						text: 'Follow Up Pekerja Question 2',
						type: 'question',
						showCancelButton: true,
						confirmButtonColor: '#3085d6',
						cancelButtonColor: '#d33',
						confirmButtonText: 'Ya',
						cancelButtonText: 'Tidak'
					}).then((result2) => {
					  	if (result2.value) {
					  		window.location.href = link;
					  	}
					});
			  	}
			});
		}
	})
})