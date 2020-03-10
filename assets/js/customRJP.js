$(document).ready(function(){
	$('#rjpTglRekap').daterangepicker({
		"singleDatePicker": true,
		"showDropdowns": true,
		locale: {
			format: 'YYYY-MM-DD'
		},
	});

	$('#rjp_Sub').on('click', function(){
		var cek = cekValidasiRjp();//cek apakah form sudah terisi dengan benar
		if (cek === 'gagal')//kalo gak benar stop it
			return false;

		let a = $('#filter-rekap').serialize();
		var x = 0;
		fakeLoading(0);
		$.ajax({
			url: baseurl + 'RekapJenisPekerjaan/Rekap/getRjp',
			type: "post",
			data: a,
			success: function (response) {
				$('#rjpTbl').html(response);
				init2();
				fakeLoading(1);
			},
			error: function(jqXHR, textStatus, errorThrown) {
				console.log(textStatus, errorThrown);
			}
		});
		// var x = 0, y = 1;
		// $('#surat-loading').attr('hidden', false);
		// showLoding(x, y);
	});
});

function showLoding(x, y)
{
	x = 10 * y
	$('.rjpProgres').css('width', x+'%')
}

function init2()
{
	var tglRe = $('#rjpTglRe').val();
	$('.rjp_tbl').DataTable({
		"scrollX": true,
		fixedColumns:   {
            leftColumns: 3,
        },
		dom: 'Bfrtip',
        buttons: [
        	{
                extend: 'print',
                filename: 'Rekap Jenis Pekerja per Tanggal '+tglRe,
                title: 'Rekap Jenis Pekerja per Tanggal '+tglRe,
                autoPrint: false
            },
            {
                extend: 'excel',
                filename: 'Rekap Jenis Pekerja per Tanggal '+tglRe,
                title: 'Rekap Jenis Pekerja per Tanggal '+tglRe
            }
        ]
	});

	$('html, body').animate({
        scrollTop: $("#rjp_sini").offset().top
    }, 2000);
}

function cekValidasiRjp()
{
	var tes = 'okey';
	$("select:not(:disabled)").each(function(){
		let v = $(this).val();
		if (v === null) {
			alert('Data Belum Lengkap');
			tes = 'gagal'
			return false;
		}
	});
	return tes;
}