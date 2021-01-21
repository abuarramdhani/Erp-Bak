<div style="margin-top:8px;">
  <label class="label label-secondary ckmb_data" style="color:black;font-size:13px;box-shadow: 0 1px 1px 0 rgba(0,0,0,0.14), 0 2px 1px -1px rgba(0,0,0,0.12), 0 1px 3px 0 rgba(0,0,0,0.20);">
    Nomor PO : <strong class="text-primary"><?php echo $no_po ?></strong>
  </label>
</div>
<div style="margin-top:12px">
  <label class="label label-secondary ckmb_data" style="color:black;font-size:13px;box-shadow: 0 1px 1px 0 rgba(0,0,0,0.14), 0 2px 1px -1px rgba(0,0,0,0.12), 0 1px 3px 0 rgba(0,0,0,0.20);">
    Surat Jalan : <strong class="text-primary"><?php echo $surat_jalan ?></strong>
  </label>
</div>
<hr>
<div class="table-responsive">
  <table class="table table-striped table-bordered table-hover text-left tbl_mon_ckmb" style="font-size:12px;">
    <thead>
      <!-- <tr class="bg-success">
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
      </tr> -->
      <tr class="bg-success">
        <th style="width:5%"><center>No</center></th>
        <th><center>Kode Barang</center></th>
        <th><center>Deskripsi</center></th>
        <th><center>Tipe</center></th>
        <th><center>Produk</center></th>
        <th><center>Warna KIB</center></th>
        <th style="width:10%"><center>No Serial</center></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($get_engine as $key => $var): ?>
        <tr row-id="<?php echo $var['SEGMENT1'] ?>">
          <td style="text-align:center"><?php echo $key+1 ?></td>
          <td style="text-align:center"><?php echo $var['SEGMENT1'] ?></td>
          <td style="text-align:center"><?php echo $var['DESCRIPTION'] ?></td>
          <td style="text-align:center"><?php echo $var['TYPE'] ?></td>
          <td style="text-align:center"><?php echo $var['PRODUK'] ?></td>
          <td style="text-align:center"><?php echo $var['WARNA_KIB'] ?></td>
          <td style="text-align:center">
            <button type="button" class="btn btn-primary btn-sm" name="button" onclick="detail_serial('<?php echo $no_po ?>', '<?php echo $surat_jalan ?>', '<?php echo $var['SEGMENT1'] ?>', '<?php echo $var['RECEIPT_DATE'] ?>')" style="font-weight:bold"> <i class="fa fa-eye"></i> Serial</button>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<br>

<script type="text/javascript">
const tableckmb = $('.tbl_mon_ckmb').DataTable({
  ordering:false,
  // search: {
  // "caseInsensitive": false
  // },
  // initComplete: function() {},
  // processing: true,
  // serverSide: true,
  // "order": [],
  // "ajax": {
  //   url: baseurl + 'CetakKIBMotorBensin/CKMB/getMaster',
  //   type: "POST",
  //   data: (d) => $.extend({}, d, {
  //     range_date: $('.tanggal_ckmb').val(),
  //     tipe: $('.select2_ckmb').val()
  //   }),
  // },
  // "bSort": false,
})

function list_detail_form(d, segment1) {
  return `<div class="table_detail_${segment1}"></div>`;
}

function detail_serial(no_po, surat_jalan, segment1, receipt_date) {
  let tr = $(`tr[row-id="${segment1}"]`);
  let row = tableckmb.row(tr);
  if ( row.child.isShown() ) {
       row.child.hide();
       tr.removeClass('shown');
  }else {
      row.child( list_detail_form(row.data(), segment1)).show();
      tr.addClass('shown');
      $.ajax({
        url: baseurl + 'CetakKIBMotorBensin/CKMB/getSerial',
        type: 'POST',
        data: {
          no_po: no_po,
          surat_jalan: surat_jalan,
          segment1: segment1,
          receipt_date: receipt_date
        },
        beforeSend: function() {
          $('.table_detail_'+segment1).html(`<center><img src="${baseurl}/assets/img/gif/loading5.gif" style=" margin: auto; width: 5%;"><br><b>Sedang Menyiapkan Data..</b>.<center>`);
        },
        success: function(result) {
          $('.table_detail_'+segment1).show();
          $('.table_detail_'+segment1).html(result);
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
          console.error();
        }
      })
  }
}



let myTable = $('#tblMonitoringDPB').DataTable({
  // fixedHeader: true
});

function format_detail( d, no ){

}

function detail1(rm, no, alamat_kirim, tujuan) {

}

</script>
