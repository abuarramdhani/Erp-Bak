// helper
function updateUrlParam(param) {
	let params = $.param(param);
	let pathname = window.location.pathname + "?" + params;
	window.history.replaceState(null, null, pathname);
}

function spl_load_data() {
	url = window.location.pathname;
	usr = $("#txt_ses").val();
	ket = $("#spl_tex_proses").val();

	if (url.indexOf("ALK") >= 0) {
		tmp = "finspot:FingerspotVer;" + btoa(baseurl + "ALK/Approve/fp_proces?userid=" + usr);
	} else {
		tmp = "finspot:FingerspotVer;" + btoa(baseurl + "ALA/Approve/fp_proces?userid=" + usr);
	}

	var client_table = $('.spl-table').DataTable();
	var chk = 0;
	var rows = $( client_table.$('input[type="checkbox"]').each(function () {
		if ($(this).is(':checked')) {
			chk++;
		}
	}));

	if (chk == 0) {
		$("#example11_wrapper").find("a.btn-primary").addClass("disabled");
		$("#example11_wrapper").find("button.btn-primary").addClass("disabled");
		console.log("tidak ada");
	} else {
		$("#example11_wrapper").find("a.btn-primary").removeClass("disabled btn-default");
		$("#example11_wrapper").find("button.btn-primary").removeClass("disabled btn-default");
		console.log("ada");
	}

	if (url.indexOf("ALK") >= 0) {
		$("#spl_proses_reject").attr("href", tmp + btoa("&stat=31&data=" + chk + "&ket=" + ket));
		$("#spl_proses_approve").attr("href", tmp + btoa("&stat=21&data=" + chk + "&ket=" + ket));
	} else {
		$("#spl_proses_reject").attr("href", tmp + btoa("&stat=35&data=" + chk + "&ket=" + ket));
		$("#spl_proses_approve").attr("href", tmp + btoa("&stat=25&data=" + chk + "&ket=" + ket));
	}
}

//--------------------- surat perintah lembur ----------------//
$(function () {
	$(".spl-table.aska, .spl-table.kasie").DataTable({
		scrollX: true,
		dom: '<"top"Bflpi>rt<"bottom"ip>',
		buttons: [
			{
				extend: "excelHtml5",
				text: "Export Table",
				className: "btn btn-success",
			},
			{
				text: "Proses",
				className: "btn btn-proses btn-primary disabled",
				action: (e, dt, node, config) => {
					$("#spl_tex_proses").val("");
					$("#btn-ProsesSPL").click();
				},
			}
		],
		"lengthMenu": [
			[10, 50, 100, 200, 500, -1], 
			[10, 50, 100, 200, 500, 'All']
		],
		ordering: false,
		retrieve: true,
		initComplete: () => {
			if ($("#btn-ProsesSPL").attr("id") == undefined) {
				$("#example11_wrapper").find("a.dt-button:last").hide();
				$("#example11_wrapper").find("button.dt-button:last").hide();
			}

			$("#example11_wrapper").find("a.dt-button").removeClass("dt-button");
			$("#example11_wrapper").find("button.dt-button").removeClass("dt-button");
			$("#example11_wrapper").find("a.btn").css("margin-right", "10px");
			$("#example11_wrapper").find("button.btn").css("margin-right", "10px");
		},
	});

	$(".spl-table").DataTable({
		scrollX: true,
		dom: "lfrtip",
		buttons: [
			{
				extend: "excelHtml5",
				text: "Export Table",
				className: "btn btn-success",
			},
		],
		"lengthMenu": [
			[10, 50, 100, 200, 500, -1], 
			[10, 50, 100, 200, 500, 'All']
		],
		ordering: false,
		retrieve: true,
		initComplete: function () {
			if ($("#btn-ProsesSPL").attr("id") == undefined) {
				$("#example11_wrapper").find("a.dt-button:last").hide();
				$("#example11_wrapper").find("button.dt-button:last").hide();
			}

			$("#example11_wrapper").find("a.dt-button").removeClass("dt-button");
			$("#example11_wrapper").find("button.dt-button").removeClass("dt-button");
			$("#example11_wrapper").find("a.btn").css("margin-right", "10px");
			$("#example11_wrapper").find("button.btn").css("margin-right", "10px");
		},
	});

	$(".spl-date").daterangepicker({
		singleDatePicker: true,
		timePicker: false,
		autoclose: true,
		"maxDate": getDate1(),
		locale: {
			format: "DD-MM-YYYY",
		},
	});

	$(".spl-date-time").daterangepicker({
		timePicker: true,
		timePickerIncrement: 1,
		timePicker24Hour: true,
		singleDatePicker: true,
		locale: {
			format: "DD-MM-YYYY HH:mm:ss",
		},
	});

	$(".spl-time").timepicker({
		defaultTime: "value",
		minuteStep: 1,
		showMeridian: false,
		format: "HH:mm:ss",
	});

	$(".spl-pkj-select2").select2({
		ajax: {
			url: baseurl + "SPLSeksi/C_splseksi/show_pekerja",
			dataType: "json",
			type: "get",
			data: function (params) {
				var other = "";

				if ($("#noi").length) {
					other = $("#noi").val();
				}

				return { key: params.term, key2: other };
			},
			processResults: function (data) {
				return {
					results: $.map(data, function (item) {
						return {
							id: item.noind,
							text: item.noind + " - " + item.nama,
						};
					}),
				};
			},
			cache: true,
		},
		minimumInputLength: 2,
		placeholder: "Silahkan pilih",
		allowClear: true,
	});

	$(".spl-new-pkj-select2").select2({
		ajax: {
			url: baseurl + "SPLSeksi/Pusat/C_splseksi/show_pekerja3",
			dataType: "json",
			type: "get",
			data: function (params) {
				var other = "";
				chk = "";
				$(".multiinput select").each(function () {
					if ($(this).val() !== null) {
						chk += "." + $(this).val();
					}
				});
				other = chk;

				return { key: params.term, key2: other };
			},
			processResults: function (data) {
				return {
					results: $.map(data, function (item) {
						return {
							id: item.noind,
							text: item.noind + " - " + item.nama,
						};
					}),
				};
			},
			cache: true,
		},
		minimumInputLength: 2,
		placeholder: "Silahkan pilih",
		allowClear: true,
	});

	$(".spl-shift-select2").select2({
		ajax: {
			url: baseurl + "SPLSeksi/C_splseksi/show_shift",
			dataType: "json",
			type: "get",
			data: function (params) {
				var other = "";

				if ($("#txtTanggal").length) {
					other = $("#txtTanggal").val();
				}

				return { key: params.term, key2: other };
			},
			processResults: function (data) {
				return {
					results: $.map(data, function (item) {
						return {
							id: item.kd_shift,
							text: item.kd_shift + " - " + item.shift,
						};
					}),
				};
			},
			cache: true,
		},
		minimumInputLength: 1,
		placeholder: "Silahkan pilih",
		allowClear: true,
	});

	$(".spl-pkj-select22").select2({
		ajax: {
			url: baseurl + "SPLSeksi/C_splseksi/show_pekerja2",
			dataType: "json",
			type: "get",
			data: function (params) {
				return { key: params.term };
			},
			processResults: function (data) {
				return {
					results: $.map(data, function (item) {
						return {
							id: item.noind,
							text: item.noind + " - " + item.nama,
						};
					}),
				};
			},
			cache: true,
		},
		minimumInputLength: 2,
		placeholder: "Silahkan pilih",
		allowClear: true,
	});

	$(".spl-sie-select2").select2({
		ajax: {
			url: baseurl + "SPLSeksi/C_splseksi/show_seksi",
			dataType: "json",
			type: "get",
			data: function (params) {
				var other = "";

				if ($("#kodel").length) {
					other = $("#kodel").val();
				}

				return { key: params.term, key2: other };
			},
			processResults: function (data) {
				return {
					results: $.map(data, function (item) {
						return {
							id: item.kode,
							text: item.kode + " - " + item.nama,
						};
					}),
				};
			},
			cache: true,
		},
		minimumInputLength: 2,
		placeholder: "Silahkan pilih",
		allowClear: true,
	});

	$("#spl-pencarian").on("click", function (e) {
		e.preventDefault();
		var table = $(".spl-table").DataTable();
		var alamate = baseurl + "SPLSeksi/C_splseksi/data_spl_filter";
		$(this).prop("disabled", true);
		table.clear().draw();

		$.ajax({
			url: alamate,
			type: "POST",
			dataType: "json",
			data: {
				dari: $("#tgl_mulai").val(),
				sampai: $("#tgl_selesai").val(),
				status: $("#status").val(),
				lokasi: $("#lokasi").val(),
				noind: $("#noind").val(),
			},
			beforeSend() {
				$(".spl-loading").removeClass("hidden");
			},
			success: function (data) {
				table.rows.add(data);
				table.draw();
			},
			error(e) {
				alert(e);
			},
		}).done((e) => {
			$(this).prop("disabled", false);

			$(".spl-loading").addClass("hidden");
		});
	});

	$("#example11").on("click", ".spl-pkj-del", function () {
		let totalRow = $(".multiinput").length;

		let thisrow = $(this).closest("tr");
		let nextrow = thisrow.next(".multiinput.parent");
		thisrow.nextUntil(nextrow, "tr.spl-jobs").remove();
		$(this).closest("tr").remove();

		let existError = false;
		$(".spl-new-error").each(function () {
			existError = true;
		});

		if (existError) {
			$("button#submit_spl").attr("type", "button").attr("class", "btn btn-default");
		} else {
			$("button#submit_spl").attr("type", "submit").attr("class", "btn btn-primary");
		}

		if (totalRow == 2) {
			$(".multiinput").find(".spl-pkj-del").prop("disabled", true);
		}
	});

	$("#submit_spl").on("click", function (e) {
		let waktu1 = $("input[name=tanggal_0_simpan]").val() + " " + $("input[name=waktu_0_simpan]").val();
		let waktu2 = $("input[name=tanggal_1_simpan]").val() + " " + $("input[name=waktu_1_simpan]").val();

		if (waktu1 == waktu2 && waktu1 != "" && waktu2 != "") {
			swal.fire("Waktu lembur yang diambil tidak boleh sama !!!", "", "error");
			e.preventDefault();
			return;
		}
	});

	$("#spl_pkj_add").click(function (e) {
		e.preventDefault();

		let row = $(".multiinput.parent");
		row = row.length == 0 ? row.length : row.last().data("row") + 1;
		let TrHTML = `
        <tr class="multiinput parent" data-row="${row}">
            <td>
                <button type='button' class='btn btn-danger spl-pkj-del'><span class='fa fa-trash'></span></button>
            </td>
            <td>
                <select class="spl-new-pkj-select2 spl-cek" name="noind[]" style="width: 100%" required>
                    <!-- select2 -->
                </select>
            </td>
            <td>
                <input type="text" class="form-control" name="lbrawal[]" disabled>
                <input type="hidden" class="form-control" name="lembur_awal[]" >
            </td>
            <td>
                <input type="text" class="form-control" name="lbrakhir[]" disabled>
                <input type="hidden" class="form-control" name="lembur_akhir[]" >
            </td>
            <td>
                <input type="text" class="form-control" name="overtime" disabled>
            </td>
            <td>
                <input type="number" min="1" class="form-control" name="target[${row}][]" required>
            </td>
            <td>
                <select class="form-control target-satuan" name="target_satuan[${row}][]" required>
                    <option value=""></option>
                    <option value="Pcs">Pcs</option>
                    <option value="%">%</option>
                    <option value="Box">Box</option>
                    <option value="Kg">Kg</option>
                    <option value="Unit">Unit</option>
                    <option value="Ton">Ton</option>
                    <option value="Flask">Flask</option>
                </select>
            </td>
            <td>
                <input type="number" min="1" class="form-control" name="realisasi[${row}][]" required>
            </td>
            <td>
                <input type="text" class="form-control realisasi-satuan" name="realisasi_satuan[${row}][]" readonly>
            </td>
            <td colspan="2">
                <textarea style="resize: vertical; min-height: 30px;" class="form-control pekerjaan" rows="1" name="pekerjaan[${row}][]" required></textarea>
            </td>
            <td>
                <button type="button" onclick="add_jobs_spl($(this))" class="btn btn-sm btn-default hidden"><i class="fa fa-plus"></i></button>
            </td>
        </tr>
        `;
		$(".multiinput").first().find(".spl-pkj-del").prop("disabled", false);
		$("#example11 tbody").append(TrHTML);

		// make new select2 ajax on new dom select pekerja
		$(".multiinput select[name*=noind]").select2({
			ajax: {
				url: baseurl + "SPLSeksi/Pusat/C_splseksi/show_pekerja3",
				dataType: "json",
				type: "get",
				data: function (params) {
					var other = "";
					chk = "";
					$(".multiinput select").each(function () {
						if ($(this).val() !== null) {
							chk += "." + $(this).val();
						}
					});
					other = chk;
					return { key: params.term, key2: other };
				},
				processResults: function (data) {
					return {
						results: $.map(data, function (item) {
							return {
								id: item.noind,
								text: item.noind + " - " + item.nama,
							};
						}),
					};
				},
				cache: true,
			},
			minimumInputLength: 2,
			placeholder: "Silahkan pilih",
			allowClear: true,
		});
	});

	$("select[name=kd_lembur").on("change", function () {
		const val = $(this).val();

		if (val == "001") {
			//lembur istirahat
			$("#break-ya, #istirahat-ya").prop("disabled", true);
			$("#istirahat-no").iCheck("check");
			$("#break-no").iCheck("check");
		} else {
			$("#break-ya, #istirahat-ya").prop("disabled", false);
		}
	});

	$("#example11").on("change", ".spl-cek", function (e) {
		tanggal0 = $("input[name*=tanggal_0]").val();
		tanggal1 = $("input[name*=tanggal_1]").val();
		waktu0 = $("input[name*=waktu_0]").val();
		waktu1 = $("input[name*=waktu_1]").val();
		lembur = $("select[name*=kd_lembur]").val();
		istirahat = $("input[name*=istirahat]:checked").val();
		break0 = $("input[name*=break]:checked").val();
		alasan = $("textarea[name*=alasan]").val();

		$("input[name*=tanggal_0_simpan]").val(tanggal0);
		$("input[name*=tanggal_1_simpan]").val(tanggal1);
		$("input[name*=waktu_0_simpan]").val(waktu0);
		$("input[name*=waktu_1_simpan]").val(waktu1);
		$("input[name*=kd_lembur_simpan]").val(lembur);
		$("input[name*=istirahat_simpan]").val(istirahat);
		$("input[name*=break_simpan]").val(break0);
		$("input[name*=alasan_simpan]").val(alasan);

		var noindSPL = $(this).val();
		var parentSelect = $(this).closest("td");
		var parentTr = $(this).closest("tr");
		var splLink = window.location.href;
		var ajaxlink = "";

		if (splLink.search("Pusat") !== -1) {
			ajaxlink = baseurl + "SPLSeksi/Pusat/C_splseksi/cek_anonymous2";
			$("input[name=tanggal_0]").attr("disabled", "disabled");
			$("input[name=tanggal_1]").attr("disabled", "disabled");
			$("input[name=waktu_0]").attr("disabled", "disabled");
			$("input[name=waktu_1]").attr("disabled", "disabled");
			$("input[name=istirahat]").attr("disabled", "disabled");
			$("input[name=break]").attr("disabled", "disabled");
			$("select[name=kd_lembur]").attr("disabled", "disabled");
			$("textarea[name=alasan]").attr("disabled", "disabled");
		} else {
			ajaxlink = baseurl + "SPLSeksi/Pusat/C_splseksi/cek_anonymous2";
		}
		if (noindSPL && noindSPL !== "") {
			$.ajax({
				url: ajaxlink,
				type: "POST",
				data: {
					tanggal0: tanggal0,
					tanggal1: tanggal1,
					waktu0: waktu0,
					waktu1: waktu1,
					lembur: lembur,
					istirahat: istirahat,
					break0: break0,
					noind: noindSPL,
				},
				async: false,
				success: function (data) {
					obj = $.parseJSON(data);
					// console.log(obj);
					if (obj["error"] == "1") {
						parentSelect.css("background", "#ffe6e6");
						$("button#submit_spl").attr("type", "button").attr("class", "btn btn-grey");
						parentSelect.find(".spl-new-error").remove();
						parentSelect.append("<p class='spl-new-error' style='color: red'><br><i style='color:#ed2b1f' class='fa fa-lg fa-info-circle spl-error'></i>  Peringatan : " + obj["text"] + "</p>");
						parentTr.find("input[name*=lbrawal]").val("");
						parentTr.find("input[name*=lembur_awal]").val("");
						parentTr.find("input[name*=lbrakhir]").val("");
						parentTr.find("input[name*=lembur_akhir]").val("");
						parentTr.find("input[name*=target]").prop("disabled", true);
						parentTr.find("input[name*=realisasi]").prop("disabled", true);
						parentTr.find("textarea[name*=pekerjaan]").prop("disabled", true);
					} else {
						parentTr.find("input[name*=target]").prop("disabled", false);
						parentTr.find("input[name*=realisasi]").prop("disabled", false);
						parentTr.find("textarea[name*=pekerjaan]").prop("disabled", false);
						parentTr.find("input[name*=lbrawal]").val(obj["awal"]);
						parentTr.find("input[name*=lembur_awal]").val(obj["awal"]);
						parentTr.find("input[name*=lbrakhir]").val(obj["akhir"]);
						parentTr.find("input[name*=lembur_akhir]").val(obj["akhir"]);
						parentSelect.css("background", "#ffffff");
						parentSelect.find(".spl-new-error").remove();
						if (noindSPL != null) {
							summon_count_overtime(noindSPL).then((overtime) => {
								parentTr.find("input[name*=overtime]").val(overtime);
								console.log(overtime);
							});
						}
						chk = "0";
						$(".spl-new-error").each(function () {
							chk = "1";
						});
						if (chk == "0") {
							$("button#submit_spl").attr("type", "submit").attr("class", "btn btn-primary");
						}
					}
				},
				error: function () {
					alert("error code : spl-cek");
				},
			});
		}
	});

	$("#spl-rekap").on("click", function (e) {
		e.preventDefault();
		var table = $(".spl-table").DataTable();
		var alamate = baseurl + "SPLSeksi/C_splseksi/rekap_spl_filter";

		table.clear().draw();
		$.ajax({
			url: alamate,
			type: "POST",
			data: {
				dari: $("#tgl_mulai").val(),
				sampai: $("#tgl_selesai").val(),
				noi: $("#noi").val(),
				noind: $("#noind").val(),
			},
			dataType: 'JSON',
			success(data) {
				if (data) {
				    table.clear().draw();
					table.rows.add(data);
					table.draw();
				} else {
					// alert('Data tidak di temukan');
					console.info("Data tidak ditemukan")
				}
			},
			error() {
			    console.error("#spl-rekap -> error")
			}
		});
	});

	for (let x = 0; x < 2; x++) {
		$("#spl-approval-" + x).on("click", { id: x }, function (e) {
			e.preventDefault();
			$(".btn-proses").addClass("disabled");
			$(this).prop("disabled", true);

			var id = e.data.id;
			var table = $(".spl-table").DataTable();

			if (id == 0) {
				var alamate = baseurl + "SPLSeksi/C_splkasie/data_spl_filter";
			} else {
				var alamate = baseurl + "SPLSeksi/C_splasska/data_spl_filter";
			}

			try {
				table.clear().draw();
				let windowHeight = 200;

				$.ajax({
					url: alamate,
					type: "POST",
					data: {
						tgl_checked: true,
						dari: $("#tgl_mulai").val(),
						sampai: $("#tgl_selesai").val(),
						status: $("#status").val(),
						lokasi: $("#lokasi").val(),
						noind: $("#noind").val(),
						kodesie: $("#kodesie").val(),
					},
					beforeSend() {
						$(".spl-table > tbody").html(`
            <tr>
							<td class="text-center" colspan="19">
							<div style="margin: 1em;">
								<img src="${baseurl}/assets/img/gif/loading6.gif" class="spl-loading" width="33px" height="33px" style="margin-right:3px">
							</div>
							<span>Memuat data ...</span>
              </td>
            </tr>
					`);
						window.scrollTo(0, windowHeight);
					},
					dataType: "json",
					success: (data) => {
						table.clear().draw();
						table.rows.add(data);
						table.draw();
						$(this).prop("disabled", false);

						if (data.length) {
							window.scrollTo(0, windowHeight);
						} else {
							// alert('Data tidak di temukan');
						}
					},
				});
			} catch (e) {
				$(this).prop("disabled", false);
			}
		});
	}

	$(document).on("ready", function () {
		$(".spl-chk-data").iCheck("destroy");

		$("#approveSPL, #rejectSPL").on("click", function () {
			const button = $(this).attr("id");

			if (!button || button === "") return;
			let reason = $("#spl_tex_proses");

			reason.on("change", () => {
				reason.css({
					border: "1px solid #ccc",
				});
			});

			if (!reason.val() && button === "rejectSPL") {
				reason.css({
					border: "1px solid red",
				});
				Swal.mixin({
					toast: true,
					position: "top-end",
					showConfirmButton: false,
					timer: 3000,
				}).fire({
					customClass: "swal-font-small",
					type: "error",
					title: "Masukkan alasan terlebih dahulu!",
				});
				return;
			} else {
				reason.css({
					border: "1px solid #ccc",
				});
			}

			if (button == "approveSPL") {
				$("#FingerDialogApprove").modal("show");
			} else {
				$("#FingerDialogReject").modal("show");
			}
		});
	});

	$(document).on("change", ".spl-chk-data", function (e) {
		spl_load_data();
	});

	$(document).on("input", "#spl_tex_proses", function (e) {
		spl_load_data();
	});

	function waitingFingerPrint() {
		var MESSAGE = "";
		var CALLBACK = () => null;
		var STORAGE_NAME = "resultApproveSPL";
		var DESTROY = () => window.removeEventListener("storage", resultStorage);
		var GET_ITEM = () => JSON.parse(localStorage.getItem(STORAGE_NAME));
		var SET_ITEM = (val) => localStorage.setItem(STORAGE_NAME, JSON.stringify(val));
		var ERROR_CODE = 3;

		// initial code
		SET_ITEM(false);

		function resultStorage(event) {
			console.log(event.key);
			if (event.key !== STORAGE_NAME) return;
			DESTROY();
			let done = GET_ITEM();

			if (done === true) {
				$("#ProsesDialog").modal("hide");
				$("#FingerDialogApprove").modal("hide");
				$("#FingerDialogReject").modal("hide");
				SET_ITEM(false);

				// call callback function
				CALLBACK();

			} else if (done === ERROR_CODE) {
				swal
					.fire({
						title: `Gagal, error code 500`,
						text: "",
						type: "error",
					})
					.then(() => {
						$("#spl-approval-1").click();
						$("#spl-approval-0").click();
					});
			} else {
				alert("Error : " + done);
			}
		}

		return {
			setCallback(newcallback) {
				CALLBACK = newcallback;
				return this;
			},
			setMessage(newmessage) {
				MESSAGE = newmessage;
				return this;
			},
			init() {
				DESTROY();
				window.addEventListener("storage", resultStorage);
			},
		};
	}

	const ApprovalLemburListener = waitingFingerPrint();

	$(document).on("click", "#FingerDialogReject .spl_finger_proses", function (e) {
		finger = $(this).attr("data");
		url = window.location.pathname;
		usr = $("#txt_ses").val();
		ket = $("#spl_tex_proses").val();

		if (url.indexOf("ALK") >= 0) {
			tmp = "finspot:FingerspotVer;";
		} else {
			tmp = "finspot:FingerspotVer;";
		}

		var client_table = $('.spl-table').DataTable();
		var chk = '';
		var rows = $( client_table.$('input[type="checkbox"]').each(function () {
			if ($(this).is(':checked')) {
				chk += "." + $(this).val();
			}
		}));

		if (chk == "") {
			$("#example11_wrapper").find("a.btn-primary").addClass("disabled");
		} else {
			$("#example11_wrapper").find("a.btn-primary").removeClass("disabled");
		}

		/**
		 * Kode status lembur
		 * 01 baru
		 * 21 approve by kasie
		 * 25 approve by aska
		 * 31 reject by kasie
		 * 35 reject by aska
		 * 11 sudah diproess
		 */

		let email_endpoint;
		var p_status;
		var p_spdlid;
		var p_ket;

		if (url.indexOf("ALK") >= 0) {
			// KASIE
			$("#spl_proses_reject").attr("href", tmp + btoa(baseurl + "ALK/Approve/fp_proces?userid=" + usr + "&finger_id=" + finger + "&stat=31&data=" + 'chk' + "&ket=" + 'ket'));

			email_endpoint = 'ALK/Approve/sendSPLEmail';

			p_status = '31';
			p_spdlid = chk;
			p_ket = ket;
		} else {
			// KEPALA UNIT
			$("#spl_proses_reject").attr("href", tmp + btoa(baseurl + "ALA/Approve/fp_proces?userid=" + usr + "&finger_id=" + finger + "&stat=35&data=" + 'chk' + "&ket=" + 'ket'));

			email_endpoint = 'ALA/Approve/sendSPLEmail';
			
			p_status = '35';
			p_spdlid = chk;
			p_ket = ket;
		}
		console.log("end point email: " + baseurl + email_endpoint);

		function send_email() {
			fakeLoading(0);
			$.ajax({
				method: "post",
				data: {
					status: p_status,
					spl_id: p_spdlid,
					ket: p_ket
				},
				url: baseurl + email_endpoint,
				success:function (e) {
					fakeLoading(1);
					swal.fire({
						title: `Sukses Reject lembur pekerja`,
						text: "",
						type: "success",
					});
					$("#spl-approval-1").click();
					$("#spl-approval-0").click();
					$("#spl_check_all").iCheck("uncheck");
					console.log(e + "Success email");
				},
			});
		}

		let apiProcess = $("#spl_proses_reject").attr("href");
		window.location.href = apiProcess;

		ApprovalLemburListener.setMessage("Reject").setCallback(send_email).init();
	});

	$(document).ready(function(){
		// swal.fire({
		// 	title: `Sukses Approve lembur pekerja`,
		// 	text: "",
		// 	type: "success",
		// });
	});

	$(document).on("click", "#FingerDialogApprove .spl_finger_proses", function (e) {
		finger = $(this).attr("data");
		url = window.location.pathname;
		usr = $("#txt_ses").val();
		ket = $("#spl_tex_proses").val();

		if (url.indexOf("ALK") >= 0) {
			tmp = "finspot:FingerspotVer;";
		} else {
			tmp = "finspot:FingerspotVer;";
		}

		var client_table = $('.spl-table').DataTable();
		var chk = '';
		var rows = $( client_table.$('input[type="checkbox"]').each(function () {
			if ($(this).is(':checked')) {
				chk += "." + $(this).val();
			}
		}));

		if (chk == "") {
			$("#example11_wrapper").find("a.btn-primary").addClass("disabled");
		} else {
			$("#example11_wrapper").find("a.btn-primary").removeClass("disabled");
		}

		let email_endpoint;
		var p_status;
		var p_spdlid;
		var p_ket;
		if (url.indexOf("ALK") >= 0) {
			$("#spl_proses_approve").attr("href", tmp + btoa(baseurl + "ALK/Approve/fp_proces?userid=" + usr + "&finger_id=" + finger + "&stat=21&data=" + 'chk' + "&ket=" + 'ket'));
			email_endpoint = 'ALK/Approve/sendSPLEmail';

			p_status = '21';
			p_spdlid = chk;
			p_ket = ket;
		} else {
			$("#spl_proses_approve").attr("href", tmp + btoa(baseurl + "ALA/Approve/fp_proces?userid=" + usr + "&finger_id=" + finger + "&stat=25&data=" + 'chk' + "&ket=" + 'ket'));
			email_endpoint = 'ALA/Approve/sendSPLEmail';

			p_status = '25';
			p_spdlid = chk;
			p_ket = ket;
		}

		console.log("end point email: " + baseurl + email_endpoint);

		function send_email() {
			fakeLoading(0);
			$.ajax({
				type: "post",
				data: {
					status: p_status,
					spl_id: p_spdlid,
					ket: p_ket
				},
				url: baseurl + email_endpoint,
				success:function(e) {
					fakeLoading(1);
					swal.fire({
						title: `Sukses Approve lembur pekerja`,
						text: "",
						type: "success",
					});
					$("#spl-approval-1").click();
					$("#spl-approval-0").click();
					$("#spl_check_all").iCheck("uncheck");
					console.log(e + "Success Email");
				},
			});
		}

		let apiProcess = $("#spl_proses_approve").attr("href");
		window.location.href = apiProcess;

		ApprovalLemburListener.setMessage("Approve").setCallback(send_email).init();
	});
});

$(document).ready(function () {
	$(".spl-time-mask").on("input", function (e) {
		value = $(this).val();
		if (value.length > 0) {
			value = value.match(/\d/g);
			if (value !== null) {
				value = value.join("");
				valjam = value.substring(0, 2);
				// console.log(valjam);
				if (parseInt(valjam) >= 24) {
					valjam = "23";
				}
				valmenit = value.substring(2, 4);
				// console.log(valmenit);
				if (parseInt(valmenit) >= 60) {
					valmenit = "59";
				}
				valdetik = value.substring(4, 6);
				// console.log(valdetik);
				if (parseInt(valdetik) >= 60) {
					valdetik = "59";
				}

				if (value.length > 4) {
					value = valjam.concat(":", valmenit, ":", valdetik);
				} else if (value.length > 2) {
					value = valjam.concat(":", valmenit);
				}
			} else {
				value = "00:00:00";
			}
		}
		$(this).val(value);
	});

	$(".spl-time-mask").on("focusout", function (e) {
		value = $(this).val();
		if (value.length > 0) {
			value = value.match(/\d/g);
			if (value !== null) {
				value = value.join("");
				valjam = value.substring(0, 2);
				if (parseInt(valjam) >= 24) {
					valjam = "23";
				} else if (parseInt(valjam) < 10 && valjam.length < 2) {
					valjam = "0" + valjam;
				}
				if (valjam.length == 0) {
					valjam = "00";
				}

				valmenit = value.substring(2, 4);
				if (parseInt(valmenit) >= 60) {
					valmenit = "59";
				} else if (parseInt(valmenit) < 10 && valmenit.length < 2) {
					valmenit = "0" + valmenit;
				}
				if (valmenit.length == 0) {
					valmenit = "00";
				}

				valdetik = value.substring(4, 6);
				if (parseInt(valdetik) >= 60) {
					valdetik = "59";
				} else if (parseInt(valdetik) < 10 && valdetik.length < 2) {
					valdetik = "0" + valdetik;
				}
				if (valdetik.length == 0) {
					valdetik = "00";
				}

				value = valjam.concat(":", valmenit, ":", valdetik);
			} else {
				value = "00:00:00";
			}
		}
		$(this).val(value);

		var time = $(this).val();
		var date = $(this).closest('div.form-group').find('input.spl-date').val();
		var now = getDate2();

		var d1 = Date.parse(date.replace( /(\d{2})-(\d{2})-(\d{4})/, "$2/$1/$3")+' '+time);
		var d2 = Date.parse(now);
		if(d1 > d2){
			alert('Tidak bisa memilih waktu lebih dari hari ini!');
			$(this).val('00:00:00');
		}
	});

	$("#spl-memopresensi").on("submit", function (e) {
		e.preventDefault();
		$.ajax({
			url: baseurl + "SPLSeksi/C_splseksi/submit_memo",
			type: "POST",
			data: new FormData(this),
			processData: false,
			contentType: false,
			cache: false,
			async: true,
			success: function (data) {
				window.location.href = baseurl + "SPLSeksi/C_splseksi/pdf_memo?id=" + data;
			},
		});
	});

	$("#spl-fingerspot").on("click", ".spl-fingerprint-modal-edit-triger", function (e) {
		sn = $(this).closest("tr").find(".d-sn").text();
		vc = $(this).closest("tr").find(".d-vc").text();
		ac = $(this).closest("tr").find(".d-ac").text();
		vkey = $(this).closest("tr").find(".d-vkey").text();
		idf = $(this).attr("data-id");
		$("#spl-fingerprint-modal-edit-id").val(idf);
		$("#spl-fingerprint-modal-edit-sn").val(sn);
		$("#spl-fingerprint-modal-edit-vc").val(vc);
		$("#spl-fingerprint-modal-edit-ac").val(ac);
		$("#spl-fingerprint-modal-edit-vkey").val(vkey);
		$("#spl-fingerprint-modal-edit").modal({
			backdrop: "static",
			keyboard: false,
		});
		$("#spl-fingerprint-modal-edit").modal("show");
	});

	$(".spl-fingerprint-modal-edit-close").on("click", function (e) {
		$("#spl-fingerprint-modal-edit").modal("hide");
	});

	$("#spl-fingerprint-modal-edit-update").on("click", function (e) {
		idf = $("#spl-fingerprint-modal-edit-id").val();
		sn = $("#spl-fingerprint-modal-edit-sn").val();
		vc = $("#spl-fingerprint-modal-edit-vc").val();
		ac = $("#spl-fingerprint-modal-edit-ac").val();
		vkey = $("#spl-fingerprint-modal-edit-vkey").val();
		if (sn == "" || vc == "" || ac == "" || vkey == "") {
			alert("Lengkapi Data Yang Masih Kosong !!");
		} else {
			$.ajax({
				data: { idf: idf, sn: sn, vc: vc, ac: ac, vkey: vkey },
				type: "POST",
				url: baseurl + "SPL/DaftarFingerspot/updateFingerspot",
				success: function (e) {
					alert("Sukses");
					generateFingerspotTable();
					$("#spl-fingerprint-modal-edit").modal("hide");
				},
				error: function (request, status, error) {
					alert(request.responseText);
				},
			});
		}
	});

	$("#spl-fingerprint-modal-add-triger").on("click", function (e) {
		$("#spl-fingerprint-modal-add").modal({
			backdrop: "static",
			keyboard: false,
		});
		$("#spl-fingerprint-modal-add").modal("show");
	});

	$(".spl-fingerprint-modal-add-close").on("click", function (e) {
		$("#spl-fingerprint-modal-add").modal("hide");
	});

	$("#spl-fingerprint-modal-add-save").on("click", function (e) {
		sn = $("#spl-fingerprint-modal-add-sn").val();
		vc = $("#spl-fingerprint-modal-add-vc").val();
		ac = $("#spl-fingerprint-modal-add-ac").val();
		vkey = $("#spl-fingerprint-modal-add-vkey").val();
		if (sn == "" || vc == "" || ac == "" || vkey == "") {
			alert("Lengkapi Data Yang Masih Kosong !!");
		} else {
			$.ajax({
				data: { sn: sn, vc: vc, ac: ac, vkey: vkey },
				type: "POST",
				url: baseurl + "SPL/DaftarFingerspot/insertFingerspot",
				success: function (e) {
					alert("Sukses");
					generateFingerspotTable();
					$("#spl-fingerprint-modal-add").modal("hide");
				},
				error: function (request, status, error) {
					alert(request.responseText);
				},
			});
		}
	});

	$("#spl-fingerspot").on("click", ".spl-fingerprint-delete", function (e) {
		idf = $(this).attr("data-id");
		con = confirm("Yakin ingin menghapus device ini ?");
		if (con) {
			$.ajax({
				data: { id: idf },
				type: "POST",
				url: baseurl + "SPL/DaftarFingerspot/deleteFingerspot",
				success: function (e) {
					alert("Sukses");
					generateFingerspotTable();
				},
				error: function (request, status, error) {
					alert(request.responseText);
				},
			});
		}
	});

	$(".spl-fingertemp-modal-select-noind").select2({
		ajax: {
			url: baseurl + "SPL/Daftarjari/getUserfinger",
			dataType: "json",
			type: "get",
			data: function (params) {
				return { key: params.term };
			},
			processResults: function (data) {
				return {
					results: $.map(data, function (item) {
						return {
							id: item.noind,
							text: item.noind + " - " + item.noind_baru + " - " + item.nama,
						};
					}),
				};
			},
			cache: true,
		},
		minimumInputLength: 2,
		placeholder: "Silahkan pilih",
		allowClear: true,
		dropdownParent: $("#spl-fingertemp-modal-user"),
	});

	$("#spl-fingertemp-modal-add-user-triger").on("click", function () {
		$(".spl-fingertemp-modal-select-noind").select2("val", "");
		$("#spl-fingertemp-modal-user").modal({
			backdrop: "static",
			keyboard: false,
		});
		$("#spl-fingertemp-modal-user").modal("show");
	});

	$(".spl-fingertemp-modal-user-add").on("click", function (e) {
		noind = $(".spl-fingertemp-modal-select-noind").val();
		$.ajax({
			data: { noind: noind },
			type: "POST",
			url: baseurl + "SPL/DaftarFingerspot/getfingerdata",
			success: function (data) {
				$("#spl-fingertemp-modal-finger tbody").html(data);
				$("#spl-fingertemp-modal-finger").modal({
					backdrop: "static",
					keyboard: false,
				});
				$("#spl-fingertemp-modal-finger").modal("show");
				$("#spl-fingertemp-modal-user").modal("hide");
			},
			error: function (request, status, error) {
				alert(request.responseText);
			},
		});
	});

	$(".spl-fingertemp-modal-user-close").on("click", function () {
		$("#spl-fingertemp-modal-user").modal("hide");
	});

	$("#spl-fingertemp").on("click", ".spl-fingertemp-modal-add-temp-triger", function () {
		noind = $(this).attr("data-id");
		$.ajax({
			data: { noind: noind },
			type: "POST",
			url: baseurl + "SPL/DaftarFingerspot/getfingerdata",
			success: function (data) {
				$("#spl-fingertemp-modal-finger tbody").html(data);
				$("#spl-fingertemp-modal-finger").modal({
					backdrop: "static",
					keyboard: false,
				});
				$("#spl-fingertemp-modal-finger").modal("show");
			},
			error: function (request, status, error) {
				alert(request.responseText);
			},
		});
	});

	$(".spl-fingertemp-modal-finger-close").on("click", function (e) {
		generateFingertempTable();
		$("#spl-fingertemp-modal-finger").modal("hide");
	});

	$("#spl-fingertemp").on("click", ".spl-fingertemp-delete", function (e) {
		noind = $(this).attr("data-id");
		con = confirm("Yakin ingin menghapus semua template finger no induk (" + noind + ") ini ?");
		if (con) {
			$.ajax({
				data: { noind: noind },
				type: "POST",
				url: baseurl + "SPL/DaftarFingerspot/deleteFingertempAll",
				success: function (e) {
					alert("Sukses");
					generateFingertempTable();
				},
				error: function (request, status, error) {
					alert(request.responseText);
				},
			});
		}
	});

	$("#spl-fingertemp-modal-finger").on("click", ".spl-fingertemp-modal-finger-delete", function (e) {
		jari = $(this).attr("data-fid");
		userid = $(this).attr("data-userid");
		noind = $(this).attr("data-noind");
		con = confirm("Apakah anda yakin ingin menghapus template finger (" + jari + ") ini ?");
		if (con) {
			$.ajax({
				data: { jari: jari, userid: userid },
				type: "POST",
				url: baseurl + "SPL/DaftarFingerspot/deleteFingertemp",
				success: function (e) {
					alert("Sukses");
					$.ajax({
						data: { noind: noind },
						type: "POST",
						url: baseurl + "SPL/DaftarFingerspot/getfingerdata",
						success: function (data) {
							$("#spl-fingertemp-modal-finger tbody").html(data);
						},
						error: function (request, status, error) {
							alert(request.responseText);
						},
					});
				},
				error: function (request, status, error) {
					alert(request.responseText);
				},
			});
		}
	});

	$("#spl-fingertemp-modal-finger").on("click", ".spl-fingertemp-modal-finger-add", function (e) {
		jari = $(this).attr("data-fid");
		userid = $(this).attr("data-userid");
		noind = $(this).attr("data-noind");
		link_base64encode = btoa(baseurl + "SPL/DaftarFingerspot/finger_register?userid=" + userid + "&finger=" + jari);
		window.location.href = "finspot:FingerspotReg;" + link_base64encode;
		var run = 0;
		var interval = setInterval(function () {
			$.ajax({
				data: { noind: noind },
				type: "POST",
				url: baseurl + "SPL/DaftarFingerspot/getfingerdata",
				success: function (data) {
					$("#spl-fingertemp-modal-finger tbody").html(data);
					generateFingertempTable();
				},
				error: function (request, status, error) {
					alert(request.responseText);
				},
			});
			if (run === 25) {
				clearInterval(interval);
			}
			run++;
		}, 1000);
	});
});

function generateFingerspotTable() {
	$.ajax({
		data: { id: "1" },
		type: "POST",
		url: baseurl + "SPL/DaftarFingerspot/generateFingerspotTable",
		success: function (data) {
			$("tbody").html(data);
		},
		error: function (request, status, error) {
			alert(request.responseText);
		},
	});
}

function generateFingertempTable() {
	$.ajax({
		data: { id: "1" },
		type: "POST",
		url: baseurl + "SPL/DaftarFingerspot/generateFingertempTable",
		success: function (data) {
			$("tbody#spl-fingertemp").html(data);
		},
		error: function (request, status, error) {
			alert(request.responseText);
		},
	});
}

const summon_count_overtime = (noind) => {
	let tgl = $(".spl-date").val(),
		start = $("input[name=waktu_0]").val(),
		end = $("input[name=waktu_1]").val(),
		type = $("select[name=kd_lembur]").val(),
		isbreak = $("input[name*=break]:checked").val() == 1 ? "Y" : "N",
		isrest = $("input[name*=istirahat]:checked").val() == 1 ? "Y" : "N";

	//console.log(noind, tgl, start, end, type, isbreak, isrest);

	if (noind == undefined || tgl == "" || start == "" || end == "" || type == "") {
		$("#estJamLembur").text("Isi semua data");
	} else {
		return count_overtime(tgl, start, end, type, isbreak, isrest, noind).then((res) => res);
	}
};

const count_overtime = (...args) => {
	return new Promise((resolve) => {
		let params = {
			date: args[0],
			start: args[1],
			end: args[2],
			type: args[3],
			isbreak: args[4],
			isrest: args[5],
			noind: args[6],
		};

		$.ajax({
			method: "POST",
			data: params,
			url: baseurl + "SPL/Pusat/ajax_count_overtime",
			success: (res) => {
				$("#estJamLembur").text(res + " jam");
				resolve(res);
			},
		});
	});
};

$(document).on("ifChecked", "input[name=break], input[name=istirahat]", (e) => {
	let noind = $(".spl-pkj-select2").val();
	summon_count_overtime(noind);
});

// !!! TRIAL
function checkLembur() {
	const endpoint = baseurl + "SPLSeksi/Pusat/C_splseksi/cek_anonymous2";

	let tanggal0 = $("input[name*=tanggal_0]").val();
	let tanggal1 = $("input[name*=tanggal_1]").val();
	let waktu0 = $("input[name*=waktu_0]").val();
	let waktu1 = $("input[name*=waktu_1]").val();
	let lembur = $("select[name*=kd_lembur]").val();
	let istirahat = $("input[name*=istirahat]:checked").val();
	let break0 = $("input[name*=break]:checked").val();

	if (!!noindSPL) {
		$.ajax({
			url: endpoint,
			type: "POST",
			data: {
				noind: noindSPL,
				tanggal0: tanggal0,
				tanggal1: tanggal1,
				waktu0: waktu0,
				waktu1: waktu1,
				lembur: lembur,
				istirahat: istirahat,
				break0: break0,
			},
			success: function (data) {
				//coba
			},
		});
	}
}

$(document).ready(function () {
	// estimasi jam lembur /menu input dan edit
	let noind = $(".spl-pkj-select2").val();
	summon_count_overtime(noind);

	$(".spl-date, input[name=waktu_0], input[name=waktu_1], select[name=kd_lembur], input[type=radio][name=istirahat], input[type=radio][name=break]").change(() => {
		let noind = $(".spl-pkj-select2").val();

		summon_count_overtime(noind);
	});

	//-------INPUT PAGE--------------------------------------
	$("#example11").on("change", ".target-satuan", function () {
		let unit = $(this).val();
		$(this).closest("tr").find(".realisasi-satuan").val(unit);
	});

	$("#example11").on("input", ".pekerjaan", function (e) {
		$(this).css("height", this.scrollHeight + "px");
	});

	//-------END INPUT PAGE----------------------------------

	//-------PERSONALIA PAGE---------------------------------

	$(".lembur-personalia-pekerja").select2({
		ajax: {
			url: baseurl + "SPL/AccessSection/ajax/showpekerja",
			dataType: "json",
			method: "GET",
			data: (a) => {
				return {
					key: a.term,
				};
			},
			processResults: (data) => {
				return {
					results: $.map(data, (item) => {
						return {
							id: item.noind,
							text: item.noind + " - " + item.nama,
						};
					}),
				};
			},
		},
		minimumInputLength: 2,
		placeholder: "Silahkan pilih",
		allowClear: true,
	});

	$(".lembur-personalia-seksi").select2({
		ajax: {
			url: baseurl + "SPL/AccessSection/ajax/showallsection",
			dataType: "json",
			method: "GET",
			data: (a) => {
				return {
					key: a.term,
				};
			},
			processResults: (data) => {
				return {
					results: $.map(data, (item) => {
						return {
							id: item.kodesie + " - " + item.nama,
							text: item.kodesie + " - " + item.nama,
						};
					}),
				};
			},
		},
		minimumInputLength: 2,
		placeholder: "Silahkan pilih",
		allowClear: true,
	});

	//listener button modal add row access section
	$("#btnAddRowAccessSection").click(function () {
		btnAddRowListener();
	});

	//table with datatable plugin
	$("#tabel-access-section").DataTable();

	//listener button delete row on table access section
	btnDelRowListener();

	//page input data & edit data
	$(".pekerjaan, textarea[name=alasan]").keypress(function (e) {
		var txt = String.fromCharCode(e.which);
		if (!txt.match(/[A-Za-z0-9 +#.%&-]/)) {
			return false;
		}
	});

	//-----END PERSONALIA PAGE-----------------------------------
});

const clearModalTable = () => {
	$("#deleteAccessSection").hide();
	$(".lembur-personalia-pekerja").select2("val", "");
	$(".lembur-personalia-pekerja").prop("disabled", false);
	$(".lembur-personalia-seksi").select2("val", "");
	$("#overtime_table_access_section > tbody").html("");
};

const btnEditListener = (e) => {
	//show delete buttons

	let noind = e.data("noind");
	let nama = e.data("nama");
	e.click(() => {
		//clear modal table
		clearModalTable();
		$("#deleteAccessSection").show();
		let option = $("<option selected></option>")
			.val(noind)
			.text(noind + " - " + nama);
		$(".lembur-personalia-pekerja").append(option).trigger("change");
		$(".lembur-personalia-pekerja").prop("disabled", true);

		$.ajax({
			method: "GET",
			url: baseurl + "SPL/AccessSection/ajax/getInfoNoind",
			beforeSend: () => {
				$("#overtime_table_access_section > tbody").html('<tr><td colspan="4"><center>loading...</center></td></tr>');
			},
			data: {
				noind,
			},
			dataType: "json",
			success: (res) => {
				let tableHTML;
				let num = 1;
				res.forEach((item) => {
					tableHTML += `
						<tr>
							<td>${num++}</td>
							<td>${item.kodesie}</td>
							<td>${item.nama_seksi}</td>
							<td><button class="btn btn-danger btn-sm delSelf"><i class="fa fa-minus"></i></button></td>
						</tr>
					`;
				});
				$("#overtime_table_access_section > tbody").html(tableHTML);
				btnDelRowListener();
			},
			error: () => {
				console.log("error custom SPL function btnEditListener");
			},
		});
	});
};

const btnDeleteAccessListener = () => {
	let noind = $(".lembur-personalia-pekerja").val();
	swal
		.fire({
			title: "Yakin untuk menghapus akses ?",
			text: "Akses akun akan terhapus",
			type: "warning",
			showCancelButton: !0,
		})
		.then((res) => {
			if (res.value) {
				//do ajax delete
				$.ajax({
					method: "POST",
					url: baseurl + "SPL/AccessSection/ajax/deleteAccess",
					data: {
						noind,
					},
					success: (res) => {
						swal.fire(`Akses noind  <b>${noind}</b>  telah dihapus`, "", "success").then((res) => location.reload());
					},
				});
			}
		});
};

const btnAddRowListener = () => {
	let elemSection = $(".lembur-personalia-seksi");

	let section = elemSection.val();

	if (section == "" || section == null) {
		swal.fire("Isi Seksi terlebih dahulu", "", "warning");
		return;
	}

	let arrayOfExistKodesie = [];
	let getExistVal = $("#overtime_table_access_section tbody > tr").each(function () {
		let kodesie = $(this).find("td:eq(1)").text().trim();
		arrayOfExistKodesie.push(kodesie);
	});

	let section_number = section.split("-")[0].trim();
	let section_name = section.split("-")[1].trim();

	if (arrayOfExistKodesie.includes(section_number)) {
		swal.fire("Kodesie tidak boleh ganda", "", "warning");
		return;
	}

	let lastNum = $("#overtime_table_access_section > tbody > tr").length + 1;

	let rowElement = `
		<tr>
			<td>${lastNum++}</td>
			<td>${section_number}</td>
			<td>${section_name}</td>
			<td><button class="btn btn-danger btn-sm delSelf"><i class="fa fa-minus"></i></button></td>
		</tr>
	`;
	$("#overtime_table_access_section > tbody").append(rowElement);
	btnDelRowListener();
};

const btnDelRowListener = () => {
	$("#overtime_table_access_section > tbody > tr > td > button.delSelf").each(function () {
		$(this).click(() => {
			$(this).closest("tr").remove();
			reNumberingTable();
		});
	});
};

const reNumberingTable = () => {
	let row = $("#overtime_table_access_section > tbody > tr");
	let num = 1;

	row.each(function () {
		$(this)
			.find("td")
			.first()
			.text(num++);
	});
};

const saveAccessSection = () => {
	let noind = $(".lembur-personalia-pekerja").val();
	if (noind == null || noind == "") {
		swal.fire("Tidak ada pekerja yang ditambahkan", "", "warning");
		return;
	}

	let arrayOfExistKodesie = [];
	let getExistVal = $("#overtime_table_access_section tbody > tr").each(function () {
		let kodesie = $(this).find("td:eq(1)").text().trim();
		arrayOfExistKodesie.push(kodesie);
	});

	if (arrayOfExistKodesie.length == 0) {
		swal.fire("Seksi masih kosong", "", "warning");
	} else {
		// do insert with ajax
		$.ajax({
			method: "POST",
			url: baseurl + "SPL/AccessSection/ajax/insertAccessSection",
			data: {
				noind,
				kodesie: arrayOfExistKodesie,
			},
			success: (res) => {
				// after it just reload the page
				swal.fire("sukses menyimpan akses noind " + noind, "", "success").then((res) => location.reload());
			},
			error: (res) => {
				swal.fire("System error, Tidak bisa input data", "", "error");
			},
		});
	}
};

//Seksi PAGE
const deleteLembur = (e) => {
	let id_spl = e.data("id");
	let worker = e.data("noind") + " - " + e.data("nama");

	swal
		.fire({
			title: "Yakin untuk menghapus SPL <br>" + worker,
			text: "pastikan tidak salah menghapus SPL",
			type: "warning",
			showCancelButton: !0,
		})
		.then((res) => {
			if (res.value) {
				//do deleting with ajax
				$.ajax({
					method: "GET",
					async: false,
					url: baseurl + "SPL/Pusat/HapusLembur/" + id_spl,
					success: () => {
						swal.fire("Sukses menghapus SPL", "", "success");
						e.closest("tr").remove();
					},
				});
			}
		});
};

const configStorageAlert = () => {
	let lastData = window.localStorage.getItem("alert-SPL");
	let json = JSON.parse(lastData);
	let count = json.count + 1;

	let now = d.getHours() + ":" + d.getMinutes();
	let today = d.getFullYear() + "-" + (d.getMonth() + 1) + "-" + d.getDate();

	let data = {
		count,
		lastTime: now,
		today,
	};

	window.localStorage.setItem("alert-SPL", JSON.stringify(data));
};

const sendReminder = () => {
	let lastData = window.localStorage.getItem("alert-SPL");
	let json = JSON.parse(lastData);
	// button di click lg cek dulu lastime apakah jam skrng > lastime+1hours
	const d = new Date();

	let now = d.getHours() + ":" + d.getMinutes();
	let today = d.getFullYear() + "-" + (d.getMonth() + 1) + "-" + d.getDate();

	if (json.count == 1) {
		let lastTime = new Date(today + " " + json.lastTime);
		let thisnow = today + " " + now;
		lastTime = today + " " + (lastTime.getHours() + 1) + ":" + lastTime.getMinutes();

		let anow = new Date(thisnow);
		let alast = new Date(lastTime);

		if (anow < alast) {
			let waiting = (alast - anow) / 1000 / 60;
			Swal.fire(`Silahkan menunggu ${waiting} menit`, "untuk mengirimkan notifkasi lagi", "warning");
			return;
		}
	} else if (json.count == 2) {
		Swal.fire("Tidak bisa mengirim notifkasi lagi", "maksimal sehari adalah 2x", "warning");
		return;
	}

	swal
		.fire({
			title: "Kirim Email Reminder SPL yang belum di proses ke Atasan",
			text: "Notifikasi akan dikirimkan ke semua atasan seksi",
			type: "warning",
			showCancelButton: !0,
		})
		.then((res) => {
			if (res.value) {
				//store the changes to localStorage
				configStorageAlert();
				//do deleting with ajax
				$.ajax({
					method: "GET",
					url: baseurl + "SPL/Pusat/ajax/sendReminderEmail",
					beforeSend: () => {
						Swal.fire({
							html: "loading....",
							allowOutsideClick: !1,
							showCancelButton: !1,
							showConfirmButton: !1,
						});
					},
					success: () => {
						Swal.close();
						swal.fire("Sukses mengirimkan reminder Atasan", "Silahkan menunggu 1 jam lagi untuk mengirimkan reminder", "success");
					},
				});
			}
		});
};

const add_jobs_spl = (e) => {
	let tr = e.closest("tr");

	let nextrow = tr.next(".multiinput.parent");
	let jobsrow = tr.nextUntil(nextrow, "tr.spl-jobs");

	let row = tr.data("row");
	let jobsHTML = `
    <tr class="spl-jobs">
        <td colspan="5"></td>
        <td>
            <input type="number" class="form-control" name="target[${row}][]" required>
        </td>
        <td>
            <select class="form-control target-satuan" name="target_satuan[${row}][]" required>
                <option value=""></option>
                <option value="Pcs">Pcs</option>
                <option value="%">%</option>
                <option value="Box">Box</option>
                <option value="Kg">Kg</option>
                <option value="Unit">Unit</option>
                <option value="Ton">Ton</option>
                <option value="Flask">Flask</option>
            </select>
        </td>
        <td>
            <input type="number" class="form-control" name="realisasi[${row}][]" required>
        </td>
        <td>
            <input type="text" class="form-control realisasi-satuan" name="realisasi_satuan[${row}][]" readonly>
        </td>
        <td>
            <textarea style="resize: vertical; min-height: 30px;" class="form-control pekerjaan" rows="1" name="pekerjaan[${row}][]"></textarea>
        </td>
        <td colspan='2'>
            <button type="button" onclick="del_jobs_spl($(this), ${row})" class="btn btn-sm btn-default"><i class="fa fa-minus"></i></button>
        </td>
    </tr>
    `;

	if (jobsrow.length == 0) {
		tr.after(jobsHTML);
	} else {
		jobsrow.last().after(jobsHTML);
	}
};

const add_jobs_spl_edit = (e) => {
	let tr = e.closest("tbody");
	let jobsHTML = `
    <tr>
        <td colspan="2"></td>
        <td>
            <input type="number" class="form-control" name="target[]" required>
        </td>
        <td>
            <select class="form-control target-satuan" name="target_satuan[]" required>
                <option value=""></option>
                <option value="Pcs">Pcs</option>
                <option value="%">%</option>
                <option value="Box">Box</option>
                <option value="Kg">Kg</option>
                <option value="Unit">Unit</option>
                <option value="Ton">Ton</option>
                <option value="Flask">Flask</option>
            </select>
        </td>
        <td>
            <input type="number" class="form-control" name="realisasi[]" required>
        </td>
        <td>
            <input type="text" class="form-control realisasi-satuan" name="realisasi_satuan[]" readonly>
        </td>
        <td>
            <textarea style="resize: vertical; min-height: 30px;" class="form-control texarea-vertical pekerjaan" rows="1" name="pekerjaan[]"></textarea>
        </td>
        <td>
            <button class="btn btn-sm" onclick="del_jobs_spl($(this))" type="button"><i class="fa fa-minus"></i></button>
        </td>
    </tr>
    `;
	tr.append(jobsHTML);
};

const del_jobs_spl = (e) => {
	e.closest("tr").remove();
};

$(document).ready(function () {
	$(".spl_exportlist_excel").on("click", function () {
		let val = $("#frm_list_lembur").serialize();
		let url = baseurl + "SPLSeksi/C_splseksi/export_excel?" + val;
		window.open(url, "_blank");
	});

	$("#spl-rekap-excel").on("click", function () {
		let val = $("#frm_rekap_lembur").serialize();
		let url = baseurl + "SPLSeksi/C_splseksi/export_rekap_excel?" + val;
		window.open(url, "_blank");
	});

	const auth_finger = {
		storage_name: "auth_fingerprint_spl",
		json_template: {
			success: Boolean,
			date: Date,
		},
		get value() {
			const raw = localStorage.getItem(this.storage_name);
			const json = JSON.parse(raw);
			return json;
		},
		set value(val) {
			// json
			const toJSON = JSON.stringify(val);
			localStorage.setItem(this.storage_name, toJSON);
		},
		action(e) {
			if (e.key !== this.storage_name) return;
			console.log("something in storage is changed");
			if (this.value.success === true) {
				window.location.reload();
			}
		},
		listener() {
			window.addEventListener("storage", this.action.bind(this));
		},
		init() {
			this.value = {
				success: false,
				date: moment().format("YYYY-mm-DD H:mm:s"),
			};
			this.listener();
		},
	};

	$(".spl_process_auth").click(function (e) {
		e.preventDefault();
		const fingerspot_sdk_url = $(this).attr("href");

		window.location.href = fingerspot_sdk_url;
		console.log(fingerspot_sdk_url);
		auth_finger.init();
	});

	$('#btn-ProsesSPL').click(function(){
		var l = $('.spl-chk-data:checked').length;
		var client_table = $('.spl-table').DataTable();
		var x = 0;
		var rows = $( client_table.$('input[type="checkbox"]').each(function () {
			if ($(this).is(':checked')) {
				x++;
			}
		}));
		console.log('jumlah checkbox',l, x);
		if (x < -1) {
			Swal.fire(
				'Tidak Bisa Memilih Pekerja lebih dari 100',
				'Mohon Kurangi jumlah pilihan Pekerja!',
				'error'
				);
		}else{
			$('#ProsesDialog').modal('show');
		}
	});
});

$(window).load(() => {
	$("#spl_check_all").on("ifChanged", function (e) {
		let isChecked = $(this).is(":checked");
		if (isChecked) {
			var client_table = $('.spl-table').DataTable();
			var rows = $( client_table.$('input[type="checkbox"]').each(function () {
				$(this).prop("checked", true);
			}));
		} else {
			var client_table = $('.spl-table').DataTable();
			var rows = $( client_table.$('input[type="checkbox"]').each(function () {
				$(this).prop("checked", false);
			}));
		}
		spl_load_data();
	});
});

function getDate1()
{
	var D = new Date();
	var y = D.getFullYear();
	var m = D.getMonth()+1;
	var d = D.getDate();

	var h = D.getHours();
	var min = D.getMinutes();
	var s = D.getSeconds(); 

	console.log(d+'/'+m+'/'+y+' '+h+':'+m+':'+s);
	return d+'/'+m+'/'+y+' '+h+':'+m+':'+s;
}

function getDate2()
{
	var D = new Date();
	var y = D.getFullYear();
	var m = D.getMonth()+1;
	var d = D.getDate();

	var h = D.getHours();
	var min = D.getMinutes();
	var s = D.getSeconds(); 

	console.log(d+'/'+m+'/'+y+' '+h+':'+m+':'+s);
	return m+'/'+d+'/'+y+' '+h+':'+m+':'+s;
}