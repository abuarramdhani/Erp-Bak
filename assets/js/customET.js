$(document).ready(function(){
	var tableJp = $('.et_jenis_penilaian').DataTable();

	$('.tbl_et_rekap').DataTable({
		"scrollX": true
	});

	$('.et_select_jp').select2({
		ajax:
		{
			url: baseurl+'EvaluasiTIMS/Setup/getPenilaian',
			dataType: 'json',
			type: 'get',
			data: function (params) {
				return {s: params.term};
			},
			processResults: function (data) {
				return {
					results: $.map(data, function (item) {
						return {
							id: item.id_jenis,
							text: item.jenis_penilaian,
						}
					})
				};
			},
			cache: true
		},
		placeholder: 'Pilih penilaian',
		allowClear: true,
	});

	$('.et_select_jp').change(function(){
		var s = $(this).val();
		$.ajax({
			type: 'POST',
			url: baseurl+'EvaluasiTIMS/Setup/getPenilaian2',
			data: {s:s},
			success: function(response){
				response = JSON.parse(response);
				// alert(response[0].created_by);
				$('#et_input_t').val(response[0].std_t)
				$('#et_input_tim').val(response[0].std_tim)
				$('#et_input_tims').val(response[0].std_tims)
			}
		});

		$('.bt_et_harian').attr('disabled', false);
	})

	$('input[name*=et_rd_le]').on('ifChecked', function(){
		$('.btn_et_el').prop('disabled', false);
	});

	$('.bt_et_harian').click(function(){
		$('#surat-loading').attr('hidden', false);
	});
});