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
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="btn-group btn-group-justified">
                                            <a type="button" class="btn btn-danger" title="Business Process List" href="<?php echo base_url('DocumentStandarization/AllDoc/BP');?>" style="width: 15%">
                                                BP
                                            </a>
                                            <a type="button" class="btn btn-danger" title="<?php echo $namaBP;?>" href=<?php echo base_url('DocumentStandarization/BP/read'.'/'.str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($idBP)));?> target="_blank" style="width: 85%">
                                                <?php echo $nomorBP;?>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-1">
                                        
                                    </div>
                                    <div class="col-lg-5">
                                        <div class="btn-group btn-group-justified">
                                            <a type="button" class="btn btn-primary" title="Context Diagram List" href="<?php echo base_url('DocumentStandarization/AllDoc/CD'.'/'.str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($idBP)));?>" style="width: 15%">
                                                CD
                                            </a>
                                            <a type="button" class="btn btn-primary" title="<?php echo $namaCD;?>" href=<?php echo base_url('DocumentStandarization/CD/read'.'/'.str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($idCD)));?> target="_blank" style="width: 85%">
                                                <?php echo $nomorCD;?>
                                            </a>                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-2">
                                        
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="btn-group btn-group-justified">
                                            <a type="button" class="btn btn-success" title="Standard Operating Procedure List" href="<?php echo base_url('DocumentStandarization/AllDoc/SOP'.'/'.str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($idCD)).'/'.str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($idBP)));?>" style="width: 15%">
                                                SOP
                                            </a>
                                            <a type="button" class="btn btn-success" title="<?php echo $namaSOP;?>" href=<?php echo base_url('DocumentStandarization/SOP/read'.'/'.str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($idSOP)));?> target="_blank" style="width: 85%">
                                                <?php echo $nomorSOP;?>
                                            </a>                                            
                                        </div>
                                    </div>
                                </div>
                                <br/>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="box box-warning box-solid">
                                            <div class="box-header with-border">
                                                <h5 class="box-title">Work Instruction</h5>
                                            </div>
                                            <div class="box-body">
                                                <?php
                                                    if($jumlahWIRooted<4 && $jumlahWIRooted>0)
                                                    {
                                                        if(12 % $jumlahWIRooted!=0)
                                                        {
                                                            $jumlahWIRooted = $jumlahWIRooted + 1;
                                                        }

                                                        foreach ($listWIRooted as $WI) 
                                                        {
                                                            if($WI['file']==NULL || $WI['file']=='' || $WI['file']==' ')
                                                            {
                                                                echo '  <div class="col-lg-'.(12/$jumlahWIRooted).'">
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
                                                    elseif($jumlahWIRooted>3)
                                                    {
                                                        foreach ($listWIRooted as $WI) 
                                                        {

                                                            if($WI['file']==NULL || $WI['file']=='' || $WI['file']==' ')
                                                            {
                                                                echo '  <div class="col-lg-'.(12/$jumlahWIRooted).'">
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
                                                                echo '  <div class="col-lg-4">
                                                                            <center>
                                                                            <br/>
                                                                                <div class="btn-group-vertical">
                                                                                        <a type="button" class="btn btn-warning btn-lg buttonlistDocUpper buttonlistDoc" title="'.$WI['nama_work_instruction'].'" href="'.base_url('assets/upload/PengembanganSistem/StandarisasiDokumen'.'/'.$WI['file']).'" target="_blank">'.$WI['nomor_kontrol'].' - '.$WI['nomor_revisi'].'<br/><h6 style="white-space: normal;">'.$WI['nama_work_instruction'].'</h6><i class="fa fa-file-pdf-o fa-lg"></i></a>
                                                                                </div>
                                                                            <br/>
                                                                            </center>
                                                                        </div>';                                                                
                                                            }
                                                        }
                                                    }
                                                    elseif($jumlahWIRooted==0)
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
                                                    if($jumlahCOPRooted<4 && $jumlahCOPRooted>0)
                                                    {
                                                        if(12 % $jumlahCOPRooted!=0)
                                                        {
                                                            $jumlahCOPRooted = $jumlahCOPRooted + 1;
                                                        }

                                                        foreach ($listCOPRooted as $COP) 
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
                                                    elseif($jumlahCOPRooted>3)
                                                    {
                                                        foreach ($listCOPRooted as $listCOPRooted) 
                                                        {
                                                            $SOPencode  = str_replace(array('+', '/', '='), array('-', '_', '~'), $listCOPRooted['id_standard_operating_procedure']);

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
                                                    elseif($jumlahCOPRooted==0)
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
                                <?php
                                    if(($jumlahWIUnrooted+$jumlahCOPUnrooted)>0)
                                        echo '
                                                <center>
                                                    <a type="button" class="btn btn-info btn-lg" href="'.base_url('DocumentStandarization/AllDoc/WI_COP_NoRoot'.'/'.str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($fungsi))).'">
                                                            WI-'.$fungsi.'-00-XX & COP-'.$fungsi.'-00-XX
                                                    </a>
                                                </center>';
                                ?>
                            </div>
                        </div>
                    </div>
                </div>    
            </div>    
        </div>
    </div>
</section>