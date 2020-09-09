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
});

/**
 * Index form
 */
const form = new Vue({
	name: "Form",
	el: "section#app",
	data() {
		return {
			today: moment().format("YYYY-MM-DD"),
			selectedMonth: new Date().getMonth() + 1,
			selectedYear: new Date().getFullYear(),
			tableLoading: false,
			table: [],
			checkbox: {
				tglevaluasi: false,
				tglpemanggilan: false,
				tgltandatangan: false,
			},
			showedTable: [],
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
	},
	methods: {
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
			this.$data.tableLoading = true;
			const { selectedMonth, selectedYear, queryParam } = this.$data;
			fetch(API.surat + `?month=${selectedMonth}&year=${selectedYear}&keyword=${queryParam}`)
				.then((e) => e.json())
				.then((data) => {
					this.$data.table = [].concat(data);
					this.$data.showedTable = [].concat(data);
					this.$data.tableLoading = false;
				})
				.catch((error) => {
					console.log(error);
				});
		},
		filterTable() {
			// let { table, queryParam } = this.$data;
			// if (!queryParam) return (this.$data.showedTable = table);

			// this.$data.activeRow = null;

			// queryParam = queryParam.toLowerCase();
			// const filteredData = table.filter((item) => {
			// 	return item.nama.toLowerCase().includes(queryParam) || item.noind.toLowerCase().includes(queryParam);
			// });

			// this.$data.showedTable = filteredData;
			this.loadTable();
		},
		updateTableItem() {
			const vm = this;
			// if nothin changed
			// Salah satu data harus terisi jika akan menyimpan
			// ask confirmation
			const selectedIndex = vm.$data.activeRow;
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
						method: "post",
						data: selectedData,
						success(res) {
							/**
							 * Reactive update index of array
							 */
							vm.$set(vm.$data.showedTable, selectedIndex, selectedData);
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
		rowOnClick(rowIndex) {
			this.$data.activeRow = rowIndex;
			this.$data.selectedData = Object.assign({}, this.$data.table[rowIndex]);
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
 * Modal Cetak
 */
const modal = new Vue({
	name: "Modal",
	el: "#modal-print",
	data() {
		return {};
	},
	computed: {},
	watch: {},
	methods: {
		printNow() {},
	},
	created() {},
	mounted() {},
});
