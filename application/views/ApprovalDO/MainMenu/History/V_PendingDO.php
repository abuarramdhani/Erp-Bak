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
                    <h3 class="box-title">History Pending Delivery Order</h3>
                </div>
                <div class="box-body">
                    <div class="box-body table-responsive no-padding">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <p class="bold">Pending DO List</p>
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
                                            <th width="4%" class="text-center">No</th>
                                            <th width="11%" class="text-center">No DO</th>
                                            <th width="11%" class="text-center">No SO</th>
                                            <th width="14%" class="text-center">Request Date</th>
                                            <th width="13%" class="text-center">Request By</th>
                                            <th width="14%" class="text-center">Pending Date</th>
                                            <th width="13%" class="text-center">Pending By</th>
                                            <th width="10%" class="text-center no-orderable">Action</th>
                                            <th width="10%" class="text-center">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($PendingDOList as $key => $val) : ?>
                                            <tr>
                                                <td width="4%" class="text-right"><?= $key+1 ?></td>
                                                <td width="11%" class="text-right tdADODONumber"><?= $val['NO_DO'] ?></td>
                                                <td width="11%" class="text-right tdASODONumber"><?= $val['NO_SO'] ?></td>
                                                <td width="14%" class="text-right"><?= $val['REQUEST_DATE'] ?></td>
                                                <td width="13%"><?= $val['REQUEST_BY'] ?></td>
                                                <td width="14%" class="text-right"><?= $val['PENDING_DATE'] ?></td>
                                                <td width="13%"><?= $val['PENDING_BY'] ?></td>
                                                <td width="10%" class="text-center">
                                                    <a href="<?= base_url('ApprovalDO/Detail/Pending-'.$val['NO_DO'].'-'.$val['NO_SO']) ?>" target="_blank" title="Detail" class="btn btn-default">
                                                        <i class="fa fa-book"></i>&nbsp; Detail
                                                    </a>
                                                </td>
                                                <td width="10%" class="text-center">
                                                    <span class="label label-default">Pending</span>
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