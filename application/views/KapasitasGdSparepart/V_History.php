<style>
.chartWrapper {
 position: relative;
}

.chartWrapper > canvas {
  position: absolute;
  left: 0;
  top: 0;
  pointer-events: none;
}

.chartAreaWrapper {
  width: 1100px;
  overflow-x: scroll;
}
</style>
<script src="<?php echo base_url('assets/plugins/dataTables/jquery.dataTables.js');?>"></script>
<script src="<?php echo base_url('assets/plugins/dataTables/dataTables.bootstrap.js');?>"></script>
<script>
$(document).ready(function () {
    $('.tblhiskgs').dataTable({
        "scrollX": true,
    });

var wkt = [];
var plyn = [];
var pglr = [];
var pck = [];
var coly = [];
var pcs = [];

<?php 
$jml = count($data);
for ($i=0; $i < 7; $i++) { ?>
    wkt.push("<?= $data[$i]['TGL_INPUT']; ?>")
    plyn.push(<?= $data[$i]['PELAYANAN'];?>)
    pglr.push(<?= $data[$i]['PENGELUARAN'];?>)
    pck.push(<?= $data[$i]['PACKING'];?>)
    coly.push(<?= $data[$i]['COLY'];?>)
    pcs.push(<?= $data[$i]['JML_PACK'];?>)
<?php }?>


var ctx = document.getElementById("myChart");
var myChart = new Chart(ctx, {
  type: 'line',
  data: {
        labels: wkt,
        datasets: [ {
            data: plyn,
            label: "Pelayanan",
            borderColor: "#FF3E45",
            backgroundColor: "#FF3E45",
            pointBackgroundColor: "black",
            fill: false
        }, { 
            data: pglr,
            label: "Pengeluaran",
            borderColor: "#EB794B",
            backgroundColor: "#EB794B",
            fill: false
        },{ 
            data: pck,
            label: "Packing",
            borderColor: "#00CE9B",
            backgroundColor: "#00CE9B",
            fill: false
        }
        ]
    },
  options: {
    "hover": {
      "animationDuration": 0
    },
    "animation": {
        "duration": 1,
                    "onComplete": function () {
                        var chartInstance = this.chart,
                        ctx = chartInstance.ctx;

                        ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
                        ctx.textAlign = 'center';
                        ctx.textBaseline = 'bottom';

                        this.data.datasets.forEach(function (dataset, i) {
                        var meta = chartInstance.controller.getDatasetMeta(i);
                        meta.data.forEach(function (line, index) {
                        var data = dataset.data[index];                            
                        ctx.fillText(data, line._model.x, line._model.y - 5);
                    });
                });
            }
    },
    scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        },
        title: {
            display: true,
            text: 'RATA-RATA WAKTU PELAYANAN SPB'
        },
        responsive: true,
        
       tooltips: {
            callbacks: {
                labelColor: function(tooltipItem, chart) {
                    return {
                        borderColor: '#7C7B78',
                        backgroundColor: '#FFFDF7'
                    }
                }
            }
        },
        legend: {
            labels: {
                fontColor: 'black',
               
            }
        }
  }
});

var ctx = document.getElementById("myChart2");
var myChart2 = new Chart(ctx, {
  type: 'line',
  data: {
    labels: wkt,
    datasets: [{
            data: coly,
            label: "Coly",
            borderColor: "#3e95cd",
            backgroundColor: "#3e95cd",
            pointBackgroundColor: "black",
            fill: false
        }, { 
            data: pcs,
            label: "Pcs / 50",
            borderColor: "#8e5ea2",
            backgroundColor: "#8e5ea2",
            fill: false,
        }
    ]
},
  options: {
    "hover": {
      "animationDuration": 0
    },
    "animation": {
        "duration": 1,
            "onComplete": function () {
                var chartInstance = this.chart,
                ctx = chartInstance.ctx;

                ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
                ctx.textAlign = 'center';
                ctx.textBaseline = 'bottom';

                this.data.datasets.forEach(function (dataset, i) {
                var meta = chartInstance.controller.getDatasetMeta(i);
                meta.data.forEach(function (line, index) {
                var data = dataset.data[index];                            
                ctx.fillText(data, line._model.x, line._model.y - 5);
                    });
                });
        }
    },
    scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        },
        title: {
            display: true,
            text: 'COLY DAN PCS PACKING'
        },
        responsive: true,
        
       tooltips: {
            callbacks: {
                labelColor: function(tooltipItem, chart) {
                    return {
                        borderColor: '#7C7B78',
                        backgroundColor: '#FFFDF7'
                    }
                }
            }
        },
        legend: {
            labels: {
                fontColor: 'black',
               
            }
        }
  }
});
});
    </script>
<section class="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-11">
                            <div class="text-right">
                                <h1>
                                    <b>
                                        <?= $Title ?> 
                                    </b>
                                </h1>
                            </div>
                        </div>
                        <div class="col-lg-1 ">
                            <div class="text-right hidden-md hidden-sm hidden-xs">
                                <a class="btn btn-default btn-lg"
                                    href="<?php echo site_url('MonitoringPelayananSPB/History/');?>">
                                    <i class="icon-wrench icon-2x">
                                    </i>
                                    <span>
                                        <br />
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <br />
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border"><b>History</b></div>
                            <div class="box-body">
                                <div class="col-md-12 text-right">
                                    <label class="control-label"><?php echo gmdate("l, d F Y, H:i:s", time()+60*60*7) ?></label>
                                </div>
                                <div class="col-md-12">
                                <div class="panel-body">
                                    <div class="table-responsive" >
                                        <table class="datatable table table-bordered table-hover table-striped text-center tblhiskgs" style="width: 100%;">
                                            <thead class="bg-primary">
                                                <tr>
                                                    <th style="width:5%">No</th>
                                                    <th>Tanggal Input</th>
                                                    <th>Lembar Masuk</th>
                                                    <th>Pcs Masuk</th>
                                                    <th>Pelayanan</th>
                                                    <th>Pengeluaran</th>
                                                    <th>Packing</th>
                                                    <th>Coly</th>
                                                    <th>Lembar Packing</th>
                                                    <th>Pcs Packing</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i=0; $no=1; foreach($data as $val){ ?>
                                                    <tr id="baris<?= $no?>">
                                                        <td ><?= $no; ?></td>
                                                        <td><input type="hidden" id="pglr<?= $no?>" value="<?= $val['TGL_INPUT']?>"><?= $val['TGL_INPUT']?></td>
                                                        <td><input type="hidden" id="lembar_msk<?= $no?>" value="<?= $val['LEMBAR_MASUK']?>"><?= $val['LEMBAR_MASUK']?></td>
                                                        <td><input type="hidden" id="pcs_msk<?= $no?>" value="<?= $val['PCS_MASUK']?>"><?= $val['PCS_MASUK']?></td>
                                                        <td><input type="hidden" id="plyn<?= $no?>" value="<?= $val['PELAYANAN']?>"><?= $val['PELAYANAN']?> detik</td>
                                                        <td><input type="hidden" id="pglr<?= $no?>" value="<?= $val['PENGELUARAN']?>"><?= $val['PENGELUARAN']?> detik</td>
                                                        <td><input type="hidden" id="pck<?= $no?>" value="<?= $val['PACKING']?>"><?= $val['PACKING']?> detik</td>
                                                        <td><input type="hidden" id="coly<?= $no?>" value="<?= $val['COLY']?>"><?= $val['COLY']?></td>
                                                        <td><input type="hidden" id="lembar_pack<?= $no?>" value="<?= $val['LEMBAR_PACK']?>"><?= $val['LEMBAR_PACK']?></td>
                                                        <td><input type="hidden" id="pcs_pack<?= $no?>" value="<?= $val['PCS_PACK']?>"><?= $val['PCS_PACK']?></td>
                                                    </tr>
                                                <?php $no++; $i++;  }?>
                                            </tbody>
                                        </table>
                                    </div>
                                    </div>

                                <div class="panel-body">
                                    <div class="chartWrapper">
                                        <div class="chartAreaWrapper">
                                            <div class="chartAreaWrapper2">
                                            <canvas id="myChart" width="2400px" height="800px" style="width:2400px;height:800px"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="panel-body">
                                    <div class="chartWrapper">
                                        <div class="chartAreaWrapper">
                                            <div class="chartAreaWrapper2">
                                            <canvas id="myChart2" width="2400px" height="800px" style="width:2400px;height:800px"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

