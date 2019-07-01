<style>
* {box-sizing: border-box}
/*body {font-family: "Lato", sans-serif;}*/

/* Style the tab */
.tab {
    float: left;
    border: 1px solid #ccc;
    background-color: #f1f1f1;
    width: 15%;
    height: 350px;
}

/* Style the buttons inside the tab */
.tab button {
    display: block;
    background-color: inherit;
    color: black;
    padding: 10px 8px;
    width: 100%;
    border: none;
    outline: none;
    text-align: left;
    cursor: pointer;
    transition: 0.3s;
    font-size: 17px;
}

/* Change background color of buttons on hover */
.tab button:hover {
    background-color: #ddd;
}

/* Create an active/current "tab button" class */
.tab button.active {
    background-color: #ccc;
}

/* Style the tab content */
.tabcontent {
    float: left;
    padding: 0px 12px;
    border: 1px solid #ccc;
    width: 85%;
    border-left: none;
    height: 350px;
}
</style>
<?php
  $arrayMount = array(
              '01' => 'Januari',
              '02' => 'Februari',
              '03' => 'Maret',
              '04' => 'April',
              '05' => 'Mei',
              '06' => 'Juni',
              '07' => 'Juli',
              '08' => 'Agustus',
              '09' => 'September',
              '10' => 'Oktober',
              '11' => 'November',
              '12' => 'Desember',
          );
?>

<section class="content">
  <div class="box box-primary color-palette-box">
    <div class="box-header with-border">
      <h3 class="box-title"><i class="fa fa-bar-chart"></i> Grafik Kaizen</h3>
    </div>
    <div class="box-body">
      <h3>Grafik Kaizen Seksi : <b><?= $seksi ?></b> </h3>
      <h4>Bulan : <b><?= $arrayMount[date('m')]; ?></b> </h4>
      <?php
        $data_seksi_final = array();
        for($i = 0; $i < count($data_seksi); $i++) {
          $data_seksi_final[$i] = array($data_seksi[$i]['kelompok'], (int) $data_seksi[$i]['target'], (int) $data_seksi[$i]['done']);
        }
      ?>
      <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">
          google.charts.load('current', {'packages':['corechart']});
          google.charts.setOnLoadCallback(drawVisualization);
          function drawVisualization() {
            var data = google.visualization.arrayToDataTable([
              ['TIM', 'Target', 'Done'],
              <?php foreach($data_seksi_final as $item) { echo json_encode($item).','; } ?>
            ]);
            var options = {
              animationEnabled: true,
              vAxis: {title: 'Jumlah Kaizen'},
              hAxis: {title: 'TIM'},
              seriesType: 'bars',
              series: {
                0: {color: '#006bb3'},
                1: {color: '#2d2d2d'},
              },
            };
            var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
                chart.draw(data, options);
            }
        </script>
        </head>
        <body>
          <div id="chart_div" style="width: 100%; height: 300px;"></div>
        </body>

      <div id="seksi" style="display: block; padding: 5px"><!-- 
        <div style="overflow: auto; height: 100%">
        <?php $widthuwu = 0; foreach ($data_seksi as $key => $value) {
            $widthuwu += 160;
          } ?>
          <div id="chartContainer" style="height: 300px; width: <?= $widthuwu ?>px"></div> -->
           <table class="datatable table table-striped table-bordered table-hover text-left" style="font-size:12px; width: 100%">
          <thead class="bg-primary">
                <tr>
                    <th class="text-center"> No.</th>
                    <th class="text-center"> Tim</th>
                    <th class="text-center"> Target</th>
                    <th class="text-center"> Jumlah Ide</th>
                    <th class="text-center"> Inproses</th>
                    <th class="text-center"> Done</th>
                </tr>
                <tbody>
          <?php $no=1; ?>
         <?php foreach ($data_seksi as $keyup): ?>
             <tr>
              <td align="center"><?php echo $no;?></td>
              <td><?php echo $keyup['kelompok'];?></td>
              <td align="center"><?php echo $keyup['target'];?></td>
              <td align="center"><?php echo $keyup['jml_ide'];?></td>
              <td align="center"><?php echo $keyup['inproses'];?></td>
              <td align="center"><?php echo $keyup['done'];?></td>
          </tr>
           <?php 
              $no++;?>
          <?php endforeach ?>
          </tbody>
            </thead>
          </table>
        </div>
      </div>
      <div id="pekerja" style="display:block; padding: 15px">
      <h3>Data Jumlah Kaizen Per Pekerja </h3>
           <table class="datatable table dataTable-pekerja table-striped table-bordered table-hover text-center" style="font-size:12px; width: 100%">
          <thead class="bg-primary">
              <tr>
                  <th> No.</th>
                  <th> No Induk</th>
                  <th> Nama</th>
                  <th> Tim</th>
                  <th> Jumlah Ide</th>
                  <th> Inproses</th>
                  <th> Done</th>
              </tr>
          </thead>
          <tbody>
          <?php $no=1; ?>
          <?php foreach ($data_pekerja as $key):  ?>
             <tr>
              <td><?php echo $no;?></td>
              <td><?php echo $key['employee_code'];?></td>
              <td style="text-align: left;"><?php echo $key['employee_name'];?></td>
              <td><?php echo $key['kelompok'];?></td>
              <td><?php echo $key['jml_ide'];?></td>
              <td><?php echo $key['inproses'];?></td>
              <td><?php echo $key['done'];?></td>
          </tr>
           <?php 
              $no++;?>
          <?php endforeach ?>
          </tbody>
        </table> 
      </div>
    </div>
  </div>

</section>