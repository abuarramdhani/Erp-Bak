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
                                        Master Cabang
                                    </b>
                                </h1>
                            </div>
                        </div>
                        <div class="col-lg-1 ">
                            <div class="text-right hidden-md hidden-sm hidden-xs">
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('ManufacturingOperation/MasterItem');?>">
                                    <i aria-hidden="true" class="fa fa-line-chart fa-2x">
                                    </i>
                                    <span>
                                        <br/>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <br/>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border">
                                Master Cabang
                            </div>
                            <div class="panel-body">
                            <!-- <?php echo $message; ?> -->
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#1">Cetak Logam</a></li>
                                <li><a href="#2">Cetak Inti</a></li>
                            </ul>
                            <div class="col-md-12 tab-content" style="padding-top:2em">
                                <div id="1" class="tab-pane fade in active">
                                   <h3>Table Master Cabang Logam</h3>
                                        <table class="table table-bordered table-striped table-hover" id="masterCabangLogam">
                                            <thead>
                                                 <tr>
                                                    <th>No</th>
                                                    <th>Cabang</th>
                                                    <th>Action</th>
                                                 </tr>
                                            </thead>
                                            <tbody>

                                            <?php $x=1; foreach ($cabangLogam as $ind) {?>
                                                <tr>
                                                   <td><?php echo $x;?></td> 
                                                   <td><p class="cbg"><?php echo $ind['cabang']?></p>
                                                        <div class="input-group updtCbg" style="display: none">    
                                                            <input class="form-control" type="text" name="updt_Cbg" value="<?php echo $ind['cabang']?>" onkeypress="saveUpdateCabang(this,<?php echo $ind['id']?>,event)">
                                                            <div class="input-group-btn">
                                                                <a class="btn btn-default cancelUpdt"><i class="fa fa-close"></i></a>
                                                            </div>
                                                        </div></td> 
                                                   <td><button class="btn btn-warning editCabang" onclick="editCabang(this)"><i class="fa fa-pencil"></i></button>
                                                   <button class="btn btn-success saveUpdtCabang" onclick="saveUpdateCabang(this,<?php echo $ind['id']?>,'32')" style="display: none"><i class="fa fa-save"></i></button>
                                                   <button class="btn btn-danger deleteCabang" onclick="deleteCabang(this,<?php echo $ind['id']?>,'<?php echo $ind['cabang']?>')"><i class="fa fa-trash"></i></button>
                                                   </td>
                                                </tr>
                                            <?php $x++;} ?>
                                              
                                            </tbody>
                                        </table>
                                    <a class="btn btn-success" href="<?php echo base_url('ManufacturingOperation/ProductionObstacles/master/addCabang')?>">Add Data <i class="fa fa-plus"></i></a>
                                    
                                </div>
                                <div id="2" class="tab-pane fade">
                                    <h3>Table Master Cabang Inti</h3>
                                    <table class="table table-bordered table-striped table-hover" id="masterCabangInti">
                                        <thead>
                                             <tr>
                                                <th>No</th>
                                                <th>Cabang</th>
                                                <th>Action</th>
                                             </tr>
                                        </thead>
                                        <tbody>
                                            <?php $x=1; foreach ($cabangInti as $int) {?>
                                                <tr>
                                                   <td><?php echo $x;?></td> 
                                                   <td><p class="cbg"><?php echo $int['cabang']?></p>
                                                        <div class="input-group updtCbg" style="display: none">    
                                                            <input class="form-control" type="text" name="updt_Cbg" value="<?php echo $int['cabang']?>" onkeypress="saveUpdateCabang(this,<?php echo $int['id']?>,event)">
                                                            <div class="input-group-btn">
                                                                <a class="btn btn-default cancelUpdt"><i class="fa fa-close"></i></a>
                                                            </div>
                                                        </div>
                                                    </td> 
                                                   <td><button class="btn btn-warning editCabang" onclick="editCabang(this)"><i class="fa fa-pencil"></i></button>
                                                   <button class="btn btn-success saveUpdtCabang" onclick="saveUpdateCabang(this,<?php echo $ind['id']?>,'32')" style="display: none"><i class="fa fa-save"></i></button>
                                                   <button class="btn btn-danger deleteCabang" onclick="deleteCabang(this,<?php echo $int['id']?>,'<?php echo $int['cabang']?>')"><i class="fa fa-trash"></i></button>
                                                   </td>
                                                </tr>
                                            <?php $x++;} ?>
                                          
                                        </tbody>
                                    </table>
                                    <a class="btn btn-success" href="<?php echo base_url('ManufacturingOperation/ProductionObstacles/master/addCabang')?>">Add Data <i class="fa fa-plus"></i></a>

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