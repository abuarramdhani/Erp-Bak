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
                                <div class="box-header with-border">Read Quality Control Detail</div>
                                <div class="box-body">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="col-lg-6">
                                                    <table class="table" style="border: 0px !Important;">
                                                    <?php foreach ($QualityControl as $headerRow): ?>
                                                        <tr>
                                                            <td class="col-lg-6" style="border: 0"><strong>Component Code :</strong></td>
                                                            <td style="border: 0" id="component_code" >  <?php echo $headerRow['component_code']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="col-lg-6" style="border: 0"><strong>Component Description :</strong></td>
                                                            <td style="border: 0">:<?php echo $headerRow['component_description']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="col-lg-6" style="border: 0"><strong>Production Date :</strong></td>
                                                            <td style="border: 0" id="production_date" ><?php echo $headerRow['production_date']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="col-lg-6" style="border: 0"><strong>Print Code :</strong></td>
                                                            <td style="border: 0" id="print_code" > <?php echo $headerRow['print_code']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="col-lg-6" style="border: 0"><strong>Moulding Quantity :</strong></td>
                                                            <td style="border: 0"> <?php echo $headerRow['moulding_quantity']; ?>
                                                                <input type="hidden" id="mould_qty" value="<?php echo $headerRow['moulding_quantity']; ?>">
                                                                <input type="hidden" id="mould_id" value="<?php echo $headerRow['moulding_id']; ?>">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="col-lg-6" style="border: 0"><strong>Keterangan</strong></td>
                                                            <td style="border: 0"><?php echo $headerRow['keterangan']; ?></td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                    </table>
                                                </div>
                                               
                                            
                                                <div class="col-lg-12 panel panel-default" style="padding: 0px;margin-top: 30px">
                                                    <div class="panel-heading">
                                                        <h3>Input Hasil Qty<i class="pull-right fa fa-plus"></i></h3>
                                                    </div>
                                                    <div class="panel-body">
                                                        <div class="form-group col-lg-6" >
                                                            <label for="checking_qty" class="control-label col-lg-4">Qty Checking Oke :</label>
                                                            <input class="form-control" id="checking_qty" type="number" name="scrap_qty" placeholder="QTY">
                                                        </div>
                                                        <div class="form-group col-lg-6">
                                                            <label for="scrap_qty" class="control-label col-lg-4">Qty Scrap :</label>
                                                            <input class="form-control" id="scrap_qty" type="number" name="scrap_qty" placeholder="QTY">
                                                        </div>
                                                        <div class="col-lg-6">
                                                           <button class="btn btn-default" onclick='checkQuantity(this)' >Add <i class="fa fa-plus"></i></button>
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