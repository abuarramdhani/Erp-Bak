<script type="text/javascript">
	            window.onload = function () {

              var chart = new CanvasJS.Chart("chartFPDKomp", {

                animationEnabled: true,
                theme: "light2",
                title:{
                  text: "Grafik Komponen"
                },
                axisY:{
                  includeZero: false
                },


                data : [{
                    type: "area",
                    cursor: "pointer",
                    click : getFamilykuis,
                    dataPoints:[
                    <?php foreach ($recap as $key => $value) { ?>
                      { key: '<?= ($key+1) ?>',label: '<?= "Minggu - ".($key+1) ?>',y : <?= $value['su'] ?>, range: '<?= $value['range'] ?>', markerSize: 10, markerColor: '#dc5753' },
                    <?php } ?>
                    ]
                }]
              });
              chart.render();

            var chart2 = new CanvasJS.Chart("chartFPDKomp2", {

                animationEnabled: true,
                theme: "light2",
                title:{
                  text: "Detail Minggu 1"
                },
                axisY:{
                  includeZero: false
                },


                data : [{
                    type: "area",
                    dataPoints:[
                    <?php foreach ($recapDay as $key => $value) {
                      ?>
                      { x:new Date(<?= $value['tgl'] ?>),y : <?= $value['su'] ?> },
                    <?php } ?>
                    ]
                }]
              });
              chart2.render();
            }
</script>