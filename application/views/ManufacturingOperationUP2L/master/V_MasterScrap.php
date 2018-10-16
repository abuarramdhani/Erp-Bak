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
                                        Master Scrap UP2L
                                    </b>
                                </h1>
                            </div>
                        </div>
                        <div class="col-lg-1 ">
                            <div class="text-right hidden-md hidden-sm hidden-xs">
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('ManufacturingOperationUP2L/MasterScrap');?>">
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
                                Master Scrap UP2L
                            </div>
                            <div class="panel-body">
                            <?php echo $message; ?>
                            <ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="#MonMasScrap">Monitoring Master Scrap</a></li>
                                <li><a  data-toggle="tab" href="#InsMasScrap">Insert Master Scrap</a></li>
                                <!-- <li><a href="#1by1">Insert 1 by 1</a></li> -->
                            </ul>
                            <div class="col-md-12 tab-content" style="padding-top:2em">
                                <div id="MonMasScrap" class="tab-pane fade in active">
                                   <h3>Table Master Scrap</h3>
                                   <table class="table table-bordered table-striped table-hover" id="masterScrap">
                                       <thead>
                                            <tr>
                                                <th style="text-align: center;vertical-align: middle;width: 5%">No</th>
                                                <th style="text-align: center;vertical-align: middle;">Description</th>
                                                <th style="text-align: center;vertical-align: middle;width: 20%">Scrap Code</th>
                                                <th style="text-align: center;vertical-align: middle;width: 20%;">Action</th>
                                            </tr>
                                       </thead>
                                       <tbody>
                                       <?php $x=1; foreach ($master as $mi) {?>
                                            <tr row-id="<?php echo $x;?>">
                                                <td><?php echo $x?></td>
                                                <td><?php echo $mi['description']; ?></td>
                                                <td><?php echo $mi['scrap_code']; ?></td>
                                                <td style="text-align: center"><button class="btn btn-default edit" data-toggle="modal" data-target="#modalEdit" onclick="editMasterScrap('<?php echo $mi['id']?>')"><i class="fa fa-pencil"></i></button>
                                                <button class="hapus btn btn-default" onclick="deleteMasterScrap('<?php echo $mi['id']?>','<?php echo $x;?>')"><i class="fa fa-trash"></i></button></td>
                                            </tr>
                                       <?php $x++;} ?>
                                         
                                       </tbody>

                                   </table>
                                </div>
                            <div id="InsMasScrap" class="tab-pane fade">
                               <div class="row">
                                    <form method="post" action="<?php echo base_url('ManufacturingOperationUP2L/MasterScrap/insertMasScrap') ?>">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Description :</label>
                                                <input type="text" name="txt_descScrap" placeholder="Input Deskripsi Scrap" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label>Kode Scrap :</label>
                                                <input type="text" name="txt_codeScrap" placeholder="Input Code Scrap" class="form-control">
                                            </div>
                                            <button class="btn btn-success">Save</button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                                <div class="modal fade" id="modalEdit" role="dialog">
                                   <div class="modal-dialog modal-lg">
                                   
                                     <!-- Modal content-->
                                     <div class="modal-content">
                                       <div class="modal-header">
                                         <button type="button" class="close" data-dismiss="modal">&times;</button>
                                         <h4 class="modal-title">Edit Item</h4>
                                       </div>
                                      
                                          <div class="modal-body" id="editMasterScrap">
                                          
                                          </div>
                                      
                                       <div class="modal-footer">
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
        </div>
    </div>
</section>