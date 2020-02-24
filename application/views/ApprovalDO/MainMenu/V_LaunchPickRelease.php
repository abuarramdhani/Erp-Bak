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
                    <h3 class="box-title">Launch Pick Release</h3>
                </div>
                <div class="box-body">
                    <div class="box-body table-responsive no-padding">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <p class="bold">Launch Pick Release List</p>
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
                                            <th width="10%" class="text-center">No</th>
                                            <th width="45%" class="text-center">No SO</th>
                                            <th width="45%" class="text-center no-orderable">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($SOList as $key => $val) : ?>
                                            <tr>
                                                <td width="10%" class="text-right"><?= $key+1 ?></td>
                                                <td width="45%" class="text-right tdASODONumber"><?= $val['SOURCE_HEADER_NUMBER'] ?></td>
                                                <td width="45%" class="text-center">
                                                    <a href="<?= base_url('ApprovalDO/Detail/LaunchPickRelease--'.$val['SOURCE_HEADER_NUMBER']) ?>" target="_blank" title="Detail" class="btn btn-default">
                                                        <i class="fa fa-book"></i>&nbsp; Detail
                                                    </a>&nbsp;
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