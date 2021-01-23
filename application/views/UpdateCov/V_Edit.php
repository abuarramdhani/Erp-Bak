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
                                        <table class="table table-bordered">
                                            <thead class="bg-yellow">
                                                <tr>
                                                    <th class="text-center">No</th>
                                                    <th class="text-center">Nama Slide Show</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1;
                                                foreach ($ToEdit as $key => $edit) { ?>
                                                    <tr>
                                                        <td class="text-center"><?= $i ?></td>
                                                        <td class="text-center"><?= $edit['SLIDE_SHOW_NAME'] ?></td>
                                                        <td class="text-center">
                                                            <button class="btn btn-default" formaction="<?php echo base_url('Slideshow/EditData/EditGambar/' . $edit['HEADER_ID']); ?>">Edit</button>
                                                            <?php if ($edit['ACTIVE_FLAG'] != 'N') { ?>
                                                                <a class="btn btn-primary" onclick="InactiveSlide(<?= $edit['HEADER_ID'] ?>)">Inactive</a>
                                                                <button class="btn btn-success" formtarget="_blank" formaction="<?php echo base_url('Slide/Show/Name/' . $edit['SLIDE_SHOW_NAME']); ?>">Show</button>
                                                            <?php } else { ?>
                                                                <a class="btn btn-primary" onclick="ActiveSlide(<?= $edit['HEADER_ID'] ?>)">Active</a>
                                                            <?php } ?>
                                                            <a class="btn btn-danger" onclick="DeleteSlide(<?= $edit['HEADER_ID'] ?>)">Delete</a>
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