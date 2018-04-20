<section class="content">
    <div class="inner" >
        <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-11">
                                <div class="text-right"><h1><b><?= $Title ?></b></h1></div>
                            </div>
                            <div class="col-lg-1">
                                <div class="text-right hidden-md hidden-sm hidden-xs">
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('GeneralAffair/FleetMonitoring');?>">
                                        <i class="icon-wrench icon-2x"></i>
                                        <br/>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br/>
           
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="box box-primary box-solid">
                                <div class="box-header with-border">Monitoring Kendaraan</div>
                                <div class="box-body">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="form-group">
                                                <label for="cmbLihatBerdasarkan" class="control-label col-lg-4">Lihat Berdasarkan</label>
                                                <div class="col-lg-4">
                                                    <select id="cmbLihatBerdasarkan" name="cmbLihatBerdasarkan" class="select2" data-placeholder="Pilih" style="width: 75%" required="">
                                                        <option value=""></option>
                                                        <option value="1">Nomor Polisi</option>
                                                        <option value="2">Kategori</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <br/>
                                            <hr/>

                                            <div id="nomor_polisi" hidden="">
                                                    <br/>
                                                    <div class="form-group">
                                                        <label for="cmbNomorPolisi" class="control-label col-lg-4">Nomor Polisi</label>
                                                        <div class="col-lg-4">
                                                            <select id="cmbNomorPolisi" name="cmbNomorPolisi" class="select2" data-placeholder="Pilih" style="width: 75%" required="">
                                                                <option value=""></option>
                                                                <?php
                                                                    foreach ($FleetKendaraan as $row) 
                                                                    {
                                                                        echo '<option value="'.$row['kode_kendaraan'].'" >'.$row['nomor_polisi'].'</option>';
                                                                    }
                                                        ?>
                                                            </select>
                                                        </div>
                                                    </div> 
                                                    <div class="form-group">
                                                        <center>
                                                            <button type="button" name="ProsesMonitoringNomorPolisi" id="ProsesMonitoringNomorPolisi" class="btn btn-primary">
                                                                Proses
                                                            </button>                                                        
                                                        </center>
                                                    </div>
                                                    <hr/>
                                                    <br/>

                                                    <div class="table-responsive" id="tabelMonitoringNomorPolisi" hidden="">
                                                        <table class="datatable table table-striped table-bordered table-hover text-left" id="dataTables-fleetMonitoringNomorPolisi" style="font-size:12px;">
                                                            <thead class="bg-primary">
                                                                <tr>
                                                                    <th style="text-align: center; width: 30px">No</th>
                                                                    <th style="text-align: center;">Kategori</th>
                                                                    <th style="text-align: center;">Tanggal</th>
                                                                    <th style="text-align: center;">Biaya</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="isiMonitoringNomorPolisi">
                                                            </tbody>
                                                        </table>
                                                    </div>
                                            </div>
                                            <div id="kategori" hidden="">
                                                <br/>
                                                    <div class="form-group">
                                                        <label for="cmbKategori" class="control-label col-lg-4">Kategori</label>
                                                        <div class="col-lg-4">
                                                            <select id="cmbKategori" name="cmbKategori" class="select2" data-placeholder="Pilih" style="width: 75%" required="">
                                                                <option value=""></option>
                                                                <option value="A">Pajak</option>
                                                                <option value="B">KIR</option>
                                                                <option value="C">Maintenance Kendaraan</option>
                                                                <option value="D">Kecelakaan</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <br/>
                                                    <div class="form-group">
                                                        <label class="control-label col-lg-4">Periode</label>
                                                        <div class="col-lg-4">
                                                            <input type="text" name="PeriodeKategori" id="ManajemenKendaraan-daterangepicker" class="date form-control">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <center>
                                                        <button type="button" name="ProsesMonitoringKategori" id="ProsesMonitoringKategori" class="btn btn-primary" >Proses</button>                                                          
                                                        </center>
                                                    </div>
                                                    <hr/>
                                                    <br/>

                                                    <div id="tabelMonitoringKategori" hidden="">
                                                        <div class="box-body">
                                                            <div class="form-group">
                                                                <form method="POST" action="<?php echo site_url('GeneralAffair/FleetMonitoring/cetakExcelMonitoringKendaraan');?>">
                                                                    <input type="hidden" name="MainMenuExport" id="MainMenuExport">
                                                                    <input type="hidden" name="KategoriMonitoringExport" id="KategoriMonitoringExport">
                                                                    <input type="hidden" name="PeriodeMonitoringExport" id="PeriodeMonitoringExport">
                                                                    <button type="submit" class="btn btn-success pull-right hidden" style="margin-top: -30px;margin-bottom: 5px;margin-left: 10px" id="buttonExport">Export</button>
                                                                </form>
                                                                <form method="POST" action="<?php echo site_url('GeneralAffair/FleetMonitoring/monitoringKendaraanDetail');?>">
                                                                    <input type="hidden" name="PeriodeMonitoringDetail" id="PeriodeMonitoringDetail">
                                                                    <button type="submit" class="btn btn-info pull-right hidden" style="margin-top: -30px;margin-bottom: 5px" target="_blank" id="buttonDetail">Detail</button>
                                                                </form> 
                                                            </div>
                                                        </div>
                                                        <table class="datatable table table-striped table-bordered table-hover text-left" id="dataTables-fleetMonitoringKategori" style="font-size:12px;">
                                                            <thead class="bg-primary">
                                                                <tr>
                                                                    <th style="text-align: center; width: 30px">No</th>
                                                                    <th style="text-align: center;">Nomor Polisi</th>
                                                                    <th style="text-align: center;">Tanggal Maintenace</th>
                                                                    <th style="text-align: center;">Biaya</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="isiMonitoringKategori">
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