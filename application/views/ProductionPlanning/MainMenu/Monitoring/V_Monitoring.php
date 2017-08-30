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
                    <div class="col-lg-9 col-md-9">
                        <div class="row">
                            <div class="col-lg-12 col-md-12">
                                <div id="monFabCarsl" class="carousel slide" data-ride="carousel" data-interval="20000">
                                    <div class="carousel-inner" role="listbox">
                            <?php
                                $count = count($plan);
                                $crslActive = 'active';
                                for ($i=0; $i < $count; $i++) {
                            ?>
                                        <div class="item <?php echo $crslActive; ?>">
                                            <div class="col-md-6 text-left">
                                                <?php
                                                foreach ($section as $sc) {
                                                    // foreach ($selectedSection as $slcSec) {
                                                        // && $plan[$i][0]['section_id'] == $sc['section_id']
                                                        if ($selectedSection[$i] == $sc['section_id'] ) { ?>
                                                    <b>
                                                        SEKSI : <?php echo $sc['section_name']; ?>
                                                    </b>
                                                <?php   // }
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
                                                <div class="col-md-6 text-right">
                                                    <b>
                                                        ACHIEVEMENT =
                                                        <?php echo "75"; ?>
                                                        %
                                                    </b>
                                                </div>
                                                <table class="table">
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
                                                    <tbody>
                                                        <?php
                                                        $no=1;
                                                        foreach ($plan[$i] as $pl ){
                                                            $status = '';
                                                            if ($pl['achieve_qty'] >= $pl['need_qty']) {
                                                                $status = 'OK';
                                                            }else{
                                                                $status = 'NOT OK';
                                                            }
                                                        ?>
                                                            <tr class="<?php if ($pl['priority']==1){echo "priority-1";}else{echo "priority-normal";}?>" style="<?php if ($status == 'OK'){echo "display: none;";} ?>">
                                                                <td>
                                                                    <?php echo $no++; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $pl['item_code']; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $pl['item_description']; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $pl['priority']; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $pl['need_qty']; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $pl['due_time']; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $pl['achieve_qty']; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $pl['last_delivery']; ?>
                                                                </td>
                                                                <td>
                                                                    <?php
                                                                        echo $status;
                                                                    ?>
                                                                </td>
                                                            </tr>
                                                        <?php
                                                        } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                            <?php $crslActive = '';
                                }
                            ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <canvas id="month-fabrication" style="height: 250px;" data-secId="3">
                                </canvas>
                            </div>
                            <div class="col-md-4">
                                <br>
                                <table class="table table-bordered">
                                	<tr>
                                		<td></td>
                                		<td>Jumlah Job</td>
                                		<td>Jumlah Part (Pcs)</td>
                                	</tr>
                                	<tr>
                                		<td>Job Released</td>
                                		<td></td>
                                		<td></td>
                                	</tr>
                                	<tr>
                                		<td>Job Pending Picklist</td>
                                		<td></td>
                                		<td></td>
                                	</tr>
                                	<tr>
                                		<td>Total Job Complete 1 bulan</td>
                                		<td></td>
                                		<td></td>
                                	</tr>
                                	<tr>
                                		<td>Job Terlama</td>
                                		<td colspan="2">
                                			<?php echo date('d-m-Y'); ?>
                                		</td>
                                	</tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3">
                        <div class="row">
                            <div class="col-lg-12 col-md-12">
                                <table class="table table-bordered">
                                	<tr>
                                		<td colspan="2">
                                			<b>ACHIEVEMENT ALL FAB</b>
                                		</td>
                                	</tr>
                                    <?php foreach ($section as $sc) { ?>
                                        <tr>
                                            <td style="width: 70%">
                                                <b><?php echo $sc['section_name']; ?></b>
                                            </td>
                                            <td style="width: 30%">
                                                <b>85%</b>
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
        <script src="<?php echo base_url('assets/plugins/jquery-2.1.4.min.js');?>" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/plugins/bootstrap/3.3.6/js/bootstrap.min.js');?>" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/plugins/chartjs/Chart.min.js');?>" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/plugins/dataTables/jquery.dataTables.min.js');?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/js/customPP.js');?>"></script>
        <script type="text/javascript">
            chartFabricationMon();
        </script>
    </body>
</html>