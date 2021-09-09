<!-- <style media="screen">
   .active > a{
    background-color: red !important;
    border-color: red !important;
  }
</style> -->
<div class="table-responsive" >
    <table class="datatable table table-bordered table-hover table-striped text-center tblManifest" id="tblManifest" style="width: 100%;">
        <thead class="bg-primary">
            <tr>
                <th style="width: 5%; vertical-align: middle;"></th>
                <th style="width: 5%; vertical-align: middle;">No</th>
                <th style="vertical-align: middle;">No SPB/DOSP</th>
                <th style="width: 5%; vertical-align: middle;">Jumlah Item</th>
                <th style="width: 5%; vertical-align: middle;">Jumlah Pcs</th>
                <th style="width: 15%; vertical-align: middle;">Ekspedisi</th>
                <th style="width: 5%; vertical-align: middle;">Total Packing</th>
                <th style="width: 5%; vertical-align: middle;">Total Berat (KG)</th>
                <th style="vertical-align: middle;">PIC Packing</th>
                <th style="width: 20%; vertical-align: middle;">Keterangan Marketing</th>
            </tr>
        </thead>
        <tbody>
            <?php $i=0; $no=1; foreach($value as $val) { ?>
                <tr id="baris<?= $val['REQUEST_NUMBER']?>">
                    <td style="width: 5%">

                    </td>
                    <td style="width: 5%">
                        <?= $no; ?>
                    </td>
                    <td style="font-size:17px; font-weight: bold"><?= $val['REQUEST_NUMBER']?></td>
                    <td style="width: 5%">
                        <?= $val['JUMLAH_ITEM']?>
                    </td>
                    <td style="width: 5%">
                        <?= $val['JUMLAH_PCS']?>
                    </td>
                    <td style="width: 15%">
                        <?= $val['EKSPEDISI']?>
                    </td>
                    <td>
                        <?= $val['TTL_COLLY']?>
                    </td>
                    <td>
                        <?= $val['TTL_BERAT'] ?>
                    </td>
                    <td>
                        <?= $val['PIC_PACKING'] ?>
                    </td>
                    <td style="width: 20%">
                        <?= $val['KETERANGAN'] ?>
                    </td>
                </tr>
            <?php $no++; $i++; } ?>
        </tbody>
    </table>
</div>
<br>
<button type="button" class="btn btn-primary text-bold" style="float: right;" onclick="createPenyerahanKGSP()"> <i class="fa fa-pied-piper-alt"></i> Create</button>
<!-- <a href="<?php echo base_url('KapasitasGdSparepart/Penyerahan/generateManifestNum') ?>" target="_blank" class="btn btn-danger btn-sm"><i class="fa fa-file-pdf-o"> Cetak</i></a> -->

<script type="text/javascript">
  let table_penyerahan_kgsp = $('#tblManifest').DataTable({
    info: false,
    // searching: false,
    columnDefs: [
      {
        orderable: false,
        className: 'select-checkbox',
        targets: 0
      }
    ],
    select: {
        style: 'multi',
        selector: 'td:nth-child(1)'
    },
  });

  const swaKGGSLarge = (type, a) =>{
  Swal.fire({
    allowOutsideClick: false,
    type: type,
    showConfirmButton: 'Ok!',
    html: a,
    // onBeforeOpen: () => {
    // Swal.showLoading()
    // }
  })
}
const swaKGGSBiasa = (type, a) =>{
Swal.fire({
  type: type,
  html: `<span style="font-weight:500">${a}<span>`,
  showConfirmButton: false,
  allowOutsideClick: false,
  timer: 1500
})
}
const swaKGGSLoading = (a) =>{
  Swal.fire({
    allowOutsideClick: false,
    // type: type,
    // cancelButtonText: 'Ok!',
    html: `<div style="font-weight:400">${a}</div>`,
    onBeforeOpen: () => {
      Swal.showLoading()
    }
  })
}

  function createPenyerahanKGSP() {
      let ekspedisi = $('#jenisEksped').val();

      let row = table_penyerahan_kgsp.rows( { selected: true } ).data();
      let count = table_penyerahan_kgsp.rows( { selected: true } ).count();
      let REQUEST_NUMBER = [];

      row.each((v,i)=>{
        REQUEST_NUMBER.push(v[2]); // perhatikan jika menambah kolom
      });
      if (count > 0) {
        console.log(REQUEST_NUMBER);
        $.ajax({
            url: baseurl + 'KapasitasGdSparepart/Penyerahan/generateManifestNum',
            type: 'POST',
            dataType: 'JSON',
            beforeSend: function() {
              swaKGGSLoading('Sedang membuat nomor manifest...')
            },
            success: function(result) {
              swaKGGSBiasa('success', `Nomor Manifest Berhasil Dibuat <b>${result}</b>`)
              setTimeout(function () {
                $.ajax({
                    url: baseurl + 'KapasitasGdSparepart/Penyerahan/cekudatransactblm',
                    type: 'POST',
                    dataType: 'JSON',
                    data: {
                      request_number : REQUEST_NUMBER
                    },
                    beforeSend: function() {
                      swaKGGSLoading('Sedang melakukan pengecekan..')
                    },
                    success: function(res1) {
                      if (res1.status == 407) {
                        swaKGGSLarge('warning', res1.message);
                      }else if (res1.status == 200) {
                        $.ajax({
                            url: baseurl + 'KapasitasGdSparepart/Penyerahan/savePenyerahan',
                            type: 'POST',
                            dataType: 'JSON',
                            data: {
                              request_number : REQUEST_NUMBER,
                              no_manifest : result,
                              ekspedisi : ekspedisi
                            },
                            beforeSend: function() {
                              swaKGGSLoading('Sedang Menyimpan dan Melakukan Transact Data..')
                            },
                            success: function(res2) {
                              if (res2.status == 500) {
                                swaKGGSLarge('warning', res2.message);
                              }else if (res2.status == 200) {
                                swaKGGSBiasa('success', 'Selesai.')
                                sudah_manifest()
                                manifest()
                              }
                            },
                            error: function(XMLHttpRequest, textStatus, errorThrown) {
                              swaKGGSLarge('error', 'Terdapat Kesalahan')
                              console.error();
                            }
                        })
                      }
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                      swaKGGSLarge('error', 'Terdapat Keasalahan Saat Melakukan Pengecekan REQUEST_NUMBER')
                      console.error();
                    }
                })
              }, 1500);
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
              swaKGGSLarge('error', 'Terdapat Kesalahan Saat Generate No Manifest')
              console.error();
            }
        })
      }else {
        swaKGGSLarge('info', 'Harap memilih request_number yang akan diserahkan!')
      }
      // $.ajax({
      //     url: baseurl + 'KapasitasGdSparepart/Penyerahan/generateManifestNum',
      //     type: 'POST',
      //     dataType: 'JSON',
      //     beforeSend: function() {
      //         Swal.showLoading();
      //     },
      //     success: function(result) {
      //         Swal.fire({
      //             title: "Sukses",
      //             text: "Berhasil membuat manifest!!",
      //             type: "success"
      //         }).then(function() {
      //             // $('#inputSPBMan').val();
      //             manifest();
      //             sudah_manifest();
      //         })
      //     }
      // })
  }
</script>
