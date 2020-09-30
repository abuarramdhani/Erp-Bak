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
                        <div class="box box-solid">
                            <div class="box-body">
                                <div class="col-md-12">
                                    <h2><i class="fa fa-car" style="font-size:35px"></i> Monitoring Item Intarnsit</h2>
                                </div>
                                <br><br><br>
                                <div class="panel-body box box-warning">
                                <br>
                                    <!-- <div class="col-md-12">
                                        <div class="col-md-1"></div>
                                        <div class="col-md-2 text-right">
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
                                    <br><br> -->
                                    <div class="col-md-12">
                                        <div class="col-md-4 text-right">
                                            <label class="control-label">Parameter:</label>
                                        </div>
                                        <div class="col-md-3">
                                            <select id="param" class="form-control select2" data-placeholder="pilih parameter" style="width:100%">
                                                <option></option>
                                                <option value="from">From SP-YSP</option>
                                                <option value="to">To SP-YSP</option>
                                            </select>
                                        </div>
                                    <!-- </div>
                                    <br><br> -->
                                    <div class="col-md-1">
                                            <button type="button" class="btn btn-success" onclick="getItemIntransit(this)">Search</button>
                                    </div>
                                    <br><br><br><br>
                                    <div class="col-md-12">
                                        <div class="table-responsive" id="tb_itemintransit"></div>
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


