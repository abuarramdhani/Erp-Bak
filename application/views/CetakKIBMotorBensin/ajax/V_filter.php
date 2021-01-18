<!-- <input type="hidden" id="range_date__" value="<?php echo $range_date ?>">
<input type="hidden" id="ckmd_tipe__" value="<?php echo $tipe ?>"> -->
<div class="table-responsive">
  <table class="table table-striped table-bordered table-hover text-left tbl_mon_ckmb" style="font-size:12px;text-align:center">
    <thead>
      <tr class="bg-success">
        <th><center>No</center></th>
        <th><center>Palet</center></th>
        <th><center>Kode Barang</center></th>
        <th><center>Nama Barang</center></th>
        <th><center>Tipe</center></th>
        <th><center>No Seri</center></th>
        <th><center>Aksi</center></th>
      </tr>
    </thead>
    <tbody>

    </tbody>
  </table>
</div>

<center>
  <button type="button" name="button" class="btn btn-danger" onclick="cetakCKMB()"> <i class="fa fa-file-pdf-o"></i> Cetak QR </button>
  <button type="button" name="button" class="btn btn-success" onclick="checklistCKMB()" style="margin-left:10px;"> <i class="fa fa-file-pdf-o"></i> Cetak Checklist </button>
</center>

<script type="text/javascript">

const tableckmb = $('.tbl_mon_ckmb').DataTable({
  search: {
  "caseInsensitive": false
  },
  initComplete: function() {},
  processing: true,
  serverSide: true,
  "order": [],
  "ajax": {
    url: baseurl + 'CetakKIBMotorBensin/CKMB/getMaster',
    type: "POST",
    data: (d) => $.extend({}, d, {
      range_date: $('.tanggal_ckmb').val(),
      tipe: $('.select2_ckmb').val()
    }),
  },
  "bSort": false,
  // lengthMenu: [ 10, 25, 50, 75, 100 , 1000],
})

function cetakCKMB (){
  const range_tanggal = $('.tanggal_ckmb').val();
  let range = range_tanggal.split(' - ');
  const tipe = $('.select2_ckmb').val();
  window.open(`${baseurl}CetakKIBMotorBensin/pdf/${range[0]}/${range[1]}/${tipe}`);
}

function checklistCKMB() {
  const range_tanggal = $('.tanggal_ckmb').val();
  let range = range_tanggal.split(' - ');
  const tipe = $('.select2_ckmb').val();
  window.open(`${baseurl}CetakKIBMotorBensin/Checklist/${range[0]}/${range[1]}/${tipe}`);
}

</script>
