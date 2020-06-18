<section class="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-primary box-solid">
                            <div class="box-body">
                                <div class="panel-body">
                                    <center><h2>Detail <?= $root?></h2></center>
                                    <center><p style="font-size:20px"><?= $desc?></p></center>
                                </div>

                                <form action="<?php echo base_url('MonitoringDeliverySparepart/BomManagement/updateBom'); ?>" method="post">
                                <div class="panel-body">
                                <div class="table-responsive" >
                                    <?php 
                                        echo '<div class="just-padding">';
                                        echo $htmllist;
                                        echo '</div>';
                                                // echo "<pre>";
                                                // print_r($Tree);
                                                // print_r($BOM);
                                                // print_r($List);
                                                // exit();
                                    ?>
                                    </div>
                                    <div class="col-md-12 text-center">
                                        <button type="submit" class="btn btn-success">SAVE</button>
                                    </div>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
