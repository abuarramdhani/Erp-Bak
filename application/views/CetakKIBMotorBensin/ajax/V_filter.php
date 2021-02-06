<hr>
<p class="label label-secondary ckmb_if_change" style="font-size:13px;display:none; color:black">Klik <strong style="color:#2bb476">Filter</strong> kembali untuk menampilkan data yang anda pilih</p>
<p class="label label-success ckmb_data" style="font-size:13px;margin-bottom:5px;">Menampilkan Data Rentang Tanggal <strong style="color:#ffe492"><?php echo $range_date ?></strong></p>
<br>
<div class="ckmb_data" style="margin-top:18.5px;">
  <div class="row">
    <div class="col-md-3">
      <?php foreach ($get_po as $key => $value): ?>
        <button type="button" onclick="show_table_engine('<?php echo $value['PO_NUMBER'] ?>', '<?php echo $value['SHIPMENT_NUMBER'] ?>')" class="btn btn-primary" name="button" style="text-align:center;width:100%;margin-top:7px;">
          Nomor PO : <strong><?php echo $value['PO_NUMBER'] ?></strong><br>Surat Jalan : <?php echo $value['SHIPMENT_NUMBER'] ?>
        </button><br>
      <?php endforeach; ?>
    </div>
    <div class="col-md-9 area-table-engine-ckmb">

    </div>
  </div>
</div>

<script type="text/javascript">

function show_table_engine(no_po, surat_jalan) {
  $.ajax({
    url: baseurl + 'CetakKIBMotorBensin/CKMB/getTableEngine',
    type: 'POST',
    // dataType: 'JSON',
    data: {
      no_po : no_po,
      surat_jalan : surat_jalan,
    },
    cache:false,
    beforeSend: function() {
      $('.area-table-engine-ckmb').html(`<div style ="width: 70%;margin:auto;height: 30%;background: #fff;overflow: hidden;z-index:
      9999;padding:20px 0 30px 0;border-radius:10px;text-align:center">
                                <img style="width: 6%;" src="${baseurl}assets/img/gif/loading5.gif"><br>
                                <span style="font-size:14px;font-weight:bold">Sedang memuat data...</span>
                            </div>`);
    },
    success: function(result) {
      if (result !== 0) {
        $('.area-table-engine-ckmb').html(result);
      }else {
        $('.area-table-engine-ckmb').html(`<div style ="width: 70%;margin:auto;height: 30%;background: #fff;overflow: hidden;z-index:
        9999;padding:20px 0 30px 0;border-radius:10px;text-align:center">
                                  <br>
                                  <span style="font-size:14px;font-weight:bold">Engine kosong.</span>
                              </div>`);
      }
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
    swalAppLarge('error', textStatus)
     console.error();
    }
  })
}

// function cek_param_ckmb() {
//   if ($('.select2_ckmb').val() == '') {
//     swalAppLarge('warning', 'Sebelum Cetak, Pilih Type Engine Terlebih Dahulu');
//   }
// }
// karena tidak ada id unik;
function ckmb_update_serial(no_po, sj, segment1, receipt_date) {
  let key = $(`.ckmb_serial_key_${segment1}`).val();
  let serial_baru = $(`.ckmb_serial_${segment1}`).val();
  let s_lama = $(`#ckmd_txt_serial_old_${segment1}`).text();
  $.ajax({
    url: baseurl + 'CetakKIBMotorBensin/CKMB/updateSerial',
    type: 'POST',
    dataType: 'JSON',
    data: {
      no_po : no_po,
      surat_jalan : sj,
      segment1 : segment1,
      receipt_date : receipt_date,
      serial_lama : s_lama,
      serial_baru : serial_baru
    },
    cache:false,
    beforeSend: function() {
      toastCKMBLoading('Sedang mengupdate serial..')
    },
    success: function(result) {
      if (result == 1) {
        toastCKMBExc('success', 'Berhasil mengupdate serial!');
        $(`.ckmb_update_serial_terbaru_${segment1}_${s_lama}`).text(serial_baru);
        $(`.ckmb_update_serial_terbaru_${segment1}_${s_lama}`).css('color', '#006bc2');
        $(`.ckmb_update_serial_terbaru_${segment1}_${s_lama}`).attr('onclick', `ckmb_set_param('${serial_baru}', ${key}, '${segment1}')`);
        $(`button[punya="serial_${segment1}_${key}"]`).removeClass(`ckmb_update_serial_terbaru_${segment1}_${s_lama}`).addClass(`ckmb_update_serial_terbaru_${segment1}_${serial_baru}`);

        $('#modal-kib-motor-bensin-'+segment1).modal('toggle');
      }else if (result == 2) {
        toastCKMBExc('warning', `Kode Serial ${serial_baru} telah ada di Kode Barang ${segment1} - PO ${no_po} - SJ ${sj.replace("__", "/")}`);
      }else {
        toastCKMBExc('warning', 'Tidak berhasil mengupdate serial, coba lagi..');
      }
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
    swalAppLarge('error', textStatus)
     console.error();
    }
  })
}

function ckmb_set_param(serial, key, segment1) {
  $('.ckmb_serial_'+segment1).val(serial);
  $('.ckmb_serial_key_'+segment1).val(key);
  $('#ckmd_txt_serial_old_'+segment1).text(serial);
}

</script>
