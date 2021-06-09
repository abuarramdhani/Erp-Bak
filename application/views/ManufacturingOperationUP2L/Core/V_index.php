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
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('ManufacturingOperationUP2L/Core');?>">
                                    <i class="icon-wrench icon-2x"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border">
                                <a href="<?php echo site_url('ManufacturingOperationUP2L/Core/view_create/') ?>" style="float:right;margin-right:1%;margin-top:-0.5%;" alt="Add New" title="Add New" >
                                    <button type="button" class="btn btn-default btn-sm"><i class="icon-plus icon-2x"></i></button>
                                </a>
                            </div>
                            <div class="box-body">
                                <div class="table-responsive">
                                    <table class="datatable table table-striped table-bordered table-hover text-left" id="tblCore2021" style="font-size:12px;">
                                        <thead class="bg-primary">
                                            <tr>
                                                <th style="text-align:center; width:30px">No</th>
                                                <th style="text-align:center; min-width:80px">Action</th>
                                                <th style="text-align:center;">Component Code</th>
                                                <th style="text-align:center;">Description</th>
                                                <th style="text-align:center;">Production Date</th>
                                                <th style="text-align:center;">Quantity</th>
                                                <th style="text-align:center;">Print Code</th>
                                                <th style="text-align:center;">Kode</th>
                                                <th style="text-align:center;">Shift</th>
                                                <th style="text-align:center;">Employee</th>
											</tr>
                                        </thead>
                                        <tbody>
                                            <!-- <?php
                                                $no = 1;
                                                foreach($Core as $row):
                                                $encrypted_string = $this->encrypt->encode($row['core_id']);
												$encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
											?>
                                            <tr>
                                                <td align='center'><?php echo $no++;?></td>
                                                <td align='center'>
                                                    <a style="margin-right:4px" href="<?php echo base_url('ManufacturingOperationUP2L/Core/read/'.$encrypted_string.''); ?>" data-toggle="tooltip" data-placement="bottom" title="Read Data"><span class="fa fa-list-alt fa-2x"></span></a>
                                                    <a style="margin-right:4px" href="<?php echo base_url('ManufacturingOperationUP2L/Core/update/'.$encrypted_string.''); ?>" data-toggle="tooltip" data-placement="bottom" title="Edit Data"><span class="fa fa-pencil-square-o fa-2x"></span></a>
                                                    <a href="<?php echo base_url('ManufacturingOperationUP2L/Core/delete/'.$encrypted_string.''); ?>" data-toggle="tooltip" data-placement="bottom" title="Hapus Data" onclick="return confirm('Are you sure you want to delete this item?');"><span class="fa fa-trash fa-2x"></span></a>
                                                </td>
                                                <td align='center'><?php echo $row['component_code'];?></td>
                                                <td align='center'><?php echo $row['component_description'];?></td>
                                                <td align='center'><?php echo $row['production_date'];?></td>
                                                <td align='center'><?php echo $row['core_quantity'];?></td>
                                                <td align='center'><?php echo $row['print_code'];?></td>
                                                <td align='center'><?php echo $row['kode'];?></td>
                                                <td align='center'><?php echo $row['shift'];?></td>
                                                <td align='center'><?php echo $row['employee_id'];?></td>
											</tr>
                                            <?php endforeach; ?> -->
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
