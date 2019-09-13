<section class="content">
    <div class="inner" >
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-11">
                            <div class="text-right"><h1><b>Perizinan Dinas Keluar</b></h1></div>
                        </div>
                        <div class="col-lg-1">
                            <div class="text-right hidden-md hidden-sm hidden-xs">
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('PerizinanDinas/AtasanApproval/V_Index');?>">
                                    <i class="icon-wrench icon-2x"></i>
                                    <br/>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <br/>

                 <div class="row" style="">
                    <div class="col-lg-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border">
                            </div>
                            <div class="box-body">
                            <div class="nav-tabs-custom">
                              <ul class="nav nav-tabs pull-right">
                                <li><a href="#izin-reject" data-toggle="tab">Rejected Izin</a></li>
                                <li><a href="#izin-ok" data-toggle="tab">Approved Izin</a></li>
                                <li><a href="#izin-check" data-toggle="tab">Uncheck izin</a></li>
                                <li class="active"><a href="#izin-all" data-toggle="tab">All Izin</a></li>
                                <li class="pull-left header"><i class="fa fa-tag"></i> Approval Izin Dinas</li>
                              </ul>
                              <div class="tab-content">

                              <div id="izin-all" class="tab-pane fade in active">
                              <form method="POST" class="form-horizontal" action="<?php echo base_url('PerizinanDinas/AtasanApproval/update') ?>">
                              <table class="datatable table table-striped table-bordered table-hover tabel_izin" style="width: 100%">
                                <thead>
                                  <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">Keputusan Anda</th>
                                    <th class="text-center">ID Izin</th>
                                    <th class="text-center">Tanggal Pengajuan</th>
                                    <th class="text-center">Nama Pekerja</th>
                                    <th class="text-center">Jenis Izin</th>
                                    <th class="text-center">Keterangan</th>
                                    <th class="text-center">Status</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php $no = 1;
                                  foreach ($izin as $row) {   
                                    ?>
                                    <tr>
                                      <td style="width: 1%; text-align: center;"><?php echo $no; ?></td>
                                      <td style="text-align: center; width: 5%"><?php  if ($row['status'] == 0) { ?>

                                           <button type="submit" name="submit" value="1|<?php echo $row['izin_id']; ?>" class="btn btn-success cm_btn_approve" onclick="return confirm('Anda Akan Memberikan Keputusan APPROVE, Klik OK untuk melanjutkan');" ><span style="color: white" class='fa fa-check'></span></button>

                                            <button type="submit" name="submit" value="2|<?php echo $row['izin_id']; ?>" class="btn btn-danger cm_btn_reject" onclick="return confirm('Anda Akan Memberikan Keputusan REJECT, Klik OK untuk melanjutkan');"><span style="color: white" class='fa fa-close'></span></button>

                                     <?php }elseif ($row['status'] == 1) { ?>
                                            <a><span style="color: green" class='fa fa-check fa-2x'></span></a>
                                     <?php }elseif ($row['status'] == 2) { ?>
                                            <a><span style="color: red" class='fa fa-close fa-2x'></span></a>
                                       <?php } ?>
                                           
                                            </td>
                                      <td style="width: 5%; text-align: center;"><?php echo $row['izin_id'] ?></td>
                                      <td style="width: 5%"><?= date("d - M - Y", strtotime($row['created_date'])); ?></td>
                                      <td style="width: 33%"><?php $daftarNamaAsli = $row['namapekerja'];
                                                $daftarNama = str_replace(',', '<br> ', $daftarNamaAsli);
                                           echo $daftarNama ?></td>
                                      <td style="width: 12%; text-align: center;"><?php if ( $row['jenis_izin'] == '1') {
                                                                                      echo "DINAS PUSAT";
                                                                                    }elseif ( $row['jenis_izin'] == '2') {
                                                                                      echo "DINAS TUKSONO";
                                                                                    }elseif ( $row['jenis_izin'] == '3') {
                                                                                      echo "DINAS MLATI";
                                                                                    } ?>
                                      </td>
                                      <td style="width: 40%"><?php echo $row['keterangan'] ?></td>
                                      <td style="text-align: center; width: 5%"><?php
                                                      if ($row['status'] == 0) { ?>
                                                          <span class="label" style="background-color: #E0E0E0; color: black">Unapproved</span>
                                                      <?php } elseif ($row['status'] == 1) { ?>
                                                           <span class="label label-success">Approved</span>
                                                      <?php } elseif ($row['status'] == 2) { ?>
                                                          <span class="label label-danger">Rejected</span>
                                                      <?php } ?>
                                                </td>
                                    </tr> 
                                    <?php
                                    $no++;
                                  }
                                  ?>
                                </tbody>
                              </table>
                            </form>
                              </div>

                              <div id="izin-ok" class="tab-pane fade in">
                              <table class="datatable table table-striped table-bordered table-hover tabel_izin" style="width: 100%">
                                <thead>
                                  <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">Keputusan Anda</th>
                                    <th class="text-center">ID Izin</th>
                                    <th class="text-center">Tanggal Pengajuan</th>
                                    <th class="text-center">Nama Pekerja</th>
                                    <th class="text-center">Jenis Izin</th>
                                    <th class="text-center">Keterangan</th>
                                    <th class="text-center">Status</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php $no = 1;
                                  foreach ($IzinApprove as $row) {   
                                    ?>
                                    <tr>
                                      <td style="width: 1%; text-align: center;"><?php echo $no; ?></td>
                                      <td style="text-align: center; width: 5%"><?php  if ($row['status'] == 0) { ?>
                                           <button type="button" value="1|<?php echo $row['izin_id']; ?>" class="btn btn-success cm_btn_approve"><span style="color: white" class='fa fa-check'></span></button>
                                            <button type="submit" value="1|<?php echo $row['izin_id']; ?>" name="submit" style="display: none" class="btn btn-success cm_btn_approve2" >Approve</button>
                                            <button type="button" value="2|<?php echo $row['izin_id']; ?>" class="btn btn-danger cm_btn_reject"><span style="color: white" class='fa fa-close'></span></button>
                                            <button type="submit" value="2|<?php echo $row['izin_id']; ?>" name="submit" style="display: none" class="btn btn-danger cm_btn_reject2" >Reject</button>
                                     <?php }elseif ($row['status'] == 1) { ?>
                                            <a><span style="color: green" class='fa fa-check fa-2x'></span></a>
                                     <?php }elseif ($row['status'] == 2) { ?>
                                            <a><span style="color: red" class='fa fa-close fa-2x'></span></a>
                                       <?php } ?>
                                           
                                            </td>
                                      <td style="width: 5%; text-align: center;"><?php echo $row['izin_id'] ?></td>
                                      <td style="width: 5%"><?= date("d - M - Y", strtotime($row['created_date'])); ?></td>
                                     <td style="width: 33%"><?php $daftarNamaAsli = $row['namapekerja'];
                                                $daftarNama = str_replace(',', '<br> ', $daftarNamaAsli);
                                           echo $daftarNama ?></td>
                                      <td style="width: 12%; text-align: center;"><?php if ( $row['jenis_izin'] == '1') {
                                                                                      echo "DINAS PUSAT";
                                                                                    }elseif ( $row['jenis_izin'] == '2') {
                                                                                      echo "DINAS TUKSONO";
                                                                                    }elseif ( $row['jenis_izin'] == '3') {
                                                                                      echo "DINAS MLATI";
                                                                                    } ?>
                                      </td>
                                      <td style="width: 40%"><?php echo $row['keterangan'] ?></td>
                                      <td style="text-align: center; width: 5%"><?php
                                                      if ($row['status'] == 0) { ?>
                                                          <span class="label" style="background-color: #E0E0E0; color: black">Unapproved</span>
                                                      <?php } elseif ($row['status'] == 1) { ?>
                                                           <span class="label label-success">Approved</span>
                                                      <?php } elseif ($row['status'] == 2) { ?>
                                                          <span class="label label-danger">Rejected</span>
                                                      <?php } ?>
                                                </td>
                                    </tr> 
                                    <?php
                                    $no++;
                                  }
                                  ?>
                                </tbody>
                              </table>
                              </div>

                              <div id="izin-check" class="tab-pane fade in">
                              <table class="datatable table table-striped table-bordered table-hover tabel_izin" style="width: 100%">
                                <thead>
                                   <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">Keputusan Anda</th>
                                    <th class="text-center">ID Izin</th>
                                    <th class="text-center">Tanggal Pengajuan</th>
                                    <th class="text-center">Nama Pekerja</th>
                                    <th class="text-center">Jenis Izin</th>
                                    <th class="text-center">Keterangan</th>
                                    <th class="text-center">Status</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php $no = 1;
                                  foreach ($IzinUnApprove as $row) {   
                                    ?>
                                    <tr>
                                      <td style="width: 1%; text-align: center;"><?php echo $no; ?></td>
                                      <td style="text-align: center; width: 5%"><?php  if ($row['status'] == 0) { ?>
                                           <button type="button" value="1|<?php echo $row['izin_id']; ?>" class="btn btn-success cm_btn_approve"><span style="color: white" class='fa fa-check'></span></button>
                                            <button type="submit" value="1|<?php echo $row['izin_id']; ?>" name="submit" style="display: none" class="btn btn-success cm_btn_approve2" >Approve</button>
                                            <button type="button" value="2|<?php echo $row['izin_id']; ?>" class="btn btn-danger cm_btn_reject"><span style="color: white" class='fa fa-close'></span></button>
                                            <button type="submit" value="2|<?php echo $row['izin_id']; ?>" name="submit" style="display: none" class="btn btn-danger cm_btn_reject2" >Reject</button>
                                     <?php }elseif ($row['status'] == 1) { ?>
                                            <a><span style="color: green" class='fa fa-check fa-2x'></span></a>
                                     <?php }elseif ($row['status'] == 2) { ?>
                                            <a><span style="color: red" class='fa fa-close fa-2x'></span></a>
                                       <?php } ?>
                                           
                                            </td>
                                      <td style="width: 5%; text-align: center;"><?php echo $row['izin_id'] ?></td>
                                      <td style="width: 5%"><?= date("d - M - Y", strtotime($row['created_date'])); ?></td>
                                      <td style="width: 33%"><?php $daftarNamaAsli = $row['namapekerja'];
                                                $daftarNama = str_replace(',', '<br> ', $daftarNamaAsli);
                                           echo $daftarNama ?></td>
                                     <td style="width: 12%; text-align: center;"><?php if ( $row['jenis_izin'] == '1') {
                                                                                      echo "DINAS PUSAT";
                                                                                    }elseif ( $row['jenis_izin'] == '2') {
                                                                                      echo "DINAS TUKSONO";
                                                                                    }elseif ( $row['jenis_izin'] == '3') {
                                                                                      echo "DINAS MLATI";
                                                                                    } ?>
                                      </td>
                                      <td style="width: 40%"><?php echo $row['keterangan'] ?></td>
                                      <td style="text-align: center; width: 5%"><?php
                                                      if ($row['status'] == 0) { ?>
                                                          <span class="label" style="background-color: #E0E0E0; color: black">Unapproved</span>
                                                      <?php } elseif ($row['status'] == 1) { ?>
                                                           <span class="label label-success">Approved</span>
                                                      <?php } elseif ($row['status'] == 2) { ?>
                                                          <span class="label label-danger">Rejected</span>
                                                      <?php } ?>
                                                </td>
                                    </tr> 
                                    <?php
                                    $no++;
                                  }
                                  ?>
                                </tbody>
                              </table>
                              </div>

                              <div id="izin-reject" class="tab-pane fade in">
                              <table class="datatable table table-striped table-bordered table-hover tabel_izin" style="width: 100%">
                                <thead>
                                  <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">Keputusan Anda</th>
                                    <th class="text-center">ID Izin</th>
                                    <th class="text-center">Tanggal Pengajuan</th>
                                    <th class="text-center">Nama Pekerja</th>
                                    <th class="text-center">Jenis Izin</th>
                                    <th class="text-center">Keterangan</th>
                                    <th class="text-center">Status</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php $no = 1;
                                  foreach ($IzinReject as $row) {   
                                    ?>
                                   <tr>
                                      <td style="width: 1%; text-align: center;"><?php echo $no; ?></td>
                                      <td style="text-align: center; width: 5%"><?php  if ($row['status'] == 0) { ?>
                                           <button type="button" value="1|<?php echo $row['izin_id']; ?>" class="btn btn-success cm_btn_approve"><span style="color: white" class='fa fa-check'></span></button>
                                            <button type="submit" value="1|<?php echo $row['izin_id']; ?>" name="submit" style="display: none" class="btn btn-success cm_btn_approve2" >Approve</button>
                                            <button type="button" value="2|<?php echo $row['izin_id']; ?>" class="btn btn-danger cm_btn_reject"><span style="color: white" class='fa fa-close'></span></button>
                                            <button type="submit" value="2|<?php echo $row['izin_id']; ?>" name="submit" style="display: none" class="btn btn-danger cm_btn_reject2" >Reject</button>
                                     <?php }elseif ($row['status'] == 1) { ?>
                                            <a><span style="color: green" class='fa fa-check fa-2x'></span></a>
                                     <?php }elseif ($row['status'] == 2) { ?>
                                            <a><span style="color: red" class='fa fa-close fa-2x'></span></a>
                                       <?php } ?>
                                           
                                            </td>
                                      <td style="width: 5%; text-align: center;"><?php echo $row['izin_id'] ?></td>
                                      <td style="width: 5%"><?= date("d - M - Y", strtotime($row['created_date'])); ?></td>
                                      <td style="width: 33%"><?php $daftarNamaAsli = $row['namapekerja'];
                                                $daftarNama = str_replace(',', '<br> ', $daftarNamaAsli);
                                           echo $daftarNama ?></td>
                                      <td style="width: 12%; text-align: center;"><?php if ( $row['jenis_izin'] == '1') {
                                                                                      echo "DINAS PUSAT";
                                                                                    }elseif ( $row['jenis_izin'] == '2') {
                                                                                      echo "DINAS TUKSONO";
                                                                                    }elseif ( $row['jenis_izin'] == '3') {
                                                                                      echo "DINAS MLATI";
                                                                                    } ?>
                                      </td>
                                      <td style="width: 40%"><?php echo $row['keterangan'] ?></td>
                                      <td style="text-align: center; width: 5%"><?php
                                                      if ($row['status'] == 0) { ?>
                                                          <span class="label" style="background-color: #E0E0E0; color: black">Unapproved</span>
                                                      <?php } elseif ($row['status'] == 1) { ?>
                                                           <span class="label label-success">Approved</span>
                                                      <?php } elseif ($row['status'] == 2) { ?>
                                                          <span class="label label-danger">Rejected</span>
                                                      <?php } ?>
                                                </td>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script> $(document).ready(function(){
  $('.tabel_izin').DataTable();
});
</script>

