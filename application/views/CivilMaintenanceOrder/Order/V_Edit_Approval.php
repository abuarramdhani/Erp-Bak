<style>
    .dataTables_filter{
        float: right;
    }
    .buttons-excel{
        background-color: green;
        color: white;
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
                            <div class="box-header with-border"></div>
                            <div class="box-body">
                                <div class="col-md-12" style="margin-top: 10px;">
                                    <div class="col-md-8">
                                        <div class="col-md-12">
                                            <label>Approval</label>
                                            <table class="table table-bordered mco_tbl_approver">
                                                <thead class="bg-info">
                                                    <th>No</th>
                                                    <th>Jenis Approve</th>
                                                    <th>Apprver</th>
                                                    <th>Status</th>
                                                    <th>Act</th>
                                                </thead>
                                                <tbody>
                                                    <?php $x=1; foreach ($approve as $key): ?>
                                                    <tr>
                                                        <td class="mco_daftarnoPek"><?=$x?></td>
                                                        <td>
                                                            <select data-id="<?= $key['order_approver_id'] ?>" class="form-control mco_slc" kolom="jenis_approver" style="width: 100%">
                                                                <option></option>
                                                                <option <?=($key['jenis_approver']==1) ? 'selected':''?> value="1">Pengorder</option>
                                                                <option <?=($key['jenis_approver']==2) ? 'selected':''?> value="2">Civil</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <select data-id="<?= $key['order_approver_id'] ?>" kolom="approver" style="width: 100%" required class="form-control cmo_slcPkj">
                                                                <option selected="" value="<?= $key['approver'] ?>">
                                                                    <?= $key['approver'].' - '.$key['employee_name'] ?>
                                                                </option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input class="form-control" value="<?= $this->M_civil->getJabatanPKJ($key['approver'])->row()->jabatan; ?>" readonly>
                                                        </td>
                                                        <td>
                                                            <button value="<?= $key['order_approver_id'] ?>" type="button" class="btn btn-xs btn-danger mco_delApprover"><i class="fa fa-times"></i></button>
                                                        </td>
                                                    </tr>
                                                    <?php $x++; endforeach ?>
                                                </tbody>
                                            </table>
                                            <button type="button" class="btn btn-sm btn-success pull-right" data-toggle="modal" data-target="#edit_aproval">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-md-12 text-center" style="margin-top: 20px;">
                                        <a class="btn btn-warning btn-lg mco_getBack">Kembali</a>
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
<div class="modal fade" id="edit_aproval" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form method="post" action="<?= base_url('civil-maintenance-order/order/add_approver') ?>">
        <div class="modal-content">
            <div class="modal-header">
                <label class="modal-title" id="exampleModalLongTitle">Tambah Approver</label>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body clearfix">
                <table class="table table-bordered" id="mco_tbl_approver">
                    <thead class="bg-info">
                        <th>No</th>
                        <th>Jenis Approve</th>
                        <th>Apprver</th>
                        <th>Jabatan</th>
                        <th>Act</th>
                    </thead>
                    <tbody class="mco_daftarApp_Append">
                        <tr class="mco_daftarApp">
                            <td class="mco_daftarnoPek">1</td>
                            <td>
                                <select name="tbl_japprove[]" class="form-control mco_slc" style="width: 100%" required>
                                    <option></option>
                                    <option value="1">Pengorder</option>
                                    <option value="2">Civil</option>
                                </select>
                            </td>
                            <td>
                                <select style="width: 100%" required class="form-control cmo_slcPkj" name="tbl_approver[]">

                                </select>
                            </td>
                            <td>
                               <input readonly="" class="form-control cmoisiJabatan">
                            </td>
                            <td>
                                <button type="button" class="btn btn-xs btn-danger mco_deldaftarnoApp"><i class="fa fa-times"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <button type="button" class="btn btn-sm btn-success pull-right mco_addRowApp">
                    <i class="fa fa-plus"></i>
                </button>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" value="<?=$id?>" name="id" class="btn btn-primary">Submit</button>
            </div>
        </div>
        </form>
    </div>
</div>
<script>
    window.addEventListener('load', function () {
        mco_initEditApproval();
    });
</script>