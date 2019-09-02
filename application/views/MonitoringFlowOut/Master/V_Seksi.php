<input type="hidden" class="hdnPagesMFO" value="1">
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
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('MonitoringFlowOut/Seksi'); ?>">
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
                <div class="col-lg-12">
                    <div class="box box-primary box-solid">
                        <div class="box-header with-border">
                            <div class="col-lg-11" style="vertical-align:middle;">
                                <b style="vertical-align:middle;"><b>Seksi</b></b>
                            </div>
                            <div class="col-lg-1">
                                <button onclick="crSeksi()" class="btn btn-danger"><i class="fa fa-plus"></i><span> Add</span></button>
                            </div>

                        </div>
                        <div class="box-body">
                            <div class="panel-body">
                                <div class="row">
                                    <div style="margin:15px;">
                                        <center>
                                            <table class="datatable table table-striped table-bordered table-hover" id="tNoButton">
                                                <thead class="bg-primary">
                                                    <tr>
                                                        <th width="5%">No</th>
                                                        <th width="20%">Action</th>
                                                        <th width="75%">Nama Seksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $i = 1;
                                                    foreach ($seksi as $ssk) { ?>
                                                        <tr data="<?= $ssk['id'] ?>">
                                                            <td width="5%"><?= $i++; ?></td>
                                                            <td class="text-center" width="20%">
                                                                <button class="btn btn-success btn-sm" onclick="editSeksi(<?= $ssk['id'] ?>)"><i class="fa fa-pencil"></i></button>
                                                                <button onclick="delSeksi(<?= $ssk['id'] ?>)" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                                                            </td>
                                                            <td id="nama<?= $ssk['id'] ?>" data="<?= $ssk['id'] ?>" width="75%"><?php echo $ssk['seksi'] ?></td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </center>

                                        <div class="modal modal-success fade" id="mdlSeksi">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span></button>
                                                        <h4 class="modal-title">Edit</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <label style="text-align:left">Nama Seksi : </label><br />
                                                        <input type="hidden" id="editNamaId">
                                                        <input type="text" class="form-control" id="editNamaSeksi">
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                                                        <button type="button" class="btn btn-outline btnSubmitSeksi">Save changes</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal modal-info fade" id="crSeksi">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form method="post" action="<?php echo base_url('MonitoringFlowOut/Seksi/setSeksi'); ?>">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span></button>
                                                            <h4 class="modal-title">Create</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <label style="text-align:left">Nama Seksi : </label><br />
                                                            <input type="text" class="form-control" id="createNamaSeksi" name="createNamaSeksi">
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                                                            <button class="btn btn-outline" type="submit">Save changes</button>
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
                </div>
            </div>
        </div>
    </div>
</section>