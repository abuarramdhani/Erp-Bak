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
                                <div class="row">
                                    <div class="col-md-12 text-right">
                                        <button data-toggle="modal" data-target="#cmojenisorder" class="btn btn-success"><i class="fa fa-plus"></i> Tambah</button>
                                    </div>
                                    <div class="col-md-12" style="margin-top: 20px;" id="CMO_tblJnsOrder">
                                        <table class="table table-bordered table-hover table-striped" id="CMOtblJpkj">
                                            <thead class="bg-primary">
                                                <th width="5%" style="text-align: center;">No</th>
                                                <th style="text-align: center;">Jenis Pekerjaan</th>
                                                <th style="text-align: center;">Keterangan</th>
                                                <th width="10%" style="text-align: center;">Action</th>
                                            </thead>
                                            <tbody class="text-center">
                                                <?php $x = 1; foreach ($list as $key): ?>
                                                <tr>
                                                    <td><?= $x ?></td>
                                                    <td style="text-align: left;"><?= $key['jenis_pekerjaan'] ?></td>
                                                    <td class="mco_jpKet" style="text-align: left;"><?= $key['keterangan'] ?></td>
                                                    <td>
                                                        <button value="<?= $key['jenis_pekerjaan_id'] ?>" data-target="#cmoupjenisorder" data-toggle="modal" class="btn btn-primary cmo_upJnsOrder" nama="<?= $key['jenis_pekerjaan'] ?>"><i class="fa fa-edit"></i></button>
                                                        <button class="btn btn-danger cmo_delJnsPkj" value="<?= $key['jenis_pekerjaan_id'] ?>" nama="<?= $key['jenis_pekerjaan'] ?>"><i class="fa fa-trash"></i></button>
                                                    </td>
                                                </tr>
                                                <?php $x++; endforeach ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <hr>
                                        <hr>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 text-right">
                                        <button data-toggle="modal" data-target="#cmojenisorderdetail" class="btn btn-success"><i class="fa fa-plus"></i> Tambah</button>
                                    </div>
                                    <div class="col-md-12" style="margin-top: 20px;" id="CMO_tblJnsOrderDetail">
                                        <table class="table table-bordered table-hover table-striped" id="CMOtblJpkjDetail">
                                            <thead class="bg-primary">
                                                <th width="5%" style="text-align: center;">No</th>
                                                <th style="text-align: center;">Jenis Pekerjaan</th>
                                                <th style="text-align: center;">Pekerjaan Detail</th>
                                                <th style="text-align: center;">Keterangan</th>
                                                <th width="10%" style="text-align: center;">Action</th>
                                            </thead>
                                            <tbody class="text-center">
                                                <?php $x = 1; foreach ($detail as $key): ?>
                                                <tr>
                                                    <td><?= $x ?></td>
                                                    <td style="text-align: left;"><?= $key['jenis_pekerjaan'] ?></td>
                                                    <td style="text-align: left;"><?= $key['detail_pekerjaan'] ?></td>
                                                    <td class="mco_jpKet" style="text-align: left;"><?= $key['keterangan'] ?></td>
                                                    <td>
                                                        <button value="<?= $key['jenis_pekerjaan_id'] ?>" data-target="#cmoupjenisorderdetail" data-toggle="modal" class="btn btn-primary cmo_upJnsOrderDetail" pekerjaan-id="<?= $key['jenis_pekerjaan_id'] ?>" detail="<?= $key['detail_pekerjaan'] ?>" detail-id="<?= $key['jenis_pekerjaan_detail_id'] ?>"><i class="fa fa-edit"></i></button>
                                                        <button class="btn btn-danger cmo_delJnsPkjDetail" value="<?= $key['jenis_pekerjaan_detail_id'] ?>" nama="<?= $key['detail_pekerjaan'] ?>"><i class="fa fa-trash"></i></button>
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
<div class="modal fade" id="cmojenisorder" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="post" action="<?= base_url('civil-maintenance-order/setting/add_jns_pkj') ?>">
                <div class="modal-header">
                    <label class="modal-title" id="exampleModalLabel">Tambah Jenis Pekerjaan</label>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <label>Jenis Pekerjaan</label>
                    <input placeholder="Masukan Jenis Pekerjaan" class="form-control" name="pekerjaan" required="">
                     <label style="margin-top: 20px;">Keterangan</label>
                    <input placeholder="Masukan Keterangan Pekerjaan" class="form-control" name="ket" required="">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="cmoupjenisorder" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="post" action="<?= base_url('civil-maintenance-order/setting/up_jns_pkj') ?>">
                <div class="modal-header">
                    <label class="modal-title" id="exampleModalLabel">Edit Jenis Pekerjaan</label>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <label>Jenis Pekerjaan</label>
                    <input placeholder="Masukan Jenis Pekerjaan" class="form-control" name="upjenisOrder" required="">
                    <label style="margin-top: 20px;">Keterangan</label>
                    <input placeholder="Masukan Keterangan Pekerjaan" class="form-control" name="upKet" required="">
                    <input hidden="" name="idJnsOrder" required="">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="cmojenisorderdetail" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="post" action="<?= base_url('civil-maintenance-order/setting/add_jns_pkj_detail') ?>">
                <div class="modal-header">
                    <label class="modal-title" id="exampleModalLabel">Tambah Jenis Pekerjaan</label>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <label>Jenis Pekerjaan</label>
                    <select class="select2" style="width: 100%" name="jenisPekerjaan" data-placeholder="Masukan Jenis Pekerjaan">
                        <option></option>
                        <?php $x = 1; foreach ($list as $key): ?>
                            <option value="<?= $key['jenis_pekerjaan_id'] ?>"><?= $key['jenis_pekerjaan'] ?></option>
                        <?php $x++; endforeach ?>
                    </select>
                    <label style="margin-top: 20px;">Detail Pekerjaan</label>
                    <input placeholder="Masukan Detail Pekerjaan" class="form-control" name="pekerjaanDetail" required="">
                     <label style="margin-top: 20px;">Keterangan</label>
                    <input placeholder="Masukan Keterangan Pekerjaan" class="form-control" name="ket" required="">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="cmoupjenisorderdetail" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="post" action="<?= base_url('civil-maintenance-order/setting/up_jns_pkj_detail') ?>">
                <div class="modal-header">
                    <label class="modal-title" id="exampleModalLabel">Edit Jenis Pekerjaan</label>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <label>Jenis Pekerjaan</label>
                    <select class="select2" style="width: 100%" name="upjenisPekerjaan" data-placeholder="Masukan Jenis Pekerjaan">
                        <option></option>
                        <?php $x = 1; foreach ($list as $key): ?>
                            <option value="<?= $key['jenis_pekerjaan_id'] ?>"><?= $key['jenis_pekerjaan'] ?></option>
                        <?php $x++; endforeach ?>
                    </select>
                    <label style="margin-top: 20px;">Detail Pekerjaan</label>
                    <input placeholder="Masukan Detail Pekerjaan" class="form-control" name="upjenisOrderDetail" required="">
                    <label style="margin-top: 20px;">Keterangan</label>
                    <input placeholder="Masukan Keterangan Pekerjaan" class="form-control" name="upKet" required="">
                    <input hidden="" name="idJnsPekerjaanDetail" required="">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>