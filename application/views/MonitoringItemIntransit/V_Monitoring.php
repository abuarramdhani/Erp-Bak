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
                                <a class="btn btn-default btn-lg">
                                    <i class="fa fa-desktop fa-2x">
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
                        <div class="box box-info">
                            <div class="box-header with-border"></div>
                            <form method="post" action="<?= base_url('MonitoringItemIntransit/Monitoring/ReportItemIntransit') ?>">
                                <div class="box-body" id="MonitoringItemIntransit">
                                    <div class="panel-body">
                                        <div class="col-md-2" style="text-align: right;">
                                            <b>IO From</b>
                                        </div>
                                        <div class="col-md-3">
                                            <select class="form-control select2 IoItemIntransit" name="io_from" data-placeholder="Select" id="IoItemIntransitFrom">
                                                <option value=""></option>
                                            </select>
                                        </div>
                                        <div class="col-md-2" style="text-align: right;">
                                            <b>IO To</b>
                                        </div>
                                        <div class="col-md-3">
                                            <select class="form-control select2 IoItemIntransit" name="io_to" data-placeholder="Select" id="IoItemIntransitTo">
                                                <option value=""></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="panel-body">
                                        <div class="col-md-2" style="text-align: right;">
                                            <b>Subinventory From</b>
                                        </div>
                                        <div class="col-md-3">
                                            <select class="form-control select2" name="subinv_from" data-placeholder="Select" id="SubInvIntransitFrom">
                                                <option value=""></option>
                                            </select>
                                        </div>
                                        <div class="col-md-2" style="text-align: right;">
                                            <b>Subinventory To</b>
                                        </div>
                                        <div class="col-md-3">
                                            <select class="form-control select2" name="subinv_to" data-placeholder="Select" id="SubInvIntransitTo">
                                                <option value=""></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="panel-body">
                                        <div class="col-md-2" style="text-align: right;">
                                            <b>Date From</b>
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text" autocomplete="off" class="form-control DateItemIntransit" name="date_from" placeholder="Date From" name="" id="DateIntransitFrom">
                                        </div>
                                        <div class="col-md-2" style="text-align: right;">
                                            <b>Date To</b>
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text" autocomplete="off" class="form-control DateItemIntransit" name="date_to" placeholder="Date To" name="" id="DateIntransitTo">
                                        </div>
                                    </div>
                                    <div class="panel-body">
                                        <div class="col-md-12" style="text-align: center;">
                                            <a class="btn btn-primary" onclick="SearchItemInvItransit()">Search</a>
                                            <button class="btn btn-success">Export</button>
                                        </div>
                                    </div>
                                    <div class="panel-body">
                                        <div class="col-md-12" id="tabel_item_intransit"></div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>
<div class="modal fade" id="mdl_req_appr" role="dialog">
    <div class="modal-dialog" style="width:60%">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <center>
                    <h3 class="modal-title">Set Approver</h3>
                </center>
            </div>
            <div class="modal-body">
                <div id="getAppr"></div>
            </div>
        </div>

    </div>
</div>