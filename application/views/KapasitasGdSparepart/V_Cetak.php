<input type="hidden" id="punyaCetakDOSP" value="1">
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
                                    href="<?php echo site_url('KapasitasGdSparepart/Cetak/');?>">
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
                            <div class="box-header with-border">
                                <b>Cetak SPB/DOSP</b>
                            </div>
                            <div class="box-body">
                                <div class="col-md-12 text-right">
                                    <label class="control-label">
                                        <?php echo gmdate("l, d F Y, H:i:s", time()+60*60*7) ?>                                    
                                    </label>
                                </div>
                                <br>
                                <div id="loadingAreaCetak" style="display:none;">
                                    <center><img style="width: 5%" src="<?php echo base_url('assets/img/gif/loading5.gif') ?>"></center>
                                </div>
                                <div class="table_area_cetak">

                                </div>
                            

                                <br>
                                <br>

                                <div id="loadingArea7" style="display: none;">
                                    <center><img style="width: 5%" src="<?php echo base_url('assets/img/gif/loading5.gif') ?>"></center>
                                </div>
                                <div class="table_area_selesai3">
                                    
                                </div>
                            </div>                           
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">
    $(document).ready(function () {
        $('.tblcetak').dataTable({
            "scrollX": true,
            paging:false,
            scrollY: 500,
            ordering: false,
        });
        $('.tblcetak2').dataTable({
            "scrollX": true,
        });
    });
</script>