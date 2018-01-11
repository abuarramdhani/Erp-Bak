$(document).ready(function(){	

	//SELECT DEPARTEMEN UNTUK CREATE
	$(".js-slcDepartemenPK").select2({
		placeholder: "Nama Departemen",
		minimumInputLength: 3,
		ajax: {		

			url:baseurl+"PenilaianKinerja/JurnalPenilaianPersonalia/GetDepartemen",
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
						return {
							id:obj.Nama_Departemen,
							text:obj.Nama_Departemen
						};
					})
				};
			}
		}
	});

	//SELECT UNIT UNTUK CREATE
	$(".js-slcUnitPK").select2({
		placeholder: "Nama Unit",
		minimumInputLength: 3,
		ajax: {		

			url:baseurl+"PenilaianKinerja/JurnalPenilaianPersonalia/GetUnit",
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
						return {
							id:obj.Nama_Unit,
							text:obj.Nama_Unit
						};
					})
				};
			}
		}
	});

	//SELECT SEKSI UNTUK CREATE
	$(".js-slcSectionPK").select2({
		placeholder: "Nama Seksi",
		minimumInputLength: 3,
		ajax: {		

			url:baseurl+"PenilaianKinerja/JurnalPenilaianPersonalia/GetSeksi",
			dataType: 'json',
			type: "GET",
			data: function (params) {
				var queryParameters = {
					term: params.term
					// type: $('select#slcSectionPK').val()
				}
				return queryParameters;
			},
			processResults: function (data) {
				return {
					results: $.map(data, function(obj) {
						return {
							id:obj.Nama_Seksi,
							text:obj.Nama_Seksi
						};
					})
				};
			}
		}
	});

	// SELECT SINGLE DATE
	$('.singledatePK').datepicker({
    	autoclose: true,
        format: 'yyyy-mm-dd'
	});

	//SELECT UNIT GROUP
	$(".SlcUnitGroup").select2({
		placeholder: "Unit Group",
		tags: true,
	});

});
	//MENAMBAH ROW UNTUK PEKERJA NONSTAF
	function AddPekerja(base){

		var table = document.getElementById("tblPekerja");
		var nomer = 0;

			var e = jQuery.Event( "click" );
			e.preventDefault();
			var newRow = jQuery("<tr class='clone' row-id='"+nomer+"'>"
									+"<td >"+ nomer +" </td>"
									+"<td>"
										+"<div class='input-group'>"
											+"<div class='input-group-addon'>"
												+"<i class='glyphicon glyphicon-user'></i>"
											+"</div>"
											+"<select class='form-control js-slcPekerja' name='slcPekerja[]' id='slcPekerja'>"
												+"<option value=''></option>"
											+"</select>"
										+"</div>"
									+"</td>"
									+"<td>"
										// +"<button type='button' class='btn btn-danger list-del' onclick='deleteRowAjax("+nomer+",0,0)'><i class='fa fa-remove'></i></button>"
									+"</td>"
								+"</tr>");
			jQuery("#tblPekerja").append(newRow);

			$("select#slcPekerja").select2({
						placeholder: "No Induk",
						minimumInputLength: 3,
						tags: true,
						ajax: {
							url:baseurl+"PenilaianKinerja/JurnalPenilaianPersonalia/GetNoInduk",
							dataType: 'json',
							type: "GET",
							data: function (params) {
								var queryParameters = {
									term: params.term,
									type: $('select#slcPekerja').val()
								}
								return queryParameters;
							},
							processResults: function (data) {
								return {
									results: $.map(data, function(obj) {
										return { id:obj.NoInduk, text:obj.NoInduk+' - '+obj.Nama};
									})
								};
							}
						}	
					}); 

			$("select#slcPekerja:last").select2({
						placeholder: "No Induk",
						minimumInputLength: 3,
						tags: true,
						ajax: {		
							url:baseurl+"PenilaianKinerja/JurnalPenilaianPersonalia/GetNoInduk",
							dataType: 'json',
							type: "GET",
							data: function (params) {
								var queryParameters = {
									term: params.term,
									type: $('select#slcPekerja').val()
								}
								return queryParameters;
							},
							processResults: function (data) {
								return {
									results: $.map(data, function(obj) {
										return { id:obj.NoInduk, text:obj.NoInduk+' - '+obj.Nama};
									})
								};
							}
						}	
					});

			$("select#slcPekerja:last").val("").change();
	
	}