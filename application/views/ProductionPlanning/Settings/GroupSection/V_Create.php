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
                                        Create Group Section
                                    </b>
                                </h1>
                            </div>
                        </div>
                        <div class="col-lg-1 ">
                            <div class="text-right hidden-md hidden-sm hidden-xs">
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('ProductionPlanning/Setting/GroupSection/Create');?>">
                                    <i aria-hidden="true" class="fa fa-pencil fa-2x">
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
                                Input Data
                            </div>
                            <div class="panel-body">
                                <form method="post" class="form-horizontal" action="<?php echo base_url('ProductionPlanning/Setting/GroupSection/CreateSave'); ?>">
                                <div class="row">
                                    <div class="col-md-10">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="norm" class="control-label col-lg-4">Registered User</label>
                                                    <div class="col-lg-8">
                                                        <select class="form-control select4" name="userCode" required="">
                                                            <option></option>
                                                            <?php foreach ($regUser as $ru) { ?>
                                                                <option value="<?php echo $ru['user_id']; ?>">
                                                                    <?php echo $ru['employee_code'].' | '.$ru['employee_name']; ?>
                                                                </option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="norm" class="control-label col-lg-4">Section Access</label>
                                                    <div class="col-lg-8">
                                                        <select class="form-control select4" name="section[]" multiple="">
                                                            <option></option>
                                                            <?php foreach ($section as $s) { ?>
                                                                <option value="<?php echo $s['section_id']; ?>">
                                                                    <?php echo $s['section_name']; ?>
                                                                </option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-10">
                                        <div class="pull-right">
                                            <a class="btn btn-default" href="<?php echo base_url('ProductionPlanning/Setting/GroupSection') ?>">CANCEL</a>
                                            <button type="submit" class="btn btn-primary">SAVE</button>
                                        </div>
                                    </div>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>