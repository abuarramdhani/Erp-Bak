<hr>
<p class="label label-success" style="font-size:13px;">Showing Data With Range Date <strong style="color:#ffe492"><?php echo $range_date ?></strong> and Type Engine <strong style="color:#ffe492"><?php echo $tipe ?></strong></p>
<br>
<br>
<div class="table-responsive">
  <table class="table table-striped table-bordered table-hover text-left tbl_mon_ckmb" style="font-size:12px;text-align:center">
    <thead>
      <tr class="bg-success">
        <th rowspan="2" style="width:5%"><center>No</center></th>
        <th rowspan="2"><center>Palet</center></th>
        <th colspan="2"><center>Sebelum Dilengkapi</center></th>
        <th colspan="2" style="border-right:0px;"><center>Setelah Ditelengkapi</center></th>
        <th rowspan="2" style="border-left:0.5px solid white;"><center>Produk</center></th>
        <th rowspan="2"><center>Warna KIB</center></th>
        <th rowspan="2"><center>Tipe</center></th>
        <th rowspan="2"><center>No Seri</center></th>
      </tr>
      <tr class="bg-success" >
        <th style="border-top:0"><center>Kode Barang</center></th>
        <th style="border-top:0"><center>Type Engine</center></th>
        <th style="border-top:0"><center>Kode Barang</center></th>
        <th style="border-top:0"><center>Type Engine</center></th>
      </tr>
      <!-- <tr class="bg-success">
        <th style="width:5%"><center>No</center></th>
        <th><center>Palet</center></th>
        <th><center>Kode Barang</center></th>
        <th><center>Nama Barang</center></th>
        <th><center>Tipe</center></th>
        <th><center>No Seri</center></th>
      </tr> -->
    </thead>
    <tbody>

    </tbody>
  </table>
</div>

<center>
  <button type="button" name="button" class="btn btn-danger" onclick="cetakCKMB()" style="font-weight:bold"> <i class="fa fa-file-pdf-o"></i> Cetak QR </button>
  <button type="button" name="button" class="btn btn-success" onclick="checklistCKMB()" style="margin-left:10px;font-weight:bold"> <i class="fa fa-file-pdf-o"></i> Cetak Checklist </button>
</center>
<br>

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
