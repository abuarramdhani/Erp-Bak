<script src="<?php echo base_url('assets/plugins/dataTables/jquery.dataTables.js');?>"></script>
	<script src="<?php echo base_url('assets/plugins/dataTables/dataTables.bootstrap.js');?>"></script>
    <script>
         $(document).ready(function () {
            $('.datepicktgl').datepicker({
                format: 'M yyyy',
                todayHighlight: true,
                viewMode: "months",
                minViewMode: "months",
                autoClose: true
            });
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
                                    href="<?php echo site_url('MonitoringDeliverySparepart/BomManagement/');?>">
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
                            <div class="box-body">
                                <div class="panel-body">
                                <form action="<?php echo base_url('MonitoringDeliverySparepart/BomManagement/saveBom'); ?>" method="post">
                                    <div class="col-md-12">
                                        <div class="col-md-5 text-right">
                                            <label class="control-label">Root Component Code</label>
                                        </div>
                                        <div class="col-md-3">
                                            <input id="rootCode1" name="rootCode" class="form-control pull-right" value="<?= $item?>" >
                                        </div>
                                    </div>
                                    <br><br>
                                    <div class="col-md-12">
                                        <div class="col-md-5 text-right">
                                            <label class="control-label">Root Component Description</label>
                                        </div>
                                        <div class="col-md-3">
                                            <textarea cols="33" id="rootDesc" name="rootDesc"><?= $desc?></textarea>
                                        </div>
                                    </div>
                                    <br><br>
                                    <div class="col-md-12">
                                        <div class="col-md-5 text-right">
                                            <label class="control-label">Identitas BoM</label>
                                        </div>
                                        <div class="col-md-3">
                                            <input id="idBom" name="idBom" class="form-control pull-right datepicktgl" onchange="cekIdentitasBom(this)" placeholder="mm/yyyy" required>
                                        </div>
                                        <div class="col-md-3">
                                            <span id="alert" style="color:red"></span>
                                        </div>
                                    </div>
                                    <br><br>
                                    <div class="col-md-12">
                                        <div class="col-md-5 text-right">
                                            <label class="control-label">Keterangan</label>
                                        </div>
                                        <div class="col-md-3">
                                            <input id="ket" name="ket" class="form-control pull-right" placeholder="keterangan" required>
                                        </div>
                                    </div>
                                    <br><br>
                                </div>
                                <div class="panel-body">
                                <?php 
                                    echo '<div class="just-padding">';
                                    echo $htmllist;
                                    echo '</div>';
                                            // echo "<pre>";
                                            // print_r($Tree);
                                            // print_r($BOM);
                                            // print_r($List);
                                            // exit();
                                ?>
                                <div class="col-md-12 text-center">
                                    <button type="submit" class="btn btn-success">SAVE</button>
                                </div>
                                </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
