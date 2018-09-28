<section class="content">
    <div class="inner" >
        <div class="row">
            <form method="post" action="<?php echo site_url('P2K3/Order/update_data/'.$edit[0]['id_kebutuhan_detail'].'/'.$edit[0]['kodesie']);?>" class="form-horizontal">
                <div class="col-lg-12">
                    <div class="col-lg-11">
                        <div class="text-right">
                            <h1><b>Edit Kebutuhan APD</b></h1>
                        </div>
                    </div>
                    <div class="col-lg-1">
                        <div class="text-right hidden-md hidden-sm hidden-xs">
                            <a class="btn btn-default btn-lg" href="<?php echo site_url('P2K3/Order/edit');?>">
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
                                <div class="box-header with-border">Edit Order</div>
                                
                                        <div class="col-lg-12">
                                            <div class="row">
                                                <div class="nav-tabs-custom">
                                                    <div class="tab-content">
                                                        <div class="tab-pane active">
                                                            <div class="panel panel-default">
                                                                <div class="panel-heading" style="height: 50px;">Lines of Edit Order</div>
                                                                <div class="panel-body" style="overflow-x: auto">
                                                                    <table id="tb_InputKebutuhanAPD" class="table table-striped table-bordered table-hover" style="font-size:12px; position: center; overflow-x: auto; table-layout: auto; width: 2000px; max-width: 3000px">
                                                                            <thead>
                                                                                <tr class="bg-primary">
                                                                                    <th style="text-align:center; width:30px; vertical-align: middle;">No</th>
                                                                                    <th style="text-align:center; width: 150px; vertical-align: middle;">APD</th>
                                                                                    <th style="text-align:center; width: 105px; vertical-align: middle;">KODE ITEM</th>
                                                                                    <?php
                                                                                        foreach ($daftar_pekerjaan as $pekerjaan)
                                                                                        {
                                                                                    ?>
                                                                                    <th style="text-align:center; width: 80px; vertical-align: middle;"><?php echo $pekerjaan['pekerjaan'];?></th>
                                                                                    <th style="text-align:center; vertical-align: middle; width: 80px">Jumlah Pekerja (<?php echo $pekerjaan['pekerjaan'];?>)</th>
                                                                                    <?php
                                                                                        }
                                                                                    ?>
                                                                                    <th style="text-align:center; width: 80px; vertical-align: middle;">KEBUTUHAN UMUM</th>
                                                                                    <th style="text-align:center; width: 150px; vertical-align: middle;">KETERANGAN</th> 
                                                                                    <th style="text-align:center; width: 100px; vertical-align: middle;">ACTION</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody id="DetailInputKebutuhanAPD">
                                                                                    <?php
                                                                                        $x = 1;
                                                                                       foreach ($edit as $key) {
                                                                                    ?>
                                                                                    <tr row-id="1" class="multiinput">
                                                                                    <td style="text-align:center; width:30px" id="nomor" ><?php echo $x?></td>
                                                                                    <td>
                                                                                        <div class="form-group" style="width: 155px;">
                                                                                            <div class="col-lg-12">
                                                                                                <select class="form-control apd-select2" name="txtJenisAPD[]" id="txtJenisAPD" data-id="1" onchange="JenisAPD(this)">
                                                                                                    <option><?php echo $key['item']?></option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="form-group" >
                                                                                            <div class="col-lg-12">
                                                                                            <input type="text" name="txtKodeItem[]" id="txtKodeItem" class="form-control" value="<?php echo $key['kode_item'];?>" data-id="<?php echo $x;?>" readonly/>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <?php
                                                                                        $i = 0;
                                                                                        foreach ($daftar_pekerjaan as $pekerjaan)
                                                                                        { 
                                                                                    ?>
                                                                                    <td>
                                                                                        <div class="form-group">
                                                                                            <div class="col-lg-12">
                                                                                            <input type="number" name="numJumlah[<?php echo $i;?>][]" id="numJumlah<?php echo $i;?>[]" class="form-control" min="1" step="1" value="<?php $jumlah = explode(',',$key['jml']); print_r($jumlah[$i]);?>" />
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="form-group">
                                                                                            <div class="col-xs-12">
                                                                                            <input type="number" name="pkjJumlah[<?php echo $i;?>][]" id="pkjJumlah<?php echo $i;?>[]" class="form-control" min="1" step="1" value="<?php $jumlah = explode(',',$key['jml_pkj']); print_r($jumlah[$i]);?>" />
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <?php

                                                                                        $i++;}
                                                                                    ?>
                                                                                    <td>
                                                                                        <div class="form-group">
                                                                                            <div class="col-lg-12">
                                                                                            <input type="hidden" name="jmlpekerjaan[]" value="<?php echo $i;?>">
                                                                                            <input type="number" name="txtKebutuhanUmum[]" id="txtKebutuhanUmum" class="form-control" min="1" step="1" value="<?php echo $key['jml_umum'];?>" />
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="form-group">
                                                                                            <div class="col-lg-12">
                                                                                            <input type="text" name="txtKeterangan[]" id="txtKeterangan" class="form-control" value="<?php echo $key['desc'];?>" />
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td align="center">
                                                                                        <button disabled class="btn btn-default group_rem">
                                                                                            <a disabled href="javascript:void(0);"  title="Hapus Baris">
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
                                        <div class="row text-right">
                                           <button type="submit" class="btn btn-success btn-lg btn-rect" id="p2k3-saveorder" style="margin-right: 20px">Save Data</button>
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