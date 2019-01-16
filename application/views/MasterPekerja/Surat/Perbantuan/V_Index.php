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
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('MasterPekerja/Surat/SuratPerbantuan');?>">
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
                                <a href="<?php echo site_url('MasterPekerja/Surat/SuratPerbantuan/create') ?>" style="float:right;margin-right:1%;margin-top:-0.5%;" alt="Add New" title="Add New" >
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
                                                <th style="text-align:center;">Nomor Surat</th>
                                                <th style="text-align:center;">Tanggal Berlaku</th>
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
                                                foreach($DaftarSuratPerbantuan as $row):
                                                $encrypted_string = $this->encrypt->encode($row['no_surat']);
                                                $encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string
                                                    );
                                                // $encrypt_kode = $this->general->enkripsi($surat['kode']);
                                                // $encrypt_kode = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypt_kode
                                                //     );
                                                // $parameter = $encrypted_string.'/'.$encrypt_kode;
                                            ?>
                                            <tr>
                                                <td align='center'><?php echo $no++;?></td>
                                                <td align='center' style="white-space: nowrap;">
                                                    <a target="_blank" style="margin-right:4px" href="<?php echo base_url('MasterPekerja/Surat/SuratPerbantuan/previewcetak/'.$encrypted_string.''); ?>" data-toggle="tooltip" data-placement="bottom" title="Preview Cetak"><span class="fa fa-file-pdf-o fa-2x"></span></a>
                                                    <a style="margin-right:4px" href="<?php echo base_url('MasterPekerja/Surat/SuratPerbantuan/update/'.$encrypted_string.''); ?>" data-toggle="tooltip" data-placement="bottom" title="Edit Data"><span class="fa fa-pencil-square-o fa-2x"></span></a>
                                                    <a href="<?php echo base_url('MasterPekerja/Surat/SuratPerbantuan/delete/'.$encrypted_string.''); ?>" data-toggle="tooltip" data-placement="bottom" title="Hapus Data" onclick="return confirm('Are you sure you want to delete this item?');"><span class="fa fa-trash fa-2x"></span></a>
                                                </td>
                                                <td><?php echo $row['no_surat'];?></td>
                                                <td><?php echo $row['tanggal_mulai_perbantuan'].' - '.$row['tanggal_selesai_perbantuan'];?></td>
                                                <td><?php echo $row['noind'];?></td>
                                                <td><?php echo $row['nama'];?></td>
                                                <td><?php echo $row['seksi_lama'];?></td>
                                                <td><?php echo $row['seksi_baru'];?></td>
                                                <td><?php echo $row['lokasi_kerja_lama'];?></td>
                                                <td><?php echo $row['lokasi_kerja_baru'];?></td>
                                                <td><?php echo $row['tanggal_cetak'];?></td>
                                                <td><?php echo $row['cetak'];?></td>
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
</section>                