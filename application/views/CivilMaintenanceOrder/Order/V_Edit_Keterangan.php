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
                                        <a class="btn btn-warning btn-lg mco_getBack">Kembali</a>
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
    <div class="modal-dialog modal-lg" role="document">
        <form method="post" action="<?= base_url('civil-maintenance-order/order/add_keterangan') ?>">
            <div class="modal-content">
                <div class="modal-header">
                    <label class="modal-title" id="exampleModalLongTitle">Tambah Approver</label>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body clearfix">
                    <table class="table table-bordered" id="mco_tblPekerjaan">
                        <thead class="bg-info">
                            <th>No</th>
                            <th>Pekerjaan</th>
                            <th width="15%">Qty</th>
                            <th width="15%">Satuan</th>
                            <th>Keterangan</th>
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