<i>*Warna<b style="color:#c1cb00"> Kuning</b> = File Gambar Kerja tidak terbaca</i>
<br>
<div class="table-responsive mt-4">
  <table class="table table-striped table-bordered table-hover text-left datatable-memo-fp-2021" style="font-size:11px;">
    <thead class="bg-primary">
      <tr>
        <th style="width:5%;text-align:center">No</th>
        <th style="width:15%">Component Code</th>
        <th>Description</th>
        <th style="width:8%;text-align:center">Revision</th>
        <th style="width:15%;text-align:left">Revision Date</th>
        <th style="width:7%;text-align:center">File</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($get as $key => $value):
        if (substr($value['file_location'], 0, 1) == '.') {
          $value['file_location'] = substr($value['file_location'], 1);
        }
        $url = 'http://192.168.168.221/gambar-kerja'.$value['file_location'].$value['file_name'].'.pdf';
        $array = @get_headers($url);
        $string = $array[0];
        if(strpos($string, "200")) {
        $img = 'y';
        }else {
        $img = 'n';
        }
      ?>
        <tr row-fp-memo="<?php echo $value['product_component_id'] ?>" <?php echo $img == 'n' ? 'style="background:#c1cb00"' : '' ?>>
          <td style="text-align:center"><?php echo $key+1 ?></td>
          <td style="text-align:left"><?php echo $value['kodebaru'] ?></td>
          <td style="text-align:left"><?php echo $value['nama_komponen'] ?></td>
          <td style="text-align:center"><?php echo $value['norevisi'] ?></td>
          <td style="text-align:left"><?php echo substr($value['revision_date'], 0, 10) ?></td>
          <td style="text-align:center"><button type="button" onclick="fp_detail_memo_img(<?php echo $value['product_component_id'] ?>, <?php echo $value['product_id'] ?>, '<?php echo $value['kodebaru'] ?>')" class="btn btn-primary" name="button" data-toggle="modal" data-target="#modalfpgambar"> <b class="fa fa-image"></b> </button></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  <?php if ($cek == 0){ ?>
    <center id="fp_kodisi_btn_memo"><button type="button" class="btn btn-success" onclick="update_status_component('<?php echo $memo ?>')" style="border-radius:7px;width:35%;margin-bottom:7px" name="button"> <i class="fa fa-check-square"></i> <b>Approve Memo(<?php echo $memo ?>)</b> </button> </center>
  <?php }else { ?>
    <center id="fp_kodisi_btn_memo"><button type="button" class="btn btn-warning" onclick="update_status_component_cancel('<?php echo $memo ?>')" style="border-radius:7px;width:35%" name="button"> <i class="fa fa-times"></i> <b>Unset Memo(<?php echo $memo ?>)</b> </button></center>
  <?php } ?>
</div>
<script type="text/javascript">
  let table_detail_memo = $('.datatable-memo-fp-2021').DataTable();

  function fp_memo_img(d, id) {
    return `<div class="fp_memo_img_${id}"></div>`;
  }

  function fp_detail_memo_img(id, product_id, code) {
    let tr = $(`tr[row-fp-memo="${id}"]`);
    let row = table_detail_memo.row(tr);
    if (row.child.isShown()) {
      row.child.hide();
      tr.removeClass('shown');
    } else {
      row.child(fp_memo_img(row.data(), id, code)).show();
      tr.addClass('shown');
      $.ajax({
        url: baseurl + 'FlowProses/Component/gambarkerjaBachAdd',
        type: 'POST',
        data: {
          product_id : product_id,
          product_component_id : id,
          jenis : '<?php echo trim($type) ?>'
        },
        beforeSend: function() {
          $(`.fp_memo_img_${id}`).html(`<div id="loadingArea0">
                                          <center><img style="width: 5%;margin-bottom:13px" src="${baseurl}assets/img/gif/loading5.gif"></center>
                                          <center>Loading...</center>
                                        </div>`);
        },
        success: function(result) {
          $(`.fp_memo_img_${id}`).html(result)
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
          swalFP('error', 'Something was wrong...')
        }
      })
    }
  }

  function update_status_component(memo) {
    fp_ajax_memo = $.ajax({
      url: baseurl + "FlowProses/Memo/updateComponentMemo",
      type: 'POST',
      dataType: 'JSON',
      data: {
        memo: memo,
        type: '<?php echo $type ?>'
      },
      beforeSend: function() {
        Swal.fire({
          onBeforeOpen: () => {
             Swal.showLoading()
           },
          text: `Sedang memproses data...`
        })
      },
      success: function(result) {
        if (result) {
          toastFP('success', `Komponen Berhasil Ditambahkan.`);
          $('#fp_kodisi_btn_memo').html(`<button type="button" class="btn btn-warning" onclick="update_status_component_cancel('<?php echo $memo ?>')" style="border-radius:7px;width:35%" name="button"> <i class="fa fa-times"></i> <b>Cancel Memo(<?php echo $memo ?>)</b> </button>`)
          $('#modalfpmemocomponent').modal('toggle')
          $(`#fp_status_<?= $memo_id ?>`).html(`<center><span class="btn-success" name="button" style="padding:4px;border-radius:5px;width:70%;font-weight:bold">Approved!</span></center>`)
        }else if (2) {
          toastFP('danger', `Terjadi Kesalahan`);
        }else{
          toastFP('warning', `Data kosong dengan no memo ${memo}`);
        }
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
        swalFP('error', 'Something was wrong!')
       console.error();
      }
    })
  }

  function update_status_component_cancel(memo) {
    fp_ajax_memo = $.ajax({
      url: baseurl + "FlowProses/Memo/updateComponentMemoCancel",
      type: 'POST',
      dataType: 'JSON',
      data: {
        memo: memo,
      },
      beforeSend: function() {
        Swal.fire({
          onBeforeOpen: () => {
             Swal.showLoading()
           },
          text: `Sedang memproses data...`
        })
      },
      success: function(result) {
        if (result) {
          toastFP('success', `Komponen Berhasil Diurungkan.`);
          $('#fp_kodisi_btn_memo').html(`<button type="button" class="btn btn-success" onclick="update_status_component('<?php echo $memo ?>')" style="border-radius:7px;width:35%" name="button"> <i class="fa fa-check-square"></i> <b>Accept Memo(<?php echo $memo ?>)</b> </button>`)
          $('#modalfpmemocomponent').modal('toggle')
          $(`#fp_status_<?= $memo_id ?>`).html(`<center><span class="btn-warning" name="button" style="padding:4px;border-radius:5px;width:70%;font-weight:bold">Unsetting</span></center>`)

        }else if (2) {
          toastFP('danger', `Terjadi Kesalahan`);
        }
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
        swalFP('error', 'Something was wrong!')
       console.error();
      }
    })
  }
</script>
