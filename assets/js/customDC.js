$(document).ready(function() {
		var baseUrl = document.location.origin;
		$('input#txtExpiredDate').datepicker({
			autoclose: true,
		});
		$('input#txtStartDate').datepicker({
			autoclose: true,
		});
		$('input#txtEndDate').datepicker({
			autoclose: true,
		});
		
		$(".jsKodeCatMasuk").select2({
		tags: true,
		placeholder: " Input Kode Cat",
		minimumInputLength: 0,
		ajax: {		
					url: baseUrl+"/erp/QuickDataCat/DataCatMasuk/GetKodeCatMasuk",
					dataType: 'json',
					type: "GET",
					data: function (params) {
						var queryParameters = {
							term: params.term,
							type: $('select#slcKodeCat').val()
						}
						return queryParameters; 
					},
					processResults: function (data) {
						return {
							results: $.map(data, function(obj) {
								return { id:obj.SEGMENT1, text:obj.SEGMENT1};
							})
						};
					}
			}

		});
		
		$(".jsKodeCatKeluar").select2({
		tags: true,
		//var cust_id = $('input#hdnCustomerId').val();
		placeholder: " Input Kode Cat",
		minimumInputLength: 0,
		ajax: {		
					url: baseUrl+"/erp/QuickDataCat/DataCatKeluar/GetKodeCatKeluar",
					dataType: 'json',
					type: "GET",
					data: function (params) {

						var queryParameters = {
							term: params.term,
							// cust: $('input#hdnCustomerId').val(),
							type: $('select#slcKodeCat').val()
						}
						return queryParameters; 
					},
					processResults: function (data) {
						return {
							results: $.map(data, function(obj) {
								return { id:obj.paint_code, text:obj.paint_code};
							})
						};
					}
			}

		});
		
		$('#cat-masuk').DataTable({
          "paging": true,
          "lengthChange": true,
          "searching": true,
          "ordering": true,
          "info": true,
          "autoWidth": false,
		});
		
		$('#cat-keluar').DataTable({
          "paging": true,
          "lengthChange": true,
          "searching": true,
          "ordering": true,
          "info": true,
          "autoWidth": false,
		});	
		$('#cat-onhand').DataTable({
          "paging": true,
          "lengthChange": true,
          "searching": true,
          "ordering": true,
          "info": true,
          "autoWidth": false,
		});
		$('#dataTables').DataTable({
          "paging": true,
          "lengthChange": false,
          "searching": false,
          "ordering": false,
          "info": true,
          "autoWidth": false,
		});
		$('#table_ohn').DataTable({
          "paging": true,
          "lengthChange": false,
          "searching": false,
          "ordering": false,
          "info": true,
          "autoWidth": false,
		});

	$('#modalDelStokCat').click(function(){
		$('#modalStokCatConfirmationDel').modal('show'); 
	});
	
	$('#modalDelOnHand').click(function(){
		$('#modalOnHandConfirmationDel').modal('show'); 
	});
	
	$('#executeDelStokCat').click(function(){
		$.ajax({
			type: "POST",
			url: baseUrl+"/erp/QuickDataCat/LihatStokCat/ajaxDelStokCat", 
			dataType:'JSON',
			success: function(data){
			   if(data == "success"){
				   location.reload();
			   }else{
				   alert('empty');
				   $('#myModal').modal('toggle'); 
			   }
			} 
		});
	});
	
	$('#executeDelOnHand').click(function(){
		$.ajax({
			type: "POST",
			url: baseUrl+"/erp/QuickDataCat/LihatStokOnHand/ajaxDelOnHand", 
			dataType:'JSON',
			success: function(data){
			   if(data == "success"){
				   location.reload();
			   }else{
				   alert('empty');
				   $('#myModal').modal('toggle'); 
			   }
			} 
		});
	});
	
});

function disabledButtonOut(){
	var paint_code = $('#slcKodeCat').val().length;
	var paint_desc = $('#txtDescription').val().length;
	var bukti      = $('#txtBukti').val().length;
	var petugas    = $('#txtPetugas').val().length;
	if(paint_code==0 || paint_desc==0 || bukti==0 || petugas==0 ){
		$('#txtBtnSave').attr('disabled','disabled');
	}else{
		$('#txtBtnSave').removeAttr('disabled');
	}
}

function disabledButtonIn(){
	var paint_code = $('#slcKodeCat').val().length;
	var paint_desc = $('#txtDescription').val().length;
	var expired    = $('#txtExpiredDate').val().length;
	var qty		   = $('#txtQuantity').val().length;
	var bukti      = $('#txtBukti').val().length;
	var petugas    = $('#txtPetugas').val().length;
	if(paint_code==0 || paint_desc==0 || bukti==0 || petugas==0 || expired==0 || qty==0){
		$('#SUBMIT').attr('disabled','disabled');
	}else{
		$('#SUBMIT').removeAttr('disabled','disabled');
	}
}

function getDescriptionMasuk(base){
	var kode_cat = $("select#slcKodeCat option:selected").attr('value');
	// alert('Hello world!');
	$.post(base+"QuickDataCat/DataCatMasuk/getDescriptionMasuk", {id:kode_cat}, function(data){
		$("input#txtDescription").val(data);
	})
}

function searchServiceProducts_new(base) {
var base_url = base;	
var kode_cat = $("#slcKodeCat").val();
	//meminta request ajax
	var request = $.ajax ({
        url : base_url+"QuickDataCat/DataCatKeluar/tableSearch",
        data : "&kode_cat="+kode_cat,
        type : "GET",
        dataType: "html"
    });
 
    //menampilkan pesan Sedang mencari saat aplikasi melakukan proses pencarian
    $('#result_table').html('');
    $('#loading').html("<center><img id='loading' style='margin-top: 2%; height:100px ; width:120px' src='"+base_url+"assets/img/gif/loading10.gif'/><br />");
	        
	//Jika pencarian selesai
    request.done(function(output) {
		window.setTimeout(function(){
			 //Prints the progress text into our Progress DIV
			$('#result_table').html(output);                //Prints the data into the table
			$('#loading').html('');
			
		}, 1000);
               //Tampilkan hasil pencarian pada tag div dengan id hasil-cari
               
    });

  	var kode_cat = $("select#slcKodeCat option:selected").attr('value');
	$.post(base_url+"QuickDataCat/DataCatKeluar/getDescriptionKeluar", {id:kode_cat}, 
		function(data){
		$("input#txtDescription").val(data);
	})
}
		
function searchPaint(base) {
var base_url = base;	
var start_date = $("#txtStartDate").val();
var end_date = $("#txtEndDate").val();
var paint_code = $("#txtPaintCode").val();
var paint_desc = $("#txtPaintDesc").val();

	//meminta request ajax
	var request = $.ajax ({
        url : base_url+"C_LihatStockCat/ajaxSearching", 
        data : {start_date: start_date,end_date: end_date,paint_code: paint_code,paint_desc: paint_desc},
        type : "post",
        dataType: "html"
    });
 
    //menampilkan pesan Sedang mencari saat aplikasi melakukan proses pencarian
    $('#resultpaint').html('');
	$('#loading2').html("<center><img id='loading' style='margin-top: 2%;' src='"+base_url+"assets/img/gif/loading5.gif'/><br /><p style='color:#575555;'>Searching Data</p></center><br />");
           
	//Jika pencarian selesai
    request.done(function(output) {
		window.setTimeout(function(){
			$('#loading2').html(''); //Prints the progress text into our Progress DIV
			$('#resultpaint').html(output);                //Prints the data into the table
			
		}, 1000);
               //Tampilkan hasil pencarian pada tag div dengan id hasil-cari
               
    });
}

function searchPaint2(base) {
var base_url = base;	
var start_date = $("#txtStartDate").val();
var end_date = $("#txtEndDate").val();
var paint_code = $("#txtPaintCode").val();
var paint_desc = $("#txtPaintDesc").val();

	//meminta request ajax
	var request = $.ajax ({
        url : base_url+"C_LihatStockCat/exportpdfDataStockPeriode", 
        data : {start_date: start_date,end_date: end_date,paint_code: paint_code,paint_desc: paint_desc},
        type : "post",
        dataType: "html"
    });     
}

function formReset(){
	document.getElementById("form1").reset();
}

$(document).ready(function() {
    $('#tabelcat_all').DataTable( {
    	"searching" : false,
        "paging":   true,
        "ordering": false,
        "info":     false
    } );
} );

$(document).ready(function() {
	$('#tabelcari').DataTable( {
		  "paging": true,
          "lengthChange": true,
          "searching": true,
          "ordering": true,
          "info": true,
          "autoWidth": false,
	} );
} );

$(function () {
    $('#btnAdd').click(function () {
        var num     = $('.clonedInput').length,
            newNum  = new Number(num + 1),
            newElem = $('#entry' + num).clone().attr('id', 'entry' + newNum).fadeIn('fast');
        newElem.find('.expired_date').attr('id', 'txtExpiredDate').attr('name','txtExpiredDate[]').val('');
        newElem.find('.quantity').attr('id', 'txtQuantity').attr('name','txtQuantity[]').val('');
		newElem.find('.expired_date').datepicker({
				autoclose: true,
			});   
		$('#entry' + num).after(newElem);
        $('#ID' + newNum + '_title').focus();
        $('#btnDel').attr('disabled', false);
		if (newNum == 10)
        $('#btnAdd').attr('disabled', true).prop('value', "ADD"); 
    });

    $('#btnDel').click(function () {
            {
                var num = $('.clonedInput').length;
                $('#entry' + num).slideUp('fast', function () {$(this).remove();
                    if (num -1 === 1)
                $('#btnDel').attr('disabled', true);
                $('#btnAdd').attr('disabled', false).prop('value', "ADD");});
            }
    });
			$('input#txtExpiredDate').datepicker({
				autoclose: true,
			});   

	
    $('#btnAdd').attr('disabled', false);
    $('#btnDel').attr('disabled', true);
});



