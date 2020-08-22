<style>    
    label {
        font-weight: normal !important;
    }
    .label {
        font-size: 90% !important;
        display: inline-block;
        width: 100px;
        padding: 5px;
    }
    .mailbox-attachments li {
        width: 225px !important;
    }    
    .mr-20px {
        margin-right: 20px;
    }
    .swal-font-small {
        font-size: 1.5rem !important;
    }
</style>

<section class="content-header">
    <h1><?= $UserMenu[0]['user_group_menu_name'] ?> </h1>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">History Request Approval Delivery Order</h3>
                </div>
                <div class="box-body">
                    <div class="box-body table-responsive no-padding">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <p class="bold">Req. Approval DO List</p>
                            </div>
                            <div class="panel-body">
                                <div class="col-sm-12 text-center divADOLoadingTable">
                                    <label class="control-label">
                                        <p><img src="<?= base_url('assets/img/gif/loading5.gif') ?>" style="width:30px"> Sedang Memproses ...</p> 
                                    </label>
                                </div>
                                <table class="table table-bordered table-hover table-striped tblADOList" style="display: none">
                                    <thead>
                                        <tr class="bg-primary" height="50px">
                                            <th width="5%" class="text-center">No</th>
                                            <th width="12%" class="text-center">No DO</th>
                                            <th width="12%" class="text-center">No SO</th>
                                            <th width="15%" class="text-center">Request Date</th>
                                            <th width="18%" class="text-center">Request By</th>
                                            <th width="18%" class="text-center">Request To</th>
                                            <th width="10%" class="text-center no-orderable">Action</th>
                                            <th width="10%" class="text-center">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($RequestedDOList as $key => $val) : ?>
                                            <tr>
                                                <td width="5%" class="text-right"><?= $key+1 ?></td>
                                                <td width="12%" class="text-right tdADODONumber"><?= $val['NO_DO'] ?></td>
                                                <td width="12%" class="text-right tdASODONumber"><?= $val['NO_SO'] ?></td>
                                                <td width="15%" class="text-right"><?= $val['REQUEST_DATE'] ?></td>
                                                <td width="18%" ><?= $val['REQUEST_BY'] ?></td>
                                                <td width="18%" >
                                                    <?php
                                                        if ( $val['STATUS'] == 'Req Approval') {
                                                            echo $val['REQUEST_TO'];
                                                        }elseif ($val['STATUS'] == 'Req Approval 2') {
                                                            echo $val['REQUEST_TO_2'];
                                                        }
                                                    ?>
                                                </td>
                                                <td width="10%" class="text-center">
                                                    <?php if ($val['NO_SO']) : ?>
                                                        <a href='<?= base_url("ApprovalDO/Detail/Requested-{$val['NO_DO']}-{$val['NO_SO']}") ?>' target="_blank" title="Detail" class="btn btn-default">
                                                            <i class="fa fa-book"></i>&nbsp; Detail
                                                        </a>
                                                    <?php else : ?>
                                                        <a href='<?= base_url("ApprovalDO/Detail/RequestedSPB-{$val['NO_DO']}-") ?>' target="_blank" title="Detail" class="btn btn-default">
                                                            <i class="fa fa-book"></i>&nbsp; Detail
                                                        </a>
                                                    <?php endif ?>
                                                </td>
                                                <td width="10%" class="text-center">
                                                    <span class="label label-primary"><?= $val['STATUS'];?></span>
                                                </td>
                                            </tr>
                                        <?php endforeach ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-footer"></div>
            </div>
        </div>
    </div>
</section>

