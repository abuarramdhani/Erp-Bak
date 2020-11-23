const toastOPP = (type, message) => {
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

const swalOPP = (type, title) => {
  Swal.fire({
    type: type,
    title: title,
    text: ''
  })
}
// ================================================ //

const opp_modal_edit = () => {
  $('#edit_proses_opp').html($('#detail_proses_opp').text())

  $('#opp_modaldetail').modal('toggle');
  $('#opp_edit_proses').modal('show');

  let param_before = $('.opp_get_param').val();
  let param = param_before.split('_');

  $.ajax({
    url: baseurl + 'OrderPrototypePPIC/OrderIn/getEditProsesOPP',
    type: 'POST',
    data: {
      id: param[0],
      nomer_urut: param[2],
    },
    beforeSend: function() {
      $('.area-edit-proses-opp').html(`<div id="loadingArea0">
                                      <center>
                                        <img style="width: 5%;margin-bottom:13px" src="${baseurl}assets/img/gif/ripple.gif">
                                        <br>
                                        Sedang Menyiapkan Data...
                                      </center>
                                    </div>`)
    },
    success: function(result) {
      $('.area-edit-proses-opp').html(result)
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
      console.error()
    }
  })

}

const oppSaveOrderOut = () => {
  let id_proses = $('.id_proses').map((_, el) => el.value).get()
  let id_order = $('.id_order').map((_, el) => el.value).get()
  let data = [];
  id_order.forEach((v,i) => {
    let cek = {
      'id_order': v,
      'id_proses': id_proses[i],
      'unit' : $('#opp_unit').text(),
      'departemen' : $('#opp_dept').text(),
      'no_order_out' : $('#opp_next_no_order_out').text()
    }
    data.push(cek);
  })
    $.ajax({
        url: baseurl + 'OrderPrototypePPIC/OrderOut/addOrderOut',
        type: 'POST',
        dataType: 'JSON',
        async: false,
        data: {
          data : data
        },
        beforeSend: function() {
          Swal.showLoading()
        },
        success: function(result) {
          if (result == 1) {
            toastOPP('success', 'Berhasil Menyimpan Order Out');
            $('#opp_modal_set_order_out').modal('toggle');
            $('#jumlahitem_opp').html('0')
            $('#opp_keranjang').text('')
          }else {
            toastOPP('warning', 'Tidak Berhasil Menyimpan Order Out');
          }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
          console.error()
          toastOPP('error', 'Terjadi kesalahan saat menyimpan data');
        }
      })
  // console.log(id_proses);
  // console.log(id_order);
}

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
  if (tampung[0] != undefined) {
    // console.log(tampung);
    $('.opp_save_order_out').show()
    let cek_seksi
    tampung.forEach((v, i) => {
      if (tampung[0][3] != v[3]) {
        cek_seksi = 1;
      }
    })
    if (cek_seksi) {
      swalOPP('warning', 'Seksi Tujuan Harus Sama Untuk Dapat Melakukan ORDER KELUAR!');
      $('#opp_modal_set_order_out').modal('toggle');
    }else {
      $('#seksi_penerima').html(tampung[0][3])
      $.ajax({
          url: baseurl + 'OrderPrototypePPIC/OrderOut/getUnitDepartemen',
          type: 'POST',
          dataType: 'JSON',
          async: true,
          data: {
            seksi: tampung[0][3],
          },
          success: function(result) {
            $('#opp_unit').html(result.unit)
            $('#opp_dept').html(result.dept)
          },
          error: function(XMLHttpRequest, textStatus, errorThrown) {
            console.error()
          }
        })
      let r = 0;
        console.log(tampung.length);
        tampung.forEach((v, ii) => {
        let opp_ajax_1 = $.ajax({
            url: baseurl + 'OrderPrototypePPIC/OrderOut/getOrder',
            type: 'POST',
            dataType: 'JSON',
            async: true,
            data: {
              id: v[1],
            },
            beforeSend: function () {
              $('.opp_area_loading').html(`<div id="loadingArea0">
                                              <center>
                                                <img style="width: 5%;margin-bottom:13px" src="${baseurl}assets/img/gif/ripple.gif">
                                                <br><span style="font-size:10px">Sedang Menyiapkan Data...</span>
                                              </center>
                                            </div>`)
            },
            success: function(result) {
              $('.opp_area_loading').html('')
              let html = `<tr>
                            <input type="hidden" class="id_proses" value="${v[0]}">
                            <input type="hidden" class="id_order" value="${v[1]}">
                            <td style="text-align:center">${ii+1}</td>
                            <td>${result.jenis}</td>
                            <td>${result.qty}</td>
                            <td>${result.kode_komponen}</td>
                            <td>${v[2]}</td>
                          </tr>`;
                $('#opp_order_out_tampung').append(html)
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
              console.error()
            },
          })
      })
      $.ajax({
          url: baseurl + 'OrderPrototypePPIC/OrderOut/generateOrderOut',
          type: 'POST',
          dataType: 'JSON',
          async: true,
          success: function(result) {
            $('#opp_next_no_order_out').html(result)
          },
          error: function(XMLHttpRequest, textStatus, errorThrown) {
            console.error()
          }
        })
    }
  }else {
    $('.opp_save_order_out').hide()
  }

}

const addtokeranjang = (id_order, proses, seksi, id, nomor) =>{
  let opp_check = $(`#opp_idproses_${id}`).attr('check');
  let val = `${id}_${id_order}_${proses}_${seksi},`;
  if (opp_check == 'plus') {
    $(`#opp_idproses_${id}`).attr('check', 'minus');
    $(`#opp_idproses_${id}`).html(`<i class="fa fa-close"></i> Cancel Order`);
    $(`tr[row-id=${nomor}]`).css("background-color", "rgba(3, 76, 161, 0.39)");
    $('#opp_keranjang').append(val)
  }else {
    $(`#opp_idproses_${id}`).html(`<i class="fa fa-sign-in"></i> Add Order`)
    $(`#opp_idproses_${id}`).attr('check', 'plus');
    let item_selected = $('.opp_cek_item_exiting').map((_, el) => el.value).get();
    let tmp_cek = 0;
    item_selected.forEach((v, i)=>{
      let get_id = v.split('_');
      let cek_001 = $(`#opp_idproses_${get_id[0]}`).attr('check')
      if (cek_001 == 'plus') {
        tmp_cek += 1;
      }
    })
    if (tmp_cek == item_selected.length) {
      $(`tr[row-id=${nomor}]`).css("background-color", "");
    }

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

const opp_monitoring = $('.opp_monitoring').DataTable();

function format_dtl_mon(d, no) {
  return `<div class="detail_mon_${no}"></div>`;
}

const opp_detail_proses_mon = (id) => {
  let tr = $(`tr[row="${id}"]`);
  let row = opp_monitoring.row(tr);
  if (row.child.isShown()) {
    row.child.hide();
    tr.removeClass('shown');
  } else {
    row.child(format_dtl_mon(row.data(), id)).show();
    tr.addClass('shown');
    $.ajax({
  		url: baseurl + 'OrderPrototypePPIC/OrderIn/getProsesOPP',
  		type: 'POST',
  		data: {
  			id: id,
        nomer_urut: '0012'
  		},
  		beforeSend: function() {
  			$('.detail_mon_'+id).html(`<div id="loadingArea0">
  																			<center>
  																				<img style="width: 5%;margin-bottom:13px" src="${baseurl}assets/img/gif/ripple.gif">
  																				<br>
  																				Sedang Menyiapkan Data...
  																			</center>
  																		</div>`)
  		},
  		success: function(result) {
  			$('.detail_mon_'+id).html(result)
  		},
  		error: function(XMLHttpRequest, textStatus, errorThrown) {
  			console.error()
  		}
  	})
  }
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

const opp_detail_proses = (id, komponen_kode, number) => {

  $('.opp_get_param').val(`${id}_${komponen_kode}_${number}`);
	$('#detail_proses_opp').html('')
	$('#detail_proses_opp').html(komponen_kode)
  $.ajax({
		url: baseurl + 'OrderPrototypePPIC/OrderIn/getProsesOPP',
		type: 'POST',
		data: {
			id: id,
      nomer_urut: number
		},
		beforeSend: function() {
			$('.area-proses-opp').html(`<div id="loadingArea0">
																			<center>
																				<img style="width: 5%;margin-bottom:13px" src="${baseurl}assets/img/gif/ripple.gif">
																				<br>
																				Sedang Menyiapkan Data...
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
  let data_jp = JSON.parse($('#opp_jenis_proses').text())
  let jenis_proses= [];
  data_jp.forEach((v,i)=>{
    jenis_proses.push(`<option value="${v.nama_proses}">${v.nama_proses}</option>`)
  })
	let html = `<tr row-id="${no}">
	              <td style="text-align:center">${no}</td>
	              <td>
	                <select class="form-control" name="p_proses[1][]" required>
									  <option value="">Pilih...</option>
                    ${jenis_proses.join('')}
	                </select>
	              </td>
	              <td>
									<select class="form-control pilihseksiOPP" name="p_seksi[1][]" style="width:100%" required></select>
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

const plus_proses_opp_add = (ca) => {
	let n = $(`.table_opp_${ca} tr`).length;
	let no = n + 1;
  let data_jp = JSON.parse($('#opp_jenis_proses').text())
  let jenis_proses= [];
  data_jp.forEach((v,i)=>{
    jenis_proses.push(`<option value="${v.nama_proses}">${v.nama_proses}</option>`)
  })
	let html = `<tr row-id="${no}">
	              <td style="text-align:center">${no}</td>
	              <td>
	                <select class="form-control" name="p_proses[${ca}][]" required>
									  <option value="">Pilih...</option>
                    ${jenis_proses.join('')}
	                </select>
	              </td>
	              <td>
									<select class="form-control pilihseksiOPP" name="p_seksi[${ca}][]" style="width:100%" required></select>
	              </td>
	              <td>
	                <center><button type="button" name="button" class="btn btn-sm" onclick="minus_proses_opp_add(${no}, ${ca})"><i class="fa fa-minus-square"></i></button></center>
	              </td>
	            </tr>`;
	 $(`.table_opp_${ca}`).append(html);
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

const minus_proses_opp_add = (no, ca) => {
	$(`.table_opp_${ca} tr[row-id="${no}"]`).remove();
}

const opp_add_data_in = () =>{
  let ca = $('.opp_data_number').length;

  $(`.opp_add_target`).append(`<div class="row opp_new_data_${Number(ca)+1}">
                              <div class="col-md-2" style="text-align:center;padding: 0px 29px 0 0;font-size: 30px;"> <b>Data.</b> <b class="opp_data_number">${Number(ca)+1}</b>
                              <br>
                              <button type="button" class="btn btn-danger" name="button" onclick="opp_min_data_in(${Number(ca)+1})" style="border-radius: 5px;text-align: center;font-weight: bolder;"> Hapus <b class="fa fa-minus-square"></b> </button>
                               </div>
                            <div class="col-md-8">
                              <table style="width:100%">
                                <tr style="height:61px">
                                  <td style="width:20%"><label>Gambar Kerja</label></td>
                                  <td style="width:3%"><label>:</label></td>
                                  <td style="width:77%">
                                    <input type="file" class="form-control" onchange="readFilePdf_opp(this)" name="file_gm[]" value="">
                                  </td>
                                </tr>
                                <tr>
                                  <td colspan="3">
                                    <iframe src="" style="width:100%;height:0" id="showPre" frameborder="0" class="mt-1"></iframe>
                                  </td>
                                </tr>
                                <tr style="height:61px">
                                  <td ><label>Kode Komponen</label></td>
                                  <td ><label>:</label></td>
                                  <td ><input type="text" class="form-control" name="kode_komp[]" value=""></td>
                                </tr>
                                <tr style="height:61px">
                                  <td ><label>Nama Komponen</label></td>
                                  <td ><label>:</label></td>
                                  <td ><input type="text" class="form-control" name="nama_komp[]" value=""></td>
                                </tr>

                                <tr style="height:61px">
                                  <td ><label>QTY /UNIT</label></td>
                                  <td ><label>:</label></td>
                                  <td ><input type="number" class="form-control" name="qty[]" value=""></td>
                                </tr>
                                <tr style="height:61px">
                                  <td ><label>Need</label></td>
                                  <td ><label>:</label></td>
                                  <td ><input type="number" class="form-control" name="need[]" value=""></td>
                                </tr>
                                <tr style="height:61px">
                                  <td ><label>Material</label></td>
                                  <td ><label>:</label></td>
                                  <td ><input type="text" class="form-control" name="material[]" value=""></td>
                                </tr>
                                <tr style="height:167px">
                                  <td style="vertical-align:top;padding-top:12px"><label>Dimensi PO/T</label></td>
                                  <td style="vertical-align:top"><label></label></td>
                                  <td >
                                    <div class="row">
                                      <div class="col-md-1">
                                        <b class="text-primary">Ø/t</b>
                                      </div>
                                      <div class="col-md-1">
                                        <b>:</b>
                                      </div>
                                      <div class="col-md-10">
                                        <input type="number" class="form-control" name="dimensi_t[]" value=""><br>
                                      </div>
                                      <div class="col-md-1">
                                        <b class="text-primary">P</b>
                                      </div>
                                      <div class="col-md-1">
                                        <b>:</b>
                                      </div>
                                      <div class="col-md-10">
                                        <input type="number" class="form-control" name="dimensi_p[]" value=""><br>
                                      </div>
                                      <div class="col-md-1">
                                        <b class="text-primary">L</b>
                                      </div>
                                      <div class="col-md-1">
                                        <b>:</b>
                                      </div>
                                      <div class="col-md-10">
                                        <input type="number" class="form-control" name="dimensi_l[]" value="">
                                      </div>
                                    </div>
                                  </td>
                                </tr>
                                <tr style="height:61px">
                                  <td ><label>Gol</label></td>
                                  <td ><label>:</label></td>
                                  <td ><input type="text" class="form-control" name="gol[]" value=""></td>
                                </tr>
                                <tr style="height:61px">
                                  <td ><label>Jenis</label></td>
                                  <td ><label>:</label></td>
                                  <td ><input type="text" class="form-control" name="jenis[]" value=""></td>
                                </tr>
                                <tr style="height:61px">
                                  <td ><label>P/A</label></td>
                                  <td ><label>:</label></td>
                                  <td >
                                    <select class="form-control" name="p_a[]">
                                      <option value="P">P</option>
                                      <option value="A">A</option>
                                    </select>
                                  </td>
                                </tr>
                                <tr style="height:61px">
                                  <td ><label>Produk</label></td>
                                  <td ><label>:</label></td>
                                  <td ><input type="text" class="form-control" name="produk[]" value=""></td>
                                </tr>
                                <tr style="height:61px">
                                  <td ><label>Project</label></td>
                                  <td ><label>:</label></td>
                                  <td ><input type="text" class="form-control" name="project[]" value=""></td>
                                </tr>
                                <tr style="height:61px">
                                  <td ><label>Upper Level</label></td>
                                  <td ><label>:</label></td>
                                  <td ><input type="text" class="form-control" name="upper_level[]" value=""></td>
                                </tr>
                                <tr style="height:61px">
                                  <td style="vertical-align:top;padding-top:7px;"><label><br>Proses</label></td>
                                  <td style="vertical-align:top;padding-top:7px;"><label><br>:</label></td>
                                  <td >
                                    <div class="row">
                                      <div class="col-md-12">
                                        <table class="table table-bordered table_opp_${Number(ca)+1}">
                                          <br>
                                          <tr row-id="1">
                                            <td style="text-align:center">1</td>
                                            <td>
                                              <select class="form-control" name="p_proses[${Number(ca)+1}][]" required>
                                                <option value="">Pilih...</option>
                                                <option value="ASSY">ASSY</option>
                                                <option value="BANDING">BANDING</option>
                                                <option value="KIRIM">KIRIM</option>
                                                <option value="CASTING">CASTING</option>
                                                <option value="WELDING">WELDING</option>
                                              </select>
                                            </td>
                                            <td style="width:30%">
                                              <select class="form-control pilihseksiOPP" required name="p_seksi[${Number(ca)+1}][]" style="width:100%"></select>
                                            </td>
                                            <td>
                                              <center><button type="button" class="btn btn-sm" onclick="plus_proses_opp_add(${Number(ca)+1})"><i class="fa fa-plus-square"></i></button></center>
                                            </td>
                                          </tr>
                                        </table>
                                      </div>
                                    </div>
                                  </td>
                                </tr>
                                <tr style="height:61px">
                                  <td ><label>Cek Kode</label></td>
                                  <td ><label>:</label></td>
                                  <td ><input type="number" class="form-control" name="cek_kode[]" value=""></td>
                                </tr>
                                <tr style="height:61px">
                                  <td ><label>Cek Mon</label></td>
                                  <td ><label>:</label></td>
                                  <td ><input type="number" class="form-control" name="cek_mon[]" value=""></td>
                                </tr>
                                <tr style="height:61px">
                                  <td ><label>Cek Nama</label></td>
                                  <td ><label>:</label></td>
                                  <td ><input type="number" class="form-control" name="cek_nama[]" value=""></td>
                                </tr>
                              </table>
                              <hr>
                              <br>
                              <br>
                              </div>
                              <div class="col-md-2">
                              </div>
                            </div>`);
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

function opp_min_data_in(ca) {
  $(`.opp_new_data_${ca}`).remove()
}

const opp_close_proses = () => {
 let param_before = $('.opp_get_param').val();
 let param = param_before.split('_');
 $('#opp_modaldetail').modal('show');
 opp_detail_proses(param[0], param[1], param[2]);

}
