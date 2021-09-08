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
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border" style="font-size:20px"><b><i class="fa fa-cog"></i> <?= $Title?></b></div>
                            <div class="box-body">
                                <div class="col-md-12 text-right">
                                    <label class="control-label">
                                        <?php echo gmdate("l, d F Y", time()+60*60*7) ?>
                                    </label>
                                </div>
                                <br>
                                <div class="col-md-12 text-center">
                                    <div class="col-md-2"></div>
                                    <div class="col-md-8">
                                        <strong>DATA EMAIL</strong>
                                    </div>
                                    <div class="col-md-2 text-right">
                                        <button  type="button" class="btn btn-success" onclick="tambahemailPBG()"><i class="fa fa-plus"></i> Tambah</button>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="panel-body">
                                        <div>
                                            <table class="table table-bordered table-hover table-striped text-center tbldataemail" style="width: 100%;">
                                                <thead class="bg-info">
                                                    <tr class="text-nowrap">
                                                        <th style="width:7%">No</th>
                                                        <th>PIC</th>
                                                        <th>Alamat Email</th>
                                                        <th>Keterangan</th>
                                                        <th style="width:20%">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php $no = 1; foreach ($email as $v) {?>
                                                    <tr>
                                                        <td><?= $no?></td>
                                                        <td><input type="hidden" id="pic<?= $no?>" value="<?= $v['pic']?>"><?= $v['pic']?></td>
                                                        <td><input type="hidden" id="email<?= $no?>" value="<?= $v['email']?>"><?= $v['email']?></td>
                                                        <td><input type="hidden" id="keterangan<?= $no?>" value="<?= $v['keterangan']?>"><?= $v['keterangan']?></td>
                                                        <td><button type="button" class="btn btn-sm btn-danger" onclick="DeleteEmail(<?= $no?>)"><i class="fa fa-trash"></i> Delete</button></td>
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
    </div>
</section> 

<div class="modal fade" id="mdlEmailPBG" role="dialog" aria-labelledby="myModalLoading">
    <div class="modal-dialog" role="document" style="width: 70%">
        <div class="modal-content">
            <div class="modal-header">
                <div class="panel-body text-center">
                    <h3>Tambah Data Email</h3>
                </div>
            </div>
            <div class="modal-body">
                <div class="panel-body">   
                    <div class="col-md-1"></div>  
                    <div class="col-md-10"> 
                        <label>PIC</label>
                        <select class="form-control select2 pic_email" name="pic_email" id="pic_email" style="width: 100%;" onchange="getEmailPic()">
                        </select>
                        <label>Email</label>                            
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-envelope"></i>
                            </div>
                            <input id="email" name="email" class="form-control" placeholder="Masukkan Email" autocomplete="off">
                        </div>
                        <label>Keterangan</label>
                        <select id="ket" name="ket" class="form-control select2" style="width: 100%;">
                            <option></option>
                            <option value="GUDANG">GUDANG</option>
                            <option value="QC">QC</option>
                        </select>
                    </div>
                    <div class="col-md-1"></div>
                </div> 
            </div>
            <div class="modal-footer">
                <div class="panel-body text-center">
                    <button class="btn btn-success" onclick="SaveEmail()"><i class="fa fa-save"></i> Save</button>
                </div>
            </div>
        </div>
    </div>
</div>