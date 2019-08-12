<style type="text/css">
    .dataTables_paginate{
        float: right;
    }
    .dataTables_length{
        float: left;
    }
    .dataTables_filter input { width: 50px }
    .table-striped > tbody > tr:nth-child(2n+1) > td, .table-striped > tbody > tr:nth-child(2n+1) > th {
     background-color: #bcd5eb;
 }
</style>
<section class="content">
    <div class="inner" >
        <div class="row">
            <div class="col-lg-12">
                <div class="col-lg-11">
                    <div class="text-right">
                        <h1><b>TIMS Harian</b></h1>
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
                                    <form class="col-12 text-center">
                                        <div class="form-inline">
                                            <h3>
                                                <b><?php echo $jp; ?> - <?php echo $dept; ?></b>
                                            </h3>
                                        </div>
                                    </form>
                                    <script>
                                        var jp = '<?php echo $jp; ?>';
                                        var pr = "<?php echo date('Y-m-d'); ?>";
                                    </script>
                                    <table style="" class="table table-striped table-striped table-bordered table-hover text-center tbl_et_rekap">
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
                                                <th style="min-width: 100px;">Prediksi Lolos</th>
                                                <th style="min-width: 100px;">Keterangan</th>
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
                                                <td><?php echo date('d-M-Y', strtotime($key['tgl_masuk'])); ?></td>
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
                                                        <a class="evt_noint_per" data-noind="<?php echo $key['noind']; ?>" data-penilaian="<?php echo $jpi; ?>" style="cursor: pointer;"><?php echo $key['ket']; ?></a>
                                                    </td>
                                                <?php else: ?>
                                                    <td><?php echo $key['ket']; ?></td>
                                                <?php endif ?>
                                            </tr>
                                            <?php $a++; endforeach ?>
                                        </tbody>
                                    </table>
                                    <form target="_blank" method="post" action="<?php echo site_url('EvaluasiTIMS/Bulanan/exportHarian'); ?>">
                                        <input hidden="" value="<?php echo date('Y-m-d'); ?>" name="tgl">
                                        <input hidden="" value="<?php echo $jpi; ?>" name="jp">
                                        <input hidden="" value="<?php echo $dept; ?>" name="nama">
                                        <button type="submit" hidden="" id="et_submitPDF" style="width: 53px; height: 31px;">PDF</button>
                                        <br>
                                        <br>
                                        <textarea name="tx_keterangan" style="margin-top: 20px;" class="form-control tx_et_bulanan"></textarea>
                                    </form>
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
        var judul = 'Evaluasi TIMS Bulanan - '+jp+' '+pr;
        // alert(judul);

        var tabell = $('.tbl_et_rekap').DataTable({
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
            },
            ]
        });
        tabell.columns.adjust().draw();
       
        setTimeout(function() {
             $("input[type=search]").css('width', '200px');
         }, 100);
             $('div.btn-group').append('<button id="et_clickPDF" class="btn btn-default buttons-excel buttons-html5">PDF</button>');
            $('#et_clickPDF').click(function(){
                $('#et_submitPDF').click();
            });

            $('.evt_noint_per').click(function(){
            $('#surat-loading').attr('hidden', false);
             var noind = $(this).attr('data-noind');
             var nilaian = $(this).attr('data-penilaian');
                $.ajax({
                 url: "<?php echo base_url() ?>EvaluasiTIMS/Bulanan/detail_perpanjangan",
                    method: "POST",
                    data: {noind:noind, nilai:nilaian},
                    success: function(data){
                        $('#surat-loading').attr('hidden', true);
                     $('#phone_result').html(data);
                        $('#evt_perpanjangan').modal('show');
                    }
                });
         });
    });
</script>