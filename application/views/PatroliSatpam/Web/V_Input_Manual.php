<style>
    th{
        text-align: center;
    }
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
                                <label style="margin-top: 15px;">List Input Manual</label>
                                <a href="<?= base_url('PatroliSatpam/web/add_input_manual') ?>" class="btn btn-primary btn-md" style="float: right;">
                                    <i class="fa fa-plus fa-2x"></i>
                                </a>
                            </div>
                            <div class="box-body">
                                <div class="panel-body">
                                    <div class="col-md-12" style="margin-top: 50px;">
                                        <table class="table table-bordered table-striped" id="pts_tblimanl">
                                            <thead class="bg-primary">
                                                <th>No</th>
                                                <th>Satpam</th>
                                                <th>Ronde</th>
                                                <th>Pos</th>
                                                <th>Waktu Scan</th>
                                                <th>Tanggal Shift</th>
                                                <th>Action</th>
                                            </thead>
                                            <tbody>
                                                <?php $x=1; foreach ($list as $key): ?>
                                                    <tr>
                                                        <td style="text-align: center;"><?=$x?></td>
                                                        <td><?= $key['noind'].' - '.$key['nama'] ?></td>
                                                        <td style="text-align: center;"><?= $key['ronde'] ?></td>
                                                        <td style="text-align: center;"><?= $key['pos'] ?></td>
                                                        <td style="text-align: center;"><?= $key['tgl_patroli'] ?></td>
                                                        <td style="text-align: center;"><?= $key['tgl_shift'] ?></td>
                                                        <td style="text-align: center;">
                                                            <a href="<?= base_url('PatroliSatpam/web/view_input_manual?id='.$key['id_patroli']) ?>" class="btn btn-primary" title="lihat data">
                                                                <i class="fa fa-eye"></i>
                                                            </a>
                                                            <button class="btn btn-danger pts_btndelmnl" value="<?=$key['id_patroli']?>">
                                                                <i class="fa fa-trash"></i>
                                                            </button>
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
<div hidden id="surat-loading" style="top: 0;left: 0;right: 0;bottom: 0; margin: auto; position: fixed; background: rgba(0,0,0,.5); z-index: 11;">
    <img src="http://erp.quick.com/assets/img/gif/loadingtwo.gif" style="position: fixed; top: 0;left: 0;right: 0;bottom: 0; margin: auto; width: 40%;">
</div>