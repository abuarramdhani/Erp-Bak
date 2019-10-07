function addRow(tableID) {
    var table = document.getElementById(tableID);
    var rowCount = table.rows.length;
    var row = table.insertRow(rowCount);
    var colCount = table.rows[0].cells.length;
    for(var i=0; i<colCount; i++) {
        var newcell = row.insertCell(i);
        newcell.innerHTML = table.rows[1].cells[i].innerHTML;
        //alert(newcell.childNodes);
        switch(newcell.childNodes[0].type) {
            case "text":
            newcell.childNodes[0].value = "";
            break;
            case "select-one":
            newcell.childNodes[0].selectedIndex = 0;
            break;
        }
    }
}

function deleteRow(tableID) {
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

$('#searchdata').click(function(){
var activity = $("#no_po").val();

    //meminta request ajax
    var request = $.ajax ({
        url : baseurl + "BarangDatang/ajaxSearching",
        data : "&activity="+activity,
        type : "GET",
        dataType: "html"
    });
    
    //menampilkan pesan Sedang mencari saat aplikasi melakukan proses pencarian
    $('#res').html('');
    $('#loading').html("<center><img id='loading' style='margin-top: 2%;' src='"+baseurl+"assets/img/gif/loading5.gif'/><br /><p style='color:#575555;'>Searching Data</p></center><br />");
            
    //Jika pencarian selesai
    request.done(function(output) {
        // console.log(output.VENDOR_NAME);

        window.setTimeout(function(){
            $('#loading').html(''); //Prints the progress text into our Progress DIV
            $('#res').html(output);                //Prints the data into the table
            
        }, 1000);
                //Tampilkan hasil pencarian pada tag div dengan id hasil-cari
                
    });
})

$('.searchsupplier').click(function(){
    var activity = $("#no_po").val();
    
        //meminta request ajax
        var request = $.ajax ({
            url : baseurl + "BarangDatang/SearchSupplier",
            data : "&activity="+activity,
            type : "GET",
            dataType: "html"
        });
             
        //Jika pencarian selesai
        request.done(function(output) {
            console.log(output);
            $("#pilihsupplier").val(output);
            // window.setTimeout(function(){
            //     $('#loading').html(''); //Prints the progress text into our Progress DIV
            //     $('#res').html(output);                //Prints the data into the table
                
            // }, 1000);
                    //Tampilkan hasil pencarian pada tag div dengan id hasil-cari
                    
        });
    })

// var prm = $("#no_po").val();
// function isisupplier() {
//     $(document).ready(function(){
//         var prm = $("#no_po").val();
//         var request = $.ajax({
//             url: baseurl+'BarangDatang/SearchSupplier',
//             data: {
//                 prm : prm
//             },
//             type: "POST",
//             datatype: 'html'
//         });
//         request.done(function(result){
//             console.log(result);
//             // document.getElementById("loading").style.display = "none";
//             // $('#ResultMBD').html(result);
//             // $('#myTable').dataTable({
//             //     "paging": false,
//             //     "scrollX": true,
//             //     "scrollCollapse": true,
//             //     "fixedHeader":true,
//             //     "ordering": false,
//             //     'rowsGroup': [0],
//             //     });
//             })
//         });
// }


$(document).ready(function(){
    // $('.jspilihSupplier').select2({
    //     allowClear: true,
    //     ajax: {
    //         url: baseurl + 'BarangDatang/GetSupplier',
    //         dataType: 'json',
    //         type: 'GET',
    //         data: function (params) {
	// 			var queryParameters = {
	// 				term: params.term
	// 			}
	// 			return queryParameters;
	// 		},
    //         processResults: function(data) {
    //             console.log(data);
    //             return {
    //                 results: $.map(data, function(item) {
    //                     return {
    //                         id: item.VENDOR_NAME,
    //                         text: item.VENDOR_NAME ,
    //                     }
    //                 })
    //             };
    //         },
    //     },
    //     minimumInputLength: 3,
    //     placeholder: 'Supplier',
    // });
    $("#gudangbd").select2({
		minimumInputLength: 3,

		ajax: {		
			url:baseurl+"BarangDatang/gudangbd",
			dataType: 'json',
			type: "GET",
			data: function (params) {
				var queryParameters = {
					term: params.term,
					// subinv: $('#gudang').val(),
					// loc: $('#locator').val()
				}
				return queryParameters;
			},
			processResults: function (data) {
				return {
					results: $.map(data, function(obj) {
						return { id:obj.SECONDARY_INVENTORY_NAME, text:obj.SECONDARY_INVENTORY_NAME};
					})
				};
			}
		}	
    });
    

    $("#itembd").select2({
		minimumInputLength: 3,

		ajax: {		
			url:baseurl+"BarangDatang/itembd",
			dataType: 'json',
			type: "GET",
			data: function (params) {
				var queryParameters = {
					term: params.term,
					// subinv: $('#gudang').val(),
					// loc: $('#locator').val()
				}
				return queryParameters;
			},
			processResults: function (data) {
				return {
					results: $.map(data, function(obj) {
						return { id:obj.SEGMENT1+"-"+obj.DESCRIPTION+"-"+obj.ITEM_ID, text:obj.SEGMENT1+" - "+obj.DESCRIPTION};
					})
				};
			}
		}	
	});

    $("#dataTables-table tbody tr").each(function() {
        if ($(this).find("#checkbox").is(':checked')) {
        var item = $(this).find('#rowItem').html();
        $.ajax({
                type:"POST",
                url:"<?php echo site_URL()?>input_data/C_Barang/saveTable",
                data:'txtID='+item,
                success:function(success){
                    alert(success);
                }
            })
        }
    });

})

$("#no_sj, #no_po, #no_id ").change(function(){
        if (
            // ($('#jspilihSupplier').val() != "" && $('#jspilihSupplier').val() != undefined) && 
            ($('#no_id').val() != "" && $('#no_id').val() != undefined) 
        && $('#no_po').val() != "" && $('#no_sj').val() != "") {
			$("#searchdata").prop('disabled', false);
		} else {
			$("#searchdata").prop('disabled', true);
		}
});

$('.dtPicker').datepicker({
	autoclose: true,
	todayHighlight: true,
	dateFormat: 'dd-mmmm-yyyy'
});

function clearfilterMBD(th) {
    $('input[name="txtNo_surat_jalan"]').val('');
    $('input[name="txtNo_po"]').val('');
    $('select[name="selectIO"]').select2("val", "");
    $('input[name="tgl_mulaiMBD"]').val('');
    $('input[name="tgl_akhirMBD"]').val('');
    $('#ResultMBD').html('');
}

function getMBD(th) {
    $(document).ready(function(){
    var no_sj = $('input[name="txtNo_surat_jalan"]').val();
    var no_po = $('input[name="txtNo_po"]').val();
    var io = $('select[name="selectIO"]').val();
    var tgl_mulai = $('input[name="tgl_mulaiMBD"]').val();
    var tgl_akhir = $('input[name="tgl_akhirMBD"]').val();
    var request = $.ajax({
        url: baseurl+'BarangDatang/search',
        data: {
            no_sj : no_sj, tgl_mulai : tgl_mulai, tgl_akhir : tgl_akhir, no_po : no_po, io :io
        },
        type: "POST",
        datatype: 'html'
    });
    
    $('#ResultMBD').html('');
    $('#loading').prop('style', false);
        
    request.done(function(result){
        // console.log(result);
        document.getElementById("loading").style.display = "none";
        $('#ResultMBD').html(result);
        // $('#myTable').dataTable({
        //     "paging": false,
        //     "scrollX": true,
        //     "scrollCollapse": true,
        //     "fixedHeader":true,
        //     "ordering": false,
        //     'rowsGroup': [0],
        //     });
        })
    });
}


var cekClickId = [];
var cekClick2 = "";
function btnRowAdd(no) {
    var index = cekClickId.indexOf("#addRow"+no)
    if(index == -1){   
        $('tr.clone'+no).toggle("callback");
        cekClickId.push('#addRow'+no)
    }else{
        $('tr.clone'+no).css('display','none');
        cekClickId.splice(index,1)        
    }
}

var cekClickId = [];
var cekClick2 = "";
function btnRowAdd2(no, no2) {
    var index = cekClickId.indexOf("#addRow2"+no+no2)
    if(index == -1){   
        $('tr.clone2'+no+no2).slideToggle( "slow" );
        cekClickId.push('#addRow2'+no+no2)
    }else{
        $('tr2.clone'+no+no2).slideUp()
        cekClickId.splice(index,1)        
    }
}

var cekClickId = [];
var cekClick2 = "";
function btnRowAdd3(no, no2, no3) {
    var index = cekClickId.indexOf("#addRow2"+no+no2+no3)
    if(index == -1){   
        $('tr.clone2'+no+no2+no3).slideToggle( "slow" );
        cekClickId.push('#addRow2'+no+no2+no3)
    }else{
        $('tr2.clone'+no+no2+no3).css('display','none');
        cekClickId.splice(index,1)        
    }
}
$("#tgl_mulaiMBD, #tgl_akhirMBD").change(function(){
    if (($('#tgl_mulaiMBD').val() != "" && $('#tgl_mulaiMBD').val() != undefined) 
    && ($('#tgl_akhirMBD').val() != "" && $('#tgl_akhirMBD').val() != undefined)) {
        $("#btnGetMBD").prop('disabled', false);
    } else {
        $("#btnGetMBD").prop('disabled', true);
    }
});
