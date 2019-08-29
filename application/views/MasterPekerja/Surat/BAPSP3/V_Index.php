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
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('MasterPekerja/Surat/BAPSP3');?>">
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
                                <a href="<?php echo site_url('MasterPekerja/Surat/BAPSP3/create') ?>" style="float:right;margin-right:1%;margin-top:-0.5%;" alt="Add New" title="Add New" >
                                    <button type="button" class="btn btn-default btn-sm"><i class="icon-plus icon-2x"></i></button>
                                </a>
                            </div>
                            <div class="box-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover text-left" id="tbl" .$new_table_name. "" style="width:100%; font-size:12px;">
                                        <thead class="bg-primary">
                                            <tr>
                                                <th style="text-align:center;">No</th>
                                                <th style="text-align:center;">Action</th>
                                                <th style="text-align:center;">Nomor Induk</th>
                                                <th style="text-align:center;">Nama</th>
                                                <th style="text-align:center;">Jabatan</th>
                                                <th style="text-align:center;">Seksi/Bidang/Unit</th>
                                                <th style="text-align:center;">Tanggal Cetak</th>
                                                <th style="text-align:center;">Cetak</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                $no = 1; 
                                                foreach($view as $surat){
                                                    $parameter = $this->general->enkripsi($surat['bap_id']);
                                            ?>
                                            <tr>
                                                <td style="text-align: center;"><?php echo $no++;?></td>
                                                <td style="text-align: center;" style="white-space: nowrap;">
                                                    <a target="_blank" style="margin-right:4px" href="<?php echo base_url('MasterPekerja/Surat/BAPSP3/previewcetak/'.$parameter.''); ?>" title="Preview Cetak"><span class="fa fa-file-pdf-o fa-2x"></span></a>
                                                    <a style="margin-right:4px" href="<?php echo base_url('MasterPekerja/Surat/BAPSP3/update/'.$parameter.''); ?>" title="Edit Data"><span class="fa fa-pencil-square-o fa-2x"></span></a>
                                                    <a href="<?php echo base_url('MasterPekerja/Surat/BAPSP3/delete/'.$parameter.''); ?>" title="Hapus Data" onclick="return confirm('Are you sure you want to delete this item?');"><span class="fa fa-trash fa-2x"></span></a>
                                                </td>
                                                <td><?php echo $surat['noind'];?></td>
                                                <td><?php echo $surat['employee_name'];?></td>
                                                <td><?php echo $surat['pekerjaan_jabatan'];?></td>
                                                <td><?php echo $surat['section_code'];?></td>
                                                <td><?php echo $surat['tgl'];?></td>
                                                <td><?php echo "-";?></td>
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