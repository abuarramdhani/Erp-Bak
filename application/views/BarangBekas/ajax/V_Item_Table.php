<style media="screen">

  .tbl_histo_timbang thead tr th{
    position: sticky;
    background: #337ab7;
    top: 0;
    flex: 0 0 auto;
    z-index: 10;
  }

  .tbl_histo_timbang td{
    vertical-align: middle !important;
    text-align:center;
  }
</style>
<div class="alert bg-success alert-dismissible pbb_hide_001">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <p><i class="icon fa fa-warning"></i>Sekilas Info! Klik angka berat timbang(*jika sudah terisi) di kolom <b>Terima</b> untuk <b>me-reset</b> berat timbang.</p>
</div>

<div class="table-responsive">
    <strong style="font-size:20px;color:#3c8dbc" class="pbbt_type">Tipe Dokumen : <?php echo $get[0]['TYPE_DOCUMENT'] ?></strong>
    <table class="table table-bordered table_pbbt mt-3" style="width:100%">
      <thead class="bg-primary">
        <tr>
          <th class="text-center" style="width:5%; !important">No</th>
          <th class="text-center">Item Code</th>
          <?php if ($get[0]['TYPE_DOCUMENT'] == 'PBB-S'){ ?>
            <th class="text-center" style="width:10%">Onhand</th>
          <?php } ?>
          <th class="text-center" style="width:10%;">Jumlah</th>
          <th class="text-center" style="width:10%;">UOM</th>
          <th class="text-center" style="width:10%;">Terima</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($get as $key => $value): ?>
          <tr >
            <td class="text-center"><?php echo $key+1 ?></td>
            <td class="text-center">
              <?php echo $value['ITEM'] ?> - <?php echo $value['DESCRIPTION'] ?>
            </td>
            <?php if ($get[0]['TYPE_DOCUMENT'] == 'PBB-S'){ ?>
              <td class="text-center"><?php echo $value['ONHAND'] ?></td>
            <?php } ?>
            <td class="text-center"><?php echo $value['JUMLAH'] ?></td>
            <td class="text-center"><?php echo $value['UOM'] ?></td>
            <td class="text-center t_berat_timbang kolom_selesai_timbang_<?php echo $value['ID_PBB'] ?>">
               <?php if ($value['NO_URUT_TIMBANG'] != 999){ ?>
                 <button type="button" class="btn btn-success btn-sm" onclick="pbbTimbang(<?php echo $value['ID_PBB'] ?>)" name="button" data-toggle="modal" data-target="#modal-pbb-transact-ambil-berat"> <i class="fa fa-download"></i> <b>Timbang</b></button>
               <?php }else{ ?>
                 <b onclick="pbbResetTimbang(<?php echo $value['ID_PBB'] ?>)"><?php echo $value['BERAT_TIMBANG'] ?> KG</b>
               <?php } ?>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
</div>

<div class="modal fade bd-example-modal-md" id="modal-pbb-transact-ambil-berat" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content" style="border-radius: 5px !important; background-color:transparent !important; box-shadow:none;">
      <div class="panel-body">
        <div class="row">
         <form class="form_pbb_timbang" action="" method="post">
          <div class="col-lg-12">
            <div class="box box-primary box-solid">
              <div class="box-header with-border">
                <div style="float:left">
                  <h4 style="font-weight:bold;">Ambil Berat Timbang (<span id="pbb_item_timbang"></span></h4>
                </div>
                <button type="button" class="btn btn-danger" style="float:right;font-weight:bold;float:right" data-dismiss="modal"><i class="fa fa-close"></i></button>
              </div>
              <div class="box-body">
                <div class="row mb-2">
                  <div class="col-md-12 pbb-area-timbang" style="margin-top:5px">

                  </div>
                </div>
              </div>
              <div class="box-footer">
                <div class="row">
                  <div class="col-md-12 mt-2">
                    <button type="submit" class="btn btn-primary" style="float:left;font-weight:bold" name="button"> <i class="fa fa-file"></i> Save</button>
                    <button type="button" class="btn btn-success btn_selesai_timbang" disabled style="float:right;font-weight:bold" name="button"> <i class="fa fa-check"></i> Selesai Timbang</button>
                  </div>
                </div>
              </div>
            </div>
      		</div>
          </form>
      	</div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  $(document).ready(function () {

    $('#pbbt_seksi').val("<?php echo $get[0]['SEKSI'] ?>");
    $('#pbbt_cost_center').val("<?php echo $get[0]['COST_CENTER'] ?>");

    if ('<?php echo $get[0]['TYPE_DOCUMENT'] ?>' === 'PBB-S') {
      $('#pbbt_subinv_check').removeAttr('hidden');
      $('#pbbt_locator_check').removeAttr('hidden');

      $('#pbbt_subinv').val('<?php echo $get[0]['SUB_INVENTORY'] ?>');
      $('#pbbt_locator').val('<?php echo $get[0]['LOCATOR'] ?>');
    }else {
      $('#pbbt_subinv_check').attr('hidden', 'hidden');
      $('#pbbt_locator_check').attr('hidden', 'hidden');
      $('#pbbt_subinv').val('');
      $('#pbbt_locator').val('');
    }

    // setTimeout(function () {
    //   $('.pbb_hide_001').hide();
    // }, 5500);
  })

  function pbbTimbang(id_primary) {
    $.ajax({
      url: baseurl + 'BarangBekas/transact/ambilItem',
      type: 'POST',
      dataType: 'JSON',
      data: {
        id: id_primary
      },
      cache:false,
      beforeSend: function() {
        $('.pbb-area-timbang').html('<center><b>Sedang Mengambil Data...</b></center>');
        $('#pbb_item_timbang').html(`)`);
      },
      success: function(result) {
        $('.btn_selesai_timbang').attr('onclick', `pbb_selesai_timbang(${id_primary})`);
        $('#pbb_item_timbang').html(`${result.SEGMENT1}) <br> <span style="font-size:12px;">${result.DESCRIPTION}</span>`);
        $('.pbb-area-timbang').html(`<div class="pbb-status-timbang"></div><br>
                                     <input type="hidden" name="id_pbb" value="${id_primary}">
                                     <input type="hidden" name="history_timbang_pbb" value="${result.HISTORY_TIMBANG_MB === null ? '' : result.HISTORY_TIMBANG_MB}">
                                     <input type="hidden" name="no_urut_timbang" value="${result.NO_URUT_TIMBANG === null ? 0 : result.NO_URUT_TIMBANG}">
                                     <input type="hidden" name="berat_timbang_before" value="${result.BERAT_TIMBANG === null ? 0 : result.BERAT_TIMBANG}">
                                      <label for="">Berat dari Timbangan</label>
                                      <div class="row">
                                        <div class="col-md-11">
                                          <input type="text" class="form-control" name="berat_timbang" autocomplete="off" required value="">
                                        </div>
                                        <div class="col-md-1" style="padding-top:6px;padding-left:1px">
                                          <b>KG</b>
                                        </div>
                                      </div>`);

        if (result.HISTORY_TIMBANG_MB === null) {
          $('.pbb-status-timbang').html(`<i><b>*Belum ada data timbangan sebelumnya</b></i>`);
        }else {
          $('.btn_selesai_timbang').removeAttr('disabled');

          let tampung_histo = $('input[name="history_timbang_pbb"]').val().split(',');
          let tampung_tr = '';
          let ut = 1;
          if (tampung_histo != '') {
            tampung_histo.forEach((v,i) => {
              tampung_tr+=`<tr class="row_${i}">
                            <td style="vertical-align:middle;" class="text-center">${Number(i)+1}</td>
                            <td style="vertical-align:middle;" class="text-center edit_berat_histo">${v}</td>
                            <td style="vertical-align:middle;" class="text-center"><button type="button" onclick="update_histo_timbang_before(${i}, ${v})" class="btn btn-primary text-bold pbbite">Ubah</button> <button type="button" class="btn btn-danger text-bold" onclick="delete_histo_timbang_before(${i}, ${v})">Hapus</button></td>
                          </tr>`;
                          ut=Number(i)+1
            })
          }

          let detail_berat_timbang = `<div style="height:200px;overflow-y:auto;border:1px solid #ababab"><table style="width:100%;" class="tbl_histo_timbang table table-bordered">
                                        <thead class="bg-primary">
                                          <tr>
                                            <th style="width:15%;text-align:center">No</th>
                                            <th style="text-align:center">Berat</th>
                                            <th style="width:32%;text-align:center">Edit</th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                          ${tampung_tr}
                                        </tbody>
                                      </table></div>`;
          $('.pbb-status-timbang').html(`${detail_berat_timbang}<i><b>*Total berat dari hasil timbang ke 1 sampai ${ut} = <span class="text-success"> ${result.BERAT_TIMBANG} KG</span> </b></i>`);
        }

        setTimeout(function () {
          $('input[name="berat_timbang"]').focus();
        }, 1000);
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
      swalPBB('error', 'Koneksi Terputus...')
       console.error();
      }
    })

  }

  function update_histo_timbang_before(n, val) {
    let elemenslc = $(`.row_${n}`).find('.edit_berat_histo').html(`<input type="number" class="form-control value_histo_timbang_edit" value="${val}">`);
    $(`.row_${n}`).find(`.pbbite`).attr('onClick',`update_pbbite(${n}, ${val})`).html('Done').removeClass('btn-primary').addClass('btn-success');;
    // console.log(elemenslc);
  }

  function update_pbbite(n, val_asli) {
    let val_telah_diubah = $(`.row_${n}`).find('.value_histo_timbang_edit').val();
    if (val_telah_diubah == val_asli) {
      $(`.row_${n}`).find('.edit_berat_histo').html(val_asli);
      $(`.row_${n}`).find(`.pbbite`).attr('onClick',`update_histo_timbang_before(${n}, ${val_asli})`).html('Ubah').removeClass('btn-success').addClass('btn-primary');
    }else {
      let master_data = $('input[name="history_timbang_pbb"]').val().split(',');
      master_data[n] = val_telah_diubah;
      let count_berat = 0;
      master_data.forEach((v,i) => {
        count_berat += Number(v);
      })
      $.ajax({
        url: baseurl + 'BarangBekas/transact/updateBeratTimbang',
        type: "POST",
        data: {
          ID_PBB : $('input[name="id_pbb"]').val(),
          BERAT_TIMBANG : count_berat,
          HISTORY_TIMBANG_MB : master_data.join(',')
        },
        cache: false,
        beforeSend : function(){
          toastPBBLoading('Sedang memproses..');
        },
        success: function(data){
          let id = $('input[name="id_pbb"]').val();
          if (data == 1) {
            toastPBB('success','Berhasil memperbarui data!');
            pbbTimbang(id);
          }else {
            toastPBB('warning','Galat, hubungi ict produksi!');
          }
        },
        error: function(e){
          swalPBB('error', 'Koneksi Terputus...');
          console.error();
        }
      });
      console.log(master_data, val_telah_diubah, 'ini...');
    }
  }

  function delete_histo_timbang_before(n, val) {
    $(`.row_${n}`).remove();
    let master_data = $('input[name="history_timbang_pbb"]').val().split(',');
    master_data.splice(n,1)
    let count_berat = 0;
    master_data.forEach((v,i) => {
      count_berat += Number(v);
    })
    $.ajax({
      url: baseurl + 'BarangBekas/transact/updateBeratTimbang',
      type: "POST",
      data: {
        ID_PBB : $('input[name="id_pbb"]').val(),
        BERAT_TIMBANG : count_berat,
        HISTORY_TIMBANG_MB : master_data.join(',')
      },
      cache: false,
      beforeSend : function(){
        toastPBBLoading('Sedang memproses..');
      },
      success: function(data){
        let id = $('input[name="id_pbb"]').val();
        if (data == 1) {
          toastPBB('success','Berhasil memperbarui data!');
          pbbTimbang(id);
        }else {
          toastPBB('warning','Galat, hubungi ict produksi!');
        }
      },
      error: function(e){
        swalPBB('error', 'Koneksi Terputus...');
        console.error();
      }
    });
  }

  $(".form_pbb_timbang").on('submit',(function(e) {
    e.preventDefault();
    let tampung_berat_timbang_all = [];
    let berat_before = $('input[name="berat_timbang_before"]').val();
    let berat_sekarang = $('input[name="berat_timbang"]').val();
    let berat_history_before = $('input[name="history_timbang_pbb"]').val();

    if (berat_history_before != '') {
      tampung_berat_timbang_all.push(berat_history_before)
    }

    tampung_berat_timbang_all.push(berat_sekarang);
    let gabung2 = tampung_berat_timbang_all.join(',');
    $('input[name="history_timbang_pbb"]').val(gabung2)
    // console.log(tampung_berat_timbang_all.join(','));

    let count_berat = 0;
    gabung2.split(',').forEach((v,i) => {
      count_berat += Number(v);
    })

    $.ajax({
      url: baseurl + 'BarangBekas/transact/updateBeratTimbang',
      type: "POST",
      data: {
        ID_PBB : $('input[name="id_pbb"]').val(),
        NO_URUT_TIMBANG : Number($('input[name="no_urut_timbang"]').val()) + 1,
        BERAT_TIMBANG : count_berat,
        HISTORY_TIMBANG_MB : tampung_berat_timbang_all.join(',')
      },
      cache: false,
      beforeSend : function(){
        toastPBBLoading('Sedang memproses..');
      },
      success: function(data){
        let id = $('input[name="id_pbb"]').val();
        if (data == 1) {
          toastPBB('success','Berhasil menyimpan data!');
          pbbTimbang(id);
        }else {
          toastPBB('warning','Galat, hubungi ict produksi!');
        }
      },
      error: function(e){
        swalPBB('error', 'Koneksi Terputus...');
        console.error();
      }
    });
  }));

  function pbbResetTimbang(id) {
    Swal.fire({
      title: 'Yakin ingin mengedit berat timbang?',
      html: "Total berat timbang akan terisi lagi setelah anda me-klik tombol <b>Selesai Timbang</b>",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, saya yakin!'
    }).then((result) => {
      if (result.value) {
        $.ajax({
          url: baseurl + 'BarangBekas/transact/updateBeratTimbang',
          type: 'POST',
          dataType: 'JSON',
          cache:false,
          data: {
            ID_PBB : id,
            NO_URUT_TIMBANG : 1
          },
          beforeSend: function() {
            toastPBBLoading('Sedang mengupdate data...');
          },
          success: function(result) {
            if (result == 1) {
              toastPBB('success', 'Berat timbang berhasil reset, klik timbang untuk mengedit.');
              $(`.kolom_selesai_timbang_${id}`).html(`<button type="button" class="btn btn-success btn-sm" onclick="pbbTimbang(${id})" name="button" data-toggle="modal" data-target="#modal-pbb-transact-ambil-berat"> <i class="fa fa-download"></i> <b>Timbang</b></button>`);
            }else {
              toastPBB('warning', 'Gagal Melakukan Update Data, Coba lagi..');
            }
          },
          error: function(XMLHttpRequest, textStatus, errorThrown) {
            swalPBB('error', 'Koneksi Terputus...');
            console.error();
          }
        })
      }
    })
  }

  function pbb_selesai_timbang(id) {
    Swal.fire({
      title: 'Apakah anda yakin?',
      text: "Pastikan tidak ada yang terlewat !",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, saya yakin!'
    }).then((result) => {
      if (result.value) {
        $.ajax({
          url: baseurl + 'BarangBekas/transact/updateBeratTimbang',
          type: 'POST',
          dataType: 'JSON',
          cache:false,
          data: {
            ID_PBB : id,
            NO_URUT_TIMBANG : 999
          },
          beforeSend: function() {
            toastPBBLoading('Sedang mengupdate data...');
          },
          success: function(result) {
            if (result == 1) {
              toastPBB('success', 'Berat timbang berhasil disimpan.');
              $(`.kolom_selesai_timbang_${id}`).html(`<b onclick="pbbResetTimbang(${id})">${$('input[name="berat_timbang_before"]').val()} KG</b>`);
              $('#modal-pbb-transact-ambil-berat').modal('toggle');
            }else {
              toastPBB('warning', 'Gagal Melakukan Update Data, Coba lagi..');
            }
          },
          error: function(XMLHttpRequest, textStatus, errorThrown) {
            swalPBB('error', 'Koneksi Terputus...');
            console.error();
          }
        })
      }
    })
  }

</script>
