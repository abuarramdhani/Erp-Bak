<section class="content">
    <div class="inner" >
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-11">
                            <div class="text-right"><h1><b><?= $Title ?></b></h1></div>
                        </div>
                        <div class="col-lg-1">
                            <div class="text-right hidden-md hidden-sm hidden-xs">
                                <a class="btn btn-default btn-lg" href="<?php echo base_url('MasterPekerja/Other');?>">
                                    <i class="icon-wrench icon-2x"></i>
                                    <br/>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <br/>
                
                <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border">    
                                <span style="font-size: 20px;">Halaman Data Pekerja Dinas Luar</span>
                            </div>
                            <div class="box-body">
                                 <div class="row" style="margin: 10px 10px">
                                    <div class="form-group">
                                      <div class="col-sm-1">
                                        <a class="btn btn-primary" href="<?php echo site_url('Presensi/PresensiDL') ?>">Pencarian</a>
                                      </div>
                                    </div> 
                                </div>
                                <br>
                                <?php if($Pencarian == 'data'){ ?>
                                <table class="table table-bordered prs-table-presensi-dl">
                                  <thead>
                                    <th class="text-center">No</th>
                                    <th class="text-center">Tanggal</th>
                                    <th class="text-center">Noind</th>
                                    <th class="text-center">Kodesie</th>
                                    <th class="text-center">Jam</th>
                                  </thead>
                                  <tbody>
                                    <?php 
                                        $no = 0;
                                        foreach ($Presensi as $item) {
                                          $no++;
                                          echo "
                                            <tr>
                                                <td class='text-center'>".$no."</td>
                                                <td class='text-center'>".$item['tanggal']."</td>
                                                <td class='text-center'>".$item['noind']."</td>
                                                <td class='text-center'>".$item['kodesie']."</td>
                                                <td class='text-center'>".$item['waktu']."</td>
                                            </tr>
                                          ";
                                        }
                                    ?>
                                  </tbody>
                                </table>
                                <?php }else{ ?>
                                 <table class="table table-bordered prs-table-presensi-dl">
                                  <thead>
                                    <th class="text-center">No</th>
                                    <th class="text-center">Noind</th>
                                    <th class="text-center">Kodesie</th>
                                    <th class="text-center">Tanggal</th>
                                    <th class="text-center">Jml DL</th>
                                    <th class="text-center">File</th>
                                  </thead>
                                  <tbody>
                                    <?php 
                                        $no = 0;
                                        foreach ($ConvertPresensi as $item) {
                                          $no++;
                                          echo "
                                            <tr>
                                                <td class='text-center'>".$no."</td>
                                                <td class='text-center'>".$item['noind']."</td>
                                                <td class='text-center'>".$item['kodesie']."</td>
                                                <td class='text-center'>".$item['tanggal']."</td>
                                                <td class='text-center'>".$item['jml_dl']."</td>
                                                <td class='text-center'><a href='http://quick.com/aplikasi/dinas-luar-online/pekerja/C_PKJ/surat_tugas_pdf?spdlid=".$item['spdl_id']."' target='blank'>Surat Tugas</a></td>
                                            </tr>
                                          ";
                                        }
                                    ?>
                                  </tbody>
                                </table>
                                <?php } ?>
                            </div> 
                        </div>
                    </div>
                </div>  
            </div>    
        </div>
    </div>
</section>

