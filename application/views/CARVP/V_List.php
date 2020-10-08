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
                            <form name="Orderform" enctype="multipart/form-data" onsubmit="return validasi();window.location.reload();" method="post">
                                <div class="box-body">
                                    <div class="panel-body">
                                        <div class="col-md-12">
                                            <table class="table table-bordered" id="list_CAR" style="width: 100%;">
                                                <thead class="bg-teal">
                                                    <tr>
                                                        <th class="text-center">Created Date</th>
                                                        <th class="text-center">Supplier Name</th>
                                                        <th class="text-center">No CAR</th>
                                                        <th class="text-center" style="width: 250px;">Action</th>
                                                        <th class="text-center">Approval Status</th>
                                                        <th class="text-center">Approval Date</th>
                                                        <th class="text-center">Delivery Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $i = 1;
                                                    foreach ($car as $v) { ?>
                                                        <?php if ($v['ACTIVE_FLAG'] == 'R') {
                                                            $warnatr = 'bg-danger';
                                                        } else {
                                                            $warnatr = "";
                                                        } ?>
                                                        <tr class="<?= $warnatr ?>">
                                                            <td class="text-center"><?= $v['CREATED_DATE'] ?></td>
                                                            <td class="text-center"><?= $v['SUPPLIER_NAME'] ?></td>
                                                            <td class="text-center"><input type="hidden" id="car<?= $i ?>" value="<?= $v['CAR_NUM'] ?>"><?= $v['CAR_NUM'] ?></td>
                                                            <td class="text-center">
                                                                <?php if ($v['ACTIVE_FLAG'] == 'B') { ?>
                                                                    <button style="border-radius: 50px;" formtarget="_blank" formaction="<?php echo base_url('CARVP/ListData/createPDFCar/' . $v['CAR_NUM']); ?>" class="btn btn-sm btn-default">View</button>
                                                                    <a style="border-radius: 50px;" class="btn btn-sm btn-success" onclick="ReqApprCAR(<?= $i ?>)">Req Approve</a>
                                                                    <button style="border-radius: 50px;" formaction="<?php echo base_url('CARVP/ListData/EditCAR/' . $v['CAR_NUM']); ?>" class="btn btn-sm btn-warning">Edit</button>
                                                                    <a style="border-radius: 50px;" class="btn btn-sm btn-danger" onclick="deleteCAR(<?= $i ?>)">Delete</a>
                                                                <?php } elseif ($v['ACTIVE_FLAG'] == 'E') { ?>
                                                                    <button style="border-radius: 50px;" formtarget="_blank" formaction="<?php echo base_url('CARVP/ListData/createPDFCar/' . $v['CAR_NUM']); ?>" class="btn btn-sm btn-default">View</button>
                                                                    <button style="border-radius: 50px;" formaction="<?php echo base_url('CARVP/ListData/EditCAR/' . $v['CAR_NUM']); ?>" class="btn btn-sm btn-warning">Edit</button>
                                                                    <a style="border-radius: 50px;" class="btn btn-sm btn-danger" onclick="deleteCAR(<?= $i ?>)">Delete</a>
                                                                <?php } elseif ($v['ACTIVE_FLAG'] == 'A') { ?>
                                                                    <button style="border-radius: 50px;" formtarget="_blank" formaction="<?php echo base_url('CARVP/ListData/createPDFCar/' . $v['CAR_NUM']); ?>" class="btn btn-sm btn-default">View</button>
                                                                    <!-- <a style="border-radius: 50px;" class="btn btn-sm btn-danger" onclick="deleteCAR(<?= $i ?>)">Delete</a> -->
                                                                <?php } elseif ($v['ACTIVE_FLAG'] == 'R') { ?>
                                                                    <a style="border-radius: 50px;" class="btn btn-sm btn-danger" onclick="deleteCAR(<?= $i ?>)">Delete</a>
                                                                <?php } ?>
                                                            </td>

                                                            <td class="text-center"><?= $v['APPROVAL_STATUS'] ?></td>
                                                            <td class="text-center"><?= $v['APPROVE_DATE'] ?></td>
                                                            <td class="text-center"><?= $v['DELIVERY_STATUS'] ?></td>
                                                        </tr>
                                                    <?php $i++;
                                                    } ?>
                                                </tbody>
                                            </table>
                                        </div>
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