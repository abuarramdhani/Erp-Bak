<script type="text/javascript">
	            window.onload = function () {

                CanvasJS.addColorSet("warnanikuy",
                [ 
                  "#DDDDDD",
                  "#A2D1CF",
                  "#86B402",
                  "#369EAD",
                  "#C24642"                
                ]);
              var chart = new CanvasJS.Chart("chartContainer", {
                 colorSet: "warnanikuy",

                animationEnabled: true,
                title:{
                  text: "Grafik Kaizen"
                },  
                axisY: {
                  title: "Jumlah Kaizen",
                  titleFontColor: "#4F81BC",
                  lineColor: "#4F81BC",
                  labelFontColor: "#4F81BC",
                  tickColor: "#4F81BC"
                },
                axisX: {
                  title: "Pekerja",
                  titleFontColor: "#C0504E",
                  lineColor: "#C0504E",
                  labelFontColor: "#C0504E",
                  tickColor: "#C0504E"
                },  
                toolTip: {
                  shared: true
                },
                legend: {
                  cursor:"pointer",
                  // itemclick: toggleDataSeries
                },
                data: [
                <?php 
                	$arrName = array('Kaizen Created & Edited','Kaizen Unchecked','Kaizen Approve Ide', 'Kaizen Reported', 'Kaizen Reject & Revisi', );
                	$arrData = array('kaizen_created', 'kaizen_unchecked','kaizen_approve_ide', 'kaizen_reported', 'kaizen_reject_revisi');
                for ($i=0; $i <= 4; $i++) { ?>
                	{
                  type: "column",
                  name: "<?= $arrName[$i] ?>",
                  legendText: "<?= $arrName[$i] ?>",
                  showInLegend: true, 
                  dataPoints:[
                  	<?php 
                  		foreach ($data_seksi as $key => $value) { 

                  			?>
                  			 { label: "<?= $value['employee_name'] ?>", y: <?= $value[$arrData[$i]] ?> },
                  	<?php }
                  	?>
                   
                  ]
                },
                <?php } ?>]
              });
              chart.render();
            }
</script>