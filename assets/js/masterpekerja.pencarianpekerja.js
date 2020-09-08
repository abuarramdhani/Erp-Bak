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
};

const app = new Vue({
	el: "#app",
	name: "App",
	data() {
		return {
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
		};
	},
	methods: {
		setActiveRow(i) {
			console.log(i);
			this.$data.activeRow = i;
		},
		sortColumn(key) {
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
			if (!this.$data.keyword) return;
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
		exportExcel() {
			$("table#table-pencarian-pekerja").table2excel({
				// exclude: "",
				name: "Sheet1",
				filename: `PencarianPekerja-${moment().format("YYYYMMDD")}.xls`, // do include extension
				preserveColors: false, // set to true if you want background colors and font colors preserved
			});
		},
	},
});
