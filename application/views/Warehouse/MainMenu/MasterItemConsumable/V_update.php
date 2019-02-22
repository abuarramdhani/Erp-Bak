<section class="content">
    <div class="inner" >
        <div class="row">
            <form method="post" action="<?php echo site_url('Warehouse/MasterItem/ConsumableUpdate/'.$id);?>" class="form-horizontal">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-11">
                                <div class="text-right"><h1><b><?= $Title ?></b></h1></div>
                            </div>
                            <div class="col-lg-1 ">
                                <div class="text-right hidden-md hidden-sm hidden-xs">
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('Warehouse/MasterItem/Consumable/');?>">
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
                                <div class="box-header with-border">Update Master Item Consumable</div>
                                <?php
                                    foreach ($MasterItemConsumable as $headerRow):
                                ?>
                                <div class="box-body">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="form-group">
                                                <label for="txtItemCodeHeader" class="control-label col-lg-4">Item Code</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Item Code" name="txtItemCodeHeader" id="txtItemCodeHeader" class="form-control" value="<?php echo $headerRow['item_code']; ?>"/>
                                                </div>
                                            </div>
											<div class="form-group">
                                                <label for="txtItemNameHeader" class="control-label col-lg-4">Item Name</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Item Name" name="txtItemNameHeader" id="txtItemNameHeader" class="form-control" value="<?php echo $headerRow['item_name']; ?>"/>
                                                </div>
                                            </div>
											<div class="form-group">
                                                <label for="txtItemQtyHeader" class="control-label col-lg-4">Item Qty</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Item Qty" name="txtItemQtyHeader" id="txtItemQtyHeader" class="form-control" value="<?php echo $headerRow['item_qty']; ?>"/>
                                                </div>
                                            </div>
											<div class="form-group">
                                                <label for="txtItemQtyMinHeader" class="control-label col-lg-4">Item Qty Min</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Item Qty Min" name="txtItemQtyMinHeader" id="txtItemQtyMinHeader" class="form-control" value="<?php echo $headerRow['item_qty_min']; ?>"/>
                                                </div>
                                            </div>
											<div class="form-group">
                                                <label for="txaItemDescHeader" class="control-label col-lg-4">Item Desc</label>
                                                <div class="col-lg-4">
                                                    <textarea name="txaItemDescHeader" id="txaItemDescHeader" class="form-control" placeholder="Item Desc"><?php echo $headerRow['item_desc']; ?></textarea>
                                                </div>
                                            </div>
											<div class="form-group">
                                                <label for="txtItemBarcodeHeader" class="control-label col-lg-4">Item Barcode</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Item Barcode" name="txtItemBarcodeHeader" id="txtItemBarcodeHeader" class="form-control" value="<?php echo $headerRow['item_barcode']; ?>"/>
                                                </div>
                                            </div>
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
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>