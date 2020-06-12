function angkawae(e, decimal) {
	var key;
	var keychar;
	if (window.event) {
		key = window.event.keyCode;
	} else
	if (e) {
		key = e.which;
	} else return true;
	keychar = String.fromCharCode(key);
	if ((key==null) || (key==0) || (key==8) ||  (key==9) || (key==13) || (key==27) ) {
		return true;
	} else
	if ((("0123456789.").indexOf(keychar) > -1)) {
		return true;
	} else
	if (decimal && (keychar == ".")) {
		return true;
	} else return false;
}

// ---------------------------------------------- JS Order Prototype PPIC Prototype ----------------------------------------------------------//

$(document).ready(function () {
		var request = $.ajax({
			url: baseurl+'OrderPro/monorderpro/loadview',
			type: "POST",
			beforeSend: function() {      
				$('div#tbl_monitoring_order' ).html('<center><img style="width:100px; height:auto" src="'+baseurl+'assets/img/gif/loading11.gif"></center>' );    },    
			});
		request.done(function(result){
			console.log(result);
				$('div#tbl_monitoring_order').html(result);
				$('#mon_order').DataTable({
					scrollX: true,
					scrollY:  400,
					scrollCollapse: true,
					paging:false,
                    info:false,
                    searching : false,
                    order : [[ 0, "desc" ],[17, "desc"],[18, "asc"]],
                    fixedColumns: {
						leftColumns: 3
					}
				});
			});
});

$(document).ready(function() {
	$('.tanggalorder').datepicker({
	    format: 'dd-M-yyyy',
	    todayHighlight: true,
	    autoclose: true
	});
});
$(document).ready(function() {
	$('.asmat_order').select2({
		allowClear: true,
		minimumResultsForSearch: Infinity,
	});
	$('#proses_order').select2({
		allowClear: true,
		minimumResultsForSearch: Infinity,
	});
});


$(document).on('click', '.hpsbtnn',  function() {
	$(this).parents('.panel-body').remove()
	$('#kanann').find('[name="urutanproses[]"]').each(function (i, v) {
		$(this).val(i + 1)
	})
});

var o =2;
function tambahproses(){

	o = $('[name="proses_order[]"').length + 1

	$('#tambah_proses').append('<div class="panel-body"><div class="col-md-3" style="text-align: left; color: white;"><label>Proses</label></div><div class="col-md-2" style="text-align: left;"><input readonly="readonly" type="text" class="form-control" name="urutanproses[]" value="'+o+'"></div><div class="col-md-6" style="text-align: left;"><select class="form-control select2 selectproses2" id="selectproses'+o+'" name="proses_order[]" data-placeholder="Proses"><option></option></select></div><div class="col-md-1"><a class="btn btn-danger btn-sm hpsbtnn"><i class="fa fa-minus"></i></a></div></div>')

	$(document).ready(function () {
	$(".selectproses2:last").select2({
		allowClear: true,
		minimumResultsForSearch: Infinity,
		ajax: {
			url: baseurl + "OrderPro/neworderpro/sugestproses",
			dataType: 'json',
			type: "GET",
			data: function (params) {
				var queryParameters = {
					term: params.term,
				}
				return queryParameters;
			},
			processResults: function (data) {
				// console.log(data);
				return {
					results: $.map(data, function (obj) {
						return {
							id: obj.id_proses,
							text: obj.nama_proses
						};
					})
				};
			}
		}
	});
});

	
}
		


$( '#asmat_order').change(function() {
	var value = $(this).val();
	console.log(value)

	if (value == 'Pusat') {
		$("#tglkirim_order2").css("display","block");
		$("#tglkirim_order").css("display","none");
		$("#tglkirim_order").attr("disabled","disabled");
		$("#tglkirim_order2").removeAttr("disabled");
		$("#tglkirim_order2").datepicker({
	    format: 'dd-M-yyyy',
	     todayHighlight: true,
	     autoclose: true
		});
	} else {
		$("#tglkirim_order2").css("display","none");
		$("#tglkirim_order").css("display","block");
		$("#tglkirim_order2").attr("disabled","disabled");
		$("#tglkirim_order").attr("readonly","readonly");
		$("#tglkirim_order").removeAttr("disabled");
		$("#tglkirim_order").val("-");
	}

});

function lihatgambar(a) {

	var no_order = $('#no_order'+a).val();

	
	var request = $.ajax({
			url: baseurl+'OrderPro/monorderpro/lihatgambar',
			data: {
			    no_order : no_order
			},
			type: "POST",
			datatype: 'html'
		});


		request.done(function(result){
			console.log(result);
				$('#gambarnya').html(result);
				$('#modalgambar').modal('show');
			});

	
}

function lihatprogress(a) {

	var no_order = $('#no_order'+a).val();

	
	var request = $.ajax({
			url: baseurl+'OrderPro/monorderpro/lihatprogress',
			data: {
			    no_order : no_order
			},
			type: "POST",
			datatype: 'html'
		});


		request.done(function(result){
			console.log(result);
				$('#progress').html(result);
				$('#modalprogress').modal('show');
			});

	
}

function terima(a){
	var no_order = $('#no_order'+a).val();

	Swal.fire({
	  title: 'Apa Anda Yakin?',
	  text: "Sudah menerima barang untuk order "+no_order+" ?",
      type: 'question',
	  showCancelButton: true,
	  confirmButtonColor: '#3085d6',
	  cancelButtonColor: '#d33',
	  confirmButtonText: 'Ya',
	  cancelButtonText : 'Tidak'
	}).then((result) => {
	  if (result.value) {

	  		var request = $.ajax({
			url: baseurl+'OrderPro/monorderpro/updateterima',
			data: {
			    no_order : no_order
			},
			type: "POST",
			datatype: 'html'
			});
			request.done(function(result){
				window.location.reload();
			});

	  }
	})

}

function edit(a) {

   	$('#preview1').css("display","block")
    $('#previewgambarpilih').css("display","none")

	var no_order = $('#no_order'+a).val();

	var request = $.ajax({
			url: baseurl+'OrderPro/monorderpro/edit',
			data: {
			    no_order : no_order
			},
			type: "POST",
			datatype: 'html'
		});
		request.done(function(result){
			console.log(result);
				$('#edit').html(result);
				$('#modaledit').modal('show');
			
				// datepicker tanggal kirim material
				// 	$('#tanggaledit').datepicker({
				// 	    format: 'dd-M-yyyy',
				// 	    todayHighlight: true,
				// 	    autoclose: true,
				// 	});
				// // datepicker  duedate
				// 	$('#duedate').datepicker({
				//     format: 'dd-M-yyyy',
				//     todayHighlight: true,
				//     autoclose: true
				// 	});
				    // $(".hahahaaaaa").inputmask();
				    Inputmask().mask("input");

				    // $(".hahahaaaaa").inputmask({
				    //     "alias": "decimal",
				    //     "digits": 2,
				    //     "autoGroup": true,
				    //     "allowMinus": false,
				    //     "rightAlign": false,
				    //     "groupSeparator": " ", // <-- this is &puncsp;
				    //     "radixPoint": ","
				    // });
				// select 2 proses yg udah ada sama asal material 
					$('.asal_material').select2({
						allowClear: true,
						minimumResultsForSearch: Infinity,
					});

					$('.proses_order').select2({
						allowClear: true,
						minimumResultsForSearch: Infinity,
					});

				// onchange select asal material
					$( '#asal_material').change(function() {
						var value = $(this).val();
						console.log(value)

						if (value == 'Tuksono') {
							$('#tanggaledit').val('');
							$('#tanggaledit').attr("disabled","disabled");
						} else {
							$('#tanggaledit').removeAttr("disabled");	
						}

					});
				// preview gambar ganti
					 $("#img_orderr").change(function(){

					        readURL(this);
					        $('#preview1').css("display","none")

					  });

				 // append select dan function select 2
						var button   = document.getElementById("buttontambahproses");
						button.onclick = function(){
								o = $('[name="proses_order[]"').length + 1

								$('#tambah_proses2').append('<div class="panel-body"><div class="col-md-4" style="text-align: right;"><label>Proses</label></div><div class="col-md-1" style="text-align: left;"><input readonly="readonly" type="text" class="form-control" name="urutan[]" value="'+o+'"></div><div class="col-md-5" style="text-align: left;"><select class="form-control select2 selectproses2" id="selectproses'+o+'" name="proses_order[]" data-placeholder="Proses"><option></option></select></div><div class="col-md-1" style="text-align:left"><a class="btn btn-danger btn-sm hpsbtnnn"><i class="fa fa-minus"></i></a></div></div>')

								$(document).ready(function () {
								$(".selectproses2:last").select2({
									allowClear: true,
									minimumResultsForSearch: Infinity,
									ajax: {
										url: baseurl + "OrderPro/neworderpro/sugestproses",
										dataType: 'json',
										type: "GET",
										processResults: function (data) {
											
											return {
												results: $.map(data, function (obj) {
												console.log(obj);	
													return {
														id: obj.id_proses,
														text: obj.nama_proses
													};
												})
											};
										}
									}
								});
							});
					}
				// function hapus select
					$(document).on('click', '.hpsbtnnn',  function() {
						$(this).parents('.panel-body').remove()
						$('#kanann').find('[name="urutan[]"]').each(function (i, v) {
						$(this).val(i + 1)
					})
				});
			});


}

function saveproses(){
	$(document).ready(function(){
		$('#hilanginaja').css("display","none");
		var nama_proses = $('#nama_proses').val();
		console.log(nama_proses);

		var request = $.ajax({
				url: baseurl+'OrderPro/masterpro/saveproses',
				data: {
				    nama_proses : nama_proses
				},
				type: "POST",
				datatype: 'html'
			});
		request.done(function(result){
			console.log(result);
				$('#tabel_proses').html(result);
				$('#nama_proses').val('');
		});
	});		

}

function deleteproses(n) {
	var nama_proses = $('#namapros' +n).val();

	Swal.fire({
	  title: 'Apa anda Yakin?',
	  text: "Anda akan menghapus proses "+nama_proses,
      type: 'warning',
	  showCancelButton: true,
	  confirmButtonColor: '#43a047',
	  cancelButtonColor: '#d33',
	  confirmButtonText: 'Ya',
	  cancelButtonText: 'Tidak'

	}).then((result) => {
	  if (result.value) {

	  		var request = $.ajax({
			url: baseurl+'OrderPro/masterpro/hapusproses',
			data: {
			    nama_proses : nama_proses
			},
			type: "POST",
			datatype: 'html'
			});
			request.done(function(result){
				window.location.reload();
			});

	  }
	})
}

 function readURL(input) {

        if (input.files && input.files[0]) {

            var reader = new FileReader();

            reader.onload = function (e) {

            	$('#previewgambarpilih').css("display","block")
                $('#previewgambar').attr('src', e.target.result);

            }

            reader.readAsDataURL(input.files[0]);

        }

    }


    // ---------------------------------------------- JS Order Prototype PPIC Fabrikasi ----------------------------------------------------------//

$(document).ready(function () {
		var request = $.ajax({
			url: baseurl+'OrderFab/monorderfab/loadview',
			type: "POST",
			beforeSend: function() {      
				$('div#tbl_monitoring_fabrikasi' ).html('<center><img style="width:100px; height:auto" src="'+baseurl+'assets/img/gif/loading11.gif"></center>' );    },    
			});
		request.done(function(result){
			console.log(result);
				$('div#tbl_monitoring_fabrikasi').html(result);
				$('#mon_order2').DataTable({
					scrollX: true,
					scrollY:  400,
					scrollCollapse: true,
					paging:false,
                    info:false,
                    searching : false,
                    order : [[ 0, "desc" ],[17, "desc"],[18, "asc"]],
                    fixedColumns: {
						leftColumns: 3
					}
				});
			});
});

    function terimamaterial(u) {
		var no_order = $('#no_order'+u).val();

			Swal.fire({
			  title: 'Apa Anda Yakin?',
			  text: "Sudah menerima material untuk order "+no_order+" ?",
		      type: 'question',
			  showCancelButton: true,
			  confirmButtonColor: '#3085d6',
			  cancelButtonColor: '#d33',
			  confirmButtonText: 'Ya',
			  cancelButtonText : 'Tidak'
			}).then((result) => {
			  if (result.value) {

			  		 var request = $.ajax({
					url: baseurl+'OrderFab/monorderfab/terimamaterial',
					data: {
					    no_order : no_order
					},
					type: "POST",
					datatype: 'html'
					});
					request.done(function(result){
						window.location.reload();
				});

			  }
			})	
    }

    function kirim(a){
	var no_order = $('#no_order'+a).val();

	Swal.fire({
	  title: 'Apa Anda Yakin?',
	  text: "Akan mengirim barang untuk order "+no_order+" ?",
      type: 'question',
	  showCancelButton: true,
	  confirmButtonColor: '#3085d6',
	  cancelButtonColor: '#d33',
	  confirmButtonText: 'Ya',
	  cancelButtonText : 'Tidak'
	}).then((result) => {
	  if (result.value) {

	  		var request = $.ajax({
			url: baseurl+'OrderFab/monorderfab/kirim',
			data: {
			    no_order : no_order
			},
			type: "POST",
			datatype: 'html'
			});
			request.done(function(result){
				window.location.reload();
			});

	  }
	})

}
function lihatprogresss(a) {

	var no_order = $('#no_order'+a).val();

	
	var request = $.ajax({
			url: baseurl+'OrderFab/monorderfab/lihatprogress',
			data: {
			    no_order : no_order
			},
			type: "POST",
			datatype: 'html'
		});


		request.done(function(result){
			console.log(result);
				$('#progress').html(result);
				$('#modalprogress').modal('show');

					$('.maudiapain').select2({
						allowClear: true,
						minimumResultsForSearch: Infinity,
					});
			});

	
}

function ubahsimboldanback(h){
	var action = $('#action'+h).val();
	var b = $('#warna'+h).val();
	console.log(b);

	if (action == 'P') {
		$('#simboldong'+h).html('<i style="color: black" class="fa fa-  fa-clock-o fa-2x">');
		$('#rowpro'+h).removeClass(b);
		$('#rowpro'+h).addClass("bg-warning");
		$('#warna'+h).val("bg-warning");
		// $('#action'+h).html('<option></option><option value ="Y">Finish</option>');
	} else if (action == 'Y') {
		$('#simboldong'+h).html('<i style="color: green" class="fa fa- fa-check fa-2x"></i>');
		$('#rowpro'+h).removeClass(b);
		$('#rowpro'+h).addClass("bg-success");
		$('#warna'+h).val("bg-success");
		$('#action'+h).next(".select2-container").hide();


	}
	

}

function inputtgljob(a) {

	var no_order = $('#no_order'+a).val();

	
	var request = $.ajax({
			url: baseurl+'OrderFab/monorderfab/inputtgljob',
			data: {
			    no_order : no_order
			},
			type: "POST",
			datatype: 'html'
		});


		request.done(function(result){
			console.log(result);
				$('#tgl_job').html(result);
				$('#modaljob').modal('show');

				$('#job_turun').datepicker({
				    format: 'dd-M-yyyy',
				    todayHighlight: true,
				    autoclose: true,
				});
			});

	
}

function inputqtyfinish(a) {

	var no_order = $('#no_order'+a).val();

	
	var request = $.ajax({
			url: baseurl+'OrderFab/monorderfab/inputqtyfinish',
			data: {
			    no_order : no_order
			},
			type: "POST",
			datatype: 'html'
		});


		request.done(function(result){
			console.log(result);
				$('#qty_finish').html(result);
				$('#modalqty').modal('show');

				$(document).on('keypress', '.qty_finish',  function(e, decimal) {
					var key;
					var keychar;
					if (window.event) {
						key = window.event.keyCode;
					} else
					if (e) {
						key = e.which;
					} else return true;
					keychar = String.fromCharCode(key);
					if ((key==null) || (key==0) || (key==8) ||  (key==9) || (key==13) || (key==27) ) {
						return true;
					} else
					if ((("0123456789.").indexOf(keychar) > -1)) {
						return true;
					} else
					if (decimal && (keychar == ".")) {
						return true;
					} else return false;
				});
				
			});

	
}

function pic_fabrikasi(a) {

	var no_order = $('#no_order'+a).val();

	
	var request = $.ajax({
			url: baseurl+'OrderFab/monorderfab/inputpicfabrikasi',
			data: {
			    no_order : no_order
			},
			type: "POST",
			datatype: 'html'
		});


		request.done(function(result){
			console.log(result);
				$('#pic_fabrikasi').html(result);
				$('#modalpic').modal('show');
				$(document).ready(function () {
				$("#pic_fab").select2({
					allowClear: true,
					minimumInputLength: 1,
					ajax: {
						url: baseurl + "OrderFab/monorderfab/sugestpic",
						dataType: 'json',
						type: "GET",
						data: function (params) {
							var queryParameters = {
								term: params.term,
							}
							return queryParameters;
						},
						processResults: function (data) {
							// console.log(data);
							return {
								results: $.map(data, function (obj) {
									return {
										id: obj.noind+' - '+obj.nama,
										text: obj.noind+' - '+obj.nama
									};
								})
							};
						}
					}
				})
							});
			});

	
}


