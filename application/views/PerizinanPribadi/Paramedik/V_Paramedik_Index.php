<section class="content">
    <div class="inner" >
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-11">
                            <div class="text-right"><h1><b><?= $Title ?></b></h1></div>
                        </div>
                        <div class="col-lg-1">
                            <div class="text-right hidden-md hidden-sm hidden-xs">
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('PerizinanPribadi/V_Indexrekap');?>">
                                    <i class="icon-wrench icon-2x"></i>
                                    <br/>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <br/>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border"></div>
                            <div class="box-body">
                                <div class="panel-body">
                                    <div class="col-md-12">
                                        <table class="table table-bordered tabel_psp_all">
                                            <thead>
                                              <tr>
                                                <th class="text-center" style="white-space: nowrap">No</th>
                                                <th class="text-center" style="white-space: nowrap">Keputusan Anda</th>
                                                <th class="text-center" style="white-space: nowrap">ID Izin</th>
                                                <th class="text-center" style="white-space: nowrap">Nama Pekerja</th>
                                                <th class="text-center" style="white-space: nowrap">Tanggal Pengajuan</th>
                                                <th class="text-center" style="white-space: nowrap">Akan Keluar</th>
                                                <th class="text-center">Keterangan Pekerja</th>
                                                <th class="text-center">Keterangan Paramedik</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $x = 1; foreach ($list as $key): ?>
                                                <tr>
                                                    <td><?= $x ?></td>
                                                    <td class="text-center">
                                                        <?php 
                                                        if ($key['appr_paramedik'] == 't') {
                                                            echo '<span class="label label-success">Approved</span>';
                                                        }elseif ($key['appr_paramedik'] == 'f') {
                                                            echo '<span class="label label-danger">Rejected</span>';
                                                        }elseif ($key['appr_atasan'] == 'f') {
                                                            echo '<span class="label label-danger">Rejected Atasan</span>';
                                                        }elseif (empty($key['appr_atasan'])) {
                                                            echo '<span class="label label-warning">Belum Approve Atasan</span>';
                                                        }elseif (date('Y-m-d', strtotime($key['created_date'])) != date('Y-m-d')) {
                                                            echo '<span class="label label-default">Expired</span>';
                                                        }else{
                                                            echo '<button value="'.$key['id'].'" title="Approve" class="btn btn-sm btn-success ppd_id_iz"><i class="fa fa-check"></i></button> ';
                                                            echo '<button value="'.$key['id'].'" title="Reject" class="btn btn-sm btn-danger ppd_btn_rej"><i class="fa fa-close"></i></button>';
                                                        }
                                                        ?>
                                                    </td>
                                                    <td><?= $key['id'] ?></td>
                                                    <td style="white-space: nowrap;">
                                                        <?php foreach ($key['pekerja'] as $k){
                                                            echo $k.'<br>';
                                                        } 
                                                        ?>
                                                    </td>
                                                    <td><?= date('d-M-Y', strtotime($key['created_date'])) ?></td>
                                                    <td><?= $key['wkt_keluar'] ?></td>
                                                    <td><?= $key['keperluan']?></td>
                                                    <td><?= $key['ket_sakit']?></td>
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
<div id="surat-loading" style="top: 0;left: 0;right: 0;bottom: 0; margin: auto; position: fixed; background: rgba(0,0,0,.5); z-index: 11;" hidden="hidden">
    <img src="http://erp.quick.com/assets/img/gif/loadingtwo.gif" style="position: fixed; top: 0;left: 0;right: 0;bottom: 0; margin: auto; width: 40%;">
</div>
<!-- Approve -->
<div class="modal fade" id="ppd_prmdk_mdl" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <form method="post" action="<?= site_url('PerizinanPribadi/PSP/ApproveParamedik/approve');?>">
                <div class="modal-header">
                    <label class="modal-title" id="exampleModalLabel">Approve Data</label>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input name="id" id="ppd_mdl_id" hidden="" value="">
                    <div class="text-center">
                        <label>Masukan Keterangan Sakit</label>
                        <textarea required="" class="form-control" name="ket" placeholder="Masukan Keterangan..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Approve</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Reject -->
<div class="modal fade" id="ppd_prmdk_mdl_rej" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <form method="post" action="<?= site_url('PerizinanPribadi/PSP/ApproveParamedik/reject');?>">
                <div class="modal-header">
                    <label class="modal-title" id="exampleModalLabel">Reject Data</label>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input name="id" id="ppd_mdl_id_rej" hidden="" value="">
                    <div class="text-center">
                        <label>Masukan Alasan Reject</label>
                        <textarea required="" class="form-control" name="ket" placeholder="Masukan Alasan Reject..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Reject</button>
                </div>
            </form>
        </div>
    </div>
</div>