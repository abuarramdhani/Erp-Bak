$(document).ready(function(){

	$('.select-nama-prs').select2({
		ajax: {
		    url: baseurl+"Presensi/PresensiDL/get_js_pekerja",
		    dataType: 'json',
		    type: "get",
		    data: function (params) {
		      return { p: params.term };
		    },
		    processResults: function (data) {
		      return {
		        results: $.map(data, function (item) {
		          return {
		            id: item.noind,
		            text: item.noind+' - '+item.nama,
		          }
		        })
		      };
		    },
		    cache: true
		  },
	  minimumInputLength: 2,
	  allowClear: false,
	  placeholder: '[ pilih Nomor Induk / Nama ]',
	});

	$('.select-kodesie-prs').select2({
		ajax: {
		    url: baseurl+"Presensi/PresensiDL/get_js_seksi",
		    dataType: 'json',
		    type: "get",
		    data: function (params) {
		      return { p: params.term };
		    },
		    processResults: function (data) {
		      return {
		        results: $.map(data, function (item) {
		          return {
		            id: item.kodesie,
		            text: item.kodesie+' - '+item.seksi,
		          }
		        })
		      };
		    },
		    cache: true
		  },
	  minimumInputLength: 2,
	  allowClear: false,
	});

	$('.select-pencarian-prs').select2({
	  placeholder: '[ Pilih Tujuan Pencarian ]',
	  allowClear: false,
	});

	// $(document).on("change", "#idNoind_prs", function () {
	// 	 var noind_length = $(this).val();
	// 	$.ajax({
	//         type: "POST",
	//         url: baseurl+"Presensi/PresensiDL/seksi_disabled",
	//         data: ({ noind : noind_length}),
	//         dataType: "json",
	//         success: function(data) {
	//            $('.select-kodesie-prs').select2('data', {kodesie: data});
	//         },
	//         error: function() {
	//             alert('Not Found');
	//         }
	//     });
	// });

	$('.prs-table-presensi-dl').DataTable({
		searching: true,
		lengthChange: false,
	});

	$('#idPencarian_prs').change(function(){
		var CekMenu = $('#idPencarian_prs').val();

		if(CekMenu=='monitoring') {
			$('#idTglBerangkat_prs').attr('disabled','disabled');
		}else{
			$('#idTglBerangkat_prs').removeAttr('disabled','disabled');
		}
	});

});


