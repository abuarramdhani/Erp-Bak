$(document).ready(function(){

	$('.slc-laporankunjungan').select2({
		placeholder: 'Informasi Pekerja',
		minimumInputLength: 3,
		allowClear: false,
		searching: true,
		ajax:
		{
			url: baseurl+'MasterPekerja/LaporanKunjungan/getInfoPekerja',
			dataType: 'json',
			type: 'GET',
			delay: 500,
			data: function (params){
				return {
					term: params.term,
				}
			},
			processResults: function(data) {
				return {
					results: $.map(data, function(obj){
						return {id: obj.noind, text: obj.noind+" - "+obj.nama+" - "+obj.seksi+" - "+obj.alamat};
					})
				};
			}
		}
	});

	$('.slc-namapetugas').select2({
		placeholder: 'Informasi Petugas',
		minimumInputLength: 3,
		allowClear: false,
		searching: true,
		ajax:
		{
			url: baseurl+'MasterPekerja/LaporanKunjungan/getInfoPekerja',
			dataType: 'json',
			type: 'GET',
			delay: 500,
			data: function (params){
				return {
					term: params.term,
				}
			},
			processResults: function(data) {
				return {
					results: $.map(data, function(obj){
						return {id: obj.noind, text: obj.noind+" - "+obj.nama+" - "+obj.seksi};
					})
				};
			}
		}
	});

	$('.slc-namaatasan').select2({
		placeholder: 'Informasi Atasan',
		minimumInputLength: 3,
		allowClear: false,
		searching: true,
		ajax:
		{
			url: baseurl+'MasterPekerja/LaporanKunjungan/getInfoPekerja',
			dataType: 'json',
			type: 'GET',
			delay: 500,
			data: function (params){
				return {
					term: params.term,
				}
			},
			processResults: function(data) {
				return {
					results: $.map(data, function(obj){
						return {id: obj.noind, text: obj.noind+" - "+obj.nama+" - "+obj.jabatan};
					})
				};
			}
		}
	});

	var latar_belakang = new Array();

		$('.btn-preview').on('click',function(){
			$(".box-preview").hide();
			$('.pv-loading').show();
			$("#divCetak").hide();

			var infoAtasan 		= $(".slc-namaatasan").val();
			var infoPetugas 	= $(".slc-namapetugas").val();
			var infoPekerja 	= $(".slc-laporankunjungan").val();
			var diagnosa 		= $("input[name='diagnosa']").val();
			var hal_laporan 	= $("input[name='hal']").val();

			latar_belakang		= [];
			$("input.latbel").each(function(){
				latar_belakang.push($(this).val());
			});
			var hasil_laporan 	= $("textarea[name='LapKun']").val();
			$.ajax({
				url: baseurl+'MasterPekerja/LaporanKunjungan/previewLaporanKunjungan',
				type: "POST",
				dataType: "json",
				data:{atasan:infoAtasan,petugas:infoPetugas,pekerja:infoPekerja,diagnosa:diagnosa,hal:hal_laporan,latar_belakang:latar_belakang,LapKun:hasil_laporan},
				success: function(response){
					console.log(response);
					var latbel;
					var i;
					var no = 0;
					$("#PvinfoPetugas").text(response.noind_petugas+" / "+response.nama_petugas+" / "+response.seksi_petugas);
					$("#PvnamaPekerja").text(response.nama_pekerja);
					$("#PvnoIndukPekerja").text(response.noind_pekerja);
					$("#PvseksiPekerja").text(response.seksi_pekerja);
					$("#PvalamatPekerja").text(response.alamat_pekerja);
					$("#Pvdiagnosa").text(response.diagnosa);
					$("#Pvttdpetugas").text(response.nama_petugas);
					$("#Pvttdatasan").text(response.nama_atasan);
					$("#Pvjabatasan").text(response.jabatan_atasan);
					for(i=0;i<response.latar_belakang.length;i++){
						no++;
						latbel += 	'<tr>'+
									'<td>'+no+'. '+response.latar_belakang[i]+'</td>'+
									'</tr>'
									;

					}

					$("#PvlatarBelakang").html(latbel);
					$(".Pvhasil_laporan").html(response.hasil_laporan);

				},
				complete: function(){
					setTimeout(function(){
					$(".pv-loading").hide();
					$(".box-preview").show();
					$("#divCetak").show();
					},3000);


				}
			})
		})

		$('.btn-cetak').on('click',function(){
			Swal.fire({
			  title: 'Simpan Laporan?',
			  text: "Pastikan data yang di-inputkan sudah benar",
			  type: 'warning',
			  showCancelButton: true,
			  confirmButtonColor: '#3085d6',
			  cancelButtonColor: '#d33',
			  confirmButtonText: 'Ya'
			}).then((result) => {
			  if (result.value) {
			   $("#formLap").submit();
			  }
			});
		})

		 $("#addLatarBelakang").on('click',function(){
		 	$("#formLap .latar-belakang:last").after('<div class="row latar-belakang"><div class="col-md-12"><div class="col-md-1"></div><div class="col-md-1"><label for="latbel">Latar Belakang </label></div><div class="form-group col-md-6"><input name="latar_belakang[]" type="text" class="form-control latbel" id="latbel" placeholder="Latar Belakang"></div></div></div>');
		 	var inputLatarBelakang = $('.latar-belakang').length;
		 	console.log(inputLatarBelakang);
		 	if(inputLatarBelakang > 1 ){
		 		$("#deleteLatarBelakang").removeAttr('disabled');
		 	}
		 })

		 $("#deleteLatarBelakang").on('click',function(){

		 	$("#formLap .latar-belakang:last").remove();
		 	var inputLatarBelakang = $('.latar-belakang').length;
		 	console.log("Delete "+inputLatarBelakang);
		 	if(inputLatarBelakang == 1 ){
		 		$("#deleteLatarBelakang").attr('disabled','disabled');
		 	}
		 })


}); //end
