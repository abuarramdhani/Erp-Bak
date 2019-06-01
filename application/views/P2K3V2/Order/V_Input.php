<section class="content">
    <div class="inner" >
        <div class="row">

            <form method="post" class="form-horizontal" action="<?php echo site_url('P2K3_V2/Order/save_data');?>" enctype="multipart/form-data">
                <div class="col-lg-12">
                    <div class="col-lg-11">
                        <div class="text-right">
                            <h1><b>Input Kebutuhan APD</b></h1>
                        </div>
                    </div>
                    <div class="col-lg-1">
                        <div class="text-right hidden-md hidden-sm hidden-xs">
                            <a class="btn btn-default btn-lg" href="<?php echo site_url('P2K3_V2/Order/input');?>">
                                <i class="icon-wrench icon-2x"></i>
                                <span><br/></span>  
                            </a>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-11"></div>
                            <div class="col-lg-1 "></div>
                        </div>
                    </div>
                    <br />
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="box box-primary box-solid">
                                <div class="box-header with-border">Create Order</div>
                                <div class="box-body">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-md-2" align="right">
                                                <label for="lb_periode" class="control-label">Periode : </label>
                                            </div>
                                        
                                            <div class="col-md-3">
                                                <div class="input-group">
                                                    <input readonly class="form-control"  autocomplete="off" type="text" name="k3_periode" id="" style="width: 200px" placeholder="Masukkan Periode" value="<?php echo date('Y-m', strtotime('+1 months')); ?>"/>
                                                </div>
                                            </div>

                                            <div class="col-md-2" align="right">
                                                <label for="lb_approval" class="control-label">Document Approval : </label>
                                            </div>
                                        
                                            <div class="col-md-3">
                                                <div class="input-group">
                                                    <input type="file" name="k3_approval" class="form-control" required />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="row">
                                                <div class="nav-tabs-custom">
                                                    <div class="tab-content">
                                                        <div class="tab-pane active">
                                                            <div class="panel panel-default">
                                                                <div class="panel-heading" style="height: 55px;">Lines of Input Order
                                                                        <button type="button" class="btn btn-warning pull-right" id="btn-smfilter" data-toggle="modal" data-target="#exampleModalapd">Reset</button>
                                                                         <!-- Modal -->
                                                                            <div class="modal fade" id="exampleModalapd" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                              <div class="modal-dialog" role="document">
                                                                                <div class="modal-content">
                                                                                  <div class="modal-header">
                                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                      <span aria-hidden="true">&times;</span>
                                                                                    </button>
                                                                                  </div>
                                                                                  <div class="modal-body">
                                                                                    <h4 style="vertical-align: middle;">Are You Sure to Reset This Data???</h4>
                                                                                  </div>
                                                                                  <div class="modal-footer">
                                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">NO</button>
                                                                                    <a class="btn btn-primary" href="<?php echo base_url('P2K3_V2/Order/reset')?>">YES</a>
                                                                                  </div>
                                                                                </div>
                                                                              </div>
                                                                            </div>
                                                                            <!-- Modal-End-->
                                                                    
                                                                    <a href="javascript:void(0);" id="group_add" title="Tambah Baris">
                                                                        <button type="button" class="btn btn-success pull-right" style="margin-bottom:10px; margin-right: 10px;"><i class="fa fa-fw fa-plus"></i>Add New</button>
                                                                    </a>
                                                                </div>
                                                                <div class="panel-body" style="overflow-x: scroll;">
                                                                    <table id="tb_InputKebutuhanAPD" class="table table-striped table-bordered table-hover" style="font-size:12px; position: center; overflow-x: auto; table-layout: fixed;">
                                                                            <thead>
                                                                                <tr class="bg-primary">
                                                                                    <th style="text-align:center; width:30px; vertical-align: middle;">No</th>
                                                                                    <th style="text-align:center; vertical-align: middle; width: 250px">APD</th>
                                                                                    <th style="text-align:center; vertical-align: middle; width: 100px">KODE ITEM</th>
                                                                                    <?php
                                                                                        foreach ($daftar_pekerjaan as $pekerjaan)
                                                                                        {
                                                                                    ?>
                                                                                    <!-- <th style="text-align:center; vertical-align: middle; width: 80px"><?php echo $pekerjaan['pekerjaan'];?><p><small>(Kebutuhan per pekerja)</small></p></th> -->
                                                                                    <th style="text-align:center; vertical-align: middle; width: 80px">Jumlah Pekerja (<?php echo $pekerjaan['pekerjaan'];?>)</th>
                                                                                    <?php
                                                                                        }
                                                                                    ?>
                                                                                    <!-- <th style="text-align:center; vertical-align: middle; width: 80px;">KEBUTUHAN UMUM</th> -->
                                                                                    <th style="text-align:center; vertical-align: middle; width: 200px">KETERANGAN</th> 
                                                                                    <th style="text-align:center; width:50px; vertical-align: middle;">ACTION</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody id="DetailInputKebutuhanAPD">
                                                                                    <?php
                                                                                        $x = 1;
                                                                                       foreach ($input as $key) {
                                                                                    ?>
                                                                                    <tr row-id="1" class="multiinput">
                                                                                    <td style="text-align:center;" id="nomor" ><?php echo $x?></td>
                                                                                    <td>
                                                                                        <div class="form-group">
                                                                                            <div class="col-xs-12">
                                                                                                <select required class="form-control apd-select2" name="txtJenisAPD[]" id="txtJenisAPD" data-id="1" onchange="JenisAPD(this)">
                                                                                                    <option><?php echo $key['item']?></option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="form-group" >
                                                                                            <div class="col-xs-12">
                                                                                            <input type="text" name="txtKodeItem[]" id="txtKodeItem" class="form-control" value="<?php echo $key['kode_item'];?>" data-id="<?php echo $x;?>" readonly/>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <?php
                                                                                        $i = 0;
                                                                                        foreach ($daftar_pekerjaan as $pekerjaan)
                                                                                        { 
                                                                                    ?>
                                                                                    <!-- <td>
                                                                                        <div class="form-group">
                                                                                            <div class="col-xs-12">
                                                                                            <input required type="number" name="numJumlah[<?php echo $i;?>][]" id="numJumlah<?php echo $i;?>[]" class="form-control" min="0" step="0" value="<?php $jumlah = explode(',',$key['jml']);
                                                                                            if(empty($jumlah[$i])){
                                                                                                echo '0'; }else{
                                                                                                    print_r($jumlah[$i]);
                                                                                                    } ?>" required/>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td> -->
                                                                                    <td>
                                                                                        <div class="form-group">
                                                                                            <div class="col-xs-12">
                                                                                            <input required type="number" name="pkjJumlah[<?php echo $i;?>][]" id="pkjJumlah<?php echo $i;?>[]" class="form-control" min="0" step="0" value="<?php $jumlah = explode(',',$key['jml_pkj']);  
                                                                                            if(empty($jumlah[$i])){
                                                                                                echo '0'; }else{
                                                                                                    print_r($jumlah[$i]);
                                                                                                    } ?>" required/>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <?php

                                                                                        $i++;}
                                                                                    ?>
                                                                                    <!-- <td>
                                                                                        <div class="form-group">
                                                                                            <div class="col-xs-12">
                                                                                            <input type="hidden" name="jmlpekerjaan[]" value="<?php echo $i;?>">
                                                                                            <input required type="number" name="txtKebutuhanUmum[]" id="txtKebutuhanUmum" class="form-control" min="0" step="0" value="<?php echo $key['jml_umum'];?>" />
                                                                                            </div>
                                                                                        </div>
                                                                                    </td> -->
                                                                                    <td>
                                                                                        <div class="form-group">
                                                                                            <div class="col-xs-12">
                                                                                            <input type="text" name="txtKeterangan[]" id="txtKeterangan" class="form-control" value="<?php echo $key['desc'];?>" />
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td align="center">
                                                                                        <button class="btn btn-default group_rem">
                                                                                            <a href="javascript:void(0);"  title="Hapus Baris">
                                                                                            <span class="glyphicon glyphicon-trash"></span> 
                                                                                            </a>
                                                                                        </button>
                                                                                    </td>
                                                                                </tr>
                                                                                    <?php
                                                                                        $x++;
                                                                                        }
                                                                                    ?>
                                                                            </tbody>
                                                                        </table>

                                                                </div>
                                                            </div>
                                                            <i style="color: red;">*) Cek Data Kembali Sebelum Disimpan</i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-footer">
                                        <div class="row text-right" style="margin-right: 12px">
                                        <?php 
                                            $h = date('d');
                                            $d = '';
                                            if ($h > '10') {
                                                $d = 'disabled';
                                            }
                                         ?>
                                            <!-- <a href="javascript:history.back(1)" class="btn btn-primary btn-lg btn-rect">Back</a> -->
                                            <a href="<?php echo site_url('P2K3_V2/Order/list_order');?>" class="btn btn-primary btn-lg btn-rect">Back</a>
                                            &nbsp;&nbsp;
                                            <button <?php echo $d; ?> type="submit" class="btn btn-primary btn-lg btn-rect" onclick="test()">Tambah Data</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
<script type="text/javascript">
    $(document).ready(function() {
    $('.example').DataTable( {
  "scrollX": true
    } );
} );
</script>