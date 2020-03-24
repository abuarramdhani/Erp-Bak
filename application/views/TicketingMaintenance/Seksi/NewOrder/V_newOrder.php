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
                    <form enctype="multipart/form-data" autocomplete="off" action="<?php echo site_url('TicketingMaintenance/Seksi/NewOrder/create'); ?>" method="post">
                        <div class="col-lg-12">
                            <div class="box box-primary box-solid">
                                <div class="box-header with-border">
                                    <b>Create New Order</b>
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
                                            <div class="form-group">
                                                <label for="seksi" class="control-label">Seksi</label>
                                                <input type="text" name="seksi" id="seksi" class="form-control seksi" value='<?php echo $seksi ?>' readonly/>
                                                <!-- <select name="seksi" id="seksi" class="form-control" required>
                                                    <option value="seksi1">seksi1</option>
                                                    <option value="seksi2">seksi2</option>
                                                    <option value="seksi3">seksi3</option>
                                                </select> -->
                                            </div> <br />
                                            <div class="form-group">    
                                                <label for="unit" class="control-label">Unit</label>
                                                <input type="text" name="unit" id="unit" class="form-control unit" value='<?php echo $unit ?>' readonly/>
                                                <!-- <select name="unit" id="unit" class="form-control" required>
                                                    <option value="unit1">unit1</option>
                                                    <option value="unit2">unit2</option>
                                                </select> -->
                                            </div> <br />
                                            <div class="form-group">
                                            <div class="form-group">
                                                <label for="nomor_mesin" class="control-label">Nomor Mesin</label>
                                                <!-- <input type="text" name="nomor_mesin" class="form-control" placeholder="Input Nomor Mesin"  id="nomor_mesin" required> -->
                                                <select style="height: 35px;" class="form-control select2 noMesin" id="txtNoMesin" name="txtNoMesin" data-placeholder="Input Nomor Mesin" tabindex="-1" aria-hidden="true" required>
												</select>
                                            </div> <br />
                                                <label for="nama_mesin" class="control-label">Nama Mesin</label>
                                                <!-- <select name="nama_mesin" id="nama_mesin" data-placeholder="Nomor Mesin" class="form-control" required>
                                                    <option value="nama_mesin1">nama_mesin1</option>
                                                    <option value="nama_mesin2">nama_mesin2</option>
                                                </select> -->
												<textarea type="text" style="height: 35px;" placeholder="Input Jenis Mesin" name="txtJenisMesin" id="jenisMesin" class="form-control jenisMesin" readonly></textarea>
                                            </div> <br />
                                            <div class="form-group">
                                                <label for="line" class="control-label">Line</label>
                                                <input type="text" name="line" class="form-control" placeholder="Input Line" id="line" required>
                                            </div> <br />
                                            <div class="form-group">
                                                <label for="kerusakan" class="control-label">Kerusakan</label>
                                                <textarea name="kerusakan" class="form-control" placeholder="Input Kerusakan" id="kerusakan" rows="6" required></textarea>
                                            </div> <br />
                                            <div class="form-group">
                                                <label for="kondisi" class="control-label">Kondisi Mesin Saat Order</label> <br >
                                                <select name="kondisi" id="kondisi" class="form-control" required>
                                                    <option value="Mesin Jalan">Mesin Jalan</option>
                                                    <option value="Mesin Berhenti">Mesin Berhenti</option>
                                                </select>
                                            </div> <br />
                                            <div class="form-group">
                                                <label for="need_you" class="control-label">Running Hour</label>
                                                <input type="number" name="runningHour" class="form-control runningHour" placeholder="Input Running Hour" id="need_you" required>
                                            </div> <br />
                                            <div class="form-group">
                                                <label for="need_you" class="control-label">Need by Date</label>
                                                <input type="text" name="need_you" class="form-control time-form1 ajaxOnChange" placeholder="Input Need by Date" id="need_youD" required>
                                            </div> <br />
                                            <div class="form-group">
                                                <label for="your_reason" class="control-label">Reason Need by Date</label>
                                                <input type="text" name="your_reason" class="form-control" placeholder="Input Reason Need by Date" id="your_reason" required>
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