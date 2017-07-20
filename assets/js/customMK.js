$(document).ready(function() {
		var baseUrl = document.location.origin;
		
		// SELECT2 FUNCTION
		
		$(".select2-KompSubInventory").select2({
		allowClear: true,
		placeholder: "[Select Subinventory]",
		minimumInputLength: 0,
		ajax: {		
				url: baseUrl+"/erp/MonitoringKomponen/Monitoring/getSubinventory",
				dataType: 'json',
				tags : true,
				type: "GET",
				data: function (params) {
					var queryParameters = {
						term: params.term
					}
					return queryParameters; 
				},
				processResults: function (data) {
					return {
						results: $.map(data, function(obj) {
							return { id:obj.SECONDARY_INVENTORY_NAME, text:obj.SECONDARY_INVENTORY_NAME};
						})
					};
				}
			}
		});
		
		$('.select2-Sorting').select2({
			placeholder: "[Select Sorting Type]",
			minimumResultsForSearch: -1
		});
		
		$('.select2-JenisLap').select2({
			placeholder: "[Select Jenis Laporan]",
			minimumResultsForSearch: -1
		});
		
		$(".select2-KompAsalLocator").select2({
		allowClear: true,
		placeholder: "[Select Locator]",
		tags : true,
		minimumInputLength: 0,
		ajax: {		
				url: baseUrl+"/erp/MonitoringKomponen/Monitoring/getLocator",
				dataType: 'json',
				type: "GET",
				data: function (params) {
					var queryParameters = {
						term: params.term,
						subin: $('#txsAsalKomp').val()
					}
					return queryParameters; 
				},
				processResults: function (data) {
					return {
						results: $.map(data, function(obj) {
							return { id:obj.INVENTORY_LOCATION_ID, text:obj.SEGMENT1};
						})
					};
				}
			}
		});
		
		$(".select2-KompTujuanLocator").select2({
		allowClear: true,
		placeholder: "[Select Locator]",
		tags : true,
		minimumInputLength: 0,
		ajax: {		
				url: baseUrl+"/erp/MonitoringKomponen/Monitoring/getLocator",
				dataType: 'json',
				type: "GET",
				data: function (params) {
					var queryParameters = {
						term: params.term,
						subin: $('#txsTujuanSub').val()
					}
					return queryParameters; 
				},
				processResults: function (data) {
					return {
						results: $.map(data, function(obj) {
							return { id:obj.INVENTORY_LOCATION_ID, text:obj.SEGMENT1};
						})
					};
				}
			}
		});
		
		$(".select2-KodeKomponen").select2({
		allowClear: true,
		placeholder: "[Select Komponen]",
		minimumInputLength: 3,
		ajax: {		
				url: baseUrl+"/erp/MonitoringKomponen/Monitoring/getKomponen",
				dataType: 'json',
				type: "GET",
				data: function (params) {
					var queryParameters = {
						term: params.term
					}
					return queryParameters; 
				},
				processResults: function (data) {
					return {
						results: $.map(data, function(obj) {
							var segment = obj.SEGMENT1; 
							var desc = obj.DESCRIPTION;
							return { id:segment, text:segment};
							alert('test');
						})
					};
				}
			}
		});
		
		//CHANGE FUNCTION 
		$('#txsAsalKomp').change(function(){
			$("#txsAsalLocator").select2("val", "");
		});
		
		$('#txsKodeKomp').change(function(){
			var kode = $('#txsKodeKomp').val();
				$.post(baseUrl+"/erp/MonitoringKomponen/Monitoring/getNamaKomponen", {kode:kode}, function(data){
				$("#txtNamaKomponen").val(data);	
			});
		});
		
		// BUTTON Function
		$('#submit-filter-komponen').click(function(){
			$('.alert').alert('close');
			$('body').addClass('noscroll');
			$('#loadingAjax').addClass('overlay_loading');
			$('#loadingAjax').html('<div class="pace pace-active"><div class="pace-progress" style="height:100px;width:80px" data-progress="100"><div class="pace-progress-inner"></div></div><div class="pace-activity"></div></div>');
				
				var date = $('#txtTanggal').val();
				var subinv_from = $('#txsAsalKomp').val();
				var subinv_to = $('#txsTujuanSub').val();
				var locator_from = $('#txsAsalLocator').val();
				var locator_to = $('#txsTujuanLocator').val();
				var kode = $('#txsKodeKomp').val();
				var name = $('#txtNamaKomponen').val();
				var sort = $('#txsSort').val();
				var report = $('#txsJenisLaporan').val();
				var nm_date = new Date(date);
				var new_date = nm_date.getDate() + '/' + nm_date.getMonth() + '/' +  nm_date.getFullYear();
				 $('#table_kirim_komponen').DataTable({
						  "paging": true,
						  "lengthChange": false,
						  "searching": true,
						  "ordering": true,
						  "info": true,
						  "autoWidth": true,
						  "ajax": {
										"url" : baseUrl+'/erp/MonitoringKomponen/MonitoringSeksi/tableView',
										"type": "POST",
										"data": {
													date : date,
													subinv_from : subinv_from,
													subinv_to : subinv_to ,
													locator_from : locator_from ,
													locator_to : locator_to ,
													kode : kode ,
													name : name ,
													sort : sort ,
													report : report
												}
									},
						  "columnDefs": [
											{ className: "text-center", "targets": [ 0 ] },
											{ className: "text-center", "targets": [ 1 ] },
											{ className: "text-center", "targets": [ 3 ] },
											{ className: "text-center", "targets": [ 4 ] },
											{ className: "text-center", "targets": [ 5 ] },
											{ className: "text-center", "targets": [ 6 ] },
											{ className: "text-center", "targets": [ 7 ] },
											{ className: "text-center", "targets": [ 8 ] },
											{ className: "text-center", "targets": [ 9 ] },
											{ className: "text-center", "targets": [ 10 ] },
											{ className: "text-center", "targets": [ 11 ] }
										],
						dom: 'Bfrtip',
						buttons: [
							'copy',  
							{
								extend: 'csv',
								title: 'kirim_komp'+new_date
								  
							}, 
							'excel', 'pdf', 'print'
						]			
					});
				
				$('.row2').hide();
				$('.row3').show();
			$('body').removeClass('noscroll');
			$('#loadingAjax').html('');
			$('#loadingAjax').removeClass('overlay_loading');
		}); 
		
		$('#destroy_datatable').click(function(){
			var table = $('#table_kirim_komponen').DataTable();
			table.destroy();
			$('.row2').show();
			$('.row3').hide();
		});
		
		
		//+++++++++++++++++++++++++++++++++++++++++
		//         KAPASITAS SIMPAN GUDANG
		//+++++++++++++++++++++++++++++++++++++++++
		
		$('#search_kapasitas_simpan').click(function(){
			$('.alert').alert('close');
			$('body').addClass('noscroll');
			$('#loadingAjax').addClass('overlay_loading');
			$('#loadingAjax').html('<div class="pace pace-active"><div class="pace-progress" style="height:100px;width:80px" data-progress="100"><div class="pace-progress-inner"></div></div><div class="pace-activity"></div></div>');
				
				var date = $('#txtTanggal').val();
				var subinv_from = $('#txsAsalKomp').val();
				var subinv_to = $('#txsTujuanSub').val();
				var locator_from = $('#txsAsalLocator').val();
				var locator_to = $('#txsTujuanLocator').val();
				var kode = $('#txsKodeKomp').val();
				var name = $('#txtNamaKomponen').val();
				var sort = $('#txsSort').val();
				var report = $('#txsJenisLaporan').val();
				
				 $('#table_kirim_komponen').DataTable({
						  "paging": true,
						  "lengthChange": false,
						  "searching": true,
						  "ordering": true,
						  "info": true,
						  "autoWidth": true,
						  "ajax": {
										"url" : baseUrl+'/erp/MonitoringKomponen/Monitoring/tableView',
										"type": "POST",
										"data": {
													date : date,
													subinv_from : subinv_from,
													subinv_to : subinv_to ,
													locator_from : locator_from ,
													locator_to : locator_to ,
													kode : kode ,
													name : name ,
													sort : sort ,
													report : report
												}
									},
						  "columnDefs": [
											{ className: "text-center", "targets": [ 0 ] },
											{ className: "text-center", "targets": [ 1 ] },
											{ className: "text-center", "targets": [ 3 ] },
											{ className: "text-center", "targets": [ 4 ] },
											{ className: "text-center", "targets": [ 5 ] },
											{ className: "text-center", "targets": [ 6 ] },
											{ className: "text-center", "targets": [ 7 ] },
											{ className: "text-center", "targets": [ 8 ] },
											{ className: "text-center", "targets": [ 9 ] },
											{ className: "text-center", "targets": [ 10 ] },
											{ className: "text-center", "targets": [ 11 ] }
										],
						dom: 'Bfrtip',
						buttons: [
							'copy',  {
										extend: 'csv',
										title: 'simpan_gd_'
									}, 'excel', 'pdf', 'print'
												],
						initComplete : function( settings, json ) {
							$('.row2').hide();
							$('.row3').show();
						  }
					});
			$('body').removeClass('noscroll');
			$('#loadingAjax').html('');
			$('#loadingAjax').removeClass('overlay_loading');
		}); 
});
