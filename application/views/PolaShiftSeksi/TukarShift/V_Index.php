<section class="content">
    <div class="inner" >
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-11">
                            <div class="text-right"><h1><b><?= $Title ?></b></h1></div>
                        </div>
                        <div class="col-lg-1 ">
                            <div class="text-right hidden-md hidden-sm hidden-xs">
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('PolaShiftSeksi/TukarShift');?>">
                                    <i class="icon-wrench icon-2x"></i>
                                    <span ><br /></span>
                                </a>                             
                            </div>
                        </div>
                    </div>
                </div>
                <br />

                <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-primary box-solid">
                        <div class="box-header with-border">
                        <div class="col-md-12">
                            List Tukar Shift
                        </div>
                        </div>
                            <div class="box-body">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <a href="<?php echo base_url('PolaShiftSeksi/TukarShift/createTS') ?>" class="btn btn-success"><i class="fa fa-plus"></i> Add</a>
                                        </div>
                                        <div class="col-md-12" style="margin-top: 20px;">
                                            <table class="table table-bordered tabel_tukarShift">
                                                <thead class="bg-primary">
                                                    <tr>
                                                        <td width="5%">No</td>
                                                        <td>Tanggal</td>
                                                        <td>Pekerja 1</td>
                                                        <td>Pekerja 2</td>
                                                        <td>Inisiatif</td>
                                                        <td>Status</td>
                                                        <td>Tanggal Input</td>
                                                        <td>Action</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $i = 1; foreach ($listTukar as $key): ?>
                                                        <tr>
                                                            <td><?= $i ?></td>
                                                            <td data-order="<?php echo substr($key['tanggal1'], 0,10) ?>"><?= date('d-M-Y', strtotime(substr($key['tanggal1'], 0,10))) ?></td>
                                                            <td><?= $key['noind1'].' - '.$key['nama1'] ?></td>
                                                            <td><?= $key['noind2'].' - '.$key['nama2'] ?></td>
                                                            <?php if ($key['optpekerja'] == 't'): ?>
                                                                <td><?= 'Pribadi' ?></td>
                                                            <?php else: ?>
                                                                <td><?= 'Perusahaan' ?></td>
                                                            <?php endif ?>
                                                            <td><?php 
                                                            if ($key['status'] == '01') {
                                                                echo "<p style='color: #ffbf00'>Menunggu Approval</p>";
                                                            }elseif ($key['status'] == '02') {
                                                                echo "<p style='color: #00a65a'>Approved</p>";
                                                            }else{
                                                                echo "<p style='color: #d3232d'>Rejected</p>";
                                                            }
                                                             ?></td>
                                                             <td><?= $key['create_timestamp'] ?></td>
                                                            <td class="text-center">
                                                                <a href="<?php echo base_url('PolaShiftSeksi/TukarShift/lihatView/'.$key['tukar_id']) ?>" title="View" class="btn btn-primary btn-md"><i class="fa fa-file-text-o"></i></a>
                                                            </td>
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
    </div>
</section>
<div id="surat-loading" hidden style="top: 0;left: 0;right: 0;bottom: 0; margin: auto; position: fixed; background: rgba(0,0,0,.5); z-index: 11;">
    <img src="<?php echo site_url('assets/img/gif/loadingtwo.gif');?>" style="position: fixed; top: 0;left: 0;right: 0;bottom: 0; margin: auto; width: 40%;">
</div>