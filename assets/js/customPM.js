$(document).ready(function() {
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
	
	$(document).on("click", "#refreshRegPers", function () {
		   window.open('http://quick.com/aplikasi/cronjob/cronjob.fphrdkhs.php','_blank');
	});
	
	$(document).on("click", "#refreshFinger", function () {
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
		
	$('.ip_address').mask('099.099.099.099');
	//========================
	// END PRESENCE MANAGEMENT
	//========================
});