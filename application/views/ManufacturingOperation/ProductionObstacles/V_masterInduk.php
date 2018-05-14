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
                            </ul>
                            <div class="col-md-12 tab-content" style="padding-top:2em">
                                <div id="1" class="tab-pane fade in active">
                                   <h3>Table Master Induk</h3>
                                        <table class="table table-bordered table-striped table-hover" id="masterIndukLogam">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Hambatan</th>
                                                    <th>Induk</th>
                                                    <th>cetakan</th>
                                                    <th>Kategori</th>
                                                    <th>Cabang</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            <?php $x=1; foreach ($indukLogam as $ind) {?>
                                                <tr>
                                                   <td><?php echo $x;?></td>
                                                   <td><?php echo $ind['hambatan']?></td> 
                                                   <td><?php echo $ind['induk']?></td>
                                                   <td><?php echo $ind['cetak']?> </td>
                                                    <td><?php echo $ind['kategori']?></td>  
                                                 <td><?php echo $ind['cabang'] ?></td> 
                                                   <td>
                                                   <form method="post" action="<?php echo base_url('ManufacturingOperation/ProductionObstacles/master/updateinduk')?>">
                                                       <input type="hidden" name="txt_idInduk" value="<?php echo $ind['id'] ?>">
                                                       <div class="btn-group">
                                                        <button type="submit" class="btn btn-warning editInduk" ><i class="fa fa-pencil"></i></button>
                                                        <button class="btn btn-danger deleteInduk" onclick="deleteInduk(this,<?php echo $ind['id']?>,'<?php echo $ind['induk']?>')"><i class="fa fa-trash"></i></button>
                                                           
                                                       </div>
                                                   </form>
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