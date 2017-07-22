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
            <?php
		$data = array(
			array(
				"Item" 			=> "Fireman",
				"Desc" 			=> "20 Maret 1998",
				"Priority" 		=> 2,
				"Need_Qty" 		=> "20 Maret 1998",
				"Due_Time" 		=> "r_firman20",
				"Achieve_Qty" 	=> "r_firman20",
				"Last_Delivery" => "r_firman20",
				"Status" 		=> "r_firman20"
				),
			array(
				"Item" 			=> "Fireman",
				"Desc" 			=> "20 Maret 1998",
				"Priority" 		=> 2,
				"Need_Qty" 		=> "20 Maret 1998",
				"Due_Time" 		=> "r_firman20",
				"Achieve_Qty" 	=> "r_firman20",
				"Last_Delivery" => "r_firman20",
				"Status" 		=> "r_firman20"
				),
			array(
				"Item" 			=> "Fireman",
				"Desc" 			=> "20 Maret 1998",
				"Priority" 		=> 2,
				"Need_Qty" 		=> "20 Maret 1998",
				"Due_Time" 		=> "r_firman20",
				"Achieve_Qty" 	=> "r_firman20",
				"Last_Delivery" => "r_firman20",
				"Status" 		=> "r_firman20"
				),
			array(
				"Item" 			=> "Fireman",
				"Desc" 			=> "20 Maret 1998",
				"Priority" 		=> 2,
				"Need_Qty" 		=> "20 Maret 1998",
				"Due_Time" 		=> "r_firman20",
				"Achieve_Qty" 	=> "r_firman20",
				"Last_Delivery" => "r_firman20",
				"Status" 		=> "r_firman20"
				),
			array(
				"Item" 			=> "Fireman",
				"Desc" 			=> "20 Maret 1998",
				"Priority" 		=> 2,
				"Need_Qty" 		=> "20 Maret 1998",
				"Due_Time" 		=> "r_firman20",
				"Achieve_Qty" 	=> "r_firman20",
				"Last_Delivery" => "r_firman20",
				"Status" 		=> "r_firman20"
				),
			array(
				"Item" 			=> "Fireman",
				"Desc" 			=> "20 Maret 1998",
				"Priority" 		=> 3,
				"Need_Qty" 		=> "20 Maret 1998",
				"Due_Time" 		=> "r_firman20",
				"Achieve_Qty" 	=> "r_firman20",
				"Last_Delivery" => "r_firman20",
				"Status" 		=> "r_firman20"
				),
			array(
				"Item" 			=> "Fireman",
				"Desc" 			=> "20 Maret 1998",
				"Priority" 		=> 1,
				"Need_Qty" 		=> "20 Maret 1998",
				"Due_Time" 		=> "r_firman20",
				"Achieve_Qty" 	=> "r_firman20",
				"Last_Delivery" => "r_firman20",
				"Status" 		=> "r_firman20"
				)
		);
	?>
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
                        <div class="row">
                            <div class="col-lg-12 col-md-12">
                                <div class="col-md-6 text-left">
                                    <b>
                                        SEKSI : PERAKITAN
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
                                            <?php $no=1; foreach ($data as $dt) { ?>
                                            <tr class="<?php if ($dt['Priority']==1){echo "priority-1";}else{echo "priority-normal";}?>
                                                ">
                                                <td>
                                                    <?php echo $no++; ?>
                                                </td>
                                                <td>
                                                    <?php echo $dt['Item']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $dt['Desc']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $dt['Priority']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $dt['Need_Qty']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $dt['Due_Time']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $dt['Achieve_Qty']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $dt['Last_Delivery']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $dt['Status']; ?>
                                                </td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <canvas id="month-fabrication" style="height: 250px;">
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
                    <div class="col-lg-2 col-md-2">
                        <div class="row">
                            <div class="col-lg-12 col-md-12">
                                <table class="table table-bordered">
                                	<tr>
                                		<td colspan="2">
                                			<b>ACHIEVEMENT ALL FAB</b>
                                		</td>
                                	</tr>
                                	<tr>
                                		<td style="width: 60%">
                                			<b>FOUNDRY Pusat</b>
                                		</td>
                                		<td style="width: 40%">
                                			<b>85 %</b>
                                		</td>
                                	</tr>
                                	<tr>
                                		<td>
                                			<b>FOUNDRY Tuksono</b>
                                		</td>
                                		<td>
                                			<b>85 %</b>
                                		</td>
                                	</tr>
                                	<tr>
                                		<td>
                                			<b>MACHINING A</b>
                                		</td>
                                		<td>
                                			<b>85 %</b>
                                		</td>
                                	</tr>
                                	<tr>
                                		<td>
                                			<b>MACHINING B1</b>
                                		</td>
                                		<td>
                                			<b>85 %</b>
                                		</td>
                                	</tr>
                                	<tr>
                                		<td>
                                			<b>MACHINING B2</b>
                                		</td>
                                		<td>
                                			<b>85 %</b>
                                		</td>
                                	</tr>
                                	<tr>
                                		<td>
                                			<b>MACHINING C</b>
                                		</td>
                                		<td>
                                			<b>85 %</b>
                                		</td>
                                	</tr>
                                	<tr>
                                		<td>
                                			<b>MACHINING D</b>
                                		</td>
                                		<td>
                                			<b>85 %</b>
                                		</td>
                                	</tr>
                                	<tr>
                                		<td>
                                			<b>SHEET METAL</b>
                                		</td>
                                		<td>
                                			<b>85 %</b>
                                		</td>
                                	</tr>
                                	<tr>
                                		<td>
                                			<b>PERAKITAN A</b>
                                		</td>
                                		<td>
                                			<b>85 %</b>
                                		</td>
                                	</tr>
                                	<tr>
                                		<td>
                                			<b>PERAKITAN B</b>
                                		</td>
                                		<td>
                                			<b>85 %</b>
                                		</td>
                                	</tr>
                                	<tr>
                                		<td>
                                			<b>PERAKITAN C</b>
                                		</td>
                                		<td>
                                			<b>85 %</b>
                                		</td>
                                	</tr>
                                	<tr>
                                		<td>
                                			<b>PAINTING</b>
                                		</td>
                                		<td>
                                			<b>85 %</b>
                                		</td>
                                	</tr>
                                	<tr>
                                		<td>
                                			<b>PACKAGING</b>
                                		</td>
                                		<td>
                                			<b>85 %</b>
                                		</td>
                                	</tr>
                                	<tr>
                                		<td>
                                			<b>PEMBELIAN/VENDOR</b>
                                		</td>
                                		<td>
                                			<b>85 %</b>
                                		</td>
                                	</tr>
                                	<tr>
                                		<td>
                                			<b>RATA - RATA</b>
                                		</td>
                                		<td>
                                			<b>85 %</b>
                                		</td>
                                	</tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <script src="<?php echo base_url('assets/plugins/chartjs/Chart.min.js');?>" type="text/javascript"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/js/customPP.js');?>"></script>
        <script type="text/javascript">
            chartFabricationMon();
        </script>
    </body>
</html>