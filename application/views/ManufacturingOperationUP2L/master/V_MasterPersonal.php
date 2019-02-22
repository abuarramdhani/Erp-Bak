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
                                        Master Personal UP2L
                                    </b>
                                </h1>
                            </div>
                        </div>
                        <div class="col-lg-1 ">
                            <div class="text-right hidden-md hidden-sm hidden-xs">
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('ManufacturingOperationUP2L/MasterPersonal');?>">
                                    <i aria-hidden="true" class="fa fa-user fa-2x">
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
                                Master Personal UP2L
                            </div>
                            <div class="panel-body">
                            <?php echo $message; ?>
                            <ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="#MonMasPer">Monitoring Personal UP2L</a></li>
                                <li><a data-toggle="tab" href="#InsMasPer">Insert Master Personal</a></li>
                                <li><a data-toggle="tab" href="#1by1">Insert 1 by 1</a></li>
                            </ul>
                            <div class="col-md-12 tab-content" style="padding-top:2em">
                                <div id="MonMasPer" class="tab-pane fade in active">
                                   <h3>Table Master Personal</h3>
                                   <table class="table table-bordered table-striped table-hover" id="MasterPersonal">
                                       <thead>
                                            <tr>
                                                <th style="text-align: center;vertical-align: middle;width: 5%">No</th>
                                                <th style="text-align: center;vertical-align: middle;">Nama</th>
                                                <th style="text-align: center;vertical-align: middle;width: 10%">No Induk</th>
                                                <th style="text-align: center;vertical-align: middle;width: 15%">Action</th>
                                            </tr>
                                       </thead>
                                       <tbody>
                                       <?php $x=1; foreach ($master as $mp) {?>
                                            <tr row-id="<?php echo $x;?>">
                                               <td><?php echo $x; ?></td>
                                               <td><?php echo $mp['nama'];?></td>
                                               <td><?php echo $mp['no_induk'];?></td>
                                               <td style="text-align: center;"><button class="btn btn-default edit" data-toggle="modal" data-target="#modalEdit" onclick="editMasterPerson('<?php echo $mp['id']?>')"><i class="fa fa-pencil"></i></button>
                                                    <button class="hapus btn btn-default" onclick="deleteMasterPersonal('<?php echo $mp['id']?>','<?php echo $x;?>')"><i class="fa fa-trash"></i></button></td>
                                            </tr>
                                       <?php $x++;} ?>
                                         
                                       </tbody>

                                   </table>
                                </div>
                            <div id="InsMasPer" class="tab-pane fade">
                                <form method="post" enctype="multipart/form-data" class="form-horizontal" action="<?php echo base_url('ManufacturingOperationUP2L/MasterPersonal/CreateSubmit'); ?>">
                                        <div class="row">
                                            <div class="col-md-12 text-center">
                                                <h2>
                                                    <b>
                                                    Upload file Excel
                                                    </b>
                                                </h2>
                                                <p>
                                                -- Klick button 'DOWNLOAD SAMPLE' to download sample format item data list --
                                                </p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group">
                                                <label class="control-label col-md-offset-2 col-md-2">Master Item File (.xls)</label>
                                                <div class="col-lg-6">
                                                    <input type="file" name="Item" class="form-control" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 text-right">
                                                <a class="btn btn-default" href="<?php echo site_url('ManufacturingOperationUP2L/MasterPersonal');?>">CANCEL</a>
                                                <a class="btn btn-warning" href="<?php echo base_url('assets/upload/ManufacturingOperationUP2L/masterPersonal/example(input-person).xlsx');?>">
                                                    <i aria-hidden="true" class="fa fa-download"></i> 
                                                DOWNLOAD SAMPLE
                                                </a>
                                                <button type="submit" class="btn btn-primary">
                                                <i aria-hidden="true" class="fa fa-upload"></i> UPLOAD
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div id="1by1" class="tab-pane fade">
                                  <div class="row">
                                    <form method="post" action="<?php echo base_url('ManufacturingOperationUP2L/MasterPersonal/insertMasPer')?>">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Nama:</label>
                                                <input class="form-control" type="text" name="tNama" placeholder="Nama" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="usr">No Induk:</label>
                                                <input type="text" class="form-control" name="tNoInduk" placeholder="No Induk" required>
                                            </div>
                                            <button type="submit" class="btn btn-default" style="float:right" >Submit</button>
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
                                      
                                          <div class="modal-body" id="editMasterPerson">
                                          
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