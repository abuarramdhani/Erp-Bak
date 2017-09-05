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
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('GeneralAffair/FleetJenisKendaraan');?>">
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
                                <div class="box-header with-border">Rekap KIR Kendaraan</div>
                                <div class="box-body">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="form-group">
                                                <label for="cmbPeriode" class="control-label col-lg-4">Periode</label>
                                                <div class="col-lg-4">
                                                    <select id="TahunPeriodeKIR" name="cmbPeriode" class="select2" data-placeholder="Pilih" style="width: 75%" required="">
                                                        <option value=""></option>
                                                        <?php
                                                            foreach ($dropdownTahun as $Tahun) 
                                                            {
                                                                echo    '  <option value="'.$Tahun['tahun'].'">'
                                                                                .$Tahun['tahun'].
                                                                        '   </option>';
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <hr>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="chart-responsive">
                                                    <canvas id="RekapTotalKIR" height="100"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="chart-responsive">
                                                    <canvas id="RekapFrekuensiKIR" height="100"></canvas>
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