<?php //"<pre>";print_r($Moulding);exit();
?>
<section class="content">
    <div class="inner">
        <div class="row">

            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-11">
                            <div class="text-right">
                                <h1><b><?= $Title ?></b></h1>
                            </div>
                        </div>
                        <div class="col-lg-1 ">
                            <div class="text-right hidden-md hidden-sm hidden-xs">
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('ManufacturingOperationUP2L/Moulding/'); ?>">
                                    <i class="icon-wrench icon-2x"></i>
                                    <br />
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <br />

                <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border">Read Moulding</div>
                            <div class="box-body">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="col-lg-6">
                                                <table class="table" style="border: 0px !Important;">
                                                    <?php foreach ($Moulding as $headerRow) : ?>
                                                        <tr>
                                                            <td class="col-lg-5" style="border: 0"><strong>Component Code</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['component_code']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="col-lg-5" style="border: 0"><strong>Component Description</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['component_description']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="col-lg-5" style="border: 0"><strong>Kode Proses</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['kode_proses']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="col-lg-5" style="border: 0"><strong>Production Date</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['production_date']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="col-lg-5" style="border: 0"><strong>Print Code</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['print_code']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="col-lg-5" style="border: 0"><strong>Shift</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['shift']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="col-lg-5" style="border: 0"><strong>Moulding Quantity</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['moulding_quantity']; ?>
                                                                <input type="hidden" id="mould_qty" value="<?php echo $headerRow['moulding_quantity']; ?>">
                                                                <input type="hidden" id="mould_id" value="<?php echo $headerRow['moulding_id']; ?>">
                                                            </td>
                                                        </tr>
                                                </table>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading">
                                                        Employee [Kode Kelompok : <?php echo $headerRow['kode']; ?>]
                                                        <?php endforeach; ?>
                                                    </div>
                                                    <ul class="list-group">
                                                        <?php foreach ($headerRow['employee'] as $emp) { ?>
                                                            <li class="list-group-item"><?php echo $emp['name'] . ' [' . $emp['no_induk'] . ']' ?></li>
                                                        <?php } ?>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <h3>Table Scrap</h3>
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Type</th>
                                                            <th>Code</th>
                                                            <th>Quantity</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $i = 1;
                                                        foreach ($headerRow['scrap'] as $scrap) { ?>
                                                            <?php //"<pre>";print_r($scrap);exit();
                                                            ?>
                                                            <tr data="<?= $scrap['scrap_id'] ?>">
                                                                <td id=""><?php echo $scrap['no'] ?></td>
                                                                <td id="editTypeScrap<?= $scrap['scrap_id'] ?>"><?php echo $scrap['type_scrap'] ?></td>
                                                                <td id="editCodeScrap<?= $scrap['scrap_id'] ?>"><?php echo $scrap['kode_scrap'] ?></td>
                                                                <td id="editQtyScrap<?= $scrap['scrap_id'] ?>"><?php echo $scrap['quantity'] ?></td>
                                                                <td>
                                                                    <button onclick="editScr(<?= $scrap['scrap_id'] ?>)" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></button>
                                                                    <button onclick="delScr(<?= $scrap['scrap_id'] ?>)" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                                                                </td>
                                                                <input type="hidden" id="jumlah_scrap" value="<?php echo $scrap['jumlah'] ?>">
                                                            </tr>
                                                            <?php $i++;
                                                        } ?>
                                                    </tbody>
                                                </table>

                                            </div>
                                            <div class="col-lg-12">
                                                <h3>Table Bongkar</h3>
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th width="10px">No</th>
                                                            <th width="200px">Quantity</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $i = 1;
                                                        foreach ($headerRow['bongkar'] as $bongkar) { ?>
                                                            <tr data="<?= $bongkar['bongkar_id'] ?>">
                                                                <td><?php echo $bongkar['no'] ?></td>
                                                                <td id="editQtyBongkar<?= $bongkar['bongkar_id'] ?>"><?php echo $bongkar['quantity'] ?></td>
                                                                <td>
                                                                    <button onclick="editBon(<?= $bongkar['bongkar_id'] ?>)" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></button>
                                                                    <button onclick="delBon(<?= $bongkar['bongkar_id'] ?>)" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                                                                </td>
                                                                <input type="hidden" id="jumlah_bongkar" value="<?php echo $bongkar['jumlah'] ?>">
                                                            </tr>
                                                            <?php $i++;
                                                        } ?>
                                                    </tbody>
                                                </table>

                                            </div>

                                            <div class="col-lg-12 panel panel-default" style="padding: 0px;margin-top: 30px">
                                                <div class="panel-heading">
                                                    <h3>Add Scrap<i class="pull-right fa fa-plus"></i></h3>
                                                </div>
                                                <div class="panel-body" id="container-scrap">
                                                  <div class="form-group field_add_scrap">
                                                    <label for="txtScrap" class="control-label col-lg-2" style="padding:5px">Scrap Type :</label>
                                                    <div class="col-lg-3">
                                                      <select class="form-control jsSlcScrap txtScrap" name="scrap" required data-placeholder="Scrap">
                                                          <option></option>
                                                      </select>
                                                    </div>
                                                    <div class="col-lg-2">
                                                      <label for="scrap_qty" class="control-label" style="padding:5px">Quantity :</label>
                                                    </div>
                                                    <div class="col-lg-3">
                                                      <input class="form-control scrap_qty" type="number" name="scrap_qty" placeholder="QTY">
                                                    </div>
                                                    <button class="btn btn-info add_field_scrap"><i class="fa fa-plus"></i></button>
                                                    <button class="btn btn-danger remove_field_scrap" style="display: none"><i class="fa fa-close"></i></button>

                                                    <div style="padding-left:384px;margin-right:-305px;"></div>
                                                  </div>
                                                </div>
                                                <div class="panel-footer">
                                                      <button class="btn btn-success add_scrap">Add <i class="fa fa-plus"></i></button>
                                                </div>
                                            </div>

                                            <div class="col-lg-12 panel panel-default" style="padding: 0px;margin-top: 30px">
                                                <div class="panel-heading">
                                                    <h3>Add Bongkar<i class="pull-right fa fa-plus"></i></h3>
                                                </div>
                                                <div class="panel-body" id="container-bongkar">
                                                  <div class="form-group field_add_bongkar">
                                                    <div class="col-lg-6">
                                                      <label for="bongkar_qty" class="control-label" style="margin-top:7px"> Quantity : </label>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <input class="form-control bongkar_qty" type="number" name="bongkar_qty" placeholder="QTY">
                                                    </div>
                                                    <button class="btn btn-info add_field_bongkar"><i class="fa fa-plus"></i></button>
                                                    <button class="btn btn-danger remove_field_bongkar" style="display: none"><i class="fa fa-close"></i></button>

                                                    <div style="padding-left:384px;margin-right:-305px;"></div>
                                                  </div>
                                                </div>
                                                <div class="panel-footer">
                                                  <button class="btn btn-success add_bongkar">Add <i class="fa fa-plus"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="panel-footer">
                                    <div align="right">
                                        <?php foreach ($Moulding as $u) { ?>
                                        <form method="POST" action="<?= base_url('ManufacturingOperationUP2L/Moulding')?>">
                                        <input type="hidden" name="bulan" value="<?= $u['production_date']; ?>">
                                        <button type="submit" class="btn btn-danger btn-lg"><i class="fa fa-arrow-left"></i></i>  Back</button>
                                        </form>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="modal modal-success fade" id="mdlEditScrap">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title">Edit Scrap</h4>
                                            </div>
                                            <div class="modal-body">
                                                <label for="nama">Scrap Type : </label><br />
                                                <input type="hidden" id="">
                                                <select class="jsSlcScrap" id="txtMdlScrap" name="txtMdlScrap" required style="width: 100%">
                                                    <option></option>
                                                </select><br />
                                                <label for="nama">Jumlah Scrap : </label><br />
                                                <input type="text" class="form-control" id="newQtyScrap">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                                                <button type="button" class="btn btn-outline btnSubmitScrap">Save changes</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal modal-success fade" id="mdlEditBongkar">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title">Edit Bongkar</h4>
                                            </div>
                                            <div class="modal-body">
                                                <!-- <input type="text" class="form-control" id="newIdBongkar" name="newIdBongkar" value=""> -->
                                                <label for="nama">Jumlah Bongkar : </label>
                                                <input type="text" class="form-control" id="newQtyBongkar" name="newQtyBongkar">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                                                <button type="button" class="btn btn-outline btnSubmitBongkar">Save changes</button>
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
