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
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('TicketingMaintenance/Seksi/NewOrder'); ?>">
                                    <i class="fa fa-ticket fa-2x">
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
                <!-- Input Form -->
                <div class="row">
                        <div class="col-lg-12">
                            <div class="box box-primary box-solid">
                                <div class="box-header with-border">
                                    <b>Edit Data Order</b>
                                </div>
                                        <?php
                                        // echo "<pre>";
                                        // print_r ($getSeksiUnit);
                                        // exit(); 
                                        foreach ($getSeksiUnit as $key) {
                                            $seksi = $key['seksi'];
                                            $unit = $key['unit'];
                                            }			
                                        ?>
                                        <div class="box-body">
                                            <div class="panel-body">
                                                <div class="col-lg-2"></div>
                                                <div class="col-lg-7">
                                            <?php foreach ($getOrderData as $order) {
                                                $no_order = $order['no_order'];
                                                $nomor_mesin = $order['nomor_mesin'];
                                                $nama_mesin = $order['nama_mesin'];
                                                $line = $order['line'];
                                                $kerusakan = $order['kerusakan'];
                                                $kondisi_mesin = $order['kondisi_mesin'];
                                                $running_hour = $order['running_hour'];
                                                $need_by_date = $order['need_by_date'];
                                                $reason_need_by_date = $order['reason_need_by_date'];
                                        }?>
                                        <form enctype="multipart/form-data" autocomplete="off" action="<?php echo site_url('TicketingMaintenance/Seksi/NewOrder/saveEditOrder/'.$no_order); ?>" method="post">
                                            <div class="form-group">
                                                <label for="seksi" class="control-label">Seksi</label>
                                                <input type="text" name="seksi" id="seksi" class="form-control seksi" value='<?php echo $seksi ?>' readonly/>
                                            </div> <br />
                                            <div class="form-group">    
                                                <label for="unit" class="control-label">Unit</label>
                                                <input type="text" name="unit" id="unit" class="form-control unit" value='<?php echo $unit ?>' readonly/>
                                            </div> <br />
                                            <div class="form-group">
                                            <div class="form-group">
                                                <label for="nomor_mesin" class="control-label">Nomor Mesin</label>
                                                <input type="text" placeholder="Input Nomor Mesin" name="txtNoMesin" id="txtNoMesinEdit" class="form-control noMesinEdit" value='<?php echo $nomor_mesin ?>' required/>
                                            </div> <br />
                                                <label for="nama_mesin" class="control-label">Nama Mesin</label>
												<textarea type="text" style="height: 35px; text-align:left;" placeholder="Input Jenis Mesin" name="txtJenisMesin" id="jenisMesin" class="form-control jenisMesin">
                                                    <?php echo $nama_mesin?>
                                                </textarea>
                                            </div> <br />
                                            <div class="form-group">
                                                <label for="line" class="control-label">Line</label>
                                                <input type="text" name="line" class="form-control" value="<?php echo $line?>" placeholder="Input Line" id="line" required>
                                            </div> <br />
                                            <div class="form-group">
                                                <label for="kerusakan" class="control-label">Kerusakan</label>
                                                <textarea name="kerusakan" class="form-control" style="text-align:left;" placeholder="Input Kerusakan" id="kerusakan" rows="6" required>
                                                    <?php echo $kerusakan?>
                                                </textarea>
                                            </div> <br />
                                            <div class="form-group">
                                                <label for="kondisi" class="control-label">Kondisi Mesin Saat Order</label> <br >
                                                <select name="kondisi" id="kondisi" class="form-control" required>
                                                    <?php echo '<option value="'.$kondisi_mesin.'" selected>'.$kondisi_mesin.'</option>'; ?>
                                                    <option value="Mesin Jalan">Mesin Jalan</option>
                                                    <option value="Mesin Berhenti">Mesin Berhenti</option>
                                                </select>
                                            </div> <br />
                                            <div class="form-group">
                                                <label for="need_you" class="control-label">Running Hour</label>
                                                <input type="number" name="runningHour" value="<?php echo $running_hour?>" class="form-control runningHour" placeholder="Input Running Hour" id="need_you" required>
                                            </div> <br />
                                            <div class="form-group">
                                                <label for="need_you" class="control-label">Need by Date</label>
                                                <input type="text" name="need_you" value="<?php echo $need_by_date?>" class="form-control time-form1 ajaxOnChange" placeholder="Input Need by Date" id="need_you" required>
                                            </div> <br />
                                            <div class="form-group">
                                                <label for="your_reason" class="control-label">Reason Need by Date</label>
                                                <input type="text" name="your_reason" class="form-control" value="<?php echo $reason_need_by_date?>" placeholder="Input Reason Need by Date" id="your_reason" required>
                                            </div> <br />
                                        </div>
                                        <div class="col-lg-3"></div>
                                    </div>
                                    <div class="panel-footer">
                                        <div class="row text-right" style="margin:1px;">
                                            <button type="submit" class="btn btn-success btn-lg"><i class="fa fa-save"></i></i>  Save</button>
                                            <a href="<?php echo site_url('TicketingMaintenance/Seksi'); ?>" class="btn btn-danger btn-lg"><i class="fa fa-arrow-left"></i></i>  Back</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>