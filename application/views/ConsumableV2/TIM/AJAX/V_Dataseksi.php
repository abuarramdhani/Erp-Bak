<table class="table table-bordered tbldataseksi" style="width:100%;text-align:center">
  <thead style="background: #f35325;color:white">
    <tr>
      <th class="text-center" style="width:5%">No</th>
      <th class="text-center">Seksi</th>
      <th class="text-center" style="width:25%">PIC</th>
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
        <td><?php echo $value['PIC'] ?><br><?php echo $value['NAMA'] ?></td>
        <td><?php echo $value['VOIP'] ?></td>
        <td><?php echo $value['JUMLAH'] ?></td>
        <td>
          <button type="button" class="btn" name="button" data-toggle="modal" style="border:1px solid #a8a8a8" data-target="#editmasterseksi" onclick="detaildataseksi(<?php echo $value['KODESIE'] ?>,'<?php echo $value['PIC'] ?>', '<?php echo $value['NAMA'] ?>', '<?php echo $value['VOIP'] ?>', '<?php echo $value['SEKSI'] ?>')"> <i class="fa fa-pencil"></i> Edit</button>
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

function detaildataseksi(kodesie, pic, name, voip, seksi) {
  $('.slc_csm_employ_').select2({
    placeholder: "Employee Name..",
    tags: true,
    allowClear:true,
    minimumInputLength: 1,
    ajax: {
      url: baseurl + "consumabletimv2/action/employee",
      dataType: "JSON",
      type: "POST",
      cache: false,
      data: function(params) {
        return {
          term: params.term,
          kodesie: kodesie
        };
      },
      processResults: function(data) {
        return {
          results: $.map(data, function(obj) {
            return {
              id: `${obj.nama} - ${obj.noind}`,
              text:`${obj.nama} - ${obj.noind}`
            }
          })
        }
      }
    }
  })
    $('#edtds_kodesie').val(kodesie);
    $('#edtds_voip').val(voip);
   $('#juduleditmasterseksi').text(seksi)
   $('.slc_csm_employ_').html('').trigger('change');
   $('.detailitembyseksi').DataTable().destroy();
   $('.detailitembyseksi tbody').html('')
   setTimeout(function () {
     var newOption = new Option(`${name} - ${pic}`, `${name} - ${pic}`, false, false);
     $('.slc_csm_employ_').append(newOption).trigger('change');

     $('.detailitembyseksi').dataTable({
       // dom: 'rtp',
       ajax: {
         data: (d) => $.extend({}, d, {
           kodesie: kodesie,    // optional
           // id_plan: null // optional
         }),
         url: baseurl + "consumabletimv2/action/getdetailitemseksi",
         type: 'POST',
       },
       language:{
         processing: "<div class='overlay custom-loader-background'><i class='fa fa-cog fa-spin custom-loader-color' style='color:#fff'></i></div>"
       },
       ordering: false,
       pageLength: 10,
       pagingType: 'first_last_numbers',
       processing: true,
       serverSide: true,
       preDrawCallback: function(settings) {
            if ($.fn.DataTable.isDataTable('.tblcsmpengajuankeb')) {
                var dt = $('.tblcsmpengajuankeb').DataTable();
                //Abort previous ajax request if it is still in process.
                var settings = dt.settings();
                if (settings[0].jqXHR) {
                    settings[0].jqXHR.abort();
                }
            }
        }
     })
   }, 605);

}
</script>
