function tampiSGA(th)
{
	var slcData = $('input[name="slcData"]').val();

	var request = $.ajax({
		url: baseurl+'StockGudangAlat/insertData/',
		data:{slcData:slcData
			},
		type: "POST",
		datatype: 'html',
    });

    request.done(function(result){
        $('#ResultMonitoring').html(result);
    })
}


var table = $('#tblDataStockBaru').DataTable();
// var table = null;
var counter = 1;

// $(function(){
//
//     table = $('#tblDataStock').DataTable({
//         "lengthMenu" : [10,25,50],
//         "paging": true,
//         "lengthChange": true,
//         "searching": true,
//         "ordering": true,
//         "info": true,
//         "autoWidth": true,
//         "deferRender" : true,
//         "scroller": true
//     });
// })

    // $('.dataTable-pekerja').DataTable({});
//
// function addData() {
//     var tag = $('#tag').val();
//     var nama = $('#nama').val();
//     var merk = $('#merk').val();
//     var qty = $('#qty').val();
//     var jenis = $('#jenis').val();
//     if(tag && nama && merk && qty && jenis) {
//         table.row.add([
//             counter + '.',
//             tag,
//             nama,
//             merk,
//             qty,
//             jenis
//         ]).draw( false );
//         counter++;
//     } else {
//         alert('Mohon isi semua kolom form');
//     }
//
//     // $('#tblDataStock').text();
//     // console.log
// }
function editSkrtt(id) {
	$.ajax({
    method: 'POST',
    async: true,
    dataType: 'json',
    url: baseurl + 'StockGudangAlat/Stock/getDataComp/',
    data: {
      id: id
    },
    success: function(result) {
			console.log(result);
			console.log(result[0].nama);
      // $('#txt_id').val(id);
			$('.noPoSaitama').val(result[0].no_po);
			$('.tagSaitama').val(result[0].tag);
			$('.nama').val(result[0].nama);
			$('.merek').val(result[0].merk);
			$('.nomerSaitama').val(result[0].number);
			$('.qtySaitama').val(result[0].qty);
			$('.jenisaitama').html(result[0].jenis);

      // $('#txtQuantity').val(result[0].quantity);
      // $('#txtDeskripsi').html(result[0].deskripsi_penyusun);
      // alert(result[0].supply_type)
    },
  })
}

function updateData(th){
	var tag = $('#tag').val();
	var nama = $('#nama').val();
	var merk = $('#merk').val();
	var qty = $('#qty').val();
	var jenis = $('#jenis').val();

	console.log("clicked");

	var request = $.ajax({
		url: baseurl+'StockGudangAlat/updateData/',
		data: {
			tag : tag,
			nama : nama,
			merk : merk,
			qty : qty,
			jenis : jenis
		},
		type: "POST",
		datatype: 'html',
	});

	request.done(function(result){
			console.log("Done");
		})
}

$("#clear").click(function(){
	// location.reload();
    $("#nopo").val('');
    $("#qty").val('');
    $("#nama").val('');
    $("#jenis").val('');
    $("#subinv").val('');
    $("#merk").val('');
})

$("#nama, #merk, #jenis, #qty").change(function(){
    if (($('#jenis').val() != "" && $('#jenis').val() != undefined) && $('#nama').val() != ""
        && $('#merk').val() != "" && $('#qty').val() != "") {
        $("#nextsga").prop('disabled', false);
        // $("#clear").removeAttr('disabled');
    } else {
        $("#nextsga").prop('disabled', true);
    }

    $("#nextsga").click(function(){
		$("#table_input").show();
		$("#SGA_save").show();
        var saveForm = $('#formSGA').serialize();
        $.ajax({
            type : 'POST',
            url : baseurl+"StockGudangAlat/Stock/search_input",
            data : saveForm,
            success: function(data){
                console.log(data);
               $('#tbody_hasil').html(data);
               $('.hapus').click(function(){
                $(this).closest('tr').remove();
                console.log($('#tbody_hasil').html());
                if($('#tbody_hasil').html().match(/^((?!<tr>).)*$/)){
                    $('#table_input, #SGA_save').hide();
                }
                });
            },
            error : function(){
                $('#modal_error').modal();
                $('#SGA_save, #tabel_account, #button_save').hide();
            }
         })
    })
})
