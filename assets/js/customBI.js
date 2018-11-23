var angka = 0;

$('#cabang').change(function(){
	$('#organisasi').val,'';
	cabang = $(this).val();
	console.log(cabang);
	$.ajax({
		url: baseurl+'BarangCabang/C_branchitem/getOrg' ,
		type: 'POST',
		data: {
			cabang:cabang
		},
		success: function(results){
			$('#organisasi').html(results);
			$('#gdgasal').empty();
		}
	});
});
	
$('#code').change(function(){
	$('#organisasi').val,'';
	code = $(this).val();
	console.log(code);
	$.ajax({
		url: baseurl+'BarangCabang/C_branchitem/getCode' ,
		type: 'POST',
		data: {
			code:code
		},
		success: function(results){
			$('#organisasi').html(results);
		}
	});
});

$('#kode').change(function(){
	$('#deskripsi').val,'';
	code = $(this).val();
	console.log(code);
	$.ajax({
		url: baseurl+'BarangCabang/C_branchitem/getDesk' ,
		type: 'POST',
		data: {
			kode:code
		},
		success: function(results){
			$('#deskripsi').val(results);
		}
	});
});


$('#organisasi').change(function(){
	$('#gdgasal').val,'';
	organisasi = $(this).val();
	cabang = $('#cabang').val();
	console.log(organisasi);
	console.log(cabang);
	$.ajax({
		url: baseurl+'BarangCabang/C_branchitem/getGudang' ,
		type: 'POST',
		data: {
			organisasi:organisasi,
			cabang:cabang
		},
		success: function(results){
			$('#gdgasal').html(results);
		}
	});
});

$('#org_all').change(function(){
	$('#asal').val,'';
	organisasi = $(this).val();
	console.log(organisasi);
	$.ajax({
		url: baseurl+'BarangCabang/C_branchitem/getGudangView' ,
		type: 'POST',
		data: {
			organisasi:organisasi,
		},
		success: function(results){
			$('#asal').html(results);
		}
	});
});

$('.datepicker_bi').datepicker({
    dateFormat: 'mm-dd-yy'
});

 var gambar = "";

$('#upload_gambar').change(function(e){

  gambar = e.target.files[0].name;

});

$('#doppen').click(function(){
	$('#upload_form').trigger('click');

});

$('#upload_form').change(function(){
	$('#this-value').text($(this).val());
});


$('#button_insert_header_modal').click(function(){
		var tanggal = $('#tgl_bi').val();
		var cabang  = $('#cabang').val();
		var organisasi  = $('#organisasi').val();
		var gdgasal  = $('#gdgasal').val();
		var gdgtujuan  = $('#gdgtujuan').val();
		var fppb = $('#inp_fppb').val();

		var value = {tanggal:tanggal,cabang:cabang,organisasi:organisasi,gudang_asal:gdgasal,gudang_tujuan:gdgtujuan,no_fppb:fppb
					};

		console.log(value);

		if (cekExist == 0) {

			$.ajax({
				url:baseurl+"BranchItem/PemindahanBarang/Input/AddMasalah/insert",
				dataType:'json',
				type:'POST',
				data:value,
				success:function(result){
					console.log(result);
			
				},
				error:function(error,status){
					console.log(error);
					// console.log("Error: Ada masalah di dalam data \n Status : "+status);
				}
			});
		}

	});

$("#no_no_fppb").on('change',function(){
	var kode = $(this).val();
	var fppbb = $("#nonono").val();
	console.log(kode);
	$.ajax({
		url:baseurl+'BarangCabang/C_branchitem/get_val_penanganan',
		type:'POST',
		dataType:'JSON',
		data:{
			no_fppb:kode
		},
		beforeSend: function() {
				$('#loadingArea').show();
				$('#ta').DataTable().destroy();
				$('#ta tbody').empty();

			},
			complete: function(){
				$('#loadingArea').hide();
			},
		success: function(results){
			console.log(results);
			var html = '';
			
            $.each(results,function(i,data){
                html += '<tr id="PO'+data.kode_barang+'">'+
                '<td>'+(i+1)+'</td>'+ 
                '<td id="kode_barang" value="'+data.kode_barang+'">'+data.kode_barang+'</td>'+
                '<td>'+data.deskripsi+'</td>'+
                '<td>'+data.jumlah+'</td>'+
                '<td>'+data.kategori_masalah+'</td>'+
                '<td>'+
                '<button data-val="'+data.id_barang+'" onclick=klikGuys("'+data.kode_barang+'","'+data.no_fppb+'","'+fppbb+'") id="button_insert_modal" data-path="'+data.path+'" style="font-size:13px;" data-toggle="modal" data-target="#myModal2" class="btn btn-info"  >PREVIEW</button>'+
                '</td>'+
                '</tr>'
            });
            console.log(html);
            $("#body_val").append(html);
		},
		error:function(error,status){
			console.log(error)
		}
	});
});

function klikGuys(data,fppb,kode){
	console.log(data);
	$("#kode_barang_txt").val(data);
	$.ajax({
		url:baseurl+'BarangCabang/C_branchitem/get_preview',
		type:'POST',
		dataType:'JSON',
		data:{
			no_fppb:fppb,
			kode_bar:data,
			fppbb:kode
		},
		success: function(results){
			console.log(results);
			
			if(results[0]){
				$("#save_line_penanganan").attr('disabled',true);
				$('#usulan_kacab').val(results[0].usulan_kacab);
				$('#preview').val(results[0].preview);	
				$('#usulan_kacab').attr('disabled',true);
				$('#preview').attr('disabled',true);	
			}else{
				$('#usulan_kacab').val("");
				$('#preview').val("");	
				$("#save_line_penanganan").attr('disabled',false);
				$('#usulan_kacab').attr('disabled',false);
				$('#preview').attr('disabled',false);	
			}
			

			
        },
		error:function(error,status){
			console.log(error)
		}
	});
	console.log("adexe");
}

$('#save_line_penanganan').click(function(){
		var no_fppb = $('#no_no_fppb').val();
		var usulan_kacab  = $('#usulan_kacab').val();
		var no_fppbb  = $('#nonono').val();
		var preview  = $('#preview').val();
		var kode_barang  = $('#kode_barang_txt').val();

		var value = {no_fppb:no_fppb,usulan_kacab:usulan_kacab,no_fppbb:no_fppbb,preview:preview,kode_barang:kode_barang
					};

		console.log(value);

			$.ajax({
				url:baseurl+"BranchItem/PenangananBarang/Input/AddMasalah/insert/insertLine",
				dataType:'json',
				type:'POST',
				data:value,
				success:function(result){
					console.log(result);
					$('#usulan_kacab').val('');
					$('#preview').val('');
					$('#myModal2').modal('toggle');

					
				},
				error:function(error,status){
					console.log(error);
					console.log("Error: Ada masalah di dalam data \n Status : "+status);
				}
			});

	});



function biImage() {
    var uploader = new qq.FineUploader({
        debug: true,
        element: document.getElementById('fine-uploader-aldi'),
        template: 'qq-template-manual-trigger',
        request: {
            endpoint: baseurl + 'assets'},
        callbacks: {
            onAllComplete: function() {
                $.ajax({
                    url: baseurl + 'assets',
                    success: function(result) {
                        $('#modalContent').html(result);
                    }
                });
            }
        }
    });
}

function DeletePemindahanLine(id) {
    var confirmDel = confirm('Apakah anda Yakin?');
    if(confirmDel){
        $('.hapus').prop('disabled',true);
        $.ajax({
            url: baseurl+'/BarangCabang/C_branchitem/DeletePemindahanLine/'+id,
            success:function(results){
               
                $('table#tableorder tbody tr[row-id="'+id+'"]').remove();
                $.toaster('Data was deleted!', 'Deleted', 'success');
                 $('.hapus').prop('disabled',false);
                 location.reload();
            },
            error:function(XMLHttpRequest, textStatus, errorThrown){
                $.toaster(textStatus+' | '+errorThrown, name, 'danger');
            }
        })
    }
}

function readURL(input) {

  if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function(e) {
      $('#prevPhoto').attr('src', e.target.result);
    }

    reader.readAsDataURL(input.files[0]);
  }
}