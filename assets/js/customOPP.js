const swalOPPToastrAlert = (type, message) => {
  Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
  }).fire({
    customClass: 'swal-font-small',
    type: type,
    title: message
  })
}

const swalWIPP = (type, title) => {
  Swal.fire({
    type: type,
    title: title,
    text: ''
  })
}
// ================================================ //
const opp_add_to_order_out = () =>{
  $('#opp_order_out_tampung').html('')
  let data = $('#opp_keranjang').text()
  let tm = []
  data = data.split(',')
  data.pop()
  let tampung = [];
  data.forEach((v, i) => {
    let baru = v.split('_')
    tampung.push(baru)
  })

  tampung.forEach((v, i) => {
    let html = `<tr>
                  <td style="text-align:center">${i+1}</td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td>${v[2]}</td>
                </tr>`;
      $('#opp_order_out_tampung').append(html)
  })

}

const addtokeranjang = (id_order, proses, seksi, id) =>{
  let opp_check = $(`#opp_idproses_${id}`).attr('check');
  let val = `${id}_${id_order}_${proses}_${seksi},`;
  if (opp_check == 'plus') {
    $(`#opp_idproses_${id}`).attr('check', 'minus');
    $(`#opp_idproses_${id}`).html(`<i class="fa fa-close"></i> Cancel Order`)
    $('#opp_keranjang').append(val)
  }else {
    $(`#opp_idproses_${id}`).html(`<i class="fa fa-sign-in"></i> Add Order`)
    $(`#opp_idproses_${id}`).attr('check', 'plus');
    let krjg = $('#opp_keranjang').text();
    let newText = krjg.replace(val, '');
    $('#opp_keranjang').text(newText)
  }
  setTimeout(function () {
    let krjg_new = $('#opp_keranjang').text();
    let count_krjg = Number(krjg_new.split(',').length) -1;
    $('#jumlahitem_opp').html(count_krjg)
  }, 70);
}

const orderinopp = $('.orderInOpp').DataTable();

function format_wipp_bom(d, no) {
  return `<div class="detailOrderIn_${no}"></div>`;
}

const opp_in_detail = (no,
											 material,
											 dimensi_t,
										   dimensi_p,
										 	 dimensi_l,
									 		 gol,
										 	 jenis,
										   pa,
										   upper_level,
										 	 cek_kode,
										   cek_mon,
										   cek_nama,
										   produk,
										   project) =>{
 let tr = $(`tr[row-id="${no}"]`);
 let row = orderinopp.row(tr);
 if (row.child.isShown()) {
   row.child.hide();
   tr.removeClass('shown');
 } else {
   row.child(format_wipp_bom(row.data(), no)).show();
   tr.addClass('shown');
	 $('.detailOrderIn_'+no).html(`<div class="table-responsive">
															   <table class="table table-striped table-bordered table-hover text-left " style="font-size:12px;">
															     <thead>
															       <tr class="bg-success">
															         <th rowspan="2" style="vertical-align:middle"><center>Produk</center></th>
															         <th rowspan="2" style="vertical-align:middle"><center>Project</center></th>
																			 <th rowspan="2" style="vertical-align:middle"><center>Jenis</center></th>
																			 <th rowspan="2" style="vertical-align:middle"><center>Gol</center></th>
																			 <th rowspan="2" style="vertical-align:middle"><center>Material</center></th>
																			 <th rowspan="2" style="vertical-align:middle"><center>P/A</center></th>
																			 <th rowspan="2" style="vertical-align:middle"><center>Upper Level</center></th>
																			 <th colspan="3" style="vertical-align:middle"><center>Dimensi</center></th>
																			 <th rowspan="2" style="vertical-align:middle"><center>Cek Kode</center></th>
																			 <th rowspan="2" style="vertical-align:middle"><center>Cek Mon</center></th>
																			 <th rowspan="2" style="vertical-align:middle"><center>Cek Nama</center></th>
															       </tr>
																		 <tr class="bg-success">
																			 <td><center>Ø/t</center></td>
																			 <td><center>P</center></td>
																			 <td><center>L</center></td>
																		 </tr>
															     </thead>
															     <tbody>
															       <tr>
																		 <td><center>${produk}</center></td>
																		 <td><center>${project}</center></td>
																		 <td><center>${jenis}</center></td>
																		 <td><center>${gol}</center></td>
																		 <td><center>${material}</center></td>
																		 <td><center>${pa}</center></td>
																		 <td><center>${upper_level}</center></td>
																		 <td><center>${dimensi_t}</center></td>
																		 <td><center>${dimensi_p}</center></td>
																		 <td><center>${dimensi_l}</center></td>
																		 <td><center>${cek_kode}</center></td>
																		 <td><center>${cek_mon}</center></td>
																		 <td><center>${cek_nama}</center></td>
															       </tr>
															     </tr>
															     </tbody>
															   </table>
															 </div>`)
 }
}

const opp_detail_proses = (id, komponen_kode) => {
	$('#detail_proses_opp').html('')
	$('#detail_proses_opp').html(komponen_kode)
  $.ajax({
		url: baseurl + 'OrderPrototypePPIC/OrderIn/getProsesOPP',
		type: 'POST',
		data: {
			id: id,
		},
		beforeSend: function() {
			$('.area-proses-opp').html(`<div id="loadingArea0">
																			<center>
																				<img style="width: 5%;margin-bottom:13px" src="${baseurl}assets/img/gif/loading5.gif">
																				<br>
																				Sedang Mengambil Data...
																			</center>
																		</div>`)
		},
		success: function(result) {
			$('.area-proses-opp').html(result)
		},
		error: function(XMLHttpRequest, textStatus, errorThrown) {
			console.error()
		}
	}).then(_=>{
    let item = $('#opp_keranjang').text();
    let item_selected = $('.opp_cek_item_exiting').map((_, el) => el.value).get()
    item_selected.forEach((v, i)=>{
      if (item.includes(`${v},`)) {
        let get_id = v.split('_');
        $(`#opp_idproses_${get_id[0]}`).attr('check', 'minus');
        $(`#opp_idproses_${get_id[0]}`).html(`<i class="fa fa-close"></i> Cancel Order`)
      }
    })
  })
}

$(document).ready(function() {
	let opp_punya = $('#opp_punya').val();
	if (opp_punya) {
		// console.log($('#opp_kodesie').val());
		const getseksiopp = $.ajax({
												url: baseurl + 'OrderPrototypePPIC/OrderIn/getSeksiBy',
												type: 'POST',
												dataType: 'JSON',
												async: true,
												data: {
													kodesie: $('#opp_kodesie').val(),
												},
												beforeSend: function() {
													$('#opp_seksi').val('Sedang Mendeteksi Seksi Anda...')
												},
												success: function(result) {
													$('#opp_seksi').val(result)
												},
												error: function(XMLHttpRequest, textStatus, errorThrown) {
													console.error()
												}
											})
	}

 $('.pilihseksiOPP').select2({
		placeholder: "Cari Seksi",
		ajax: {
			url: baseurl + "OrderPrototypePPIC/OrderIn/getSeksi",
			dataType: "JSON",
			type: "POST",
			data: function(params) {
				return {
					term: params.term
				};
			},
			processResults: function(data) {
				return {
					results: $.map(data, function(obj) {
						return {
							id: obj.seksi,
							text: `${obj.seksi}`
						}
					})
				}
			}
		}
	})
})

function readFilePdf_opp(input) {
		if (input.files && input.files[0]) {
				var reader = new FileReader();

				reader.onload = function (e) {
						$('#showPre')
								.attr('src', e.target.result)
								.height(300);
				};
		reader.readAsDataURL(input.files[0]);
		}
}

const plus_proses_opp = () => {
	let n = $(`.table_opp tr`).length;
	let no = n + 1;
	let html = `<tr row-id="${no}">
	              <td style="text-align:center">${no}</td>
	              <td>
	                <select class="form-control" name="p_proses[]" required>
									  <option value="">Pilih...</option>
										<option value="ASSY">ASSY</option>
										<option value="BANDING">BANDING</option>
										<option value="KIRIM">KIRIM</option>
										<option value="CASTING">CASTING</option>
										<option value="WELDING">WELDING</option>
	                </select>
	              </td>
	              <td>
									<select class="form-control pilihseksiOPP" name="p_seksi[]" style="width:100%" required></select>
	              </td>
	              <td>
	                <center><button type="button" name="button" class="btn btn-sm" onclick="minus_proses_opp(${no})"><i class="fa fa-minus-square"></i></button></center>
	              </td>
	            </tr>`;
	 $(`.table_opp`).append(html);
	 $('.pilihseksiOPP').select2({
		 placeholder: "Cari Seksi",
		 ajax: {
			 url: baseurl + "OrderPrototypePPIC/OrderIn/getSeksi",
			 dataType: "JSON",
			 type: "POST",
			 data: function(params) {
				 return {
					 term: params.term
				 };
			 },
			 processResults: function(data) {
				 return {
					 results: $.map(data, function(obj) {
						 return {
							 id: obj.seksi,
							 text: `${obj.seksi}`
						 }
					 })
				 }
			 }
		 }
	 })
}

const minus_proses_opp = (no) => {
	$(`.table_opp tr[row-id="${no}"]`).remove();
}
