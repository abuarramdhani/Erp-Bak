<section class="content">
    <div class="inner" >
        <div class="row">
            
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-11">
                                <div class="text-right"><h1><b><?= $Title ?></b></h1></div>
                            </div>
                            <div class="col-lg-1 ">
                                <div class="text-right hidden-md hidden-sm hidden-xs">
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('ManufacturingOperationUP2L/Moulding/');?>">
                                        <i class="icon-wrench icon-2x"></i>
                                        <br />
                                    </a>                             
                                </div>
                            </div>
                        </div>
                    </div>
                    <br />
                    
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="box box-primary box-solid">
                                <div class="box-header with-border">Read Moulding</div>
                                <div class="box-body">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="col-lg-6">
                                                    <table class="table" style="border: 0px !Important;">
                                                    <?php foreach ($Moulding as $headerRow): ?>
														<tr>
                                                            <td class="col-lg-5" style="border: 0"><strong>Component Code</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['component_code']; ?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-lg-5" style="border: 0"><strong>Component Description</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['component_description']; ?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-lg-5" style="border: 0"><strong>Production Date</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['production_date']; ?></td>
                                                        </tr>
														<tr>
                                                            <td class="col-lg-5" style="border: 0"><strong>Moulding Quantity</strong></td>
                                                            <td style="border: 0">: <?php echo $headerRow['moulding_quantity']; ?>
                                                                <input type="hidden" id="mould_qty" value="<?php echo $headerRow['moulding_quantity']; ?>">
                                                                <input type="hidden" id="mould_id" value="<?php echo $headerRow['moulding_id']; ?>">
                                                            </td>
                                                        </tr>
														<tr>
                                                            <td class="col-lg-5" style="border: 0"><strong>Keterangan</strong></td>
                                                            <td style="border: 0"><?php echo $headerRow['keterangan']; ?></td>
                                                        </tr>
													<?php endforeach; ?>
                                                    </table>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading">
                                                            Employee
                                                        </div>
                                                            <ul class="list-group">
                                                            <?php foreach ($headerRow['employee'] as $emp) { ?>
                                                              <li class="list-group-item"><?php echo $emp['name'].' ['.$emp['no_induk'].']' ?></li>
                                                            <?php } ?>
                                                            </ul>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12" >
                                                <h3>Table Scrap</h3>
                                                    <table class="table table-bordered">
                                                           <thead>
                                                                <tr>
                                                                    <th>No</th>
                                                                    <th>Type</th>
                                                                    <th>Code</th>
                                                                    <th>Quantity</th>
                                                                </tr>
                                                           </thead>
                                                           <tbody>
                                                           <?php $i=1; foreach ($headerRow['scrap'] as $scrap) { ?>
                                                               <tr>
                                                                   <td><?php echo $scrap['no'] ?></td>
                                                                   <td><?php echo $scrap['type_scrap']?></td>
                                                                   <td><?php echo $scrap['kode_scrap']?></td>
                                                                   <td><?php echo $scrap['quantity']?></td>
                                                                   <input type="hidden" id="jumlah_scrap" value="<?php echo $scrap['jumlah'] ?>">
                                                               </tr>
                                                            <?php $i++;} ?>
                                                           </tbody>
                                                       </table>

                                                </div>
                                                 <div class="col-lg-12" >
                                                <h3>Table Bongkar</h3>
                                                    <table class="table table-bordered">
                                                           <thead>
                                                                <tr>
                                                                    <th width="10px">No</th>
                                                                    <th width="200px">Quantity</th>
                                                                </tr>
                                                           </thead>
                                                           <tbody>
                                                           <?php $i=1; foreach ($headerRow['bongkar'] as $bongkar) { ?>
                                                               <tr>
                                                                   <td><?php echo $bongkar['no'] ?></td>
                                                                   <td><?php echo $bongkar['quantity']?></td>
                                                                   <input type="hidden" id="jumlah_bongkar" value="<?php echo $bongkar['jumlah'] ?>">
                                                               </tr>
                                                            <?php $i++;} ?>
                                                           </tbody>
                                                       </table>

                                                </div>
                                            
                                                <div class="col-lg-12 panel panel-default" style="padding: 0px;margin-top: 30px">
                                                    <div class="panel-heading">
                                                        <h3>Add Scrap<i class="pull-right fa fa-plus"></i></h3>
                                                    </div>
                                                    <div class="panel-body">
                                                        <div class="form-group col-lg-6" >
                                                            <label for="txtScrap" class="control-label col-lg-4">Scrap Type :</label>
                                                            <select class="form-control jsSlcScrap" id="txtScrap" name="scrap" required data-placeholder="Scrap">
                                                                <option></option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group col-lg-6">
                                                            <label for="scrap_qty" class="control-label col-lg-4">Quantity :</label>
                                                        <input class="form-control" id="scrap_qty" type="number" name="scrap_qty" placeholder="QTY">
                                                        </div>
                                                        <div class="col-lg-6">
                                                           <button class="btn btn-default add_scrap">Add <i class="fa fa-plus"></i></button>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-12 panel panel-default" style="padding: 0px;margin-top: 30px">
                                                    <div class="panel-heading">
                                                        <h3>Add Bongkar<i class="pull-right fa fa-plus"></i></h3>
                                                    </div>
                                                    <div class="panel-body">
                                                        <div class="form-group col-lg-6">
                                                            <label for="bongkar_qty" class="control-label col-lg-4"> Quantity : </label>
                                                            </div>
                                                        <div class="form-group col-lg-6">
                                                            
                                                        <input class="form-control" id="bongkar_qty" type="number" name="bongkar_qty" placeholder="QTY">
                                                        </div>
                                                        <div class="col-lg-6">
                                                           <button class="btn btn-default add_bongkar">Add <i class="fa fa-plus"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="panel-footer">
                                        <div align="right">
                                            <a href="javascript:history.back(1)" class="btn btn-primary btn-lg btn-rect">Back</a>
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