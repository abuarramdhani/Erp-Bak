var org_ss = $('#org_ss').val();
var route_serverside = $('#routeraktif_ss').val();
var kind = $('#kind').val();

$(document).ready(function(){
	$('#tbleffectiveDays').DataTable({
		"columnDefs": [{
		  "targets": '_all',
		  "orderable": false,
		}],
	  });

if(kind == 'EDIT'){

  $.ajax({
  url: baseurl + 'SettingMinMaxOPM/C_settingMinMaxOPM/serversideMinMax',
  type: 'POST',
  data: {
    org: org_ss,
    route: route_serverside,
  },
  beforeSend: function() {
    $( '#loadingArea' ).show();
  },
  success: function(result) {
    $( '#loadingArea' ).hide();

    $('div#tablearea').html(result);
    $('#tableDataMinMax').DataTable({
      "columnDefs": [{
        "targets": '_all',
        "orderable": false,
      }],
    });
    $(".loader").fadeOut();
  },
  error: function(XMLHttpRequest, textStatus, errorThrown) {
    $('div#loadingArea').html('');
    $('div#tbCompDat').html(errorThrown);
    $("body").niceScroll();
  }
})

}else if(kind == 'IE') {

  $.ajax({
  url: baseurl + 'SettingMinMaxOPM/C_settingMinMaxOPM/serversideMinMaxIE',
  type: 'POST',
  data: {
    org: org_ss,
    route: route_serverside,
  },
  beforeSend: function() {
    $( '#loadingArea' ).show();
  },
  success: function(result) {
    $( '#loadingArea' ).hide();
    $('div#tablearea').html(result);
    $(".loader").fadeOut();

  },
  error: function(XMLHttpRequest, textStatus, errorThrown) {
    $('div#loadingArea').html('');
    $('div#tbCompDat').html(errorThrown);
    $("body").niceScroll();
  }
  })

}else{
   console.log('none');
}



})


$('#org').change(function(){
	org = $(this).val();
	console.log(org);
	if (org == 'OPM') {
			$.ajax({
			url: baseurl+'SettingMinMaxOPM/C_settingMinMaxOPM/getRouteOPM',
			success: function(results){
				$('#routing_class').html(results);
			}
		});
		} else if (org == 'ODM') {
			$.ajax({
			url: baseurl+'SettingMinMaxOPM/C_settingMinMaxOPM/getRouteODM',
			success: function(results){
				$('#routing_class').html(results);
			}
		});
		}

});

$('#sublimit').click(function() {
	$( "#formlimit" ).submit();
});


$("#Modalku").modal('hide');

function getData(th){
	var itemCode = [];
	var desc = [];
	var uom = [];
	var min = [];
	var max = [];
	var rop = [];
	var limit = [];
	$('.chkMinmaxData').each(function(){
		if (this.checked) {
			var id = $(this).val()
			console.log(id, "id")
			$('tr#'+id).each(function(){
				var col = 1;
				$(this).find('td').each(function(){
					if(col == 3){
						itemCode.push($(this).text())
					}
					if(col == 4){
						desc.push($(this).text())
					}
					if(col == 5){
						uom.push($(this).text())
					}
					if(col == 6){
						min.push($(this).text())
					}
					if(col == 7){
						max.push($(this).text())
					}
					if(col == 8){
						rop.push($(this).text())
					}
					if(col == 9){
						limit.push($(this).text())
					}
					col++
				});
			})
		}
	});
	$.ajax({
		type: "post",
		url: baseurl+"SettingMinMaxOPM/C_settingMinMaxOPM/Import",
		data:{
		itemcode: itemCode,
		description: desc,
		uom: uom,
		min: min,
		max: max,
		rop: rop,
		limit: limit
		},
		cache:false,
		success:function(data){
			console.log('berhasil')
		},
		error: function (xhr, ajaxOptions, thrownError){
			console.log(xhr.responseText);
		}
	})
}

$('#btn_upload').click(function() {
	$('#uploadFile').submit(function(e) {
		e.preventDefault();
			$.ajax({
				url: baseurl + 'SettingMinMaxOPM/C_settingMinMaxOPM/Import',
				type: "post",
				dataType: 'json',
				data: new FormData(this),
				processData: false,
				contentType: false,
				cache: false,
				async: false,
				success: function(data) {
					console.log(data);
					alert("Upload File Berhasil.");
					window.location.reload();
				}
			});
	})
});

$(document).ready(function(){
	$('#export_excell').click(function(){
		$('.buttons-html5').click();
	});
});
