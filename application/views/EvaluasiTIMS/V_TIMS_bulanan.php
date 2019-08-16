<style>
 /*div.dt-buttons {
    float: center;
}*/
.table-striped > tbody > tr:nth-child(2n+1) > td, .table-striped > tbody > tr:nth-child(2n+1) > th {
   background-color: #bcd5eb;
}
.dataTables_paginate{
    float: right;
}
.dataTables_length{
    float: left;
}
</style>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
<section class="content">
    <div class="inner" >
        <div class="row">
            <div class="col-lg-12">
                <div class="col-lg-11">
                    <div class="text-right">
                        <h1><b>TIMS Bulanan</b></h1>
                    </div>
                </div>
                <div class="col-lg-1">
                    <div class="text-right hidden-md hidden-sm hidden-xs">

                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-11"></div>
                        <div class="col-lg-1 "></div>
                    </div>
                </div>
                <br />
                <div class="">
                    <div class="col-lg-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border"></div>
                            <div class="box-body">
                                <div class="panel-body">
                                   <div class="row">
                                    <form id="formTimsBulanan" class="col-md-12" method="post" action="<?php echo site_url('EvaluasiTIMS/Bulanan'); ?>">
                                        <div class="form-inline">
                                            <div class="col-md-12">
                                                <label style="margin-top: 5px;" class="col-sm-2 col-form-label" for="name">Periode :</label>
                                                <div class="col-md-4">
                                                    <input type="text" class="form-control MasterPekerja-daterangepicker" style="width: 100%;" name="et_periode" required="">
                                                </div>
                                            </div>
                                            <div class="col-md-12 form-group" style="margin-top: 10px;">
                                                <label style="margin-top: 5px;" class="col-sm-2 col-form-label" for="name">Jenis Penilaian :</label>
                                                <div class="col-md-4">
                                                    <select type="text" class="form-control et_select_jp" style="width: 100%;" name="et_jenis_jp" id="" required="">
                                                        <option></option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-12 form-group" style="margin-top: 10px;">
                                                <label style="margin-top: 5px;" class="col-sm-2 col-form-label" for="name">Pilih :</label>
                                                <div class="col-md-4">
                                                    <select style="width: 100%;" name="evt_pilih" type="text" class="form-control" id="evt_pilih">
                                                        <option value="0" selected>Semua</option>
                                                        <option id="1" value="1">Departemen</option>
                                                        <option id="2" value="2">Bidang</option>
                                                        <option id="3" value="3">Unit</option>
                                                        <option id="4" value="4">Seksi</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-12 form-group" style="margin-top: 10px;">
                                                <label id="evt_lbl_pilih" style="margin-top: 5px;" class="col-sm-2 col-form-label" for="name">Pilihan :</label>
                                                <div class="col-md-4">
                                                    <select multiple="multiple" style="width: 100%;" disabled="" name="evt_departemen[]" required="" type="text" class="form-control" id="evt_departemen2">
                                                    </select>
                                                </div>
                                                <button disabled="" type="submit" style="margin-left: 20px;" class="btn btn-primary bt_et_harian">Search</button>
                                            </div>
                                        </div>
                                    </form>
                                    <script>
                                        var jp = '<?php echo $jp; ?>';
                                        var pr = '<?php echo $pr; ?>'
                                    </script>
                                    <?php if ($val == '1'): ?>
                                        <div style="margin-top: 100px;">
                                                <p align="center" style="color: black;font-weight: bold; font-size: 24px; text-align: center;"><?php
                                                    $pri = str_replace(' - ', ' sd ', $pr);
                                                    $Nper = explode(' - ', $pr);
                                                    echo $jp.'<br>Periode '.date('d-M-Y', strtotime($Nper[0])).' sd '.date('d-M-Y', strtotime($Nper[1])).'<br>'.$nama; ?></p>
                                            <table class="table table-bordered table-striped table-hover text-center tb_et_bulanan">
                                                    <input hidden="" id="p2k3_judul" value="<?php echo 'Evaluasi TIMS Bulanan - '.$jp.' '.$pri; ?>">
                                                    <thead>
                                                        <tr class="bg-primary">
                                                            <th class="bg-primary">No</th>
                                                            <th class="bg-primary">No Induk</th>
                                                            <th class="bg-primary" style="min-width: 100px;">Nama</th>
                                                            <th style="min-width: 80px;">Tgl Masuk</th>
                                                            <th>Unit</th>
                                                            <th>Seksi</th>
                                                            <th style="min-width: 80px;">Lama Kerja</th>
                                                            <th>T</th>
                                                            <th>I</th>
                                                            <th>M</th>
                                                            <th>S</th>
                                                            <th>PSP</th>
                                                            <th>IP</th>
                                                            <th>CT</th>
                                                            <th>SP</th>
                                                            <th>TIM</th>
                                                            <th>TIMS</th>
                                                            <th>Prediksi M</th>
                                                            <th>Prediksi TIM</th>
                                                            <th>Prediksi TIMS</th>
                                                            <th>Prediksi Lolos</th>
                                                            <th>Keterangan</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $a = 1; foreach ($listLt as $key): ?>
                                                        <tr>
                                                            <td><?php echo $a; ?></td>
                                                            <td>
                                                                <a target="_blank" href="<?php echo site_url('RekapTIMSPromosiPekerja/RekapTIMS/employee/'.$key['tanggal_awal_rekap'].'/'.$key['tanggal_akhir_rekap'].'/'.$key['nik']); ?>">
                                                                    <?php echo $key['noind']; ?>
                                                                </a>
                                                            </td>
                                                            <td>
                                                                <a target="_blank" href="<?php echo site_url('RekapTIMSPromosiPekerja/RekapTIMS/employee/'.$key['tanggal_awal_rekap'].'/'.$key['tanggal_akhir_rekap'].'/'.$key['nik']); ?>">
                                                                    <?php echo $key['nama']; ?>
                                                                </a>
                                                            </td>
                                                            <td data-order="<?php echo $key['tgl_masuk']; ?>"><?php echo date('d-M-Y', strtotime($key['tgl_masuk'])); ?></td>
                                                            <td><?php echo $key['unit']; ?></td>
                                                            <td><?php echo $key['seksi']; ?></td>
                                                            <td><?php echo $key['masa_kerja']; ?></td>
                                                            <td><?php echo $key['telat']; ?></td>
                                                            <td><?php echo $key['ijin']; ?></td>
                                                            <td><?php echo $key['mangkir']; ?></td>
                                                            <td><?php echo $key['sk']; ?></td>
                                                            <td><?php echo $key['psp']; ?></td>
                                                            <td><?php echo $key['ip']; ?></td>
                                                            <td><?php echo $key['ct']; ?></td>
                                                            <td><?php echo $key['sp']; ?></td>
                                                            <td><?php echo $key['tim']; ?></td>
                                                            <td><?php echo $key['tims']; ?></td>
                                                            <td><?php echo round($key['pred_m'],2); ?></td>
                                                            <td><?php echo round($key['pred_tim'],2); ?></td>
                                                            <td><?php echo round($key['pred_tims'],2); ?></td>
                                                            <td><?php echo $key['pred_lolos']; ?></td>
                                                            <?php if ($key['ket'] == 'PERPANJANGAN'): ?>
                                                                <td>
                                                                    <a onclick="evt_ayoJalan('<?php echo $key['noind']; ?>', '<?php echo $jpi; ?>')" class="" data-noind="<?php echo $key['noind']; ?>" data-penilaian="<?php echo $jpi; ?>" style="cursor: pointer;"><?php echo $key['ket']; ?></a>
                                                                </td>
                                                            <?php else: ?>
                                                                <td><?php echo $key['ket']; ?></td>
                                                            <?php endif ?>
                                                        </tr>
                                                        <?php $a++; endforeach ?>
                                                    </tbody>
                                                </table>
                                                <form target="_blank" method="post" action="<?php echo site_url('EvaluasiTIMS/Bulanan/exportBulanan'); ?>">
                                                    <input hidden="" value="<?php echo $pr; ?>" name="tgl">
                                                    <input hidden="" value="<?php echo $jpi; ?>" name="jp">
                                                    <input hidden="" value="<?php echo $nama; ?>" name="nama">
                                                    <input hidden="" value="<?php echo $s; ?>" name="ess">
                                                    <button type="submit" hidden="" id="et_submitPDF" style="width: 55px; height: 31px;">PDF</button>
                                                    <br>
                                                    <br>
                                                    <h4><b>Keterangan :</b></h4>
                                                    <textarea name="tx_keterangan" style="margin-top: 20px;" class="form-control tx_et_bulanan"></textarea>
                                                </form>
                                                <!-- <button type="submit" class="dt-buttons evt_test" style="width: 53px; height: 31px;">test</button> -->
                                            </div>
                                        <?php endif ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="modal fade" id="evt_perpanjangan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="exampleModalLabel" style="font-weight: bold;">TIMS 6 Bulan Masa OJT</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="phone_result" class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
            </div>
        </div>
    </div>
</div>
<div hidden id="surat-loading" style="top: 0;left: 0;right: 0;bottom: 0; margin: auto; position: fixed; background: rgba(0,0,0,.5); z-index: 11;">
    <img src="http://erp.quick.com/assets/img/gif/loadingtwo.gif" style="position: fixed; top: 0;left: 0;right: 0;bottom: 0; margin: auto; width: 40%;">
</div>
<script>
    $(document).ready(function(){
        var check = function(){
            if ($("#DataTables_Table_0_length")[0]) {
                // alert('ada');
                $("#DataTables_Table_0_length").find("select").css('width', '60px');
                $("input[type=search]").css('width', '200px');
                var a = $('#DataTables_Table_0_wrapper').width();
                var l = $('#DataTables_Table_0_length').find('label').width();
                // alert(l);
                var mar = (a/2)-l-100;
                // $('div.dt-buttons').css('padding-left', mar+'px');
            }else{
                // alert('nope');
            }
        }
        setTimeout(check, 100);
        var judul = 'Evaluasi TIMS Bulanan - '+jp+' '+pr;
        // alert(judul);

        var tabell = $('.tb_et_bulanan').DataTable({
            scrollX: true,
            dom: 'lfrtpB',
            scrollCollapse: true,
            fixedColumns:   {
                leftColumns: 3,
            },
            buttons: [
            {
                extend: 'excelHtml5',
                title:  judul,
                exportOptions: {
                    columns: ':visible'
                }
                // customize: function(doc) {
                //   doc.defaultStyle.alignment = 'center'
                // }
            },
          //   {
          //       extend: 'pdfHtml5',
          //       messageBottom: judul,
          //       title:  judul,
          //       orientation: 'landscape',
          //       pageSize: 'LEGAL',
          //       customize: function(doc) {
          //           doc.content.splice(0, 1, {
          //             text: [{
          //               text: 'Lampiran \n',
          //               bold: false,
          //               alignment: 'left',
          //               fontSize: 12
          //                     },
          //                     {
          //               text: judul+'\n',
          //               bold: false,
          //               alignment: 'center',
          //               fontSize: 14
          //                     }],
          //                     alignment: 'bottom',
          //                   });
          //         doc.defaultStyle.alignment = 'center',
          //         doc.defaultStyle.fontSize = 8;
          //     }
          // }
          ]
      });
        tabell.columns.adjust().draw();
        $('div.btn-group').append('<button id="et_clickPDF" class="btn btn-default buttons-excel buttons-html5">PDF</button>');
        $('#et_clickPDF').click(function(){
            $('#et_submitPDF').click();
        });
    });
</script>