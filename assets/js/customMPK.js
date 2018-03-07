$(document).ready(function(){

	$('.select-nama').select2({
		ajax: {
		    url: baseurl+"MasterPekerja/Other/pekerja",
		    dataType: 'json',
		    type: "get",
		    data: function (params) {
		      return { p: params.term };
		    },
		    processResults: function (data) {
		      return {
		        results: $.map(data, function (item) {
		          return {
		            id: item.noind,
		            text: item.noind+' - '+item.nama,
		          }
		        })
		      };
		    },
		    cache: true
		  },
	  minimumInputLength: 2,
	  placeholder: 'Select Nama Pekerja',
	  allowClear: false,
	});

	$(function() {
		$('#tabel-idcard').DataTable( {
	      dom: 'frt',
	    });
	});

	function SelectNama(){
		var val = $('#NamaPekerja').val();
		if (val) {
			$('#CariPekerja').removeAttr('disabled', 'disabled');
		    $('#CariPekerja').removeClass('disabled'); 
		  }else{
		    $('#CariPekerja').attr('disabled', 'disabled');
		    $('#CariPekerja').addClass('disabled', 'disabled');
		  }
	}

	$(document).on('change', '#NamaPekerja', function() {
		SelectNama();
	});

	$(document).on('click', '#CariPekerja', function(e){
		e.preventDefault();
		var nama = $('#NamaPekerja').val();

		$.ajax({
			url: baseurl+"MasterPekerja/Other/DataIDCard",
		    type: "get",
		    data: {nama: nama}
		}).done(function(data){
			var html = '';
			var data = $.parseJSON(data);

			console.log(data['worker']);
			$('tbody#dataIDcard').empty(html);
			for (var i = 0; i < data['worker'].length; i++) {
				html += '<tr>';
				html += '<td>'+(i+1)+'</td>';
				html += '<td>'+data['worker'][i][0]['no_induk']+'<input type="hidden" name="noind[]" value="'+data['worker'][i][0]['noind']+'"></td>';
				html += '<td>'+data['worker'][i][0]['nama']+'</td>';
				if (data['worker'][i][0]['jabatan']) {
				html += '<td>'+data['worker'][i][0]['jabatan']+' '+data['worker'][i][0]['seksi']+'</td>';
				}else{
				html += '<td>'+data['worker'][i][0]['seksi']+'</td>';
				}
				html += '<td><a target="_blank" href="'+data['worker'][i][0]['photo']+'">PHOTO</td>';
				html += '<td><input type="text" style="text-transform:uppercase" data-noind="'+data['worker'][i][0]['noind']+'" class="form-control" name="nick[]" id="nickname" maxlength="10"></td>'
				html += '</tr>';
			}
			$('tbody#dataIDcard').append(html);
			$('#tampil-data').removeClass('hidden');
			$('#print_card').removeAttr('disabled',false);
			$('#print_card').removeClass('disabled');
		})
	});

});



