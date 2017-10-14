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
                    <div class="col-lg-12 col-md-12">
                        <h3 class="text-center">
                            <b>
                                MONITOR ACHIEVEMENT FABRIKASI
                            </b>
                        </h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-10 col-md-10">
                        <div id="monFabCarsl" class="carousel slide" data-ride="carousel" data-interval="20000">
                            <div class="carousel-inner" role="listbox">
                                <?php
                                    $count = count($selectedSection);
                                    $crslActive = 'active';
                                    for ($i=0; $i < $count; $i++) {
                                ?>
                                <div class="item <?php echo $crslActive; ?>">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12">
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
                                                <table class="table mon-fab-table dailyPlan" data-secid="<?php echo $selectedSection[$i]; ?>">
                                                    <thead class="bg-primary" style="font-weight: bold; font-size: 16px;">
                                                        <tr>
                                                            <td>
                                                                No
                                                            </td>
                                                            <td>
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
                                                            <td>
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
                                                    if (!empty($highPriority[$i][0])) {
                                                    ?>
                                                        <tbody id="highPriority">
                                                            <?php
                                                            foreach ($highPriority[$i] as $hpl ){
                                                                if ($hpl['achieve_qty'] >= $hpl['need_qty']) {
                                                                    $classStatus = "plan-done";
                                                                }else{
                                                                    $classStatus = "plan-undone-high";
                                                                }
                                                            ?>
                                                                <tr class="<?php echo $classStatus; ?>">
                                                                    <td>
                                                                        <?php echo $no++; ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php echo $hpl['item_code']; ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php
                                                                            if (strlen($hpl['item_description']) > 20) {
                                                                                echo substr($hpl['item_description'],0,20).'...';
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
                                                                        <?php echo $hpl['achieve_qty']; ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php echo $hpl['last_delivery']; ?>
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
                                                        <tbody id="normalPriority">
                                                        <?php
                                                            foreach ($normalPriority[$i] as $npl ){
                                                                if ($npl['achieve_qty'] >= $npl['need_qty']) {
                                                                    $classStatus = "plan-done";
                                                                }else{
                                                                    $classStatus = "plan-undone-normal";
                                                                }
                                                            ?>
                                                                <tr class="<?php echo $classStatus; ?>" <?php if ($checkpoint > 6) {
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
                                                                        <?php echo $npl['item_description']; ?>
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
                                                                        <?php echo $npl['achieve_qty']; ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php echo $npl['last_delivery']; ?>
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
                                    </div>
                                    <div class="row">
                                        <div class="col-md-8">
                                            <input type="hidden" name="sectionId<?php echo $i; ?>" value="<?php echo $selectedSection[$i]; ?>">
                                            <canvas id="month-fabrication<?php echo $selectedSection[$i]; ?>" height="250">
                                            </canvas>
                                        </div>
                                        <div class="col-md-4">
                                            <br>
                                            <table class="table table-bordered infoJob" data-secid="<?php echo $selectedSection[$i]; ?>">
                                                <thead>
                                                    <tr>
                                                		<td></td>
                                                		<td class="text-center">JUMLAH JOB</td>
                                                		<td class="text-center">JUMLAH PART (PCS)</td>
                                                	</tr>
                                                </thead>
                                                <tbody>
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
                        <div class="row">
                            <div class="col-lg-12 col-md-12">
                                <table class="table table-bordered" id="achieveAllFab">
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
            var repeat = setInterval(function(){
                getSectionMon();
                getDailyPlan();
                getAchieveAllFab();
                getInfoJob();
                getAchievement();
            }
            , 600000);

            var showhide = setInterval(function(){
                showHideNormalPlanning();
            }
            , 20000);
        </script>
    </body>
</html>