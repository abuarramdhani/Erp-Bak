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
                                        Master Item UP2L
                                    </b>
                                </h1>
                            </div>
                        </div>
                        <div class="col-lg-1 ">
                            <div class="text-right hidden-md hidden-sm hidden-xs">
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('ManufacturingOperationUP2L/MasterItem');?>">
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
                                Master Item UP2L
                            </div>
                            <div class="panel-body">
                            <?php echo $message; ?>
                            <ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="#MonMasIt">Monitoring Master Item</a></li>
                                <li><a data-toggle="tab" href="#InsMasIt">Insert Master Item</a></li>
                                <li><a data-toggle="tab" href="#1by1">Insert 1 by 1</a></li>
                            </ul>
                            <div class="col-md-12 tab-content" style="padding-top:2em">
                                <div id="MonMasIt" class="tab-pane fade in active">
                                   <h3>Table Master Item</h3>
                                   <table class="table table-bordered table-striped table-hover" id="masterItem">
                                       <thead>
                                            <tr>
                                                <th rowspan="2" style="text-align: center;vertical-align: middle;">No</th>
                                                <th rowspan="2" style="text-align: center;vertical-align: middle;">Type</th>
                                                <th rowspan="2" style="text-align: center;vertical-align: middle;">Kode Barang</th>
                                                <th rowspan="2" style="text-align: center;vertical-align: middle;">Nama Barang</th>
                                                <th rowspan="2" style="text-align: center;vertical-align: middle;">Proses</th>
                                                <th rowspan="2" style="text-align: center;vertical-align: middle;">Kode Proses</th>
                                                <th colspan="2" style="text-align: center;vertical-align: middle;">Target</th>
                                                <th rowspan="2" style="text-align: center;vertical-align: middle;">Tanggal Berlaku</th>
                                                <th rowspan="2" style="text-align: center;vertical-align: middle;">Jenis</th>
                                                <th rowspan="2" style="text-align: center;vertical-align: middle;">Berat</th>
                                                <th rowspan="2" style="text-align: center;vertical-align: middle;">Action</th>
                                            </tr>
                                            <tr>
                                                <th style="text-align: center;vertical-align: middle;">Senin-Kamis</th>
                                                <th style="text-align: center;vertical-align: middle;">Jumat-Sabtu</th>
                                            </tr>
                                       </thead>
                                       <tbody>
                                       <?php $x=1; foreach ($master as $mi) {?>
                                            <tr row-id="<?php echo $x;?>">
                                               <td><?php echo $x; ?></td>
                                               <td><?php echo $mi['type'];?></td>
                                               <td><?php echo $mi['kode_barang'];?></td>
                                               <td><?php echo $mi['nama_barang'];?></td>
                                               <td><?php echo $mi['proses'];?></td>
                                               <td><?php echo $mi['kode_proses'];?></td>
                                               <td><?php echo $mi['target_sk'];?></td>
                                               <td><?php echo $mi['target_js'];?></td>
                                               <td><?php echo $mi['tanggal_berlaku'];?></td>
                                               <td><?php echo $mi['jenis'];?></td>
                                               <td><?php echo $mi['berat'];?></td>
                                               <td><button class="btn btn-default edit" data-toggle="modal" data-target="#modalEdit" onclick="editMasterItem('<?php echo $mi['id']?>')"><i class="fa fa-pencil"></i></button>
                                                    <button class="hapus btn btn-default" onclick="deleteMasterItem('<?php echo $mi['id']?>','<?php echo $x;?>')"><i class="fa fa-trash"></i></button></td>
                                            </tr>
                                       <?php $x++;} ?>
                                         
                                       </tbody>

                                   </table>
                                </div>
                            <div id="InsMasIt" class="tab-pane fade in ">
                                <form method="post" enctype="multipart/form-data" class="form-horizontal" action="<?php echo base_url('ManufacturingOperationUP2L/MasterItem/CreateSubmit'); ?>">
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
                                                <a class="btn btn-default" href="<?php echo site_url('ManufacturingOperationUP2L/MasterItem');?>">CANCEL</a>
                                                <a class="btn btn-warning" href="<?php echo base_url('assets/upload/ManufacturingOperationUP2L/masterItem/example.xlsx');?>">
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
                                <div id="1by1" class="tab-pane fade in">
                                  <div class="row">
                                      <form method="post" action="<?php echo base_url('ManufacturingOperationUP2L/MasterItem/insertMasIt')?>">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Type:</label>
                                            <input class="form-control" type="text" name="tType" placeholder="Type" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="usr">Kode Barang:</label>
                                            <input type="text" class="form-control" name="tKodeBarang" placeholder="Kode Barang" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="usr">Nama Barang:</label>
                                            <input type="text" class="form-control" name="tNamaBarang" placeholder="Nama Barang" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="usr">Proses:</label>
                                            <input type="text" class="form-control" name="tProses" placeholder="Proses" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="usr">Kode Proses:</label>
                                            <input type="text" class="form-control" name="tKodeProses" placeholder="Kode Proses" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">Target</div>
                                            <div class="panel-body">
                                                <div class="form-group">
                                                    <label for="usr">Senin-Kamis</label>
                                                    <input type="number" class="form-control" name="tSK" placeholder="Target Senin-Kamis" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="usr">Jumat-Sabtu:</label>
                                                    <input type="number" class="form-control" name="tJS" placeholder="Target Jumat-Sabtu" required>
                                                </div> 
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="usr">Tanggal Berlaku</label>
                                            <input id="tglBerlaku" type="date" class="form-control" name="tBerlaku" required>
                                        </div> 
                                         <div class="form-group">
                                            <label for="usr">Jenis</label>
                                            <input id="txtJenis" type="text" class="form-control" name="tJenis" placeholder="Jenis Item" required>
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
                                      
                                          <div class="modal-body" id="editMasterItem">
                                          
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