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
                            <a href="<?=base_url('PatroliSatpam/web/add_rekap_bulanan')?>" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Tambah</a>
                            </div>
                            <div class="box-body">
                                <div class="panel-body">
                                    <table class="table table-bordered table-hover table-striped text-center pts_tblask">
                                        <thead class="bg-primary">
                                            <th>No</th>
                                            <th>Periode</th>
                                            <th>Tanggal Cetak</th>
                                            <th>Action</th>
                                        </thead>
                                        <tbody>
                                            <?php $x=1; foreach ($list as $key): ?>
                                                <tr>
                                                    <td><?=$x?></td>
                                                    <td data-order="<?=$key['periode']?>"><?=$this->konversibulan->konvert_periode_en($key['periode']);?></td>
                                                    <td data-order="<?=$key['create_date']?>"><?=date('d-M-Y H:i:s', strtotime($key['create_date']))?></td>
                                                    <td>
                                                        <a target="_blank" href="<?=base_url('PatroliSatpam/web/patroli_read_file?id='.$key['id'])?>" class="btn btn-info">
                                                            <i class="fa fa-file-pdf-o"></i>
                                                        </a>
                                                        <a class="btn btn-primary" href="<?=base_url('PatroliSatpam/web/add_rekap_bulanan?pr='.$key['periode'].'&id='.$key['id'])?>">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                        <button class="btn btn-danger pts_delrkpData" value="<?=$key['id']?>">
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
</section>
<div hidden id="surat-loading" style="top: 0;left: 0;right: 0;bottom: 0; margin: auto; position: fixed; background: rgba(0,0,0,.5); z-index: 11;">
    <img src="http://erp.quick.com/assets/img/gif/loadingtwo.gif" style="position: fixed; top: 0;left: 0;right: 0;bottom: 0; margin: auto; width: 40%;">
</div>