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
                                <a hidden href="<?php echo site_url('P2K3/Order/input')?>">
                                    <div style="float:right;margin-right:1%;margin-top:0px; margin-bottom: 5px;" alt="Add New" title="Add New">
                                        <button type="button" class="btn btn-default btn-sm"><i class="icon-plus icon-2x"></i></button>
                                    </div>
                                </a>
                            </div>

                            <div class="box-body">
                                <div hidden class="row text-right" style="margin-right: 3px;">
                                    <a hidden class="btn btn-primary" id="bt_export" href="<?php echo site_url('P2K3/Order/export')?>">Export &nbsp<span class="glyphicon glyphicon-arrow-up"></a>
                                </div>
                                <br>
                                    <div class="table-responsive">
                                        <table id="tb_p2k3" class="datatable table table-striped table-bordered table-hover text-left" style="font-size:12px;">
                                            <thead class="bg-primary">
                                                <tr>
                                                    <th width="5%" style="text-align: center; vertical-align: middle;">NO</th>
                                                    <th width="10%" style="text-align: center; vertical-align: middle;">APD</th>
                                                    <th style="text-align: center; width: 105px; vertical-align: middle;">KODE ITEM</th>
                                                    <th style="text-align: center; vertical-align: middle;">TOTAL ORDER</th>
                                                    <th style="text-align: center; vertical-align: middle;">STATUS</th>
                                                    <th style="text-align: center; vertical-align: middle; width: 7%">ACTION</th>
                                                    <?php
                                                          foreach ($daftar_pekerjaan as $pekerjaan)
                                                         {
                                                    ?>
                                                        <th style="text-align:center; width: 80px; vertical-align: middle;"><?php echo $pekerjaan['pekerjaan'];?><p><small>(Kebutuhan per pekerja)</small></p></th>
                                                        <th style="text-align:center; width: 80px; vertical-align: middle;">Jumlah Pekerja (<?php echo $pekerjaan['pekerjaan'];?>)</th>
                                                     <?php
                                                         }
                                                    ?>
                                                    <th style="text-align: center; vertical-align: middle; width: 75px;">KEBUTUHAN UMUM</th>
                                                    <th style="text-align: center; vertical-align: middle; width: 80px;">TOTAL PEMAKAIAN</th>
                                                    <th style="text-align: center; vertical-align: middle;" hidden>SISA</th>
                                                    <th style="text-align: center; vertical-align: middle;">KETERANGAN</th>
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
                                                <td style="text-align: center;"><?php echo $row['ttl_order']; ?></td>
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
                                                        <a hidden data-toggle="tooltip" data-placement="left" title="Edit" href="<?php echo site_url('P2K3/Order/edit'.'/'.$id_kebutuhan_detail) ?>">
                                                            <button type="button" class="btn btn-info btn-xs">
                                                                <span class="glyphicon glyphicon-edit"></span>
                                                            </button>
                                                        </a>
                                                        <a hidden data-toggle="tooltip" data-placement="left" title="Delete" href="<?php echo site_url('P2K3/Order/delete_apd'.'/'.$id_kebutuhan_detail) ?>">
                                                            <button style="margin-left: 3px" type="button" class="btn btn-danger btn-xs">
                                                                <span class="glyphicon glyphicon-trash"></span>
                                                            </button>
                                                        </a>
                                                        <br>
                                                        <?php 
                                                            if ($approve[0]['p2k3_approver'] == 't') {
                                                                if ($row['status'] == '0') {
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
                                                            }
                                                        } ?>
                                                </td>
                                                <?php 
                                                    $jmlh=0;
                                                    foreach ($daftar_pekerjaan as $pekerjaan) 
                                                    {
                                                ?>
                                                    <td style="text-align: center;">
                                                    <?php 
                                                        $jumlah = explode(',',$row['jml']); print_r($jumlah[$jmlh]); 
                                                    ?>
                                                    </td>
                                                    <td style="text-align: center;">
                                                    <?php 
                                                        $jumlah = explode(',',$row['jml_pkj']); print_r($jumlah[$jmlh]); 
                                                    ?>
                                                    </td>
                                                <?php 
                                                    $jmlh++;
                                                    }
                                                ?>
                                                <td style="text-align: center;"><?php echo $row['jml_umum']; ?></td>
                                                <td style="text-align: center;"></td>
                                                <td style="text-align: center;" hidden></td>
                                                <td style="text-align: center;"><?php echo $row['desc'];?></td>
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
<script>
// function myfunc() {
//     var approve = document.getElementById("aprove").value;
//     if (confirm("Anda yakin ingin melakukan Approve pada order ini?")) {
//        window.location.replace("<?php echo site_url('P2K3/Order/approve');?>"+approve);
//     } else {
//       return false;
//     }
//     return false;
// }
// function myfunc2() {
//     confirm("Anda yakin ingin melakukan Reject pada order ini?");
// }
</script>