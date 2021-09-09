<table class="table table-bordered tbl_cst_apprkeb" style="width:100%;text-align:center">
  <thead style="background: #f35325;color:white">
    <tr>
      <th class="text-center" style="width:5%">No</th>
      <th class="text-center" style="width:40%">Seksi</th>
      <th class="text-center" style="width:15%">PIC</th>
      <th class="text-center" style="width:10%">VoIP</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($get as $key => $value): ?>
      <tr>
        <td><?php echo $key+1 ?></td>
        <td><?php echo $value['SEKSI'] ?></td>
        <td><?php echo $value['PIC'] ?>  <br> <?php echo $value['NAMA'] ?> </td>
        <td><?php echo $value['VOIP'] ?></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<script type="text/javascript">
  $('.tbl_cst_apprkeb').dataTable()

  function detailapprovalcstitem(kodesie, seksi) {
    apporreject = 1;
    $('#seksiapprovalpengajuanitem').text(seksi)
    $.ajax({
    url: baseurl + 'consumabletimv2/action/detailitemapproval2',
    type: 'POST',
    data : {
      kodesie : kodesie
    },
    cache: false,
    // dataType: "JSON",
    beforeSend: function() {
      $('.areaapprovalpengajuan2').html(`<div style ="width: 70%;margin:auto;height: 30%;background: #fff;overflow: hidden;z-index: 9999;padding:20px 0 30px 0;border-radius:10px;text-align:center">
                                          <img style="width: 8%;" src="${baseurl}assets/img/gif/loading5.gif"><br>
                                          <span style="font-size:14px;font-weight:bold">Sedang memuat form input...</span>
                                      </div>`)
    },
    success: function(result) {
      $('.areaapprovalpengajuan2').html(result)
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
    swaCSTLarge('error', XMLHttpRequest);
     console.error();
    }
    })
  }
</script>
