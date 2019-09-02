<input type="hidden" class="hdnPagesMFO" value="2">
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
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('MonitoringFlowOut/PossibleFailure'); ?>">
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
                        <!-- Datatable -->
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border">
                                <div class="col-lg-11" style="vertical-align:middle;">
                                    <b style="vertical-align:middle;"><b>Possible Failure</b></b>
                                </div>
                                <div class="col-lg-1">
                                    <button onclick="crPoss()" class="btn btn-danger"><i class="fa fa-plus"></i><span> Add</span></button>
                                </div>
                            </div>
                            <div class="box-body">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="" style="margin:15px;">
                                            <table width="100%" style="text-align:center;" class="datatable table table-striped table-bordered table-hover" id="tNoButton">
                                                <thead class="bg-primary">
                                                    <tr>
                                                        <th style="text-align:center;" width="5%">No</th>
                                                        <th style="text-align:center;" width="20%">Action</th>
                                                        <th style="text-align:center;" width="">Possible Failure</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $i = 1;
                                                    foreach ($possibleFailure as $pf) { ?>
                                                        <tr data="<?= $pf['id'] ?>">
                                                            <td><?php echo $i++; ?></td>
                                                            <td>
                                                                <button class="btn btn-success btn-sm" onclick="editPoss(<?= $pf['id'] ?>)"><i class="fa fa-pencil"></i></button>
                                                                <button onclick="delPoss(<?= $pf['id'] ?>)" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                                                            </td>
                                                            <td style="text-align:left;" id="poss<?= $pf['id'] ?>"><?= $pf['possible_failure'] ?></td>
                                                        <?php } ?>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <div class="modal modal-info fade" id="mdlUser1">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span></button>
                                                            <h4 class="modal-title">Edit</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <label for="nama">Possible Failure : </label>
                                                            <input type="hidden" id="editId">
                                                            <input type="text" class="form-control" id="editPoss">
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                                                            <button type="button" class="btn btn-outline" onclick="updPoss()">Save changes</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal modal-info fade" id="crPoss">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <form method="POST" action="<?php echo base_url('MonitoringFlowOut/PossibleFailure/setPoss') ?>">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span></button>
                                                                <h4 class="modal-title">Create</h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                <label style="text-align:left">Possible Failure : </label><br />
                                                                <textarea type="text" class="form-control" name="txtPossibleFailure" placeholder="Possible Failure"></textarea>
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
    </div>
</section>