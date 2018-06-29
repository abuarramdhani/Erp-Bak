$(document).ready(function(){
	$('.sm_tglmonitoring').daterangepicker({
		"todayHiglight": true,
	});

	$('.sm_datepicker').datepicker({});

	$('.sm_select2').select2({
		placeholder: "Select Option",
	});

	$('.sm_datatable').DataTable({
    });

    $('.sm_table2').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false,
      'pageLength'	: 5,
    });

	$(document).on('click', '#SaveDataSM', function(e) {
		e.preventDefault();
		var id_jadwal = $(this).attr('data-id');
		var pic	= $('#sm_pic[data-id="'+id_jadwal+'"]').val();
		var ket = $('#sm_keterangan[data-id="'+id_jadwal+'"]').val();
		var cek = $('#sm_status[data-id="'+id_jadwal+'"]').is(":checked");

		if (cek) {
			$('#sm_status[data-id="'+id_jadwal+'"]').attr('value','1');
		}else{
			$('#sm_status[data-id="'+id_jadwal+'"]').attr('value','0')
		}
		var status = $('#sm_status[data-id="'+id_jadwal+'"]').val();

		$(this).closest('tr').find('input,textarea').each(function() {
				$(this).attr('readonly','readonly');
			});
		$(this).closest('tr').find('input:checkbox').each(function() {
				$(this).attr('disabled','disabled');
			});

		$.ajax({
			url: baseurl+"SiteManagement/Monitoring/InsertDataMonitoring",
		    type: "POST",
		    data: {id_jadwal: id_jadwal,pic: pic,ket: ket,status: status}
		}).done(function(data){
			alert('data berhasil disimpan');
		});
	});

	$(document).on('click', '#sm-edit', function(e){
		e.preventDefault();
		var type = $(this).attr('data-type');
		if(type == 'read') {
			$(this).closest('tr').find('input,textarea').each(function() {
				$(this).removeAttr('readonly');
			});
			$(this).closest('tr').find('input:checkbox').each(function() {
				$(this).removeAttr('disabled');
			});
			// $(this).closest('tr').find('textarea').each(function() {
			// 	$(this).removeAttr('readonly');
			// });
			// $(this).addClass('hidden');
			$(this).attr('data-type', 'write');
			$(this).toggleClass("fa fa-edit fa-2x fa fa-save fa-2x");
			// $(this).siblings('a').removeClass('hidden');
		} else {
			$(this).attr('data-type', 'read');
			$(this).closest('tr').find('input,textarea').each(function() {
				$(this).attr('readonly','readonly');
			});
			$(this).closest('tr').find('input:checkbox').each(function() {
				$(this).attr('disabled','disabled');
			});

			var id_jadwal = $(this).attr('data-id');
			var pic	= $('#sm_pic[data-id="'+id_jadwal+'"]').val();
			var ket = $('#sm_keterangan[data-id="'+id_jadwal+'"]').val();
			var cek = $('#sm_status[data-id="'+id_jadwal+'"]').is(":checked");

			if (cek) {
				$('#sm_status[data-id="'+id_jadwal+'"]').attr('value','1');
			}else{
				$('#sm_status[data-id="'+id_jadwal+'"]').attr('value','0');
			}
			var status = $('#sm_status[data-id="'+id_jadwal+'"]').val();

			$.ajax({
				url: baseurl+"SiteManagement/Monitoring/InsertDataMonitoring",
			    type: "POST",
			    data: {id_jadwal: id_jadwal,pic: pic,ket: ket,status: status}
			}).done(function(data){
				alert('data berhasil disimpan');
			});

			$(this).toggleClass("fa fa-save fa-2x fa fa-edit fa-2x");
		}
	});

	$('.sm-selectseksi').select2({
		ajax:{
			url: baseurl+'SiteManagement/Order/getSeksi',
			dataType: 'json',
			type: 'get',
			data: function (params) {
				return {s: params.term};
			},
			processResults: function (data) {
				return {
					results: $.map(data, function (item) {
						return {
							id: item.kode_seksi,
							text: item.nama_seksi,
						}
					})
				};
			},
			cache: true
		},
		minimumInputLength: 2,
		placeholder: 'Select Seksi',
		allowClear: true,
	});
});

//Order Site Management
	function AddRowOrderSM(base){  
	      var e = jQuery.Event( "click" );
	      var n = $('#osm-orderlinesdetail tr').length;
	      count = n+1;

	        var newRow  = jQuery("<tr row-id='"+count+"'>"
	                                +"<td style='text-align:center; width:'"+"30px"+"'>"+count+"</td>"
	                                +"<td align='center' width='60px'>"
	                                +"<a onclick='delSpesifikRow(this)' class='del-row btn btn-xs btn-danger' data-toggle='tooltip' data-placement='bottom' title='Delete Data'><span class='fa fa-times'></span></a>"
	                                +"</td>"
	                                +"<td>"
	                                +"<div class='form-group'>"
	                                +"<div class='col-lg-12'>"
	                                +"<input type='number' placeholder='Jumlah' name='txtJenisMaintenanceSPK[]' id='txtJenisMaintenanceSPK' class='form-control'/>"
	                                +"</div>"
	                                +"</div>"
	                                +"</td>"
	                                +"<td>"
	                                +"<div class='form-group'>"
	                                +"<div class='col-lg-12'>"
	                                +"<input type='text' placeholder='Satuan' name='txtJenisMaintenanceSPK[]' id='txtJenisMaintenanceSPK' class='form-control'/>"
	                                +"</div>"
	                                +"</div>"
	                                +"</td>"
	                                +"<td>"
	                                +"<div class='form-group'>"
	                                +"<div class='col-lg-12'>"
	                                +"<input type='text' placeholder='Masukkan Keterangan' name='txtJenisMaintenanceSPK[]' id='txtJenisMaintenanceSPK' class='form-control'/>"
	                                +"</div>"
	                                +"</div>"
	                                +"</td>"
	                                +"<td>"
	                                +"<div class='form-group'>"
	                                +"<div class='col-lg-12'>"
	                                +"<input type='text' placeholder='Masukkan Lampiran' name='txtJenisMaintenanceSPK[]' id='txtJenisMaintenanceSPK' class='form-control'/>"
	                                +"</div>"
	                                +"</div>"
	                                +"</td>"
	                                +"</tr>");
	        jQuery("#table_smorderdetail").append(newRow);
	  }
	  
$(function() {
	$(document).on('click', '#osm-saveorder', function(e) {
		e.preventDefault();
		var tgl_order = $('#osm-tglorder').val();
		var jenis_order = $('#osm-jenisorder').val();
		var seksi_order = $('#osm-seksiorder').val();
		var duedate = $('#osm-duedate').val();
		var tgl_terima = $('#osm-tglterima').val(); 
		var remarks = $('#osm-remarks').is(':checked');
		var jumlah = $('#osm-jumlahorder').val();
		var satuan = $('#osm-satuanorder').val();
		var keterangan = $('#osm-ketorder').val();
		var lampiran = $('#osm-lampiran').val();

		if (remarks) {
			$('#osm-remarks').val('1');
		}else{
			$('#osm-remarks').val('0');
		}

		$.ajax({
			url: baseurl+"OrderSiteManagement/Order/SaveDataOrderSM",
			type: "POST",
			data: {tgl_order: tgl_order,jenis_order: jenis_order,seksi_order: seksi_order,duedate: duedate,tgl_terima: tgl_terima,remarks: remarks, jumlah: jumlah, satuan: satuan, keterangan: keterangan, lampiran: lampiran}
		}).done(function(data) {
			alert('data berhasil disimpan');
		});
		$('#osm-cetakorder').removeClass('hidden');
	});

	// $(document).on('click', '#osm-saveorder', function(){
	// 	$('#osm-cetakorder').removeClass('hidden');
	// });

	function cekDataOSM() {
		var tgl_order = $('#osm-tglorder').val();
		var jenis_order = $('#osm-jenisorder').val();
		var seksi_order = $('#osm-seksiorder').val();

		if (tgl_order && jenis_order && seksi_order) {
			$('#osm-saveorder').removeAttr('disabled','disabled');
		}else{
			$('#osm-saveorder').attr('disabled','disabled');
		}
	}

	$(document).on('change', '#osm-tglorder,#osm-jenisorder,#osm-seksiorder', function() {
		cekDataOSM();
	});

	// $(document).on('click', '.osm-deleteorder', function(e) {
	// 	var id = $(this).attr('');
	// 	var ini = $(this);

	// 	if (id!=null || id!='') 
	// 	{
	// 		$.ajax({
	// 			url: baseurl+'OrderSiteManagement/Order/DeleteDataOSM',
	// 			type: 'POST',
	// 			success: function()
	// 			{
	// 				ini.closest('tr').remove();
	// 			}
	// 		})
	// 	}else{
	// 		ini.closest('tr').remove();
	// 	}
	// });
});
