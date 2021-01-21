<script>
$(document).ready(function () {
    $('.tbldataemail').DataTable({
        "scrollX" : true,
    });
})
</script>
<section class="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <form method="post">
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-primary">
                        <div class="box-header text-center" style="font-size:20px">
                            <div class="col-md-2"></div>
                            <div class="col-md-8">
                                <strong>DATA EMAIL</strong>
                            </div>
                            <div class="col-md-2 text-right">
                            <?php 
                                // jika resp. pendaftaran master item dan email user login sudah terdaftar = btn tambah email display none
                                $tambah = $view == 'Seksi' && $ket == 'ada' ? 'display:none' : ''; 
                            ?>
                                <button  type="button" class="btn btn-success" style="<?= $tambah?>" onclick="mdltambahemail()"><i class="fa fa-plus"></i> Tambah</button>
                                <input type="hidden" id="keterangan" value="<?= $view?>">
                            </div>
                        </div>
                            <div class="box-body">
                                <div class="panel-body">
                                    <div>
                                        <table class="table table-bordered table-hover table-striped text-center tbldataemail" style="width: 100%;">
                                            <thead class="bg-info">
                                                <tr class="text-nowrap">
                                                    <th style="width:7%">No</th>
                                                    <th>Alamat Email</th>
                                                    <th style="width:20%">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php $no = 1; foreach ($data as $val) {?>
                                                <tr>
                                                    <td><input type="hidden" id="id_email<?= $no?>" value="<?= $val['ID_EMAIL']?>"><?= $no?></td>
                                                    <td><input type="hidden" id="nama_email<?= $no?>" value="<?= $val['EMAIL']?>"><?= $val['EMAIL']?></td>
                                                    <td><button type="button" class="btn btn-sm btn-danger" onclick="deleteemail(<?= $no?>)"><i class="fa fa-trash"></i> Delete</button></td>
                                                </tr>
                                            <?php $no++; }?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</section>


<form method="post">
<div class="modal fade" id="mdlReqMasterItem" role="dialog">
    <div class="modal-dialog" style="padding-right:5px">
      <!-- Modal content-->
      <div class="modal-content" style="border-radius:25px">
        <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
            <div id="datareq"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>
</form>