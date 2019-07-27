<section class="content">
    <div class="inner" >
        <div class="row">
            <div class="col-lg-12">
                <div class="col-lg-11">
                    <div class="text-right">
                        <h1><b>List Memo</b></h1>
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
                            <div class="box-header with-border">
                                List Jenis Penilaian
                                <a href="<?php echo site_url('EvaluasiTIMS/Setup/AddMemo')?>">
                                    <div style="float:right;margin-right:1%;margin-top:0px; margin-bottom: 5px;" alt="Add New" title="Add New">
                                        <button type="button" class="btn btn-default btn-sm"><i class="icon-plus icon-2x"></i></button>
                                    </div>
                                </a>
                            </div>
                            <div class="box-body">
                                <div class="panel-body">
                                   <div class="row">
                                    <table class="table table-striped table-bordered table-hover text-center et_jenis_penilaian">
                                        <thead>
                                            <tr class="bg-primary">
                                                <th>No</th>
                                                <th width="10%">Action</th>
                                                <th>No Surat</th>
                                                <th>Kepada</th>
                                                <th>Bagian</th>
                                                <th>Kasie Pdev</th>
                                                <th>Tanggal Di Buat</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; foreach ($listMemo as $key): ?>
                                                <tr>
                                                    <td><?php echo $i; ?></td>
                                                    <td>
                                                        <a target="_blank" style="margin-right:4px" href="<?php echo site_url('EvaluasiTIMS/Setup/previewcetak/'.$key['id']); ?>" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Preview Cetak"><span class="fa fa-file-pdf-o fa-2x"></span></a>
                                                        <a style="margin-right:4px" href="<?php echo site_url('EvaluasiTIMS/Setup/EditMemo/'.$key['id']); ?>" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Edit Memo"><span class="fa fa-edit fa-2x"></span></a>
                                                    </td>
                                                    <td><?php echo $key['nomor_surat']; ?></td>
                                                    <td><?php echo $key['kepada']; ?></td>
                                                    <td><?php echo $key['bagian']; ?></td>
                                                    <td><?php echo $key['nama']; ?></td>
                                                    <td data-order="<?php echo $key['create_date']; ?>"><?php echo date('d-M-Y',strtotime($key['create_date'])); ?></td>
                                                </tr>
                                            <?php $i++; endforeach ?>
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