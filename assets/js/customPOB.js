$(document).ready(function(){
    $(".nav-tabs a").click(function(){
        $(this).tab('show');
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
				$(th).parents('table').DataTable().destroy();
				$(th).closest('tr').remove();
				$(th).parents('table').DataTable({
					dom: 'Bfrtip',
    				buttons: ['excel', 'pdf']
				});
				$('.deleteInduk').prop('disabled',false);

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
				$(th).parents('table').DataTable().destroy();
				$(th).closest('tr').remove();
				$(th).parents('table').DataTable({
					dom: 'Bfrtip',
    				buttons: ['excel', 'pdf']
				});
				$('.deleteCabang').prop('disabled',false);

			}
		})
	}
}


function editInduk(th){
	$(th).parents('tr').find('div.updtInd').show();
	$(th).parents('tr').find('p.ind').hide();
	$(th).parents('tr').find('input[name="updt_indk"]').focus();
	$(th).parents('td').find('button.saveUpdtInduk').show();
	$(th).hide();
}

function editCabang(th){
	$(th).parents('tr').find('div.updtCbg').show();
	$(th).parents('tr').find('p.cbg').hide();
	$(th).parents('tr').find('input[name="updt_Cbg"]').focus();
	$(th).parents('td').find('button.saveUpdtCabang').show();
	$(th).hide();
}

$("#masterIndukLogam").on("click", ".cancelUpdt", function(){
	$(this).parents('tr').find('div.updtInd').hide();
	$(this).parents('tr').find('p.ind').show();
	$(this).parents('tr').find('button.saveUpdtInduk').hide();
	val = $(this).parents('tr').find('p.ind').html();
	$(this).parents('tr').find('input[name="updt_indk"]').val(val);
	$(this).parents('tr').find('button.editInduk').show();
});

$("#masterIndukInti").on("click", ".cancelUpdt", function(){
	$(this).parents('tr').find('div.updtInd').hide();
	$(this).parents('tr').find('p.ind').show();
	$(this).parents('tr').find('button.saveUpdtInduk').hide();
	val = $(this).parents('tr').find('p.ind').html();
	$(this).parents('tr').find('input[name="updt_indk"]').val(val);
	$(this).parents('tr').find('button.editInduk').show();
});

$("#masterCabangLogam").on("click", ".cancelUpdt", function(){
	$(this).parents('tr').find('div.updtCbg').hide();
	$(this).parents('tr').find('p.cbg').show();
	$(this).parents('tr').find('button.saveUpdtCabang').hide();
	val = $(this).parents('tr').find('p.cbg').html();
	$(this).parents('tr').find('input[name="updt_Cbg"]').val(val);
	$(this).parents('tr').find('button.editCabang').show();
});

$("#masterCabangInti").on("click", ".cancelUpdt", function(){
	$(this).parents('tr').find('div.updtCbg').hide();
	$(this).parents('tr').find('p.cbg').show();
	$(this).parents('tr').find('button.saveUpdtCabang').hide();
	val = $(this).parents('tr').find('p.cbg').html();
	$(this).parents('tr').find('input[name="updt_Cbg"]').val(val);
	$(this).parents('tr').find('button.editCabang').show();
});

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
			}
		})
	}
}

// $('.cancelUpdt').click(function(){
	
// })
