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
                                    <center><h2>LIHAT TRANSACT</h2></center>
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
                                            <label class="control-label">Kode Barang :</label>
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text" id="kode_awal" class="form-control pull-right" placeholder="masukan kode awal">
                                        </div>
                                    </div>
                                    <br><br>
                                    <div class="col-md-12 text-center">
                                            <button type="button" class="btn btn-success" onclick="getLihatTransact(this)">Search</button>
                                    </div>
                                </div>
                                
                                <div class="panel-body">
                                    <div class="table-responsive" id="tb_lihattransact">
                                        
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


