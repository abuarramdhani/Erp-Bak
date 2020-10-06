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
                                        <button class="btn btn-success" data-target="#modal_tambah_celana" id="" data-toggle="modal" ><i class="fa fa-plus"></i> Tambah</button>
                                    </div>
                                    <div class="col-md-12" style="margin-top: 20px">
                                    <table class="table table-striped table-bordered table-hover text-center os_dtable">
                                        <thead class="bg-primary">
                                            <tr>
                                                <td>No</td>
                                                <td>Tanggal</td>
                                                <td>Jenis Celana</td>
                                                <td>Ukuran</td>
                                                <td>Jumlah</td>
                                                <td>Tanggal Input</td>
                                                <td>Action</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $x = 1; foreach ($list_celana as $c): ?>
                                             <tr>
                                                 <td><?= $x ?></td>
                                                 <td isi="<?= date('Y-m-d', strtotime($c['tanggal'])) ?>"><?= date('d-M-Y', strtotime($c['tanggal'])) ?></td>
                                                 <td isi="<?= $c['id_jenis_celana'] ?>"><?= $c['jenis'] ?></td>
                                                 <td isi="<?= $c['id_ukuran'] ?>"><?= $c['ukuran'] ?></td>
                                                 <td><?= $c['jumlah'] ?></td>
                                                 <td><?= date('d-M-Y', strtotime($c['tgl_input'])) ?></td>
                                                 <td>
                                                    <button value="<?= $c['id'] ?>" class="os_edit_clmsk btn btn-primary"><i class="fa fa-edit"></i></button>
                                                    <a onclick="return confirm('Apa anda yakin ?')" href="<?= base_url('SeragamOnline/Transaksi/hapus_celana_masuk?id='.$c['id']) ?>" class="btn btn-danger"><i class="fa fa-trash"></i></a>
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
<div class="modal fade" id="modal_tambah_celana" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <form method="post" action="<?= base_url('SeragamOnline/Transaksi/add_celana_masuk') ?>">
                <div class="modal-header">
                    <label class="modal-title" id="exampleModalLabel">Tambah Data</label>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <label>Tanggal</label>
                    <input style="width: 200px;" class="form-control so_datepicker" name="tgl" id="">
                    <label>Jenis Celana</label>
                    <select id="" required="" style="width: 100%" data-placeholder="Pilih Salah Satu" class="select2 form-control" name="jenis" placeholder="Masukan Tipe Baju">
                        <option></option>
                        <?php foreach ($tjCelana as $tj): ?>
                            <option value="<?= $tj['id'] ?>"><?= $tj['jenis'] ?></option>    
                        <?php endforeach ?>
                    </select>
                    <label>Ukuran</label>
                    <select id="" required="" style="width: 100%" data-placeholder="Pilih Salah Satu" class="select2 form-control os_slc_dis" name="ukuran" placeholder="Masukan Tipe Baju">
                        <option></option>
                        <?php foreach ($tUkuran as $tu): ?>
                            <option value="<?= $tu['id'] ?>"><?= $tu['ukuran']?></option>    
                        <?php endforeach ?>
                    </select>
                    <label id="os_label_jns">Jumlah (pcs)</label>
                    <input required="" type="number" min="1" style="width: 200px;" class="form-control" name="jumlah" id="">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_edit_celana" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <form method="post" action="<?= base_url('SeragamOnline/Transaksi/edit_celana_masuk') ?>">
                <div class="modal-header">
                    <label class="modal-title" id="exampleModalLabel">Edit Data</label>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <label>Tanggal</label>
                    <input style="width: 200px;" class="form-control so_datepicker soEditclmskModal" name="tgl" id="">
                    <label>Jenis Celana</label>
                    <select id="" required="" style="width: 100%" data-placeholder="Pilih Salah Satu" class="select2 form-control soEditclmskModal" name="jenis" placeholder="Masukan Tipe Baju">
                        <option></option>
                        <?php foreach ($tjCelana as $tj): ?>
                            <option value="<?= $tj['id'] ?>"><?= $tj['jenis'] ?></option>    
                        <?php endforeach ?>
                    </select>
                    <label>Ukuran</label>
                    <select id="" required="" style="width: 100%" data-placeholder="Pilih Salah Satu" class="select2 form-controls soEditclmskModal" name="ukuran" placeholder="Masukan Tipe Baju">
                        <option></option>
                        <?php foreach ($tUkuran as $tu): ?>
                            <option value="<?= $tu['id'] ?>"><?= $tu['ukuran']?></option>    
                        <?php endforeach ?>
                    </select>
                    <label id="os_label_jns">Jumlah (pcs)</label>
                    <input required="" type="number" min="1" style="width: 200px;" class="form-control soEditclmskModal" name="jumlah" id="">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button name="id" type="submit" id="sosubmited" class="btn btn-success">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>