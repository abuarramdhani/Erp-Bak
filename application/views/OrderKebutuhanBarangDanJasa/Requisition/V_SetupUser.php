<style>
    .tblOKBNewOrderList thead tr th {
        text-align: center;
    }
    .txaOKBNewOrderListReason, .txaOKBNewOrderListNote {
        height: 34px;
        resize: vertical;
    }
    .divOKBScrollable {
		overflow-x: scroll;
	}
    .ml-15px {
        margin-left: 15px;
    }
    .bold {
        font-weight: bold;
    }
    .organizationOKB+.select2-container>.selection>.select2-selection, .locationOKB+.select2-container>.selection>.select2-selection,.subinventoryOKB+.select2-container>.selection>.select2-selection{
        text-align: center;
    }
</style>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1> Order Kebutuhan Barang dan Jasa </h1>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">

        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Setup User</h3>
                </div>

                <div class="box-body">
                    <div class="box-body table-responsive no-padding">
                        <div class="panel panel-warning">
							<div class="panel-heading">
                                <div style="float: right">
                                    <button type="button" class="btn btn-md btn-primary btnAddUser" title="Tambah Data"><i class="fa fa-plus"></i></button>
                                </div>
                                <p class="bold">Setting</p>
  							</div>
                            <form action="<?php echo base_url('OrderKebutuhanBarangDanJasa/Requisition/setUser')?>" method="post" enctype="multipart/form-data">
                                <div class="panel-body">
                                    <div class="col-lg-12">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr class="bg-primary">
                                                    <th>Kasie</th>
                                                    <th>Unit 1</th>
                                                    <th>Unit 2</th>
                                                    <th>Department</th>
                                                    <!-- <th>Direksi</th> -->
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="trOKBNewSetupUserDataRow" data-row="1">
                                                    <td><select class="select2 slcAtasanOKB" style="width:200px" name="slcAtasanOKB[]" required></td>
                                                    <td><select class="select2 slcAtasanOKB" style="width:200px" name="slcAtasanUnit1OKB[]" required></td>
                                                    <td><select class="select2 slcAtasanOKB" style="width:200px" name="slcAtasanUnit2OKB[]"></td>
                                                    <td><select class="select2 slcAtasanOKB" style="width:200px" name="slcAtasanDepartmentOKB[]" required></td>
                                                    <!-- <td><input type="text" class="form-control" name="" value="Hendro Wijayanto" readonly></td> -->
                                                    <td>
                                                        <button type="button" class="btn btn-danger btnOKBNewUserDelete" title="Hapus" disabled><i class="fa fa-trash"></i></button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <div class="pull-right">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>