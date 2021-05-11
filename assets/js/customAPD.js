$("#group_add").click(function (e) {
	var d = new Date();
	var n = d.getDate();
	if (n > 40) {
		// alert('Anda Terlambat Order');
		Swal.fire({
			type: "error",
			title: "Anda Terlambat Order!",
			text: "Order dapat Dilakukan di Tanggal 1 - 10",
			animation: false,
			// showCancelButton: true,
			customClass: {
				popup: "animated tada",
			},
		});
	} else {
		e.preventDefault();
		$(".apd-select2").last().select2("destroy");
		$(".multiinput").last().clone().appendTo("#tb_InputKebutuhanAPD tbody");
		$("tr:last .form-control").val("").end();
		// var idsekarang = Number($('tr:last input#txtKodeItem').attr('data-id'));
		var nomorr = Number($("#tb_InputKebutuhanAPD tr:last").find("input#txtKodeItem").attr("data-id"));
		// var tez = $('tr:last input#txtKodeItem').attr('data-id');

		nomorr = nomorr + 1;
		// alert(nomorr);
		// alert(tez);
		$("#tb_InputKebutuhanAPD tr:last td#nomor").html(nomorr);
		$("#tb_InputKebutuhanAPD tr:last input#txtKodeItem").attr("data-id", nomorr);
		$(".apd-select2").select2({
			ajax: {
				url: baseurl + "P2K3_V2/Order/getItem",
				dataType: "json",
				type: "get",
				data: function (params) {
					return { s: params.term };
				},
				processResults: function (data) {
					return {
						results: $.map(data, function (item) {
							return {
								id: item.kode_item,
								text: item.item,
							};
						}),
					};
				},
				cache: true,
			},
			minimumInputLength: 0,
			placeholder: "Select Item",
			allowClear: true,
		});
	}

	// initialize tippy again
	tippyInit();
});

$(document).on("click", ".group_rem", function (e) {
	e.preventDefault();
	if ($(".multiinput").size() > 1) {
		$(this).closest("tr").remove();
	} else {
		alert("Minimal harus ada satu baris tersisa");
	}
});

function tippyInit() {
	// Popup
	return tippy("[tippy-title]", {
		onCreate(instance) {
			tippyku = instance;
		},
		content(ref) {
			const title = ref.getAttribute("tippy-title");
			return title;
		},
		allowHTML: true,
	});
}

$("#group_add2").click(function (e) {
	var d = new Date();
	var n = d.getDate();
	if (n > 300) {
		alert("Anda Terlambat Order");
		// Swal.fire(
		//   'Error',
		//   'Anda Terlambat Order!',
		//   'error',
		//   )
	} else {
		e.preventDefault();
		$(".apd-select2").last().select2("destroy");
		$(".multiinput").last().clone().appendTo("#tb_InputKebutuhanAPD tbody");
		$("tr:last .form-control").val("").end();
		// var idsekarang = Number($('tr:last input#txtKodeItem').attr('data-id'));
		var nomorr = Number($("#tb_InputKebutuhanAPD tr:last").find("input#txtKodeItem").attr("data-id"));
		// var tez = $('tr:last input#txtKodeItem').attr('data-id');

		nomorr = nomorr + 1;
		// alert(nomorr);
		// alert(tez);
		$("#tb_InputKebutuhanAPD tr:last td#nomor").html(nomorr);
		$("#tb_InputKebutuhanAPD tr:last input#txtKodeItem").attr("data-id", nomorr);
		$(".apd-select2").select2({
			ajax: {
				url: baseurl + "P2K3_V2/Order/getItem",
				dataType: "json",
				type: "get",
				data: function (params) {
					return { s: params.term };
				},
				processResults: function (data) {
					return {
						results: $.map(data, function (item) {
							return {
								id: item.kode_item,
								text: item.item,
							};
						}),
					};
				},
				cache: true,
			},
			// minimumInputLength: 0,
			placeholder: "Select Item",
			allowClear: true,
		});
	}

	// initialize tippy again
	tippyInit();
});

$(function () {
	$(".dataTable-p2k3").DataTable({
		dom: "frtp",
	});

	$(".dataTable-p2k3Frezz").DataTable({
		dom: "frtp",
		ordering: false,
		scrollX: true,
		fixedColumns: {
			leftColumns: 3,
		},
	});

	$(".dataTable-p2k3Frezz4").DataTable({
		dom: "frtp",
		scrollX: true,
		fixedColumns: {
			leftColumns: 4,
		},
	});

	$(".apd-select2").select2({
		ajax: {
			url: baseurl + "P2K3_V2/Order/getItem",
			dataType: "json",
			type: "get",
			data: function (params) {
				return { s: params.term };
			},
			processResults: function (data) {
				return {
					results: $.map(data, function (item) {
						return {
							id: item.kode_item,
							text: item.item,
						};
					}),
				};
			},
			cache: true,
		},
		// minimumInputLength: 0,
		placeholder: "Select Item",
		allowClear: true,
	});
});

function JenisAPD(hh) {
	var id = $(hh).closest("tr").find("input#txtKodeItem").attr("data-id");
	var it = $("input[data-id='" + id + "']");
	var kode = $(hh).val();
	it.val(kode);
}

$(document).ready(function () {
	function delSpesifikRow(th) {
		$(th).closest("tr").remove();
	}

	$("#k3_periode").datepicker({
		autoclose: true,
	});

	$("#detailModal").on("show.bs.modal", function (event) {
		var button = $(event.relatedTarget); // Button that triggered the modal
		var recipient = button.data("whatever"); // Extract info from data-* attributes
		// If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
		// Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
		var modal = $(this);
		modal.find(".modal-title").text("New message to " + recipient);
		modal.find(".modal-body input").val(recipient);

		var NextId = $(event.relatedTarget).data("next-id");
		$("#id-input").val(NextId);
		var id = $("id-input").val();

		$.ajax({
			type: "POST",
			url: baseurl + "P2K3_V2/Order/detail",
			data: {
				id: id,
			},
			success: function (response) {
				$("#slcEcommerceSubInventory").removeAttr("disabled");
				$("#slcEcommerceOrganization").removeAttr("disabled");
				$("#btnTambahKriteriaPencarian").removeAttr("disabled");
				$("#submitExportExcelItemEcatalog").removeAttr("disabled");
				$("#searchResultTableItemBySubInventory").html(response);
				$("#tbItemTokoquick").DataTable();
			},
		});
	});

	$(".p2k3-daterangepicker").daterangepicker(
		{
			showDropdowns: true,
			autoApply: true,
			locale: {
				format: "YYYY-MM-DD",
				separator: " - ",
				applyLabel: "OK",
				cancelLabel: "Batal",
				fromLabel: "Dari",
				toLabel: "Hingga",
				customRangeLabel: "Custom",
				weekLabel: "W",
				daysOfWeek: ["Mg", "Sn", "Sl", "Rb", "Km", "Jm", "Sa"],
				monthNames: ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus ", "September", "Oktober", "November", "Desember"],
				firstDay: 1,
			},
		},
		function (start, end, label) {
			console.log("New date range selected: ' + start.format('DD-MM-YYYY H:i:s') + ' to ' + end.format('DD-MM-YYYY H:i:s') + ' (predefined range: ' + label + ')");
		}
	);

	$(".p2k3-daterangepickersingledate").daterangepicker(
		{
			singleDatePicker: true,
			showDropdowns: true,
			autoApply: true,
			mask: true,
			locale: {
				format: "YYYY-MM-DD",
				separator: " - ",
				applyLabel: "OK",
				cancelLabel: "Batal",
				fromLabel: "Dari",
				toLabel: "Hingga",
				customRangeLabel: "Custom",
				weekLabel: "W",
				daysOfWeek: ["Mg", "Sn", "Sl", "Rb", "Km", "Jm", "Sa"],
				monthNames: ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus ", "September", "Oktober", "November", "Desember"],
				firstDay: 1,
			},
		},
		function (start, end, label) {
			console.log("New date range selected: ' + start.format('DD-MM-YYYY H:i:s') + ' to ' + end.format('DD-MM-YYYY H:i:s') + ' (predefined range: ' + label + ')");
		}
	);

	$(".p2k3-daterangepickersingledatewithtime").daterangepicker(
		{
			timePicker: true,
			timePicker24Hour: true,
			singleDatePicker: true,
			showDropdowns: true,
			autoApply: true,
			locale: {
				format: "YYYY-MM-DD HH:mm:ss",
				separator: " - ",
				applyLabel: "OK",
				cancelLabel: "Batal",
				fromLabel: "Dari",
				toLabel: "Hingga",
				customRangeLabel: "Custom",
				weekLabel: "W",
				daysOfWeek: ["Mg", "Sn", "Sl", "Rb", "Km", "Jm", "Sa"],
				monthNames: ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus ", "September", "Oktober", "November", "Desember"],
				firstDay: 1,
			},
		},
		function (start, end, label) {
			console.log("New date range selected: ' + start.format('DD-MM-YYYY H:i:s') + ' to ' + end.format('DD-MM-YYYY H:i:s') + ' (predefined range: ' + label + ')");
		}
	);

	$("#exampleModalapd").on("show.bs.modal", function (event) {
		var button = $(event.relatedTarget); // Button that triggered the modal
		var recipient = button.data("whatever"); // Extract info from data-* attributes
		// If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
		// Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
		var modal = $(this);
		modal.find(".modal-title").text("New message to " + recipient);
		modal.find(".modal-body input").val(recipient);
	});
});
$(document).ready(function () {
	$("#tb_p2k3").DataTable({
		pagingType: "full_numbers",
	});
	$("#p2k3_adm_list_approve").DataTable({
		pagingType: "full_numbers",
	});
	$("#tb_InputKebutuhanAPDs").dataTable({
		dom: "frtp",
	});
	$(".tb_p2k3").dataTable({
		dom: "frtp",
	});
	$(".p2k3_tblstok").dataTable();

	// $('.p2k3_exp_perhitungan').click(function(){
	//   var judul = 'Perhitungan APD periode '+period+'.csv';
	//   // alert(judul);
	//   $(".p2k3_perhitungan").tableHTMLExport({
	//     type:'csv',
	//     filename: judul,
	//     ignoreColumns: '.ignore',
	//     ignoreRows: '.ignore'
	//   });
	// })

	// $('.p2k3_exp_perhitungan_pdf').click(function(){
	//   var judul = 'Perhitungan APD periode '+period+'.pdf';
	//   $(".p2k3_perhitungan").tableExport({type:'pdf',
	//    jspdf: {orientation: 'p',
	//    margins: {left:20, top:10},
	//    autotable: false}
	//  });
	// });
});

// $('#tanggal').datepicker({
//   changeMonth: true,
//   changeYear: true,
//   showButtonPanel: true,
//   dateFormat: 'MM - yy'
// }).focus(function() {
//   var thisCalendar = $(this);
//   $('.ui-datepicker-calendar').detach();
//   $('.ui-datepicker-close').click(function() {
//     var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
//     var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
//     thisCalendar.datepicker('setDate', new Date(year, month, 1));
//   });
// });

$("#tanggal").datepicker({
	dateFormat: "mm/yy",
	changeMonth: true,
	changeYear: true,
	showButtonPanel: true,

	onClose: function (dateText, inst) {
		var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
		var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
		$(this).val($.datepicker.formatDate("mm - yy", new Date(year, month, 1)));
	},
});

$("input.p2k3_tanggal_periode").monthpicker({
	changeYear: true,
	dateFormat: "mm - yy",
});

$("input.p2k3_tanggal_periodeUnlimited").monthpicker({
	changeYear: true,
	dateFormat: "mm - yy",
});

$(".monthPicker").focus(function () {
	$(".ui-datepicker-calendar").remove();
	$("#ui-datepicker-div").position({
		my: "center top",
		at: "center bottom",
		of: $(this),
	});
});

// get Apd umum
$(document).ready(function () {
	$(".k3_admin_standar").select2({
		ajax: {
			url: baseurl + "p2k3adm_V2/Admin/getSeksiAprove",
			dataType: "json",
			type: "get",
			data: function (params) {
				return { s: params.term };
			},
			processResults: function (data) {
				return {
					results: $.map(data, function (item) {
						return {
							id: item.section_code,
							text: item.section_code + " - " + item.section_name,
						};
					}),
				};
			},
			cache: true,
		},
		minimumInputLength: 2,
		placeholder: "Select Item",
		allowClear: true,
	});
	$(".k3_admin_monitorbon").select2({});

	$("#p2k3_addPkj").click(function () {
		// var ks = kodesie;
		// var angka;

		var d = new Date();
		var n = d.getDate();
		if (jmlOrder == "true") {
			// Swal.fire({
			//   type: 'error',
			//   title: 'Anda Sudah Order!',
			//   text: 'Order hanya dapat dilakukan sekali dalam satu periode!',
			//   animation: false,
			//     // showCancelButton: true,
			//     customClass: {
			//       popup: 'animated shake'
			//     }
			//   })
			$(".modal-title").text("Anda Sudah Order!");
			$("#p2k3_mb").text("Order hanya dapat dilakukan sekali dalam satu periode!");
			$("#p2k3_modal").modal("show");
		} else if (n > 10) {
			// Swal.fire({
			//   type: 'error',
			//   title: 'Anda Terlambat Order!',
			//   text: 'Order dapat Dilakukan di Tanggal 1 - 10',
			//   animation: false,
			//     // showCancelButton: true,
			//     customClass: {
			//       popup: 'animated tada'
			//     }
			//   })
			$(".modal-title").text("Anda Terlambat Order!");
			$("#p2k3_mb").text("Order dapat Dilakukan di Tanggal 1 - 10");
			$("#p2k3_modal").modal("show");
		} else {
			window.location.replace(baseurl + "P2K3_V2/Order/reset");
		}
	});

	$("#pemakai_2s").select2({
		ajax: {
			url: baseurl + "P2K3_V2/Order/searchOracle",
			dataType: "json",
			type: "get",
			data: function (params) {
				return { s: params.term };
			},
			processResults: function (data) {
				return {
					results: $.map(data, function (item) {
						return {
							id: item.COST_CENTER,
							text: item.COST_CENTER + " - " + item.PEMAKAI,
						};
					}),
				};
			},
			cache: true,
		},
		placeholder: "Select Item",
		allowClear: true,
	});

	$("#pemakai_2").change(function () {
		$("#surat-loading").attr("hidden", false);
		var value = $(this).val();
		var hm = value.split("/");
		value = hm[0];
		$.ajax({
			type: "POST",
			data: { pemakai_2: value },
			url: baseurl + "P2K3_V2/Order/pemakai_2",
			success: function (result) {
				a = result.split("|");
				$("#cost_center").val(a[0]);
				$("#kodCab1").val(a[1]);
				$("#surat-loading").attr("hidden", true);
				$("#cost_center").trigger("change");
			},
		});
	});

	$("#p2k3_lokasi").change(function () {
		$("#surat-loading").attr("hidden", false);
		var value = $(this).val();
		$("#p2k3_gudang").select2("val", null);
		$("#p2k3_gudang").prop("disabled", true);
		$.ajax({
			type: "POST",
			data: { lokasi_id: value },
			url: baseurl + "P2K3_V2/Order/gudang",
			success: function (result) {
				$("#surat-loading").attr("hidden", true);
				if (result != "<option></option>") {
					$("#p2k3_gudang").prop("disabled", false).html(result);
					$("#p2k3_gudang").closest("div").addClass("bg-danger");
					$("#kode_barang").closest("div").removeClass("bg-danger");
				} else {
					$("#p2k3_gudang").closest("div").removeClass("bg-danger");
					$("#kode_barang").closest("div").addClass("bg-danger");
					$("#kode_barang").removeAttr("disabled");
				}
			},
		});
	});

	$("#p2k3_gudang").change(function () {
		$("#surat-loading").attr("hidden", false);
		$("#p2k3_locator").select2("val", null);
		$("#p2k3_locator").prop("disabled", true);
		var value = $(this).val();
		$.ajax({
			type: "POST",
			data: { gudang_id: value },
			url: baseurl + "P2K3_V2/Order/lokator",
			success: function (result) {
				$("#surat-loading").attr("hidden", true);
				if (result != "<option></option>") {
					$("#p2k3_locator").closest(".form-group").show();
					$("#p2k3_locator").prop("disabled", false).html(result);
				} else {
					$("#p2k3_locator").closest(".form-group").hide();
				}
			},
		});
	});

	// $('#cost_center').change(function(){

	// });
});

$(document).on("ifChecked", ".p2k3_chkAll", function () {
	$(".p2k3_chk").iCheck("check");
});
$(document).on("ifUnchecked", ".p2k3_chkAll", function () {
	$(".p2k3_chk").iCheck("uncheck");
});

/* Formatting function for row details - modify as you need */
function format(d) {
	// `d` is the original data object for the row
	return '<div class="slider">' + '<table class="table table-xs table-bordered">' + '<thead class="bg-info">' + "<tr>" + "<td>Kode Item</td>" + "<td>Nama Item</td>" + "<td>Jumlah Bon</td>" + "<td>Satuan</td>" + "</tr>" + "</thead>" + "<tbody>" + "<tr>" + "<td>" + d.kode_barang + "</td>" + "<td>" + d.nama_apd + "</td>" + "<td>" + d.jml_bon + "</td>" + "<td>" + d.satuan + "</td>" + "<tr>" + "<tbody>" + "</table>" + "</div>";
}

$(document).ready(function () {
	var table = $(".p2k3s_monitoringbon").DataTable({
		// "ajax": baseurl+"p2k3adm_V2/Admin/ajaxRow/"+kodes+"/"+period,
		columns: [
			{
				className: "details-control",
				orderable: false,
				data: null,
				defaultContent: "",
			},
			{ data: "no_bon" },
			{ data: "tgl_bon" },
			{ data: "seksi_pengebon" },
			{ data: "tujuan_gudang" },
			{ data: "keterangan" },
		],
	});

	// Add event listener for opening and closing details
	$(".p2k3_monitoringbon tbody").on("click", "td.details-control", function () {
		var tr = $(this).closest("tr");
		var row = table.row(tr);

		if (row.child.isShown()) {
			// This row is already open - close it
			$("div.slider", row.child()).slideUp(function () {
				row.child.hide();
				tr.removeClass("shown");
			});
		} else {
			// Open this row
			row.child(format(row.data()), "no-padding").show();
			tr.addClass("shown");
			$("div.slider", row.child()).slideDown();
		}
	});

	$(".p2k3_row_swow").click(function () {
		var val = $(this).closest("td").find("input").val();
		var clas = "p2k3_row" + val;
		// alert(clas);
		$("." + clas).slideToggle("slow");
		// $("."+clas).css('display', 'block');
		var clas2 = $(this).find("img").attr("class");
		// alert (clas2);
		if (clas2 == "1") {
			$(this).find("img").attr("src", "../../assets/img/icon/details_close.png");
			$(this).find("img").attr("class", "2");
		} else {
			$(this).find("img").attr("src", "../../assets/img/icon/details_open.png");
			$(this).find("img").attr("class", "1");
		}
	});

	$(".p2k3_btn_bon").click(function () {
		var a = "0";
		var b = "0";
		var c = "0",
			item = "",
			stokgudang = "";
		$(".p2k3_inHasil").each(function () {
			if ($(this).val() < 0) {
				a = "1";
			}
		});
		$(".p2k3_inBon").each(function () {
			//cek jumlah apakah 0 semua
			// alert($(this).val());
			if ($(this).val() > 0) {
				b = "1";
				// alert('as');
			}
		});

		$(".p2k3_inBon").each(function () {
			// cek jumlah apakah melebihi stok gudang
			var stokg = $(this).closest("tr").find("p.p2k3_stokg").text();
			if ($(this).val() > Number(stokg)) {
				c = "1";
				item = $(this).closest("tr").find("a.p2k3_see_apd_text").text();
				stokgudang = stokg;
				// alert('as');
			}
		});

		if (a == "1") {
			Swal.fire({
				type: "error",
				title: "Oops...",
				text: "Jumlah Bon Melebihi dari Sisa Saldo yang di Inputkaan!",
			});
			return false;
		} else if (b == "0") {
			Swal.fire({
				type: "error",
				title: "Oops...",
				text: "Semua Jumlah Bon 0!",
			});
			return false;
		} else if (c == "1") {
			Swal.fire({
				type: "error",
				title: "Oops...",
				text: "Jumlah Item " + item + " tidak boleh Melebihi jumlah Stok Gudang (" + stokgudang + ") !",
			});
			return false;
		}
	});

	$(".et_add_email").click(function () {
		Swal.fire({
			title: "Input email address",
			input: "email",
			allowOutsideClick: false,
			allowEscapeKey: false,
			showCancelButton: true,
			inputPlaceholder: "Enter your email address",
		}).then(function (result) {
			if (result.value) {
				$("#surat-loading").attr("hidden", false);
				$.ajax({
					type: "POST",
					url: baseurl + "p2k3adm_V2/Admin/addEmail",
					data: { email: result.value },
					success: function (response) {
						location.reload();
					},
				});
			}
		});
	});

	$(".et_edit_email").click(function () {
		var em = $(this).closest("tr").find("td.et_em").text();
		var id = $(this).closest("tr").find("input").val();
		Swal.fire({
			title: "Input email address",
			input: "email",
			allowOutsideClick: false,
			allowEscapeKey: false,
			showCancelButton: true,
			inputValue: em,
			inputPlaceholder: "Enter your email address",
		}).then(function (result) {
			if (result.value) {
				$("#surat-loading").attr("hidden", false);
				$.ajax({
					type: "POST",
					url: baseurl + "p2k3adm_V2/Admin/editEmail",
					data: { email: result.value, id: id },
					success: function (response) {
						location.reload();
					},
				});
			}
		});
	});

	$(".et_del_email").click(function () {
		var em = $(this).closest("tr").find("td.et_em").text();
		var id = $(this).closest("tr").find("input").val();
		Swal.fire({
			allowOutsideClick: false,
			allowEscapeKey: false,
			showCancelButton: true,
			title: em,
			text: "Apa anda yakin ingin Menghapus Email Ini?",
			type: "warning",
			focusCancel: true,
		}).then(function (result) {
			if (result.value) {
				$("#surat-loading").attr("hidden", false);
				$.ajax({
					type: "POST",
					url: baseurl + "p2k3adm_V2/Admin/hapusEmail",
					data: { id: id },
					success: function (response) {
						location.reload();
					},
				});
			}
		});
	});

	$(".p2k3_detail_seksi").click(function () {
		var ks = $(this).val();
		$("#surat-loading").attr("hidden", false);
		$.ajax({
			url: baseurl + "P2K3_V2/Order/getJumlahPekerja",
			method: "POST",
			data: { ks: ks },
			success: function (data) {
				$("#phone_result").html(data);
				$("#surat-loading").attr("hidden", true);
				$("#p2k3_detail_pekerja").modal("show");
			},
			error: function (xhr, ajaxOptions, thrownError) {
				$.toaster(xhr + "," + ajaxOptions + "," + thrownError);
			},
		});
	});

	$(".p2k3_detail_seksi_hitung").click(function () {
		var ks = $(this).val();
		var periodehitung = $(".p2k3_tanggal_periode").val();
		$("#surat-loading").attr("hidden", false);
		$.ajax({
			url: baseurl + "p2k3adm_V2/Admin/getDetailSeksi",
			method: "POST",
			data: {
				ks: ks,
				pr: periodehitung,
			},
			success: function (data) {
				$("#phone_result_seksi_hitung").html(data);
				$("#surat-loading").attr("hidden", true);
				$("#p2k3_detail_seksi_hitung").modal("show");
				const table = $("#tbl_detailHitungOrderSeksi").DataTable({
					dom: "frtp",
					scrollX: true,
					scrollY: 400,
					paging: false,
					ordering: false,
					initComplete() {
						setTimeout(() => {
							$($.fn.dataTable.tables(true)).DataTable().columns.adjust();
						}, 800);
					},
				});
			},
			error: function () {
				$("#phone_result_seksi_hitung").html('Data Masih Kosong Pada Bulan Tersebut');
				$("#surat-loading").attr("hidden", true);
				$("#p2k3_detail_seksi_hitung").modal("show");
			},
		});
	});

	$(".p2k3_cek_hitung").click(function () {
		var pr = $(".p2k3_tanggal_periode").val();
		var ks = $(".k3_admin_monitorbon").val();
		$("#surat-loading").attr("hidden", false);
		$.ajax({
			url: baseurl + "p2k3adm_V2/Admin/cekHitung",
			method: "POST",
			data: { pr: pr, kodesie: ks },
			success: function (data) {
				$("#p2k3_result").html(data);
				$("#surat-loading").attr("hidden", true);
				$("#p2k3_cekError").modal("show");
				// alert(data.indexOf('center'));
				if (data.indexOf("center") > 10) {
					$(".p2k3_submit_hitung").css("cursor", "not-allowed");
					$(".p2k3_submit_hitung").attr("data-original-title", "Ada Error Pada data. Harap perbaiki sebelum melanjutkan");
					$(".p2k3_submit_hitung").attr("type", "button");
				} else {
					$(".p2k3_submit_hitung").css("cursor", "pointer");
					$(".p2k3_submit_hitung").attr("data-original-title", "Data Aman klik untuk Melanjutkan");
					$(".p2k3_submit_hitung").attr("type", "submit");
				}
			},
			error: function (xhr, ajaxOptions, thrownError) {
				$.toaster(xhr + "," + ajaxOptions + "," + thrownError);
			},
		});
	});

	$(".p2k3_select2").select2({
		allowClear: false,
	});

	$(".p2k3_select2Item").select2({
		allowClear: false,
		placeholder: "Pilih Item",
		minimumInputLength: 2,
	});

	$(".et_edit_masterItem").click(function () {
		var kode = $(this).closest("tr").find("td.et_kode").text();
		var nama = $(this).closest("tr").find("td.et_item").text();
		var bulan = $(this).closest("tr").find("td.et_exbulan").text();
		$("#p2k3_kode_item").val(kode);
		$("#p2k3_kode_item2").val(kode);
		$("#p2k3_nama_item").val(nama);
		$("#p2k3_bulan_item").val(bulan);
		$("#p2k3_edit_item").modal("show");
	});

	$(".p2k3_see_image").click(function () {
		var file = $(this).val();
		var nama = $(this).attr("data-nama");
		var kode = $(this).attr("data-kode");
		// alert(file);
		Swal.fire({
			// title: file,
			// text: kode+' - '+nama,
			html: "<b>" + kode + " - " + nama + "</b>",
			imageUrl: baseurl + "assets/upload/P2K3/item/" + file,
			// imageWidth: 600,
			// imageHeight: 400,
			imageAlt: file,
			animation: false,
		});
	});

	$(".p2k3_select2Item").change(function () {
		var satuan = $("option:selected", this).attr("data-satuan");
		// alert(satuan);
		$("#p2k3_setItem").val(satuan);
	});

	$(document).on("click", ".p2k3_to_input", function () {
		// alert($(this).closest('tr').find('input').val());
		$(this).closest("tr").find("input.p2k3_see_apd").trigger("click");
	});

	$(document).on("click", ".p2k3_see_apd_text", function () {
		var vall = $(this).text();
		$("#surat-loading").attr("hidden", false);
		$.ajax({
			type: "POST",
			url: baseurl + "p2k3adm_V2/Admin/getFoto",
			data: { id: vall },
			beforeSend: () => {
				swal.fire({
					title: `Loading Gambar Apd ...`,
					imageUrl: `${baseurl}assets/img/gif/loading99.gif`,
					showConfirmButton: false,
					allowOutsideClick: false
				})
			},
			success: function (response) {
				// alert(response['foto']);
				$("#surat-loading").attr("hidden", true);
				if (response["foto"] == "-") {
					Swal.fire({
						html: "<b>Foto tidak di Temukan</b>",
						imageUrl: baseurl + "assets/img/notFound.png",
						imageAlt: "not found",
						animation: false,
					});
				} else {
					var file = response["foto"];
					Swal.fire({
						html: "<b>" + response["kode"] + " - " + response["nama"] + "</b>",
						imageUrl: baseurl + "assets/upload/P2K3/item/" + file,
						imageAlt: file,
						animation: false,
					});
				}
			},
		});
	});
});
function p2k3_val() {
	var max = $("#pw2k3_maxpkj").val();
	var staf = $("input[name='staffJumlah']").val();
	var values = $("input[name='pkjJumlah\\[\\]']")
		.map(function () {
			return $(this).val();
		})
		.get();
	var jumlah = Number(staf);

	for (var i = 0; i < values.length; i++) {
		jumlah += Number(values[i]);
	}
	// alert(jumlah);
	if (jumlah > Number(max)) {
		Swal.fire({
			type: "error",
			title: "Jumlah Pekerja Melebihi Batas",
			text: "Maksimal Jumlah Pekerja adalah " + max,
		});
		return false;
	} else {
		return true;
	}
}

$(document).on("click", ".p2k3_see_apd", function () {
	var nama = $(this).closest("tr").find("select.apd-select2").text();
	nama = $.trim(nama);
	// console.log(nama);
	var vall = $(this).val();
	if (vall.length < 2) {
		// alert(vall);
	} else {
		$("#surat-loading").attr("hidden", false);
		$.ajax({
			type: "POST",
			url: baseurl + "p2k3adm_V2/Admin/getFoto",
			data: { id: vall },
			success: function (response) {
				// alert(response['foto']);
				$("#surat-loading").attr("hidden", true);
				if (response["foto"] == "-") {
					Swal.fire({
						html: "<b>Foto tidak di Temukan</b>",
						imageUrl: baseurl + "assets/img/notFound.png",
						imageAlt: "not found",
						animation: false,
					});
				} else {
					var file = response["foto"];
					Swal.fire({
						html: "<b>" + vall + " - " + response["nama"] + "</b>",
						imageUrl: baseurl + "assets/upload/P2K3/item/" + file,
						imageAlt: file,
						animation: false,
					});
				}
			},
		});
	}
});

$(document).ready(function () {
	$(".et_add_email_seksi").click(function () {
		Swal.fire({
			title: "Input email address",
			input: "email",
			allowOutsideClick: false,
			allowEscapeKey: false,
			showCancelButton: true,
			inputPlaceholder: "Enter your email address",
		}).then(function (result) {
			if (result.value) {
				$("#surat-loading").attr("hidden", false);
				$.ajax({
					type: "POST",
					url: baseurl + "P2K3_V2/Order/addEmailSeksi",
					data: { email: result.value },
					success: function (response) {
						location.reload();
					},
				});
			}
		});
	});

	$(".et_edit_email_seksi").click(function () {
		var em = $(this).closest("tr").find("td.et_em").text();
		var id = $(this).closest("tr").find("input").val();
		Swal.fire({
			title: "Input email address",
			input: "email",
			allowOutsideClick: false,
			allowEscapeKey: false,
			showCancelButton: true,
			inputValue: em,
			inputPlaceholder: "Enter your email address",
		}).then(function (result) {
			if (result.value) {
				$("#surat-loading").attr("hidden", false);
				$.ajax({
					type: "POST",
					url: baseurl + "P2K3_V2/Order/editEmailSeksi",
					data: { email: result.value, id: id },
					success: function (response) {
						location.reload();
					},
				});
			}
		});
	});

	$(".et_del_email_seksi").click(function () {
		var em = $(this).closest("tr").find("td.et_em").text();
		var id = $(this).closest("tr").find("input").val();
		Swal.fire({
			allowOutsideClick: false,
			allowEscapeKey: false,
			showCancelButton: true,
			title: em,
			text: "Apa anda yakin ingin Menghapus Email Ini?",
			type: "warning",
			focusCancel: true,
		}).then(function (result) {
			if (result.value) {
				$("#surat-loading").attr("hidden", false);
				$.ajax({
					type: "POST",
					url: baseurl + "P2K3_V2/Order/hapusEmailSeksi",
					data: { id: id },
					success: function (response) {
						location.reload();
					},
				});
			}
		});
	});

	$(".p2k3_tbl_frezz").DataTable({
		dom: "frtp",
		scrollX: true,
		paging: false,
		// scrollX: "100%",
		ordering: false,
		scrollCollapse: true,
		fixedColumns: {
			leftColumns: 4,
		},
	});

	$(".p2k3_tbl_frezz_nos").DataTable({
		dom: "frtp",
		// scrollX: true,
		paging: false,
		// scrollX: "100%",
		ordering: false,
		scrollCollapse: true,
		fixedColumns: {
			leftColumns: 4,
		},
	});

	$(".dataTable_p2k3Frezz_noOrder").DataTable({
		dom: "frtp",
		scrollX: true,
		ordering: false,
		fixedColumns: {
			leftColumns: 3,
		},
	});

	$(".p2k3_tbl_datamasuk").DataTable();

	$(".p2k3_tanggal_periode").change(function () {
		var d = new Date();
		var n = d.getFullYear();
		var m = d.getMonth() + 01;
		var v = $(this).val().split(" - ");
		if (v[1] < n) {
			alert("Periode tidak boleh lebih kecil dari bulan sekarang");
			$(this).val(pad(m) + " - " + n);
		} else if (v[1] > n) {
			//oke
		} else if (v[0] < m) {
			alert("Periode tidak boleh lebih kecil dari bulan sekarang");
			$(this).val(pad(m) + " - " + n);
		}
	});
});

function erp_checkPopUp() {
	setTimeout(function () {
		var newWin = window.open(url);
		if (!newWin || newWin.closed || typeof newWin.closed == "undefined") {
			alert("Popup Tidak Aktif (Blocked)!\nMohon Aktifkan Pop up Untuk melanjutkan, lalu refresh/reload Halaman ini!");
			$("#p2k3_popup").modal({ backdrop: "static", keyboard: false });
		} else {
			newWin.close();
		}
	}, 500);
}

function pad(d) {
	return d < 10 ? "0" + d.toString() : d.toString();
}

//Kecelakaan Kerja
$(document).ready(function () {
	$("#apdtblmkk").DataTable({
		scrollX: true,
		fixedColumns: {
			leftColumns: 3,
		},
	});
	getPekerjaTpribadi("#apdslcpic");

	$("#apdslcpkj").change(function () {
		var noind = $(this).val();
		$("#surat-loading").attr("hidden", false);
		$.ajax({
			type: "get",
			url: baseurl + "p2k3adm_V2/Admin/detail_pkj_mkk",
			data: {
				noind: noind,
			},
			success: function (response) {
				var d = JSON.parse(response);
				$('[name="seksi"]').val(d["seksi"].trim());
				$('[name="unit"]').val(d["unit"].trim());
				$('[name="bidang"]').val(d["bidang"].trim());
				$('[name="dept"]').val(d["dept"].trim());
			},
			complete: function (response) {
				$("#surat-loading").attr("hidden", true);
			},
		});
	});

	$("#apdslcpic").change(function () {
		var noind = $(this).val();
		if (noind == null || noind == "") {
			$('[name="seksi_car"]').val("");
			$('[attr-name="seksi_car"]').val("");
			return false;
		}
		$("#surat-loading").attr("hidden", false);
		$.ajax({
			type: "get",
			url: baseurl + "p2k3adm_V2/Admin/detail_pkj_mkk",
			data: {
				noind: noind,
			},
			success: function (response) {
				var d = JSON.parse(response);
				$('[name="seksi_car"]').val(d["seksi"].trim());
				$('[attr-name="seksi_car"]').val(d["seksi"].trim());
			},
			complete: function (response) {
				$("#surat-loading").attr("hidden", true);
			},
		});
	});

	$(".daterangepickerYMDhis").daterangepicker({
		singleDatePicker: true,
		drops: "up",
		timePicker: true,
		timePicker24Hour: true,
		showDropdowns: true,
		locale: {
			format: "YYYY-MM-DD HH:mm:ss",
		},
	});

	$(".daterangepickerYMD").daterangepicker({
		singleDatePicker: true,
		drops: "up",
		timePicker: false,
		showDropdowns: true,
		autoApply: true,
		autoUpdateInput: false,
		locale: {
			cancelLabel: "Clear",
			format: "YYYY-MM-DD",
		},
	});

	$(".daterangepickerYMD").on("apply.daterangepicker", function (ev, picker) {
		$(this).val(picker.startDate.format("YYYY-MM-DD"));
		$(this).change();
	});
	$(".daterangepickerYMD").on("cancel.daterangepicker", function (ev, picker) {
		$(this).val("");
		$(this).change();
	});

	$("#apdinptglkc").change(function () {
		var tgl = $(this).val();
		var noind = $("#apdslcpkj").val();
		if (noind == "" || noind == null) {
			alert("Pilih Pekerja terlebih dahulu!");
			return false;
		}
		$("#surat-loading").attr("hidden", false);
		$.ajax({
			type: "get",
			url: baseurl + "p2k3adm_V2/Admin/ket_mkk",
			data: {
				tgl: tgl,
				noind: noind,
			},
			success: function (response) {
				var data = JSON.parse(response);
				console.log(data["success"]);
				if (data["success"] == "1") {
					// $('[name="range1"]').val(data['ket1']);
					// $('[name="range2"]').val(data['ket2']);
					$(".apdinprngwkt1mkk, .apdinprngwkt2mkk").each(function () {
						$(this).iCheck("uncheck");
					});
					$(".apdinprngwkt1mkk")
						.eq(data["rng1"] - 1)
						.iCheck("check");
					$(".apdinprngwkt2mkk")
						.eq(data["rng2"] - 1)
						.iCheck("check");
					$('[name="masa_kerja"]').val(data["masa_kerja"]);
					$('[attr-name="masa_kerja"]').val(data["masa_kerja"]).trigger("change");
				}
			},
			complete: function (response) {
				$("#surat-loading").attr("hidden", true);
			},
		});
	});

	$(".apdSlcTags").select2({
		placeholder: "Masukan TKP",
		tags: true,
	});

	$(".apd_select2").select2({
		placeholder: "Pilih Salah Satu!",
	});

	$("#apdslcmkkloker").change(function () {
		var id = $(this).val();
		return true;
		// alert(id);
		if (id == "999") {
			$('input[type="radio"], input[type="checkbox"]').each(function () {
				// $(this).attr('checked', false);
				$(this).iCheck("uncheck");
				$(this).iCheck("disable");
				$(this).closest("label").css("color", "grey");
				// $(this).closest('div').attr('disabled', true);
			});
		} else {
			// alert('a');
			$('input[type="radio"], input[type="checkbox"]').each(function () {
				// alert('n');
				$(this).closest("label").css("color", "black");
				$(this).iCheck("enable");
				// return false;
			});
		}
	});

	$("#apddivaddmkk").on("click", ".iradio_square-green", function (event) {
		if ($(this).hasClass("checked")) {
			event.stopImmediatePropagation();
			$(this).removeClass("checked");
			$(this).find("input").attr("checked", false);
		}
	});

	$(document).on("ifClicked", ".apdinpjpmkk", function () {
		$(".apdinpjpmkk").each(function () {
			$(this).iCheck("uncheck");
		});
	});
	$(document).on("ifClicked", ".apdinpprosmkk", function () {
		$(".apdinpprosmkk").each(function () {
			$(this).iCheck("uncheck");
		});
	});
	$(document).on("ifClicked", ".apdinpunsmkk", function () {
		$(".apdinpunsmkk").each(function () {
			$(this).iCheck("uncheck");
		});
	});
	$(document).on("ifClicked", ".apdinpkssmkk", function () {
		$(".apdinpkssmkk").each(function () {
			$(this).iCheck("uncheck");
		});
	});
	$(document).on("ifClicked", ".apdinprngwkt1mkk", function () {
		$(".apdinprngwkt1mkk").each(function () {
			$(this).iCheck("uncheck");
		});
	});
	$(document).on("ifClicked", ".apdinprngwkt2mkk", function () {
		$(".apdinprngwkt2mkk").each(function () {
			$(this).iCheck("uncheck");
		});
	});

	$(document).on("click", ".apdbtndelmkk", function () {
		var id = $(this).val();
		var pkj = $(this).attr("pkj");
		Swal.fire({
			title: "Anda Yakin?",
			text: "Hapus Data " + pkj + "?",
			type: "warning",
			showCancelButton: true,
		}).then(function (result) {
			if (result.value) {
				$.ajax({
					type: "post",
					url: baseurl + "p2k3adm_V2/Admin/del_k3k",
					data: {
						id: id,
					},
					success: function (response) {
						location.reload();
					},
					complete: function (response) {
						$("#surat-loading").attr("hidden", true);
					},
				});
			}
		});
	});

	$("#apdslclstkp").select2({
		ajax: {
			url: baseurl + "p2k3adm_V2/Admin/get_tkp",
			dataType: "json",
			type: "get",
			data: function (params) {
				return { s: params.term };
			},
			processResults: function (data) {
				return {
					results: $.map(data, function (item) {
						return {
							id: item.tkp,
							text: item.tkp,
						};
					}),
				};
			},
			cache: false,
		},
		minimumInputLength: -1,
		tags: true,
		placeholder: "Select Item",
		allowClear: true,
	});

	$("#apd_yearonly").datepicker({
		autoclose: true,
		todayHighlight: true,
		format: "yyyy",
		viewMode: "years",
		minViewMode: "years",
	});

	$("#apdmkkbyyear").click(function () {
		var y = $("#apd_yearonly").val();
		window.location.replace(baseurl + "p2k3adm_V2/Admin/monitoringKK?y=" + y);
	});

	$(".apd_delbonspt").click(function () {
		var id = $(this).val();
		$("#apd_mdldelspt").find("#apd_btnsubdelspt").val(id);
		$("#apd_mdldelspt").modal("show");
	});
});

function InitK3kForm() {
	// $('input').iCheck({
	// 	labelHover: false,
	// 	cursor: true,
	// 	checkboxClass: 'icheckbox_square-green',
	// 	radioClass: 'iradio_square-green',
	// 	increaseArea: '20%'
	// });
	var changed = false;
	$("textarea, select, input").change(function () {
		changed = true;
	});
	$(document).on("ifChanged", "input", function () {
		changed = true;
	});
	$("#apdbtnupdatemkk").click(function () {
		changed = false;
	});
	$(window).bind("beforeunload", function () {
		if (changed) {
			return "Are you sure you want to leave?";
		}
	});
}

function InitK3kFormEdit() {
	$("textarea, select, input").change(function () {
		var nm = $(this).attr("attr-name");
		$(this).attr("name", nm);
		$("#apdbtnupdatemkk").attr("disabled", false);
	});
	$(document).on("ifChanged", "input", function () {
		var nm = $(this).attr("attr-name");
		$(this).attr("name", nm);
		$("#apdbtnupdatemkk").attr("disabled", false);
	});
}

function apd_alert_mixin(icon, title) {
	const Toast = Swal.mixin({
		toast: true,
		background: "#ebfff0",
		position: "center",
		showConfirmButton: false,
		timer: 5000,
		width: 500,
		timerProgressBar: true,
		onOpen: (toast) => {
			toast.addEventListener("mouseenter", Swal.stopTimer);
			toast.addEventListener("mouseleave", Swal.resumeTimer);
		},
	});

	Toast.fire({
		type: icon,
		title: title,
	});
}

$(document).ready(function () {
	$("#apd_btnceknoBon").click(function () {
		$("#surat-loading").attr("hidden", false);
		var id = $("#apd_inpnobon").val();
		$.ajax({
			type: "get",
			url: baseurl + "P2K3_V2/Order/checkNobon",
			data: {
				nobon: id,
			},
			success: function (response) {
				var d = JSON.parse(response);
				if (d.error == "1") {
					showSwal(d);
				} else {
					$("#apd_table-shoes tbody").html(d.tr);
					$("#apd_inpnobon").attr("disabled", true);
					$("#apd_submit_bonM").attr("disabled", false);
					$("#apd_submit_bonM").val(id);
					$("#apd_btnceknoBon").off("click");
					$("#apd_btnceknoBon").attr("disabled", true);
				}
			},
			complete: function (response) {
				$("#surat-loading").attr("hidden", true);
			},
		});
	});

	$("#apd_submit_bonM").click(function () {
		var id = $(this).val();
		Swal.fire({
			type: "question",
			title: "Insert Data Nomor Bon " + id + " ?",
			showCancelButton: true,
		}).then(function (result) {
			if (result.value) {
				$("#surat-loading").attr("hidden", false);
				$.ajax({
					type: "POST",
					url: baseurl + "P2K3_V2/Order/insertBonManual",
					data: { nobon: id },
					success: function (response) {
						location.reload();
					},
				});
			}
		});
	});

	$(".apd_slccostc").select2({
		placeholder: "Pilih Seksi Pemakai",
	});
});

function showSwal(d) {
	Swal.fire({
		type: d.type,
		title: d.pesan,
		animation: false,
		customClass: {
			popup: "animated tada",
		},
	});
}

$(document).ready(function () {
	$('.tbl_periodeSafetyShoes').DataTable();

	$(".btn_editPeriodeSafetyShoes").click(function () {
		var kodesie = $(this).closest("tr").find("td.ess_kodesie").text();
		var seksi = $(this).closest("tr").find("td.ess_seksi").text();
		var periode = $(this).closest("tr").find("td.ess_periode").text();

		$("#editSafetyShoes_Kodesie").val(kodesie.substring(0, 7));
		$("#editSafetyShoes_Kodesie2").val(kodesie);
		$("#editSafetyShoes_Seksi").val(seksi);
		$("#editSafetyShoes_Periode").val(periode);
		$("#editSafetyShoes_Modal").modal("show");
	});
});

//-------------// 16-Maret-2021 - Akbar Sani Hasan Order #518177 //-------------//
$('.apd-staff').on('click', function () {
	let kodeSie = $(this).data('ks')
	$.ajax({
		url: `${baseurl}p2k3adm_V2/Admin/ajax/ajaxGetKebStaff`,
		method: 'get',
		dataType: 'json',
		data: {
			kodeSie
		},
		beforeSend: () => {
			swal.fire({
				title: `Loading Gambar Apd ...`,
				imageUrl: `${baseurl}assets/img/gif/loading99.gif`,
				showConfirmButton: false,
				allowOutsideClick: false
			})
		},
		success: res => {
			swal.fire({
				title: `STAFF`,
				confirmButtonText: "Ok",
				allowOutsideClick: "true",
				imageUrl: false,
				animation: false
			})
			const fotoel = `
				<div class="apd-wrapper">
					${res.filter(item => item.jml_kebutuhan_staff > 0).sort((a, b) => a.urutan - b.urutan)
					.map(it => `
							<div class="apd-container">
								<img style="width:60px; margin-bottom:20px;" src="${baseurl}assets/upload/P2K3/item/${it.nama_file}?>" alt="${it.nama_file}"></img>
								<h5>${it.item}</h5>
							</div>`).join('')}
							<img style="width:70px; grid-column:2/3; grid-row:${Math.round((Math.round(((res.filter(item => item.jml_kebutuhan_staff > 0).length) + 1) / 3) + 1) / 2)}/${Math.ceil((Math.ceil(((res.filter(item => item.jml_kebutuhan_staff > 0).length) + 1) / 3) + 1) / 2) + 1};"  src="${baseurl}assets/img/pegawaiKHS/PegawaiKHS-Staff.png"></img>
					</div>`
			$('.swal2-content').html(fotoel)
		},
		error: () => {
			swal.fire({
				type: 'error',
				title: 'error',
				text: 'Error Dalam Mengambil Gambar, Harap Coba Kembali'
			})
		}
	})
})

$('.apd-pekerja').each(function () {
	$(this).on('click', function () {
		let kdPekerjaan = $(this).data('kp')
		let kodeSie = $(this).data('ks')
		let pekerjaan = $(this).text().toUpperCase()
		console.log(kodeSie)
		$.ajax({
			url: `${baseurl}p2k3adm_V2/Admin/ajax/ajaxGetKebSet`,
			method: 'get',
			dataType: 'json',
			data: {
				kodeSie,
				kdPekerjaan
			},
			beforeSend: () => {
				swal.fire({
					title: `Loading Gambar Apd ...`,
					imageUrl: `${baseurl}assets/img/gif/loading99.gif`,
					showConfirmButton: false,
					allowOutsideClick: false
				})
			},
			success: res => {
				console.log(baseurl)
				swal.fire({
					title: `${pekerjaan}`,
					confirmButtonText: "Ok",
					allowOutsideClick: "true",
					imageUrl: false,
					animation: false
				})
				if (res.length > 0) {
					let fotoel = `
						<div class="apd-wrapper">
							${res.filter(item => item.jml_item > 0).sort((a, b) => a.urutan - b.urutan)
							.map(it => `
									<div class="apd-container">
										<img style="width:60px; margin-bottom:20px;" src="${baseurl}assets/upload/P2K3/item/${it.nama_file}?>" alt="${it.nama_file}"></img>
										<h5>${it.item}</h5>
									</div>`).join('')}
									<img style="width:70px; grid-column:2/3; grid-row:${Math.round((Math.floor(((res.filter(item => item.jml_item > 0).length) + 1) / 3) + 1) / 2)}/${Math.ceil((Math.ceil(((res.filter(item => item.jml_item > 0).length) + 1) / 3) + 1) / 2) + 1};" src="${baseurl}assets/img/pegawaiKHS/PegawaiKHS-Operator.png"></img>
							</div>`

					$('.swal2-content').html(fotoel)
				} else {
					$('.swal2-content').html('Gambar Apd Tidak Ditemukan')
				}
			},
			error: () => {
				swal.fire({
					type: 'error',
					title: 'error',
					text: 'Error Dalam Mengambil Gambar, Harap Coba Kembali'
				})
			}
		})
	})
})