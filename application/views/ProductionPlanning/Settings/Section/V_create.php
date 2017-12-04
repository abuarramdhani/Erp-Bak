<section class="content">
    <div class="inner">
        <div class="row">
            <form method="post" action="<?php echo site_url('ProductionPlanning/Setting/Section/create');?>" class="form-horizontal">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-11">
                                <div class="text-right"><h1><b><?= $Title ?></b></h1></div>
                            </div>
                            <div class="col-lg-1 ">
                                <div class="text-right hidden-md hidden-sm hidden-xs">
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('ProductionPlanning/Setting/Section/');?>">
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
                                <div class="box-header with-border">Create Section</div>
                                <div class="box-body">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="form-group">
                                                <label for="txtSectionNameHeader" class="control-label col-lg-4">Section Name</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Section Name" name="txtSectionNameHeader" id="txtSectionNameHeader" class="form-control" required="" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group">
                                                <label for="LocatorId" class="control-label col-lg-4">Locator Id</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Locator Id" name="LocatorId" id="LocatorId" class="form-control" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group">
                                                <label for="OrganizationId" class="control-label col-lg-4">Organization Id</label>
                                                <div class="col-lg-4">
                                                    <select class="form-control select4" data-placeholder="Organization Id" name="OrganizationId" id="OrganizationId" required="">
                                                        <option></option>
                                                        <option value="ODM">ODM</option>
                                                        <option value="OPM">OPM</option>
                                                        <option value="0">ODM & OPM</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group">
                                                <label for="DepartementClass" class="control-label col-lg-4">Departement Class</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Departement Class" name="DepartementClass" id="DepartementClass" class="form-control" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
											<div class="form-group">
                                                <label for="RoutingClass" class="control-label col-lg-4">Routing Class</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Routing Class" name="RoutingClass" id="RoutingClass" class="form-control" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-footer">
                                        <div class="row text-right">
                                            <a href="<?php echo site_url('ProductionPlanning/Setting/Section/');?>" class="btn btn-primary btn-lg btn-rect">Back</a>
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