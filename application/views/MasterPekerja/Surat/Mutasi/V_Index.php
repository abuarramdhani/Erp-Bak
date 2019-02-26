<section class="content">
    <div class="inner" >
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-11">
                            <div class="text-right"><h1><b><?php echo $Title;?></b></h1></div>
                        </div>
                        <div class="col-lg-1">
                            <div class="text-right hidden-md hidden-sm hidden-xs">
                                <!-- Ganti yang di dalam site url dengan alamat main menu yang diinginkan -->
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('MasterPekerja/Surat/SuratMutasi');?>">
                                    <i class="icon-wrench icon-2x"></i>
                                    <br/>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <br/>
<!--                 <?php 
                if (date('i') >= '16') {
                 echo '<h1>aw</h1>';
                }
                 echo date('i');
                  ?> -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border">
                                <a href="<?php echo site_url('MasterPekerja/Surat/SuratMutasi/create') ?>" style="float:right;margin-right:1%;margin-top:-0.5%;" alt="Add New" title="Add New" >
                                    <button type="button" class="btn btn-default btn-sm"><i class="icon-plus icon-2x"></i></button>
                                </a>
                            </div>
                            <div class="box-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover text-left" id="tbl" .$new_table_name. "" style="font-size:12px;">
                                        <thead class="bg-primary">
                                            <tr>
                                                <th style="text-align:center;">No</th>
                                                <th style="text-align:center;">Action</th>
                                                <th style="text-align:center;">Tanggal Berlaku</th>
                                                <th style="text-align:center;">Nomor Surat</th>
                                                <th style="text-align:center;">Nomor Induk</th>
                                                <th style="text-align:center;">Nama</th>
                                                <th style="text-align:center;">Kodesie Lama</th>
                                                <th style="text-align:center;">Kodesie Baru</th>
                                                <th style="text-align:center;">Lokasi Kerja Lama</th>
                                                <th style="text-align:center;">Lokasi Kerja Baru</th>
                                                <th style="text-align:center;">Tanggal Cetak</th>
                                                <th style="text-align:center;">Cetak</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                $no = 1; 
                                                foreach($view as $surat) //<----------------------------------
                                                {
                                                    $parameter  =   strtotime($surat['tanggal_cetak'])."/".$this->general->enkripsi($surat['kode'])."/".$this->general->enkripsi($surat['no_surat']);
                                            ?>
                                            <tr>
                                                <td align='center'><?php echo $no++;?></td>
                                                <td align='center' style="white-space: nowrap;">
                                                    <a target="_blank" style="margin-right:4px" href="<?php echo base_url('MasterPekerja/Surat/SuratMutasi/previewcetak/'.$parameter.''); ?>" data-toggle="tooltip" data-placement="bottom" title="Preview Cetak"><span class="fa fa-file-pdf-o fa-2x"></span></a>
                                                    <a style="margin-right:4px" href="<?php echo base_url('MasterPekerja/Surat/SuratMutasi/update/'.$parameter.''); ?>" data-toggle="tooltip" data-placement="bottom" title="Edit Data"><span class="fa fa-pencil-square-o fa-2x"></span></a>
                                                    <a href="<?php echo base_url('MasterPekerja/Surat/SuratMutasi/delete/'.$parameter.''); ?>" data-toggle="tooltip" data-placement="bottom" title="Hapus Data" onclick="return confirm('Are you sure you want to delete this item?');"><span class="fa fa-trash fa-2x"></span></a>
                                                </td>
                                                <td><?php echo $surat['tanggal_berlaku'];?></td>
                                                <td><?php echo $surat['no_surat'].'/'.$surat['kode'];?></td>
                                                <td><?php echo $surat['noind'];?></td>
                                                <td><?php echo $surat['nama'];?></td>
                                                <td>
                                                    <?php
                                                        if(($surat['seksi_lama'])=='-')
                                                        {
                                                            if(($surat['unit_lama'])=='-')
                                                            {
                                                                if(($surat['bidang_lama'])=='-')
                                                                {
                                                                    echo 'Departemen '.$surat['dept_lama'];
                                                                }
                                                                else
                                                                {
                                                                    echo 'Bidang '.$surat['bidang_lama'];
                                                                }
                                                            }
                                                            else
                                                            {
                                                                echo 'Unit '.$surat['unit_lama'];
                                                            }
                                                        }
                                                        else
                                                        {
                                                            echo 'Seksi '.$surat['seksi_lama'];
                                                        }

                                                        if(($surat['pekerjaan_lama'])!='-')
                                                        {
                                                            echo ' - '.$surat['pekerjaan_lama'];
                                                        }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                        if(($surat['seksi_baru'])=='-')
                                                        {
                                                            if(($surat['unit_baru'])=='-')
                                                            {
                                                                if(($surat['bidang_baru'])=='-')
                                                                {
                                                                    echo 'Departemen '.$surat['dept_baru'];
                                                                }
                                                                else
                                                                {
                                                                    echo 'Bidang '.$surat['bidang_baru'];
                                                                }
                                                            }
                                                            else
                                                            {
                                                                echo 'Unit '.$surat['unit_baru'];
                                                            }
                                                        }
                                                        else
                                                        {
                                                            echo 'Seksi '.$surat['seksi_baru'];
                                                        }

                                                        if(($surat['pekerjaan_baru'])!='-')
                                                        {
                                                            echo ' - '.$surat['pekerjaan_baru'];
                                                        }
                                                    ?>
                                                </td>
                                                <td><?php echo $surat['lokasi_kerja_lama'];?></td>
                                                <td><?php echo $surat['lokasi_kerja_baru'];?></td>
                                                <td><?php echo $surat['tanggal_cetak'];?></td>
                                                <td><?php echo $surat['cetak'];?></td>
                                            </tr>
                                            <?php
                                                }
                                            ?>
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
</section>                