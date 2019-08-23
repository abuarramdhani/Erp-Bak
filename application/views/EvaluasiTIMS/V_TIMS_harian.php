<style>
    .card:hover
    {
        transform: scale(1.2);
        margin-right: 6%; /*fallback for old browsers */
        margin-right: calc(2% + 0px);
        margin-left: 5%;
    }
    .card
    {
        transition: all 0.4s ease;
    }
    #et_set_eval{
        position:absolute;
        z-index: 300;
        right:0;
        margin-top: -25px;
        top:0; font-weight: bold;
    }
    #et_set_eval2{
        position:absolute;
        z-index: 300;
        right:0;
        margin-top: -12px;
        top:0; font-weight: bold;
    }
</style>
<section class="content">
    <div class="inner" >
        <div class="row">
            <div class="col-lg-12">
                <div class="col-lg-11">
                    <div class="text-right">
                        <h1><b>TIMS Harian</b></h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-11"></div>
                        <div class="col-lg-1 "></div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="box box-primary box-solid">
                        <div class="box-header with-border"></div>
                        <div class="box-body">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <p id="et_set_eval"><?php echo 'Lama Evaluasi OJT : '.$LamaEvaluasi[0]['lama_penilaian'].' bulan'; ?></p>
                                        <p id="et_set_eval2"><?php echo 'Lama Evaluasi Non OJT : '.$LamaEvaluasi[1]['lama_penilaian'].' bulan'; ?></p>
                                        <form method="post" action="<?php echo site_url('EvaluasiTIMS/Harian'); ?>">
                                            <div class="col-md-12 form-group">
                                                <label style="margin-top: 5px;" class="col-sm-2 col-form-label" for="name">Jenis Penilaian :</label>
                                                <div class="col-md-4">
                                                    <select required="" type="text" class="form-control et_select_jp et_get_lamaEval" style="width: 100%;" name="et_s_harian" id="name">
                                                        <option></option>
                                                    </select>
                                                </div>
                                                <button disabled="" style="margin-left: 20px;" class="btn btn-primary bt_et_harian">Search</button>
                                            </div>
                                        </form>
                                        <?php if ($val == '1') { ?>
                                        <div style="font-weight: bold;" class="col-md-12 text-center">
                                            <h3><?php echo $jp[0]['jenis_penilaian']; ?></h3>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="card text-center">
                                                <div style="background-color: #D32F2F;" class="card-header">
                                                    <h4 style="margin: 0px; font-weight: bold; color: #fff">Keuangan</h4>
                                                </div>
                                                <div style="padding: 0px; background-color: #F44336; color: #fff;" class="card-body">
                                                    <h4 class="card-text">
                                                        <?php echo hari_ini().', '.date('d/m/Y'); ?> <br/>
                                                        <p style="font-size: 64px; margin-bottom: 0px;"><?php echo $jumlah[0]; ?></p>New
                                                    </h4>
                                                    <h3 style="margin: 0px;">Tidak Lolos</h3>
                                                </div>
                                                <div style="background-color: #D32F2F;" class="card-footer">
                                                    <a target="_blank" href="<?php echo site_url('EvaluasiTIMS/Harian/LihatHarian/'.$idi.'/1'); ?>" style="font-size: 14px; font-weight: bold; color: #FFFFFF">More Info</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="card text-center">
                                                <div style="background-color: #388E3C;" class="card-header">
                                                    <h4 style="margin: 0px; font-weight: bold; color: #fff">Pemasaran</h4>
                                                </div>
                                                <div style="padding: 0px; background-color: #4CAF50; color: #fff;" class="card-body">
                                                    <h4 class="card-text">
                                                        <?php echo hari_ini().', '.date('d/m/Y'); ?> <br/>
                                                        <p style="font-size: 64px; margin-bottom: 0px;"><?php echo $jumlah[1]; ?></p>New
                                                    </h4>
                                                    <h3 style="margin: 0px;">Tidak Lolos</h3>
                                                </div>
                                                <div style="background-color: #388E3C;" class="card-footer">
                                                    <a target="_blank" href="<?php echo site_url('EvaluasiTIMS/Harian/LihatHarian/'.$idi.'/2'); ?>" style="font-size: 14px; font-weight: bold; color: #FFFFFF">More Info</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="card text-center">
                                                <div style="background-color: #1976D2;" class="card-header">
                                                    <h4 style="margin: 0px; font-weight: bold; color: #fff">Personalia</h4>
                                                </div>
                                                <div style="padding: 0px; background-color: #2196F3; color: #fff;" class="card-body">
                                                    <h4 class="card-text">
                                                        <?php echo hari_ini().', '.date('d/m/Y'); ?> <br/>
                                                        <p style="font-size: 64px; margin-bottom: 0px;"><?php echo $jumlah[2]; ?></p>New
                                                    </h4>
                                                    <h3 style="margin: 0px;">Tidak Lolos</h3>
                                                </div>
                                                <div style="background-color: #1976D2;" class="card-footer">
                                                    <a target="_blank" href="<?php echo site_url('EvaluasiTIMS/Harian/LihatHarian/'.$idi.'/3'); ?>" style="font-size: 14px; font-weight: bold; color: #FFFFFF">More Info</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="card text-center">
                                                <div style="background-color: #7B1FA2;" class="card-header">
                                                    <h4 style="margin: 0px; font-weight: bold; color: #fff">Produksi</h4>
                                                </div>
                                                <div style="padding: 0px; background-color: #9C27B0; color: #fff;" class="card-body">
                                                    <h4 class="card-text">
                                                        <?php echo hari_ini().', '.date('d/m/Y'); ?> <br/>
                                                        <p style="font-size: 64px; margin-bottom: 0px;"><?php echo $jumlah[3]; ?></p>New
                                                    </h4>
                                                    <h3 style="margin: 0px;">Tidak Lolos</h3>
                                                </div>
                                                <div style="background-color: #7B1FA2;" class="card-footer">
                                                    <a target="_blank" href="<?php echo site_url('EvaluasiTIMS/Harian/LihatHarian/'.$idi.'/4'); ?>" style="font-size: 14px; font-weight: bold; color: #FFFFFF">More Info</a>
                                                </div>
                                            </div>
                                        </div>
                                        <?php } ?>
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
<div hidden id="surat-loading" style="top: 0;left: 0;right: 0;bottom: 0; margin: auto; position: fixed; background: rgba(0,0,0,.5); z-index: 11;">
    <img src="http://erp.quick.com/assets/img/gif/loadingtwo.gif" style="position: fixed; top: 0;left: 0;right: 0;bottom: 0; margin: auto; width: 40%;">
</div>
<?php 
function hari_ini(){
    $hari = date ("D");

    switch($hari){
        case 'Sun':
        $hari_ini = "Minggu";
        break;

        case 'Mon':         
        $hari_ini = "Senin";
        break;

        case 'Tue':
        $hari_ini = "Selasa";
        break;

        case 'Wed':
        $hari_ini = "Rabu";
        break;

        case 'Thu':
        $hari_ini = "Kamis";
        break;

        case 'Fri':
        $hari_ini = "Jumat";
        break;

        case 'Sat':
        $hari_ini = "Sabtu";
        break;
        
        default:
        $hari_ini = "Tidak di ketahui";     
        break;
    }

    return "<b>" . $hari_ini . "</b>";

}
?>