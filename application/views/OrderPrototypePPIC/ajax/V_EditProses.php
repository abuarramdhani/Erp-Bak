<div class="table-responsive">
  <table class="table table-striped table-bordered table-hover text-left tbleditopp" style="font-size:12px;">
    <thead>
      <tr class="bg-success">
        <th><center>Urutan Proses</center></th>
        <th><center>Proses</center></th>
        <th style="width:55%"><center>Seksi</center></th>
        <th><center><button type="button" name="button" style="margin-left:0;" class="btn btn-sm btn-success" onclick="plus_proses_edit_opp()"><i class="fa fa-plus-square"></i></button></center></th>
      </tr>
    </thead>
    <tbody>
      <?php $no = 1; foreach ($get as $key => $g): ?>
        <tr opp-row-edit="<?php echo $no; ?>">
          <td><center class="opp_proses_number"><?php echo $no; ?></center></td>
          <td>
            <center>
              <select class="opp_select2" name="proses" style="width:100%">
                <?php foreach ($nama_proses as $key => $value): ?>
                  <option value="<?php echo $value['nama_proses'] ?>" <?php echo $value['nama_proses']  == $g['proses'] ? 'selected' : '' ?> ><?php echo $value['nama_proses'] ?></option>
                <?php endforeach; ?>
              </select>
            </center>
          </td>
          <td>
            <center>
              <select class="opp_select2" name="seksi" style="width:100%">
                <?php foreach ($seksi as $key => $value): ?>
                  <option value="<?php echo $value['seksi'] ?>" <?php echo $value['seksi']  == $g['seksi'] ? 'selected' : '' ?> ><?php echo $value['seksi'] ?></option>
                <?php endforeach; ?>
              </select>
            </center>
            <input type="hidden" name="id" value="<?php echo $g['id'] ?>">
          </td>
          <td>
            <center><button type="button" name="button" class="btn btn-sm btn-success" onclick="minus_proses_edit_opp(<?php echo $no; ?>)"><i class="fa fa-minus-square"></i></button></center>
          </td>
        </tr>
      <?php $no++; endforeach; ?>
    </tbody>
  </table>
</div>

<center>
  <button type="button" class="btn btn-success" onclick="opp_update_proses()" style="width:30%;font-weight:bold;margin-bottom:10px" name="button"> <i class="fa fa-file"></i> Update</button>
</center>


<script type="text/javascript">
$('.tbleditopp').DataTable({
  "pageLength": 10,
  "ordering": false,
  "searching": false
});

$('.opp_select2').select2();

function opp_update_proses() {
  let proses = $('select[name="proses"]').map((_, el) => el.value).get();
  let seksi = $('select[name="seksi"]').map((_, el) => el.value).get();
  let id = $('input[name="id"]').map((_, el) => el.value).get();
  let mass = [];

  let param_before = $('.opp_get_param').val();
  let param = param_before.split('_');
  proses.forEach((v, i) => {
    let tam = {
      'proses' : v,
      'seksi' : seksi[i],
      'id_order' : <?php echo $id ?>,
      'id' : id[i]
    }
    mass.push(tam);
  })
  $.ajax({
    url: baseurl + 'OrderPrototypePPIC/OrderIn/edit_proses_opp',
    type: 'POST',
    data: {
      data: mass
    },
    beforeSend: function() {
      $('.area-edit-proses-opp').html(`<div id="loadingArea0">
                                      <center>
                                        <img style="width: 5%;margin-bottom:13px" src="${baseurl}assets/img/gif/ripple.gif">
                                        <br>
                                        Sedang Memproses Data...
                                      </center>
                                    </div>`)
    },
    success: function(result) {
      $('.area-edit-proses-opp').html(`<div id="loadingArea0">
                                      <center>
                                        <b style="color:#08b164"> <i class="fa fa-check-square"></i> Selesai Melakukan Update Data.</b>
                                      </center>
                                    </div>`)
      // $('.area-proses-opp').html(result)
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
      console.error()
    }
  }).done(_=>{
    setTimeout(function () {
      $('#opp_edit_proses').modal('toggle');
      $('#opp_modaldetail').modal('show');
      opp_detail_proses(param[0], param[1], param[2]);
    }, 700);
  })
}

function plus_proses_edit_opp(){
	let n = $(`.tbleditopp tr`).length;
  console.log(n);
	let no = n;
  let jenis_proses= [];
  let seksi = [];

  <?php foreach ($nama_proses as $key => $value){ ?>
    jenis_proses.push(`<option value="<?php echo $value['nama_proses'] ?>"><?php echo $value['nama_proses'] ?></option>`)
  <?php } ?>
  <?php foreach ($seksi as $key => $value): ?>
    seksi.push(`<option value="<?php echo $value['seksi'] ?>"><?php echo $value['seksi'] ?></option>`)
  <?php endforeach; ?>

	let html = `<tr opp-row-edit="${no}">
	              <td style="text-align:center"><center class="opp_proses_number">${no}</center></td>
	              <td>
                  <center>
  	                <select class="form-control opp_select2" name="proses" style="width:100%">
  									  <option value="">Pilih...</option>
                      ${jenis_proses.join('')}
  	                </select>
                  </center>
	              </td>
	              <td>
                <center>
                  <select class="form-control opp_select2" name="seksi" style="width:100%">
                    <option value="">Pilih...</option>
                    ${seksi.join('')}
                  </select>
                </center>
                <input type="hidden" name="id" value="n">
	              </td>
	              <td>
	                <center><button type="button" name="button" class="btn btn-sm btn-success" onclick="minus_proses_edit_opp(${no})"><i class="fa fa-minus-square"></i></button></center>
	              </td>
	            </tr>`;
	 $(`.tbleditopp`).append(html);
   $('.opp_select2').select2();
}

function minus_proses_edit_opp(no) {
  $(`.tbleditopp tr[opp-row-edit="${no}"]`).remove();
  $('.opp_proses_number').each(function(i){
    $(this).html(i + 1);
    console.log(i);
   });
}

</script>
