"use strict";
/**
 * @DOCUMENTATION
 * THIS IS JAVASCRIPT FILE FOR VIVIL MAINTENANCE ORDER APPS
 * @url /civil-maintenace-order
 *
 * please write with OOP or Write query selector with that element
 * please write a clear class element
 * example -> table, detail, jenis
 * you don't need write specific class name :(, it will make a code is not dry
 * write using scope please, es6, OOP, scope, es6 variable
 *
 * "Its hard to maintenance than creating"
 */

// experimental
/**
 * @return String
 */
const get_slug = () => {
	return window.location.href.replace(baseurl, "");
};
/**
 * @return Boolean
 */
const url_validation = (url) => {
	return get_slug().includes(url);
};

$(document).ready(function () {
	$("#CMOtblJpkj").DataTable();
	$("#CMOtblJpkjDetail").DataTable();

	$(".textareaMCO").redactor({
		imageUpload: baseurl + "civil-maintenance-order/order/upload_imageChat",
		imageUploadErrorCallback(json) {
			alert(json.error);
		},
	});

	$("#CMO_tblJnsOrder").on("click", ".cmo_setApprove", function () {
		const val = $(this).attr("data-id");

		Swal.fire({
			title: "Anda yakin ingin melakukan Approve ?",
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: "#55b055",
			confirmButtonText: "OK",
		}).then((result) => {
			if (result.value) {
				$.ajax({
					url: baseurl + "civil-maintenance-order/order/setApproveOrder",
					type: "POST",
					data: {
						id: val,
						status: 1,
					},
					success: function (data) {
						mcc_showAlert("success", "Berhasil Mengupdate Data");
						window.location.reload();
					},
					error: function (request, error) {
						alert("Request: " + JSON.stringify(request));
					},
				});
			}
		});
	});

	$("#CMO_tblJnsOrder").on("click", ".cmo_setReject", function () {
		const val = $(this).attr("data-id");

		Swal.fire({
			title: "Anda yakin ingin melakukan Reject ?",
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: "#ff3333",
			confirmButtonText: "OK",
		}).then((result) => {
			if (result.value) {
				$.ajax({
					url: baseurl + "civil-maintenance-order/order/setApproveOrder",
					type: "POST",
					data: {
						id: val,
						status: 2,
					},
					success(data) {
						mcc_showAlert("success", "Berhasil Mengupdate Data");
						window.location.reload();
					},
					error(request, error) {
						alert("Request: " + JSON.stringify(request));
					},
				});
			}
		});
	});

	// Initialize all table order
	$("table.table-civil-maintenance-order").DataTable({
		dom: "Bfrtip",
		scrollX: true,
		fixedColumns: {
			leftColumns: 2,
			rightColumns: 1,
		},
		buttons: [
			{
				extend: "excel",
				title: "",
			},
		],
	});

	$("#mco_tablistorder").on("shown.bs.tab", 'a[data-toggle="tab"]', function () {
		$.fn.dataTable.tables({ visible: true, api: true }).columns.adjust().fixedColumns().relayout();
	});

	$("#mco_changestatus").change(function () {
		$.ajax({
			url: baseurl + "civil-maintenance-order/order/up_kolomOrder",
			type: "POST",
			data: {
				id: $(this).attr("data-id"),
				kolom: $(this).attr("data-kolom"),
				val: $(this).val(),
			},
			success() {
				mcc_showAlert("success", "Berhasil Mengupdate Data");
			},
			error(request, error) {
				alert("Request: " + JSON.stringify(request));
			},
		});
	});

	$("#cmo_addJnsOrder").click(function () {
		const stringForm = $("#frm_addJnsOrder").serialize();
		$.ajax({
			url: baseurl + "civil-maintenance-order/setting/add_jenis_order",
			type: "POST",
			data: stringForm,
			success(data) {
				if (data || data == "") {
					$("#cmojenisorder").modal("hide");
					$('input[name="jenisOrder"]').val("");
					mcc_showAlert("success", "Berhasil Menambah Data");
					loadTableCMOjnsOrder();
				} else {
					alert("Gagal!!");
				}
			},
			error(request, error) {
				alert("Request: " + JSON.stringify(request));
			},
		});
	});

	$("#cmoupJnsOrder").click(function () {
		$.ajax({
			url: baseurl + "civil-maintenance-order/setting/up_jnsOrder",
			type: "POST",
			data: $("#frm_upJnsOrder").serialize(),
			success() {
				$("#cmoupjenisorder").modal("hide");
				loadTableCMOjnsOrder();
				mcc_showAlert("success", "Berhasil Mengupdate Data");
			},
			error(request, error) {
				alert("Request: " + JSON.stringify(request));
			},
		});
	});

	$('.cmo_slcPkj[change="1"]').change(function () {
		const val = $(this).val();
		if (!val) return false;

		$.ajax({
			url: baseurl + "civil-maintenance-order/order/get_detailpkj",
			type: "get",
			data: { term: val },
			success(data) {
				let obj = jQuery.parseJSON(data);
				$(".mco_isiData")
					.eq(0)
					.text("Seksi : " + obj[0]["seksi"]);

				$(".mco_inputData").eq(0).val(obj[0]["kodesie"]);
				$(".mco_lokasi").val(obj[0]["id_"]).change();
			},
			error(request, error) {
				alert("Request: " + JSON.stringify(request));
			},
		});
	});

	$(".mco_tglpick").daterangepicker({
		singleDatePicker: true,
		timePicker: false,
		timePicker24Hour: true,
		showDropdowns: false,
		autoUpdateInput: true,
		locale: {
			format: "YYYY-MM-DD",
		},
	});

	$(".cmo_slcJnsPkj").select2({
		searching: false,
		placeholder: "Jenis Pekerjaan",
		minimumResultsForSearch: Infinity,
		allowClear: false,
		ajax: {
			url: baseurl + "civil-maintenance-order/order/getJnsPkj",
			dataType: "json",
			delay: 500,
			type: "GET",
			data(params) {
				return {
					term: params.term,
				};
			},
			processResults(data) {
				return {
					results: $.map(data, function (obj) {
						return { id: obj.jenis_pekerjaan_id, text: obj.jenis_pekerjaan };
					}),
				};
			},
		},
	});

	$(".cmo_slcJnsPkjDetail").select2({
		searching: false,
		placeholder: "Detail Pekerjaan",
		minimumResultsForSearch: Infinity,
		allowClear: false,
		ajax: {
			url: baseurl + "civil-maintenance-order/order/getJnsPkjDetail",
			dataType: "json",
			delay: 500,
			type: "GET",
			data(params) {
				return {
					id: $(".cmo_slcJnsPkj").val(),
					term: params.term,
				};
			},
			processResults(data) {
				return {
					results: $.map(data, function (obj) {
						return {
							id: obj.jenis_pekerjaan_detail_id,
							text: obj.detail_pekerjaan,
						};
					}),
				};
			},
		},
	});

	$(".cmo_slcJnsPkj").change(function () {
		const jenisPekerjaan = $(this).find(":selected").text();

		if (jenisPekerjaan == "Buat Baru") {
			$(".cmo_slcJnsPkjDetail").closest(".col-md-12").hide();
		} else {
			$(".cmo_slcJnsPkjDetail").closest(".col-md-12").show();
			$.ajax({
				url: baseurl + "civil-maintenance-order/setting/getket_jenis_order",
				type: "GET",
				data: {
					id: $(this).val(),
				},
				dataType: "JSON",
				success(response) {
					$(".cmo_slcJnsPkjDetail").attr("disabled", false);
					// console.log(res);
					$(".setjnsPkjhere").text(response.keterangan);
				},
				error(request, error) {
					alert("Request: " + JSON.stringify(request));
				},
			});
		}
	});

	$(".cmo_slcJnsPkjDetail").change(function () {
		$.ajax({
			url: baseurl + "civil-maintenance-order/setting/getket_jenis_pekerjaan_detail",
			type: "GET",
			data: {
				id: $(this).val(),
			},
			dataType: "json",
			success(data) {
				$(".setjnsPkjhereDetail").text(data.keterangan);
			},
			error(request, error) {
				alert("Request: " + JSON.stringify(request));
			},
		});
	});

	$(".cmo_slcJnsOrder").select2({
		searching: false,
		placeholder: "Jenis Pekerjaan",
		minimumResultsForSearch: Infinity,
		allowClear: false,
		ajax: {
			url: baseurl + "civil-maintenance-order/order/getJnsOrder",
			dataType: "json",
			delay: 500,
			type: "GET",
			data(params) {
				return {
					term: params.term,
				};
			},
			processResults(data) {
				return {
					results: $.map(data, function (obj) {
						return {
							id: obj.jenis_order_id,
							text: obj.jenis_order,
						};
					}),
				};
			},
		},
	});

	$(".cmo_slcJnsOrder").change(function () {
		const val = $(this).val();
		if (val == "1") {
			$(".cmo_pengorderCivil").show();
			$(".cmo_pengorderCivil select").attr("required", true);
		} else {
			$(".cmo_pengorderCivil").hide();
			$(".cmo_pengorderCivil select").attr("required", false);
			$(".cmo_pengorderCivil input").val("");
			$(".cmo_pengorderCivil select").val(null).trigger("change");
			$(".mco_isiData").eq(0).text("Seksi : xxxxxxxxxx");
			$(".mco_isiData").eq(1).text("Lokasi : xxxxxxxxx");
		}
	});

	$(".mco_status").on("change", function () {
		var tanggal = $("input[name=tglorder]").val();
		var butuh = new Date(tanggal);

		if ($(this).val() == "Biasa") {
			butuh.setDate(butuh.getDate() + 3);
			var tahun = butuh.getUTCFullYear();
			var bulan = butuh.getMonth() + 1;
			if (bulan < 10) {
				bulan = "0" + bulan;
			}
			var hari = butuh.getDate();
			if (hari < 10) {
				hari = "0" + hari;
			}
			var tglButuh = tahun + "-" + bulan + "-" + hari;
			$("[name=tglbutuh]").data("daterangepicker").setStartDate(tglButuh);
			$("[name=tglbutuh]").data("daterangepicker").setEndDate(tglButuh);
			$(".mco_tglbutuh").show();
			$(".mco_alasan").hide();
		} else if ($(this).val() == "Urgent") {
			butuh.setDate(butuh.getDate() + 1);

			const tahun = butuh.getUTCFullYear();
			const bulan = Number(butuh.getMonth() + 1)
				.toString()
				.padStart(2, "0");
			const hari = Number(butuh.getDate()).toString().padStart(2, "0");

			const tglButuh = tahun + "-" + bulan + "-" + hari;

			$("[name=tglbutuh]").data("daterangepicker").setStartDate(tglButuh);
			$("[name=tglbutuh]").data("daterangepicker").setEndDate(tglButuh);
			$(".mco_tglbutuh").show();
			$(".mco_alasan").show();
		} else {
			$("[name=tglbutuh]").data("daterangepicker").setStartDate(tanggal);
			$("[name=tglbutuh]").data("daterangepicker").setEndDate(tanggal);
			$(".mco_tglbutuh").hide();
			$(".mco_alasan").hide();
		}
	});

	$(".mco_delfile").on("click", function () {
		const $this = $(this);

		const txt = $this.attr("nama");
		const id = $this.val();

		Swal.fire({
			title: "Anda yakin ?",
			text: 'Anda akan menghapus File "' + txt + '"',
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: "#ff3333",
			confirmButtonText: "OK",
		}).then((result) => {
			if (result.value) {
				let s = mco_delFile(id);
				if (s) {
					$this.closest("div.mco_insertafter").remove();
					reIndexLampiran();
				}
			}
		});
	});

	$(".cmo_ifchange").on("change", "input, select, textarea", function () {
		$("#cmo_btnSaveUp").attr("disabled", false);
	});

	$(".cmo_delOrder").click(function () {
		const val = $(this).attr("hapus");

		Swal.fire({
			title: "Anda yakin ?",
			text: "Anda akan menghapus Order ini.",
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: "#ff3333",
			confirmButtonText: "OK",
		}).then((result) => {
			if (result.value) {
				window.location.href = baseurl + "civil-maintenance-order/order/del_order/" + val;
			}
		});
	});

	$(".mco_addRowPek").click(function () {
		var nomor = $(".mco_daftarPek:last").find(".tbl_pekerjaan").attr("nomor");
		nomor = parseInt(nomor) + 1;

		console.log(nomor);
		let c = $(".mco_daftarPek").eq(0).clone();

		$(".mco_daftarPek_Append").append(c);
		$(".mco_daftarPek:last").find("input, textarea").val("");
		$(".mco_daftarPek:last").find(".td_lampiran div button").remove();
		$(".mco_daftarPek:last").find(".td_lampiran div br").remove();
		$(".mco_daftarPek:last").find(".td_lampiran div label").remove();
		$(".mco_daftarPek:last").find(".td_lampiran input").not(":eq(0)").remove();
		$(".mco_daftarPek:last").find(".td_lampiran input").val("");
		$(".mco_daftarPek:last").find("button.add_lamp").attr("nomor", 1);
		$(".mco_daftarPek:last").find("button.add_lamp").text("Choose File 1");

		$(".mco_daftarPek:last")
			.find(".tbl_pekerjaan")
			.attr("name", "tbl_pekerjaan[" + nomor + "]");
		$(".mco_daftarPek:last").find(".tbl_pekerjaan").attr("nomor", nomor);
		$(".mco_daftarPek:last")
			.find(".tbl_qty")
			.attr("name", "tbl_qty[" + nomor + "]");
		$(".mco_daftarPek:last")
			.find(".tbl_satuan")
			.attr("name", "tbl_satuan[" + nomor + "]");
		$(".mco_daftarPek:last")
			.find(".tbl_lampiran")
			.attr("name", "tbl_lampiran[" + nomor + "][]");
		$(".mco_daftarPek:last")
			.find(".tbl_ket")
			.attr("name", "tbl_ket[" + nomor + "]");
		reIndexTblInput("#mco_tblPekerjaan");
	});

	$(".mco_addRowApp").click(function () {
		$(this).closest("div").find(".mco_slc").select2("destroy");
		$(this).closest("div").find(".cmo_slcPkj").select2("destroy");
		let c = $(".mco_daftarApp").last().clone();
		$(".mco_daftarApp_Append").append(c);
		$(".mco_daftarApp:last").find("input, textarea").val("");
		reIndexTblInput("#mco_tbl_approver");
		$(this).closest("div").find(".mco_slc").select2({
			placeholder: "Pilih Salah Satu",
		});
		initSlcPkj();
		$(this).closest("div").find(".cmo_slcPkj").last().val("").trigger("change");
	});

	$(".mco_slc").select2({
		placeholder: "Pilih Salah Satu",
	});
	initSlcPkj();

	$(document).on("change", ".mco_lampiranFilePekerjaan", function () {
		var nomor = $(this).closest("td").find("button.add_lamp").attr("nomor");
		var button = '<button nomor="' + nomor + '" class="btn btn-danger btn-xs del_lamp" type="button" style="float: right"><span class="fa fa-trash"></span></button>';
		var anchor = '<button nomor="' + nomor + '" class="btn btn-success btn-xs view_lamp" type="button" style="float: right"><span class="fa fa-eye"></span></button>';
		var label = '<label nomor="' + nomor + '" style="width: 70%;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;float: left;"><i>' + nomor + ". " + $(this).val().substring(12) + " </i></label>";

		$(this)
			.closest("div")
			.append(label + button + anchor + "<br nomor='" + nomor + "'>");

		var posisi = $(this).closest("div");
		var nomorAsli = nomor;
		if (this.files && this.files[0]) {
			var reader = new FileReader();

			reader.onload = function (e) {
				var link = e.target.result;
				posisi.find(".view_lamp[nomor=" + nomorAsli + "]").attr("data-isi", link);
			};

			reader.readAsDataURL(this.files[0]);
		}

		nomor = parseInt(nomor) + 1;
		$(this).clone().val("").attr("nomor", nomor).appendTo($(this).closest("div"));
		$(this).closest("td").find("button.add_lamp").attr("nomor", nomor);
		$(this)
			.closest("td")
			.find("button.add_lamp")
			.text("Choose File " + nomor);
	});

	$(document).on("click", ".td_lampiran button.add_lamp", function () {
		$(this).closest("td").find("input").last().trigger("click");
	});

	$(document).on("click", ".td_lampiran button.del_lamp", function () {
		var nomor = $(this).attr("nomor");
		var nomorMax = $(this).closest("td").find("button.add_lamp").attr("nomor");
		$(this)
			.closest("div")
			.find("[nomor=" + nomor + "]")
			.attr("nomor", 999);

		for (var i = nomor * 1 + 1; i < nomorMax; i++) {
			var nomorBaru = i - 1;
			var text = $(this)
				.closest("div")
				.find("label[nomor=" + i + "] i")
				.text()
				.substring(1);
			$(this)
				.closest("td")
				.find("label[nomor=" + i + "] i")
				.html(nomorBaru + text);
			$(this)
				.closest("div")
				.find("[nomor=" + i + "]")
				.attr("nomor", nomorBaru);
		}

		$(this)
			.closest("div")
			.find("[nomor=" + nomorMax + "]")
			.attr("nomor", nomorMax - 1);
		$(this)
			.closest("td")
			.find("button.add_lamp")
			.attr("nomor", nomorMax - 1);
		$(this)
			.closest("td")
			.find("button.add_lamp")
			.text("Choose File " + (nomorMax - 1));

		$(this)
			.closest("div")
			.find("[nomor=" + 999 + "]")
			.remove();
	});

	$(document).on("click", ".td_lampiran button.view_lamp", function () {
		$("iframe").attr("src", $(this).attr("data-isi"));
		$("#inputOrder").modal("show");
	});
});
$(document).on("click", ".mco_deldaftarnoPek", function () {
	if ($(".mco_deldaftarnoPek").length > 1) {
		$(this).closest("tr").remove();
		reIndexTblInput("#mco_tblPekerjaan");
	}
});
$(document).on("click", ".mco_deldaftarnoApp", function () {
	if ($(".mco_deldaftarnoApp").length > 1) {
		$(this).closest("tr").remove();
		reIndexTblInput("#mco_tbl_approver");
	}
});

function cetakOrderCM(id) {
	Swal.fire({
		title: "Apakah Anda Ingin Mencetak Order ?",
		text: "Anda Akan diarahkan ke halaman PDF",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: "#3085d6",
		cancelButtonColor: "#d33",
		confirmButtonText: "Ya",
		cancelButtonText: "Tidak",
	}).then((result) => {
		if (!result.value) {
			Swal.fire("Cetak Telah Dibatalkan", "Cetak Dibatalkan", "error");
		} else {
			window.open(baseurl + "civil-maintenance-order/order/cetak_order/" + id, "_blank");
		}
	});
}

function reIndexTblInput(selector) {
	var x = 1;
	$(selector)
		.find(".mco_daftarnoPek")
		.each(function () {
			$(this).text(x);
			x++;
		});
}

$(document).on("change", ".mco_lampiranFile:last", function () {
	var div = $(this).closest("div.col-md-12").clone();
	div.insertAfter($(".mco_insertafter:last")).find("input").val("");
	reIndexLampiran();
});

function mco_delFile(id) {
	let ayax = $.ajax({
		url: baseurl + "civil-maintenance-order/order/del_file",
		type: "post",
		data: { id: id },
		success: function (data) {
			mcc_showAlert("success", "Berhasil Menghapus File");
			return 1;
		},
		error: function (request, error) {
			alert("Request: " + JSON.stringify(request));
			return false;
		},
	});

	return ayax;
}

function reIndexLampiran() {
	var x = 1;
	$(".mco_lampiranno").each(function () {
		$(this).text("Lampiran " + x);
		x++;
	});
}

function loadTableCMOjnsOrder() {
	$.ajax({
		url: baseurl + "civil-maintenance-order/setting/getlist_jenis_order",
		type: "GET",
		success: function (data) {
			$("#CMO_tblJnsOrder").html(data);
			$("#CMOtblJorder").DataTable();
		},
		error: function (request, error) {
			alert("Request: " + JSON.stringify(request));
		},
	});
}

$(document).on("click", ".cmo_delJnsOrder", function () {
	var txt = $(this).attr("nama");
	var val = $(this).val();
	Swal.fire({
		title: "Anda yakin ?",
		text: 'Anda akan menghapus Jenis Order "' + txt + '"',
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: "#ff3333",
		confirmButtonText: "OK",
	}).then((result) => {
		if (result.value) {
			deleteDataSetting(val);
		}
	});
});

$(document).on("click", ".cmo_delJnsPkj", function () {
	var txt = $(this).attr("nama");
	var val = $(this).val();
	Swal.fire({
		title: "Anda yakin ?",
		text: 'Anda akan menghapus Jenis Pekerjaan "' + txt + '"',
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: "#ff3333",
		confirmButtonText: "OK",
	}).then((result) => {
		if (result.value) {
			window.location = baseurl + "civil-maintenance-order/setting/del_jnsPkj?id=" + val;
		}
	});
});
$(document).on("click", ".cmo_delsto", function () {
	var txt = $(this).attr("nama");
	var val = $(this).val();
	Swal.fire({
		title: "Anda yakin ?",
		text: 'Anda akan menghapus Status Order "' + txt + '"',
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: "#ff3333",
		confirmButtonText: "OK",
	}).then((result) => {
		if (result.value) {
			window.location = baseurl + "civil-maintenance-order/setting/del_sto?id=" + val;
		}
	});
});

$(document).on("click", ".cmo_upJnsOrder", function () {
	var txt = $(this).attr("nama");
	var val = $(this).val();
	var ket = $(this).closest("tr").find("td.mco_jpKet").text();
	const color = $(this).data("color");
	console.log(color);
	$('input[name="idJnsOrder"]').val(val);
	$('input[name="upKet"]').val(ket);
	$('input[name="upjenisOrder"]').val(txt);
	$('#cmoupjenisorder input[name="color"]').val(color);
});

$(document).on("click", ".cmo_upJnsOrderDetail", function () {
	var pekerjaanId = $(this).attr("pekerjaan-id");
	var detailId = $(this).attr("detail-id");
	var detail = $(this).attr("detail");
	var ket = $(this).closest("tr").find("td.mco_jpKet").text();
	console.log(pekerjaanId + "----" + detailId + "-----" + detail + "-----" + ket);
	$('select[name="upjenisPekerjaan"]').val(pekerjaanId).change();
	$('input[name="upKet"]').val(ket);
	$('input[name="upjenisOrderDetail"]').val(detail);
	$('input[name="idJnsPekerjaanDetail"]').val(detailId);
});

function deleteDataSetting(id, url = "civil-maintenance-order/setting/del_jnsOrder") {
	$.ajax({
		url: baseurl + url,
		type: "POST",
		data: { id: id },
		success: function (data) {
			loadTableCMOjnsOrder();
			mcc_showAlert("success", "Berhasil Menghapus Data");
		},
		error: function (request, error) {
			alert("Request: " + JSON.stringify(request));
		},
	});
}

function initSlcPkj() {
	$(".cmo_slcPkj").select2({
		searching: true,
		minimumInputLength: 3,
		placeholder: "No. Induk / Nama Pekerja",
		allowClear: false,
		ajax: {
			url: baseurl + "MasterPekerja/Poliklinik/getPekerja",
			dataType: "json",
			delay: 500,
			type: "GET",
			data: function (params) {
				return {
					term: params.term,
				};
			},
			processResults: function (data) {
				return {
					results: $.map(data, function (obj) {
						return { id: obj.noind, text: obj.noind + " - " + obj.nama };
					}),
				};
			},
		},
	});
}

function mco_initEditApproval(id) {
	setUrlBack(".mco_getBack");
	$(".mco_tbl_approver select").change(function () {
		$.ajax({
			url: baseurl + "civil-maintenance-order/order/up_kolomApprover",
			type: "POST",
			data: {
				id: $(this).attr("data-id"),
				kolom: $(this).attr("kolom"),
				val: $(this).val(),
			},
			success: function (data) {
				mcc_showAlert("success", "Berhasil Mengupdate Data");
			},
			error: function (request, error) {
				alert("Request: " + JSON.stringify(request));
			},
		});
	});

	$(".mco_delApprover").click(function () {
		var txt = $(this).closest("tr").find(".cmo_slcPkj option:selected").text();
		var ini = $(this);
		Swal.fire({
			title: "Anda yakin ?",
			text: "Anda akan menghapus Approver " + txt + "?",
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: "#ff3333",
			confirmButtonText: "OK",
		}).then((result) => {
			if (result.value) {
				$.ajax({
					url: baseurl + "civil-maintenance-order/order/del_kolomApprover",
					type: "POST",
					data: {
						id: ini.val(),
					},
					success: function (data) {
						mcc_showAlert("success", "Berhasil Menghapus Data");
						ini.closest("tr").remove();
						reIndexTblInput(".mco_tbl_approver");
					},
					error: function (request, error) {
						alert("Request: " + JSON.stringify(request));
					},
				});
			}
		});
	});

	$(".cmo_slcPkj").change(function () {
		var val = $(this).val();
		var ini = $(this);
		$.ajax({
			url: baseurl + "civil-maintenance-order/order/get_detailpkj",
			type: "get",
			data: { term: val },
			success: function (data) {
				let obj = jQuery.parseJSON(data);
				// ini.closest('tr').find('input').remove();
				ini.closest("tr").find("input.cmoisiJabatan").val(obj[0]["jabatan"]);
			},
			error: function (request, error) {
				alert("Request: " + JSON.stringify(request));
			},
		});
	});
}

function mco_initEditKeterangan() {
	setUrlBack(".mco_getBack");
	$(".mco_tblPekerjaan input, .mco_tblPekerjaan textarea").change(function () {
		var dataId = $(this).attr("data-id");

		if (dataId) {
			$.ajax({
				url: baseurl + "civil-maintenance-order/order/up_kolomKeterangan",
				type: "POST",
				data: {
					id: $(this).attr("data-id"),
					kolom: $(this).attr("kolom"),
					val: $(this).val(),
				},
				success: function (_) {
					mcc_showAlert("success", "Berhasil Mengupdate Data");
				},
				error: function (request, error) {
					alert("Request: " + JSON.stringify(request));
				},
			});
		} else {
			// lampiran
		}
	});

	$(".mco_delKeterangan").click(function () {
		var txt = $(this).closest("tr").find(".mco_editKeteranggan").val();
		var ini = $(this);
		Swal.fire({
			title: "Anda yakin ?",
			text: 'Anda akan menghapus "' + txt + '"?',
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: "#ff3333",
			confirmButtonText: "OK",
		}).then((result) => {
			if (result.value) {
				$.ajax({
					url: baseurl + "civil-maintenance-order/order/del_kolomKeterangan",
					type: "POST",
					data: {
						id: ini.val(),
					},
					success: function (data) {
						mcc_showAlert("success", "Berhasil Menghapus Data");
						ini.closest("tr").remove();
						reIndexTblInput(".mco_tblPekerjaan");
					},
					error: function (request, error) {
						alert("Request: " + JSON.stringify(request));
					},
				});
			}
		});
	});

	$(".mco_delFile_editKet").on("click", function () {
		att_id = $(this).attr("data-attachment-id");
		$.ajax({
			url: baseurl + "civil-maintenance-order/order/del_file",
			type: "POST",
			data: { id: att_id },
			success: function (data) {
				$("a[data-attachment-id=" + att_id + "]").remove();
				$("label[data-attachment-id=" + att_id + "]").remove();
			},
			error: function (request, error) {
				alert("Request: " + JSON.stringify(request));
			},
		});
		// link
	});

	$(".mco_lampiranFilePekerjaanEdit").on("change", function () {
		$(this).closest("tr").find(".btnsubmit").click();
	});
}

function setUrlBack(selektor) {
	let back = document.referrer;
	if (back.length > 2) {
		$(selektor).attr("href", back);
	} else {
		$(selektor).attr("href", baseurl + "civil-maintenance-order");
	}
}

/**
 * ------------------------------------
 *
 * MENU JADWAL
 *
 * write with in anonymous scope function
 * Full JS sluur
 * Sorry i make this with Object Oriented Structure :)
 * ------------------------------------
 */

/**
 * Debug for this class
 * you can access this from console
 */
let debug = "";

!(function () {
	// CORE VARIABLE
	/**
	 * Ini hanya jalan di url /civil-maintenance-order/order/monitoring
	 * variabel dibawah diset jika di view schedule
	 * jika tidak ditemukan, maka script dibawah tidak berjalan
	 */
	const order_id = $("input#monitoring_schedule_order_id").val();
	if (!order_id) return;

	// set moment locale to indonesian
	moment.locale("id");

	class Loading {
		static $element = $("#fullscreen-loading");

		static show() {
			this.$element.css({ display: "block" });
		}

		static hide() {
			this.$element.css({ display: "none" });
		}
	}

	class CalenderView {
		// jquery element container
		containerElement = "";

		// list of rest api
		api = {
			schedule: baseurl + "civil-maintenance-order/api/get_schedule",
			update_schedule: baseurl + "civil-maintenance-order/api/update_schedule",
			remove_schedule: baseurl + "civil-maintenance-order/api/remove_schedule",
		};

		// full calendar properties
		properties = {};

		// list of color
		backgroundColor = {
			red: "#ff7575",
			redDark: "#b5180d",
			green: "#30db3f",
			greenDark: "#0eb01c",
			orange: "#e6a82c",
			OrangeDark: "#ba810f",
			blue: "#316ed6",
			blueDark: "#1148a6",
			yellow: "#dbd527",
			yellowDark: "#c9c30e",
		};

		// state variable
		state = {
			schedule: [],
			scheduleDetail: [],
			isScheduleEnd: false, // default is false
			currentClickDate: "",
		};

		constructor($container, prop) {
			this.containerElement = $container;
			this.properties = prop;
		}

		// when date is click
		onDateClick(date, allDay, jsEvent, view, resource) {
			// first date
			const formattedDate = moment(date).format("YYYY-MM-DD");
			const firstDate = this.getFirstDate();
			const lastDate = this.getLastDate();

			// set state
			this.state.currentClickDate = formattedDate;

			// add click effect
			this.renderClickEvent();

			// if existSchedule
			if (formattedDate < firstDate) return this.clearTask();

			// jika tanggal akhir setted maka tidak bisa click tanggal setelahnya(tanggal akhir)
			if (this.getIsExistEnd()) {
				if (formattedDate > lastDate) return this.clearTask();
			}

			this.setTaskField();
		}

		/**
		 * Get the first date
		 * @return String | false
		 */
		getFirstDate() {
			if (this.state.schedule.length == 0) return false;

			let tempSchedule = this.state.schedule.sort((a, b) => new Date(a.start) - new Date(b.start));
			return tempSchedule[0].start;
		}

		/**
		 * Get the first date
		 * @return String | false
		 */
		getLastDate() {
			if (this.state.schedule.length == 0) return false;

			let tempSchedule = this.state.schedule.sort((a, b) => new Date(a.start) - new Date(b.start));
			return tempSchedule[tempSchedule.length - 1].start;
		}

		/**
		 * get exist of end
		 * @return Boolean
		 */
		getIsExistEnd() {
			return this.state.schedule.find((item) => item.status == "end") ? true : false;
		}

		/**
		 *
		 * @param {String} date
		 * @return {Boolean}
		 */
		getIsDateInSchedule(date) {
			return this.state.schedule.find((item) => item.start == date) ? true : false;
		}

		/**
		 * @return Array
		 */
		getJobTaskValue() {
			const $task = $("#task");
			const $table = $task.find("table#job_task");
			const $tableBody = $table.find("tbody");

			let values = [];

			$tableBody.find("input").each(function () {
				let value = $(this).val();

				if (value) {
					values.push(value);
				}
			});

			return values;
		}

		/**
		 * Make row template
		 * @return String
		 */
		jobTaskRowTemplate(number, value) {
			return `
        <tr>
          <td>${number}</td>
          <td>
            <input placeholder="Tulis pekerjaan ..." class="form-control" value="${value}">
          </td>
          <td>
            <button class="task_delete btn btn-sm btn-danger">
              <i class="fa fa-times"></i>
            </button>
          </td>
        </tr>
      `;
		}

		/**
		 * Make row template
		 * @return String
		 */
		jobTaskRowTemplateReadonly(number, value) {
			return `
        <tr>
          <td>${number}</td>
          <td>
            ${value}
          </td>
          <td>
          </td>
        </tr>
      `;
		}

		/**
		 * Add event listener to new dom of delete task
		 */
		initializeDeleteJobTask() {
			const $task = $("#task");
			const $table = $task.find("table#job_task");

			$table.find("tbody tr button.task_delete").each(function () {
				const tableRow = $(this).closest("tr");
				$(this).click(function () {
					const confirmation = confirm("Apakah yakin untuk menghapus pekerjaan ini ?");

					if (!confirmation) return;

					tableRow.remove();
				});
			});
		}

		/**
		 * Render job list table to view
		 */
		setJobTaskItems(jobs) {
			const $task = $("#task");
			const $table = $task.find("table#job_task");

			const existEnd = this.getIsExistEnd();
			const lastDate = this.getLastDate();
			const currentClickedDate = this.state.currentClickDate;

			// jika tanggal selesai belum di set
			if (!this.getIsExistEnd()) {
				// additional
				jobs.push({
					title: "",
				});
			}

			const jobTableBody = jobs
				.map((item, index) => {
					return existEnd && currentClickedDate != lastDate ? this.jobTaskRowTemplateReadonly(index + 1, item.title) : this.jobTaskRowTemplate(index + 1, item.title);
				})
				.join("");

			$table.find("tbody").html(jobTableBody);
			this.initializeDeleteJobTask();
		}

		/**
		 * Add row when button add is clicked
		 */
		addJobTask() {
			const maxRow = 10;
			const $task = $("#task");
			const $table = $task.find("table#job_task");
			const $tableBody = $table.find("tbody");
			const rowCount = $tableBody.find("tr").length;

			if (rowCount == 10) return alert("Terlalu banyak tugas");

			const lastNumber = $tableBody.find("tr").length + 1;

			$tableBody.append(this.jobTaskRowTemplate(lastNumber, ""));
			this.initializeDeleteJobTask();
		}

		/**
		 * Task set task field based on state
		 */
		setTaskField() {
			const $task = $("#task");
			// current selected date
			const date = this.state.currentClickDate;
			const lastDate = this.getLastDate();
			const endDateExist = this.getIsExistEnd();
			const dateInSchedule = this.getIsDateInSchedule(date);

			// find task item (array)
			const events = this.state.schedule.filter((item) => {
				return item.start == date;
			});

			// find task detail (object)
			const detail = this.state.scheduleDetail.find((item) => {
				return item.tanggal == date;
			});

			this.setJobTaskItems(events);

			// set value to task view
			$task.find("#task_date").text(moment(date).format("LL"));
			// set value of detail
			$task.find("#task_detail").val((detail && detail.keterangan) || "");

			// ketika tanggal selesai sudah di set
			// when end date is setted
			// maka hide action tambah & simpan, dll
			if (endDateExist && date != lastDate) {
				$("#task #action_wrapper").hide();
				$("#task #task_job_add").hide();
			} else {
				$("#task #action_wrapper").show();
				$("#task #task_job_add").show();
			}

			// if current clicked data is < end date
			// maka hide selesai checkbox
			if (date < lastDate || !lastDate) {
				$task.find("#end_wrapper").hide();
				$task.find("#end_wrapper #task_is_end").iCheck("uncheck");
			} else {
				$task.find("#end_wrapper").show();
				$task.find("#end_wrapper #task_is_end").iCheck("uncheck");
			}

			// jika ada tanggal akhir
			if (endDateExist && date == lastDate) {
				$task.find("#task_detail").prop("disabled", false);
				$task.find("#end_wrapper #task_is_end").iCheck("check");
			} else if (endDateExist) {
				$task.find("#task_detail").prop("disabled", true);
			} else {
				$task.find("#task_detail").prop("disabled", false);
			}

			// show / hide remove button
			// jika tanggal ada di jadwal maka munculkan, atau hide
			if (dateInSchedule) {
				$task.find("#task_delete").show();
			} else {
				$task.find("#task_delete").hide();
			}

			// will show task
			$task.removeClass("hidden");
		}

		/**
		 * Clear all field task and hide
		 */
		clearTask() {
			const $task = $("#task");

			$task.addClass("hidden");
			$task.find("#task_date").text();
			this.setJobTaskItems([]); // empty array will clear item
			$task.find("#task_detail").val("");
		}

		/**
		 * Task save button clicked
		 */
		onTaskSave() {
			// this will insert or update
			const _this = this;
			let currentSchedule = this.state.schedule;
			let currentScheduleDetail = this.state.scheduleDetail;

			const detail = $("#task #task_detail").val();
			const jobs = this.getJobTaskValue();

			let status = "";

			if ($("#task #task_is_end").is(":checked")) {
				status = "end";
			} else if (this.state.schedule.length == 0) {
				status = "start";
			} else {
				status = "progress";
			}

			// validation
			if (jobs.length === 0) return alert("Minimal ada 1 pekerjaan !!");

			// remove this current selected date
			currentSchedule = currentSchedule.filter(({ start }) => {
				return _this.state.currentClickDate != start;
			});

			let schedule = jobs.map((job) => {
				return {
					start: _this.state.currentClickDate,
					title: job,
					status: status,
				};
			});

			let scheduleDetail = {
				tanggal: _this.state.currentClickDate,
				keterangan: detail,
			};

			const newSchedule = currentSchedule.concat(schedule);
			const newScheduleDetail = currentScheduleDetail.concat(scheduleDetail);

			$.ajax({
				method: "POST",
				url: this.api.update_schedule,
				dataType: "json",
				data: {
					order_id, // from global variable
					detail,
					jobs,
					status,
					tanggal: this.state.currentClickDate,
				},
				beforeSend() {
					Loading.show();
				},
				success() {
					// update data calendar
					_this.setData(newSchedule);
					_this.setDataDetail(newScheduleDetail);
				},
				complete() {
					Loading.hide();
				},
			});
		}

		/**
		 * Tombol batal pada task
		 */
		onTaskCancel() {
			this.state.currentClickDate = "";
			this.renderClickEvent();
			this.clearTask();
		}

		/**
		 * Tombol selesai di task di ubah
		 */
		onTaskEnd() {
			// set end
		}

		/**
		 * Ketika remove button di click
		 */
		onTaskDelete(event) {
			event.preventDefault();
			const _this = this;

			const confirmation = confirm("Apakah yakin untuk menghapus detail tanggal ini ?");
			if (!confirmation) return;

			$.ajax({
				method: "POST",
				url: this.api.remove_schedule,
				dataType: "json",
				data: {
					order_id,
					tanggal: this.state.currentClickDate,
				},
				beforeSend() {
					Loading.show();
				},
				success() {
					// update data
					const data = _this.state.schedule.filter((item) => {
						return item.start != _this.state.currentClickDate;
					});

					console.log("filtered", data);
					console.log("schedule", _this.state.schedule);

					_this.state.currentClickDate = "";
					// update data calendar
					_this.clearTask();
					_this.setData(data);
				},
				error() {
					Swal.fire("Gagal untuk menghapus, silahkan cek koneksi anda");
				},
				complete() {
					Loading.hide();
				},
			});
		}

		/**
		 * Untuk mengupdate data kalendernya
		 */
		setData(data) {
			this.state.schedule = data;
			this.render();
		}

		/**
		 * Untuk mengupdate data detail kalendernya
		 *
		 */
		setDataDetail(details) {
			this.state.scheduleDetail = details;
		}

		/**
		 * Untuk merender selected date berdasarkan state tanggal yg aktif
		 */
		renderClickEvent() {
			$(`.fc-day.selected`).removeClass("selected");
			if (!this.state.currentClickDate) return;
			$(`.fc-day[data-date=${this.state.currentClickDate}]`).addClass("selected");
		}

		/**
		 * Destroy or remove this fullcalendar
		 */
		destroy() {
			this.containerElement.fullCalendar("destroy");
		}

		/**
		 * Render all date background based on state.schedule
		 */
		setDateItemColor() {
			const firstIndex = 0;

			let distinct = [];
			let tempSchedule = this.state.schedule.filter((item) => {
				if (distinct.includes(item.start)) return false;
				distinct.push(item.start);
				return true;
			});

			tempSchedule = tempSchedule.sort((a, b) => new Date(a.start) - new Date(b.start));

			const lastIndex = tempSchedule.length - 1;

			$(`.fc-day`).css({
				backgroundColor: "",
			});

			tempSchedule.forEach((item, index) => {
				item.start = moment(item.start).format("YYYY-MM-DD");

				if (item.status == "end" && index == lastIndex) {
					$(`.fc-day[data-date=${item.start}]`).css({
						backgroundColor: this.backgroundColor.redDark,
					});
				} else if (index == firstIndex) {
					$(`.fc-day[data-date=${item.start}]`).css({
						backgroundColor: this.backgroundColor.green,
					});
				} else {
					$(`.fc-day[data-date=${item.start}]`).css({
						backgroundColor: this.backgroundColor.orange,
					});
				}
			});
		}

		/**
		 * See documentation
		 */
		afterAllRender() {
			this.renderClickEvent();
			console.log("afterall render");
		}

		/**
		 * See documentation
		 */
		afterRender() {
			this.setDateItemColor();
			console.log("after render");
		}

		/***
		 * Jump to month in view
		 * @param String of date, e.g: 2020-10-01
		 */
		gotToDate(date) {
			this.containerElement.fullCalendar("gotoDate", new Date(date));
		}

		/**
		 * Init all button on task card
		 */
		taskButtonInit() {
			const $taskWrapper = $("#task");

			$taskWrapper.find("button#task_save").click(this.onTaskSave.bind(this));

			$taskWrapper.find("a#task_delete").click(this.onTaskDelete.bind(this));

			$taskWrapper.find("button#task_end").click(this.onTaskEnd.bind(this));

			$taskWrapper.find("button#task_cancel").click(this.onTaskCancel.bind(this));

			$taskWrapper.find("button#task_job_add").click(this.addJobTask.bind(this));
		}

		/**
		 * Render calendar based on state.schedule variable
		 * and render background -color
		 */
		render() {
			this.containerElement.fullCalendar("removeEvents");
			this.containerElement.fullCalendar("addEventSource", [].concat(this.state.schedule));

			this.setDateItemColor();
		}

		/**
		 * Initialize Fullcalendar
		 */
		init() {
			this.properties.eventAfterAllRender = this.afterAllRender.bind(this);
			this.properties.eventAfterRender = this.afterRender.bind(this);
			this.properties.dayClick = this.onDateClick.bind(this);

			this.containerElement.fullCalendar(this.properties);

			this.taskButtonInit();

			// for debug in browser console
			// use debug variable
			debug = this;
		}
	}

	/**
	 * Show loading on
	 */
	Loading.show();

	$(() => {
		const Calendar = new CalenderView($("#calender-container"), {
			initialView: "dayGridMonth",
			monthNames: "Januari Februari Maret April Mei Juni Juli Agustus September Oktober November Desember".split(" "),
			dayNames: "Minggu Senin Selasa Rabu Kamis Jumat Sabtu".split(" "),
			dayNamesShort: "Minggu Senin Selasa Rabu Kamis Jumat Sabtu".split(" "),
			selectable: true,
			locale: "id",
		});

		// Render Calendar
		Calendar.init();

		// fetch from server
		function fetchCalendar() {
			$.ajax({
				method: "GET",
				url: Calendar.api.schedule,
				dataType: "json",
				data: {
					order_id,
				},
				beforeSend() {
					Loading.show();
				},
				success(response) {
					console.log(response);
					Calendar.clearTask();
					Calendar.setData(response.schedule);
					Calendar.setDataDetail(response.schedule_detail);

					// if its has value / not an empty array
					if (response.schedule.length) {
						Calendar.gotToDate(response.schedule[response.schedule.length - 1].start);
					}
				},
				error() {
					swal.fire("Gagal mengambil data", ":(", "error");
				},
				complete() {
					Loading.hide();
				},
			});
		}

		fetchCalendar();

		$("a#fetch_calendar").click(fetchCalendar);
	});
})();

/**
 * --------------------------------------
 *
 * Menu Monitoring
 * @url /civil-maintenance-order/order/monitoring
 *
 * --------------------------------------
 */

!(function () {
	const api = {
		updateAccDate: baseurl + "civil-maintenance-order/api/update_acc_date",
		updateOrderStatus: baseurl + "civil-maintenance-order/api/update_order_status",
	};

	$(function () {
		const $modalChangeDate = $("#modal-change-date");
		const $modalChangeStatus = $("#modal-change-status");
		const status_value = {
			open: 1,
			wip: 2,
			done: 3,
			close: 4,
		};

		let $currentClickedElement = null;

		// initialize listener
		// modal change acc date
		$modalChangeDate.find("input#datepicker").daterangepicker({
			singleDatePicker: true,
			timePicker: false,
			timePicker24Hour: true,
			showDropdowns: false,
			autoUpdateInput: true,
			locale: {
				format: "DD/MM/YYYY",
			},
		});

		$modalChangeDate.find("button#submit").click(function (e) {
			e.preventDefault();

			const data = {
				date: $modalChangeDate.find("input#datepicker").val(),
				order_id: $modalChangeDate.find("input[name=order_id]").val(),
			};

			// ajax send to server
			$.ajax({
				url: api.updateAccDate,
				method: "POST",
				data,
				dataType: "json",
				success() {
					const $td = $currentClickedElement.closest("td");
					$td.html(data.date);
					$td.attr("data-tanggal_masuk_order", data.date);

					$modalChangeDate.modal("toggle");
				},
				error() {
					Swal.fire("Gagal mengupdate tanggal", "Silahkan cek koneksi jaringan anda", "error");
				},
			});

			// then update this element
		});

		// modal change status
		$modalChangeStatus.find("button#submit").click(function (e) {
			e.preventDefault();
			const order_id = $modalChangeStatus.find("input[name=order_id]").val();
			const $select_status = $modalChangeStatus.find("select[name=status]");
			const $tr = $currentClickedElement.closest("tr");

			const status = {
				id: $select_status.val(),
				color: $select_status.find("option:selected").data("color"),
				text: $select_status.find("option:selected").text(),
			};

			console.log(status);

			// confirmation
			const confirmation = confirm("Apakah anda yakin untuk mengubah status");

			if (!confirmation) return;

			$.ajax({
				url: api.updateOrderStatus,
				method: "POST",
				data: {
					order_id,
					status_id: status.id,
				},
				success() {
					const $closestTd = $currentClickedElement.closest("td");

					$closestTd.find(".status_name").text(status.text);
					$closestTd.css({
						backgroundColor: status.color,
					});
					$closestTd.find(".change-status").data("status_id", status.id);
					console.log($closestTd.find(".change-status").data("status_id"));
					// show calendar button
					if (status.id == status_value.wip) {
						$tr.find(".calendar-toggle").removeClass("hidden");
					} else if (status.id == status_value.open) {
						$tr.find(".calendar-toggle").addClass("hidden");
					}
					// close the modal
					$modalChangeStatus.modal("toggle");
				},
				error() {
					Swal.fire("Cek koneksi and", "", "error");
				},
			});
		});

		// call this before datatable initialize
		$("table#monitoring-table tbody tr .change-status").click(function () {
			const $tr = $(this).closest("tr");

			const order_id = $(this).data("order_id");
			const status_id = $(this).data("status_id");
			console.log(status_id);
			console.log("current status: ", status_id);
			$modalChangeStatus.find("input[name=order_id]").val(order_id);

			// check condition
			// select option dinamis
			// - ketika tanggal terima masih kosong maka tidak bisa set status jadi WIP dan seterusnya
			// - ketika tanggal selesai masih kosong maka tidak bisa set status jadi Done belum serah terima, dan seterusnya
			const tgl_masuk_order = $tr.find("td[data-tanggal_masuk_order]").data("tanggal_masuk_order");
			const tgl_dikerjakan = $tr.find("td[data-tanggal_dikerjakan]").data("tanggal_dikerjakan");
			const tgl_selesai = $tr.find("td[data-tanggal_selesai]").data("tanggal_selesai");

			console.log({
				masuk: tgl_masuk_order,
				selesai: tgl_selesai,
			});

			const setOptionDisable = (max_status = 2, reverse = false) => {
				let disable = reverse;
				$modalChangeStatus.find("select[name=status] option").each(function () {
					const val = $(this).val();
					if (val == max_status) {
						disable = !reverse;
					}

					$(this).prop("disabled", disable);
				});
			};

			console.log(tgl_masuk_order, tgl_selesai);

			if (!tgl_masuk_order) {
				setOptionDisable(status_value.wip);
			} else if (!tgl_selesai) {
				setOptionDisable(status_value.done);
			} else if (tgl_masuk_order && tgl_selesai) {
				// disable option 1 & 2
				setOptionDisable(status_value.done, true);
			}

			if (tgl_dikerjakan) {
				console.log(tgl_dikerjakan);
				$modalChangeStatus.find("select[name=status] option[value=1]").prop("disabled", true);
			} else {
				$modalChangeStatus.find("select[name=status] option[value=1]").prop("disabled", false);
			}

			// set select value
			$modalChangeStatus.find("select[name=status]").val(status_id);
			$currentClickedElement = $(this);
		});

		$("table#monitoring-table tbody button.change_acc_date").click(function () {
			const order_id = $(this).data("order_id");
			$modalChangeDate.find("input[name=order_id]").val(order_id);

			$currentClickedElement = $(this);
		});

		// datatable init
		$("table#monitoring-table").DataTable();
	});
})();
