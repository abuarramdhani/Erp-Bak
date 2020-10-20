<table class="table table-condensed">
    <tbody>
        <tr>
            <?php
            $i = 0;
            foreach ($presentase as $value) {
                if (($i + 1) % 4 == 0) {
                    $tutup = '</td></tr><tr>';
                } else {
                    $tutup = '</td>';
                }
                if ($value['jml'] == 0) {
                    $persen = number_format(0.00, 2);
                } else {
                    $persen = number_format(($value['jml'] / $value['jml_asli']) * 100, 2);
                }
                if ($persen > 60 && $persen <= 80) {
                    $class_progress = 'progress-bar-warning';
                } else if ($persen > 80 && $persen <= 100) {
                    $class_progress = 'progress-bar-danger';
                } else {
                    $class_progress = 'progress-bar-success';
                }
                if ($value['class'] != 'OTHER') {
                    echo '<td class="text-center">' . $value['class'] . '</td>
                    <td>
                      <div class="progress">
                        <div class="progress-bar ' . $class_progress . '" style="width: ' . $persen . '%;color:black">&nbsp;' . $persen . '%</div>
                      </div><span>' . $value['jml'] . ' dari ' . $value['jml_asli'] . '</span>' . $tutup;
                } else {
                    echo '<td class="text-center">' . $value['class'] . '</td>
                    <td><div>' . $value['jml'] . ' Item</div>' . $tutup;
                }

                $i++;
            }
            ?>
    </tbody>
</table>
<form name="Orderform" action="<?php echo base_url('DbHandling/MonitoringHandling/DownLoadPersentase'); ?>" target="_blank" enctype="multipart/form-data" onsubmit="return validasi();window.location.reload();" method="post">
    <div class="col-md-12" style="text-align: right;"><button class="btn btn-success">Export Excel</button></div>
</form>