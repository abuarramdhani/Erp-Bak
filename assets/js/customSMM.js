$(function() {
    $('#tableDataMinMax').DataTable({
    	columnDefs: [
    		{ targets: '_all', orderable: false}
    	]
	});

//SETTING CURRENT DATE//
var today = new Date();
var dd = today.getDate();
var mm = today.getMonth() + 1; //January is 0!
var yyyy = today.getFullYear();
if (dd < 10) {
  dd = '0' + dd;
} 
if (mm < 10) {
  mm = '0' + mm;
} 
today = dd + '-' + mm + '-' + yyyy;

					// var today = new Date();
					// var dd = String(today.getDate()).padStart(2, '0');
					// var mm = String(today.getMonth() + 1).padStart(2, '0'); 
					// var yyyy = today.getFullYear();

					// today = dd + '-' + mm + '-' + yyyy;

	var dt2 = $('#tableDataMinMaxIE').DataTable({
		dom: '<"dataTable_Button"B><"dataTable_Filter"f>rt<"dataTable_Information"i><"dataTable_Paging"p>',
		columnDefs: [
			{
				orderable: false,
				className: 'select-checkbox',
				targets: 1
			}
		],
        buttons: [
			{
				extend: 'excelHtml5',
				title: 'Edit Data Min Max'+' : '+today,
				exportOptions: {
					columns: ':visible',
					// rows: ':visible',
					modifier: {
                        selected: true
                    },
					columns: [0, 2, 3, 4, 5, 6, 7],

				}
			}
		],
        select: {
            style: 'multi',
            selector: 'td:nth-child(2)'
        },
        order: [[0, 'asc']]
	});
	// $('#tableDataMinMaxIE tbody').on('click', 'tr', function() { $(this).toggleClass('selected'); }); // slct by row
	$('#check-all').off('ifChanged').on('ifChanged', function(event) {
		if(event.target.checked) {
			dt2.rows().select();        
		} else {
			dt2.rows().deselect(); 
		}
	});
	$(".loader").fadeOut("slow");
} );

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


$("#Modalku").modal('hide');

function getData(th){
	var itemCode = [];
	var desc = [];
	var uom = [];
	var min = [];
	var max = [];
	var rop = [];
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
		rop: rop
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