<section class="content">
    <div class="inner" >
        <div class="row">
            <form method="post" action="<?php echo site_url('ManufacturingOperationUP2L/QualityControl/create');?>" class="form-horizontal">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-11">
                                <div class="text-right"><h1><b><?= $Title ?></b></h1></div>
                            </div>
                            <div class="col-lg-1 ">
                                <div class="text-right hidden-md hidden-sm hidden-xs">
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('ManufacturingOperationUP2L/QualityControl/');?>">
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
                                <div class="box-header with-border">Create Quality Control</div>
                                <div class="box-body">
                                    <div class="panel-body">
                                        <div class="row">
											<div class="form-group">
                                                <label for="txtCheckingDateHeader" class="control-label col-lg-4">Tanggal Cetak</label>
                                                <div class="col-lg-3">
                                                    <input type="text" name="txtCheckingDateHeader" class="form-control time-form " required="" placeholder="Tanggal Cetak" >
                                                </div>
                                                <div class="col-lg-2">
                                                    <button class="btn btn-primary" id="tanggal_cetak" type="button">Process</div>
                                                </div>
                                            </div>
                                             <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border">
                            </div>
                            <div class="box-body">
                                <div class="table-responsive">
                                    <table class="datatable table table-striped table-bordered table-hover text-left" id="tblQualityControl" style="font-size:12px;">
                                        <thead class="bg-primary">
                                            <tr>
                                                <th style="text-align:center; width:30px">No</th>
                                                <th style="text-align:center; min-width:80px">Action</th>
                                                <th>Component Code</th>
                                                <th>Component Description</th>
                                                <th>Production Date</th>
                                                <th>Moulding Quantity</th>
                                                <th>Print Code</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tableQuality">
                                            
                                            
                                        </tbody>                                      
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>    

											<!-- <div class="form-group">
                                                <label for="txtPrintCodeHeader" class="control-label col-lg-4">Print Code</label>
                                                <div class="col-lg-4">
                                                    <select placeholder="Print Code" name="txtPrintCodeHeader" id="txtPrintCodeHeader" class="form-control">
                                                        <option></option>
                                                        <?php foreach ($PrintCode as $value): ?>
                                                            <option value="<?php echo $value['print_code']; ?>"><?php echo $value['print_code']; ?></option>    
                                                        <?php endforeach ?>
                                                    </select>
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtCheckingQuantityHeader" class="control-label col-lg-4">Checking Quantity</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Checking Quantity" name="txtCheckingQuantityHeader" id="txtCheckingQuantityHeader" class="form-control" />
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtScrapQuantityHeader" class="control-label col-lg-4">Scrap Quantity</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Scrap Quantity" name="txtScrapQuantityHeader" id="txtScrapQuantityHeader" class="form-control" />
                                                </div>
                                            </div> -->


                                        </div>

                                        <div class="col-lg-12">
                                            <br />
                                            <br />
                                            <div class="row">
                                                <div class="nav-tabs-custom">
                                                    <ul class="nav nav-tabs">
                                                    </ul>
                                                    <div class="tab-content">
                                                    </div>
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
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>