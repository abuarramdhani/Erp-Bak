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
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('MasterPekerja/SetupPekerjaan');?>">
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
                                <a href="<?php echo site_url('MasterPekerja/SetupPekerjaan/create') ?>" style="float:right;margin-right:1%;margin-top:-0.5%;" alt="Add New" title="Add New" >
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
                                                <th style="text-align:center;">Kode Pekerjaan</th>
                                                <th style="text-align:center;">Pekerjaan</th>
                                                <th style="text-align:center;">Learning Periode</th>
                                                <th style="text-align:center;">Satuan</th>
                                                <th style="text-align:center;">Keterangan</th>
                                                <th style="text-align:center;">Keterangan2</th>
                                                <th style="text-align:center;">JenisPekerjaan</th>
                                                <th style="text-align:center;">JenisBaju</th>
                                                <th style="text-align:center;">JenisCelana</th>
                                         </thead>

                                        <tbody>
                                              <?php 
                                                $no = 1; 
                                                foreach($data as $pekerjaan) :
                                                $encrypted_string = $this->encrypt->encode($pekerjaan['id_kdpekerjaan']);
                                                $encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
                                                $ket = explode(";", $pekerjaan['seksi']);
                                                $ket0 = $ket['0'];
                                                $ket1 = $ket['1'];
                                                    
                                            ?>
                                            <tr>
                                                <td align='center'><?php echo $no++;?></td>
                                                <td align='center' style="white-space: nowrap;">
                                                     <a href='<?php echo base_url('MasterPekerja/SetupPekerjaan/read/'.$encrypted_string.''); ?>' data-toggle='tooltip' data-placement='bottom' data-original-title='Lihat Data'><span class='fa fa-list-alt fa-2x'></span></a>
                                                    <a style="margin-right:4px" href="<?php echo base_url('MasterPekerja/SetupPekerjaan/update/'.$encrypted_string.''); ?>" data-toggle="tooltip" data-placement="bottom" title="Edit Data"><span class="fa fa-pencil-square-o fa-2x"></span></a>
                                                    <a href="<?php echo base_url('MasterPekerja/SetupPekerjaan/delete/'.$encrypted_string.''); ?>" data-toggle="tooltip" data-placement="bottom" title="Hapus Data" onclick="return confirm('Are you sure you want to delete this item?');"><span class="fa fa-trash fa-2x"></span></a>
                                                </td>
                                                <td><?php echo $pekerjaan['kdpekerjaan'];?></td>
                                                <td><?php echo $pekerjaan['pekerjaan'];?></td>
                                                <td><?php echo $pekerjaan['learningperiode'];?></td>
                                                <td><?php echo $pekerjaan['waktu'];?></td>
                                                <td><?php echo $ket0 ?></td>
                                                <td><?php echo $ket1 ?></td>
                                                <td><?php echo $pekerjaan['jenis'];?></td>
                                                <td><?php echo $pekerjaan['jenisbaju'];?></td>
                                                <td><?php echo $pekerjaan['jeniscelana'];?></td>
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