<script src="<?php echo base_url('assets/plugins/dataTables/jquery.dataTables.js');?>"></script>
	<script src="<?php echo base_url('assets/plugins/dataTables/dataTables.bootstrap.js');?>"></script>
     <script>
            $(document).ready(function () {
            $('#myTable').dataTable({
                "scrollX": true,
            });
            $('.datepicktgl').datepicker({
                format: 'dd/mm/yyyy',
                todayHighlight: true,
                autoClose: true
            });
            
            });
    </script>


<section class="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-primary">
                            <div class="box-body">
                                <div class="col-md-12 text-center">
                                    <center><h2>LIHAT STOCK</h2></center>
                                </div>
                                <br><br><br>
                                <div class="panel-body">
                                    <div class="col-md-12">
                                        <div class="col-md-2">
                                            <label class="control-label">Periode :</label>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-group date">
                                                <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                                <input id="tglAwal" name="tglAwal[]" class="form-control pull-right datepicktgl" placeholder="tanggal awal" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                        <div class="input-group date">
                                                <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                            <input id="tglAkhir" class="form-control pull-right datepicktgl" placeholder="tanggal akhir" autocomplete="off">
                                            </div>
                                        </div>
                                    </div>
                                    <br><br>
                                    <div class="col-md-12">
                                        <div class="col-md-2">
                                            <label class="control-label">SubInventory :</label>
                                        </div>
                                        <div class="col-md-3">
                                            <select id="subinv" class="form-control subInvCode" data-placeholder="pilih subinventory" onchange="getKodeBrg(this)" style="width:100%">
                                                <option></option>
                                            </select>
                                        </div>
                                    </div>
                                    <br><br>
                                    <div class="col-md-12">
                                        <div class="col-md-2">
                                            <label class="control-label">Special Code :</label>
                                        </div>
                                        <div class="col-md-6">
                                            <select id="kodestockgdsp" class="form-control select2 kodestockgdsp" data-placeholder="masukkan kode / nama barang" style="width:100%">
                                                <option></option>
                                            </select>
                                        </div>
                                    </div>
                                    <br><br>
                                    <div class="col-md-12">
                                        <div class="col-md-2">
                                            <label class="control-label">Search Item :</label>
                                        </div>
                                        <div class="col-md-6">
                                            <input id="kode_awal" class="form-control pull-right" placeholder="masukan item" autocomplete="off">
                                        </div>
                                    </div>
                                    <br><br>
                                    <div class="col-md-12">
                                        <div class="col-md-2">
                                            <label class="control-label">Lokasi Simpan :</label>
                                        </div>
                                        <div class="col-md-6">
                                            <select id="lokasi_simpan" class="form-control select2 lokasi_simpan" data-placeholder="pilih lokasi simpan" style="width:100%">
                                                <option></option>
                                            </select>
                                        </div>
                                    </div>
                                    <br><br>
                                    <div class="col-md-12" id="kode_unit_ls">
                                        <div class="col-md-2">
                                            <label class="control-label">Kode Unit :</label>
                                        </div>
                                        <!-- <div class="col-md-3">
                                            <input type="text" id="kode_awal" class="form-control pull-right" placeholder="masukan kode awal">
                                        </div>
                                    </div>
                                    <br><br>
                                    <div class="col-md-12">
                                        <div class="col-md-2"></div> -->
                                        <div class="col-md-1">
                                            <?php for ($i=0; $i < 3; $i++) { 
                                                echo '<input type="hidden" id="unit'.$i.'" value="'.$kode[$i].'">
                                                <button type="button" class="btn btn-md btn-info" style="width:70px;height:70px;white-space: normal;" onclick="getLihatStock('.$i.', 123)">
                                                <span style="color:black;font-size:15px;font-weight:bold">'.$kode[$i].'</span></br><span style="color:white;font-size:10px;">'.$nama[$i].'</span></button><br><br>';
                                            }?>
                                        </div>
                                        <div class="col-md-1">
                                            <?php for ($i=3; $i < 6; $i++) { 
                                                echo '<input type="hidden" id="unit'.$i.'" value="'.$kode[$i].'">
                                                <button type="button" class="btn btn-md btn-info" style="width:70px;height:70px;white-space: normal;" onclick="getLihatStock('.$i.', 123)">
                                                <span style="color:black;font-size:15px;font-weight:bold">'.$kode[$i].'</span></br><span style="color:white;font-size:10px;">'.$nama[$i].'</span></button><br><br>';
                                            }?>
                                        </div>
                                        <div class="col-md-1">
                                            <?php for ($i=6; $i < 9; $i++) { 
                                                echo '<input type="hidden" id="unit'.$i.'" value="'.$kode[$i].'">
                                                <button type="button" class="btn btn-md btn-info" style="width:70px;height:70px;white-space: normal;" onclick="getLihatStock('.$i.', 123)">
                                                <span style="color:black;font-size:15px;font-weight:bold">'.$kode[$i].'</span></br><span style="color:white;font-size:10px;">'.$nama[$i].'</span></button><br><br>';
                                            }?>
                                        </div>
                                        <div class="col-md-1">
                                            <?php for ($i=9; $i < 12; $i++) { 
                                                echo '<input type="hidden" id="unit'.$i.'" value="'.$kode[$i].'">
                                                <button type="button" class="btn btn-md btn-info" style="width:70px;height:70px;white-space: normal;" onclick="getLihatStock('.$i.', 123)">
                                                <span style="color:black;font-size:15px;font-weight:bold">'.$kode[$i].'</span></br><span style="color:white;font-size:10px;">'.$nama[$i].'</span></button><br><br>';
                                            }?>
                                        </div>
                                        <div class="col-md-1">
                                            <?php for ($i=12; $i < 15; $i++) { 
                                                echo '<input type="hidden" id="unit'.$i.'" value="'.$kode[$i].'">
                                                <button type="button" class="btn btn-md btn-info" style="width:70px;height:70px;white-space: normal;" onclick="getLihatStock('.$i.', 123)">
                                                <span style="color:black;font-size:15px;font-weight:bold">'.$kode[$i].'</span></br><span style="color:white;font-size:10px;">'.$nama[$i].'</span></button><br><br>';
                                            }?>
                                        </div>
                                        <div class="col-md-1">
                                            <?php for ($i=15; $i < 18; $i++) { 
                                                echo '<input type="hidden" id="unit'.$i.'" value="'.$kode[$i].'">
                                                <button type="button" class="btn btn-md btn-info" style="width:70px;height:70px;white-space: normal;" onclick="getLihatStock('.$i.', 123)">
                                                <span style="color:black;font-size:15px;font-weight:bold">'.$kode[$i].'</span></br><span style="color:white;font-size:10px;">'.$nama[$i].'</span></button><br><br>';
                                            }?>
                                        </div>
                                        <div class="col-md-1">
                                            <?php for ($i=18; $i < 21; $i++) { 
                                                $warna = $i == 18 ? 'bg-black' : ($i == 19 ? 'bg-primary' : 'bg-orange');
                                                $warna2 = $i == 20 ? 'black' : 'white';
                                                echo '<input type="hidden" id="unit'.$i.'" value="'.$kode[$i].'">
                                                <button type="button" class="btn btn-md '.$warna.'" style="width:70px;height:70px;white-space: normal;" onclick="getLihatStock('.$i.', 123)">
                                                <span style="color:'.$warna2.';font-size:15px;font-weight:bold">'.$kode[$i].'</span></br><span style="color:white;font-size:10px;">'.$nama[$i].'</span></button><br><br>';
                                            }?>
                                        </div>
                                        <div class="col-md-1">
                                            <?php for ($i=21; $i < 24; $i++) { 
                                                $warna = $i == 21 ? 'bg-black' : ($i == 22 ? 'bg-primary' : 'bg-orange');
                                                $warna2 = $i == 23 ? 'black' : 'white';
                                                echo '<input type="hidden" id="unit'.$i.'" value="'.$kode[$i].'">
                                                <button type="button" class="btn btn-md '.$warna.'" style="width:70px;height:70px;white-space: normal;" onclick="getLihatStock('.$i.', 123)">
                                                <span style="color:'.$warna2.';font-size:15px;font-weight:bold">'.$kode[$i].'</span></br><span style="color:white;font-size:10px;">'.$nama[$i].'</span></button><br><br>';
                                            }?>
                                        </div>
                                        <div class="col-md-1">
                                            <?php for ($i=24; $i < 27; $i++) { 
                                                $warna = $i != 26 ? 'btn-success' : 'btn-danger';
                                                echo '<input type="hidden" id="unit'.$i.'" value="'.$kode[$i].'">
                                                <button type="button" class="btn btn-md '.$warna.'" style="width:70px;height:70px;white-space: normal;" onclick="getLihatStock('.$i.', 123)">
                                                <span style="color:'.$warna2.';font-size:15px;font-weight:bold">'.$kode[$i].'</span></br><span style="color:white;font-size:10px;">'.$nama[$i].'</span></button><br><br>';
                                            }?>
                                        </div>
                                    <br><br><br><br><br><br><br><br>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-2">
                                            <label class="control-label">Quantity Diatas :</label>
                                        </div>
                                        <div class="col-md-3">
                                            <input type="number" id="qty_atas" class="form-control pull-right" placeholder="qty atas" autocomplete="off">
                                        </div>
                                    </div>
                                    <br><br>
                                    <div class="col-md-12">
                                        <div class="col-md-2">
                                            <label class="control-label">Quantity Dibawah :</label>
                                        </div>
                                        <div class="col-md-3">
                                            <input type="number" id="qty_bawah" class="form-control pull-right" placeholder="qty bawah" autocomplete="off">
                                        </div>
                                    </div>
                                    <br><br><br>
                                    <div class="col-md-12" style="padding-top:10px">
                                        <div class="col-md-2">
                                            <label class="control-label">Min Max :</label>
                                        </div>
                                        <div class="col-md-3">
                                            <button class="btn btn-lg btn-danger" onclick="getLihatStock('', 'min')">MIN</button>
                                            <button class="btn btn-lg bg-teal" style="margin-left:10px" onclick="getLihatStock('', 'max')">MAX</button>
                                        </div>
                                    </div>
                                    <br><br>
                                    <div class="col-md-12 text-center">
                                            <button type="button" class="btn btn-lg btn-success" onclick="getLihatStock('', 'sch')">Search</button>
                                    </div>
                                </div>
                                
                                <div class="panel-body">
                                    <div class="table-responsive" id="tb_lihatstock">
                                        
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


