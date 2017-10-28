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
                                <h3 class="box-title">Context Diagram List</h3>                                
                            </div>
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="btn-group btn-group-justified">
                                            <a type="button" class="btn btn-danger" title="Business Process List" href="<?php echo base_url('DocumentStandarization/AllDoc/BP');?>" style="width: 15%">BP</a>
                                            <a type="button" class="btn btn-danger" title="<?php echo $namaBP;?>" href=<?php echo base_url('DocumentStandarization/BP/read'.'/'.str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($idBP)));?> target="_blank" style="width: 85%;"><?php echo $nomorBP;?></a>                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <?php
                                        if($jumlahCD<7 && $jumlahCD>0)
                                        {
                                            if(12 % $jumlahCD!=0)
                                            {
                                                $jumlahCD = $jumlahCD + 1;
                                            }
                                            echo '<hr/>';

                                            foreach ($listCD as $CD) 
                                            {
                                                $CDencode   = $this->encrypt->encode($CD['id_context_diagram']);
                                                $CDencode   = str_replace(array('+', '/', '='), array('-', '_', '~'), $CDencode);

                                                $BPencode   = str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($idBP));

                                                $linkencode = base_url('DocumentStandarization/AllDoc/SOP/'.$CDencode.'/'.$BPencode);

                                                echo '  <div class="col-lg-'.(12/$jumlahCD).'">
                                                            <center>
                                                            <br/>
                                                                <div class="btn-group-vertical">
                                                                        <a type="button" class="btn btn-primary btn-lg buttonlistDocUpper buttonlistDoc" id="btnListDoc" title="'.$CD['nama_context_diagram'].'" href="'.$linkencode.'" style="width: 100%;">'.$CD['nomor_kontrol'].' - '.$CD['nomor_revisi'].'<br/><h6 style="white-space: normal;">'.$CD['nama_context_diagram'].'</h6></a>';
                                                if($CD['file']==NULL || $CD['file']=='' || $CD['file']==' ')
                                                {
                                                    echo    '<a type="button" class="btn btn-primary btn-lg" title="Lihat Dokumen" disabled="" target="_blank" style="width: 100%;"><i class="fa fa-file-pdf-o fa-lg"></i></a>';
                                                }
                                                else
                                                {
                                                    echo    '<a type="button" class="btn btn-primary btn-lg" title="Lihat Dokumen" href="'.base_url('assets/upload/PengembanganSistem/StandarisasiDokumen'.'/'.$CD['file']).'" target="_blank" style="width: 100%;"><i class="fa fa-file-pdf-o fa-lg"></i></a>';                                                    
                                                }
                                                echo    '       </div>
                                                                <br/>
                                                            </center>
                                                        </div>';
                                            }
                                        }
                                        elseif($jumlahCD>6)
                                        {
                                            echo '<hr/>';
                                            $incrementalCD = 0;
                                            foreach ($listCD as $CD) 
                                            {
                                                $CDencode   = $this->encrypt->encode($CD['id_context_diagram']);
                                                $CDencode   = str_replace(array('+', '/', '='), array('-', '_', '~'), $CDencode);
                                                $BPencode   = str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($idBP));

                                                $linkencode = base_url('DocumentStandarization/AllDoc/SOP/'.$CDencode.'/'.$BPencode);

                                                echo '  <div class="col-lg-2">
                                                            <center>
                                                            <br/>
                                                                <div class="btn-group-vertical">
                                                                        <a type="button" class="btn btn-primary btn-lg buttonlistDocUpper buttonlistDoc" id="btnListDoc" title="'.$CD['nama_context_diagram'].'" href="'.$linkencode.'" style="width: 100%;">'.$CD['nomor_kontrol'].' - '.$CD['nomor_revisi'].'<br/><h6 style="white-space: normal;">'.$CD['nama_context_diagram'].'</h6></a>';
                                                if($CD['file']==NULL || $CD['file']=='' || $CD['file']==' ')
                                                {
                                                    echo    '<a type="button" class="btn btn-primary btn-lg" title="Lihat Dokumen" disabled="" target="_blank" style="width: 100%;"><i class="fa fa-file-pdf-o fa-lg"></i></a>';
                                                }
                                                else
                                                {
                                                    echo    '<a type="button" class="btn btn-primary btn-lg" title="Lihat Dokumen" href="'.base_url('assets/upload/PengembanganSistem/StandarisasiDokumen'.'/'.$CD['file']).'" target="_blank" style="width: 100%;"><i class="fa fa-file-pdf-o fa-lg"></i></a>';                                                    
                                                }
                                                echo    '       </div>
                                                                <br/>
                                                            </center>
                                                        </div>';
                                                $incrementalCD++;
                                                if($incrementalCD % 6 == 0)
                                                {
                                                    echo '  <div class="clearfix visible-lg-block"></div>';
                                                }
                                            }
                                        }
                                        elseif($jumlahCD==0)
                                        {
                                            echo '  <br/>
                                                    <div class="col-lg-6">
                                                        <div class="callout callout-primary">
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