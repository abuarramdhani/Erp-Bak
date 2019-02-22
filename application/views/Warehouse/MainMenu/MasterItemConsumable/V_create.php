<section class="content">
    <div class="inner" >
        <div class="row">
            <form method="post" action="<?php echo site_url('Warehouse/MasterItem/ConsumableCreate');?>" class="form-horizontal">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-11">
                                <div class="text-right"><h1><b><?= $Title ?></b></h1></div>
                            </div>
                            <div class="col-lg-1 ">
                                <div class="text-right hidden-md hidden-sm hidden-xs">
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('Warehouse/MasterItem/ConsumableCreate');?>">
                                        <i class="icon-wrench icon-2x"></i>
                                        <span ><br /></span>
                                    </a>                             
                                </div>
                            </div>
                        </div>
                    </div>
                    <br />
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="box box-primary box-solid">
                                <div class="box-header with-border">Create Master Item Consumable</div>
                                <div class="box-body">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="form-group">
                                                <label for="txtItemCodeHeader" class="control-label col-lg-2">Item Id</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Item Id" name="txtItemCodeHeader" id="txtItemCodeHeader" class="form-control toupper" />
                                                </div>
                                            </div>
											<div class="form-group">
                                                <label for="txtItemNameHeader" class="control-label col-lg-2">Tool</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Tool Name" name="txtItemNameHeader" id="txtItemNameHeader" class="form-control" />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="txtItemMerk" class="control-label col-lg-2">Merk</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Merk" name="txtItemMerk" id="txtItemMerk" class="form-control" />
                                                </div>
                                            </div>
											<div class="form-group">
                                                <label for="txtItemQtyHeader" class="control-label col-lg-2">Item Qty</label>
                                                <div class="col-lg-4">
                                                    <input type="number" placeholder="Item Qty" name="txtItemQtyHeader" id="txtItemQtyHeader" class="form-control" />
                                                </div>
                                                <label for="txtItemQtyMinHeader" class="control-label col-lg-2">Item Qty Min</label>
                                                <div class="col-lg-4">
                                                    <input type="number" placeholder="Item Qty Min" name="txtItemQtyMinHeader" id="txtItemQtyMinHeader" class="form-control" />
                                                </div>
                                            </div>
											<div class="form-group">
                                                <label for="txaItemDescHeader" class="control-label col-lg-2">Item Desc</label>
                                                <div class="col-lg-4">
                                                    <textarea name="txaItemDescHeader" id="txaItemDescHeader" class="form-control" placeholder="Item Desc"></textarea>
                                                </div>
                                            </div>
											<!-- <div class="form-group">
                                                <label for="txtItemBarcodeHeader" class="control-label col-lg-4">Item Barcode</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Item Barcode" name="txtItemBarcodeHeader" id="txtItemBarcodeHeader" class="form-control toupper" />
                                                </div>
                                            </div> -->
                                        </div>
                                    </div>
                                    <div class="panel-footer">
                                        <div class="row text-right">
                                            <a href="javascript:history.back(1)" class="btn btn-primary btn-lg btn-rect">Back</a>
                                            &nbsp;&nbsp;
                                            <button type="submit" class="btn btn-primary btn-lg btn-rect">Save Data</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>