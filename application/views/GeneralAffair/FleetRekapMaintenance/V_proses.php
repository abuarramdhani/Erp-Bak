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
                                <div class="box-header with-border">Rekap Maintenance Kendaraan</div>
                                <div class="box-body">
                                    <div class="panel-body">
                                        <div class="row">
                                            <form method="post" action="<?php echo base_url('GeneralAffair/FleetRekapMaintenance/RekapMaintenance');?>">
                                                <div class="form-group">
                                                    <label for="cmbPeriode" class="control-label col-lg-4">Periode</label>
                                                    <div class="col-lg-4">
                                                        <select id="TahunPeriodeMaintenance" name="cmbPeriode" class="select2" data-placeholder="Pilih" style="width: 75%" required="">
                                                            <option value=""></option>
                                                            <?php
                                                                foreach ($dropdownTahun as $Tahun) 
                                                                {
                                                                    $status = '';
                                                                    if($Tahun['tahun']==$tahun)
                                                                    {
                                                                        $status = 'selected';
                                                                    }
                                                                    echo    '  <option value="'.$Tahun['tahun'].'" '.$status.'>'
                                                                                    .$Tahun['tahun'].
                                                                            '   </option>';
                                                                }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <center>
                                                            <button type="submit" class="btn btn-primary">Proses</button>
                                                        </center>
                                                    </div>                                                    
                                                </div>
                                                <br/>
                                                <hr/>
                                            </form>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="chart-responsive">
                                                    <center>
                                                    <label for="RekapTotalMaintenance" class="control-label">Rekap Total Maintenance</label>
                                                    </center>
                                                    <hr/>                                                         
                                                    <canvas id="RekapTotalMaintenance" height="200"></canvas>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="chart-responsive">
                                                    <center>
                                                    <label for="RekapFrekuensiMaintenance" class="control-label">Rekap Frekuensi Maintenance</label>
                                                    </center>
                                                    <hr/>                                                  
                                                    <canvas id="RekapFrekuensiMaintenance" height="200"></canvas>
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

<script type="text/javascript">
    
    window.onload = function() {
        setTimeout(function() {
            var     tahun   = $('#TahunPeriodeMaintenance').val();
            rekapMaintenance(tahun);
        }, 1000);
    }
</script>