	$(document).change(function(){
		var seksiflow = $("#seksi_fp").val();
        var doc = "FP";
        
		$.ajax({
                type: "POST",
                url: baseurl+"PengembanganSistem/cek_nomor_flow",
                data: {
					seksi : seksiflow,
                },
                dataType: "JSON",
                success: function (data) {
					if (data > 0) {
						var plus = parseInt(data) + 1;
						var y = (plus>9)?(plus<99)?plus:'0'+plus:'00'+plus;
						$("#number_flow_ps").val(doc+"-"+seksiflow+"-"+y);
					}else if (data == null) {
						$("#number_flow_ps").val(doc+"-"+seksiflow+"-"+"001");
					}
				}
		  });
    });

	$("#seksi_flow_ps").change(function(){
		var nodoc = $("#number_flow_ps").val();
		var sekum = $("#seksi_flow_ps").val();
		var c = nodoc.split("-");

		$.ajax({
			type: "POST",
			url: baseurl+"PengembanganSistem/cek_nomor_flow",
			data: {
				seksi : sekum,
			},
			dataType: "JSON",
			success: function (data) {
				if (data > 0) {
					var plus = parseInt(data) + 1;
					var y = (plus>9)?(plus<99)?plus:'0'+plus:'00'+plus;
					$("#number_flow_ps").val(c[0]+"-"+sekum+"-"+y);
				}else if (data == null) {
					$("#number_flow_ps").val(c[0]+"-"+sekum+"-"+"001");
				}
			}
		});
		
	})
	

	$("#number_rev-fp").change(function(){
		var number = $("#number_rev-fp").val();
		var number_rev = (number>9)?(number>99)?number:''+number:'0'+number;
			$("#number_rev-fp").val(number_rev);
	})

	function upload_file_flow(id) {
		var doc = $("#judul_flow_"+id).val().split('?');
		var	 ida= doc[1];
		var	 file_name= doc[0];
		var  doc_status= $("#status_flow_"+id).val();
		let file_flow = $('#file_fp_'+id)[0].files[0];
		
			let formData = new FormData();
			formData.append('id',ida);
			formData.append('fileupload', file_flow); 
			formData.append('nama_file', file_name);
			formData.append('doc_status', doc_status);

			console.log(formData); 

			$.ajax({
				type: 'POST',
				url: baseurl + "PengembanganSistem/upload_data_flow/"+id,
				data: formData,
				contentType: false,
				processData: false,
				dataType: 'JSON',
				beforeSend: function() {
				  Swal.showLoading()
				},
                success: function(response) {
                    if (response == 1) {
                        Swal.fire({
                            type: 'success',
                            title: 'Berhasil',
                            text: 'Data berhasil diupload!'
						}).then(function() {
							location.reload();
						});
                    } else {
						Swal.fire({
							type: 'error',
							title: 'Gagal',
							text: 'Format file tidak sesuai / Kolom belum diisi!',
						});
                    }
                }
			});
	}

	function link_ps(id) {
		var a = $("#fp_lilola"+id).attr('href');
		var str = a.replace(/\&/g, "_");
		$("#fp_lilola"+id).attr('href',str);
	};

//COPWI

	$("#number_rev-cw").change(function(){
		var number = $("#number_rev-cw").val();
		var number_rev = (number>9)?(number>99)?number:''+number:'0'+number;
			$("#number_rev-cw").val(number_rev);
	})

	$("#nomor_sop_cw").change(function(){
		var number = $("#nomor_sop_cw").val();
		var number_rev = (number>9)?(number>99)?number:''+number:'0'+number;
			$("#nomor_sop_cw").val(number_rev);
	})

	$(document).change(function(){
		var seksicop = $("#seksi_copwi_ps").val();
		var doc_copwi = $("#cop_wi_cw").val();
		var doc_sop = $("#nomor_sop_cw").val();

		$("#doc_sop_cw").val(seksicop);
		$.ajax({
                type: "POST",
                url: baseurl+"PengembanganSistem/cek_nomor_cop_wi",
                data: {
					cop_wi :doc_copwi,
					seksi_doc : seksicop,
					number_sop : doc_sop,
                },
                dataType: "JSON",
                success: function (data) {
					if (data > 0) {
						var plus = parseInt(data) + 1;
						var y = (plus>9)?(plus<99)?plus:'0'+plus:'00'+plus;
						$("#number_copwi_ps").val(doc_copwi+"-"+seksicop+"-"+doc_sop+"-"+y);
					}else{
						$("#number_copwi_ps").val(doc_copwi+"-"+seksicop+"-"+doc_sop+"-001");
					}
				}
		  });
	});

	$("#number_copwi_ps").change(function() {
		var cek_nomor_doc = $("#number_copwi_ps").val();
		var doc_cw = cek_nomor_doc.split('-',1);
		if (doc_cw == 'COP') {
			var sop_number_doc = cek_nomor_doc.substr(8,2);
		}else{
			var sop_number_doc = cek_nomor_doc.substr(7,2);
		}
		$("#nomor_sop_cw").val(sop_number_doc);
	})

	$("#number_copwi_ps").change(function() {
		var nomor_doc = $("#number_copwi_ps").val();
		var doc_cw = nomor_doc.split('-');
		var wi_cop = doc_cw[0];
		if (wi_cop == 'COP') {
			var cop_wi = 'Code Of Practice';
		} else {
			var cop_wi = 'Work Instruction';
		}
		$("#select_doc").val(wi_cop);
		$("#select_doc").text(cop_wi);
		$("#select2-cop_wi_cw-container").text(cop_wi);
	})

	$("#number_copwi_ps").change(function() {
		var nomor_doc = $("#number_copwi_ps").val();
		var doc_cw = nomor_doc.split('-',1);
		if (doc_cw == 'COP') {
			var seksi_wi_cop = nomor_doc.substr(4,3);
		}else{
			var seksi_wi_cop = nomor_doc.substr(3,3);
		}

		$.ajax({
			type: "POST",
			url: baseurl+"PengembanganSistem/select_seksi",
			data: {
				seksi : seksi_wi_cop,
			},
			dataType: "JSON",
			success: function (data) {
				// console.log(data);
				$("#select_seksi").val(data[0].singkat);
				$("#select_seksi").text(data[0].seksi);
				$("#sop_cw").val(data[0].singkat);
				$("#select2-seksi_cw-container").text(data[0].seksi);
			}
		});
	})

	$(document).on('change','#number_copwi_ps', function() {
		var datanum_cek_cw = $(this).val();

		$.ajax({
			type: "POST",
			url: baseurl+"PengembanganSistem/cek_nomor_cop_wi",
			data: {
				number_cw : datanum_cek_cw,
			},
			dataType: "JSON",
			success: function (data) {
				if (data.length > 0) {
					var numa = data[0].number_doc;
					alert(numa);
				}
			}
		});
	})

	$("#seksi_cw").change(function(){
		var nomor_doc = $("#number_copwi_ps").val();
		var cop_wi = $("#cop_wi_cw").val();
		var seksi_copwi = $("#seksi_cw").val();
		var c = nomor_doc.split("-");
		var c1 = c[0];
		var c3 = c[2];

		$("#sop_cw").val(seksi_copwi);
		// alert(hasil);
		$.ajax({
			type: "POST",
			url: baseurl+"PengembanganSistem/cek_nomor_cop_wi",
			data: {
				cop_wi : cop_wi,
				seksi_doc : seksi_copwi,
				number_sop : c3,
			},
			dataType: "JSON",
			success: function (data) {
				if (data > 0) {
					var plus = parseInt(data) + 1;
					var y = (plus>9)?(plus<99)?plus:'0'+plus:'00'+plus;
					console.log(plus);
					$("#number_copwi_ps").val(c1+"-"+seksi_copwi+"-"+c3+"-"+y);
				}else{
					$("#number_copwi_ps").val(c1+"-"+seksi_copwi+"-"+c3+"-001");
				}
			}
		});
		
	})

	$("#cop_wi_cw").change(function(){
		var nomor_doc = $("#number_copwi_ps").val();
		var cop_wi = $("#cop_wi_cw").val();
		var seksi_copwi = $("#seksi_cw").val();
		var c = nomor_doc.split("-");
		var c3 = c[2];
		
		$.ajax({
			type: "POST",
			url: baseurl+"PengembanganSistem/cek_nomor_cop_wi",
			data: {
				cop_wi : cop_wi,
				seksi_doc : seksi_copwi,
				number_sop : c3,

			},
			dataType: "JSON",
			success: function (data) {
				if (data > 0) {
					var plus = parseInt(data) + 1;
					var y = (plus>9)?(plus<99)?plus:'0'+plus:'00'+plus;
					console.log(plus);
					$("#number_copwi_ps").val(cop_wi+"-"+seksi_copwi+"-"+c3+"-"+y);
				}else{
					$("#number_copwi_ps").val(cop_wi+"-"+seksi_copwi+"-"+c3+"-001");
				}
			}
		});
		
	})

	function input_nomor_cop_wi_ps() {
		var nomor_doc = $("#number_copwi_ps").val();
		var a = nomor_doc.split('-');
		var yx = $("#nomor_sop_cw").val();
		var number = (yx>9)?(yx>99)?yx:''+yx:'0'+yx;
		a[2] = number;
		var b = a.join('-')
		$("#number_copwi_ps").val(b);
		console.log(a[2])
	}
	
	$("#nomor_sop_cw").change(function() {
		var yx = $("#nomor_sop_cw").val();
		var yy = $(".cle_number").text();
		var datanum_cek_cw = $("#number_copwi_ps").val();
		var b	= datanum_cek_cw.split('-');
		var a	= b[0];
		var a1	= b[1];
		var a2	= b[2];
		console.log(yy);

		$.ajax({
			type: "POST",
			url: baseurl+"PengembanganSistem/cek_nomor_cop_wi",
			data: {
				cop_wi : a,
				seksi_doc : a1,
				number_sop : a2,
			},
			dataType: "JSON",
			success: function (data) {
				if (yx == yy) {
					var as = $(".clas_number").text();
						$("#number_copwi_ps").val(a+"-"+a1+"-"+a2+"-"+as);
				}else{
					if (data > 0) {
						var plus = parseInt(data) + 1;
						var y = (plus>9)?(plus<99)?plus:'0'+plus:'00'+plus;
						$("#number_copwi_ps").val(a+"-"+a1+"-"+a2+"-"+y);
					}else{
						$("#number_copwi_ps").val(a+"-"+a1+"-"+a2+"-001");
					}
				}
			}
		});
	})

	function nomor_cop_wi_ps() {
		var nomor_doc = $("#number_copwi_ps").val();
		var a = nomor_doc.split('-');
		var yx = $("#nomor_sop_cw").val();
		var number = (yx>9)?(yx>99)?yx:''+yx:'0'+yx;
		a[2] = number;
		var b = a.join('-')
		$("#number_copwi_ps").val(b);
		console.log(a[2])
	}

	function upload_file_cop(id) {
		var doc = $("#judul_cop_"+id).val().split('?');
		var	 ida= doc[1];
		var	 file_name= doc[0];
		var  doc_status= $("#status_cop_"+id).val();
		let file_cop = $('#file_cop_'+id)[0].files[0];
		
			let formData = new FormData();
			formData.append('id',ida);
			formData.append('fileupload', file_cop); 
			formData.append('nama_file', file_name);
			formData.append('doc_status', doc_status);

			// console.log(formData); 

			$.ajax({
				type: 'POST',
				url: baseurl + "PengembanganSistem/upload_file_cop_wi/"+id,
				data: formData,
				contentType: false,
				processData: false,
				dataType: 'JSON',
				beforeSend: function() {
				  Swal.showLoading()
				},
                success: function(response) {
                    if (response == 1) {
                        Swal.fire({
                            type: 'success',
                            title: 'Berhasil',
                            text: 'Data berhasil diupload!'
						}).then(function() {
							location.reload();
						});
                    } else {
						Swal.fire({
							type: 'error',
							title: 'Gagal',
							text: 'Format file tidak sesuai / Kolom belum diisi!!',
						});
                    }
                }
			});
	}

	function link_cop(id) {
		var a = $("#cop_lilola"+id).attr('href');
		var str = a.replace(/\&/g, "_");
		$("#cop_lilola"+id).attr('href',str);
	};

	$(function(){
		$('#dataTables-PengSistem').DataTable({
			// "lengthChange": false,
			// "responsive": false,
			"scrollX": false,
			// "scroller": true,
			// "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
			// "pagingType": "full_numbers",
		});	
	});	
	
	function datepsfunction(){
		$('.date_pengSistem').daterangepicker({
			"singleDatePicker": true,
			"showDropdowns": true,
			"autoApply": true,
			"mask": true,
			"locale": {
				"format": "DD-MM-YYYY",
				"separator": " - ",
				"applyLabel": "OK",
				"cancelLabel": "Batal",
				"fromLabel": "Dari",
				"toLabel": "Hingga",
				"customRangeLabel": "Custom",
				"weekLabel": "W",
				"daysOfWeek": [
					"Mg",
					"Sn",
					"Sl",
					"Rb",
					"Km",
					"Jm",
					"Sa"
				],
				"monthNames": [
					"Januari",
					"Februari",
					"Maret",
					"April",
					"Mei",
					"Juni",
					"Juli",
					"Agustus ",
					"September",
					"Oktober",
					"November",
					"Desember"
				],
				"firstDay": 1
			}
		}, function(start, end, label) {
		  console.log("New date range selected: ' + start.format('DD-MM-YYYY H:i:s') + ' to ' + end.format('DD-MM-YYYY H:i:s') + ' (predefined range: ' + label + ')");
		});
	}

	function notif_input_flow() {
		$("#number_flow_ps").ready(function(){
			var a = $("#number_flow_ps").val();
			var b = $("#judul_fp").val();
			var c = $("#seksi_fp").val();
			var d = $("#date_rev_fp").val();
			var e = $("#number_rev-fp").val();
			var f = $("#pic-fp").val();
			var g = $("#status-fp").val();
			$(".as").text(a);
			$(".as").attr("style","text-align: center ; font: bold;");
			$(".bs").text(b);
			$(".bs").attr("style","text-align: center ; font: bold;");
			$(".cs").text(c);
			$(".cs").attr("style","text-align: center ; font: bold;");
			$(".ds").text(d);
			$(".ds").attr("style","text-align: center ; font: bold;");
			$(".es").text(e);
			$(".es").attr("style","text-align: center ; font: bold;");
			$(".fs").text(f);
			$(".fs").attr("style","text-align: center ; font: bold;");
			$(".gs").text(g);
			$(".gs").attr("style","text-align: center ; font: bold;");
		})
	}

	function notif_edit_flow() {
		$("#number_flow_ps").ready(function(){
			var a = $("#number_flow_ps").val();
			var b = $("#judulfp").val();
			var c = $("#seksi_flow_ps").val();
			var d = $("#date_rev_fp").val();
			var e = $("#number_rev-fp").val();
			var f = $("#pic-fp").val();
			var g = $("#status-fp").val();
			$(".as").text(a);
			$(".as").attr("style","text-align: center ; font: bold;");
			$(".bs").text(b);
			$(".bs").attr("style","text-align: center ; font: bold;");
			$(".cs").text(c);
			$(".cs").attr("style","text-align: center ; font: bold;");
			$(".ds").text(d);
			$(".ds").attr("style","text-align: center ; font: bold;");
			$(".es").text(e);
			$(".es").attr("style","text-align: center ; font: bold;");
			$(".fs").text(f);
			$(".fs").attr("style","text-align: center ; font: bold;");
			$(".gs").text(g);
			$(".gs").attr("style","text-align: center ; font: bold;");
		})
	}

	function notif_input_cop_wi() {
		$("#number_copwi_ps").ready(function(){
			var a = $("#cop_wi_cw").val();
			var b = $("#number_copwi_ps").val();
			var c = $("#judulcw").val();
			var d = $("#doc_cw").val();
			var e = $("#date_rev_cw").val();
			var f = $("#number_rev-cw").val();
			var g = $("#doc_sop_cw").val();
			var h = $("#nomor_sop_cw").val();
			var x = 'SOP-'+g+'-'+h;
			var i = $("#pic-cw").val();
			var j = $("#seksi_copwi_ps").val();
			var k = $("#status-cw").val();
			$(".ac").text(a);
			$(".ac").attr("style","text-align: center ; font: bold;");
			$(".bc").text(b);
			$(".bc").attr("style","text-align: center ; font: bold;");
			$(".cc").text(c);
			$(".cc").attr("style","text-align: center ; font: bold;");
			$(".dc").text(d);
			$(".dc").attr("style","text-align: center ; font: bold;");
			$(".ec").text(e);
			$(".ec").attr("style","text-align: center ; font: bold;");
			$(".fc").text(f);
			$(".fc").attr("style","text-align: center ; font: bold;");
			$(".gc").text(x);
			$(".gc").attr("style","text-align: center ; font: bold;");
			$(".hc").text(i);
			$(".hc").attr("style","text-align: center ; font: bold;");
			$(".ic").text(j);
			$(".ic").attr("style","text-align: center ; font: bold;");
			$(".jc").text(k);
			$(".jc").attr("style","text-align: center ; font: bold;");
		})
	}

	function notif_edit_cop_wi() {
		$("#number_copwi_ps").ready(function(){
			var a = $("#cop_wi_cw").val();
			var b = $("#number_copwi_ps").val();
			var c = $("#judulcw").val();
			var d = $("#doc_cw").val();
			var e = $("#date_rev_cw").val();
			var f = $("#number_rev-cw").val();
			var g = $("#sop_cw").val();
			var h = $("#nomor_sop_cw").val();
			var x = 'SOP-'+g+'-'+h;
			var i = $("#pic-cw").val();
			var j = $("#seksi_cw").val();
			var k = $("#status-cw").val();
			$(".ac").text(a);
			$(".ac").attr("style","text-align: center ; font: bold;");
			$(".bc").text(b);
			$(".bc").attr("style","text-align: center ; font: bold;");
			$(".cc").text(c);
			$(".cc").attr("style","text-align: center ; font: bold;");
			$(".dc").text(d);
			$(".dc").attr("style","text-align: center ; font: bold;");
			$(".ec").text(e);
			$(".ec").attr("style","text-align: center ; font: bold;");
			$(".fc").text(f);
			$(".fc").attr("style","text-align: center ; font: bold;");
			$(".gc").text(x);
			$(".gc").attr("style","text-align: center ; font: bold;");
			$(".hc").text(i);
			$(".hc").attr("style","text-align: center ; font: bold;");
			$(".ic").text(j);
			$(".ic").attr("style","text-align: center ; font: bold;");
			$(".jc").text(k);
			$(".jc").attr("style","text-align: center ; font: bold;");
		})
	}


	//User Manual


	$("#nomor_sop_um").change(function(){
		var number = $("#nomor_sop_um").val();
		var number_sop = (number>9)?(number>99)?number:''+number:'0'+number;
			$("#nomor_sop_um").val(number_sop);
	})

	$("#seksi_um").change(function(){
		var chec_number = $(".chle_number").text();
		var seksium = $("#seksi_um").val();
		var doc_um = "UM";
		var doc = "User Manual";
		var doc_sop = $("#nomor_sop_um").val();

		$("#sop_um").val(seksium);
		$.ajax({
                type: "POST",
                url: baseurl+"PengembanganSistem/hitung_data_um",
                data: {
					seksi_um : seksium,
					doc_um :doc,
					number_sop : doc_sop,
                },
                dataType: "JSON",
                success: function (data) {
					if (doc_sop == chec_number) {
						var check_number = $(".check_number").text();
						$("#number_um").val(doc_um+"-"+ seksium+ "-"+ doc_sop +"-" + check_number);
					} else {
						if (data > 0) {
							var data1 = parseInt(data) + 1;
							var y = (data1>9)?(data1<99)?data1:'0'+data1:'00'+data1;
							$("#number_um").val(doc_um+"-"+ seksium+ "-"+ doc_sop +"-" + y);
						} else {
							$("#number_um").val(doc_um+"-"+ seksium+ "-"+ doc_sop +"-001")
						}
					}
				}
		  });
	});

	function nomor_um_ps() {
		var nomor_doc = $("#number_um").val();
		var a = nomor_doc.split('-');
		var yx = $("#nomor_sop_um").val();
		var number = (yx>9)?(yx>99)?yx:''+yx:'0'+yx;
		a[2] = number;
		var b = a.join('-')
		$("#number_um").val(b);
		console.log(a[2])
	}

	$("#nomor_sop_um").change(function(){
		var chec_number = $(".chle_number").text();
		var seksium = $("#seksi_um").val();
		var doc_um = "UM";
		var doc = "User Manual";
		var doc_sop = $("#nomor_sop_um").val();

		$("#sop_um").val(seksium);
		$.ajax({
                type: "POST",
                url: baseurl+"PengembanganSistem/hitung_data_um",
                data: {
					seksi_um : seksium,
					doc_um :doc,
					number_sop : doc_sop,
                },
                dataType: "JSON",
                success: function (data) {
					if (doc_sop == chec_number) {
						var check_number = $(".check_number").text();
						$("#number_um").val(doc_um+"-"+ seksium+ "-"+ doc_sop +"-" + check_number);
					} else {
						if (data > 0) {
							var data1 = parseInt(data) + 1;
							var y = (data1>9)?(data1<99)?data1:'0'+data1:'00'+data1;
							$("#number_um").val(doc_um+"-"+ seksium+ "-"+ doc_sop +"-" + y);
						} else {
							$("#number_um").val(doc_um+"-"+ seksium+ "-"+ doc_sop +"-001")
						}
					}
				}
		  });
	});

	$(document).on('change','#number_um', function() {
		var datanum_cek_um = $(this).val();

		$.ajax({
			type: "POST",
			url: baseurl+"PengembanganSistem/cek_nomor_um",
			data: {
				number_um : datanum_cek_um,
			},
			dataType: "JSON",
			success: function (data) {
				if (data.length > 0) {
					if (confirm('data sudah ada')) {
						window.location.reload();
					} else {
						
					}
				}
			}
		});
	})

	function upload_file_um(id) {
		var doc = $("#judul_doc_"+id).val().split('?');
		var	 ida= doc[1];
		var	 file_name= doc[0];
		var  doc_status= $("#status_"+id).val();
		let file_ps = $('#upload_file_'+id)[0].files[0];
		
			let formData = new FormData();
			formData.append('id',ida);
			formData.append('fileupload', file_ps); 
			formData.append('nama_file', file_name);
			formData.append('doc_status', doc_status);

			// console.log(formData); 

			$.ajax({
				type: 'POST',
				url: baseurl + "PengembanganSistem/upload_file_um/"+id,
				data: formData,
				contentType: false,
				processData: false,
				dataType: 'JSON',
				beforeSend: function() {
				  Swal.showLoading()
				},
                success: function(response) {
                    if (response == 1) {
                        Swal.fire({
                            type: 'success',
                            title: 'Berhasil',
                            text: 'Data berhasil diupload!'
						}).then(function() {
							location.reload();
						});
                    } else {
						Swal.fire({
							type: 'error',
							title: 'Gagal',
							text: 'Format file tidak sesuai / Kolom belum diisi!',
						});
                    }
                }
			});
	}

	function link_um(id) {
		var a = $("#um_lilola"+id).attr('href');
		var str = a.replace(/\&/g, "_");
		$("#um_lilola"+id).attr('href',str);
	};

	function notif_input_um() {
		$("#number_um").ready(function(){
			var a = $("#number_um").val();
			var b = $("#judul_um").val();
			var c = $("#doc_um").val();
			var d = $("#date_rev_um").val();
			var e = $("#number_rev-fp").val();
			var f = $("#sop_um").val();
			var g = $("#nomor_sop_um").val();
			var x = 'SOP-'+f+'-'+g;
			var h = $("#pic-um").val();
			var i = $("#seksi_um").val();
			var j = $("#status-um").val();
			$(".am").text(a);
			$(".am").attr("style","text-align: center ; font: bold;");
			$(".bm").text(b);
			$(".bm").attr("style","text-align: center ; font: bold;");
			$(".cm").text(c);
			$(".cm").attr("style","text-align: center ; font: bold;");
			$(".dm").text(d);
			$(".dm").attr("style","text-align: center ; font: bold;");
			$(".em").text(e);
			$(".em").attr("style","text-align: center ; font: bold;");
			$(".fm").text(x);
			$(".fm").attr("style","text-align: center ; font: bold;");
			$(".gm").text(h);
			$(".gm").attr("style","text-align: center ; font: bold;");
			$(".hm").text(i);
			$(".hm").attr("style","text-align: center ; font: bold;");
			$(".im").text(j);
			$(".im").attr("style","text-align: center ; font: bold;");
		})
	}

	function notif_edit_um() {
		$("#number_um").ready(function(){
			var a = $("#number_um").val();
			var b = $("#judul_um").val();
			var c = $("#doc_um").val();
			var d = $("#date_rev_um").val();
			var e = $("#number_rev-fp").val();
			var f = $("#sop_um").val();
			var g = $("#nomor_sop_um").val();
			var x = 'SOP-'+f+'-'+g;
			var h = $("#pic-um").val();
			var i = $("#seksi_um").val();
			var j = $("#status-um").val();
			$(".am").text(a);
			$(".am").attr("style","text-align: center ; font: bold;");
			$(".bm").text(b);
			$(".bm").attr("style","text-align: center ; font: bold;");
			$(".cm").text(c);
			$(".cm").attr("style","text-align: center ; font: bold;");
			$(".dm").text(d);
			$(".dm").attr("style","text-align: center ; font: bold;");
			$(".em").text(e);
			$(".em").attr("style","text-align: center ; font: bold;");
			$(".fm").text(x);
			$(".fm").attr("style","text-align: center ; font: bold;");
			$(".gm").text(h);
			$(".gm").attr("style","text-align: center ; font: bold;");
			$(".hm").text(i);
			$(".hm").attr("style","text-align: center ; font: bold;");
			$(".im").text(j);
			$(".im").attr("style","text-align: center ; font: bold;");
		})
	};

	//Memo
	$(document).ready(function(){
		$('input[name="r2sys"]').on('ifChanged', function () {
				if ($('input[name="r2sys"]:checked').val() == "user") {
					console.log("user");
					$('#ditujukan_ms1').select2({
					ajax: {
						url: baseurl + 'PengembanganSistem/ambilSemuaPekerja',
						dataType: 'json',
						delay: 250,
						data: function (params) {
							var queryParameters = {
								noind: params.term.toUpperCase(),
							}
							return queryParameters;
						},
						processResults: function(data) {
							
							return {
								results: $.map(data, function(item) {
									return {
										id: item.daftar_pekerja,
										text: item.daftar_pekerja,
									}
								})
							};
						},
						cache: true,
					},
					minimumInputLength: 4,
					placeholder: 'Pilih data',
				})
			}else if ($('input[name="r2sys"]:checked').val() == "siedept") {
				console.log("seksi");
					$('#ditujukan_ms1').select2({
					ajax: {
						url: baseurl + 'PengembanganSistem/select_all_seksi',
						dataType: 'json',
						delay: 250,
						data: function(params) {
							return {
								seksi: params.term.toUpperCase(),
							};
						},
						processResults: function(data) {
							return {
								results: $.map(data, function(item) {
									return {
										id: item.singkat,
										text: item.seksi,
									}
								})
							};
						},
						cache: true,
					},
					minimumInputLength: 3,
					placeholder: 'Pilih data',
				})
			}
		})
	})

	function notif_input_memo() {
		$("#date_ms").ready(function(){
			var a = $("#a_number").val();
			var b = $("#date_ms").val();
			var c = $('select[name="ditujukan_ms"]').val(); //ditujukan
			var d = $("#siepenerima_ms").val();
			var e = $("#perihal_ms").val();
			var f = $("#makeby_ms").val();
			var g = $("#date_distribusi_ms").val();
			$(".ams").text(a);
			$(".ams").attr("style","text-align: center ; font: bold;");
			$(".bms").text(b);
			$(".bms").attr("style","text-align: center ; font: bold;");
			$(".cms").text(c);
			$(".cms").attr("style","text-align: center ; font: bold;");
			$(".dms").text(d);
			$(".dms").attr("style","text-align: center ; font: bold;");
			$(".ems").text(e);
			$(".ems").attr("style","text-align: center ; font: bold;");
			$(".fms").text(f);
			$(".fms").attr("style","text-align: center ; font: bold;");
			$(".gms").text(g);
			$(".gms").attr("style","text-align: center ; font: bold;");
		})
	};

	function notif_create_memo() {
		$("#date_ms").ready(function(){
			var a = $("#a_number").val();
			var b = $("#date_ms").val();
			var c = $('select[name="ditujukan_ms"]').val(); //ditujukan
			var d = $("#siepenerima_ms").val();
			var e = $("#perihal_ms").val();
			var f = $("#makeby_ms").val();
			var g = $("#date_distribusi_ms").val();
			$(".hms").text(a);
			$(".hms").attr("style","text-align: center ; font: bold;");
			$(".ims").text(b);
			$(".ims").attr("style","text-align: center ; font: bold;");
			$(".jms").text(c);
			$(".jms").attr("style","text-align: center ; font: bold;");
			$(".kms").text(d);
			$(".kms").attr("style","text-align: center ; font: bold;");
			$(".lms").text(e);
			$(".lms").attr("style","text-align: center ; font: bold;");
			$(".mms").text(f);
			$(".mms").attr("style","text-align: center ; font: bold;");
			$(".nms").text(g);
			$(".nms").attr("style","text-align: center ; font: bold;");
		})
	};

	$("#seleksidata").change(function(){
		var data1 = $("#seleksidata").val()
		if (data1 = "I") {
			$("#seleksidata").text("Internal");
			$("#select2-kode_ms-container").text("Intenal");
		}if (data1 = "E") {
			$("#seleksidata").text("Eksternal");
			$("#select2-kode_ms-container").text("Eksternal");
		} else {
			$("#seleksidata").text("Cabang");
			$("#select2-kode_ms-container").text("Cabang");
		}
	});

	$("#kode_ms").change(function(){
		var kode1 = "KU/PS/Ke-";
		var kode_doc = $("#kode_ms").val();
		var date_doc = $("#date_ms").val();
		var split_date = date_doc.split('-');
		var param_date = split_date[2]+'-'+split_date[1];
		var param_date2 = split_date[1]+'/'+split_date[2];
			// alert(param_date);
		$.ajax({
                type: "POST",
                url: baseurl+"PengembanganSistem/hitung_data_memo",
                data: {
					param_date :param_date,
					kode_doc : kode_doc,
                },
                dataType: "JSON",
                success: function (data) {
					var json = $.parseJSON(data);
					if (json > 0) {
						$number = json+1;
					}else {
						$number = 1;
					}
					
				var number_ok = ($number>9)?($number<99)?$number:'0'+$number:'00'+$number;
				$("#a_number").val(number_ok+"/"+kode1+kode_doc+"/"+param_date2);
				// console.log(kode_doc);s
				// console.log($number)
				}
		  });
	});

	$("#kode_ms").ready(function(){
		var kode_full = $("#seleksidata").text();
		var kode_a	=	'Internal';
		var kode_b	=	'Eksternal';
		var kode_c	=	'Cabang';
		if (kode_full == kode_a) {
			$("#seleksidata").val('I');
		} else if (kode_full == kode_b) {
			$("#seleksidata").val('E');
		} else if (kode_full == kode_c) {
			$("#seleksidata").val('I');
		} else {
			false;
		}
	})

	function upload_file_memo(id) {
		var file_name = $("#file_name_"+id).val();
		let file_ps = $('#file_ps_'+id)[0].files[0];
		
			let formData = new FormData();
			formData.append('id',id);
			formData.append('fileupload', file_ps); 
			formData.append('nama_file', file_name);

			// console.log(file_ps); 

			$.ajax({
				type: 'POST',
				url: baseurl + "PengembanganSistem/upload_file_ms/"+id,
				data: formData,
				contentType: false,
				processData: false,
				dataType: 'JSON',
				beforeSend: function() {
				  Swal.showLoading()
				},
                success: function(response) {
                    if (response == 1) {
                        Swal.fire({
                            type: 'success',
                            title: 'Berhasil',
                            text: 'Data berhasil diupload!'
						}).then(function() {
							location.reload();
						});
                    } else {
						Swal.fire({
							type: 'error',
							title: 'Gagal',
							text: 'Format file tidak sesuai / Kolom belum diisi!',
						});
                    }
                }
			});
	}

	//LAPORAN KERJA HARIAN

    $('input[name=total_waktu]').keyup(function(){
        $(this).val($(this).val().replace(/[^\d]/,''));
    });
		
	function kode_lkh() {
	    var x = $("#kode_lkh_ps").val();
		var xx = x.toUpperCase();
		$("#kode_lkh_ps").val(xx);
	}
	
	$("#waktu_selesai").change(function() {
		if ($("#hari_masuk").val() == "Jum'at") {
			if ($("#waktu_mulai").val() != 0 && $("#total_target").val() !=0 ) {
				var mulai = $("#waktu_mulai").val()+":00";
				var selesai = $("#waktu_selesai").val()+":00";
		
				var total = hmsToSeconds(selesai) - hmsToSeconds(mulai);
				var perbedaan = Math.floor(total/60)-75;
				$("#total_waktu").val(perbedaan);
	

				var target = $("#total_target").val();
				var total = $("#total_waktu").val();
				var hasil =  Math.floor((total/target)*100);
				$("#persen_lkh").val(hasil+"%");

			}
		}else{	
			if ($("#waktu_mulai").val() != 0 && $("#total_target").val() !=0 ) {
				var mulai = $("#waktu_mulai").val()+":00";
				var selesai = $("#waktu_selesai").val()+":00";
		
				var total = hmsToSeconds(selesai) - hmsToSeconds(mulai);
				var perbedaan = Math.floor(total/60)-60;
				$("#total_waktu").val(perbedaan);
	

				var target = $("#total_target").val();
				var total = $("#total_waktu").val();
				var hasil =  Math.floor((total/target)*100);
				$("#waktu_selesai").ready(function() {
				$("#persen_lkh").val(hasil+"%");
				});
			}
		}
		if (perbedaan > target) {
			false;
				$("#demo_blink").text('Total Waktu Melebihi Target ...!');
				$("#total_waktu").css('background','red');
				$("#persen_lkh").css('background','red');
		}else{
			true;
			$("#demo_blink").text('');
			$("#total_waktu").css('background','');
			$("#persen_lkh").css('background','');
		}
	});
				
	function hmsToSeconds(s) {
	  var b = s.split(':');
	  return b[0]*3600 + b[1]*60 + (+b[2] || 0);
	}

	function timepickerPS() {
		$('.timepickerPS').timepicker({
			showMeridian: false,
			showDropdowns: true
		});
	}

	$("#uraian_pekerjaan").click(function(){
		var date_lkh = $("#date_masuk").val();
		var a	= date_lkh.split("-");
		var a1 = a[2] + '-' +a[1]+ '-' +a[0];

		$.ajax({
                type: "POST",
                url: baseurl+"PengembanganSistem/cek_lkh_ps",
                data: {
					date_lkh :a1,
                },
                dataType: "JSON",
                success: function (data) {
						if (data.length > 0) {
							if (confirm('Data dengan tanggal tersebut sudah pernah diinput.')) {
								$("#date_masuk").val('')
							} else {
								
							}
						}
				}
		  });
	});

	$("#hari_masuk").change(function() {
		var y = document.getElementById("kode_lkh_ps");
		if ($(this).val() == "Minggu") {
			$("#total_target").val('');
			$("#kode_lkh_ps").val('LL');
			$('#date_masuk').css('background', 'aquamarine');
			$('#uraian_pekerjaan').css('background', 'aquamarine');
			$('#waktu_mulai').css('background', '');
			$('#waktu_selesai').css('background', '');
			$("#total_target").attr('readonly','');
			$("#waktu_mulai").attr('readonly','');
			$("#waktu_selesai").attr('readonly','');
			y.value = y.value.toUpperCase();
		}else{
			if ($(this).val() != "Jum'at" && $(this).val() !== "Sabtu") {
			$("#kode_lkh_ps").val('LL');
			$("#total_target").val('420');
			$('#date_masuk').css('background', 'aquamarine');
			$('#uraian_pekerjaan').css('background', 'aquamarine');
			$('#waktu_mulai').css('background', 'aquamarine');
			$('#waktu_selesai').css('background', 'aquamarine');
			y.value = y.value.toUpperCase();
		} else {
			$("#kode_lkh_ps").val('LL');
			$("#total_target").val('360');
			$('#date_masuk').css('background', 'aquamarine');
			$('#uraian_pekerjaan').css('background', 'aquamarine');
			$('#waktu_mulai').css('background', 'aquamarine');
			$('#waktu_selesai').css('background', 'aquamarine');
			y.value = y.value.toUpperCase();
			}
		}
		if ($("#total_waktu").val() > $("#total_target").val()) {
			alert("Total waktu melebihi target!!!!");
			$('#waktu_mulai').val('');
			$('#waktu_selesai').val('');
			$("#total_waktu").val('');
			$("#persen_lkh").val('');
		}
	});

	function wekday() {
		var uraian = $('#uraian_pekerjaan').val();
		var add = uraian.split(' ');
		if (add[0] == "Libur") {
			$("#kode_lkh_ps").attr('readonly','');
			$("#total_target").attr('readonly','');
			$("#total_target").val('');
			$("#waktu_mulai").attr('readonly','');
			$("#waktu_mulai").val('');
			$("#waktu_selesai").attr('readonly','');
			$("#waktu_selesai").val('');
			$("#total_waktu").val('');
			$("#persen_lkh").val('');
			$('#waktu_mulai').css('background', '');
			$('#waktu_selesai').css('background', '');
			
		} else {
			if (add[0] == "LIBUR") {
				$("#kode_lkh_ps").attr('readonly','');
				$("#total_target").attr('readonly','');
				$("#waktu_mulai").attr('readonly','');
				$("#waktu_selesai").attr('readonly','');
				$('#waktu_mulai').css('background', '');
				$('#waktu_selesai').css('background', '');
				
			}else{
				$("#kode_lkh_ps").removeAttr('readonly','');
				$("#total_target").removeAttr('readonly','');
				$("#waktu_mulai").removeAttr('readonly','');
				$("#waktu_selesai").removeAttr('readonly','');
			}
		}
	}


	function notif_input_lkh() {
		$("#hari_masuk").ready(function(){
			var a = $("#hari_masuk").val();
			var b = $("#date_masuk").val();
			var c = $('#uraian_pekerjaan').val(); //ditujukan
			var d = $("#kode_lkh_ps").val();
			var e = $("#total_target").val();
			var f = $("#waktu_mulai").val();
			var g = $("#waktu_selesai").val();
			var h = $("#total_waktu").val();
			var i = $("#persen_lkh").val();
			if ($('input[id="t"]:checked').val() == "V") {
				var j = $("#t").val();
			}else{
				if ($('input[id="i"]:checked').val() == "V") {
				var k = $("#i").val();
				}else{
					if ($('input[id="m"]:checked').val() == "V") {
					var l = $("#m").val();
					}else{
						if ($('input[id="sk"]:checked').val() == "V") {
						var m = $("#sk").val();
						}else{
							if ($('input[id="ct"]:checked').val() == "V") {
							var n = $("#ct").val();
							}else{
								if ($('input[id="ip"]:checked').val() == "V") {
								var o = $("#ip").val();
								}
							}
						}
					}
				}
			}

			$(".lkh1").text(a);
			$(".lkh1").attr("style","text-align: center ; font: bold;");
			$(".lkh2").text(b);
			$(".lkh2").attr("style","text-align: center ; font: bold;");
			$(".lkh3").text(c);
			$(".lkh3").attr("style","text-align: center ; font: bold;");
			$(".lkh4").text(d);
			$(".lkh4").attr("style","text-align: center ; font: bold;");
			$(".lkh5").text(e);
			$(".lkh5").attr("style","text-align: center ; font: bold;");
			$(".lkh6").text(f);
			$(".lkh6").attr("style","text-align: center ; font: bold;");
			$(".lkh7").text(g);
			$(".lkh7").attr("style","text-align: center ; font: bold;");
			$(".lkh8").text(h);
			$(".lkh8").attr("style","text-align: center ; font: bold;");
			$(".lkh9").text(i);
			$(".lkh9").attr("style","text-align: center ; font: bold;");
			$(".lkh10").text(j);
			$(".lkh10").attr("style","text-align: center ; font: bold;");
			$(".lkh11").text(k);
			$(".lkh11").attr("style","text-align: center ; font: bold;");
			$(".lkh12").text(l);
			$(".lkh12").attr("style","text-align: center ; font: bold;");
			$(".lkh13").text(m);
			$(".lkh13").attr("style","text-align: center ; font: bold;");
			$(".lkh14").text(n);
			$(".lkh14").attr("style","text-align: center ; font: bold;");
			$(".lkh15").text(o);
			$(".lkh15").attr("style","text-align: center ; font: bold;");
		})
	};

	function exspotexcel(){
		$('.printexcel').attr('action',"excel_lkh");
	}

	function exspotpdf(){
		$('.printexcel').attr('action',"print_lkh");
	}
	
