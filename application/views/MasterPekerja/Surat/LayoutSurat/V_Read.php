<section class="content">
    <div class="inner" >
        <div class="row">
            <!-- <form method="post" action="<?php echo site_url('MasterPekerja/Surat/SuratLayout/add');?>" class="form-horizontal"> -->
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-11">
                                <div class="text-right"><h1><b><?= $Title ?></b></h1></div>
                            </div>
                            <div class="col-lg-1 ">
                                <div class="text-right hidden-md hidden-sm hidden-xs">
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('MasterPekerja/Surat/SuratLayout/');?>">
                                        <i class="icon-wrench icon-2x"></i>
                                        <span ><br /></span>
                                    </a>                             
                                </div>
                            </div>
                        </div>
                    </div>
                    <br />
                
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="box box-primary box-solid">
                                <div class="box-header with-border">Read Layout Surat</div>
                                    <div class="box-body">
                                        <div class="panel-body">
                                                <div class="table-responsive">
                                                    <table class="table" style="border: 0px !Important;">
                                                    <?php foreach ($layoutSurat as $layout): ?>
                                                        <tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Jenis Surat</strong></td>
                                                            <td class="col-lg-1" style="border: 0"> : </td>
                                                            <td style="border: 0"><?php echo $layout['jenis_surat']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Staf/Nonstaf</strong></td>
                                                            <td class="col-lg-1" style="border: 0"> : </td>
                                                            <td style="border: 0">
                                                                <?php
                                                                    if ($layout['staf']=='t') 
                                                                    {
                                                                        $Staf_Nonstaf='Staf';
                                                                    }
                                                                    else
                                                                    {
                                                                        $Staf_Nonstaf='NonStaf';
                                                                    }
                                                                    echo $Staf_Nonstaf;
                                                                ?>
                                                            </td>
                                                        </tr>
                                                         <tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Format Surat</strong></td>
                                                            <td style="col-lg-1" style="border: 0"> : </td>
                                                            <td style="border: 0"><?php echo $layout['isi_surat']; ?></td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel-footer">
                                            <div class="row text-right">
                                                <a href="javascript:history.back(1)" class="btn btn-primary btn-lg btn-rect">Back</a>
                                                &nbsp;&nbsp;
                                            </div>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            <!-- </form> -->
        </div>
    </div>
</section>