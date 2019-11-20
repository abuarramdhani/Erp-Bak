<script src="<?php echo base_url('assets/plugins/dataTables/jquery.dataTables.js');?>"></script>
	<script src="<?php echo base_url('assets/plugins/dataTables/dataTables.bootstrap.js');?>"></script>
     <script>
         $(document).ready(function () {
            $(".datepickerTahun").datepicker( {
                format: " yyyy",
                viewMode: "years", 
                minViewMode: "years"
            });
            // $('.tblRkapLppb').dataTable({
            //     "scrollX": false,
            //     "paging":false,
            // });
            
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
                                    href="<?php echo site_url('RekapTahunan/');?>">
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
                            <div class="box-header with-border"><b>Rekap Tahunan</b></div>
                            <div class="box-body">
                                <div class="panel-body">
                                    <div class="col-md-3">
                                        <div class="input-group input-group-sm">
                                        <input id="tahun" name="tahun" class="form-control pull-right datepickerTahun" placeholder="<?= $tahun?>" >
                                        <span class="input-group-btn">
                                            <button type="button" onclick="searchTahunLppb(this)" class="btn btn-flat" style="background:inherit; text-align:left;padding:0px;padding-left:10px;"><i class="fa fa-2x fa-arrow-circle-right" ></i></button>    
                                            <!-- <button type="submit" class="btn btn-flat" style="background:inherit; text-align:left;padding:0px;padding-left:10px;"><i class="fa fa-2x fa-arrow-circle-right" ></i></button>     -->
                                        </span>
                                        </div>
                                    </div>
                                </div>

                                    <div class="panel-body">
                                        <div class="table-responsive" id="tb_rekapTh">
                                        <table class="table table-striped table-bordered table-responsive table-hover text-center" style="font-size:14px; table-layout:fixed; width:100%">
                                        <thead class="bg-primary">
                                            <tr>
                                                <td>Bulan</td>
                                                <td>Jumlah Belum Deliver</td>
                                                <td>Action</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                                <tr>
                                                    <td><input type="hidden" id="bulan<?= $no['0']?>" value="<?= $bulan['11']?>">January</td>
                                                    <td><?= $selisih['11']?></td>
                                                    <td>
                                                    <a href="<?php echo base_url('RekapLppb/Input/searchRekap/'.$bulan['11'])?>" >
                                                    <button type="button" class="btn btn-xs btn-success">klik</button>
                                                    </a></td>
                                                </tr>
                                                <tr>
                                                    <td><input type="hidden" id="bulan<?= $no['1']?>" value="<?= $bulan['10']?>">February</td>
                                                    <td><?= $selisih['10']?></td>
                                                    <td>
                                                    <a href="<?php echo base_url('RekapLppb/Input/searchRekap/'.$bulan['10'])?>" >
                                                    <button type="button" class="btn btn-xs btn-success">klik</button>
                                                    </a></td>
                                                </tr><tr>
                                                    <td><input type="hidden" id="bulan<?= $no['2']?>" value="<?= $bulan['9']?>">March</td>
                                                    <td><?= $selisih['9']?></td>
                                                    <td>
                                                    <a href="<?php echo base_url('RekapLppb/Input/searchRekap/'.$bulan['9'])?>" >
                                                    <button type="button" class="btn btn-xs btn-success">klik</button>
                                                    </a></td>
                                                </tr><tr>
                                                    <td><input type="hidden" id="bulan<?= $no['3']?>" value="<?= $bulan['8']?>">April</td>
                                                    <td><?= $selisih['8']?></td>
                                                    <td>
                                                    <a href="<?php echo base_url('RekapLppb/Input/searchRekap/'.$bulan['8'])?>" >
                                                    <button type="button" class="btn btn-xs btn-success">klik</button>
                                                    </a></td>
                                                </tr><tr>
                                                    <td><input type="hidden" id="bulan<?= $no['4']?>" value="<?= $bulan['7']?>">May</td>
                                                    <td><?= $selisih['7']?></td>
                                                    <td>
                                                    <a href="<?php echo base_url('RekapLppb/Input/searchRekap/'.$bulan['7'])?>" >
                                                    <button type="button" class="btn btn-xs btn-success">klik</button>
                                                    </a></td>
                                                </tr><tr>
                                                    <td><input type="hidden" id="bulan<?= $no['5']?>" value="<?= $bulan['6']?>">June</td>
                                                    <td><?= $selisih['6']?></td>
                                                    <td>
                                                    <a href="<?php echo base_url('RekapLppb/Input/searchRekap/'.$bulan['6'])?>" >
                                                    <button type="button" class="btn btn-xs btn-success">klik</button>
                                                    </a></td>
                                                </tr><tr>
                                                    <td><input type="hidden" id="bulan<?= $no['6']?>" value="<?= $bulan['5']?>">July</td>
                                                    <td><?= $selisih['5']?></td>
                                                    <td>
                                                    <a href="<?php echo base_url('RekapLppb/Input/searchRekap/'.$bulan['5'])?>" >
                                                    <button type="button" class="btn btn-xs btn-success">klik</button>
                                                    </a></td>
                                                </tr><tr>
                                                    <td><input type="hidden" id="bulan<?= $no['7']?>" value="<?= $bulan['4']?>">August</td>
                                                    <td><?= $selisih['4']?></td>
                                                    <td>
                                                    <a href="<?php echo base_url('RekapLppb/Input/searchRekap/'.$bulan['4'])?>" >
                                                    <button type="button" class="btn btn-xs btn-success">klik</button>
                                                    </a></td>
                                                </tr><tr>
                                                    <td><input type="hidden" id="bulan<?= $no['8']?>" value="<?= $bulan['3']?>">September</td>
                                                    <td><?= $selisih['3']?></td>
                                                    <td>
                                                    <a href="<?php echo base_url('RekapLppb/Input/searchRekap/'.$bulan['3'])?>" >
                                                    <button type="button" class="btn btn-xs btn-success">klik</button>
                                                    </a></td>
                                                </tr><tr>
                                                    <td><input type="hidden" id="bulan<?= $no['9']?>" value="<?= $bulan['2']?>">October</td>
                                                    <td><?= $selisih['2']?></td>
                                                    <td>
                                                    <a href="<?php echo base_url('RekapLppb/Input/searchRekap/'.$bulan['2'])?>" >
                                                    <button type="button" class="btn btn-xs btn-success">klik</button>
                                                    </a></td>
                                                </tr><tr>
                                                    <td><input type="hidden" id="bulan<?= $no['10']?>" value="<?= $bulan['1']?>">November</td>
                                                    <td><?= $selisih['1']?></td>
                                                    <td>
                                                    <a href="<?php echo base_url('RekapLppb/Input/searchRekap/'.$bulan['1'])?>" >
                                                    <button type="button" class="btn btn-xs btn-success">klik</button>
                                                    </a></td>
                                                </tr><tr>
                                                    <td><input type="hidden" id="bulan<?= $no['11']?>" value="<?= $bulan['0']?>">December</td>
                                                    <td><?= $selisih['0']?></td>
                                                    <td>
                                                    <a href="<?php echo base_url('RekapLppb/Input/searchRekap/'.$bulan['0'])?>" >
                                                    <button type="button" class="btn btn-xs btn-success">klik</button>
                                                    </a></td>
                                                </tr>
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
