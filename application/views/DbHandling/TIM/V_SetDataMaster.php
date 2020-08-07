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
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('DbHandling/SetDataMaster'); ?>">
                                    <i class="fa fa-cog fa-2x">
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
                        <div class="box box-danger">
                            <div class="box-header with-border" style="font-weight: bold;">MASTER HANDLING</div>
                            <div class="box-body">
                                <div class="col-md-12" id="tabel_master_handling"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-primary">
                            <div class="box-header with-border" style="font-weight: bold;">MASTER PROSES SEKSI</div>
                            <div class="box-body">
                                <div class="col-md-12" id="tabel_masterpro_seksi"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-info">
                            <div class="box-header with-border" style="font-weight: bold;">MASTER STATUS KOMPONEN</div>
                            <div class="box-body">
                                <div class="col-md-12" id="tabel_masterstat_komp"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-success">
                            <div class="box-header with-border" style="font-weight: bold;">*KETENTUAN SESUAI COP TH-01 PEMBUATAN STANDAR HANDLING Rev 2 Ver 220914</div>
                            <div class="box-body">
                                <div class="col-md-12">
                                    <table style="width: 100%;">
                                        <tr>
                                            <td style="background-color: #ff00ff;color: #ff00ff;width:5%">u</td>
                                            <td>&nbsp;&nbsp;UPPL</td>
                                            <td style="background-color: #94bd5e;color: #94bd5e;width:5%">s</td>
                                            <td>&nbsp;&nbsp;Sheet Metal</td>
                                            <td style="background-color: #ffff00;color: #ffff00;width:5%">m</td>
                                            <td>&nbsp;&nbsp;Machining</td>
                                            <td style="background-color: #99ccff;color: #99ccff;width:5%">p</td>
                                            <td>&nbsp;&nbsp;Perakitan</td>
                                            <td style="background-color: #ff8080;color: #ff8080;width:5%">p</td>
                                            <td>&nbsp;&nbsp;PnP</td>
                                            <td style="background-color: #cccccc;color: #cccccc;width:5%">g</td>
                                            <td>&nbsp;&nbsp;Gudang(All)</td>
                                            <td style="background-color: #ffcc99;color: #ffcc99;width:5%">s</td>
                                            <td>&nbsp;&nbsp;Subkon</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
</section>
<!-- Modal Tambah -->
<div class="modal fade" id="modaltambahmasterhandling" role="dialog">
    <div class="modal-dialog" style="width:60%">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <center>
                    <h3 class="modal-title">Tambah Master Handling</h3>
                </center>
            </div>
            <div class="modal-body">
                <div id="masterhandlingadd"></div>
            </div>
        </div>

    </div>
</div>
<div class="modal fade" id="modaltambahmasterproseksi" role="dialog">
    <div class="modal-dialog" style="width:60%">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <center>
                    <h3 class="modal-title">Tambah Master Proses Seksi</h3>
                </center>
            </div>
            <div class="modal-body">
                <div id="masterproseksiadd"></div>
            </div>
        </div>

    </div>
</div>
<div class="modal fade" id="modaltambahmasterstatkomp" role="dialog">
    <div class="modal-dialog" style="width:60%">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <center>
                    <h3 class="modal-title">Tambah Master Status Komponen</h3>
                </center>
            </div>
            <div class="modal-body">
                <div id="masterstatkompadd"></div>
            </div>
        </div>

    </div>
</div>
<!-- Modal Edit -->
<div class="modal fade" id="modaleditmasterhandling" role="dialog">
    <div class="modal-dialog" style="width:60%">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <center>
                    <h3 class="modal-title">Edit Master Handling</h3>
                </center>
            </div>
            <div class="modal-body">
                <div id="masterhandlingedit"></div>
            </div>
        </div>

    </div>
</div>
<div class="modal fade" id="modaleditmasterproseksi" role="dialog">
    <div class="modal-dialog" style="width:60%">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <center>
                    <h3 class="modal-title">Edit Master Handling</h3>
                </center>
            </div>
            <div class="modal-body">
                <div id="masterproseksiedit"></div>
            </div>
        </div>

    </div>
</div>
<div class="modal fade" id="modaleditmasterstatkom" role="dialog">
    <div class="modal-dialog" style="width:60%">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <center>
                    <h3 class="modal-title">Edit Status Komponen</h3>
                </center>
            </div>
            <div class="modal-body">
                <div id="masterstatkompp"></div>
            </div>
        </div>

    </div>
</div>