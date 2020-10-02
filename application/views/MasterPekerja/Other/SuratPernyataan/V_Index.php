<section class="content">
    <div class="inner" >
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-3">
                        </div>
                        <div class="col-lg-3"></div>
                        <div class="col-lg-5">
                            <div class="text-right"><h1><b><?=$Title?></b></h1></div>
                        </div>
                        <div class="col-lg-1">
                        </div>
                    </div>
                </div>
                <br/>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border">
                            </div>
                            <div class="box-body">
                                <div class="col-md-12 text-right">
                                    <a href="<?= base_url('MasterPekerja/surat_pernyataan/addsuper') ?>" class="btn btn-success">
                                        <i class="fa fa-plus"></i> Tambah
                                    </a>
                                </div>
                                <div class="col-md-12" style="margin-top: 20px;">
                                    <table class="table table-bordered table-hover" id="mpktblsuper">
                                        <thead>
                                            <tr class="bg-primary">
                                                <th>No</th>
                                                <th>Pekerja</th>
                                                <th>Hubker</th>
                                                <th>RS / Klinik</th>
                                                <th>Tanggal JKK</th>
                                                <th>Tanggal Cetak</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $x=1; foreach ($list as $k): ?>
                                                <tr>
                                                    <td><?= $x++ ?></td>
                                                    <td><?= $k['pekerja'].' - '.$k['nama_pekerja'] ?></td>
                                                    <td><?= $k['hubker'].' - '.$k['nama_hubker'] ?></td>
                                                    <td><?= $listRs[$k['rs_klinik_id']] ?></td>
                                                    <td style="text-align: center;" data-order="<?=$k['tgl_jkk']?>"><?= date('d-M-Y', strtotime($k['tgl_jkk'])) ?></td>
                                                    <td style="text-align: center;" data-order="<?=$k['tgl_cetak']?>"><?= date('d-M-Y', strtotime($k['tgl_cetak'])) ?></td>
                                                    <td style="text-align: center;">
                                                        <a class="btn btn-primary" href="<?= base_url('MasterPekerja/surat_pernyataan/edit_super?id='.$k['id']) ?>">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                        <a target="_blank" href="<?= base_url('MasterPekerja/surat_pernyataan/cetak_super?id='.$k['id']) ?>" class="btn btn-danger" title="Cetak PDF">
                                                            <i class="fa fa-file-pdf-o"></i>
                                                        </a>
                                                    </td>
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
<div id="surat-loading" hidden style="top: 0;left: 0;right: 0;bottom: 0; margin: auto; position: fixed; background: rgba(0,0,0,.5); z-index: 11;">
    <img src="<?php echo site_url('assets/img/gif/loadingtwo.gif'); ?>" style="position: fixed; top: 0;left: 0;right: 0;bottom: 0; margin: auto; width: 40%;">
</div>