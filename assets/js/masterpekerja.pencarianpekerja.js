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
 * SELECT2
 * VUE
 */

"use strict";

// set global locale of moment JS to indonesian
moment.locale("id");

// JQUERY
// $("select.select2").select2();
$(() => {
	// $("th").resizable(); // resizeable th
	$(".date-range")
		.daterangepicker()
		.on("change", function () {
			app.$data.keyword = $(this).val();
		});
});

const API = {
	/**
	 * find worker
	 * GET
	 * param
	 * keyword
	 * out
	 */
	findWorker: baseurl + "MasterPekerja/PencarianPekerja/api/find",
	getOption: baseurl + "MasterPekerja/PencarianPekerja/api/option",
};

const app = new Vue({
	el: "#app",
	name: "App",
	data() {
		return {
			option: [],
			tableHead: [],
			tableHeadToggled: {},
			tableBody: [],
			tableKeys: [],
			activeRow: "",
			tableLoading: false,
			out: "f",
			param: "noind", // first time selected
			keyword: "",
			limit: "-",
			get optionType() {
				return this.option[this.param] && this.option[this.param].type;
			},
		};
	},
	watch: {
		// this method watch reactive optionType when is changed
		optionType: function (prev, news) {
			this.$data.keyword = "";
		},
	},
	methods: {
		setActiveRow(i) {
			/**
			 * set index of active row when row is click
			 * this will toggle class of bg-primary
			 */
			console.log(i);
			this.$data.activeRow = i;
		},
		sortColumn(key) {
			/**
			 * when table head is clicked, then sort asc/desc table item
			 */
			key = key - 1;
			const newArr = [].concat(this.tableBody);
			if (this.$data.tableHeadToggled[key] === false) {
				this.$data.tableHeadToggled[key] = true;
			} else {
				this.$data.tableHeadToggled[key] = false;
			}

			this.$data.tableBody = newArr.sort((a, b) => {
				const aKey = Object.keys(a)[key];
				const bKey = Object.keys(b)[key];

				if (this.$data.tableHeadToggled[key]) {
					if (a[aKey] < b[bKey]) return -1;
					if (a[aKey] > b[bKey]) return 1;
				} else {
					if (a[aKey] > b[bKey]) return -1;
					if (a[aKey] < b[bKey]) return 1;
				}
				return 0;
			});
			console.log(this.tableBody);
		},
		find() {
			/**
			 * find data with api based on form
			 */
			// validation not null value
			if (!this.$data.keyword || !this.$data.param) return console.warn("Params is must be not empty value");

			// validation data type
			if (this.$data.optionType == "date") {
				let splitDate = this.$data.keyword.split("-");
				if (splitDate.length < 2) return console.warn("date param is not valid");
				if (!moment(splitDate[0], ["dd/mm/yyyy"]).isValid()) return console.warn("first of date is not valid, must dd/mm/yyyy");
				if (!moment(splitDate[1], ["dd/mm/yyyy"]).isValid()) return console.warn("second of date is not valid, must dd/mm/yyyy");
			}

			this.$data.tableBody = [];
			this.$data.tableLoading = true;

			const data = {
				param: this.$data.param,
				keyword: this.$data.keyword,
				out: this.$data.out,
				limit: this.$data.limit,
			};

			const query = $.param(data);

			fetch(API.findWorker + "?" + query)
				.then((e) => e.json())
				.then((response) => {
					// use object freeze to improve perfomance
					// large data
					this.$data.tableLoading = false;
					this.$data.tableHead = Object.freeze(response.data.table_head);
					this.$data.tableBody = Object.freeze(response.data.table_body);
					this.$data.tableKeys = Object.freeze(response.data.table_keys);
					this.$data.tableHeadToggled = {};
					this.$data.activeRow = "";
				})
				.catch((e) => {
					alert("Fetch failed, try to reload");
				});
		},
		getOption() {
			/**
			 * get select option by api
			 */
			fetch(API.getOption)
				.then((e) => e.json())
				.then((data) => (this.$data.option = data))
				.catch((e) => {
					let err = "Something is happen, check your internet connection";
					console.error(err);
					alert(err);
				});
		},
		exportExcel() {
			/**
			 * this is export with plugin table2excel based current table
			 * @deprecated not used again
			 */
			$("table#table-pencarian-pekerja").table2excel({
				// exclude: "",
				name: "Sheet1",
				filename: `PencarianPekerja-${moment().format("YYYYMMDD")}.xls`, // do include extension
				preserveColors: false, // set to true if you want background colors and font colors preserved
			});
		},
		exportExcelBackend() {
			/**
			 * this is export excel with php backend
			 */
			const data = {
				param: this.$data.param,
				keyword: this.$data.keyword,
				out: this.$data.out,
				limit: this.$data.limit,
			};

			const query = $.param(data);

			const full_url = baseurl + "MasterPekerja/PencarianPekerja/export_excel?" + query;
			window.location.href = full_url;
		},
	},
	created() {
		console.log("i am created");
		// this is method is called when vue component is created /** read vue2 lifecycle */
		// fetch option
		this.getOption();
	},
	mounted() {
		// this method is called when vue component is mounted into DOM
	},
});
