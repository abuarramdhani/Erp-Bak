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
                                    <i class="fa fa-list fa-2x">
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
                            <div class="box-body">
                                <div class="panel-body">
                                    <div class="col-md-2" style="text-align: center;">
                                        <label>Status Transact</label>
                                    </div>
                                    <div class="col-md-3">
                                        <select id="stat_trans" class="form-control status_spb" data-placeholder="Status Transact">
                                            <option></option>
                                            <option value="BELUM TRANSACT">BELUM TRANSACT</option>
                                            <option value="LINE CLOSE/SUDAH TRANSACT">LINE CLOSE/SUDAH TRANSACT</option>
                                            <option value="LINE CANCEL">LINE CANCEL</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2" style="text-align: center;">
                                        <label>Status Interorg</label>
                                    </div>
                                    <div class="col-md-3">
                                        <select id="stat_int" class="form-control status_spb" data-placeholder="Status Interorg">
                                            <option></option>
                                            <option value="BELUM INTERORG">BELUM INTERORG</option>
                                            <option value="INTERORG">INTERORG</option>
                                            <option value="SUDAH INTERORG">SUDAH INTERORG</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div class="col-md-2" style="text-align: center;">
                                        <label>IO Tujuan</label>
                                    </div>
                                    <div class="col-md-3">
                                        <select class="form-control io_tjn" id="io_tjn" data-placeholder="IO Tujuan">
                                            <option></option>
                                        </select>
                                    </div>

                                    <div class="col-md-2" style="text-align: center;">
                                        <label>Status Receipt</label>
                                    </div>
                                    <div class="col-md-3">
                                        <select id="rcpt_date" class="form-control status_spb" data-placeholder="Status Receipt">
                                            <option></option>
                                            <option value="1">BELUM RECEIPT</option>
                                            <option value="2">SUDAH RECEIPT</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div class="col-md-12" style="text-align: center;"><button class="btn btn-info search_spbeh">Search</button></div>
                                </div>
                                <div class="panel-body">
                                    <div class="col-md-12" id="tbl_spb"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>
<div class="modal fade" id="mdl_detail_spb" role="dialog">
    <div class="modal-dialog" style="width:60%">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <center>
                    <h3 class="modal-title">Detail SPB</h3>
                </center>
            </div>
            <div class="modal-body">
                <div id="tbl_spb"></div>
            </div>
        </div>

    </div>
</div>