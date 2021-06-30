//-----------------------------------------------------------LIHAT STOCK------------------------------------------------------------------------
$(document).ready(function () {
	$(".kodestockgdsp").select2({
			allowClear: true,
			minimumInputLength: 3,
			ajax: {
					url: baseurl + "StockGdSparepart/LihatStock/getKodebarang",
					dataType: 'json',
					type: "GET",
					data: function (params) {
							var queryParameters = {
									term: params.term, subinv : $('#subinv').val()
							}
							return queryParameters;
					},
					processResults: function (data) {
							// console.log(data);
							return {
									results: $.map(data, function (obj) {
											return {id:obj.ITEM, text:obj.PRODUCT_DESC};
									})
							};
					}
			}
	});

	$(".lokasi_simpan").select2({
		allowClear: true,
		minimumInputLength: 3,
		ajax: {
				url: baseurl + "StockGdSparepart/LihatStock/getLokasiSimpan",
				dataType: 'json',
				type: "GET",
				data: function (params) {
						var queryParameters = {
								term: params.term, subinv : $('#subinv').val()
						}
						return queryParameters;
				},
				processResults: function (data) {
						// console.log(data);
						return {
								results: $.map(data, function (obj) {
										return {id:obj.LOKASI, text:obj.LOKASI};
								})
						};
				}
		}
});

	$(".subInvCode").select2({
			allowClear: true,
			minimumInputLength: 2,
			ajax: {
					url: baseurl + "StockGdSparepart/LihatStock/getSubinv",
					dataType: 'json',
					type: "GET",
					data: function (params) {
							var queryParameters = {
									term: params.term,
							}
							return queryParameters;
					},
					processResults: function (data) {
							// console.log(data);
							return {
									results: $.map(data, function (obj) {
											return {id:obj.SUB_INV_CODE, text:obj.SUB_INV_CODE};
									})
							};
					}
			}
	});

	var kode_unit = document.getElementById('kode_unit_ls');
	if (kode_unit) {
		getKodeUnit(this);
	}
});

function getLihatStock(no, ket) {
		var tglAw 		= $('#tglAwal').val();
		var tglAk 		= $('#tglAkhir').val();
		var subinv 		= $('#subinv').val();
		var kode_brg 	= $('#kodestockgdsp').val();
		var kode_awal 	= $('#kode_awal').val();
		var qty_atas 	= $('#qty_atas').val();
		var qty_bawah 	= $('#qty_bawah').val();
		var lokasi		= $('#lokasi_simpan').val();
		var unit 		= ket == 123 ? $('#unit'+no).val() : '';
		// console.log(unit, no, ket)
		var request = $.ajax({
			url: baseurl+'StockGdSparepart/LihatStock/searchData',
			data: {
                tglAw : tglAw, tglAk : tglAk, subinv : subinv, kode_awal : kode_awal, lokasi : lokasi,
				kode_brg : kode_brg, qty_atas : qty_atas, qty_bawah : qty_bawah, unit : unit, ket : ket
			},
			type: "POST",
			datatype: 'html'
		});
		$('#tb_lihatstock').html('');
		$('#tb_lihatstock').html('<center><img style="width:100px; height:auto" src="'+baseurl+'assets/img/gif/loadingtwo.gif"><br/></center>' );
			
		request.done(function(result){
			$('#tb_lihatstock').html(result);
            // $('.myTable').dataTable({
            //     "scrollX": true,
            // });
			$('.myTable').dataTable({
				dom: 'lfrtBip',
				scrollY : true,
                "scrollX": true,
				buttons: [{
					extend: 'excel',
					title: 'Stock Gudang Sparepart',
					message:'Periode : '+tglAw+' - '+tglAk+'',
					text: '<i class="fa fa-download"></i> Download',
					exportOptions: {
						columns: ':visible',
						columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 13],
					},
				}        
			
			],
			 order: [[0, 'asc']]
			});
		});
}

function getLihatStockKodeUnit(no) {
	var tglAw 		= $('#tglAwal').val();
	var tglAk 		= $('#tglAkhir').val();
	var subinv 		= $('#subinv').val();
	var unit 		= $('#unit'+no).val();
	// console.log(unit, no, ket)
	var request = $.ajax({
		url: baseurl+'StockGdSparepart/LihatStock/searchDataKodeUnit',
		data: {
			tglAw : tglAw, tglAk : tglAk, subinv : subinv, unit : unit
		},
		type: "POST",
		datatype: 'html'
	});
	$('#tb_lihatstock').html('');
	$('#tb_lihatstock').html('<center><img style="width:100px; height:auto" src="'+baseurl+'assets/img/gif/loadingtwo.gif"><br/></center>' );
		
	request.done(function(result){
		$('#tb_lihatstock').html(result);
		// $('.myTable').dataTable({
		//     "scrollX": true,
		// });
		$('.myTable').dataTable({
			dom: 'lfrtBip',
			scrollY : true,
			"scrollX": true,
			buttons: [{
				extend: 'excel',
				title: 'Stock Gudang Sparepart',
				message:'Periode : '+tglAw+' - '+tglAk+'',
				text: '<i class="fa fa-download"></i> Download',
				exportOptions: {
					columns: ':visible',
					columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 14],
				},
			}        
		
		],
		 order: [[0, 'asc']]
		});
	});
}

function getKodeUnit(th) {
	var subinv = $('#subinv').val();
	
	$.ajax({
		url : baseurl + "StockGdSparepart/LihatStock/getKodeUnit",
		data : {subinv : subinv},
		type : 'POST',
		datatype : "html",
		beforeSend: function() {
			$('div#kode_unit_ls' ).html('<center><img style="width:50px; height:auto" src="'+baseurl+'assets/img/gif/loading5.gif"></center>' );
		},
		success : function (result) {
			$('div#kode_unit_ls' ).html(result);
		}
	})
}

var peti = document.getElementById('tb_peti');
if (peti) {
	var request = $.ajax({
		url: baseurl+'StockGdSparepart/MonitoringPeti/searchData',
		type: "POST",
		datatype: 'html'
	});
	$('#tb_peti').html('');
	$('#tb_peti').html('<center><img style="width:100px; height:auto" src="'+baseurl+'assets/img/gif/loadingtwo.gif"><br/></center>' );
		
	request.done(function(result){
		$('#tb_peti').html(result);
	});
}

function savejmlPeti(no) {
	var item = $('#kode_brg'+no).val();
	var jml = $('#peti'+no).val();

	$.ajax({
		url : baseurl + "StockGdSparepart/MonitoringPeti/savepeti",
		data : { item : item, jml : jml},
		dataType : 'html',
		type : 'POST',
	})
}

function modalHistory(no) {
    var kode 	= $('#kode_brg'+no).val();
    var nama 	= $('#nama_brg'+no).val();
    var subinv 	= $('#subinv'+no).val();
    var tglAwl 	= $('#tglAwl'+no).val();
    var tglAkh 	= $('#tglAkh'+no).val();
    var onhand 	= $('#onhand'+no).val();
    var qty_in 	= $('#in'+no).val();
	var out 	= $('#out'+no).val();

	if (qty_in == '') {
		var inout = parseInt(out);
	}else if (out == '') {
		var inout = parseInt(qty_in);		
	}else{
		var inout = parseInt(qty_in) + parseInt(out);
	}	

    var request = $.ajax({
        url: baseurl+'StockGdSparepart/LihatStock/searchHistory',
        data: {
            kode : kode, nama : nama, subinv : subinv, 
			tglAwl : tglAwl, tglAkh : tglAkh, onhand : onhand,
			inout : inout
        },
        type: "POST",
        datatype: 'html'
    });
    request.done(function(result){
        $('#dataHistory').html(result);
        $('#mdlHistory').modal('show');
    });
   
}

function modalGambarItem(no) {
    var kode 	= $('#kode_brg'+no).val();
    var nama 	= $('#nama_brg'+no).val();
    var subinv 	= $('#subinv'+no).val();
    var tglAwl 	= $('#tglAwl'+no).val();
	var tglAkh 	= $('#tglAkh'+no).val();
	
    var request = $.ajax({
        url: baseurl+'StockGdSparepart/LihatStock/searchGambarItem',
        data: {
            kode : kode, nama : nama, subinv : subinv, 
			tglAwl : tglAwl, tglAkh : tglAkh
        },
        type: "POST",
        datatype: 'html'
    });
    request.done(function(result){
        $('#datagambar').html(result);
        $('#mdlGambarItem').modal('show');
    });
   
}


//----------------------------------------------------------LIHAT TRANSACT---------------------------------------------------------------------

function getLihatTransact(th) {
	$(document).ready(function(){
		var tglAw 		= $('#tglAwal').val();
		var tglAk 		= $('#tglAkhir').val();
		var subinv 		= $('#subinv').val();
		var kode_brg 	= $('#kodestockgdsp').val();
		var kode_awal 	= $('#kode_awal').val();
		// console.log(tglAw);
		
		var request = $.ajax({
			url: baseurl+'StockGdSparepart/LihatTransact/searchData',
			data: {
				tglAw : tglAw, tglAk : tglAk, subinv : subinv, 
				kode_awal : kode_awal, kode_brg : kode_brg
			},
			type: "POST",
			datatype: 'html'
		});
		$('#tb_lihattransact').html('');
		$('#tb_lihattransact').html('<center><img style="width:100px; height:auto" src="'+baseurl+'assets/img/gif/loadingtwo.gif"><br/></center>' );
			
		request.done(function(result){
			$('#tb_lihattransact').html(result);
		});
	});		
}

//-------------------------------------------------------MIN MAX----------------------------------------------------

function saveminmax(th) {
	var item = $('input[name="item[]"]').map(function(){return $(this).val();}).get();
	var desc = $('input[name="desc[]"]').map(function(){return $(this).val();}).get();
	var min = $('input[name="min[]"]').map(function(){return $(this).val();}).get();
	var max = $('input[name="max[]"]').map(function(){return $(this).val();}).get();
	var uom = $('input[name="uom[]"]').map(function(){return $(this).val();}).get();
		
	// window.location.replace('');
    $("#mdlloading").modal({
		backdrop: 'static',
		keyboard: true, 
		show: true
	}); 
	var request = $.ajax({
		url: baseurl+'StockGdSparepart/MinMaxStock/saveminmax',
		data: {
			item : item, min : min, max : max, uom : uom, desc : desc
		},
		type: "POST",
		datatype: 'html',
		success: function(data) {
            $("#mdlloading").modal("hide"); 
			swal.fire("Berhasil!", "", "success");
			// window.location = "";
		}

	});
}

$(document).ready(function(){
	$('#exportminmaxstock').click(function(){
		$('.buttons-html5').click();
	});


	oTable = $('#tblminmaxstock').dataTable({
		dom: 'Bfrtip',
		paging : false,
		scrollY : 500,
        columnDefs: [
        {
            orderable: false,
            className: 'select-checkbox',
			targets: 1,
        }
        ],
        buttons: [{
            extend: 'excel',
            title: 'Min Max Stock Gudang Sparepart',
            exportOptions: {
            columns: ':visible',
            // rows: ':visible',
            modifier: {
                    selected: true,
            },
            columns: [0, 2, 3, 4, 5, 6],

		},
        }        
    
    ],
    select: {
            style: 'multi',
            selector: 'td:nth-child(2)'
    },
     order: [[0, 'asc']]
    });


    $('#check_semua').click(function(){
		var cek = $('#tandacek').val();
        // console.log('hahahahaha');
      if(cek == 'cek') {
		  $('#tandacek').val('uncek');
		  $('#cekall').removeClass('fa-square-o').addClass('fa-check-square-o');
		  $('.haha').addClass('selected');
		  $('#export2').css('display', '');
		  $('#exportminmaxstock').css('display', 'none');
      } else {
		  $('#tandacek').val('cek');
		  $('#cekall').removeClass('fa-check-square-o').addClass('fa-square-o');
		  $('.haha').removeClass('selected');
		  $('#exportminmaxstock').css('display', '');
		  $('#export2').css('display', 'none');
      }
    });
});


function hover1() {
	$(".gambar").css("box-shadow","-5px 5px 10px -3px #367da6");
}
function hover2() {
	$(".gambar").css("box-shadow","");
}