function tampilTK(th)
{
	var slcNoKIB = $('input[name="slcNoKIB"]').val();

	var request = $.ajax({
		url: baseurl+'TransactKIB/Transact/getData/',
		data:{slcNoKIB:slcNoKIB
			},
		type: "POST",
		datatype: 'html', 
	});

	$(document).ready(function(){
		// Add smooth scrolling to all links
		$("a").on('click', function(event) {
	  
		  // Make sure this.hash has a value before overriding default behavior
		  if (this.hash !== "") {
			// Prevent default anchor click behavior
			event.preventDefault();
	  
			// Store hash
			var hash = this.hash;
	  
			// Using jQuery's animate() method to add smooth page scroll
			// The optional number (800) specifies the number of milliseconds it takes to scroll to the specified area
			$('html, body').animate({
			  scrollTop: $(hash).offset().top
			}, 500, function(){
		 
			  // Add hash (#) to URL when done scrolling (default click behavior)
			  window.location.hash = hash;
			});
		  } // End if
		});
	  });

		$('#ResultMonitoring').html('');
        $('#ResultMonitoring').html('<center><img style="width:50px; height:auto" src="'+baseurl+'assets/img/gif/loading11.gif"></center>' );
        
        request.done(function(result){
				if(result == 1) {
					
					Swal.fire({
						title: 'Tidak Dapat Menjalankan Proses',
						type: 'error',
						text : 'Nomor KIB Sudah Pernah Di-transact'
					});
					$('#ResultMonitoring').html('');
					return false;
				}else{
					$('#ResultMonitoring').html(result);
				}
		})
}

function transactKIB(th)
{
	var slcNoKIB = $('input[name="slcNoKIB"]').val();
	var transfer = $('input[name="transfer"]').val();

	var request = $.ajax({
			url: baseurl+'TransactKIB/Transact/Transaksi/',
			data:{slcNoKIB:slcNoKIB,
				  transfer:transfer
				},
			type: "POST",
			datatype: 'html', 
			
		});

		$('#ResultMonitoring').html('');
        $('#ResultMonitoring').html('<center><img style="width:50px; height:auto" src="'+baseurl+'assets/img/gif/loading11.gif"></center>' )
		
		request.done(function(result){
			console.log(result);
			if (result == "On Hand Kurang") {
			Swal.fire({
					title: 'Tidak Dapat Menjalankan Proses',
					type:  'error',
					text : 'Jumlah To Transfer Tidak Boleh Lebih Besar dari On Hand'
			});
				}else if (result == "Transaksi Kelebihan"){
			Swal.fire({
					title:  'Tidak Dapat Menjalankan Proses',
					type:  'error',
					text : 'Jumlah Transaksi Tidak Boleh Lebih dari 0'
			});
				}else if (result == "ATT Kurang"){
			Swal.fire({
					title:  'Tidak Dapat Menjalankan Proses',
					type:  'error',
					text : 'Jumlah ATT Tidak Boleh Kurang dari To Transfer'
			});
				}else if (result == "Transfer Kebanyakan"){
			Swal.fire({
					title: 'Tidak Dapat Menjalankan Proses',
					type: 'error',
					text :'Jumlah To Transfer Tidak Boleh Lebih Besar dari Verifikasi'
			});
				}else if (result == "KIB Cancel"){
			Swal.fire({
					title: 'Tidak Dapat Menjalankan Proses',
					type: 'error',
					text :'KIB Sudah Cancel'
			});
				}else{ 
			Swal.fire({
					title: 'Transact KIB Berhasil',
					type: 'success',
					text : 'Nomor KIB Telah Di-transact'
			});
			$('#ResultMonitoring').html('');
			}
        })
}