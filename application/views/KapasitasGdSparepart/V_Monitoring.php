<script src="<?php echo base_url('assets/plugins/dataTables/jquery.dataTables.js');?>"></script>
	<script src="<?php echo base_url('assets/plugins/dataTables/dataTables.bootstrap.js');?>"></script>
     <script>
         $(document).ready(function () {
            $('.datepicktgl').datepicker({
                format: 'yyyy-mm-dd',
                todayHighlight: true,
                autoClose: true
            });
            
            $(".date_report").datetimepicker({
                showSecond: true,
                // format:'Y/m/d H:i:s',
                timeFormat: 'hh:mm:ss',
            }).datetimepicker("setDate", new Date());
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
                                    href="<?php echo site_url('MonitoringPelayananSPB/Monitoring/');?>">
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
                        <div class="box box-primary">
                            <div class="col-md-12 text-right">
                                <label class="control-label"><?php echo gmdate("l, d F Y, H:i:s", time()+60*60*7) ?></label>
                            </div>
                            <nav class="navbar" style="width:30%">
                                <div class="container-fluid">
                                    <ul class="nav nav-pills nav-justified">
                                        <li class="active text-nowrap"><a data-toggle="tab" href="#monitoring1" id="ini_monitoring1">Monitoring</a></li>
                                        <li class="text-nowrap"><a data-toggle="tab"  href="#monitoring2" id="ini_monitoring2">Report Period</a></li>
                                    </ul>
                                </div>
                            </nav>
                            <div class="box-body">
                            <div class="tab-content">
                                <div class="col-md-12 tab-pane fade in active" id="monitoring1">
                                <div class="panel-body">
                                    <div class="col-md-3">
                                        <label class="text-right">Tanggal Awal</label>
                                        <input id="tglAwal" name="tglAwal" class="form-control pull-right datepicktgl" placeholder="yyyy-mm-dd" autocomplete="off">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="text-right">Tanggal Akhir</label>
                                        <div class="input-group">
                                        <input id="tglAkhir" name="tglAkhir" class="form-control pull-right datepicktgl" placeholder="yyyy-mm-dd" autocomplete="off">
                                        <span class="input-group-btn">
                                            <button type="button" onclick="schMonitoringSPB(this)" class="btn btn-flat" style="background:inherit; text-align:left;padding:0px;padding-left:10px;"><i class="fa fa-2x fa-arrow-circle-right" ></i></button>    
                                        </span>
                                        </div>
                                    </div>
                                </div>
                                <form method="post" target="_blank" autocomplete="off" action="<?php echo base_url('KapasitasGdSparepart/Monitoring/Keterangan')?>">
                                <div class="panel-body" id="tb_MonSPB">
                                    <div class="col-md-12">
                                        <div class="col-md-12">
                                            <label class="text-right">Tanggal : <?php echo date("d F Y") ?></label>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="text-right">DOSP / SPB Masuk Sebelum pk 12:00 : <?= $jml_spb ?> lembar (<?= $dopcs?> item)</label>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="text-right">Terselesaikan : <?= $jml_spb_selesai ?> lembar (<?= $dopcs_selesai?> item)</label>
                                        </div>
                                        <div class="col-md-2">
                                            <button type="button" class="btn btn-xs btn-info" onclick="addDoSpb(this)">Rincian</button></td>
                                        </div>
                                        <div class="col-md-12">
                                            <div id="DoSpb" class="table-responsive" style="display:none">
                                            <center><label>DOSP / SPB Masuk Sebelum pk 12:00</label></center>
                                                <table class="datatable table table-bordered table-hover table-striped text-center" id="myTable" style="width: 100%;">
                                                    <thead class="bg-primary">
                                                        <tr>
                                                            <th width="5px">No</th>
                                                            <th>Jam</th>
                                                            <th>Jenis Dokumen</th>
                                                            <th>No Dokumen</th>
                                                            <th>Jumlah Item</th>
                                                            <th>Jumlah Pcs</th>
                                                            <th>Keterangan</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $i= 0; $no=1; foreach($dospb as $val){ ?>
                                                            <tr>
                                                                <td width="5px"><?= $no; ?></td>
                                                                <td><input type="hidden" name="jam[]" value="<?= $val['TGL_DIBUAT']?>"><?= $val['TGL_DIBUAT']?></td>
                                                                <td><input type="hidden" name="jenis_doc[]" value="<?= $val['JENIS_DOKUMEN']?>"><?= $val['JENIS_DOKUMEN']?></td>
                                                                <td><input type="hidden" name="no_doc[]" value="<?= $val['NO_DOKUMEN']?>"><?= $val['NO_DOKUMEN']?></td>
                                                                <td><input type="hidden" name="jml_item[]" value="<?= $val['JUMLAH_ITEM']?>"><?= $val['JUMLAH_ITEM']?></td>
                                                                <td><input type="hidden" name="jml_pcs[]" value="<?= $val['JUMLAH_PCS']?>"><?= $val['JUMLAH_PCS']?></td>
                                                                <td><input type="hidden" name="urgent[]" value="<?= $val['URGENT']?> <?= $val['BON'] ?>"><?= $val['URGENT']?> <?= $val['BON'] ?></td>
                                                            </tr>
                                                        <?php $no++; $i++;}?>
                                                    </tbody>
                                                </table>
                                                <br>
                                                <center><label>Terselesaikan</label></center>
                                                <table class="datatable table table-bordered table-hover table-striped text-center" id="myTable" style="width: 100%;">
                                                    <thead class="bg-primary">
                                                        <tr>
                                                            <th width="5px">No</th>
                                                            <th>Jam</th>
                                                            <th>Jenis Dokumen</th>
                                                            <th>No Dokumen</th>
                                                            <th>Jumlah Item</th>
                                                            <th>Jumlah Pcs</th>
                                                            <th>Keterangan</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $i= 0; $no=1; foreach($dospb_selesai as $val){ ?>
                                                            <tr>
                                                                <td width="5px"><?= $no; ?></td>
                                                                <td><input type="hidden" name="jam[]" value="<?= $val['TGL_DIBUAT']?>"><?= $val['TGL_DIBUAT']?></td>
                                                                <td><input type="hidden" name="jenis_doc[]" value="<?= $val['JENIS_DOKUMEN']?>"><?= $val['JENIS_DOKUMEN']?></td>
                                                                <td><input type="hidden" name="no_doc[]" value="<?= $val['NO_DOKUMEN']?>"><?= $val['NO_DOKUMEN']?></td>
                                                                <td><input type="hidden" name="jml_item[]" value="<?= $val['JUMLAH_ITEM']?>"><?= $val['JUMLAH_ITEM']?></td>
                                                                <td><input type="hidden" name="jml_pcs[]" value="<?= $val['JUMLAH_PCS']?>"><?= $val['JUMLAH_PCS']?></td>
                                                                <td><input type="hidden" name="urgent[]" value="<?= $val['URGENT']?> <?= $val['BON'] ?>"><?= $val['URGENT']?> <?= $val['BON'] ?></td>
                                                            </tr>
                                                        <?php $no++; $i++;}?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="text-right">DOSP / SPB Masuk Setelah pk 12:00 : <?= $jml_spb2 ?> lembar (<?= $dopcs2?> item)</label>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="text-right">Terselesaikan : <?= $jml_spb2_selesai ?> lembar (<?= $dopcs2_selesai?> item)</label>
                                        </div>
                                        <div class="col-md-2">
                                            <button type="button" class="btn btn-xs btn-info" onclick="addDoSpb2(this, 2)">Rincian</button></td>
                                        </div>
                                        <div class="col-md-12">
                                            <div id="DoSpb2" class="table-responsive" style="display:none">
                                            <center><label>DOSP / SPB Masuk Setelah pk 12:00</label></center>
                                                <table class="datatable table table-bordered table-hover table-striped text-center" id="myTable" style="width: 100%;">
                                                    <thead class="bg-primary">
                                                        <tr>
                                                            <th width="5px">No</th>
                                                            <th>Jam</th>
                                                            <th>Jenis Dokumen</th>
                                                            <th>No Dokumen</th>
                                                            <th>Jumlah Item</th>
                                                            <th>Jumlah Pcs</th>
                                                            <th>Keterangan</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $i= 0; $no=1; foreach($dospb2 as $val){ ?>
                                                            <tr>
                                                                <td width="5px"><?= $no; ?></td>
                                                                <td><input type="hidden" name="jam[]" value="<?= $val['TGL_DIBUAT']?>"><?= $val['TGL_DIBUAT']?></td>
                                                                <td><input type="hidden" name="jenis_doc[]" value="<?= $val['JENIS_DOKUMEN']?>"><?= $val['JENIS_DOKUMEN']?></td>
                                                                <td><input type="hidden" name="no_doc[]" value="<?= $val['NO_DOKUMEN']?>"><?= $val['NO_DOKUMEN']?></td>
                                                                <td><input type="hidden" name="jml_item[]" value="<?= $val['JUMLAH_ITEM']?>"><?= $val['JUMLAH_ITEM']?></td>
                                                                <td><input type="hidden" name="jml_pcs[]" value="<?= $val['JUMLAH_PCS']?>"><?= $val['JUMLAH_PCS']?></td>
                                                                <td><input type="hidden" name="urgent[]" value="<?= $val['URGENT']?> <?= $val['BON'] ?>"><?= $val['URGENT']?> <?= $val['BON'] ?></td>
                                                            </tr>
                                                        <?php $no++; $i++;}?>
                                                    </tbody>
                                                </table>
                                                <br>
                                                <center><label>Terselesaikan</label></center>
                                                <table class="datatable table table-bordered table-hover table-striped text-center" id="myTable" style="width: 100%;">
                                                    <thead class="bg-primary">
                                                        <tr>
                                                            <th width="5px">No</th>
                                                            <th>Jam</th>
                                                            <th>Jenis Dokumen</th>
                                                            <th>No Dokumen</th>
                                                            <th>Jumlah Item</th>
                                                            <th>Jumlah Pcs</th>
                                                            <th>Keterangan</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $i= 0; $no=1; foreach($dospb2_selesai as $val){ ?>
                                                            <tr>
                                                                <td width="5px"><?= $no; ?></td>
                                                                <td><input type="hidden" name="jam[]" value="<?= $val['TGL_DIBUAT']?>"><?= $val['TGL_DIBUAT']?></td>
                                                                <td><input type="hidden" name="jenis_doc[]" value="<?= $val['JENIS_DOKUMEN']?>"><?= $val['JENIS_DOKUMEN']?></td>
                                                                <td><input type="hidden" name="no_doc[]" value="<?= $val['NO_DOKUMEN']?>"><?= $val['NO_DOKUMEN']?></td>
                                                                <td><input type="hidden" name="jml_item[]" value="<?= $val['JUMLAH_ITEM']?>"><?= $val['JUMLAH_ITEM']?></td>
                                                                <td><input type="hidden" name="jml_pcs[]" value="<?= $val['JUMLAH_PCS']?>"><?= $val['JUMLAH_PCS']?></td>
                                                                <td><input type="hidden" name="urgent[]" value="<?= $val['URGENT']?> <?= $val['BON'] ?>"><?= $val['URGENT']?> <?= $val['BON'] ?></td>
                                                            </tr>
                                                        <?php $no++; $i++;}?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <label class="text-right">Pelayanan</label>
                                        </div>
                                        <div class="col-md-6">
                                            Terselesaikan : <?= $jml_pelayanan ?> lembar
                                        </div>
                                        <div class="col-md-4">
                                            Tanggungan : <?= $krg_pelayanan ?> lembar
                                        </div>
                                        <div class="col-md-2">
                                            <button type="button" class="btn btn-xs btn-info" onclick="addRinPelayanan1(this)">Rincian</button>
                                        </div>
                                        <div class="col-md-12">
                                            <div id="RinPelayanan1" style="display:none">
                                                <center><label>Terselesaikan</label></center>
                                                <table class="table table-bordered table-hover table-striped text-center" id="myTable" style="width: 100%; table-layout:fixed">
                                                    <thead class="bg-primary">
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Tanggal</th>
                                                            <th>Jenis Dokumen</th>
                                                            <th>No Dokumen</th>
                                                            <th>Jumlah Item</th>
                                                            <th>Jumlah Pcs</th>
                                                            <th>Jam Mulai</th>
                                                            <th>Jam Selesai</th>
                                                            <th>Waktu</th>
                                                            <th>PIC</th>
                                                            <th>Keterangan</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $i= 0 ;$no=1; foreach($pelayanan as $val) {?>
                                                            <tr>
                                                                <td style="width: 5px"><?= $no; ?></td>
                                                                <td><input type="hidden" name="jam[]" value="<?= $val['TGL_DIBUAT']?>"><?= $val['TGL_DIBUAT']?></td>
                                                                <td><input type="hidden" name="jenis_doc[]" value="<?= $val['JENIS_DOKUMEN']?>"><?= $val['JENIS_DOKUMEN']?></td>
                                                                <td><input type="hidden" name="no_doc[]" value="<?= $val['NO_DOKUMEN']?>"><?= $val['NO_DOKUMEN']?></td>
                                                                <td><input type="hidden" name="jml_item[]" value="<?= $val['JUMLAH_ITEM']?>"><?= $val['JUMLAH_ITEM']?></td>
                                                                <td><input type="hidden" name="jml_pcs[]" value="<?= $val['JUMLAH_PCS']?>"><?= $val['JUMLAH_PCS']?></td>
                                                                <td><input type="hidden" name="mulai_pelayanan[]" value="<?= $val['MULAI_PELAYANAN']?>"><?= $val['MULAI_PELAYANAN']?></td>
                                                                <td><input type="hidden" name="selesai_pelayanan[]" value="<?= $val['SELESAI_PELAYANAN']?>"><?= $val['SELESAI_PELAYANAN']?></td>
                                                                <td><input type="hidden" name="waktu_pelayanan[]" value="<?= $val['WAKTU_PELAYANAN']?>"><?= $val['WAKTU_PELAYANAN']?></td>
                                                                <td><input type="hidden" name="pic[]" value="<?= $val['PIC_PELAYAN']?>"><?= $val['PIC_PELAYAN']?></td>
                                                                <td><input type="hidden" name="urgent[]" value="<?= $val['URGENT']?> <?= $val['BON'] ?>"><?= $val['URGENT']?> <?= $val['BON'] ?></td>
                                                            </tr>
                                                        <?php $no++; $i++; }?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div id="RinPelayanan2" style="display:none">
                                                <center><label>Tanggungan</label></center>
                                                <table class="table table-bordered table-hover table-striped text-center" id="myTable" style="width: 100%;table-layout:100%">
                                                    <thead class="bg-primary">
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Tanggal</th>
                                                            <th>Jenis Dokumen</th>
                                                            <th>No Dokumen</th>
                                                            <th>Jumlah Item</th>
                                                            <th>Jumlah Pcs</th>
                                                            <th>Keterangan</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $no=1; foreach($krgpelayanan as $val){ ?>
                                                            <tr>
                                                                <td style="width: 5px"><?= $no; ?></td>
                                                                <td><input type="hidden" name="jam[]" value="<?= $val['TGL_DIBUAT']?>"><?= $val['TGL_DIBUAT']?></td>
                                                                <td><input type="hidden" name="jenis_doc[]" value="<?= $val['JENIS_DOKUMEN']?>"><?= $val['JENIS_DOKUMEN']?></td>
                                                                <td><input type="hidden" name="no_doc[]" value="<?= $val['NO_DOKUMEN']?>"><?= $val['NO_DOKUMEN']?></td>
                                                                <td><input type="hidden" name="jml_item[]" value="<?= $val['JUMLAH_ITEM']?>"><?= $val['JUMLAH_ITEM']?></td>
                                                                <td><input type="hidden" name="jml_pcs[]" value="<?= $val['JUMLAH_PCS']?>"><?= $val['JUMLAH_PCS']?></td>
                                                                <td><input type="hidden" name="urgent[]" value="<?= $val['URGENT']?> <?= $val['BON'] ?>"><?= $val['URGENT']?> <?= $val['BON'] ?></td>
                                                            </tr>
                                                        <?php $no++; }?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <label class="text-right">Packing</label>
                                        </div>
                                        <div class="col-md-6">
                                        Terselesaikan : <?= $jml_packing ?> lembar
                                        </div>
                                        <div class="col-md-4">
                                        Tanggungan : <?= $krg_packing ?> lembar
                                        </div>
                                        <div class="col-md-2">
                                            <button type="button" class="btn btn-xs btn-info" onclick="addRinPacking1(this)">Rincian</button></td>
                                        </div>
                                        <div class="col-md-12">
                                            <div id="RinPacking1" style="display:none">
                                                <center><label>Terselesaikan</label></center>
                                                <table class="table table-bordered table-hover table-striped text-center" id="myTable" style="width: 100%;table-layout:100%">
                                                    <thead class="bg-primary">
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Tanggal</th>
                                                            <th>Jenis Dokumen</th>
                                                            <th>No Dokumen</th>
                                                            <th>Jumlah Item</th>
                                                            <th>Jumlah Pcs</th>
                                                            <th>Jam Mulai</th>
                                                            <th>Jam Selesai</th>
                                                            <th>Waktu</th>
                                                            <th>PIC</th>
                                                            <th>Keterangan</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $i=0; $no=1; foreach($packing as $val){ ?>
                                                            <tr>
                                                                <td style="width: 5px"><?= $no; ?></td>
                                                                <td><input type="hidden" name="jam[]" value="<?= $val['TGL_DIBUAT']?>"><?= $val['TGL_DIBUAT']?></td>
                                                                <td><input type="hidden" name="jenis_doc[]" value="<?= $val['JENIS_DOKUMEN']?>"><?= $val['JENIS_DOKUMEN']?></td>
                                                                <td><input type="hidden" name="no_doc[]" value="<?= $val['NO_DOKUMEN']?>"><?= $val['NO_DOKUMEN']?></td>
                                                                <td><input type="hidden" name="jml_item[]" value="<?= $val['JUMLAH_ITEM']?>"><?= $val['JUMLAH_ITEM']?></td>
                                                                <td><input type="hidden" name="jml_pcs[]" value="<?= $val['JUMLAH_PCS']?>"><?= $val['JUMLAH_PCS']?></td>
                                                                <td><input type="hidden" name="mulai_packing[]" value="<?= $val['MULAI_PACKING']?>"><?= $val['MULAI_PACKING']?></td>
                                                                <td><input type="hidden" name="selesai_packing[]" value="<?= $val['SELESAI_PACKING']?>"><?= $val['SELESAI_PACKING']?></td>
                                                                <td><input type="hidden" name="waktu_packing[]" value="<?= $val['WAKTU_PACKING']?>"><?= $val['WAKTU_PACKING']?></td>
                                                                <td><input type="hidden" name="pic[]" value="<?= $val['PIC_PACKING']?>"><?= $val['PIC_PACKING']?></td>
                                                                <td><input type="hidden" name="urgent[]" value="<?= $val['URGENT']?> <?= $val['BON'] ?>"><?= $val['URGENT']?> <?= $val['BON'] ?></td>
                                                            </tr>
                                                        <?php $no++; $i++; } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div id="RinPacking2" style="display:none">
                                                <center><label>Tanggungan</label></center>
                                                <table class="table table-bordered table-hover table-striped text-center" id="myTable" style="width: 100%;table-layout:100%">
                                                    <thead class="bg-primary">
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Tanggal</th>
                                                            <th>Jenis Dokumen</th>
                                                            <th>No Dokumen</th>
                                                            <th>Jumlah Item</th>
                                                            <th>Jumlah Pcs</th>
                                                            <th>PIC</th>
                                                            <th>Keterangan</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $no=1; foreach($krgpacking as $val){ ?>
                                                            <tr>
                                                                <td style="width: 5px"><?= $no; ?></td>
                                                                <td><input type="hidden" name="jam[]" value="<?= $val['TGL_DIBUAT']?>"><?= $val['TGL_DIBUAT']?></td>
                                                                <td><input type="hidden" name="jenis_doc[]" value="<?= $val['JENIS_DOKUMEN']?>"><?= $val['JENIS_DOKUMEN']?></td>
                                                                <td><input type="hidden" name="no_doc[]" value="<?= $val['NO_DOKUMEN']?>"><?= $val['NO_DOKUMEN']?></td>
                                                                <td><input type="hidden" name="jml_item[]" value="<?= $val['JUMLAH_ITEM']?>"><?= $val['JUMLAH_ITEM']?></td>
                                                                <td><input type="hidden" name="jml_pcs[]" value="<?= $val['JUMLAH_PCS']?>"><?= $val['JUMLAH_PCS']?></td>
                                                                <td><input type="hidden" name="pic[]" value="<?= $val['PIC_PELAYAN']?>"><?= $val['PIC_PELAYAN']?></td>
                                                                <td><input type="hidden" name="urgent[]" value="<?= $val['URGENT']?> <?= $val['BON'] ?>"><?= $val['URGENT']?> <?= $val['BON'] ?></td>
                                                            </tr>
                                                        <?php $no++; } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <div>
                                            <table style="width: 100%;table-layout:fixed">
                                                <tbody>
                                                    <tr>
                                                       <th width="52%" style="padding-left:15px">Jumlah lembar selesai</th>
                                                       <th>: <?= $jml_selesai ?> lembar</th>
                                                    </tr>
                                                    <tr>
                                                       <th width="52%" style="padding-left:15px">Jumlah item selesai</th>
                                                       <th>: <?= $jml_item_selesai ?> item</th>
                                                    </tr>
                                                    <tr>
                                                       <th width="52%" style="padding-left:15px">Jumlah pcs selesai</th>
                                                       <th>: <?= $jml_pcs_selesai ?> pcs</th>
                                                    </tr>
                                                    <tr>
                                                       <th style="padding-left:15px">Kekurangan selesai</th>
                                                       <th>: <?= $krg_selesai ?> pcs</th>
                                                    </tr>
                                                    <tr>
                                                       <th style="padding-left:15px">DOSP / SPB cancel hari ini</th>
                                                       <th>: <?= $cancel ?> lembar</th>
                                                    </tr>
                                                    <tr>
                                                       <th style="padding-left:15px">Penerimaan menyelesaikan</th>
                                                       <th>: <?= $jml_gd ?> lembar</th>
                                                    </tr>
                                                    <tr>
                                                       <th style="padding-left:15px">Jumlah Colly</th>
                                                       <th>: <?= $jml_colly?></th>
                                                    </tr>
                                                    <tr>
                                                        <th style="padding-left:15px" colspan="2">
                                                            <div class="table-responsive">
                                                                <table class="table table-bordered table-hover text-center" style="width:100%;">
                                                                    <thead class="bg-info">
                                                                        <th>Kardus Kecil</th>
                                                                        <th>Kardus Sedang</th>
                                                                        <th>Kardus Panjang</th>
                                                                        <th>Karung</th>
                                                                        <th>Peti</th>
                                                                    </thead>
                                                                    <tbody>
                                                                        <td><?= $dus_kecil?></td>
                                                                        <td><?= $dus_sdg?></td>
                                                                        <td><?= $dus_pjg?></td>
                                                                        <td><?= $karung?></td>
                                                                        <td><?= $peti?></td>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </th>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                </form>
                                </div>

                                
                                <div class="col-md-12 tab-pane fade" id="monitoring2">
                                    <form method="POST" action="<?php echo base_url("KapasitasGdSparepart/Monitoring/report_period")?>">
                                    <div class="panel-body">
                                        <div class="col-md-3">
                                            <label class="text-right">Tanggal Awal</label>
                                            <input id="tgl_awal" name="tgl_awal" class="form-control pull-right date_report" placeholder="<?= date('Y/m/d H:i')?>" autocomplete="off">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="text-right">Tanggal Akhir</label>
                                            <div class="input-group">
                                            <input id="tgl_akhir" name="tgl_akhir" class="form-control pull-right date_report" placeholder="<?= date('Y/m/d H:i')?>" autocomplete="off">
                                            <span class="input-group-btn">
                                                <button class="btn btn-success" style="margin-left:10px"><i class="fa fa-download" ></i> Export</button>    
                                            </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-body"></div>
                                    </form>
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