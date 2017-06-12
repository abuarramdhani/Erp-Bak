//---------------------------------Account Receivables.begin---------------------------------
	$(document).ready(function() {
		$('#creditLimit').DataTable({
			"aoColumns": [ 
			null,
			null,
			null,
			null,
			null,
			null,
				{ "bSortable": false,
					"bVisible": true }, //action column
			],
		});
		//-----------BAGIAN INPUT DATA------------------
		$('#CustNameCL').change(function(){
			var value = $('select#CustNameCL option:selected').attr('value');
			$.ajax({
				type:'POST',
				data:{data_name:value},
				url:baseurl+"AccountReceivables/CreditLimit/New/Cust",
				success:function(result)
				{
					$('#CustAccountID').val(result);
				}
			})
		});

		$('#CustNameCL').change(function(){
			var value = $('select#CustNameCL option:selected').attr('value');
			$.ajax({
				type:'POST',
				data:{data_name:value},
				url:baseurl+"AccountReceivables/CreditLimit/New/Account",
				success:function(result)
				{
					$('#AccountNumber').val(result);
				}
			})
		});

		$('#CustNameCL').change(function(){
			var value = $('select#CustNameCL option:selected').attr('value');
			$.ajax({
				type:'POST',
				data:{data_name:value},
				url:baseurl+"AccountReceivables/CreditLimit/New/PartyID",
				success:function(result)
				{
					$('#PartyID').val(result);
				}
			})
		});

		$('#CustNameCL').change(function(){
			var value = $('select#CustNameCL option:selected').attr('value');
			$.ajax({
				type:'POST',
				data:{data_name:value},
				url:baseurl+"AccountReceivables/CreditLimit/New/PartyNumber",
				success:function(result)
				{
					$('#PartyNumber').val(result);
				}
			})
		});

		$('#BranchCL').change(function(){
			var value = $('select#BranchCL option:selected').attr('value');
			$.ajax({
				type:'POST',
				data:{data_name:value},
				url:baseurl+"AccountReceivables/CreditLimit/New/Branch",
				success:function(result)
				{
					$('#CustNameCL').prop('disabled',false).html(result);
				}
			})
		});

		$('#Expireds').daterangepicker({
				"singleDatePicker": true,
				"timePicker": true,
				"timePicker24Hour": true,
				"showDropdowns": false,
				locale: {
						format: 'DD-MMM-YYYY HH:mm:ss'
					},
			}).val('');

		$('#Expired').datepicker({
				format: 'dd-M-yyyy'
			});
	});
//---------------------------------Account Receivables.end---------------------------------
