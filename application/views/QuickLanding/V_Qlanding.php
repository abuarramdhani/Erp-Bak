<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <form class="form-horizontal">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">WA Landing Page Monitor</h3>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <label for="Cabang" class="col-sm-2 control-label">Button Location</label>
                            <div class="col-sm-10">
                                <select class="from-control" id="slcLocationQland" style="width: 200px;">
                                    <option></option>
                                    <?php
                                    foreach ($select as $key => $value) { ?>
                                        <option><?php echo $value['button_location'] ?></option>
                                    <?php
                                    }
                                    ?>
                                    <option value="all">Select all</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="ordertype" class="col-sm-2 control-label">Click Date</label>
                            <div class="col-sm-10">
                                <input type="text" id="fromDateQland" placeholder="From Date">
                                -
                                <input type="text" id="toDateQland" placeholder="To Date">
                            </div>
                        </div>
                        <div align="center">
                            <button type="button" id="btnSearchQland" class="btn btn-primary"><i class="fa fa-search"></i>Search</button>
                            <a id="btnExportWLP" href="<?php echo base_url('LandingPageMonitor/exportExcel') ?>" class="btn btn-success">Export</a>
                        </div>
                        <br>
                        <div class="loadingQland" align="center" style="display:none;">
                            <img src="<?= base_url('assets/img/gif/loading11.gif'); ?>" alt="loading">
                        </div>
                        <div class="tableReportQland">

                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>