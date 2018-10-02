<section class="content">
    <div class="inner" >
        <div class="row">

            <form method="post" action="<?php echo site_url('P2K3/Order/save_data');?>" class="form-horizontal">
                <div class="col-lg-12">
                    <div class="col-lg-11">
                        <div class="text-right">
                            <h1><b>Input Kebutuhan APD</b></h1>
                        </div>
                    </div>
                    <div class="col-lg-1">
                        <div class="text-right hidden-md hidden-sm hidden-xs">
                            <a class="btn btn-default btn-lg" href="<?php echo site_url('P2K3/Order/reset');?>">
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
                                                <label for="lb_periode" class="control-label">Peroide : </label>
                                            </div>
                                        
                                            <div class="col-md-3">
                                                <div class="input-group">
                                                    <input class="form-control p2k3-daterangepickersingledate"  autocomplete="off" type="text" name="k3_periode" id="k3_periode" style="width: 200px" placeholder="Masukkan Periode" value=""/>
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
                                                                    <a href="javascript:void(0);" id="group_add" title="Tambah Baris">
                                                                        <button type="button" class="btn btn-success pull-right" style="margin-bottom:10px; margin-right: 10px;"><i class="fa fa-fw fa-plus"></i>Add New</button>
                                                                    </a>
                                                                </div>
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
                                                                                    <th style="text-align:center; width: 80px; vertical-align: middle;"><?php echo $pekerjaan['pekerjaan'];?> <p><small>(Kebutuhan per pekerja)</small></p></th><th style="text-align:center; width: 80px; vertical-align: middle;">Jumlah Pekerja (<?php echo $pekerjaan['pekerjaan'];?>)</th>
                                                                                    <?php
                                                                                        }
                                                                                    ?>
                                                                                    <th style="text-align:center; width: 80px; vertical-align: middle;">KEBUTUHAN UMUM</th>
                                                                                    <th style="text-align:center; width: 150px; vertical-align: middle;">KETERANGAN</th> 
                                                                                    <th style="text-align:center; width: 100px; vertical-align: middle;">ACTION</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody id="DetailInputKebutuhanAPD">
                                                                                    <tr row-id="1" class="multiinput">
                                                                                    <td style="text-align:center; width:30px" id="nomor">1</td>
                                                                                    <td>
                                                                                        <div class="form-group" style="width: 155px;">
                                                                                            <div class="col-lg-12">
                                                                                                <select required class="form-control apd-select2" name="txtJenisAPD[]" id="txtJenisAPD" data-id="1" onchange="JenisAPD(this)">
                                                                                                    <option></option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="form-group" >
                                                                                            <div class="col-lg-12">
                                                                                            <input type="text" name="txtKodeItem[]" id="txtKodeItem" class="form-control" data-id="1" readonly/>
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
                                                                                            <input required type="number" name="numJumlah[<?php echo $i;?>][]" id="numJumlah<?php echo $i;?>[]" class="form-control" min="0" step="0" value="0"/>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="form-group">
                                                                                            <div class="col-lg-12">
                                                                                            <input required type="number" name="pkjJumlah[<?php echo $i;?>][]" id="pkjJumlah<?php echo $i;?>[]" class="form-control" min="0" step="0" value="0"/>
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
                                                                                            <input required type="number" name="txtKebutuhanUmum[]" id="txtKebutuhanUmum" class="form-control" min="0" step="0" value="0"/>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="form-group">
                                                                                            <div class="col-lg-12">
                                                                                            <input type="text" name="txtKeterangan[]" id="txtKeterangan" class="form-control" />
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
                                            <a href="<?php echo base_url('P2K3/Order/list_order'); ?>" class="btn btn-primary btn-lg btn-rect">Back</a>
                                            &nbsp;&nbsp;
                                            <button type="submit" class="btn btn-primary btn-lg btn-rect" onclick="test()">Tambah Data</button>
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