$(document).ready(function(){
	// $('.select2').select2({
	// 	allowClear : true,
	// });

	$('#dateLS').datepicker({
		todayHighlight: true,
	});

	$('.dateICT').datepicker({
		todayHighlight: true,
		format: 'dd/mm/yyyy',
	});

	// $("#formInputMon").hide();
	$("#btnInputMon").show();

	$('#btnInputMon').click(function(){
	$("#formInputMon").slideToggle();
	});


	$('#tbldaily').dataTable();
	$('#tblmonthly').dataTable();
	$('#tblweekly').dataTable();
	$('#tblHasilMnt').dataTable();

	$('.ict-lokasi').select2({
	allowClear: false,
	searching: true,
	placeholder: "Pilih Lokasi",
	ajax: 
	{
		url: baseurl+'MonitoringICT/DataServer/cek_lokasi',
		dataType: 'json',
		type: 'GET',
		delay: 500,
		data: function (params){
			return {
				term: params.term,
			}
		},
		processResults: function(data) {
			return {
				results: $.map(data, function(obj){
					return {id: obj.sc_ruang_server_id, text: obj.sc_ruang_server_id+" - "+obj.ruang_server_name};
				})
			};
		}
	}
});

});

function btnInpMont(){
  $("#formInputMon").slideToggle();
}

function ajaxGetHasil(th, base){
	var limit = $(th).val();
	var perangkat = $(th).closest('div').find('input[name="perangkatID"]').val();
	var baseUrl = base;
	var request = $.ajax ({
        url : baseUrl+"MonitoringICT/JobListMonitoring/searchHasil",
        data : {
        	limit : limit,
        	perangkat : perangkat
        },
        type : "POST",
        dataType: "html"
    });
	$('#hasil').html("<center><img id='loading' style='margin-top: 2%; ' src='"+baseUrl+"assets/img/gif/loading5.gif'/><p style='color:#575555;'>Searching Data</p></center><br />");
    request.done(function(output) {
		window.setTimeout(function(){
			$('#hasil').html('');
			$('#hasil').html(output);
		}, 1000);
    });
}

$(document).ready(function() {
  $('#tb_ictserver').DataTable( {
    "pagingType": "full_numbers"
  } );
} );