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
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('WasteManagement/LimbahTransaksi/');?>">
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
                                <div class="box-header with-border">Read Limbah Masuk 
                                <?php foreach ($LimbahTransaksi as $headerRow):$encrypted_string = $this->encrypt->encode($headerRow['id_transaksi']);
                                                $encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string); ?>
                                </div>
                                <div class="box-body">
                                <div class="col-lg-12">
                                           
                                            <div class="row">
                                                <div class="nav-tabs-custom" align="center">
                                                   
                                                   
                                                    <?php if($headerRow['konfirmasi']==1) {
                                                            echo "<div class='callout callout-success'>
                                                                        <h4><strong>Status Confirmed! </strong></h4> <p>Anda telah melakukan konfirmasi pada data limbah ini.</p>
                                                                </div>";
                                                            }elseif($headerRow['konfirmasi']==2) {
                                                                echo "<div class='callout callout-danger'>
                                                                        <h4><strong>Status Not Confirmed! </strong></h4> <p>Anda tidak melakukan konfirmasi pada data limbah ini.</p>
                                                                </div>";
                                                            }else{
                                                                echo "";
                                                            }
                                                    ?>
                                                  
                                                </div>
                                            </div>
                                            
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="table-responsive">
                                                    <table class="table" style="border: 0px !Important;">
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Tanggal Masuk</strong></td>
                                                            <td style="border: 0">: <?php echo date('d M Y', strtotime($headerRow['tanggal_transaksi'])) ;?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Jenis Limbah</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['jenis']; ?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Sumber Limbah</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['sumber']; ?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Jenis Sumber</strong></td>
                                                            <td style="border: 0">: <?php if($headerRow['jenis_sumber']==1){
                                                                                echo "Proses Produksi";}
                                                                        elseif ($headerRow['jenis_sumber']==0) {
                                                                                echo "Diluar Proses Produksi";} ?>
                                                            </td>
                                                        </tr>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Satuan</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['satuan_limbah'] ?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Jumlah</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['jumlah']; ?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Perlakuan</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['limbah_perlakuan']; ?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-lg-2" style="border: 0"><strong>Maks Penyimpanan</strong></td>
                                                            <td style="border: 0">: <?php echo date('d M Y',strtotime($headerRow['maks_penyimpanan'])) ;?></td>
                                                        </tr>
														
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                        
                                        </div>
                                        </div>
                                    </div>
                                    <div class="panel-footer">
                                        <div align="right">
                                    <?php foreach ($user as $us): ?> 
                                        <?php if($this->session->userdata['user']==$us['user_name']):?>
                                        <?php if(empty($headerRow['konfirmasi'])) {
                                            echo '<a href="'.site_url('WasteManagement/LimbahTransaksi/kirimApprove/'.$encrypted_string.'').'" class="btn btn-success btn-md btn-flat">Confirmed</a> <a href="'.site_url('WasteManagement/LimbahTransaksi/kirimReject/'.$encrypted_string.'').'" class="btn btn-danger btn-md btn-flat">Not Confirmed</a>';
                                        }?>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                            <a href="javascript:history.back(1)" class="btn btn-primary btn-md btn-flat">Back</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
