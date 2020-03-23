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
                                    <b style="margin-right:600px; margin-left:50px;"><?= 'No Order : '.$id[0]['no_order']?></b>
                                    <b>Input Form Keterlambatan</b>
                                </div>
                                <div class="box-body">
                                <form autocomplete="off" action="<?= base_url('TicketingMaintenance/Agent/OrderList/save_keterlambatan/'.$id[0]['no_order']); ?>" method="post">
                                    <div class="row">
                                        <div class="col-lg-2"></div>
                                        <div class="col-lg-7">
                                            <input type="hidden" name="no_order" value="<?= $id[0]['no_order'] ?>"> <br />
                                            <?php foreach ($selectOrder as $so) {
                                                // echo "<pre>"; print_r($so);
                                                $tgl_perkiraan_selesai = $so['perkiraan_selesai'];
                                                $date_selesai = strtotime($tgl_perkiraan_selesai);
                                                $tgl_order_diterima = $so['tgl_order_diterima'];
                                                $date_terima = strtotime($tgl_order_diterima);
                                                // echo "<pre>";print_r($date_selesai);
                                                // echo "<pre>";print_r($date_terima);
                                                // $diff = abs($date_selesai - $date_terima);
                                                // $years = floor($diff / (365*60*60*24));  
                                                // $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));  
                                                // $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24)); 
                                                $tgl_pengurangan = ceil(($date_selesai - $date_terima)/60/60/24);// == <seconds between the two times>
                                                // $days = $secs / 86400;  
                                                // $tgl_pengurangan = $days;
                                                // echo "<pre>";print_r($tgl_pengurangan);
                                                // echo "<pre>";print_r($secs);
                                            } ?>
                                            <?php foreach ($selectLate as $telat) {
                                                if ($telat == null) {
                                                    # code...
                                                }else{
                                                    $tgl_selesai = $telat['waktu_selesai'];
                                                    $selesai = explode(" ", $tgl_selesai);
                                                    $tanggal = $selesai[0];
                                                    // echo $tanggal;
                                                }
                                            }?>
                                            <div class="form-group">
                                                <input type="hidden" value="<?php echo $tgl_pengurangan;?>" name="tanggalPengurangan" class="form-control">
                                                <label for="alasan" class="control-label">Alasan Keterlambatan</label>
                                                <select name="alasan" id="alasan" class="form-control" required>
                                                    <option value="" selected>== Alasan Keterlambatan ==</option>
                                                    <option value="Menunggu Spare Part">Menunggu Spare Part</option>
                                                    <option value="Menunggu Machining Part">Menunggu Machining Part</option>
                                                    <option value="Menunggu Instruksi">Menunggu Instruksi</option>
                                                </select>
                                            </div> <br />
                                            <div class="form-group">
                                                <label for="waktu_mulai" class="control-label">Tanggal Mulai</label>
                                                <input type="text" name="tanggalMulai" class="form-control time-form" placeholder="1999/12/31 23:59:59" required>
                                            </div> <br />
                                            <div class="form-group">
                                                <label for="waktu_selesai" class="control-label">Tanggal Selesai</label>
                                                <input type="text" name="tanggalSelesai" class="form-control time-form" placeholder="1999/12/31 23:59:59" required>
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
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>