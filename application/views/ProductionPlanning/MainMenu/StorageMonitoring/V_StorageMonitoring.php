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
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/custom.css');?>">
        </link>
    </head>
    <body>
        <section id="mon-area">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <h2 class="text-center">
                            <b>
                                MONITOR ACHIEVEMENT FABRIKASI
                            </b>
                        </h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-10 col-md-10">
                        <div class="row">
                            <div class="col-lg-12 col-md-12">
                                <div class="col-md-6 text-left">
                                    <b>
                                        STORAGE NAME : <?php echo $storage[0]['storage_name']; ?>
                                        <input type="hidden" name="storage_name" value="<?php echo $storage[0]['storage_name']; ?>">
                                    </b>
                                </div>
                                <div class="col-md-6 text-right">
                                    <b>
                                        TANGGAL :
                                        <?php echo date('d-m-Y'); ?>
                                    </b>
                                </div>
                                <div class="col-lg-12 col-md-12" style="padding-top: 20px;">
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
                                    <table class="table mon-fab-table dailyPlan table-border-mon-prod">
                                        <thead class="bg-primary" style="font-weight: bold; font-size: 14px;">
                                            <tr>
                                                <td>
                                                    No
                                                </td>
                                                <td style="width: 15%;">
                                                    Item
                                                </td>
                                                <td>
                                                    Desc
                                                </td>
                                                <td>
                                                    Priority
                                                </td>
                                                <td>
                                                    Need Qty
                                                </td>
                                                <td style="width: 15%;">
                                                    Due Time
                                                </td>
                                                <td>
                                                    Achieve Qty
                                                </td>
                                                <td>
                                                    Last Delivery
                                                </td>
                                                <td>
                                                    Status
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
                                                    <tr class="plan-undone-high">
                                                        <td>
                                                            <?php echo $no++; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $hpl['item_code']; ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                                if (strlen($hpl['item_description']) > 15) {
                                                                    echo substr($hpl['item_description'],0,15).'...';
                                                                }else{
                                                                    echo $hpl['item_description'];
                                                                }
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $hpl['priority']; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $hpl['need_qty']; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $hpl['due_time']; ?>
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
                                                    <tr class="plan-undone-normal" <?php if ($checkpoint > 12) {
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
                                                                if (strlen($npl['item_description']) > 15) {
                                                                    echo substr($npl['item_description'],0,15).'...';
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
                                                            <?php echo $npl['due_time']; ?>
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
                    </div>
                    <div class="col-lg-2 col-md-2">
                        <div class="row">
                            <div class="col-lg-12 col-md-12">
                                <table class="table table-border-mon-prod bg-green-plan" id="achieveAllFab">
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
                                            <td style="width: 30%">
                                                <b><?php echo $aa['percentage']; ?></b>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </table>
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