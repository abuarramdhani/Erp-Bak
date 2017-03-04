$(document).ready(function() {
	$("div#loading1").hide();
	$("div#loading2").hide();
	$("div#loading3").hide();
	$("div#loading4").hide();
	//========
	// JAVASCRIPT & JQUERY PRESENCE MANAGEMENT > PIC : ALFIAN AFIEF N
	//======== START
	$('#datatable-presensi-presence-management').dataTable({
	 "bLengthChange": false,
	 "ordering": false
	});
	
	$('#registered-presensi').dataTable({
	 "bLengthChange": false,
	 "ordering": false,
	 "scrollX": true
	});
	
	$('#confirm-delete').on('show.bs.modal', function(e) {
		$(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
	});
	
	$(document).on("click", ".modalmutation", function () {
		 var id = $(this).data('id');
		 var name = $(this).data('filter');
		 $(".modal-body #txtID").val(id);
		 $(".modal-body #txtNoind").text(id);
		 $(".modal-body #txtName").text(name);
	});
	
	$(document).on("click", ".btn-delete-finger", function () {
		alert('test');
	});
	
	$(document).on("click", ".modalcheckfinger", function () {
		 var id = $(this).data('id');
		 var name = $(this).data('filter');
		 $(".modal-body #txtID").val(id);
		 $(".modal-body #txtNoind").text(id);
		 $(".modal-body #txtName").text(name);
	});
	
	$(document).on("click", "#modaladd", function () {
		 var id = $(this).data('id');
		 $(".modal-body #txtID").val(id);
	});
	
	$(document).on("click", ".modalchangelocationname", function () {
		 var loc = $(this).data('filter');
		 var name = $(this).data('id');
		 $(".modal-body #txtLocation").val(loc);
		 $(".modal-body #txtName").val(name);
	});
	
	$(document).on("click", ".distribusi-presensi", function () {
		 var loc = $(this).data('filter');
		 var name = $(this).data('id');
		 $(".modal-body #txtLocation").val(loc);
		 $(".modal-body #txtName").val(name);
	});
	
	$(document).on("click", "#refreshRegPers", function () {
		   window.open('http://quick.com/aplikasi/cronjob/cronjob.fphrdkhs.php','_blank');
	});
	
	$(document).on("click", "#refreshFinger", function () {
		   window.open('http://quick.com/aplikasi/cronjob/cronjob.fpupdatefingerlocal.php','_blank');
	});
	
	$(document).on("click", "#updateFinger", function () {
		   window.open('http://quick.com/aplikasi/cronjob/cronjob.fpupdatefingerquickcom.php','_blank');
	});
	
	$(".select-presence").select2({
			allowClear: true,
			placeholder: "[ Select Noind or Name ]",
			minimumInputLength: 1,
			ajax: {
				url:baseurl+"PresenceManagement/Monitoring/JsonNoind",
				dataType: 'json',
				type: "GET",
				data: function (params) {
					var queryParameters = {
						term: params.term,
						loc : $("#txtLocation").val()
					}
					return queryParameters;
				},
				processResults: function (data) {
					return {
						results: $.map(data, function(obj) {
							return { id: obj.noind, text: obj.noind +" / "+ obj.nama.toUpperCase() };
						})
					};
				}
			}
		});
		
		$(".select-presence-section").select2({
			allowClear: true,
			placeholder: "[ Select Section or ID Section ]",
			minimumInputLength: 1,
			ajax: {
				url:baseurl+"PresenceManagement/Monitoring/JsonSection",
				dataType: 'json',
				type: "GET",
				data: function (params) {
					var queryParameters = {
						term: params.term,
						loc : $("#txtLocation").val()
					}
					return queryParameters;
				},
				processResults: function (data) {
					return {
						results: $.map(data, function(obj) {
							return { id: obj.kodesie, text: obj.kodesie +" / "+ obj.seksi.toUpperCase() };
						})
					};
				}
			}
		});
		
	
	//========================
	// END PRESENCE MANAGEMENT
	//========================
	setTimeout(function(){$(".alert").slideUp();}, 1000);
	
	$("#datatable-presensi tbody tr").each(function() {
		var con = $(this).find("#stat_con").html(); 
		if( con == "0"){
			$(this).find("#btn-reg-person").addClass("disabled");
			$(this).find("#btn-change-name").addClass("disabled");
		}
	});
	
	$(document).on("click", "#refresh-cronjob-hrd", function () {
		$.ajax({
			url 	: baseurl + 'PresenceManagement/Cronjob/CronjobRefreshDatabase',
			beforeSend	: function(){
									 $("#loading2").slideDown();
								   },
			complete		: function(){
									 $("#loading2").slideUp();
								   },
			success:  function (data) {
				alert(data);
			}
		});
	});
	
	$(document).on("click", "#update-section-cronjob-hrd", function () {
		$.ajax({
			url 	: baseurl + 'PresenceManagement/Cronjob/UpdateSection',
			beforeSend	: function(){
									 $("#loading3").slideDown();
								   },
			complete		: function(){
									 $("#loading3").slideUp();
								   },
			success:  function (data) {
				alert(data);
			}
		});
	});
	
	
	$('#fr_start').daterangepicker({
			"singleDatePicker": true,
			"timePicker": false,
			"timePicker24Hour": true,
			"showDropdowns": true,
			locale: {
					format: 'YYYY-MM-DD'
				},
		});
		
		$('#fr_end').daterangepicker({
			"singleDatePicker": true,
			"timePicker": false,
			"timePicker24Hour": true,
			"showDropdowns": true,
			locale: {
					format: 'YYYY-MM-DD'
				},
		});
		
		$(document).on("click", ".btn-distribute-presence", function () {
			var start	= $("input#fr_start").val();
			var end		= $("input#fr_end").val();
			if( start == '' || end == ''){
				alert('plesae complete your fill data !!!');
			}else{
				window.open("http://quick.com/aplikasi/cronjob/cronjob.fpfrontpresensimasuk_erp.php?start="+start+"&end="+end+"", '_blank');
			}
		});
		
		$(document).on("click", ".release_presence", function () {
			var start	= $("input#txtLoc").val();
			var end		= $("input#txtStart").val();
			var loc		= $("input#txtEnd").val();
			if( start == '' || end == ''){
				alert('plesae complete your fill data !!!');
			}else{
				window.open("http://localhost/cronjob/fingerprint/cronjob.frontpresensi.tpresensi.loc.php?start="+start+"&end="+end+"&loc="+loc+"", '_blank');
			}
		});
		
		$(document).on("click", "#execute-cronjob-hrd", function () {
				window.open("http://quick.com/aplikasi/cronjob/fingerprint/cronjob.presence.monitoring.php", '_blank');
		});
		
		$(document).on("click", "#update-fingercode", function () {
				window.open("http://quick.com/aplikasi/cronjob/cronjob.dbupdatefinger.php", '_blank');
		});
		
		var host	= window.location.origin;
		var url_loc	= host+"/erp/PresenceManagement/Monitoring";
		var url_mon	= window.location.href;
		if(url_mon == url_loc){
			setTimeout(function(){
				window.location.href = url_loc;
			  }, 60000);
		}
		
	// $(document).on("click", "a[href='"+baseurl+"PresenceManagement/Monitoring']", function () {
		// alert('test');
	// });
	
	$(document).on("click", ".btn-refresh-db", function () {
		$('#modal-loader').modal('show');
	});

});