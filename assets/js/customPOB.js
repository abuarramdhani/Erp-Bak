$(document).ready(function(){
    $(".nav-tabs a").click(function(){
        $(this).tab('show');
    });

    val = $('#hambatan').val();
	if(val=='non-mesin'){
		$('#slc_kategori').hide();
		$('#slc_kategori').find('select').val('');
	}else{
		$('#slc_kategori').show();
	}

	$('#typeCetakan').on('select2:select', function(){
		$('#slc_updtInduk').select2('val', '');
		$('#slc_updtCabang').select2('val', '');
		type = $(this).val();
		kategori =  $('#kategori').val();
		$('#slc_updtInduk').select2({
			allowClear: true,
			ajax:{
				type:'POST',
				dataType: 'json',
				data:function (params) {
					var queryParameters = {
						term: params.term,
						type: type,
						kategori : kategori
					}
					return queryParameters;
				},
				url:baseurl+'ManufacturingOperation/ProductionObstacles/ajax/select2CetakInduk',
				processResults:function(data){
					return {
							results: $.map(data, function(obj) {
								return { id:obj.id, text:obj.induk};
							})
						}
					}
		
				}
			});
	})

	$('#slc_updtInduk').change(function(){
		$('#slc_updtCabang').select2('val', '');
		induk = $(this).val();
		$('#slc_updtCabang').select2({
				allowClear: true,
				ajax:{
					type:'POST',
					dataType: 'json',
					data:function (params) {
						var queryParameters = {
							term: params.term,
							induk: induk
						}
						return queryParameters;
					},
					url:baseurl+'ManufacturingOperation/ProductionObstacles/ajax/select2Cabang',
					processResults:function(data){
						return {
								results: $.map(data, function(obj) {
									return { id:obj.cabang, text:obj.cabang};
								})
							}
						}
			
					}
				});


	})

	tipe = $('#typeCetakan').val();
	kategori =  $('#kategori').val();
	$('#slc_updtInduk').select2({
		allowClear: true,
		ajax:{
			type:'POST',
			dataType: 'json',
			data:function (params) {
				var queryParameters = {
					term: params.term,
					type: tipe,
					kategori : kategori
				}
				return queryParameters;
			},
			url:baseurl+'ManufacturingOperation/ProductionObstacles/ajax/select2CetakInduk',
			processResults:function(data){
				return {
						results: $.map(data, function(obj) {
							return { id:obj.id, text:obj.induk};
						})
					}
				}
	
			}
		});


	induk = $('#slc_updtInduk').val();
	$('#slc_updtCabang').select2({
			allowClear: true,
			ajax:{
				type:'POST',
				dataType: 'json',
				data:function (params) {
					var queryParameters = {
						term: params.term,
						induk: induk
					}
					return queryParameters;
				},
				url:baseurl+'ManufacturingOperation/ProductionObstacles/ajax/select2Cabang',
				processResults:function(data){
					return {
							results: $.map(data, function(obj) {
								return { id:obj.cabang, text:obj.cabang};
							})
						}
					}
		
				}
			});


    $('#typeCetakan').on("select2:select", function(){
    	$('#slc_indukUmumLogam').select2('val','');
    	$('#slc_cabangUmumLogam').select2('val','');
    	type = $(this).val();
    	kategori = $('#kategori').val();
    	$('#slc_indukUmumLogam').select2({
		allowClear: true,
		ajax:{
			type:'POST',
			dataType: 'json',
			data:function (params) {
				var queryParameters = {
					term: params.term,
					type: type,
					kategori : kategori
				}
				return queryParameters;
			},
			url:baseurl+'ManufacturingOperation/ProductionObstacles/ajax/select2CetakInduk',
			processResults:function(data){
				return {
						results: $.map(data, function(obj) {
							return { id:obj.id, text:obj.induk};
						})
					}
				}
	
			}
		});
    });

    $('#slc_indukUmumLogam').on('select2:select', function(){
    	$('#slc_cabangUmumLogam').select2('val','');
    	// $('#slc_cabangUmumLogam').prop('required', true);
    	induk = $(this).val();
    	$('#slc_cabangUmumLogam').select2({
			allowClear: true,
			ajax:{
				type:'POST',
				dataType: 'json',
				data:function (params) {
					var queryParameters = {
						term: params.term,
						induk: induk
					}
					return queryParameters;
				},
				url:baseurl+'ManufacturingOperation/ProductionObstacles/ajax/select2Cabang',
				processResults:function(data){
					return {
							results: $.map(data, function(obj) {
								return { id:obj.cabang, text:obj.cabang};
							})
						}
					}
		
				}
			});
    	})


	$('#slcIndukCabang').select2({
			ajax:{
				type:'POST',
				dataType:'json',
				data:function(params){
					var queryParameters={
						term:params.term
					}
					return queryParameters;
				},
				url:baseurl+'ManufacturingOperation/ProductionObstacles/ajax/select2Induk',
				processResults:function(data){
					return {
							results: $.map(data, function(obj) {
								return { id:obj.id, text:obj.induk};
							})
						}
					}
		
			}
		});

    
});

$('#masterIndukLogam').DataTable({
    dom: 'Bfrtip',
    buttons: ['excel', 'pdf']
});

$('#masterIndukInti').DataTable({
    dom: 'Bfrtip',
    buttons: ['excel', 'pdf']
});

$('#masterCabangLogam').DataTable({
    dom: 'Bfrtip',
    buttons: ['excel', 'pdf']
});

$('#masterCabangInti').DataTable({
    dom: 'Bfrtip',
    buttons: ['excel', 'pdf']
});

$('#HamMesinUmum').DataTable({
	dom: 'ftip'
});

$('#addNewInduk').click(function(){
	$('#removeNewInduk').show();
	$(this).parents('div.input-group').clone(true).find("input:text").val("").end().appendTo($("#input-containerLogam"));
	
})

$('#removeNewInduk').click(function(){
	$(this).parents('div.input-group').remove();
	inputGroup = $('div#containerLogam').length;
	// console.log(inputGroup);
	if(inputGroup==1){
		$('#removeNewInduk').hide();
	}
})

$('#addNewCabang').click(function(){
	$('#removeNewCabang').show();
	$(this).parents('div.input-group').clone(true).find("input:text").val("").end().appendTo($("#input-containerLogam"));
	
})

$('#removeNewCabang').click(function(){
	$(this).parents('div.input-group').remove();
	inputGroup = $('div#containerLogam').length;
	// console.log(inputGroup);
	if(inputGroup==1){
		$('#removeNewCabang').hide();
	}
})

$('#addNewInduk1').click(function(){
	$('#removeNewInduk1').show();
	$(this).parents('div.input-group').clone(true).find("input:text").val("").end().appendTo($("#input-containerInti"));
	
})

$('#removeNewInduk1').click(function(){
	$(this).parents('div.input-group').remove();
	inputGroup = $('div#containerInti').length;
	// console.log(inputGroup);
	if(inputGroup==1){
		$('#removeNewInduk1').hide();
	}
})

$('#addNewCabang1').click(function(){
	$('#removeNewCabang1').show();
	$(this).parents('div.input-group').clone(true).find("input:text").val("").end().appendTo($("#input-containerInti"));
	
})

$('#removeNewCabang1').click(function(){
	$(this).parents('div.input-group').remove();
	inputGroup = $('div#containerInti').length;
	// console.log(inputGroup);
	if(inputGroup==1){
		$('#removeNewCabang1').hide();
	}
})

function deleteInduk(th,id,ind) {
	confirmdel = confirm('Apakah anda yakin akan menghapus induk '+ind+'?');
	if (confirmdel) {
		$('.deleteInduk').prop('disabled',true);
		$(th).find('i.fa-trash').addClass('fa-spinner fa-spin').removeClass('fa-trash');
		$.ajax({
			type: 'POST',
			data: {
				id:id
			},
			url:baseurl+'ManufacturingOperation/ProductionObstacles/ajax/hapus',
			success:function(results){
				$('.deleteInduk').prop('disabled',false);
				$(th).parents('table').DataTable().destroy();
				$(th).closest('tr').remove();
				$('#masterIndukLogam').DataTable({
					dom: 'Bfrtip',
    				buttons: ['excel', 'pdf']
				});

			}
		})
	}
}

function deleteCabang(th,id,ind) {
	confirmdel = confirm('Apakah anda yakin akan menghapus cabang '+ind+'?');
	if (confirmdel) {
		$('.deleteCabang').prop('disabled',true);
		$(th).find('i.fa-trash').addClass('fa-spinner fa-spin').removeClass('fa-trash');
		$.ajax({
			type: 'POST',
			data: {
				id:id
			},
			url:baseurl+'ManufacturingOperation/ProductionObstacles/ajax/hapusCabang',
			success:function(results){
				$('.deleteCabang').prop('disabled',false);
				$(th).parents('table').DataTable().destroy();
				$(th).closest('tr').remove();
				$('#masterCabangLogam').DataTable({
					dom: 'Bfrtip',
    				buttons: ['excel', 'pdf']
				});

			}
		})
	}
}

function deleteHambatan(th,id){
	red = $(th).parents('tr').css('background-color','#E94B3C');
	if (red) {
		setTimeout(function(){
			confirmdel = confirm('Apakah anda yakin akan menghapus item tersebut?');
			if (confirmdel) {
				$('.delHam').prop('disabled',true);
				$(th).find('i.fa-trash').addClass('fa-spinner fa-spin').removeClass('fa-trash');
				$.ajax({
					type: 'POST',
					data: {
						id:id
					},
					url:baseurl+'ManufacturingOperation/ProductionObstacles/ajax/deleteHambatan',
					success:function(results){
						$('.delHam').prop('disabled',false);
						$(th).parents('table').DataTable().destroy();
						$(th).closest('tr').remove();
						$('#HamMesinUmum').DataTable({
							dom: 'Bfrtip',
    						buttons: ['excel', 'pdf']
						});
		
					}
				})
			}else{
				$(th).parents('tr').css('background-color','');
			}
		},1000);
	}
}

function deleteHambatanNon(th,id){
	var red = $(th).parents('tr').css('background-color','#E94B3C');
	// var confirmdel;
	if (red) {
		setTimeout(function(){ 
			confirmdel = confirm('Apakah anda yakin akan menghapus item tersebut?'); 
			if (confirmdel) {
				$('.delHam').prop('disabled',true);
				$(th).find('i.fa-trash').addClass('fa-spinner fa-spin').removeClass('fa-trash');
				$.ajax({
					type: 'POST',
					data: {
						id:id
					},
					url:baseurl+'ManufacturingOperation/ProductionObstacles/ajax/deleteHambatanNon',
					success:function(results){
						$('.delHam').prop('disabled',false);
						$(th).parents('table').DataTable().destroy();
						$(th).closest('tr').remove();
						$('#HamNonMesin').DataTable({
							dom: 'Bfrtip',
   	 					buttons: ['excel', 'pdf']
						});
		
					}
				})
			}else{
				$(th).parents('tr').css('background-color','');
			}
		}, 1000);
	}
	
}


$('#hambatan').change(function(){
	val = $(this).val();
	// alert(val);
	if(val=='non-mesin'){
		$('#slc_kategori').hide();
		$('#slc_kategori').find('select').val('');
	}
	else{
		$('#slc_kategori').show();;
	}
})


// function editInduk(th){
// 	$(th).parents('tr').find('div.updtInd').show();
// 	$(th).parents('tr').find('p.ind').hide();
// 	$(th).parents('tr').find('input[name="updt_indk"]').focus();
// 	$(th).parents('td').find('button.saveUpdtInduk').show();
// 	$(th).hide();
// }

// function editCabang(th){
// 	$(th).parents('tr').find('div.updtCbg').show();
// 	$(th).parents('tr').find('div.updtCbgInd').show();
// 	$(th).parents('tr').find('p.cbg').hide();
// 	$(th).parents('tr').find('p.cbg_ind').hide();
// 	$(th).parents('tr').find('input[name="updt_Cbg"]').focus();
// 	$(th).parents('td').find('button.saveUpdtCabang').show();
// 	$(th).hide();
// }

// $("#masterIndukLogam").on("click", ".cancelUpdt", function(){
// 	$(this).parents('tr').find('div.updtInd').hide();
// 	$(this).parents('tr').find('p.ind').show();
// 	$(this).parents('tr').find('button.saveUpdtInduk').hide();
// 	val = $(this).parents('tr').find('p.ind').html();
// 	$(this).parents('tr').find('input[name="updt_indk"]').val(val);
// 	$(this).parents('tr').find('button.editInduk').show();
// });

// $("#masterIndukInti").on("click", ".cancelUpdt", function(){
// 	$(this).parents('tr').find('div.updtInd').hide();
// 	$(this).parents('tr').find('p.ind').show();
// 	$(this).parents('tr').find('button.saveUpdtInduk').hide();
// 	val = $(this).parents('tr').find('p.ind').html();
// 	$(this).parents('tr').find('input[name="updt_indk"]').val(val);
// 	$(this).parents('tr').find('button.editInduk').show();
// });

// $("#masterCabangLogam").on("click", ".cancelUpdt", function(){
// 	$(this).parents('tr').find('div.updtCbg').hide();
// 	$(this).parents('tr').find('p.cbg').show();
// 	$(this).parents('tr').find('button.saveUpdtCabang').hide();
// 	val = $(this).parents('tr').find('p.cbg').html();
// 	$(this).parents('tr').find('input[name="updt_Cbg"]').val(val);
// 	$(this).parents('tr').find('button.editCabang').show();
// });


// $("#masterCabangInti").on("click", ".cancelUpdt", function(){
// 	$(this).parents('tr').find('div.updtCbg').hide();
// 	$(this).parents('tr').find('p.cbg').show();
// 	$(this).parents('tr').find('button.saveUpdtCabang').hide();
// 	val = $(this).parents('tr').find('p.cbg').html();
// 	$(this).parents('tr').find('input[name="updt_Cbg"]').val(val);
// 	$(this).parents('tr').find('button.editCabang').show();
// });

function saveUpdateInduk(th,id,e){
	if(e.keyCode===13||e=='32'){
		val = $(th).parents('tr').find('input[name="updt_indk"]').val();
		$(th).parents('tr').find('button.saveUpdtInduk').prop('disabled',true);
		$(th).parents('tr').find('button.saveUpdtInduk').find('i.fa-save').addClass('fa-spinner fa-spin').removeClass('fa-save');
		$.ajax({
			type: 'POST',
			data: {
				id:id,
				val:val
			},
			url: baseurl+'ManufacturingOperation/ProductionObstacles/ajax/UpdateInduk',
			success: function(results){
				$(th).parents('tr').find('p.ind').html(val);
				$(th).parents('tr').find('input[name="updt_indk"]').val(val);
				$(th).parents('tr').find('p.ind').show();
				$(th).parents('tr').find('div.updtInd').hide();
				$(th).parents('tr').find('button.saveUpdtInduk').find('i.fa-spinner').addClass('fa-save').removeClass('fa-spin fa-spinner');
				$(th).parents('tr').find('button.saveUpdtInduk').hide();
				$(th).parents('tr').find('button.editInduk').show();
			},
			error: function(XMLHttpRequest, textStatus, errorThrown){
            	$.toaster(textStatus+' | '+errorThrown, name, 'danger');
            	window.location.reload();
        	}
		})
	}
}

function saveUpdateCabang(th,id,e){
	if(e.keyCode===13||e=='32'){
		val = $(th).parents('tr').find('input[name="updt_Cbg"]').val();
		$(th).parents('tr').find('button.saveUpdtCabang').prop('disabled',true);
		$(th).parents('tr').find('button.saveUpdtCabang').find('i.fa-save').addClass('fa-spinner fa-spin').removeClass('fa-save');
		$.ajax({
			type: 'POST',
			data: {
				id:id,
				val:val
			},
			url: baseurl+'ManufacturingOperation/ProductionObstacles/ajax/UpdateCabang',
			success: function(results){
				$(th).parents('tr').find('p.cbg').html(val);
				$(th).parents('tr').find('input[name="updt_Cbg"]').val(val);
				$(th).parents('tr').find('p.cbg').show();
				$(th).parents('tr').find('div.updtCbg').hide();
				$(th).parents('tr').find('button.saveUpdtCabang').find('i.fa-spinner').addClass('fa-save').removeClass('fa-spin fa-spinner');
				$(th).parents('tr').find('button.saveUpdtCabang').hide();
				$(th).parents('tr').find('button.editCabang').show();
			},
			error: function(XMLHttpRequest, textStatus, errorThrown){
            	$.toaster(textStatus+' | '+errorThrown, name, 'danger');
            	window.location.reload();
        	}
		})
	}
}

function saveUpdateIndukCabang(th,id){
	ind = $(th).val();
	$.ajax({
		type: 'POST',
		data: {
			ind:ind,
			id:id
		},
		url:baseurl+'ManufacturingOperation/ProductionObstacles/ajax/updateindukCabang',
		success:function(results){
			alert('success');
		}
	})
}

$('#btn-searchHam').click(function(){
	tgl1= $('#tgl_hambatan1').val();
	tgl2= $('#tgl_hambatan2').val();
	type= $('#type').val();
	kategori = $('#kategoriHambatan').val();

	if(type==''){
		$('#type').select2('open');
	}else{
		$(this).find('i.fa').removeClass('fa-search').addClass('fa-spinner fa-spin');
		$.ajax({
			type:'POST',
			data:{
				tgl1:tgl1,
				tgl2:tgl2,
				type:type,
				kategori:kategori
			},
			url:baseurl+'ManufacturingOperation/ProductionObstacles/ajax/searchHambatan',
			success:function(results){
				if (results!=='') {
					$('#btn-searchHam').find('i.fa').removeClass('fa-spinner fa-spin').addClass('fa-search');
					$('#tableHam').hide()
					$('#tableSearchHam').find('tbody').html(results);
					$('#tableSearchHam').show();
					$('#exportHamb').show();
					var str = type;
					str = str.toLowerCase().replace(/\b[a-z]/g, function(letter) {
					    return letter.toUpperCase();
					});
					$('span#headCetakan').html(str);
				}else{
					$('#btn-searchHam').find('i.fa').removeClass('fa-spinner fa-spin').addClass('fa-search');
					alert('data not found');
	
				}
			}
	
		});
		
	}
});
$('#btn-searchHamNon').click(function(){
	tgl1= $('#tgl_hambatan1').val();
	tgl2= $('#tgl_hambatan2').val();
	type= $('#type').val();
	// kategori = $('#kategoriHambatan').val();

	if(type==''){
		$('#type').select2('open');
	}else{
		$(this).find('i.fa').removeClass('fa-search').addClass('fa-spinner fa-spin');
		$.ajax({
			type:'POST',
			data:{
				tgl1:tgl1,
				tgl2:tgl2,
				type:type
			},
			url:baseurl+'ManufacturingOperation/ProductionObstacles/ajax/searchHambatanNon',
			success:function(results){
				if (results!=='') {
					$('#btn-searchHamNon').find('i.fa').removeClass('fa-spinner fa-spin').addClass('fa-search');
					$('#tableHam').hide()
					$('#tableSearchHam').find('tbody').html(results);
					$('#tableSearchHam').show();
					$('#exportHamb').show();
					var str = type;
					str = str.toLowerCase().replace(/\b[a-z]/g, function(letter) {
					    return letter.toUpperCase();
					});
					$('span#headCetakan').html(str);
				}else{
					$('#btn-searchHamNon').find('i.fa').removeClass('fa-spinner fa-spin').addClass('fa-search');
					alert('data not found');
	
				}
			}
	
		});
		
	}
})


$('#container-collapse').find('input').change(function(){
	$('#exportHamb').hide();
})

$('#container-collapse').find('select').change(function(){
	$('#exportHamb').hide();
})

// $('#exportHamb').click(function(){
// 	tgl1= $('#tgl_hambatan1').val();
// 	tgl2= $('#tgl_hambatan2').val();
// 	type= $('#type').val();
// 	$(this).find('i.fa').removeClass('fa-search').addClass('fa-spinner fa-spin');
// 	$.ajax({
// 		type:'POST',
// 		data:{
// 			tgl1:tgl1,
// 			tgl2:tgl2,
// 			type:type
// 		},
// 		url:baseurl+'ManufacturingOperation/ProductionObstacles/ajax/exportHamMesin',
// 		success:function(results){
// 			if (results!=='') {
// 				$('#exportHamb').find('i.fa').removeClass('fa-spinner fa-spin').addClass('fa-search');
// 				$('#tableHam').hide()
// 				$('#tableSearchHam').find('tbody').html(results);
// 				$('#tableSearchHam').show();
// 			}else{
// 				$('#exportHamb').find('i.fa').removeClass('fa-spinner fa-spin').addClass('fa-search');
// 				alert('data not found');

// 			}
// 		}

// 	});
// })

// $('.cancelUpdt').click(function(){
	
// })


