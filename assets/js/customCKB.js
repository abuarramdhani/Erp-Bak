$(document).ready(function () {
	$(".kompKartu").select2({
			allowClear: true,
			placeholder: "Nama Komponen",
			minimumInputLength: 3,
			ajax: {
					url: baseurl + "CetakKartuBody/Cetak/getKomponen",
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
											return {id:obj.PRODUK, text:obj.PRODUK};
									})
							};
					}
			}
	});
});

function getKartu(th) {
    var komponen = $('#kompKartu').val();
    var qty = $('#qty').val();
    var size = $('#sizekertas').val();

    var request = $.ajax({
        url : baseurl + "CetakKartuBody/Cetak/getData",
		data: { komponen : komponen, qty : qty, size : size},
		type : "POST",
		dataType: "html"
	})
	$('#tb_kartu').html('');
	$('#tb_kartu').html('<center><img style="width:130px; height:auto" src="'+baseurl+'assets/img/gif/loading10.gif"></center>' );
	request.done(function(result){
        $('#tb_kartu').html('');
        $('#tb_kartu').html(result);
        
        })
}

function getNoSerial(th) {
    var no_awal = $('input[name="nomors[]"]').map(function(){return $(this).val();}).get();
    var size = $('select[name="size[]"]').map(function(){return $(this).val();}).get();
    var namakomp = $('select[name="namakomp[]"]').map(function(){return $(this).val();}).get();
    // var no_akhir = $('#no_akhir').val();
	console.log(no_awal);
    var request = $.ajax({
        url : baseurl + "CetakKartuBody/Cetak/getData2",
		data: { no_awal : no_awal, size : size, namakomp : namakomp},
		type : "POST",
		dataType: "html"
	})
	$('#tb_kartu').html('');
	$('#tb_kartu').html('<center><img style="width:130px; height:auto" src="'+baseurl+'assets/img/gif/loading10.gif"></center>' );
	request.done(function(result){
        $('#tb_kartu').html('');
        $('#tb_kartu').html(result);
        
        })
}

$(document).ready(function () {
$('#ctk_baru').on('click',function() {
	$('#tablelagi').css('display', 'none');
	$('input[name="nomors[]"]').val('');
	$('select[name="size[]"]').select2("val", "");
	$('select[name="namakomp[]"]').select2("val", "");
})

$('#ctk_lagi').on('click',function() {
	$('#tablebaru').css('display', 'none');
	$('input[name="qty"]').val('');
	$('select[name="kompKartu"]').select2("val", "");
	$('select[name="sizekertas"]').select2("val", "");
})
});

function generateLagi(no) {
    var no_awal = $('#awal'+no).val();
    var no_akhir = $('#akhir'+no).val();
	var komponen = $('#komponen'+no).val();
	var size	= $('#size'+no).val();
	var qty	= $('#qty'+no).val();

    var request = $.ajax({
        url : baseurl + "CetakKartuBody/Cetak/generateLagi",
		data: { no_awal : no_awal, no_akhir : no_akhir, komponen : komponen, size : size, qty : qty},
		type : "POST",
		dataType: "html"
	})
}
