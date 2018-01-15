<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
        <title>
            Quick Storage Monitoring
        </title>
        <link href="<?php echo base_url('assets/img/logo.ico');?>" rel="shortcut icon" type="image/x-icon">
            <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
            <!-- GLOBAL STYLES -->
            <link href="<?php echo base_url('assets/plugins/bootstrap/3.3.6/css/bootstrap.css');?>" rel="stylesheet"/>
            <link rel="stylesheet" href="<?php echo base_url('assets/plugins/Font-Awesome/4.3.0/css/font-awesome-animation.css');?>" type="text/css" />
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/custom.css');?>">
        </link>
    </head>
    <body>
        <section id="mon-area">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-10 col-md-10">
                        <div class="row">
                            <div class="col-md-3 text-left">
                                <div style="margin-top: 15px; width: 100%; border-radius: 5px 60px 5px 5px; padding: 4px 5px 4px 5px;" class="bg-success-plan">
                                    <h5><b>
                                        STORAGE NAME : <?php echo $storage[0]['storage_name']; ?>
                                        <input type="hidden" name="storage_name" value="<?php echo $storage[0]['storage_name']; ?>">
                                    </b></h5>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h3 class="text-center" style="font-family: cursive;">
                                    <b>
                                        MONITOR ACHIEVEMENT FABRIKASI
                                    </b>
                                </h3>
                            </div>
                            <div class="col-md-3 text-right">
                                <div style="margin-top: 15px; width: 100%; border-radius: 60px 5px 5px 5px; padding: 4px 5px 4px 5px;" class="bg-success-plan">
                                    <h5><b>
                                        TANGGAL :
                                        <?php echo date('d-m-Y'); ?>
                                    </b></h5>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 text-left">
                                <b>
                                    TARGET PENGIRIMAN KOMPONEN
                                </b>
                            </div>
                            <div class="col-md-6 text-right achievement">
                                <b>
                                    ACHIEVEMENT =
                                    <?php
                                        if (!empty($stgAchieve)) {
                                            echo $stgAchieve[0]['percentage'];
                                        }else{
                                            echo "0 %";
                                        }
                                    ?>
                                </b>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <table class="table mon-fab-table dailyPlan table-border-dark">
                                    <thead style="font-weight: bold; font-size: 14px;">
                                        <tr>
                                            <td style="width: 5%;">
                                                NO
                                            </td>
                                            <td style="width: 15%;">
                                                ITEM
                                            </td>
                                            <td style="width: 25%;">
                                                DESC
                                            </td>
                                            <td>
                                                PRIOR
                                            </td>
                                            <td>
                                                NEED QTY
                                            </td>
                                            <td>
                                                DUE TIME
                                            </td>
                                            <td>
                                                ACHIEVE QTY
                                            </td>
                                            <td>
                                                LAST DELIVERY
                                            </td>
                                            <td>
                                                STATUS
                                            </td>
                                        </tr>
                                    </thead>
                                    <?php
                                    $no=1;
                                    $checkpoint = 1;
                                    if (!empty($highPriority)) {
                                    ?>
                                        <tbody id="highPriority" style="font-weight: bold;">
                                            <?php
                                            foreach ($highPriority as $hpl){
                                            ?>
                                                <tr class="bg-danger-plan">
                                                    <td>
                                                        <?php echo $no++; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $hpl['item_code']; ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                            if (strlen($hpl['item_description']) > 25) {
                                                                echo substr($hpl['item_description'],0,25).'...';
                                                            }else{
                                                                echo $hpl['item_description'];
                                                            }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php if ($hpl['priority'] == 'NORMAL') {
                                                                echo "N";
                                                            }else{
                                                                echo $hpl['priority'];
                                                            } ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $hpl['need_qty']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo date('d/m H:i', strtotime($hpl['due_time'])); ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                            if ($hpl['achieve_qty'] == null) {
                                                                echo "0";
                                                            }else{
                                                                echo $hpl['achieve_qty'];
                                                            }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                            if ($hpl['last_delivery'] == null) {
                                                                echo "-";
                                                            }else{
                                                                echo $hpl['last_delivery'];
                                                            }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                            echo $hpl['status'];
                                                        ?>
                                                    </td>
                                                </tr>
                                                <?php
                                                $checkpoint++;
                                            }
                                        ?>
                                        </tbody>
                                    <?php
                                    }
                                    if (!empty($normalPriority)) {
                                    ?>
                                        <input type="hidden" name="checkpointBegin" value="<?php echo $checkpoint; ?>">
                                        <tbody id="normalPriority" style="font-weight: bold;">
                                        <?php
                                            foreach ($normalPriority as $npl ){
                                            ?>
                                                <tr class="bg-success-plan" <?php if ($checkpoint > 12) {
                                                    echo " data-showid='".$checkpoint."'";
                                                    echo " data-showstat='0'";
                                                    echo " style='display:none;'";
                                                    $checkpoint++;
                                                }else{
                                                    echo " data-showid='".$checkpoint."'";
                                                    echo " data-showstat='1'";
                                                    $checkpoint++;
                                                } ?>>
                                                    <td>
                                                        <?php echo $no++; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $npl['item_code']; ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                            if (strlen($npl['item_description']) > 25) {
                                                                echo substr($npl['item_description'],0,25).'...';
                                                            }else{
                                                                echo $npl['item_description'];
                                                            }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $npl['priority']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $npl['need_qty']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo date('d/m H:i', strtotime($npl['due_time'])); ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                            if ($npl['achieve_qty'] == null) {
                                                                echo "0";
                                                            }else{
                                                                echo $npl['achieve_qty'];
                                                            }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                            if ($npl['last_delivery'] == null) {
                                                                echo "-";
                                                            }else{
                                                                echo $npl['last_delivery'];
                                                            }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                            echo $npl['status'];
                                                        ?>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                        ?>
                                        </tbody>
                                        <input type="hidden" name="checkpointEnd" value="<?php echo $checkpoint; ?>">
                                    <?php
                                    }
                                    ?>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2">
                        <div class="row" style="padding-top: 15px;">
                            <div class="col-lg-12 col-md-12">
                                <table class="table table-border-dark" id="minPercenDaily" style="text-align: center; vertical-align: middle;">
                                    <tr>
                                        <td><b>MINIMUM PERCENTAGE</b></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <h2 style="font-family: cursive; margin: 5px;"><b>
                                                <?php
                                                    $a = date('d');
                                                    $b = date('t');
                                                    $c = ($a/$b)*100;
                                                    echo round($c,0).'%';
                                                ?>
                                            </b></h2>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12">
                                <table class="table table-border-dark" id="achieveAllFab">
                                    <tr>
                                        <td colspan="2">
                                            <b>ACHIEVEMENT ALL FAB</b>
                                        </td>
                                    </tr>
                                    <?php foreach ($achieveAll as $aa) {?>
                                        <tr>
                                            <td style="width: 70%">
                                                <b><?php echo $aa['section_name']; ?></b>
                                            </td>
                                            <?php
                                                if ($aa['percentage'] < round($c,0)) {
                                                    $percenStyle = 'bg-danger-plan';
                                                    $percenVal = '<span class="faa-flash faa-slow animated">'.$aa['percentage'].'</span>';
                                                }else{
                                                    $percenStyle = 'bg-success-plan';
                                                    $percenVal = $aa['percentage'];
                                                }
                                            ?>
                                            <td style="width: 30%;" class="<?php echo $percenStyle; ?>">
                                                <b><?php
                                                    echo $percenVal;
                                                ?></b>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </section>
        <script type="text/javascript">
            var baseurl = "<?php echo base_url(); ?>";
        </script>
        <script src="<?php echo base_url('assets/plugins/jquery-2.1.4.min.js');?>" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/plugins/bootstrap/3.3.6/js/bootstrap.min.js');?>" type="text/javascript"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/js/customPP.js');?>"></script>
        <script type="text/javascript">
            var checkpointEnd = $('input[name="checkpointEnd"]').val();
            var repeat = setInterval(function(){
                getDailyPlanStorage();
            }
            , 20000*checkpointEnd);

            var showhide = setInterval(function(){
                showHideNormalPlanningStorage();
                getAchieveAllFab();
                getAchievementStorage();
            }
            , 20000);
        </script>
    </body>
</html>