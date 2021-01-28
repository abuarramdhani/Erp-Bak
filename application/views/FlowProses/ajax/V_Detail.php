<div class="alert alert-success alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h4><i class="icon fa fa-warning"></i> Peringatan!</h4>
    Komponen data yang ditampilkan hanya komponen yang telah diapprove di menu <b>Memo</b>.
</div>
<?php if (sizeof($warning) != 0){ ?>
  <div class="box box-danger collapsed-box" style="margin-bottom:13px;background:#fee1e1">
    <div class="box-header with-border">
      <h3 class="box-title"> <b class="fa fa-info-circle" style="color:#c70f0f"></b> <b style="color:#c70f0f">Warning!</b> <b><?php echo sizeof($warning) ?> components have no process operations</b></h3>

      <div class="box-tools pull-right">
        <button type="button" class="btn btn-danger btn-box-tool" onclick="detail_no_proses()" data-widget="collapse"><i class="fa fa-plus" style="color:white"></i> <b style="color:white">Detail Component</b>
        </button>
      </div>
      <!-- /.box-tools -->
    </div>
    <!-- /.box-header -->
    <div class="box-body" style="display: none;">
      <div class="table-responsive" style="margin-top:13px;">
        <input type="text" class="form-control" id="search_warning" oninput="searchWarning()" placeholder="Search..." value="">
        <table class="table table-striped table-bordered table-hover text-left dtfpfilteredwarning" style="font-size:11px;">
          <thead style="background:#dd4b39;color:white">
            <tr>
              <th style="text-align:center; width:5%">
                  No
              </th>
              <th>Select</th>
              <th>
                  Product
              </th>
              <th>
                  Code
              </th>
              <th style="min-width: 100px">
                  Number
              </th>
              <th style="min-width: 170px">
                  Description
              </th>
              <th style="max-width: 20px;">
                  Rev
              </th>
              <th style="min-width: 70px">
                  Revision Date
              </th>
              <th style="min-width: 70px">
                  Received Date
              </th>
              <th>
                  File
              </th>
              <th>
                  Material Type
              </th>
              <th style="min-width: 100px">
                  Oracle Item
              </th>
              <th>
                  Weight
              </th>
              <th style="min-width:70px">
                  Status Memo
              </th>
              <th>
                  Status Flow
              </th>
              <th>
                  Upper Level
              </th>
              <th>
                  Memo Number
              </th>
              <th style="min-width: 170px">
                  Explanation
              </th>
              <th style="min-width: 170px">
                  Changing Date
              </th>
              <th>
                  Changing Status
              </th>
              <th>
                  Qty
              </th>
              <th hidden></th>
              <th>Jenis</th>
            </tr>
          </thead>
          <tbody style="background:#ffffff">
            <?php foreach ($warning as $key => $row): ?>
              <tr onclick="fp_check_click_warning()">
                <td><center><?php echo $key+1; ?></center></td>
                <td></td>
                <td><?php echo $row['product_name'] ?></td>
                <td><?php echo $row['product_component_code'] ?></td>
                <td><?php echo $row['component_code'] ?></td>
                <td><?php echo $row['component_name'] ?></td>
                <td><?php echo $row['revision'] ?></td>
                <td><?php echo substr($row['revision_date'], 0, 10) ?></td>
                <td><?php echo $row['received'] ?></td>
                <td>
                  <button type="button" onclick="getgambarkerja('<?php echo $row['product_id'] ?>', '<?php echo $row['product_component_id'] ?>', '<?php echo $row['jenis'] ?>', '<?php echo $row['component_code'] ?>')" class="btn btn-primary" name="button" data-toggle="modal" data-target="#modalfpgambar"> <b class="fa fa-image"></b> </button>
                </td>
                <td><?php echo $row['material_type'] ?></td>
                <td class="fp_item_oracle_replace<?php echo $row['product_component_id'] ?>" title="Klik Untuk Mengupdate" style="font-weight:bold;text-align:center">

                <?php
                // href="'.base_url().'FlowProses/SetOracleItem"
                 if ($row['material_type'] != '-') {
                   $cek = array_search($row['product_component_id'], array_column($oracle_item, 'product_component_id'));
                   if (!empty(trim($cek)) || trim($cek) == '0') {
                     foreach ($oracle_item as $key2 => $value) {
                       if ($value['product_component_id'] == $row['product_component_id']) {
                         echo '<span data-toggle="modal" data-target="#modalfpItem" id="txtGetOracleItem'.$row['product_component_id'].'" onclick="update_fp_oracle_item('.$row['product_component_id'].', \''.$value['org'].'\', \''.$row['component_code'].'\', \''.$value['inventory_item_id'].'\')">'.$value['code_component'].' <br> '.$value['description'].'</span>';
                       }
                     }
                   }else {
                     echo '<button type="button" data-toggle="modal" data-target="#modalfpItem" style="border-radius:7px;font-weight:bold;" class="btn btn-sm btn-danger" onclick="fp_set_oracle_item(\''.$row['product_component_id'].'\', \''.$row['component_code'].'\')" name="button"> <i class="fa fa-cube"></i> Set Oracle Item</a>';
                   }
                 }else{
                   echo "-";
                 }
                ?></td>
                <td><?php echo $row['weight'] ?></td>
                <td style="text-align:center"><?php echo $row['status'] ?></td>
                <?php foreach ($status as $key => $value) { ?>
                 <?php if ($value['product_component_id'] == $row['product_component_id']) {
                   $cek_stat = $value['status'];
                   break;
                 }else {
                   $cek_stat = 'Y';
                 } ?>
               <?php }?>
                <td id="fp_cek_stat" style="text-align:center;background:<?php echo $cek_stat == 'Y'?'#359f70':'#ba2828' ?>;color:white" >
                  <?php echo $cek_stat ?>
                </td>
                <td><?php echo '-' ?></td>
                <td><?php echo $row['memo_number'] ?></td>
                <td><?php echo $row['information'] ?></td>
                <td><?php echo $row['last_update_date'] ?></td>
                <td><?php echo $row['change_type'] ?></td>
                <td><?php echo $row['qty'] ?></td>
                <!-- 20 -->
                <td hidden><?php echo $row['product_component_id'] ?></td>
                <td><?php echo $row['jenis'] ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <br>
      <button type="button" class="btn btn-success fp_set_active_warning" onclick="fp_set_inactive()" style="border-radius:7px;float:right;display:none" name="button"> <i class="fa fa-times"></i> <b id="txt_fp_stat_w">Set Inactive</b> </button>
    </div>
    <!-- /.box-body -->
  </div>
<?php } ?>
<!--
|
|
|
|
-->
<div class="table-responsive" style="margin-top:13px;">
  <input type="text" class="form-control" id="search" oninput="search_fp_comp()" placeholder="Search..." value="">
  <table class="table table-striped table-bordered table-hover text-left dt-fp-filtered" style="font-size:11px;">
    <thead class="bg-primary">
      <tr>
        <th style="text-align:center; width:5%">
            No
        </th>
        <th>Select</th>
        <th>
            Product
        </th>
        <th>
            Code
        </th>
        <th style="min-width: 100px">
            Number
        </th>
        <th style="min-width: 170px">
            Description
        </th>
        <th style="max-width: 20px;">
            Rev
        </th>
        <th style="min-width: 70px">
            Revision Date
        </th>
        <th style="min-width: 70px">
            Received Date
        </th>
        <th>
            File
        </th>
        <th>
            Material Type
        </th>
        <th style="min-width: 100px">
            Oracle Item
        </th>
        <th>
            Weight
        </th>
        <th>
            Status Memo
        </th>
        <th>
            Status Flow
        </th>
        <th>
            Upper Level
        </th>
        <th>
            Memo Number
        </th>
        <th style="min-width: 170px">
            Explanation
        </th>
        <th style="min-width: 170px">
            Changing Date
        </th>
        <th>
            Changing Status
        </th>
        <th>
            Qty
        </th>
        <th hidden></th>
        <th>Jenis</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($get as $key => $row): ?>
        <tr onclick="fp_check_click()">
          <td><center><?php echo $key+1; ?></center></td>
          <td></td>
          <td><?php echo $row['product_name'] ?></td>
          <td><?php echo $row['product_component_code'] ?></td>
          <td><?php echo $row['component_code'] ?></td>
          <td><?php echo $row['component_name'] ?></td>
          <td><?php echo $row['revision'] ?></td>
          <td><?php echo substr($row['revision_date'], 0, 10) ?></td>
          <td><?php echo $row['received'] ?></td>
          <td>
            <button type="button" onclick="getgambarkerja('<?php echo $row['product_id'] ?>', '<?php echo $row['product_component_id'] ?>', '<?php echo $row['jenis'] ?>', '<?php echo $row['component_code'] ?>')" class="btn btn-primary" name="button" data-toggle="modal" data-target="#modalfpgambar"> <b class="fa fa-image"></b> </button>
          </td>
          <td><?php echo $row['material_type'] ?></td>
          <td class="fp_item_oracle_replace<?php echo $row['product_component_id'] ?>" title="Klik Untuk Mengupdate" style="font-weight:bold;text-align:center">
          <?php
          // href="'.base_url().'FlowProses/SetOracleItem"
           if ($row['material_type'] != '-') {
             $cek = array_search($row['product_component_id'], array_column($oracle_item, 'product_component_id'));
             if (!empty(trim($cek)) || trim($cek) == '0') {
               foreach ($oracle_item as $key2 => $value) {
                 if ($value['product_component_id'] == $row['product_component_id']) {
                   echo '<span data-toggle="modal" data-target="#modalfpItem" id="txtGetOracleItem'.$row['product_component_id'].'" onclick="update_fp_oracle_item('.$row['product_component_id'].', \''.$value['org'].'\', \''.$row['component_code'].'\', \''.$value['inventory_item_id'].'\')">'.$value['code_component'].' <br> '.$value['description'].'</span>';
                 }
               }
             }else {
               echo '<button type="button" data-toggle="modal" data-target="#modalfpItem" style="border-radius:7px;font-weight:bold;" class="btn btn-sm btn-danger" onclick="fp_set_oracle_item(\''.$row['product_component_id'].'\', \''.$row['component_code'].'\')" name="button"> <i class="fa fa-cube"></i> Set Oracle Item</a>';
             }
           }else{
             echo "-";
           }
          ?></td>
          <td><?php echo $row['weight'] ?></td>
          <td style="text-align:center"><?php echo $row['status'] ?></td>
          <?php foreach ($status as $key => $value): ?>
           <?php if ($value['product_component_id'] == $row['product_component_id']) {
             $cek_stat = $value['status'];
             break;
           }else {
             $cek_stat = 'Y';
           } ?>
         <?php endforeach; ?>
          <td id="fp_cek_stat<?php echo $row['product_component_id'] ?>" style="text-align:center;background:<?php echo $cek_stat == 'Y'?'#359f70':'#ba2828' ?>;color:white" >
            <?php echo $cek_stat ?>
          </td>
          <td><?php echo '-' ?></td>
          <td><?php echo $row['memo_number'] ?></td>
          <td><?php echo $row['information'] ?></td>
          <td><?php echo $row['last_update_date'] ?></td>
          <td><?php echo $row['change_type'] ?></td>
          <td><?php echo $row['qty'] ?></td>
          <!-- 20 -->
          <td hidden><?php echo $row['product_component_id'] ?></td>
          <td><?php echo $row['jenis'] ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
<br>
<button type="button" class="btn btn-success fp_set_active" onclick="fp_set_inactive()" style="border-radius:7px;float:right;display:none" name="button"> <i class="fa fa-times"></i> <b id="txt_fp_stat">Set Inactive</b> </button>
<script type="text/javascript">

const fp_dt_warning = $('.dtfpfilteredwarning').DataTable({
  paging:false,
  dom: 'rtpi',
  // searching:false,
  scrollX: 'auto',
  scrollY: '70vh',
  scrollCollapse: true,
  columnDefs: [
    {
      orderable: false,
      className: 'select-checkbox',
      targets: 1
    }
  ],
  select: {
      style: 'single',
      selector: 'tr'
  },
  // order: [[0, 'asc']],
})

function searchWarning() {
  const datatable = $('.dtfpfilteredwarning').DataTable()
    var statCol = datatable.columns();
    var stat = $('#search_warning').val();
    datatable.search(stat);

    datatable.draw();
}

function fp_check_click_warning() {
  setTimeout(function () {
    let data_list = fp_dt_warning.rows( { selected: true } ).data()[0];
    // console.log($(`#${fp_cek_stat}${data_list[21]}`).html().trim());
    // console.log(data_list);
    if (data_list != undefined) {
      if ($(`#fp_cek_stat${data_list[21]}`).html().trim() == 'Y') {
        $('#txt_fp_stat_w').html('Set Inactive');
        $(".fp_set_active_warning").css("background", "#bb1e1e");
      }else {
        $('#txt_fp_stat_w').html('Set Active');
        $(".fp_set_active_warning").css("background", "");
      }
      $('.btn_fp_operation').removeAttr('disabled');
      $('.fp_set_active_warning').show();
    }else {
      $('.btn_fp_operation').attr('disabled', true);
      $('.fp_set_active_warning').hide();
    }
  }, 50);
}

// ===================== normal ========================
const fp_dt = $('.dt-fp-filtered').DataTable({
  paging:false,
  dom: 'rtpi',
  // searching:false,
  scrollX: 'auto',
  scrollY: '80vh',
  scrollCollapse: true,
  columnDefs: [
    {
      orderable: false,
      className: 'select-checkbox',
      targets: 1
    }
  ],
  select: {
      style: 'single',
      selector: 'tr'
  },
  // order: [[0, 'asc']],
})

function search_fp_comp() {
  const datatable = $('.dt-fp-filtered').DataTable()
    var statCol = datatable.columns();
    var stat = $('#search').val();
    datatable.search(stat);

    datatable.draw();
}

function fp_check_click() {
  setTimeout(function () {
    let data_list = fp_dt.rows( { selected: true } ).data()[0];
    // console.log(data_list[12]);
    if (data_list != undefined) {
      if (data_list[14] == 'Y') {
        $('#txt_fp_stat').html('Set Inactive');
        $(".fp_set_active").css("background", "#DD4B38");
      }else {
        $('#txt_fp_stat').html('Set Active');
        $(".fp_set_active").css("background", "");
      }
      $('.btn_fp_operation').removeAttr('disabled');
      $('.fp_set_active').show();
    }else {
      $('.btn_fp_operation').attr('disabled', true);
      $('.fp_set_active').hide();
    }
  }, 50);
}

function fp_set_pro() {
  $('.btn_fp_operation').attr('disabled', true);
  let data_list = fp_dt.rows( { selected: true } ).data()[0];
  let data_list_warning = fp_dt_warning.rows( { selected: true } ).data()[0];
  let type = data_list != undefined ? data_list[22] : data_list_warning[22];
  if ($('#fp_tipe_search').val() == 'se') {
    $('.fpselectproses').show()
    $('#code_product').text(data_list != undefined ? data_list[4] : data_list_warning[4])
  }else {
    $('.fpselectprosescheckoperation').show()
    $('#code_product_check_operation').text(data_list != undefined ? data_list[4] : data_list_warning[4])
  }
  $('#fpsimpanidsementara').val(data_list != undefined ? data_list[21] : data_list_warning[21]);
  $('#fpsimpanidsementara_desc').val(data_list != undefined ? data_list[5] : data_list_warning[5]);

  let ajaxx = $.ajax({
              url: baseurl + 'FlowProses/Operation/GetProsesByComponent',
              type: 'POST',
              // dataType: 'JSON',
              data: {
                product_component_id : data_list != undefined ? data_list[21] : data_list_warning[21],
                type : type,
              },
              beforeSend: function() {
                $('.fp-table-area').html(`<div id="loadingArea0">
                                            <center><img style="width: 5%;margin-bottom:13px" src="${baseurl}assets/img/gif/loading5.gif"><br>Loading...</center>
                                          </div>`);
              },
              success: function(result) {
                if (result != 0) {
                  console.log(type);
                  $('.fp-table-area').html(result);
                  $('#fp_jenis_produk_ok').html(type);
                  $('#fp_code_product_2').html(data_list != undefined ? data_list[4] : data_list_warning[4])

                }else {
                  swalFP('warning', 'Gagal Mengambil Data, Coba lagi..');
                  $('.fp_search_area').show()
                  $('.fp-table-area').html(``);
                }
              },
              error: function(XMLHttpRequest, textStatus, errorThrown) {
                swalFP('error', 'Something was wrong...')
                $('.fp_search_area').show()
                $('.fp-table-area').html(``);
              }
            })
}

function fp_set_inactive() {

  // if($('#fp_status1').is(':checked')) {
  //    type = $('#fp_status1').val()
  // }else {
  //    type = $('#fp_status2').val()
  // }
  let idcomp = '';
  let type = '';
  if (fp_dt_warning.rows( { selected: true } ).data()[0] != undefined) {
    idcomp = fp_dt_warning.rows( { selected: true } ).data()[0][21];
    type = fp_dt_warning.rows( { selected: true } ).data()[0][22];
  }else {
    idcomp = fp_dt.rows( { selected: true } ).data()[0][21];
    type = fp_dt.rows( { selected: true } ).data()[0][22];
  }
  // console.log(idcomp);
  // let cek = fp_dt.rows( { selected: true } ).data()[0][13];
  $.ajax({
    url: baseurl + 'FlowProses/Operation/set_inactive',
    type: 'POST',
    dataType: 'JSON',
    async: true,
    data: {
      product_component_id : idcomp,
      type : type,
    },
    beforeSend: function() {
      Swal.showLoading()
    },
    success: function(result) {
      if (result) {
        // if ($('#fp_tipe_search').val() == 'se') {
        // if (cek == 'Y') {
        //   $("#fp_cek_stat"+idcomp).css("background", "#ba2828");
        //   $("#fp_cek_stat"+idcomp).html('N')
        // }else {
        //   $("#fp_cek_stat"+idcomp).css("background", "#359f70");
        //   $("#fp_cek_stat"+idcomp).html('Y')
        // }
        // console.log(fp_dt.rows( { selected: true } ).data()[0][12]);
        fpselectcomponent()
        // }else {
        //   fpselectcheckoperation()
        // }
        toastFP('success', 'Status Berhasil Diperbarui.');
      }else {
        swalFP('warning', 'Gagal Melakukan Update Data, Coba lagi..');
      }
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
      swalFP('error', 'Something was wrong...')
    }
  })
}

</script>
