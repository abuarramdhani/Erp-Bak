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
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('DocumentStandarization/AllDoc');?>">
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
                            </div>
                            <div class="box-body">
                                <div class="row">
                                    <?php
                                        if($jumlahBP<7)
                                        {
                                            if(12 % $jumlahBP!=0)
                                            {
                                                $jumlahBP = $jumlahBP + 1;
                                            }

                                            foreach ($listBP as $BP) 
                                            {
                                                echo '  <div class="col-lg-'.(12/$jumlahBP).'">
                                                            <center>
                                                                <div class="btn-group-vertical">
                                                                        <a type="button" class="btn btn-default btn-lg" title="'.$BP['nama_business_process'].'" href="'.base_url('DocumentStandarization/AllDoc/CD/'.$BP['id_business_process']).'" target="_blank">'.$BP['nomor_kontrol'].' - '.$BP['nomor_revisi'].'</a>
                                                                        <a type="button" class="btn btn-default btn-lg" title="Lihat Dokumen" href="'.base_url('assets/upload/PengembanganSistem/StandarisasiDokumen'.'/'.$BP['file']).'" target="_blank"><i class="fa fa-file-pdf-o fa-lg"></i></a>
                                                                </div>
                                                            </center>
                                                        </div>';
                                            }
                                        }
                                        else
                                        {
                                            foreach ($listBP as $BP) 
                                            {
                                                echo '  <div class="col-lg-2">
                                                            <center>
                                                                <div class="btn-group-vertical">
                                                                        <a type="button" class="btn btn-default" title="'.$BP['nama_business_process'].'" href="'.base_url('DocumentStandarization/AllDoc/CD/'.$BP['id_business_process']).'" target="_blank">'.$BP['nomor_kontrol'].' - '.$BP['nomor_revisi'].'</a>
                                                                        <a type="button" class="btn btn-default" title="Lihat Dokumen" href="'.base_url('assets/upload/PengembanganSistem/StandarisasiDokumen'.'/'.$BP['file']).'" target="_blank"><i class="fa fa-file-pdf-o"></i></a>
                                                                </div>
                                                            </center>
                                                        </div>';
                                            }
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>    
            </div>    
        </div>
    </div>
</section>