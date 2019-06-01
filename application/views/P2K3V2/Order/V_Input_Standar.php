<style type="text/css">
    td{
        min-width:155px; /* force table to be oversize */
    }
</style>
<section class="content">
    <div class="inner" >
        <div class="row">
            <div class="col-lg-12">
                <div class="col-lg-11">
                    <div class="text-right">
                        <h1><b>Standar Kebutuhan APD</b></h1>
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
                                <a href="<?php echo site_url('P2K3_V2/Order/inputStandarAPD')?>">
                                    <div style="float:right;margin-right:1%;margin-top:0px; margin-bottom: 5px;" alt="Add New" title="Add New">
                                        <button type="button" class="btn btn-default btn-sm"><i class="icon-plus icon-2x"></i></button>
                                    </div>
                                </a>
                            </div>

                            <div class="box-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover dataTable-p2k3 text-center" style="font-size:12px; overflow-x: scroll;">
                                        <thead class="bg-primary">
                                            <tr>
                                                <th>NO</th>
                                                <th>Nama APD</th>
                                                <th>Kode Barang</th>
                                                <th>Kebutuhan Umum</th>
                                                <th>Kebutuhan per Pekerja (STAFF)</th>
                                                <?php foreach ($daftar_pekerjaan as $key) { ?>
                                                <th>Kebutuhan per Pekerja (<?php echo $key['pekerjaan'];?>)</th>
                                                <?php } ?>
                                                <th width="15%">Tanggal Input</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $a=1; foreach ($inputStandar as $key) { 
                                                    $status = $key['status'];
                                                    if ($status == '0') {
                                                        $status = 'Pending';
                                                    }else if ($status == '1') {
                                                        $status = 'Approved Atasan';
                                                    }else if ($status == '2'){
                                                        $status = 'Reject Atasan';
                                                    }else if ($status == '3'){
                                                        $status = 'Approved TIM';
                                                    }else{
                                                        $status = 'Reject TIM';
                                                    }
                                                ?>
                                            <tr style="color: #000;">
                                                <td style="min-width: 10px;"><?php echo $a; ?></td>
                                                <td><?php echo $key['item']; ?></td>
                                                <td><?php echo $key['kode_item']; ?></td>
                                                <td><?php echo $key['jml_kebutuhan_umum']; ?></td>
                                                <td><?php echo $key['jml_kebutuhan_staff']; ?></td>
                                                <?php $jml = explode(',', $key['jml_item']);
                                                foreach ($jml as $row) { ?>
                                                <td><?php echo $row; ?></td>
                                                <?php  } ?>
                                                <td><?php echo $key['tgl_input']; ?></td>
                                                <td><?php echo $status; ?></td>
                                            </tr>
                                            <?php $a++; } ?>
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
