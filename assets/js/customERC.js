$(document).ready(function() {
   $('#tabletest').DataTable( {
        scrollY:        "300px",
        scrollX:        true,
        scrollCollapse: true,
        paging:         false,
        sorting: false,
        searching: false,
        fixedColumns: true,
        order: [],
        bDestroy: true,
    } );
      $('.tabletest2').DataTable( {
        scrollY:        "300px",
        scrollX:        true,
        scrollCollapse: true,
        paging:         false,
        sorting: false,
        searching: false,
        fixedColumns: true,
        order: [],
    } );
       $('.tabledelERC').DataTable( {
        scrollY:        "300px",
        scrollX:        true,
        scrollCollapse: true,
        paging:         true,
        sorting: false,
        searching: false,
        fixedColumns: true,
        order: [],
    } );
} );

function checkJawabERC(th){
	var rule = $(th).attr("data-rule");
	var jwb = $(th).val();
	if (rule == 's') {
		if (jwb.length != 1 && jwb.length != 0 ) {
			$(th).parent().removeClass('bg-green').addClass('bg-red');
		}else if(jwb.length == 0 ){
			$(th).parent().removeClass('bg-green').addClass('bg-yellow');
		}else{
			$(th).parent().removeClass('bg-red bg-yellow').addClass('bg-green');
			setTimeout(function(){ $(th).parent().removeClass('bg-green'); }, 1000);
		}
	}else if(rule == 'd'){
		if (jwb.length != 4 ) {
			$(th).parent().removeClass('bg-green').addClass('bg-red');
		}
		else if(jwb.length == 0 ){
			$(th).parent().removeClass('bg-green').addClass('bg-yellow');
		}else{
			jawabd = jwb.split("");
			if (jawabd[0] == '(' && jawabd[3] == ')') {
				$(th).parent().removeClass('bg-red bg-yellow').addClass('bg-green');
				setTimeout(function(){ $(th).parent().removeClass('bg-green'); }, 1000);
			}else{
				$(th).parent().removeClass('bg-green').addClass('bg-red');
			}
		}
	}

	checkJmlErrERC();
}


function checkSetERC(th){
	var jwb = $(th).val().toLowerCase();
	var rule = $(th).closest('tr').find('select#slcType').val();
	if (rule == 's') {
		if (jwb.length != 1 ) {
			$(th).parent().removeClass('bg-green').addClass('bg-red');
		}else{
			$(th).parent().removeClass('bg-red').addClass('bg-green');
			setTimeout(function(){ $(th).parent().removeClass('bg-green'); }, 1000);
		}
	}else if(rule == 'd'){
		if (jwb.length != 2 ) {
			$(th).parent().removeClass('bg-green').addClass('bg-red');
		}else{
			$(th).parent().removeClass('bg-red').addClass('bg-green');
			setTimeout(function(){ $(th).parent().removeClass('bg-green'); }, 1000);
		}
	}

	$(th).val(jwb);
}

function checkJmlErrERC(){
	var Err = 0;
	var Emp = 0;
	$('#tabletest tr').find("td").each(function( i ) {
     if ($(this).attr("class") == 'bg-red') {
     	Err = Err+1;
     }
     if ($(this).attr("class") == 'bg-yellow') {
     	Emp = Emp+1;
     }
  });
	$('#jmlError').html(Err);
	$('#jmlEmpty').html(Emp);
	if (Err > 0) {
		$('#jmlError').css('color', 'red');
		$('#ErrDone').html('');
	}else{
		$('#ErrDone').html('&#10004;');
		$('#jmlError').css('color', 'green');
	}

	if (Emp > 0) {
		$('#jmlEmpty').css('color', 'orange');
		$('#EmpDone').html('');
	}else{
		$('#EmpDone').html('&#10004;');
		$('#jmlEmpty').css('color', 'green');
	}
}

$('#processCor').click(function(){
	$('.alert').alert('close');
	$('body').addClass('noscroll');
	$('#loadingAjax').addClass('overlay_loading');
	$('#loadingAjax').html('<div class="pace pace-active"><div class="pace-progress" style="height:100px;width:80px" data-progress="100"><div class="pace-progress-inner"></div></div><div class="pace-activity"></div></div>');
			
});

// function addRowERC(tableID) {

// var table = document.getElementById(tableID);
// var rowCount = table.rows.length;
// var row = table.insertRow(rowCount);
// var colCount = table.rows[0].cells.length;
// for(var i=0; i<colCount; i++) 
// 	{
		
		 
// 		var newcell = row.insertCell(i);
// 		newcell.innerHTML = table.rows[1].cells[i].innerHTML;
// 		switch(newcell.childNodes[0].type) 
// 			{
// 				case "text":
// 				newcell.childNodes[0].value = "";
// 				break;
// 				case "checkbox":
// 				newcell.childNodes[0].checked = false;
// 				break;

// 			}
// 				newcell.childNodes[0].text = "tod";
// 	}
// }

function addRowERC(th) {
      var rowCount = $('#tableRule tr').length;
        var form = $('.rowERC').last().clone();
        var num = form.find('.frst').text();
        var id2 = Number(num)-1;
        form.find('.frst').empty();
        form.find('.frst').append(Number(num)+1);
        form.find('.id-key').attr("name",'');
        form.find('.id-key').attr("name",'txtKey['+Number(num)+']');

        form.find('.id-btl').attr("name",'');
        form.find('.id-btl').attr("name",'scrBtl['+Number(num)+']');

        form.find('.id-ruleid').attr("name",'');
        form.find('.id-ruleid').attr('value','');
        form.find('.id-ruleid').attr("name",'idNo['+Number(num)+']');

        form.find('.id-slh').attr("name",'');
        form.find('.id-slh').attr("name",'scrSlh['+Number(num)+']');

        form.find('#id-sub').attr("name",'');
        form.find('#id-sub').attr("name",'subTest['+Number(num)+']');

        form.find('#slcType').attr("name",'');
        form.find('#slcType').attr("name",'slcType['+Number(num)+']');

        form.find('.id-num').attr("name",'');
        form.find('.id-num').attr("name",'nomer['+Number(num)+']');
        form.find('.id-num').attr('value','');
        $('#tableRule').append(form);
         $('#tableRule tr:last select').val('').change();
         $('#tableRule tr:last input').val('').change();
        form.find('.id-num').attr('value',Number(num)+1);
}
						
							
function deleteRowERC(tableID) {
try {
	var table = document.getElementById(tableID);
	var rowCount = table.rows.length;
	var i = rowCount-1;
		
if(rowCount > 2){
	table.deleteRow(i);
}else{
	alert('Baris Tidak Tersedia');
	}
		
}catch(e) {
	alert(e);
}
}
function slcAllERC(th) {
	$('.tabledelERC tr').find("td").each(function( i ) {
		var attr = $(this).find('input[name="id[]"]').attr('checked');

		if (typeof attr !== typeof undefined && attr !== false) {
	     	$('input[name="id[]"]').iCheck('uncheck'); 
	     	$(this).find('input[name="id[]"]').removeAttr('checked');
		    
		}else{
	     	$('input[name="id[]"]').iCheck('check'); 
	     	$(this).find('input[name="id[]"]').attr('checked', 'checked');

		}
  });
}

