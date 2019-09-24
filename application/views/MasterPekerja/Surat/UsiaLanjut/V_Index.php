<section class="content">
    <div class="inner" >
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-11">
                            <div class="text-right"><h2><b><?php echo $Title;?></b></h2></div>
                        </div>
                        <div class="col-lg-1">
                            <div class="text-right hidden-md hidden-sm hidden-xs">
                                <!-- Ganti yang di dalam site url dengan alamat main menu yang diinginkan -->
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('MasterPekerja/Surat/SuratUsiaLanjut');?>">
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
                                <h4 class="text-center header"><i class="fa fa-envelope"></i> Surat Pemberitahuan Usia Lanjut</h4>
                            </div>
                            <div class="box-body">
                             <div class="nav-tabs-custom">
                              <ul class="nav nav-tabs">
                                <li class="active"><a href="#daftarpkj" data-toggle="tab">Daftar Pekerja</a></li>
                                <li><a href="#suratpkj" data-toggle="tab">Daftar Surat</a></li>
                              </ul>
                              <div class="tab-content">
                              <div id="daftarpkj" class="tab-pane fade in active">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover text-left" id="usialanjut" .$new_table_name. "" style="font-size:12px;">
                                        <thead class="bg-primary">
                                            <tr>
                                                <th style="text-align:center;">No</th>
                                                <th style="text-align:center;">Action</th>
                                                <th style="text-align:center;">Noind</th>
                                                <th style="text-align:center;">Nama</th>
                                                <th style="text-align:center;">Seksi</th>
                                                <th style="text-align:center;">Tanggal Lahir</th>
                                                <th style="text-align:center;">Umur</th>
                                                <th style="text-align:center;">Sisa Waktu -/+</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                $no = 1; 
                                                foreach($DaftarPekerjaUsiaLanjut as $row):

                                                 $bithdayDate = substr($row['tgllahir'], 0, 10);
                                                    $date = new DateTime($bithdayDate);    
                                                    $now = new DateTime();    
                                                    $interval = $now->diff($date);    
                                                    $age = $interval->y;    
                                                    $usia = $age;

                                                        
                                                $date1 = $row['tglkeluar'];
                                                $date2 =  date('Y-m-d');

                                                $diff = abs(strtotime($date2) - strtotime($date1));

                                                $years = floor($diff / (365*60*60*24));
                                                $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
                                                $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
                                                $sisawaktu =  $years.' Tahun '.$months.' Bulan ';

                                                if ($years == '0') {
                                                    $sisawaktu =  $months.' Bulan ';
                                                }elseif ($months == '0') {
                                                    $sisawaktu =  $years.' Tahun ';
                                                    if ($years == '0') {
                                                        $sisawaktu = '1'.' Bulan ';
                                                    }
                                                }
                                                // echo "<pre>"; print_r($sisawaktu); exit();
                                            ?>
                                            <tr>
                                                <td align='center'><?php echo $no++;?></td>
                                                <td align='center' style="white-space: nowrap;">
                                                <?php if (empty( $row['tc'])) { ?>
                                                    <a style="margin-right:4px" href="<?php echo site_url('MasterPekerja/Surat/SuratUsiaLanjut/create/'.$row['noind'].''); ?>" data-toggle="tooltip" data-placement="bottom" title="Buat Surat"><span class="fa fa-pencil-square-o fa-2x"></span></a>
                                                <?php }else{ 
                                                    echo "SUDAH DIBUAT";
                                                    } ?>
                                                </td>
                                                <td><?php echo $row['noind'];?></td>
                                                <td><?php echo $row['nama'];?></td>
                                                <td><?php echo $row['seksi'];?></td>
                                                 <?php   ?>
                                                <td data-order="<?php echo substr($row['tgllahir'], 0, 10); ?>"><?php echo date_format(new DateTime($row['tgllahir']),"d-F-Y");;?></td>
                                                <td style="text-align: center;"><?php echo "$usia"." "."Tahun";?></td>
                                                <td data-order="<?php echo substr($row['tgllahir'], 0, 10); ?>"><?php echo $sisawaktu;?></td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>                                      
                                    </table>
                                    </div>
                                </div>
                                <div id="suratpkj" class="tab-pane fade in">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover text-left" id="tbl" .$new_table_name. "" style="font-size:12px;">
                                        <thead class="bg-primary">
                                            <tr>
                                                <th style="text-align:center;">No</th>
                                                <th style="text-align:center;">Action</th>
                                                <th style="text-align:center;">Nomor Surat</th>
                                                <th style="text-align:center;">Nomor Induk</th>
                                                <th style="text-align:center;">Nama</th>
                                                <th style="text-align:center;">Seksi</th>
                                                <th style="text-align:center;">Tanggal Cetak</th>
                                                <th style="text-align:center;">Update Terakhir</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                $no = 1; 
                                                foreach($DaftarSuratUsiaLanjut as $row):
                                            ?>
                                            <tr>
                                                <td align='center'><?php echo $no++;?></td>
                                                <td align='center' style="white-space: nowrap;">
                                                    <a target="_blank" style="margin-right:4px" href="<?php echo base_url('MasterPekerja/Surat/SuratUsiaLanjut/previewcetak/'.$row['noind'].''); ?>" data-toggle="tooltip" data-placement="bottom" title="Preview Cetak"><span class="fa fa-file-pdf-o fa-2x"></span></a>
                                                    <a style="margin-right:4px" href="<?php echo base_url('MasterPekerja/Surat/SuratUsiaLanjut/update/'.$row['noind'].''); ?>" data-toggle="tooltip" data-placement="bottom" title="Edit Data"><span class="fa fa-pencil-square-o fa-2x"></span></a>
                                                    <a href="<?php echo base_url('MasterPekerja/Surat/SuratUsiaLanjut/delete/'.$row['noind'].''); ?>" data-toggle="tooltip" data-placement="bottom" title="Hapus Data" onclick="return confirm('Are you sure you want to delete this item?');"><span class="fa fa-trash fa-2x"></span></a>
                                                </td>
                                                <td><?php echo $row['no_surat'].'/'.$row['kode'].'/'.date('m', strtotime($row['tanggal_cetak'])).'/'.date('Y', strtotime($row['tanggal_cetak'])); ?></td>
                                                <td style="text-align:center;"><?php echo $row['noind'];?></td>
                                                <td><?php echo $row['nama'];?></td>
                                                <td><?php echo $row['seksi'];?></td>
                                                <td style="text-align:center;"><?php echo $row['tanggal_cetak'];?></td>
                                                <td style="text-align:center;"><?php if (empty($row['terakhir_update'])) {
                                                   echo "Belum Pernah Dirubah";
                                                }else{
                                                    echo $row['terakhir_update'];
                                                } ;?></td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>                                      
                                    </table>
                                    </div>
                                </div>
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