<section class="content">
    <div class="inner" >
        <div class="row">
            <div class="col-lg-12">
                <div class="col-lg-11">
                    <div class="text-right">
                        <h1><b><?= $Title ?></b></h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-11"></div>
                        <div class="col-lg-1 "></div>
                    </div>
                </div>
                <br />
                <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border"></div>
                            <div class="box-body">
                                <div class="panel-body">
                                    <div class="col-md-12 text-right">
                                        <button class="btn btn-success" data-toggle="modal" data-target="#mdl_add_jnsBaju" id=""><i class="fa fa-plus"></i> Tambah</button>
                                    </div>
                                    <div id="os_getTableBaju" class="col-md-12" style="margin-top: 20px">
                                        <table class="table table-striped table-bordered table-hover text-center os_dtable">
                                            <thead class="bg-primary">
                                                <th>No</th>
                                                <th>ID</th>
                                                <th>Jenis</th>
                                                <th>Tipe Baju</th>
                                                <th>Action</th>
                                            </thead>
                                            <tbody>
                                                <?php $x = 1; foreach ($jnsBaju as $j): ?>
                                                    <tr>
                                                        <td><?= $x; ?></td>
                                                        <td><?= $j['id'] ?></td>
                                                        <td style="font-weight: bold;"><?= $j['jenis'] ?></td>
                                                        <td style="font-weight: bold;"><?= $j['tipe'] ?></td>
                                                        <td>
                                                        <button textnya="<?= $j['jenis'] ?>" idnya="<?= $j['id'] ?>" class="btn btn-primary os_edTB_modal" tipenya="<?= $j['id_tipe'] ?>" style="margin-right: 10px;"><i class="fa fa-pencil"></i> Edit</button>
                                                        <button textnya="<?= $j['jenis'] ?>" idnya="<?= $j['id'] ?>" class="btn btn-danger os_delTB"><i class="fa fa-trash"></i> Delete</button>
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
<div hidden id="surat-loading" style="top: 0;left: 0;right: 0;bottom: 0; margin: auto; position: fixed; background: rgba(0,0,0,.5); z-index: 11;">
    <img src="http://erp.quick.com/assets/img/gif/loadingtwo.gif" style="position: fixed; top: 0;left: 0;right: 0;bottom: 0; margin: auto; width: 40%;">
</div>
<div class="modal fade" id="mdl_add_jnsBaju" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <form method="post" action="<?= base_url('SeragamOnline/MasterData/addTableTipeNoajax') ?>">
                <div class="modal-header">
                    <label class="modal-title" id="exampleModalLabel">Tambah Data</label>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <label>Jenis Baju</label>
                    <input required="" class="form-control" name="jnsBaju" placeholder="Masukan Jenis Baju">
                    <input hidden="" name="tabel" value="tjenis_baju">
                    <label>Tipe Baju</label>
                    <select required="" style="width: 100%" data-placeholder="Pilih Salah Satu" class="select2 form-control" name="jnsTipe" placeholder="Masukan Tipe Baju">
                        <option></option>
                        <?php foreach ($tpBaju as $tb): ?>
                            <option value="<?= $tb['id'] ?>"><?= $tb['tipe']?></option>    
                        <?php endforeach ?>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="mdl_edit_jnsBaju" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <form method="post" action="<?= base_url('SeragamOnline/MasterData/edTableTipenoAjax') ?>">
                <div class="modal-header">
                    <label class="modal-title" id="exampleModalLabel">Edit Data</label>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <label>Jenis Baju</label>
                    <input id="edit_jnsbj" required="" class="form-control deaktif_disabled" name="jnsBaju" placeholder="Masukan Jenis Baju">
                    <input hidden="" name="tabel" value="tjenis_baju">
                    <label>Tipe Baju</label>
                    <select id="edit_jnsbj_tipe" required="" style="width: 100%" data-placeholder="Pilih Salah Satu" class="select2 form-control deaktif_disabled" name="jnsTipe" placeholder="Masukan Tipe Baju">
                        <option></option>
                        <?php foreach ($tpBaju as $tb): ?>
                            <option value="<?= $tb['id'] ?>"><?= $tb['tipe']?></option>    
                        <?php endforeach ?>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button name="id" id="for_id_jns" type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    var os_info = '<?= $info ?>';
    window.addEventListener('load', function () {
        os_init_table('tjenis_baju');
    });
</script>