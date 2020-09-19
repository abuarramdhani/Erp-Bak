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
                $persen = number_format(($value['jml'] / $value['jml_asli']) * 100, 2);
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