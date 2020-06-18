
<style type="text/css">

/* #SearchRangeOrder {
    border-radius: 25px; 
} */

/* #rangeAwal {
    border-radius: 25px; 
}

#rangeAkhir {
    border-radius: 25px; 
} */

</style>
</head>

<body>
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
                                    REKAP ORDER
                                 </b>
                             </h1>
                         </div>
                     </div>
                     <div class="col-lg-1 ">
                        <div class="text-right hidden-md hidden-sm hidden-xs">
                            <a class="btn btn-default btn-lg" href="">
                                <i aria-hidden="true" class="fa fa-ticket fa-2x">
                                </i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="box box-primary box-solid">
                        <div class="box-header with-border">
                           Rekap Order Perbaikan dan Perawatan Mesin (OPPM)
                       </div>
                       <br>
                       <div class="box-body">
                        <form autocomplete="off" action="<?= base_url('TicketingMaintenance/Agent/selectRekapOPPM'); ?>" method="post">
                            <div class="row">
                                <div class="col-md-12" style="padding-top: 10px">
                                <?php
                                    if ($jenisParameter == 'FilterRangeTanggal') {
                                            foreach ($hasilRekapData as $key) {
                                                $tgl_awal = $key['tanggal_awal'];
                                                $tgl_akhir = $key['tanggal_akhir'];
                                            }  
                                    }elseif ($jenisParameter == 'FilterMesin' || $jenisParameter == 'FilterSeksi') {
                                        $tgl_awal = NULL;
                                        $tgl_akhir = NULL;
                                    }
                                ?>
                                <div class="col-md-3 " style="text-align: left;">
                                    <label>PARAMETER REKAP</label>
                                </div>
                                <div class="col-lg-12 text-left" style="margin-bottom : 20px">
                                    <input type="radio" name="filterRekap" value="FilterMesin" <?php if ($jenisParameter == 'FilterMesin') { echo "checked"; }?>> <label for="norm" class="control-label">&nbsp;&nbsp;Mesin </label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<input type="radio" name="filterRekap" value="FilterSeksi" <?php if ($jenisParameter == 'FilterSeksi') { echo "checked"; }?>><label for="norm" class="control-label">&nbsp;&nbsp; Seksi</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<input type="radio" name="filterRekap" value="FilterRangeTanggal" <?php if ($jenisParameter == 'FilterRangeTanggal') { echo "checked"; }?>><label for="norm" class="control-label">&nbsp;&nbsp; Range Tanggal </label>
                                </div>
                            <!--filter by mesin-->
                            <div class="row filterMesin" style="<?php if ($jenisParameter !== 'FilterMesin') { echo "display:none"; }?>">
                                 <div class="row">
                                    <div class="col-md-12 " style="text-align: center;margin-top: -35px;">
                                        <label><H3><b>FILTER</b></H3></label>
                                    </div>
                                </div>
                                <div class="row" style="margin-bottom: 5px;">
                                        <div class="col-lg-2"></div>
                                        <div class="col-lg-3" style="text-align: center;">
                                            <label>Mesin</label>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
												<select style="height: 35px; width:350px;" class="form-control select2" id="parMesin" name="txtParMesin[]" data-placeholder="Pilih Nama Mesin" tabindex="-1" aria-hidden="true" multiple>
                                                    <?php 
                                                        $listNoMesin = explode("$", $namaMesin);
                                                        foreach ($listNoMesin as $nm) {
                                                            echo '<option value="'.$nm.'" selected>'.$nm.'</option>';
                                                        }
												    ?>
												</select>
                                            </div>
                                        </div>
                                    </div>
                            <div style="text-align: center;">
                                <button type="submit" class="btn btn-success" id="SearchRangeOrderMesin">
                                    <span class="fa fa-search" style="padding-right: 5px;padding-top: 5px;padding-left: 5px;padding-bottom: 5px;"></span> SEARCH
                                </button><p>
                                    <span style="height: 50px"></span>
                                </p>
                            </div>
                        </div>
                        <!--filter by mesin-->

                        <!--filter by seksi-->
                            <div class="row filterSeksi" style="<?php if ($jenisParameter !== 'FilterSeksi') { echo "display:none"; }?>">
                                 <div class="row">
                                    <div class="col-md-12 " style="text-align: center;margin-top: -35px;">
                                        <label><H3><b>FILTER</b></H3></label>
                                    </div>
                                </div>
                                <div class="row" style="margin-bottom: 5px;">
                                        <div class="col-lg-2"></div>
                                        <div class="col-lg-3" style="text-align: center;">
                                            <label>Seksi</label>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
												<select style="height: 35px; width: 350px;" class="form-control select2" id="parSeksi" name="txtParSeksi" data-placeholder="Pilih Seksi" tabindex="-1" aria-hidden="true">
                                                    <?php
                                                    $listSeksi[] = $namaSeksi;
                                                    foreach ($listSeksi as $sk) {
                                                            echo '<option value="'.$sk.'" selected>'.$sk.'</option>';
                                                        }
												    ?>
												</select>
                                            </div>
                                        </div>
                                    </div>
                            <div style="text-align: center;">
                                <button type="submit" class="btn btn-success" id="SearchRangeOrderSeksi">
                                    <span class="fa fa-search" style="padding-right: 5px;padding-top: 5px;padding-left: 5px;padding-bottom: 5px;"></span> SEARCH
                                </button><p>
                                    <span style="height: 50px"></span>
                                </p>
                            </div>
                        </div>
                        <!--filter by seksi-->

                        <!--filter by date range-->
                            <div class="row filterRange" style="<?php if ($jenisParameter !== 'FilterRangeTanggal') { echo "display:none"; }?>">
                                 <div class="row">
                                    <div class="col-md-12 " style="text-align: center;margin-top: -35px;">
                                        <label><H3><b>FILTER</b></H3></label>
                                    </div>
                                </div>
                                <div class="row" style="margin-bottom: 5px;">
                                        <div class="col-md-3 " style="text-align: right;margin-left: 30px;">
                                            <label>Input Range Tanggal</label>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <input type="text" value="<?php echo $tgl_awal;?>" name="txtRangeAwal" id="rangeAwal" class="form-control datepicker" style="padding-left: 12px;width: 300px" placeholder="Pilih Tanggal Awal"  />
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group" style="padding-left: 40px">
                                                <input type="text" value="<?php echo $tgl_akhir;?>" name="txtRangeAkhir" id="rangeAkhir" class="form-control datepicker" style="padding-left: 12px;width: 300px;" placeholder="Pilih Tanggal Akhir" >
                                            </div>
                                        </div>
                                    </div>
                            <div style="text-align: center;">
                                <button type="submit" class="btn btn-success" id="SearchRangeOrder">
                                    <span class="fa fa-search" style="padding-right: 5px;padding-top: 5px;padding-left: 5px;padding-bottom: 5px;"></span> SEARCH
                                </button><p>
                                    <span style="height: 50px"></span>
                                </p>
                            </div>
                        </div>
                        <!--filter by date range-->
                            <br>
                            <!--TABEL REKAP OPPM-->
								<table class="datatable table table-striped table-bordered table-hover text-left" id="tblOrderListAgent" style="">
									<thead class="bg-primary">
										<tr>
											<th style="text-align:center" width="5%"  class="text-center">No.</th>
											<th style="text-align:center" width="30%" class="text-center">Nama Mesin</th>
											<th style="text-align:center" width="10%" class="text-center">Jumlah Order</th>
											<th style="text-align:center" width="25%" class="text-center">Seksi</th>
											<th style="text-align:center" width="15%" class="text-center">MTTR <br> (JAM)</th>
											<th style="text-align:center" width="15%" class="text-center">MTBF <br> (JAM)</th>
										</tr>
									</thead>
									<tbody>
                                        <?php $no=1;
                                        if ($jenisParameter == 'FilterMesin') {
                                            foreach ($hasilRekapDataByMesin as $rekapMesin) {
                                                if ($rekapMesin == null) {
                                                    echo "Tidak Ada Hasil Rekap Order";
                                                }else{
                                                    $nama_mesin = $rekapMesin['machine_name'];
                                                    $jumlah_order = $rekapMesin['total_machine'];
                                                    $seksi = $rekapMesin['section'];
                                                    $mttr = $rekapMesin['sum'];
                                                    $mtbr = $rekapMesin['end_result'];
                                            ?>
                                                <tr>
                                                    <td class="text-center"><?php echo $no?></td>
                                                    <td class="text-left"><?php echo $nama_mesin?></td>
                                                    <td class="text-center"><?php echo $jumlah_order?></td>
                                                    <td class="text-left"><?php echo $seksi?></td>
                                                    <td class="text-center"><?php echo $mttr?></td>
                                                    <td class="text-center"><?php echo $mtbr?></td>
                                                </tr>
                                            <?php } $no++; } 
                                        }elseif ($jenisParameter == 'FilterSeksi') {
                                            foreach ($hasilRekapDataBySeksi as $rekapSeksi) {
                                                if ($rekapSeksi == null) {
                                                    echo "Tidak Ada Hasil Rekap Order";
                                                }else{
                                                    $nama_mesin = $rekapSeksi['machine_name'];
                                                    $jumlah_order = $rekapSeksi['total_machine'];
                                                    $seksi = $rekapSeksi['section'];
                                                    $mttr = $rekapSeksi['sum'];
                                                    $mtbr = $rekapSeksi['end_result'];
                                            ?>
                                                <tr>
                                                    <td class="text-center"><?php echo $no?></td>
                                                    <td class="text-left"><?php echo $nama_mesin?></td>
                                                    <td class="text-center"><?php echo $jumlah_order?></td>
                                                    <td class="text-left"><?php echo $seksi?></td>
                                                    <td class="text-center"><?php echo $mttr?></td>
                                                    <td class="text-center"><?php echo $mtbr?></td>
                                                </tr>
                                            <?php } $no++; } 
                                        }else {
                                            foreach ($hasilRekapData as $rekapTanggal) {
                                                if ($rekapTanggal == null) {
                                                    echo "Tidak Ada Hasil Rekap Order";
                                                }else{
                                                    $nama_mesin = $rekapTanggal['machine_name'];
                                                    $jumlah_order = $rekapTanggal['total_machine'];
                                                    $seksi = $rekapTanggal['section'];
                                                    $mttr = $rekapTanggal['sum'];
                                                    $mtbr = $rekapTanggal['end_result'];
                                            ?>
                                                <tr>
                                                    <td class="text-center"><?php echo $no?></td>
                                                    <td class="text-left"><?php echo $nama_mesin?></td>
                                                    <td class="text-center"><?php echo $jumlah_order?></td>
                                                    <td class="text-left"><?php echo $seksi?></td>
                                                    <td class="text-center"><?php echo $mttr?></td>
                                                    <td class="text-center"><?php echo $mtbr?></td>
                                                </tr>
                                            <?php } $no++; } }?>
									</tbody>
								</table>
                            </div>
                        </div>
                    </div>
</section>