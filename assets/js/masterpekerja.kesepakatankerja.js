/**
 * ------------------------
 * | DOCUMENTATION
 * ------------------------
 * this project is using vue js 2
 * written by /DK/
 * write use strict
 * es6 style
 *
 * @depedencies
 */

"use strict";

// set global locale of moment JS to indonesian
moment.locale("id");

const API = {
	surat: baseurl + "MasterPekerja/KesepakatanKerja/api/kesepakatan_kerja", // get: month, year
	updateSurat: baseurl + "MasterPekerja/KesepakatanKerja/api/update_kesepakatan_kerja", // noind, data: Array
	upah: baseurl + "MasterPekerja/KesepakatanKerja/api/get_upah", // null param, return array
	set_upah: baseurl + "MasterPekerja/KesepakatanKerja/api/set_salary", // set upah return string of message
	perjanjian_kerja: baseurl + "MasterPekerja/KesepakatanKerja/api/get_item_perjanjian_kerja",
	update_perjanjian_kerja: baseurl + "MasterPekerja/KesepakatanKerja/api/update_item_perjanjian_kerja",
};

/**
 * Alert UI
 * Swal mixin
 */

const Toast = Swal.mixin({
	toast: true,
	position: "top-right",
	timer: 3000,
	showConfirmButton: false,
});

/**
 * Jquery
 */
$(() => {
	$("input.date").datepicker({
		format: "yyyy-mm-dd",
	});
	$("input.date").change(function () {
		const stateName = $(this).data("model");
		const value = $(this).val();
		form.$data.selectedData[stateName] = value;
	});
	$("#modal-print select#signer").select2({
		allowClear: true,
		ajax: {
			url: baseurl + "MasterPekerja/KesepakatanKerja/api/get_signer",
			dataType: "json",
			data({ term }) {
				return {
					keyword: term,
				};
			},
			type: "GET",
			processResults: function (response) {
				const { data } = response;
				return {
					results: $.map(data, function ({ noind, nama }) {
						return {
							id: noind,
							text: noind + " - " + nama,
						};
					}),
				};
			},
		},
	});

	$("#modal-print select#signer").change(function () {
		const val = $(this).val();
		console.log(val);
		modal.$data.signer = val;
	});
});

// helper
// stolen from https://stackoverflow.com/questions/995168/textarea-to-resize-based-on-content-length
// function textAreaAdjust(element) {
// 	console.log("hello world");
// 	element.style.height = "1px";
// 	element.style.height = 25 + element.scrollHeight + "px";
// }

String.prototype.lines = function () {
	if (!this) return null;
	return this.split(/\r*\n/);
};

String.prototype.lineCount = function () {
	if (!this) return null;
	return this.lines().length;
};

/**
 * Index form application
 */
const form = new Vue({
	name: "Form",
	el: "section#app",
	data() {
		return {
			today: moment().format("YYYY-MM-DD"),
			selectedMonth: new Date().getMonth() + 1,
			selectedYear: new Date().getFullYear(),
			// debugging
			// selectedMonth: "7",
			// selectedYear: "2019",
			// end debugging
			tableLoading: false,
			table: [],
			checkbox: {
				tglevaluasi: false,
				tglpemanggilan: false,
				tgltandatangan: false,
			},
			selectedNoind: [],
			selectedData: {
				noind: "",
				nama: "",
				seksi: "",
				dept: "",
				tgldiangkat: "",
				tglevaluasi: "",
				tglpemanggilan: "",
				tgltandatangan: "",
				keterangan: "",
				user: "",
			},
			activeRow: null,
			queryParam: "",
		};
	},
	computed: {
		// checkedBoxEvaluasi() {
		// 	return !!this.$data.selectedData.tglevaluasi;
		// },
		formData() {
			let data = Object.assign({}, this.$data.selectedData);
			const today = this.$data.today;

			data.tglevaluasi = this.$data.checkbox.tglevaluasi ? data.tglevaluasi || today : "";
			data.tglpemanggilan = this.$data.checkbox.tglpemanggilan ? data.tglpemanggilan || today : "";
			data.tgltandatangan = this.$data.checkbox.tgltandatangan ? data.tgltandatangan || today : "";

			return data;
		},
	},
	watch: {
		selectedData: function (newval, oldval) {
			// set checkbox value Boolean
			// if tgl value is not empty/null then set true
			this.$data.checkbox.tglevaluasi = !!newval.tglevaluasi;
			this.$data.checkbox.tglpemanggilan = !!newval.tglpemanggilan;
			this.$data.checkbox.tgltandatangan = !!newval.tgltandatangan;
		},
		selectedNoind(newval) {
			console.log("selected noind is : " + newval.toString());
			if (newval.length == 1) {
				let noind = newval[0];
				let findData = this.$data.table.find((item) => item.noind == noind);
				this.$data.selectedData = Object.assign({}, findData);
			}
		},
	},
	methods: {
		printOpen() {
			modal.fetchPerjanjian(this.$data.selectedNoind[0]);
		},
		loadTable() {
			this.$data.selectedData = {
				noind: "",
				nama: "",
				seksi: "",
				dept: "",
				tgldiangkat: "",
				tglevaluasi: "",
				tglpemanggilan: "",
				tgltandatangan: "",
				keterangan: "",
				user: "",
			};

			this.$data.activeRow = null;
			this.$data.selectedNoind = [];
			this.$data.tableLoading = true;
			const { selectedMonth, selectedYear, queryParam } = this.$data;
			fetch(API.surat + `?month=${selectedMonth}&year=${selectedYear}&keyword=${queryParam}`)
				.then((e) => e.json())
				.then((data) => {
					this.$data.table = [].concat(data);
					this.$data.tableLoading = false;
				})
				.catch((error) => {
					console.log(error);
				});
		},
		filterTable() {
			// find with fetch to server
			this.loadTable();
		},
		updateTableItem() {
			const vm = this;
			// if nothing changed
			// Salah satu data harus terisi jika akan menyimpan
			// ask confirmation
			const selectedIndex = vm.$data.table.findIndex((item) => item.noind == this.$data.selectedNoind[0]);
			const selectedData = Object.assign({}, this.formData);
			// change user to this session user
			// this vaalue from V_INDEX
			selectedData.user = SESSION_USER;
			console.log(selectedIndex, selectedData);
			Swal.fire({
				title: "Apakah anda yakin menyimpan keterangan ini ?",
				type: "question",
				showCancelButton: true,
			}).then(({ value }) => {
				if (value) {
					// do the ajax update
					$.ajax({
						url: API.updateSurat,
						method: "POST",
						data: selectedData,
						success(res) {
							/**
							 * Reactive update index of array
							 */
							vm.$set(vm.$data.table, selectedIndex, selectedData);
							// unfocus / blur save button
							vm.$refs.saveButton.blur();

							// show alert
							Toast.fire({
								title: "Sukses mengupdate data",
								type: "success",
							});
							console.log("should updated");
						},
						error() {
							alert("Gagal mengupdate data");
						},
					});
					// set view with selected current
				}
			});
		},
		rowOnClick(rowIndex, noind = false) {
			// set selectedNoind data
			if (this.$data.selectedNoind.includes(noind)) {
				this.$data.selectedNoind = this.$data.selectedNoind.filter((item) => item != noind);
			} else {
				this.$data.selectedNoind = this.$data.selectedNoind.concat(noind);
			}

			console.log(this.$data.selectedNoind.length);
			// this is to set data from
			// console.log(this.$data.selectedNoind.length);
			if (this.$data.selectedNoind.length >= 0) {
				this.$data.selectedData = Object.assign({}, {});
			} else {
				// return console.log(rowIndex);
				this.$data.activeRow = rowIndex;
				this.$data.selectedData = Object.assign({}, this.$data.table[rowIndex]);
			}
			// this.$data.selectedNoind = [...new Set([...this.$data.selectedNoind, this.$data.selectedData.noind])];
		},
		exportToExcel() {
			$("table#table-kesepakatan-kerja").table2excel({
				// exclude: "",
				name: "Sheet1",
				filename: `KesepakatanKerja-${this.$data.selectedYear}-${moment(this.$data.selectedMonth, ["MM"]).format("MMMM")}-${moment().format("YYYYMMDD")}.xls`, // do include extension
				preserveColors: false, // set to true if you want background colors and font colors preserved
			});
		},
	},
	created() {
		this.loadTable();
	},
	mounted() {},
});

/**
 * Modal Cetak form application
 */
const modal = new Vue({
	name: "Modal",
	el: "#modal-print",
	data() {
		return {
			selectedLoker: "",
			upahs: [],
			perjanjian: [], // real data
			v_perjanjian: [], // virtual
			signer: "",
			// get upahValue() {
			// 	const findUpah = this.upahs.find((item) => item.align == this.selectedLoker);
			// 	return findUpah && findUpah.isi;
			// },
			newtab: false,
			upahValue: "",
			// alert
			alertOpen: false,
			// button ui
			download_is_processing: false,
			// this is for table
			activeTable: "parent", // enum(parent, child)
			activePasal: null,
			tableChildSelected: [],
			tableChildTemporaryCheck: [],
		};
	},
	computed: {},
	watch: {
		alertOpen: function () {
			// will close or set false in 3 second
			setTimeout(() => (this.$data.alertOpen = false), 3000);
		},
		selectedLoker(prev, next) {
			const findUpah = this.upahs.find((item) => item.align == this.selectedLoker);
			this.$data.upahValue = findUpah && findUpah.isi;
		},
	},
	methods: {
		add() {
			alert("Fitur akan segera dibuat");
		},
		addChildRow() {
			const items = [].concat(this.$data.v_perjanjian[this.$data.activePasal].item);
			console.log(items);
			let lastLine = parseInt(items.lastItem.kd_baris);
			lastLine++;
			console.log(lastLine);
			items.push({
				align: "l",
				isi: "",
				kd_baris: lastLine.toString().padStart(4, "0"),
				lokasi: "0",
				sub: "0",
			});
			this.$data.v_perjanjian[this.$data.activePasal].item = items;
		},
		clearChildTemporaryCheck() {
			this.$data.tableChildTemporaryCheck = [];
		},
		removeChildRow() {
			const confirmation = confirm("Apakah anda ingin menghapus item yang dichecklist");
			if (!confirmation) return;
			const items = [].concat(this.$data.v_perjanjian[this.$data.activePasal].item).filter((item, i) => {
				return !this.$data.tableChildTemporaryCheck.includes(i);
			});

			this.$data.v_perjanjian[this.$data.activePasal].item = items;
			this.clearChildTemporaryCheck();
		},
		backTable() {
			this.$data.activeTable = "parent";
			this.$data.activePasal = null;
			this.clearChildTemporaryCheck();
		},
		handleClick(pasal) {
			this.$data.activeTable = "child";
			this.$data.activePasal = pasal;
		},
		handleSave() {
			// this is assign virtual template to native template
			const clonedTemplate = [...Object.values(this.$data.v_perjanjian)];
			const actualTemplate = clonedTemplate.map((item) => {
				item.count_sub = item.item.filter((item) => {
					return item.sub > 0;
				}).length;
				return item;
			});

			this.$data.perjanjian = actualTemplate;

			// flat array
			let data = [];
			actualTemplate.forEach((sub) => {
				data.push(sub.title);
				data = [...data, ...sub.item];
			});
			let normalData = JSON.parse(JSON.stringify(data));

			$.ajax({
				method: "POST",
				url: API.update_perjanjian_kerja,
				data: {
					template: normalData,
				},
				success: () => {
					this.$data.alertOpen = true;
				},
				error() {
					console.error("Failed update database");
				},
			});
		},
		setUpah() {
			const { selectedLoker, upahValue } = this.$data;
			if (!upahValue || !selectedLoker) return console.warn("Value must be filled first");

			const confirmation = confirm("Apakah ingin mengubah upah di database ?");
			if (confirmation) {
				$.ajax({
					method: "POST",
					url: API.set_upah,
					data: {
						work_place: selectedLoker,
						salary: upahValue,
					},
					dataType: "json",
					success(res) {
						console.info(`--> ${res.message} `);
					},
					error(res) {
						console.error(`->> ${res.message} `);
					},
				});
			}

			const index = this.upahs.findIndex((item) => item.align == this.selectedLoker);
			this.upahs[index].isi = this.upahValue;
		},
		printNow() {
			const vm = this;
			const param = {
				batch_noind: form.$data.selectedNoind, // array of string
				template: this.$data.perjanjian, // array of object
				noind: form.$data.selectedData.noind, // string
				loker: this.$data.selectedLoker, // string
				upah: this.$data.upahValue, // string
				signer: this.$data.signer, // string
			};

			$.ajax({
				method: "post",
				url: baseurl + "MasterPekerja/KesepakatanKerja/print_pdf",
				data: param,
				// responseType: "arraybuffer",
				// dataType: "blob",
				// success(data) {
				// 	let dt = new Blob([data["response"]], { type: "application/pdf" });
				// 	window.open(URL.createObjectURL(dt), "_blank");
				// },
				beforeSend() {
					vm.download_is_processing = true;
				},
				dataType: "json",
				success(data) {
					let a = document.createElement("a");
					// this array item can be 1 or more
					for (let item of data) {
						// direct download
						a.href = item.full_path;
						// a.download = data.filename;
						if (vm.$data.newtab) {
							a.target = "_blank";
						} else {
							a.download = item.filename;
						}
						a.click();
					}
				},
				error(message) {
					console.error(message);
				},
				complete() {
					vm.download_is_processing = false;
				},
			});
		},
		printNowBackup() {
			/**
			 * This is backup
			 */
			const param = {
				noind: form.$data.selectedData.noind,
				loker: this.$data.selectedLoker,
				upah: this.$data.upahValue,
				signer: this.$data.signer,
			};
			const query = $.param(param);
			const encrypt = btoa(query);

			const pdf_url = baseurl + "MasterPekerja/KesepakatanKerja/print_pdf?token=" + encrypt;

			window.open(pdf_url, "_blank");
		},
		fetchSalary() {
			fetch(API.upah)
				.then((e) => e.json())
				.then((res) => {
					this.$data.upahs = res.data;
				})
				.catch((e) => {
					alert(e.message);
				});
		},
		fetchPerjanjian(noind = false) {
			let param = "";

			if (noind) {
				param = {
					noind: noind,
				};
			}

			// this will add query string param at end of url
			fetch(API.perjanjian_kerja + "?" + $.param(param))
				.then((e) => e.json())
				.then((res) => {
					this.$data.perjanjian = res.data;
					this.$data.v_perjanjian = res.data;
				})
				.catch((e) => {
					alert(e.message);
				});
		},
	},
	created() {
		this.fetchSalary();
		this.fetchPerjanjian();
	},
	mounted() {},
	updated() {
		console.log("component is updated");

		// re count sub in child item
		if (this.$data.activePasal) {
			let selected_child = this.$data.v_perjanjian[this.$data.activePasal].item;
			let sub = 1;
			selected_child = selected_child.map((it) => {
				it.sub = it.sub > 0 ? sub++ : 0;
				return it;
			});
		}

		// resizing textarea element
		var textarea = this.$el.querySelectorAll("textarea");
		var limit = 500; //height limit

		for (let element of textarea) {
			// element.oninput = function () {
			element.style.height = "";
			console.log(element.value.lineCount());
			let scrollHeight = element.scrollHeight;
			if (scrollHeight < 40) {
				element.style.height = "25px";
			} else {
				element.style.height = Math.min(scrollHeight, limit) + "px";
			}
			// };
		}
	},
});
