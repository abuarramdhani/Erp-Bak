$(document).ready(function(){
  	$('.tabel_polashift').DataTable({
  		// "scrollY"			: true,
        "scrollX"			: true,
        "scrollCollapse"	: true,
        "fixedColumns":   {
            "leftColumns": 1,
            "leftColumns": 2,
        },
  	});
	$('#ImportPola-DaftarSeksi').select2({
        allowClear: false,
        placeholder: "Pilih Seksi",
        minimumInputLength: 3,
        ajax: {
            url: baseurl + 'PolaShiftSeksi/ImportPolaShift/daftar_seksi',
            dataType: 'json',
            delay: 500,
            type: "GET",
            data: function(params) {
                return {
                    term: params.term
                }
            },
            processResults: function(data) {
                return {
                    results: $.map(data, function(obj) {
                        return { id: obj.kodesie, text: obj.kodesie + ' - ' + obj.daftar_tseksi };
                    })
                };
            }
        }
    });

    $("input.importpola_periode").monthpicker({
	  changeYear:true,
	  dateFormat: 'yy-mm', });

	/*$(".monthPicker").focus(function () {
	  $(".ui-datepicker-calendar").remove();
	  $("#ui-datepicker-div").position({
	    my: "center top",
	    at: "center bottom",
	    of: $(this)
	  });
	});*/
});

