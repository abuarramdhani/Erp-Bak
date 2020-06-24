<style>
    .select2-search__field{
        text-transform: uppercase;
    }
    .div_kotak{
        height: 150px;
        border-radius: 10px;
        background-color: blue;
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
                            </div>
                            <div class="box-body">
                                <div class="panel-body">
                                    <div class="col-md-1">
                                        <label style="margin-top: 5px">Status</label>
                                    </div>
                                    <div class="col-md-2">
                                        <select class="form-control pad_slcInit" id="pad_slcStat">
                                            <option <?=($stat == 'all') ? 'selected':'' ?> value="all">Semua Data</option>
                                            <option <?=($stat == '0') ? 'selected':'' ?> value="0">New</option>
                                            <option <?=($stat == '1') ? 'selected':'' ?> value="1">Approved</option>
                                            <option <?=($stat == '2') ? 'selected':'' ?> value="2">Rejected</option>
                                        </select>
                                    </div>
                                    <div class="col-md-12" style="margin-top: 50px;">
                                        <table class="table table-bordered table-hover table-striped text-center pad_tblpkj">
                                            <thead class="bg-primary">
                                                <th>No</th>
                                                <th>Noind</th>
                                                <th>Nama</th>
                                                <th>Seksi</th>
                                                <th>Tgl Approve</th>
                                                <th>Tgl Pembuatan</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </thead>
                                            <tbody>
                                                <?php $x=1; foreach ($list as $key): ?>
                                                <tr>
                                                    <td><?=$x?></td>
                                                    <td><?=$key['noind']?></td>
                                                    <td><?=$key['nama']?></td>
                                                    <td><?=$key['seksi']?></td>
                                                    <td><?=$key['approve_date']?></td>
                                                    <td><?=$key['create_date']?></td>
                                                    <?php 
                                                        if($key['status'] == '1')
                                                            $color = 'green';
                                                        elseif ($key['status'] == '2')
                                                            $color = 'red';
                                                        else
                                                            $color = 'black';
                                                    ?>
                                                    <td style="color: <?=$color?>;">
                                                        <label><?=$key['stat']?></label>
                                                    </td>
                                                    <td>
                                                        <?php if ($key['status'] == 0): ?>
                                                            <a class="btn btn-success" href="<?=base_url('pengembalian-apd/hubker/view_data_detail?id='.$key['id'])?>" title="detail">
                                                                <i class="fa fa-eye"></i>
                                                            </a>
                                                        <?php else: ?>
                                                            <a class="btn btn-success" href="<?=base_url('pengembalian-apd/hubker/view_only?id='.$key['id'])?>" title="detail">
                                                                <i class="fa fa-eye"></i>
                                                            </a>
                                                        <?php endif ?>
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