//TABLE INPUT ELEMENT'S STANDARDIZATION//
$('.tabel_elemen').DataTable({
	"lengthMenu" : [10],
	"ordering": false,
	"lengthChange": false,
	"fixedHeader": true
});

//TABEL DAFTAR TSKK//
$('#tabel_daftarTSKK').DataTable({
	"lengthMenu" : [10],
	"ordering": false,
	"lengthChange": false
});

// $(document).ready(function () {

// })

//ADD ROWS FOR OBSERVATION SHEET//
	var nomor ="6";
	// var nc = nomor-1;
	function addRowObservation(){
		// 2-10-2020
		let no_gaes = $(`#tblObservasi tbody tr`).length;
		nomor = Number(no_gaes) + 1;
		// KOLOM 1
		var html = '<tr class="nomor_'+nomor+'"><td class="posisi">'+nomor+'</td>';
		console.log(nomor);
		// KOLOM 2
		html += '<td><input type="checkbox" name="checkBoxParalel['+(nomor-1)+']" value="PARALEL" class="checkBoxParalel" onchange="//chckParalel(this)"></td>'
		// KOLOM 3
		html += '<td><select id="slcJenis_'+nomor+'" onchange="myFunctionTSKK(this)" name="slcJenisProses[]" class="form-control select4" id="" style="width:100%;" title="Jenis Proses" >';
		html += '<option value=""> </option>';
		html += '<option value="MANUAL" id="manual"> MANUAL </option>';
		html += '<option value="AUTO" id="auto" onclick="setElemenGTSKK()"> AUTO </option>';
		// html += '<option value="AUTO (Inheritance)">AUTO (Inheritance)</option>';
		html += '<option value="WALK" id="walk"> WALK </option>';
		// html += '<option value="WALK (Inheritance)" id="walk"> WALK (Inheritance) </option>';
		html += "</select></td>";
		html += '<td><div class="col-lg-12"><div class="col-lg-6"><select class="form-control select2 slcElemen" id="slcElemen_'+nomor+'" name="txtSlcElemen[]" data-placeholder="Elemen" tabindex="-1" aria-hidden="true" ></select></div><div class="col-lg-6"><input type="text" class="form-control elemen" style="width: 100%" type="text" id="elemen_'+nomor+'" name="elemen[]" placeholder="Keterangan Elemen"></div></div></td>';
		// KOLOM 4
		html += '<td><input type="number" onchange="minMaxId(this)" name="waktu1[]" class="form-control waktuObs inputWaktuKolom1" placeholder="Detik" ></td>';
		// KOLOM 6
		html += '<td><input type="number" onchange="minMaxId(this)"  name="waktu2[]" class="form-control waktuObs inputWaktuKolom2" placeholder="Detik" ></td>';
		// KOLOM 7
		html += '<td><input type="number" onchange="minMaxId(this)"  name="waktu3[]" class="form-control waktuObs inputWaktuKolom3" placeholder="Detik" ></td>';
		//KOLOM 8
		html += '<td><input type="number" onchange="minMaxId(this)"  name="waktu4[]" class="form-control waktuObs inputWaktuKolom4" placeholder="Detik" ></td>';
		//KOLOM 9
		html += '<td><input type="number" onchange="minMaxId(this)"  name="waktu5[]" class="form-control waktuObs inputWaktuKolom5" placeholder="Detik" ></td>';
		//KOLOM 10
		html += '<td><input type="number" onchange="minMaxId(this)"  name="waktu6[]" class="form-control waktuObs inputWaktuKolom6" placeholder="Detik" ></td>';
		//KOLOM 11
		html += '<td><input type="number" onchange="minMaxId(this)"  name="waktu7[]" class="form-control waktuObs inputWaktuKolom7" placeholder="Detik" ></td>';
		//KOLOM 12
		html += '<td><input type="number" onchange="minMaxId(this)"  name="waktu8[]" class="form-control waktuObs inputWaktuKolom8" placeholder="Detik" ></td>';
		//KOLOM 13
		html += '<td><input type="number" onchange="minMaxId(this)" name="waktu9[]" class="form-control waktuObs inputWaktuKolom9" placeholder="Detik" ></td>';
		//KOLOM 14
		html += '<td><input type="number" onchange="minMaxId(this)" name="waktu10[]" class="form-control waktuObs inputWaktuKolom10" placeholder="Detik" ></td>';
		//KOLOM 15
		html += '<td><input type="number" id="xmin_".$no name="xmin[]" class="form-control xmin" placeholder="Detik" readonly></td>';
		//KOLOM 16
		html += '<td><input type="number" id="range_".$no name="range[]" class="form-control range" placeholder="Detik" readonly></td>';
		//KOLOM 17
		html += '<td><input type="number" onchange="minMaxId(this)" id="wDistribusi_".$no name="wDistribusi[]" class="form-control wDistribusi" placeholder="Detik" readonly></td>';
		//KOLOM SELIPAN
		html += '<td><input type="number" onchange="minMaxId(this)" onclick="checkDistributionTime(this)" name="wDistribusiAuto[]" class="form-control wDistribusiAuto" placeholder="Detik" readonly></td>';
		//KOLOM 18
		html += '<td><input type="number" id="wKerja_".$no name="wKerja[]" class="form-control wKerja" placeholder="Detik" readonly></td>';
		//KOLOM 19
		html += '<td><input type="text" id="keterangan_".$no name="keterangan[]" class="form-control keterangan" placeholder="Input Keterangan" ></td>';
		//KOLOM 20
		html += '<td><i class="fa fa-times fa-2x" onclick="deleteObserve(this)" style="color:red" id="hapus" title="Hapus Elemen"></i></td>';
		html += "</tr>";

		nomor++;
		// console.log(html);

		$('#tbodyLembarObservasi').append(html);

		$('input').iCheck({
			checkboxClass: 'icheckbox_flat-blue',
			radioClass: 'iradio_flat-blue'
		});

		$('input[name="terdaftar"]').on('ifChanged', function () {
			if ($('input[name=terdaftar]:checked').val() == "TidakTerdaftar") {
				console.log("tdk");
				$('.terdaftar').css("display", "none");
				$('.tdkTerdaftar').show("display", "");
			} else if ($('input[name=terdaftar]:checked').val() == "Terdaftar") {
				console.log("ya");
				$('.terdaftar').css("display", "");
				$('.tdkTerdaftar').css("display", "none");
			}
		});

		$('input[name="equipmenTerdaftar"]').on('ifChanged', function () {
			if ($('input[name=equipmenTerdaftar]:checked').val() == "TidakTerdaftar") {
				console.log("tdk");
				$('.equipmenTerdaftar').css("display", "none");
				$('.equipmenTdkTerdaftar').show("display", "");
			} else if ($('input[name=equipmenTerdaftar]:checked').val() == "Terdaftar") {
				console.log("ya");
				$('.equipmenTerdaftar').css("display", "");
				$('.equipmenTdkTerdaftar').css("display", "none");
			}
		});

			$('.select4').select2({
				placeholder: 'Jenis Proses',
				allowClear: true,
			  });

			$('.tipe_urutan').select2({
				placeholder: 'Tipe Urutan',
				allowClear: true,
				});

			$('.slcElemen').select2({
				placeholder: 'Elemen',
				allowClear: true,
				});

			$('.slcElemen').select2({
				ajax: {
				url:baseurl+'GeneratorTSKK/C_GenTSKK/ElemenKerja/',
				dataType: 'json',
				type: "GET",
				data: function (params) {
					var queryParameters = {
					elk: params.term,
					elm_krj: $('#slcElemen').val()
					}
			return queryParameters;
				},
				processResults: function (data) {
					console.log(data)
			return {
				results: $.map(data, function(obj) {
			return { id:obj.elemen_kerja, text:obj.elemen_kerja };
							})
						};
					}
				}
			});

			$('.posisi').each((i, item) => {
				document.getElementsByClassName('posisi')[i].innerHTML = i + 1
			})
	}

	//ADD ROWS FOR OBSERVATION SHEET after NEXT//
	var nomor ="6";
	function addRowObservationAfterNext(){
		// KOLOM 1
		var html = '<tr class="nomor_'+nomor+'"><td class="posisi">'+nomor+'</td>';
		// KOLOM 2
		html += '<td><select id="slcJenis_'+nomor+'" onchange="myFunctionTSKK(this)" name="slcJenisProses[]" class="form-control select4" id="" style="width:100%;" title="Jenis Proses" disabled>';
		html += '<option value=""> </option>';
		html += '<option value="MANUAL" id="manual"> MANUAL </option>';
		html += '<option value="AUTO" id="auto" onclick="setElemenGTSKK()"> AUTO </option>';
		// html += '<option value="AUTO (Inheritance)">AUTO (Inheritance)</option>';
		html += '<option value="WALK" id="walk"> WALK </option>';
		html += "</select></td>";
		// KOLOM 3
		html += '<td><div class="col-lg-12"><div class="col-lg-6"><select class="form-control select2 slcElemen" id="slcElemen_'+nomor+'" name="txtSlcElemen[]" data-placeholder="Elemen" tabindex="-1" aria-hidden="true" disabled></select></div><div class="col-lg-6" disabled><input type="text" class="form-control elemen" style="width: 100%" type="text" id="elemen_'+nomor+'" name="elemen[]" placeholder="Keterangan Elemen" readonly></div></div></td>';
		// KOLOM 4
		html += '<td><select id="slcTipeUrutan_'+nomor+'" name="slcTipeUrutan[]" class="form-control tipe_urutan" style="width:100%;" title="Tipe Urutan Proses" disabled>';
		html += '<option value="" >  </option>';
		html += '<option value="SERIAL"> SERIAL </option>';
		html += '<option value="PARALEL"> PARALEL </option>';
		html += "</select></td>";
		// KOLOM 5
		html += '<td><input type="number" onchange="minMaxId(this)" name="waktu1[]" class="form-control waktuObs inputWaktuKolom1" placeholder="Detik" readonly></td>';
		// KOLOM 6
		html += '<td><input type="number" onchange="minMaxId(this)"  name="waktu2[]" class="form-control waktuObs inputWaktuKolom2" placeholder="Detik" readonly></td>';
		// KOLOM 7
		html += '<td><input type="number" onchange="minMaxId(this)"  name="waktu3[]" class="form-control waktuObs inputWaktuKolom3" placeholder="Detik" readonly></td>';
		//KOLOM 8
		html += '<td><input type="number" onchange="minMaxId(this)"  name="waktu4[]" class="form-control waktuObs inputWaktuKolom4" placeholder="Detik" readonly></td>';
		//KOLOM 9
		html += '<td><input type="number" onchange="minMaxId(this)"  name="waktu5[]" class="form-control waktuObs inputWaktuKolom5" placeholder="Detik" readonly></td>';
		//KOLOM 10
		html += '<td><input type="number" onchange="minMaxId(this)"  name="waktu6[]" class="form-control waktuObs inputWaktuKolom6" placeholder="Detik" readonly></td>';
		//KOLOM 11
		html += '<td><input type="number" onchange="minMaxId(this)"  name="waktu7[]" class="form-control waktuObs inputWaktuKolom7" placeholder="Detik" readonly></td>';
		//KOLOM 12
		html += '<td><input type="number" onchange="minMaxId(this)"  name="waktu8[]" class="form-control waktuObs inputWaktuKolom8" placeholder="Detik" readonly></td>';
		//KOLOM 13
		html += '<td><input type="number" onchange="minMaxId(this)" name="waktu9[]" class="form-control waktuObs inputWaktuKolom9" placeholder="Detik" readonly></td>';
		//KOLOM 14
		html += '<td><input type="number" onchange="minMaxId(this)" name="waktu10[]" class="form-control waktuObs inputWaktuKolom10" placeholder="Detik" readonly></td>';
		//KOLOM 15
		html += '<td><input type="number" id="xmin_".$no name="xmin[]" class="form-control xmin" placeholder="Detik" readonly></td>';
		//KOLOM 16
		html += '<td><input type="number" id="range_".$no name="range[]" class="form-control range" placeholder="Detik" readonly></td>';
		//KOLOM 17
		html += '<td><input type="number" onchange="minMaxId(this)" id="wDistribusi_".$no name="wDistribusi[]" class="form-control wDistribusi" placeholder="Detik" readonly></td>';
		//KOLOM 18
		html += '<td><input type="number" id="wKerja_".$no name="wKerja[]" class="form-control wKerja" placeholder="Detik" readonly></td>';
		//KOLOM 19
		html += '<td><input type="text" id="keterangan_".$no name="keterangan[]" class="form-control keterangan" placeholder="Input Keterangan" readonly></td>';
		//KOLOM 20
		html += '<td><i class="fa fa-times fa-2x" onclick="deleteObserve(this)" style="color:red" id="hapus" title="Hapus Elemen"></i></td>';
		html += "</tr>";

		nomor++;

		$('#tbodyLembarObservasi').append(html);
		// $('#tbodyEditTSKK').append(html);

			$('.select4').select2({
				placeholder: 'Jenis Proses',
				allowClear: true,
			  });

			$('.tipe_urutan').select2({
				placeholder: 'Tipe Urutan',
				allowClear: true,
				});

			$('.slcElemen').select2({
				placeholder: 'Elemen',
				allowClear: true,
				});

			$('.slcElemen').select2({
				// minimumInputLength: 3,
				ajax: {
				url:baseurl+'GeneratorTSKK/C_GenTSKK/ElemenKerja/',
				dataType: 'json',
				type: "GET",
				data: function (params) {
					var queryParameters = {
					elk: params.term,
					elm_krj: $('#slcElemen').val()
					}
			return queryParameters;
				},
				processResults: function (data) {
					console.log(data)
			return {
				results: $.map(data, function(obj) {
			return { id:obj.elemen_kerja, text:obj.elemen_kerja };
							})
						};
					}
				}
			});

			$('.posisi').each((i, item) => {
				document.getElementsByClassName('posisi')[i].innerHTML = i + 1
			})
	}

	//ADD ROWS FOR OBSERVATION SHEET ON EDIT PAGE//
	var nomor ="6";
	function addRowObservationEdit(){
		// 2-10-2020 hia
		let no_gaes = $(`#tblObservasiEdit tbody tr`).length;
		nomor = Number(no_gaes) + 1;
		// KOLOM 1
		var html = '<tr class="nomor_'+nomor+'"><td class="posisi">'+nomor+'</td>';
		html += '<td><input type="checkbox" name="checkBoxParalel['+(nomor-1)+']" value="PARALEL" class="checkBoxParalel"></td>'
		// KOLOM 2
		html += '<td><select id="slcJenis_'+nomor+'" onchange="myFunctionTSKK(this)" name="slcJenisProses[]" class="form-control select4" id="" style="width:100%;" title="Jenis Proses">';
		html += '<option value=""> </option>';
		html += '<option value="MANUAL" id="manual"> MANUAL </option>';
		html += '<option value="AUTO" id="auto" onclick="setElemenGTSKK()"> AUTO </option>';
		// html += '<option value="AUTO (Inheritance)">AUTO (Inheritance)</option>';
		html += '<option value="WALK" id="walk"> WALK </option>';
		html += "</select></td>";
		// KOLOM 3
		html += '<td><div class="col-lg-12"><div class="col-lg-6"><select class="form-control select2 slcElemen" id="slcElemen_'+nomor+'" name="txtSlcElemen[]" data-placeholder="Elemen" tabindex="-1" aria-hidden="true" ></select></div><div class="col-lg-6"><input type="text" class="form-control elemen" style="width: 100%" type="text" id="elemen_'+nomor+'" name="elemen[]" placeholder="Keterangan Elemen"></div></div></td>';
		// KOLOM 4
		// KOLOM 5
		html += '<td><input type="number" onchange="minMaxId(this)" name="waktu1[]" class="form-control waktuObs inputWaktuKolom1" placeholder="Detik" ></td>';
		// KOLOM 6
		html += '<td><input type="number" onchange="minMaxId(this)"  name="waktu2[]" class="form-control waktuObs inputWaktuKolom2" placeholder="Detik" ></td>';
		// KOLOM 7
		html += '<td><input type="number" onchange="minMaxId(this)"  name="waktu3[]" class="form-control waktuObs inputWaktuKolom3" placeholder="Detik" ></td>';
		//KOLOM 8
		html += '<td><input type="number" onchange="minMaxId(this)"  name="waktu4[]" class="form-control waktuObs inputWaktuKolom4" placeholder="Detik" ></td>';
		//KOLOM 9
		html += '<td><input type="number" onchange="minMaxId(this)"  name="waktu5[]" class="form-control waktuObs inputWaktuKolom5" placeholder="Detik" ></td>';
		//KOLOM 10
		html += '<td><input type="number" onchange="minMaxId(this)"  name="waktu6[]" class="form-control waktuObs inputWaktuKolom6" placeholder="Detik" ></td>';
		//KOLOM 11
		html += '<td><input type="number" onchange="minMaxId(this)"  name="waktu7[]" class="form-control waktuObs inputWaktuKolom7" placeholder="Detik" ></td>';
		//KOLOM 12
		html += '<td><input type="number" onchange="minMaxId(this)"  name="waktu8[]" class="form-control waktuObs inputWaktuKolom8" placeholder="Detik" ></td>';
		//KOLOM 13
		html += '<td><input type="number" onchange="minMaxId(this)" name="waktu9[]" class="form-control waktuObs inputWaktuKolom9" placeholder="Detik" ></td>';
		//KOLOM 14
		html += '<td><input type="number" onchange="minMaxId(this)" name="waktu10[]" class="form-control waktuObs inputWaktuKolom10" placeholder="Detik" ></td>';
		//KOLOM 15
		html += '<td><input type="number" id="xmin_".$no name="xmin[]" class="form-control xmin" placeholder="Detik" readonly></td>';
		//KOLOM 16
		html += '<td><input type="number" id="range_".$no name="range[]" class="form-control range" placeholder="Detik" readonly></td>';
		//KOLOM 17
		html += '<td><input type="number" onchange="minMaxId(this)" onclick="checkDistributionTime(this)" id="wDistribusi" name="wDistribusi[]" class="form-control wDistribusi" placeholder="Detik" readonly></td>';
		//KOLOM 18
		html += '<td><input type="number" onchange="minMaxId(this)" onclick="checkDistributionTime(this)" name="wDistribusiAuto[]" class="form-control wDistribusiAuto" placeholder="Detik" readonly></td>';
		//KOLOM 19
		html += '<td><input type="number" id="wKerja_".$no name="wKerja[]" class="form-control wKerja" placeholder="Detik" readonly></td>';
		//KOLOM 20
		html += '<td><input type="text" id="keterangan_".$no name="keterangan[]" class="form-control keterangan" placeholder="Input Keterangan" ></td>';
		//KOLOM 21
		html += '<td><i class="fa fa-times fa-2x" onclick="deleteObserve(this)" style="color:red" id="hapus" title="Hapus Elemen"></i></td>';
		html += "</tr>";

		nomor++;

		$('#tbodyLembarObservasiEdit').append(html);
		// $('#tbodyEditTSKK').append(html);

		$('input').iCheck({
			checkboxClass: 'icheckbox_flat-blue',
			radioClass: 'iradio_flat-blue'
		});

		$('input[name="terdaftar"]').on('ifChanged', function () {
			if ($('input[name=terdaftar]:checked').val() == "TidakTerdaftar") {
				console.log("tdk");
				$('.terdaftar').css("display", "none");
				$('.tdkTerdaftar').show("display", "");
			} else if ($('input[name=terdaftar]:checked').val() == "Terdaftar") {
				console.log("ya");
				$('.terdaftar').css("display", "");
				$('.tdkTerdaftar').css("display", "none");
			}
		});

		$('input[name="equipmenTerdaftar"]').on('ifChanged', function () {
			if ($('input[name=equipmenTerdaftar]:checked').val() == "TidakTerdaftar") {
				console.log("tdk");
				$('.equipmenTerdaftar').css("display", "none");
				$('.equipmenTdkTerdaftar').show("display", "");
			} else if ($('input[name=equipmenTerdaftar]:checked').val() == "Terdaftar") {
				console.log("ya");
				$('.equipmenTerdaftar').css("display", "");
				$('.equipmenTdkTerdaftar').css("display", "none");
			}
		});

			$('.select4').select2({
				placeholder: 'Jenis Proses',
				allowClear: true,
			  });

			$('.tipe_urutan').select2({
				placeholder: 'Tipe Urutan',
				allowClear: true,
				});

			$('.slcElemen').select2({
				placeholder: 'Elemen',
				allowClear: true,
				});

			$('.slcElemen').select2({
				// minimumInputLength: 3,
				ajax: {
				url:baseurl+'GeneratorTSKK/C_GenTSKK/ElemenKerja/',
				dataType: 'json',
				type: "GET",
				data: function (params) {
					var queryParameters = {
					elk: params.term,
					elm_krj: $('#slcElemen').val()
					}
			return queryParameters;
				},
				processResults: function (data) {
					console.log(data)
			return {
				results: $.map(data, function(obj) {
			return { id:obj.elemen_kerja, text:obj.elemen_kerja };
							})
						};
					}
				}
			});

			$('.posisi').each((i, item) => {
				document.getElementsByClassName('posisi')[i].innerHTML = i + 1
			})
	}

//-----------------------------------------------------------DEKLARASI AWAL------------------------------------------------------------//
// fungsi konversi array ke map
	function convertArrayToMap(a) {
		var result = new Map()
		for(var i = 0; i < a.length; i++) result.set(i, a[i])
		return result
  	}

// fungsi sort descending map
  	function sortMapDescendingByValue(a, b) { return b[1] - a[1]; }

// fungsi total array
  	function total(a, b) { return a + b; }

// fungsi distinct array
  	function unique (value, index, self) { return self.indexOf(value) === index; }

//GET VALUES FROM 10 OBSERVATION TIME ROWS AND GIVE THE LOGIC//
	function minMaxId(a) {

		//CHANGE THE NUMBER FROM DECIMAL INTO CEIL MATH

		$(a).closest('tr').find('input.waktuObs').each(function() {
			var val = $(this).val();
			if(val != ""){
				$(this).val(Math.ceil(val));
			}
		});

		//FIND MIN & R
		var arr = [];
		$(a).closest('tr').find('input.waktuObs').each(function() {
			// alert();
			var val = $(this).val();
			if (val != '') {
				arr.push(val);
			}
		});
		// console.log(arr);

		var minimum = Math.min.apply(Math,arr);
		var maximum = Math.max.apply(Math,arr);

		$(a).closest('tr').find('input.xmin').val(minimum);                               //SET Xmin
		$(a).closest('tr').find('input.range').val(Number(maximum) - Number(minimum));	  //SET R

		//1. FIND TOTAL TIMES PER COLUMN
		let totalKolomArr = []
		for (let index = 0; index < 10; index++) {
			var total = 0;
			$('.inputWaktuKolom' + (index + 1)).each((i, item) => {
				if (item.value == false) {
					return;
				}
				total += Number(item.value)
			})
			if(total == false){
				continue;
			}
			// console.log(total, "total  kolom " + (index + 1));
			totalKolomArr.push(total)
		}

		//2. CARI TERKECIL
		var minimalAllKolom = Math.min.apply(Math, totalKolomArr);
		// console.log(totalKolomArr);
		// console.log(minimalAllKolom, "kecil sendiri");

		//3. TOTAL XMIN
		var total_min = 0;
		$('input.xmin').each((i, item) => {
			if (item.value == false) {
				return
			}
			total_min += Number(item.value)
		})
		// console.log(total_min, "jml min");

//---------------------------------------------THE MOST COMPLICATED PART HERE HWHWHWH---------------------------------------//

		//4. WAKTU BUAT DISEBARIN (DISTRIBUSI)
		var input_distribusi = $(a).closest('tr').find('.wDistribusi').val();
		var distribusi = Number(minimalAllKolom) - Number(total_min);
		console.log('DISTRIBUSI : ' + distribusi)

		// GET RANGE
		var range = [];
		var rangeIndex = 0

		//Diubah jadi yang ini biar kalo ada row kosong dianggap 0 bukan NaN lagi
		$('input[name^=range]').each(function() {
			var isi = parseInt($(this).val())
			if(isNaN(isi)){
				range[rangeIndex++] = 0;
			} else {
				range[rangeIndex++] = parseInt($(this).val())
			}
		})
		///////////////////////////////////////////////////////////////////////////
		console.log('RANGE : ' + range)

		// TOTAL RANGE
		var totalRange = 0
		range.forEach(function(i) { totalRange += i })
		console.log('TOTAL RANGE : ' + totalRange)

		var divider = Math.round((distribusi / totalRange) * 100) / 100
		var rangeMap = convertArrayToMap(range)
		var rangeMapSorted = new Map([...rangeMap.entries()].sort(sortMapDescendingByValue))
		console.log('DIVIDER : ' + divider)

		// menghitung penambah range distinct
		var rangeDistinct = range.sort().reverse().filter(unique);
		var calculatedRangeDistinct = new Map()
		rangeDistinct.forEach(function(value) {
			calculatedRangeDistinct.set(value, Math.ceil(Math.round((value * divider) * 100) / 100))
		})
		calculatedRangeDistinct = new Map([...calculatedRangeDistinct.entries()].sort(sortMapDescendingByValue))

		// apply ke array
		let resultMap = new Map()
		var currentCalculation = 0
		calculatedRangeDistinct.forEach(function(valueDistinct, keyDistinct) {
			rangeMapSorted.forEach(function(value, key) {
				if(keyDistinct == value) {
					if(currentCalculation < distribusi) {
						resultMap.set(key, value + ((distribusi - currentCalculation) >= valueDistinct ? valueDistinct : distribusi - currentCalculation))
						currentCalculation += valueDistinct
					} else {

					}
				} else {

				}
			})
		})
		// console.log('batas akhir perulangan')
		console.log(resultMap);
		// console.log(hasilmap)
		var result = []
		var resultIndex = 0
		resultMap = new Map([...resultMap.entries()].sort((a, b) => a[0] > b[0] ? 1 : -1))
		// resultMap.forEach(function(value, _) { result[resultIndex++] = value })
		resultMap.forEach(function(value, key) { result[key] = value })

		//NGURANGIN HASIL AUTO DISTRIBUSI w/ RANGE
		var distributionTime = []
		var rangeAwal = []
		var rangeAwalIndex = 0
		//dikasih pengecekan seperti range di atas, supaya NaN dianggap 0
		$('input[name^=range]').each(function() {
			if(isNaN(parseInt($(this).val()))){
				rangeAwal[rangeAwalIndex++] = 0;
			} else {
				rangeAwal[rangeAwalIndex++] = parseInt($(this).val())
			}
		})
		/////////////////////////////////////////////////////////////////
		for(let i = 0; i < rangeAwal.length; i++) {
			if(typeof result[i] === 'undefined') {
				// does not exist
				distributionTime[i] = 0;
			}
			else {
				distributionTime[i] = result[i] - rangeAwal[i];
				// does exist
			}
		}

		console.log('RESULT : ' + result)
		console.log('RANGE : ' + rangeAwal)
		console.log('DISTRIBUTION TIME : ' + distributionTime)

		//SET AUTO WAKTU DISTRIBUSI
		const input = document.querySelectorAll('.wDistribusiAuto');
		for(let i = 0; i < distributionTime.length; i++) if(distributionTime[i] != null) input[i].value = distributionTime[i];

		var total_Wdistribusi = 0;
		$('.wDistribusi').each((i, item) => {
			if (item.value == false) {
				return
			}
			total_Wdistribusi += Number(item.value)
		})
		console.log(total_Wdistribusi, "ini total waktu distribusi");

		var kurang = Number(distribusi) - Number(total_Wdistribusi);

		//i think over here//
		if(kurang < 0){
			var sisa = $('#dst').val();
			$(a).closest('tr').find('.wDistribusi').val(0)
			var krg = (Number(total_Wdistribusi) - Number(input_distribusi));
			// console.log(krg);
			var dstMin = (Number(distribusi) - Number(krg));
			// console.log(dstMin, "dstMin");
			kurang = dstMin;
			$(a).closest('tr').find('.wKerja').val(Number(minimum) + Number(0)); //jumlah dari x min + yg distribusi
			// $(a).closest('tr').find('.wKerja').val(Number(minimum) + Number(input_distribusi)); //jumlah dari x min + yg distribusi
			console.log("MINIMUM: " + maximum + "+" + "ID" + input_distribusi)
			console.log("< 0")
		}else if(kurang == 0){
			var input_distribusi = $(a).closest('tr').find('.wDistribusi').val();
			var total_wKerja = (Number(minimum) + Number(input_distribusi))
			$(a).closest('tr').find('.wKerja').val(total_wKerja)
			console.log("TOTAL W KERJA: " + total_wKerja)
			console.log("=0")
		}else{
			$(a).closest('tr').find('.wKerja').val(Number(minimum) + Number(input_distribusi))
			console.log("MINIMUM: " + maximum + "+" + "ID" + input_distribusi)
			console.log(">0")
		}

		//AUTO NGURANGIN WAKTU DISTRIBUSINYA
		if (input_distribusi == null) {
			$('#dst').val(distribusi);
		}else{
			$('#dst').val(kurang);
		}

		//5. KALO MISAL HASIL WAKTU DISTRIBUSINYA < 1 a.k.a 0 KE BAWAH
		if (kurang < 1) {
			$('.wDistribusi').each((i, item) => {
				if(item.value != false){return}item.value = "0"
			})
		}
	}

	function copyAutoWaktuDistribusi(a) {
					var waktumu = $("input[name='wDistribusiAuto[]']")
					.map(function(){return $(this).val();}).get();
					// console.log(waktumu)
					for (let i = 0; i < $('.wDistribusiAuto').size(); i++) {
						$(".wDistribusi").eq(i).val(waktumu[i]);

					}

				//1. FIND TOTAL TIMES PER COLUMN
				let totalKolomArr = []
				for (let index = 0; index < 10; index++) {
					var total = 0;
					$('.inputWaktuKolom' + (index + 1)).each((i, item) => {
						if (item.value == false) {
							return;
						}
						total += Number(item.value)
					})
					if(total == false){
						continue;
					}
					// console.log(total, "total  kolom " + (index + 1));
					totalKolomArr.push(total)
				}

				//2. CARI TERKECIL
				var minimalAllKolom = Math.min.apply(Math, totalKolomArr);

				//3. TOTAL XMIN
				var total_min = 0;
				$('input.xmin').each((i, item) => {
					if (item.value == false) {
						return
					}
					total_min += Number(item.value)
				})
				// console.log(total_min, "jml min");

		//---------------------------------------------THE MOST COMPLICATED PART HERE HWHWHWH---------------------------------------//

				//4. WAKTU BUAT DISEBARIN (DISTRIBUSI)
				var input_distribusi = $(a).closest('tr').find('.wDistribusi').val();
				var distribusi = Number(minimalAllKolom) - Number(total_min);
				console.log('DISTRIBUSI : ' + distribusi);

				var autoDistribusi = [];
				$('input[name^=wDistribusiAuto]').each(function(){
					autoDistribusi.push($(this).val());
				});
				console.log("autoDistribusi:" ,autoDistribusi);

				var waktuDistribusi = [];
				$('input[name^=wDistribusi]').each(function(){
					waktuDistribusi.push($(this).val());
				});
				console.log("waktuDistribusi:" ,waktuDistribusi);

				var xMin = [];
				$('input[name^=xmin]').each(function(){
					xMin.push($(this).val());
				});
				console.log("xMin:" ,xMin);

				//SET WAKTU KERJA OTOMATIS
				const set = document.querySelectorAll('.wKerja');
				// console.log(`INPUT: ${input}`);
				for(let i = 0; i < xMin.length; i++) if(xMin[i] != null) set[i].value = Number(xMin[i]) + Number(autoDistribusi[i]);
				console.log("x min: " + xMin + "ditambah" + waktuDistribusi);


				var total_Wdistribusi = 0;
				$('.wDistribusi').each((i, item) => {
					if (item.value == false) {
						return
					}
					total_Wdistribusi += Number(item.value)
				})
				console.log(total_Wdistribusi);

				var kurang = Number(distribusi) - Number(total_Wdistribusi);
				console.log(kurang);

				var sisa_nilai_distribusi = $('#dst').val();
				//AUTO NGURANGIN WAKTU DISTRIBUSINYA
				if (sisa_nilai_distribusi == total_Wdistribusi) {
					$('#dst').val(0);
				}

	}

//YA GITU POKONYA, KALO PAS NGISI WAKTU DISTRIBUSI NILAINYA MINUS//
	function checkDistributionTime() {
		var nilai_distribusi = $('#dst').val();
		console.log(nilai_distribusi);
			$('input.wDistribusi').each(function(){
				if(nilai_distribusi < 0){
					Swal.fire({
						title: 'Tidak Dapat Mengisi Waktu Distribusi',
						type: 'error',
						text :'Nilai Distribusi Sudah Habis'
					});
					// $('#dst').val(0);
				}
			});
	}

//DELETE CURRENT ROWS IN OBSERVATION SHEET//
	function deleteObserve(th) {
		var curr_row = $(th).parent().parent('tr');
		//remove row
		curr_row.remove();

		$('.posisi').each((i, item) => {
			document.getElementsByClassName('posisi')[i].innerHTML = i + 1;
		})
		$('.checkBoxParalel').each((i, v) =>{
			$(v).attr('name', `checkBoxParalel[${i}]`)
		})

	}

//ADD ROWS GENERATE//
	var num ="2";
	function addRowElement(){
			// KOLOM 1
			var html = '<tr class="number'+num+'"><td>'+num+'</td>';
			// KOLOM 2
			html += '<td><select id="slcJenis_'+num+'" name="slcJenisProses[]" onchange="myAutomatically('+num+')" class="form-control slcJenisProses" style="width:100%;" onFocus="onBakso()" title="Jenis Proses">';
			html += '<option value=""> </option>';
			html += '<option value="MANUAL" id="manual"> MANUAL </option>';
			html += '<option value="WALK" id="walk"> WALK </option>';
			// html += '<option value="WALK (Inheritance)" id="walk"> WALK (Inheritance) </option>';
			html += "</select></td>";
			// KOLOM 3
			html += '<td><select class="form-control select2 slcElemen"  onmouseover="slcElemen('+num+')" id="slcElemen_'+num+'" name="txtSlcElemen[]" data-placeholder="Elemen" tabindex="-1" aria-hidden="true"></select><input type="text" class="form-control" style="width: 100%" type="text" onchange="myFunctionTSKK('+num+')" id="elemen_'+num+'" name="elemen[]" placeholder="Input Keterangan"></td>';
			// KOLOM 4
			html += '<td><select id="slcTipeUrutan_'+num+'" name="slcTipeUrutan[]" class="form-control tipe_urutan" style="width:100%;" onchange="editTimie('+num+')" title="Tipe Urutan Proses">';
			html += '<option value="" >  </option>';
			html += '<option value="SERIAL"> SERIAL  </option>';
			html += '<option value="PARALEL"> PARALEL </option>';
			html += "</select></td>";
			// KOLOM 5
			html += '<td><input type="number" class="form-control" style="width: 100%" type="text" oninput="setFinishGTSKK('+num+')"  id="waktu_'+num+'" name="waktu[]" placeholder="Detik"></td>';
			// KOLOM 6
			html += '<td><input type="number" class="form-control" style="width: 100%" type="text" oninput="setFinishGTSKK('+num+')" id="mulai_'+num+'" name="mulai[]" placeholder="Detik"></td>';
			// KOLOM 7
			html += '<td><input type="number" class="form-control finish" style="width: 100%" type="text" onclick="setFinishGTSKK('+num+')" id="finish_'+num+'" name="finish[]" placeholder="Detik"></td>';
			//KOLOM 8
			html += '<td><i class="fa fa-times fa-2x" onClick="onClickNasgor('+num+')" style="color:red" id="hapus" title="Hapus Elemen"></i> <i class="fa fa-plus fa-2x" onclick="addRowElement($(this))" style="color:green" id="hapus" title="Tambah Elemen"></i></td>';
			html += "</tr>";

		num++;

			$('#tbodyGeneratorTSKK').append(html);
			$('#tbodyEditTSKK').append(html);

				$('.slcJenisProses').select2({
					placeholder: 'Jenis Proses',
					allowClear: true,
				  });

			    $('.tipe_urutan').select2({
					placeholder: 'Tipe Urutan',
					allowClear: true,
					});

				$('.slcElemen').select2({
					placeholder: 'Keterangan Elemen',
					allowClear: true,
					});

					$('.slcElemen').select2({
						// minimumInputLength: 3,
						ajax: {
						url:baseurl+'GeneratorTSKK/C_GenTSKK/ElemenKerja/',
						dataType: 'json',
						type: "GET",
						data: function (params) {
							var queryParameters = {
							elk: params.term,
							elm_krj: $('#slcElemen').val()
							}
					return queryParameters;
						},
						processResults: function (data) {
							console.log(data)
					return {
						results: $.map(data, function(obj) {
					return { id:obj.elemen_kerja, text:obj.elemen_kerja };
									})
								};
							}
						}
					});

		};

	$('#txtTanggal').datepicker({
		todayHighlight: true,
		format: 'dd-M-yyyy',
		autoclose: true
	});

	// $('#kodepart').select2({
	// 	placeholder: 'Input Kode Part'
	// });

//Edit Time Set Auto Start//
const editTimie = (num) => {
	let tu = $("#slcTipeUrutan_" + num).val();
	let endTime = $("#finish_"+(num - 1)).val();
	console.log(tu);
	let jnsProses = $('#slcJenis_' + num).val();
	console.log(jnsProses);

	let no = Number(num - 1);
	console.log("Ini nomor sebelumnya : ", no);
	let waktuSblm = $("#waktu_" + no).val();
	console.log("Ini waktu sebelumnya : ", waktuSblm);

	let jnsProsesBfr = $('#slcJenis_' + no).val();
	console.log("Ini jenis proses sebelumnya : ", jnsProsesBfr);

	if (tu == "SERIAL" && jnsProses == "MANUAL" && jnsProsesBfr == "AUTO") {

		$('#mulai_'+num).val(Number(endTime) + 1 - Number(waktuSblm));
		$('#mulai_'+num).trigger("change");
		$('#mulai_'+num).prop('readonly', true);

	}else if (tu == "SERIAL" && jnsProses == "WALK (Inheritance)" && jnsProsesBfr == "MANUAL"){
		$('#mulai_'+num).val(Number(endTime) + 1);
		$('#mulai_'+num).trigger("change");
		$('#mulai_'+num).prop('readonly', true);

	}else if(tu == "SERIAL" && jnsProses == "WALK" && jnsProsesBfr == "MANUAL"){

		console.log("Ini serial : ",endTime);
		$('#mulai_'+num).val(Number(endTime) + 1);
		$('#mulai_'+num).trigger("change");
		$('#mulai_'+num).prop('readonly', true);

	}else if (tu == "SERIAL" && jnsProses != 'WALK (Inheritance)' && jnsProses != 'WALK' && jnsProses != 'MANUAL') {

		console.log("Ini serial : ",endTime);
		$('#mulai_'+num).val(Number(endTime) + 1);
		$('#mulai_'+num).trigger("change");
		$('#mulai_'+num).prop('readonly', true);

	//if WALK INHERITANCE and WALK, the start value will as same as AUTO
	} else if (tu == "SERIAL" && jnsProses == "WALK" && jnsProsesBfr == "WALK (Inheritance)") {

		$('#mulai_'+num).val(Number(endTime) + 1);
		$('#mulai_'+num).trigger("change");
		$('#mulai_'+num).prop('readonly', true);

	} else if (tu == "SERIAL" && jnsProses == 'WALK (Inheritance)' || jnsProses == 'WALK') {

		$('#mulai_'+num).val(Number(endTime) + 1 - Number(waktuSblm));
		$('#mulai_'+num).prop('readonly', true);
		// $('#mulai_'+no).val(Number(endTime) + 1);

	}else if (tu == "SERIAL" && jnsProses != 'WALK (Inheritance)' && jnsProses != 'WALK') {

		console.log("Ini serial : ",endTime);
		$('#mulai_'+num).val(Number(endTime) + 1);
		$('#mulai_'+num).trigger("change");
		$('#mulai_'+num).prop('readonly', true);

	}else{
		$('#mulai_'+num).val("");
		$('#mulai_'+num).trigger("change");
		$('#mulai_'+num).prop('readonly', false);
	}

}

//DELETE ROW'S ELEMENTS//
	const onClickNasgor = (th) => {
	console.log(th, "bakso")

	$('tr.number'+th).remove()
		num -=1
	}

//DISPLAY AND UNDISPLAY DIV IN PART SECTION//
$(document).ready(function () {
    $('input[name="terdaftar"]').on('ifChanged', function () {
        if ($('input[name=terdaftar]:checked').val() == "TidakTerdaftar") {
			console.log("tdk");
			$('.terdaftar').css("display", "none");
            $('.tdkTerdaftar').show("display", "");
        } else if ($('input[name=terdaftar]:checked').val() == "Terdaftar") {
			console.log("ya");
            $('.terdaftar').css("display", "");
            $('.tdkTerdaftar').css("display", "none");
        }
	});

	$('.inputWaktuKolom1').trigger('change');

});

//DISPLAY AND UNDISPLAY DIV IN EQUIPMENT SECTION//
$(document).ready(function () {
    $('input[name="equipmenTerdaftar"]').on('ifChanged', function () {
        if ($('input[name=equipmenTerdaftar]:checked').val() == "TidakTerdaftar") {
			console.log("tdk");
			$('.equipmenTerdaftar').css("display", "none");
            $('.equipmenTdkTerdaftar').show("display", "");
        } else if ($('input[name=equipmenTerdaftar]:checked').val() == "Terdaftar") {
			console.log("ya");
            $('.equipmenTerdaftar').css("display", "");
            $('.equipmenTdkTerdaftar').css("display", "none");
        }
	});
});

//SELECT TIPE PRODUK//
$(document).ready(function() {
	$("#typeProduct").select2({
		// minimumInputLength: 3,
		ajax: {
		url:baseurl+'GeneratorTSKK/C_GenTSKK/tipeProduk/',
		dataType: 'json',
		type: "GET",
		data: function (params) {
			var queryParameters = {
			tp: params.term,
			tipeProduk: $('#typeProduct').val()
			}
	return queryParameters;
		},
		processResults: function (tipeProduk) {
	return {
		results: $.map(tipeProduk, function(obj) {
	return { id:obj.DESCRIPTION, text:obj.DESCRIPTION };
	// id:obj.KODE_DIGIT,
					})
				};
			}
		}
	});
});

//SELECT KODE PART//
$(document).ready(function() {
	$("#kodepart").select2({
		minimumInputLength: 3,
		maximumSelectionLength: 1,
		ajax: {
		url:baseurl+'GeneratorTSKK/C_GenTSKK/kodePart/',
		dataType: 'json',
		type: "GET",
		data: function (params) {
			var queryParameters = {
			variable: params.term,
			kode: $('#kodepart').val()
			}
	return queryParameters;
		},
		processResults: function (kode) {
	return {
		results: $.map(kode, function(obj) {
	if (kode !== null) {
		return { id:obj.SEGMENT1, text:obj.SEGMENT1 };
	}else{
		$('.namaPart').val('');
	}
					})
				};
			}
		}
	});
});

//HAPUS KODE PART NAMA PART ILANG AWOKAWOK//
// $(document).ready(function(){
// 	$('#kodepart').click(function(){
// 		var isiKodePart  = $('.kodepart').val();
// 		console.log("kode part harusnya ilang: " + isiKodePart);

// 		if (isiKodePart == null) {
// 			$('.namaPart').val('');
// 		}
// 	})
// })

//AUTOFILL NAMA PART//
	$('#kodepart').change(function(){
		var isiKodePart  = $('.kodepart').val();

		if (isiKodePart !== null) {
			$.ajax({
				type: "POST",
				url: baseurl+'GeneratorTSKK/C_GenTSKK/namaPart/',
				// data: {kode :kode},
				data:{params: $(this).val() },
				dataType: "json",
				beforeSend: function(e) {
				if(e && e.overrideMimeType) {
			e.overrideMimeType("application/json;charset=UTF-8");
				}
			},
			success: function(response){

				if(response != null){
					// alert("Data Masuk")
					var sblm = $('#namaPart').val();
					console.log(sblm);
					if (sblm == '') {
						$("#namaPart").val(response[0].DESCRIPTION);
					} else {
						$("#namaPart").val(sblm+' , '+response[0].DESCRIPTION);
					}
				// console.log(response[0].DESCRIPTION);
				}else{
					alert("Data Tidak Ditemukan");
				}
			},
			error: function (xhr) {
			alert(xhr.responseText);
				}
			});
		}else{
			$('.namaPart').val('');
		}
});

//SELECT NO MESIN//
$(document).ready(function() {
	$("#txtNoMesinTSKK").select2({
		minimumInputLength: 3,
		maximumSelectionLength: 6,
		ajax: {
		url:baseurl+'GeneratorTSKK/C_GenTSKK/NoMesin/',
		dataType: 'json',
		type: "GET",
		data: function (params) {
			var queryParameters = {
			nm: params.term,
			noMesin: $('#txtNoMesinTSKK').val()
			}
	return queryParameters;
		},
		processResults: function (noMesin) {
	return {
		results: $.map(noMesin, function(obj) {
	return { id:obj.NO_MESIN, text:obj.NO_MESIN };
					})
				};
			}
		}
	});
});

//AUTOFILL JENIS MESIN//
$('#txtNoMesinTSKK').change(function(){
	var isiNoMesin = $('.noMesin').val();

	if (isiNoMesin !== null) {
		$.ajax({
			type: "POST",
			url: baseurl+'GeneratorTSKK/C_GenTSKK/jenisMesin/',
			dataType: "json",
			data:{
				params:isiNoMesin
			},
			beforeSend: e => {
				if(e && e.overrideMimeType) {
					e.overrideMimeType("application/json;charset=UTF-8");
				}
			},
			success: res => {
				console.log(res);
				$('.jenisMesin').val(res);
			},
			error: function (xhr) {
			alert(xhr.responseText);
				}
			});
	}else{
		$('.jenisMesin').val('');
	}

});

//AUTOFILL RESOURCE MESIN//
$('#txtNoMesinTSKK').change(function(){
	var isiNoMesin = $('.noMesin').val();
	console.log(isiNoMesin);

	if (isiNoMesin !== null) {

		$.ajax({
			type: "POST",
			url: baseurl+'GeneratorTSKK/C_GenTSKK/resourceMesin/',
			dataType: "json",
			data:{params: $(this).val() },
			beforeSend: e => {
			if(e && e.overrideMimeType) {
				e.overrideMimeType("application/json;charset=UTF-8");
			}
		},
		success: res => {
			console.log(res);
			$('.resource').val(res);
		},
		error: function (xhr) {
		alert(xhr.responseText);
			}
		});
	}else{
		$('.resource').val('');
	}

});

//SELECT ALAT BANTU//
$(document).ready(function() {
	$("#txtAlatBantu").select2({
		minimumInputLength: 3,
		maximumSelectionLength: 3,
		ajax: {
		url:baseurl+'GeneratorTSKK/C_GenTSKK/AlatBantu/',
		dataType: 'json',
		type: "GET",
		data: function (params) {
			var queryParameters = {
			ab: params.term,
			alatBantu: $('#txtAlatBantu').val()
			}
	return queryParameters;
		},
		processResults: function (alatBantu) {
	return {
		results: $.map(alatBantu, function(obj) {
	return { id:obj.fs_nm_tool, text:obj.fs_nm_tool }; //njg
					})
				};
			}
		}
	});
});

//SELECT TOOLS//
$(document).ready(function() {
	$("#txtTools").select2({
		minimumInputLength: 3,
		maximumSelectionLength: 5,
		ajax: {
		url:baseurl+'GeneratorTSKK/C_GenTSKK/Tools/',
		dataType: 'json',
		type: "GET",
		data: function (params) {
			var queryParameters = {
			tl: params.term,
			tools: $('#txtTools').val()
			}
	return queryParameters;
		},
		processResults: function (tools) {
	return {
		results: $.map(tools, function(obj) {
	return { id:obj.DESCRIPTION, text:obj.DESCRIPTION }; //njg
					})
				};
			}
		}
	});
});

//SELECT SEKSI//
$(document).ready(function(){
	$("#pilihseksi").select2({
		minimumInputLength: 3,
		ajax: {
		url:baseurl+'GeneratorTSKK/C_GenTSKK/Seksi/',
		dataType: 'json',
		type: "GET",
		data: function (params) {
		var queryParameters = {
			term: params.term,
			seksi: $('#pilihseksi').val()
		}
	return queryParameters;
		},
		processResults: function (seksi) {
	return {
		results: $.map(seksi, function(obj) {
	return { id:obj.SEKSI_PENGEBON, text:obj.SEKSI_PENGEBON};
					})
				};
			}
		}
	});
});

//SELECT MESIN//
// $(document).ready(function(){
// 	$("#txtMesin").select2({
// 		minimumInputLength: 3,
// 		ajax: {
// 		url:baseurl+'GeneratorTSKK/C_GenTSKK/Mesin/',
// 		dataType: 'json',
// 		type: "GET",
// 		data: function (params) {
// 		var queryParameters = {
// 			mach: params.term,
// 			mesin: $('#txtMesin').val()
// 		}
// 	return queryParameters;
// 		},
// 		processResults: function (mesin) {
// 	return {
// 		results: $.map(mesin, function(obj) {
// 	return { id:obj.ATTRIBUTE1, text:obj.ATTRIBUTE1};
// 					})
// 				};
// 			}
// 		}
// 	});
// });

//SELECT OPERATOR//
$(document).ready(function() {
	$("#txtOperator").select2({
		minimumInputLength: 3,
		ajax: {
		url:baseurl+'GeneratorTSKK/C_GenTSKK/Operator/',
		dataType: 'json',
		type: "GET",
		data: function (params) {
			var queryParameters = {
			opr: params.term,
			operator: $('#txtOperator').val()
			}
	return queryParameters;
		},
		processResults: function (operator) {
	return {
		results: $.map(operator, function(obj) {
			// id:obj.noind+' - '+obj.nama, text:obj.noind+' - '+obj.nama
	return { id:obj.nama+' - '+obj.noind, text:obj.nama+' - '+obj.noind };
					})
				};
			}
		}
	});
});

//SELECT ELEMEN KERJA 1//
$(document).ready(function() {
	$('.slcElemen').select2({
		// minimumInputLength: 3,
		ajax: {
		url:baseurl+'GeneratorTSKK/C_GenTSKK/ElemenKerja/',
		dataType: 'json',
		type: "GET",
		data: function (params) {
			var queryParameters = {
			elk: params.term,
			elm_krj: $('#slcElemen').val()
			}
	return queryParameters;
		},
		processResults: function (data) {
			console.log(data)
	return {
		results: $.map(data, function(obj) {
	return { id:obj.elemen_kerja, text:obj.elemen_kerja };
					})
				};
			}
		}
	});
});

//AUTO FILL FOR GENERATE MENU
function myAutomatically(no){
	var num = Number(no) - 1;
	console.log("ini num : ", num, "ini no : ", no);

	var oldJenis= $('#slcJenis_' + no).val()
	var elemen = $('#elemen_'+num).val()
	var keterangan = $('#slcElemen_'+num).val()

	if(oldJenis == 'AUTO'){
		var Element = `<option value="${keterangan}">${keterangan}</option>`;
		$('#slcElemen_' + no).append(Element)

		$('#elemen_'+ no).val(elemen)
		$('#slcTipeUrutan_' + no).val('SERIAL');
		$('#slcTipeUrutan_' + no).trigger('change');
		$('#slcElemen_'+ no).val(keterangan);
		$('#slcElemen_' + no).trigger('change');
	}else if(oldJenis == 'MANUAL'){
		$('#slcElemen_' + no).val(null).trigger('change'); 		 //temporary on
		$('#elemen_'+no).val('');
		$('#slcTipeUrutan_' + no).val(null).trigger('change');
	}else if(oldJenis == 'WALK'){
		$('#slcElemen_' + no).val(null).trigger('change'); 		 //temporary on
		$('#elemen_'+no).val('');
		$('#slcTipeUrutan_' + no).val('SERIAL').trigger('change');
	}else if(oldJenis == 'WALK (Inheritance)'){
		var Element = `<option value="${keterangan}">${keterangan}</option>`;
		$('#slcElemen_' + no).append(Element)

		$('#elemen_'+no).val(elemen)
		$('#slcTipeUrutan_' + no).val('SERIAL');
		$('#slcTipeUrutan_' + no).trigger('change');
		$('#slcElemen_'+no).val(keterangan);
		$('#slcElemen_' +no).trigger('change');
	}
}

//COUNT FINISH FOR THE FIRST ROW//
function setFinishGTSKK(no){
	console.log("clicked", no)
	if(no == 1){
		var waktu = $('#waktu_'+no).val()
		// console.log(waktu, 'uye')
		$('#finish_'+no).val(waktu)
		$('#finish_'+no).prop('readonly', true);
	}else{
		var waktu = $('#waktu_'+no).val()
		var mulai = $('#mulai_'+no).val()

		$('#finish_'+no).val(Number(waktu) + Number(mulai) - 1)
		$('#finish_'+no).prop('readonly', true);
	}
}

$('#waktu').keyup(function(){
	var waktu = $('#waktu').val()

	console.log(waktu)
	var mulai = 0;
	var hasil = Number(waktu) + Number(mulai);

	$('#finish').click(function(){
		console.log("finish diklik")
		$('#finish').val(hasil)
	})
})

//AUTOFILL ELEMENT FOR EDIT MENU//
function myFunctionTSKK(th){

		var row_index = $(th).parent().parent('tr').index();
		var oldRow = Number(row_index) - 1;
		var oldJenis= $('table tbody tr:nth('+oldRow+') td .select4').val();
		console.log(row_index, oldJenis)

		var elemen = $('table tbody tr:nth('+row_index+') td .select4').val();
		var elemen_kerja = $('table tbody tr:nth('+oldRow+') td .slcElemen').val();
		var keterangan = $('table tbody tr:nth('+oldRow+') td .elemen').val();
		console.log(elemen, elemen_kerja, keterangan)

		if (elemen != null) {
			$('table tbody tr:nth('+row_index+') td .wDistribusi').attr('readonly', false);
			// $('.wDistribusi').attr('readonly', false);
		}

		if(elemen == 'AUTO (Inheritance)') {
			var Element = `<option value="${elemen_kerja}">${elemen_kerja}</option>`;
			$('table tbody tr:nth('+row_index+') td .slcElemen').append(Element); //auto isi elemen kerja
			$('table tbody tr:nth('+row_index+') td .slcElemen').trigger('change');
			$('table tbody tr:nth('+row_index+') td .elemen').val(keterangan);   //auto isi keterangan
			$('table tbody tr:nth('+row_index+') td .tipe_urutan').val('SERIAL');
			$('table tbody tr:nth('+row_index+') td .tipe_urutan').trigger('change');
		// console.log("ini element: ", Element, elemen, elemen_kerja, keterangan)
		}else if(elemen == 'AUTO'){ //how to make it works completely?
			$('table tbody tr:nth('+row_index+') td .slcElemen').val(null).trigger('change');
			$('table tbody tr:nth('+row_index+') td .elemen').val('');
			$('table tbody tr:nth('+row_index+') td .tipe_urutan').val(null).trigger('change');
		}else if(elemen == 'MANUAL'){ //how to make it works completely?
			$('table tbody tr:nth('+row_index+') td .slcElemen').val(null).trigger('change');
			$('table tbody tr:nth('+row_index+') td .elemen').val('');
			$('table tbody tr:nth('+row_index+') td .tipe_urutan').val(null).trigger('change');
		}else if(elemen == 'WALK'){	//how to make it works completely?
			$('table tbody tr:nth('+row_index+') td .slcElemen').val(null).trigger('change');
			$('table tbody tr:nth('+row_index+') td .elemen').val('');
			$('table tbody tr:nth('+row_index+') td .tipe_urutan').val('SERIAL').trigger('change');
		}else if(elemen == 'WALK (Inheritance)'){
			var Element = `<option value="${elemen_kerja}">${elemen_kerja}</option>`;
			$('table tbody tr:nth('+row_index+') td .slcElemen').append(Element); //auto isi elemen kerja
			$('table tbody tr:nth('+row_index+') td .slcElemen').trigger('change');
			$('table tbody tr:nth('+row_index+') td .elemen').val(keterangan);   //auto isi keterangan
			$('table tbody tr:nth('+row_index+') td .tipe_urutan').val('SERIAL');
			$('table tbody tr:nth('+row_index+') td .tipe_urutan').trigger('change');
		}
	}

//SET THE FINISH AND START FOR EDIT PAGE
function newFinish(th) {
	var row_index = $(th).parent().parent('tr').index();
	var oldRow = Number(row_index) - 1;
	var start = 0;
	var oldFinish = $('table tbody tr:nth('+oldRow+') td .finish').val();
	var countRow = $('table tbody tr').length;
	var waktu = $('table tbody tr:nth('+row_index+') td .waktu').val()
	var mulai = $('table tbody tr:nth('+row_index+') td .mulai').val()
	var tu = $('table tbody tr:nth('+row_index+') td .tipe_urutan').val();

	//set first row with value = 1
	if (row_index == 0 && tu == 'SERIAL'){
		var finish = Number(waktu) + Number(mulai) - 1;
	}else if (row_index != 0 && tu == 'SERIAL'){
		var finish = Number(waktu) + Number(oldFinish);
	}else if (row_index != 0 && tu == 'PARALEL'){
		var finish = Number(waktu) + Number(mulai) - 1;
	}

	$('table tbody tr:nth('+row_index+') td .finish').val(finish)
	$('table tbody tr:nth('+row_index+') td .finish').trigger('change')

	for (let index = row_index + 1; index < countRow ; index++) {
		var urutan = $('table tbody tr:nth('+index+') td .tipe_urutan').val();
		var proses = $('table tbody tr:nth('+index+') td .select4').val();

		if (urutan == 'PARALEL'){
			break;
		}

		var oldFinish = $('table tbody tr:nth('+(index - 1)+') td .finish').val();
		var prosesAtas = $('table tbody tr:nth('+(index - 1)+') td .select4').val();
		var startBfr = $('table tbody tr:nth('+(index - 1)+') td .mulai').val();

		//KALO GINI JADI GITU, KALO GITU JADI GINI :)
		if (prosesAtas == 'AUTO'){
			$('table tbody tr:nth('+Number(index)+') td .mulai').val(Number(startBfr));
		}else{
			$('table tbody tr:nth('+index+') td .mulai').val(Number(oldFinish) + 1);
		}

		var start = $('table tbody tr:nth('+(index)+') td .mulai').val()
		var waktu = $('table tbody tr:nth('+index+') td .waktu').val();

		// console.log(oldFinish)
		$('table tbody tr:nth('+(index)+') td .finish').val((Number(start) + Number(waktu)) - 1);
		// console.log(Number(start) + Number(waktu), "finish")
		console.log(start)
	}
	// console.log("end", countRow)
}

//SET START AND FINISH FOR TABLE ELEMENT//
function finishTableElement(th) {

	var curr_row = $(th).parent().parent('tr');
	var nextRow = curr_row.next();
	// console.log(nextRow, "ini next rownya");

	var w_now = curr_row.children().children('.waktu').val();
	var s_now = curr_row.children().children('.mulai').val();
	// var f_now = curr_row.children().children('.finish').val();
	var takt_time = $('#inputInsert').val();
	let finishNow = curr_row.children('td').children('.finish');
	let finishRN = Number(w_now) + Number(s_now) - 1;

	finishNow.val(Number(finishRN));

	//ngitung finish kena takt time = finish now - takt time
// 	if (finishRN > takt_time) {
// 		let finish = Number(finishRN) - Number(takt_time);
// 	finishNow.val(Number(finish));
// console.log("ini finish lebih dari takt time AWAL: ", finish);
// 	}else{
// 		let finish = Number(w_now)+Number(s_now)-1
// 	finishNow.val(Number(finish));
// console.log("ini finish kurang dari takt time AWAL: ", finish);
// 	}

	// finishNow.val(finish); //set finish at current row that being clicked

	var maxRow = $('.position').length;
	var indexRow = nextRow.find('.position').html();

	for (let index = indexRow; index < (maxRow + 1); index++) {

		// const curr_row = $(th).parent().parent('tr');
		// const nextRow = curr_row.next();
		const prevRow = nextRow.prev();
		// console.log(prevRow, "ini prevRow");
		// console.log(nextRow, "ini next rownya");

		let tu = nextRow.children('td').children('.tipe_urutan').val();
		// console.log("ini tipe urutannya gan: ", tu);

		if(tu == "PARALEL"){
			break;
		}

		let prevFinish = prevRow.children('td').children('.finish').val();  //get the previous finish
		let nextFinish = nextRow.children('td').children('.finish').val();  //get the NEXT finish
		let prevStart = prevRow.children('td').children('.mulai').val();	//get the previous start
		let currFinish = nextRow.children('td').children('.finish');
		let currStart = nextRow.children('td').children('.mulai');
		let currWaktu = nextRow.children('td').children('.waktu').val();
		let currMulai = nextRow.children('td').children('.mulai').val();
		let jp = prevRow.children('td').children('.select4').val();
		// console.log(jp);

		let finish1 = Number(currWaktu) + Number(prevStart) - 1;
		let finishAI = Number(currWaktu) + Number(currMulai) - 1;
		let startRN = (Number(prevFinish) + 1)
		let finish2 = Number(currWaktu) + Number(startRN) - 1;

		if (jp == "AUTO (Inheritance)" && finish1 > takt_time) {
			// let finish = Number(finish1) - Number(takt_time)
			let finish = Number(finish1)
			// let finish = Number(prevFinish) - Number(takt_time)  //
				console.log("ini finish kurang dari takt time: ", finish);

				if (finish < 0) {
					finish = Number(currWaktu) + Number(prevStart) - 1;
				}

			currStart.val(Number(prevStart));
			currFinish.val(finish);
			console.log("AI > TAKT TIME");
		}else if (jp == "AUTO (Inheritance)" && finish1 < takt_time) {
			let finish = Number(finsih1)
				console.log("ini finish kurang dari takt time: ", finish);
			currStart.val(Number(prevStart));
			currFinish.val(finish);
				console.log("AI < TAKT TIME");
		}else if (jp != "AUTO (Inheritance)" && finish1 > takt_time) {
			// let finish = Number(finish2)
			// let finish = Number(finish2) - Number(takt_time)
			let finish = Number(finish2)
				console.log("ini finish lebih dari takt time: ", finish);
				console.log(nextFinish, "dikurangi" , takt_time);
				console.log("finishAI :", currWaktu, "ditambah", currMulai);
				console.log("finishYGBENAR :", currWaktu, "ditambah", finish2);
				console.log("finish 2: ", finish2);

			if (finish < 0) {
				finish = Number(currWaktu) + Number(startRN) - 1;
			}

			currStart.val(startRN);
			currFinish.val(finish);
				console.log("BUKAN AI > TAKT TIME");
		}else{
			let finish = Number(finish2)
				console.log("ini finish kurang dari takt time: ", finish);
			currStart.val(startRN);
			currFinish.val(finish);
				console.log("BUKAN AI < TAKT TIME");
		}
		nextRow = nextRow.next()
	}
}

//DELETE THE ELEMENT FROM EDIT MENU
function newDeletion(th) {
	var curr_row = $(th).parent().parent('tr');
	var prevRow = curr_row.prev();
	var nextRow = curr_row.next();
	//remove row
	curr_row.remove();

	$('.posisi').each((i, item) => {
		document.getElementsByClassName('posisi')[i].innerHTML = i + 1
	})

	var maxRow = $('.posisi').length;
	var indexRow = nextRow.children('td.posisi').html()

	for (let index = indexRow; index < (maxRow + 1); index++) {
		console.log(index);
		let tu = nextRow.children('td').children('.tipe_urutan').val();

		if(tu == "PARALEL"){
			break;
		}

		let prevFinish = prevRow.children('td').children('.finish').val();
		let prevStart = prevRow.children('td').children('.mulai').val();
		let currFinish = nextRow.children('td').children('.finish');
		let currStart = nextRow.children('td').children('.mulai');
		let currWaktu = nextRow.children('td').children('.waktu').val();
		let jp = prevRow.children('td').children('.select4').val();

		let indexNow = nextRow.children('td').children('.posisi').html();
		let waktuNow = curr_row.children('td').children('.waktu').val();
		console.log("index yg dihapus : ", indexNow);
		console.log("waktu now : ", waktuNow);

		if (index == 1){

			currStart.val(Number(1))
			currFinish.val(Number(currWaktu))

			prevRow = nextRow
			nextRow = nextRow.next()
			continue;
		}

		if (jp == "AUTO") {
			let finish = Number(currWaktu) + Number(prevStart);
			currStart.val(Number(prevStart))
			currFinish.val(finish)
		}else{
			let finish = Number(currWaktu) + Number(prevFinish);
			currStart.val(Number(prevFinish) + 1)
			currFinish.val(finish)
		}

		nextRow = nextRow.next()
		prevRow = prevRow.next()
		console.log(index, prevFinish);
	}
}

//INSERT ROW TO TABLE
function attachRow() {
	var posisi = $('#inputInsert').val();
	var maxRow = $('#tblEditTSKK tbody tr').length;
	var indx = posisi - 1;
	var index = posisi + 1;

	var newRow = $(`
	<tr class = "number_${num}">
		<td class="posisi"> ${posisi} </td>
		<td>
			<select id="slcJenis_${num}" name="slcJenisProses[]" onchange="myFunctionTSKK(this)" class="form-control select4 slcJenisProses_num" style="width:100%;" onFocus="onBakso()" title="Jenis Proses"><option value=""> </option><option value="MANUAL" id="manual"> MANUAL </option><option value="AUTO" id="auto" onclick="setElemenGTSKK()"> AUTO </option><option value="WALK" id="walk"> WALK </option><option value="WALK (Inheritance)" id="walk"> WALK (Inheritance) </option></select>
		</td>
		<td>
			<select class="form-control select2 slcElemen" id="slcElemen_${num}" name="txtSlcElemen[]" data-placeholder="Input Elemen Kerja" tabindex="-1" aria-hidden="true"></select><input type="text" class="form-control elemen" style="width: 100%" type="text" id="elemen_${num}" name="elemen[]" placeholder="Input Keterangan">
		</td>
		<td>
			<select id="slcTipeUrutan_${num}" name="slcTipeUrutan[]" class="form-control tipe_urutan" style="width:100%;" onchange="AutomaticTime(this)" title="Tipe Urutan Proses"><option value="" >  </option><option value="SERIAL"> SERIAL  </option><option value="PARALEL"> PARALEL </option></select>
		</td>
		<td>
			<input type="number" class="form-control waktu" style="width: 100%" type="text" onchange="newFinish(this)"  id="waktu_${num}" name="waktu[]" placeholder="Detik">
		</td>
		<td>
			<input type="number" class="form-control mulai" style="width: 100%" type="text" id="mulai_${num}" name="mulai[]" placeholder="Detik">
		</td>
		<td>
			<input type="number" class="form-control finish" style="width: 100%" type="text"  id="finish_${num}" name="finish[]" placeholder="Detik">
		</td>
		<td>
			<i class="fa fa-times fa-2x" style="color:red" id="hapus" title="Hapus Elemen" onclick="newDeletion(this)"></i>
		</td>
	</tr>
	`);

	if( indx < maxRow){
		newRow.insertBefore($('.tblEditTSKK tbody tr:nth('+indx+')'));

		//set the auto increment sequence for edit page//
		$('.posisi').each((i, item) => {
			document.getElementsByClassName('posisi')[i].innerHTML = i + 1
		})
		//set the auto increment sequence for edit page//

			$('.select4').select2({
				placeholder: 'Jenis Proses',
				allowClear: true,
			});

			$('.tipe_urutan').select2({
				placeholder: 'Tipe Urutan',
				allowClear: true,
				});

			$('.slcElemen').select2({
				placeholder: 'Keterangan Elemen',
				allowClear: true,
				});

				$('.slcElemen').select2({
					// minimumInputLength: 3,
					ajax: {
					url:baseurl+'GeneratorTSKK/C_GenTSKK/ElemenKerja/',
					dataType: 'json',
					type: "GET",
					data: function (params) {
						var queryParameters = {
						elk: params.term,
						elm_krj: $('#slcElemen').val()
						}
				return queryParameters;
					},
					processResults: function (data) {
						console.log(data)
				return {
					results: $.map(data, function(obj) {
				return { id:obj.elemen_kerja, text:obj.elemen_kerja };
								})
							};
						}
					}
				});

	}else{
		$('.tblEditTSKK tbody').append(newRow)

		console.log("ini after", newRow)

			$('.select4').select2({
				placeholder: 'Jenis Proses',
				allowClear: true,
			});

			$('.tipe_urutan').select2({
				placeholder: 'Tipe Urutan Proses',
				allowClear: true,
				});

			$('.slcElemen').select2({
				placeholder: 'Input Keterangan',
				allowClear: true,
			});

			$('.slcElemen').select2({
				// minimumInputLength: 3,
				ajax: {
				url:baseurl+'GeneratorTSKK/C_GenTSKK/ElemenKerja/',
				dataType: 'json',
				type: "GET",
				data: function (params) {
					var queryParameters = {
					elk: params.term,
					elm_krj: $('#slcElemen').val()
					}
			return queryParameters;
				},
				processResults: function (data) {
					console.log(data)
			return {
				results: $.map(data, function(obj) {
			return { id:obj.elemen_kerja, text:obj.elemen_kerja };
							})
						};
					}
				}
			});
	}

	console.log("add new line",  indx, maxRow)
	console.log(newRow)
}

//INSERT ROW TO TABLE OBSERVATION
function attachRowObservation() {
	var posisi = $('#inputInsertPosiition').val();
	var maxRow = $('#tblObservasiEdit tbody tr').length;
	var indx = posisi - 1;
	var index = posisi + 1;
	// name="checkBoxParalel['+(nomor-1)+']"
	var newRow = $(`
	<tr class = "number_${num}">
		<td class="posisi"> ${posisi} </td>
		<td>
		<input type="checkbox" name="checkBoxParalel[${indx}]" value="PARALEL" class="checkBoxParalel" onchange="//chckParalel(this)">
		</td>
		<td>
		<select id="slcJenis_'+nomor+'" onchange="myFunctionTSKK(this)" name="slcJenisProses[]" class="form-control select4" id="" style="width:100%;" title="Jenis Proses" >';
		<option value=""> </option>';
		<option value="MANUAL" id="manual"> MANUAL </option>';
		<option value="AUTO" id="auto" onclick="setElemenGTSKK()"> AUTO </option>';
		<option value="WALK" id="walk"> WALK </option>';
		</select>
		</td>
		<td>
		<div class="col-lg-12"><div class="col-lg-6"><select class="form-control select2 slcElemen" id="slcElemen_'+nomor+'" name="txtSlcElemen[]" data-placeholder="Elemen" tabindex="-1" aria-hidden="true"></select></div><div class="col-lg-6"><input type="text" class="form-control elemen" style="width: 100%" type="text" id="elemen_'+nomor+'" name="elemen[]" placeholder="Keterangan Elemen"></div></div>
		</td>
		<td>
		<input type="number" onchange="minMaxId(this)" name="waktu1[]" class="form-control waktuObs inputWaktuKolom1" placeholder="Detik">
		</td>
		<td>
		<input type="number" onchange="minMaxId(this)"  name="waktu2[]" class="form-control waktuObs inputWaktuKolom2" placeholder="Detik">
		</td>
		<td>
		<input type="number" onchange="minMaxId(this)"  name="waktu3[]" class="form-control waktuObs inputWaktuKolom3" placeholder="Detik">
		</td>
		<td>
		<input type="number" onchange="minMaxId(this)"  name="waktu4[]" class="form-control waktuObs inputWaktuKolom4" placeholder="Detik">
		</td>
		<td>
		<input type="number" onchange="minMaxId(this)"  name="waktu5[]" class="form-control waktuObs inputWaktuKolom5" placeholder="Detik">
		</td>
		<td>
		<input type="number" onchange="minMaxId(this)"  name="waktu6[]" class="form-control waktuObs inputWaktuKolom6" placeholder="Detik">
		</td>
		<td>
		<input type="number" onchange="minMaxId(this)"  name="waktu7[]" class="form-control waktuObs inputWaktuKolom7" placeholder="Detik">
		</td>
		<td>
		<input type="number" onchange="minMaxId(this)"  name="waktu8[]" class="form-control waktuObs inputWaktuKolom8" placeholder="Detik">
		</td>
		<td>
		<input type="number" onchange="minMaxId(this)"  name="waktu9[]" class="form-control waktuObs inputWaktuKolom9" placeholder="Detik">
		</td>
		<td>
		<input type="number" onchange="minMaxId(this)" name="waktu10[]" class="form-control waktuObs inputWaktuKolom10" placeholder="Detik">
		</td>
		<td>
		<input type="number" id="xmin_".$no name="xmin[]" class="form-control xmin" placeholder="Detik" readonly>
		</td>
		<td>
		<input type="number" id="range_".$no name="range[]" class="form-control range" placeholder="Detik" readonly>
		</td>
		<td>
		<input type="number" onchange="minMaxId(this)" id="wDistribusi_".$no name="wDistribusi[]" class="form-control wDistribusi" placeholder="Detik">
		</td>
		<td>
		<input type="number" onchange="minMaxId(this)" onclick="checkDistributionTime(this)" name="wDistribusiAuto[]" class="form-control wDistribusiAuto" placeholder="Detik" readonly>
		</td>
		<td>
		<input type="number" id="wKerja_".$no name="wKerja[]" class="form-control wKerja" placeholder="Detik" readonly>
		</td>
		<td>
		<input type="text" id="keterangan_".$no name="keterangan[]" class="form-control keterangan" placeholder="Input Keterangan">
		</td>
		<td>
		<i class="fa fa-times fa-2x" onclick="deleteObserve(this)" style="color:red" id="hapus" title="Hapus Elemen"></i>
		</td>
	</tr>
	`);

	if( indx < maxRow){
		newRow.insertBefore($('#tblObservasiEdit tbody tr:nth('+indx+')'));

		//set the auto increment sequence for edit page//
		$('.posisi').each((i, item) => {
			document.getElementsByClassName('posisi')[i].innerHTML = i + 1
		})
		//set the auto increment sequence for edit page//

			$('.select4').select2({
				placeholder: 'Jenis Proses',
				allowClear: true,
			});

			$('.tipe_urutan').select2({
				placeholder: 'Tipe Urutan',
				allowClear: true,
				});

			$('.slcElemen').select2({
				placeholder: 'Keterangan Elemen',
				allowClear: true,
				});

				$('.slcElemen').select2({
					// minimumInputLength: 3,
					ajax: {
					url:baseurl+'GeneratorTSKK/C_GenTSKK/ElemenKerja/',
					dataType: 'json',
					type: "GET",
					data: function (params) {
						var queryParameters = {
						elk: params.term,
						elm_krj: $('#slcElemen').val()
						}
				return queryParameters;
					},
					processResults: function (data) {
						console.log(data)
				return {
					results: $.map(data, function(obj) {
				return { id:obj.elemen_kerja, text:obj.elemen_kerja };
								})
							};
						}
					}
				});

				$('input').iCheck({
					checkboxClass: 'icheckbox_flat-blue',
					radioClass: 'iradio_flat-blue'
				});

	}else{
		$('#tblObservasiEdit tbody').append(newRow)

		console.log("ini after", newRow)

			$('.select4').select2({
				placeholder: 'Jenis Proses',
				allowClear: true,
			});

			$('.tipe_urutan').select2({
				placeholder: 'Tipe Urutan',
				allowClear: true,
				});

			$('.slcElemen').select2({
				placeholder: 'Input Keterangan',
				allowClear: true,
			});

			$('.slcElemen').select2({
				// minimumInputLength: 3,
				ajax: {
				url:baseurl+'GeneratorTSKK/C_GenTSKK/ElemenKerja/',
				dataType: 'json',
				type: "GET",
				data: function (params) {
					var queryParameters = {
					elk: params.term,
					elm_krj: $('#slcElemen').val()
					}
			return queryParameters;
				},
				processResults: function (data) {
					console.log(data)
			return {
				results: $.map(data, function(obj) {
			return { id:obj.elemen_kerja, text:obj.elemen_kerja };
							})
						};
					}
				}
			});

			$('input').iCheck({
				checkboxClass: 'icheckbox_flat-blue',
				radioClass: 'iradio_flat-blue'
			});
	}

	$('.checkBoxParalel').each((i, v) =>{
		$(v).attr('name', `checkBoxParalel[${i}]`)
	})

	console.log("add new line",  indx, maxRow)
	console.log(newRow)

}

	//Edit Time Set Auto Start//
	function AutomaticTime(th) {
		var row_index = $(th).parent().parent('tr').index();
		var oldRow = Number(row_index) - 1;
		var tu = $('table tbody tr:nth('+row_index+') td .tipe_urutan').val()
		var endTime = $('table tbody tr:nth('+oldRow+') td .finish').val();
		console.log(tu, ': ini tipe urutan');
		console.log(endTime, ': ini finish sblm');
		var jnsProses = $('table tbody tr:nth('+row_index+') td .select4').val();
		console.log(jnsProses, ': jenis prosesnya');

		var waktuSblm = $('table tbody tr:nth('+oldRow+') td .waktu').val()
		console.log("Ini waktu elemen sebelumnya : ", waktuSblm);

		var jnsProsesBfr = $('table tbody tr:nth('+oldRow+') td .select4').val();
		console.log("Ini jenis proses sebelumnya : ", jnsProsesBfr);

			var waktuSkrg = $('table tbody tr:nth('+row_index+') td .waktu').val();
			console.log("Ini waktuSkrg : ", waktuSkrg);

			var startSkrg = $('table tbody tr:nth('+row_index+') td .mulai').val();
			console.log("Ini startSkrg : ", startSkrg);

		if(tu == "SERIAL" && jnsProses == "MANUAL" && jnsProsesBfr == "AUTO"){
			$('table tbody tr:nth('+row_index+') td .mulai').val(Number(endTime) + 1 - Number(waktuSblm));
			$('table tbody tr:nth('+row_index+') td .mulai').trigger("change");
			$('table tbody tr:nth('+row_index+') td .finish').prop('readonly', true);

		}else if (tu == "SERIAL" && jnsProses != 'WALK (Inheritance)' && jnsProses != 'WALK'){
			$('table tbody tr:nth('+row_index+') td .mulai').val(Number(endTime) + 1);
			$('table tbody tr:nth('+row_index+') td .mulai').trigger("change");
			$('table tbody tr:nth('+row_index+') td .finish').prop('readonly', true);

		}else if(tu == "SERIAL" && jnsProses == "WALK (Inheritance)" && jnsProsesBfr == "MANUAL"){
			$('table tbody tr:nth('+row_index+') td .mulai').val(Number(endTime) + 1);
			$('table tbody tr:nth('+row_index+') td .mulai').trigger("change");
			$('table tbody tr:nth('+row_index+') td .finish').prop('readonly', true);

		}else if(tu == "SERIAL" && jnsProses == "WALK" && jnsProsesBfr == "MANUAL"){
			$('table tbody tr:nth('+row_index+') td .mulai').val(Number(endTime) + 1);
			$('table tbody tr:nth('+row_index+') td .mulai').trigger("change");
			$('table tbody tr:nth('+row_index+') td .mulai').prop('readonly', true);

		}else if(tu == "SERIAL" && jnsProses == "WALK" && jnsProsesBfr == "WALK (Inheritance)"){
			$('table tbody tr:nth('+row_index+') td .mulai').val(Number(endTime) + 1);
			$('table tbody tr:nth('+row_index+') td .mulai').trigger("change");
			$('table tbody tr:nth('+row_index+') td .mulai').prop('readonly', true);

		//if WALK INHERITANCE and WALK, the start value will as same as AUTO
		}else if (tu == "SERIAL" && jnsProses == 'WALK (Inheritance)' || jnsProses == 'WALK'){
			$('table tbody tr:nth('+row_index+') td .mulai').val(Number(endTime) + 1 - Number(waktuSblm))
			$('table tbody tr:nth('+row_index+') td .mulai').prop('readonly', true);
			$('table tbody tr:nth('+row_index+') td .mulai').prop('readonly', true);
			$('table tbody tr:nth('+row_index+') td .finish').prop('readonly', true);

			console.log(endTime, 'ini endTime cuy');
			console.log(waktuSblm, 'ini waktuSblm cuy');

		}else{
			$('table tbody tr:nth('+row_index+') td .mulai').val("");
			$('table tbody tr:nth('+row_index+') td .mulai').trigger("change");
			$('table tbody tr:nth('+row_index+') td .mulai').prop('readonly', false);
			$('table tbody tr:nth('+row_index+') td .finish').val("");
			$('table tbody tr:nth('+row_index+') td .finish').trigger("change");
			$('table tbody tr:nth('+row_index+') td .finish').prop('readonly', false);

		}

		//bikin kalo nyelipin di urutan 1 maka startnya auto 1 uga
		var posisi = $('#inputInsert').val();
		var indx = posisi - 1;

		if (tu == "SERIAL" && jnsProses == 'MANUAL' && indx == 0){
			$('table tbody tr:nth('+row_index+') td .mulai').val(1);
			$('table tbody tr:nth('+row_index+') td .mulai').prop('readonly', true);

			console.log('masuk kondisi ini nich');
		}

		var oldJenis= $('table tbody tr:nth('+oldRow+') td .select4').val();
		console.log(row_index, oldJenis)

		var elemen = $('table tbody tr:nth('+row_index+') td .select4').val();
		var elemen_kerja = $('table tbody tr:nth('+oldRow+') td .slcElemen').val();
		var keterangan = $('table tbody tr:nth('+oldRow+') td .elemen').val();
		console.log(elemen, elemen_kerja, keterangan)
	}

//DELETE ROW'S ELEMENTS FROM ATTACHMENT ELEMENTS//
const onDeletefrAttach = (th) => {
	var row_index = $(th).parent().parent('tr').index();
	$('table tbody tr:nth('+row_index+')').remove();
	console.log(row_index, "bakso")
	}

//DELETE FROM EDIT TSKK MENU
const onClickDelete = (th) => {
	var row_index = $(th).parent().parent('tr').index();
	var id = $('table tbody tr:nth('+row_index+') td .iniID').val();
	var seq = $('table tbody tr:nth('+row_index+') td .iniSEQ').val();

		$.ajax({
		url: baseurl+'GeneratorTSKK/C_GenTSKK/deleteEdit/'+seq+'/'+id,
		type: 'POST',
		success: function(results){
			newDeletion(th)
		}
	});
}

//DELETE FROM LIST TSKK PAGE
const onClickDeleteEditPage = (th) => {
	var row_index = $(th).parent().parent('tr').index();
	var id = $('table tbody tr:nth('+row_index+') td .idView').val();
	console.log(row_index, "bakso")
	console.log(id, "INI ID")

		$.ajax({
		url: baseurl+'GeneratorTSKK/C_GenTSKK/deleteData/'+id,
		type: 'POST',
		success: function(results){
			$('table tbody tr:nth('+row_index+')').remove();
			}
		});
}

	function generateTSKK(a) {
		// alert('oke');
		//insert header//
		var id				 	= $('.idTSKK').val();
		var judul            	= $('.judul').val();
		//PART
		var type 	         	= $('.type').val();
		var kode_part        	= $('.kodepart').val();
		var nama_part        	= $('.namaPart').val();
		//EQUIPMENT
		var no_mesin		 	= $('.noMesin').val();
		var jenis_mesin      	= $('.jenisMesin').val();
		var resource      	 	= $('.resource').val();
		var line      	 	 	= $('.line').val();
		var alat_bantu       	= $('.txtAlatBantu').val();
		var tools       	 	= $('.tools').val();
		//SDM
		var nama         	 	= $('.txtOperator').val();
		var jumlah_operator  	= $('.jml_oprator').val();
		var dari_operator    	= $('.txtDari').val();
		var seksi            	= $('.pilihseksi').val();
		//PROCESS
		var proses           	= $('.process').val(); //asw
		var kode_proses      	= $('.kodeproses').val();
		var proses_ke        	= $('.proses_ke').val();
		var dari             	= $('.txtDariProses').val();
		var qty              	= $('.qty_proses').val();
		//ACTIVITY
		var tanggal          	= $('.txtTanggal').val();
		//TAKT TIME
		var waktu_satu_shift 	= $('.waktu1Shift').val();
		var jumlah_shift 		= $('.jumlahShift').val();
		var forecast 			= $('.forecast').val();
		var qty_unit 			= $('.qtyUnit').val();
		var rencana_kerja 		= $('.forecast').val();
		var jumlah_hari_kerja 	= $('.jumlahHariKerja').val();

		console.log(id, judul, type, kode_part, nama_part, no_mesin, jenis_mesin, resource,
			line, alat_bantu, tools,nama, jumlah_operator,dari_operator,seksi, proses, kode_proses, proses_ke,
			dari, tanggal, qty, waktu_satu_shift, jumlah_shift, rencana_kerja, jumlah_hari_kerja);

		var jenis_proses_elemen = [];
		$('input[name^=jenisProsesElemen]').each(function(){
			jenis_proses_elemen.push($(this).val());
		});
		console.log("jenis_proses_elemen:" ,jenis_proses_elemen);

		var elemen_kerja = [];
		$('input[name^=txtElemenKerja]').each(function(){
			elemen_kerja.push($(this).val());
		});
		console.log("elemen_kerja:" ,elemen_kerja);

		// var elemen_tskk = [];
		// $('select[name^=txtSlcElemen]').each(function(){
		// 	elemen_tskk.push($(this).val());
		// 	// alert($(this).val());
		// });
		// console.log("elemen_tskk:" ,elemen_tskk);

		var keterangan_elemen_kerja = [];
		$('input[name^=txtKeteranganElemenKerja]').each(function(){
			keterangan_elemen_kerja.push($(this).val());
		});
		console.log("keterangan_elemen_kerja:" ,keterangan_elemen_kerja);

		var tipe_urutan_elemen = [];
		$('input[name^=tipeUrutanElemen]').each(function(){
			tipe_urutan_elemen.push($(this).val());
			// alert($(this).val());
		});
		console.log("tipe_urutan_elemen:" ,tipe_urutan_elemen);

		var finish = [];
		$('input[name^=finish]').each(function(){
			finish.push($(this).val());
		});
		console.log("finish:" ,finish);

		var waktu = [];
		$('input[name^=waktuKerja]').each(function(){
			waktu.push($(this).val());
		});
		console.log("waktu:" ,waktu);

		var mulai = [];
		$('input[name^=mulai]').each(function(){
			mulai.push($(this).val());
		});
		console.log("mulai:" ,mulai);

		var irregular_job = [];
		$('input[name^=txtIrregularJob]').each(function(){
			irregular_job.push($(this).val());
		});
		console.log("irregular_job:" ,irregular_job);

		var ratio_ij = [];
		$('input[name^=txtRatioIrregular]').each(function(){
			ratio_ij.push($(this).val());
		});
		console.log("ratio_ij:" ,ratio_ij);

		var waktu_ij = [];
		$('input[name^=txtWaktuIrregular]').each(function(){
			waktu_ij.push($(this).val());
		});
		console.log("waktu_ij:" ,waktu_ij);

		var hasil_ij = [];
		$('input[name^=txtHasilWaktuIrregular]').each(function(){
			hasil_ij.push($(this).val());
		});
		console.log("hasil_ij:" ,hasil_ij);


		var takt_time = $('#inputInsert').val();
		console.log("takt time: ", takt_time);

		$('#loading').attr('hidden', false);
		$.ajax({
			type: "POST",
			data:{
			id						: id,
			judul			    	: judul,
			type		        	: type,
			kode_part		    	: kode_part,
			nama_part		    	: nama_part,
			no_mesin  		    	: no_mesin,
			jenis_mesin  		    : jenis_mesin,
			resource  		    	: resource,
			line  		    		: line,
			alat_bantu  		    : alat_bantu,
			tools  		    	    : tools,
			nama  		    	    : nama,
			jumlah_operator  		: jumlah_operator,
			dari_operator  		    : dari_operator,
			seksi			    	: seksi,
			proses			    	: proses,
			kode_proses		    	: kode_proses,
			proses_ke   	    	: proses_ke,
			dari			    	: dari,
			tanggal			    	: tanggal,
			qty				    	: qty,
			takt_time           	: takt_time,
			jenis_proses_elemen 	: jenis_proses_elemen,
			elemen_kerja        	: elemen_kerja,
			keterangan_elemen_kerja : keterangan_elemen_kerja,
			tipe_urutan_elemen 	    : tipe_urutan_elemen,
			mulai 	 		    	: mulai,
			finish 	 		    	: finish,
			waktu 	 		    	: waktu,
			irregular_job 	 		: irregular_job,
			ratio_ij 	 		    : ratio_ij,
			waktu_ij 	 		    : waktu_ij,
			hasil_ij 	 		    : hasil_ij,
			waktu_satu_shift        : waktu_satu_shift,
			jumlah_shift 			: jumlah_shift,
			forecast				: forecast,
			qty_unit				: qty_unit,
			rencana_kerja 			: rencana_kerja,
			jumlah_hari_kerja		: jumlah_hari_kerja
			},
			dataType: 'json',
			url: baseurl+'GeneratorTSKK/C_GenTSKK/exportExcel/',
			// cache:false,
			success:function(data){
					// console.log(result);
					// alert(data['url']);
					$('#loading').attr('hidden', true);
						window.open(baseurl+'assets/upload/GeneratorTSKK/'+data['url'], '_blank');
						$.ajax({
							url: baseurl+'GeneratorTSKK/C_GenTSKK/deleteFile/'+id,
							data:{
								judul:judul,
								tanggal:tanggal
							},
							type: 'POST'
						})
			},
			error: function (xhr, ajaxOptions, thrownError){
				console.log(xhr.responseText);
			}

		});
	}

//ENABLE READONLY AND DISABLED FROM HEADER AND OBSERVATION SHEET
$(document).ready(function(){
	$('#btnEdit').click(function(){
		$('.judul').prop('readonly', false);
		$('.taktTime').prop('readonly', false);
		$('.type').prop('readonly', false);
		$('.kodepart').prop('readonly', false);
		$('.namaPart').prop('readonly', false);
		$('.noAlat').prop('readonly', false);
		$('.pilihseksi').prop('readonly', false);
		$('.txtProses').prop('readonly', false);
		$('.kodeProses').prop('readonly', false);
		$('.txtMesin').prop('readonly', false);
		$('.txtProsesKe').prop('readonly', false);
		$('.txtDari').prop('readonly', false);
		$('.txtTanggal').prop('readonly', false);
		$('.txtQty').prop('readonly', false);
		$('.txtOperator').prop('readonly', false);
		$('.elemen').prop('readonly', false);
		$('.waktuObs').prop('readonly', false);
		$('input.wDistribusi').each(function(){
			var waktu_distribusi = $(this).val();
			console.log(waktu_distribusi);
			if(waktu_distribusi == ''){
				$(this).prop('readonly', true);
			}else{
				$(this).prop('readonly', false);
			}
		});
		$('.keterangan').prop('readonly', false);
		$('.select4').prop('disabled', false);
		$('.slcElemen').prop('disabled', false);
		$('.tipe_urutan').prop('disabled', false);
	});
});

function checkNilaiDistribusi(){
	var nilai_distribusi = $('#dst').val();
	console.log("nilai_distribusi: ", nilai_distribusi);

	if (nilai_distribusi > 0) {
		Swal.fire({
			type: 'error',
			title: 'Tidak Dapat Menyimpan Lembar Observasi!',
			text: 'Anda Harus Mendistribusikan Nilai Distribusi',
			// footer: '<a href>Why do I have this issue?</a>'
		})
		// $('#btnShow').click();
	}else{
		$('#btnHidden').click();
		return true;
	}
}

function checkNilaiDistribusiObservasi(){
	var nilai_distribusi = $('#dst').val();
	console.log("nd: ", nilai_distribusi);

	if (nilai_distribusi > 0) {
		Swal.fire({
			type: 'error',
			title: 'Tidak Dapat Menyimpan Lembar Observasi!',
			text: 'Anda Harus Mendistribusikan Nilai Distribusi',
			// footer: '<a href>Why do I have this issue?</a>'
		})
		// $('#btnSaveObservation').click();
	}else{
		$('#Observasi').submit();
		return true;
	}
}

// SELECT OPERATOR //
$(document).ready(function() {
	$("#pelaksanaReparasi").select2({
		minimumInputLength: 3,
		ajax: {
		url:baseurl+'TicketingMaintenance/C_OrderList/Pelaksana/',
		dataType: 'json',
		type: "GET",
		data: function (params) {
			var queryParameters = {
			pls: params.term,
			pelaksana: $('#pelaksanaReparasi').val()
			}
	return queryParameters;
		},
		processResults: function (pelaksana) {
	return {
		results: $.map(pelaksana, function(obj) {
    return { id:obj.noind+' - '+obj.nama, text:obj.noind+' - '+obj.nama };
					})
				};
			}
		}
	});
});

function detectSelectKodePart() {
	var kode_part = $('.kodepart').val();
	console.log(kode_part);
	if (kode_part == null) {
		$('.namaPart').attr('value', '');
	}
}

function AreYouSureWantToDelete(id){

	Swal.fire({
		title: 'Tunggu!',
		text: "Apakah Anda Yakin Ingin Menghapus?",
		type: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Yeah!'
	  }).then((result) => {
		if (result.value) {
			$.ajax({
				type: "POST",
				url: baseurl+'GeneratorTSKK/C_GenTSKK/deleteData/'+id,
				data:{
					id	: id
				},
				success:function(response){
					Swal.fire(
						'Done!',
						'Lembar Observasi Telah Terhapus',
						'success'
					),
					window.location.replace(baseurl+"GeneratorTSKK/Generate/");
				}
			});
		}
	  })
}

//ADD ROWS FOR IRREGULAR JOB//
var nmbr ="2";
function addRowIrregularJob(){
	// KOLOM 1
	var html = '<tr class="nmbr_'+nmbr+'"><td class="position" style="text-align:center;">'+nmbr+'</td>';
	console.log(nmbr);
	// KOLOM 2
	html += '<td style="text-align: center;"><input type="text" class="form-control irregularJob" name="txtIrregularJob[]" id="irregularJob" placeholder="Input Irregular Job"></td>'
	// KOLOM 3
	html += '<td style="text-align: center;"> <input type="number" onchange="countIrregularJobs(this)" style="text-align: center;" class="form-control ratio" name="txtRatioIrregular[]" id="ratio" placeholder="Input Ratio"></td>';
	// KOLOM 4
	html += '<td style="text-align: center;"> <input type="number" onchange="countIrregularJobs(this)" style="text-align: center;" class="form-control waktu" name="txtWaktuIrregular[]" id="waktu" placeholder="Input Waktu"></td>';
	// KOLOM 5
	html += '<td style="text-align: center;" class="hasilIrregularJob" id="hasilIrregularJob"><input type="text" style="text-align: center;" class="form-control hasilIrregularJob" name="txtHasilWaktuIrregular[]" placeholder="Hasil" readonly></td>';
	// KOLOM 6
	html += '<td style="text-align: center;"><i class="fa fa-times fa-2x deleteIrregularJob" id="deleteIrregularJob" onclick="deleteIrregularJobs(this)" style="color:red" title="Hapus Irregular Job"></i>&nbsp;&nbsp;<a class="fa fa-plus fa-2x fa-primary" onclick="addRowIrregularJob($(this))" title="Tambah Irregular Job"></td>';
	html += "</tr>";

	nmbr++;
	// console.log(html);

	$('#tbodyIrregularJob').append(html);

	$('.position').each((i, item) => {
		document.getElementsByClassName('position')[i].innerHTML = i + 1
	})
}

//DELETE CURRENT ROWS IN IRREGULAR JOBS//
function deleteIrregularJobs(th) {
	var curr_row = $(th).parent().parent('tr')
	console.log(curr_row)

	//remove row
	curr_row.remove();

	$('.position').each((i, item) => {
		document.getElementsByClassName('position')[i].innerHTML = i + 1
	})
}

//COUNT IRREGULAR JOBS//
function countIrregularJobs(a) {
	var ratio =  $(a).closest('tr').find('input.ratio').val()	  //GET THE RATIO
	var waktu =  $(a).closest('tr').find('input.waktu').val()	  //GET THE TIME

	// console.log('waktu ' + waktu + 'dibagi ' + 'rasio ' +  ratio);
	// console.log((Math.ceil(Number(waktu) / Number(ratio))));

	$(a).closest('tr').find('input.hasilIrregularJob').val(Math.ceil(Number(waktu) / Number(ratio)))	  //SET THE RESULT
}

//RENCANA PRODUKSI CALCULATION
function countRencanaProduksi() {
	var forecast 	= $('.forecast').val()
	var qty_unit 	= $('.qtyUnit').val()
	// console.log(forecast, qty_unit);

	$('.rencanaKerja').val(Number(forecast) * Number(qty_unit))
}

//TAKT TIME CALCULATION
function countTaktTime() {
	var waktu_satu_shift 	= $('.waktu1Shift').val();
	var jumlah_shift 		= $('.jumlahShift').val();
	var rencana_kerja 		= $('.rencanaKerja').val();
	var jumlah_hari_kerja 	= $('.jumlahHariKerja').val();
	// console.log(waktu_satu_shift + ',' + jumlah_shift + ',' + rencana_kerja + ',' + jumlah_hari_kerja);

	var a = Number(waktu_satu_shift) * Number(jumlah_shift)
	var b = Number(rencana_kerja) / Number(jumlah_hari_kerja)
	var result = Number(a) / Number(b)

	$('#inputInsert').val(Math.floor(Number(result))); //round down the result
}
