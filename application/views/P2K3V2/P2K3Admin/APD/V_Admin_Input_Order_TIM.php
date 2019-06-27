<style type="text/css">
    td{
        min-width:130px; /* force table to be oversize */
        }
</style>
<section class="content">
    <div class="inner" >
        <div class="row">
            <div class="col-lg-12">
                <div class="col-lg-11">
                    <div class="text-right">
                        <h1><b>Input Order Seksi</b></h1>
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
                                    <div class="col-md-1 text-left" align="right">
                                        <label for="lb_periode" class="control-label">Seksi : </label>
                                    </div>
                                    <form method="post" action="<?php echo site_url('p2k3adm_V2/Admin/inputOrderTIM');?>" enctype="multipart/form-data">
                                        <div class="col-md-5">
                                            <div class="input-group col-md-12">
                                                <select required class="form-control k3_admin_standar" name="k3_adm_ks" placeholder="Masukkan Periode">
                                                    <option></option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <button type="submit" class="btn btn-primary btn-md">Tampilkan</button>
                                        </div>
                                        <div class="col-md-12" style="margin-top: 5px;">
                                            <div style="padding-left: 0px; margin-top: 5px;" class="col-md-1" align="left">
                                                <label for="lb_periode" class="control-label">Periode : </label>
                                            </div>

                                            <div class="col-md-3" style="padding-left: 0px; margin-left: 3px">
                                                <div class="input-group">
                                                    <input readonly class="form-control"  autocomplete="off" type="text" name="k3_periode" id="" style="width: 200px" placeholder="Masukkan Periode" value="<?php echo date('Y-m', strtotime('+1 months')); ?>"/>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="row">
                                                <?php if ($act == '1' or $act =='2'): ?>
                                                    <form onsubmit="return p2k3_val()" method="post" class="form-horizontal" action="<?php echo site_url('p2k3adm_V2/Admin/saveInputOrder');?>" enctype="multipart/form-data">
                                                        <div class="nav-tabs-custom">
                                                            <div class="tab-content">
                                                                <div class="tab-pane active">
                                                                    <div class="panel panel-default">
                                                                        <div class="panel-heading" style="height: 55px;">Lines of Input Order
                                                                        </div>
                                                                        <div class="panel-body table-responsive" style="overflow-x: auto;">
                                                                         <table id="tb_InputKebutuhanAPD" class="table table-striped table-bordered table-hover">
                                                                             <caption style="color: #000;font-weight: bold;font-size: 18px; padding-left: 0px;"><?php echo $seksi[0]['section_name']; ?>
                                                                                </caption>
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
                                                                                    <td style="min-width: 10px;" id="nomor">1</td>
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
                                                                        <input name="p2k3_adm_kodesie" hidden="" type="text" value="<?php echo $kodesie; ?>">
                                                                         <input name="k3_periode" hidden="" value="<?php echo date('Y-m', strtotime('+1 months')); ?>"/>
                                                                        <div class="row text-right" style="margin-right: 12px; margin-top: 20px;">
                                                                            <?php if ($act == '1'): ?>
                                                                                <a href="<?php echo site_url('P2K3_V2/Order/inputStandarKebutuhan');?>" class="btn btn-primary btn-lg btn-rect">Back</a>
                                                                                &nbsp;&nbsp;
                                                                                <button onclick="return confirm('Apa anda yakin ingin Menginput Data Ini?')" type="submit" class="btn btn-primary btn-lg btn-rect bt_p2k3_save_order">Tambah Data</button>
                                                                            <?php endif ?>
                                                                            <?php if ($act == '2'): ?>
                                                                                <h4><b style="color: red;">Seksi Ini Telah Order</b></h4>
                                                                            <?php endif ?>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <i style="color: red;">*) Cek Data Kembali Sebelum Disimpan</i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            <?php endif ?>
                                        </div>
                                    </div>
                                </div>
                                <input hidden="" value="<?php echo $max_pekerja; ?>" id="pw2k3_maxpkj">
                                <div class="panel-footer" style="margin-top: 20px;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</section>