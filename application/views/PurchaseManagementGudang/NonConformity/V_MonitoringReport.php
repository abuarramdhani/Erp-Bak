<section class="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-right">
                            <h1>
                                <b>
                                    <?php echo $Title; ?>
                                </b>
                            </h1>
                        </div>
                    </div>
                </div>
                <br/>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-primary">
                            <div class="box-body">
                                <button type="button" class="btn btn-default btnFilterNC"><i class="fa fa-filter"></i>Filters</button><br><br>
                                <table class="table table-bordered table-hover table-striped" id="tblMonitoringNonC">
                                    <thead>
                                        <tr class="bg-aqua">
                                            <th>TASKLIST</th>
                                            <th width="150px">NC Number</th>
                                            <th>Verificator</th>
                                            <th>PERIODE</th>
                                            <th>NO.</th>
                                            <th>NO.LPPB</th>
                                            <th>TGL SJ</th>
                                            <th>NO.SJ</th>
                                            <th>PO (LINE)</th>
                                            <th>ITEM</th>
                                            <th>VENDOR</th>
                                            <th>BUYER</th>
                                            <th>KATEGORI KASUS</th>
                                            <th>PELACAKAN KASUS</th>
                                            <th>SCOPE</th>
                                            <th>CAR ?</th>
                                            <th>PENYELESAIAN</th>
                                            <th>TGL PENYELESAIAN</th>
                                            <th>STATUS</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($monitoring_report as $key => $report) { ?>
                                            <tr>
                                                <td>
                                                    <?php

                                                        if (!$report['tasklist']) {
                                                            echo 'Pending Assign';
                                                        }elseif ($report['tasklist'] == 1 &&  $report[0][0]['status'] !=1 && $report['forward_buyer'] != 1) {
                                                           echo 'List Data Supplier';
                                                        }elseif ($report['tasklist'] == 2 &&  $report[0][0]['status'] !=1 && $report['forward_buyer'] != 1) {
                                                            echo 'List Data Subkon';
                                                        }elseif ($report['tasklist'] == 3 &&  $report[0][0]['status'] !=1 && $report['forward_buyer'] != 1) {
                                                            echo 'Return to PBB';
                                                        }elseif ($report['tasklist'] == 4 &&  $report[0][0]['status'] !=1 && $report['forward_buyer'] != 1) {
                                                            echo 'Pending Execute';
                                                        }elseif ($report['forward_buyer'] == 1 &&  $report[0][0]['status'] !=1) {
                                                           echo 'List Data For Buyer';
                                                        }elseif ( $report[0][0]['status'] == 1) {
                                                            echo 'Finish Order';
                                                        }
                                                    ?>
                                                </td>
                                                <td><?= $report['non_conformity_num'];?></td>
                                                <td><?= $report['verificator'];?></td>
                                                <td><?= date('Y-m-d', strtotime($report['periode']));?></td>
                                                <td><?php
                                                        $nc_num = $report['non_conformity_num'];
                                                        $nc = explode('-',$nc_num);

                                                        echo $nc[4];
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php 
                                                        if ($report[1]) {
                                                            echo $report[1][0]['no_lppb'];
                                                        }
                                                    // foreach ($report[1] as $keys => $lppb) { 
                                                    //     if (count($report[1]) > 1) {
                                                    //         echo $lppb['no_lppb'].', <br>';

                                                    //         if (($keys+1) == count($report[1])) {
                                                    //             echo $lppb['no_lppb'];
                                                    //         }
                                                    //     }else{
                                                    //         echo $lppb['no_lppb'];
                                                    //     }
                                                    // } 
                                                    ?>
                                                </td>
                                                <td><?= $report['tgl_sj'];?></td>
                                                <td><?= $report['no_sj'];?></td>
                                                <td><?php foreach ($report[1] as $keys => $po) { 
                                                        if (count($report[1]) > 1) {
                                                            if (($keys+1) == count($report[1])) {
                                                                echo $po['no_po'].'('.$po['line'].')';
                                                            }else{

                                                                echo $po['no_po'].'('.$po['line'].'), <br>';
                                                            }
                                                            
                                                        }else{
                                                            echo $po['no_po'].'('.$po['line'].')';
                                                        }
                                                        
                                                    } ?>
                                                </td>
                                                <td><?php foreach ($report[1] as $keys => $item) { 
                                                        if (count($report[1]) > 1) {
                                                            if (($keys+1) == count($report[1])) {
                                                                echo $item['item_code'];
                                                            }else{
                                                                echo $item['item_code'].', <br>';
                                                            }
                                                        }else{
                                                            echo $item['item_code'];
                                                        }
                                                    } ?>
                                                </td>
                                                <td><?= $report['vendor'];?></td>
                                                <td><?php if ($report[1]) {
                                                    echo $report[1][0]['buyer'];
                                                };?></td>
                                                <td><?php foreach ($report[0] as $keys => $case) { 
                                                        if (count($report[0] > 1)) {
                                                            if (($keys+1) == count($report[1])) {
                                                                echo $case['case_name'];
                                                            }else{

                                                                echo $case['case_name'].', <br>';
                                                            }
                                                        }else{
                                                            echo $case['case_name'];
                                                        }
                                                    } ?></td>
                                                 <td>
                                                    <?php 
                                                    if ($report[0]) {
                                                        echo $report[0][0]['problem_tracking'];
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php 
                                                        if ($report[0]) {
                                                            
                                                            $scope = $report[0][0]['scope'];
                                                            if ($scope == 0) {
                                                                echo 'External';
                                                            }else if($scope == 1){
                                                                echo 'Internal';
                                                            }
                                                        }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php 
                                                    if ($report[0]) {
                                                        echo $report[0][0]['judgement'];
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php 
                                                    if ($report[0]) {
                                                        echo $report[0][0]['problem_completion'];
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php 
                                                    if ($report[0]) {
                                                        echo $report[0][0]['completion_date'];
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                <?php 
                                                if ($report[0]) {
                                                    if ($report[0][0]['status'] == 0) {
                                                       echo 'OPEN';
                                                    }elseif ($report[0][0]['status'] == 1) {
                                                        echo 'CLOSE';
                                                    }
                                                }
                                                ?>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="modal fade" id="ModFilterReportNC">
    <div class="modal-dialog" style="min-width:800px;">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Pilter</h4>
        </div>
        <div class="modal-body">
            <div class="box box-body">
                <div class="col-md-12">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Status</label>
            
                            <div class="col-sm-8">
                                <select class="slc2 slcStatusNC" data-placeholder="Filter by status" name="slcSeksi[]" style="width: 100%;">
                                    <option></option>
                                    <option value="OPEN">OPEN</option>
                                    <option value="CLOSE">CLOSE</option>
                                </select>
                            </div>
                        </div><br><br>
                        <div class="form-group">
						    <label class="col-sm-4 control-label">Periode</label>
						    <div class="col-sm-8">
							    <input type="text" class="form-control minPeriodeNC" placeholder="Filter by min. tanpa %" style="width: 100%;"><br>
							    <input type="text" class="form-control maxPeriodeNC" placeholder="Filter by max. tanpa %" style="width: 100%;">
						    </div>
					    </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
							<label class="col-sm-4 control-label">Vendor</label>
							<div class="col-sm-8">
								<select name="slcVendorNC" class="slcVendorNC" data-placeholder="Filter by Vendor" style="width: 100%;">
									<option></option>
									<?php foreach ($list_vendor as $key => $vendor) { ?>
										<option value="<?= $vendor['vendor'] ?>"> <?= $vendor['vendor'] ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
                    </div><br><br><br>
                    <div class="col-md-6">
                        <div class="form-group">
							<label class="col-sm-4 control-label">Buyer</label>
							<div class="col-sm-8">
								<select name="slcBuyerNC" class="slcBuyerNC" data-placeholder="Filter by Buyer" style="width: 100%;">
									<option></option>
									<?php foreach ($list_buyer as $key => $buyer) { ?>
										<option value="<?= $buyer['buyer'] ?>"> <?= $buyer['buyer'] ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-md btn-default pull-left" data-dismiss="modal">Close</button>
            <button class="btn btn-md bg-navy" onclick="filterMonitoringReportNC(event)">Set Filter </button>
        </div>
    </div>
    </div>
</div>