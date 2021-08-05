<table class="table table-bordered tbl_cst_apprkeb" style="width:100%;text-align:center">
  <thead class="bg-primary">
    <tr>
      <th class="text-center" style="width:5%">No</th>
      <th class="text-center" style="width:40%">Seksi</th>
      <th class="text-center" style="width:15%">PIC</th>
      <th class="text-center" style="width:10%">VoIP</th>
      <th class="text-center">Jumlah Item</th>
      <th class="text-center" style="width:10%">Action</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($approvalkebutuhan as $key => $value): ?>
      <tr>
        <td><?php echo $key+1 ?></td>
        <td><?php echo $value['seksi'] ?></td>
        <td></td>
        <td></td>
        <td><?php echo $value['jumlah_item'] ?></td>
        <td>
          <button type="button" class="btn" name="button" data-toggle="modal" data-target="#detailitem-approval-cst" title="detail" onclick="detailapprovalcst('<?php echo $value['kodesie'] ?>', '<?php echo $value['seksi'] ?>')"> <i class="fa fa-eye"></i> Detail Item</button>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<script type="text/javascript">
  $('.tbl_cst_apprkeb').dataTable()

  function detailapprovalcst(kodesie, seksi) {
    apporreject = 1;
    $('#seksiapprovalpengajuan').text(seksi)
    $.ajax({
    url: baseurl + 'consumabletimv2/action/detailitemapproval',
    type: 'POST',
    data : {
      kodesie : kodesie
    },
    cache: false,
    // dataType: "JSON",
    beforeSend: function() {
      $('.areaapprovalpengajuan').html(`<div style ="width: 70%;margin:auto;height: 30%;background: #fff;overflow: hidden;z-index: 9999;padding:20px 0 30px 0;border-radius:10px;text-align:center">
                                          <img style="width: 8%;" src="${baseurl}assets/img/gif/loading5.gif"><br>
                                          <span style="font-size:14px;font-weight:bold">Sedang memuat form input...</span>
                                      </div>`)
    },
    success: function(result) {
      $('.areaapprovalpengajuan').html(result)
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
    swaCSTLarge('error', XMLHttpRequest);
     console.error();
    }
    })
  }
</script>
