<section class="content">
    <div class="inner" >
        <div class="row">
            <form method="post" action="<?php echo site_url('ManufacturingOperationUP2L/Selep/update/'.$id);?>" class="form-horizontal">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-11">
                                <div class="text-right"><h1><b><?= $Title ?></b></h1></div>
                            </div>
                            <div class="col-lg-1 ">
                                <div class="text-right hidden-md hidden-sm hidden-xs">
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('ManufacturingOperationUP2L/Selep/');?>">
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
                                <div class="box-header with-border">Update Selep</div>
                                <?php
                                    foreach ($Selep as $headerRow):
                                ?>
                                <div class="box-body">
                                    <div class="panel-body">
                                        <div class="row">
											<div class="form-group">
                                                <label for="txtSelepDateHeader" class="control-label col-lg-4">Selep Date</label>
                                                <div class="col-lg-4">
                                                    <input type="text" name="txtSelepDateHeader" class="form-control time-form ajaxOnChange" value="<?php echo $headerRow['selep_date']; ?>" required="" placeholder="Selep Date">
                                                </div>
                                                
                                            </div>

											<div class="form-group">
                                                <label for="txtComponentCodeHeader" class="control-label col-lg-4">Component Code</label>
                                                <div class="col-lg-4">
                                                   <select class="form-control jsSlcComp toupper" id="txtComponentCodeHeader" name="component_description" required data-placeholder="Component Code" onchange="getCompDescMO(this)">
                                                    <option><?php echo $headerRow['component_code']; ?></option>
                                                    </select>
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtComponentDescriptionHeader" class="control-label col-lg-4">Component Description</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Component Description" name="txtComponentDescriptionHeader" id="txtComponentDescriptionHeader" class="form-control" value="<?php echo $headerRow['component_description']; ?>"/>
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtSelepQuantityHeader" class="control-label col-lg-4">Selep Quantity</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Selep Quantity" name="txtSelepQuantityHeader" id="txtSelepQuantityHeader" class="form-control" value="<?php echo $headerRow['selep_quantity']; ?>"/>
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtJobIdHeader" class="control-label col-lg-4">Job Id</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Job Id" name="txtJobIdHeader" id="txtJobIdHeader" class="form-control" value="<?php echo $headerRow['job_id']; ?>"/>
                                                </div>
                                            </div>


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
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>