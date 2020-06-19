<style>
    .dataTables_filter{
        float: right;
    }
    .buttons-excel{
        background-color: green;
        color: white;
    }
</style>
<section class="content">
    <div class="inner" >
        <div class="row">
            <div class="col-lg-12">
                <div class="col-lg-11">
                    <div class="text-right">
                        <h1><b><?= $Title ?></b></h1>
                    </div>
                </div>
                <div class="col-lg-1">
                    <div class="text-right hidden-md hidden-sm hidden-xs">

                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-11"></div>
                        <div class="col-lg-1 "></div>
                    </div>
                </div>
                <br />
                <div class="">
                    <div class="col-lg-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border"></div>
                            <form method="post" action="<?= base_url('civil-maintenance-order/order/update_lampiran') ?>" enctype="multipart/form-data">
                            <div class="box-body cmo_ifchange">
                                <?php $x = 1; foreach ($lampiran as $key):
                                $file = explode('/', $key['path']);
                                ?>
                                <div class="col-md-12 mco_insertafter" style="margin-top: 10px;">
                                    <div class="col-md-6">
                                        <div class="col-md-4">
                                            <label class="mco_lampiranno">Lampiran <?= $x ?></label>
                                        </div>
                                        <div class="col-md-8">
                                            <input readonly="" value="<?= $file[count($file)-1] ?>" type="text" class="form-control mco_lampiranFile" name="lampiran_lama">
                                        </div>
                                    </div>
                                    <div class="col-md-6" style="padding-left: 0px;">
                                        <div class="col-md-1 text-center">
                                            <button type="button" class="btn btn-danger mco_delfile" value="<?= $key['attachment_id'] ?>" nama="<?= $file[count($file)-1] ?>">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <?php $x++; endforeach ?>
                                <div class="col-md-12 mco_insertafter" style="margin-top: 10px;">
                                    <div class="col-md-6">
                                        <div class="col-md-4">
                                            <label class="mco_lampiranno">Lampiran <?= $x; ?></label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="file" class="form-control mco_lampiranFile" name="lampiran[]">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 text-center" style="margin-top: 50px;">
                                    <a href="<?= base_url('civil-maintenance-order/order/view_order/'.$id);?>" class="btn btn-warning btn-lg">Kembali</a>
                                    <button disabled value="<?= $id ?>" name="id" class="btn btn-success btn-lg" id="cmo_btnSaveUp">Update</button>
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