<style>
    th {
        text-align: center;
        vertical-align: middle;
    }
</style>
<input type="hidden" id="mfoTipe" value="tagExt">
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
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('MonitoringFlowOut/TagihanExternal'); ?>">
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
                <div class="col-lg-12">
                    <div class="box box-primary box-solid">
                        <div class="box-header with-border">
                            <b>Search</b>
                        </div>
                        <div class="box-body">
                            <form action="<?= base_url("MonitoringFlowOut/TagihanExternal/ExportExt")?>" method="post" autocomplete="off">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <select id="slcSeksiFAjx" name="seksi2" class="form-control">
                                            <option value=""></option>
                                            <?php foreach ($seksi2 as $s){ ?>
                                                <option name="seksi2" value="<?= $s ?>"><?= $s ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-3" style="text-align:center;vertical-align:middle;">
                                        <button type="button" id="subMfo" class="btn btn-success btn-sm"> <i
                                                class="fa fa-search"></i> Search</button>
                                        <a href="<?= base_url('MonitoringFlowOut/TagihanExternal')?>"
                                            class="btn btn-warning btn-sm"><i class="fa fa-refresh"></i> Refresh</a>
                                        <button type="submit" class="btn btn-info btn-sm" id=""> <i class="fa fa-file-excel-o"></i>
                                            Export</button>
                                    </div>
                                </div> <br />
                                <div class="row">
                                    <div class="col-lg-4">
                                        <input type="text" name="txtTglMFO1" id="txtTglMFO1" placeholder="Tanggal Awal"
                                            class="form-control selectTgl"
                                            oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');">
                                    </div>
                                    <div class="col-lg-4">
                                        <input type="text" name="txtTglMFO2" id="txtTglMFO2" placeholder="Tanggal Akhir"
                                            class="form-control selectTgl"
                                            oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');">
                                    </div>
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>
                    <!-- Datatable -->
                    <div class="box box-primary box-solid" id="ajaxTblTagExt">
                        <div class="box-header with-border">
                            <b>Tagihan External</b>
                        </div>
                        <div class="box-body">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="table-responsive">
                                        <table class="datatable table table-striped table-bordered table-hover"
                                            id="tCar">
                                            <thead class="bg-primary">
                                                <tr>
                                                    <th style="width:3%;">No</th>
                                                    <th style="width:9%">Tgl</th>
                                                    <th style="width:20%">Kode Komp</th>
                                                    <th style="width:20%">Nama Komp</th>
                                                    <th style="width:">Tipe</th>
                                                    <th style="width:">Possible Failure</th>
                                                    <th style="width:">Kronologi Masalah</th>
                                                    <th style="width:">Seksi PJ</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i=1; foreach ($allTagihan as $key => $tagihanAll) { $tanggalnew = date('d-m-Y', strtotime($tagihanAll['tanggal'])) ?>
                                                <tr>
                                                    <td style="text-align:center;"><?= $i++; ?></td>
                                                    <td><?= $tanggalnew ?></td>
                                                    <td><?= $tagihanAll['component_code_ext'] ?></td>
                                                    <td><?= $tagihanAll['component_name'] ?></td>
                                                    <td><?= $tagihanAll['type'] ?></td>
                                                    <td><?= $tagihanAll['possible_fail'] ?></td>
                                                    <td><?= $tagihanAll['kronologi_p'] ?></td>
                                                    <td><?= $tagihanAll['seksi_penanggungjawab'] ?></td>
                                                </tr>
                                                <?php
                                                }
                                                ?>
                                            </tbody>
                                        </table>
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