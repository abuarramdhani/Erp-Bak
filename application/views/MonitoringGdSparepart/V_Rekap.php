<input type="hidden" value="ok" id="rekapmpg">
<script src="<?php echo base_url('assets/plugins/dataTables/jquery.dataTables.js');?>"></script>
	<script src="<?php echo base_url('assets/plugins/dataTables/dataTables.bootstrap.js');?>"></script>
     <script>
            $(document).ready(function () {            
            $('.datepicktgl').datepicker({
                format: 'yyyy-mm-dd',
                todayHighlight: true,
                autoClose: true
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
                                    href="<?php echo site_url('MonitoringGdSparepart/Monitoring/');?>">
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
                            <div class="box-header with-border"><b>Rekap</b></div>

                            <div class="box-body">
                                <div class="panel-body">
                                    <div class="col-md-12 text-right">
                                      <label class="control-label"><?php echo date("l, d F Y") ?></label>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-3">
                                            <label class="control-label">Subinventory</label>
                                            <input id="subinventory" name="subinventory" class="form-control pull-right" placeholder="Subinventory" readonly>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="text-right">Tanggal Awal</label>
                                            <input id="tglAwal" name="tglAwal" class="form-control pull-right datepicktgl" placeholder="yyyy-mm-dd" autocomplete="off">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="text-right">Tanggal Akhir</label>
                                            <div class="input-group">
                                            <input id="tglAkhir" name="tglAkhir" class="form-control pull-right datepicktgl" placeholder="yyyy-mm-dd" autocomplete="off">
                                            <span class="input-group-btn">
                                                <button type="button" onclick="schRekapMGS(this)" class="btn btn-flat" style="background:inherit; text-align:left;padding:0px;padding-left:10px;"><i class="fa fa-2x fa-arrow-circle-right" ></i></button>    
                                            </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <form method="post" action="<?= base_url('MonitoringGdSparepart/Rekap/exportRekap'); ?>">
                                <div class="panel-body" id="tb_RkpMGS">
                                    <!-- <div class="col-md-12">
                                        <table class="datatable table table-bordered table-hover table-striped text-center" id="myTable" style="width: 100%; table-layout:fixed">
                                            <thead class="bg-info">
                                                <tr>
                                                    <th rowspan="2" style="width5%;">Tanggal</th>
                                                    <th rowspan="2">Jumlah Lembar</th>
                                                    <th rowspan="2">Jumlah Pcs</th>
                                                    <th colspan="2">Status / lembar</th>
                                                    <th rowspan="2">Asal</th>
                                                </tr>
                                                <tr>
                                                    <th>Sudah Terlayani</th>
                                                    <th>Belum Terlayani</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><?php echo date("d-M-Y") ?></td>
                                                    <td><?= $masuk?></td>
                                                    <td><?= $pcs?></td>
                                                    <td><?= $sudah?></td>
                                                    <td><?= $belum?></td>
                                                    <td><button type="button" class="btn btn-success" onclick="adddrekap(this)"> Detail</button></td>
                                                </tr>
                                                    <td colspan="6">
                                                        <div id="drekapmgs" style="display:none">
                                                            <table class="datatable table table-bordered table-hover table-striped text-center" style="width: 100%;table-layout:fixed">
                                                                <thead class="bg-success">
                                                                    <tr>
                                                                        <th rowspan="2">Asal Gudang</th>
                                                                        <th colspan="2">Sudah Terlayani</th>
                                                                        <th colspan="2">Belum Terlayani</th>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Item</th>
                                                                        <th>Pcs</th>
                                                                        <th>Item</th>
                                                                        <th>Pcs</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php foreach ($asal as $key => $val) { ?>
                                                                    <tr>
                                                                        <td><?= $key?></td>
                                                                        <td><?= $val['sudah']?></td>
                                                                        <td><?= $val['pcs_sudah']?></td>
                                                                        <td><?= $val['belum'] ?></td>
                                                                        <td><?= $val['pcs_belum']?></td>
                                                                    </tr>
                                                                    <?php }?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div> -->
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
