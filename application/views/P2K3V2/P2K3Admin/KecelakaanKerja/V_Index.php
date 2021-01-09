<style>

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
                                    <div class="col-md-1">
                                        <label style="margin-top: 5px;">Tahun</label>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" id="apd_yearonly" value="<?=$year?>" />
                                    </div>
                                    <div class="col-md-2">
                                        <button class="btn btn-primary" id="apdmkkbyyear">Lihat</button>
                                    </div>
                                    <div class="col-md-12" style="height: 50px;"></div>
                                    <div class="col-md-12" style="margin-bottom: 20px; padding: 0px;">
                                        <a href="<?= base_url('p2k3adm_V2/Admin/excel_monitoringKK?y='.$year); ?>" class="btn btn-success pull-left">
                                            <i class="fa fa-file-excel-o"></i> Excel
                                        </a>
                                        <a href="<?= base_url('p2k3adm_V2/Admin/pdf_monitoringKK?y='.$year); ?>" class="btn btn-danger pull-left" style="margin-left: 10px;" target="_blank">
                                            <i class="fa fa-file-pdf-o"></i> PDF
                                        </a>
                                        <a href="<?= base_url('p2k3adm_V2/Admin/add_monitoringKK'); ?>" class="btn btn-info pull-right">
                                            <i class="fa fa-plus"></i> Tambah
                                        </a>
                                    </div>
                                    <table class="table table-bordered table-hover" id="apdtblmkk">
                                        <thead>
                                            <tr class="bg-primary">
                                                <th class="bg-primary text-center" style="width: 10;">No</th>
                                                <th class="bg-primary text-center" style="width: 60px;">Action</th>
                                                <th class="bg-primary text-center">Noind</th>
                                                <th class="bg-primary text-center" style="width: 200px;">Nama</th>
                                                <th class="text-center" style="width: 200px;">Seksi</th>
                                                <th class="text-center" style="width: 200px;">Unit</th>
                                                <th class="text-center" >Dept</th>
                                                <th class="text-center" >Tgl. Kecelakaan</th>
                                                <th class="text-center" >Lokasi Kecelakaan</th>
                                                <th class="text-center" >Tempat Kecelakaan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $x=1; foreach ($list as $key): ?>
                                                <tr>
                                                    <td><?= $x++; ?></td>
                                                    <td style="text-align: center;">
                                                        <!-- <a href="" class="btn btn-success btn-sm" title="export Excel">
                                                            <i class="fa fa-file-excel-o"></i>
                                                        </a> -->
                                                        <a href="<?= base_url('p2k3adm_V2/Admin/edit_monitoringKK?id='.$key['id_kecelakaan']); ?>" class="btn btn-primary btn-sm" title="Edit">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                        <button class="btn btn-danger btn-sm apdbtndelmkk" title="Delete" value="<?= $key['id_kecelakaan'] ?>" pkj="<?= $key['noind'].' - '.$key['nama'] ?>">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </td>
                                                    <td><?= $key['noind'] ?></td>
                                                    <td><?= $key['nama'] ?></td>
                                                    <td><?= $key['seksi'] ?></td>
                                                    <td><?= $key['unit'] ?></td>
                                                    <td><?= $key['dept'] ?></td>
                                                    <td><?= $key['waktu_kecelakaan'] ?></td>
                                                    <td><?= $lokasi[$key['lokasi_kerja_kecelakaan']] ?></td>
                                                    <td><?= $key['tkp'] ?></td>
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
<script>
    var year = '<?=$year?>';
</script>