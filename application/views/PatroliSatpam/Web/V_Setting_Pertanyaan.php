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
                            <div class="box-body">
                                <div class="panel-body">
                                    <div class="col-md-12 text-right">
                                        <button class="btn btn-success" data-toggle="modal" data-target="#pts_mdl_addask">
                                            <i class="fa fa-plus"></i> Tambah Pertanyaan
                                        </button>
                                    </div>
                                    <div class="col-md-12" style="margin-top: 50px">
                                        <table class="table table-hover table-striped table-bordered">
                                            <thead class="bg-primary">
                                                <th width="5%" style="text-align: center;">No</th>
                                                <th style="text-align: center;">Pertaynaan</th>
                                                <th style="text-align: center; width: 200px">Action</th>
                                            </thead>
                                            <tbody>
                                                <?php $x=1; foreach ($ask as $key): ?>
                                                <tr>
                                                    <td style="text-align: center;"><?= $x ?></td>
                                                    <td class="pts_ask"><?= $key['pertanyaan'] ?></td>
                                                    <td style="text-align: center;">
                                                        <button class="btn btn-primary pts_edit_ask" value="<?=$key['id_pertanyaan']?>">
                                                            <i class="fa fa-edit"></i>
                                                        </button>
                                                        <button title="hapus" value="<?=$key['id_pertanyaan']?>" class="btn btn-danger pts_del_ask">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                <?php $x++; endforeach ?>
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
    </div>
</section>
<div class="modal fade" id="pts_mdl_addask" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="post" action="<?= base_url('PatroliSatpam/web/addask'); ?>">
            <div class="modal-content">
                <div class="modal-header">
                <label class="modal-title" id="exampleModalLabel">Tambah Pertanyaan</label>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <label>Pertanyaan</label>
                    <input class="form-control" name="pertanyaan">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="pts_mdl_upask" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="post" action="<?= base_url('PatroliSatpam/web/upask'); ?>">
            <div class="modal-content">
                <div class="modal-header">
                <label class="modal-title" id="exampleModalLabel">Edit Pertanyaan</label>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <label>Pertanyaan</label>
                    <input class="form-control" name="pertanyaan">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button id="id" name="id" type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div hidden id="surat-loading" style="top: 0;left: 0;right: 0;bottom: 0; margin: auto; position: fixed; background: rgba(0,0,0,.5); z-index: 11;">
    <img src="http://erp.quick.com/assets/img/gif/loadingtwo.gif" style="position: fixed; top: 0;left: 0;right: 0;bottom: 0; margin: auto; width: 40%;">
</div>