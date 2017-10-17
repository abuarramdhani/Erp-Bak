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
                                        Setting Group Section
                                    </b>
                                </h1>
                            </div>
                        </div>
                        <div class="col-lg-1 ">
                            <div class="text-right hidden-md hidden-sm hidden-xs">
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('ProductionPlanning/Setting/GroupSection');?>">
                                    <i aria-hidden="true" class="fa fa-group fa-2x">
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
                                <a class="pull-right" title="Add New" href="<?php echo site_url('ProductionPlanning/Setting/GroupSection/Create') ?>">
                                    <button class="btn btn-default btn-sm" type="button">
                                        <i class="icon-plus icon-2x">
                                        </i>
                                    </button>
                                </a>
                                Data Group Section
                            </div>
                            <div class="panel-body">
                                <table class="table table-striped table-bordered table-hover" id="tbdatagroupsection">
                                    <thead class="bg-primary">
                                        <tr>
                                            <td>
                                                No
                                            </td>
                                            <td>
                                                User Name
                                            </td>
                                            <td>
                                                User Code
                                            </td>
                                            <td>
                                                Employee Name
                                            </td>
                                            <td>
                                                Group Section
                                            </td>
                                            <td style="width: 10%;">
                                                Action
                                            </td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no=1; foreach ($userGroup as $ug) { ?>
                                        <tr>
                                            <td><?php echo $no++; ?></td>
                                            <td><?php echo $ug['user_name']; ?></td>
                                            <td><?php echo $ug['employee_code']; ?></td>
                                            <td><?php echo $ug['employee_name']; ?></td>
                                            <td>
                                                <?php
                                                unset($section);
                                                $section = array();
                                                foreach ($sectionGroup as $sg) { 
                                                    if ($sg['pp_user_id']== $ug['pp_user_id']) {
                                                         $section[] = $sg['section_name'];
                                                    }
                                                }
                                                $count = count($section);
                                                if (!$count==0) {
                                                    $sec = implode($section, ', ');
                                                    echo $sec;
                                                }else{
                                                    echo "-";
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-justified" role="group" aria-label="...">
                                                    <a href="<?php echo base_url('ProductionPlanning/Setting/GroupSection/Edit/'.$ug['pp_user_id']) ?>" class="btn btn-success">
                                                        <i aria-hidden="true" class="fa fa-pencil-square-o"></i>
                                                    </a>
                                                    <a href="javascript:void(0)" class="btn btn-danger">
                                                        <i aria-hidden="true" class="fa fa-trash"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>