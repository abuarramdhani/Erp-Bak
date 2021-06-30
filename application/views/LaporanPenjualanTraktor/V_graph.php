<?php
require_once(APPPATH . 'libraries/SVGGraph/autoloader.php');

?>
<!DOCTYPE html>
<html>

<body style="text-align:center">
    <div style="padding-bottom:30px;">
        <?php

        $settings = array(
            'back_colour' => '#ffffff',
            'stroke_colour' => 'none',
            'back_stroke_width' => 0,
            'back_stroke_colour' => '#eee',
            'axis_colour' => '#ffffff',
            'axis_overlap' => 2,
            'axis_font' => 'Calibri',
            'axis_font_size' => 10,
            'grid_colour_h' => '#ffffff',
            'label_colour' => '#000',
            'pad_right' => 0,
            'pad_left' => 0,
            'link_base' => '/',
            'link_target' => '_top',
            'bar_width' => 30,
            'minimum_grid_spacing' => 20,
            'axis_stroke_width' => 0,
            'axis_space' => 10,
            'percentage' => true,
            'units_y' => ' %',
            'axis_text_colour' => '#333',
            'grid_division_v' => 20,
            'guideline' => 100,
            'guideline_colour' => 'red',
            'axis_max_v' => 120,
            'show_data_labels' => true,
            'data_label_position' => 'outside top',
            'units_label' => ' %'
        );

        $values = array(
            array(
                'MKS' => $grafik[0]['PERBANDINGAN'], 'GJK' => $grafik[1]['PERBANDINGAN'],
                'YGY' => $grafik[2]['PERBANDINGAN'], 'JKT' => $grafik[3]['PERBANDINGAN'], 'TJK' => $grafik[4]['PERBANDINGAN'],
                'MDN' => $grafik[5]['PERBANDINGAN'], 'PLU' => $grafik[6]['PERBANDINGAN'], 'PKU' => $grafik[7]['PERBANDINGAN'],
                'PNK' => $grafik[8]['PERBANDINGAN'], 'BJM' => $grafik[9]['PERBANDINGAN'], 'EKSPOR' => $grafik[10]['PERBANDINGAN']
            )
        );

        $colours = array(
            array('#3C8DBC')
        );

        $graph = new Goat1000\SVGGraph\SVGGraph(600, 280, $settings);

        $graph->colours($colours);
        $graph->values($values);
        echo $graph->fetch('BarGraph', false);

        ?>
    </div>
    <?php echo $graph->fetchJavascript(); ?>
</body>

</html>