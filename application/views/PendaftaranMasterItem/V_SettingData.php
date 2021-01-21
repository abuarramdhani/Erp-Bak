<script>
$(document).ready(function () {
    $('.tblsettingpiea').DataTable({
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
                        <div class="box box-warning">
                        <div class="box-header text-center" style="font-size:20px">
                            <div class="col-md-2"></div>
                            <div class="col-md-8">
                                <strong>DATA ORGANIZATION GROUP</strong>
                            </div>
                            <div class="col-md-2 text-right">
                                <button  type="button" class="btn btn-success" onclick="mdltambahorg()"><i class="fa fa-plus"></i> Tambah</button>
                            </div>
                        </div>
                            <div class="box-body">
                                <div class="panel-body">
                                    <div>
                                        <table class="table table-bordered table-hover table-striped text-center tblsettingpiea" style="width: 100%;">
                                            <thead style="background-color:#FF955A">
                                                <tr class="text-nowrap">
                                                    <th style="width:7%">No</th>
                                                    <th>Group Name</th>
                                                    <th>List Organization</th>
                                                    <th style="width:20%">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php $n = 1; foreach ($org as $val) {?>
                                                <tr>
                                                    <td><input type="hidden" id="id_org<?= $n?>" value="<?= $val['ID_ORG']?>"><?= $n?></td>
                                                    <td><input type="hidden" id="nama_group<?= $n?>" value="<?= $val['GROUP_NAME']?>"><?= $val['GROUP_NAME']?></td>
                                                    <td><input type="hidden" id="org_assign<?= $n?>" value="<?= $val['ORG_ASSIGN']?>"><?= $val['ORG_ASSIGN']?></td>
                                                    <td><button type="button" class="btn btn-xs btn-info" onclick="editorg_group(<?= $n?>)"><i class="fa fa-pencil"></i> Edit</button>
                                                        <button type="button" class="btn btn-xs btn-danger" onclick="deleteorg_group(<?= $n?>)"><i class="fa fa-trash"></i> Delete</button></td>
                                                </tr>
                                            <?php $n++; }?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-success">
                        <div class="box-header text-center" style="font-size:20px">
                            <div class="col-md-2"></div>
                            <div class="col-md-8">
                                <strong>DATA KODE SEKSI</strong>
                            </div>
                            <div class="col-md-2 text-right">
                                <button  type="button" class="btn btn-success" onclick="mdltambahseksi()"><i class="fa fa-plus"></i> Tambah</button>
                                <!-- <button class="btn btn-success" formaction="<?php echo base_url('MasterItemPIEA/SettingData/tambahkodeseksi') ?>"><i class="fa fa-plus"></i> Tambah</button> -->
                            </div>
                        </div>
                            <div class="box-body">
                                <div class="panel-body">
                                    <div>
                                        <table class="table table-bordered table-hover table-striped text-center tblsettingpiea" style="width: 100%;">
                                            <thead style="background-color:#51E080">
                                                <tr class="text-nowrap">
                                                    <th style="width:7%">No</th>
                                                    <th>Seksi</th>
                                                    <th>Kode</th>
                                                    <th style="width:20%">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php $no = 1; foreach ($seksi as $val) {?>
                                                <tr>
                                                    <td><input type="hidden" id="id_seksi<?= $no?>" value="<?= $val['ID_SEKSI']?>"><?= $no?></td>
                                                    <td><input type="hidden" id="nama_seksi<?= $no?>" value="<?= $val['NAMA_SEKSI']?>"><?= $val['NAMA_SEKSI']?></td>
                                                    <td><input type="hidden" id="kode_seksi<?= $no?>" value="<?= $val['KODE_SEKSI']?>"><?= $val['KODE_SEKSI']?></td>
                                                    <td><button type="button" class="btn btn-xs btn-danger" onclick="deleteseksi(<?= $no?>)"><i class="fa fa-trash"></i> Delete</button></td>
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

                <br /> 
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-info">
                        <div class="box-header text-center" style="font-size:20px">
                            <div class="col-md-2"></div>
                            <div class="col-md-8">
                                <strong>DATA KODE UOM</strong>
                            </div>
                            <div class="col-md-2 text-right">
                                <button type="button" class="btn btn-success" onclick="mdltambahuom()"><i class="fa fa-plus"></i> Tambah</button>
                            </div>
                        </div>
                            <div class="box-body">
                                <div class="panel-body">
                                    <div>
                                        <table class="table table-bordered table-hover table-striped text-center tblsettingpiea" style="width: 100%;">
                                            <thead style="background-color:#5DBDF5">
                                                <tr class="text-nowrap">
                                                    <th style="width:7%">No</th>
                                                    <th>UOM</th>
                                                    <th>Kode</th>
                                                    <th style="width:20%">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php $num = 1; foreach ($uom as $val) {?>
                                                <tr>
                                                    <td><input type="hidden" id="id_uom<?= $num?>" value="<?= $val['ID_UOM']?>"><?= $num?></td>
                                                    <td><input type="hidden" id="nama_uom<?= $num?>" value="<?= $val['UOM']?>"><?= $val['UOM']?></td>
                                                    <td><input type="hidden" id="kode_uom<?= $num?>" value="<?= $val['KODE_UOM']?>"><?= $val['KODE_UOM']?></td>
                                                    <td><button type="button" class="btn btn-xs btn-danger" onclick="deleteuom(<?= $num?>)"><i class="fa fa-trash"></i> Delete</button></td>
                                                </tr>
                                            <?php $num++; }?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-danger">
                        <div class="box-header text-center" style="font-size:20px">
                            <div class="col-md-2"></div>
                            <div class="col-md-8">
                                <strong>DATA EMAIL PIEA</strong>
                            </div>
                            <div class="col-md-2 text-right">
                                <button  type="button" class="btn btn-success" onclick="mdltambahemail()"><i class="fa fa-plus"></i> Tambah</button>
                                <input type="hidden" id="keterangan" value="<?= $view?>">
                            </div>
                        </div>
                            <div class="box-body">
                                <div class="panel-body">
                                    <div>
                                        <table class="table table-bordered table-hover table-striped text-center tblsettingpiea" style="width: 100%;">
                                            <thead style="background-color:#FF7070">
                                                <tr class="text-nowrap">
                                                    <th style="width:7%">No</th>
                                                    <th>Alamat Email</th>
                                                    <th style="width:20%">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php $nom = 1; foreach ($email as $val) {?>
                                                <tr>
                                                    <td><input type="hidden" id="id_email<?= $nom?>" value="<?= $val['ID_EMAIL']?>"><?= $nom?></td>
                                                    <td><input type="hidden" id="nama_email<?= $nom?>" value="<?= $val['EMAIL']?>"><?= $val['EMAIL']?></td>
                                                    <td><button type="button" class="btn btn-xs btn-danger" onclick="deleteemail(<?= $nom?>)"><i class="fa fa-trash"></i> Delete</button></td>
                                                </tr>
                                            <?php $nom++; }?>
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


<form method="post" class="frmpreqpiea">
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