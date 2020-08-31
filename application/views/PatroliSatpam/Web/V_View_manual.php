<style>
    th{
        text-align: center;
    }
    .containr {
        border: 1px solid grey;
        margin-top: 5px;
        position: relative;
        width: 50%;
    }
    .containr:hover .imghover {
      opacity: 0.3;
    }
    .containr:hover .middle {
      opacity: 1;
    }
    .imghover {
      opacity: 1;
      display: block;
      width: 100%;
      height: auto;
      transition: .5s ease;
      backface-visibility: hidden;
    }
    .middle {
      transition: .5s ease;
      opacity: 0;
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      -ms-transform: translate(-50%, -50%);
      text-align: center;
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
                            <div class="box-header with-border">
                                <label style="margin-top: 15px;">Add Input Manual</label>
                            </div>
                            <div class="box-body">
                                <div class="panel-body">
                                    <div class="col-md-8">
                                        <div class="col-md-3" style="padding-left: 0px;">
                                            <label>Pekerja / Satpam</label>
                                        </div>
                                        <div class="col-md-9">
                                            <label>: <?= $detail['noind'].' - '.$detail['nama'] ?></label>
                                        </div>
                                        <div class="col-md-3" style="padding-left: 0px;">
                                            <label>Tanggal Shift</label>
                                        </div>
                                        <div class="col-md-9">
                                            <label>: <?= $detail['tgl_shift'] ?></label>
                                        </div>
                                        <div class="col-md-3" style="padding-left: 0px;">
                                            <label>Waktu Scan</label>
                                        </div>
                                        <div class="col-md-9">
                                            <label>: <?= $detail['tgl_patroli'] ?></label>
                                        </div>
                                        <div class="col-md-3" style="padding-left: 0px;">
                                            <label>Ronde</label>
                                        </div>
                                        <div class="col-md-9">
                                            <label>: <?= $detail['ronde'] ?></label>
                                        </div>
                                        <div class="col-md-3" style="padding-left: 0px;">
                                            <label>Pos</label>
                                        </div>
                                        <div class="col-md-9">
                                             <label>: <?= $detail['pos'] ?></label>
                                        </div>
                                        <br><br><br>
                                        <br><br><br>
                                        <label style="text-decoration: underline;">Pertanyaan & Jawaban</label>
                                        <?php if (empty($ask)): ?>
                                            <br><label>-</label>   
                                        <?php endif ?>
                                        <?php $x=1; foreach ($ask as $key): ?>
                                        <div class="col-md-12" style="padding-left: 0px;">
                                            <?php if ($key['jawaban'] == '1') {
                                                $jwb = '<label style="color:green">Ya</label>';
                                            }else{
                                                $jwb = '<label style="color:red">Tidak</label>';
                                            } ?>
                                            <label><?= $x.'. '.$key['pertanyaan'].'('.$jwb.')'?></label>
                                        </div>
                                        <?php $x++; endforeach ?>
                                        <br>
                                        <button class="btn btn-sm btn-primary" id="pts_btnupjwbn" value="<?=$id?>">
                                            <i class="fa fa-edit"></i> Edit Jawaban
                                        </button>
                                        <br>
                                        <label style="margin-top: 30px;"><u>Temuan</u></label>
                                        <br>
                                        <div id="pts_endisdiv">
                                            <?php foreach ($temuan as $key): ?>
                                                <label>- <?=$key['deskripsi']?></label>
                                            <?php endforeach ?>
                                            <br>
                                            <?php if (!empty($attch)): ?>
                                                <label>Foto</label>
                                            <?php endif ?>
                                            <br>
                                            <?php foreach ($attch as $key): ?>
                                                <?php if (!empty($key['nama_file'])): ?>
                                                    <div class="containr">
                                                        <img src="<?= base_url('assets/upload/PatroliSatpam/'.$key['nama_file']) ?>" class="imghover"/>
                                                        <div class="middle">
                                                            <!-- <button type="button" class="btn btn-outline-secondary">
                                                                <i class="fa fa-edit"></i> Edit
                                                            </button> -->
                                                            <button type="button" class="btn btn-danger pts_btndelattch" value="<?=$key['id_attachment']?>">
                                                                <i class="fa fa-trash"></i> Delete
                                                            </button>
                                                        </div>
                                                    </div>
                                                <?php else: ?>
                                                    <!-- *Tidak ada    -->
                                                <?php endif ?>
                                            <?php endforeach ?>
                                            <br><br>
                                            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#pts_mdledtbtmn">
                                               <i class="fa fa-edit"></i> Edit Temuan
                                            </button>
                                            <?php if (count($attch) < 4): ?>
                                                <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#pts_mdladdtbtmnft">
                                                   <i class="fa fa-plus"></i> Add Foto Temuan
                                                </button>
                                            <?php endif ?>
                                        </div>
                                    </div>
                                    <div class="col-md-4 text-center">
                                        <?php if (!empty($detail['barcode_file'])): ?>
                                            <img src="<?= base_url('assets/upload/PatroliSatpam/barcode/'.$detail['barcode_file']) ?>" style="max-width: 200px;"/>
                                            <button class="btn-info btn" style="margin-left: 20px; margin-top: 10px;" data-toggle="modal" data-target="#pts_mdledtbrc">
                                                <i class="fa fa-edit"></i> Edit Barcode
                                            </button>
                                        <?php else: ?>
                                            <button class="btn-success btn" data-toggle="modal" data-target="#pts_mdledtbrc">
                                                <i class="fa fa-edit"></i> Upload Barcode
                                            </button>
                                        <?php endif ?>
                                    </div>
                                    <hr>
                                    <div class="col-md-12 text-center" style="margin-top: 50px">
                                        <a class="btn btn-warning" href="<?= base_url('PatroliSatpam/web/input_manual'); ?>">
                                            <label style="cursor: pointer;">Kembali</label>
                                        </a>
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
<div hidden id="surat-loading" style="top: 0;left: 0;right: 0;bottom: 0; margin: auto; position: fixed; background: rgba(0,0,0,.5); z-index: 11;">
    <img src="http://erp.quick.com/assets/img/gif/loadingtwo.gif" style="position: fixed; top: 0;left: 0;right: 0;bottom: 0; margin: auto; width: 40%;">
</div>
<div class="modal fade" id="pts_mdledtbrc" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="pts_frmedtbrc" enctype="multipart/form-data" method="post" action="<?=base_url('PatroliSatpam/web/edit_barcode_manual?id='.$id)?>">
                <div class="modal-header">
                    <label class="modal-title" id="exampleModalLabel">Add/Edit Barcode</label>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input class="form-control" type="file" accept="image/*" name="barcode" required="">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="pts_mdledtbtmn" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="pts_frmedtbrc" enctype="multipart/form-data" method="post" action="<?=base_url('PatroliSatpam/web/edit_temuan_manual?id='.$id)?>">
                <div class="modal-header">
                    <label class="modal-title" id="exampleModalLabel">Add/Edit Temuan</label>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <label>Deskripsi</label>
                    <textarea required="" class="form-control endis" name="deskripsi" style="height: 100px; width: 500px;" /><?php foreach ($temuan as $key): ?><?=$key['deskripsi']?><?php endforeach ?></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="pts_mdladdtbtmnft" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="pts_frmedtbrc" enctype="multipart/form-data" method="post" action="<?=base_url('PatroliSatpam/web/add_attch_manual?id='.$id)?>">
                <div class="modal-header">
                    <label class="modal-title" id="exampleModalLabel">Add Foto Temuan</label>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <label>Foto</label>
                    <input class="form-control endis" name="foto" type="file" style="width: 500px" required="" />
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="pts_mdlupdjwb" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="pts_frmedtbrc" enctype="multipart/form-data" method="post" action="<?=base_url('PatroliSatpam/web/upd_jawaban_manual?id='.$id)?>">
                <div class="modal-header">
                    <label class="modal-title" id="exampleModalLabel">Add/Update Temuan</label>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>