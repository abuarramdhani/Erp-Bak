$(function () {
	$('input').iCheck({
		checkboxClass: 'icheckbox_flat-blue',
		radioClass: 'iradio_flat-blue'
	});

	$('.slc2').select2({
		allowClear:true
	});

	$('select[class="input-sm"]').addClass("slc2");

	$('.tblSrcFPD').DataTable({
		info : true,
		paging: true
	});

	$('.slcProductFPD').select2({
	allowClear: true,
	// tags: true,
	minimumInputLength: 0,
	ajax: {		
				url: baseurl+"FlowProcess/ProductSearch/getSearch",
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
	});

	selectCheckFPD();
	if(typeof(jenisFPD) != "undefined" && jenisFPD !== null){
		switch (jenisFPD) {
			case 'OPRPROSTD':
				segmentSetupOprPro();
			break;
		}

	}
});

function getFamilykuis(e) {
	var range = e.dataPoint.range;
	var ke = e.dataPoint.key;
	$('#chartFPDKomp2,.tbl-comp').html('<center><img style="width:100px; height:auto" src="'+baseurl+'assets/img/gif/loading12.gif"></center>' );
	$.ajax({
		url: baseurl+"FlowProcess/Grafik/getGrafik",
		type: "POST",
		data:{
			range:range,
			ke : ke
		},
		success:function (result) {
			var array2 = [];
			var htmls = '';
			var data = JSON.parse(result);
	        var array = $.map(data['recapDay'], function(value) {
	            return [value];
	        });
	        var arrayke = $.map(data['ke'], function(value) {
	            return [value];
	        });

		        for (var i = 0; i < array.length; i++) {
		        	array2.push({ x:new Date(array[i]['tgl']),y : Number(array[i]['su']) })
	            	}
	        var arrayComp = $.map(data['recapComp'], function(value) {
	            return [value];
	        });
			setTimeout(function () {
				var chart3 = new CanvasJS.Chart("chartFPDKomp2", {

                animationEnabled: true,
                theme: "light2",
                title:{
                  text: "Detail Minggu "+arrayke[0]['ke']
                },
                axisY:{
                  includeZero: false
                },


                data : [{
                    type: "area",
                    dataPoints:array2
                }]
              });
              chart3.render();
			},1500);
			setTimeout(function () {
				if (arrayComp.length > 0 ) {
					for (var i = 0; i < arrayComp.length; i++) {
			        	htmls += '<tr>';
			        	htmls += '<td><center>'+arrayComp[i]['tgl']+'</center></td>';
			        	htmls += '<td>'+arrayComp[i]['cd_comp']+' di Produk '+arrayComp[i]['desc_prod']+'</td>';
			        	htmls += '</tr>'
		            	}
		            $('.tbl-comp').html(htmls);
				}else{
					htmls += 'Tidak ada input data komponen di minggu ke '+arrayke[0]['ke'];
		            $('.tbl-comp').html(htmls);
				}
			},1500);
		}
	})
}

function clearform()
{
    document.getElementById("product_number").value=""; //don't forget to set the textbox ID
    document.getElementById("product_description").value=""; //don't forget to set the textbox ID
    document.getElementById("status2").value=""; //don't forget to set the textbox ID
}

//clear data input form
// $('.clrFrom').click(function() {
// 	$('input').each(function() {
// 		$(this).val('');
// 		$(this).parent().removeClass('checked');
// 		$(this).removeAttr('checked');
// 	})
// });

$('.clrFrom').click(function() {
	// $('input').each(function() {
		// $(this).val('');
		$('input').parent().removeClass('checked');
		$('input').removeAttr('checked');
		$("#drw_date").val('');
		$("#product_id").val('');
		$("#drw_description").val('');
		$("#drw_group").val('');
		$("#drw_material").val('');
		$("#rev").val('');
		$("#weight").val('');
		$("#changing_ref_doc").val('');
		$("#old_drw_code").val('');
		$("#changing_ref_expl").val('');
		// $("#statuscomp1").iCheck("check", false);
	// })
});

$('#btnOpenProduct')
	.mouseover(function () {
		$(this).find('b').removeClass('fa-folder').addClass('fa-folder-open');
	})
	.mouseout(function () {
		$(this).find('b').addClass('fa-folder').removeClass('fa-folder-open');
	})
$('select[name="slcProductFPD"]').change(function () {
	var product_id = $(this).val();
	console.log(product_id);
	$('.rs').hide();
	if (product_id == '') { 
		return false};
	$('.res1').show();
	$('.resFPD').hide();
	$('.res-load').hide().html('');
 	$('#loadingPageFPD').html('<center><img style="width:130px; height:auto" src="'+baseurl+'assets/img/gif/loading2.gif"></center>' );
	$.ajax({
		url: baseurl+"FlowProcess/ProductSearch/getDescription",
		dataType: "json",
		type: "POST",
		data: {
				product_id : product_id
			},
		success: function (result) {
			console.log(result);
			$('#loadingPageFPD').html('');
			$('.resFPD').show();
			$('.res-resume').show();
			$('.srcRes1').text(result.pn);
			$('.srcRes2').text(result.pd);
			$('.srcRes3').text(result.ps);
			$('.srcRes4').text(result.ed);
			$('.srcRes5').html(result.gu);
			$('#resume_tgk').html(result.rs.tgk);
			$('#resume_bomp').html(result.rs.bomp);
			$('#resume_bomsp').html(result.rs.bomsp);
			$('#resume_jo').html(result.rs.jo);
			$('#resume_so').html(result.rs.so);
			if (result.gun != '') {
				$('#fileOldTemp').html('<a id="linkOldDrawing" target="_blank" href=""> <b id="fileOldDrawing">()</b></a>').css('text-decoration','none');
				$('#butOldFileTemp').html('<b class="text-danger" id="delFileOldDrawing" data-id=""> Delete </b>');
			}else{
				$('#fileOldTemp').html('<b>File not Found</b>').css('color','black').css('text-decoration','none');
				$('#butOldFileTemp').html('');
			}
			$('input[name="txtProductNumber"]').val(result.pn);
			$('input[name="txtProductDesc"]').val(result.pd);
			$('#fileOldDrawing').text('( '+result.gun+' )');
			$('#linkOldDrawing').attr('href',baseurl+'assets/upload_flow_process/product/'+result.gun);
			$('#delFileOldDrawing').attr('data-id',result.pi).attr('data-nm',result.gun);
			$('input[name="statusProduct"]').parent().removeClass('checked');
			$('input[name="statusProduct"]').each(function () {
				if ($(this).attr('value') == result.pso ) {
					$(this).attr('checked','checked');
					$(this).parent().addClass('checked');
				}
			})
			$('input[name="dateEndDateActive"]').val(result.ed);
			$('input[name="product_id"]').val(result.pp);
			$('.btnSaveEditProduct').attr('value',product_id);
			$('#btnOpenProduct').attr('data-id',product_id);
		}
	});
});

$('#btnEditProduct').click(function () {
	$('.res1').slideUp();
	$('.res2').slideDown();
			$('#delFileOldDrawing')
				.mouseover(function () {
					$('#fileOldDrawing').css('text-decoration','line-through');
				})
				.mouseout(function () {
					$('#fileOldDrawing').css('text-decoration','none');
				})
	$('input[name="statusProduct"]').on('ifChanged',function(){
			if($(this).is(':checked')){
				$(this).attr('checked','checked');
			}else{
				$(this).removeAttr('checked');
			}
	});
	$('#delFileOldDrawing').click(function () {
		var text = $('#fileOldDrawing').text();
		var product_id = $(this).attr('data-id');
		var file_gambar = $(this).attr('data-nm');
		$(this).parent().append('<img id="imgloadFPD" style="width:30px; height:auto" src="'+baseurl+'assets/img/gif/spinner.gif">' );
			$.ajax({
				url: baseurl+"FlowProcess/ProductSearch/deleteFIleGambar",
				type: "post",
				data: {product_id:product_id, file_gambar : file_gambar },
				success: function () {
					$('#imgloadFPD').parent().html('File Deleted').addClass('text-danger').css('font-weight','bold');
					$('#linkOldDrawing').parent().text(text).addClass('text-danger').css('text-decoration','line-through');
					$(this).remove();
				}
			});
	})
});

$('#btnOpenProduct, .btnFrmFPDsub1').click(function(){
	$('.ndas, .res1, .res2,.res-resume').hide();
	$('.res3').show().html('<center><img style="height:auto; width:120px" src="'+baseurl+'assets/img/gif/loading13.gif"></center>');
	$('.btnFrmFPDsub2,.btnFrmFPDsub3').hide();
	var product_id = $(this).attr('data-id');
	var pn = $('.srcRes1').text();
	var pd = $('.srcRes2').text();
	$.ajax({
		url: baseurl+"FlowProcess/ProductSearch/viewComponent",
		type: "post",
		dataType: "html",
		data:{ product_id:product_id },
		success: function (result) {
			$('.res3').show().html(result);
			$('.res-load').hide().html('');
			$('#titleSrcFPD').text('Product ('+pn+') '+pd);
			$('.btnFrmFPDsub1').show();
			$('#subTitleSub1').parent().attr('data-id',product_id);
			$('.btnFrmFPDsub2').hide();
			$('#subTitleSub1').text('Component ('+pn+') '+pd);
			$(".tblSrcFPD").dataTable({
				info : false,
				paging: true
			});
			$('.tblSrcFPD').on('draw.dt', function () {
				$('input').iCheck({
					checkboxClass: 'icheckbox_flat-blue',
					radioClass: 'iradio_flat-blue'
				});
				AddComponentFPD();
			});
			$('input').iCheck({
					checkboxClass: 'icheckbox_flat-blue',
					radioClass: 'iradio_flat-blue'
				});
			$('select,.slc2').select2({
				allowClear:true
			});

			$(".tblSrcFPD").wrap('<div class="dataTables_scroll" />');
			AddComponentFPD();

		}
		});
});


var AddComponentFPD = function () {
	$('input[name="slcStatusComponent"]').on('ifChanged',function(){
		if($(this).is(':checked')){
			$(this).attr('checked','checked');
		}else{
			$(this).removeAttr('checked');
		}
		val = $('input[name="slcStatusComponent"]:checked').val();
		// if (val == '1') {
		// 	$('.old-code').slideUp();
		// }else{
		// 	$('.old-code').slideDown();
		// }
	});

	$('input').on('ifChanged',function(){
		if($(this).is(':checked')){
			$(this).attr('checked','checked');
		}else{
			$(this).removeAttr('checked');
		}
	});


	$('.btnAddComponentFPD').click(function () {
		var product_id = $(this).attr('data-id');
		$('.res3').html('<center><img style="width:120px; height:auto" src="'+baseurl+'assets/img/gif/loading13.gif"> <p class="text-success">Loading Form ...</p></center>');
		$.ajax({
			url: baseurl+"FlowProcess/ProductSearch/setupComponent",
			type: "post",
			dataType: "html",
			data:{ product_id:product_id },
			success: function (result) {
					$('.res-load').hide().html('');
					$('.res3').show().html(result);
					// done();
					$('.dtPicker').datepicker({
						autoclose: true,
					    todayHighlight: true
					});
					$('input').iCheck({
							checkboxClass: 'icheckbox_flat-blue',
							radioClass: 'iradio_flat-blue'
						});
					$('.btnFrmFPDsub2').show();
					$('#subTitleSub2').text('Add New Component');
					AddComponentFPD();
				}
			});
	});

	$('.btnAddComponentFPD2').click(function () {
		var product_id = $(this).attr('data-id');
		var pn = $('.srcRes1').text();
		var pd = $('.srcRes2').text();
		console.log(product_id),
		// $('.res3').html('<center><img style="width:120px; height:auto" src="'+baseurl+'assets/img/gif/loading13.gif"> <p class="text-success">Loading Form ...</p></center>');
		$.ajax({
				url: baseurl+"FlowProcess/ProductSearch/viewCompbyId",
				type: "post",
				dataType: "html",
				data:{ product_id : product_id },
				success: function (result) {
					console.log(result),
					$('.res3').show().html(result);
					$('.res-load').hide().html('');
					$('#titleSrcFPD').text('Product ('+pn+') '+pd);
					$('.btnFrmFPDsub1').show();
					$('#subTitleSub1').parent().attr('data-id',product_id);
					$('.btnFrmFPDsub2').hide();
					$('#subTitleSub1').text('Component ('+pn+') '+pd);
					$(".tblSrcFPD").dataTable({
						info : false,
						paging: true
					});
					$('.tblSrcFPD').on('draw.dt', function () {
						$('input').iCheck({
							checkboxClass: 'icheckbox_flat-blue',
							radioClass: 'iradio_flat-blue'
						});
						AddComponentFPD();
					});
					$('input').iCheck({
							checkboxClass: 'icheckbox_flat-blue',
							radioClass: 'iradio_flat-blue'
						});
					$('select,.slc2').select2({
						allowClear:true
					});
		
					$(".tblSrcFPD").wrap('<div class="dataTables_scroll" />');
					AddComponentFPD();
		
				}
				});
	});
	

	$('input[name="checkrad[]"]').on('ifChanged',function(){
		if($(this).is(':checked')){
			$(this).attr('checked','checked');
			$('.btnFPDCompoDel').show('slow');
			$('.btnFPDCompoDel,.btnFPDCompoDit, .btnSetupOprFPD').removeAttr('disabled').css('pointer','cursor');
			component_id = $(this).val();
			drw_code = $(this).parent().parent().closest('tr').find('.drw_code').text();
			jml_opr = $(this).parent().parent().closest('td').find('input[name="opr"]').val();
			$('.btnSetupOprFPD').attr('data-id',component_id).attr('data-nm',drw_code);
			$('.btnAddOperationFPD').attr('data-id',component_id);
			$('input[name="kode_comp"]').val(component_id);
			$('input[name="name_comp"]').val(drw_code);
			$('input[name="opr_comp"]').val(jml_opr);
		}else{
			$(this).removeAttr('checked');
			$(this).parent().removeClass('checked');
			$('.btnFPDCompoDel, .btnFPDCompoDit, .btnSetupOprFPD').attr('disabled','disabled').css('pointer','none');
		}
	});

	$('.btnFPDCompoDel').click(function () {
		ComponentList = '';
		$('input[name="checkrad[]"]').each(function() {
			var attrCheck = $(this).attr('checked');
			if (($(this).is(':checked')) || (typeof attrCheck !== typeof undefined && attrCheck !== false)){
				d_code = $(this).parent().parent().closest('tr').find('.d_code').text();
				d_desc = $(this).parent().parent().closest('tr').find('.d_desc').text();
				ComponentList += '<b>('+d_code+') '+d_desc+'</b></br>';
				joinih = $(this).val();
			}
		});
		$('#apaajaDelFPD').html(ComponentList);
		$('input[name="component_id"]').val(joinih);
		$('.inActiveComponentFPD,.closeComponentFPD').removeAttr('disabled');
	});

	$('.inActiveComponentFPD').click(function () {
		var component_id = $('input[name="component_id"]').val();
		var product_id = $(this).attr('data-id');
		$('.inActiveComponentFPD,.closeComponentFPD').attr('disabled','disabled');
		$('#apaajaDelFPD').html('<center><img style="width:130px; height:auto" src="'+baseurl+'assets/img/gif/loading2.gif"></center>' );
		$.ajax({
			url: baseurl+"FlowProcess/ComponentSetup/InnactiveComponent",
			type: "post",
			dataType: "html",
			data: {component_id:component_id, product_id:product_id},
			success: function (result) {
					$('#modalDelFPD').modal('hide');
					$('body').removeClass('modal-open');
					$('.modal-backdrop').remove();
					$('.res3').show().html('<center><img style="width:120px; height:auto" src="'+baseurl+'assets/img/gif/loading13.gif"> </center>');
					setTimeout(function(){ $('.res3').show().html(result); 
						$(".tblSrcFPD").dataTable({
							info : false,
							paging: false
						});
						$('input').iCheck({
								checkboxClass: 'icheckbox_flat-blue',
								radioClass: 'iradio_flat-blue'
							});
						$('.slc2').select2({
							allowClear:true
						});
						$(".tblSrcFPD").wrap('<div class="dataTables_scroll" />');
						AddComponentFPD();
					}, 1500);
				}
		})
	});


	// $('#import_excel_btn1').click(function () {
	// 	$('#loadingimport').html('<center>apa<img style="width:120px; height:auto" src="'+baseurl+'assets/img/gif/loading13.gif"> </center>');
	// });

	$('.btnSaveComp').click(function () {
		$("#formAddComponent").submit(function(evt){
      evt.preventDefault();
      var formData = new FormData($(this)[0]);
			$.ajax({
					url: baseurl+"FlowProcess/ComponentSetup/saveComp",
					type: 'POST',
					data: formData,
					async: false,
					cache: false,
					contentType: false,
					enctype: 'multipart/form-data', 
					processData: false,
					success: function (result) {
							$('.btnFrmFPDsub1').hide();
							$('body').removeClass('modal-open');
							$('.modal-backdrop').remove();
							$('.res3').show().html('<center><img style="width:120px; height:auto" src="'+baseurl+'assets/img/gif/loading13.gif"> </center>');
							setTimeout(function(){ $('.res3').show().html(result); 
								$(".tblSrcFPD").dataTable({
									info : false,
									paging: false,
									pageLength: true
								});
								$('input').iCheck({
										checkboxClass: 'icheckbox_flat-blue',
										radioClass: 'iradio_flat-blue'
									});
								$('.slc2').select2({
									allowClear:true
								});
								$(".tblSrcFPD").wrap('<div class="dataTables_scroll" />');
								AddComponentFPD();
							}, 1500);
						}
			});
		});
	});

	$('#saveOperation').click(function() {
		$("#formAddOperation").submit(function(evt){
      evt.preventDefault();
      var formData = new FormData($(this)[0]);
			$.ajax({
					url: baseurl + "FlowProcess/OperationSetup/saveOperation",
					type: 'POST',
					data: formData,
					async: false,
					cache: false,
					contentType: false,
					enctype: 'multipart/form-data', 
					processData: false,
					success: function (result) {
						
						Swal.fire({
							type: 'success',
							width: 700,
							heightAuto: false,
							showConfirmButton: true,
							title: 'Operation Saved'
						});
						// $('input[name="txtSeqNumber"]').val('');
						// $('input[name="slcOperationProcess"]').val('');
						// $('input[name="txtProcessDetail"]').val('');
						// $('input[name="txtMachineMinReq"]').val('');
						// $('input[name="slcPlanningTool"]').val('');
						// $('input[name=""]').val('');
						// $('input[name=""]').val('');
						// $('input[name=""]').val('');
						// $('input[name="slcPlanning"]').parent().removeClass('checked');
						// $('input[name="slcPlanning"]').removeAttr('checked');

						// $('.btnFrmFPDsub3').hide();
						$('.res3').html(result);
						// $('.res-load').hide().html('');
						// $(".tblSrcFPD").dataTable({
						// 	info : false,
						// 	paging: true
						// });
						// $('input').iCheck({
						// 		checkboxClass: 'icheckbox_flat-blue',
						// 		radioClass: 'iradio_flat-blue'
						// 	});
						// $('select.input-sm').parent().css('width','50%');
						// $('select,.slc2').select2({
						// 	allowClear:true
						// });
						// $(".tblSrcFPD").wrap('<div class="dataTables_scroll" />');
	
						// OperationSetupFPD();
					}
			});
		});
	});

	$('.btnFPDCompoDit').click(function () {
		var product_id = $(this).attr('data-id');
		// $('input[name="checkrad[]"]').each(function() {
		// 	var attrCheck = $(this).attr('checked');
		// 	if (($(this).is(':checked')) || (typeof attrCheck !== typeof undefined && attrCheck !== false)){
		// 		component_id = $(this).val();
		// 		drw_code = $(this).parent().parent().closest('tr').find('.drw_code').text();
		// 	}
		// });
		component_id = $('input[name="kode_comp"]').val();
		drw_code = $('input[name="name_comp"]').val();
		$('.res3').html('<center><img style="width:120px; height:auto" src="'+baseurl+'assets/img/gif/loading13.gif"> <p class="text-success">Loading Form ...</p></center>');
		$.ajax({
			url: baseurl+"FlowProcess/ComponentSetup/editComponent",
			type: "post",
			dataType: "html",
			data: {component_id:component_id, product_id:product_id},
			success:function (result) {
				$('.btnFrmFPDsub2').show();
				$('#subTitleSub2').text('Edit Component ('+drw_code+')');
				// $('.res-load').hide().html('');
				$('.res3').html(result);
				// done();
				$('.dtPicker').datepicker({
					autoclose: true,
				    todayHighlight: true
				});
				$('input[type=radio]').iCheck({
					radioClass: 'iradio_flat-blue'
				});
				FileHAndlerFPD();
				AddComponentFPD();
			}
		})
	});

	$('.row-comp').click(function () {
		$(this).find('input[name="checkrad[]"]').iCheck('toggle');
	})

	$('.btnSetupOprFPD , button[data-jn="opr"]').click(function() {
		$('.btnFrmFPDsub3').hide();
		var jml_opr = $('input[name="opr_comp"]').val();
		// $('input[name="checkrad[]"]').each(function() {
		// 	var attrCheck = $(this).attr('checked');
		// 	if (($(this).is(':checked')) || (typeof attrCheck !== typeof undefined && attrCheck !== false)){
		// 		jml_opr = $(this).parent().parent().closest('td').find('input[name="opr"]').val();
		// 	}
		// });
		if (Number(jml_opr) < 1 ) {
			$('#modalSetupOpr').modal('show');
			OperationSetupFPD();
			return;
		}
		var component_id = $(this).attr('data-id');
		var drw_code = $(this).attr('data-nm');
			$('.btnFrmFPDsub2').show();
			$('#subTitleSub2').text('Operation '+drw_code);
			$('.btnFrmFPDsub2').attr('data-id',component_id);
			$('.btnFrmFPDsub2').attr('data-nm',drw_code);
			$('.btnFrmFPDsub2').attr('data-jn','opr');
			$('.res3').html('<center><img style="width:120px; height:auto" src="'+baseurl+'assets/img/gif/loading13.gif">');
			$.ajax({
				url: baseurl+"FlowProcess/OperationSetup/viewOperation",
				type: "post",
				dataType: "html",
				data: {component_id:component_id},
				success: function (result) {
					$('.res3').html(result);
					$('.res-load').hide().html('');
					$(".tblSrcFPD").dataTable({
						info : false,
						paging: true
					});
					$('input').iCheck({
							checkboxClass: 'icheckbox_flat-blue',
							radioClass: 'iradio_flat-blue'
						});
					$('select.input-sm').parent().css('width','50%');
					$('select,.slc2').select2({
						allowClear:true
					});
					$(".tblSrcFPD").wrap('<div class="dataTables_scroll" />');

					OperationSetupFPD();
				}
			});

	});
}

var FileHAndlerFPD = function(){
	$('.btnDelFileFPD')
		.mouseover(function () {
			$(this).parent().parent().find('.nameOldFileFPD').css('text-decoration','line-through');
		})
		.mouseout(function () {
			$(this).parent().parent().find('.nameOldFileFPD').css('text-decoration','none');
		});
	$('.btnDelFileFPD').click(function () {
		var mode = $(this).attr('data-mode');
		var text = $(this).parent().parent().find('.nameOldFileFPD').text();
		var param_id = $(this).attr('data-id');
		var file_gambar = $(this).attr('data-nm');
		var type = $(this).attr('data-type');
			if (mode == '1') {
				cont = 'ComponentSetup/deleteFIleGambar';
			}else if(mode == '2'){
				cont = 'OperationSetup/deleteFIleGambar';
			}
			$(this).parent().append('<img id="imgloadFPD" style="width:30px; height:auto" src="'+baseurl+'assets/img/gif/spinner.gif">' );
			$.ajax({
				url: baseurl+"FlowProcess/"+cont,
				type: "POST",
				data: {param_id:param_id, file_gambar : file_gambar ,type:type},
				success: function () {
					$('#imgloadFPD').parent().html('File Deleted').addClass('text-danger').css('font-weight','bold');
					$('.tempBtnOld[data-type="'+type+'"]').parent().find('.tempFileOld').html(text).addClass('text-danger').css('text-decoration','line-through');
					$(this).remove();
				}
			});
		});
}
$(document).ready(function(){
$('.btnFrmFPDHome').click(function () {
	$('.rs').hide();
	$('#titleSrcFPD').text('Product Search');
	$('.btnSub').hide();
	$('.ndas').show();
	$('.slcProductFPD').val(null).trigger('change');
	$('.slcProductFPD').html('<option></option>');
	$('.slcProductFPD').select2({
	allowClear: true,
	// tags: true,
	minimumInputLength: 0,
	ajax: {		
				url: baseurl+"FlowProcess/ProductSearch/getSearch",
				dataType: 'json',
				type: "POST",
				data: function (params) {
					var queryParameters = {
						term: params.term
					}
					// console.log($params.term)
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
	});
});
});

var OperationSetupFPD = function () {
	$('.row-opr').click(function () {
		$(this).find('input[name="check[]"]').iCheck('toggle');
		// a = 0;
		// var attrCheck = $(this).find('input[name="check[]"]').attr('checked');
		// if (($(this).find('input[name="check[]"]').is(':checked')) || (typeof attrCheck !== typeof undefined && attrCheck !== false)){
		// 	a = 1;
		// }
		// if (a == 0) { $(this).removeClass('tract') }
	});
	$('.btnAddOperationFPD').click(function () {
		var component_id = $(this).attr('data-id');
		var drw_code = $('input[name="name_comp"]').val();
		if (drw_code == 'undefined' || drw_code == undefined) {
			var drw_code = $('.btnFrmFPDsub2').attr('data-nm');
		}
		$('body').removeClass('modal-open');
		$('.modal-backdrop').remove();
		$('.res3').html('<center><img style="width:120px; height:auto" src="'+baseurl+'assets/img/gif/loading13.gif">');
		$.ajax({
			url: baseurl+"FlowProcess/OperationSetup/setupOperation",
			dataType: "html",
			type:"POST",
			data: {component_id:component_id},
			success: function (result) {
				$('.btnFrmFPDsub2').show().attr('data-id',component_id).attr('data-nm',drw_code).attr('data-jn','opr');
				$('#subTitleSub2').text('Operation '+drw_code);
				$('.btnFrmFPDsub3').show();
				$('#subTitleSub3').text('Add New Operation');
				$('.res3').html(result);
				$('input').iCheck({
					checkboxClass: 'icheckbox_flat-blue',
					radioClass: 'iradio_flat-blue'
				});
				$('.slc2').select2({
					allowClear:true
				});
				$('.dtPicker').datepicker({
					autoclose: true,
				    todayHighlight: true
				});
					$('.slcToolExist').select2({
						allowClear: true,
						tags: true,
						minimumInputLength: 3,
						ajax: {		
									url: baseurl+"FlowProcess/OperationSetup/getTool",
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
												return { id:obj.fs_no_order, text:'('+obj.fs_nm_tool+')'+obj.fs_kd_komp+' '+obj.fs_nm_komp};
											})
										};
									}
							}
						});
				OperationSetupFPD();
				AddComponentFPD();
			}
		})
	});
	viewOperationFPD();

	$('button[jns-btn="opr"]').click(function () { 
		id = $(this).attr('data-id');
		name = $(this).attr('data-nm');
		OperationSetupFPD(name,id);
	});


	$('input[name="slcPlanningTool"]').on('ifChanged',function(){
		if($(this).is(':checked')){
			$(this).attr('checked','checked');
		}else{
			$(this).removeAttr('checked');
		}
		val = $('input[name="slcPlanningTool"]:checked').val();
		if (val == '1') {
			$('.frmtool').slideDown();
		}else{
			$('.frmtool,.frmtool2').slideUp();
			$('input[name="slcTool"]').removeAttr('checked');
			$('input[name="slcTool"]').parent().removeClass('checked');
		}
	});

	$('input[name="slcPlannigMeasurementTool"]').on('ifChanged',function(){
		if($(this).is(':checked')){
			$(this).attr('checked','checked');
		}else{
			$(this).removeAttr('checked');
		}
		val = $('input[name="slcPlanningTool"]:checked').val();
		if (val == '1') {
			$('.frmMeasurement').slideDown();
		}else{
			$('.frmMeasurement').slideUp();
		}
	});

	$('input[name="slcTool"]').on('ifChanged',function(){
		if($(this).is(':checked')){
			$(this).attr('checked','checked');
		}else{
			$(this).removeAttr('checked');
		}
		val = $('input[name="slcTool"]:checked').val();
		if (val == '1') {
			$('.frmtool2').slideDown();
		}else{
			$('.frmtool2').slideUp();
		}

		$('.slcToolExist').select2({
		allowClear: true,
		tags: true,
		minimumInputLength: 3,
		ajax: {		
					url: baseurl+"FlowProcess/OperationSetup/getTool",
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
								return { id:obj.fs_no_order, text:'('+obj.fs_nm_tool+')'+obj.fs_kd_komp+' '+obj.fs_nm_komp};
							})
						};
					}
			}
		});
	});

}

var viewOperationFPD = function () {
	$('input[name="select-all"]').on('ifChanged',function(){
		var countChk = 0;
		if($(this).is(':checked')){
			$(this).attr('checked','checked');
			$('input[name="check[]"]').each(function() {
				countChk += 1;
					$(this).attr('checked','checked');
					$(this).parent().addClass('checked');
				})
		}else{
			$(this).removeAttr('checked');
			$('input[name="check[]"]').each(function() {
					$(this).removeAttr('checked');
					$(this).parent().removeClass('checked');
				})
		}

		if (countChk > 0) {
			$('.btnFPDOperaDel').removeAttr('disabled').css('pointer','cursor');
			if (countChk > 1) {
				$('.btnFPDOperaDit').attr('disabled','disabled').css('pointer','none');
			}else{
				$('.btnFPDOperaDit').removeAttr('disabled').css('pointer','cursor');
			}
		}else{
			$('.btnFPDOperaDel, .btnFPDOperaDit').attr('disabled','disabled').css('pointer','none');
		}
	});

	$('input[name="check[]"]').on('ifChanged',function(){
		countChk = 0;
		if($(this).is(':checked')){
			$(this).attr('checked','checked');

		}else{
			$(this).removeAttr('checked');
		}
		$('input[name="check[]"]').each(function() {
				if($(this).is(':checked')){
					countChk += 1;
				}
				if (countChk > 0) {
					$('.btnFPDOperaDel').removeAttr('disabled').css('pointer','cursor');
					if (countChk > 1) {
						$('.btnFPDOperaDit').attr('disabled','disabled').css('pointer','none');
					}else{
						$('.btnFPDOperaDit').removeAttr('disabled').css('pointer','cursor');
					}
				}else{
					$('.btnFPDOperaDel, .btnFPDOperaDit').attr('disabled','disabled').css('pointer','none');
				}
			});
	});

	$('.btnFPDOperaDel').click(function () {
		countChk = 0;
		arrOperation = [];
		OperationList = '';
		$('input[name="check[]"]').each(function() {
			var attrCheck = $(this).attr('checked');
			if (($(this).is(':checked')) || (typeof attrCheck !== typeof undefined && attrCheck !== false)){
				countChk += 1;
				d_seq_num = $(this).parent().parent().closest('tr').find('.seq_num').text();
				OperationList += 'operation Sequence Number <b>'+d_seq_num+' </b></br>';
				arrOperation.push($(this).val());
			}
		});
		joinih = arrOperation.join(',');
		$('#jmlDelFPD').html(countChk);
		$('#apaajaDelFPD').html(OperationList);
		$('input[name="operation_id"]').val(joinih);
		$('.delOperationFPD,.closeOperationFPD').removeAttr('disabled');
	});


	$('.delOperationFPD').click(function () {
		var operation_id = $('input[name="operation_id"]').val();
		var component_id = $(this).attr('data-id');
		$('.delOperationFPD,.closeOperationFPD').attr('disabled','disabled');
		$('#apaajaDelFPD').html('<center><img style="width:130px; height:auto" src="'+baseurl+'assets/img/gif/loading2.gif"></center>' );
		$.ajax({
			url: baseurl+"FlowProcess/OperationSetup/deleteOperation",
			type: "post",
			dataType: "html",
			data: {component_id:component_id, operation_id:operation_id},
			success: function (result) {
					$('#modalDelFPD').modal('hide');
					$('body').removeClass('modal-open');
					$('.modal-backdrop').remove();
					$('.res3').show().html('<center><img style="width:120px; height:auto" src="'+baseurl+'assets/img/gif/loading13.gif"> </center>');
					setTimeout(function(){ $('.res3').show().html(result); 
						$(".tblSrcFPD").dataTable({
							info : false,
							paging: true
						});
						$('input').iCheck({
								checkboxClass: 'icheckbox_flat-blue',
								radioClass: 'iradio_flat-blue'
							});
						$('.slc2').select2({
							allowClear:true
						});
						$(".tblSrcFPD").wrap('<div class="dataTables_scroll" />');
						OperationSetupFPD();
					}, 1500);
				}
		})
	});

	$('.btnFPDOperaDit').click(function () {
		var component_id = $(this).attr('data-id');
		$('input[name="check[]"]').each(function() {
			var attrCheck = $(this).attr('checked');
			if (($(this).is(':checked')) || (typeof attrCheck !== typeof undefined && attrCheck !== false)){
				operation_id = $(this).val();
				seq_num = $(this).parent().parent().closest('tr').find('.seq_num').text();
			}
		});
		$('.res3').html('<center><img style="width:120px; height:auto" src="'+baseurl+'assets/img/gif/loading13.gif"> <p class="text-success">Loading Form ...</p></center>');
		$.ajax({
			url: baseurl+"FlowProcess/OperationSetup/editOperation",
			type: "post",
			dataType: "html",
			data: {operation_id:operation_id, component_id:component_id},
			success:function (result) {
				$('.btnFrmFPDsub3').show();
				$('#subTitleSub3').text('Edit Operation (Seq '+seq_num+')');
				$('.res-load').hide().html('');
				$('.res3').show().html(result);
				// done();
				$('.dtPicker').datepicker({
					autoclose: true,
				    todayHighlight: true
				});
				$('input[type=radio]').iCheck({
					radioClass: 'iradio_flat-blue'
				});
				$('.slcToolExist').select2({
						allowClear: true,
						tags: true,
						minimumInputLength: 3,
						ajax: {		
									url: baseurl+"FlowProcess/OperationSetup/getTool",
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
												return { id:obj.fs_no_order, text:'('+obj.fs_nm_tool+')'+obj.fs_kd_komp+' '+obj.fs_nm_komp};
											})
										};
									}
							}
						});
				OperationSetupFPD();
				FileHAndlerFPD();
			}
		});
		AddComponentFPD();
	});
}

function getInfoFPD(th) {
	var nomor = $(th).attr('data-id');
	var name = $(th).parent().parent().find('.planning_tool').text();
	$('#modalInfoFPDtit').text(name);
	$('#modalInfoFPDBody').html('<center><img style="width:130px; height:auto" src="'+baseurl+'assets/img/gif/loading2.gif"></center>' );
	$.ajax({
		url : baseurl+"FlowProcess/OperationSetup/getInfoTool",
		type: "POST",
		data: {nomor:nomor},
		success: function (result) {
			$('#modalInfoFPDBody').html(result);
		}
	})
}


var selectCheckFPD = function () {
	$('input[name="select-all"]').on('ifChanged',function(){
		var countChk = 0;
		if($(this).is(':checked')){
			$(this).attr('checked','checked');
			$('input[name="check[]"]').each(function() {
				countChk += 1;
					$(this).attr('checked','checked');
					$(this).parent().addClass('checked');
				})
		}else{
			$(this).removeAttr('checked');
			$('input[name="check[]"]').each(function() {
					$(this).removeAttr('checked');
					$(this).parent().removeClass('checked');
				})
		}

		if (countChk > 0) {
			$('.btnFPD1').removeAttr('disabled').css('pointer','cursor');
			if (countChk > 1) {
				$('.btnFPD2').attr('disabled','disabled').css('pointer','none');
			}else{
				$('.btnFPD2').removeAttr('disabled').css('pointer','cursor');
			}
		}else{
			$('.btnFPD1, .btnFPD2').attr('disabled','disabled').css('pointer','none');
		}
	});

	$('input[name="check[]"]').on('ifChanged',function(){
		countChk = 0;
		if($(this).is(':checked')){
			$(this).attr('checked','checked');

		}else{
			$(this).removeAttr('checked');
		}
		$('input[name="check[]"]').each(function() {
				if($(this).is(':checked')){
					countChk += 1;
				}
				if (countChk > 0) {
					$('.btnFPD1').removeAttr('disabled').css('pointer','cursor');
					if (countChk > 1) {
						$('.btnFPD2').attr('disabled','disabled').css('pointer','none');
					}else{
						$('.btnFPD2').removeAttr('disabled').css('pointer','cursor');
					}
				}else{
					$('.btnFPD1, .btnFPD2').attr('disabled','disabled').css('pointer','none');
				}
			});
	});
}


function segmentSetupOprPro() {
	$('.row-ops').click(function () {
		$(this).find('input[name="check[]"]').iCheck('toggle');
	})
	$('.btnFPD').click(function () {
		$('.res-div').html('<center><img style="width:120px; height:auto" src="'+baseurl+'assets/img/gif/loading13.gif">Loading Form</center>');
		$.ajax({
			url: baseurl+"FlowProcess/Setup/OperationProcessStd/AddOPS",
			dataType: "html",
			type:"POST",
			success: function (result) {
				$('.btnFrmFPDsub01').show();
				$('#subTitleSub1').text('Add New Operation Process Standard');
				$('.res-div').html(result);
				$('input').iCheck({
					checkboxClass: 'icheckbox_flat-blue',
					radioClass: 'iradio_flat-blue'
				});
				$('.slc2').select2({
					allowClear:true
				});
				$('.dtPicker').datepicker({
					autoclose: true,
				    todayHighlight: true
				});
			}
		});
	});
	$('.btnFPD1').click(function () {
		countChk = 0;
		arrOprPro = [];
		opr_pro_list = '';
		$('input[name="check[]"]').each(function() {
			var attrCheck = $(this).attr('checked');
			if (($(this).is(':checked')) || (typeof attrCheck !== typeof undefined && attrCheck !== false)){
				countChk += 1;
				opr_pro_std = $(this).parent().parent().closest('tr').find('.opr_pro_std').text();
				opr_pro_list += countChk+'. <b>'+opr_pro_std+' </b></br>';
				arrOprPro.push($(this).val());
			}
		});
		joinih = arrOprPro.join(',');
		$('#jmlDelFPD').html(countChk);
		$('#apaajaDelFPD').html(opr_pro_list);
		$('input[name="ops_id"]').val(joinih);
		$('.delOperationFPD,.closeOperationFPD').removeAttr('disabled');
	});

	$('.actionModalFPD').click(function () {
		$('.actionModalFPD,.closeModalFPD').attr('disabled','disabled');
		var ops_id = $('input[name="ops_id"]').val();
		$('#apaajaDelFPD').html('<center><img style="width:130px; height:auto" src="'+baseurl+'assets/img/gif/loading2.gif"></center>' );
		$.ajax({
			url: baseurl+"FlowProcess/Setup/OperationProcessStd/deleteOPS",
			type: "post",
			dataType: "html",
			data: {ops_id:ops_id},
			success: function (result) {
					$('#modalDelFPD').modal('hide');
					$('body').removeClass('modal-open');
					$('.modal-backdrop').remove();
					$('.res-div').html('<center><img style="width:120px; height:auto" src="'+baseurl+'assets/img/gif/loading13.gif"> </center>');
					setTimeout(function(){ $('.res-div').show().html(result); 
						$(".tblSrcFPD").dataTable({
							info : false,
							paging: true
						});
						$('input').iCheck({
								checkboxClass: 'icheckbox_flat-blue',
								radioClass: 'iradio_flat-blue'
							});
						$('.slc2').select2({
							allowClear:true
						});
						selectCheckFPD();
						segmentSetupOprPro();
					}, 1500);
				}
		})
	});

	$('.btnFrmFPDHome0').click(function () {
		$('.btnSub').hide();
		$('.res-div').html('<center><img style="width:120px; height:auto" src="'+baseurl+'assets/img/gif/loading13.gif"></center>');
		$.ajax({
			url: baseurl+"FlowProcess/Setup/OperationProcessStd/HomeOPS",
			dataType: "html",
			type:"POST",
			success: function (result) {
				$('.res-div').html(result);
				$('input').iCheck({
					checkboxClass: 'icheckbox_flat-blue',
					radioClass: 'iradio_flat-blue'
				});
				$('.tblSrcFPD').DataTable({
						// info : true,
						paging : true,
					});
				selectCheckFPD();
				segmentSetupOprPro();
			}
		})
	});

	$('.saveFormAdd').click(function () {
		var ops = $('input[name="txtOprStd"]').val();
		var ops_d = $('input[name="txtOprStdDesc"]').val();
		var ops_g = $('input[name="txtOprStdGroup"]').val();
		$('.res-div').html('<center><img style="width:120px; height:auto" src="'+baseurl+'assets/img/gif/loading2.gif"><br> SAVING DATA..</center>');

		$.ajax({
			url : baseurl+"FlowProcess/Setup/OperationProcessStd/SaveNewOPS",
			type:"POST",
			data: {
				ops : ops,
				ops_d : ops_d,
				ops_g : ops_g
			},
			success: function (result) {
				$('.res-div').html(result);
				$('input').iCheck({
					checkboxClass: 'icheckbox_flat-blue',
					radioClass: 'iradio_flat-blue'
				});
				$('.tblSrcFPD').DataTable({
						// info : true,
					});
				$('.btnFrmFPDsub01').hide();
				$('#subTitleSub1').text('');
				selectCheckFPD();
				segmentSetupOprPro();
			}
		})
	});

	$('.btnFPD2').click(function () {
		$('input[name="check[]"]').each(function() {
			var attrCheck = $(this).attr('checked');
				if (($(this).is(':checked')) || (typeof attrCheck !== typeof undefined && attrCheck !== false)){
					countChk += 1;
					opr_pro_std = $(this).parent().parent().closest('tr').find('.opr_pro_std').text();
					ops_id = $(this).val();
				}
			});
		$('.res-div').html('<center><img style="width:120px; height:auto" src="'+baseurl+'assets/img/gif/loading13.gif">Loading Form</center>');

			$.ajax({
				url:  baseurl+"FlowProcess/Setup/OperationProcessStd/editOPS",
				type : "POST",
				data : {ops_id:ops_id},
				success: function (result) {
					$('.btnFrmFPDsub01').show();
					$('#subTitleSub1').text('Edit Operation Process Std ('+opr_pro_std+')');
					$('.res-div').html(result);
					$('input').iCheck({
						checkboxClass: 'icheckbox_flat-blue',
						radioClass: 'iradio_flat-blue'
					});
					$('.slc2').select2({
						allowClear:true
					});
					$('.dtPicker').datepicker({
						autoclose: true,
					    todayHighlight: true
					});
				}
			});
	});

	$('.saveFormEdit').click(function () {
		var ops_id = $(this).attr('data-id');
		var ops = $('input[name="txtOprStd"]').val();
		var ops_d = $('input[name="txtOprStdDesc"]').val();
		var ops_g = $('input[name="txtOprStdGroup"]').val();
		var eda = $('input[name="txtEndDateActive"]').val();
		$('.res-div').html('<center><img style="width:120px; height:auto" src="'+baseurl+'assets/img/gif/loading2.gif"><br> SAVING DATA..</center>');

		$.ajax({
			url : baseurl+"FlowProcess/Setup/OperationProcessStd/SaveEditOPS",
			type:"POST",
			data: {
				ops_id : ops_id,
				ops : ops,
				ops_d : ops_d,
				ops_g : ops_g,
				eda : eda
			},
			success: function (result) {
				$('.res-div').html(result);
				$('input').iCheck({
					checkboxClass: 'icheckbox_flat-blue',
					radioClass: 'iradio_flat-blue'
				});
				$('.tblSrcFPD').DataTable({
						info : true,
					});
				$('.btnFrmFPDsub1').hide();
				$('#subTitleSub1').text('');
				selectCheckFPD();
				segmentSetupOprPro();
			}
		})
	});
}

$('.btn-searchKomponen2').click(function(){
	$("#loading").show(); // Tampilkan loadingnya
		  
	  $.ajax({
	        type: "POST", // Method pengiriman data bisa dengan GET atau POST
	        url: baseurl+ "FlowProcess/ComponentSetup/searchgroup", // Isi dengan url/path file php yang dituju
					data: {product_component_code : $("#drw_group").val()}, // data yang akan dikirim ke file proses
	        dataType: "json",
	        beforeSend: function(e) {
	            if(e && e.overrideMimeType) {
	                e.overrideMimeType("application/json;charset=UTF-8");
	            }
	    },
	    success: function(response){ // Ketika proses pengiriman berhasil
	            $("#loading").hide(); // Sembunyikan loadingnya
	            if(response.status == "success"){ // Jika isi dari array status adalah success
	        // $("#product_number").val(response.product_number); 
	        	$("#drw_code").val(response.drw_code); // set textbox dengan id product_description
				$("#drw_description").val(response.drw_description); 
				$("#drw_date").val(response.drw_date); 
				$("#drw_material").val(response.drw_material); 
					if(response.drw_status == Y) {
						$("#statuscomp1").iCheck("check");
					}else{
						$("#statuscomp2").iCheck("check");
					};
					console.log(response.drw_status);
				$("#drw_upper_level_code").val(response.drw_upper_level_code); 
				$("#drw_upper_level_desc").val(response.drw_upper_level_desc); 
					if(response.component_status == 1) {
						$("#Drawing_status1").iCheck("check");
					}else{
						$("#Drawing_status2").iCheck("check");
					};
					console.log(response.component_status);
				$("#component_qty_per_unit").val(response.component_qty_per_unit); 
			}else{ 
	        alert("Data Tidak Ditemukan");
	      }
	    },
	        error: function (xhr) { // Ketika ada error
	      	alert(xhr.responseText);
	        }
	    });	
});

$('.btn-searchKomponen3').click(function(){
	$("#loading").show(); // Tampilkan loadingnya
		  
	  $.ajax({
	        type: "POST", // Method pengiriman data bisa dengan GET atau POST
	        url: baseurl+ "FlowProcess/ComponentSetup/searchgroup3", // Isi dengan url/path file php yang dituju
					data: {product_component_code : $("#drw_group").val(), productId : $("#productId").val()}, // data yang akan dikirim ke file proses
	        dataType: "json",
	        beforeSend: function(e) {
	            if(e && e.overrideMimeType) {
	                e.overrideMimeType("application/json;charset=UTF-8");
	            }
	    },
	    success: function(response){ // Ketika proses pengiriman berhasil
	            $("#loading").hide(); // Sembunyikan loadingnya
	            if(response.status == "success"){ // Jika isi dari array status adalah success
	        // $("#product_number").val(response.product_number); 
	        	$("#drw_code").val(response.drw_code); // set textbox dengan id product_description
				$("#drw_description").val(response.drw_description); 
				$("#drw_date").val(response.drw_date); 
				// $("#rev").val(response.rev); 
				$("#drw_material").val(response.drw_material); 
				$("#weight").val(response.weight); 
					// if(response.drw_status == 1) {
					// 	$("#statuscomp1").iCheck("check");
					// }else{
					// 	$("#statuscomp2").iCheck("check");
					// };
					console.log(response.drw_date);
				// $("#drw_upper_level_code").val(response.drw_upper_level_code); 
				// $("#drw_upper_level_desc").val(response.drw_upper_level_desc); 
				// 	if(response.component_status == 1) {
				// 		$("#Drawing_status1").iCheck("check");
				// 	}else{
				// 		$("#Drawing_status2").iCheck("check");
				// 	};
				// 	console.log(response.component_status);
				// $("#component_qty_per_unit").val(response.component_qty_per_unit); 
			}else{ 
	        alert("Data Tidak Ditemukan");
	      }
	    },
	        error: function (xhr) { // Ketika ada error
	      	alert(xhr.responseText);
	        }
	    });	
});

$('.btn-searchKomponenBbg').click(function(){
	$("#loading").show(); // Tampilkan loadingnya
		  
	  $.ajax({
	        type: "POST", // Method pengiriman data bisa dengan GET atau POST
	        url: baseurl+ "FlowProcess/ComponentSetup/searchgroupbbg", // Isi dengan url/path file php yang dituju
	        data: {product_component_code : $("#drw_group").val()}, // data yang akan dikirim ke file proses
	        dataType: "json",
	        beforeSend: function(e) {
	            if(e && e.overrideMimeType) {
	                e.overrideMimeType("application/json;charset=UTF-8");
	            }
	    },
	    success: function(response){ // Ketika proses pengiriman berhasil
	            $("#loading").hide(); // Sembunyikan loadingnya
	            if(response.status == "success"){ // Jika isi dari array status adalah success
	        // $("#product_number").val(response.product_number); 
	        	$("#drw_code").val(response.drw_code); // set textbox dengan id product_description
				$("#drw_description").val(response.drw_description); 
				$("#drw_date").val(response.drw_date); 
				$("#drw_material").val(response.drw_material); 
					if(response.drw_status == Y) {
						$("#statuscomp1").iCheck("check");
					}else{
						$("#statuscomp2").iCheck("check");
					};
					console.log(response.drw_status);
				$("#drw_upper_level_code").val(response.drw_upper_level_code); 
				$("#drw_upper_level_desc").val(response.drw_upper_level_desc); 
					if(response.component_status == 1) {
						$("#Drawing_status1").iCheck("check");
					}else{
						$("#Drawing_status2").iCheck("check");
					};
					console.log(response.component_status);
				$("#component_qty_per_unit").val(response.component_qty_per_unit); 
			}else{ 
	        alert("Data Tidak Ditemukan");
	      }
	    },
	        error: function (xhr) { // Ketika ada error
	      	alert(xhr.responseText);
	        }
	    });	
});

$('.toupper').keyup(function() {
	this.value = this.value.toUpperCase();
});

$('.btn-searchKomponen').click(function(){
	$("#loading").show();
	  $.ajax({
	        type: "POST",
	        url: baseurl+ "FlowProcess/InputDataGambar/search",
	        data: {product_code : $("#product_code").val()},
	        dataType: "json",
	        beforeSend: function(e) {
	            if(e && e.overrideMimeType) {
	                e.overrideMimeType("application/json;charset=UTF-8");
	            }
	    },
	    success: function(response){ 
	            $("#loading").hide(); 
	            if(response.status == "success"){
	        $("#product_name").val(response.product_name);
	        $("#product_id").val(response.product_id);
			console.log(response.product_name);
			console.log(response.product_id);
	    	}else{ 
	        alert("Data Tidak Ditemukan");
	      }
	    },
	        error: function (xhr) { 
	      	alert(xhr.responseText);
	        }
	    });	
});

$('#btn-submit2').off('click').click(function() {
	var product_number = $('#product_number').val();
	var product_description = $('#product_description').val();
	if($('#status1').iCheck('update')[0].checked) {
		var status_product = 1;
	} else {
		var status_product = 2;
	}
	var dateEndDateActive = $('#txtEndDateSI').val();
	var current_page = $('#current_page').val();
	var max_page = $('#max_page').val();
	// console.log(product_description);
	// console.log(dateEndDateActive);
	if(product_number && product_description && dateEndDateActive) {
		$.ajax({
			type: "POST",
			url: baseurl + "FlowProcess/InputDataGambar/saveDataGambar",
			dataType : "json",
			data: {
				"product_number": product_number,
				"product_description": product_description,
				"status_product": status_product,
				"dateEndDateActive": dateEndDateActive,
				"current_page": current_page,
				"max_page": max_page
			},
			success: function(result) {
				// alert('Data berhasil dikirim');
				$('#header').text('Page ' + (parseInt(current_page) + 1));
				$('#product_number').val('');
				$('#product_description').val('');
				$('#status1').iCheck('uncheck');
				$('#status2').iCheck('uncheck');
				$('#txtEndDateSI').val('');
				$('#current_page').attr('value', parseInt(current_page) + 1);
				if(result == max_page) {
					window.location.href = baseurl + 'FlowProcess/InputDataGambar';
				} else {
					console.log(result);
				}
			},
			error: function(result) {
				alert('error');
				console.log(result);
			}
		});
	} else {
		alert('Harap isi semua form');
	}
});


$('#btn-submit').off('click').click(function() {
	var product_number = $('#product_number').val();
	var product_description = $('#product_description').val();
	if($('#status1').iCheck('update')[0].checked) {
		var status_product = 1;
	} else {
		var status_product = 2;
	}
	var dateEndDateActive = $('#txtEndDateSI').val();
	var current_page = $('#current_page').val();
	var max_page = $('#max_page').val();
	// console.log(product_description);
	// console.log(dateEndDateActive);
	if(product_number && product_description && dateEndDateActive) {
		$.ajax({
			type: "POST",
			url: baseurl + "FlowProcess/InputDataGambar/saveDataGambar",
			dataType : "json",
			data: {
				"product_number": product_number,
				"product_description": product_description,
				"status_product": status_product,
				"dateEndDateActive": dateEndDateActive,
				"current_page": current_page,
				"max_page": max_page
			},
			success: function(result) {
				// alert('Data berhasil dikirim');
				$('#header').text('Page ' + (parseInt(current_page) + 1));
				$('#product_number').val('');
				$('#product_description').val('');
				$('#status1').iCheck('uncheck');
				$('#status2').iCheck('uncheck');
				$('#txtEndDateSI').val('');
				$('#current_page').attr('value', parseInt(current_page) + 1);
				if(result == max_page) {
					window.location.href = baseurl + 'FlowProcess/InputDataGambar';
				} else {
					console.log(result);
				}
			},
			error: function(result) {
				alert('error');
				console.log(result);
			}
		});
	} else {
		alert('Harap isi semua form');
	}
});


$('#btn-submit3').off('click').click(function() {
	// var product_number = $('#product_number').val();
	// var product_description = $('#product_description').val();
	// if($('#status1').iCheck('update').checked) {
	// 	var status_product = 1;
	// } else {
	// 	var status_product = 2;
	// }
	// var dateEndDateActive = $('#txtEndDateSI').val();
	// var current_page = $('#current_page').val();
	// var max_page = $('#max_page').val();
	// console.log(product_description);
	// console.log(dateEndDateActive);
	var product_id = $('#product_ID').val();
	var drw_group = $('#drawing_group').val();
	var drw_code = $('#selectDrawingCode2').val();
	var drw_description = $('#drawing_description').val();
	var drw_date=$('#drawing_date').val();
	var drw_material=$('#drawing_material').val();
	if($('#Drawing_status1').iCheck('update')[0].checked) {
		var drw_status = 1;
	} else {
		var drw_status = 2;
	}
	var drw_upper_level_code=$('#drawing_upper_code').val();
	var drw_upper_level_desc=$('#drawing_upper_description').val();
	if($('#statuscomp1').iCheck('update')[0].checked) {
		var component_status = 'Y';
	} else {
		var component_status = 'N';
	}
	var component_qty=$('#component_qty').val();
	var old_drw_code=$('#old_drawing_code').val();
	var changing_ref_doc=$('#ref_document').val();
	var changing_ref_expl=$('#explanation').val();
	var changing_due_date=$('#duedate').val();
	var weight=$('#weight').val();
	var rev=$('#rev').val();
	var gambar_kerja=$('#rev').val();
	var current_page = $('#current_page').val();
	var max_page = $('#max_page').val();
	console.log(product_id);
	console.log(drw_group);
	console.log(drw_code);
	console.log(drw_description);
	console.log(drw_date);
	console.log(drw_material);
	console.log(drw_status);
	console.log(drw_upper_level_code);
	console.log(current_page);
	console.log(max_page);
	console.log(drw_material);
	console.log(component_qty);
	console.log(weight);
	console.log(rev);
	console.log(gambar_kerja);

	if(product_id && drw_group && drw_code && drw_description && drw_date && drw_material && drw_status 
		&& drw_upper_level_code && drw_upper_level_desc && component_status && component_qty) {
		$.ajax({
			type: "POST",
			url: baseurl + "FlowProcess/InputDataGambar/saveDataGambar2",
			dataType : "json",
			data: {
				"product_id": product_id,
				"drw_group": drw_group,
				"drw_code": drw_code,
				"drw_description": drw_material,
				"drw_date": drw_date,
				"drw_material": drw_material,
				"drw_status": drw_status,
				"drw_upper_level_code": drw_upper_level_code,
				"drw_upper_level_desc": drw_upper_level_desc,
				"component_status": component_status,
				"component_qty": component_qty,
				"old_drw_code": old_drw_code,
				"changing_ref_doc": changing_ref_doc,
				"changing_ref_expl": changing_ref_expl,
				"changing_due_date": changing_due_date,
				"weight" : weight,
				"rev": rev,
				"current_page": current_page ,
				"max_page": max_page
			},
			success: function(result) {
				// alert('Data berhasil dikirim');
				$('#header').text('Page ' + (parseInt(current_page) + 1));
				$('#product_ID').val(product_id);
				$('#drawing_group').val('');
				$('#drawing_code').val('');
				$('#drawing_description').val('');
				$('#drawing_date').val('');
				$('#drawing_material').val('');
				$('#Drawing_status1').iCheck('uncheck');
				$('#Drawing_status2').iCheck('uncheck');
				$('#drawing_upper_code').val('');
				$('#drawing_upper_description').val('');
				$('#statuscomp1').iCheck('uncheck');
				$('#statuscomp2').iCheck('uncheck');
				$('#component_qty').val('');
				$('#old_drawing_code').val('');
				$('#ref_document').val('');
				$('#explanation').val('');
				$('#duedate').val('');
				$('#current_page').attr('value', parseInt(current_page) + 1);
				if(result == max_page) {
					window.location.href = baseurl + 'FlowProcess/InputDataGambar';
				} else {
					console.log(result);
				}
			},
			error: function(result) {
				alert('error');
				console.log(result);
				// console.log(data);
			}
		});
	} else {
		alert('Harap isi semua form');
	}
});


$(document).ready(function(){
$('#selectProduct').select2({
	placeholder: "Pilih product",
	allowClear: true,
	tags: true,
	minimumInputLength: 0,
	ajax: {		
				url: baseurl+"FlowProcess/InputDataGambar/selectproduct",
				dataType: 'json',
				type: "POST",
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
							return { id:obj.product_id, text:obj.product_number+' - '+obj.product_description};
						})
					};
				}
		}
	});
});

$('.dtPicker').datepicker({
	autoclose: true,
	todayHighlight: true});

$(document).ready(function(){
	$("#btn-searchcomp").click(function(){
		// $("#loading").show(); // Tampilkan loadingnya
		$("#searchcomp").modal();
		// var rowID = $('#modalComponent input[name="rowID"]').val();
    // var detail_info = '';
    $.ajax({
        async: true,
				dataType:'json',
				type: "POST", // Method pengiriman data bisa dengan GET atau POST
	      url: baseurl+ "FlowProcess/ComponentSetup/searchgroupbbg", // Isi dengan url/path file php yang dituju
	      data: {product_component_code : $("#drw_group").val(),
				productId : $("#productId").val()}, // data yang akan dikirim ke file proses}, // data yang akan dikirim ke file proses
        success: function() {

                // detail_info = result[0]['information'];
                // $('#modalComponent div.loadingArea').empty();
                // $('#tbMemoLine tbody tr[row-id="' + rowID + '"] input[name="product_component_id[]"]').val(comID);
                // $('#tbMemoLine tbody tr[row-id="' + rowID + '"] input[name="history_id[]"]').val(history_id);
                // $('#tbMemoLine tbody tr[row-id="' + rowID + '"] input[name="component[]"]').val(comName);
                // $('#tbMemoLine tbody tr[row-id="' + rowID + '"] input[name="component_old[]"]').val(codeOld);
                // $('#tbMemoLine tbody tr[row-id="' + rowID + '"] input[name="component_new[]"]').val(component_new);
                // $('#tbMemoLine tbody tr[row-id="' + rowID + '"] input[name="revision_number[]"]').val(revision);
                // $('#tbMemoLine tbody tr[row-id="' + rowID + '"] input[name="change_detail[]"]').val(detail_info);
                // $('#tbMemoLine tbody tr[row-id="' + rowID + '"] input[name="change_detail[]"]').attr('disabled', false);
                // $('#tbMemoLine tbody tr[row-id="' + rowID + '"] select[name="change_type[]"]').attr('disabled', false);
                // $('#tbMemoLine tbody tr[row-id="' + rowID + '"] select[name="status_design[]"]').attr('disabled', false);
                // $('#tbMemoLine tbody tr[row-id="' + rowID + '"] input[name="status_component[]"]').attr('disabled', false);
                // console.log(product_component_code);

            },
	        error: function (xhr) { // Ketika ada error
	      	alert(xhr.responseText);
	        }
	    });	
		
		});
	});

	$(document).ready(function(){
		$('#selectDrawingCode').select2({
			placeholder: "Pilih drawing code",
			allowClear: true,
			// tags: true,
			minimumInputLength: 3,
			ajax: {		
						url: baseurl+"FlowProcess/ComponentSetup/selectdrwcode",
						dataType: 'json',
						type: "POST",
						data:  function (params) {
							var queryParameters = {
								term: params.term , productId :$("#productId").val()     
							}
							console.log(params.term)
							console.log(productId)
							return queryParameters; 
						},
						processResults: function (data) {
							console.log(data);
							return {
								results: $.map(data, function(obj) {
									return { id:obj.drw_code, text:obj.drw_code+' - '+obj.drw_description+'  Rev.'+obj.rev};
								})
							};
						}
				}
			});
		});
	
		$(document).ready(function(){
			var productId = $("#produk_id").val();  
			$('#selectDrawingCode2').select2({
				placeholder: "Pilih drawing code",
				allowClear: true,
				// tags: true,
				minimumInputLength: 3,
				ajax: {		
							url: baseurl+"FlowProcess/InputDataGambar/selectdrwcode",
							dataType: 'json',
							type: "POST",
							data:  function (params) {
								var queryParameters = {
									term: params.term , productId : productId     
								}
								console.log(params.term)
								console.log(productId)
								return queryParameters; 
							},
							processResults: function (data) {
								console.log(data);
								return {
									results: $.map(data, function(obj) {
										return { id:obj.drw_code, text:obj.drw_code+' - '+obj.drw_description+'  Rev.'+obj.rev};
									})
								};
							}
					}
				});
		});


	$(document).ready(function(){
	$('#selectDrawingCode').change(function(){
			var drwcode = $(this).val();  
			console.log(drwcode);
			// $("#searchDeptCode").select2('val', null);
			// $("#loading").show();
	  	$.ajax({
	      type: "POST",
	    	url: baseurl+ "FlowProcess/ComponentSetup/searchdetail",
				data: {drwcode :drwcode , productId :$("#productId").val()
				},
	      dataType: "json",
	      beforeSend: function(e) {
					$("#drw_date").val('');
					$("#product_id").val('');
					$("#drw_description").val('');
					$("#drw_group").val('');
					$("#drw_material").val('');
					$("#rev").val('');
					$("#weight").val('');
					$("#changing_ref_doc").val('');
					$("#old_drw_code").val('')
					$("#changing_ref_expl").val('');	
					$('input').parent().removeClass('checked');
					$('input').removeAttr('checked');
	        if(e && e.overrideMimeType) {
	          e.overrideMimeType("application/json;charset=UTF-8");
					}
				},
				success: function(response){ 
					// $("#loading").hide(); 
						if(response.status == "success"){
						$("#drw_date").val(response.drw_date);
						$("#product_id").val(response.product_id);
						$("#drw_description").val(response.drw_description);
						$("#drw_group").val(response.drw_group);
						$("#drw_material").val(response.drw_material);
						$("#rev").val(response.rev);
						$("#weight").val(response.weight);
						$("#changing_ref_doc").val(response.changing_ref_doc);
						$("#old_drw_code").val(response.drw_code)
						$("#changing_ref_expl").val(response.changing_ref_expl);
							if(response.statuscomponent == 'Y') {
								$("#statuscomp1").iCheck("check");
							}else{
								$("#statuscomp2").iCheck("check");
							};
						$("#component_qty_per_unit").val(response.qty);
						console.log(response);
						// console.log(response.product_id);
						}else if(response.status == "failed"){ 
							$("#drw_date").val('');
							$("#product_id").val('');
							$("#drw_description").val('');
							$("#drw_group").val('');
							$("#drw_material").val('');
							$("#rev").val('');
							$("#weight").val('');
							$("#changing_ref_doc").val('');
							$("#old_drw_code").val('')
							$("#changing_ref_expl").val('');	
							$('input').parent().removeClass('checked');
							$('input').removeAttr('checked');

							Swal.fire({
								type: 'warning',
								width: 700,
								heightAuto: false,
								title: 'Komponen sudah ada!',
								// html: '<h4>Komponen sudah ada!</h4>',
							})
						}else{
							Swal.fire({
								type: 'error',
								width: 700,
								heightAuto: true,
								title: 'Data Tidak Ditemukan',
								// html: '<h4>Data Tidak Ditemukan</h4>',
							})
							$("#drw_date").val('');
							$("#product_id").val('');
							$("#drw_description").val('');
							$("#drw_group").val('');
							$("#drw_material").val('');
							$("#rev").val('');
							$("#weight").val('');
							$("#changing_ref_doc").val('');
							$("#old_drw_code").val('')
							$("#changing_ref_expl").val('');	
							$('input').parent().removeClass('checked');
							$('input').removeAttr('checked');
						}
				},
				error: function (xhr) { 
				alert(xhr.responseText);
				}
	    });	
		});
	});

		$('#selectDrawingCode2').change(function(){
			var drwcode = $(this).val();  
			console.log(drwcode);
			// $("#searchDeptCode").select2('val', null);
			// $("#loading").show();
	  	$.ajax({
	      type: "POST",
	    	url: baseurl+ "FlowProcess/InputDataGambar/searchdetail",
				data: {drwcode :drwcode , productId :$("#produk_id").val()
				},
	      dataType: "json",
	      beforeSend: function(e) {
	        if(e && e.overrideMimeType) {
	          e.overrideMimeType("application/json;charset=UTF-8");
					}
				},
				success: function(response){ 
					// $("#loading").hide(); 
						if(response.status == "success"){
						$("#drawing_date").val(response.drw_date);
						$("#drawing_group").val(response.drw_group);
						$("#drawing_code").val(response.drw_code);
						$("#drawing_description").val(response.drw_description);
						$("#drw_group").val(response.drw_group);
						$("#drawing_material").val(response.drw_material);
						$("#rev").val(response.rev);
						$("#weight").val(response.weight);
						$("#ref_document").val(response.changing_ref_doc);
						$("#old_drw_code").val(response.drw_code);
						$("#explanation").val(response.changing_ref_expl);
						if(response.statuscomp == 'Y') {
							$("#statuscomp1").iCheck("check");
						}else{
							$("#statuscomp2").iCheck("check");
						};
						$("#component_qty").val(response.qty);
						console.log(response);
						// console.log(response.product_id);
						}else{ 
							alert("Data Tidak Ditemukan");
						}
				},
				error: function (xhr) { 
				alert(xhr.responseText);
				}
	    });	
		});

	$(document).ready(function(){
			$('#selectProductCode').select2({
				placeholder: "Pilih drawing code",
				allowClear: true,
				// tags: true,
				minimumInputLength: 0,
				ajax: {		
							url: baseurl+"FlowProcess/ProductSetup/selectprdcode",
							dataType: 'json',
							type: "POST",
							data:  function (params) {
								var queryParameters = {
									term: params.term  
								}
								// console.log(params.term)
								// console.log(productId)
								return queryParameters; 
							},
							processResults: function (data) {
								console.log(data);
								return {
									results: $.map(data, function(obj) {
										return { id:obj.product_id, text:obj.product_code+' - '+obj.product_name};
									})
								};
							}
					}
				});
			});

	$('#selectProductCode').change(function(){
				var prdid = $(this).val();  
				console.log(prdid);
				$.ajax({
					type: "POST",
					url: baseurl+ "FlowProcess/ProductSetup/searchdetail",
					data: {prdid :prdid},
					dataType: "json",
					beforeSend: function(e) {
						if(e && e.overrideMimeType) {
							e.overrideMimeType("application/json;charset=UTF-8");
						}
					},
					success: function(response){ 
						// $("#loading").hide(); 
							if(response.status == "success"){
							$("#product_name").val(response.product_name);
							$("#product_code").val(response.product_code);
							console.log(response);
							}else{ 
								alert("Data Tidak Ditemukan");
							}
					},
					error: function (xhr) { 
					alert(xhr.responseText);
					}
				});	
			});
// $(document).ready(function(){
// 	$("#selectProduct").select2({
// 		allowClear: true,
// 		placeholder: "Product",
// 		minimumInputLength: 0,
// 		ajax: {		
// 			url:baseurl+"FlowProcess/InputDataGambar/selectproduct",
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
// 				// $('#kodeorg').val(data.ORGANIZATION_CODE);
// 				return {
// 					results: $.map(data, function(obj) {
// 						return {id:obj.product_id, text:'('+obj.product_number+')'+obj.product_description};
// 					})
// 				};
// 			}
// 		}
// 	});
// });

function readURL(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function(e) {
      $('#blah').attr('src', e.target.result);
    }
		reader.readAsDataURL(input.files[0]);
		$('#blah').attr('style', false);

  }
}

$("#imgInp").change(function() {
  readURL(this);
});

// $("blah").click(function(){
// 	$("img").attr("width","500");
// });