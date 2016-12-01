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
	});
//---------------------------------CLAIMS EXTERNAL.end---------------------------------