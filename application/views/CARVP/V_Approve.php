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
                        <div class="box box-primary">
                            <div class="box-header with-border"></div>
                            <form name="Orderform" enctype="multipart/form-data" onsubmit="return validasi();window.location.reload();" method="post">
                                <div class="box-body">
                                    <div class="panel-body">
                                        <div class="col-md-12" style="text-align: right;"><a onclick="deleteAlldata()" class="btn btn-danger">Delete All Data</a></div>
                                    </div>
                                    <div class="panel-body">
                                        <div class="col-md-12">
                                            <table class="table table-bordered" id="list_CARR">
                                                <thead class="bg-aqua">
                                                    <tr>
                                                        <th class="text-center">No</th>
                                                        <th class="text-center">Supplier Name</th>
                                                        <th class="text-center">Submit Date</th>
                                                        <th class="text-center">Approved Date</th>
                                                        <th class="text-center">No CAR</th>
                                                        <th class="text-center">Action</th>
                                                        <th class="text-center">Delivery Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $i = 1;
                                                    foreach ($car as $v) { ?>
                                                        <tr>
                                                            <td class="text-center"><?= $i ?></td>
                                                            <td class="text-center"><?= $v['SUPPLIER_NAME'] ?></td>
                                                            <td class="text-center"><?= date('d-M-Y H:i:s', strtotime($v['CREATED_DATE'])) ?></td>
                                                            <td class="text-center"><?= $v['APPROVE_DATE'] ?></td>
                                                            <td class="text-center"><input type="hidden" id="car_num<?= $i ?>" value="<?= $v['NO_CAR'] ?>"><?= $v['NO_CAR'] ?></td>
                                                            <td class="text-center">
                                                                <a style="border-radius: 50px;" class="btn btn-sm btn-warning" onclick="detailCAR(<?= $i ?>)">Detail</a>
                                                                <button style="border-radius: 50px;" formtarget="_blank" formaction="<?php echo base_url('CARVP/ListData/createPDFCar/' . $v['NO_CAR']); ?>" class="btn btn-sm bg-teal">View</button>
                                                                <?php if ($noind == $v['APPROVE_TO'] && $v['ACTIVE_FLAG'] == 'E') { ?>
                                                                    <a style="border-radius: 50px;" class="btn btn-sm btn-success" onclick="ApproveReqCAR(<?= $i ?>)">Approve</a>
                                                                    <a style="border-radius: 50px;" class="btn btn-sm btn-danger" onclick="RejectReqCAR(<?= $i ?>)">Reject</a>
                                                                <?php } else if ($v['ACTIVE_FLAG'] == 'F') { ?>
                                                                    <a class="btn btn-sm btn-default" onclick="kirimulangcar(<?= $i ?>)">Kirim Ulang CAR</a>
                                                                <?php } ?>
                                                            </td>
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
<div class="modal fade" id="mdl_det_car" role="dialog">
    <div class="modal-dialog" style="width:80%">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <center>
                    <h3 class="modal-title">Detail</h3>
                </center>
            </div>
            <div class="modal-body">
                <div id="getCAR"></div>
            </div>
        </div>
    </div>
</div>