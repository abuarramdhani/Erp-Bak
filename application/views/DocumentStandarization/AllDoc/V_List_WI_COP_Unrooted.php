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
                                <h3 class="box-title">Work Instruction and Code of Practice List</h3>                                   
                            </div>
                            <div class="box-body">
                                <br/>
                                <p><button onclick="previousPage()" class="btn btn-warning"><i class="fa fa-undo"> Kembali ke Halaman Sebelumnya</i></button></p>
                                <br/>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="box box-warning box-solid">
                                            <div class="box-header with-border">
                                                <h5 class="box-title">Work Instruction</h5>
                                            </div>
                                            <div class="box-body">
                                                <?php
                                                    if($jumlahWIUnrooted<4 && $jumlahWIUnrooted>0)
                                                    {
                                                        if(12 % $jumlahWIUnrooted!=0)
                                                        {
                                                            $jumlahWIUnrooted = $jumlahWIUnrooted + 1;
                                                        }

                                                        foreach ($listWIUnrooted as $WI) 
                                                        {
                                                            if($WI['file']==NULL || $WI['file']=='' || $WI['file']==' ')
                                                            {
                                                                echo '  <div class="col-lg-'.(12/$listWIUnrooted).'">
                                                                            <center>
                                                                            <br/>
                                                                                <div class="btn-group-vertical">
                                                                                        <a type="button" class="btn btn-warning btn-lg buttonlistDocUpper buttonlistDoc">'.$WI['nomor_kontrol'].' - '.$WI['nomor_revisi'].'<br/><h6 style="white-space: normal;">'.$WI['nama_work_instruction'].'</h6><i class="fa fa-file-pdf-o fa-lg"></i></a>
                                                                                </div>
                                                                            <br/>
                                                                            </center>
                                                                        </div>';
                                                            }
                                                            else
                                                            {
                                                                echo '  <div class="col-lg-2">
                                                                            <center>
                                                                            <br/>
                                                                                <div class="btn-group-vertical">
                                                                                        <a type="button" class="btn btn-warning btn-lg buttonlistDocUpper buttonlistDoc" href="'.base_url('assets/upload/PengembanganSistem/StandarisasiDokumen'.'/'.$WI['file']).'" target="_blank">'.$WI['nomor_kontrol'].' - '.$WI['nomor_revisi'].'<br/><h6 style="white-space: normal;">'.$WI['nama_work_instruction'].'</h6><i class="fa fa-file-pdf-o fa-lg"></i></a>
                                                                                </div>
                                                                            <br/>
                                                                            </center>
                                                                        </div>';                                                                
                                                            }
                                                        }
                                                    }
                                                    elseif($jumlahWIUnrooted>3)
                                                    {
                                                        foreach ($listWIUnrooted as $WI) 
                                                        {
                                                            if($WI['file']==NULL || $WI['file']=='' || $WI['file']==' ')
                                                            {
                                                                echo '  <div class="col-lg-'.(12/$jumlahWIUnrooted).'">
                                                                            <center>
                                                                            <br/>
                                                                                <div class="btn-group-vertical">
                                                                                        <a type="button" class="btn btn-warning btn-lg buttonlistDocUpper buttonlistDoc">'.$WI['nomor_kontrol'].' - '.$WI['nomor_revisi'].'<br/><h6 style="white-space: normal;">'.$WI['nama_work_instruction'].'</h6><i class="fa fa-file-pdf-o fa-lg"></i></a>
                                                                                </div>
                                                                            <br/>
                                                                            </center>
                                                                        </div>';
                                                            }
                                                            else
                                                            {
                                                                echo '  <div class="col-lg-2">
                                                                            <center>
                                                                            <br/>
                                                                                <div class="btn-group-vertical">
                                                                                        <a type="button" class="btn btn-warning btn-lg buttonlistDocUpper buttonlistDoc" href="'.base_url('assets/upload/PengembanganSistem/StandarisasiDokumen'.'/'.$WI['file']).'" target="_blank">'.$WI['nomor_kontrol'].' - '.$WI['nomor_revisi'].'<br/><h6 style="white-space: normal;">'.$WI['nama_work_instruction'].'</h6><i class="fa fa-file-pdf-o fa-lg"></i></a>
                                                                                </div>
                                                                            <br/>
                                                                            </center>
                                                                        </div>';                                                                
                                                            }
                                                        }
                                                    }
                                                    elseif($jumlahWIUnrooted==0)
                                                    {
                                                        echo '  <br/>
                                                                <div class="col-lg-9">
                                                                    <div class="callout callout-warning">
                                                                        <h4><i class="fa fa-warning"></i> Peringatan</h4>
                                                                        Tidak ada dokumen.
                                                                    </div>
                                                                </div>';                                            
                                                    }                                            
                                                ?>
                                            </div>
                                        </div>                            
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="box box-warning box-solid">
                                            <div class="box-header with-border">
                                                <h5 class="box-title">Code of Practice</h5>
                                            </div>
                                            <div class="box-body">
                                                <?php
                                                    if($jumlahCOPUnrooted<4 && $jumlahCOPUnrooted>0)
                                                    {
                                                        if(12 % $jumlahCOPUnrooted!=0)
                                                        {
                                                            $jumlahCOPUnrooted = $jumlahCOPUnrooted + 1;
                                                        }

                                                        foreach ($listCOPUnrooted as $COP) 
                                                        {
                                                            if($COP['file']==NULL || $COP['file']=='' || $COP['file']==' ')
                                                            {
                                                                echo '  <div class="col-lg-'.(12/$jumlahCOPRooted).'">
                                                                            <center>
                                                                            <br/>
                                                                                <div class="btn-group-vertical">
                                                                                        <a type="button" class="btn btn-warning btn-lg buttonlistDocUpper buttonlistDoc">'.$COP['nomor_kontrol'].' - '.$COP['nomor_revisi'].'<br/><h6 style="white-space: normal;">'.$COP['nama_work_instruction'].'</h6><i class="fa fa-file-pdf-o fa-lg"></i></a>
                                                                                </div>
                                                                            <br/>
                                                                            </center>
                                                                        </div>';
                                                            }
                                                            else
                                                            {
                                                                echo '  <div class="col-lg-4">
                                                                            <center>
                                                                            <br/>
                                                                                <div class="btn-group-vertical">
                                                                                        <a type="button" class="btn btn-warning btn-lg buttonlistDocUpper buttonlistDoc" href="'.base_url('assets/upload/PengembanganSistem/StandarisasiDokumen'.'/'.$COP['file']).'" target="_blank">'.$COP['nomor_kontrol'].' - '.$COP['nomor_revisi'].'<br/><h6 style="white-space: normal;">'.$COP['nama_work_instruction'].'</h6><i class="fa fa-file-pdf-o fa-lg"></i></a>
                                                                                </div>
                                                                            <br/>
                                                                            </center>
                                                                        </div>';
                                                            }
                                                        }
                                                    }
                                                    elseif($jumlahCOPUnrooted>3)
                                                    {
                                                        foreach ($listCOPUnrooted as $listCOPUnrooted) 
                                                        {
                                                            $SOPencode  = str_replace(array('+', '/', '='), array('-', '_', '~'), $listCOPUnrooted['id_standard_operating_procedure']);

                                                            $CDencode   = str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($idCD)); 
                                                            $BPencode   = str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($idBP));

                                                            $linkencode = base_url('DocumentStandarization/AllDoc/WI_COP/'.$SOPencode.'/'.$CDencode.'/'.$BPencode);

                                                            if($COP['file']==NULL || $COP['file']=='' || $COP['file']==' ')
                                                            {
                                                                echo '  <div class="col-lg-'.(12/$jumlahCOPRooted).'">
                                                                            <center>
                                                                            <br/>
                                                                                <div class="btn-group-vertical">
                                                                                        <a type="button" class="btn btn-warning btn-lg buttonlistDocUpper buttonlistDoc">'.$COP['nomor_kontrol'].' - '.$COP['nomor_revisi'].'<br/><h6 style="white-space: normal;">'.$COP['nama_work_instruction'].'</h6><i class="fa fa-file-pdf-o fa-lg"></i></a>
                                                                                </div>
                                                                            <br/>
                                                                            </center>
                                                                        </div>';
                                                            }
                                                            else
                                                            {
                                                                echo '  <div class="col-lg-4">
                                                                            <center>
                                                                            <br/>
                                                                                <div class="btn-group-vertical">
                                                                                        <a type="button" class="btn btn-warning btn-lg buttonlistDocUpper buttonlistDoc" href="'.base_url('assets/upload/PengembanganSistem/StandarisasiDokumen'.'/'.$COP['file']).'" target="_blank">'.$COP['nomor_kontrol'].' - '.$COP['nomor_revisi'].'<br/><h6 style="white-space: normal;">'.$COP['nama_work_instruction'].'</h6><i class="fa fa-file-pdf-o fa-lg"></i></a>
                                                                                </div>
                                                                            <br/>
                                                                            </center>
                                                                        </div>';
                                                            }
                                                        }
                                                    }
                                                    elseif($jumlahCOPUnrooted==0)
                                                    {
                                                        echo '  <br/>
                                                                <div class="col-lg-9">
                                                                    <div class="callout callout-warning">
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
<!--                                 <?php
                                    if(($jumlahWIUnrooted+$jumlahCOPUnrooted)>0)
                                        $fungsi     =   explode('-', $nomorCD);
                                        $fungsi     =   $fungsi[1];
                                        $fungsi     =   str_replace(' ', '', $fungsi);
                                        echo '
                                                <center>
                                                    <a type="button" class="btn btn-info btn-lg" href="'.base_url('DocumentStandarization/AllDoc/WI_COP_NoRoot'.'/'.str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($fungsi))).'">
                                                            WI-'.$fungsi.'-00-XX & COP-'.$fungsi.'-00-XX
                                                    </a>
                                                </center>';
                                ?> -->
                            </div>
                        </div>
                    </div>
                </div>    
            </div>    
        </div>
    </div>
</section>