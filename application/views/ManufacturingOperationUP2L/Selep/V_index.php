<section class="content">
    <div class="inner" >
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-11">
                            <div class="text-right"><h1><b><?= $Title ?></b></h1></div>
                        </div>
                        <div class="col-lg-1">
                            <div class="text-right hidden-md hidden-sm hidden-xs">
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('ManufacturingOperationUP2L/Selep');?>">
                                    <i class="icon-wrench icon-2x"></i>
                                    <br/>
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
                                <a href="<?php echo site_url('ManufacturingOperationUP2L/Selep/view_create/') ?>" style="float:right;margin-right:1%;margin-top:-0.5%;" alt="Add New" title="Add New" >
                                    <button type="button" class="btn btn-default btn-sm"><i class="icon-plus icon-2x"></i></button>
                                </a>
                            </div>
                            <div class="box-body">
                                <div class="table-responsive">
                                    <table class="datatable table table-striped table-bordered table-hover text-left" id="tblSelep_ss" style="font-size:12px;">
                                        <thead class="bg-primary">
                                            <tr>
                                                <th style="text-align:center; width:30px">No</th>
                                                <th style="text-align:center; min-width:80px">Action</th>
                        												<th>Selep Date</th>
                        												<th>Component Code</th>
                        												<th>Component Description</th>
                        												<th>Selep Quantity</th>
                        												<th>Scrap Quantity</th>
                                                <th>Shift</th>
                        												<th>Employee</th>
                        											</tr>
                                        </thead>
                                        <tbody>
                                            <!-- <?php
                                            	//$no = 1; foreach($Selep as $row):
											                       ?>
                                            <tr>
                                                <td align='center'><?php echo $no++;?></td>
                                                <td align='center'>
                                                	<a style="margin-right:4px" href="<?php //echo base_url('ManufacturingOperationUP2L/Selep/read/'. $row['selep_id']); ?>" data-toggle="tooltip" data-placement="bottom" title="Read Data"><span class="fa fa-list-alt fa-2x"></span></a>
                                                	<a style="margin-right:4px" href="<?php //echo base_url('ManufacturingOperationUP2L/Selep/edit/'. $row['selep_id']); ?>" data-toggle="tooltip" data-placement="bottom" title="Edit Data"><span class="fa fa-pencil-square-o fa-2x"></span></a>
                                                	<a href="<?php //echo base_url('ManufacturingOperationUP2L/Selep/delete/'.$row['selep_id']); ?>" data-toggle="tooltip" data-placement="bottom" title="Hapus Data" onclick="return confirm('Are you sure you want to delete this item?');"><span class="fa fa-trash fa-2x"></span></a>
                                                </td>
                        												<td><?php // echo $row['selep_date'] ?></td>
                        												<td><?php // echo $row['component_code'] ?></td>
                        												<td><?php // echo $row['component_description'] ?></td>
                        												<td><?php // echo $row['selep_quantity'] ?></td>
                        												<td><?php // echo $row['scrap_quantity'] ?></td>
                                                                        <td><?php // echo $row['shift'] ?></td>
                        												<td><?php // echo $row['job_id'] ?></td>
                        											</tr>
                                            <?php //endforeach; ?> -->
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
</section>
