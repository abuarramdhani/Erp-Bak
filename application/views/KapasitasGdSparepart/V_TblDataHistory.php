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
  width: 1000px;
  height: 350px;
  /* overflow-x: scroll; */
}
</style>
<script src="<?php echo base_url('assets/plugins/dataTables/jquery.dataTables.js');?>"></script>
<script src="<?php echo base_url('assets/plugins/dataTables/dataTables.bootstrap.js');?>"></script>
<script>
$(document).ready(function () {
    $('.tblhiskgs').dataTable({
        "scrollX": true,
    });
    $('.datepicktgl').datepicker({
        format: 'dd/mm/yyyy',
        todayHighlight: true,
        autoClose: true
    }).on('change', function(){
        $('.datepicker').hide();
    });
    
var wkt = [];
var plyn = [];
var pglr = [];
var pck = [];
var coly = [];
var pcs = [];
var item_in = [];
var out = [];
var plynout = [];
var pglrout = [];

<?php 
$jml = count($data);
for ($i=6; $i > -1; $i--) { ?>
    wkt.push("<?= $data[$i]['TGL_INPUT']; ?>")
    plyn.push(<?= $data[$i]['PELAYANAN'];?>)
    pck.push(<?= $data[$i]['PACKING'];?>)
    coly.push(<?= $data[$i]['COLY'];?>)
    pcs.push(<?= $data[$i]['JML_PACK'];?>)
    item_in.push(<?= $data[$i]['ITEM_MASUK'];?>)
    out.push(<?= $data[$i]['ITEM_KELUAR'];?>)
    plynout.push(<?= $data[$i]['ITEM_PLYN'];?>)
<?php }?>


var ctx = document.getElementById("myChart");
var myChart = new Chart(ctx, {
  type: 'line',
  data: {
        labels: wkt,
        datasets: [ {
            data: plyn,
            label: "Pelayanan",
            borderColor: "#E86761",
            backgroundColor: "#E86761",
            pointBackgroundColor: "black",
            fill: false
        }, 
        { 
            data: pck,
            label: "Packing",
            borderColor: "#3ED6A6",
            backgroundColor: "#3ED6A6",
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

var ctx = document.getElementById("myChart3");
var myChart3 = new Chart(ctx, {
  type: 'line',
  data: {
        labels: wkt,
        datasets: [ {
            data: [210, 210, 210, 210, 210, 210,210],
            label: "Standar",
            borderColor: "black",
            backgroundColor: "black",
            pointBackgroundColor: "black",
            fill: false
        }, { 
            data: item_in,
            label: "In",
            borderColor: "#47A861",
            backgroundColor: "#47A861",
            pointBackgroundColor: "#005C28",
            fill: false
        },{ 
            data: out,
            label: "Out",
            borderColor: "#00A5F5",
            backgroundColor: "#00A5F5",
            pointBackgroundColor: "#003D5C",
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
            text: 'ITEM IN OUT'
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

var ctx = document.getElementById("myChart4");
var myChart3 = new Chart(ctx, {
  type: 'bar',
  data: {
        labels: wkt,
        datasets: [ {
            data: plynout,
            label: "Pelayanan",
            borderColor: "#E86761",
            backgroundColor: "#E86761",
            fill: true
        }, 
        { 
            data: out,
            label: "Packing",
            borderColor: "#3ED6A6",
            backgroundColor: "#3ED6A6",
            fill: true
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
            text: 'ITEM PELAYANAN SPB/DO'
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

var vbelt = [];
var diesel = [];
var sap = [];
<?php for ($j=0; $j < 3; $j++) { ?>
    vbelt.push(<?= $jml_vbelt[$j];?>)
    diesel.push(<?= $jml_diesel[$j];?>)
    sap.push(<?= $jml_sap[$j];?>)
<?php }?>

var ctx = document.getElementById("myChart5");
var myChart5 = new Chart(ctx, {
  type: 'bar',
  data: {
        labels: ["LEMBAR", "ITEM / 10", "PCS / 100"],
        datasets: [ {
            data: vbelt,
            label: "VBELT",
            borderColor: "#55D3F2",
            backgroundColor: "#55D3F2",
            fill: true
        }, { 
            data: diesel,
            label: "DIESEL",
            borderColor: "#57DBD3",
            backgroundColor: "#57DBD3",
            fill: true
        },{ 
            data: sap,
            label: "SAP",
            borderColor: "#55F2BB",
            backgroundColor: "#55F2BB",
            fill: true
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
            text: 'PERBANDINGAN JENIS ITEM'
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

<div class="panel-body tab-pane fade in active" id="data_dospb">
    <div class="table-responsive" >
        <table class="datatable table table-bordered table-hover table-striped text-center tblhiskgs" style="width: 100%;">
            <thead class="bg-primary">
                <tr>
                    <th style="width:5%">No</th>
                    <th>Tanggal Input</th>
                    <th>Lembar Masuk</th>
                    <th>Item Masuk</th>
                    <th>Pcs Masuk</th>
                    <th>Pelayanan</th>
                    <th>Packing</th>
                    <th>Coly</th>
                    <th>Lembar Pelayanan</th>
                    <th>Lembar Packing</th>
                    <th>Item Pelayanan</th>
                    <th>Item Packing</th>
                    <th>Pcs Packing</th>
                    <th>Jenis Item</th>
                </tr>
            </thead>
            <tbody>
                <?php $i=0; $no=1; foreach($data as $val){ ?>
                    <tr id="baris<?= $no?>">
                        <td ><?= $no; ?></td>
                        <td><input type="hidden" id="tgl_input<?= $no?>" value="<?= $val['TGL_INPUT']?>"><?= $val['TGL_INPUT']?></td>
                        <td><input type="hidden" id="lembar_msk<?= $no?>" value="<?= $val['LEMBAR_MASUK']?>"><?= $val['LEMBAR_MASUK']?></td>
                        <td><input type="hidden" id="item_in<?= $no?>" value="<?= $val['ITEM_MASUK']?>"><?= $val['ITEM_MASUK']?></td>
                        <td><input type="hidden" id="pcs_msk<?= $no?>" value="<?= $val['PCS_MASUK']?>"><?= $val['PCS_MASUK']?></td>
                        <td><input type="hidden" id="plyn<?= $no?>" value="<?= $val['PELAYANAN']?>"><?= $val['PELAYANAN']?> detik</td>
                        <td><input type="hidden" id="pck<?= $no?>" value="<?= $val['PACKING']?>"><?= $val['PACKING']?> detik</td>
                        <td><input type="hidden" id="coly<?= $no?>" value="<?= $val['COLY']?>"><?= $val['COLY']?></td>
                        <td><input type="hidden" id="lembar_plyn<?= $no?>" value="<?= $val['LEMBAR_PLYN']?>"><?= $val['LEMBAR_PLYN']?></td>
                        <td><input type="hidden" id="lembar_pack<?= $no?>" value="<?= $val['LEMBAR_PACK']?>"><?= $val['LEMBAR_PACK']?></td>
                        <td><input type="hidden" id="item_plyn<?= $no?>" value="<?= $val['ITEM_PLYN']?>"><?= $val['ITEM_PLYN']?></td>
                        <td><input type="hidden" id="item_out<?= $no?>" value="<?= $val['ITEM_KELUAR']?>"><?= $val['ITEM_KELUAR']?></td>
                        <td><input type="hidden" id="pcs_pack<?= $no?>" value="<?= $val['PCS_PACK']?>"><?= $val['PCS_PACK']?></td>
                        <td><button class="btn btn-info" onclick="detailJenisItem(<?= $no?>)">Detail</button></td>
                    </tr>
                <?php $no++; $i++;  }?>
            </tbody>
        </table>
    </div>
    <br><br>
    <div>
        <div class="chartWrapper">
            <div class="chartAreaWrapper">
                <div class="chartAreaWrapper2">
                <canvas id="myChart" width="2400px" height="800px" style="width:2400px;height:800px"></canvas>
                </div>
            </div>
        </div>
    </div>
    <br><br>

    <div>
        <div class="chartWrapper">
            <div class="chartAreaWrapper">
                <div class="chartAreaWrapper2">
                <canvas id="myChart2" width="2400px" height="800px" style="width:2400px;height:800px"></canvas>
                </div>
            </div>
        </div>
    </div>
    <br><br>

    <div>
        <div class="chartWrapper">
            <div class="chartAreaWrapper">
                <div class="chartAreaWrapper2">
                <canvas id="myChart3" width="2400px" height="800px" style="width:2400px;height:800px"></canvas>
                </div>
            </div>
        </div>
    </div>
    <br><br>
    
    <div>
        <div class="chartWrapper">
            <div class="chartAreaWrapper">
                <div class="chartAreaWrapper2">
                <canvas id="myChart4" width="2400px" height="800px" style="width:2400px;height:800px"></canvas>
                </div>
            </div>
        </div>
    </div>
    <br><br>
    
    <div>
        <div class="chartWrapper">
            <div class="chartAreaWrapper">
                <div class="chartAreaWrapper2">
                <canvas id="myChart5" width="2400px" height="800px" style="width:2400px;height:800px"></canvas>
                </div>
            </div>
        </div>
    </div>
    <br><br>
</div>
