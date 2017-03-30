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
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('PayrollManagementNonStaff/ProsesGaji/DataLKHSeksi');?>">
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
                                <a href="<?php echo site_url('PayrollManagementNonStaff/ProsesGaji/DataLKHSeksi/clear_data/') ?>" data-toggle="tooltip" data-placement="left" style="float:right;margin-right:1%;margin-top:-0.5%;" alt="Kosongkan Data" title="Kosongkan Data" >
                                    <button type="button" class="btn btn-default btn-sm"><i class="fa fa-trash fa-2x"></i></button>
                                </a>
                                <a href="<?php echo site_url('PayrollManagementNonStaff/ProsesGaji/DataLKHSeksi/import_data/') ?>" data-toggle="tooltip" data-placement="left" style="float:right;margin-right:1%;margin-top:-0.5%;" alt="Import Data" title="Import Data" >
                                    <button type="button" class="btn btn-default btn-sm"><i class="fa fa-upload fa-2x"></i></button>
                                </a>
                                <a href="<?php echo site_url('PayrollManagementNonStaff/ProsesGaji/DataLKHSeksi/import_data/') ?>" data-toggle="tooltip" data-placement="left" style="float:right;margin-right:1%;margin-top:-0.5%;" alt="Tambah Data" title="Tambah Data" >
                                    <button type="button" class="btn btn-default btn-sm"><i class="icon-plus icon-2x"></i></button>
                                </a>
                                <a href="<?php echo site_url('PayrollManagementNonStaff/ProsesGaji/DataLKHSeksi/download_data/') ?>" data-toggle="tooltip" data-placement="left" style="float:right;margin-right:1%;margin-top:-0.5%;" alt="Download Data From Database" title="Download Data From Database" >
                                    <button type="button" class="btn btn-default btn-sm"><i class="fa fa-database fa-2x"></i></button>
                                </a>
                            </div>
                            <div class="box-body">
                                <div class="table-responsive">
                                    <table class="datatable table table-striped table-bordered table-hover text-left" id="tblDataLKHSeksi" style="font-size:12px;">
                                        <thead class="bg-primary">
                                            <tr>
                                                <th style="text-align:center; width:30px">No</th>
                                                <th>Tanggal</th>
                                                <th>No Induk</th>
                                                <th>Kode Barang</th>
                                                <th>Kode Proses</th>
                                                <th>Jml Barang</th>
                                                <th>Afmat</th>
                                                <th>Afmch</th>
                                                <th>Repair</th>
                                                <th>Reject</th>
                                                <th>Setting Time</th>
                                                <th>Shift</th>
                                                <th>Status</th>
                                                <th>Kode Barang Target Sementara</th>
                                                <th>Kode Proses Target Sementara</th>
											</tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                $no = 1; 
                                                foreach($LKHSeksi as $row):
                                                $encrypted_string = $this->encrypt->encode($row['lkh_seksi_id']);
                                                $encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
                                            ?>
                                            <tr>
                                                <td align='center'><?php echo $no++;?></td>
                                                <td><?php echo $row['tgl'] ?></td>
                                                <td><?php echo $row['noind'] ?></td>
                                                <td><?php echo $row['kode_barang'] ?></td>
                                                <td><?php echo $row['kode_proses'] ?></td>
                                                <td><?php echo $row['jml_barang'] ?></td>
                                                <td><?php echo $row['afmat'] ?></td>
                                                <td><?php echo $row['afmch'] ?></td>
                                                <td><?php echo $row['repair'] ?></td>
                                                <td><?php echo $row['reject'] ?></td>
                                                <td><?php echo $row['setting_time'] ?></td>
                                                <td><?php echo $row['shift'] ?></td>
                                                <td><?php echo $row['status'] ?></td>
                                                <td><?php echo $row['kode_barang_target_sementara'] ?></td>
                                                <td><?php echo $row['kode_proses_target_sementara'] ?></td>
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