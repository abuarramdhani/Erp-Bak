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
                                                <?php echo $jp; ?> - <?php echo $dept; ?>
                                            </h3>
                                        </div>
                                    </form>
                                    <script>
                                        var jp = '<?php echo $jp; ?>';
                                        var pr = "<?php echo date('Y-m-d'); ?>";
                                    </script>
                                    <table style="" class="table table-striped table-bordered table-hover text-center tbl_et_rekap">
                                        <thead>
                                            <tr class="bg-primary">
                                                <th>No</th>
                                                <th>No Induk</th>
                                                <th>Nama</th>
                                                <th style="min-width: 100px;">Tgl Masuk</th>
                                                <th>Unit</th>
                                                <th>Seksi</th>
                                                <th style="min-width: 100px;">Lama Kerja</th>
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
                                                <td><?php echo $key['ket']; ?></td>
                                            </tr>
                                            <?php $a++; endforeach ?>
                                        </tbody>
                                    </table>
                                    <form target="_blank" method="post" action="<?php echo site_url('EvaluasiTIMS/Bulanan/exportHarian'); ?>">
                                        <input hidden="" value="<?php echo date('Y-m-d'); ?>" name="tgl">
                                        <input hidden="" value="<?php echo $jpi; ?>" name="jp">
                                        <input hidden="" value="<?php echo $dept; ?>" name="nama">
                                        <button type="submit" class="dt-buttons" style="width: 53px; height: 31px;">PDF</button>
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
<script>
    $(document).ready(function(){
        var judul = 'Evaluasi TIMS Bulanan - '+jp+' '+pr;
        // alert(judul);

        var tabell = $('.tbl_et_rekap').DataTable({
            scrollX: true,
            dom: 'lfrtpB',
            responsive: true,
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
    });
</script>