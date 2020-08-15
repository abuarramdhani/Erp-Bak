<script src="<?php echo base_url('assets/plugins/dataTables/jquery.dataTables.js');?>"></script>
	<script src="<?php echo base_url('assets/plugins/dataTables/dataTables.bootstrap.js');?>"></script>
    <script>
         $(document).ready(function () {
            $('.myTable').dataTable({
                "scrollX": true,
            });
         });
    </script>
<style>
.blink {
    -webkit-animation: blink 1s steps(5, start) infinite;
    -moz-animation: blink 1s steps(5, start) infinite;
    -ms-animation : blink 1s steps(5, start) infinite;
    -o-animation : blink 1s steps(5, start) infinite;
     animation: blink 1s steps(5, start) infinite;
}

@-webkit-keyframes blink {
  0% { opacity : 1;}
  50% { opacity: 0.25;}
  100% { opacity : 1;}
}
@-moz-keyframes blink {
  0% { opacity : 1;}
  50% { opacity: 0.25;}
  100% { opacity : 1;}
}
@-ms-keyframes blink {
  0% { opacity : 1;}
  50% { opacity: 0.25;}
  100% { opacity : 1;}
}
@-o-keyframes blink {
  0% { opacity : 1;}
  50% { opacity: 0.25;}
  100% { opacity : 1;}
}
@keyframes blink {
  0% { opacity : 1;}
  50% { opacity: 0.25;}
  100% { opacity : 1;}
}
</style>
<section class="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-solid">
                            <div class="box-body">
                                <div class="col-md-12">
                                    <h2><i class="fa fa-clipboard" style="font-size:25px"></i> Detail Rak <?= $lokasi?></h2>
                                </div>
                                <br><br><br>
                                <form method="post" target="_blank" action="<?php echo base_url("StockGdSparepart/MonitoringRak/Cetak") ?>">
                                <div class="panel-body box box-warning">
                                <br>
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table class="datatable table table-bordered table-hover table-striped myTable text-center" id="myTable" style="width: 100%;">
                                                <thead class="bg-navy text-nowrap">
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Kode Barang</th>
                                                        <th>Nama Barang</th>
                                                        <th>Alamat</th>
                                                        <th>Min</th>
                                                        <th>Max</th>
                                                        <th>Onhand</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="text-nowrap">
                                                <?php $i = 1; foreach ($data as $val) { 
                                                    if ($val['ONHAND'] > $val['MAX'] && $val['MAX'] != '') {
                                                        $blink1 = 'blink';
                                                    }else {
                                                        $blink1 = '';
                                                    }
                                                    if($val['ONHAND'] < $val['MIN']){
                                                        $blink2 = 'blink';
                                                    }else {
                                                        $blink2 = '';
                                                    }
                                                ?>
                                                    <tr>
                                                        <td><input type="hidden" name="lokasi" id="lokasi<?= $i?>" value="<?= $lokasi?>"><?= $i?></td>
                                                        <td><?= $val['ITEM']?></td>
                                                        <td style="text-align:left"><?= $val['DESCRIPTION']?></td>
                                                        <td><?= $val['LOKASI']?></td>
                                                        <td class="bg-danger <?= $blink2?>"><?= $val['MIN']?></td>
                                                        <td class="bg-success <?= $blink1?>"><?= $val['MAX']?></td>
                                                        <td><?= $val['ONHAND']?></td>
                                                    </tr>
                                                <?php $i++; } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                <div class="panel-body text-right">
                                    <button class="btn btn-lg bg-orange"><i class="fa fa-print"></i> Cetak</button>
                                </div>
                                </div>
                                </form>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


