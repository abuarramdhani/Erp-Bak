<section class="content">
    <div class="inner" >
        <div class="row">
            <form method="post" action="<?php echo site_url('PayrollManagementNonStaff/Setelan/update/'.$id);?>" class="form-horizontal">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-11">
                                <div class="text-right"><h1><b><?= $Title ?></b></h1></div>
                            </div>
                            <div class="col-lg-1 ">
                                <div class="text-right hidden-md hidden-sm hidden-xs">
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('PayrollManagementNonStaff/Setelan/');?>">
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
                                <div class="box-header with-border">Update Setelan</div>
                                <?php
                                    foreach ($Setelan as $headerRow):
                                ?>
                                <div class="box-body">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="form-group">
                                                <label for="txtSetelanValueHeader" class="control-label col-lg-4">Setelan Value</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Setelan Name" class="form-control" value="<?php echo $headerRow['setelan_name']; ?>" disabled/>
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtSetelanValueHeader" class="control-label col-lg-4">Setelan Value</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Setelan Value" name="txtSetelanValueHeader" id="txtSetelanValueHeader" class="form-control" value="<?php echo $headerRow['setelan_value']; ?>"/>
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtSetelanInfoHeader" class="control-label col-lg-4">Setelan Info</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Setelan Info" name="txtSetelanInfoHeader" id="txtSetelanInfoHeader" class="form-control" value="<?php echo $headerRow['setelan_info']; ?>"/>
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