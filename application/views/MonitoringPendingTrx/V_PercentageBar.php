<div class="row">
    <div class="col-md-6">
    <div class="box box-warning">
        <div class="box-header" style="font-weight: bold;">
            Dari <?= $subinv.' / '.$loc2 ?>
        </div>
        <div class="box-body">
            <div class="col-md-12">
                <table class="table table-condensed">
                    <tbody>
                        <tr>
                            <?php
                            $i = 0;
                            $sum_dari = 0;
                            foreach ($dari as $total) {
                                $sum_dari += $total['JML'];
                            }

                            foreach ($dari as $value) {
                                if (($i + 1) % 2 == 0) {
                                    $tutup = '</td></tr><tr>';
                                }
                                else {
                                    $tutup = '</td>';
                                }

                                if ($value['JML'] == 0) {
                                    $persen = number_format(0.00, 2);
                                }
                                else {
                                    $persen = number_format(($value['JML'] / $sum_dari) * 100, 2);
                                }

                                if ($persen > 25 && $persen <= 50) {
                                    $class_progress = 'progress-bar-warning';
                                }
                                else if ($persen > 50 && $persen <= 100) {
                                    $class_progress = 'progress-bar-danger';
                                }
                                else {
                                    $class_progress = 'progress-bar-success';
                                }

                                echo '<td class="text-center" style="font-weight: bold;">' . $value['TO_SUBINVENTORY_CODE'] . '</td>
                                <td>
                                  <div class="progress">
                                    <div class="progress-bar ' . $class_progress . '" style="width: ' . $persen . '%; color: black"><b>&nbsp;' . $persen . '%</b></div>
                                  </div><span>' . $value['JML'] . ' dari ' . $sum_dari . '</span>' . $tutup;

                                $i++;
                            }
                            ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>
    <div class="col-md-6">
    <div class="box box-danger">
        <div class="box-header" style="font-weight: bold;">
            Ke <?= $subinv.' / '.$loc2 ?>
        </div>
        <div class="box-body">
            <div class="col-md-12">                    
                <table class="table table-condensed">
                    <tbody>
                        <tr>
                            <?php
                            $i = 0;
                            $sum_ke = 0;
                            foreach ($ke as $total) {
                                $sum_ke += $total['JML'];
                            }

                            foreach ($ke as $value) {
                                if (($i + 1) % 2 == 0) {
                                    $tutup = '</td></tr><tr>';
                                }
                                else {
                                    $tutup = '</td>';
                                }

                                if ($value['JML'] == 0) {
                                    $persen = number_format(0.00, 2);
                                }
                                else {
                                    $persen = number_format(($value['JML'] / $sum_ke) * 100, 2);
                                }

                                if ($persen > 25 && $persen <= 50) {
                                    $class_progress = 'progress-bar-warning';
                                }
                                else if ($persen > 50 && $persen <= 100) {
                                    $class_progress = 'progress-bar-danger';
                                }
                                else {
                                    $class_progress = 'progress-bar-success';
                                }

                                echo '<td class="text-center" style="font-weight: bold;">' . $value['FROM_SUBINVENTORY_CODE'] . '</td>
                                <td>
                                  <div class="progress">
                                    <div class="progress-bar ' . $class_progress . '" style="width: ' . $persen . '%; color: black"><b>&nbsp;' . $persen . '%</b></div>
                                  </div><span>' . $value['JML'] . ' dari ' . $sum_ke . '</span>' . $tutup;

                                $i++;
                            }
                            ?>
                    </tbody>
                </table>                    
            </div>
        </div>
    </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="box box-success">
            <div class="box-header" style="font-weight: bold;">
                Export Data
            </div>
            <div class="box-body">
            <form name="exportData" action="<?php echo base_url('MonitoringPendingTrx/Monitoring/exportData'); ?>" target="_blank" enctype="multipart/form-data" method="post">
                <div class="col-md-3">
                    <label>From Subinv</label>
                    <select class="form-control select2" name="expFSubinv" id="expFSubinv" required>
                        <option></option>
                        <?php 
                            foreach ($ke as $value) {
                        ?>
                        <option value="<?= $value['FROM_SUBINVENTORY_CODE'] ?>"><?= $value['FROM_SUBINVENTORY_CODE'] ?></option>
                        <?php
                            }
                        ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label>To Subinv</label>
                    <!-- <select class="form-control select2" name="expTSubinv" id="expTSubinv" required>
                        <option></option>
                    </select> -->
                    <input type="text" class="form-control" name="expTSubinv" id="expTSubinv" value="<?= $subinv ?>" readonly>
                </div>
                <div class="col-md-3">
                    <label>To Locator</label>
                    <!-- <select class="form-control select2" name="expTLoc" id="expTLoc" required>
                        <option></option>
                    </select> -->
                    <input type="text" class="form-control" name="expLSubinv" id="expLSubinv" value="<?= $loc2 ?>" readonly>
                </div>
                <div class="col-md-3">
                    <label style="color: transparent;">____</label>
                    <p>
                        <button type="submit" class="btn btn-success"><i class="fa fa-file-excel-o"> Export Excel</i></button>
                    </p>    
                </div>
            </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $("#expFSubinv").select2({
        placeholder: 'Pilih Subinventory',
        allowClear: true
    });
</script>