<section class="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-11">
                            <div class="text-right">
                                <h1><b>Setup Pertanyaan</b></h1>
                            </div>
                        </div>
                        <div class="col-lg-1"></div>
                    </div>
                </div>
                <br/>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border">
                                <a href="<?php echo site_url('ADMSeleksi/Setting/SetupPertanyaan/CreateNew') ?>" style="float:right;margin-right:1%;margin-top:-0.5%;" alt="Add New" title="Add New" >
                                    <button type="button" class="btn btn-default btn-sm">
                                        <i class="icon-plus icon-2x"></i>
                                    </button>
                                </a>
                                <b>Lihat Pertanyaan</b>
                            </div>
                            <div class="box-body">
                                <ul class="nav nav-tabs nav-justified">
                                <?php foreach ($data as $key => $value) {
                                    if ($key == 0) { ?>
                                        <li class="active"><a data-toggle="pill" href="#nav_<?= $value['id_tes']?>"><?= $value['nama_tes']?></a></li>
                                    <?php }else{ ?>
                                        <li><a data-toggle="pill" href="#nav_<?= $value['id_tes'] ?>"><?= $value['nama_tes']?></a></li>
                                    <?php }
                                }?>
								</ul>
                                <br>
                                <div class="tab-content">
                                <?php foreach ($data as $key => $value) {
                                    if ($key == 0) { ?>
                                    <div id="nav_<?= $value['id_tes']?>" class="tab-pane fade in in active">
                                    <?php }else{ ?>
                                    <div id="nav_<?= $value['id_tes']?>" class="tab-pane fade in">
                                    <?php } 
                                    
                                    if ($value['tipe_pilihan'] == 'ANGKA') {
                                        $typeol = "type='1'";
                                    } else if ($value['tipe_pilihan'] == 'HURUF') {
                                        $typeol = "type='A'";
                                    } else {
                                        $typeol = "";
                                    }
                                    ?>
                                     
                                        <table class="table table-bordered table-hover table-striped" style="width: 100%;" >
                                            <thead>
                                                <tr style="background-color: #3c8dbc; color:white;" class="text-nowrap">
                                                    <th class="text-center" rowspan="2" style="width:5%;">No</th>
                                                    <th class="text-center" colspan="2" style="width:40%;">Pertanyaan</th>
                                                    <th class="text-center" colspan="2" style="width:45%;">Pilihan Jawaban</th>
                                                    <th class="text-center" rowspan="2" style="width:10%;">Option</th>
                                                </tr>
                                                <tr style="background-color: #3c8dbc; color:white;" class="text-nowrap">
                                                    <th class="text-center" style="width:25%;">Pertanyaan</th>
                                                    <th class="text-center" style="width:15%;">File</th>
                                                    <th class="text-center" style="width:30%;">Jawaban</th>
                                                    <th class="text-center" style="width:15%;">File</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $no = 1; foreach ($value['pertanyaan'] as $key2 => $val) {?>
                                                <tr>
                                                    <td class="text-center"><?= $no?></td>
                                                    <td><?= $val['pertanyaan']?></td>
                                                    <td>
                                                    <?php foreach ($val['file_pertanyaan'] as $key3 => $fileval) {
                                                        if ($fileval['doc_path'] != NULL) {
                                                    ?>
                                                        <img src="<?= base_url($fileval['doc_path']) ?>" style="border:solid #ababab;width:100px;height:auto;display:block;" />
                                                    <?php } } ?>
                                                    </td>
                                                    <td>
                                                        <ol <?= $typeol?>>
                                                        <?php foreach ($val['jawaban'] as $key4 => $jwb) { 
                                                            if ($jwb['status_correct'] > 0) {
                                                                $color = "style='color:red;'";
                                                            } else {
                                                                $color = "";
                                                            }
                                                        ?>
                                                            <li <?= $color?>><?= $jwb['jawaban']?></li>
                                                        <?php } ?>
                                                        </ol>
                                                    </td>
                                                    <td>
                                                        <ol <?= $typeol?>>
                                                        <?php foreach ($val['jawaban'] as $key5 => $filejwb) {
                                                            if ($filejwb['status_correct'] > 0) {
                                                                $color = "style='color:red;'";
                                                            } else {
                                                                $color = "";
                                                            }

                                                            if ($filejwb['doc_path'] != NULL) {
                                                        ?>
                                                            <li <?= $color?>><img src="<?= base_url($filejwb['doc_path']) ?>" style="border:solid #ababab;width:100px;height:auto;display:block;margin-bottom:5px;" /></li>
                                                        <?php } else { ?>
                                                            <li <?= $color?>></li>
                                                        <?php } } ?>
                                                        </ol>
                                                    </td>
                                                    <td class="text-nowrap text-center">
                                                        <a class="btn btn-warning btn-xs" title="Edit" href="<?= site_URL() ?>ADMSeleksi/Setting/SetupPertanyaan/Edit?id_pertanyaan=<?= $val['id_pertanyaan'] ?>">
                                                            <i class="fa fa-edit"></i> Edit
                                                        </a>
                                                        <a class="btn btn-success btn-xs" title="Preview" href="<?= site_URL() ?>ADMSeleksi/Setting/SetupPertanyaan/Preview?id_pertanyaan=<?= $val['id_pertanyaan'] ?>">
                                                            <i class="fa fa-eye"></i> Preview
                                                        </a>
                                                    </td>
                                                </tr>
                                                <?php $no++; } ?>
                                            </tbody>
                                        </table>
                                        <a href="<?php echo base_url('ADMSeleksi/Setting/SetupPertanyaan/TambahSoal/'.$value['id_tes'])?>" class="btn btn-primary btn-xs">
                                            <i class="fa fa-plus"></i> Tambah Soal
                                        </a>
                                    </div>
                                <?php }?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>