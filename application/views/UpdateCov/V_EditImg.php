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
                        <div class="box box-warning box-solid">
                            <form name="Orderform" class="form-horizontal" enctype="multipart/form-data" onsubmit="return validasi();window.location.reload();" method="post">
                                <div class="box-body">
                                    <div class="panel-body">
                                        <div class="col-md-6" style="text-align: left;"><button class="btn btn-danger" formaction="<?php echo base_url('Slideshow/EditData'); ?>">Back</button></div>
                                        <div class="col-md-6" style="text-align: right;"><a class="btn btn-default" onclick="AddingImg(<?= $w ?>)">Add Image</a></div>
                                    </div>
                                    <div class="panel-body">
                                        <table class="table table-bordered">
                                            <thead class="bg-yellow">
                                                <tr>
                                                    <th class="text-center">No</th>
                                                    <th class="text-center">Image</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tambah_img">
                                                <?php $i = 1;
                                                foreach ($img as $key => $edit) { ?>
                                                    <tr>
                                                        <input type="hidden" id="urIm<?= $i ?>" value="<?= $i ?>" name="urutan_imgnya[]">
                                                        <td class="text-center"><?= $i ?></td>
                                                        <td class="text-center">
                                                            <img style="max-width: 700px;" src="<?php echo base_url($edit['FILE_DIR_ADDRESS']); ?>">
                                                        </td>
                                                        <td class="text-center">
                                                            <?php if ($edit['ACTIVE_FLAG'] != 'N') { ?>
                                                                <a class="btn btn-primary" onclick="InactiveGambar(<?= $edit['LINE_ID'] ?>)">Inactive</a>
                                                            <?php } else { ?>
                                                                <a class="btn btn-primary" onclick="ActiveGambar(<?= $edit['LINE_ID'] ?>)">Active</a>
                                                            <?php } ?>
                                                            <a class="btn btn-warning" onclick="UpdateGambar(<?= $edit['LINE_ID'] ?>, <?= $i ?>)">Update</a>
                                                            <a class="btn btn-danger" onclick="DeleteGambar(<?= $edit['LINE_ID'] ?>)">Delete</a>
                                                        </td>
                                                    </tr>
                                                <?php $i++;
                                                } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="modal fade" id="UpImg" role="dialog">
    <div class="modal-dialog" style="width:80%">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <center>
                    <h3 class="modal-title">Update Img</h3>
                </center>
            </div>
            <div class="modal-body">
                <div id="update_img"></div>
            </div>
        </div>
    </div>
</div>