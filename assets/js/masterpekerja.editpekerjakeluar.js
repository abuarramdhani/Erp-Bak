/**
 * use gulp/grunt/roller/webpack is better :)
 * |----------------------------
 * | Dependencies
 * |----------------------------
 * Jquery
 * Select2
 * Datatables
 * Icheck
 * Sweetalert2
 * Datepicker
 * Moment
 */

"use strict";

// set global locale of moment JS to indonesian
moment.locale("id");

/**
 * replace param url
 */
function update_param_url(ObjUrl) {
	let params = $.param(ObjUrl);
	let pathname = window.location.pathname + "?" + params;
	window.history.replaceState(null, null, pathname);
}

$(function () {
	console.info("zzz... headache");

	const SELECTED_NOIND = $("input[name=noind]").val();
	let TGL_DIANGKAT = moment($("input[name=diangkat]").val(), ["DD-MM-YYYY"]).format("YYYY-MM-DD");

	// fullscreen button @deprecated
	$("button.btn-fullscreen").click(function () {
		document.querySelector(".nav-tabs-custom");
		this.requetstFullScreen;
	});

	/**
	 * Sweet alert mixin
	 * Alert like toast
	 */
	const Toast = Swal.mixin({
		toast: true,
		position: "top-center",
		showConfirmButton: false,
		timer: 3000,
		timerProgressBar: true,
		onOpen: (toast) => {
			toast.addEventListener("mouseenter", Swal.stopTimer);
			toast.addEventListener("mouseleave", Swal.resumeTimer);
		},
	});

	/**
	 * Form cari pekerja
	 */
	const cariPekerja = {
		init() {
			$("div#search-container select#select-pekerja").select2({
				minimumInputLength: 3,
				allowClear: true,
				ajax: {
					url: baseurl + "MasterPekerja/DataPekerjaKeluar/data_pekerja",
					dataType: "json",
					type: "GET",
					data: (params) => {
						const keluarElement = $('div#search-container input[name="keluar"]:checked');

						return { term: params.term, keluar: keluarElement.val() };
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
				},
			});
		},
	};

	cariPekerja.init();

	/**
	 * Penempatan jabatan lifecycle
	 */
	const jabatan = {
		appName: "penempatan-jabatan",
		tableName: "table-jabatan",
		noind: SELECTED_NOIND,
		activeId: "",
		kodesie: "",
		seksi: "",
		refresh() {
			// will refresh table
			$.ajax({
				url: baseurl + "MasterPekerja/DataPekerjaKeluar/refjabatan",
				method: "GET",
				data: {
					noind: this.noind,
				},
				dataType: "json",
				success: (res) => {
					let html = res.map((item, i) => {
						return `
								<tr data-id="${i}">
									<td class="kodesie">${item.kodesie}</td>
									<td class="seksi">${item.seksi}</td>
									<td>${item.kd_jabatan}</td>
									<td>${item.jabatan}</td>
								</tr>
							`;
					});
					$(`#${this.tableName} tbody`).html(html);
					// init again
					this.init();
				},
				error(e) {
					alert(e);
				},
			});
		},
		delete() {
			// will remove row with id, and delete in tref jabatan
			// with activeId
			$.ajax({
				url: baseurl + "MasterPekerja/DataPekerjaKeluar/delete_jabatan",
				method: "POST",
				data: {
					noind: this.noind,
					kodesie: this.kodesie,
				},
				dataType: "json",
				success: (res) => {
					// console.log(`#${this.tableName} tr[data-id=${this.activeId}]`)
					// $(`#${this.tableName} tr[data-id=${this.activeId}]`).remove()
					this.refresh();
					modalJabatan.closeModal();
					Toast.fire({
						type: "success",
						title: "Sukses Menghapus Jabatan",
					});
				},
				error: (e) => {
					alert(e);
				},
			});
		},
		update() {
			// will remove row with id and insert new row
			// with activeId
			// this.delete()
			// this.add()

			// :TODO = make single function to update on backend
			let newkodesie = $("#modal-jabatan #select-seksi").val();
			let noind = this.noind;

			$.ajax({
				method: "POST",
				url: baseurl + "MasterPekerja/DataPekerjaKeluar/update_jabatan",
				dataType: "json",
				data: {
					noind,
					kodesie_from: this.kodesie,
					kodesie_to: newkodesie,
				},
				success: () => {
					this.refresh();
					modalJabatan.closeModal();
					Toast.fire({
						type: "success",
						title: "Sukses Memperbaharui Jabatan",
					});
				},
				error(e) {
					alert(e);
				},
			}).done(() => {
				modalJabatan.saveButtonDisable(false);
			});
		},
		add() {
			// will add new row
			// call refresh

			let kodesie = $("#modal-jabatan #select-seksi").val();
			let jabatan = $("#modal-jabatan #jabatan").val();
			let noind = this.noind;

			$.ajax({
				method: "POST",
				url: baseurl + "MasterPekerja/DataPekerjaKeluar/add_jabatan",
				dataType: "json",
				data: {
					noind,
					kodesie,
					// jabatan
				},
				success: () => {
					this.refresh();
					modalJabatan.closeModal();
					Toast.fire({
						type: "success",
						title: "Sukses Menambah Jabatan Baru",
					});
				},
				error(e) {
					alert(e);
				},
			}).done(() => {
				modalJabatan.saveButtonDisable(false);
			});
		},
		disableButton(param) {
			// Boolean
			$(`#${this.appName} #edit, #${this.appName} #delete`).prop("disabled", param);
		},
		removeActiveClass() {
			$(`#${this.tableName} > tbody > tr.activex`).removeClass("activex");
		},
		outsideclick() {
			const ignoreClickOnMeElement = document.getElementById(this.tableName);

			document.addEventListener("click", (event) => {
				const isClickInsideElement = ignoreClickOnMeElement.contains(event.target);
				if (!isClickInsideElement) {
					this.removeActiveClass();
					this.disableButton(true);
				}
			});
		},
		listener() {
			const vm = this;

			const tableRow = $(`#${this.tableName} > tbody > tr`);
			// const activeRow = $(`#${this.tableName} > tbody > tr.activex`)

			tableRow.click(function () {
				const id = $(this).data("id");
				const kodesie = $(this).find(".kodesie").text().trim();
				const seksi = $(this).find(".seksi").text().trim();

				vm.removeActiveClass();
				vm.disableButton(false);
				vm.activeId = id;
				vm.kodesie = kodesie;
				vm.seksi = seksi;

				console.log(vm.kodesie, vm.activeId);
				$(this).addClass("activex");
			});

			// add button
			$(`#${this.appName} #add`).click(() => {
				modalJabatan.setMode("save");
			});

			// edit button
			$(`#${this.appName} #edit`).click(() => {
				modalJabatan.initSelect2();
				modalJabatan.setMode("update");

				var newOption = $("<option selected='selected'></option>")
					.val(this.kodesie)
					.text(this.kodesie + " - " + this.seksi);
				let slc = $("#modal-jabatan #select-seksi");
				slc.html(newOption);
				slc.trigger("change");
			});
			// delete button
			$(`#${this.appName} #delete`).click(function () {
				swal
					.fire({
						title: "Apakah yakin untuk menghapus jabatan ?",
						text: "note: jabatan akan langsung terubah",
						type: "question",
						showCancelButton: true,
					})
					.then(({ value }) => {
						if (!value) return;
						vm.delete();
					});
			});
		},
		init() {
			this.listener();
			this.outsideclick();
		},
	};

	/**
	 * Modal jabatan
	 */
	const modalJabatan = {
		temp_seksi: [],
		setModalJabatan(detail) {
			$("#modal-jabatan #seksi").val(detail.seksi);
			$("#modal-jabatan #unit").val(detail.unit);
			$("#modal-jabatan #bidang").val(detail.bidang);
			$("#modal-jabatan #dept").val(detail.dept);
			$("#modal-jabatan #kd_jabatan").val(detail.kd_jabatan);
			$("#modal-jabatan #jabatan").val(detail.jabatan);
		},
		getDetailJabatan(kodesie) {
			$.ajax({
				type: "GET",
				url: baseurl + "MasterPekerja/DataPekerjaKeluar/data_seksi",
				dataType: "json",
				data: {
					noind: SELECTED_NOIND,
					params: kodesie,
				},
				success: (res) => {
					if (!res) return;
					this.setModalJabatan(res[0]);
				},
			});
		},
		clearModalJabatan() {
			$("#modal-jabatan #select-seksi").val("");
			$("#modal-jabatan #seksi").val("");
			$("#modal-jabatan #unit").val("");
			$("#modal-jabatan #bidang").val("");
			$("#modal-jabatan #dept").val("");
			$("#modal-jabatan #kd_jabatan").val("");
			$("#modal-jabatan #jabatan").val("");
		},
		closeModal() {
			$("#modal-jabatan").modal("hide");
		},
		setMode(mode) {
			// save/update
			$("#modal-jabatan #jbtn_save").data("mode", mode);
		},
		saveButtonDisable(prop) {
			//boolean
			$("#modal-jabatan #jbtn_save").prop("disabled", !!prop);
		},
		get getMode() {
			return $("#modal-jabatan #jbtn_save").data("mode");
		},
		listener() {
			const self = this;
			$("#select-seksi").change(function () {
				const val = $(this).val();
				console.log("select seksi change: ", val);
				const detail = self.temp_seksi.find((e) => e.kodesie === val);
				if (!detail) return self.getDetailJabatan(val);
				self.setModalJabatan(detail);
			});

			$("#penempatan-jabatan #add, #penempatan-jabatan #edit").click(() => {
				this.clearModalJabatan();
				this.initSelect2();
			});

			// add button
			$(`#modal-jabatan #jbtn_save`).click(() => {
				let kodesie = $("#modal-jabatan #select-seksi").val();
				if (!kodesie)
					return Toast.fire({
						type: "error",
						title: "Pilih kodesie terlebih dahulu",
					});

				console.log(this.getMode);
				if (this.getMode === "save") {
					jabatan.add();
					this.saveButtonDisable(true);
				} else if (this.getMode === "update") {
					jabatan.update();
					this.saveButtonDisable(true);
				} else {
					alert("Error: Mode is null");
				}
			});
		},
		initSelect2() {
			$("#modal-jabatan #select-seksi").select2({
				placeholder: "Seksi/Unit/Bidang/Dept",
				minimumInputLength: 2,
				ajax: {
					type: "GET",
					url: baseurl + "MasterPekerja/DataPekerjaKeluar/data_seksi",
					dataType: "json",
					data: (a) => ({
						noind: SELECTED_NOIND,
						params: a.term,
					}),
					processResults: (res) => {
						this.temp_seksi = res;
						return {
							results: res.map((a) => ({
								id: a.kodesie,
								text: a.kodesie + " - " + a.seksi_name,
							})),
						};
					},
				},
			});
		},
		init() {
			this.initSelect2();
			this.listener();
		},
	};

	/**
	 * Modal Pengaturan Lokasi kerja dan kantor asal
	 */
	const modalLokasiKerja = {
		kantor_asal: "",
		lokasi_kerja: "",
		update() {
			const kantor_asal = $("#modal-work-location #kantor_asal").val();
			const lokasi_kerja = $("#modal-work-location #lokasi_kerja").val();

			this.kantor_asal = $("#modal-work-location #kantor_asal").select2("data")[0].text.split(" - ")[1];
			this.lokasi_kerja = $("#modal-work-location #lokasi_kerja").select2("data")[0].text.split(" - ")[1];

			$.ajax({
				url: baseurl + "MasterPekerja/DataPekerjaKeluar/update_lokasi_kerja",
				method: "POST",
				dataType: "json",
				data: {
					noind: jabatan.noind,
					kantor_asal,
					lokasi_kerja,
				},
				beforeSend: () => this.enableButton(false),
				success: () => {
					this.setLokasiDisplay();
					this.modalClose();

					Toast.fire({
						title: "Sukses Memperbaharui Lokasi Kantor Asal & Lokasi Kerja",
						type: "success",
					});
				},
				error: () => {
					this.enableButton(true);
					alert("Error update lokasi kerja");
				},
			});
		},
		modalClose() {
			$("#modal-work-location").modal("hide");
		},
		setLokasiDisplay() {
			$("#kantor_asal_text").text(this.kantor_asal);
			$("#lokasi_kerja_text").text(this.lokasi_kerja);
		},
		enableButton(prop) {
			$("#modal-work-location #save").prop("disabled", !prop);
		},
		listener() {
			$("#modal-work-location .select2").select2();
			$("#btn-pengaturan").click(() => {
				$("#modal-work-location #agree").iCheck("uncheck");
			});

			// icheck only run after page load complete
			$(window).load(() => {
				$("#modal-work-location #agree").on("ifChanged", () => {
					let val = $("#modal-work-location #agree").is(":checked");
					console.log(val);
					this.enableButton(val); // if checked then button is enable
				});
			});

			$("#modal-work-location #save").click(this.update.bind(this));
		},
		init() {
			this.listener();
		},
	};

	/**
	 * Modal Anggota Keluarga
	 */
	const modalKeluarga = {
		state: {
			data: new Array(),
			noind: SELECTED_NOIND,
			get formValue() {
				let form = {};
				for (let key in modalKeluarga.element.form) {
					form[key] = modalKeluarga.element.form[key].val();
				}
				return form;
			},
			selectedKey: "",
			selectedRow: {},
			activeAction: null,
		},
		api: {
			read: baseurl + "MasterPekerja/DataPekerjaKeluar/api/keluarga", // get -> param noind
			add: baseurl + "MasterPekerja/DataPekerjaKeluar/api/keluarga/add", // post  -> param noind + data
			update: baseurl + "MasterPekerja/DataPekerjaKeluar/api/keluarga/update", // post -> noind + data
			delete: baseurl + "MasterPekerja/DataPekerjaKeluar/api/keluarga/delete", // post  -> noind + nokel
		},
		element: {
			count_childs: $("input[name=jumanak]"),
			count_siblings: $("input[name=jumsdr]"),
			form: {
				// this key is same with table in the database
				nokel: $("select#modal-keluarga_anggota"),
				nama: $("input#modal-keluarga_nama"),
				alamat: $("textarea#modal-keluarga_alamat"),
				tgllahir: $("input#modal-keluarga_tgllahir"),
				nik: $("input#modal-keluarga_nik"),
				ditanggung: $("select#modal-keluarga_tanggung"),
				stattanggunganpajak: $("select#modal-keluarga_tanggungpajak"),
				status: $("select#modal-keluarga_statnikah"),
				statusbpjs: $("select#modal-keluarga_statbpjs"),
				keterangan: $("input#modal-keluarga_keterangan"),
			},
			button: {
				add: $("#modal-keluarga button#add"),
				add_submit: $("#modal-keluarga button#add_submit"),
				edit: $("#modal-keluarga button#edit"),
				edit_submit: $("#modal-keluarga button#update_submit"),
				cancel_button: $("#modal-keluarga button#cancel"),
				delete: $("#modal-keluarga button#delete"),
				print: $("#modal-keluarga button#print"),
				refresh: $("#modal-keluarga button#refresh"),
			},
			table: $("#modal-keluarga table#table-anggota-keluarga"),
			trigger: $("#toggle-modal-keluarga"),
		},
		handleFormDisable(prop = true /** Boolean */) {
			Object.values(this.element.form).forEach((JqueryElement) => {
				JqueryElement.prop("disabled", prop);
			});
		},
		handleFormReset() {
			Object.values(this.element.form).forEach((JqueryElement) => {
				JqueryElement.val("").trigger("change");
			});
		},
		handleFormUpdate() {
			const data = this.state.selectedRow;
			const form = this.element.form;

			if (!data) return;

			form.nokel.val(data.nokel).trigger("change");
			form.nama.val(data.nama);
			form.alamat.val(data.alamat);
			form.nik.val(data.nik);
			form.tgllahir.datepicker("setDate", moment(data.tgllahir).format("DD-MM-YYYY"));
			form.ditanggung.val(data.ditanggung).trigger("change");
			form.stattanggunganpajak.val(data.stattanggunganpajak).trigger("change");
			form.status.val(data.status).trigger("change");
			form.statusbpjs.val(data.statusbpjs).trigger("change");
			form.keterangan.val(data.keterangan);
		},
		handleEdit() {
			// toggle view add/hide
			this.state.activeAction = "edit";
			this.toggleWrapperButton("edit");
			this.handleFormDisable(false);
		},
		handleAdd() {
			// toggle view add/hide
			this.state.activeAction = "add";
			this.enableTable(false);
			this.handleFormReset();
			this.handleFormDisable(false);
			this.toggleWrapperButton("add");
			this.handleUnselected();
		},
		handleCancelButton() {
			// if (this.state.activeAction == 'add') {
			// }
			this.state.activeAction = null;
			this.enableTable(true);
			this.handleFormReset();
			this.handleFormUpdate();
			this.toggleWrapperButton("main");
			this.handleFormDisable(true);
		},
		handleAddSubmit() {
			const existMember = this.state.data.find((item) => item.nokel == this.state.formValue.nokel);
			if (existMember)
				return Swal.fire({
					title: "Jenis Anggota Keluarga Sudah Ada",
					type: "error",
				});

			const self = this;
			// ajax request to api.add
			// reset form
			$.ajax({
				method: "POST",
				url: this.api.add,
				data: {
					noind: self.state.noind,
					data: self.state.formValue,
				},
				beforeSend() {
					self.element.button.add_submit.prop("disabled", true);
				},
				success(data) {
					if (data.success) {
						Toast.fire({
							title: `Berhasil Menambahkan Anggota Keluarga Baru`,
							type: "success",
						});
						self.handleFormReset();
						self.handleFormDisable(true);
						self.fetchTable();
						self.enableTable(true);
						self.toggleWrapperButton("main");
					} else {
						Toast.fire({
							title: `Gagal Menambahkan Anggota Keluarga Baru`,
							type: "error",
						});
					}
				},
				error(e) {
					Toast.fire({
						title: e.message,
						type: "error",
					});
				},
				complete() {
					self.element.button.add_submit.prop("disabled", false);
				},
			});
		},
		handleEditSubmit() {
			const existMember = this.state.data.filter((item) => item.nokel != this.state.selectedKey).find((item) => item.nokel == this.state.formValue.nokel);
			if (existMember)
				return Swal.fire({
					title: "Jenis Anggota Keluarga Sudah Ada",
					type: "error",
				});
			// ajax request to api.update
			// just update, dont change other
			const self = this;
			$.ajax({
				method: "POST",
				url: this.api.update,
				data: {
					noind: self.state.noind,
					nokel: self.state.selectedRow.nokel,
					data: self.state.formValue,
				},
				beforeSend() {
					self.element.button.edit_submit.prop("disabled", true);
				},
				success(data) {
					if (data.success) {
						self.handleFormReset();
						self.handleFormDisable(true);
						self.fetchTable();
						self.enableTable(true);
						self.toggleWrapperButton("main");
						// then update varaible state.data with new data
						Toast.fire({
							title: `Berhasil Mengupdate Anggota Keluarga (${self.state.selectedRow.nokel})`,
							type: "success",
						});
						self.state.selectedRow = self.state.formValue;
					} else {
						Toast.fire({
							title: `Gagal Mengupdate Anggota Keluarga (${self.state.selectedRow.nokel})`,
							type: "false",
						});
					}
				},
				error(e) {
					Toast.fire({
						tiytle: e.message,
						type: "error",
					});
				},
				complete() {
					self.element.button.edit_submit.prop("disabled", false);
				},
			});
		},
		handleDelete() {
			// question
			// ajax request to api.delete
			// reset form
			// fetch table
			const self = this;
			console.log(self.state.selectedRow);
			Swal.fire({
				title: "Konfirmasi hapus",
				text: "",
				type: "question",
				showCancelButton: true,
			}).then(({ value }) => {
				if (!value) return;
				$.ajax({
					method: "POST",
					url: this.api.delete,
					data: {
						noind: self.state.noind,
						nokel: self.state.selectedRow.nokel,
					},
					beforeSend() {
						self.element.button.delete.prop("disabled", true);
					},
					success(data) {
						if (data.success) {
							self.handleFormReset();
							self.fetchTable();

							Toast.fire({
								title: `Anggota keluarga (${self.state.selectedRow.nokel}) berhasil dihapus`,
								type: "success",
							});
						} else {
							self.element.button.delete.prop("disabled", false);
							Toast.fire({
								title: `Gagal Menghapus Anggota Keluarga (${self.state.selectedRow.nokel})`,
								type: "error",
							});
						}
					},
					error(e) {
						console.log(e);
						self.element.button.delete.prop("disabled", false);
						Toast.fire({
							tiytle: e.message || e || "Terjadi kesalahan ",
							type: "error",
						});
					},
					// complete() {}
				});
			});
		},
		checkExistFamily() {
			// Still in progress may be not be used
		},
		toggleWrapperButton(prop = "main") {
			// toggle button view
			const mainWrapper = $("#modal-keluarga #main-wrapper");
			const addWrapper = $("#modal-keluarga #add-wrapper");
			const editWrapper = $("#modal-keluarga #edit-wrapper");

			switch (prop) {
				case "add":
					mainWrapper.addClass("hidden");
					addWrapper.removeClass("hidden");
					break;
				case "edit":
					mainWrapper.addClass("hidden");
					editWrapper.removeClass("hidden");
					break;
				default:
					mainWrapper.removeClass("hidden");
					addWrapper.addClass("hidden");
					editWrapper.addClass("hidden");
			}
		},
		handleUnselected() {
			this.element.button.edit.prop("disabled", true);
			this.element.button.delete.prop("disabled", true);
			this.element.table.find("tbody tr td.bg-primary").removeClass();
			this.handleFormReset();
			this.state.selectedRow = "";
			this.state.selectedKey = "";
			this.state.activeAction = null;
		},
		handleRowOnClick() {
			// ALGORITHM
			// when row on click
			// when on click, set state.selectedRows
			// updateForm

			const self = this;
			this.element.table.find("tbody > tr").on("click", function (e) {
				// get key selected
				const selected = $(this).find("[data-nokel]").data("nokel");
				if (selected == self.state.selectedKey) return;
				// remove bg selected row
				self.element.table.find("tbody > tr > td.bg-primary").removeClass("bg-primary");

				$(this).find("td").addClass("bg-primary");
				// generate value
				// set selected state to obj
				self.state.selectedRow = self.state.data.find((e) => e.nokel == selected);
				// set selected key state to string
				self.state.selectedKey = selected;
				// update value to form
				self.handleFormUpdate();
				// enable edit/delete button
				self.element.button.edit.prop("disabled", false);
				self.element.button.delete.prop("disabled", false);
				console.log(self.state.selectedRow);
			});
		},
		enableTable(prop = true) {
			this.element.table.css("pointer-events", prop ? "" : "none");
		},
		fetchTable() {
			// clear table
			this.element.table.find("tbody").html('<tr><td class="text-center" colspan="7"><h3>Memuat data ...</h3></td></tr>');
			// ajax request then draw data into table /GET
			fetch(this.api.read + "?noind=" + this.state.noind)
				.then((e) => e.json())
				.then(({ data, success, count }) => {
					// draw to tbody
					let htmlTable = data
						.map(
							(item) => `
							<tr>
								<td>${item.noind}</td>
								<td data-nokel="${item.nokel}">${item.nokel}</td>
								<td>${item.jenisanggota}</td>
								<td>${item.nama}</td>
								<td>${item.alamat}</td>
								<td>${moment(item.tgllahir).format("DD-MM-YYYY")}</td>
								<td>${item.nik}</td>
							</tr>
						`
						)
						.join("");

					this.state.data = data;
					// fill & set the table
					this.element.table.find("tbody").html(htmlTable);
					this.element.table.dataTable({
						retrieve: true, // :Prevent datatable to reinitialize
						dom: "Bfrtip",
						buttons: new Array(
							{
								extend: "excel",
								title: `Keluarga - ${this.state.noind}`,
								text: "Excel",
								className: "btn btn-success text-white datatable-excel",
							},
							{
								extend: "pdfHtml5",
								title: `Keluarga - ${this.state.noind}`,
								text: "PDF",
								className: "btn btn-danger text-white datatable-pdf",
								orientation: "potrait",
								pageSize: "A4",
								download: "open",
							}
						),
						initComplete() {
							$(".datatable-excel").removeClass("btn-default").html('<i class="fa fa-file-excel-o"></i><span> Excel</span>');
							$(".datatable-pdf").removeClass("btn-default").html('<i class="fa fa-file-pdf-o"></i><span> PDF</span>');
						},
					});

					// update sibling & children count
					this.element.count_childs.val(count.childs);
					this.element.count_siblings.val(count.siblings);
					console.log(count);
					this.handleUnselected();
					this.handleRowOnClick();
				})
				.catch((e) => {
					this.element.table.find("tbody").html('<tr><td class="text-center" colspan="7"><h3 class="text-red">Terjadi kesalahan saat memuat data :(</h3></td></tr>');
					console.error(e, "fetchTable function");
				});
		},
		tableOutsideClick() {
			const ignoreClickOnElement = document.getElementById("table-anggota-keluarga");

			$(".modal#modal-keluarga").on("click", (event) => {
				event.stopPropagation();

				if ($(event.target).is("button")) return;
				const isClickInsideElement = $.contains(ignoreClickOnElement, event.target);
				if (!isClickInsideElement && this.state.activeAction == null) {
					console.log("where my mom :''");
					this.handleUnselected();
				}
			});
		},
		listener() {
			// about the listener
			this.element.trigger.click(this.modalInit.bind(this));
			// this.element.table.dataTable()
			this.element.table.css("font-size", "12px");
			this.element.button.add.click(this.handleAdd.bind(this));
			this.element.button.add_submit.click(this.handleAddSubmit.bind(this));
			this.element.button.edit.click(this.handleEdit.bind(this));
			this.element.button.edit_submit.click(this.handleEditSubmit.bind(this));
			this.element.button.delete.click(this.handleDelete.bind(this));
			this.element.button.cancel_button.click(this.handleCancelButton.bind(this));
			this.element.button.refresh.click((e) => (this.fetchTable(), this.handleFormReset()));
		},
		modalInit() {
			// disable this element
			this.element.button.edit.prop("disabled", true);
			this.element.button.delete.prop("disabled", true);
			this.toggleWrapperButton("main");
			this.handleFormReset();
			this.handleFormDisable(true);
			this.fetchTable();
		},
		init() {
			// initialize all
			this.listener();
			// this.tableOutsideClick();
			this.handleRowOnClick();
		},
	};

	/** Select Daerah */
	const wilayah = {
		provinsiEl: $("#select-provinsi"),
		kabupatenEl: $("#select-kabupaten"),
		kecamatanEl: $("#select-kecamatan"),
		desaEl: $("#select-desa"),
		getValue(query) {
			return this[query].val() || null;
		},
		init() {
			$("#select-provinsi").select2({
				allowClear: true,
				placeholder: "Provinsi",
				ajax: {
					url: baseurl + "MasterPekerja/DataPekerjaKeluar/provinsiPekerja",
					dataType: "json",
					type: "GET",
					data: function (params) {
						return {
							term: params.term,
						};
					},
					processResults: function (data) {
						return {
							results: $.map(data, function (obj) {
								return {
									id: obj.id_prov,
									text: obj.nama,
								};
							}),
						};
					},
				},
			});

			$("#select-kabupaten").select2({
				minimumInputLength: 0,
				allowClear: true,
				placeholder: "Kabupaten",
				ajax: {
					url: baseurl + "MasterPekerja/DataPekerjaKeluar/kabupatenPekerja",
					dataType: "json",
					type: "GET",
					data: (params) => {
						return {
							term: params.term,
							prov: this.provinsiEl.val(),
						};
					},
					processResults: function (data) {
						return {
							results: $.map(data, function (ok) {
								return {
									id: ok.id_kab,
									text: ok.nama,
								};
							}),
						};
					},
				},
			});

			$("#select-kecamatan").select2({
				minimumInputLength: 0,
				allowClear: true,
				placeholder: "Kecamatan",
				ajax: {
					url: baseurl + "MasterPekerja/DataPekerjaKeluar/kecamatanPekerja",
					dataType: "json",
					type: "GET",
					data: (params) => {
						return {
							term: params.term,
							kab: this.kabupatenEl.val(),
						};
					},
					processResults: function (data) {
						return {
							results: $.map(data, function (ok) {
								return {
									id: ok.id_kec,
									text: ok.nama,
								};
							}),
						};
					},
				},
			});

			$("#select-desa").select2({
				minimumInputLength: 0,
				allowClear: true,
				placeholder: "Desa/Kelurahan",
				ajax: {
					url: baseurl + "MasterPekerja/DataPekerjaKeluar/desaPekerja",
					dataType: "json",
					type: "GET",
					data: (params) => {
						return {
							term: params.term,
							kec: this.kecamatanEl.val(),
						};
					},
					processResults: function (data) {
						return {
							results: $.map(data, function (ok) {
								return {
									id: ok.id_kel,
									text: ok.nama,
								};
							}),
						};
					},
				},
			});
		},
	};

	/**
	 * Modal Perpanjangan Orientasi
	 */
	const modalPerpanjangOrientasi = {
		state: {
			data: {},
			selected: {},
		},
		api: {
			getMemo: baseurl + "MasterPekerja/DataPekerjaKeluar/getMemoPerpanjangOrientasi",
			pdfMemo: baseurl + "MasterPekerja/DataPekerjaKeluar/generatePDFMemoOrientasi",
		},
		element: {
			toggle: $("#toggle-perpanjangan-orientasi"),
			modal: $("#modal-perpanjangan-orientasi"),
			table: $("#modal-perpanjangan-orientasi table"),
			form: {
				no_surat: $("#modal-perpanjangan-orientasi #no_surat"),
				code: $("#modal-perpanjangan-orientasi #code"),
				archives: $("#modal-perpanjangan-orientasi #archives"),
				assingment: $("#modal-perpanjangan-orientasi #assignment_atasan"),
				hubker: $("#modal-perpanjangan-orientasi #assignment_hubker"),
			},
			button: $("#modal-perpanjangan-orientasi button#print"),
		},
		handleRowOnClick() {
			const self = this;

			this.element.table.find("tbody tr[clicky]").on("click", function () {
				// ui
				self.element.table.find("tbody tr.bg-primary").removeClass("bg-primary");
				$(this).addClass("bg-primary");
				self.element.button.prop("disabled", false);

				// logic
				const order = $(this).data("order");
				self.state.selected = self.state.data.find((item) => item.ke == order);
				console.log(self.state.selected);
			});
		},
		generateUrl() {
			const data = {
				noind: SELECTED_NOIND,
				ke: this.state.selected.ke,
				no_surat: this.element.form.no_surat.val(),
				kode_arsip: this.element.form.code.val() + "/" + this.element.form.archives.val(),
				atasan: this.element.form.assingment.val(),
				hubker: this.element.form.hubker.val(),
			};
			console.log(data);
			// btoa -> encrypt string to base64
			const encrypt = btoa(JSON.stringify(data));
			const param = {
				key: encrypt,
			};

			const rawQuery = $.param(param);

			return this.api.pdfMemo + "?" + rawQuery;
		},
		setTableContent(data) {
			let html = data
				.map(
					(item) => `
        <tr clicky data-order="${item.ke}">
          <td>${item.ke}</td>
          <td>${moment(item.mulai).format("YYYY-MM-DD")}</td>
          <td>${moment(item.akhir).format("YYYY-MM-DD")}</td>
        </tr>
      `
				)
				.join("");

			let empty = `
          <tr>
            <td colspan="3" class="text-center" style="font-color: #e8e8e8;">Tidak ada memo perpanjangan orientasi</td>
          </tr>
      `;
			this.element.table.find("tbody").html(html || empty);
		},
		fetchTable() {
			this.handleUnselected();
			fetch(this.api.getMemo + "?noind=" + SELECTED_NOIND)
				.then((e) => e.json())
				.then((res) => {
					if (res.success) {
						this.state.data = res.data;
						this.setTableContent(res.data);
						this.handleRowOnClick();
					} else {
						alert("Failed to fetch data");
					}
				});
		},
		handleUnselected() {
			this.element.table.find("tbody tr.bg-primary").removeClass("bg-primary");
			this.element.button.prop("disabled", true);
			this.state.selected = {};
		},
		tableOutsideClick() {
			// TODO: THIS IS NOT WORK
			const ignoreClickOnElement = document.querySelector("#modal-perpanjangan-orientasi table");

			this.element.modal.on("click", (event) => {
				console.log(event.target);
				if ($(event.target).is("button")) return;
				const isClickInsideElement = $.contains(ignoreClickOnElement, event.target);
				if (!isClickInsideElement) {
					this.handleUnselected();
				}
			});
		},
		listener() {
			this.element.toggle.click(() => this.fetchTable());
			this.element.button.click(() => {
				window.open(this.generateUrl(), "_blank");
			});
		},
		init() {
			// this.fetchTable();
			// this.tableOutsideClick();
			this.listener();
		},
	};

	/**
	 * Modal modal-ambil-data
	 */
	const modalAmbilNoind = {
		state: {
			selectedNoind: "",
		},
		api: {
			ambilNoind: baseurl + "MasterPekerja/DataPekerjaKeluar/replaceDataPekerja", // POST
		},
		element: {
			modal: $("#modal-ambil-data"),
			button: {
				init: $("#app button#ambil-data"),
				submit: $("#modal-ambil-data button#submit"),
			},
			select: {
				active: $("#modal-ambil-data select.select2-active-noind"),
			},
		},
		listener() {
			const self = this;
			this.element.button.init.click(this.handleOnOpen.bind(this));
			this.element.button.submit.click(this.handleOnSubmit.bind(this));
			this.element.select.active
				.select2({
					minimumInputLength: 1,
					allowClear: true,
					ajax: {
						url: baseurl + "MasterPekerja/DataPekerjaKeluar/data_pekerja",
						dataType: "json",
						type: "GET",
						data: (query) => ({ term: query.term }),
						processResults: function (data) {
							return {
								results: data.map((item) => {
									return {
										id: item.noind,
										text: item.noind + " - " + item.nama,
									};
								}),
							};
						},
					},
				})
				.on("change", function () {
					const value = $(this).val();
					self.element.button.submit.prop("disabled", !value);
					self.state.selectedNoind = value;
				});
		},
		handleOnOpen() {
			this.element.select.active.val("").trigger("change");
			this.element.button.submit.prop("disabled", true);
		},
		handleApiRequest(from, to) {
			$.ajax({
				method: "POST",
				url: this.api.ambilNoind,
				dataType: "json",
				data: {
					noind: from,
					noind_dest: to,
				},
				success(res) {
					// log
					if (res.success) {
						Swal.fire({
							title: "Ambil Data Nomor Induk Lama Berhasil Dilakukan",
							text: "Silahkan refresh browser / klik tombol dibawah",
							type: "success",
						}).then((e) => window.location.reload());
					}
				},
				error(e) {
					Swal.fire({
						title: "Terjadi Kesalahan saat mengambil data nomor induk " + noind_dest,
						text: "Error api request",
						type: "error",
					});
				},
			});
		},
		handleOnSubmit() {
			Swal.mixin({
				showCancelButton: true,
			})
				.queue([
					{
						title: "Yakin untuk mengubah data pekerja sesuai dengan noind yang di ambil ?",
						type: "question",
					},
					{
						title: 'Masukkan kata "saya yakin"',
						input: "text",
						inputAutoTrim: true,
						inputPlaceholder: "Ketik disini",
						inputAttributes: {
							autocomplete: false,
						},
						type: "question",
						preConfirm: (inputVal) => {
							const keyword = "saya yakin";
							return keyword === inputVal;
						},
					},
				])
				.then((data) => {
					if (!data) return;
					console.log(data);
					this.element.modal.modal("toggle");
					toggle_loading();
					this.handleApiRequest(SELECTED_NOIND, this.state.selectedNoind);
				});
		},
		init() {
			this.listener();
		},
	};

	// initialize
	modalLokasiKerja.init();
	modalJabatan.init();
	jabatan.init();
	modalKeluarga.init();
	modalPerpanjangOrientasi.init();
	modalAmbilNoind.init();
	$(window).load(() => {
		wilayah.init();
	});

	// ---------------------------------------------------------------------
	// | REFACTOR THIS SPAGHETII CODE !!!!!!!!!!!
	// | REFACTOR
	// ---------------------------------------------------------------------
	// custom script

	/**
	 * VARIABLE DATA
	 * variabel yg dikirim ke server melalui ajax
	 */
	let temp_changed = {};

	// on changed all field
	$("#app")
		.find("input, textarea, select")
		.on("change", function () {
			handle_field_change(this);
		});

	$("#app")
		.find("input[type=checkbox]")
		.on("ifToggled", (event) => {
			let { target } = event;
			let { name } = target;
			let checked = $(target).is(":checked");

			temp_changed[name] = checked;
			temp_changed["is_changed"] = true;
			console.log(temp_changed);
		});

	$(window).load(() => {
		$("#app")
			.find("input[type=radio]")
			.on("ifClicked", function () {
				handle_field_change(this);
			});
	});

	function handle_field_change(e) {
		let element = {
			name: $(e).attr("name"),
			val: $(e).val(),
		};
		temp_changed[element.name] = element.val;
		temp_changed["is_changed"] = true;
		console.log(temp_changed);
	}
	// end on changed all field

	// end custom script

	function show_notif_update() {
		if ($("div.submit-container > span.notif").length) return;
		$("div.submit-container").append('<span class="notif text-red">Tidak ada data yang berubah (tidak perlu save)</span>');
		setTimeout(() => $("div.submit-container > span.notif").remove(), 2500);
	}

	/**
	 * Update Button On CLick
	 * Handle Update Data with API Request
	 * Show alert to confirm with condition
	 */
	$("button#submit_update").click(function () {
		const update_data = () => {
			Swal.fire({
				title: "Apakah anda yakin untuk mengubah data ?",
				text: "",
				type: "question",
				showCancelButton: true,
			}).then((data) => {
				if (!data.value) return;

				$.ajax({
					url: baseurl + "MasterPekerja/DataPekerjaKeluar/update",
					method: "POST",
					data: temp_changed,
					dataType: "json",
					beforeSend: () => {
						$(this).prop("disabled", true);
						toggle_loading();
					},
					success(res) {
						let title;
						if (res.success) {
							/**
							 * set url query param to actual
							 * set select aktif/keluar
							 */
							if (temp_changed.hasOwnProperty("pekerja_keluar")) {
								const keluar_val = temp_changed.pekerja_keluar == true ? "t" : "f";
								$(`input:radio[name=keluar][value=${keluar_val}]`).iCheck("check");
								const query = {
									keluar: keluar_val,
									noind: SELECTED_NOIND,
								};
								// update_param_url(query);
							}

							title = "Sukses Memperbaharui Data Pekerja";
							TGL_DIANGKAT = temp_changed["tgl_diangkat"];
							temp_changed = {};
						} else {
							title = "Gagal Memperbaharui Data Pekerja";
						}

						Toast.fire({
							title,
							type: res.success ? "success" : "error",
						});
					},
					error: (e) => {
						$(this).prop("disabled", false);
						toggle_loading();
						Toast.fire({
							title: "Gagal memperbaharui data pekerja",
							type: "error",
						});
					},
				}).done(() => {
					toggle_loading();
					$(this).prop("disabled", false);
				});
			});
		};

		if (!temp_changed.is_changed) return show_notif_update();

		temp_changed["noind"] = SELECTED_NOIND;
		console.log(temp_changed);

		let queueAlert = new Array();

		/**
		 * REFACTORING ALERT !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
		 */
		if (temp_changed.hasOwnProperty("diangkat")) {
			const moment_from = TGL_DIANGKAT; // YYYY-MM-DD
			const moment_to = moment(temp_changed["diangkat"], ["DD-MM-YYYY"]).format("YYYY-MM-DD"); // YYYY-MM-DD

			const from = moment(moment_from).format("LL");
			const to = moment(moment_to).format("LL");
			// e.g: 17 Agustus 2020

			if (moment_to > moment_from) {
				temp_changed["new_memo_perpanjangan_orientasi"] = true;
				temp_changed["tgl_diangkat_before"] = TGL_DIANGKAT;
				queueAlert.push({
					title: `Apakah Anda akan memperpanjang orientasi pekerja ${SELECTED_NOIND} dari ${from} menjadi ${to}?`,
					text: "",
					type: "question",
				});
			}
		} else {
			temp_changed["new_memo_perpanjangan_orientasi"] = false;
		}

		if (temp_changed.hasOwnProperty("pekerja_keluar") && temp_changed.pekerja_keluar === true) {
			const tgl = $("#app input[name=tglkeluar]").val();
			const today = moment().format("YYYY-MM-DD");
			const tglkeluar = moment(tgl, ["DD-MM-YYYY"]).format("YYYY-MM-DD");
			const tglhapus = moment(tglkeluar).add(190, "day").format("YYYY-MM-DD");
			const tglhapusgaji = moment(tglkeluar).add(740, "day").format("YYYY-MM-DD");

			if (tglkeluar > today) return Swal.fire("Tanggal Keluar Lebih dari tanggal sekarang!! Silakan Cek Kembali!!!", "", "info");

			queueAlert.push({
				title: `Yakin pekerja dengan ${SELECTED_NOIND} akan di set keluar !!!`,
				text: "",
				type: "question",
			});

			if (tglhapus < today) {
				queueAlert.push({
					title: `(HATI - HATI!! Jika Tgl Keluar pekerja lebih dari 6 bln yg lalu, Shg Data Pekerja akan terhapus !!!)`,
					text: `Apakah Yakin Pekerja dengan noind ${SELECTED_NOIND} akan di set keluar ???`,
					type: "question",
				});
			}
		}

		Swal.mixin({
			confirmButtonText: "Next &rarr;",
			showCancelButton: true,
		})
			.queue(queueAlert)
			.then(({ value }) => {
				if (value) update_data();
			});
	});

	// $('#select-kd_jbt_dl').select2({
	// 	dropdownCssClass: 'bigdrop'
	// })
}); // end document on ready
