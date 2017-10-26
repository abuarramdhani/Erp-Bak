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
                                <h3 class="box-title">Standard Operating Procedure List</h3>                                  
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
                                    <?php
                                        if($jumlahSOP<7 && $jumlahSOP>0)
                                        {
                                            if(12 % $jumlahSOP!=0)
                                            {
                                                $jumlahSOP = $jumlahSOP + 1;
                                            }
                                            echo '<hr/>';

                                            foreach ($listSOP as $SOP) 
                                            {
                                                $SOPencode  = str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($SOP['id_standard_operating_procedure']));

                                                $CDencode   = str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($idCD)); 
                                                $BPencode   = str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($idBP));

                                                $linkencode = base_url('DocumentStandarization/AllDoc/WI_COP/'.$SOPencode.'/'.$CDencode.'/'.$BPencode);

                                                echo '  <div class="col-lg-'.(12/$jumlahSOP).'">
                                                            <center>
                                                            <br/>
                                                                <div class="btn-group-vertical">
                                                                        <a type="button" class="btn btn-success btn-lg buttonlistDocUpper buttonlistDoc" title="'.$SOP['nama_standard_operating_procedure'].'" href="'.$linkencode.'">'.$SOP['nomor_kontrol'].' - '.$SOP['nomor_revisi'].'<br/><h6 style="white-space: normal;">'.$SOP['nama_standard_operating_procedure'].'</h6></a>
                                                                        <a type="button" class="btn btn-success btn-lg" title="Lihat Dokumen" href="'.base_url('assets/upload/PengembanganSistem/StandarisasiDokumen'.'/'.$SOP['file']).'" target="_blank"><i class="fa fa-file-pdf-o fa-lg"></i></a>
                                                                </div>
                                                                <br/>
                                                            </center>
                                                        </div>';
                                            }
                                        }
                                        elseif($jumlahSOP>6)
                                        {
                                            echo '<hr/>';
                                            foreach ($listSOP as $SOP) 
                                            {
                                                $SOPencode  = str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($SOP['id_standard_operating_procedure']));

                                                $CDencode   = str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($idCD)); 
                                                $BPencode   = str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($idBP));

                                                $linkencode = base_url('DocumentStandarization/AllDoc/WI_COP/'.$SOPencode.'/'.$CDencode.'/'.$BPencode);

                                                echo '  <div class="col-lg-2">
                                                            <center>
                                                            <br/>
                                                                <div class="btn-group-vertical">
                                                                        <a type="button" class="btn btn-success btn-lg buttonlistDocUpper buttonlistDoc" title="'.$SOP['nama_standard_operating_procedure'].'" href="'.$linkencode.'">'.$SOP['nomor_kontrol'].' - '.$SOP['nomor_revisi'].'<br/><h6 style="white-space: normal;">'.$SOP['nama_standard_operating_procedure'].'</h6></a>
                                                                        <a type="button" class="btn btn-success btn-lg" title="Lihat Dokumen" href="'.base_url('assets/upload/PengembanganSistem/StandarisasiDokumen'.'/'.$SOP['file']).'" target="_blank"><i class="fa fa-file-pdf-o fa-lg"></i></a>
                                                                </div>
                                                                <br/>
                                                            </center>
                                                        </div>';
                                            }
                                        }
                                        elseif($jumlahSOP==0)
                                        {
                                            echo '  <br/>
                                                    <div class="col-lg-6">
                                                        <div class="callout callout-success">
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