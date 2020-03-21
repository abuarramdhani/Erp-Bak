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
                                            <?php for ($i=0; $i < 7; $i++) { 
                                                echo '<input type="radio" name="unit" value="'.$unit[$i]['UNIT'].'">'.$unit[$i]['UNIT'].'<br>';
                                            }?>
                                        </div>
                                        <div class="col-md-1">
                                            <?php for ($i=7; $i < 14; $i++) { 
                                                echo '<input type="radio" name="unit" value="'.$unit[$i]['UNIT'].'">'.$unit[$i]['UNIT'].'<br>';
                                            }?>
                                        </div>
                                        <div class="col-md-1">
                                            <?php for ($i=14; $i < 21; $i++) { 
                                                echo '<input type="radio" name="unit" value="'.$unit[$i]['UNIT'].'">'.$unit[$i]['UNIT'].'<br>';
                                            }?>
                                        </div>
                                        <div class="col-md-1">
                                            <?php for ($i=21; $i < 28; $i++) { 
                                                echo '<input type="radio" name="unit" value="'.$unit[$i]['UNIT'].'">'.$unit[$i]['UNIT'].'<br>';
                                            }?>
                                        </div>
                                        <div class="col-md-1">
                                            <?php for ($i=28; $i < 35; $i++) { 
                                                echo '<input type="radio" name="unit" value="'.$unit[$i]['UNIT'].'">'.$unit[$i]['UNIT'].'<br>';
                                            }?>
                                        </div>
                                        <div class="col-md-1">
                                            <?php for ($i=35; $i < 42; $i++) { 
                                                echo '<input type="radio" name="unit" value="'.$unit[$i]['UNIT'].'">'.$unit[$i]['UNIT'].'<br>';
                                            }?>
                                        </div>
                                        <div class="col-md-1">
                                            <?php for ($i=42; $i < 49; $i++) { 
                                                echo '<input type="radio" name="unit" value="'.$unit[$i]['UNIT'].'">'.$unit[$i]['UNIT'].'<br>';
                                            }?>
                                        </div>
                                    </div>
                                    <br><br><br><br><br><br><br><br>
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
                                    <br><br>
                                    <div class="col-md-12 text-center">
                                            <button type="button" class="btn btn-success" onclick="getLihatStock(this)">Search</button>
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


