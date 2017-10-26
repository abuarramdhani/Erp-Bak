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
                                <h3 class="box-title">Business Process List</h3>                             
                            </div>
                            <div class="box-body">
                                <div class="row">
                                    <?php
                                        if($jumlahBP<7 && $jumlahBP>0)
                                        {
                                            if(12 % $jumlahBP!=0)
                                            {
                                                $jumlahBP = $jumlahBP + 1;
                                            }

                                            foreach ($listBP as $BP) 
                                            {
                                                $BPencode   = $this->encrypt->encode($BP['id_business_process']);
                                                $BPencode   = str_replace(array('+', '/', '='), array('-', '_', '~'), $BPencode);

                                                $linkencode = base_url('DocumentStandarization/AllDoc/CD/'.$BPencode);

                                                echo '  <div class="col-lg-'.(12/$jumlahBP).'">
                                                            <center>
                                                                <br/>
                                                                <div class="btn-group-vertical">
                                                                        <a type="button" class="btn btn-danger btn-lg buttonlistDocUpper buttonlistDoc" title="'.$BP['nama_business_process'].'" href="'.$linkencode.'" style="width: 100%;">'.$BP['nomor_kontrol'].' - '.$BP['nomor_revisi'].'<br/><h6 style="white-space:normal;">'.$BP['nama_business_process'].'</h6></a>
                                                                        <a type="button" class="btn btn-danger btn-lg" title="Lihat Dokumen" href="'.base_url('assets/upload/PengembanganSistem/StandarisasiDokumen'.'/'.$BP['file']).'" target="_blank"><i class="fa fa-file-pdf-o fa-lg"></i></a>
                                                                </div>
                                                                <br/>
                                                            </center>
                                                        </div>';
                                            }
                                        }
                                        elseif($jumlahBP>6)
                                        {
                                            $incrementalBP = 0;
                                            foreach ($listBP as $BP) 
                                            {
                                                $BPencode   = $this->encrypt->encode($BP['id_business_process']);
                                                $BPencode   = str_replace(array('+', '/', '='), array('-', '_', '~'), $BPencode);

                                                $linkencode = base_url('DocumentStandarization/AllDoc/CD/'.$BPencode);

                                                echo '  <div class="col-lg-2">
                                                            <center>
                                                                <br/>
                                                                <div class="btn-group-vertical">
                                                                        <a type="button" class="btn btn-danger btn-lg buttonlistDocUpper buttonlistDoc" title="'.$BP['nama_business_process'].'" href="'.$linkencode.'" style="width: 100%;">'.$BP['nomor_kontrol'].' - '.$BP['nomor_revisi'].'<br/><h6 style="white-space: normal;">'.$BP['nama_business_process'].'</h6></a>
                                                                        <a type="button" class="btn btn-danger btn-lg" title="Lihat Dokumen" href="'.base_url('assets/upload/PengembanganSistem/StandarisasiDokumen'.'/'.$BP['file']).'" target="_blank"><i class="fa fa-file-pdf-o fa-lg"></i></a>
                                                                </div>
                                                                <br/>
                                                            </center>
                                                        </div>';
                                                $incrementalBP++;
                                                if($incrementalBP % 6 == 0)
                                                {
                                                    echo '  <div class="clearfix visible-lg-block"></div>';
                                                }                                                        
                                            }
                                        }
                                        elseif($jumlahBP==0)
                                        {
                                            echo '  <br/>
                                                    <div class="col-lg-6">
                                                        <div class="callout callout-danger">
                                                            <h4><i class="fa fa-warning"></i> Peringatan</h4>
                                                            Tidak ada dokumen.
                                                        </div>
                                                    </div>';
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