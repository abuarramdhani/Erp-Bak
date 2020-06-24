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
                            </div>
                            <div class="box-body">
                                <div class="panel-body">
                                    <a class="btn btn-success" id="pad_btnAdd" href="<?= base_url('pengembalian-apd/pekerja/add_data') ?>" style="margin-bottom: 30px;">
                                        <i class="fa fa-plus"></i> Add Data
                                    </a>
                                    <br>
                                    <table class="table table-bordered table-hover table-striped text-center pad_tblpkj">
                                        <thead class="bg-primary">
                                            <th>No</th>
                                            <th>Noind</th>
                                            <th>Nama</th>
                                            <th>Seksi</th>
                                            <th>Tgl Approve</th>
                                            <th>Tgl Pembuatan</th>
                                            <th>Status</th>
                                            <th style="width: 100px;">Action</th>
                                        </thead>
                                        <tbody>
                                        <?php $x=1; foreach ($list as $key): ?>
                                                <tr>
                                                    <td><?=$x?></td>
                                                    <td><?=$key['noind']?></td>
                                                    <td><?=$key['nama']?></td>
                                                    <td><?=$key['seksi']?></td>
                                                    <td><?=$key['approve_date']?></td>
                                                    <td><?=$key['create_date']?></td>
                                                    <?php 
                                                        if($key['status'] == '1')
                                                            $color = 'green';
                                                        elseif ($key['status'] == '2')
                                                            $color = 'red';
                                                        else
                                                            $color = 'black';
                                                    ?>
                                                    <td style="color: <?=$color?>;">
                                                        <label><?=$key['stat']?></label>
                                                    </td>
                                                    <td>
                                                        <?php if ($key['status'] == 0): ?>
                                                            <?php if ($key['item'] > 0): ?>
                                                                <a href="<?=base_url('pengembalian-apd/pekerja/edit_data?id='.$key['id'])?>" class="btn btn-primary">
                                                                    <i class="fa fa-edit"></i>
                                                                </a>
                                                            <?php else: ?>
                                                                <a class="btn btn-success" href="<?=base_url('pengembalian-apd/hubker/view_only?id='.$key['id'])?>" title="detail">
                                                                    <i class="fa fa-eye"></i>
                                                                </a>
                                                            <?php endif ?>
                                                            <button class="btn btn-danger pad_btnDelAPD" value="<?=$key['id']?>">
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                        <?php else: ?>
                                                            <a class="btn btn-success" href="<?=base_url('pengembalian-apd/hubker/view_only?id='.$key['id'])?>" title="detail">
                                                                <i class="fa fa-eye"></i>
                                                            </a>
                                                        <?php endif ?>
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
</section>
<div hidden id="surat-loading" style="top: 0;left: 0;right: 0;bottom: 0; margin: auto; position: fixed; background: rgba(0,0,0,.5); z-index: 11;">
    <img src="http://erp.quick.com/assets/img/gif/loadingtwo.gif" style="position: fixed; top: 0;left: 0;right: 0;bottom: 0; margin: auto; width: 40%;">
</div>
<div class="modal fade" id="pad_mdlpkj" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <label class="modal-title" id="exampleModalLabel">Add Data</label>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <label>Noind - Nama</label>
                <select class="form-control" id="pad_mdl_getpkj" name="pekerja" style="width: 100%">
                    
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </div>
</div>