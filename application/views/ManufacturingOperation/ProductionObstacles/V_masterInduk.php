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
                                        Master Induk
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
                                Master Induk
                            </div>
                            <div class="panel-body">
                            <!-- <?php echo $message; ?> -->
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#1">Cetak Logam</a></li>
                                <li><a href="#2">Cetak Inti</a></li>
                            </ul>
                            <div class="col-md-12 tab-content" style="padding-top:2em">
                                <div id="1" class="tab-pane fade in active">
                                   <h3>Table Master Induk Logam</h3>
                                        <table class="table table-bordered table-striped table-hover" id="masterIndukLogam">
                                            <thead>
                                                 <tr>
                                                    <th>No</th>
                                                    <th>Induk</th>
                                                    <th>Action</th>
                                                 </tr>
                                            </thead>
                                            <tbody>

                                            <?php $x=1; foreach ($indukLogam as $ind) {?>
                                                <tr>
                                                   <td><?php echo $x;?></td> 
                                                   <td><p class="ind"><?php echo $ind['induk']?></p>
                                                        <div class="input-group updtInd" style="display: none">    
                                                            <input class="form-control" type="text" name="updt_indk" value="<?php echo $ind['induk']?>" onkeypress="saveUpdateInduk(this,<?php echo $ind['id']?>,event)">
                                                            <div class="input-group-btn">
                                                                <a class="btn btn-default cancelUpdt"><i class="fa fa-close"></i></a>
                                                            </div>
                                                        </div>
                                                   </td> 
                                                   <td><button class="btn btn-warning editInduk" onclick="editInduk(this)"><i class="fa fa-pencil"></i></button>
                                                    <button class="btn btn-success saveUpdtInduk" style="display: none" onclick="saveUpdateInduk(this,<?php echo $ind['id']?>,'32')"><i class="fa fa-save"></i></button>
                                                    <button class="btn btn-danger deleteInduk" onclick="deleteInduk(this,<?php echo $ind['id']?>,'<?php echo $ind['induk']?>')"><i class="fa fa-trash"></i></button>
                                                   </td>
                                                </tr>
                                            <?php $x++;} ?>
                                              
                                            </tbody>
                                        </table>
                                    <a class="btn btn-success" href="<?php echo base_url('ManufacturingOperation/ProductionObstacles/master/addInduk')?>">Add Data <i class="fa fa-plus"></i></a>
                                    
                                </div>
                                <div id="2" class="tab-pane fade">
                                    <h3>Table Master Induk Inti</h3>
                                    <table class="table table-bordered table-striped table-hover" id="masterIndukInti">
                                        <thead>
                                             <tr>
                                                <th>No</th>
                                                <th>Induk</th>
                                                <th>Action</th>
                                             </tr>
                                        </thead>
                                        <tbody>
                                            <?php $x=1; foreach ($indukinti as $int) {?>
                                                <tr>
                                                   <td><?php echo $x;?></td> 
                                                   <td>
                                                    <p class="ind"><?php echo $int['induk']?></p>
                                                        <div class="input-group updtInd" style="display: none">    
                                                            <input class="form-control" type="text" name="updt_indk" value="<?php echo $int['induk']?>" onkeypress="saveUpdateInduk(this,<?php echo $int['id']?>,event)">
                                                            <div class="input-group-btn">
                                                                <a class="btn btn-default cancelUpdt"><i class="fa fa-close"></i></a>
                                                            </div>
                                                        </div>
                                                    </td> 
                                                   <td><button class="btn btn-warning editInduk" onclick="editInduk(this)"><i class="fa fa-pencil"></i></button>
                                                   <button class="btn btn-success saveUpdtInduk" style="display: none" onclick="saveUpdateInduk(this,<?php echo $int['id']?>,'32')"><i class="fa fa-save"></i></button>
                                                   <button class="btn btn-danger deleteInduk" onclick="deleteInduk(this,<?php echo $int['id']?>,'<?php echo $int['induk']?>')"><i class="fa fa-trash"></i></button>
                                                   </td>
                                                </tr>
                                            <?php $x++;} ?>
                                          
                                        </tbody>
                                    </table>
                                    <a class="btn btn-success" href="<?php echo base_url('ManufacturingOperation/ProductionObstacles/master/addInduk')?>">Add Data <i class="fa fa-plus"></i></a>

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