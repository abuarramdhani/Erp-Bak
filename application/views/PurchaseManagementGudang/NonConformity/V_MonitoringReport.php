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
                                                    $assign = $report['tasklist'];
                                                        if ($assign == '') {
                                                            echo 'Pending Assign';
                                                        }elseif ($assign == 1) {
                                                           echo 'List Data Supplier';
                                                        }elseif ($assign == 2) {
                                                            echo 'List Data Subkon';
                                                        }elseif ($assign == 3) {
                                                            echo 'Return to PBB';
                                                        }elseif ($assign == 4) {
                                                            echo 'Pending Execute';
                                                        }elseif ($report[0][0]['status'] == 1) {
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
                                                            echo $po['no_po'].'('.$po['line'].'), <br>';
                                                            if (($keys+1) == count($report[1])) {
                                                                echo $po['no_po'].'('.$po['line'].')';
                                                            }
                                                        }else{
                                                            echo $po['no_po'].'('.$po['line'].')';
                                                        }
                                                        
                                                    } ?>
                                                </td>
                                                <td><?php foreach ($report[1] as $keys => $item) { 
                                                    if (count($report[1]) > 1) {
                                                        echo $item['item_code'].', <br>';

                                                        if (($keys+1) == count($report[1])) {
                                                            echo $item['item_code'];
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
                                                            echo $case['case_name'].', <br>';
                                                            if (($keys+1) == count($report[1])) {
                                                                echo $case['case_name'];
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