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
                                    href="<?php echo site_url('MonitoringFlowOut/UserQC');?>">
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
                    <div class="col-lg-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border">
                                <b>UserQC</b>
                            </div>
                            <div class="box-body">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="panel-body">
                                            <div class="col-lg-4"></div>
                                            <div class="col-lg-4" text-center>
                                                <label>Nama Seksi</label>
                                                <input type="text" class="form-control"> <br />
                                                <label>No Induk</label>
                                                <input type="text" class="form-control">
                                                <center><a href="#"><br /><i class="btn btn-info fa fa-plus"></i></a>
                                                </center>
                                            </div>
                                            <div class="col-lg-4"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border">
                                <b>View</b>
                            </div>
                            <div class="box-body">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class= "" style="margin:15px;">
                                            <center><table style="width:90%;"
                                                class="datatable table table-striped table-bordered table-hover"
                                                id="tNoButton">
                                                <thead class="bg-primary">
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Nama</th>
                                                        <th>No Induk</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                </tbody>
                                            </table></center>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>