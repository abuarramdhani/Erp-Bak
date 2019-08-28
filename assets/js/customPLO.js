$(function () {
	$('input').iCheck({
		checkboxClass: 'icheckbox_flat-blue',
		radioClass: 'iradio_flat-blue'
	});

	$('.slc2').select2({
		allowClear:true
	});

	$('select[class="input-sm"]').addClass("slc2");

    // $('.monthPeriode').datepicker({
    //     autoclose: true,
    //     todayHighlight: true
    // });
    //edited

    $('.monthPeriode').datepicker( {
        changeMonth: true,
        changeYear: true,
        showButtonPanel: true,
        dateFormat: 'MMM yy',
        onClose: function(dateText, inst) { 
            var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
            var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
            $(this).datepicker('setDate', new Date(year, month, 1));
        }
    });

    //edited

    // $(".monthPeriode").datepicker({
    //     dateFormat: 'MM yy',
    //     changeMonth: true,
    //     changeYear: true,
    //     showButtonPanel: true,

    //     onClose: function(dateText, inst) {
    //         var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
    //         var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
    //         $(this).val($.datepicker.formatDate('MM yy', new Date(year, month, 1)));
    //     }
    // });

    // $(".monthPeriode").focus(function () {
    //     $(".ui-datepicker-calendar").hide();
    //     $("#ui-datepicker-div").position({
    //         my: "center top",
    //         at: "center bottom",
    //         of: $(this)
    //     });
    // });

    // $(".monthPeriode").datepicker({
    //     dateFormat: 'MM yy',
    //     changeMonth: true,
    //     changeYear: true,
    //     showButtonPanel: true,

    //     onClose: function(dateText, inst) {
    //         var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
    //         var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
    //         $(this).val($.datepicker.formatDate('MM yy', new Date(year, month, 1)));
    //     }
    // });

    // $(".monthPeriode").focus(function () {
    //     $(".ui-datepicker-calendar").hide();
    //     $("#ui-datepicker-div").position({
    //         my: "center top",
    //         at: "center bottom",
    //         of: $(this)
    //     });
	// });
	$('#bulan').datepicker({
		autoclose: true,
		format:'M',
		minViewMode: 1,
	});


    $('#date').datepicker( {
        changeMonth: true,
        changeYear: true,
        showButtonPanel: true,
        dateFormat: 'dd MM'
    });

	$('.slcProductFPD').select2({
	allowClear: true,
	tags: true,
	minimumInputLength: 0,
	ajax: {		
				url: baseurl+"PerhitunganLoadingODM/PerhitunganLoadingODM/getSearch",
				dataType: 'json',
				type: "POST",
				data: function (params) {
					var queryParameters = {
						term: params.term
					}
					return queryParameters; 
				},
				processResults: function (data) {
					return {
						results: $.map(data, function(obj) {
							return { id:obj.product_id, text:'('+obj.product_number+')'+obj.product_description};
						})
					};
				}
        }
    }
)}
);

$(document).ready(function(){
	$("#searchOrgCode").select2({
		allowClear: true,
		placeholder: "Department Class",
		minimumInputLength: 0,
		ajax: {		
			url:baseurl+"PerhitunganLoadingODM/Input/OrgCode",
			dataType: 'json',
			type: "GET",
			data: function (params) {
				var queryParameters = {
					term: params.term
				}
				return queryParameters;
			},
			processResults: function (data) {
				console.log(data);
				// $('#kodeorg').val(data.ORGANIZATION_CODE);
				return {
					results: $.map(data, function(obj) {
						return { id:obj.ORGANIZATION_ID, text:obj.ORGANIZATION_CODE};
					})
				};
			}
		}
	});
});

$(document).ready(function(){
	$('#tabeldata').DataTable({
		"scrollX": true,
		"scrollY": 500,
		"scrollCollapse": true,
		"fixedHeader":true
		});
	$('#tblHistoryInput').DataTable({
		// "scrollX": true,
		// "scrollY": 500,
		// "scrollCollapse": true,
		// "fixedHeader":true
	});
	$('#searchOrgCode').change(function(){
	var orgcode = $(this).val();
	console.log(orgcode);
	// $("#searchItemCode").select2('val', null);
	$("#searchItemCode").select2({
		allowClear: true,
		placeholder: "Kode Item",
		minimumInputLength: 3,
		ajax: {		
			url:baseurl+"PerhitunganLoadingODM/Input/ItemCode",
			dataType: 'json',
			type: "GET",
			data: 
				function (params) {
				var queryParameters = {
					term: params.term,
					orgcode : orgcode
				}
				return queryParameters;
			},
			processResults: function (data) {
				console.log(data);
				return {
					results: $.map(data, function(obj) {
						return { id:obj.ITEM_ID, text:obj.ITEM_CODE+" | "+obj.DESCRIP};
					})
				};
			}
		}
	});
	// $.ajax( {
	// 		url:baseurl+"PerhitunganLoadingODM/Input/ItemCode",
	// 		dataType: 'json',
	// 		type:'POST',
	// 		data : {
	// 			orgcode : orgcode
	// 			},
	// 		success: function (data) {
	// 			console.log(data);
	// 			$('#searchItemCode').html('');
	// 			for (let i = 0; i < data.length; i++) {
	// 				var element = data[i];
	// 				// console.log(element)
	// 				$('#searchItemCode').append('<option value="'+element.ITEM_ID+'">'+element.ITEM_CODE+'</option>');
	// 			}
	// 			$('#searchItemCode').select2('val',null);
	// 			// console.log(DEPARTMENT_CODE);
	// 			// return true;
	// 		}
	// 	});
	});
	// $("#searchItemCode").select2({
	// 	allowClear: true,
	// 	placeholder: "Kode Item",
	// 	minimumInputLength: 3,
	// 	ajax: {		
	// 		url:baseurl+"PerhitunganLoadingODM/Input/ItemCode",
	// 		dataType: 'json',
	// 		type: "GET",
	// 		data: function (params) {
	// 			var queryParameters = {
	// 				term: params.term
	// 			}
	// 			return queryParameters;
	// 		},
	// 		processResults: function (data) {
	// 			console.log(data);
	// 			return {
	// 				results: $.map(data, function(obj) {
	// 					return { id:obj.ITEM_ID, text:obj.ITEM_CODE+" | "+obj.DESCRIP};
	// 				})
	// 			};
	// 		}
	// 	}
	// });
});

$(document).ready(function(){
	$("#searchDeptClass").select2({
		allowClear: true,
		placeholder: "Department Class",
		minimumInputLength: 0,
		ajax: {		
			url:baseurl+"PerhitunganLoadingODM/View/DeptClass",
			dataType: 'json',
			type: "GET",
			data: function (params) {
				var queryParameters = {
					term: params.term
				}
				return queryParameters;
			},
			processResults: function (data) {
				console.log(data);
				return {
					results: $.map(data, function(obj) {
						return { id:obj.DEPARTMENT_CLASS_CODE, text:obj.DEPARTMENT_CLASS_CODE};
					})
				};
			}
		}
	});
});

$('#searchDeptClass').change(function(){
	var deptclass = $(this).val();
	console.log(deptclass);
	$("#searchDeptCode").select2('val', null);
	
	$.ajax( {
			url:baseurl+"PerhitunganLoadingODM/View/DeptCode",
			dataType: 'json',
			type:'POST',
			data : {
				deptclass : deptclass
				},
			success: function (data) {
				// console.log(data);
				$('#searchDeptCode').html('');
				for (let i = 0; i < data.length; i++) {
					var element = data[i];
					// console.log(element)
					$('#searchDeptCode').append('<option value="'+element.DEPARTMENT_CODE+'">'+element.DEPARTMENT_CODE+" - "+element.DESCRIPTION+'</option>');
					
				}
				$('#searchDeptCode').select2('val',null);
				// console.log(DEPARTMENT_CODE);
				// return true;
			}
		}
	);
});



// $(document).ready(function(){
// 	$("#searchDeptCode").select2({
// 		allowClear: true,
// 		placeholder: "Department Code",
// 		minimumInputLength: 3,
// 		ajax: {		
// 			url:baseurl+"PerhitunganLoadingODM/View/DeptCode",
// 			dataType: 'json',
// 			type: "GET",
// 			data: function (params) {
// 				var queryParameters = {
// 					term: params.term
// 				}
// 				return queryParameters;
// 			},
// 			processResults: function (data) {
// 				console.log(data);
// 				return {
// 					results: $.map(data, function(obj) {
// 						// return { id:obj.DEPARTMENT_CODE, text:obj.DEPARTMENT_CLASS_CODE};
// 						return { id:obj.DEPARTMENT_CODE+" - "+obj.DESCRIPTION, text:obj.DEPARTMENT_CODE+" - "+obj.DESCRIPTION};
// 					})
// 				};
// 			}
// 		}
// 	});




$("#next").click(function(){
	var available_op = $('input[name="available_op"]').val();
	var hari_kerja = $('input[name="hari_kerja"]').val();
	var input_parameter = $('input[name="input_parameter"]').val();
	var deptclass = $('select[name="deptclass"]').val();
	var deptcode = $('select[name="deptcode"]').val();
	var monthPeriode = $('input[name="monthPeriode"]').val();
	console.log(available_op, hari_kerja, input_parameter, deptclass, deptcode, monthPeriode);
		$.ajax({
			 type : 'POST',
			 url : baseurl+"PerhitunganLoadingODM/View/searchData",
			 data : {
				available_op:available_op,
				hari_kerja:hari_kerja,
				input_parameter:input_parameter,
				deptclass:deptclass,
				deptcode:deptcode,
				monthPeriode:monthPeriode
				},
				beforeSend: function() {
					$('#loading').prop('style', false);
				},
			 success: function(data){
				 console.log(data);
				 document.getElementById("loading").style.display = "none";
				$('#result').html(data);
	 
				$('#tbl-content').DataTable({
				   "scrollX": true,
				   "scrollY": 450,
				   "scrollCollapse": true,
				   "fixedHeader":true
				   });
				// $('.hapus').click(function(){
				// 	$(this).closest('tr').remove();
				// 	console.log($('#tbody_next').html());
				// 	if($('#tbody_next').html().match(/^((?!<tr>).)*$/)){
				// 		$('#tbody_next').hide();
				// 	}
				// 	});
				// $('.add').click(function(){
				// 	$(this).closest('tr').clone(true).appendTo($("#tbody_next"));
				// 	});
				 },
			 error : function(){
				 $('#modal_error').modal();
				 $('#tbody_next').hide();
			 }
	 })
	});

$("#view").click(function(){
	var dept_class = $('select[name="txt_deptclass"]').val();
	var dept_code = $('select[name="txt_deptcode"]').val();
	var month_Periode = $('input[name="txt_monthPeriode"]').val();
	console.log(dept_class, dept_code, month_Periode);
		$.ajax({
				type : 'POST',
				url : baseurl+"PerhitunganLoadingODM/Summary/viewData",
				data : {
					dept_class:dept_class,
					dept_code:dept_code,
					month_Periode:month_Periode
				},
				beforeSend: function() {
					$('#loading').prop('style', false);
				},
				success: function(data){
					console.log(data);
				document.getElementById("loading").style.display = "none";
				$('#result').html(data);
		
				$('#tbl-content').DataTable({
					"scrollX": true,
					"scrollY": 450,
					"scrollCollapse": true,
					"fixedHeader":true
					});
				},
				error : function(){
					$('#modal_error').modal();
					$('#tbody_next').hide();
				}
		})
	});

// $("#available_op, #hari_kerja, #input_parameter, #searchDeptClass, #searchDeptCode, #monthPeriode").change(function(){
// 	// alert($('#pemakai_2').val());
// 	if ( ($('#available_op').val() != null &&
// 		$('#hari_kerja').val() !=null && 
// 		$('#input_parameter').val() != null && 
// 		$('#searchDeptClass').val() != null &&
// 		$('#searchDeptCode').val() != null &&
// 		$('#monthPeriode').val() != null )){
// 		alert('ERROR!!\nItem yang anda pilih merupakan\nitem PENYUSUN dan item NON-PENYUSUN');
// 	}else{
// 		// $("#next").prop('disabled', 'disabled');
// 		$("#next").click(function(){
// 		// $("#tabel_next").show();
// 		var available_op = $('input[name="available_op"]').val();
// 		var hari_kerja = $('input[name="hari_kerja"]').val();
// 		var input_parameter = $('input[name="input_parameter"]').val();
// 		var deptclass = $('select[name="deptclass"]').val();
// 		var deptcode = $('select[name="deptcode"]').val();
// 		var monthPeriode = $('input[name="monthPeriode"]').val();
// 		console.log(available_op, hari_kerja, input_parameter, deptclass, deptcode, monthPeriode);
// 			$.ajax({
// 				 type : 'POST',
// 				 url : baseurl+"PerhitunganLoadingODM/View/searchData",
// 				 data : {
// 					available_op:available_op,
// 					hari_kerja:hari_kerja,
// 					input_parameter:input_parameter,
// 					deptclass:deptclass,
// 					deptcode:deptcode,
// 					monthPeriode:monthPeriode
// 					},
// 				 success: function(data){
// 					//  console.log(data);
// 					$('#result').html(data);
// 					// $('#tbody_next').html(data);
// 					$('.hapus').click(function(){
// 						$(this).closest('tr').remove();
// 						console.log($('#tbody_next').html());
// 						if($('#tbody_next').html().match(/^((?!<tr>).)*$/)){
// 							$('#tbody_next').hide();
// 						}
// 						});
// 					$('.add').click(function(){
// 						$(this).closest('tr').clone(true).appendTo($("#tbody_next"));
// 						});
// 					 },
// 				 error : function(){
// 					 alert('ERROR!!\nItem yang anda pilih merupakan\nitem PENYUSUN dan item NON-PENYUSUN');
// 					 $('#modal_error').modal();
// 					 $('#tbody_next').hide();
// 				 }
// 		 })
// 		});
// 	}
	

function clearform()
{
	document.getElementById("item_code").value=""; //don't forget to set the textbox ID
}

//clear data input form
$('.clrFrom').click(function() {
	$('input').each(function() {
		$(this).val('');
		$(this).parent().removeClass('checked');
		$(this).removeAttr('checked');
	})
});