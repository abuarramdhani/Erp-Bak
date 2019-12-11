<style>
    .center{
        text-align: center;
    }
    tbody>tr>td{
        text-align: center;
    }
	thead>tr{
		font-weight: bold;
	}
    .modal-content {
        top: 2em !important;
        border-radius: 10px !important;
        z-index: 1;
    }
</style>
<section class="content">
    <div class="panel-body">
        <div class="row">
            <div class="box box-success box-solid">
                <div class="box-header with-border">
                    <h2><b>Data Approved - Personalia <?= $lv ?></b></h2>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="datatable table table-striped table-bordered table-hover text-left SendDocument" style="font-size: 12px;">
                            <thead class="bg-primary center">
                                <tr>
                                    <td>No</td>
                                    <td>Nomor Induk</td>
                                    <td>Nama</td>
                                    <td>Keterangan</td>
                                    <td>Tanggal</td>
                                    <td>Tanggal Approve</td>
                                    <td>Edit</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i=1; foreach($table as $row): ?>
                                    <tr>
                                        <td><?= $i++ ?></td>
                                        <td><?= $row['noind'] ?></td>
                                        <td><?= $row['nama'] ?></td>
                                        <td><?= $row['keterangan'] ?></td>
                                        <td><?= $row['tanggal'] ?></td>
                                        <td><?= $row['tgl_update'] ?></td>
                                        <td><button data-toggle="modal" data-target="#modalChange" class="btn btn-sm btn-success"><i class="fa fa-edit"></button></td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- modal edit button -->

<div class="modal fade" id="modalChange" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header modal-detail">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h3 class="modal-title center"><b>Detail</b></h3>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="modalDetail">Detail</label>
                        <input class="form-control" id="modalDetail" disabled>
                    </div>
                    <div class="form-group">
                        <label for="modalApp1">Approve 1</label>
                        <input class="form-control" id="modalApp1" disabled>
                    </div>
                    <div class="form-group">
                        <label for="modalApp2">Approve 2</label>
                        <input class="form-control" id="modalApp2" disabled>
                    </div>
                    <div class="form-group modalHistoryDiv borderHistory">
                        <!-- on js -->
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger">Reject</button>
                <button class="btn btn-success">Approve</button>
            </div>
            <div class="modal-footer">
                <small style="color:red;">*pastikan data valid</small>
            </div>
        </div>
    </div>
</div>