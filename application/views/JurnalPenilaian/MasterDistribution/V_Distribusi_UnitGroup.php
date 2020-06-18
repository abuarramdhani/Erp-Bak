<section class="content">
    <div class="inner" >
        <div class="row">
            <form method="post" action="<?php echo site_url('PenilaianKinerja/MasterUnitGroupDistribution/distribusi_unitGroupEdit'.'/'.$id);?>" class="form-horizontal" enctype="multipart/form-data">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-11">
                                <div class="text-right"><h1><b><?= $Title ?></b></h1></div>
                            </div>
                            <div class="col-lg-1 ">
                                <div class="text-right hidden-md hidden-sm hidden-xs">
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('PenilaianKinerja/MasterUnitGroupDistribution');?>">
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
                                <div class="box-header with-border">Distribusi</div>
                                <div class="box-body">
                                    <div class="panel-body">
                                        <div class="row">
                                            <table>
                                                <tr>
                                                    <td>Golongan Kerja</td>
                                                    <td> : </td>
                                                    <td><b><?php echo $golKerja;?></b></td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="row">
                                            <?php
                                                for ($j=1; $j <= $jumlahGolongan; $j++) 
                                                {
                                                    $gridOpen   =   '';
                                                    $gridClose  =   '';
                                                    $attrAutoFocus  =   '';
                                                    $value          =   0;
                                                    if(($j % 8) == 1)
                                                    {
                                                        $gridOpen   =   '<div class="col-lg-6">';
                                                    }
                                                    if(($j % 8) == 0)
                                                    {
                                                        $gridClose  =   '</div>';
                                                    }

                                                    if($j == 1)
                                                    {
                                                        $attrAutoFocus  =   'autofocus=""';
                                                    }

                                                    if(!(empty($daftarDistribusiPekerja)))
                                                    {
                                                        $value  =   $daftarDistribusiPekerja[$j-1]['worker_count'];
                                                    }
                                            ?>
                                            <?php echo $gridOpen;?>
                                            <div>
                                                <table>
                                                    <tr class="form-group">
                                                        <td style="width: 25%">
                                                            <b>Gol. <?php echo $j;?></b>
                                                        </td>
                                                        <td style="width: 100%">
                                                            <input type="number" min="0" step="1" value="<?php echo $value;?>" name="txtJumlahPekerja[<?php echo ($j-1);?>]" <?php echo $attrAutoFocus;?> style="width: 100%"/>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <?php echo $gridClose;?>
                                            <?php
                                                }                                            
                                            ?>
                                        </div>
                                    </div>
                                    <div class="panel-footer">
                                        <div class="row text-right">
                                            <a href="javascript:history.back(1)" class="btn btn-primary btn-lg btn-rect">Back</a>
                                            &nbsp;&nbsp;
                                            <button type="submit" class="btn btn-primary btn-lg btn-rect">Save Data</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>