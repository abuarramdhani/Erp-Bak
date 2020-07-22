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
                                        <button id="os_add_tpmsk" class="btn btn-success" data-target="#modal_tambah_topi" data-toggle="modal"><i class="fa fa-plus"></i> Tambah</button>
                                    </div>
                                    <div class="col-md-12" style="margin-top: 20px">
                                    <table class="table table-striped table-bordered table-hover text-center os_dtable">
                                        <thead class="bg-primary">
                                            <tr>
                                                <td>No</td>
                                                <td>Tanggal</td>
                                                <td>Jenis Topi</td>
                                                <td>Jumlah</td>
                                                <td>Tanggal Input</td>
                                                <td>Action</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $x = 1; foreach ($list_topi as $t): ?>
                                                <tr>
                                                    <td><?= $x ?></td>
                                                    <td id="<?= date('Y-m-d', strtotime($t['tanggal'])) ?>"><?= date('d-M-Y', strtotime($t['tanggal'])) ?></td>
                                                    <td id="<?= $t['id_jenis_topi'] ?>"><?= $t['jenis'] ?></td>
                                                    <td><?= $t['jumlah'] ?></td>
                                                    <td><?= date('d-M-Y', strtotime($t['tgl_input'])) ?></td>
                                                    <td>
                                                        <button value="<?= $t['id'] ?>" class="os_edit_tpmsk btn btn-primary"><i class="fa fa-edit"></i></button>
                                                        <a onclick="return confirm('Apa anda yakin ?')" href="<?= base_url('SeragamOnline/Transaksi/hapus_topi_masuk?id='.$t['id']) ?>" class="btn btn-danger"><i class="fa fa-trash"></i></a>
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
<div class="modal fade" id="modal_tambah_topi" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <form method="post" action="<?= base_url('SeragamOnline/Transaksi/add_topi_masuk') ?>">
                <div class="modal-header">
                    <label class="modal-title" id="exampleModalLabel">Tambah Data</label>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <label>Tanggal</label>
                    <input style="width: 200px;" class="form-control so_datepicker" name="tgl" id="">
                    <label>Jenis Topi</label>
                    <select id="" required="" style="width: 100%" data-placeholder="Pilih Salah Satu" class="select2 form-control" name="jenis" placeholder="Masukan Tipe Baju">
                        <option></option>
                        <?php foreach ($tjTopi as $tj): ?>
                            <option value="<?= $tj['id'] ?>"><?= $tj['jenis'] ?></option>    
                        <?php endforeach ?>
                    </select>
                    <label id="os_label_jns">Jumlah (pcs)</label>
                    <input required="" type="number" min="1" style="width: 200px;" class="form-control" name="jumlah" id="">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button id="sosubmited" name="id" type="submit" class="btn btn-success">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_edit_topi" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <form method="post" action="<?= base_url('SeragamOnline/Transaksi/edit_topi_masuk') ?>">
                <div class="modal-header">
                    <label class="modal-title" id="exampleModalLabel">Edit Data</label>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <label>Tanggal</label>
                    <input style="width: 200px;" class="form-control so_datepicker soEdittpmskModal" name="tgl" id="">
                    <label>Jenis Topi</label>
                    <select id="" required="" style="width: 100%" data-placeholder="Pilih Salah Satu" class="select2 form-control soEdittpmskModal" name="jenis" placeholder="Masukan Tipe Baju">
                        <option></option>
                        <?php foreach ($tjTopi as $tj): ?>
                            <option value="<?= $tj['id'] ?>"><?= $tj['jenis'] ?></option>    
                        <?php endforeach ?>
                    </select>
                    <label id="os_label_jns">Jumlah (pcs)</label>
                    <input required="" type="number" min="1" style="width: 200px;" class="form-control soEdittpmskModal" name="jumlah" id="">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button id="sosubmited" name="id" type="submit" class="btn btn-success">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>