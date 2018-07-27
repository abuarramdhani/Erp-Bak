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
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('SiteManagement');?>">
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
                               <form action="<?php echo base_url('SiteManagement/Order/FilterData');?>" method="post" enctype="multipart/formdata">
                                   <div class="col-md-3">
                                        <div class="input-group">
                                            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                            <input class="form-control sm_tglmonitoring"  data-date-format="d M Y" autocomplete="off" type="text" name="sm_tglorder" id="sm_tglorder" style="width: 200px" placeholder="Masukkan Periode" value=""/>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="input-group">
                                            <select class="form-control sm-selectseksi" name="order_seksi" id="order_seksi" style="width:240px">
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="input-group">
                                            <select class="form-control sm_select2" name="sm_jenisorder" id="sm_order" style="width: 200px">
                                                <option value=""></option>
                                                <option value="Perbaikan Kursi">Perbaikan Kursi</option>
                                                <option value="Cleaning Service">Cleaning Service</option>
                                                <option value="Lain-Lain">Lain-Lain</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3" align="right">
                                        <div class="input-group">
                                            <button type="submit" class="btn btn-success pull-right" id="btn-smfilter" disabled>Search</button>
                                        </div>
                                    </div>
                               </form>
                            </div>
                            <div class="box-body">
                                <div>
                                    <table class="table table-striped table-bordered table-hover text-left sm_datatable" style="font-size:12px;">
                                       <thead class="bg-primary">
                                            <tr>
                                                <th style="text-align:center; width:30px">No</th>
                                                <th>No Order</th>
                                                <th>Tanggal Order</th>
                                                <th style="text-align:center; min-width:80px">Action</th>
                                                <th>Jenis Order</th>
                                                <th>Seksi Order</th>
                                                <th>Tanggal Kebutuhan</th>
                                                <th>Tanggal Terima</th>
                                                <th>Remarks</th>
                                                <th>Status</th>
                                                <th>Reject</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                $no = 1; 
                                                if (!isset($list_order)) {
                                                    $data_item = $filterdata;
                                                }else{
                                                    $data_item = $list_order;
                                                }

                                                foreach($data_item as $row):
                                                $encrypted_string = $this->encrypt->encode($row['id_order']);
                                                $encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
                                            ?>
                                            <tr>
                                                <td align='center'><?php echo $no++;?></td>
                                                <td><?php echo $row['no_order'] ?></td>
                                                <td><?php echo date('Y-m-d', strtotime($row['tgl_order'])); ?></td>
                                                <td align='center'>
                                                    <a style="margin-right:4px" href="<?php echo base_url('SiteManagement/Order/readData/'.$encrypted_string.''); ?>" data-toggle="tooltip" data-placement="bottom" title="Read Data"><span class="fa fa-file-text-o fa-2x"></span></a>
                                                    <a style="margin-right:4px" href="<?php echo base_url('SiteManagement/Order/DeleteOrderMasuk/'.$encrypted_string.''); ?>" data-toggle="tooltip" onclick="return confirm('Are you sure you want to delete this item?');" data-placement="bottom" title="Hapus Data"><span class="fa fa-trash fa-2x"></span></a>
                                                </td>
                                                <td><?php echo $row['jenis_order'] ?></td>
                                                <td><?php echo $row['nama_seksi'] ?></td>
                                                <td><?php echo date('Y-m-d', strtotime($row['due_date']));?></td>
                                                <td><?php if($row['tgl_terima']==null || $row['tgl_terima']==''){echo "";}else{ echo date('Y-m-d', strtotime($row['tgl_terima']));}?></td>
                                                <td align="center"><input type="checkbox" name="re_order" class="sm_remarksorder" data-id="<?php echo $row['id_order'];?>" <?php if($row['remarks']==='t') {echo "checked";}?> <?php if($row['status']!=1) {echo "disabled";}?>></td>
                                                <td align="center">
                                                    <?php 
                                                        if($row['status']==0){echo "<b style='color:orange;'>New</b>";}
                                                        elseif ($row['status']==1) {echo "<b style='color:blue;'>Approve</b>";}
                                                        elseif ($row['status']==2) {echo "<b style='color:red;'>Reject by admin</b>";}
                                                        elseif ($row['status']==3) {echo "<b style='color:green;'>Done</b>";}
                                                        elseif ($row['status']==4) {echo "<b style='color:navy;'>Reject by system</b>";}
                                                    ?>
                                                </td>
                                                <td><button class="btn btn-danger" id="sm_reject" data-id="<?php echo $row['id_order'];?>" <?php if($row['status']!=0) {echo "disabled";}?>>Reject</button>
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
