<script src="<?php echo base_url('assets/plugins/dataTables/jquery.dataTables.js');?>"></script>
	<script src="<?php echo base_url('assets/plugins/dataTables/dataTables.bootstrap.js');?>"></script>
     <script>
         $(document).ready(function () {
            // $('.datepickTanggal').datepicker({
            //     autoclose: true,
            //     todayHighlight: true,
            //     dateFormat: 'dd/mm/yyyy',
            // });
            $('.datepickBulan').datepicker({
                format: 'dd-M-yyyy',
                todayHighlight: true,
                // viewMode: "months",
                // minViewMode: "months",
                autoClose: true
            });
            // $('.tblRkapLppb').dataTable({
            //     "scrollX": true,
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
                                    href="<?php echo site_url('RekapLppb/History/');?>">
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
                            <div class="box-header with-border"><b>History</b></div>
                            <div class="box-body">
                                <div class="panel-body">
                                    <div class="col-md-3">
                                        <input id="tgl" name="tgl" class="form-control pull-right datepickBulan" placeholder="Tanggal Recipt" >
                                    </div>
                                    <div class="col-md-3">
                                        <select class="form-control select2" data-placeholder="Item" id="item_history" name="item_history">
                                        <option></option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <select class="form-control select2" data-placeholder="Deskripsi" id="desc_history" name="desc_history">
                                        <option></option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="input-group">
                                        <select id="id_org" name="id_org" class="form-control select2" data-placeholder="Pilih IO">
                                        <option></option>
                                        </select>
                                        <span class="input-group-btn">
                                            <button type="button" onclick="schHistoryLppb(this)" class="btn btn-flat" style="background:inherit; text-align:left;padding:0px;padding-left:10px;"><i class="fa fa-2x fa-arrow-circle-right" ></i></button>    
                                        </span>
                                        </div>
                                    </div>
                                </div>

                                    <div class="panel-body">
                                        <div class="table-responsive"  id="tb_historyLppb">
                                        <!-- <table class="table table-striped table-bordered table-responsive table-hover text-left tblRkapLppb" style="font-size:14px;"> -->
                                            
                                        <!-- </table> -->
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
