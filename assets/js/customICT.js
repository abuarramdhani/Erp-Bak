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
	$.fn.delayKeyup = function(callback, ms){
		var timer = 0;
		var el = $(this);
		$(this).keyup(function(){                   
			clearTimeout (timer);
			timer = setTimeout(function(){
				callback(el)
			}, ms);
		});
		return $(this);
	};
	$('#monitoringict-ipaddress').delayKeyup(function(){
		var text = document.getElementById("monitoringict-ipaddress").value;
		if (text.match(/^([0-9]{1,3}\.){3}[0-9]{1,3}$/)) {
        	// document.getElementById("result").textContent = "Terlihat bagus";
        	// $('#result').addClass('glyphicon-ok');
        	// $('#result').addClass('green');
        	// $('#result').removeClass('red');
        	// $('#result').removeClass('glyphicon-remove');
        	// $('#result').removeClass('icon-question-sign');

        	$('#ict-stat1').addClass('has-success');
        	$('#ict-stat2').addClass('glyphicon-ok');
        	$('#ict-stat1').removeClass('has-error');
        	$('#ict-stat2').removeClass('glyphicon-remove');
        	document.getElementById("ict-stat1").setAttribute("data-original-title", "Terlihat Bagus");
        	// document.getElementById("ict-stat1").removeAttribute("title", "Format IP Address Salah");data-original-title
        }else{
        	// document.getElementById("result").textContent = "Format IP Address salah";
        	// $('#result').addClass('glyphicon-remove');
        	// $('#result').addClass('red');
        	// $('#result').removeClass('green');
        	// $('#result').removeClass('glyphicon-ok');
        	// $('#result').removeClass('icon-question-sign');

        	$('#ict-stat1').removeClass('has-success');
        	$('#ict-stat2').removeClass('glyphicon-ok');
        	$('#ict-stat1').addClass('has-error');
        	$('#ict-stat2').addClass('glyphicon-remove');
        	document.getElementById("ict-stat1").setAttribute("data-original-title", "Format IP Address Salah");
        	// document.getElementById("ict-stat1").removeAttribute("title", "Terlihat Bagus");
        	// document.getElementById("icta").setAttribute("title", "Terlihat Bagus");

        }
    },1000);

    $('#monitoringict-hostname').delayKeyup(function(){
		var text = document.getElementById("monitoringict-hostname").value;
		if (text.match(/^([a-zA-Z0-9]([a-zA-Z0-9\-]{0,61}[a-zA-Z0-9])?\.)+[a-zA-Z]{2,6}$/)) {
        	// document.getElementById("result").textContent = "Terlihat bagus";
        	// $('#result').addClass('glyphicon-ok');
        	// $('#result').addClass('green');
        	// $('#result').removeClass('red');
        	// $('#result').removeClass('glyphicon-remove');
        	// $('#result').removeClass('icon-question-sign');

        	$('#ict-host').addClass('has-success');
        	$('#ict-host-span').addClass('glyphicon-ok');
        	$('#ict-host').removeClass('has-error');
        	$('#ict-host-span').removeClass('glyphicon-remove');
        	document.getElementById("ict-host").setAttribute("data-original-title", "Terlihat Bagus");
        	// document.getElementById("ict-stat1").removeAttribute("title", "Format IP Address Salah");data-original-title
        }else{
        	// document.getElementById("result").textContent = "Format IP Address salah";
        	// $('#result').addClass('glyphicon-remove');
        	// $('#result').addClass('red');
        	// $('#result').removeClass('green');
        	// $('#result').removeClass('glyphicon-ok');
        	// $('#result').removeClass('icon-question-sign');

        	$('#ict-host').removeClass('has-success');
        	$('#ict-host-span').removeClass('glyphicon-ok');
        	$('#ict-host').addClass('has-error');
        	$('#ict-host-span').addClass('glyphicon-remove');
        	document.getElementById("ict-host").setAttribute("data-original-title", "invalid hostname");
        	// document.getElementById("ict-stat1").removeAttribute("title", "Terlihat Bagus");
        	// document.getElementById("icta").setAttribute("title", "Terlihat Bagus");

        }
    },1000);
	if (window.innerWidth < 1200) {
				// alert(window.innerWidth);
				// document.getElementById("lebar").setAttribute("align", "center");
				// document.getElementById("lebar").removeAttribute("align", "left");
			}
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