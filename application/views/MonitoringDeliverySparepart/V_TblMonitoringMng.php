<section class="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-11">
                            <div class="text-right">
                                <h1>
                                    <b>
                                        <?= $Title ?> 
                                    </b>
                                </h1>
                            </div>
                        </div>
                        <div class="col-lg-1 ">
                            <div class="text-right hidden-md hidden-sm hidden-xs">
                                <a class="btn btn-default btn-lg"
                                    href="<?php echo site_url('MonitoringDeliverySparepart/MonitoringManagement/');?>">
                                    <i class="icon-wrench icon-2x">
                                    </i>
                                    <span>
                                        <br />
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <br />
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-primary box-solid">
                            <div class="box-body">
                                <div class="panel-body">
                                    <center><h2>Detail <?= $root?></h2></center>
                                    <center><p style="font-size:20px"><?= $desc?></p></center>
                                </div>

                                <div class="panel-body">
                                <div class="table-responsive" >
                                <table class="table table-responsive table-hover text-center" style="width: 100%">
                                    <thead>
                                        <tr class="text-nowrap bg-primary">
                                            <th><i class="fa fa-plus" aria-hidden="true"></i></th>
                                            <th>Bom Level</th>
                                            <th>Component Code</th>
                                            <th>Description</th>
                                            <th>QTY/Unit</th>
                                            <th>Seksi</th>
                                            <?php 
                                            if ($bulan == 'Jan' || $bulan == 'Mar' || $bulan == 'May' || $bulan == 'Jul' || $bulan == 'Ags' || $bulan == 'Oct' || $bulan == 'Dec') {
                                                for ($i=1; $i < 32; $i++) { 
                                                    echo ("<th>$i</th>");
                                                }
                                            }elseif ($bulan == 'Apr' || $bulan == 'Jun' || $bulan == 'Sep' || $bulan == 'Nov') {
                                                for ($i=1; $i < 31; $i++) { 
                                                    echo ("<th>$i</th>");
                                                }
                                            }elseif ($bulan == 'Feb') {
                                                if ($tahun%4 == 0) {
                                                    for ($i=1; $i < 30; $i++) { 
                                                        echo ("<th>$i</th>");
                                                    }
                                                }else {
                                                    for ($i=1; $i < 29; $i++) { 
                                                        echo ("<th>$i</th>");
                                                    }
                                                }
                                            }
                                            ?>
                                        </tr>
                                    </thead>
                                    <tbody>
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
                                    </tbody>
                                </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

