<section class="content">
    <div class="inner" >
        <div class="row">
            <div class="col-lg-12">
                <div class="col-lg-11">
                    <div class="text-right">
                        <h1><b>Riwayat Kebutuhan Standar</b></h1>
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
                            <div class="box-header with-border"></div>
                            <div class="box-body">
                                <div class="panel-body" style="overflow-x: scroll;">
                                    <div class="col-md-1 text-left" align="right">
                                        <label for="lb_periode" class="control-label">Seksi : </label>
                                    </div>
                                    <form method="post" action="<?php echo site_url('p2k3adm_V2/Admin/RiwayatKebutuhan');?>" enctype="multipart/form-data">
                                        <div class="col-md-5">
                                            <div class="input-group col-md-12">
                                                <select required class="form-control k3_admin_standar" name="k3_adm_ks" placeholder="Masukkan Periode">
                                                    <option></option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <button type="submit" class="btn btn-primary btn-md">Tampilkan</button>
                                        </div>
                                    </form>
                                    <div style="margin-top: 20px;" class="col-md-12 text-center">
                                        <h4 style="color: #000; font-weight: bold;">
                                            <?php  if (!empty($seksi) || !isset($seksi)) {
                                               echo $seksi[0]['section_name'];
                                           } ?>
                                       </h4>
                                   </div>
                                  <table class="table table-striped table-bordered table-hover dataTable-p2k3 text-center" style="font-size:12px; overflow-x: scroll;">
                                        <thead class="bg-primary">
                                            <tr>
                                                <th>NO</th>
                                                <th>Nama APD</th>
                                                <th>Kode Barang</th>
                                                <th>Kebutuhan Umum</th>
                                                <th>STAFF</th>
                                                <?php foreach ($daftar_pekerjaan as $key) { ?>
                                                <th><?php echo $key['pekerjaan'];?></th>
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