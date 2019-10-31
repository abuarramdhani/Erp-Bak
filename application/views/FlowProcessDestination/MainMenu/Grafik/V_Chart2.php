<script type="text/javascript">
	            window.onload = function () {


            var chart3 = new CanvasJS.Chart("chartFPDKomp3", {

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
                      $exp = explode('-',$value['tgl']);
                      ?>
                      { x:new Date(<?= $exp[0].','.$exp[1].','.$exp[2] ?>),y : <?= $value['su'] ?> },
                    <?php } ?>
                    ]
                }]
              });
              chart3.render();
            }
</script>

<div id="chartFPDKomp3" style="height: 100%;vertical-align: middle;">
                      
                    </div>
