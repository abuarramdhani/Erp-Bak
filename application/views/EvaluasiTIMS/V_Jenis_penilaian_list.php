<section class="content">
    <div class="inner" >
        <div class="row">
            <div class="col-lg-12">
                <div class="col-lg-11">
                    <div class="text-right">
                        <h1><b>Jenis Penilaian</b></h1>
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
                                <a href="<?php echo site_url('EvaluasiTIMS/Setup/InputJenisPenilaian')?>">
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
                                                <th>Jenis Penilaian</th>
                                                <th>M</th>
                                                <th>TIM</th>
                                                <th>TIMS</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php $a=1; foreach ($listJp as $key): ?>
                                            <tr>
                                                <td><?php echo $a; ?></td>
                                                <td><?php echo $key['jenis_penilaian']; ?></td>
                                                <td><?php echo $key['std_m']; ?></td>
                                                <td><?php echo $key['std_tim']; ?></td>
                                                <td><?php echo $key['std_tims']; ?></td>
                                            </tr>
                                        <?php $a++; endforeach ?>
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