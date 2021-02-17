<div class="table-responsive">
    <div class="panel-body">
      <strong style="font-size:20px;" class="pbbt_type">Type : <?php echo $get[0]['TYPE_DOCUMENT'] ?></strong>
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
              <td class="text-center kolom_selesai_timbang_<?php echo $value['ID_PBB'] ?>">
                 <?php if ($value['NO_URUT_TIMBANG'] != 999){ ?>
                   <button type="button" class="btn btn-success btn-sm" onclick="pbbTimbang(<?php echo $value['ID_PBB'] ?>)" name="button" data-toggle="modal" data-target="#modal-pbb-transact-ambil-berat"> <i class="fa fa-download"></i> <b>Timbang</b></button>
                 <?php }else{ ?>
                   <b><?php echo $value['BERAT_TIMBANG'] ?> KG</b>
                 <?php } ?>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
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
                                     <input type="hidden" name="no_urut_timbang" value="${result.NO_URUT_TIMBANG === null ? 0 : result.NO_URUT_TIMBANG}">
                                     <input type="hidden" name="berat_timbang_before" value="${result.BERAT_TIMBANG === null ? 0 : result.BERAT_TIMBANG}">
                                        <label for="">Berat dari Timbangan</label>
                                        <div class="row">
                                          <div class="col-md-11">
                                            <input type="number" class="form-control" name="berat_timbang" value="">
                                          </div>
                                          <div class="col-md-1" style="padding-top:6px;padding-left:1px">
                                            <b>KG</b>
                                          </div>
                                        </div>`);

        if (result.BERAT_TIMBANG === null) {
          $('.pbb-status-timbang').html(`<i><b>*Belum ada data timbangan sebelumnya</b></i>`);
        }else {
          $('.btn_selesai_timbang').removeAttr('disabled');
          $('.pbb-status-timbang').html(`<i><b>*Total berat dari timbang ke ${result.NO_URUT_TIMBANG} = <span class="text-success"> ${result.BERAT_TIMBANG} KG</span> </b></i>`);
        }
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
      swalPBB('error', 'Koneksi Terputus...')
       console.error();
      }
    })

  }

  $(".form_pbb_timbang").on('submit',(function(e) {
    e.preventDefault(); //mencegah reload saat ada form submit
    $.ajax({
      url: baseurl + 'BarangBekas/transact/updateBeratTimbang',
      type: "POST",
      data:  {
        ID_PBB : $('input[name="id_pbb"]').val(),
        NO_URUT_TIMBANG : Number($('input[name="no_urut_timbang"]').val()) + 1,
        BERAT_TIMBANG : Number($('input[name="berat_timbang_before"]').val()) + Number($('input[name="berat_timbang"]').val())
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

  function pbb_selesai_timbang(id) {
    Swal.fire({
      title: 'Apakah anda yakin?',
      text: "Anda tidak akan dapat mengembalikan ini!",
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
              toastPBB('success', 'Data Berhasil Dihapus.');
              $(`.kolom_selesai_timbang_${id}`).html(`<b>${$('input[name="berat_timbang_before"]').val()} KG</b>`);
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
