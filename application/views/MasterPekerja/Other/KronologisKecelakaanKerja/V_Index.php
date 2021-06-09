<section class="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <h1><b><?=$Title ?></b></h1>    
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border text-left">
                                <label>List Kronologis Kecelakaan Kerja</label>
                            </div>
                            <div class="box-body">
                                <div class="col-md-12 text-right">
                                    <a href="<?= base_url('MasterPekerja/KronologisKecelakaanKerja/tambah') ?>" class="btn btn-success">
                                        <i style="margin-right: 10px" class="fa fa-plus"></i> Tambah
                                    </a>
                                </div>
                                <div class="col-md-12" style="margin-top: 20px;">
                                    <table class="table table-bordered table-striped table-hover mpk_dtables">
                                        <thead>
                                            <tr class="bg-primary">
                                                <th>No</th>
                                                <th>Action</th>
                                                <th>Noind</th>
                                                <th>Nama</th>
                                                <th>No. KPJ</th>
                                                <th>Waktu</th>
                                                <th>Tempat</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $x=1; foreach ($list as $key): ?>
                                                <tr>
                                                    <td style="text-align: center;"><?= $x++ ?></td>
                                                    <td style="text-align: center;">
                                                        <a href="<?= base_url('MasterPekerja/KronologisKecelakaanKerja/cetak?id='.$key['id']) ?>" target="_blank" class="btn btn-danger">
                                                            <i class="fa fa-file-pdf-o"></i>
                                                        </a>
                                                        <a href="<?= base_url('MasterPekerja/KronologisKecelakaanKerja/edit?id='.$key['id']) ?>" class="btn btn-primary">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                    </td>
                                                    <td><?= $key['pekerja'] ?></td>
                                                    <td><?= $key['nama'] ?></td>
                                                    <td><?= $key['no_kpj'] ?></td>
                                                    <td data-order="<?= $key['tanggal'] ?>"><?= date('d-M-Y', strtotime($key['tanggal'])).' '.$key['jam'] ?></td>
                                                    <td><?= $key['tempat'] ?></td>
                                                </tr>  
                                            <?php endforeach ?>
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