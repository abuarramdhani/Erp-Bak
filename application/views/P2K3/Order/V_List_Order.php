<section class="content">
    <div class="inner" >
        <div class="row">
            <div class="col-lg-12">
                <div class="col-lg-11">
                    <div class="text-right">
                        <h1><b>List Order Kebutuhan APD</b></h1>
                    </div>
                </div>
                    <div class="col-lg-1">
                        <div class="text-right hidden-md hidden-sm hidden-xs">
                            <a class="btn btn-default btn-lg" href="<?php echo site_url('P2K3/Order/list_order');?>">
                                <i class="icon-wrench icon-2x"></i>
                                <span><br/></span>  
                            </a>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-11">
                            <div class="text-right"><h1><b></b></h1></div>
                        </div>

                         <div class="panel panel-primary" style="height: 110px;">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-1">
                                        <div class="form-group">
                                            <label class="control-label">Departement</label> <br>
                                            <label class="control-label">Bidang</label> <br>
                                            <label class="control-label">Unit</label> <br>
                                        </div>
                                    </div>
                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <label class="control-label">: <?php echo $seksi[0]["dept"] ?></label> <br>
                                            <label class="control-label">: <?php echo $seksi[0]["bidang"] ?></label> <br>
                                            <label class="control-label">: <?php echo $seksi[0]["unit"] ?></label> <br>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                                        
                    </div>
                </div>
                <br/>
          
                <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border" style="height: 60px;">
                                <a href="<?php echo site_url('P2K3/Order/input')?>">
                                    <div style="float:right;margin-right:1%;margin-top:0px; margin-bottom: 5px;" alt="Add New" title="Add New">
                                        <button type="button" class="btn btn-default btn-sm"><i class="icon-plus icon-2x"></i></button>
                                    </div>
                                </a>
                            </div>

                            <div class="box-body">
                                <div class="row" style="margin-right: 3px;">
                                    <div class="col-lg-6">
                                         <form class="form-horizontal" method="POST" style="border:1px solid #3c8dbc;border-radius: 3px;padding-top: 10px" enctype="multipart/form-data" action="<?php echo base_url('P2K3/Order/UploadApproval'); ?>">
                                            <div class="form-group">
                                                <label class="form-label text-center col-lg-12">Upload Document Approval</label>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-lg-4">Bulan : </label>
                                                <div class="col-lg-7">
                                                    <input type="text" class="date form-control txtBulanTahunP2K3" name="txtBulanTahun" required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="lb_approval" class="control-label col-lg-4">Document Approval : </label>
                                                <div class="col-lg-7">
                                                    <div class="input-group ">
                                                        <input type="file" name="k3_approval" class="form-control" required/>
                                                    </div>
                                                </div>
                                                    
                                            </div>
                                            <div class="form-group">
                                                <div class="col-lg-12 text-center">
                                                    <button type="submit" class="btn btn-primary">Upload Approval</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-lg-6">
                                        <form class="form-horizontal" method="POST" target="_blank"  style="border:1px solid #dd4b39;border-radius: 3px;padding-top: 10px" action="<?php echo site_url('P2K3/Order/approval')?>">
                                            <div class="form-group">
                                                <label class="form-label text-center col-lg-12">Download Document Approval</label>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-lg-4">Bulan : </label>
                                                <div class="col-lg-7">
                                                    <input type="text" class="date form-control txtBulanTahunP2K3" name="txtBulanTahun" required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-lg-12 text-center">
                                                    <button class="btn btn-danger">Document Approval &nbsp <span class="fa fa-file-pdf-o"></span></button>
                                                </div>
                                                
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <br> 
                                <div class="row">
                                    <div class="col-lg-2">
                                        <a class="btn btn-primary" id="bt_export" href="<?php echo site_url('P2K3/Order/export')?>">
                                            Export &nbsp<span class="glyphicon glyphicon-arrow-up"></span>
                                        </a>
                                    </div>
                                    <div class="col-lg-10">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <label>Document Approval : </label>
                                            </div>
                                            <div class="col-lg-8">
                                                <?php 
                                                    $tampung_approval = array();
                                                    if (isset($tampil_data) and !empty($tampil_data)) {
                                                       foreach ($tampil_data as $tp_dt) {
                                                            if (!in_array($tp_dt['document_approval'], $tampung_approval)) {
                                                                echo '<label class="control-label"><a target="_blank" href="'.base_url('assets/upload/P2K3DocumentApproval/'.$tp_dt['document_approval']).'">'.$tp_dt['document_approval'].'</a></label><br>';
                                                                array_push($tampung_approval, $tp_dt['document_approval']);
                                                            }
                                                           
                                                        }
                                                    }else{
                                                        echo '<label class="control-label"> - </label><br>';
                                                    }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>   
                                <br>
                                <div class="table-responsive">
                                    <table id="tb_p2k3" class="datatable table table-striped table-bordered table-hover text-left" style="font-size:12px;">
                                        <thead class="bg-primary">
                                            <tr>
                                                <th width="5%" style="text-align: center; vertical-align: middle;">NO</th>
                                                <th width="10%" style="text-align: center; vertical-align: middle;">APD</th>
                                                <th style="text-align: center; width: 105px; vertical-align: middle;">KODE ITEM</th>
                                                <?php
                                                      foreach ($daftar_pekerjaan as $pekerjaan)
                                                     {
                                                ?>
                                                    <th style="text-align:center; width: 80px; vertical-align: middle;"><?php echo $pekerjaan['pekerjaan'];?> <p><small>(Kebutuhan per pekerja)</small></p></th>
                                                    <th style="text-align:center; width: 80px; vertical-align: middle;">Jumlah Pekerja (<?php echo $pekerjaan['pekerjaan'];?>)</th>
                                                 <?php
                                                     }
                                                ?>
                                                <th style="text-align: center; vertical-align: middle; width: 75px;">KEBUTUHAN UMUM</th>
                                                <th style="text-align: center; vertical-align: middle;">TOTAL ORDER</th>
                                                <th style="text-align: center; vertical-align: middle; width: 80px;">TOTAL PEMAKAIAN</th>
                                                <th style="text-align: center; vertical-align: middle;" hidden>SISA</th>
                                                <th style="text-align: center; vertical-align: middle;">KETERANGAN</th>
                                                <th style="text-align: center; vertical-align: middle;">STATUS</th>
                                                <th style="text-align: center; vertical-align: middle; width: 7%">ACTION</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php 
                                            $no=1;
                                            foreach ($tampil_data as $row) {
                                                $id_kebutuhan_detail = $row['id_kebutuhan_detail'];
                                        ?>
                                        <tr>
                                            <td style="text-align: center;"><?php echo $no; ?></td>
                                            <td style="text-align: center;"><?php echo $row['item']; ?></td>
                                            <td style="text-align: center;"><?php echo $row['kode_item']; ?></td>
                                            <?php 
                                                $jmlh=0;
                                                foreach ($daftar_pekerjaan as $pekerjaan) 
                                                {
                                            ?>
                                                <td style="text-align: center;">
                                                <?php 
                                                    $jumlah = explode(',',$row['jml']); 
                                                    if (isset($jumlah[$jmlh]) and !empty($jumlah[$jmlh])) {
                                                        print_r($jumlah[$jmlh]); 
                                                    }else{
                                                        echo "0";
                                                    }
                                                ?>
                                                </td>
                                                <td style="text-align: center;">
                                                <?php 
                                                    $jumlah = explode(',',$row['jml_pkj']); 
                                                    if (isset($jumlah[$jmlh]) and !empty($jumlah[$jmlh])) {
                                                        print_r($jumlah[$jmlh]); 
                                                    }else{
                                                        echo "0";
                                                    } 
                                                ?>
                                                </td>
                                            <?php 
                                                $jmlh++;
                                                }
                                            ?>
                                            <td style="text-align: center;"><?php echo $row['jml_umum']; ?></td>
                                            <td style="text-align: center;"><?php echo $row['ttl_order']; ?></td>
                                            <td style="text-align: center;"></td>
                                            <td style="text-align: center;" hidden></td>
                                            <td style="text-align: center;"><?php echo $row['desc'];?></td>
                                            <td style="text-align: center;">
                                                <?php if ($row['status'] == '0'){
                                                    echo "Pending";
                                                } else if ($row['status'] == '1'){
                                                    echo "Approved";
                                                } else {
                                                    echo "Rejected";
                                                }?>
                                            </td>
                                            <td style="text-align: center;" align="center">
                                                    <a data-toggle="tooltip" data-placement="left" title="Edit" href="<?php echo site_url('P2K3/Order/edit'.'/'.$id_kebutuhan_detail) ?>">
                                                        <button type="button" class="btn btn-info btn-xs">
                                                            <span class="glyphicon glyphicon-edit"></span>
                                                        </button>
                                                    </a>
                                                    <a data-toggle="tooltip" data-placement="left" title="Delete" href="<?php echo site_url('P2K3/Order/delete_apd'.'/'.$id_kebutuhan_detail) ?>">
                                                        <button style="margin-left: 3px" type="button" class="btn btn-danger btn-xs">
                                                            <span class="glyphicon glyphicon-trash"></span>
                                                        </button>
                                                    </a>
                                                    <br>
                                                    <?php 
                                                        if ($approve[0]['p2k3_approver'] == 't') { 
                                                    ?>
                                                
                                                     <a href="<?php echo site_url('P2K3/Order/approve'.'/'.$row['id_kebutuhan'].'/'.$row['id_kebutuhan_detail']);?>">
                                                        <button type="button" class="btn btn-success" style="margin: 10px 0 10px 0; padding: 5px 10px" >
                                                            <span class="glyphicon glyphicon-ok"></span>Approve
                                                        </button>
                                                    </a> 
                                                    <a href="<?php echo site_url('P2K3/Order/reject'.'/'.$row['id_kebutuhan_detail']);?>">
                                                        <button type="button" class="btn btn-danger" style="padding: 5px 15px">
                                                            <i class="glyphicon glyphicon-remove"></i>Reject
                                                        </button>
                                                    </a>
                                                    <?php 
                                                    } ?>
                                            </td>
                                        </tr>

                                        <?php
                                            $no++;
                                            }
                                        ?>                                                
                                        </tbody> 

                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>  
                <!-- <div class="box-header with-border">
                                <a href="<?php echo site_url('') ?>" style="float:right;margin-right:1%;margin-top:-0.5%;" alt="Add New" title="Add New" >
                                    <button type="button" class="btn btn-default btn-sm"><i class="icon-plus icon-2x"></i></button>
                                </a>
                </div> -->
            </div>    
        </div>
    </div>
</section>
