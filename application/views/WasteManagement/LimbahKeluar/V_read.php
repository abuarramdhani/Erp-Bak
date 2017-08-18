<section class="content">
    <div class="inner" >
        <div class="row">
            <form class="form-horizontal">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-11">
                                <div class="text-right"><h1><b><?= $Title ?></b></h1></div>
                            </div>
                            <div class="col-lg-1 ">
                                <div class="text-right hidden-md hidden-sm hidden-xs">
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('WasteManagement/LimbahKeluar/');?>">
                                        <i class="icon-wrench icon-2x"></i>
                                        <br />
                                    </a>                             
                                </div>
                            </div>
                        </div>
                    </div>
                    <br />
                    
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="box box-primary box-solid">
                                <div class="box-header with-border">Read Limbah Keluar</div>
                                 <?php foreach ($LimbahKeluar as $headerRow):$encrypted_string = $this->encrypt->encode($headerRow['id_limbah_keluar']);
                                                            $encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string); ?>
                                <div class="box-body">

                                <div class="col-lg-12">
                                           
                                            <div class="row">
                                                <div class="nav-tabs-custom" align="center">
                                                   
                                                        <?php if($headerRow['konfirmasi_status']==1) {
                                                            echo "<div class='callout callout-success'>
                                                                        <h4><strong>Status Confirmed! </strong></h4> <p>Anda telah melakukan konfirmasi pada data limbah ini.</p>
                                                                </div>";
                                                            }elseif($headerRow['konfirmasi_status']==2) {
                                                                echo "<div class='callout callout-danger'>
                                                                        <h4><strong>Status Not Confirmed! </strong></h4> <p>Anda tidak melakukan konfirmasi pada data limbah ini.</p>
                                                                </div>";
                                                            }else{
                                                                echo "";
                                                            }
                                                        ?>
                                                      
                                                </div>
                                            </div>
                                    </div>

                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="table-responsive">
                                                    <table class="table" style="border: 0px !Important;">
                                                   
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Tanggal Keluar</strong></td>
                                                            <td style="border: 0">: <?php echo date('d M Y',strtotime($headerRow['tanggal_keluar'])); ?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Jumlah Keluar</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['jumlah_keluar']; ?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Tujuan Limbah</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['tujuan_limbah']; ?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Nomor Dok</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['nomor_dok']; ?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Sisa Limbah</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['sisa_limbah']; ?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Jenis Limbah</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['jenis']; ?></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                        
                                    </div>
                                    </div>
                                    <div class="panel-footer">
                                        <div align="right">
                                    <?php foreach ($User as $user): ?>
                                        <?php if($this->session->userdata['user']==$user['user_name']): ?> 
                                        <?php if($headerRow['konfirmasi_status']==0) {
                                            echo '<a href="'.site_url('WasteManagement/LimbahKeluar/kirimApprove/'.$encrypted_string.'').'" class="btn btn-success btn-md btn-flat">Confirmed</a> <a href="'.site_url('WasteManagement/LimbahKeluar/kirimReject/'.$encrypted_string.'').'" class="btn btn-danger btn-md btn-flat">Not Confirmed</a>';
                                        }?>
                                        <?php endif; ?>
                                    <?php endforeach; ?> 
                                            <a href="javascript:history.back(1)" class="btn btn-primary btn-md btn-flat">Back</a>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>