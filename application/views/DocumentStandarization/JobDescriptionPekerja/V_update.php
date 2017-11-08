<section class="content">
    <div class="inner" >
        <div class="row">
            <form method="post" action="<?php echo site_url('DocumentStandarization/JobdeskEmployee/update/'.$id);?>" class="form-horizontal">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-11">
                                <div class="text-right"><h1><b><?= $Title ?></b></h1></div>
                            </div>
                            <div class="col-lg-1 ">
                                <div class="text-right hidden-md hidden-sm hidden-xs">
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('DocumentStandarization/JobdeskEmployee/');?>">
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
                                <div class="box-header with-border">Update Jobdesk Employee</div>
                                <?php
                                    foreach ($JobdeskEmployee as $headerRow):
                                ?>
                                <div class="box-body">
                                    <div class="panel-body">
                                        <div class="row">
											<div class="form-group">
                                                <label for="txtJdIdHeader" class="control-label col-lg-4">Jd Id</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Jd Id" name="txtJdIdHeader" id="txtJdIdHeader" class="form-control" value="<?php echo $headerRow['jd_id']; ?>"/>
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtEmployeeIdHeader" class="control-label col-lg-4">Employee Id</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Employee Id" name="txtEmployeeIdHeader" id="txtEmployeeIdHeader" class="form-control" value="<?php echo $headerRow['employee_id']; ?>"/>
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