function tampilTB(th)
{
	var slcNoBon = $('input[name="slcNoBon"]').val();

	var request = $.ajax({
		url: baseurl+'TransactBon/Transact/search/',
		data:{slcNoBon:slcNoBon
			},
		type: "POST",
		datatype: 'html', 
	});
		$('#ResultMonitoring').html('');
		$('#ResultMonitoring').html('<center><img style="width:130px; height:auto" src="'+baseurl+'assets/img/gif/loading10.gif"></center>' );
	
		request.done(function(result){
			$('#ResultMonitoring').html(result);

			$('.serah').on('input',function(){
				// alert($(this).val());
				var serah = $(this).val();
				var penyerahan = $(this).closest('tr').find('td#give').text();
				var penyerahan2 = $(this).closest('tr').find('input#give2').val();
				var permintaan = $(this).closest('tr').find('td#minta').text();
				var hasilnya = Number(permintaan) - Number(penyerahan) - Number(serah);
				$(this).closest('tr').find('td#kurang').text(hasilnya);
				$(this).closest('tr').find('td#give').text(Number(serah)+Number(penyerahan2));
				var id = $(this).closest('tr').find('td.trs_id').text();
				var final = $(this).closest('tr').find('td#give').text();
				$(this).closest('tr').find('input#final').val(final);
				// alert(final);
				$.ajax({
					type: "POST",
					url: baseurl+'TransactBon/C_Transact/insertData/', 
					data:{
						penyerahan:final, no_id:id
					},
					cache:false,
					success:function(data){
						console.log('berhasil')
					},
					error: function (xhr, ajaxOptions, thrownError){
						console.log(xhr.responseText);
					}
				});
			});

			$('.result').each(function(){
				var penyerahan = $(this).find('td#give').text();
				var permintaan = $(this).find('td#minta').text();
				var hasilnya = Number(permintaan) - Number(penyerahan);
				$(this).closest('tr').find('td#kurang').text(hasilnya)
			});

		})
}

$(function(){
    table = $('#tblDataStock').DataTable({
        "lengthMenu" : [10],
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": true,
        "deferRender" : true,
        "scroller": true
    });
})

function tampilTB2(th)
{
	var slcNoBon = $('input[name="slcNoBon"]').val();

	var request = $.ajax({
		url: baseurl+'TransactBon/Transact/searchBSTBP/',
		data:{slcNoBon:slcNoBon
			},
		type: "POST",
		datatype: 'html', 
	});
		$('#ResultMonitoring').html('');
		$('#ResultMonitoring').html('<center><img style="width:130px; height:auto" src="'+baseurl+'assets/img/gif/loading10.gif"></center>' );
	
		request.done(function(result){
			$('#ResultMonitoring').html(result);

			$('.serah').on('input',function(){
				// alert($(this).val());
				var serah = $(this).val();
				var penyerahan = $(this).closest('tr').find('td#give').text();
				var penyerahan2 = $(this).closest('tr').find('input#give2').val();
				var permintaan = $(this).closest('tr').find('td#minta').text();
				var hasilnya = Number(permintaan) - Number(penyerahan) - Number(serah);
				$(this).closest('tr').find('td#kurang').text(hasilnya);
				$(this).closest('tr').find('td#give').text(Number(serah)+Number(penyerahan2));
				var id = $(this).closest('tr').find('td.trs_id').text();
				var final = $(this).closest('tr').find('td#give').text();
				$(this).closest('tr').find('input#final').val(final);
				// alert(final);
				$.ajax({
					type: "POST",
					url: baseurl+'TransactBon/C_Transact/insertData/', 
					data:{
						penyerahan:final, no_id:id
					},
					cache:false,
					success:function(data){
						console.log('berhasil')
					},
					error: function (xhr, ajaxOptions, thrownError){
						console.log(xhr.responseText);
					}
				});
			});

			$('.result').each(function(){
				var penyerahan = $(this).find('td#give').text();
				var permintaan = $(this).find('td#minta').text();
				var hasilnya = Number(permintaan) - Number(penyerahan);
				$(this).closest('tr').find('td#kurang').text(hasilnya)
			});


		})
}