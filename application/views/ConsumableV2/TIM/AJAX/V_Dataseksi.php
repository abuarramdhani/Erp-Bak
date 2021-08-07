<table class="table table-bordered tbldataseksi" style="width:100%;text-align:center">
  <thead style="background: #f35325;color:white">
    <tr>
      <th class="text-center" style="width:5%">No</th>
      <th class="text-center">Seksi</th>
      <th class="text-center">PIC</th>
      <th class="text-center">VoIP</th>
      <th class="text-center">Jumlah Item</th>
      <th class="text-center" style="width:13%">Action</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($get as $key => $value): ?>
      <tr>
        <td><?php echo $key+1 ?></td>
        <td><?php echo $value['SEKSI'] ?></td>
        <td><?php echo $value['PIC'] ?></td>
        <td><?php echo $value['VOIP'] ?></td>
        <td>-</td>
        <td>
          <button type="button" class="btn" name="button" data-toggle="modal" style="border:1px solid #a8a8a8" data-target="#editmasterseksi"> <i class="fa fa-pencil"></i> Edit</button>
          <button type="button" class="btn" name="button ml-2" style="border:1px solid #a8a8a8" onclick="deldataseksi(<?php echo $value['KODESIE'] ?>)"> <i class="fa fa-trash"></i></button>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<script type="text/javascript">
$(document).ready(function() {
  $('.tbldataseksi').dataTable()
})
function deldataseksi(id) {
  Swal.fire({
    title: 'Apakah anda yakin?',
    text: "....",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, delete it!'
  }).then((result) => {
    if (result.value) {
      $.ajax({
      url: baseurl + 'consumabletimv2/action/delseksi',
      type: 'POST',
      data : {
        id : id
      },
      cache: false,
      // async:false,
      dataType: "JSON",
      beforeSend: function() {
        swaCSTLoading('Menghapus data')
      },
      success: function(result) {
        if (result == 'done') {
          toastCST('success', `Berhasil Dihapus`);
          csmdataseksi()
        }else {
          toastCST('warning', 'Terjadi Kesalahan Saat Menghapus Data! Harap Coba lagi');
        }
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
      swaCSTLarge('error', `${XMLHttpRequest.textStatus}`);
       console.error();
      }
      })
    }
  })

}
</script>
