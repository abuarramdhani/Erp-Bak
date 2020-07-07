<script>
    $(document).ready(function () {
        $('.tblcutminmax').dataTable({
            "scrollX": true,
        });
    
    });
</script>
<section class="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-11">
                            <div class="text-right">
                                <h1>
                                    <b>
                                        <?= $Title ?> 
                                    </b>
                                </h1>
                            </div>
                        </div>
                        <div class="col-lg-1 ">
                            <div class="text-right hidden-md hidden-sm hidden-xs">
                                <a class="btn btn-default btn-lg"
                                    href="<?php echo site_url('MonitoringCuttingTool/SettingMin');?>">
                                    <i class="fa fa-2x fa-cogs">
                                    </i>
                                    <span>
                                        <br />
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <br />
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-primary box-solid">
                        <div class="box-header">
                                <div class="col-md-6 text-left"><h4><strong>Setting Min</strong></h4></div>
                                <div class="col-md-6 text-right">
                                    <button type="submit" class="btn btn-success" onclick="tambahdata()"><i class="fa fa-plus"></i> Tambah</button>
                                </div>
                            </div>
                            <div class="box-body">
                            <!-- <form method="post" action="<?php echo base_url('MonitoringCuttingTool/SettingMin/Save')?>">
                                <div class="panel-body">
                                <div class="col-md-5" style="text-align:right">
                                        <label>Kode Barang :</label></div>
                                    <div class="col-md-3">
                                        <select name="item" class="form-control getkodebrg" data-placeholder="pilih kode barang">
                                            <option></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="panel-body">
                                <div class="col-md-5" style="text-align:right">
                                        <label>Min TR-TKS :</label></div>
                                    <div class="col-md-3">
                                        <input type="number" name="min_trtks" class="form-control" placeholder="min tr-tks" autocomplete="off">
                                    </div>
                                </div>
                                <div class="panel-body">
                                <div class="col-md-5" style="text-align:right">
                                        <label>Min TM-DM :</label></div>
                                    <div class="col-md-3">
                                        <input type="number" name="min_tmdm" class="form-control" placeholder="min tm-dm" autocomplete="off">
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div class="col-md-12" style="text-align:center">
                                        <button type="submit" class="btn btn-lg btn-success"> Save</button>
                                    </div>
                                </div>
                            <form> -->

                                <div class="panel-body">
                                    <div class="table-responsive" >
                                        <table class="datatable table table-bordered table-hover table-striped text-center tblcutminmax" style="width: 100%;">
                                            <thead class="bg-info">
                                                <tr>
                                                    <th style="width:5%">No</th>
                                                    <th>Kode Barang</th>
                                                    <th>Deskripsi Barang</th>
                                                    <th>MIN</th>
                                                    <th>MAX</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php $no = 1; foreach ($data as $val) {?>
                                                <tr>
                                                    <td><?= $no?></td>
                                                    <td><input type="hidden" id="item<?= $no?>" value="<?= $val['item']?>"><?= $val['item']?></td>
                                                    <td><input type="hidden" id="item<?= $no?>" value="<?= $val['desc']?>"><?= $val['desc']?></td>
                                                    <td><input type="hidden" id="min<?= $no?>" value="<?= $val['min_tr_tks']?>"><?= $val['min_tr_tks']?></td>
                                                    <td><input type="hidden" id="max<?= $no?>" value="<?= $val['max_tr_tks']?>"><?= $val['max_tr_tks']?></td>
                                                    <td><button type="button" class="btn btn-warning" onclick="mdleditminmax(<?= $no?>)"><i class="fa fa-pencil"></i> Edit</button></td>
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
            </div>
        </div>
    </div>
</section>

<form method="post" action="<?php echo base_url("MonitoringCuttingTool/SettingMin/Save"); ?>">
<div class="modal fade" id="mdlminmaxCutt" role="dialog">
    <div class="modal-dialog" style="width:60%;padding-top:50px">
      <div class="modal-content">
        <div class="modal-body">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <div id="datamdlminmax"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>
</form>