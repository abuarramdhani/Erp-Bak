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
                                <div class="box-header with-border">Rekap Total</div>
                                <div class="box-body">
                                    <div class="panel-body">
                                        <div class="row">
                                            <form method="post" action="<?php echo base_url('GeneralAffair/FleetRekapTotal/RekapTotal');?>">
                                                <div class="form-group">
                                                    <label for="cmbPeriode" class="control-label col-lg-3">Periode</label>
                                                    <div class="col-lg-3">
                                                        <select id="TahunPeriodeTotal" name="cmbTahun" class="select2" data-placeholder="Pilih" style="width: 75%" required="">
                                                            <option value=""></option>
                                                            <?php
                                                                foreach ($dropdownTahun as $Tahun) 
                                                                {
                                                                    $status_tahun = '';
                                                                    if($Tahun['tahun']==$tahun)
                                                                    {
                                                                        $status_tahun = "selected";
                                                                    }
                                                                    echo    '  <option value="'.$Tahun['tahun'].'" '.$status_tahun.'>'
                                                                                    .$Tahun['tahun'].
                                                                            '   </option>';
                                                                }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <select id="BulanPeriodeTotal" name="cmbBulan" class="select2" data-placeholder="Pilih" style="width: 75%" required="">
                                                            <option value=""></option>
                                                            <?php
                                                                foreach ($dropdownBulan as $Bulan) 
                                                                {
                                                                    $status_bulan   = '';
                                                                    if($Bulan['bulan_angka']==$bulan)
                                                                    {
                                                                        $status_bulan = 'selected';
                                                                    }
                                                                    echo    '  <option value="'.$Bulan['bulan_angka'].'" '.$status_bulan.'>'
                                                                                    .$Bulan['bulan'].
                                                                            '   </option>';
                                                                }
                                                            ?>
                                                        </select>
                                                        
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            <center>
                                                                <button type="submit" name="ProsesRekapTotal" id="ProsesRekapTotal" class="btn btn-primary">
                                                                Proses
                                                                </button>
                                                            </center>  
                                                        </div>                                                      
                                                    </div>                                                 
                                                </div>
                                                <hr>
                                            </form>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="chart-responsive" id="ContainerRekapBiayaTotal">
                                                    <center>
                                                    <label for="RekapBiayaTotal" class="control-label">Rekap Biaya Total</label>
                                                    </center>
                                                    <hr/>                                                    
                                                    <canvas id="RekapBiayaTotal" height="200"></canvas>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="chart-responsive" id="ContainerRekapFrekuensiTotal">
                                                    <center>
                                                    <label for="RekapFrekuensiTotal" class="control-label">Rekap Frekuensi Total</label>
                                                    </center>
                                                    <hr/>                                                
                                                    <canvas id="RekapFrekuensiTotal" height="200"></canvas>
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
    $(window).load(function(){
            var     tahun   = $('#TahunPeriodeTotal').val();
            var     bulan   = $('#BulanPeriodeTotal').val();
            rekapTotal(tahun, bulan);
    });     
</script>