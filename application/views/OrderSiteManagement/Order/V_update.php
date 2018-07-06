<section class="content">
    <div class="inner" >
        <div class="row">
            <form method="post" action="<?php echo site_url('SafetyManagement/Order/update/'.$id);?>" class="form-horizontal">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-11">
                                <div class="text-right"><h1><b><?= $Title ?></b></h1></div>
                            </div>
                            <div class="col-lg-1 ">
                                <div class="text-right hidden-md hidden-sm hidden-xs">
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('SafetyManagement/Order/');?>">
                                        <i class="icon-wrench icon-2x"></i>
                                        <span ><br /></span>
                                    </a>                             
                                </div>
                            </div>
                        </div>
                    </div>
                    <br />
                
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="box box-primary box-solid">
                                <div class="box-header with-border">Update Order</div>
                                <?php
                                    foreach ($Order as $headerRow):
                                ?>
                                <div class="box-body">
                                    <div class="panel-body">
                                        <div class="row">
											<div class="form-group">
                                                <label for="txtNoOrderHeader" class="control-label col-lg-4">No Order</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="No Order" name="txtNoOrderHeader" id="txtNoOrderHeader" class="form-control" value="<?php echo $headerRow['no_order']; ?>"/>
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtTglOrderHeader" class="control-label col-lg-4">Tgl Order</label>
                                                <div class="col-lg-4">
                                                    <input type="text" maxlength="10" placeholder="<?php echo date('Y-m-d')?>" name="txtTglOrderHeader" value="<?php echo $headerRow['tgl_order'] ?>" class="date form-control" data-date-format="yyyy-mm-dd" id="txtTglOrderHeader" />
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="cmbJenisOrderHeader" class="control-label col-lg-4">Jenis Order</label>
                                                <div class="col-lg-4">
                                                    <select id="cmbJenisOrderHeader" name="cmbJenisOrderHeader" class="select select2" data-placeholder="Choose an option">
                                                        <option value=""></option>
                                                        <option value="Perbaikan Kursi" <?php if ($headerRow['jenis_order'] == "Perbaikan Kursi") { echo "selected"; }?>>Perbaikan Kursi</option>
                                                        <option value="Cleaning Service" <?php if ($headerRow['jenis_order'] == "Cleaning Service") { echo "selected"; }?>>Cleaning Service</option>
                                                        <option value="Lain-Lain" <?php if ($headerRow['jenis_order'] == "Lain-Lain") { echo "selected"; }?>>Lain-Lain</option>
                                                    </select>
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="cmbSeksiOrderHeader" class="control-label col-lg-4">Seksi Order</label>
                                                <div class="col-lg-4">
                                                    <select id="cmbSeksiOrderHeader" name="cmbSeksiOrderHeader" class="select select2" data-placeholder="Choose an option">
                                                        <option value=""></option>
                                                        <?php
                                                            foreach ($ as $row) {
                                                                if ($headerRow['seksi_order'] == $row['seksi_order']) {
                                                                    $selected_data = "selected";
                                                                } else {
                                                                    $selected_data = "";   
                                                                }
                                                                echo '<option value="'.$row[''].'" '.$selected_data.'>'.$row[''].'</option>';
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtDueDateHeader" class="control-label col-lg-4">Due Date</label>
                                                <div class="col-lg-4">
                                                    <input type="text" maxlength="10" placeholder="<?php echo date('Y-m-d')?>" name="txtDueDateHeader" value="<?php echo $headerRow['due_date'] ?>" class="date form-control" data-date-format="yyyy-mm-dd" id="txtDueDateHeader" />
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtTglTerimaHeader" class="control-label col-lg-4">Tgl Terima</label>
                                                <div class="col-lg-4">
                                                    <input type="text" maxlength="10" placeholder="<?php echo date('Y-m-d')?>" name="txtTglTerimaHeader" value="<?php echo $headerRow['tgl_terima'] ?>" class="date form-control" data-date-format="yyyy-mm-dd" id="txtTglTerimaHeader" />
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="chkRemarksHeader" class="control-label col-lg-4">Remarks</label>
                                                <div class="col-lg-4">
                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="checkbox" name="chkRemarksHeader" id="chkRemarksHeader" /> Options 1
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>

                                        <div class="col-lg-12">
                                            <br />
                                            <br />
                                            <div class="row">
                                                <div class="nav-tabs-custom">
                                                    <ul class="nav nav-tabs">
                                                    </ul>
                                                    <div class="tab-content">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-footer">
                                        <div class="row text-right">
                                            <a href="javascript:history.back(1)" class="btn btn-primary btn-lg btn-rect">Back</a>
                                            &nbsp;&nbsp;
                                            <button type="submit" class="btn btn-primary btn-lg btn-rect">Save Data</button>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>