<style type="text/css">

.jamMulai::-webkit-datetime-edit-ampm-field {
   display: none;
 }

.jamSelesai::-webkit-datetime-edit-ampm-field {
display: none;
}
 input[type=time]::-webkit-clear-button {
   -webkit-appearance: none;
   -moz-appearance: none;
   -o-appearance: none;
   -ms-appearance:none;
   appearance: none;
   margin: -10px; 
 }

</style>

<section class="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-11">
                            <div class="text-right">
                                <h1><b><?= $Title ?></b></h1>
                            </div>
                        </div>
                        <div class="col-lg-1">
                            <div class="text-right hidden-md hidden-sm hidden-xs">
                                <a class="btn btn-default btn-lg" href="<?= base_url('TicketingMaintenance/Agent/OrderList/detail/'.$id[0]['no_order']); ?>">
                                    <i class="fa fa-ticket fa-2x"></i>
                                    <br />
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <br />
                <div class="col-lg-12">
                    <div class="row">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border">
                                <b style="margin-right:700px; margin-left:50px;"><?= 'No Order : '.$id[0]['no_order']?></b>
                                <b>Input Form Reparasi</b>
                            </div>
                            <div class="box-body">
                                <div class="row">
                                <form autocomplete="off" action="<?= base_url('TicketingMaintenance/Agent/OrderList/saveReparasi/'.$id[0]['no_order']); ?>" method="post">
                                    <div class="col-lg-2"></div>
                                    <div class="col-lg-7">
                                            <input type="hidden" name="no_order" value="<?= $id[0]['no_order'] ?>"> <br />
                                            <div class="form-group">
                                                <label for="waktu_mulai" class="control-label">Pelaksana</label>
                                                <!-- <input type="text" name="pelaksana" class="form-control time-form" id="pelaksanaReparasi" placeholder="Input Pelaksana Reparasi" required> -->
                                                <select class="form-control select2" id="pelaksanaReparasi" name="pelaksana[]" data-placeholder="Input Pelaksana Reparasi" required multiple></select>
                                            </div> <br />
                                            <div class="form-group">
                                                <label for="waktu_mulai" class="control-label">Tanggal</label>
                                                <input type="text" name="tanggal" class="form-control time-form1 ajaxOnChange" placeholder="Input Tanggal" required>
                                            </div> <br />
                                            <!-- <div class="form-group bootstrap-timepicker timepicker"> -->
                                            <div class="form-group">
                                                <label for="waktu_mulai" class="control-label">Jam Mulai</label>
                                                <!-- <input type="text" name="jamMulai" class="form-control input-small jamMulai" id="txtJamMulai" placeholder="Input Jam Mulai" required> -->
                                                <!-- <input type="time" name="jamMulai" class="form-control jamMulai" id="txtJamMulai" placeholder="Input Jam Mulai" required> -->
                                                <!-- <input id="jamAkhirMPBG" name="jamAkhirMPBG" type="text" class="form-control input-small jamAkhirMPBG"> -->
                                                    <!-- <span class="input-group-addon">
                                                        <i class="glyphicon glyphicon-time"></i>
                                                    </span> -->
                                                    <input autocomplete="off" value="00:00" class="form-control" id="txtJamMulai" placeholder="Input Jam Mulai" style="font-size: 15px; line-height: 15px; border: 1px solid #dddddd; position: relative;" name="jamMulai" >
                                            </div> <br />
                                            <!-- <div class="form-group bootstrap-timepicker timepicker"> -->
                                            <div class="form-group">
                                                <label for="waktu_selesai" class="control-label">Jam Selesai</label>
                                                <input autocomplete="off" value="00:00" class="form-control" id="txtJamSelesai" placeholder="Input Jam Selesai" style="font-size: 15px; line-height: 15px; border: 1px solid #dddddd; position: relative;" name="jamSelesai" >
                                                <!-- <input type="time" name="jamSelesai" class="form-control jamSelesai" id="txtJamSelesai" placeholder="Input Jam Selesai" required> -->
                                            </div> <br />
                                        </div>
                                        <div class="col-lg-3"></div>
                                    </div>
                                </div>
                                <div class="box-footer">
                                    <div class="row text-right" style="margin:1px;">
                                        <button type="submit" class="btn btn-success btn-lg"><i class="fa fa-save"></i></i>  Save</button>
                                        <a href="<?php echo site_url('TicketingMaintenance/Agent/OrderList/detail/'.$id[0]['no_order']); ?>" class="btn btn-danger btn-lg"><i class="fa fa-arrow-left"></i></i>  Back</a>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>