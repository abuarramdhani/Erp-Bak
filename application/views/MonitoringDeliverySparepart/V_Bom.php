<script src="<?php echo base_url('assets/plugins/dataTables/jquery.dataTables.js');?>"></script>
	<script src="<?php echo base_url('assets/plugins/dataTables/dataTables.bootstrap.js');?>"></script>
    <script>
         $(document).ready(function () {
            $('.tbl_BomMng').dataTable({
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
                                    href="<?php echo site_url('MonitoringDeliverySparepart/BomManagement/');?>">
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
                            <!-- <div class="box box-primary box-solid"> -->
                                <div class="panel-body">
                                <form action="<?php echo base_url('MonitoringDeliverySparepart/BomManagement/GenerateBoM'); ?>" method="post">
                                    <div class="col-md-12">
                                        <div class="col-md-5 text-right">
                                            <label class="control-label">Root Component Code</label>
                                        </div>
                                        <div class="col-md-3">
                                            <select id="rootCode" name="rootCode" class="form-control select2" placeholder="pilih kode komponen" >
                                                <option></option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div class="col-md-12 text-center">
                                        <button type="submit" class="btn btn-primary"><i class="fa fa-gears"> Generate</i></button>    
                                    </div>
                                    </form>
                                </div>
                            <!-- </div> -->
                                <div class="panel-body">
                                <div class="table-responsive" >
                                    <table class="table table-striped table-bordered table-responsive table-hover text-center text-nowrap tbl_BomMng" style="font-size:14px;width:100%;">
                                        <thead>
                                            <tr class="bg-primary">
                                                <td width="5px">No</td>
                                                <td>Kode Komponen </td>
                                                <td width="20%">Deskripsi Komponen</td>
                                                <td>BoM Version</td>
                                                <td>Keterangan</td>
                                                <td>Action</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php 
                                        $no=1; foreach($data as $val){
                                            ?>
                                                <tr>
                                                    <td><?= $no ?></td>
                                                    <td><input type="hidden" id="compCode<?= $no ?>" value="<?= $val['component_code']?>"><?= $val['component_code']?></td>
                                                    <td><input type="hidden" id="compDesc<?= $no ?>" value="<?= $val['component_desc']?>"><?= $val['component_desc']?></td>
                                                    <td><input type="hidden" id="bomVersion<?= $no ?>" value="<?= $val['identitas_bom']?>"><?= $val['identitas_bom']?></td>
                                                    <td><input type="hidden" value="<?= $val['keterangan']?>"><?= $val['keterangan']?></td>
                                                    <td><a href="<?php echo base_url('MonitoringDeliverySparepart/BomManagement/detailBom/'.$val['component_code'].'/'.$val['id']) ?>" type="button" class="btn btn-xs btn-success"><i class="fa fa-search"></i> Detail</a>
                                                        <a href="<?php echo base_url('MonitoringDeliverySparepart/BomManagement/deleteBom/'.$val['component_code'].'/'.$val['id']) ?>" type="button" class="btn btn-xs btn-danger"><i class="fa fa-trash-o"></i> Delete</a></td>
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
