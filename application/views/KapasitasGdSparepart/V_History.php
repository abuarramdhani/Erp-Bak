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
var lpack = [];
var ppack = [];
var lmsk = [];
var pmsk = [];

<?php 
$jml = count($data);
for ($i=0; $i < 7; $i++) { ?>
    wkt.push(<?= $data[$i]['TANGGAL']; ?>)
    plyn.push(<?= $data[$i]['PELAYANAN'];?>)
    pglr.push(<?= $data[$i]['PENGELUARAN'];?>)
    pck.push(<?= $data[$i]['PACKING'];?>)
    coly.push(<?= $data[$i]['COLY'];?>)
    lpack.push(<?= $data[$i]['LEMBAR_PACK'];?>)
    ppack.push(<?= $data[$i]['PCS_PACK'];?>)
    lmsk.push(<?= $data[$i]['LEMBAR_MASUK'];?>)
    pmsk.push(<?= $data[$i]['PCS_MASUK'];?>)
<?php }?>

// console.log(plyn);
var ctx = document.getElementById("myChart");
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: wkt,
        
        datasets: [ {
            label: 'Pelayanan',
            fill:false,
            data: plyn,
            backgroundColor: '#E91E63',
            borderColor: [
                'rgba(255,99,132,1)',
                'rgba(255,99,132,1)',
                'rgba(255,99,132,1)',
                'rgba(255,99,132,1)',
                'rgba(255,99,132,1)',
                'rgba(255,99,132,1)',
            ],
            borderWidth: 1
        },
        
        {
            label: 'Pengeluaran',
            fill:false,
            data: pglr,
            backgroundColor: 
                '#3F51B5'
            ,
            borderColor: [
                'rgba(255,99,132,1)',
                'rgba(255,99,132,1)',
                'rgba(255,99,132,1)',
                'rgba(255,99,132,1)',
                'rgba(255,99,132,1)',
                'rgba(255,99,132,1)',
            ],
            borderWidth: 1
        },
        {
            label: ['Packing'],
            data: pck,
              fill:false,
           backgroundColor:  '#004D40',
            borderColor: [
                'rgba(255,99,132,1)',
                'rgba(255,99,132,1)',
                'rgba(255,99,132,1)',
                'rgba(255,99,132,1)',
                'rgba(255,99,132,1)',
                'rgba(255,99,132,1)',
            ],
            borderWidth: 1
        }
        ]
    },
    options: {
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
                        borderColor: 'rgb(255, 0, 20)',
                        backgroundColor: 'rgb(255,20, 0)'
                    }
                }
            }
        },
        legend: {
            labels: {
                // This more specific font property overrides the global property
                fontColor: 'red',
               
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
                                                    <th>Pelayanan</th>
                                                    <th>Pengeluaran</th>
                                                    <th>Packing</th>
                                                    <th>Coly</th>
                                                    <th>Lembar Packing</th>
                                                    <th>Pcs Packing</th>
                                                    <th>Lembar Masuk</th>
                                                    <th>Pcs Masuk</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i=0; $no=1; foreach($data as $val){ ?>
                                                    <tr id="baris<?= $no?>">
                                                        <td ><?= $no; ?></td>
                                                        <td><input type="hidden" id="pglr<?= $no?>" value="<?= $val['TGL_INPUT']?>"><?= $val['TGL_INPUT']?></td>
                                                        <td><input type="hidden" id="plyn<?= $no?>" value="<?= $val['PELAYANAN']?>"><?= $val['PELAYANAN']?> detik</td>
                                                        <td><input type="hidden" id="pglr<?= $no?>" value="<?= $val['PENGELUARAN']?>"><?= $val['PENGELUARAN']?> detik</td>
                                                        <td><input type="hidden" id="pglr<?= $no?>" value="<?= $val['PACKING']?>"><?= $val['PACKING']?> detik</td>
                                                        <td><input type="hidden" id="pglr<?= $no?>" value="<?= $val['COLY']?>"><?= $val['COLY']?></td>
                                                        <td><input type="hidden" id="pglr<?= $no?>" value="<?= $val['LEMBAR_PACK']?>"><?= $val['LEMBAR_PACK']?></td>
                                                        <td><input type="hidden" id="pglr<?= $no?>" value="<?= $val['PCS_PACK']?>"><?= $val['PCS_PACK']?></td>
                                                        <td><input type="hidden" id="pglr<?= $no?>" value="<?= $val['LEMBAR_MASUK']?>"><?= $val['LEMBAR_MASUK']?></td>
                                                        <td><input type="hidden" id="pglr<?= $no?>" value="<?= $val['PCS_MASUK']?>"><?= $val['PCS_MASUK']?></td>
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
                                        <canvas id="axis-Test" height="800" width="0"></canvas>
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

