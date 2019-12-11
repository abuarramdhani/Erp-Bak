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
                            List Import Shift
                        </div>
                        </div>
                            <div class="box-body">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <a href="<?php echo base_url('PolaShiftSeksi/ImportPolaShift/addImShift') ?>" class="btn btn-success"><i class="fa fa-plus"></i> Add</a>
                                        </div>
                                        <div class="col-md-12" style="margin-top: 20px;">
                                            <table class="table table-bordered tbl_tlis">
                                                <thead class="bg-primary">
                                                    <tr>
                                                        <td width="5%">No</td>
                                                        <td>Seksi</td>
                                                        <td>Periode</td>
                                                        <td width="20%">Atasan</td>
                                                        <td>Status</td>
                                                        <td>Tanggal Import</td>
                                                        <td>Action</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php $i = 1; foreach ($listImpShift as $key): ?>
                                                    <tr>
                                                        <td><?= $i ?></td>
                                                        <td><?= $key['seksi'] ?></td>
                                                        <td><?= $key['periode'] ?></td>
                                                        <td><?= $key['atasan'].' - '.rtrim($key['employee_name']) ?></td>
                                                        <td>
                                                        <?php 
                                                            if (!empty($key['alasan'])) {
                                                                echo '<label style="color: red">Rejected</label>';
                                                            }elseif (!empty($key['tgl_approve'])) {
                                                                 echo '<label style="color: green">Approved</label>';
                                                            }else{
                                                                echo '<label style="color: grey">Pending</label>';
                                                            }
                                                         ?>
                                                         </td>
                                                         <td><?= $key['tgl_import'] ?></td>
                                                        <td class="text-center">
                                                            <a target="_blank" href="<?php echo base_url('PolaShiftSeksi/ImportPolaShift/ViewList/'.$key['kodesie'].'/'.$key['periode'].'/'.$key['tgl_import']) ?>" title="View" class="btn btn-primary"><i class="fa fa-eye"></i></a>
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