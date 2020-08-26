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
                            <div class="box-body">
                                <div class="col-md-12" style="margin-top: 10px;">
                                    <div class="col-md-12">
                                            <label>Approval</label>
                                            <table class="table table-bordered mco_tblPekerjaan" id="">
                                                <thead class="bg-info">
                                                    <th>No</th>
                                                    <th>Pekerjaan</th>
                                                    <th width="15%">Qty</th>
                                                    <th width="15%">Satuan</th>
                                                    <th>Keterangan</th>
                                                    <th>Lampiran</th>
                                                    <th>Act</th>
                                                </thead>
                                                <tbody>
                                                    <?php $x=1; foreach ($ket as $key): ?>
                                                    <tr>
                                                        <td class="mco_daftarnoPek"><?=$x?></td>
                                                        <td>
                                                            <input data-id="<?=$key['pekerjaan_id']?>" kolom="pekerjaan" value="<?= $key['pekerjaan'] ?>" class="form-control mco_editKeteranggan">
                                                        </td>
                                                        <td>
                                                            <input data-id="<?=$key['pekerjaan_id']?>" kolom="qty" value="<?= $key['qty'] ?>" type="number" class="form-control">
                                                        </td>
                                                        <td>
                                                            <input data-id="<?=$key['pekerjaan_id']?>" kolom="satuan" value="<?= $key['satuan'] ?>" class="form-control" oninput="this.value = this.value.toUpperCase()">
                                                        </td>
                                                        <td>
                                                            <textarea data-id="<?=$key['pekerjaan_id']?>" kolom="keterangan" class="form-control" style="margin: 0px; resize: none;"><?= $key['keterangan'] ?></textarea>
                                                        </td>
                                                        <td class='td_lampiran'>
                                                            <form method="POST" enctype="multipart/form-data" action="<?php echo base_url('civil-maintenance-order/order/add_lampiran_pekerjaan') ?>">
                                                                <input type="hidden" name="id_order" value="<?php echo $id ?>">
                                                                <input type="hidden" name="pekerjaan" value="<?php echo $key['pekerjaan'] ?>">
                                                                <button type="submit" class="btnsubmit" style="display: none;">submit</button>
                                                                <?php 
                                                                $no_lamp = 1;
                                                                if (isset($lampiran) && !empty($lampiran)) {
                                                                    foreach ($lampiran as $lamp) {
                                                                        if ($lamp['pekerjaan'] == $key['pekerjaan']) {
                                                                            $lamp_path = explode('/', $lamp['path']);
                                                                            if ($no_lamp > 1) {
                                                                                echo "<br>";
                                                                            }
                                                                            ?>
                                                                            <a target="_blank" href="<?= base_url('civil-maintenance-order/order/download_file/'.$lamp['attachment_id']) ?>" data-attachment-id="<?php echo $lamp['attachment_id'] ?>">
                                                                                <?php echo $no_lamp.'. '.end($lamp_path) ?>
                                                                            </a>
                                                                            <a data-attachment-id="<?php echo $lamp['attachment_id'] ?>" class="btn btn-danger btn-xs mco_delFile_editKet"><span class="fa fa-trash"></span></a>
                                                                            <?php
                                                                            $no_lamp++; 
                                                                        }
                                                                    }
                                                                }
                                                                if ($no_lamp > 1) {
                                                                    echo "<br>";
                                                                }
                                                                ?>
                                                                <label nomor='<?php echo $no_lamp ?>'>Lampiran <?php echo $no_lamp ?> :</label>
                                                                <input type="file" class="form-control mco_lampiranFilePekerjaanEdit tbl_lampiran" name="tbl_lampiran[0][]">

                                                            </form>
                                                        </td> 
                                                        <td>
                                                            <button type="button" class="btn btn-xs btn-danger mco_delKeterangan" value="<?=$key['pekerjaan_id']?>">
                                                                <i class="fa fa-times"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    <?php $x++; endforeach ?>
                                                </tbody>
                                            </table>
                                            <button type="button" class="btn btn-sm btn-success pull-right" data-toggle="modal" data-target="#edit_aproval">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                        <div class="col-md-12 text-center" style="margin-top: 20px;">
                                        <a class="btn btn-warning btn-lg" href="<?php echo base_url('civil-maintenance-order/order/edit_order/'.$id) ?>">Kembali</a>
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
<div class="modal fade" id="edit_aproval" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document" style="width: 90%">
        <form method="post" action="<?= base_url('civil-maintenance-order/order/add_keterangan') ?>" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <label class="modal-title" id="exampleModalLongTitle">Tambah Pekerjaan</label>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body clearfix">
                    <table class="table table-bordered" id="mco_tblPekerjaan">
                        <thead class="bg-info">
                            <th>No</th>
                            <th>Pekerjaan</th>
                            <th width="10%">Qty</th>
                            <th width="10%">Satuan</th>
                            <th>Keterangan</th>
                            <th width="20%">Lampiran</th>
                            <th>Act</th>
                        </thead>
                        <tbody class="mco_daftarPek_Append">
                            <tr class="mco_daftarPek">
                                <td class="mco_daftarnoPek">1</td>
                                <td>
                                    <input name="tbl_pekerjaan[]" class="form-control" required>
                                </td>
                                <td>
                                    <input name="tbl_qty[]" type="number" class="form-control" required>
                                </td>
                                <td>
                                    <input name="tbl_satuan[]" class="form-control" oninput="this.value = this.value.toUpperCase()" required>
                                </td>
                                <td>
                                    <textarea name="tbl_ket[]" class="form-control" style="margin: 0px; resize: none;" required></textarea>
                                </td>
                                <td class='td_lampiran'>
                                    <div>
                                        <input type="file" nomor='1' class="form-control mco_lampiranFilePekerjaan tbl_lampiran" name="tbl_lampiran[0][]" style="display: none;">
                                    </div>
                                    <button nomor='1' type='button' class="btn btn-primary add_lamp">Choose File 1</button>
                                </td>  
                                <td>
                                    <button type="button" class="btn btn-xs btn-danger mco_deldaftarnoPek"><i class="fa fa-times"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <button type="button" class="btn btn-sm btn-success pull-right mco_addRowPek">
                        <i class="fa fa-plus"></i>
                    </button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" value="<?=$id?>" name="id" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    window.addEventListener('load', function () {
        mco_initEditKeterangan();
    });
</script>