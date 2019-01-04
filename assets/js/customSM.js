$(document).ready(function(){
	$('.sm_tglmonitoring').daterangepicker({
		"todayHiglight": true,
	});
	$('.sm_datepicker').datepicker({
		autoclose: true
	});
	var todayDate = new Date().getDate();
	$(document).on('change', '#osm-jenisorder', function() {
		var osm_option = $(this).val();
		if (osm_option == 'Perbaikan Kursi') {
			var n = 7; 
		}else{
			var n = 1;
		}
		$('#osm-duedate').daterangepicker({
			singleDatePicker: true,
			minDate: new Date(new Date().setDate(todayDate + n)),
			locale: {
	            format: 'YYYY-MM-DD'
	        }
		});
	});
	$('#osm-duedate').daterangepicker({
		singleDatePicker: true,
		minDate: new Date(new Date().setDate(todayDate)),
		locale: {
            format: 'YYYY-MM-DD'
        }
	});
	$('.sm_select2').select2({
		placeholder: "Select Option",
	});
	// $('.sm_datatable').dataTable({
 //    });
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
	$(document).on('change', '#sm_tglorder', function(){
		enableButton();
	});
	function enableButton(){
		var tgl = $('#sm_tglorder').val();
		if (tgl) {
			$('#btn-smfilter').removeAttr('disabled','disabled');
		}else{
			$('#btn-smfilter').attr('disabled','disabled');
		}
	}
	// $('.sm_remarksorder').click(function() {
	// 	var id_order = $(this).attr('data-id');
	// 	var check = confirm("Apakah anda yakin telah menyelesaikan order tersebut?");
	// 	if (check) {
	// 		$(this).attr('disabled','disabled');
	// 		$(this).closest('tr').find('b').each(function(){
	// 			$(this).text('Done');
	// 		});
	// 		$.ajax({
	// 			url: baseurl+"SiteManagement/Order/RemarkSOrder",
	// 		    type: "POST",
	// 		    data: {id_order: id_order}
	// 		}).done(function(data){
	// 			alert('data berhasil diupdate');
	// 		});
	// 	}else{
	// 		$(this).removeAttr('checked');
	// 		alert('data batal diupdate');
	// 	}
	// });
	
	// $('.sm_remarksorder').on('checked',function(e){
	// 	if($(this).prop("checked") == true){
	// 		alert("check");
	// 		// var id_order = $(this).attr('data-id');
	// 		// var check = confirm("Apakah anda yakin telah menyelesaikan order tersebut?");
	// 		// if (check) {
	// 		// 	$(this).attr('disabled','disabled');
	// 		// 	$(this).closest('tr').find('b').each(function(){
	// 		// 		$(this).text('Done');
	// 		// 	});
	// 		// 	$.ajax({
	// 		// 		url: baseurl+"SiteManagement/Order/RemarkSOrder",
	// 		// 	    type: "POST",
	// 		// 	    data: {id_order: id_order}
	// 		// 	}).done(function(data){
	// 		// 		alert('data berhasil diupdate');
	// 		// 	});
	// 		// }else{
	// 		// 	$(this).removeAttr('checked');
	// 		// 	alert('data batal diupdate');
	// 		// }	
	// 	}else{
	// 		alert("uncheck");
	// 	}
	// });
	$(document).ready(function() {
    var table = $('#sm_datatable').DataTable();
     
   
	} );
	$('.sm_remarksorder').on('click',function(e){
		var id_order = $(this).attr('data-id');
		var check = confirm("Apakah anda yakin telah menyelesaikan order tersebut?");
		if (check) {
			$(this).attr('disabled','disabled');
			$(this).closest('tr').find('b').each(function(){
				$(this).text('Done');
			});
			$.ajax({
				url: baseurl+"SiteManagement/Order/RemarkSOrder",
			    type: "POST",
			    data: {id_order: id_order}
			}).done(function(data){
				alert('data berhasil diupdate');
			});
		}else{
			$(this).removeAttr('style');
			alert('data batal diupdate');
		}
	});
	
    
    // $('.sm_remarksorder').change(function() {
    //     if(this.checked) {
    //         var returnVal = confirm("Are you sure?");
    //         $(this).prop("checked", returnVal);
    //     }
        
    // });
 //    $('#sm_remarksorder').click(function(){
 //    if($(this).prop("checked") == true){ //can also use $(this).prop("checked") which will return a boolean.
 //        alert("checked");
 //    }
 //    else if($(this).prop("checked") == false){
 //        alert("Checkbox is unchecked.");
 //    }
	// });
	$(document).on('click', '#sm_reject', function(e){
		e.preventDefault();
		var id = $(this).attr("data-id");
		$.ajax({
			url: baseurl+"SiteManagement/Order/RejectFromAdmin",
		    type: "POST",
		    data: {id: id}
		}).done(function(data){
			alert('data telah di Reject');
		});
		$(this).attr('disabled','disabled');
		$(this).closest('tr').find('b').each(function(){
			$(this).text('Reject by admin');
		});
	})
});
	function sm_cekproses(){
		var minggu = $('#sm-selectminggu').val();
		var hari = $('#sm-selecthari').val();
		var kategori = $('#sm-selectkategori').val();
		
		if(minggu && hari && kategori){
			$('#sm-prosesmonitoring').removeAttr('disabled', 'disabled');
		}else{
			$('#sm-prosesmonitoring').attr('disabled', 'disabled');
		}
	}
	$(document).on('change','#sm-selectminggu, #sm-selecthari, #sm-selectkategori',function(){
		sm_cekproses();
	});
//Order Site Management
	function AddRowOrderSM(base){  
	      var e = jQuery.Event( "click" );
	      // var n = $('#osm-orderlinesdetail tr').length;
	      // var count = n+1;
	        var newRow  = jQuery("<tr>"
	                                +"<td style='text-align:center; width:'"+"30px"+"'></td>"
	                                +"<td align='center' width='60px'>"
	                                +"<a onclick='delSpesifikRow(this)' class='del-row btn btn-xs btn-danger' data-toggle='tooltip' data-placement='bottom' title='Delete Data'><span class='fa fa-times'></span></a>"
	                                +"</td>"
	                                +"<td>"
	                                +"<div class='form-group'>"
	                                +"<div class='col-lg-12'>"
	                                +"<input type='number' placeholder='Jumlah' name='osm-jumlahorder[]' id='osm-jumlahorder' class='form-control'/>"
	                                +"</div>"
	                                +"</div>"
	                                +"</td>"
	                                +"<td>"
	                                +"<div class='form-group'>"
	                                +"<div class='col-lg-12'>"
	                                +"<input type='text' placeholder='Satuan' name='osm-satuanorder[]' id='osm-satuanorder' class='form-control'/>"
	                                +"</div>"
	                                +"</div>"
	                                +"</td>"
	                                +"<td>"
	                                +"<div class='form-group'>"
	                                +"<div class='col-lg-12'>"
	                                +"<input type='text' placeholder='Masukkan Keterangan' name='osm-ketorder[]' id='osm-ketorder' class='form-control'/>"
	                                +"</div>"
	                                +"</div>"
	                                +"</td>"
	                                +"<td>"
	                                +"<div class='form-group'>"
	                                +"<div class='col-lg-12'>"
	                                +"<input type='text' placeholder='Masukkan Lampiran' name='osm-lampiran[]' id='osm-lampiran' class='form-control'/>"
	                                +"</div>"
	                                +"</div>"
	                                +"</td>"
	                                +"</tr>");
	        jQuery("#table_smorderdetail").append(newRow);
	  }
$(function() {
	// $(document).on('click', '#osm-saveorder', function(e) {
	// 	e.preventDefault();
	// 	var tgl_order = $('#osm-tglorder').val();
	// 	var jenis_order = $('#osm-jenisorder').val();
	// 	var seksi_order = $('#osm-seksiorder').val();
	// 	var duedate = $('#osm-duedate').val();
	// 	var tgl_terima = $('#osm-tglterima').val(); 
	// 	var remarks = $('#osm-remarks').is(':checked');
	// 	var jumlah = $('#osm-jumlahorder').val();
	// 	var satuan = $('#osm-satuanorder').val();
	// 	var keterangan = $('#osm-ketorder').val();
	// 	var lampiran = $('#osm-lampiran').val();
	// 	if (remarks) {
	// 		$('#osm-remarks').val('1');
	// 	}else{
	// 		$('#osm-remarks').val('0');
	// 	}
	// 	$.ajax({
	// 		url: baseurl+"OrderSiteManagement/Order/SaveDataOrderSM",
	// 		type: "POST",
	// 		data: {tgl_order: tgl_order,jenis_order: jenis_order,seksi_order: seksi_order,duedate: duedate,tgl_terima: tgl_terima,remarks: remarks, jumlah: jumlah, satuan: satuan, keterangan: keterangan, lampiran: lampiran}
	// 	}).done(function(data) {
	// 		alert('data berhasil disimpan');
	// 	});
	// 	$('#osm-cetakorder').removeClass('hidden');
	// });
	// $(document).on('click', '#osm-saveorder', function(){
	// 	$('#osm-cetakorder').removeClass('hidden');
	// });
	function cekDataOSM() {
		var kebutuhan = $('#osm-duedate').val();
		var jenis_order = $('#osm-jenisorder').val();
		var seksi_order = $('#osm-seksiorder').val();
		if (kebutuhan && jenis_order && seksi_order) {
			$('#osm-saveorder').removeAttr('disabled','disabled');
		}else{
			$('#osm-saveorder').attr('disabled','disabled');
		}
	}
	$(document).on('change', '#osm-duedate,#osm-jenisorder,#osm-seksiorder', function() {
		cekDataOSM();
	});
	// $(document).on('click', '.osm-deleteorder', function(e) {
	// 	var id = $('tr').attr('row-id')
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
	
	
	$('#osm-ordermasuk').submit(function(e){
		e.preventDefault();
		// var curtab = window.open(window.location, '_self');
		
		// curtab.delay(10000);
		// window.open(baseurl+'OrderSiteManagement/Order');
		// window.location.href(baseurl+'OrderSiteManagement/Order');
		// $(this).unbind('submit').submit();
		this.submit()
		setTimeout(function(){
			window.open(window.location, '_self');
		}), 100 ;
		
	});
	//Asset
$(function(){
	$('#txtTanggalPPAsset').datepicker({
		"autoclose" : true,
		"todayHiglight": true,
		"format": 'dd MM yyyy'
	});
	$('#txtTanggalTransferDiterima').datepicker({
		"autoclose" : true,
		"todayHiglight": true,
		"format": 'dd MM yyyy'
	});
	$('#txtTanggalPembelian').datepicker({
		"autoclose" : true,
		"todayHiglight": true,
		"format": 'dd MM yyyy'
	});
	$('.table-asset').DataTable({
		dom: 'frtp',
	});
});
$(document).ready(function(){
	$('#txtSeksiPemakaiAsset').select2({
		allowClear: false,
	});
	$('#txtRequesterAsset').select2({
		placeholder: "Requester",
		searching: true,
		minimumInputLength: 3,
		allowClear: false,
		ajax:
		{
			url: baseurl+'SiteManagement/InputAsset/GetRequester',
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
	$('#txtNoPPAsset').select2({
		placeholder: "No PP",
		searching: true,
		minimumInputLength: 2,
		allowClear: false,
		ajax:
		{
			url: baseurl+'SiteManagement/PembelianAsset/GetNoPP',
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
						return {id: obj.id_input_asset, text: obj.no_pp};
					})
				}
			}
		}
	});
	$('#txtCostCenter').select2({
		placeholder: "Cost Center",
		searching: true,
		minimumInputLength: 2,
		allowClear: false,
		ajax:
		{
			url: baseurl+'SiteManagement/PembelianAsset/GetCostCenter',
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
						return {id: obj.code_cost, text: obj.code_cost+" - "+obj.seksi_cost};
					})
				}
			}
		}
	});
	$('#txtNoPPAsset').on('change',function(){
		var noPPasset = $(this).find(':selected').val();
		$.ajax({
			url: baseurl+'SiteManagement/PembelianAsset/GetNamaBarang',
			type: 'POST',
			data:{nopp : noPPasset},
			success:function(data){
				var data = JSON.parse(data);
				var textoption = "<option></option>";
				var nama = "";
				var kode = "";
				var jumlah = "";
				var seksi = "";
				var id_detail = "";
				for (var i = 0; i < data.length; i++) {
					nama 	= data[i]['nama_item'];
					kode 	= data[i]['kode_item'];
					jumlah 	= data[i]['jumlah_diminta'];
					seksi 	= data[i]['seksi'];
					id_detail 	= data[i]['id_input_asset_detail'];
					textoption = textoption+"<option value='"+id_detail+"' data-kode='"+kode+"' data-jumlah='"+jumlah+"' data-seksi='"+seksi+"'>"+nama+"</option>";
				}
				$('#txtNamaBarang').html(textoption);
			}
		});
	});
	$('#txtNamaBarang').on('change',function(){
		var kode = $(this).find(':selected').attr('data-kode');
		$('#txtKodeBarang').val(kode);
		var jumlah = $(this).find(':selected').attr('data-jumlah');
		$('#txtJumlahKebutuhan').val(jumlah);
		var seksi = $(this).find(':selected').attr('data-seksi');
		$('#txtSeksiPemakai').val(seksi);
	});
	$('.classaset1').select2({
		placeholder: "Nama Barang",
		searching: true,
		minimumInputLength: 3,
		allowClear: false,
		ajax:
		{
			url: baseurl+'SiteManagement/InputAsset/GetItem',
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
						return {id: obj.kode_item, text: obj.nama_item};
					})
				}
			}
		}
	});
	$('.tagRetirement').select2({
		placeholder: "Tag Number",
		searching: true,
		minimumInputLength: 3,
		allowClear: false,
		ajax:
		{
			url: baseurl+'SiteManagement/RetirementAsset/GetTagNumber',
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
						return {id: obj.id_pembelian, text: obj.tag_number};
					})
				}
			}
		}
	});
	$('.tagTransfer').select2({
		placeholder: "Tag Number",
		searching: true,
		minimumInputLength: 3,
		allowClear: false,
		ajax:
		{
			url: baseurl+'SiteManagement/RetirementAsset/GetTagNumber',
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
						return {id: obj.id_pembelian, text: obj.tag_number};
					})
				}
			}
		}
	});
	$('.seksiTransfer').select2({
		placeholder: "Seksi Baru",
		searching: true,
		minimumInputLength: 3,
		allowClear: false,
		ajax:
		{
			url: baseurl+'SiteManagement/TransferAsset/GetSeksi',
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
						return {id: obj.section_code, text: obj.section_name};
					})
				}
			}
		}
	});
	$('.requesterBaru').select2({
		placeholder: "Requester Baru",
		searching: true,
		minimumInputLength: 3,
		allowClear: false,
		ajax:
		{
			url: baseurl+'SiteManagement/TransferAsset/GetRequester',
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
						return {id: obj.employee_code, text: obj.employee_code+" - "+obj.employee_name};
					})
				}
			}
		}
	});
	$('.kotaRetirementAsset').select2({
		placeholder: "Kota",
		searching: true,
		minimumInputLength: 3,
		allowClear: false,
		ajax:
		{
			url: baseurl+'SiteManagement/RetirementAsset/GetDaerah',
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
						return {id: obj.id_kab, text: obj.nama};
					})
				}
			}
		}
	});
	$('.kotaRetirementAsset').on('change', function(){
		var kota = $(this).find(':selected').text();
		$('input[name="txtKotaRetirementAsset"]').val(kota);
	});
	$('.tagRetirement').on('change',function(){
		var idTagNum = $(this).val();
		$.ajax({
			url 	: baseurl+"SiteManagement/RetirementAsset/getBarang",
			type 	: 'POST',
			data 	: {id : idTagNum},
			success	: function(data){
				var data = JSON.parse(data);
				data = data['0'];
				$('input[name="txtNamaBarangRetirementAsset"]').val(data['nama_item']);
				$('input[name="txtSeksiRetirementAsset"]').val(data['seksi_pemakai']);
				$('input[name="txtTagNumberRetirementAsset"]').val(data['tag_number']);
			}
		})
	});
	$('#txtUsulanSeksiRetirementAsset').on('change', function(){
		var isi = $(this).find(':selected').text();
		if (isi == 'Lainnya') {
			$('input[name="txtUsulanLainnyaRetirementAsset"]').removeAttr('disabled');
		}else{
			$('input[name="txtUsulanLainnyaRetirementAsset"]').attr('disabled','');
		}
		
	});
	$('.tagTransfer').on('change',function(){
		var idTagNum = $(this).val();
		$.ajax({
			url 	: baseurl+"SiteManagement/RetirementAsset/getBarang",
			type 	: 'POST',
			data 	: {id : idTagNum},
			success	: function(data){
				var data = JSON.parse(data);
				data = data['0'];
				$('input[name="txtNamaBarangTransferAsset"]').val(data['nama_item']);
				$('input[name="txtSeksiLamaTransferAsset"]').val(data['seksi_pemakai']);
				$('input[name="txtTagNumberTransferAsset"]').val(data['tag_number']);
			}
		})
	});
	$('.seksiTransfer').on('change',function(){
		var seksi = $(this).find(':selected').text();
		$('input[name="txtSeksiBaruTransferAsset"]').val(seksi);
	});
});
function removeDetailAsset(pos){
	var numSelect = $('.rowAsset').length;
	if (numSelect !== 1) {
		$(pos).closest('tr').remove(); 
	}
}
function addDetailAsset(){
	var newRow = $('.rowAsset:last').clone();
	$('.tbodyAsset').append(newRow);
	$(newRow).find('.select2-container').remove();
	$(newRow).find('.classaset').val("");
	var angka = $(newRow).find('#angka').html();
	$(newRow).find('#angka').html(parseInt(angka)+1);
	$(newRow).find(':selected').val("");
	$(newRow).find(':selected').text("");
	$('.classaset1').select2({
		placeholder: "Nama Barang",
		searching: true,
		minimumInputLength: 3,
		allowClear: false,
		ajax:
		{
			url: baseurl+'SiteManagement/InputAsset/GetItem',
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
						return {id: obj.kode_item, text: obj.nama_item};
					})
				}
			}
		}
	});
}
function gantiBarang(pos){
	var kode = $(pos).find(':selected').val();
	var barang = $(pos).find(':selected').text();
	$(pos).closest('tr').find('.kode').val(kode);
	$(pos).find(':selected').val(barang);
}

//------------------------------------------------
$(function(){

	$('.sm-tgl').daterangepicker({
		// "autoUpdateInput": false,
		"singleDatePicker": true,
		// "timePicker": true,
		// "timePicker24Hour": true,
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
		$('#sm-tanggal').val('');

    $('.sm-wkt').mdtimepicker(
	    {
	    timeFormat: 'hh:mm:ss.000', // format of the time value (data-time attribute)
	    format: 'hh:mm:ss tt',    // format of the input value
	    theme: 'blue',        // theme of the timepicker
	    readOnly: false,       // determines if input is readonly
	    hourPadding: false    // determines if display value has zero padding for hour value less than 10 (i.e. 05:30 PM); 24-hour format has padding by default
	});
	// $('.sm-wkt').datepicker({
 //    autoclose : true,
 //  });

	$('.sm-tgl').change(function(){
		var tgl = $('.sm-tgl').val();
		var tahun = tgl.substr(0,4)
		var bulan = tgl.substr(5,2)
		var tanggal = tgl.substr(8,2)
		var newdate = tanggal+'-'+bulan+'-'+tahun;
		function parseDate(input) {
			var parts = input.split('-');

			return new Date(parts[2], parts[1]-1, parts[0]);
		}
		function getName(day) {
			if (day == 0) return 'Minggu';
			else if (day == 1) return 'Senin';
			else if (day == 2) return 'Selasa';
			else if (day == 3) return 'Rabu';
			else if (day == 4) return 'Kamis';
			else if (day == 5) return 'Jumat';
			return 'Sabtu';
		}
		var d = parseDate(newdate);
		var weekday = d.getDay();
		var weekdayName = getName(weekday);
		// alert(weekdayName);
		$('.sm-hari').val(weekdayName);
	});

	$('#sm_WC').DataTable( {
		"lengthChange": true,
		"language": {
            "lengthMenu": "_MENU_",
        },
        dom: 'lBfrtip',
        buttons: [ 
            {
                extend: 'excelHtml5',
                title: 'Record Data Penggunaan Jasa Sedot WC'
            },
             {
                extend: 'pdf',
                title: 'Record Data Penggunaan Jasa Sedot WC'
            }, {
                extend: 'print',
                title: 'Record Data Penggunaan Jasa Sedot WC'
            }
        ]
    } );
    $('select[name="sm_WC_length"]').css("width","60px");
    $('select[name="sm_WC_length"]').css("margin-right","10px");
    // $(".sm-wktim").inputmask(
    //     "hh:mm:ss", {
    //     placeholder: "__:__:__", 
    //     insertMode: false, 
    //     showMaskOnHover: false,
    //     hourFormat: 12 });
    // $('#sm_WC_length')
 //    $('div:contains(" records per page")').each(function(){
 //    	$(this).html($(this).html().split(" records per page").join(""));
	// });;

	// var str = $('div').text().replace(/By:/g, '');
	// $('div').text(str);
});

$(document).ready(function() {  
	// $(".sm-wktim").mask("99:99:99");
	// $(".sm-wktim").inputmask(
 //        "hh:mm:ss", {
 //        placeholder: "__:__:__", 
 //        insertMode: false, 
 //        showMaskOnHover: false,
 //        hourFormat: 12 });

  // $(".sm-wktim").inputmask("99-9999999");  //static mask
  // $(".sm-wktim").inputmask({"mask": "(999) 999-9999"}); //specifying options
  // $(".sm-wktim").mask('99-99-99');
  $('.sm-pilihSeksi').select2(
  {
  	allowClear: false,
  	placeholder: "Pilih Seksi",
  	minimumInputLength: 3,
  	ajax: 
  	{
  		url: baseurl+'SiteManagement/Order/allSeksi',
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
  					return {id: obj.seksi, text: obj.seksi};
  				})
  			};
  		}
  	}
  });
});

(function($) {
  $.fn.inputFilter = function(inputFilter) {
    return this.on("input keydown keyup mousedown mouseup select contextmenu drop", function() {
      if (inputFilter(this.value)) {
        this.oldValue = this.value;
        this.oldSelectionStart = this.selectionStart;
        this.oldSelectionEnd = this.selectionEnd;
      } else if (this.hasOwnProperty("oldValue")) {
        this.value = this.oldValue;
        this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
      }
    });
  };
}(jQuery));
$(".num").inputFilter(function(value) {
  return /^-?\d*$/.test(value); });
