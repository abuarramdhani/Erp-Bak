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
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('MasterPekerja/PerhitunganPesangon/Pesangon');?>">
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
                                <a href="<?php echo site_url('MasterPekerja/PerhitunganPesangon/create') ?>" style="float:right;margin-right:1%;margin-top:-0.5%;" alt="Add New" title="Add New" >
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
                                                <th style="text-align:center;">NoInduk</th>
                                                <th style="text-align:center;">Nama</th>
                                                <th style="text-align:center;">Jabatan Terakhir</th>
                                                <th style="text-align:center;">U.Pesangon</th>
                                                <th style="text-align:center;">U.UPMK</th>
                                                <th style="text-align:center;">Sisa Cuti</th>
                                                <th style="text-align:center;">U.Ganti Rugi</th>
                                                <th style="text-align:center;">Potongan</th>
                                                <th style="text-align:center;">Htg Koperasi</th>
                                                <th style="text-align:center;">Htg Perusahaan</th>
                                                <th style="text-align:center;">Lain lain</th>
                                         </thead>

                                        <tbody>
                                              <?php 
                                                $no = 1; 
                                                foreach($data as $pesangon) :
                                                $encrypted_string = $this->encrypt->encode($pesangon['id_pesangon']);
                                                $encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
                                                    
                                            ?>
                                            <tr>
                                                <td align='center'><?php echo $no++;?></td>
                                                <td align='center' style="white-space: nowrap;">
                                                    <a target="_blank" style="margin-right:4px" href="<?php echo base_url('MasterPekerja/PerhitunganPesangon/previewcetak/'.$encrypted_string.''); ?>" data-toggle="tooltip" data-placement="bottom" title="Preview Cetak"><span class="fa fa-file-pdf-o fa-2x"></span></a>
                                                    <a style="margin-right:4px" href="<?php echo base_url('MasterPekerja/PerhitunganPesangon/update/'.$encrypted_string.''); ?>" data-toggle="tooltip" data-placement="bottom" title="Edit Data"><span class="fa fa-pencil-square-o fa-2x"></span></a>
                                                    <a href="<?php echo base_url('MasterPekerja/PerhitunganPesangon/delete/'.$encrypted_string.''); ?>" data-toggle="tooltip" data-placement="bottom" title="Hapus Data" onclick="return confirm('Are you sure you want to delete this item?');"><span class="fa fa-trash fa-2x"></span></a>
                                                </td>
                                                <td><?php echo $pesangon['noinduk'];?></td>
                                                <td><?php echo $pesangon['nama'];?></td>
                                                <td><?php echo $pesangon['jabatan_terakhir'];?></td>
                                                <td><?php echo $pesangon['jml_pesangon'];?></td>
                                                <td><?php echo $pesangon['jml_upmk'];?></td>
                                                <td><?php echo $pesangon['jml_cuti'];?></td>
                                                <td><?php echo $pesangon['uang_ganti_kerugian'];?></td>
                                                <td><?php echo $pesangon['potongan'];?></td>
                                                <td><?php echo $pesangon['hutang_koperasi'];?></td>
                                                <td><?php echo $pesangon['hutang_perusahaan'];?></td>
                                                <td><?php echo $pesangon['lain_lain'];?></td>
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