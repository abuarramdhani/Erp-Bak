<style media="screen">
    .btn3d {
        transition:all .08s linear;
        position:relative;
        outline:medium none;
        -moz-outline-style:none;
        border:0px;
        margin-top:-10px;
    }
    .btn3d:focus {
        outline:medium none;
        -moz-outline-style:none;
    }
    .btn3d:active {
        top:6px;
    }
    .btn-primary2 {
    box-shadow:0 0 0 1px #428bca inset, 0 0 0 2px rgba(255,255,255,0.15) inset, 0 8px 0 0 #357ebd, 0 8px 0 1px rgba(0,0,0,0.4), 0 8px 8px 1px rgba(0,0,0,0.5);
    background-color:#428bca;
    color: white;
    }
    .btn-primary2:hover{
        color: white;
    }
    .btn-danger2 {
    box-shadow:0 0 0 1px #b83b3b inset, 0 0 0 2px rgba(255,255,255,0.15) inset, 0 8px 0 0 #b83b3b, 0 8px 0 1px rgba(0,0,0,0.4), 0 8px 8px 1px rgba(0,0,0,0.5);
    background-color:#b83b3b;
    color: white;
    }
    .btn-danger2:hover{
        color: white;
    }
    .btn-success2 {
    box-shadow:0 0 0 1px #1b8c1d inset, 0 0 0 2px rgba(255,255,255,0.15) inset, 0 8px 0 0 #1b8c1d, 0 8px 0 1px rgba(0,0,0,0.4), 0 8px 8px 1px rgba(0,0,0,0.5);
    background-color:#1b8c1d;
    color: white;
    }
    .btn-success2:hover{
        color: white;
    }
</style>
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
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('GeneralAffair/');?>">
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
                            <div class="box-header with-border"></div>
                            <div class="box-body">
                                <div class="col-lg-12">
                                    <label for="GA_shutle" class="col-lg-1">Tanggal : </label>
                                    <form action="<?php echo base_url('GeneralAffair/PemesananShutle/ExportPDF') ?>" method="post">
                                        <input name="tgl_pesan" id="GA_shutle" class=" col-lg-3" value="<?php echo date('d-m-Y') ?>">
                                        <a name="button" id="GA_find_shutle" class="btn btn-primary2 btn3d col-lg-1">Search</a>
                                        <button type="submit" name="GA_btn_shutle" value="1" class="btn btn-danger2 btn3d col-lg-1"><span class="fa fa-file-pdf-o"></span>PDF</button>
                                        <button type="submit" name="GA_btn_shutle" value="2" class="btn btn-success2 btn3d col-lg-1"><span class="fa fa-file-excel-o"></span>Excel</button>
                                    </form>
                                </div>
                                <div class="col-lg-12" style="margin-top: 20px;" id="GA_tabel_Shutle">
                                    <p style="text-align: center; font-size: 18px"><b>Rekap <?= date('d F Y') ?></b></p>
                                    <table class="table table-striped table-bordered table-hover GA_tble" id="GA_Tbl_shutle" width="100%" style="margin-top: 20px">
                                        <tr>
                                            <th colspan="2" rowspan="2" width="8%" style="background-color: #94cfff"></th>
                                            <th class="text-center" colspan="4" style="background-color: #94cfff">DARI PUSAT</th>
                                        </tr>
                                        <tr>
                                            <th class="text-center" width="23%">08:00</th>
                                            <th class="text-center" width="23%">10:00</th>
                                            <th class="text-center" width="23%">13:00</th>
                                            <th class="text-center" width="23%">-</th>
                                        </tr>
                                        <tr>
                                            <th class="text-center" rowspan="4" style="background-color: #94cfff">D<br>A<br>R<br>I<br><br>T<br>U<br>K<br>S<br>O<br>N<br>O</th>
                                            <th class="text-center">09:00</th>
                                            <td><?php if (!empty($data89[0]['pekerja'])) {
                                                foreach ($data89 as $key) {
                                                    echo $key['pekerja'];
                                                }
                                            }else {
                                                echo '-';
                                            } ?></td>
                                            <td><?php if (!empty($data910[0]['pekerja'])) {
                                                foreach ($data910 as $key) {
                                                    echo $key['pekerja'];
                                                }
                                            }else {
                                                echo '-';
                                            } ?></td>
                                            <td><?php if (!empty($data913[0]['pekerja'])) {
                                                foreach ($data913 as $key) {
                                                    echo $key['pekerja'];
                                                }
                                            }else {
                                                echo '-';
                                            } ?></td>
                                            <td><?php if (!empty($data900[0]['pekerja'])) {
                                                foreach ($data900 as $key) {
                                                    echo $key['pekerja'];
                                                }
                                            }else {
                                                echo '-';
                                            } ?></td>
                                        </tr>
                                        <tr>
                                            <th class="text-center">11:00</th>
                                            <td><?php if (!empty($data811[0]['pekerja'])) {
                                                foreach ($data811 as $key) {
                                                    echo $key['pekerja'];
                                                }
                                            }else {
                                                echo '-';
                                            } ?></td>
                                            <td><?php if (!empty($data1011[0]['pekerja'])) {
                                                foreach ($data1011 as $key) {
                                                    echo $key['pekerja'];
                                                }
                                            }else {
                                                echo '-';
                                            } ?></td>
                                            <td><?php if (!empty($data1113[0]['pekerja'])) {
                                                foreach ($data1113 as $key) {
                                                    echo $key['pekerja'];
                                                }
                                            }else {
                                                echo '-';
                                            } ?></td>
                                            <td><?php if (!empty($data1100[0]['pekerja'])) {
                                                foreach ($data1100 as $key) {
                                                    echo $key['pekerja'];
                                                }
                                            }else {
                                                echo '-';
                                            } ?></td>
                                        </tr>
                                        <tr>
                                            <th class="text-center">14:00</th>
                                            <td><?php if (!empty($data814[0]['pekerja'])) {
                                                foreach ($data814 as $key) {
                                                    echo $key['pekerja'];
                                                }
                                            }else {
                                                echo '-';
                                            } ?></td>
                                            <td><?php if (!empty($data1014[0]['pekerja'])) {
                                                foreach ($data1014 as $key) {
                                                    echo $key['pekerja'];
                                                }
                                            }else {
                                                echo '-';
                                            } ?></td>
                                            <td><?php if (!empty($data1314[0]['pekerja'])) {
                                                foreach ($data1314 as $key) {
                                                    echo $key['pekerja'];
                                                }
                                            }else {
                                                echo '-';
                                            } ?></td>
                                            <td><?php if (!empty($data1400[0]['pekerja'])) {
                                                foreach ($data1400 as $key) {
                                                    echo $key['pekerja'];
                                                }
                                            }else {
                                                echo '-';
                                            } ?></td>
                                        </tr>
                                        <tr>
                                            <th class="text-center">-</th>
                                            <td><?php if (!empty($data8[0]['pekerja'])) {
                                                foreach ($data8 as $key) {
                                                    echo $key['pekerja'];
                                                }
                                            }else {
                                                echo '-';
                                            } ?></td>
                                            <td><?php if (!empty($data10[0]['pekerja'])) {
                                                foreach ($data10 as $key) {
                                                    echo $key['pekerja'];
                                                }
                                            }else {
                                                echo '-';
                                            } ?></td>
                                            <td><?php if (!empty($data13[0]['pekerja'])) {
                                                foreach ($data13 as $key) {
                                                    echo $key['pekerja'];
                                                }
                                            }else {
                                                echo '-';
                                            } ?></td>
                                            <td>-</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
