<input type="hidden" id="up2l_tmpl" value="<?= $tmpl; ?>">
<style>
    .active {
        color : #000 !important;
        background-color: #FFF !important;
    }
    a.nav-link{
        cursor:pointer;
    }
</style>
<section class="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-11">
                            <div class="text-right">
                                <h1><b><?= $Title ?></b></h1>
                            </div>
                        </div>
                        <div class="col-lg-1">
                            <div class="text-right hidden-md hidden-sm hidden-xs">
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('ManufacturingOperationUP2L/QualityControl'); ?>">
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
                            <div class="box-header with-border">
                                <b>Search</b>
                            </div>
                            <div id="sear_1">
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div id="searchSEmpUP2L"></div>
                                        </div>
                                        <div class="col-lg-4" style="">
                                            <div id="searchSShiftUP2L"></div>
                                        </div>
                                        <form action="<?= base_url('ManufacturingOperationUP2L/QualityControl/selectByDate1') ?>" method="post">
                                            <div class="col-lg-2">
                                                <input type="text" class="form-control selcDateUp2L" placeholder="Selep Date" name="dateSQCUp2l" id="dateQCUp2l" />
                                            </div>
                                            <div class="col-lg-2" style="margin:0px;">
                                                <button type="submit" class="btn btn-success"><i class="fa fa-search"></i></button>
                                                <a class="btn btn-warning" href="<?= base_url('ManufacturingOperationUP2L/QualityControl'); ?>"><i class="fa fa-refresh"></i></a>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div id="sear_2" style="display:none;">
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div id="searchEmpUP2L"></div>
                                    </div>
                                    <div class="col-lg-4" style="">
                                        <div id="searchShiftUP2L"></div>
                                    </div>
                                    <form action="<?= base_url('ManufacturingOperationUP2L/QualityControl/selectByDate2') ?>" method="post">
                                        <div class="col-lg-2">
                                            <input type="text" class="form-control selcDateUp2L" placeholder="Checking Date" name="dateQCUp2l" id="dateQCUp2l" />
                                        </div>
                                        <div class="col-lg-2" style="margin:0px;">
                                            <button type="submit" class="btn btn-success"><i class="fa fa-search"></i></button>
                                            <a class="btn btn-warning" href="<?= base_url('ManufacturingOperationUP2L/QualityControl'); ?>"><i class="fa fa-refresh"></i></a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="box box-primary box-solid">

                            <div class="box-header with-border">
                                <ul class="nav nav-tabs">
                                    <li class="nav-item">
                                        <a id="mo_button1" class="nav-link">Belum QC</a>
                                    </li>
                                    <li>
                                        <a id="mo_button2" class="nav-link">Sudah QC</a>
                                    </li>
                                </ul>
                            </div>

                            <div class="box-body" id="mo_tab1">
                                <div class="row" style="margin:10px;">
                                    <div class="table-responsive">
                                        <table class="datatable table table-striped table-bordered table-hover text-left" id="tblSelep" style="font-size:12px;">
                                            <thead class="bg-primary">
                                                <tr>
                                                    <th style="text-align:center; width:30px">No</th>
                                                    <th style="text-align:center; min-width:80px">Action</th>
                                                    <th>Selep Date</th>
                                                    <th>Component Code</th>
                                                    <th>Component Description</th>
                                                    <th>Selep Quantity OK</th>
                                                    <th>Scrap Quantity</th>
                                                    <th>Shift</th>
                                                    <th>Employee</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                    $no = 1; 
                                                    foreach($Selep as $row):
                                                ?>
                                                <tr>
                                                    <td align='center'><?php echo $no++;?></td>
                                                    <td align='center'>
                                                    <a style="margin-right:4px; cursor:pointer;" data-toggle="modal" onclick="swnKuburan(<?= $row['selep_id'] ?>)" data-target="#mdlHasilQC" title="Tambah Data Selep Ke QC"> <span class="fa fa-plus fa-2x"></span> </a>
                                                        <!-- <span style="margin-right:4px" href="<?php// echo base_url('ManufacturingOperationUP2L/QualityControl/read_detail/'.$row['selep_id'].''); ?>" data-toggle="tooltip" data-placement="bottom" title="Tambah Data Selep Ke QC"><span class="fa fa-plus fa-2x"></span></a> -->
                                                        <a style="margin-right:4px" href="<?php echo base_url('ManufacturingOperationUP2L/Selep/edit/'.$row['selep_id'].''); ?>" data-toggle="tooltip" data-placement="bottom" title="Edit Data"><span class="fa fa-pencil-square-o fa-2x"></span></a>
                                                        <a href="<?php echo base_url('ManufacturingOperationUP2L/Selep/delete/'.$row['selep_id'].''); ?>" data-toggle="tooltip" data-placement="bottom" title="Hapus Data" onclick="return confirm('Are you sure you want to delete this item?');"><span class="fa fa-trash fa-2x"></span></a>
                                                    </td>
                                                    <td><?php echo $row['selep_date'] ?></td>
                                                    <td><?php echo $row['component_code'] ?></td>
                                                    <td><?php echo $row['component_description'] ?></td>
                                                    <td><?php echo $row['selep_quantity'] ?></td>
                                                    <td><?php echo $row['scrap_quantity'] ?></td>
                                                    <td><?php echo $row['shift'] ?></td>
                                                    <td><?php echo $row['job_id'] ?></td>
                                                </tr>
                                                <?php endforeach; ?>
                                            </tbody>                                      
                                        </table>
                                        <!-- Modal -->
                                        <div class="modal fade" id="mdlHasilQC" tabindex="-1" role="dialog" aria-labelledby="mdlHasilQC" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <b class="modal-title" id="mdlHasilQC">QC Data Selep</b>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-content">
                                                        <input type="hidden" id="component_code">
                                                        <input type="hidden" id="description">
                                                        <input type="hidden" id="production_date">
                                                        <input type="hidden" id="shift">
                                                        <input type="hidden" id="job_id">
                                                        <input type="hidden" id="selep_qty">
                                                        <input type="hidden" id="mould_id">
                                                        <div class="row">
                                                            <div class="col-lg-2"></div>
                                                            <div class="col-lg-8" id="inPuY"></div>
                                                            <div class="col-lg-2"></div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                        <button type="button" onclick='checkQuantity(this)' class="btn btn-primary">Save</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /Modal -->
                                    </div>
                                </div>
                                </div>
                                <div class="box-body" id="mo_tab2" style="display:none">
                                <div class="row" style="margin:10px;">
                                    <div class="table-responsive">
                                        <table class="datatable table table-striped table-bordered table-hover text-left" id="tblQualityControl" style="font-size:12px;">
                                            <thead class="bg-primary">
                                                <tr>
                                                    <th style="text-align:center; width:30px">No</th>
                                                    <th style="text-align:center; min-width:80px">Action</th>
                                                    <th>Tanggal Cetak</th>
                                                    <th>Component Code</th>
                                                    <th>Component Description</th>
                                                    <th>Shift</th>
                                                    <th>Selep Quantity OK</th>
                                                    <th>Checking Quantity</th>
                                                    <th>Scrap Quantity</th>
                                                    <th>Remaining Quantity</th>
                                                    <th>Employee</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $no = 1;
                                                foreach ($QualityControl as $row) :
                                                    // echo "<pre>";print_r($QualityControl);exit();
                                                    $encrypted_string = $this->encrypt->encode($row['quality_control_id']);
                                                    $encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
                                                    ?>
                                                    <tr>
                                                        <td align='center'><?php echo $no++; ?></td>
                                                        <td align='center'>
                                                            <a style="margin-right:4px" href="<?php echo base_url('ManufacturingOperationUP2L/QualityControl/read/' . $row['quality_control_id'] . ''); ?>" data-toggle="tooltip" data-placement="bottom" title="Read Data"><span class="fa fa-list-alt fa-2x"></span></a>
                                                            <a style="margin-right:4px" href="<?php echo base_url('ManufacturingOperationUP2L/QualityControl/update/' . $row['quality_control_id'] . ''); ?>" data-toggle="tooltip" data-placement="bottom" title="Edit Data"><span class="fa fa-pencil-square-o fa-2x"></span></a>
                                                            <a href="<?php echo base_url('ManufacturingOperationUP2L/QualityControl/delete/' . $row['quality_control_id'] . ''); ?>" data-toggle="tooltip" data-placement="bottom" title="Hapus Data" onclick="return confirm('Are you sure you want to delete this item?');"><span class="fa fa-trash fa-2x"></span></a>
                                                        </td>
                                                        <td><?php echo $row['checking_date'] ?></td>
                                                        <td><?php echo $row['component_code']; ?></td>
                                                        <td><?php echo $row['component_description']; ?></td>
                                                        <td><?php echo $row['shift']; ?></td>
                                                        <td><?php echo $row['selep_quantity'] ?></td>
                                                        <td><?php echo $row['checking_quantity'] ?></td>
                                                        <td><?php echo $row['scrap_quantity'] ?></td>
                                                        <td><?php echo ($row['selep_quantity'] - ($row['checking_quantity'] + $row['scrap_quantity'])) ?></td>
                                                        <td><?php echo $row['employee'] ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
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