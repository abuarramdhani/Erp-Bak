<section class="content">
    <div class="inner" >
        <div class="row">
            <div class="col-lg-12">
                <div class="col-lg-11">
                    <div class="text-right">
                        <h1><b>Monitoring APD Seksi</b></h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-primary" style="">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-lg-1">
                                            <div class="form-group">
                                                <label class="control-label">Departement</label> <br>
                                                <label class="control-label">Bidang</label> <br>
                                                <label class="control-label">Unit</label> <br>
                                                <label class="control-label">Seksi</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-5">
                                            <div class="form-group">
                                                <label class="control-label">: <?php echo $seksi[0]["dept"] ?></label> <br>
                                                <label class="control-label">: <?php echo $seksi[0]["bidang"] ?></label> <br>
                                                <label class="control-label">: <?php echo $seksi[0]["unit"] ?></label> <br>
                                                <label class="control-label">: <?php echo $seksi[0]["section"] ?></label> <button type="button" class="btn btn-xs p2k3_detail_seksi" value="<?php echo $seksi[0]['section_code'] ?>">Details</button>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
                <br />
                <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border"></div>
                            <div class="box-body">
                                <div class="panel-body" style="overflow-x: scroll;">
                                    <form method="post" class="form-horizontal" action="<?php echo site_url('P2K3_V2/Order/MonitoringApd');?>" enctype="multipart/form-data">
                                        <div class="col-md-1 text-left" align="right">
                                            <label for="lb_periode" class="control-label">Periode : </label>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="input-group col-md-12">
                                                <input required="" class="form-control p2k3_tanggal_periode"  autocomplete="off" type="text" name="k3_periode" id="yangPentingtdkKosong" value="<?php echo $pr; ?>"/>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <button type="submit" class="btn btn-primary">Lihat</button>
                                        </div>
                                    </form>
                                    <table style="margin-top: 50px;" id="tb_InputKebutuhanAPD" class="table table-striped table-bordered table-hover text-center">
                                        <thead>
                                            <tr class="bg-info">
                                                <th>No</th>
                                                <th>APD</th>
                                                <th>Kode Barang</th>
                                                <th>Jumlah Kebutuhan</th>
                                                <th>Jumlah Bon</th>
                                                <th>Sisa Saldo</th>
                                            </tr>
                                        </thead>
                                        <tbody id="DetailInputKebutuhanAPD">
                                            <?php $a=1; foreach ($listmonitor as $key): ?>
                                            <tr style="color: #000;" class="multiinput">
                                                <td id="nomor"><?php echo $a; ?></td>
                                                <td>
                                                    <?php echo $key['item']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $key['kode_item']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $key['0']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $key['jml_bon']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $key['1']; ?>
                                                </td>
                                            </tr>
                                            <?php $a++; endforeach ?>
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
<div class="modal fade" id="p2k3_detail_pekerja" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true" style="margin-top: -20px;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Detail Pekerja</h4>
            </div>
            <div class="modal-body">
                <!-- Place to print the fetched phone -->
                <div id="phone_result"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>