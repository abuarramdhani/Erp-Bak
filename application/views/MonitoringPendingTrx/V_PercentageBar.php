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