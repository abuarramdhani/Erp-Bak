<section class="content">
    <div class="inner" >
        <div class="row">
            <form onsubmit="return p2k3_val()" method="post" action="<?php echo site_url('P2K3_V2/Order/save_pekerja');?>" class="form-horizontal" enctype="multipart/form-data">
                <div class="col-lg-12">
                    <div class="col-lg-11">
                        <div class="text-right">
                            <h1><b>Input Kebutuhan APD</b></h1>
                        </div>
                    </div>
                    <div class="col-lg-1">
                        <div class="text-right hidden-md hidden-sm hidden-xs">
                            <a class="btn btn-default btn-lg" href="<?php echo site_url('P2K3_V2/Order/reset');?>">
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
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="row">
                                                <div class="nav-tabs-custom">
                                                    <div class="tab-content">
                                                        <div class="tab-pane active">
                                                            <div class="panel panel-default">
                                                                <div class="panel-heading">Lines of Input Order
                                                                    <a href="javascript:void(0);" id="group_add" title="Tambah Baris">
                                                                        <!-- <button type="button" class="btn btn-success pull-right" style="margin-bottom:10px; margin-right: 10px;"><i class="fa fa-fw fa-plus"></i>Add New</button> -->
                                                                    </a>
                                                                </div>
                                                                <div class="panel-body" style="overflow-x: scroll">
                                                                    <table id="tb_InputKebutuhanAPD" class="table table-striped table-bordered table-hover">
                                                                        <thead>
                                                                            <tr class="bg-primary">
                                                                                <th>No</th>
                                                                                <th>Jumlah Pekerja (STAFF)</th>
                                                                                <?php
                                                                                foreach ($daftar_pekerjaan as $pekerjaan)
                                                                                    { ?>
                                                                                <th>Jumlah Pekerja (<?php echo $pekerjaan['pekerjaan'];?>)
                                                                                </th>
                                                                                <?php } ?>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody id="DetailInputKebutuhanAPD">
                                                                            <tr row-id="1" class="multiinput">
                                                                                <td id="nomor">1</td>
                                                                                <td><input required type="number" name="staffJumlah" class="form-control" min="0" /></td>
                                                                                <?php
                                                                                $i = 0;
                                                                                foreach ($daftar_pekerjaan as $pekerjaan)
                                                                                    { ?>
                                                                                <td>
                                                                                    <div class="form-group">
                                                                                        <div class="col-lg-12">
                                                                                            <input required type="number" name="pkjJumlah[]" class="form-control" min="0"  />
                                                                                        </div>
                                                                                    </div>
                                                                                </td>
                                                                                <?php
                                                                                $i++;}
                                                                                ?>
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
                                    <input hidden="" value="<?php echo $max_pekerja; ?>" id="pw2k3_maxpkj">
                                    <div class="panel-footer">
                                        <div class="row text-right" style="margin-right: 12px">
                                            <?php 
                                            $h = date('d');
                                            $d = '';
                                            if ($h > '10') {
                                                $d = 'disabled';
                                            }
                                            ?>
                                            <a href="<?php echo base_url('P2K3_V2/Order/list_order'); ?>" class="btn btn-primary btn-lg btn-rect">Back</a>
                                            &nbsp;&nbsp;
                                            <button <?php echo $d; ?> type="submit" class="btn btn-primary btn-lg btn-rect">Tambah Data</button>
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