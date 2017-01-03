//---------------------------------CLAIMS EXTERNAL.begin-------------------------------
	$(document).ready(function() {
		//--------------------------------DATA TABLE-------------------------------------
		function datatable(){
			$('#tbNewClaim').DataTable({
				"aoColumns": [ 
				null, // id
				null, // product
				null, // another column
				null, // another column
				null, // another column
				{ "bSortable": false,
					"bVisible": true }, //action column
			],
			});
			$('#tbClosedClaim').DataTable({
				"aoColumns": [ 
				null, // id
				null, // product
				null, // another column
				null, // another column
				null, // another column
				{ "bSortable": false,
					"bVisible": true }, //action column
			],
			});
			$('#tbOverClaim').DataTable({
				"aoColumns": [ 
				null, // id
				null, // product
				null, // another column
				null, // another column
				null, // another column
				{ "bSortable": false,
					"bVisible": true }, //action column
			],
			});
			$('#tbApprovedClaim').DataTable({
				"aoColumns": [ 
				null, // id
				null, // product
				null, // another column
				null, // another column
				null, // another column
				{ "bSortable": false,
					"bVisible": true }, //action column
			],
			});
		};
		//--------------------------------JAVASCRIPT OnCLICK-------------------------------------
		$('#newClaims').click(function(){
			$.ajax({
				url:baseurl+"SalesOrder/BranchApproval/NewClaims",
				success:function(result)
				{
					$('#showClaimsData').html(result);
					datatable();
				}
			})
		});
		$('#claimApproved').click(function(){
			$.ajax({
				url:baseurl+"SalesOrder/BranchApproval/ClaimApproved",
				success:function(result)
				{
					$('#showClaimsData').html(result);
					datatable();
				}
			})
		});
		$('#centralApproved').click(function(){
			$.ajax({
				url:baseurl+"SalesOrder/CentralApproval/ClaimApproved",
				success:function(result)
				{
					$('#showClaimsData').html(result);
					datatable();
				}
			})
		});
		$('#over24Hour').click(function(){
			$.ajax({
				url:baseurl+"SalesOrder/BranchApproval/Over24Hour",
				success:function(result)
				{
					$('#showClaimsData').html(result);
					datatable();
				}
			})
		});
		$('#ClaimClosed').click(function(){
			$.ajax({
				url:baseurl+"SalesOrder/BranchApproval/ClaimClosed",
				success:function(result)
				{
					$('#showClaimsData').html(result);
					datatable();
				}
			})
		});
		
		$('#provinceIncident').change(function(){
			var value = $('#provinceIncident').val();
			$.ajax({
				type:'POST',
				data:{data_name:value,modul:'CityRegency'},
				url:baseurl+"CustomerRelationship/ServiceProducts/Location",
				success:function(result)
				{
					$('#CityIncident').prop('disabled',false).html(result);
				}
			});
		});
		$('#CityIncident').change(function(){
			var value = $('#CityIncident').val();
			$.ajax({
				type:'POST',
				data:{data_name:value,modul:'District'},
				url:baseurl+"CustomerRelationship/ServiceProducts/Location",
				success:function(result)
				{
					$('#DistrictIncident').prop('disabled',false).html(result);
				}
			});
		});
		$('#DistrictIncident').change(function(){
			var value = $('#DistrictIncident').val();
			$.ajax({
				type:'POST',
				data:{data_name:value,modul:'Village'},
				url:baseurl+"CustomerRelationship/ServiceProducts/Location",
				success:function(result)
				{
					$('#VillageIncident').prop('disabled',false).html(result);
				}
			});
		});
		function datepick(){
			$('#sentDate').daterangepicker({
				"singleDatePicker": true,
				"timePicker": true,
				"timePicker24Hour": true,
				"showDropdowns": false,
				locale: {
						format: 'YYYY-MM-DD HH:mm:ss'
					},
			});
		};
		$('#claimsItem1').click(function(){
			$.ajax({
				url:baseurl+"CustomerRelationship/ServiceProducts/shipped",
				success:function(result)
				{
					$('#showClaimsItem').html(result);
					datepick();
				}
			})
		});
		$('#claimsItem2').click(function(){
			$('#loadAjax').show();
			document.getElementById("showClaimsItem").innerHTML = '<div class="form-group"><label>Reason Can Not be Sent</label><input type="text" class="form-control" name="reason" placeholder="Reason Can Not be Sent" data-toggle="tooltip" data-placement="top" title="Masukkan alasan barang tidak dapat dikirim" required></div>';
		});
		$('#claimsItem3').click(function(){
			$('#loadAjax').show();
			document.getElementById("showClaimsItem").innerHTML = '<p style="text-align:center;"><strong>- No Evidence for The Claim -</strong></p>';
		});
		$('#start').datepicker({
			autoclose: true,
			format: 'yyyy-mm-dd'
		});
		$('#end').datepicker({
			autoclose: true,
			format: 'yyyy-mm-dd'
		});
		/*$('#slcBranchApproval').change(function(){
			var value = $('#slcBranchApproval').val();
			$.ajax({
				type:'POST',
				data:{'value':value},
				url:baseurl+"CustomerRelationship/Setting/ApprovalClaim/Employee",
				success:function(result)
				{
					$('#slcEmployeeApproval').prop('disabled',false).html(result);
				}
			});
		});*/
	});
//---------------------------------CLAIMS EXTERNAL.end---------------------------------