<section class="content">
    <div class="inner" >
        <div class="row">
            <div class="col-lg-12">
                <div class="col-lg-11">
                    <div class="text-right">
                        <h1><b>Setup Standar TIMS</b></h1>
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
                            <div class="box-header with-border"></div>
                            <div class="box-body">
                                <div class="panel-body">
                                 <div class="row">
                                     <div class="col-md-12">
                                         <button style="float: right;" class="btn btn-success et_add_email">Add Email</button>
                                     </div>
                                     <div class="col-md-12" style="height: 20px;"></div>
                                     <table class="table table-striped table-bordered table-hover text-center et_jenis_penilaian">
                                        <thead>
                                            <tr class="bg-primary">
                                                <th width="10%">No</th>
                                                <th>Email</th>
                                                <th width="20%">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $no = 1; foreach ($email as $key): ?>
                                            <tr>
                                                <td>
                                                    <?php echo $no; ?>
                                                    <input hidden="" value="<?php echo $key['id']; ?>">
                                                </td>
                                                <td class="et_em" style="font-size: 18px;"><?php echo $key['email']; ?></td>
                                                <td>
                                                    <button class="btn btn-info btn-sm et_edit_email" data-toggle="tooltip" data-placement="top" title="Edit">
                                                        <span class="glyphicon glyphicon-edit"></span>
                                                    </button>
                                                    <button class="btn btn-danger btn-sm et_del_email" data-toggle="tooltip" data-placement="top" title="Hapus">
                                                        <span class="glyphicon glyphicon-remove"></span>
                                                    </button>
                                                </td>
                                            </tr>
                                            <?php $no++; endforeach ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div style="height: 50px;"></div>
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