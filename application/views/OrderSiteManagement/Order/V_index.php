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
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('OrderSiteManagement');?>">
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
                                <br></br>
                            </div>
                            <div class="box-body">
                                <div>
                                    <table class="table table-striped table-bordered table-hover text-left sm_datatable" style="font-size:12px;">
                                        <thead class="bg-primary">
                                            <tr>
                                                <th style="text-align:center; width:30px">No</th>
                                                <th style="text-align:center; min-width:80px">Action</th>
												<th>No Order</th>
												<th>Tanggal Order</th>
												<th>Jenis Order</th>
												<th>Seksi Order</th>
												<th>Tanggal Kebutuhan</th>
                                                <th>Status</th>
											</tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                $no = 1; 
                                                foreach($list_order as $row):
                                                $encrypted_string = $this->encrypt->encode($row['id_order']);
                                                $encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
                                            ?>
                                            <tr>
                                                <td align='center'><?php echo $no++;?></td>
                                                <td align='center'>
                                                    <?php if($row['status']==0):?>
                                                    <a target="blank_" style="margin-right:4px" href="<?php echo base_url('OrderSiteManagement/Order/CetakData/'.$encrypted_string.''); ?>" data-toggle="tooltip" data-placement="bottom" title="Cetak Data" ><span class="fa fa-file-pdf-o fa-2x"></span></a>
                                                    <?php else: ?>
                                                        <span class="fa fa-file-pdf-o fa-2x" style="color: red;" title="Order Sudah Diproses Oleh GA"></span>
                                                    <?php endif; ?>
                                                </td>
                                                <td><?php echo $row['no_order'] ?></td>
                                                <td><?php echo date('Y-m-d', strtotime($row['tgl_order'])); ?></td>
                                                <td><?php echo $row['jenis_order'] ?></td>
                                                <td><?php echo $row['nama_seksi'] ?></td>
                                                <td><?php echo date('Y-m-d', strtotime($row['due_date']));?></td>
                                                <td align="center">
                                                    <?php 
                                                        if($row['status']==0){echo "<b style='color:orange;'>New</b>";}
                                                        elseif ($row['status']==1) {echo "<b style='color:blue;'>Approve</b>";}
                                                        elseif ($row['status']==2) {echo "<b style='color:red;'>Reject by admin</b>";}
                                                        elseif ($row['status']==3) {echo "<b style='color:green;'>Done</b>";}
                                                        elseif ($row['status']==4) {echo "<b style='color:pink;'>Reject by system</b>";}
                                                    ?>
                                                </td>
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