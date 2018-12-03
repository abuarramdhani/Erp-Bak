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
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('Warehouse/MasterItem/Consumable');?>">
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
                                <?php 
                                $no_ind = $this->session->userdata('user');
                                if(in_array($no_ind, $admin)){
                                    ?>
                                    <a href="<?php echo site_url('Warehouse/MasterItem/ConsumableCreate/') ?>" style="float:right;margin-right:1%;margin-top:-0.5%;" alt="Add New" title="Add New" >
                                        <button type="button" class="btn btn-default btn-sm"><i class="icon-plus icon-2x"></i></button>
                                    </a>
                                    <?php
                                }
                                ?>
                            </div>
                            <div class="box-body">
                                <div class="table-responsive">
                                    <table class="datatable table table-striped table-bordered table-hover text-left" id="tblMasterItemConsumable" style="font-size:12px;">
                                        <thead class="bg-primary">
                                            <tr>
                                                <th style="text-align:center; width:30px">No</th>
                                                <?php 
                                                $no_ind = $this->session->userdata('user');
                                                if(in_array($no_ind, $admin)){
                                                    ?>
                                                    <th style="text-align:center; min-width:80px">Action</th>
                                                    <?php } ?>
                                                    <th>Item Name</th>
                                                    <th>Item Qty Awal</th>
                                                    <th>Item Qty Sisa</th>
                                                    <th>Item Qty Keluar</th>
                                                    <th>Item Qty Min</th>
                                                    <th>Item Desc</th>
                                                    <!-- <th>Item Barcode</th> -->
                                                    <th>Item Code</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                $no = 1; 
                                                foreach($MasterItemConsumable as $row):
                                                   $encrypted_string = $this->encrypt->encode($row['consumable_id']);
                                               $encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
                                               ?>
                                               <tr>
                                                <td align='center'><?php echo $no++;?></td>
                                                <?php 
                                                $no_ind = $this->session->userdata('user');
                                                if(in_array($no_ind, $admin)){
                                                    ?>
                                                    <td align='center'>
                                                      
                                                        <a style="margin-right:4px" href="<?php echo base_url('Warehouse/MasterItem/ConsumableUpdate/'.$encrypted_string.''); ?>" data-toggle="tooltip" data-placement="bottom" title="Edit Data"><span class="fa fa-pencil-square-o fa-2x"></span></a>
                                                        <a href="<?php echo base_url('Warehouse/MasterItem/ConsumableDelete/'.$encrypted_string.''); ?>" data-toggle="tooltip" data-placement="bottom" title="Hapus Data" onclick="return confirm('Are you sure you want to delete this item?');"><span class="fa fa-trash fa-2x"></span></a>
                                                        
                                                    </td>
                                                    <?php 
                                                }
                                                ?>
                                                <td><?php echo $row['item_name'] ?></td>
                                                <td><?php echo $row['item_qty_awal'] ?></td>
                                                <td><?php echo $row['item_qty_sisa'] ?></td>
                                                <td><?php echo $row['item_qty_dipinjam'] ?></td>
                                                <td><?php echo $row['item_qty_min'] ?></td>
                                                <td><?php echo $row['item_desc'] ?></td>
                                                <!-- 	<td><?php echo $row['item_barcode'] ?></td> -->
                                                <td><?php echo $row['item_code'] ?></td>
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
</section>