	$('#id_vbca').click(function(){
		$('#loading_quick').html("<center><img id='loading99' style='margin-top: 2%;' src='"+baseurl+"assets/img/gif/loading99.gif'/><br /></center><br />");
		var number = $('#no_vabca').val();
		
		$.ajax({
			type: "POST",
			url: baseurl+"VBTokoQuick/Dashboard/proses",
			data: {
				number:number
			},
			success: function (response) {
				$('#loading_quick').html(response);
				$('#tb_quick').DataTable({
					"paging": true,
					"info":     false,
					"language" : {
						"zeroRecords": " "             
					},
				});
			}
		});
	})


	