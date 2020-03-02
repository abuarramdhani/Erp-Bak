<script src="<?php echo base_url('assets/plugins/dataTables/jquery.dataTables.js');?>"></script>
	<script src="<?php echo base_url('assets/plugins/dataTables/dataTables.bootstrap.js');?>"></script>
    <script>
         $(document).ready(function () {
            $('.tbl_userMng').dataTable({
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
                                    href="<?php echo site_url('MonitoringDeliverySparepart/UserManagement/');?>">
                                    <i class="icon-wrench icon-2x">
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
                            <div class="box-body">
                                <div class="panel-body">
                                <form action="<?php echo base_url('MonitoringDeliverySparepart/UserManagement/saveUser'); ?>" method="post" class="formBom">
                                    <div class="col-md-12">
                                        <div class="col-md-4 text-right">
                                            <label class="control-label">Hak Akses</label>
                                        </div>
                                        <div class="col-md-4">
                                            <select id="hak_akses" name="hak_akses" class="form-control pull-right select2" style="width:100%" data-placeholder="hak akses" required>
                                                <option></option>
                                                <option value="Koordinator">Koordinator</option>
                                                <option value="Seksi">Seksi</option>
                                            </select>
                                        </div>
                                    </div>
                                    <br><br>
                                    <div class="col-md-12">
                                        <div class="col-md-4 text-right">
                                            <label class="control-label">No Induk</label>
                                        </div>
                                        <div class="col-md-4">
                                            <input id="noInduk" name="noInduk" class="form-control pull-right" placeholder="no induk" onchange="getSeksiDept(this)" required>
                                        </div>
                                    </div>
                                    <br><br>
                                    <div class="col-md-12">
                                        <div class="col-md-4 text-right">
                                            <label class="control-label">Seksi</label>
                                        </div>
                                        <div class="col-md-4">
                                            <input id="seksiUser" name="seksiUser" class="form-control pull-right" style="font-size:12px" readonly>
                                        </div>
                                    </div>
                                    <br><br>
                                    <div class="col-md-12">
                                        <div class="col-md-4 text-right">
                                            <label class="control-label">Department</label>
                                        </div>
                                        <div class="col-md-4">
                                            <select id="deptclassUser" name="department" class="form-control select2 deptclassUser" style="width:100%" >
                                                <option></option>
                                            </select>
                                        </div>
                                    </div>
                                    <br><br><br>
                                    <div class="col-md-12 text-center">
                                        <button type="submit" class="btn btn-primary" >SAVE</button>    
                                    </div>
                                </div>
                                </form>

                                <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-responsive table-hover text-center tbl_userMng" style="font-size:14px;width:100%">
                                        <thead>
                                            <tr class="bg-primary">
                                                <td width="5px">No</td>
                                                <td>No Induk</td>
                                                <td>Seksi </td>
                                                <td>Department</td>
                                                <td>Hak Akses</td>
                                                <td>Action</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php 
                                        $no=1; foreach($data as $val){ ?>
                                                <tr>
                                                    <td><?= $no ?></td>
                                                    <td><input type="hidden" id="noinduk<?= $no ?>" value="<?= $val['no_induk'] ?>"><?= $val['no_induk'] ?></td>
                                                    <td><input type="hidden" id="seksi<?= $no ?>" value="<?= $val['seksi'] ?>"><?= $val['seksi'] ?></td>
                                                    <td><input type="hidden" id="passwd<?= $no ?>" value="<?= $val['deptclass'] ?>"><?= $val['deptclass']?></td>
                                                    <td><input type="hidden" id="hak<?= $no?>" value="<?= $val['hak_akses'] ?>"><?= $val['hak_akses'] ?></td>
                                                    <td>
                                                        <button type="button" class="btn btn-xs btn-info" data-toggle="modal" data-target="#modalEdit<?php echo $val['id'] ?>"><i class="fa fa-pencil"></i> Edit</button>
                                                        <a href="<?php echo base_url('MonitoringDeliverySparepart/UserManagement/deleteData/'.$val['id'].'/'.$val['no_induk'])  ?>" type="button" class="btn btn-xs btn-danger"><i class="fa fa-trash-o"></i> Delete</a>
                                                    </td>
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

<?php foreach ($data as $val) { ?>
<div class="modal fade" id="modalEdit<?= $val['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalEdit">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h3 class="modal-title"><b><i class="fa fa-pencil"></i> Edit User</b></h3>
			</div>
            <form action="<?php echo base_url('MonitoringDeliverySparepart/UserManagement/saveUser'); ?>" method="post" class="formBom">
			<div class="modal-body">
            <div class="panel-body">
                <div class="col-md-12">
                    <div class="col-md-3 text-right">
                        NO INDUK : 
                    </div>
                    <div class="col-md-9">
                        <?php $nama = $this->M_usermng->cariNama($val['no_induk']); 
                            if (empty($nama)) {
                                $nama = '';
                            }else {
                                $nama = ' - '.$nama[0]['USERNAME'];
                            }
                        ?>
                        <input type="hidden" class="form-control" id="no_induk" name="noInduk" value="<?= $val['no_induk']?>"><?= $val['no_induk'].$nama?>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <div class="col-md-12">
                    <div class="col-md-3 text-right">
                        SEKSI : 
                    </div>
                    <div class="col-md-9">
                        <input type="hidden" class="form-control" id="seksi" name="seksiUser" value="<?= $val['seksi']?>"><?= $val['seksi']?>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <div class="col-md-12">
                    <div class="col-md-3 text-right">
                        DEPARTMENT : 
                    </div>
                    <div class="col-md-6">
                        <select class="form-control select2 deptclassUser" id="department" name="department" style="width:100%">
                            <option value="<?= $val['deptclass']?>"><?= $val['deptclass']?></option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <div class="col-md-12">
                    <div class="col-md-3 text-right">
                        HAK AKSES : 
                    </div>
                    <div class="col-md-6">
                        <select class="form-control select2" id="hak_akses" name="hak_akses" style="width:100%">
                            <option value="<?= $val['hak_akses']?>"><?= $val['hak_akses']?></option>
                            <?php if ($val['hak_akses'] == 'Seksi') {
                               echo '<option value="Koordinator">Koordinator</option>';
                            }else {
                                echo '<option value="Seksi">Seksi</option>';
                            }?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <div class="col-md-12 text-center">
                    <button type="submit" class="btn btn-info"><i class="fa fa-save"></i> Save</button>
                </div>
            </div>
		    </div>
            </form>
		</div>
	</div>
</div>

<?php } ?>
