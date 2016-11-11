$(document).ready(function() {
		var base = $('#txtBaseUrl').val();
		var org_id = $('#txtOrgId').val();
		
		//-------------- confirm ---------------------------
		var deleteLinks = document.querySelectorAll('.confirm');

		for (var i = 0; i < deleteLinks.length; i++) {
		  deleteLinks[i].addEventListener('click', function(event) {
			  event.preventDefault();

			  var choice = confirm(this.getAttribute('data-confirm'));

			  if (choice) {
				window.location.href = this.getAttribute('href');
			  }
		  });
		}
		
		
		// document.querySelectorAll('form#frmDeleteAsset #btnDeleteAssets').onclick= function() {return confirm('Delete All Shown Assets?')};
		
		//-------------- confirm ---------------------------
		
		$('input#txtBppbaDate').datepicker({
			autoclose: true,
		});
		$('input#txtLpaDate').datepicker({
			autoclose: true,
		});
		$('input#txtTransferDate').datepicker({
			autoclose: true,
		});
		$('input#txtRetirementDate').datepicker({
			autoclose: true,
		});
		$('input#txtAddByDate').datepicker({
			autoclose: true,
		});
		$('input#txtUploadOracleDate').datepicker({
			autoclose: true,
		});
		
		// $( "#frmDataAsset  #txtAssetValue" ).keyup(function() {
			
			// var x = $('#txtAssetValue').val(), pattern = /\B(?=(\d{3})+(?!\d))/g;
			
			// var parts = x.toString().split(".");
			// parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
			// var y = parts.join(".");
			// $('#txtAssetValue').val(y);
			// alert(y);
		// });
		
		$('#txtAssetValue').number( true, 2 );//customd/jquery-number
		
		$("#frmDataAsset input#txtTagNumber").change(function(){
			var tag = $('#txtTagNumber').val();
			var id_asset = $('#hdnTemp').val() || "0";
			var returnedValue;
			var url = base+"FixedAsset/DataAssets/GetTagNumberInfo";
			// alert(url);
			
		   $.ajax({
				type: "POST",
				url: url,
				data: {term : tag,id : id_asset}, 
				cache: false,

				success: function(result) { //just add the result as argument in success anonymous function
				   //$('#txtDescription').val(result) ;
				   if(result === 'DANGER'){
						$('input#txtTagNumber').val('');
						// event.preventDefault();
						alert('Duplicate Tag Number');
					}/*else{
						alert(result);
					}*/
					// alert(result);
				}
			});
		});
		
		$("#frmDataAsset input#txtOldNumber").change(function(){
			var tag = $('#txtOldNumber').val();
			var id_asset = $('#hdnTemp').val() || "0";
			var returnedValue;
			var url = base+"FixedAsset/DataAssets/GetOldNumberInfo";
			// alert(url);
			
		   $.ajax({
				type: "POST",
				url: url,
				data: {term : tag,id : id_asset}, 
				cache: false,

				success: function(result) { //just add the result as argument in success anonymous function
				   //$('#txtDescription').val(result) ;
				   if(result === 'DANGER'){
						$('input#txtOldNumber').val('');
						// event.preventDefault();
						alert('Duplicate Tag Number');
					}/*else{
						alert(result);
					}*/
					// alert(result);
				}
			});
		});
		
		$("#frmDataAsset").submit(function(event){
			event.preventDefault();
			var tag = $('#txtTagNumber').val();
			var old = $('#txtOldNumber').val();
			var id_asset = $('#hdnTemp').val() || "0";
			var form = this;
			var url = base+"FixedAsset/DataAssets/CheckDuplicateAll";
			
		   $.ajax({
				type: "POST",
				url: url,
				data: {tag : tag,old : old,id : id_asset}, 
				cache: false,

				success: function(result) { //just add the result as argument in success anonymous function
				   //$('#txtDescription').val(result) ;
				   if(result !== 'DANGER'){
						form.submit();
					}
					 // alert(result);
				}
			});
		});
		
		$('.jsTagNumber').autocomplete({
				source: function(request, response) {
					$.ajax({
							url: base+"FixedAsset/DataAssets/GetTagNumber",
							dataType: "json",
							data: {
								// term : $("#slcLocation").val()
								term : request.term
							},
							success: function(data) {
								response(data);
							}
						});
				},
				// min_length: 2
		});
		
		
		
		$('.jsLocation').autocomplete({
				source: function(request, response) {
					$.ajax({
							url: base+"FixedAsset/DataAssets/GetLocation",
							dataType: "json",
							data: {
								// term : $("#slcLocation").val()
								term : request.term
							},
							success: function(data) {
								response(data);
							}
						});
				},
				// min_length: 2
		});
		
		$('.jsAssetCategory').autocomplete({
				source: function(request, response) {
					$.ajax({
							url: base+"FixedAsset/DataAssets/GetAssetCategory",
							dataType: "json",
							data: {
								// term : $("#slcLocation").val()
								term : request.term
							},
							success: function(data) {
								response(data);
							}
						});
				},
				// min_length: 2
		});
				
		$('.jsItemCode').autocomplete({
				source: function(request, response) {
					$.ajax({
							url: base+"FixedAsset/DataAssets/GetItemCode",
							dataType: "json",
							data: {
								// term : $("#slcLocation").val()
								term : request.term
							},
							success: function(data) {
								response(data);
							}
						});
				},
				// min_length: 2
		});
				
		$('.jsSpecification').autocomplete({
				source: function(request, response) {
					$.ajax({
							url: base+"FixedAsset/DataAssets/GetSpecification",
							dataType: "json",
							data: {
								// term : $("#slcLocation").val()
								term : request.term
							},
							success: function(data) {
								response(data);
							}
						});
				},
		});
		
		$('.jsBppbaNumber').autocomplete({
				source: function(request, response) {
					$.ajax({
							url: base+"FixedAsset/DataAssets/GetBppbaNumber",
							dataType: "json",
							data: {
								// term : $("#slcLocation").val()
								term : request.term
							},
							success: function(data) {
								response(data);
							}
						});
				},
		});
		
		$('.jsLpaNumber').autocomplete({
				source: function(request, response) {
					$.ajax({
							url: base+"FixedAsset/DataAssets/GetLpaNumber",
							dataType: "json",
							data: {
								// term : $("#slcLocation").val()
								term : request.term
							},
							success: function(data) {
								response(data);
							}
						});
				},
		});
		
		$('.jsTransferNumber').autocomplete({
				source: function(request, response) {
					$.ajax({
							url: base+"FixedAsset/DataAssets/GetTransferNumber",
							dataType: "json",
							data: {
								// term : $("#slcLocation").val()
								term : request.term
							},
							success: function(data) {
								response(data);
							}
						});
				},
		});
		
		$('.jsRetirementNumber').autocomplete({
				source: function(request, response) {
					$.ajax({
							url: base+"FixedAsset/DataAssets/GetRetirementNumber",
							dataType: "json",
							data: {
								// term : $("#slcLocation").val()
								term : request.term
							},
							success: function(data) {
								response(data);
							}
						});
				},
		});
				
		$('.jsPpNumber').autocomplete({
				source: function(request, response) {
					$.ajax({
							url: base+"FixedAsset/DataAssets/GetPpNumber",
							dataType: "json",
							data: {
								// term : $("#slcLocation").val()
								term : request.term
							},
							success: function(data) {
								response(data);
							}
						});
				},
		});
		
		$('.jsPoNumber').autocomplete({
				source: function(request, response) {
					$.ajax({
							url: base+"FixedAsset/DataAssets/GetPoNumber",
							dataType: "json",
							data: {
								// term : $("#slcLocation").val()
								term : request.term
							},
							success: function(data) {
								response(data);
							}
						});
				},
		});
		
		$('.jsPrNumber').autocomplete({
				source: function(request, response) {
					$.ajax({
							url: base+"FixedAsset/DataAssets/GetPrNumber",
							dataType: "json",
							data: {
								// term : $("#slcLocation").val()
								term : request.term
							},
							success: function(data) {
								response(data);
							}
						});
				},
		});
		
		$(".jsUploadOracle").select2({
		// tags: true,
		//var cust_id = $('input#hdnTransferNumber').val();
		placeholder: "Upload Oracle",
		allowClear : true,
		minimumInputLength: 0,
		ajax: {		
					url: base+"FixedAsset/DataAssets/GetUploadOracle",
					dataType: 'json',
					type: "GET",
					data: function (params) {

						var queryParameters = {
							term: params.term
							// cust: $('input#hdnCustomerId').val(),
							// type: $('select#slcUploadOracle').val()
						}
						return queryParameters;
					},
					processResults: function (data) {
						return {
							results: $.map(data, function(obj) {
								return { id:obj.NAME, text:obj.NAME};
							})
						};
					}
			}

		});
		
		$('#dataAssetdataTables').DataTable({
		   // "paging": true,
          // "lengthChange": true,
          // "searching": true,
          // "ordering": true,
          // "info": true,
          // "autoWidth": false,
		"processing": true,
		"serverSide": true,
        "ajax": base+"FixedAsset/DataAssets/LoadDataAsset",
		 "order": [[ 24, "desc" ]],
		"columnDefs": [
            { "targets": [ 0 ], "searchable": false },
            { "visible": false,  "targets": [ 1 ], "searchable": false }
        ],
		  dom: 'Blfrtip',
		  lengthMenu : [ 10, 25, 50, 75, 100, 500, 1000, 10000000 ],
			buttons: [
				'copy', 'csv', 'excel', 'pdf', 'print'
			]
		});
		
		
		$(".select4").select2({
			allowClear : false,
	});
		
});

document.getElementById('btnDeleteAssets').onclick= function() {return confirm('Delete All Shown Assets?')};

function ConfirmDelete() {
  return confirm("Are you sure you want to delete?");
}

function getBppbaDate(base){
	var bppba_number = $("select#slcBppbaNumber option:selected").attr('value');
	$.post(base+"DataAsset/getDateBppba", {id:bppba_number}, function(data){
		$("input#txtBppbaDate").val(data);
	})
}

function getLpaDate(base){
	var lpa_number = $("select#slcLpaNumber option:selected").attr('value');
	$.post(base+"DataAsset/getDateLpa", {id:lpa_number}, function(data){
		$("input#txtLpaDate").val(data);
	})
}

function getTransferDate(base){
	var transfer_number = $("select#slcTransferNumber option:selected").attr('value');
	$.post(base+"DataAsset/getDateTransfer", {id:transfer_number}, function(data){
		$("input#txtTransferDate").val(data);
	})
}

function getRetirementDate(base){
	var retirement_number = $("select#slcRetirementNumber option:selected").attr('value');
	$.post(base+"DataAsset/getDateRetirement", {id:retirement_number}, function(data){
		$("input#txtRetirementDate").val(data);
	})
}

function getAddByDate(base){
	var add_by = $("select#slcAddBy option:selected").attr('value');
	$.post(base+"DataAsset/getAddByDate", {id:add_by}, function(data){
		$("input#txtAddByDate").val(data);
	})
}

// function getDate(){
// alert("asdasd");
// var slcBppbaNumber = $("select#slcBppbaNumber option:selected").attr('value');
// $.post("http://localhost/AASR/C_AdminRecruitment/fullname", {slcbppbanumber:slcbppbanumber}, function(data){
// $('input#txtbppbadate').val(data);
// });
// $.post("http://localhost/AASR/C_AdminRecruitment/nickname", {no_ktp:no_ktp}, function(data){
// $('input#nickname').val(data);
// });
// };

// function getLocationDesc(base){
		// var id = $("select#txtLocation option:selected").attr('value');
		// if(id == ''){
			// $("#select2-txtLocationDesc-container").html("<span style='color:#999;'>Location Description</span>");
			// $("select#txtLocationDesc").prop("disabled", true);
			
		// }else{
			
			// $("#select2-txtLocationDesc-container").html("<span style='color:#999;'>Location Description</span>");
			// $("select#txtLocationDesc").prop("disabled", false);
			// $.post(base+"ajax/GetLocationDesc", {id:id}, function(data){
				// $("select#txtLocationDesc").html(data);
			// });
		// }
	// }