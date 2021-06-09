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
                        <div class="col-lg-1">
                            <div class="text-right hidden-md hidden-sm hidden-xs">
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('ManufacturingOperationUP2L/Absen'); ?>">
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
                            <div class="box-header with-border">
                                <a href="<?php echo site_url('ManufacturingOperationUP2L/Absen/view_create/') ?>" style="float:right;margin-right:1%;margin-top:-0.5%;" alt="Add New" title="Add New">
                                    <button type="button" class="btn btn-default btn-sm"><i class="icon-plus icon-2x"></i></button>
                                </a>
                            </div>
                            <div class="box-body">
                                <div class="table-responsive">
                                    <table class="datatable table table-striped table-bordered table-hover text-left" id="tblMouldingAbs" style="font-size:12px;">
                                        <thead class="bg-primary">
                                            <tr>
                                                <th style="text-align:center; width:30px">No</th>
                                                <th style="text-align:center; width:100px">Action</th>
                                                <th style="text-align:center;">Nama</th>
                                                <th style="text-align:center;">No Induk</th>
                                                <th style="text-align:center;">Tanggal</th>
                                                <th style="text-align:center;">Presensi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- <?php $a=1; foreach ($show as $key => $value) { ?>
                                            <tr>
                                                <td><?= $a++; ?></td>
                                                <td>
                                                    <a style="margin-right:4px" href="<?php echo base_url('ManufacturingOperationUP2L/Absen/read_data/'.$value['id_absensi']); ?>" data-toggle="tooltip" data-placement="bottom" title="Read Data"><span class="fa fa-list-alt fa-2x"></span></a>
                                                    <a style="margin-right:4px" href="<?php echo base_url('ManufacturingOperationUP2L/Absen/update_data/'.$value['id_absensi']); ?>" data-toggle="tooltip" data-placement="bottom" title="Edit Data"><span class="fa fa-pencil-square-o fa-2x"></span></a>
                                                    <a href="<?php echo base_url('ManufacturingOperationUP2L/Absen/delete_data/'.$value['id_absensi']); ?>" data-toggle="tooltip" data-placement="bottom" title="Hapus Data" onclick="return confirm('Are you sure you want to delete this item?');"><span class="fa fa-trash fa-2x"></span></a>
                                                </td>
                                                <td><?= $value['nama'] ?></td>
                                                <td><?= $value['no_induk'];?></td>
                                                <td><?= $value['created_date']?></td>
                                                <td><?= $value['presensi']?></td>
                                            </tr>
                                            <?php }?> -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
