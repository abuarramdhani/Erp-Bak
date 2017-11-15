<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
        <title>
            Quick Fabrication Monitoring
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
                    <div class="col-lg-10 col-md-10">
                        <div class="row">
                            <div class="col-lg-12 col-md-12">
                                <h2 class="text-center" style="font-family: cursive;">
                                    <b>
                                        MONITOR ACHIEVEMENT FABRIKASI
                                    </b>
                                </h2>
                            </div>
                        </div>
                        <div id="monFabCarsl" class="carousel slide" data-ride="carousel" data-interval="20000">
                            <div class="carousel-inner" role="listbox">
                                <?php
                                    $count = count($selectedSection);
                                    $crslActive = 'active';
                                    for ($i=0; $i < $count; $i++) {
                                ?>
                                <div class="item <?php echo $crslActive; ?>">
                                    <div class="row">
                                        <div class="col-md-6 text-left">
                                            <?php
                                            foreach ($section as $sc) {
                                                if ($selectedSection[$i] == $sc['section_id'] ) { ?>
                                                <b>
                                                    SEKSI : <?php echo $sc['section_name']; ?>
                                                </b>
                                            <?php
                                                }
                                            } ?>
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
                                            <div class="col-md-6 text-right achievement" data-secid="<?php echo $selectedSection[$i]; ?>">
                                                <b>
                                                    ACHIEVEMENT =
                                                    <?php
                                                        if (!empty($secAchieve[$i])) {
                                                            echo $secAchieve[$i][0]['percentage'];
                                                        }else{
                                                            echo "0 %";
                                                        }
                                                    ?>
                                                </b>
                                            </div>
                                            <table class="table table-border-mon-prod mon-fab-table dailyPlan" data-secid="<?php echo $selectedSection[$i]; ?>" style="border: 2px solid #000;">
                                                <thead class="bg-primary" style="font-weight: bold; font-size: 14px;">
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
                                                if (!empty($highPriority[$i][0])) {
                                                ?>
                                                    <tbody id="highPriority" style="font-weight: bold;">
                                                        <?php
                                                        foreach ($highPriority[$i] as $hpl ){
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
                                                                        if (strlen($hpl['item_description']) > 25) {
                                                                            echo substr($hpl['item_description'],0,25).'...';
                                                                        }else{
                                                                            echo $hpl['item_description'];
                                                                        }
                                                                    ?>
                                                                </td>
                                                                <td>
                                                                    <?php
                                                                        if ($hpl['priority'] == 'NORMAL') {
                                                                            echo "N";
                                                                        }else{
                                                                            echo $hpl['priority'];
                                                                        }
                                                                    ?>
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
                                                                            echo "-";
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
                                                if (!empty($normalPriority[$i][0])) {
                                                ?>
                                                    <input type="hidden" name="checkpointBegin" data-secid="<?php echo $selectedSection[$i]; ?>" value="<?php echo $checkpoint; ?>">
                                                    <tbody id="normalPriority" style="font-weight: bold;">
                                                    <?php
                                                        foreach ($normalPriority[$i] as $npl ){
                                                        ?>
                                                            <tr class="plan-undone-normal" <?php if ($checkpoint > 6) {
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
                                                                            echo substr($npl['item_description'],0,25).' ...';
                                                                        }else{
                                                                            echo $npl['item_description'];
                                                                        }
                                                                    ?>
                                                                </td>
                                                                <td>
                                                                    <?php
                                                                        if ($npl['priority'] == 'NORMAL') {
                                                                            echo "N";
                                                                        }else{
                                                                            echo $npl['priority'];
                                                                        }
                                                                    ?>
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
                                                    <input type="hidden" name="checkpointEnd" data-secid="<?php echo $selectedSection[$i]; ?>" value="<?php echo $checkpoint; ?>">
                                                <?php
                                                }
                                                ?>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-8">
                                            <input type="hidden" name="sectionId<?php echo $i; ?>" value="<?php echo $selectedSection[$i]; ?>">
                                            <canvas id="month-fabrication<?php echo $selectedSection[$i]; ?>" height="250">
                                            </canvas>
                                        </div>
                                        <div class="col-md-4">
                                            <br>
                                            <table class="table table-border-mon-prod infoJob bg-green-plan" data-secid="<?php echo $selectedSection[$i]; ?>">
                                                <thead style="font-weight: bold; font-size: 12px;">
                                                    <tr>
                                                		<td></td>
                                                		<td class="text-center">JUMLAH JOB</td>
                                                		<td class="text-center">JUMLAH PART (PCS)</td>
                                                	</tr>
                                                </thead>
                                                <tbody style="font-weight: bold; font-size: 12px;">
                                                	<tr>
                                                		<td>JOB RELEASED</td>
                                                		<td class="text-right">
                                                            <?php echo $infoJob[0]['RELEASED_JUMLAH_JOB']; ?>
                                                        </td>
                                                		<td class="text-right">
                                                            <?php echo $infoJob[0]['RELEASED_JUMLAH_PART']; ?>
                                                        </td>
                                                	</tr>
                                                	<tr>
                                                		<td>JOB PENDING PICKLIST</td>
                                                		<td class="text-right">
                                                            <?php echo $infoJob[0]['PENDING_JUMLAH_JOB']; ?>
                                                        </td>
                                                		<td class="text-right">
                                                            <?php echo $infoJob[0]['PENDING_JUMLAH_PART']; ?>
                                                        </td>
                                                	</tr>
                                                	<tr>
                                                		<td>TOTAL JOB COMPLETE 1 BULAN</td>
                                                		<td class="text-right">
                                                            <?php echo $infoJob[0]['COMPLETE_JUMLAH_JOB']; ?>
                                                        </td>
                                                		<td class="text-right">
                                                            <?php echo $infoJob[0]['COMPLETE_JUMLAH_PART']; ?>
                                                        </td>
                                                	</tr>
                                                	<tr>
                                                		<td>JOB TERLAMA</td>
                                                		<td colspan="2">
                                                			<?php echo date('d, F Y', strtotime($infoJob[0]['JOB_TERLAMA'])); ?>
                                                		</td>
                                                	</tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <?php $crslActive = '';
                                    }
                                ?>
                                <input type="hidden" name="sectionCount" value="<?php echo $count; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2">
                        <div class="row" style="padding-top: 15px;">
                            <div class="col-lg-12 col-md-12">
                                <table class="table table-border-mon-prod bg-green-plan" id="minPercenDaily" style="text-align: center; vertical-align: middle;">
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
                                                    echo $c.'%';
                                                ?>
                                            </b></h2>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
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
        <script src="<?php echo base_url('assets/plugins/chartjs/Chart.min.js');?>" type="text/javascript"></script>
        <!-- <script src="<?php echo base_url('assets/plugins/dataTables/jquery.dataTables.min.js');?>"></script> -->
        <script src="<?php echo base_url('assets/plugins/datepicker/js/bootstrap-datepicker.js');?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/js/customPP.js');?>"></script>
        <script type="text/javascript">
            getSectionMon();
            var checkpointEnd = $('input[name="checkpointEnd"]').val();
            var repeat = setInterval(function(){
                getDailyPlan();
            }
            , 20000*checkpointEnd);

            var showhide = setInterval(function(){
                showHideNormalPlanningMultiple();
                getSectionMon();
                getAchieveAllFab();
                getInfoJob();
                getAchievement();
            }
            , 20000);
        </script>
    </body>
</html>